<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {


    public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->helper('html');
        $this->load->helper('url');

        // Load session through controller
        $this->load->library('session');

        $this->load->model('AdminModel');
        $this->load->model('CountryModel');
        $this->load->model('ContinentModel');
        $this->load->model('StateModel');
        $this->load->model('CountyModel');
        $this->load->model('CityModel');
    }



    /////////////////////////////////////////////////
    // API Calls Starts
    /////////////////////////////////////////////////
    //Get list of countries based on id
    public function getcountries(){
        //$country_id = $this->uri->segment(3);
        $continent_id = $this->input->post('continent_id');
        //echo $continent_id;exit;
        $countries = $this->CountryModel->getCointriesByCountryID($continent_id);
        //print_r($countries);exit;

        $output = "";

        if(!empty($continent_id) || $continent_id != null){
            if(!empty($countries) || $countries != false){
                foreach($countries as $key => $country){
                    $output .= "<option value='".$country->id."'>".$country->name."</option>";
                }
            }else{
                $output = "<option value='' selected disabled>No Country Found</option>";
            }
            
        }else{
            $output = "<option value='' selected disabled>Invalid Input</option>";
        }
        //echo json_encode($output);
        echo $output;
    }

    //Get list of states based on id
    public function getstates(){
        //$country_id = $this->uri->segment(3);
        $country_id = $this->input->post('country_id');

        $states = $this->StateModel->getStatesByCountryID($country_id);
        //print_r($countries);exit;

        $output = "";

        if(!empty($country_id) || $country_id != null){
            if(!empty($states) || $states != false){
                foreach($states as $key => $state){
                    $output .= "<option value='".$state->state_id."'>".$state->state_name."</option>";
                }
            }else{
                $output = "not_found";
            }
            
        }else{
            $output = "<option value='' selected disabled>Invalid Input</option>";
        }
        //echo json_encode($output);
        echo $output;
    }



    //Get list of states based on id
    public function getstatessignup(){
        //$country_id = $this->uri->segment(3);
        $country_id = $this->input->post('country_id');
        //echo $country_id;
        $states = $this->StateModel->getStatesByCountryID($country_id);
        //print_r($countries);exit;

        $output = "";

        if(!empty($country_id) || $country_id != null){
            if(!empty($states) || $states != false){
                foreach($states as $key => $state){
                    $output .= "<option value='".$state->state_id."'>".$state->state_name."</option>";
                }
            }else{
                $output = "not_found";
            }
            
        }else{
            $output = "<option value='' selected disabled>Invalid Input</option>";
        }
        //echo json_encode($output);
        echo $output;
    }


    //Get list of counties based on id
    public function getcounties(){
        //echo "hello";exit;
        //$country_id = $this->uri->segment(3);
        $state_id = $this->input->post('state_id');
        //echo "State ID: " .$state_id;exit;

        $counties = $this->CountyModel->getCountiesByStateID($state_id);
        //print_r($counties);exit;

        $output = "";

        if(!empty($state_id) || $state_id != null){
            if(!empty($counties) || $counties != false){
                foreach($counties as $key => $county){
                    $output .= "<option value='".$county->id."'>".$county->name."</option>";
                }
            }else{
                $output = "<option value='' selected disabled>No County Found</option>";
            }
            
        }else{
            $output = "<option value='' selected disabled>Invalid Input</option>";
        }
        //echo json_encode($output);
        echo $output;
    }


    //Get list of cities based on id
    public function getcities(){
        //echo "hello";exit;
        //$county_id = $this->uri->segment(3);
        $county_id = $this->input->post('county_id');
        //echo "City ID: " .$county_id;exit;

        $cities = $this->CityModel->getCitiesByCountyID($county_id);
        //print_r($counties);exit;

        $output = "";

        if(!empty($county_id) || $county_id != null){
            if(!empty($cities) || $cities != false){
                foreach($cities as $key => $city){
                    $output .= "<option value='".$city->id."'>".$city->name."</option>";
                }
            }else{
                $output = "<option value='' selected disabled>No City Found</option>";
            }
            
        }else{
            $output = "<option value='' selected disabled>Invalid Input</option>";
        }
        //echo json_encode($output);
        echo $output;
    }


    public function getcitiesbystateid(){
        //echo "hello";exit;
        //$county_id = $this->uri->segment(3);
        $state_id = $this->input->post('state_id');
        //echo "City ID: " .$county_id;exit;

        $cities = $this->CityModel->getCitiesByStateID($state_id);
        //print_r($counties);exit;

        $output = "";

        if(!empty($state_id) || $state_id != null){
            if(!empty($cities) || $cities != false){
                foreach($cities as $key => $city){
                    $output .= "<option value='".$city->id."'>".$city->name."</option>";
                }
            }else{
                $output = "<option value='' selected disabled>No City Found</option>";
            }
            
        }else{
            $output = "<option value='' selected disabled>Invalid Input</option>";
        }
        //echo json_encode($output);
        echo $output;
    }



    public function getcitiesbycountryid(){
        //echo "hello";exit;
        //$county_id = $this->uri->segment(3);
        $country_id = $this->input->post('country_id');
        //echo "City ID: " .$county_id;exit;

        $cities = $this->CityModel->getCitiesByCountryID($country_id);
        //print_r($counties);exit;

        $output = "";

        if(!empty($country_id) || $country_id != null){
            if(!empty($cities) || $cities != false){
                foreach($cities as $key => $city){
                    $output .= "<option value='".$city->id."'>".$city->name."</option>";
                }
            }else{
                $output = "<option value='' selected disabled>No City Found</option>";
            }
            
        }else{
            $output = "<option value='' selected disabled>Invalid Input</option>";
        }
        //echo json_encode($output);
        echo $output;
    }
    /////////////////////////////////////////////////
    // API Calls Ends
    /////////////////////////////////////////////////
}