<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prize extends CI_Controller {


    public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->helper('html');
        $this->load->helper('url');

        // Load session through controller
		$this->load->library('session');

        $this->load->model('ContinentModel');
        $this->load->model('CountryModel');
        $this->load->model('StateModel');
        $this->load->model('CityModel');

        $this->load->model('UserModel');
        $this->load->model('DocumentModel');
        $this->load->model('GeneralSettingsModel');
        $this->load->model('PaymentSettingsModel');
        $this->load->model('RowGameModel');
        $this->load->model('GameGalleryModel');
        //$this->load->library('session'); //Session already exists on top

        $this->load->model('ImageActivityModel');
        $this->load->model('GamePlayRecordModel');

        $this->load->model('LevelPrizeModel');
        $this->load->model('LevelPrizeCollectionModel');
        $this->load->model('RowPrizeCollectionModel');
        $this->load->model('RowPrizeModel');

        $this->load->model('AddressModel');
        $this->load->model('BlogPageModel');
    }

    private function getVisIpAddr() { 
      
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
            return $_SERVER['HTTP_CLIENT_IP']; 
        } 
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
            return $_SERVER['HTTP_X_FORWARDED_FOR']; 
        } 
        else { 
            return $_SERVER['REMOTE_ADDR']; 
        } 
    }
    private function getCountryAPI($ip){
        $ipdat = @json_decode(file_get_contents( 
        "http://www.geoplugin.net/json.gp?ip=" . $ip));
        return $ipdat;
    }
    private function isBlocked($blocked_location, $code, $name){
        $blocked = false;
        foreach ($blocked_location as $key => $location) {
            if($location->code == $code || $location->name == $name){
                $blocked = true;
            }
        }
        return $blocked;
    }
    private function checkIsBlocked(){
        $blocked_continents = $this->ContinentModel->blockedContinents();
        $blocked_countries = $this->CountryModel->blockedCountries();
        $blocked_states = $this->StateModel->blockedStates();
        $blocked_cities = $this->CityModel->blockedCities();

        // Store the IP address
        $ip = "86.44.67.106";
        //$ip = $this->getVisIPAddr();
        //echo $ip;exit;
        $country_json_object = $this->getCountryAPI($ip);
        //print_r($country_json_object);exit;
        //echo $country_json_object->geoplugin_countryCode;exit;
        //$blocked_continents = $this->ContinentModel->blockedContinents();
        //print_r($blocked_continents);exit;
        
        $isBlocked = false;

        if($blocked_continents){
            $isContinentBlocked = $this->isBlocked($blocked_continents, $country_json_object->geoplugin_continentCode, $country_json_object->geoplugin_continentName);
            if($isContinentBlocked){
                $isBlocked = true;
            }
        }
        
        if($blocked_countries){
            $isCountryBlocked = $this->isBlocked($blocked_countries, $country_json_object->geoplugin_countryCode, $country_json_object->geoplugin_countryName);
            if($isCountryBlocked){
                $isBlocked = true;
            }
        }

        if($blocked_states){
            $isStateBlocked = $this->isBlocked($blocked_states, $country_json_object->geoplugin_regionCode, $country_json_object->geoplugin_regionName);
            if($isStateBlocked){
                $isBlocked = true;
            }
        }

        if($blocked_cities){
            $isCityBlocked = $this->isBlocked($blocked_cities, "null", $country_json_object->geoplugin_city);
            if($isStateBlocked){
                $isBlocked = true;
            }
        }

        
        if($isBlocked){
            echo "Content blocked in your location!";
            die();
        }
    }


    public function index(){
        $this->checkIsBlocked();

        //redirect to myaccount
        $data['pagename'] = "prizes";

        if($this->session->userdata('player_logged_in_data')){
            $data['blogs'] = $this->BlogPageModel->getBlog();
        }else{
            $data['blogs'] = $this->BlogPageModel->getBlogsByPublicStatus('1'); //1 is public only
        }

        $data['general_settings'] = $this->GeneralSettingsModel->getSettings();


        if($this->session->userdata('player_logged_in_data')){

            $logged_in_data = $this->session->userdata('player_logged_in_data');
            $data['user_object'] = $this->UserModel->getUserByUsername($logged_in_data['username']);
            $data['windata'] = $this->UserModel->GetwinRow($data['user_object'][0]->id);
            // print_r($data['windata']);exit;
            
            $data['the_row_prize'] = $this->RowPrizeModel->getRowPrize();
           
            // print_r($data['the_row_prize']);exit;

            //Check if user account status if 0
            if($data['user_object'][0]->status == '0'){
                //load payment view
                $data['stripe_payment_settings'] = $this->PaymentSettingsModel->getSettingsByID("stripe");
                //print_r($data['stripe_payment_settings']);exit;
                //Get PayPal Settings
                $data['paypal_payment_settings'] = $this->PaymentSettingsModel->getSettingsByID("paypal");
                // print_r($data['paypal_payment_settings']);exit;
                //Get Crypto Settings
                $data['crypto_payment_settings'] = $this->PaymentSettingsModel->getSettingsByID("crypto");
                //print_r($data['crypto_payment_settings']);exit;
                
                //load payment view
                $this->load->view('player/pages/payment/payment_view', $data);
            }else{
                //Get just user info by username
                $documents = $this->DocumentModel->getDocumentsByID($data['user_object'][0]->id);

                //Check if any of the user document has not been approved yet
                $hasPendingDocuments = false;
                foreach ($documents as $key => $document) {
                    if($document->approved == '0'){
                        $hasPendingDocuments = true;
                    }
                }

                //Check if documents are pending
                if($hasPendingDocuments){
                    redirect('account/uploaddocuments');
                    //redirect('account/settings');
                }else{

                    // $data['level_prizes'] = $this->LevelPrizeModel->getAllLevelPrizes();
                    // print_r($data['level_prizes']);exit;
                    
                    $this->load->view('player/pages/game/level_prize_view', $data);
                }
            }
        }else{
            redirect('account/login');
            //$this->load->view('player/error/404.php');
        }
    }

    public function details(){
        $this->checkIsBlocked();

        $data['pagename'] = "prizes";

        if($this->session->userdata('player_logged_in_data')){
            $data['blogs'] = $this->BlogPageModel->getBlog();
        }else{
            $data['blogs'] = $this->BlogPageModel->getBlogsByPublicStatus('1'); //1 is public only
        }
        

        if($this->session->userdata('player_logged_in_data')){
            $logged_in_data = $this->session->userdata('player_logged_in_data');
            //print_r($logged_in_data);
            $user_object = $this->UserModel->getUserByUsername($logged_in_data['username']);

            $data['user_object'] = $user_object;

            //Check if user account status if 0
            if($user_object[0]->status == '0'){
                //load payment view
                $this->load->view('player/pages/payment/payment_view', $data);
            }else{
                //Get just user info by username
                //$user_object = $this->UserModel->getUserByUsername($logged_in_data['username']);

                $documents = $this->DocumentModel->getDocumentsByID($user_object[0]->id);

                //Check if any of the user document has not been approved yet
                $hasPendingDocuments = false;
                foreach ($documents as $key => $document) {
                    if($document->approved == '0'){
                        $hasPendingDocuments = true;
                    }
                }

                //Check if documents are pending
                if($hasPendingDocuments){
                    //Set flash data
                    redirect('account/uploaddocuments');
                }else{
                    $id = $this->input->get('id');

                    $the_prize = $this->LevelPrizeModel->prizeDetails($id);
                    //print_r($data['the_prize']);exit;
                    if($the_prize != false || !empty($the_prize)){
                        $data['the_prize'] = $the_prize;
                        $this->load->view('player/pages/game/level_prize_details_view', $data);
                    }else{
                        $this->load->view('player/error/404.php');
                    }
                }
            }
        }else{
            redirect('account/login');
        }
    }

    public function prizedetailsrow(){
        $this->checkIsBlocked();

        $data['pagename'] = "prizes";

        $data['general_settings'] = $this->GeneralSettingsModel->getSettings();


        if($this->session->userdata('player_logged_in_data')){
            $data['blogs'] = $this->BlogPageModel->getBlog();
        }else{
            $data['blogs'] = $this->BlogPageModel->getBlogsByPublicStatus('1'); //1 is public only
        }
        

        if($this->session->userdata('player_logged_in_data')){
            $logged_in_data = $this->session->userdata('player_logged_in_data');
            //print_r($logged_in_data);
            $user_object = $this->UserModel->getUserByUsername($logged_in_data['username']);

            $data['user_object'] = $user_object;

            //Check if user account status if 0
            if($user_object[0]->status == '0'){
                //load payment view
                $this->load->view('player/pages/payment/payment_view', $data);
            }else{
                //Get just user info by username
                //$user_object = $this->UserModel->getUserByUsername($logged_in_data['username']);

                $documents = $this->DocumentModel->getDocumentsByID($user_object[0]->id);

                //Check if any of the user document has not been approved yet
                $hasPendingDocuments = false;
                foreach ($documents as $key => $document) {
                    if($document->approved == '0'){
                        $hasPendingDocuments = true;
                    }
                }

                //Check if documents are pending
                if($hasPendingDocuments){
                    //Set flash data
                    redirect('account/uploaddocuments');
                }else{
                    $id =  $_GET['id'];

                    $the_row_prize = $this->RowPrizeModel->getRowPrizeEdit($id);
                    //print_r($data['the_prize']);exit;
                    if($the_row_prize != false || !empty($the_row_prize)){
                        $data['the_row_prize'] = $the_row_prize;


                        //print_r($data['the_row_prize']);exit;
                        $this->load->view('player/pages/game/prize_details_row', $data);
                    }else{
                        $this->load->view('player/error/404.php');
                    }
                }
            }
        }else{
            redirect('account/login');
        }
    }

    public function claimprize(){
        $this->checkIsBlocked();

        if($this->session->userdata('player_logged_in_data')){
            $logged_in_data = $this->session->userdata('player_logged_in_data');
            //get level prize id
            $level_prize_id = $this->input->get('id');
            //echo $id;
            //Get address by user_id
            $user_address = $this->AddressModel->getAddressByUserID($logged_in_data['id']);
            //print_r($address);
            $address = $user_address[0]->first_name. ' ' .$user_address[0]->last_name. ', ' .$user_address[0]->address_line1. ', ' .$user_address[0]->address_line2. ', ' .$user_address[0]->town. ', ' .$user_address[0]->city. ', ' .$user_address[0]->state. ', ' .$user_address[0]->country. ', ' .$user_address[0]->post_code;
            //echo $address;exit;

            //Get the level prize
            $the_prize = $this->LevelPrizeModel->getLevelPrizesByID($level_prize_id);
            //print_r($the_prize);

            //Prepare prize collection data
            $collection_object = array(
                "levelprize_id" => $the_prize[0]->id,
                "date_collected" => date('Y-m-d H:i:s'),
                "user_id" => $logged_in_data['id'],
                "user_fullname" => $logged_in_data['first_name']. ' ' .$logged_in_data['last_name'],
                "address" => $address,
                "prize_name" => $the_prize[0]->prize_name,
                "delivered_status" => 'not_delivered',
                "status" => '1',
                "sent" => 'no',
            );
            if(!$this->LevelPrizeCollectionModel->samePrizeClaimExistsIn24Hours($logged_in_data['id'], $the_prize[0]->id)){
                if($this->LevelPrizeCollectionModel->insertIntoLevelPrizeCollection($collection_object)){
                    $this->session->set_flashdata('message_success', "Thank you for claiming your prize!");
                }else{
                    $this->session->set_flashdata('message_error', "Ooops, something went wrong, prize could not been claimed!");
                }
            }else{
                 $this->session->set_flashdata('message_error', "You have already claimed this prize, please allow up to 24 hours before you claim again!");
            }
            //print_r($collection_object);exit;
            redirect('prize/details/?id='.$level_prize_id);
        }else{
            $this->load->view('player/error/404.php');
        }
    }


    public function claimrowprize(){
        $this->checkIsBlocked();
        
        if($this->session->userdata('player_logged_in_data')){
            $logged_in_data = $this->session->userdata('player_logged_in_data');
            //get level prize id
            //$row_prize_id = $this->input->get('id');
            $row_prize_id = 1;
            //echo $id;
            //Get address by user_id
            $user_address = $this->AddressModel->getAddressByUserID($logged_in_data['id']);
            //print_r($address);
            $address = $user_address[0]->first_name. ' ' .$user_address[0]->last_name. ', ' .$user_address[0]->address_line1. ', ' .$user_address[0]->address_line2. ', ' .$user_address[0]->town. ', ' .$user_address[0]->city. ', ' .$user_address[0]->state. ', ' .$user_address[0]->country. ', ' .$user_address[0]->post_code;
            //echo $address;exit;
            $id= $_GET['id'];
            //Get the level prize
            $the_prize = $this->RowPrizeModel->getRowPrizeEdit($id);
//             print_r($the_prize);
// exit;
            $prize_id = $the_prize[0]->id;
            $prize_name = $the_prize[0]->prize_name;

            //Prepare prize collection data
            $collection_object = array(
                "rowprize_id" => $prize_id,
                "date_collected" => date('Y-m-d H:i:s'),
                "user_id" => $logged_in_data['id'],
                "user_fullname" => $logged_in_data['first_name']. ' ' .$logged_in_data['last_name'],
                "address" => $address,
                "prize_name" => $prize_name,
                "delivered_status" => 'not_delivered',
                "status" => '1',
                "sent" => 'no',
            );

            if(!$this->RowPrizeCollectionModel->samePrizeClaimExistsIn24Hours($logged_in_data['id'], 1)){
                if($this->RowPrizeCollectionModel->insertIntoRowPrizeCollection($collection_object)){
                    $this->session->set_flashdata('message_success', "Thank you for claiming your prize!");
                    //echo "Claimed";
                }else{
                    $this->session->set_flashdata('message_error', "Ooops, something went wrong, prize could not been claimed!");
                    //echo "Could not claim";
                }
            }else{
                 $this->session->set_flashdata('message_error', "You have already claimed this prize, please allow up to 24 hours before you claim again!");
                 //echo "Already claimed";
            }
            //print_r($collection_object);exit;
            redirect('prize/prizedetailsrow?id='.$prize_id);
        }else{
            $this->load->view('player/error/404.php');
        }
    }
}