<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


    public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->helper('html');
        $this->load->helper('url');

        $this->load->model('ContinentModel');
    }

    public function index(){
        //$this->ContinentModel->getAllContinents();
        redirect('game/playrow');
    }

    //make it private if not in use
    private function emptytemplate(){
        $this->load->view('player/pages/template/empty_template');
    }
    
}