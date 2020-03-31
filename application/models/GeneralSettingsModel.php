<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GeneralSettingsModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getSettings(){
        return $this->dbcommon->getAll("generalsettings");
    }

    //Update settings
    function updateSettings($settings_object){
        $this->db->where('id', 1);
        $this->db->update('generalsettings', $settings_object);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            //print_r($this->db->error());
            return false;
        }
    }
    
}