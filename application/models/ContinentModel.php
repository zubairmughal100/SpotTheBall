<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContinentModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();
        
        $this->load->library('dbcommon');
    }

    function getAllContinentsByOrder(){
        $continents = $this->dbcommon->getAllOrderBy("continents", "name", "ASC");
        //print_r($countries);
        if(!empty($continents)){
            return $continents;
        }else{
            return false;
        }
    }

    function blockedContinents(){
        $sql = "SELECT * FROM continents WHERE is_blocked = '1'";

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    function updateContinent($id, $object_update){
        $this->db->where('id', $id);
        $this->db->update('continents', $object_update);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }
    
    function getAllContinents(){
        $continents = $this->dbcommon->getAll("continents");
        if(!empty($continents)){
            return $continents;
        }else{
            return false;
        }
    }
}