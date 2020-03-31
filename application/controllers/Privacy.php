<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privacy extends CI_Controller {


    public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->helper('html');
        $this->load->helper('url');

        // Load session through controller
		$this->load->library('session');

        $this->load->model('UserModel');
        $this->load->model('BlogPageModel');

        $this->load->model('GeneralSettingsModel');
    }

    public function index(){
        $data['pagename'] = "privacy";

        $data['general_settings'] = $this->GeneralSettingsModel->getSettings();

        if($this->session->userdata('player_logged_in_data')){
            $data['blogs'] = $this->BlogPageModel->getBlog();
        }else{
            $data['blogs'] = $this->BlogPageModel->getBlogsByPublicStatus('1'); //1 is public only
        }

        $this->load->view('site/privacy.php', $data);
    }
}