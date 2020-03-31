<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MessageSettingsModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getMessageSettings(){
        return $this->dbcommon->getAll("messagesettings");
    }

    function getMessageSettingsByID($whereValue){
        return $this->dbcommon->getAllWhere("messagesettings", "id", $whereValue);
    }

    //Update settings
    function updateMessage($id, $settings_object){
        $this->db->where('id', $id);
        $this->db->update('messagesettings', $settings_object);
        //print_r($this->db->error());exit;
        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }


    function insertIntoMessageSettings($aMessage) {
        if($this->dbcommon->insertIntoTable("messagesettings", $aMessage)){
            return true;
        }else{
            return false;
        }
        
    }


    //Delete country
    function deleteMessage($id){
        return $this->dbcommon->deleteRowByID("id", $id, "messagesettings");
    }
    
}