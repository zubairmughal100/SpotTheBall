<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StateModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();
        
        $this->load->library('dbcommon');
    }
    
    function getAllStates(){
        $states = $this->dbcommon->getAll("state");
        print_r($states);
    }

    function blockedStates(){
        $sql = "SELECT id, code, name FROM state WHERE is_blocked = '1'";

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    function getStateNameByID($id){
        $sql = "SELECT name FROM state WHERE id = ".$id;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query[0]->name;
        }else{
            return false;
        }
    }

    function getStateIDByName($name){
        $sql = "SELECT id FROM state WHERE name = '".$name."'";

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query[0]->id;
        }else{
            return false;
        }
    }

    function getAllStatesOrderBy(){
        $states = $this->dbcommon->getAllOrderBy("state", "name", "ASC");
        //print_r($countries);
        if(!empty($states)){
            return $states;
        }else{
            return false;
        }
    }

    function getStatesByCountryID($country_id){
        $sql = "SELECT c.id as country_id, c.name as country_name, c.icon as country_icon, s.id as state_id, s.name as state_name, s.icon as state_icon FROM state s INNER JOIN country AS c ON c.id = s.country_id WHERE s.country_id = ".$country_id;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
		//print_r($query);
		if(!empty($query)){
			return $query;
		}else{
			return false;
		}
    }

    function updateState($id, $object_update){
        $this->db->where('id', $id);
        $this->db->update('state', $object_update);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }


    //Check if country name exists, return false otherwise
    function stateExistsByName($name){
        return $this->dbcommon->existsByColumn("state", "name", $name);
    }

    //Check if country id exists, return false otherwise
    function stateExistsByID($id){
        return $this->dbcommon->existsByColumn("state", "id", $id);
    }

    //Delete country
    function deleteState($id){
        return $this->dbcommon->deleteRowByID("id", $id, "state");
    }

    function insertIntoState($aState) {
        if($this->dbcommon->insertIntoTable("state", $aState)){
            return true;
        }else{
            return false;
        }
    }
}