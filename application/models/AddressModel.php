<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddressModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getAllAddress(){
        $users = $this->dbcommon->getAll("address");
        
    }


    //Check if user id exists, return false otherwise
    function addressExistsByID($id){
        $sql = "SELECT * FROM address WHERE id = ".$id;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
		//print_r($query);
		if(!empty($query)){
			return true;
		}else{
			return false;
		}
    }


    //Get address by user id
    function getAddressByUserID($user_id){
        $sql = "SELECT * FROM address WHERE user_id = ".$user_id;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    ///////////////////////////////////////////////
    // ALL UPDATE QUERIES GOES UNDER THIS LINE
    ///////////////////////////////////////////////
    
    function updateAddress($id, $address_object_update){
        $this->db->where('id', $id);
        $this->db->update('address', $address_object_update);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }


    function insertIntoAddress($aAddress) {
        if($this->dbcommon->insertIntoTable("address", $aAddress)){
            return true;
        }else{
            return false;
        }
        
    }
}