<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentSettingsModel extends CI_Model {
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
        return $this->dbcommon->getAll("paymentsettings");
    }

    function getSettingsByID($whereValue){
        return $this->dbcommon->getAllWhere("paymentsettings", "id", $whereValue);
    }

    //Update settings
    function updateSettings($id, $settings_object){
        $this->db->where('id', $id);
        $this->db->update('paymentsettings', $settings_object);
        //print_r($this->db->error());exit;
        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }
    
}