<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {


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

        //Blogs
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

        if($this->session->userdata('player_logged_in_data')){
            $data['blogs'] = $this->BlogPageModel->getBlog();
        }else{
            $data['blogs'] = $this->BlogPageModel->getBlogsByPublicStatus('1'); //1 is public only
        }

        //print_r($data['blogs']);exit;
        $this->load->view('blogs/blog_home', $data);
    }

    public function page(){
        $this->checkIsBlocked();
        
        //Get id
        $id = $this->input->get('id');
        //echo $id;exit;
        
        $the_blog = $this->BlogPageModel->getBlogByIDPublished($id);
        if($the_blog != false){
            $data['the_blog'] = $the_blog;
            $this->load->view('blogs/blog_details', $data);
        }else{
            $this->load->view('blogs/not_found');
        }
    }
}