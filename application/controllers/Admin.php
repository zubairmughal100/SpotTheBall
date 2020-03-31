<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {


    public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->helper('html');
        $this->load->helper('url');

        // Load session through controller
        $this->load->library('session');

        $this->load->model('AdminModel');

        $this->load->model('ContinentModel');
        $this->load->model('CountryModel');
        $this->load->model('StateModel');
        $this->load->model('CountyModel');
        $this->load->model('CityModel');

        $this->load->model('UserModel');
        $this->load->model('DocumentModel');
        $this->load->model('PaymentCardModel');
        $this->load->model('AddressModel');

        $this->load->model('GeneralSettingsModel');
        $this->load->model('PaymentSettingsModel');

        $this->load->model('GameGalleryModel');

        $this->load->model('LevelModel');

        $this->load->model('LevelPrizeModel');
        $this->load->model('LevelPrizeImageModel');

        $this->load->model('RowGameModel');

        //Prize collection
        $this->load->model('LevelPrizeCollectionModel');
        $this->load->model('RowPrizeCollectionModel');

        //Game Play Record
        $this->load->model('GamePlayRecordModel');

        $this->load->model('AccountTransactionsModel');

        $this->load->model('MessageSettingsModel');

        $this->load->model('BlogPageModel');
        $this->load->model('RowPrizeModel');

        //Load LoginActivityModel
        $this->load->model('LoginActivityModel');

        //Load Ci Session model
        $this->load->model('CISessionModel');
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

    public function index(){
        if($this->session->userdata('admin_logged_in_data')){
            // Store the IP address
            //$ip = "86.44.67.106";
            $ip = $this->getVisIPAddr();
            $country_json_object = $this->getCountryAPI($ip);
            //echo $country_json_object->geoplugin_countryCode;exit;
            //$blocked_continents = $this->ContinentModel->blockedContinents();
            //print_r($blocked_continents);exit;
            /*
            if($this->isBlocked($blocked_continents, $country_json_object->geoplugin_continentCode, $country_json_object->geoplugin_continentName)){
                echo "Continent is Blocked";
                die();
            }
            */

            $data['pagename'] = "dashboard";

            //Todays top 5 winners
            $data['top_5_game_winner'] = $this->GamePlayRecordModel->getTopWinnerGamePlayedRecordByDate(date('Y-m-d'), 5);
            //Todays to 5 losers
            $data['top_5_game_loser'] = $this->GamePlayRecordModel->getTopLoserGamePlayedRecordByDate(date('Y-m-d'), 5);
            //Todays total
            $data['todays_total'] = $this->AccountTransactionsModel->getTotalByDate(date('Y-m-d'));
            //Months total
            $data['monthly_total'] = $this->AccountTransactionsModel->monthlyTotal();
            //Yearly total
            $data['yearly_total'] = $this->AccountTransactionsModel->yearlyTotal();
            //All time total
            $data['all_time_total'] = $this->AccountTransactionsModel->allTimeTotal();

            //Total signups today
            $data['total_signup_today'] = $this->UserModel->getTotalSignupByDate(date('Y-m-d'));
            //Total signups this month
            $data['total_monthly_signup'] = $this->UserModel->totalSignupThisMonth();
            //Total signups this year
            $data['total_yearly_signup'] = $this->UserModel->totalSignupThisYear();
            //Total signups all time
            $data['total_alltime_signup'] = $this->UserModel->totalSignupAllTime();

            //Get online users
            $data['online_users'] = $this->LoginActivityModel->getOnlineUsers(0, false, 30);
            //print_r($data['online_users']);
            
            //Expire any login activities older than 2 hours and delete the ci_sessions
            if($data['online_users'] != false){
                foreach ($data['online_users'] as $key => $activity) {
                    $today = strtotime("-4 hours");
                    $activity_last_seen = strtotime($activity->last_seen_datetime);
                    //Check if current time is greater than 4 hours older than last_seen
                    if($activity_last_seen <= $today){
                        //More than 4 hours ago
                        //echo $activity->session_id . "<br>";
                        //Expire login activity
                        $this->LoginActivityModel->expireLoginActivity($activity->user_id, $activity->session_id);
                        //Delete session
                        $this->CISessionModel->deleteCiSession($activity->session_id);
                    }
                }
            }
            //exit;
            
            //Get Highest score sort by date and number of rows
            $data['higest_score_by_rows'] = $this->GamePlayRecordModel->highestByNumberOfRows(20);
            //print_r($data['higest_score_by_rows']);exit;

            //Monthly transactions
            $data['transaction_monthly_report'] = $this->AccountTransactionsModel->getMonthlyReportMethodTwo();
            //print_r($data['transaction_monthly_report']);exit;

            $this->load->view('admin/pages/dashboard/dashboard', $data);
        }else{
            redirect('admin/login');
        }
    }

    //Make it private if not in use
    private function emptytemplate(){
        $data['pagename'] = "emptytemplate";
        $this->load->view('admin/pages/template/404', $data);
    }


    /////////////////////////////////////////////////
    // General Settings Start
    /////////////////////////////////////////////////
    // Adding Blog Page
    public function blogpages(){
        if($this->session->userdata('admin_logged_in_data')){
            $data['pagename'] = "blogpages";

            $data['blogpages'] = $this->BlogPageModel->getBlog();
            //print_r($data['blogpages']);exit;

            $this->load->view('admin/pages/general_settings/blog_pages', $data);
        }else{
            redirect('admin/login');
        }
    }

    public function addblog(){
        if($this->session->userdata('admin_logged_in_data')){
            if($this->input->post('btnPublishBlog')){
                $blog_object = array(
                    "title" => $this->input->post('title'),
                    "message" => $this->input->post('message'),
                    "is_public" => $this->input->post('is_public'),
                    "is_draft" => '0',
                    "status" => '1',
                    "tab_name" => $this->input->post('tab_name')
                );
                //print_r($blog_object);exit;
                if($this->BlogPageModel->insertIntoBlogPage($blog_object)){
                    $this->session->set_flashdata('message_success', "Blog added successfully!");
                }else{
                    $this->session->set_flashdata('message_success', "Blog could not been added successfully!");
                }
            }else{
                $blog_object = array(
                    "title" => $this->input->post('title'),
                    "message" => $this->input->post('message'),
                    "is_public" => $this->input->post('is_public'),
                    "is_draft" => '1',
                    "status" => '1',
                    "tab_name" => $this->input->post('tab_name')
                );
                //print_r($blog_object);exit;
                if($this->BlogPageModel->insertIntoBlogPage($blog_object)){
                    $this->session->set_flashdata('message_success', "Blog added successfully!");
                }else{
                    $this->session->set_flashdata('message_success', "Blog could not been added successfully!");
                }
            }
            redirect('admin/blogpages');
        }else{
            redirect('admin/login');
        }
    }
    public function editblog(){
        if($this->session->userdata('admin_logged_in_data')){
            $data['pagename'] = "blogpages";

            $id = $this->input->get('id');

            if(!empty($id)){
                $data['the_blog'] = $this->BlogPageModel->getBlogByID($id);
                //print_r($data['the_blog']);exit;
                $data['blogpages'] = $this->BlogPageModel->getBlog();
                //print_r($data['blogpages']);exit;

                $this->load->view('admin/pages/general_settings/edit_blog', $data);
            }else{
                $this->session->set_flashdata('message_success', "Blog could not been found!");
                redirect('admin/blogpages');
            }
        }else{
            redirect('admin/login');
        }
    }
    public function updateblog(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->post('id');
            if($this->input->post('btnPublishBlog')){
                $blog_object = array(
                    "title" => $this->input->post('title'),
                    "message" => $this->input->post('message'),
                    "is_public" => $this->input->post('is_public'),
                    "is_draft" => '0',
                    "status" => '1',
                    "tab_name" => $this->input->post('tab_name')
                );
                //print_r($blog_object);exit;
                if($this->BlogPageModel->updateBlog($id, $blog_object)){
                    $this->session->set_flashdata('message_success', "Blog updated successfully!");
                }else{
                    $this->session->set_flashdata('message_error', "Blog could not been updated successfully!");
                }
            }else{
                $blog_object = array(
                    "title" => $this->input->post('title'),
                    "message" => $this->input->post('message'),
                    "is_public" => $this->input->post('is_public'),
                    "is_draft" => '1',
                    "status" => '1',
                    "tab_name" => $this->input->post('tab_name')
                );
                //print_r($blog_object);exit;
                if($this->BlogPageModel->updateBlog($id, $blog_object)){
                    $this->session->set_flashdata('message_success', "Blog updated successfully!");
                }else{
                    $this->session->set_flashdata('message_success', "Blog could not been updated successfully!");
                }
            }
            redirect('admin/blogpages');
        }else{
            redirect('admin/login');
        }
    }
    public function deleteblog(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->get('id');
            if($this->BlogPageModel->deleteBlog($id)){
                $this->session->set_flashdata('message_success', "Blog deleted successfully!");
            }else{
                $this->session->set_flashdata('message_error', "Blog could not been deleted!");
            }
            redirect('admin/blogpages');
        }else{
            redirect('admin/login');
        }
    }
    public function messages(){
        if($this->session->userdata('admin_logged_in_data')){
            $data['pagename'] = "messages";

            $data['messagesettings'] = $this->MessageSettingsModel->getMessageSettings();

            //print_r($data['messagesettings']);exit;

            $this->load->view('admin/pages/general_settings/game_messages', $data);
        }else{
            redirect('admin/login');
        }
    }
    public function updatemessagesettings(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->post('id');
            if(!empty($id)){
                if($this->input->post('btnUpdateMessage')){
                    $message_update = array(
                        "message" => $this->input->post('message'),
                        "type" => $this->input->post('type')
                    );
                    if($this->MessageSettingsModel->updateMessage($id, $message_update)){
                        $this->session->set_flashdata('message_success', "Message updated successfully!");
                    }else{
                        $this->session->set_flashdata('message_error', "Error could not been update message!");
                    }
                }else{
                    if($this->MessageSettingsModel->deleteMessage($id)){
                        $this->session->set_flashdata('message_success', "Message deleted successfully!");
                    }else{
                        $this->session->set_flashdata('message_error', "Error could not been deleted message!");
                    }
                }
            }else{
                $this->session->set_flashdata('message_error', "Could not find message to update!");
            }
            redirect('admin/messages');
        }else{
            redirect('admin/login');
        }
    }
    public function addnewmessage(){
        if($this->session->userdata('admin_logged_in_data')){
            $message_update = array(
                "message" => $this->input->post('message'),
                "type" => $this->input->post('message_type')
            );
            if($this->MessageSettingsModel->insertIntoMessageSettings($message_update)){
                $this->session->set_flashdata('message_success', "Message added successfully!");
            }else{
                $this->session->set_flashdata('message_error', "Error could not add message!");
            }
            redirect('admin/messages');
        }else{
            redirect('admin/login');
        }
    }
    //Country settings start
    public function addcountry(){
        if($this->session->userdata('admin_logged_in_data')){
            $data['pagename'] = "country";

            //Get list of continents
            $data['continents'] = $this->ContinentModel->getAllContinentsByOrder();

            //Get list of all countries
            $data['countries'] = $this->CountryModel->getAllCountries();

            $this->load->view('admin/pages/general_settings/add_country', $data);
        }else{
            redirect('admin/login');
        }
    }
    public function addcountrytodb(){
        if($this->session->userdata('admin_logged_in_data')){
            //Check if btnAddCountry was clicked
            if($this->input->post('btnAddCountry')){
                $aCountry = array(
                    "name" => $this->input->post('country_name'),
                    "continent_id" => $this->input->post('continent_id'),
                    "code" => $this->input->post('code'),
                    "status" => "1"
                );
                
            }
            if(!$this->CountryModel->countryExistsByName($this->input->post('country_name'))){
                if($this->CountryModel->insertIntoCountry($aCountry)){
                    $this->session->set_flashdata('message_success', "<strong>" .$this->input->post('country_name'). "</strong> has been added successfully!");
                }else{
                    $this->session->set_flashdata('message_error', "Could not add <strong>" .$this->input->post('country_name'). "</strong>");
                }
            }else{
                $this->session->set_flashdata('message_error', "<strong>" .$this->input->post('country_name'). "</strong> already exists!");
            }
            
            redirect('admin/addcountry');
        }else{
            redirect('admin/login');
        }
    }
    public function deletecountry(){
        if($this->session->userdata('admin_logged_in_data')){
            //Get country id from get request
            $country_id = $this->input->get('countryid');
            //Get country name
            $country_name = $this->input->get('name');

            if($this->CountryModel->countryExistsByID($country_id)){
                //Country has been found, now call delete function
                if($this->CountryModel->deleteCountry($country_id)){
                    $this->session->set_flashdata('delete_success', "<strong>" .$country_name. "</strong> has been deleted successfully!");
                }else{
                    $this->session->set_flashdata('delete_error', "<strong>" .$country_name. "</strong> could not be deleted!");
                }
            }else{
                $this->session->set_flashdata('delete_error', "<strong>" .$country_name. "</strong> could not be found!");
            }
            redirect('admin/addcountry');
        }else{
            redirect('admin/login');
        }
    }

    public function addstate(){
        if($this->session->userdata('admin_logged_in_data')){
            $data['pagename'] = "country";

            //Get list of continents
            $data['continents'] = $this->ContinentModel->getAllContinentsByOrder();

            //Get list of all countries
            $data['countries'] = $this->CountryModel->getAllCountries();

            //Get list of all states
            $data['states'] = $this->StateModel->getAllStatesOrderBy();

            $this->load->view('admin/pages/general_settings/add_state', $data);
        }else{
            redirect('admin/login');
        }
    }
    public function addstatetodb(){
        if($this->session->userdata('admin_logged_in_data')){
            //Get country name
            $country_code = $this->CountryModel->getCountryCodeByID($this->input->post('country_id'));
            if(!empty($country_code) || $country_code != false){
                //Check if Country 2 digit iso code is
                if($country_code == "US" || $country_code == "us"){
                    //Check if btnAddCountry was clicked
                    if($this->input->post('btnAddState')){
                        $aState = array(
                            "name" => $this->input->post('state_name'),
                            "country_id" => $this->input->post('country_id'),
                            "code" => strtoupper($this->input->post('code')),
                            "status" => "1"
                        );
                    }
                    if(!$this->StateModel->stateExistsByName($this->input->post('state_name'))){
                        if($this->StateModel->insertIntoState($aState)){
                            $this->session->set_flashdata('message_success', "<strong>" .$this->input->post('state_name'). "</strong> has been added successfully!");
                        }else{
                            $this->session->set_flashdata('message_error', "Could not add <strong>" .$this->input->post('state_name'). "</strong>");
                        }
                    }else{
                        $this->session->set_flashdata('message_error', "<strong>" .$this->input->post('state_name'). "</strong> already exists!");
                    }
                }else{
                    $this->session->set_flashdata('message_error', "You can only add states for USA!");
                }
            }else{
                $this->session->set_flashdata('message_error', "Selected country could not been found!");
            }
            
            
            redirect('admin/addstate');
        }else{
            redirect('admin/login');
        }
    }
    public function deletestate(){
        if($this->session->userdata('admin_logged_in_data')){
            //Get country id from get request
            $state_id = $this->input->get('stateid');
            //Get country name
            $state_name = $this->input->get('name');

            if($this->StateModel->stateExistsByID($state_id)){
                //Country has been found, now call delete function
                if($this->StateModel->deleteState($state_id)){
                    $this->session->set_flashdata('delete_success', "<strong>" .$state_name. "</strong> has been deleted successfully!");
                }else{
                    $this->session->set_flashdata('delete_error', "<strong>" .$state_name. "</strong> could not be deleted!");
                }
            }else{
                $this->session->set_flashdata('delete_error', "<strong>" .$state_name. "</strong> could not be found!");
            }
            redirect('admin/addstate');
        }else{
            redirect('admin/login');
        }
    }

    //These three functions has been disabled
    private function addcounty(){
        if($this->session->userdata('admin_logged_in_data')){
            $data['pagename'] = "country";

            //Get list of continents
            $data['continents'] = $this->ContinentModel->getAllContinentsByOrder();

            //Get list of all countries
            $data['countries'] = $this->CountryModel->getAllCountries();

            //Get list of all states
            $data['states'] = $this->StateModel->getAllStatesOrderBy();

            $data['counties'] = $this->CountyModel->getAllCountiesOrderBy();

            //Get list of all cities
            //$data['cities'] = $this->CityModel->getAllCitiesOrderBy();

            $this->load->view('admin/pages/general_settings/add_county', $data);
        }else{
            redirect('admin/login');
        }
    }
    private function addcountytodb(){
        if($this->session->userdata('admin_logged_in_data')){
            //Check if btnAddCountry was clicked
            if($this->input->post('btnAddCounty')){
                $aState = array(
                    "name" => $this->input->post('county_name'),
                    "state_id" => $this->input->post('state_id'),
                    "status" => "1"
                );
                
            }
            if(!$this->CountyModel->countyExistsByName($this->input->post('state_name'))){
                if($this->CountyModel->insertIntoCounty($aState)){
                    $this->session->set_flashdata('message_success', "<strong>" .$this->input->post('county_name'). "</strong> has been added successfully!");
                }else{
                    $this->session->set_flashdata('message_error', "Could not add <strong>" .$this->input->post('county_name'). "</strong>");
                }
            }else{
                $this->session->set_flashdata('message_error', "<strong>" .$this->input->post('county_name'). "</strong> already exists!");
            }
            
            redirect('admin/addcounty');
        }else{
            redirect('admin/login');
        }
    }
    private function deletecounty(){
        if($this->session->userdata('admin_logged_in_data')){
            //Get country id from get request
            $county_id = $this->input->get('countyid');
            //Get country name
            $county_name = $this->input->get('name');

            if($this->CountyModel->countyExistsByID($county_id)){
                //Country has been found, now call delete function
                if($this->CountyModel->deleteCounty($county_id)){
                    $this->session->set_flashdata('delete_success', "<strong>" .$county_name. "</strong> has been deleted successfully!");
                }else{
                    $this->session->set_flashdata('delete_error', "<strong>" .$county_name. "</strong> could not be deleted!");
                }
            }else{
                $this->session->set_flashdata('delete_error', "<strong>" .$county_name. "</strong> could not be found!");
            }
            redirect('admin/addcounty');
        }else{
            redirect('admin/login');
        }
    }
    //These three functions has been disabled

    public function addcityusa(){
        if($this->session->userdata('admin_logged_in_data')){
            $data['pagename'] = "country";

            //Get list of continents
            $data['continents'] = $this->ContinentModel->getAllContinentsByOrder();

            //Get list of all countries
            $data['countries'] = $this->CountryModel->getAllCountries();

            //Get list of all states
            $data['states'] = $this->StateModel->getAllStatesOrderBy();

            //Get list of counties
            $data['counties'] = $this->CountyModel->getAllCountiesOrderBy();

            //Get list of all cities
            $data['cities'] = $this->CityModel->getAllCitiesOrderBy();

            $this->load->view('admin/pages/general_settings/add_city_usa', $data);
        }else{
            redirect('admin/login');
        }
    }
    public function addcityusatodb(){
        if($this->session->userdata('admin_logged_in_data')){
            //Get country name
            $country_name = $this->CountryModel->getCountryNameByID($this->input->post('country_id'));
            $country_code = $this->CountryModel->getCountryCodeByID($this->input->post('country_id'));
            if(!empty($country_name)){
                if(strtolower($country_name) == "usa" || strtolower($country_code) == "us"){
                    //Check if btnAddCountry was clicked
                    if($this->input->post('btnAddCity')){
                        $aCity = array(
                            "name" => $this->input->post('city_name'),
                            "state_id" => $this->input->post('state_id'),
                            "code" => $this->input->post('code'),
                            "status" => "1"
                        );
                        
                    }
                    if(!$this->CityModel->cityExistsByName($this->input->post('state_name'))){
                        if($this->CityModel->insertIntoCity($aCity)){
                            $this->session->set_flashdata('message_success', "<strong>" .$this->input->post('city_name'). "</strong> has been added successfully!");
                        }else{
                            $this->session->set_flashdata('message_error', "Could not add <strong>" .$this->input->post('city_name'). "</strong>");
                        }
                    }else{
                        $this->session->set_flashdata('message_error', "<strong>" .$this->input->post('city_name'). "</strong> already exists!");
                    }
                }else{
                    $this->session->set_flashdata('message_error', "You can only add city to USA States");
                }
            }else{
                $this->session->set_flashdata('message_error', "Selected country could not be found");
            }
            redirect('admin/addcityusa');
        }else{
            redirect('admin/login');
        }
    }

    public function addcity(){
        if($this->session->userdata('admin_logged_in_data')){
            $data['pagename'] = "country";

            //Get list of continents
            $data['continents'] = $this->ContinentModel->getAllContinentsByOrder();

            //Get list of all countries
            $data['countries'] = $this->CountryModel->getAllCountries();

            //Get list of all states
            $data['states'] = $this->StateModel->getAllStatesOrderBy();

            //Get list of counties
            $data['counties'] = $this->CountyModel->getAllCountiesOrderBy();

            //Get list of all cities
            $data['cities'] = $this->CityModel->getAllCitiesOrderBy();

            $this->load->view('admin/pages/general_settings/add_city', $data);
        }else{
            redirect('admin/login');
        }
    }
    public function addcitytodb(){
        if($this->session->userdata('admin_logged_in_data')){
            //Get country name
            $country_name = $this->CountryModel->getCountryNameByID($this->input->post('country_id'));
            $country_code = $this->CountryModel->getCountryCodeByID($this->input->post('country_id'));
            if(!empty($country_name)){
                //Check if country name or code has us/usa
                if(strtolower($country_name) != "usa" || strtolower($country_code) != "us"){
                    //Check if btnAddCountry was clicked
                    if($this->input->post('btnAddCity')){
                        $aCity = array(
                            "name" => $this->input->post('city_name'),
                            "country_id" => $this->input->post('country_id'),
                            "code" => strtoupper($this->input->post('code')),
                            "status" => "1"
                        );
                        
                    }
                    if(!$this->CityModel->cityExistsByName($this->input->post('city_name'))){
                        if($this->CityModel->insertIntoCity($aCity)){
                            $this->session->set_flashdata('message_success', "<strong>" .$this->input->post('city_name'). "</strong> has been added successfully!");
                        }else{
                            $this->session->set_flashdata('message_error', "Could not add <strong>" .$this->input->post('city_name'). "</strong>");
                        }
                    }else{
                        $this->session->set_flashdata('message_error', "<strong>" .$this->input->post('city_name'). "</strong> already exists!");
                    }
                }else{
                    $this->session->set_flashdata('message_error', "Cannot add city directly into USA");
                }
            }else{
                $this->session->set_flashdata('message_error', "Could not find selected country");
            }
            
            
            redirect('admin/addcity');
        }else{
            redirect('admin/login');
        }
    }
    public function deletecity(){
        if($this->session->userdata('admin_logged_in_data')){
            //Get country id from get request
            $city_id = $this->input->get('cityid');
            //Get country name
            $city_name = $this->input->get('name');

            if($this->CityModel->cityExistsByID($city_id)){
                //Country has been found, now call delete function
                if($this->CityModel->deleteCity($city_id)){
                    $this->session->set_flashdata('delete_success', "<strong>" .$city_name. "</strong> has been deleted successfully!");
                }else{
                    $this->session->set_flashdata('delete_error', "<strong>" .$city_name. "</strong> could not be deleted!");
                }
            }else{
                $this->session->set_flashdata('delete_error', "<strong>" .$city_name. "</strong> could not be found!");
            }
            redirect('admin/addcity');
        }else{
            redirect('admin/login');
        }
    }
    //Country settings end
    
    //Banned users settings start
    public function bannedlist(){
        if($this->session->userdata('admin_logged_in_data')){
            $data['pagename'] = "banned_list";

            $data['banned_users'] = $this->UserModel->getAllBannedUsers();

            $this->load->view('admin/pages/general_settings/banned_list', $data);
        }else{
            redirect('admin/login');
        }
    }
    public function banemail(){
        if($this->session->userdata('admin_logged_in_data')){
            //Get email
            $email = $this->input->post('email');

            //Check if email exists in database
            if($this->UserModel->userExistsByEmail($email)){
                //Email found in database, procceed to ban this email by updating the status to 3
                if($this->UserModel->updateAccountStatusByEmail("3", $email)){
                    $this->session->set_flashdata('ban_success', "<strong>" .$email. "</strong> has been banned successfully!");
                }else{
                    $this->session->set_flashdata('ban_error', "<strong>" .$email. "</strong> could not been banned!");
                }
            }else{
                $this->session->set_flashdata('ban_error', "<strong>" .$email. "</strong> was not found in database!");
            }
            redirect('admin/bannedlist');
        }else{
            redirect('admin/login');
        }
    }
    public function removeban(){
        if($this->session->userdata('admin_logged_in_data')){
            //Get email
            $email = $this->input->get('email');

            //Check if email exists in database
            if($this->UserModel->userExistsByEmail($email)){
                //Email found in database, procceed to ban this email by updating the status to 3
                if($this->UserModel->updateAccountStatusByEmail("1", $email)){
                    $this->session->set_flashdata('remove_ban_success', "<strong>" .$email. "&quot;s</strong> ban has been removed successfully!");
                }else{
                    $this->session->set_flashdata('remove_ban_error', "<strong>" .$email. "&quot;s</strong> ban could not been removed!");
                }
            }else{
                $this->session->set_flashdata('ban_error', "<strong>" .$email. "</strong> was not found in database!");
            }
            redirect('admin/bannedlist');
        }else{
            redirect('admin/login');
        }
    }
    //Banned users settings end

    //Manage users settings start
    public function users(){
        if($this->session->userdata('admin_logged_in_data')){
            $data['pagename'] = "users";

            $data['active_users'] = $this->UserModel->getAllUsersLastLoggedIn();

            $data['user_pending_docs'] = $this->UserModel->getUsersWithPendingDocuments();

            $this->load->view('admin/pages/general_settings/all_users', $data);
        }else{
            redirect('admin/login');
        }
    }
    public function newuser(){
        if($this->session->userdata('admin_logged_in_data')){
            $data['pagename'] = "newuser";

            //Get list of continents
            $data['continents'] = $this->ContinentModel->getAllContinentsByOrder();

            //Get list of all countries
            $data['countries'] = $this->CountryModel->getAllCountries();

            //Get list of all states
            $data['states'] = $this->StateModel->getAllStatesOrderBy();

            //Get list of counties
            $data['counties'] = $this->CountyModel->getAllCountiesOrderBy();

            //Get list of all cities
            $data['cities'] = $this->CityModel->getAllCitiesOrderBy();

            //Get unique account number
            $data['unique_user_id'] = $this->GenerateUniqueUserID();

            $this->load->view('admin/pages/general_settings/add_new_user', $data);
        }else{
            redirect('admin/login');
        }
    }
    public function addnewusertodb(){
        if($this->session->userdata('admin_logged_in_data')){
            $user_type=$this->session->userdata('admin_logged_in_data');
            if(!$user_type['user_type']=="Moderator"||$user_type['user_type']=="Editor"){
            //Get driving license / Passport
            $licensePassport = $this->input->post('drivingLicenseOrPassportFile');
            //Get utility bill
            $utilityBill = $this->input->post('utilityBillFile');
            //Get bank statement
            $bankStatement = $this->input->post('bankStatementFile');

            $dob = explode("/", $this->input->post('dob'));

            $balance = 0;
            if($this->input->post('balance')){
                $balance = $this->input->post('balance');
            }

            $isDemo = '0';
            if($this->input->post('isDemoAccount')){
                $isDemo = $this->input->post('isDemoAccount');
            }

            $demo_balance = 0;
            if($this->input->post('demo_balance')){
                $demo_balance = $this->input->post('demo_balance');
            }

            $status = '0';
            if($this->input->post('status')){
                $status = $this->input->post('status');
            }

            $state_name = "null";
            if(!empty($state)){
                $tmp_state_name = $this->StateModel->getStateNameByID($this->input->post('state_id'));
                if($tmp_state_name != false){
                    $state_name = $tmp_state_name;
                }
            }

            $user_object = array(
                "id" => $this->input->post('user_id'),
                "title" => $this->input->post('title'),
                "email" => $this->input->post('email'),
                "password" => md5($this->input->post('password')),
                "username" => $this->input->post('username'),
                "first_name" => $this->input->post('firstName'),
                "last_name" => $this->input->post('lastName'),
                "dob_day" => $dob[0],
                "dob_month" => $dob[1],
                "dob_year" => $dob[2],
                "phone" => $this->input->post('phone'),
                "tc_agree" => '1',
                "country_id" => $this->input->post('country_id'),
                "state" => $state_name,
                "current_level" => 0,
                "balance" => $balance,
                "isDemoAccount" => $isDemo,
                "demo_balance" => $demo_balance,
                "crypto_address" => $this->input->post('crypto_address'),
                "status" => $status
            );
            //print_r($user_object);

            //Unique address id
            $unique_address_id = $this->GenerateUniqueAddressID();
            //Prepare array for [address] table
            $address_object = array(
                "id" => $unique_address_id,
                "first_name" => $this->input->post('firstName'),
                "last_name" => $this->input->post('lastName'),
                "phone" => $this->input->post('phone'),
                "address_line1" => $this->input->post('address_line1'),
                "address_line2" => $this->input->post('address_line2'),
                "post_code" => $this->input->post('post_code'),
                "city" => $this->CityModel->getCityNameByID($this->input->post('city_id')),
                "state" => $state_name,
                "country" => $this->CountryModel->getCountryNameByID($this->input->post('country_id')),
                "user_id" => $this->input->post('user_id')
            );
            //print_r($address_object);exit;

            if($this->UserModel->userExistsByUsername($this->input->post('username')) == false || $this->UserModel->userExistsByEmail($this->input->post('email')) == false){
                
                $this->proccesssignup($user_object, $address_object);
            }
        }else{
             $this->session->set_flashdata('reg_error', 'Could not add user!');
        }
        redirect('admin/users');
        }else{
            redirect('admin/login');
           
        }
    }
    //Verify and proccess signup data
    private function proccesssignup($user_object, $address_object){
       //Get driving license or passport file extension
        $drivingLicenseOrPassportFileExt = pathinfo($_FILES["drivingLicenseOrPassportFile"]["name"], PATHINFO_EXTENSION);
        //Upload driving license or passport and store file name, so it can be used to unlink if error takes place
        $drivingLicenseOrPassportFileName = "";
        $drivingLicenseOrPassportFileObject = array();
        //Set a flag to store if upload was successfull
        $drivingLicenseOrPassportFileUploadStatus = false;
        //Check if the file type is either pdf|doc
        if($drivingLicenseOrPassportFileExt == "pdf" || $drivingLicenseOrPassportFileExt == "doc"){
            //User is uploading a document type either pdf or doc
            $drivingLicenseOrPassportFileName = $this->uploadAndResizeDocument("drivingLicenseOrPassportFile", "account_documents", $user_object['id'], "proof_of_id");
            //Set upload flag to true
            if($drivingLicenseOrPassportFileName != false){
                $drivingLicenseOrPassportFileUploadStatus = true;
                //echo "<br>drivingLicenseOrPassportFileUploadStatus true";
                $drivingLicenseOrPassportFileObject = array(
                    "image_url" => $drivingLicenseOrPassportFileName,
                    "document_type" => "proof_of_id",
                    "approved" => '0',
                    "userid" => $user_object['id']
                );
            }
        //Check if the file type is either jpg|png|jpeg
        }else if($drivingLicenseOrPassportFileExt == "jpg" || $drivingLicenseOrPassportFileExt == "png" || $drivingLicenseOrPassportFileExt == "jpeg"){
            //User is uploading a image
            $drivingLicenseOrPassportFileName = $this->uploadAndResizeImage("drivingLicenseOrPassportFile", "account_documents", $user_object['id'], "proof_of_id");
            //Set upload flag to true
            if($drivingLicenseOrPassportFileName != false){
                $drivingLicenseOrPassportFileUploadStatus = true;
                //echo "<br>drivingLicenseOrPassportFileUploadStatus true";
                $drivingLicenseOrPassportFileObject = array(
                    "image_url" => $drivingLicenseOrPassportFileName,
                    "document_type" => "proof_of_id",
                    "approved" => '0',
                    "userid" => $user_object['id']
                );
            }
        }else{
            //This means user may have tweaked the file using some plugin or malicious attack/attempt to upload invalid file and fool the system
            $drivingLicenseOrPassportFileUploadStatus = false;
            //Set file name for deletion
            $drivingLicenseOrPassportFileName = "proof_of_id_".$user_object['id'].".".$drivingLicenseOrPassportFileExt;
        }

        //Get utility bill file extension
        $utilityBillFileExt = pathinfo($_FILES["utilityBillFile"]["name"], PATHINFO_EXTENSION);
        //Upload utility bill and store file name, so it can be used to unlink if error takes place
        $utilityBillFileFileName = "";
        $utilityBillFileFileObject = array();
        //Set a flag to store if upload was successfull
        $utilityBillFileStatus = false;
        //Check if the file type is either pdf|doc
        if($utilityBillFileExt == "pdf" || $utilityBillFileExt == "doc"){
            //User is uploading a document type either pdf or doc
            $utilityBillFileFileName = $this->uploadAndResizeDocument("utilityBillFile", "account_documents", $user_object['id'], "utility_bill");
            //Set upload flag to true
            if($utilityBillFileFileName != false){
                $utilityBillFileStatus = true;
                //echo "<br>utilityBillFileStatus true";
                $utilityBillFileFileObject = array(
                    "image_url" => $utilityBillFileFileName,
                    "document_type" => "utility_bill",
                    "approved" => '0',
                    "userid" => $user_object['id']
                );
            }
        //Check if the file type is either jpg|png|jpeg
        }else if($utilityBillFileExt == "jpg" || $utilityBillFileExt == "png" || $utilityBillFileExt == "jpeg"){
            //User is uploading a image
            $utilityBillFileFileName = $this->uploadAndResizeImage("utilityBillFile", "account_documents", $user_object['id'], "utility_bill");
            //Set upload flag to true
            if($utilityBillFileFileName != false){
                $utilityBillFileStatus = true;
                //echo "<br>utilityBillFileStatus true";
                $utilityBillFileFileObject = array(
                    "image_url" => $utilityBillFileFileName,
                    "document_type" => "utility_bill",
                    "approved" => '0',
                    "userid" => $user_object['id']
                );
            }
        }else{
            //This means user may have tweaked the file using some plugin or malicious attack/attempt to upload invalid file and fool the system
            $utilityBillFileStatus = false;
            //Set file name for deletion
            $utilityBillFileFileName = "utility_bill".$user_object['id'].".".$utilityBillFileExt;
        }

        //Get bank statement file extension
        $bankStatementFileExt = pathinfo($_FILES["bankStatementFile"]["name"], PATHINFO_EXTENSION);
        //Upload bank statement and store file name, so it can be used to unlink if error takes place
        $bankStatementFileName = "";
        $bankStatementFileObject = array();
        //Set a flag to store if upload was successfull
        $bankStatementFileStatus = false;
        //Check if the file type is either pdf|doc
        if($bankStatementFileExt == "pdf" || $bankStatementFileExt == "doc"){
            //User is uploading a document type either pdf or doc
            $bankStatementFileName = $this->uploadAndResizeDocument("bankStatementFile", "account_documents", $user_object['id'], "bank_statement");
            //Set upload flag to true
            if($bankStatementFileName != false){
                $bankStatementFileStatus = true;
                //echo "<br>bankStatementFileStatus true";
                $bankStatementFileObject = array(
                    "image_url" => $bankStatementFileName,
                    "document_type" => "bank_statement",
                    "approved" => '0',
                    "userid" => $user_object['id']
                );
            }
        //Check if the file type is either jpg|png|jpeg
        }else if($bankStatementFileExt == "jpg" || $bankStatementFileExt == "png" || $bankStatementFileExt == "jpeg"){
            //User is uploading a image
            $bankStatementFileName = $this->uploadAndResizeImage("bankStatementFile", "account_documents", $user_object['id'], "bank_statement");
            //Set upload flag to true
            if($bankStatementFileName != false){
                $bankStatementFileStatus = true;
                //echo "<br>bankStatementFileStatus true";
                $bankStatementFileObject = array(
                    "image_url" => $bankStatementFileName,
                    "document_type" => "bank_statement",
                    "approved" => '0',
                    "userid" => $user_object['id']
                );
            }
        }else{
            //This means user may have tweaked the file using some plugin or malicious attack/attempt to upload invalid file and fool the system
            $bankStatementFileStatus = false;
            //Set file name for deletion
            $bankStatementFileName = "bank_statement".$user_object['id'].".".$bankStatementFileExt;
        }
        //Check to make sure all three files have been uploaded successfully
        //$drivingLicenseOrPassportFileUploadStatus, $utilityBillFileStatus, $bankStatementFileStatus
        if($drivingLicenseOrPassportFileUploadStatus == true && $utilityBillFileStatus == true && $bankStatementFileStatus == true){
            //Do some magic here
            echo "<hr>All three files have been uploaded successfully";
            //Insert user object into db
            if($this->UserModel->insertIntoUser($user_object)){
                echo "<br>User inserted successfully";
                if($this->AddressModel->insertIntoAddress($address_object)){
                    echo "<br>Address inserted successfully";
                    
                    $amount_to_update = $this->currencyExchanger(0);
                    //$amount_to_update = 10;
                    $docProofIDInserted = false;
                    if($this->DocumentModel->insertIntoDocument($drivingLicenseOrPassportFileObject)){
                        echo "<br>proof_of_id inserted successfully";
                        $docProofIDInserted = true;
                    }

                    $docUtilityBillInserted = false;
                    if($this->DocumentModel->insertIntoDocument($utilityBillFileFileObject)){
                        echo "<br>proof_of_id inserted successfully";
                        $docUtilityBillInserted = true;
                    }

                    $docBankStatementInserted = false;
                    if($this->DocumentModel->insertIntoDocument($bankStatementFileObject)){
                        echo "<br>proof_of_id inserted successfully";
                        $docBankStatementInserted = true;
                    }

                    //Check if all documents objects have been inserted
                    //Send login credentials to be verified and log the user into the system
                    if($docProofIDInserted == true && $docUtilityBillInserted == true && $docBankStatementInserted == true){
                        $this->session->set_flashdata('reg_success', 'User have been added successfully!');
                    }else{
                        $this->session->set_flashdata('reg_error', 'Could not add user!');
                    }
                    redirect('admin/users'); 
                }
            }
        }else{
            //Delete / unlink files something went wrong and files/documents couldn't be uploaded
            //Delete proof_of_id
            $this->deletefile("assets/account_documents", $drivingLicenseOrPassportFileName);
            //echo "<br>Deleting " .$drivingLicenseOrPassportFileName;
            //Delete utility_bill
            $this->deletefile("assets/account_documents", $utilityBillFileFileName);
            //echo "<br>Deleting " .$utilityBillFileFileName;
            //Delete bank_statement
            $this->deletefile("assets/account_documents", $bankStatementFileName);
            //echo "<br>Deleting " .$bankStatementFileName;
        }
    }

    public function updatetwofactor(){
        if($this->session->userdata('admin_logged_in_data')){
            //Check if checkbox is checked
            $test = $this->session->userdata('admin_logged_in_data');
            $user_id = $this->input->post('user_id');
            if(!$test['user_type'] == "Editor"){

            if(isset($_POST['twofactorInput'])){
                //echo "Checked";
                $user_object_update = array(
                    "two_factor_login" => '1'
                );
            }else{
                //echo "Not checked";
                $user_object_update = array(
                    "two_factor_login" => '0',
                    "fa_token" => '0'
                );
            }
            if($this->UserModel->updateUserinfo($user_id, $user_object_update)){
                $this->session->set_flashdata('account_update_twoFact_success', "Account has been updated successfully!");
            }else{
                $this->session->set_flashdata('account_update_twoFact_error', "Account could not been updated!");
            }
            redirect('admin/edituser?id='.$user_id);
        }else{
            $this->session->set_flashdata('account_update_twoFact_error', "bamd!");
        }
        redirect('admin/edituser?id='.$user_id);
        }else{
            redirect('admin/login');
        }
    }

    public function edituser(){

        if($this->session->userdata('admin_logged_in_data')){
            $data['pagename'] = "users";

            //Get user id from get request
            $id = $this->input->get('id');

            //Get user_object based on the id
            //$data['user_object'] = $this->UserModel->getUserAddressByID($id);
            $data['user_object'] = $this->UserModel->getUserById($id);
            //print_r($data['user_object']);exit;
            
            if($data['user_object'] == false){
                redirect('admin/users');
            }

            $data['twofact'] = $data['user_object'][0]->two_factor_login;
            //echo $data['twofact'];exit;

            //Get user address/s
            $data['user_address'] = $this->AddressModel->getAddressByUserID($id);
            //print_r($data['user_address']);exit;

            //Get user's documents
            $documents = $this->DocumentModel->getDocumentsByID($data['user_object'][0]->id);

            //Get user's payment cards
            $data['paymentcards'] = $this->PaymentCardModel->getPaymentCardByUserID($data['user_object'][0]->id);

            //Check if any of the user document has not been approved yet
            $data['hasPendingDocuments'] = false;
            if($documents != false){
                foreach ($documents as $key => $document) {
                    if($document->approved == '0'){
                        $data['hasPendingDocuments'] = true;
                    }
                }
            }
            

            //Check if documents are pending
            if($data['hasPendingDocuments']){
                //Set flash data
                $this->session->set_flashdata('documents_pending', "User have pending documents that needs to be approved!");
            }
            $data['documents'] = $documents;
            //print_r($data['documents']);exit;

            $this->load->view('admin/pages/general_settings/edit_user', $data);
        }else{
            redirect('admin/login');
        }
    }
    public function approvedocument(){
        if($this->session->userdata('admin_logged_in_data')){
            //Get user id for redirect
            $user_id = $this->input->get('userid');

            //Get document id
            $document_id = $this->input->get('docid');
            if($this->DocumentModel->updateDocumentStatusByID("1", $document_id)){
                $this->session->set_flashdata('doc_approve_success', "<strong>Document</strong> has been approved successfully!");
            }else{
                $this->session->set_flashdata('doc_approve_error', "<strong>Document</strong> could not been approved!");
            }
            redirect('admin/edituser?id='.$user_id);
        }else{
            redirect('admin/login');
        }
    }
    public function rejectdocument(){
        if($this->session->userdata('admin_logged_in_data')){
            //Get user id for redirect
            $user_id = $this->input->get('userid');

            //Get document id
            $document_id = $this->input->get('docid');
            if($this->DocumentModel->updateDocumentStatusByID("0", $document_id)){
                $this->session->set_flashdata('doc_reject_success', "<strong>Document</strong> has been rejected successfully!");
            }else{
                $this->session->set_flashdata('doc_reject_error', "<strong>Document</strong> could not been rejected!");
            }
            redirect('admin/edituser?id='.$user_id);
        }else{
            redirect('admin/login');
        }
    }
    public function updateaccount(){
        if($this->session->userdata('admin_logged_in_data')){
            //Get user_id
            $user_type=$this->session->userdata('admin_logged_in_data');
            $user_id = $this->input->post('user_id');
            if(!$user_type['user_type']== "Moderator"||$user_type['user_type']== "Editor"){
            $user_object_update = array(
                "first_name" => $this->input->post('first_name'),
                "last_name" => $this->input->post('last_name'),
                "phone" => $this->input->post('phone'),
                "username" => $this->input->post('username'),
                "email" => $this->input->post('email'),
                "dob_day" => $this->input->post('dob_day'),
                "dob_month" => $this->input->post('dob_month'),
                "dob_year" => $this->input->post('dob_year'),
                "current_level" => $this->input->post('current_level'),
                "level_progress" => $this->input->post('level_progress')
            );

            //print_r($user_object_update);
            
            if($this->UserModel->updateUserinfo($user_id, $user_object_update)){
                $this->session->set_flashdata('account_update_success', "Account has been updated successfully!");
            }else{
                $this->session->set_flashdata('account_update_error', "Account could not been updated!");
            }
            redirect('admin/edituser?id='.$user_id);
        }else{
             $this->session->set_flashdata('account_update_error', "tha");
        }
        redirect('admin/edituser?id='.$user_id);
        }else{
            redirect('admin/login');
        }
    }
    public function updatebillinginformation(){
        if($this->session->userdata('admin_logged_in_data')){
            //Get user_id
            $user_id = $this->input->post('user_id');
            //Get address_id
            $address_id = $this->input->post('address_id');

            $address_object_update = array(
                "first_name" => $this->input->post('address_first_name'),
                "last_name" => $this->input->post('address_last_name'),
                "phone" => $this->input->post('address_phone'),
                "address_line1" => $this->input->post('address_line1'),
                "address_line2" => $this->input->post('address_line2'),
                "city" => $this->input->post('city'),
                "state" => $this->input->post('state'),
                "country" => $this->input->post('country'),
                "post_code" => $this->input->post('post_code')
            );

            //print_r($address_object_update);exit;

            if($this->AddressModel->updateAddress($address_id, $address_object_update)){
                $this->session->set_flashdata('billing_update_success', "Billing has been updated successfully!");
            }else{
                $this->session->set_flashdata('billing_update_error', "Billing has been updated successfully!");
            }
            redirect('admin/edituser?id='.$user_id);
        }else{
            redirect('admin/login');
        }
    }
    public function updateaccountstatus(){
        if($this->session->userdata('admin_logged_in_data')){
            //$account_status = $this->input->post('account_status');
            //echo $account_status;exit;
            $user_id = $this->input->post('user_id');
            if(!empty($_POST["account_status"])){
                //echo "Checked: ";exit;
                if($this->UserModel->updateAccountStatus("1", $user_id)){
                    $this->session->set_flashdata('status_update_success', "Account status has been set to enabled!");
                }else{
                    $this->session->set_flashdata('status_update_error', "Account status could not been set to enabled!");
                }
            }else{
                //echo "Not checked: ";exit;
                if($this->UserModel->updateAccountStatus("0", $user_id)){
                    $this->session->set_flashdata('status_update_success', "Account status has been set to disabled!");
                }else{
                    $this->session->set_flashdata('status_update_error', "Account status could not been set to disabled!");
                }
            }
            redirect('admin/edituser?id='.$user_id);
        }else{
            redirect('admin/login');
        }
    }
    public function updatecrypto(){
        if($this->session->userdata('admin_logged_in_data')){
            $user_id = $this->input->post('user_id');
            $crypto_address = $this->input->post('crypto_address');
            if($this->UserModel->updateCryptoKey($crypto_address, $user_id)){
                $this->session->set_flashdata('crypto_update_success', "Crypto address been been updated!");
            }else{
                $this->session->set_flashdata('crypto_update_error', "Crypto address could not been updated!");
            }
            redirect('admin/edituser?id='.$user_id);
        }else{
            redirect('admin/login');
        }
    }
    public function updatedemo(){
        if($this->session->userdata('admin_logged_in_data')){
            $user_id = $this->input->post('user_id');
            $balance = $this->input->post('demo_balance');
            if(!empty($_POST["demo_status"])){
                if($this->UserModel->updateDemoMode("1", $user_id) && $this->UserModel->updateDemoBalance($balance, $user_id)){
                    $this->session->set_flashdata('demo_update_success', "Demo settings has been updated!");
                }else{
                    $this->session->set_flashdata('demo_update_error', "Demo settings could not been updated!");
                }
            }else{
                if($this->UserModel->updateDemoMode("0", $user_id) && $this->UserModel->updateDemoBalance($balance, $user_id)){
                    $this->session->set_flashdata('demo_update_success', "Demo settings has been updated!");
                }else{
                    $this->session->set_flashdata('demo_update_error', "Demo settings could not been updated!");
                }
            }
            redirect('admin/edituser?id='.$user_id);
        }else{
            redirect('admin/login');
        }
    }
    public function updatebalance(){
        if($this->session->userdata('admin_logged_in_data')){
            $user_id = $this->input->post('user_id');
            $balance = $this->input->post('balance');
            if($this->UserModel->updateBalance($balance, $user_id)){
                $this->session->set_flashdata('balance_update_success', "Balance has been updated!");
            }else{
                $this->session->set_flashdata('balance_update_error', "Balance could not been updated!");
            }
            redirect('admin/edituser?id='.$user_id);
        }else{
            redirect('admin/login');
        }
    }
    public function updatenotes(){
        if($this->session->userdata('admin_logged_in_data')){
            $Admin_type=$this->session->userdata('admin_logged_in_data');
            if(!$admin_type['user_type']=="Editor")
            {
            $user_id = $this->input->post('user_id');
            $notes = $this->input->post('notes');
            if($this->UserModel->updateNotes($notes, $user_id)){
                $this->session->set_flashdata('notes_update_success', "Notes has been updated!");
            }else{
                $this->session->set_flashdata('notes_update_error', "Notes could not been updated!");
            }
            redirect('admin/edituser?id='.$user_id);
        }else{
            $this->session->set_flashdata('notes_update_error', "You are not able to Update it");
        }
        redirect('admin/edituser?id='.$user_id);
        }else{
            redirect('admin/login');
        }
    }
    public function deleteuser(){
        if($this->session->userdata('admin_logged_in_data')){
            //Get country id from get request
            $id = $this->input->get('id');
            //Get country name
            $email = $this->input->get('email');

            if($this->UserModel->userExistsByID($id)){
                //Country has been found, now call delete function
                $user_object = $this->UserModel->getUserById($id);

                //Get documents
                $documents = $this->DocumentModel->getDocumentsByID($id);

                if(!empty($documents) || $documents != false){
                    foreach ($documents as $key => $document) {
                        $this->deletefile("assets/account_documents", $document->image_url);
                    }
                }

                
                if($this->UserModel->deleteUser($id)){
                    $this->session->set_flashdata('delete_success', "User account <strong>" .$email. "</strong> has been deleted successfully!");
                }else{
                    $this->session->set_flashdata('delete_error', "User account <strong>" .$email. "</strong> could not be deleted!");
                }
            }else{
                $this->session->set_flashdata('delete_error', "User account <strong>" .$email. "</strong> could not be found!");
            }
            redirect('admin/users');
        }else{
            redirect('admin/login');
        }
    }
    public function settings(){
        if($this->session->userdata('admin_logged_in_data')){
            $user_type=$this->session->userdata('admin_logged_in_data');
            if(!($user_type['user_type']== "Moderat"||$user_type['user_type']== "Editor"))
            {
            $data['pagename'] = "general_settings";

            $data['general_settings'] = $this->GeneralSettingsModel->getSettings();
            //print_r($data['general_settings']);exit;
            
            //Get list of continents
            $data['continents'] = $this->ContinentModel->getAllContinentsByOrder();
            //Get list of all countries
            $data['countries'] = $this->CountryModel->getAllCountries();
            //Get list of all states
            $data['states'] = $this->StateModel->getAllStatesOrderBy();
            //Get list of counties
            $data['counties'] = $this->CountyModel->getAllCountiesOrderBy();
            //Get list of all cities
            $data['cities'] = $this->CityModel->getAllCitiesOrderBy();

            //Get all blocked continents
            $data['blocked_continents'] = $this->ContinentModel->blockedContinents();
            //Get all blocked countries
            $data['blocked_countries'] = $this->CountryModel->blockedCountries();
            //Get all blocked states
            $data['blocked_states'] = $this->StateModel->blockedStates();
            //Get all Blocked counties
            $data['blocked_counties'] = $this->CountyModel->blockedCounties();
            //Get all blocked cities
            $data['blocked_cities'] = $this->CityModel->blockedCities();

            $this->load->view('admin/pages/general_settings/general_settings', $data);
        }else{
            redirect('admin');
        }
        }else{
            redirect('admin/login');
        }
    }
    public function updatesettings(){
        if($this->session->userdata('admin_logged_in_data')){
            // $signup_bonus_status = '0';
            // if(!empty($_POST["bonus_check"])){
            //     $signup_bonus_status = '1';
            // }

            // $signup_bonus_percentage = 0;
            // if(!empty($_POST["signup_percentage"])){
            //     $signup_bonus_percentage = $this->input->post('signup_percentage');
            // }

            $same_picture_frequency = 0;
            if(!empty($_POST["picture_frequency"])){
                $same_picture_frequency = $this->input->post('picture_frequency');
            }

            $default_account_status = '0';
            if(!empty($_POST["default_account_status"])){
                $default_account_status = $this->input->post('default_account_status');
            }

            $allow_demo_mode = '0';
            // if(!empty($_POST["demo_mode"])){
            //     $allow_demo_mode = '1';
            // }

            $default_demo_balance = 0;
            // if(!empty($_POST["demo_balance"])){
            //     $default_demo_balance = $this->input->post('demo_balance');
            // }

            $tax = 0;
            // if(!empty($_POST["tax"])){
            //     $tax = $this->input->post('tax');
            // }

            $admin_fees = 0;
            // if(!empty($_POST["admin_fees"])){
            //     $admin_fees = $this->input->post('admin_fees');
            // }

            $challenge_timer = 0;
            if(!empty($_POST["challenge_timer"])){
                $challenge_timer = $this->input->post('challenge_timer');
            }

            $challenge_timer_type = 'h';
            if(!empty($_POST["challenge_timer_type"])){
                $challenge_timer_type = $this->input->post('challenge_timer_type');
            }

            $game_timer = 0;
            if(!empty($_POST["game_timer"])){
                $game_timer = $this->input->post('game_timer');
            }

            $game_timer_type = 'm';
            if(!empty($_POST["game_timer_type"])){
                $game_timer_type = $this->input->post('game_timer_type');
            }

            $start_timer = '0';
            if(!empty($_POST["start_timer"])){
                $start_timer = '1';
            }

            $euro_conversion = '0';
            if(!empty($_POST["euro_conversion"])){
                $euro_conversion = $this->input->post('euro_conversion');
            }

            $pound_conversion = '0';
            if(!empty($_POST["pound_conversion"])){
                $pound_conversion = $this->input->post('pound_conversion');
            }


            $dollar_conversion = '0';
            if(!empty($_POST["dollar_conversion"])){
                $dollar_conversion = $this->input->post('dollar_conversion');
            }

            $settings_object = array(
                // "signup_bonus" => $signup_bonus_status,
                // "signup_bonus_percentage" => $signup_bonus_percentage,
                "same_picture_frequency" => $same_picture_frequency,
                "default_account_status" => $default_account_status,
                "allow_demo_mode" => $allow_demo_mode,
                "default_demo_balance" => $default_demo_balance,
                "tax" => $tax,
                "admin_fees" => $admin_fees,
                "challenge_timer" => $challenge_timer,
                "challenge_timer_type" => $challenge_timer_type,
                "game_timer" => $game_timer,
                "game_timer_type" => $game_timer_type,
                "start_timer" => $start_timer,
                "euro_conversion" => $euro_conversion,
                "pound_conversion" => $pound_conversion,
                "dollar_conversion" => $dollar_conversion,
                "default_currency" => $this->input->post('default_currency'),
                "stake_conversion_level" => $this->input->post('stake_conversion_level'),
                "cursor_size" => $this->input->post('cursor_size')
            );

            if($this->GeneralSettingsModel->updateSettings($settings_object)){
                $this->session->set_flashdata('update_settings_success', "Settings have been updated successfully!");
            }else{
                $this->session->set_flashdata('update_settings_error', "Settings could not been updated successfully!");
            }
            redirect('admin/settings');
        }else{
            redirect('admin/login');
        }
    }
    public function sitesettings(){
        if($this->session->userdata('admin_logged_in_data')){
            $user_type=$this->session->userdata('admin_logged_in_data');
            if(!($user_type['user_type']== "Moderat"||$user_type['user_type']== "Editor")){
            $data['pagename'] = "sitesettings";

            $data['general_settings'] = $this->GeneralSettingsModel->getSettings();
            //print_r($data['general_settings']);exit;

            $this->load->view('admin/pages/general_settings/site_settings', $data);
        }
        else{
            redirect('admin');
        }
        }else{
            redirect('admin/login');
        }
    }
    public function updatesitesettings(){
        if($this->session->userdata('admin_logged_in_data')){
            if($this->input->post('btnUpdatePolicy')){
                $settings_object = array(
                    "privacy_policy" => $this->input->post('privacy')
                );
                if($this->GeneralSettingsModel->updateSettings($settings_object)){
                    $this->session->set_flashdata('success', "Site settings updated successfully!");
                }else{
                    $this->session->set_flashdata('error', "Failed to update site settings!");
                }
            }else if($this->input->post('btnUpdateTerms')){
                $settings_object = array(
                    "terms_conditions" => $this->input->post('terms')
                );
                //print_r($settings_object);exit;
                if($this->GeneralSettingsModel->updateSettings($settings_object)){
                    $this->session->set_flashdata('success', "Site settings updated successfully!");
                }else{
                    $this->session->set_flashdata('error', "Failed to update site settings!");
                }
            }else if($this->input->post('btnUpdateCopyright')){
                $settings_object = array(
                    "copyright" => $this->input->post('copyright')
                );
                //print_r($settings_object);exit;
                if($this->GeneralSettingsModel->updateSettings($settings_object)){
                    $this->session->set_flashdata('success', "Site copyright updated successfully!");
                }else{
                    $this->session->set_flashdata('error', "Failed to update site copyright!");
                }
            }else if($this->input->post('btnUpdateTitle')){
                $settings_object = array(
                    "site_title" => $this->input->post('site_title')
                );
                //print_r($settings_object);exit;
                if($this->GeneralSettingsModel->updateSettings($settings_object)){
                    $this->session->set_flashdata('success', "Site title updated successfully!");
                }else{
                    $this->session->set_flashdata('error', "Failed to update site title!");
                }
            }else if($this->input->post('btnUpdateSiteLogo')){
                if($_FILES['logo_image']['name'] != ""){
                    $file_name = $this->uploadLogo("logo_image", "site/", "logo_image");
                    if($file_name != false){
                        $settings_object = array(
                            "logo_image" => $file_name
                        );
                        //print_r($settings_object);exit;
                        if($this->GeneralSettingsModel->updateSettings($settings_object)){
                            $this->session->set_flashdata('success', "Site logo updated successfully!");
                        }else{
                            $this->session->set_flashdata('error', "Failed to update site logo!");
                        }
                    }else{
                        $this->session->set_flashdata('error', "File upload failed, invalid file or file type");
                    }
                }else{
                    $this->session->set_flashdata('error', "Please select an image");
                }
            }else if($this->input->post('btnUpdateTermsOfUse')){
                $settings_object = array(
                    "terms_of_use" => $this->input->post('signup_terms_of_use')
                );
                //print_r($settings_object);exit;
                if($this->GeneralSettingsModel->updateSettings($settings_object)){
                    $this->session->set_flashdata('success', "Site signup terms of use updated successfully!");
                }else{
                    $this->session->set_flashdata('error', "Failed to update site signup terms of use!");
                }
            }else{
                $this->session->set_flashdata('error', "You did not make any changes!");
            }
            redirect('admin/sitesettings');
        }else{
            redirect('admin/login');
        }
    }
    public function blockcontinent(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->post('block_continent_id');
            if(!empty($id)){
                $update_object = array(
                    "is_blocked" => '1'
                );
                if($this->ContinentModel->updateContinent($id, $update_object)){
                    $this->session->set_flashdata('block_update_success', "Continent blocked successfully!");
                }else{
                    $this->session->set_flashdata('block_update_error', "Could not block continent!");
                }
            }else{
                $this->session->set_flashdata('block_update_error', "Could not find continent!");
            }
            redirect('admin/settings');
        }else{
            redirect('admin/login');
        }
    }
    public function unblockcontinent(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->get('id');
            $update_object = array(
                "is_blocked" => '0'
            );
            if($this->ContinentModel->updateContinent($id, $update_object)){
                $this->session->set_flashdata('block_update_success', "Continent unblocked successfully!");
            }else{
                $this->session->set_flashdata('block_update_error', "Could not unblock continent!");
            }
            redirect('admin/settings');
        }else{
            redirect('admin/login');
        }
    }
    public function blockcountry(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->post('country_id');
            if(!empty($id)){
                $update_object = array(
                    "is_blocked" => '1'
                );
                if($this->CountryModel->updateCountry($id, $update_object)){
                    $this->session->set_flashdata('block_update_success', "Country blocked successfully!");
                }else{
                    $this->session->set_flashdata('block_update_error', "Could not block country!");
                }
            }else{
                $this->session->set_flashdata('block_update_error', "Could not find country!");
            }
            redirect('admin/settings');
        }else{
            redirect('admin/login');
        }
    }
    public function unblockcountry(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->get('id');
            $update_object = array(
                "is_blocked" => '0'
            );
            if($this->CountryModel->updateCountry($id, $update_object)){
                $this->session->set_flashdata('block_update_success', "Country unblocked successfully!");
            }else{
                $this->session->set_flashdata('block_update_error', "Could not unblock country!");
            }
            redirect('admin/settings');
        }else{
            redirect('admin/login');
        }
    }
    public function blockstate(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->post('state_id');
            if(!empty($id)){
                $update_object = array(
                    "is_blocked" => '1'
                );
                if($this->StateModel->updateState($id, $update_object)){
                    $this->session->set_flashdata('block_update_success', "State blocked successfully!");
                }else{
                    $this->session->set_flashdata('block_update_error', "Could not block state!");
                }
            }else{
                $this->session->set_flashdata('block_update_error', "Could not find state!");
            }
            redirect('admin/settings');
        }else{
            redirect('admin/login');
        }
    }
    public function unblockstate(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->get('id');
            $update_object = array(
                "is_blocked" => '0'
            );
            if($this->StateModel->updateState($id, $update_object)){
                $this->session->set_flashdata('block_update_success', "State unblocked successfully!");
            }else{
                $this->session->set_flashdata('block_update_error', "Could not unblock state!");
            }
            redirect('admin/settings');
        }else{
            redirect('admin/login');
        }
    }
    public function blockcity(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->post('city_id');
            if(!empty($id)){
                $update_object = array(
                    "is_blocked" => '1'
                );
                if($this->CityModel->updateCity($id, $update_object)){
                    $this->session->set_flashdata('block_update_success', "City blocked successfully!");
                }else{
                    $this->session->set_flashdata('block_update_error', "Could not block city!");
                }
            }else{
                $this->session->set_flashdata('block_update_error', "Could not find city!");
            }
            redirect('admin/settings');
        }else{
            redirect('admin/login');
        }
    }
    public function unblockcity(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->get('id');
            $update_object = array(
                "is_blocked" => '0'
            );
            if($this->CityModel->updateCity($id, $update_object)){
                $this->session->set_flashdata('block_update_success', "City unblocked successfully!");
            }else{
                $this->session->set_flashdata('block_update_error', "Could not unblock city!");
            }
            redirect('admin/settings');
        }else{
            redirect('admin/login');
        }
    }
    public function updatelevelgameimageorder(){
        if($this->session->userdata('admin_logged_in_data')){
            $settings_object = array(
                "level_game_image_order" => $this->input->post('levelgameimageorder')
            );
            if($this->GeneralSettingsModel->updateSettings($settings_object)){
                $this->session->set_flashdata('success', "Settings have been updated successfully!");
            }else{
                $this->session->set_flashdata('error', "Settings could not been updated successfully!");
            }
            redirect('admin/manageimages');
        }else{
            redirect('admin/login');
        }
    }
    //Manage users settings end
    /////////////////////////////////////////////////
    // General Settings End
    /////////////////////////////////////////////////


    /////////////////////////////////////////////////
    // Game Settings Start
    /////////////////////////////////////////////////
    public function addgallery(){
        if($this->session->userdata('admin_logged_in_data')){
            $user_type=$this->session->userdata('admin_logged_in_data');
        if(!($user_type['user_type']== "Moderat"||$user_type['user_type']== "Editor"))
        {
            $data['pagename'] = "addgallery";

            $data['general_settings'] = $this->GeneralSettingsModel->getSettings();
            //print_r($data['general_settings']);exit;

            $data['unique_image_id'] = $this->GenerateRandomNumber(6);

            $data['gallery_live'] = $this->GameGalleryModel->getDetailedGallery("live");
            //print_r($data['gallery_live']);exit;
            
            $data['gallery_demo'] = $this->GameGalleryModel->getDetailedGallery("demo");

            // $data['new_level_number'] = $this->LevelModel->getLastlevelNumber() + 1;
            // //echo $data['new_level_number'];exit;
            
            // //Get all active levels
            // $data['levels'] = $this->LevelModel->getAllLevels();
            //print_r($data['levels']);exit;

            $this->load->view('admin/pages/game_settings/add_gallery', $data);
        }else{
            redirect('admin');
        }
        }else{
            redirect('admin/login');
        }
    }
    //Upload picture ajax request
    public function choosePhoto(){
       // file name
        //$filename = $_FILES['file']['name'];
        $filename = $this->input->get('image_id');

        $upload_type = $this->input->get('name');

        $input_name = $this->input->get('inputname');

        $ext = pathinfo($_FILES[$input_name]['name'], PATHINFO_EXTENSION);
        $newfilename = $filename. '_' . $upload_type . '.' .$ext;
        // Location
        $location = 'assets/game_images/gallery/' .$newfilename;

        // file extension
        $file_extension = pathinfo($location, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);

        // Valid image extensions
        $image_ext = array("jpg","png","jpeg","gif");

        $response = 0;
        if(in_array($file_extension,$image_ext)){
          // Upload file
          if(move_uploaded_file($_FILES[$input_name]['tmp_name'],$location)){
            $response = $newfilename;
          }
        }

        echo $response;
    }
    //Insert image data into database
    public function addimagetodb(){
        if($this->session->userdata('admin_logged_in_data')){

            $general_settings = $this->GeneralSettingsModel->getSettings();
            //echo $general_settings[0]->id;exit;
            //print_r($general_settings);exit;
            
            //Get user by username
            $logged_in_user = $this->session->userdata('admin_logged_in_data');
            //echo $logged_in_user['username'];exit;
            $user_object = $this->AdminModel->getUserByUsername($logged_in_user['username']);
            //print_r($user_object);exit;
            //echo $user_object[0]->id;exit;
            
            $title = $this->input->post('title');
            $description = $this->input->post('description');
            $challenge_img_url = $this->input->post('challenge_img_name');
            $x_value = $this->input->post('x_axis');
            $y_value = $this->input->post('y_axis');
            $solution_img_url = $this->input->post('solution_img_name');
            $tags = $this->input->post('tags');
            //$img_mode = $this->input->post('');
            $date_added = date('m-d-Y');
            $img_frequency = $this->input->post('img_frquency');
            $admin_id = $user_object[0]->id;
            $status = $this->input->post('status');
            $move = $this->input->post('move');

            $image_onject = array(
                "title" =>$title ,
                "description" => $description,
                "challenge_img_url" => $challenge_img_url,
                "x_value" => $x_value,
                "y_value" => $y_value,
                "solution_img_url" => $solution_img_url,
                "tags" => $tags,
                "date_added" => date('Y-m-d H:i:s'),
                "img_frequency" => $img_frequency,
                "admin_id" => $admin_id,
                "status" => $status,
                "move" => $move
            );
            //print_r($image_onject);
            if($this->GameGalleryModel->insertIntoGameGallery($image_onject)){
                $this->session->set_flashdata('add_gallery_success', "Image have been added to Gallery successfully!");
            }else{
                $this->session->set_flashdata('add_gallery_error', "Image could not been added to Gallery!");
            }
            redirect('admin/addgallery');
        }else{
            redirect('admin/login');
        }
    }
    //Delete upload images on cancel
    public function deleteuploadimagesoncancel(){
        if($this->session->userdata('admin_logged_in_data')){
            $challenge_img_url = $this->input->get('challenge_img_url');
            $solution_img_url = $this->input->get('solution_img_url');

            $file_to_delete = 'assets/game_images/gallery/' .$challenge_img_url;
            unlink($file_to_delete);
            $file_to_delete = 'assets/game_images/gallery/' .$solution_img_url;
            unlink($file_to_delete);
            $this->session->set_flashdata('delete_gallery_success', "Image have been deleted from Gallery successfully!");

            //redirect('admin/addgallery');
            echo "success";
        }else{
            redirect('admin/login');
        }
    }
    //Delete Gallery image
    public function deletegalleryimage(){
        if($this->session->userdata('admin_logged_in_data')){
            //Get gallery image id
            $id = $this->input->get('id');
            //Get Gallery Image
            $image = $this->GameGalleryModel->getGalleryImageByID($id);
            //print_r($image);exit;
            //Delete record in db
            if($this->GameGalleryModel->deleteImage($id)){
                //Delete images
                $file_to_delete = 'assets/game_images/gallery/' .$image[0]->challenge_img_url;
                unlink($file_to_delete);
                $file_to_delete = 'assets/game_images/gallery/' .$image[0]->solution_img_url;
                unlink($file_to_delete);
                $this->session->set_flashdata('delete_gallery_success', "Image have been deleted from Gallery successfully!");
            }else{
                $this->session->set_flashdata('delete_gallery_error', "Image have not been deleted from Gallery successfully!");
            }
            redirect('admin/addgallery');
        }else{
            redirect('admin/login');
        }
    }
    //Manage images
    public function manageimages(){
        if($this->session->userdata('admin_logged_in_data')){
            $user_type=$this->session->userdata('admin_logged_in_data');
    if(!($user_type['user_type']== "Moderat"||$user_type['user_type']== "Editor"))
    {

            $data['pagename'] = "manageimages";

            $data['general_settings'] = $this->GeneralSettingsModel->getSettings();
            //print_r($data['general_settings']);exit;

            $data['gallery_live'] = $this->GameGalleryModel->getDetailedGallery("live");
            //print_r($data['gallery_live']);exit;
            
            $data['gallery_demo'] = $this->GameGalleryModel->getDetailedGallery("demo");

            $data['new_level_number'] = $this->LevelModel->getLastlevelNumber() + 1;
            //echo $data['new_level_number'];exit;
            
            //Get all active levels
            $data['levels'] = $this->LevelModel->getAllLevels();

            $this->load->view('admin/pages/game_settings/manage_images', $data);
    }
    else{
        redirect('admin');
    }
        }else{
            redirect('admin/login');
        }
    }
    //Manage levels
    public function managelevels(){
        if($this->session->userdata('admin_logged_in_data')){

            $data['pagename'] = "managelevels";

            $data['general_settings'] = $this->GeneralSettingsModel->getSettings();
            //print_r($data['general_settings']);exit;

            $data['gallery_live'] = $this->GameGalleryModel->getDetailedGallery("live");
            //print_r($data['gallery_live']);exit;
            
            $data['gallery_demo'] = $this->GameGalleryModel->getDetailedGallery("demo");

            $data['new_level_number'] = $this->LevelModel->getLastlevelNumber() + 1;
            //echo $data['new_level_number'];exit;
            
            //Get all active levels
            $data['levels'] = $this->LevelModel->getAllLevels();

            $this->load->view('admin/pages/game_settings/manage_levels', $data);
        }else{
            redirect('admin/login');
        }
    }
    public function enablegalleryimage(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->get('id');
            $update_object = array(
                "status" => '1'
            );
            if($this->GameGalleryModel->updateGalleryImage($id, $update_object)){
                $this->session->set_flashdata('success', "Image set to enabled!");
            }else{
                $this->session->set_flashdata('error', "Error, could not set image to enabled!");
            }
            redirect('admin/manageimages');
        }else{
            redirect('admin/login');
        }
    }
    public function disablegalleryimage(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->get('id');
            $update_object = array(
                "status" => '0'
            );
            if($this->GameGalleryModel->updateGalleryImage($id, $update_object)){
                $this->session->set_flashdata('success', "Image set to disabled!");
            }else{
                $this->session->set_flashdata('error', "Error, could not set image to disabled!");
            }
            redirect('admin/manageimages');
        }else{
            redirect('admin/login');
        }
    }
    public function movelivegalleryimage(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->get('id');
            $update_object = array(
                "move" => 'live'
            );
            if($this->GameGalleryModel->updateGalleryImage($id, $update_object)){
                $this->session->set_flashdata('success', "Image set to live!");
            }else{
                $this->session->set_flashdata('error', "Error, could not set image to live!");
            }
            redirect('admin/manageimages');
        }else{
            redirect('admin/login');
        }
    }
    public function movedemogalleryimage(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->get('id');
            $update_object = array(
                "move" => 'demo'
            );
            if($this->GameGalleryModel->updateGalleryImage($id, $update_object)){
                $this->session->set_flashdata('success', "Image set to demo!");
            }else{
                $this->session->set_flashdata('error', "Error, could not set image to demo!");
            }
            redirect('admin/manageimages');
        }else{
            redirect('admin/login');
        }
    }
    //Add a new level
    public function addlevel(){
        if($this->session->userdata('admin_logged_in_data')){
            
            $data['gallery_live'] = $this->GameGalleryModel->getDetailedGallery("live");
            //print_r($data['gallery_live']);exit;
            
            $data['gallery_demo'] = $this->GameGalleryModel->getDetailedGallery("demo");

            if($data['gallery_live'] == false && $data['gallery_demo'] == false){
                $this->session->set_flashdata('level_not_found', "You must add Image/s in Gallery to add Level!");
                redirect('admin/addgallery');
            }

            $level_image_name = $this->uploadAndResizeImage("level_image", "game_images/level", $this->input->post('level_number'), "level");
            if($level_image_name != false){
                $level_object = array(
                    "level_image" => $level_image_name,
                    "level_title" => "Level",
                    "level_number" => $this->input->post('level_number'),
                    "percentage_increase" => $this->input->post('percentage_increase'),
                    "passmark" => $this->input->post('passmarks'),
                    "min_stake" => $this->input->post('min_stake'),
                    "max_stake" => $this->input->post('max_stake'),
                    "status" => $this->input->post('status')
                );
                //print_r($level_object);exit;
                
                if($this->LevelModel->insertIntoGameLevel($level_object)){
                    $this->session->set_flashdata('success', "Level " .$this->input->post('level_number'). " has been added successfully!");
                }else{
                    $this->session->set_flashdata('error', "Level " .$this->input->post('level_number'). " could not been added!");
                }
            }else{
                $this->session->set_flashdata('error', "Level " .$this->input->post('level_number'). " could not been added!");
                $this->deletefile("assets/games_images/level", $level_image_name);
            }
            
            redirect('admin/manageimages');
        }else{
            redirect('admin/login');
        }
    }
    public function updatelevel(){
        if($this->session->userdata('admin_logged_in_data')){

            $id = $this->input->post('level_id');
            $image_name = $this->input->post('level_image_name');

            //Check if image is empty
            if(!empty($_FILES['level_image']['name'])){
                $level_image_name = $this->uploadAndResizeImage("level_image", "game_images/level", $this->input->post('level_number'), "level");
                if($level_image_name != false){
                    $level_object = array(
                        "level_image" => $level_image_name,
                        "percentage_increase" => $this->input->post('percentage_increase'),
                        "passmark" => $this->input->post('passmark'),
                        "min_stake" => $this->input->post('min_stake'),
                        "max_stake" => $this->input->post('max_stake'),
                        "status" => $this->input->post('status')
                    );
                    //print_r($level_object);exit;
                    if($this->LevelModel->updateLevel($id, $level_object)){
                        $this->session->set_flashdata('success', "Level " .$this->input->post('level_number'). " has been updated successfully!");
                    }else{
                        $this->session->set_flashdata('error', "Level " .$this->input->post('level_number'). " could not been updated!");
                    }
                }else{
                    $this->session->set_flashdata('error', "Level " .$this->input->post('level_number'). " could not been updated!");
                }
            }else{
                $level_object = array(
                    "passmark" => $this->input->post('passmark'),
                    "percentage_increase" => $this->input->post('percentage_increase'),
                    "min_stake" => $this->input->post('min_stake'),
                    "max_stake" => $this->input->post('max_stake'),
                    "status" => $this->input->post('status')
                );
                //print_r($level_object);exit;
                if($this->LevelModel->updateLevel($id, $level_object)){
                    $this->session->set_flashdata('success', "Level " .$this->input->post('level_number'). " has been updated successfully!");
                }else{
                    $this->session->set_flashdata('error', "Level " .$this->input->post('level_number'). " could not been updated!");
                }
            }    
            redirect('admin/managelevels');
        }else{
            redirect('admin/login');
        }
    }
    public function deletelastlevel(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->get('id');
            if($this->LevelModel->deleteLevel($id)){
                $this->session->set_flashdata('success', "Level " .$id. " has been deleted successfully!");
            }else{
                $this->session->set_flashdata('error', "Level " .$id. " could not been deleted successfully!");
            }
            redirect('admin/manageimages');
        }else{
            redirect('admin/login');
        }
    }
    private function levelgame(){
        if($this->session->userdata('admin_logged_in_data')){
            $data['pagename'] = "levelgame";
            $this->load->view('admin/pages/game_settings/level_game_settings', $data);
        }else{
            redirect('admin/login');
        }
    }
    public function rowgame(){
        if($this->session->userdata('admin_logged_in_data')){
            $user_type=$this->session->userdata('admin_logged_in_data');
            if(!($user_type['user_type']== "Moderat"||$user_type['user_type']== "Editor"))
            {
            $data['pagename'] = "rowgame";

            $data['the_row_game'] = $this->RowGameModel->getTheRowGame();
            //print_r($data['the_row_game']);exit;
            $data['the_row_prize'] = $this->RowPrizeModel->getRowPrize("the_row_prize");
            //print_r($data['the_row_prize']);exit;

            $data['gallery_live'] = $this->GameGalleryModel->getDetailedGallery("live");

            $data['Stake_Row'] = $this->StakeRowsModel->getStake();
            $data['ActiveStakes'] = $this->StakeRowsModel->getStakesActive();


            $this->load->view('admin/pages/game_settings/row_game_settings', $data);
        }
        else{
           redirect('admin');
        }
        }else{
            redirect('admin/login');
        }
    }
    public function getDataRowPrize()
    {
         $id=$this->input->post('Prize_id');
        // $data=$this->RowPrizeModel->getRowPrizeEdit($id);
         $sql = "SELECT * FROM rowprize WHERE id = '".$id."'";
        $query = $this->db->query($sql)->result();
        echo json_encode($query);
    }
   public function updaterowprize(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->post('id');

         

            //initialize name
            $img_name_1 = rand(10,100000000000);
            $img_name_2 = 'row_prize_img_name_2';
            $img_name_3 = 'row_prize_img_name_3';
            $img_name_4 = 'row_prize_img_name_4';


            /*
            //This will override if data present
            if(!empty($this->input->post('img_name_1'))){
                $img_name_1 = $this->input->post('img_name_1');
            }else if(!empty($this->input->post('img_name_2'))){
                $img_name_2 = $this->input->post('img_name_2');
            }else if(!empty($this->input->post('img_name_3'))){
                $img_name_3 = $this->input->post('img_name_3');
            }else if(!empty($this->input->post('img_name_4'))){
                $img_name_4 = $this->input->post('img_name_4');
            }
            */
            
            

            if( !empty($_FILES['img_1']['name']) && !empty($_FILES['img_2']['name']) && !empty($_FILES['img_3']['name']) && !empty($_FILES['img_4']['name']) ){
                //All four to be uploaded
                $img_1 = $this->uploadImage("img_1", "game_images/prizes/", $img_name_1);
                $img_2 = $this->uploadImage("img_2", "game_images/prizes/", $img_name_2);
                $img_3 = $this->uploadImage("img_3", "game_images/prizes/", $img_name_3);
                $img_4 = $this->uploadImage("img_4", "game_images/prizes/", $img_name_4);
                $update_object = array(
                    "prize_name" => $this->input->post('prize_name'),
                    "prize_value" => $this->input->post('prize_value'),
                    "prize_type" => $this->input->post('prize_type'),
                    "Stake_id" => $this->input->post('Stake_Row'),
                    "description_highlight" => $this->input->post('description_highlight'),
                    "description" => $this->input->post('description'),
                    "img_1" => $img_1,
                    "img_2" => $img_2,
                    "img_3" => $img_3,
                    "img_4" => $img_4
                );
            }else if( (!empty($_FILES['img_1']['name']) && !empty($_FILES['img_2']['name']) && !empty($_FILES['img_3']['name'])) && empty($_FILES['img_4']['name']) ){
                //1, 2 and 3 to be uploaded
                $img_1 = $this->uploadImage("img_1", "game_images/prizes/", $img_name_1);
                $img_2 = $this->uploadImage("img_2", "game_images/prizes/", $img_name_2);
                $img_3 = $this->uploadImage("img_3", "game_images/prizes/", $img_name_3);
                $update_object = array(
                    "prize_name" => $this->input->post('prize_name'),
                    "prize_value" => $this->input->post('prize_value'),
                    "prize_type" => $this->input->post('prize_type'),
                    "Stake_id" => $this->input->post('Stake_Row'),
                    "description_highlight" => $this->input->post('description_highlight'),
                    "description" => $this->input->post('description'),
                    "img_1" => $img_1,
                    "img_2" => $img_2,
                    "img_3" => $img_3
                );
            }else if( (!empty($_FILES['img_1']['name']) && !empty($_FILES['img_2']['name'])) && (empty($_FILES['img_3']['name']) && empty($_FILES['img_4']['name'])) ){
                //1 and 2 to be uploaded
                $img_1 = $this->uploadImage("img_1", "game_images/prizes/", $img_name_1);
                $img_2 = $this->uploadImage("img_2", "game_images/prizes/", $img_name_2);
                $update_object = array(
                    "prize_name" => $this->input->post('prize_name'),
                    "prize_value" => $this->input->post('prize_value'),
                    "prize_type" => $this->input->post('prize_type'),
                    "Stake_id" => $this->input->post('Stake_Row'),
                    "description_highlight" => $this->input->post('description_highlight'),
                    "description" => $this->input->post('description'),
                    "img_1" => $img_1,
                    "img_2" => $img_2
                );
            }else if( !empty($_FILES['img_1']['name']) && (empty($_FILES['img_2']['name']) && empty($_FILES['img_3']['name']) && empty($_FILES['img_4']['name'])) ){
                //Only image 1 to be uploaded
                $img_1 = $this->uploadImage("img_1", "game_images/prizes/", $img_name_1);
                $update_object = array(
                    "prize_name" => $this->input->post('prize_name'),
                    "prize_value" => $this->input->post('prize_value'),
                    "prize_type" => $this->input->post('prize_type'),
                    "Stake_id" => $this->input->post('Stake_Row'),
                    "description_highlight" => $this->input->post('description_highlight'),
                    "description" => $this->input->post('description'),
                    "img_1" => $img_1
                );
            }else if( !empty($_FILES['img_2']['name']) && (empty($_FILES['img_1']['name']) && empty($_FILES['img_3']['name']) && empty($_FILES['img_4']['name'])) ){
                //echo "image 2 selected";exit;
                $img_2 = $this->uploadImage("img_2", "game_images/prizes/", $img_name_2);
                $update_object = array(
                    "prize_name" => $this->input->post('prize_name'),
                    "prize_value" => $this->input->post('prize_value'),
                    "prize_type" => $this->input->post('prize_type'),
                    "Stake_id" => $this->input->post('Stake_Row'),
                    "description_highlight" => $this->input->post('description_highlight'),
                    "description" => $this->input->post('description'),
                    "img_2" => $img_2
                );
                //print_r($update_object);exit;
            }else if( !empty($_FILES['img_3']['name']) && (empty($_FILES['img_1']['name']) && empty($_FILES['img_2']['name']) && empty($_FILES['img_4']['name'])) ){
                $img_3 = $this->uploadImage("img_3", "game_images/prizes/", $img_name_3);
                $update_object = array(
                    "prize_name" => $this->input->post('prize_name'),
                    "prize_value" => $this->input->post('prize_value'),
                    "prize_type" => $this->input->post('prize_type'),
                    "Stake_id" => $this->input->post('Stake_Row'),
                    "description_highlight" => $this->input->post('description_highlight'),
                    "description" => $this->input->post('description'),
                    "img_3" => $img_3
                );
            }else if(!empty($_FILES['img_4']['name']) && (empty($_FILES['img_1']['name']) && empty($_FILES['img_2']['name']) && empty($_FILES['img_3']['name']))){
                $img_4 = $this->uploadImage("img_4", "game_images/prizes/", $img_name_4);
                $update_object = array(
                    "prize_name" => $this->input->post('prize_name'),
                    "prize_value" => $this->input->post('prize_value'),
                    "prize_type" => $this->input->post('prize_type'),
                    "Stake_id" => $this->input->post('Stake_Row'),
                    "description_highlight" => $this->input->post('description_highlight'),
                    "description" => $this->input->post('description'),
                    "img_4" => $img_4
                );
            }else{
                $update_object = array(
                    "prize_name" => $this->input->post('prize_name'),
                    "prize_value" => $this->input->post('prize_value'),
                    "prize_type" => $this->input->post('prize_type'),
                    "Stake_id " => $this->input->post('Stake_Row'),
                    "description_highlight" => $this->input->post('description_highlight'),
                    "description" => $this->input->post('description'),
                );
            }
            if($this->RowPrizeModel->updateRowPrize($id, $update_object)){
                $this->session->set_flashdata('update_row_game_success', "Row prize updated successfully!");
            }else{
                $this->session->set_flashdata('update_row_game_error', "Failed to update row prize!");
            }
            redirect('admin/rowgame');
        }else{
            redirect('admin/login');
        }
    }
    
    public function uploadrowwinningimage(){
        if($this->session->userdata('admin_logged_in_data')){
            //Check if user have selected file
            if(!empty($_FILES['inputFile']['name'])){
                $id = $this->input->post('id');
                $file_upload_name = $this->uploadImage("inputFile", "game_images/row/", "row_winning_image");
                //Prepare update object
                $update_object = array(
                    "winning_image" => $file_upload_name
                );
                if($this->RowGameModel->updateRowGame($id, $update_object)){
                    $this->session->set_flashdata('update_row_game_success', "Image updated successfully!");
                }else{
                    $this->session->set_flashdata('update_row_game_error', "Image could not be updated!");
                }
            }else{
                $this->session->set_flashdata('update_row_game_error', "Please select a file to upload!");
            }
            redirect('admin/rowgame');
        }else{
            redirect('admin/login');
        }
    }
    public function updaterowgamesettings(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->post('id');
            //echo $id;exit;
            $the_row_game_object = array(
                "min_stake" => $this->input->post('min_stake'),
                "max_stake" => $this->input->post('max_stake'),
                "image_order" => $this->input->post('image_order'),
                "number_of_row" => $this->input->post('number_of_row')
            );
            //print_r($the_row_game_object);exit;
            if($this->RowGameModel->updateRowGame($id, $the_row_game_object)){
                $this->session->set_flashdata('update_row_game_success', "Row game settings have been updated successfully");
            }else{
                $this->session->set_flashdata('update_row_game_error', "Row game settings have not been updated successfully");
            }
            redirect('admin/rowgame');
        }else{
            redirect('admin/login');
        }
    }
    public function prizes(){
        if($this->session->userdata('admin_logged_in_data')){
            $user_type=$this->session->userdata('admin_logged_in_data');
            if(!($user_type['user_type']== "Moderat"||$user_type['user_type']== "Editor")){
            $data['pagename'] = "prizes";

            //Get all active levels
            $data['levels'] = $this->LevelModel->getAllLevels();
            if($data['levels'] == false){
                $this->session->set_flashdata('level_not_found', "You must add Image/s in Gallery and atleast 1 Level to add Prizes!");
                redirect('admin/addgallery');
            }
            //Get all prizes
            $data['prizes'] = $this->RowPrizeModel->getRowPrize();
            //print_r($data['prizes']);
            $data['ActiveStakes']= $this->StakeRowsModel->getStakesActive();
            $this->load->view('admin/pages/game_settings/prizes_settings', $data);
        }
        else{
            redirect('admin');
        }
        }else{
            redirect('admin/login');
        }
    }
    public function prizeclaim(){
        if($this->session->userdata('admin_logged_in_data')){
            $data['pagename'] = "prizeclaim";

            $data['pending_level_prizes'] = $this->LevelPrizeCollectionModel->getAllLevelPrizeCollectionBySent('no');
            //print_r($data['pending_level_prizes']);exit;
            $data['sent_level_prizes'] = $this->LevelPrizeCollectionModel->getAllLevelPrizeCollectionBySent('yes');
            //print_r($data['sent_level_prizes']);exit;

            $data['pending_row_prizes'] = $this->RowPrizeCollectionModel->getAllRowPrizeCollectionBySent('no');
            //print_r($data['pending_row_prizes']);exit;
            $data['sent_row_prizes'] = $this->RowPrizeCollectionModel->getAllRowPrizeCollectionBySent('yes');
            //print_r($data['sent_row_prizes']);exit;

            $this->load->view('admin/pages/prize_collection/prize_collection', $data);
        }else{
            redirect('admin/login');
        }
    }
    public function updatelevelprizecollection(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->post('id');
            $update_object = array(
                "tracking" => $this->input->post('tracking'),
                "tracking_url" => $this->input->post('tracking_url'),
                "delivered_status" => $this->input->post('delivery_status'),
                "status" => $this->input->post('status'),
                "sent" => $this->input->post('sent')
            );
            if($this->LevelPrizeCollectionModel->updateLevelPrizeCollection($id, $update_object)){
                $this->session->set_flashdata('message_success', "Updated successfully!");
            }else{
                $this->session->set_flashdata('message_error', "Could not update!");
            }
            redirect('admin/prizeclaim');
        }else{
            redirect('admin/login');
        }
    }
    public function updaterowprizecollection(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->post('id');
            $user_type = $this->session->userdata('admin_logged_in_data');
            if(!$user_type['user_type']== "Editor")
            {
            $update_object = array(
                "tracking" => $this->input->post('tracking'),
                "tracking_url" => $this->input->post('tracking_url'),
                "delivered_status" => $this->input->post('delivery_status'),
                "status" => $this->input->post('status'),
                "sent" => $this->input->post('sent')
            );
            if($this->RowPrizeCollectionModel->updateRowPrizeCollection($id, $update_object)){
                $this->session->set_flashdata('message_success', "Updated successfully!");
            }else{
                $this->session->set_flashdata('message_error', "Could not update!");
            }
            redirect('admin/prizeclaim');
        }else{
            $this->session->set_flashdata('message_error', "You are not allowed to update");
        }
        redirect('admin/prizeclaim');
        }else{
            redirect('admin/login');
        }
    }
    // public function addprizzetodb(){
    //     if($this->session->userdata('admin_logged_in_data')){
    //         // $prize_id = $this->GenerateRandomNumber(2);
    //         $prize_id = rand(10,1000000000);
    //         $prize_object = array(
    //             "id" => $prize_id,
    //             "prize_name" => $this->input->post('prize_name'),
    //             "prize_value" => $this->input->post('prize_value'),
    //             "prize_type" => $this->input->post('prize_type'),
    //             "Stake_Id " => $this->input->post('Stake_Row'),
    //             "description_highlight" => $this->input->post('description_highlight'),
    //             "description" => $this->input->post('description'),
    //             "status" => $this->input->post('status')
    //         );
            
    //             if($this->RowPrizeModel->insertIntoRowPrize($prize_object)){
    //                 echo $prize_id;
    //             }else{
    //                 echo "fail";
    //             }
            
    //     }else{
    //         redirect('admin/login');
    //     }
    // }
    public function addprizzetodb(){
        if($this->session->userdata('admin_logged_in_data')){
            $id = $this->input->post('id');
            $prize_id = rand(10,1000000000);


            //initialize name
            $img_name_1 = $prize_id;
            $img_name_2 = 'row_prize_img_name_2';
            $img_name_3 = 'row_prize_img_name_3';
            $img_name_4 = 'row_prize_img_name_4';


            /*
            //This will override if data present
            if(!empty($this->input->post('img_name_1'))){
                $img_name_1 = $this->input->post('img_name_1');
            }else if(!empty($this->input->post('img_name_2'))){
                $img_name_2 = $this->input->post('img_name_2');
            }else if(!empty($this->input->post('img_name_3'))){
                $img_name_3 = $this->input->post('img_name_3');
            }else if(!empty($this->input->post('img_name_4'))){
                $img_name_4 = $this->input->post('img_name_4');
            }
            */
            
            

            if( !empty($_FILES['img_1']['name']) && !empty($_FILES['img_2']['name']) && !empty($_FILES['img_3']['name']) && !empty($_FILES['img_4']['name']) ){
                //All four to be uploaded
                $img_1 = $this->uploadImage("img_1", "game_images/row/", $img_name_1);
                $img_2 = $this->uploadImage("img_2", "game_images/row/", $img_name_2);
                $img_3 = $this->uploadImage("img_3", "game_images/row/", $img_name_3);
                $img_4 = $this->uploadImage("img_4", "game_images/row/", $img_name_4);
                $update_object = array(
                    "id" => $prize_id,
                    "prize_name" => $this->input->post('prize_name'),
                    "prize_value" => $this->input->post('prize_value'),
                    "prize_type" => $this->input->post('prize_type'),
                    "status"=>$this->input->post('status'),
                    "Stake_id"=>$this->input->post('Stake_Row'),
                    "description_highlight" => $this->input->post('description_highlight'),
                    "description" => $this->input->post('description'),
                    "img_1" => $img_1,
                    "img_2" => $img_2,
                    "img_3" => $img_3,
                    "img_4" => $img_4
                );
            }else if( (!empty($_FILES['img_1']['name']) && !empty($_FILES['img_2']['name']) && !empty($_FILES['img_3']['name'])) && empty($_FILES['img_4']['name']) ){
                //1, 2 and 3 to be uploaded
                $img_1 = $this->uploadImage("img_1", "game_images/row/", $img_name_1);
                $img_2 = $this->uploadImage("img_2", "game_images/row/", $img_name_2);
                $img_3 = $this->uploadImage("img_3", "game_images/row/", $img_name_3);
                $update_object = array(
                    "id" => $prize_id,
                    "prize_name" => $this->input->post('prize_name'),
                    "Stake_id"=>$this->input->post('Stake_Row'),
                    "prize_value" => $this->input->post('prize_value'),
                    "prize_type" => $this->input->post('prize_type'),
                    "status"=>$this->input->post('status'),
                    "description_highlight" => $this->input->post('description_highlight'),
                    "description" => $this->input->post('description'),
                    "img_1" => $img_1,
                    "img_2" => $img_2,
                    "img_3" => $img_3
                );
            }else if( (!empty($_FILES['img_1']['name']) && !empty($_FILES['img_2']['name'])) && (empty($_FILES['img_3']['name']) && empty($_FILES['img_4']['name'])) ){
                //1 and 2 to be uploaded
                $img_1 = $this->uploadImage("img_1", "game_images/row/", $img_name_1);
                $img_2 = $this->uploadImage("img_2", "game_images/row/", $img_name_2);
                $update_object = array(
                    "id" => $prize_id,
                    "prize_name" => $this->input->post('prize_name'),
                    "Stake_id"=>$this->input->post('Stake_Row'),
                    "prize_value" => $this->input->post('prize_value'),
                    "prize_type" => $this->input->post('prize_type'),
                    "status"=>$this->input->post('status'),
                    "description_highlight" => $this->input->post('description_highlight'),
                    "description" => $this->input->post('description'),
                    "img_1" => $img_1,
                    "img_2" => $img_2
                );
            }else if( !empty($_FILES['img_1']['name']) && (empty($_FILES['img_2']['name']) && empty($_FILES['img_3']['name']) && empty($_FILES['img_4']['name'])) ){
                //Only image 1 to be uploaded
                $img_1 = $this->uploadImage("img_1", "game_images/row/", $img_name_1);
                $update_object = array(
                    "id" => $prize_id,
                    "prize_name" => $this->input->post('prize_name'),
                    "Stake_id"=>$this->input->post('Stake_Row'),
                    "prize_value" => $this->input->post('prize_value'),
                    "prize_type" => $this->input->post('prize_type'),
                    "status"=>$this->input->post('status'),
                    "description_highlight" => $this->input->post('description_highlight'),
                    "description" => $this->input->post('description'),
                    "img_1" => $img_1
                );
            }else if( !empty($_FILES['img_2']['name']) && (empty($_FILES['img_1']['name']) && empty($_FILES['img_3']['name']) && empty($_FILES['img_4']['name'])) ){
                //echo "image 2 selected";exit;
                $img_2 = $this->uploadImage("img_2", "game_images/row/", $img_name_2);
                $update_object = array(
                    "id" => $prize_id,
                    "prize_name" => $this->input->post('prize_name'),
                    "Stake_id"=>$this->input->post('Stake_Row'),
                    "prize_value" => $this->input->post('prize_value'),
                    "prize_type" => $this->input->post('prize_type'),
                    "status"=>$this->input->post('status'),
                    "description_highlight" => $this->input->post('description_highlight'),
                    "description" => $this->input->post('description'),
                    "img_2" => $img_2
                );
                //print_r($update_object);exit;
            }else if( !empty($_FILES['img_3']['name']) && (empty($_FILES['img_1']['name']) && empty($_FILES['img_2']['name']) && empty($_FILES['img_4']['name'])) ){
                $img_3 = $this->uploadImage("img_3", "game_images/row/", $img_name_3);
                $update_object = array(
                    "id" => $prize_id,
                    "prize_name" => $this->input->post('prize_name'),
                    "Stake_id"=>$this->input->post('Stake_Row'),
                    "prize_value" => $this->input->post('prize_value'),
                    "prize_type" => $this->input->post('prize_type'),
                    "status"=>$this->input->post('status'),
                    "description_highlight" => $this->input->post('description_highlight'),
                    "description" => $this->input->post('description'),
                    "img_3" => $img_3
                );
            }else if(!empty($_FILES['img_4']['name']) && (empty($_FILES['img_1']['name']) && empty($_FILES['img_2']['name']) && empty($_FILES['img_3']['name']))){
                $img_4 = $this->uploadImage("img_4", "game_images/row/", $img_name_4);
                $update_object = array(
                    "id" => $prize_id,
                    "prize_name" => $this->input->post('prize_name'),
                    "Stake_id"=>$this->input->post('Stake_Row'),
                    "prize_value" => $this->input->post('prize_value'),
                    "prize_type" => $this->input->post('prize_type'),
                    "status"=>$this->input->post('status'),
                    "description_highlight" => $this->input->post('description_highlight'),
                    "description" => $this->input->post('description'),
                    "img_4" => $img_4
                );
            }else{
                $update_object = array(
                    "id" => $prize_id,
                    "prize_name" => $this->input->post('prize_name'),
                    "Stake_id"=>$this->input->post('Stake_Row'),
                    "prize_value" => $this->input->post('prize_value'),
                    "prize_type" => $this->input->post('prize_type'),
                    "status"=>$this->input->post('status'),
                    "description_highlight" => $this->input->post('description_highlight'),
                    "description" => $this->input->post('description'),
                );
            }
            if($this->RowPrizeModel->insertIntoRowPrize( $update_object)){
                $this->session->set_flashdata('update_row_game_success', "Row prize add successfully!");
            }else{
                $this->session->set_flashdata('update_row_game_error', "Failed to update row prize!");
            }
            redirect('admin/prizes');
        }else{
            redirect('admin/login');
        }
    }
    public function uploadprizeimages(){
        $prize_id = $this->input->get('prizelid');
        if (isset($_FILES['files']) && !empty($_FILES['files'])) {
            $no_files = count($_FILES["files"]['name']);
            for ($i = 0; $i < $no_files; $i++) {
                if ($_FILES["files"]["error"][$i] > 0) {
                    echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
                } else {
                    $ext = pathinfo($_FILES["files"]["name"][$i], PATHINFO_EXTENSION);
                    $newfilename = $this->GenerateRandomNumber(8). '_prize.' .$ext;
                    move_uploaded_file($_FILES["files"]["tmp_name"][$i], 'assets/game_images/row/' . $newfilename);
                    $prize_image_object = array(
                        "image_url" => $newfilename,
                        "prize_id" => $prize_id
                    );
                    if($this->LevelPrizeImageModel->insertIntolevelPrizeImage($prize_image_object)){
                        echo "success5";
                    }
                    //echo $newfilename;
                }
            }
        } else {
            echo '0';
        }
    }
    public function deleteprizes(){
        if($this->session->userdata('admin_logged_in_data')){
            //Get id
            $id= $_GET['id'];;
            
            //Get prize object by id
            $prize_object = $this->LevelPrizeModel->getLevelPrizesByID($id);
            // print_r($prize_object);exit;
            //Get all images for this object
            // $prize_images_object = $this->LevelPrizeImageModel->getLevelPrizeImagesByID($prize_object[0]->id);
            //print_r($prize_images_object);exit;
            
            //Step 1 delete all images
            // foreach ($prize_object as $key => $image) {
                //echo $image->image_url;
                $file_to_delete = 'assets/game_images/prizes/' .$prize_object[0]->img_1;
                unlink($file_to_delete);
            // }
            if($this->RowPrizeModel->deleteRowPrize($prize_object[0]->id)){
                $this->session->set_flashdata('level_prize_delete_success', "Prize has been deleted successfully!");
            }else{
                 $this->session->set_flashdata('level_prize_delete_error', "Prize has been deleted successfully!");
            }
            redirect('admin/rowgame');
        }else{
            redirect('admin/login');
        }
    }
    /////////////////////////////////////////////////
    // Game Settings End
    /////////////////////////////////////////////////
    


    /////////////////////////////////////////////////
    // API Settings End
    /////////////////////////////////////////////////
    public function apisettings(){
        if($this->session->userdata('admin_logged_in_data')){
            $user_type=$this->session->userdata('admin_logged_in_data');
            if(!($user_type['user_type']== "Moderat"||$user_type['user_type']== "Editor")){
            $data['pagename'] = "apisettings";

            //Get stripe payment settings
            $data['stripe_payment_settings'] = $this->PaymentSettingsModel->getSettingsByID("stripe");
            //print_r($data['stripe_payment_settings']);exit;
            
            //Get PayPal Settings
            $data['paypal_payment_settings'] = $this->PaymentSettingsModel->getSettingsByID("paypal");

            //Get Crypto Settings
            $data['crypto_payment_settings'] = $this->PaymentSettingsModel->getSettingsByID("crypto");
            //print_r($data['crypto_payment_settings']);exit;

            $data['two_fa_name'] = $this->PaymentSettingsModel->getSettingsByID("twofa");
            //print_r($data['crypto_payment_settings']);exit;

            $this->load->view('admin/pages/api/api_settings', $data);
        }
        else
        {
            redirect('admin');
        }
        }else{
            redirect('admin/login');
        }
    }
    public function updatestripesettings(){
        if($this->session->userdata('admin_logged_in_data')){
            
            //Payment mode
            $payment_mode = $this->input->post('stripe_payment_mode');

            //Sandbox mode
            $sandbox_mode = $this->input->post('stripe_sandbox_mode');

            //Live publishable key
            $live_public_key = $this->input->post('stripe_publishable_keys_live');

            //Live secret key
            $live_secret_key = $this->input->post('stripe_secret_keys_live');

            //Sandbox publishable key
            $sandbox_public_key = $this->input->post('stripe_publishable_keys_sandbox');

            //Sandbox secret key
            $sandbox_secret_key = $this->input->post('stripe_secret_keys_sandbox');

            $stripe_settings_object = array(
                "payment_mode" => $payment_mode,
                "sandbox_mode" => $sandbox_mode,
                "live_public_key" => $live_public_key,
                "live_secret_key" => $live_secret_key,
                "sandbox_public_key" => $sandbox_public_key,
                "sandbox_secret_key" => $sandbox_secret_key
            );
            //print_r($stripe_settings_object);exit;

            if($this->PaymentSettingsModel->updateSettings("stripe", $stripe_settings_object)){
                $this->session->set_flashdata('stripe_update_success', "Stripe settings have been updated successfully!");
            }else{
                $this->session->set_flashdata('stripe_update_error', "Stripe settings could not been updated!");
            }
            redirect('admin/apisettings');
        }else{
            redirect('admin/login');
        }
    }
    public function updatepaypalsettings(){
        if($this->session->userdata('admin_logged_in_data')){
            
            //Payment mode
            $payment_mode = $this->input->post('paypal_payment_mode');

            //Sandbox mode
            $sandbox_mode = $this->input->post('paypal_sandbox_mode');

            //Live publishable key
            $live_public_key = $this->input->post('paypal_publishable_keys_live');

            //Live secret key
            $live_secret_key = $this->input->post('paypal_secret_keys_live');

            //Sandbox publishable key
            $sandbox_public_key = $this->input->post('paypal_publishable_keys_sandbox');

            //Sandbox secret key
            $sandbox_secret_key = $this->input->post('paypal_secret_keys_sandbox');

            $paypal_settings_object = array(
                "payment_mode" => $payment_mode,
                "sandbox_mode" => $sandbox_mode,
                "live_public_key" => $live_public_key,
                "live_secret_key" => $live_secret_key,
                "sandbox_public_key" => $sandbox_public_key,
                "sandbox_secret_key" => $sandbox_secret_key
            );
            //print_r($stripe_settings_object);exit;

            if($this->PaymentSettingsModel->updateSettings("paypal", $paypal_settings_object)){
                $this->session->set_flashdata('paypal_update_success', "PayPal settings have been updated successfully!");
            }else{
                $this->session->set_flashdata('paypal_update_error', "PayPal settings could not been updated!");
            }
            redirect('admin/apisettings');
        }else{
            redirect('admin/login');
        }
    }
    public function updatecryptosettings(){
        if($this->session->userdata('admin_logged_in_data')){
            
            //Payment mode
            $payment_mode = $this->input->post('crypto_payment_mode');

            //Sandbox mode
            $sandbox_mode = $this->input->post('crypto_sandbox_mode');

            //Live publishable key
            $live_public_key = $this->input->post('crypto_publishable_keys_live');

            //Live secret key
            $live_secret_key = $this->input->post('crypto_secret_keys_live');

            //Sandbox publishable key
            $sandbox_public_key = $this->input->post('crypto_publishable_keys_sandbox');

            //Sandbox secret key
            $sandbox_secret_key = $this->input->post('crypto_secret_keys_sandbox');

            $crypto_settings_object = array(
                "payment_mode" => $payment_mode,
                "sandbox_mode" => $sandbox_mode,
                "live_public_key" => $live_public_key,
                "live_secret_key" => $live_secret_key,
                "sandbox_public_key" => $sandbox_public_key,
                "sandbox_secret_key" => $sandbox_secret_key
            );
            //print_r($stripe_settings_object);exit;

            if($this->PaymentSettingsModel->updateSettings("crypto", $crypto_settings_object)){
                $this->session->set_flashdata('crypto_update_success', "Crypto settings have been updated successfully!");
            }else{
                $this->session->set_flashdata('crypto_update_error', "Crypto settings could not been updated!");
            }
            redirect('admin/apisettings');
        }else{
            redirect('admin/login');
        }
    }

    // Update 2 FA Settings
    public function updatefasettings(){
        if($this->session->userdata('admin_logged_in_data')){

        $live_public_key = $this->input->post('fa_name_mode');
        $fa_settings_object = array(
                "payment_mode" => 'twofa',
                "sandbox_mode" => 1,
                "live_public_key" => $live_public_key,
                "live_secret_key" => 'SpotTheBallUK',
                "sandbox_public_key" => 'SpotTheBallUK',
                "sandbox_secret_key" => 'SpotTheBallUK'
            );
        if($this->PaymentSettingsModel->updateSettings("twofa", $fa_settings_object)){
                $this->session->set_flashdata('two_fa_success', "Two Factor Name have been updated successfully!");
            }else{
                $this->session->set_flashdata('two_fa_error', "Two Factor Name could not been updated!");
            }
            redirect('admin/apisettings');
        }else{
            redirect('admin/login');
        }

    }
    /////////////////////////////////////////////////
    // API Settings End
    /////////////////////////////////////////////////


    //Login page
    public function login(){
        if(!$this->session->userdata('admin_logged_in_data')){
            $this->load->view('admin/pages/auth/login_view');
        }else{
            redirect('admin');
        }
    }


    /////////////////////////////////////////////////
    // Admin settings
    /////////////////////////////////////////////////
    public function newadmin(){
        if($this->session->userdata('admin_logged_in_data')){
            $user_type=$this->session->userdata('admin_logged_in_data');
            if(!($user_type['user_type']== "Moderat"||$user_type['user_type']== "Editor")){
            $data['pagename'] = "new_admin";
            $this->load->view('admin/pages/admin_settings/create_admin', $data);
        }
        else{
            redirect('admin');
        }
        }else{
            redirect('admin');
        }
    }
    public function manageadmins(){
        if($this->session->userdata('admin_logged_in_data')){
            $user_type=$this->session->userdata('admin_logged_in_data');
            if(!($user_type['user_type']== "Moderat"||$user_type['user_type']== "Editor")){
            $data['pagename'] = "manage_admins";

            $data['admins'] = $this->AdminModel->getAllAdmins();

            $this->load->view('admin/pages/admin_settings/manage_admin', $data);
        }
        else{
            redirect('admin');
        }
        }else{
            redirect('admin');
        }
    }
    public function createadmin(){
        if($this->session->userdata('admin_logged_in_data')){
            $authenticated_user = $this->session->userdata('admin_logged_in_data');
            //print_r($authenticated_user);
            if($authenticated_user['user_type'] != "super"){
                $this->session->set_flashdata('error', 'You are not authorized to create a new admin account!');
                redirect('admin/newadmin');
            }else{
                $this->form_validation->set_rules('first_name', 'First Name', 'required');
                $this->form_validation->set_rules('last_name', 'Last Name', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
                $this->form_validation->set_rules('user_type', 'Account Type', 'required');
                $this->form_validation->set_rules('status', 'Account Status', 'required');
                $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]');
                $this->form_validation->set_rules('password', 'Password', 'required');

                if($this->form_validation->run() == FALSE){
                    $data['pagename'] = "new_admin";
                    $this->load->view('admin/pages/admin_settings/create_admin', $data);
                }else{
                    $admin_data = array(
                        "username" => $this->input->post('username'),
                        "email" => $this->input->post('email'),
                        "password" => md5($this->input->post('password')),
                        "first_name" => $this->input->post('first_name'),
                        "last_name" => $this->input->post('last_name'),
                        "user_type" => $this->input->post('user_type'),
                        "status" => $this->input->post('status')
                    );
                    if($this->AdminModel->insertIntoAdmin($admin_data)){
                        $this->session->set_flashdata('success', 'You have successfully created admin account for user: ' .$this->input->post('username'));
                        redirect("admin/manageadmins");
                    }else{
                        $this->session->set_flashdata('error', 'Error encountered while creating account for user: ' .$this->input->post('username'));
                        redirect("admin/manageadmins");
                    }
                }
            }
        }else{
            redirect('admin');
        }
    }
    public function editadmin(){
        if($this->session->userdata('admin_logged_in_data')){
            $data['pagename'] = "edit_admin";

            $id = $this->input->get('id');
            if(empty($id)){
                $this->session->set_flashdata('error', 'Invalid value passed for admin ID!');
                redirect("admin/manageadmins");
            }else{
                //get admin
                $data['admin'] = $this->AdminModel->getAdminByID($id);
                if($data['admin'] == false){
                    $this->session->set_flashdata('error', 'Could not find the user you are looking for!');
                    redirect("admin/manageadmins");
                }else{
                    $this->load->view('admin/pages/admin_settings/edit_admin', $data);
                }
            }
        }else{
            redirect('admin');
        }
    }
    public function updateadmin(){
        if($this->session->userdata('admin_logged_in_data')){
            $authenticated_user = $this->session->userdata('admin_logged_in_data');
            //print_r($authenticated_user);
            if($authenticated_user['user_type'] != "super"){
                $this->session->set_flashdata('error', 'You are not authorized to update an admin account!');
                redirect('admin/manageadmins');
            }else{
                $this->form_validation->set_rules('first_name', 'First Name', 'required');
                $this->form_validation->set_rules('last_name', 'Last Name', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
                $this->form_validation->set_rules('user_type', 'Account Type', 'required');
                $this->form_validation->set_rules('status', 'Account Status', 'required');
                $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]');

                $id = $this->input->post('id');

                if($this->form_validation->run() == FALSE){
                    $this->session->set_flashdata('error', 'Form validation failed, please try again');
                    redirect('admin/editadmin?id='.$id);
                }else{
                    if(empty($this->input->post('password'))){
                        $admin_data = array(
                            "username" => $this->input->post('username'),
                            "email" => $this->input->post('email'),
                            "first_name" => $this->input->post('first_name'),
                            "last_name" => $this->input->post('last_name'),
                            "user_type" => $this->input->post('user_type'),
                            "status" => $this->input->post('status')
                        );
                    }else{
                        $admin_data = array(
                            "username" => $this->input->post('username'),
                            "email" => $this->input->post('email'),
                            "password" => md5($this->input->post('password')),
                            "first_name" => $this->input->post('first_name'),
                            "last_name" => $this->input->post('last_name'),
                            "user_type" => $this->input->post('user_type'),
                            "status" => $this->input->post('status')
                        );
                    }
                    
                    if($this->AdminModel->updateAdmin($id, $admin_data)){
                        $this->session->set_flashdata('success', 'You have successfully updated admin account for user: ' .$this->input->post('username'));
                        redirect("admin/manageadmins");
                    }else{
                        $this->session->set_flashdata('error', 'Error encountered while updating account for user: ' .$this->input->post('username'));
                        redirect("admin/manageadmins");
                    }
                }
            }
        }else{
            redirect('admin');
        }
    }
    public function deleteadmin(){
        if($this->session->userdata('admin_logged_in_data')){
            $authenticated_user = $this->session->userdata('admin_logged_in_data');
            //print_r($authenticated_user);
            if($authenticated_user['user_type'] != "super"){
                $this->session->set_flashdata('error', 'You are not authorized to update an admin account!');
                redirect('admin/manageadmins');
            }else{
                $id = $this->input->get('id');

                if($this->AdminModel->deleteAdminAccount($id)){
                    $this->session->set_flashdata('success', 'You have successfully deleted admin account!');
                    redirect("admin/manageadmins");
                }else{
                    $this->session->set_flashdata('error', 'Error encountered while deleting account');
                    redirect("admin/manageadmins");
                }
        }
        }else{
            redirect('admin');
        }
    }

    //Get submitted data for login
    public function proccesslogin(){
        if($this->session->userdata('admin_logged_in_data')){
            redirect('admin/login');
        }else{
            //Check if login button was submitted
            if($this->input->post('btnLogin')){
                $this->form_validation->set_rules('username', 'Username', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');

                if ($this->form_validation->run() == FALSE){
                    $this->session->set_flashdata('login_error', 'You have entered invalid username or password!, Please try again.');
                    redirect('admin/login');
                    
                }else{
                    $username = $this->input->post('username');
                    $password = $this->input->post('password');

                    //echo "Username: " .$username;
                    //echo "<br>Password: " .$password;
                    if($this->verify_login($username, $password) == true){
                        $this->session->set_flashdata('login_success', 'You have successfully logged into our system.');
                        redirect('admin');
                    }else{
                        $this->session->set_flashdata('login_error', 'Wrong username or password, please try again.');
                        redirect('admin/login');
                    }
                } 
            }else{
                $data['pagename'] = "emptytemplate";
                $this->load->view('admin/pages/template/404', $data);
            }
        }
    }



    public function createQr(){
      if(!isset($_SESSION['adminid']))
      {
        redirect('admin/login');
      }
      $user=$_SESSION['adminid'];
      unset($_SESSION['adminid']);
      session_destroy();
      $this->load->library('GoogleAuthenticator');
      $ga = new GoogleAuthenticator();
      $secret = $ga->createSecret();
      $qrCodeUrl 	= $ga->getQRCodeGoogleUrl($user,$secret,'hasnainriazkayani');
      $data['qr']=$qrCodeUrl;
      $data['secret']=$secret;
      $data['adminid']=$user;
      $this->load->view('admin/pages/auth/scanqr',$data);
    }

    public function processTwoFactor(){
        $userid=$this->input->post('adminid');
        $code=$this->input->post("code");
        $secret=$this->input->post("secret");
        // echo $secret;exit;
        $this->load->library('GoogleAuthenticator');
        $ga = new GoogleAuthenticator();
        $checkResult = $ga->verifyCode($secret,$code,2); 
        if($checkResult)
        {
           
            $userobject=$this->AdminModel->getSingleUserById($userid);
            // echo $userid;exit;
            // echo '<pre>',print_r($userobject[0]);
            $sess_array = array(
                'username' => $userobject[0]->username,
                'first_name' => $userobject[0]->first_name,
                'last_name' => $userobject[0]->last_name,
                'status' => $userobject[0]->status,
                'user_type' => $userobject[0]->user_type,
                'expire' => time()+60*60*24*365
            );
            $this->session->set_userdata('admin_logged_in_data', $sess_array);
            $this->session->set_flashdata('login_success', 'You have successfully logged into our system.');
            redirect('admin');
        }
        else{
            $this->session->set_flashdata('login_banned', 'Login Failed Bad Credentials try again');
                redirect('admin/login'); 
        }
    }
    private function verify_login($username, $password){
        $user_found = false;
        $user_object = $this->AdminModel->verifyUser($username, $password);
        //If not false we have a user matching
        if($user_object != false){
            if($user_object[0]->two_factor_login==1)
            {
                $_SESSION['adminid']=$user_object[0]->id;
                redirect('admin/createQr');
            }
            else{
                $sess_array = array(
                    'username' => $user_object[0]->username,
                    'first_name' => $user_object[0]->first_name,
                    'last_name' => $user_object[0]->last_name,
                    'status' => $user_object[0]->status,
                    'user_type' => $user_object[0]->user_type,
                    'expire' => time()+60*60*24*365
                );
                $this->session->set_userdata('admin_logged_in_data', $sess_array);
                $user_found =  true;
            }
        }else{
            $user_found = false;
        }
        return $user_found;
    }
    public function logout(){
        if($this->session->userdata('admin_logged_in_data')){
            $this->session->unset_userdata('admin_logged_in_data');
        }
        redirect('admin/login');
    }

    //Helper functions
    private function GenerateRandomNumber($digits){
        //Generate the first number
        $randNum = rand(pow($digits, $digits-1), pow($digits, $digits)-1);
        return date("Ymd").$randNum;
    }
    private function GenerateUniqueUserID(){
        $unique_id = $this->GenerateRandomNumber(6);
        while($this->UserModel->userExistsByID($unique_id)){
            $unique_id = $this->GenerateRandomNumber(6);
        }
        return $unique_id;
    }


    private function GenerateUniqueAddressID(){
        $unique_id = $this->GenerateRandomNumber(6);
        while($this->AddressModel->addressExistsByID($unique_id)){
            $unique_id = $this->GenerateRandomNumber(6);
        }
        return $unique_id;
    }


    private function GenerateDateFromDDMMYYYY($dobDay, $dobMonth, $dobYear){
        $dobString = strtotime($dobDay . "/" .$dobMonth. "/" .$dobYear);
        return date('Y-m-d',$dobString);
    }
    //////////////////////////////////////////////////////////////////////////
    // $file_input_name is the name of the field
    //////////////////////////////////////////////////////////////////////////
    private function uploadAndResizeImage($file_input_name, $folder, $ad_identifier, $image_type){
        //Used to control error or success

        $new_name = $image_type."_".$ad_identifier;
        //echo $new_name;exit;
        $isUploadSuccess = false;

        $this->load->library('image_lib');
        $this->load->library('upload');

        $config['image_library'] = 'gd2';
        $config['upload_path'] = './assets/'.$folder;
        //echo $config['upload_path'];exit;
        $config['overwrite'] = TRUE;
        $config['allowed_types'] = 'jpg|png|jpeg';
        //$config['max_size'] = '1000';
        //$config['max_width'] = '1024';
        //$config['max_height'] = '768';
        $config['file_name'] = $new_name;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 600;
        $config['height'] = 400;

        
        $this->image_lib->initialize($config);
        $this->upload->initialize($config);
        
        if($this->upload->do_upload($file_input_name)){
            //echo 'upload done<br>';exit;
            $isUploadSuccess = true;
        }else{
            //Do some magic here
            echo $this->upload->display_errors();
            echo "<hr>Error uploading " .$new_name;
            //exit;
        }

        $upload_data = $this->upload->data();
        //echo $this->image_lib->display_errors();

        /*
        if(!$this->image_lib->resize()){
            //Do some magic here
            //echo $this->image_lib->display_errors();
            echo "<hr>Error resizing " .$new_name;
        }
        */

        $this->image_lib->clear();
        $new_name = "";

        //return $path;
        if($isUploadSuccess){
            return $upload_data['file_name'];
        }else{
            return false;
        }
    }
    private function uploadImage($file_input_name, $folder, $img_name){
        //Used to control error or success

        $new_name = $img_name;
        //echo $new_name;exit;
        $isUploadSuccess = false;

        $this->load->library('image_lib');
        $this->load->library('upload');

        $config['image_library'] = 'gd2';
        $config['upload_path'] = './assets/'.$folder;
        //echo $config['upload_path'];exit;
        $config['overwrite'] = TRUE;
        $config['allowed_types'] = 'jpg|png|jpeg';
        //$config['max_size'] = '1000';
        //$config['max_width'] = '1024';
        //$config['max_height'] = '768';
        $config['file_name'] = $new_name;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 600;
        $config['height'] = 400;

        
        $this->image_lib->initialize($config);
        $this->upload->initialize($config);
        
        if($this->upload->do_upload($file_input_name)){
            //echo 'upload done<br>';exit;
            $isUploadSuccess = true;
        }else{
            //Do some magic here
            echo $this->upload->display_errors();
            echo "<hr>Error uploading " .$new_name;
            //exit;
        }

        $upload_data = $this->upload->data();
        //echo $this->image_lib->display_errors();

        /*
        if(!$this->image_lib->resize()){
            //Do some magic here
            //echo $this->image_lib->display_errors();
            echo "<hr>Error resizing " .$new_name;
        }
        */

        $this->image_lib->clear();
        $new_name = "";

        //return $path;
        if($isUploadSuccess){
            return $upload_data['file_name'];
        }else{
            return false;
        }
    }

    private function uploadLogo($file_input_name, $folder, $img_name){
        //Used to control error or success

        $new_name = $img_name;
        //echo $new_name;exit;
        $isUploadSuccess = false;

        $this->load->library('image_lib');
        $this->load->library('upload');

        $config['image_library'] = 'gd2';
        $config['upload_path'] = './assets/'.$folder;
        //echo $config['upload_path'];exit;
        $config['overwrite'] = TRUE;
        $config['allowed_types'] = 'jpg|png|jpeg';
        //$config['max_size'] = '1000';
        //$config['max_width'] = '1024';
        //$config['max_height'] = '768';
        $config['file_name'] = $new_name;

        $filename= $_FILES[$file_input_name]["name"];
        $file_ext = pathinfo($filename,PATHINFO_EXTENSION);
        //echo $file_ext;exit;

        $config['source_image'] = $config['upload_path'].$new_name.'.'.$file_ext;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 100;
        $config['height'] = 50;

        //echo $config['source_image'];exit;
        
        $this->image_lib->initialize($config);
        $this->upload->initialize($config);
        
        if($this->upload->do_upload($file_input_name)){
            //echo 'upload done<br>';exit;
            $isUploadSuccess = true;
        }else{
            //Do some magic here
            //echo $this->upload->display_errors();
            //echo "<hr>Error uploading " .$new_name;
            //exit;
        }

        $upload_data = $this->upload->data();
        //echo $this->image_lib->display_errors();

        
        // if(!$this->image_lib->resize()){
        //     //Do some magic here
        //     echo $this->image_lib->display_errors();exit;
        //     //echo "<hr>Error resizing " .$new_name;exit;
        // }else{
        //     echo "resize done";exit;
        // }
        

        $this->image_lib->clear();
        $new_name = "";

        //return $path;
        if($isUploadSuccess){
            return $upload_data['file_name'];
        }else{
            return false;
        }
    }
    //////////////////////////////////////////////////////////////////////////
    // $file_input_name is the name of the field
    //////////////////////////////////////////////////////////////////////////
    private function uploadAndResizeDocument($file_input_name, $folder, $ad_identifier, $document_type){

        $new_name = $document_type."_".$ad_identifier;

        $isUploadSuccess = false;

        $config['upload_path'] = './assets/'.$folder;
        $config['overwrite'] = TRUE;
        $config['allowed_types'] = 'pdf|doc';
        $config['file_name'] = $new_name;

        $this->load->library('upload', $config);

        //Requires to clear out previous data, otherwise CI_Model will over write file name
        $this->upload->initialize($config);
        if($this->upload->do_upload($file_input_name)){
            //echo 'upload done<br>';
            $isUploadSuccess = true;
        }else{
            //Do some magic here
            echo $this->upload->display_errors();
            echo "<hr>Error uploading " .$new_name;
        }

        $upload_data = $this->upload->data();

        $new_name = "";

        //return $path;
        if($isUploadSuccess){
            return $upload_data['file_name'];
        }else{
            return false;
        }
    }

    private function deletefile($directory, $file_name){
        $file_url = $directory. '/' .$file_name;
        if(is_readable($file_url) && unlink($file_url)){
            return true;
        }else{
            return false;
        }
    }

    private function currencyExchanger($money_amount_to_convert){
        $money_to_exchange = $money_amount_to_convert;
        $exchange_rate = 1.12; //Should get from db
        $exchange_value = $money_to_exchange * $exchange_rate;
        return $exchange_value;
    }

    public function SaveStake()
    {
        $Stakes=$this->input->post('Stakes');
        $Rows=$this->input->post('Rows');
        if($this->StakeRowsModel->SaveStakes($Stakes,$Rows)){
                        $this->session->set_flashdata('success', 'You have successfully created Stakes: ' );
                        redirect("admin/rowgame");
                    }else{
                        $this->session->set_flashdata('error', 'Error encountered while creating account for user: ');
                        redirect("admin/rowgame");
                    }
    }
    function updateStake() {
        
$id= $this->input->post('id');
$data = array(
'Stake' => $this->input->post('stake'),
'Rows' => $this->input->post('row'),
'Status' => $this->input->post('status'),

);

if($this->StakeRowsModel->update_stake($id,$data))
{
    redirect("admin/rowgame");
}
    }
    public function addRowPrize()
    {
        $data = array(
'id ' => $this->input->post('id'),
'prize_name' => $this->input->post('prize_name'),
'prize_value' => $this->input->post('prize_value'),
'prize_value' => $this->input->post('status'),
'prize_value' => $this->input->post('Stake_id '),
'prize_value' => $this->input->post('unique_id'),
'prize_value' => $this->input->post('prize_value'),
'prize_value' => $this->input->post('prize_value'),
'prize_type' => $this->input->post('prize_type')
);
        $Stakes=$this->input->post('Stakes');
        $Rows=$this->input->post('Rows');
        if($this->RowPrizeModel->insertIntoRowPrize($Stakes,$Rows)){
                        $this->session->set_flashdata('success', 'You have successfully created Stakes: ' );
                        redirect("admin/rowgame");
                    }else{
                        $this->session->set_flashdata('error', 'Error encountered while creating account for user: ');
                        redirect("admin/rowgame");
                    }
    }
}