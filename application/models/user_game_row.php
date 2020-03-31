<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user_game_row extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    function insertStatus($data)
  {
  if($this->dbcommon->insertIntoTable("user_row_game", $data)){
            return true;
        }else{
            return false;
        }
  }
    
}