<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class CISessionModel extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
	}

	//Get ci_session by session_id
	function getSessionByID($session_id){
		$sql = "SELECT * FROM ci_sessions WHERE id = '" .$session_id. "'";
		//echo $sql;
		$query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
	}

	//Delete the ci_session by session_id
	function deleteCiSession($session_id){
		$this->db->where('id', $session_id);
		$this->db->delete('ci_sessions');

		if($this->db->affected_rows() > 0){
            return true;
        }else{
            //print_r($this->db->error());
            return false;
        }
	}
}