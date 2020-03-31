<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends CI_Controller {


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
        $this->load->model('LevelGameModel');

        $this->load->model('MessageSettingsModel');

        $this->load->model('LevelModel');

        $this->load->model('BlogPageModel');
         $this->load->model('StakeRowsModel');
         $this->load->model('user_game_row');
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
        //redirect to myaccount
        redirect('playlevel');
    }

    //This is signup view
    private function playlevel(){
        $this->checkIsBlocked();

        $data['pagename'] = "level_game";

        /*
        $logged_in_data = $this->session->userdata('player_logged_in_data');
        //print_r($logged_in_data);

        $data['the_level_game'] = $this->LevelGameModel->getTheLevelGame();
        print_r($data['the_level_game']);exit;
        //Check if user account status if 0
        if($logged_in_data['status'] == '0'){
            //load payment view
            $this->load->view('player/pages/payment/payment_view', $data);
        }else{
            $this->load->view('player/pages/game/levelgame_view', $data);
        }*/

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
            $documents = $this->DocumentModel->getDocumentsByID($user_object[0]->id);
            //Check if any of the user document has not been approved yet
            $hasPendingDocuments = false;
            foreach ($documents as $key => $document) {
                if($document->approved == '0'){
                    $hasPendingDocuments = true;
                }
            }
            if($hasPendingDocuments){
                redirect('account/uploaddocuments');
            }
            //Control pending documents end

            //Get all active levels
            $data['levels'] = $this->LevelModel->getlevelorderByAsc();
            //print_r($data['levels']);exit;
            if($data['levels'] == false || empty($data['levels'])){
                $this->session->set_flashdata('message', "Apologies game is offline!");
                redirect('account/settings');
            }

            $data['level_count'] = count($data['levels']);

            if($data['level_count'] <= $user_object[0]->current_level){
                $this->session->set_flashdata('message', "Apologies game is offline!");
                redirect('account/settings');
            }


            $data['general_settings'] = $this->GeneralSettingsModel->getSettings();
            //print_r( $data['general_settings']);exit;
            // $_SESSION["level_val"] = 1;

            //$logged_in_data = $this->session->userdata('player_logged_in_data');
            //print_r($logged_in_data);exit;
            //Get user_object
           // $data['user_object'] = $this->UserModel->getUserAddressByUsername($logged_in_data['username']);
            $data['user_object'] = $user_object;
            //print_r($data['user_object']);exit;
            $data['current_level'] = $user_object[0]->current_level;
            $data['current_progress'] = 0;
            if(!empty($user_object[0]->level_progress)){
                $data['current_progress'] = $user_object[0]->level_progress;
            }
            //echo $data['current_progress'];exit;
            

            //Get all images and activities
            $data['image_activities_live_rand'] = $this->GameGalleryModel->getGalleryActivity('RAND()', 'live');

            $data['image_activities_demo_rand'] = $this->GameGalleryModel->getGalleryActivity('RAND()', 'demo');

            $data['image_activities_live_asc'] = $this->GameGalleryModel->getGalleryActivity('ASC', 'live');

            $data['image_activities_demo_asc'] = $this->GameGalleryModel->getGalleryActivity('ASC', 'demo');

            $allgallery = $this->GameGalleryModel->getAllGallery();
            if($allgallery == false || empty($allgallery)){
                $this->session->set_flashdata('message', "Apologies game is offline!");
                redirect('account/settings');
            }

            $data['user_id'] = $data['user_object'][0]->id;

            $data['username'] = $data['user_object'][0]->username;
            // echo "<pre>"; print_r($data['levels']);exit;
            // Pass Marks
            $data['pass_marks'] = $data['levels'][0]->passmark;
            // Percentage
            $data['percentage_increase'] = $data['levels'][0]->percentage_increase;
            // Max Stake
            $data['max_stake'] = $data['levels'][0]->max_stake;
            $data['min_stake'] = $data['levels'][0]->min_stake;
            //Game Timer
            $data['game_timer'] = $data['general_settings'][0]->game_timer;
            // Is Demo
            $data['isDemoAccount'] = $data['user_object'][0]->isDemoAccount;
            //echo $data['isDemoAccount'];exit;
            //level image
            $data['level_image'] = $data['levels'][0]->level_image;

            // Live Balance
            if(!empty($data['user_object'][0]->balance)){
            $data['live_balance'] = $data['user_object'][0]->balance;
            }else{
                $data['live_balance'] = 0;
            }
            //echo  $data['live_balance'];exit;
            // Demo Balance
            $data['demo_balance'] = $data['user_object'][0]->demo_balance;

            if($user_object[0]->isDemoAccount == '1'){
                $data['live_balance'] = $data['demo_balance'];
            }

            $formatted_balance = explode(".", $data['live_balance']);
            $data['live_balance'] = $formatted_balance[0];

            $data['gallery_live'] = $this->GameGalleryModel->getDetailedGallery("live");
            // print_r($data['gallery_live']);exit;
            // Gallery Picture
            $data['gallery_live_id'] = $this->GameGalleryModel->getGalleryActivityByUserID("RAND()", $data['user_object'][0]->id, "live");
            // print_r($data['gallery_live']);exit;

            //Get unqiue image from gallery
            $unique_gallery = $this->GameGalleryModel->getUniqueGalleryImageByUserID('ASC', $data['user_object'][0]->id, 'live');
            //print_r($unique_gallery);exit;
            $randIndex = array_rand($unique_gallery);
            //print_r($unique_gallery[$randIndex]);exit;
            $data['unique_gallery_image'] = $unique_gallery[$randIndex];

            // Live Chellenge Picture URL
            $data['live_challenge_img_url'] = $data['gallery_live'][0]->challenge_img_url;

            $data['gallery_demo'] = $this->GameGalleryModel->getDetailedGallery("demo");

            //$data['row_game_messages'] = $this->MessageSettingsModel->getMessageSettings();
            //print_r($data['row_game_messages']);

            //Session
            // print_r($_SESSION);
            // Demo chellenge Picture URL
            // $data['demo_challenge_img_url'] = $data['gallery_demo'][0]->challenge_img_url;
            
            //Check if user account status if 0
            if($data['user_object'][0]->status == '0'){
                //load payment view
                $this->load->view('player/pages/payment/payment_view', $data);
            }else{
                $this->load->view('player/pages/game/levelgame_view', $data);
            }
        }else{
            redirect('account/login');
        } 
    }


    public function getNextLevelAjax(){
        if($this->session->userdata('player_logged_in_data')){

            //$id = $this->input->get('id');

            
            $logged_in_data = $this->session->userdata('player_logged_in_data');
            //print_r($logged_in_data);exit;
            $user_object = $this->UserModel->getUserAddressByUsername($logged_in_data['username']);
            //echo $user_object[0]->user_id;exit;
            //print_r($user_object);exit;
            $next_level = $user_object[0]->current_level;
            $next_level = $next_level + 1;
            $next_level = $this->LevelModel->getLevelByID($next_level);
            //print_r($next_level);exit;

            if(!empty($next_level)){
                print_r(json_encode($next_level[0]));
            }else{
                echo "end_of_level";
            }
        }else{
            echo "unauthorized";
        }
    }


    public function getGalleryAjax(){
        if($this->session->userdata('player_logged_in_data')){
            //$gallery_live = $this->GameGalleryModel->getDetailedGallery("live");
            $logged_in_data = $this->session->userdata('player_logged_in_data');
            //print_r($logged_in_data);exit;
            $user_object = $this->UserModel->getUserAddressByUsername($logged_in_data['username']);
            //echo $user_object[0]->user_id;exit;
            //print_r($user_object);exit;
            $unique_gallery = $this->GameGalleryModel->getUniqueGalleryImageByUserID('ASC', $user_object[0]->user_id, 'live');
            //print_r($unique_gallery);exit;
            
            if(!empty($unique_gallery)){
                $randIndex = array_rand($unique_gallery);
                //print_r($unique_gallery[$randIndex]);exit;
                $unique_gallery_image = $unique_gallery[$randIndex];

                if(!empty($unique_gallery_image)){
                    print_r(json_encode($unique_gallery_image));
                }else{
                    $message = array(
                        "message" => "no_data"
                    );
                    print_r(json_encode($message));
                }
            }else{
                $message = array(
                    "message" => "no_data"
                );
                print_r(json_encode($message));
            }
        }else{
            $message = array(
                "message" => "unauthorized"
            );
            print_r(json_encode($message));
        }
    }
public function GetStake()
{

    $account = $this->input->post('Stake');
   $Stakes = $this->StakeRowsModel->UserStake($account);

print_r(json_encode($Stakes));
}
    //This is signup view
    public function playrow(){
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
            $documents = $this->DocumentModel->getDocumentsByID($user_object[0]->id);
            //Check if any of the user document has not been approved yet
            $hasPendingDocuments = false;
            foreach ($documents as $key => $document) {
                if($document->approved == '0'){
                    $hasPendingDocuments = true;
                }
            }
            if($hasPendingDocuments){
                redirect('account/uploaddocuments');
            }
            //Control pending documents end
            
            $data['pagename'] = "row_game";
            $data['user_id']= $this->StakeRowsModel->UserStake($user_object[0]->id);
            $data['the_row_game'] = $this->RowGameModel->getTheRowGame();
            $data['the_row_game1'] = $this->StakeRowsModel->UserStake($user_object[0]->Default_Stake);
            //print_r($data['the_row_game']);exit;
            // Max Stakes
            $data['max_stake'] = $data['the_row_game'][0]->max_stake;
            $data['min_stake'] = $data['the_row_game'][0]->min_stake;
            // Min Stakes
            $data['number_of_row'] = $data['the_row_game1'][0]->Rows;

            $data['general_settings'] = $this->GeneralSettingsModel->getSettings();
            // print_r( $data['general_settings']);
            // $_SESSION["level_val"] = 1;

            //$logged_in_data = $this->session->userdata('player_logged_in_data');
            //print_r($logged_in_data);exit;
            //Get user_object
            $data['user_object'] = $this->UserModel->getUserAddressByUsername($logged_in_data['username']);

            //Get all images and activities
            $data['image_activities_live_rand'] = $this->GameGalleryModel->getGalleryActivity('RAND()', 'live');

            $data['image_activities_demo_rand'] = $this->GameGalleryModel->getGalleryActivity('RAND()', 'demo');

            $data['image_activities_live_asc'] = $this->GameGalleryModel->getGalleryActivity('ASC', 'live');

            $data['image_activities_demo_asc'] = $this->GameGalleryModel->getGalleryActivity('ASC', 'demo');

            $allgallery = $this->GameGalleryModel->getAllGallery();
            //print_r($allgallery);
            if($allgallery == false || empty($allgallery)){
                $this->session->set_flashdata('message', "Apologies game is offline!");
                redirect('account/settings');
            }
            if(count($allgallery) < $data['the_row_game'][0]->number_of_row){
                $this->session->set_flashdata('message', "Apologies, game is not available at this time!");
                redirect('account/settings');
            }

            $data['user_id'] = $data['user_object'][0]->user_id;

            $data['username'] = $data['user_object'][0]->username;


            //Game Timer
            $data['game_timer'] = $data['general_settings'][0]->game_timer;
            // Is Demo
            $data['isDemoAccount'] = $data['user_object'][0]->isDemoAccount;

            // Live Balance
            if(!empty($data['user_object'][0]->balance)){
                $data['live_balance'] = $data['user_object'][0]->balance;
            }else{
                $data['live_balance'] = 0;
            }
            // Demo Balance
            $data['demo_balance'] = $data['user_object'][0]->demo_balance;

            if($user_object[0]->isDemoAccount == '1'){
                $data['balance'] = $data['demo_balance'];
            }else{
                $data['balance'] = $data['live_balance'];
            }

            $formatted_balance = explode(".", $data['balance']);
            $data['balance'] = $formatted_balance[0];
            //echo $data['live_balance'];exit;

            $data['gallery_live'] = $this->GameGalleryModel->getDetailedGallery("live");
            //print_r($data['gallery_live']);exit;
            // Gallery Picture
            $data['gallery_live_id'] = $this->GameGalleryModel->getGalleryActivityByUserID("RAND()", $data['user_object'][0]->user_id, "live");
            // print_r($data['gallery_live']);exit;

            //Get unqiue image from gallery
            $unique_gallery = $this->GameGalleryModel->getUniqueGalleryImageByUserID('ASC', $data['user_object'][0]->user_id, 'live');
            if($unique_gallery == false){
                $this->session->set_flashdata('message', "Apologies game is offline!");
                redirect('account/settings');
            }
            //print_r($unique_gallery);exit;
            $randIndex = array_rand($unique_gallery);
            //print_r($unique_gallery[$randIndex]);exit;
            $data['unique_gallery_image'] = $unique_gallery[$randIndex];

            // Live Chellenge Picture URL
            $data['live_challenge_img_url'] = $data['gallery_live'][0]->challenge_img_url;

            $data['gallery_demo'] = $this->GameGalleryModel->getDetailedGallery("demo");

            $data['row_game_messages'] = $this->MessageSettingsModel->getMessageSettings();
            //print_r($data['row_game_messages']);

            //Session
            // print_r($_SESSION);
            // Demo chellenge Picture URL
            // $data['demo_challenge_img_url'] = $data['gallery_demo'][0]->challenge_img_url;
            
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
                $data['ActiveStakes']= $this->StakeRowsModel->getStakesActive();
                $data['default_stake'] = $user_object[0]->Default_Stake;
               
                $this->load->view('player/pages/game/rowgame_view', $data);
            }
        }else{
            redirect('account/login');
        } 
    }

// functio for add status to db for game
    // public function saveStatusUserGame()
    // {
    //     $data = array(
    //         "user_id_stake"=>$this->input->post('user_id_stake'),
    //         "stake_id"=>$this->input->post('stake_id'),
    //         "game_status"=>$this->input->post('status'),
    //         "date_time"=>$this->input->post('date'),
    //     );
    //     $this->user_game_row->insertStatus($data);
    //     echo "done";
    // }
    private function testimageactivity(){
        $game_played_record = array(
                "user_id" => 1,
                "username" => 'ripple',
                "date_played" => date('Y-d-m H:i:s'),
                "billed" => 100, //This is the amount deducted from their game credit
                "win_lost" => 1, //Did they get a correct answer or wrong, possible values 0, 1
                "game_type" => 'row', //Possible values level or row
                "stake" => 100, //How much did the player play with, for row, get value from row settings, level = level settings
                "img_x" => 20,//User clicked x co-ordinates
                "img_y" => 10,//User clicked y co-ordinators
                "time_out" => 'no',//Did the user time out while playing, possible values 'yes' or 'no'
                "amount_played" => 100, //Same amount as billed
            );
            if($this->GamePlayRecordModel->insertIntoGamePlayedRecord($game_played_record)){
                echo "success";
                //This is success scenario
            }else{
                echo "fail";
                //Failed scenario
            }
    }

    // Game win and update table
    public function updateGameWin(){
        // Add Your code Here To Update DB Billed
        //Check if user is logged in
        if($this->session->userdata('player_logged_in_data')){
            $logged_in_data = $this->session->userdata('player_logged_in_data');
            $user_object = $this->UserModel->getUserByUsername($logged_in_data['username']);
            //print_r($user_object);exit;
            $rowgame_win_status = $user_object[0]->rowgame_win;
            //echo $rowgame_win_status;exit;
            $rowgame_win_status += 1;

            $update_rowgame_user = array(
                "rowgame_win" => $rowgame_win_status
            );
            if($this->UserModel->updateUserinfo($user_object[0]->id, $update_rowgame_user)){
                echo "updatesuccess";exit;
            }else{
                echo "updatefailed";exit;
            }

            //Update user table column rowgame_win to 
            //updateUserinfo($id, $user_object_update)
        }else{
            echo "not_logged_in";exit;
        }
    }

    public function updateUserLevel(){

        //Add Your code Here To Update DB Billed
        //Check if user is logged in
        
        if($this->session->userdata('player_logged_in_data')){
            $logged_in_data = $this->session->userdata('player_logged_in_data');
            $user_object = $this->UserModel->getUserByUsername($logged_in_data['username']);
            //print_r($user_object);exit;
            $current_user_level = $user_object[0]->current_level;
            //$new_progress = $this->input->get('new_progress');
            //echo $rowgame_win_status;exit;
            $current_user_level += 1;

            //echo "User ".$user_object[0]->id;exit;

            //echo "Current Level " .$current_user_level;exit;

            $update_user_level = array(
                "current_level" => $current_user_level
            );
            //print_r($update_user_level);exit;
            if($this->UserModel->updateUserinfo($user_object[0]->id, $update_user_level)){
                echo "updatelevel-progress";exit;
            }else{
                echo "updatefailed";exit;
            }

            //Update user table column rowgame_win to 
            //updateUserinfo($id, $user_object_update)
        }else{
            echo "not_logged_in";exit;
        }
    }

    public function updateUserCurrentProgress(){
        //Add Your code Here To Update DB Billed
        //Check if user is logged in
        if($this->session->userdata('player_logged_in_data')){
            $logged_in_data = $this->session->userdata('player_logged_in_data');
            $user_object = $this->UserModel->getUserByUsername($logged_in_data['username']);
            //print_r($user_object);exit;
            
            //echo "User ".$user_object[0]->id;exit;

            $new_level_progress = $this->input->get('new_level_progress');
            //echo "Current Level " .$current_user_level;exit;
            //echo $new_level_progress;exit;

            $update_user_level_progress = array(
                "level_progress" => $new_level_progress
            );
            //print_r($update_user_level);exit;
            if($this->UserModel->updateUserinfo($user_object[0]->id, $update_user_level_progress)){
                echo "updatesuccess";exit;
            }else{
                echo "updatefailed";exit;
            }

            //Update user table column rowgame_win to 
            //updateUserinfo($id, $user_object_update)
        }else{
            echo "not_logged_in";exit;
        }
    }

    // check Cordinates Of Row Game Circle clicked..
    public function Check_cordinates_rowgame(){

       // $_SESSION["level_val"] = $_SESSION["level_val"]+1;

       $user_id = $this->input->post('user_id');
       $distance = $this->input->post('distance');
       $img_id = $this->input->post('img_id');
       $stakes = $this->input->post('max_stake');
       $username = $this->input->post('username');
       $img_url = $this->input->post('img_url');


       // Distance
       $distance = $this->input->post('distance');
       if($distance >= 0 && $distance <= 35){
           $data = array(
                'user_id'=>$user_id,
                'gamegallery_id'=>$img_id,
                'win'=> 1,
                'lose'=> 0,
                'stakes'=>$stakes,
                'date_time'=>date('Y-d-m H:i:s')
            );
            if($this->ImageActivityModel->insertIntoImageActivity($data)){
                echo "win";
            }else{
                echo "false";
            }
            // if($this->ImageActivityModel->insertIntoImageActivity($data)){
            //     //Prepare gameplayedrecord
            //     $game_played_record = array(
            //         "user_id" => $user_id,
            //         "username" => $username,
            //         "date_played" => date('Y-d-m H:i:s'),
            //         "billed" => $stakes, //This is the amount deducted from their game credit
            //         "win_lost" => 1, //Did they get a correct answer or wrong, possible values 0, 1
            //         "game_type" => 'row', //Possible values level or row
            //         "stake" => 100, //How much did the player play with, for row, get value from row settings, level = level settings
            //         "img_x" => 10,//User clicked x co-ordinates
            //         "img_y" => 20,//User clicked y co-ordinators
            //         "time_out" => 'yes',//Did the user time out while playing, possible values 'yes' or 'no'
            //         "amount_played" => 100, //Same amount as billed
            //     ); 
            //      if($this->GamePlayRecordModel->insertIntoGamePlayedRecord($game_played_record)){
            //         //$new_balance = $old_balance
            //         //if(win){$new_balance = $old_balance + $game_balance;}else{$new_balance = $old_balance - $gamae_balance; }
            //         $user_update = array(
            //             "balance" => 500 //If it's row game, only update balance
            //             //To update balance you need to first get the current balance then plus/minus new balance
            //         );
                    
            //         Level Game
            //         $user_update = array(
            //             "balance" => //If it's row game, only update balance
            //             //To update balance you need to first get the current balance then plus/minus new balance
            //         );
            //         //Only update current level if level incresed since last
            //         $user_update = array(
            //             "current_level" => //If it's row game, only update balance
            //             //To update balance you need to first get the current balance then plus/minus new balance
            //         );
                    
            //     } 
            // } 
            // header('Location: '.redirect("game/playrow"));
        // }else{
        //     $data = array(
        //         'user_id'=>$user_id,
        //         'gamegallery_id'=>$img_id,
        //         'win'=> 0,
        //         'lose'=> 1,
        //         'stakes'=>$stakes,
        //         'date_time'=>date('Y-d-m H:i:s')
        //     );
        //     if($this->ImageActivityModel->insertIntoImageActivity($data)){
        //         echo "lose";
        //     }else{
        //         echo "false";
        //     }
            //print_r($data);exit;

            // Add Activit Record Here
            // $data['gallery_image_data_live'] = $this->GameGalleryModel->galleryImageRecordById($img_id);
            // header('Location: '.redirect("/game/playrow"));
        }

    }

    public function updateGamePlayRecords(){
        if($this->session->userdata('player_logged_in_data')){
            $logged_in_data = $this->session->userdata('player_logged_in_data');
            //print_r($logged_in_data);exit;
            //Get user_object
            $user_object = $this->UserModel->getUserAddressByUsername($logged_in_data['username']);

            //get billed amount
            $billed = $this->input->post('billed_amount');
            $game_type = $this->input->post('type');
            $img_x = $this->input->post('x');
            $img_y = $this->input->post('y');
            $win_lost = $this->input->post('win_lost');
            $number_of_rows_won = $this->input->post('number_of_rows_won');
            $number_of_rows_won_out_of = $this->input->post('number_of_rows_won_out_of');

            $gamerecord_object = array(
                "user_id" => $user_object[0]->user_id,
                "username" => $logged_in_data['username'],
                "billed" => $billed,
                "win_lost" => $win_lost,
                "game_type" => $game_type,
                "stake" => $billed,
                "img_x" => $img_x,
                "img_y" => $img_y,
                "time_out" => 'no', //Static value
                "amount_played" => $billed,
                "number_of_rows_won" => $number_of_rows_won,
                "number_of_rows_won_out_of" => $number_of_rows_won_out_of
            );
            //print_r($gamerecord_object);exit;

            if($this->GamePlayRecordModel->insertIntoGamePlayedRecord($gamerecord_object)){
                echo "success";
            }else{
                echo "fail";
            }
        }else{
            echo "unauthorized";
        }
    }

    public function increaseBalance(){
        if($this->session->userdata('player_logged_in_data')){
            $logged_in_data = $this->session->userdata('player_logged_in_data');
            //print_r($logged_in_data);exit;
            //Get user_object
            $user_object = $this->UserModel->getUserAddressByUsername($logged_in_data['username']);

            $general_settings = $this->GeneralSettingsModel->getSettings();

            //get billed amount
            //$credit_to_update = $general_settings[0]->stake_conversion_level * $this->input->post('billed_amount');
            $credit_to_update = (($this->input->post('billed_amount') / 100) * $general_settings[0]->stake_conversion_level) + $this->input->post('billed_amount');
            //echo $credit_to_update;exit;
            if($user_object[0]->isDemoAccount == '1'){
                if($this->UserModel->increaseDemoBalance($credit_to_update, $user_object[0]->user_id)){
                    echo "success";
                }else{
                    echo "fail";
                }
            }else{
                if($this->UserModel->increaseBalance($credit_to_update, $user_object[0]->user_id)){
                    echo "success";
                }else{
                    echo "fail";
                }
            }
            
        }else{
            echo "unauthorized";
        }
    }


    public function deductBalance(){
        if($this->session->userdata('player_logged_in_data')){
            $logged_in_data = $this->session->userdata('player_logged_in_data');
            //print_r($logged_in_data);exit;
            //Get user_object
            $user_object = $this->UserModel->getUserAddressByUsername($logged_in_data['username']);


            $general_settings = $this->GeneralSettingsModel->getSettings();

            //get billed amount
            $credit_to_update = $this->input->post('billed_amount');

            if($user_object[0]->isDemoAccount == '1'){
                if($this->UserModel->deductDemoBalance($credit_to_update, $user_object[0]->user_id)){
                    echo "success";
                }else{
                    echo "fail";
                }
            }else{
                if($this->UserModel->deductBalance($credit_to_update, $user_object[0]->user_id)){
                    $currentBalance = $this->UserModel->currentBalance($user_object[0]->user_id);
                    
                    echo $currentBalance;
                }else{
                    echo "fails";
                }
            }
            
        }else{
            echo "unauthorized";
        }
    }


    private function prizes(){
        $this->checkIsBlocked();

        $data['pagename'] = "prizes";
        $logged_in_data = $this->session->userdata('player_logged_in_data');

        //Check if user account status if 0
        if($logged_in_data['status'] == '0'){
            //load payment view
            $this->load->view('player/pages/payment/payment_view', $data);
        }else{
            if($this->session->userdata('player_logged_in_data')){
                //Get just user info by username
                $user_object = $this->UserModel->getUserByUsername($logged_in_data['username']);

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
                    $this->session->set_flashdata('documents_pending', "You have pending documents that needs to be approved!");
                }
            }

            $this->load->view('player/pages/game/level_prize_view', $data);
        }
    }

    private function prizedetails(){
        $this->checkIsBlocked();

        $data['pagename'] = "prizes";

        $logged_in_data = $this->session->userdata('player_logged_in_data');
        //print_r($logged_in_data);

        //Check if user account status if 0
        if($logged_in_data['status'] == '0'){
            //load payment view
            $this->load->view('player/pages/payment/payment_view', $data);
        }else{
            if($this->session->userdata('player_logged_in_data')){
                //Get just user info by username
                $user_object = $this->UserModel->getUserByUsername($logged_in_data['username']);

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
                    $this->session->set_flashdata('documents_pending', "You have pending documents that needs to be approved!");
                }
            }

            $this->load->view('player/pages/game/level_prize_details_view', $data);
        }
    }
}