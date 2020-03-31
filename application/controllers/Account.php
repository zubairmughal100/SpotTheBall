<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {


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
        $this->load->model('AddressModel');
        $this->load->model('DocumentModel');
        $this->load->model('GeneralSettingsModel');

        //Prizes stored in db
        $this->load->model('LevelPrizeModel');
        $this->load->model('LevelPrizeImageModel');

        //Prize collection
        $this->load->model('LevelPrizeCollectionModel');
        $this->load->model('RowPrizeCollectionModel');

        $this->load->model('PaymentSettingsModel');
        $this->load->model('GamePlayRecordModel');

        $this->load->model('BlogPageModel');
        // $this->load->model('');
        $this->load->library("GoogleAuthenticator");
        $this->load->model('StakeRowsModel');

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
        //$ip = "86.44.67.106";
        $ip = $this->getVisIPAddr();
        //echo $ip;exit;
        $country_json_object = $this->getCountryAPI($ip);
        //print_r($country_json_object);exit;
        //echo $country_json_object->geoplugin_countryCode;exit;
        //$blocked_continents = $this->ContinentModel->blockedContinents();
        //print_r($blocked_continents);exit;
        
        $isBlocked = false;

        // if($blocked_continents){
        //     $isContinentBlocked = $this->isBlocked($blocked_continents, $country_json_object->geoplugin_continentCode, $country_json_object->geoplugin_continentName);
        //     if($isContinentBlocked){
        //         $isBlocked = true;
        //     }
        // }
        
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
        //redirect to myaccount
        redirect("account/settings");
    }

    //This is signup view
    public function signup(){
        $this->checkIsBlocked();

        $data['general_settings'] = $this->GeneralSettingsModel->getSettings();

        if($this->session->userdata('player_logged_in_data')){
            $data['blogs'] = $this->BlogPageModel->getBlog();
        }else{
            $data['blogs'] = $this->BlogPageModel->getBlogsByPublicStatus('1'); //1 is public only
        }
        
        if(!$this->session->userdata('player_logged_in_data')){
            $data['pagename'] = "signup";
            
            //get list of available countries
            $data['countries'] = $this->CountryModel->getAllCountries();

            //General Settings
            $data['general_settings'] = $this->GeneralSettingsModel->getSettings();
            $data['terms_condition'] = $data['general_settings'][0]->terms_conditions;
            $this->load->view('player/pages/myaccount/signup_view', $data);
        }else{
            redirect('account/settings');
        }
    }

    //API call to get list of cities and return a jason object
    public function getstates(){
        //$country_id = $this->uri->segment(3);
        $country_id = $this->input->post('country');

        $states = $this->StateModel->getStatesByCountryID($country_id);
        //print_r($countries);exit;

        $output = "";

        if(!empty($country_id) || $country_id != null){
            if(!empty($states) || $states != false){
                foreach($states as $key => $state){
                    $output .= "<option value='".$state->state_name."'>".$state->state_name."</option>";
                }
            }else{
                $output = "<option value=''>No Country Found</option>";
            }
            
        }else{
            $output = "<option value=''>Invalid Input</option>";
        }
        //echo json_encode($output);
        echo $output;
    }

    

    public function login(){

        
        $this->checkIsBlocked();

        if($this->session->userdata('player_logged_in_data')){
            $data['blogs'] = $this->BlogPageModel->getBlog();
        }else{
            $data['blogs'] = $this->BlogPageModel->getBlogsByPublicStatus('1'); //1 is public only
        }

        $data['general_settings'] = $this->GeneralSettingsModel->getSettings();

        //echo "Blog count: " .count($data['blogs']);exit;

        //print_r($data['blogs']);exit;

        if($this->session->userdata('player_logged_in_data')){
            redirect('account/settings');
        }else{
            $data['pagename'] = "login";
            $this->load->view('player/pages/myaccount/login_view', $data);
        }
    }

    public function forgotpassword(){
        $this->checkIsBlocked();

        $data['pagename'] = "forgotpassword";
        $this->load->view('player/pages/myaccount/forgot_password_view', $data);
    }


    //View users prize history
    public function prizehistory(){
        $this->checkIsBlocked();

        $data['general_settings'] = $this->GeneralSettingsModel->getSettings();

        if($this->session->userdata('player_logged_in_data')){
            $data['blogs'] = $this->BlogPageModel->getBlog();
        }else{
            $data['blogs'] = $this->BlogPageModel->getBlogsByPublicStatus('1'); //1 is public only
        }

        if($this->session->userdata('player_logged_in_data')){
            $data['pagename'] = 'settings';
            $data['subpage'] = "prizehistory";

            $logged_in_data = $this->session->userdata('player_logged_in_data');

            //Control pending documents start
            //$logged_in_data = $this->session->userdata('player_logged_in_data');
            //Get just user info by username
            $user_object = $this->UserModel->getUserByUsername($logged_in_data['username']);

            if($user_object[0]->status == '0'){
                //load payment view
                $data['stripe_payment_settings'] = $this->PaymentSettingsModel->getSettingsByID("stripe");
                //print_r($data['stripe_payment_settings']);exit;
                //Get PayPal Settings
                $data['paypal_payment_settings'] = $this->PaymentSettingsModel->getSettingsByID("paypal");
                // print_r($data['paypal_payment_settings']);exit;
                //Get Crypto Settings
                $data['crypto_payment_settings'] = $this->PaymentSettingsModel->getSettingsByID("crypto");
                //print_r($data['crypto_payment_settings']);exit;

                //$data['hasPendingDocuments'] = $hasPendingDocuments;
                
                $this->load->view('player/pages/payment/payment_view', $data);
            }else{
                $documents = $this->DocumentModel->getDocumentsByID($user_object[0]->id);
                //Check if any of the user document has not been approved yet
                $hasPendingDocuments = false;
                if(!empty($documents) || $documents != false){
                    foreach ($documents as $key => $document) {
                        if($document->approved == '0'){
                            $hasPendingDocuments = true;
                        }
                    }
                 }else{
                    $hasPendingDocuments = true;
                 }
                if($hasPendingDocuments){
                    redirect('account/uploaddocuments');
                }
                //Control pending documents end

                //Level prize history
                $data['level_prize_history'] = $this->LevelPrizeCollectionModel->getAllLevelPrizeCollectionByUserID($logged_in_data['id']);
                //print_r($data['level_prize_history']);exit;
                
                //Row prize history
                $data['row_prize_history'] = $this->RowPrizeCollectionModel->getAllLevelPrizeCollectionByUserID($logged_in_data['id']);
                //print_r($data['row_prize_history']);exit;

                $this->load->view('player/pages/myaccount/prize_history', $data);
            }
        }else{
            redirect('accounts/login');
        }
        
    }


    //Code written by purpledesign.in Jan 2014
    private function dateDiff($date){
        $mydate= date("Y-m-d H:i:s");
        $theDiff="";
        //echo $mydate;//2014-06-06 21:35:55
        $datetime1 = date_create($date);
        $datetime2 = date_create($mydate);
        $interval = date_diff($datetime1, $datetime2);
        //echo $interval->format('%s Seconds %i Minutes %h Hours %d days %m Months %y Year    Ago')."<br>";
        $min=$interval->format('%i');
        $sec=$interval->format('%s');
        $hour=$interval->format('%h');
        $mon=$interval->format('%m');
        $day=$interval->format('%d');
        $year=$interval->format('%y');
        if($interval->format('%i%h%d%m%y')=="00000"){
            //echo $interval->format('%i%h%d%m%y')."<br>";
            return $sec.":Seconds";
        }else if($interval->format('%h%d%m%y')=="0000"){
            return $min.":Minutes";
        }else if($interval->format('%d%m%y')=="000"){
            return $hour.":Hours";
        }else if($interval->format('%m%y')=="00"){
            return $day.":Days";
        }else if($interval->format('%y')=="0"){
            return $mon.":Months";
        }else{
            return $year.":Years";
        }
    }

    public function change2factor(){
        if($this->session->userdata('player_logged_in_data')){
            //Check if checkbox is checked
            $logged_in_data = $this->session->userdata('player_logged_in_data');

            if(isset($_POST['twofactorInput'])){
                //echo "Checked";
                $update_data = array(
                    "two_factor_login" => '1',
                    "fa_token" => $this->input->post('inputTwoFactCode')
                );
            }else{
                //echo "Not checked";
                $update_data = array(
                    "two_factor_login" => '0',
                    "fa_token" => '0'
                );
            }
            if($this->UserModel->updateUserinfo($logged_in_data['id'],  $update_data)){
                $this->session->set_flashdata('message_twofactor_success', "Two factor settings updated successfully!");
            }else{
                $this->session->set_flashdata('message_twofactor_error', "Two factor settings could not been updated!");
            }
            redirect('account/settings');
        }else{
           redirect('account/login'); 
        }
    }


    //Accessible only after login into the system
    public function settings(){
        $this->checkIsBlocked();

        if($this->session->userdata('player_logged_in_data')){
            $data['blogs'] = $this->BlogPageModel->getBlog();
        }else{
            $data['blogs'] = $this->BlogPageModel->getBlogsByPublicStatus('1'); //1 is public only
        }

        if($this->session->userdata('player_logged_in_data')){

            //Control pending documents start
            $logged_in_data = $this->session->userdata('player_logged_in_data');

            //Get just user info by username
            //$user_object = $this->UserModel->getUserByUsername($logged_in_data['username']);
            $user_object = $this->UserModel->getUserAddressByUsername($logged_in_data['username']);
            $last_24hours_game_play_records = $this->GamePlayRecordModel->getLast24HoursRecordsByUserId("level", $user_object[0]->user_id);
            //print_r($last_24hours_game_play_records);exit;
            if(!empty($last_24hours_game_play_records)){
                $last_played_date = date('Y-m-d H:i:s', strtotime($last_24hours_game_play_records[0]->date_played));
                $now = date('Y-m-d H:i:s');
               //echo "DB: " .$last_played_date. "<br>";
                //echo "Now: " .$now."<br>";
                $diff=$this->dateDiff($last_played_date);
                $diff = explode(":",$diff);
                //print_r($diff);
                if($diff[1] == "Hours"){
                    //echo "Yes";exit;
                    if($diff[0] >= 24){
                        //Reset level
                        $reset_level = array(
                            "current_level" => '0'
                        );
                        $this->UserModel->updateUserinfo($user_object[0]->user_id, $reset_level);
                    }
                }
            }
            
            //Control pending documents end

            $data['pagename'] = "settings";
            $data['subpage'] = "home";

            $data['general_settings'] = $this->GeneralSettingsModel->getSettings();
            //print_r($data['general_settings']);exit;

            //$logged_in_data = $this->session->userdata('player_logged_in_data');
            //print_r($logged_in_data);
            //print_r($_SESSION);
            //$data['amount_value'] = $this->session->userdata('amount_value');
            //$data['credit_amount'] = $this->session->userdata('credit_amount');

            //Get user_object
            
            //print_r($user_object);exit;


            //get only user object
            $the_user = $this->UserModel->getUserByUsername($logged_in_data['username']);
          
            $data['twofact'] = $the_user[0]->two_factor_login;
             $data['Stake_id']= $the_user[0]->Default_Stake;
               
            //echo $data['twofact'];exit;
            
            //Check if user account status if 0
            if($user_object[0]->status == '0'){
                //load payment view
               
                $data['stripe_payment_settings'] = $this->PaymentSettingsModel->getSettingsByID("stripe");
                //print_r($data['stripe_payment_settings']);exit;
                //Get PayPal Settings
                $data['paypal_payment_settings'] = $this->PaymentSettingsModel->getSettingsByID("paypal");
                // print_r($data['paypal_payment_settings']);exit;
                //Get Crypto Settings
                $data['crypto_payment_settings'] = $this->PaymentSettingsModel->getSettingsByID("crypto");
                //print_r($data['crypto_payment_settings']);exit;

                //$data['hasPendingDocuments'] = $hasPendingDocuments;
                
                $this->load->view('player/pages/payment/payment_view', $data);
            }else{
                $data['user_object'] = $user_object;

                // print_r($data['user_object']);exit;
                $data['countries'] = $this->CountryModel->getAllCountries();
                $data['state_id'] = $this->StateModel->getStateIDByName($data['user_object'][0]->state);
                $data['city_id'] = $this->CityModel->getCityIDByName($data['user_object'][0]->city);

                $documents = $this->DocumentModel->getDocumentsByID($data['user_object'][0]->user_id);
                $hasPendingDocuments = false;
                if(!empty($documents) || $documents != false){
                    //Check if any of the user document has not been approved yet
                    foreach ($documents as $key => $document) {
                        if($document->approved == '0'){
                            $hasPendingDocuments = true;
                        }
                    }
                }else{
                    $hasPendingDocuments = true;
                }

                if($hasPendingDocuments){
                    redirect('account/uploaddocuments');
                }
                $two_fa_name = $this->PaymentSettingsModel->getSettingsByID("twofa");

                // echo '<pre>',print_r($data);exit;
                // QR Bar Code And Secret Generator
                  $ga = new GoogleAuthenticator();
                  $secret = $ga->createSecret();
                  $qrCodeUrl    = $ga->getQRCodeGoogleUrl($user_object[0]->email,$secret,$two_fa_name[0]->live_public_key);
                  $data['qr']=$qrCodeUrl;
                  $data['secret']=$secret;
                  $data['ActiveStakes']= $this->StakeRowsModel->getStakesActive();
                $this->load->view('player/pages/myaccount/settings/settings_home_view', $data);
            } 
        }else{
            redirect('account/login');
        }
         
    }
// 
// public function createQr()
//     {
//       if(!isset($_SESSION['userid']))
//       {
//         redirect('account/login');
//       }
//       $this->load->library('GoogleAuthenticator');
//       $user=$_SESSION['userid'];
//       unset($_SESSION['userid']);
//         session_destroy();
//       $ga = new GoogleAuthenticator();
//       $secret = $ga->createSecret();
//       $qrCodeUrl    = $ga->getQRCodeGoogleUrl($user,$secret,'hasnainriazkayani');
//       $data['qr']=$qrCodeUrl;
//       $data['secret']=$secret;
//       $data['userid']=$user;
//       $this->load->view('player/pages/myaccount/scanqr',$data);
//     }


    public function updateTwoFactorEnable()
    {
        $id=$this->session->userdata('player_logged_in_data')["id"];
        $value=1;
        $res=$this->UserModel->updateTwoFactor($id,$value);
        $data['response']=$res;
        echo json_encode($data);
    }

    public function updateTwoFactorDisable()
    {
        $id=$this->session->userdata('player_logged_in_data')["id"];
        $value=0;
        $res=$this->UserModel->updateTwoFactor($id,$value);
        $data['response']=$res;
        echo json_encode($data);
    }
    public function addfund(){
        $this->checkIsBlocked();

        if($this->session->userdata('player_logged_in_data')){
            $data['blogs'] = $this->BlogPageModel->getBlog();
        }else{
            $data['blogs'] = $this->BlogPageModel->getBlogsByPublicStatus('1'); //1 is public only
        }

        if($this->session->userdata('player_logged_in_data')){
            //Control pending documents start
            $logged_in_data = $this->session->userdata('player_logged_in_data');
            //Get just user info by username
            $user_object = $this->UserModel->getUserByUsername($logged_in_data['username']);

            $data['general_settings'] = $this->GeneralSettingsModel->getSettings();
            //print_r($data['general_settings']);exit;

            //Get stripe settings
            $data['stripe_payment_settings'] = $this->PaymentSettingsModel->getSettingsByID("stripe");
            //print_r($data['stripe_payment_settings']);exit;
            //Get PayPal Settings
            $data['paypal_payment_settings'] = $this->PaymentSettingsModel->getSettingsByID("paypal");
            // print_r($data['paypal_payment_settings']);exit;
            //Get Crypto Settings
            $data['crypto_payment_settings'] = $this->PaymentSettingsModel->getSettingsByID("crypto");
            //print_r($data['crypto_payment_settings']);exit;

            $documents = $this->DocumentModel->getDocumentsByID($user_object[0]->id);
            //Check if any of the user document has not been approved yet
            $hasPendingDocuments = false;
            if(!empty($documents) || $documents != false){
                foreach ($documents as $key => $document) {
                    if($document->approved == '0'){
                        $hasPendingDocuments = true;
                    }
                }
            }else{
                $hasPendingDocuments = true;
            }
            
            if($hasPendingDocuments){
                redirect('account/uploaddocuments');
            }
            //Control pending documents end
                
            $data['pagename'] = "settings";
            $data['subpage'] = "addfund";
            $this->load->view('player/pages/myaccount/fund_account_view', $data);
        }else{
            redirect('account/login');
        }
    }

    public function lostpassword(){
        $this->checkIsBlocked();

        $data['general_settings'] = $this->GeneralSettingsModel->getSettings();

        if($this->session->userdata('player_logged_in_data')){
            $data['blogs'] = $this->BlogPageModel->getBlog();
        }else{
            $data['blogs'] = $this->BlogPageModel->getBlogsByPublicStatus('1'); //1 is public only
        }

        if($this->session->userdata('player_logged_in_data')){
            redirect('account/settings');
        }else{
            $data['pagename'] = "settings";
            $data['subpage'] = "resetpassword";

            $this->load->view('player/pages/myaccount/reset_password_view', $data);
        }
    }

    public function recoverpassword(){
        $this->checkIsBlocked();

        $data['general_settings'] = $this->GeneralSettingsModel->getSettings();

        if($this->session->userdata('player_logged_in_data')){
            $data['blogs'] = $this->BlogPageModel->getBlog();
        }else{
            $data['blogs'] = $this->BlogPageModel->getBlogsByPublicStatus('1'); //1 is public only
        }

        if($this->session->userdata('player_logged_in_data')){
            redirect('account/settings');
        }else{
            if($this->input->post('btnRecoverPasssword')){
                //Get account number
                $user_id = $this->input->post('secret_code');
                if(empty($user_id)){
                    $this->session->set_flashdata('error', "We could not find an account!");
                    redirect('account/lostpassword');
                }else{
                    //Check user id is found
                    if(!empty($this->UserModel->getUserById($user_id)) || $this->UserModel->$UserModel->getUserById($user_id) != false){
                        //Send them to the recovery page
                        /*$sess_array = array(
                            'recovery_id' => $user_id
                        );
                        $this->session->set_userdata('recovery_password', $sess_array);*/
                        $data['secret_code'] = $user_id;
                        $this->load->view('player/pages/myaccount/recover_password', $data);
                    }else{
                        $this->session->set_flashdata('error', "We could not find an account!");
                        redirect('account/lostpassword');
                    }
                }
            }else{
                $this->session->set_flashdata('error', "Error try again!");
                redirect('account/lostpassword');
            }
        }
    }

    public function changepassword(){
        $this->checkIsBlocked();

        $data['general_settings'] = $this->GeneralSettingsModel->getSettings();

        if($this->session->userdata('player_logged_in_data')){
            $data['blogs'] = $this->BlogPageModel->getBlog();
        }else{
            $data['blogs'] = $this->BlogPageModel->getBlogsByPublicStatus('1'); //1 is public only
        }

        if($this->session->userdata('player_logged_in_data')){
            redirect('account/settings');
        }else{
            if($this->input->post('btnChangePasssword')){
                //Get account number
                $user_id = $this->input->post('secret_code');
                if(empty($user_id)){
                    $this->session->set_flashdata('error', "We could not find an account!");
                    redirect('account/lostpassword');
                }else{
                    $user = $this->UserModel->getUserById($user_id);
                    //Check user id is found
                    if(!empty($user) || $user != false){
                        //get old password
                        $dob = $this->input->post('dob');
                        //get new pass
                        $new_pass = $this->input->post('new_password');
                        //get confirm pass
                        $confirm_new_pass = $this->input->post('confirm_new_password');

                        $user_dob_day = $user[0]->dob_day;
                        $user_dob_month = $user[0]->dob_month;
                        $user_dob_year = $user[0]->dob_year;

                        $user_dob = $user_dob_day. "/" .$user_dob_month. "/" .$user_dob_year;

                        if($user_dob == $dob){
                            //We have a password match
                            //check if new password and confirm password are same
                            if($new_pass == $confirm_new_pass){
                                //Password has match
                                //Update password
                                if($this->UserModel->updatePassword($user_id, md5($new_pass))){
                                    $this->session->set_flashdata('success', "Password updated successfully!");
                                    redirect('account/login');
                                }else{
                                    $data['secret_code'] = $user_id;
                                    $this->session->set_flashdata('error', "Error updating password");
                                    $this->load->view('player/pages/myaccount/recover_password', $data);
                                }
                            }else{
                                $data['secret_code'] = $user_id;
                                $this->session->set_flashdata('error', "New password does not match");
                                $this->load->view('player/pages/myaccount/recover_password', $data);
                            }
                        }else{
                            $data['secret_code'] = $user_id;
                            $this->session->set_flashdata('error', "Could not verify your date of birth!");
                            $this->load->view('player/pages/myaccount/recover_password', $data);
                        }
                    }else{
                        $this->session->set_flashdata('error', "We could not find an account!");
                        redirect('account/lostpassword');
                    }
                }
            }else{
                $this->session->set_flashdata('error', "Error try again!");
                redirect('account/lostpassword');
            }
        }
    }

    public function uploaddocuments(){
        $this->checkIsBlocked();

        $data['general_settings'] = $this->GeneralSettingsModel->getSettings();

        if($this->session->userdata('player_logged_in_data')){
            $data['blogs'] = $this->BlogPageModel->getBlog();
        }else{
            $data['blogs'] = $this->BlogPageModel->getBlogsByPublicStatus('1'); //1 is public only
        }

        if($this->session->userdata('player_logged_in_data')){
            $data['pagename'] = "settings";
            $data['subpage'] = "uploaddocuments";

            $logged_in_data = $this->session->userdata('player_logged_in_data');

            //Get just user info by username
            $user_object = $this->UserModel->getUserByUsername($logged_in_data['username']);

            $documents = $this->DocumentModel->getDocumentsByID($user_object[0]->id);
            //print_r($documents);exit;

            //Check if any of the user document has not been approved yet
            $hasPendingDocuments = false;
            if(!empty($documents) || $documents != false){
                foreach ($documents as $key => $document) {
                    if($document->approved == '0'){
                        $hasPendingDocuments = true;
                    }
                }
            }else{
                $hasPendingDocuments = true;
            }

            //Check if documents are pending
            if($hasPendingDocuments){
                //Set flash data
                $this->session->set_flashdata('documents_pending', "You have pending documents that needs to be approved!");
            }
            $data['hasPendingDocuments'] = $hasPendingDocuments;
            $data['documents'] = $documents;

            $this->load->view('player/pages/myaccount/upload_documents_view', $data);
        }else{
            redirect('account/login');
        }
    }

    //Advance account control
    private function pendingaccount(){
        $data['pagename'] = "settings";
        $data['subpage'] = "pendingaccount";
        $this->load->view('player/pages/myaccount/pending_account_view', $data);
    }

    private function deleteaccount(){
        $data['pagename'] = "settings";
        $data['subpage'] = "deleteaccount";
        $this->load->view('player/pages/myaccount/delete_account_view', $data);
    }



    //////////////////////////////////////////////////////////
    // AJAX CALL, ONLY AJAX CALL FUNCTIONS SHOULD BE WRITTEN
    // UNDER THIS LINE
    //////////////////////////////////////////////////////////
    public function updateuserinfo(){

        if($this->session->userdata('player_logged_in_data')){
            //Get user_id
         
            $user_id = $this->input->post('user_id');
            $user_object_update = array(
                "first_name" => $this->input->post('first_name'),
                "last_name" => $this->input->post('last_name'),
                "email" => $this->input->post('email'),
                "username" => $this->input->post('username'),
                "phone" => $this->input->post('phone'),
                "Default_Stake" => $this->input->post('sss'),
            );

            // print_r($user_object_update);
            // exit;
            if($this->UserModel->updateUserinfo($user_id, $user_object_update)){
                echo "success";
            }else{
                echo "fail";
            }
        }else{
            echo "fail";
        }
    }


    public function updateaddress(){
        if($this->session->userdata('player_logged_in_data')){
            //Get address_id
            $address_id = $this->input->post('address_id');
            $state_name = $this->input->post('state_id');

            $city_name = $this->input->post('city_id');
            //echo $city_name;exit;
            if(empty($city_name)){
                echo "fail";exit;
            }

            $country_name = $this->CountryModel->getCountryNameByID($this->input->post('country_id'));
            //echo "State:".$state_name;exit;
            if(($country_name == 'USA')) {
                //echo "'yes";exit;
                $state_name = $this->StateModel->getStateNameByID($this->input->post('state_id'));
            }else{
                $state_name = 'null';
            }
            //echo $state_name;exit;

            $address_object_update = array(
                "address_line1" => $this->input->post('address_line1'),
                "address_line2" => $this->input->post('address_line2'),
                "city" => $this->CityModel->getCityNameByID($this->input->post('city_id')),
                "state" => $state_name,
                "country" => $this->CountryModel->getCountryNameByID($this->input->post('country_id')),
                "post_code" => $this->input->post('post_code')
            );

            //print_r($address_object_update);exit;

            if($this->AddressModel->updateAddress($address_id, $address_object_update)){
                echo "success";
            }else{
                echo "fail";
            }
        }else{
            echo "fail";exit;
        }
    }

    public function updatepassword(){
        if($this->session->userdata('player_logged_in_data')){
            //Get user_id
            $user_id = $this->input->post('user_id');

            //Get old pass
            $old_pass = $this->input->post('old_pass');

            //Get new pass
            $new_pass = $this->input->post('new_pass');

            //Get confirm pass
            $confirm_pass = $this->input->post('new_pass_confirm');

            

            if(!empty($user_id)){
                //Get user information by id
                $user_object = $this->UserModel->getUserById($user_id);

                //echo "Db Old Pass: " .$user_object[0]->password;
                //echo "Input Old Pass:  " .$old_pass;

                if($user_object[0]->password == md5($old_pass)){
                    if($new_pass == $confirm_pass){
                        if($this->UserModel->updatePassword($user_id, md5($new_pass))){
                            echo "success";
                        }else{
                            echo "fail";
                        }
                    }else{
                        echo "pass_no_match";
                    }
                }else{
                    echo "old_pass_wrong";
                }
            }else{
                echo "tampered";
            }
        }else{
            echo "tampered";exit;
        }
    }



    private function currencyExchanger($money_amount_to_convert, $currencyType){
        $general_settings = $this->GeneralSettingsModel->getSettings();
        $game_credit = 0;
        if($currencyType == "eur"){
            $game_credit = $money_amount_to_convert + (($general_settings[0]->euro_conversion / 100) * $money_amount_to_convert);
        }else if($currencyType == "gbp"){
            $game_credit = $money_amount_to_convert + (($general_settings[0]->pound_conversion / 100) * $money_amount_to_convert);
        }else if($currencyType == "usd"){
            $game_credit = $money_amount_to_convert + (($general_settings[0]->dollar_conversion / 100) * $money_amount_to_convert);
        }else{
            //The likelyhood of this else conversion is zero
            $game_credit = $money_amount_to_convert + (($general_settings[0]->dollar_conversion / 100) * $money_amount_to_convert);
        }
        //$money_to_exchange = $money_amount_to_convert;
        //$exchange_rate = 1.12; //Should get from db
        //$exchange_value = $money_to_exchange * $exchange_rate;
        return $game_credit;
    }


}