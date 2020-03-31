<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CountyModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();
        
        $this->load->library('dbcommon');
    }
    
    function getAllCountiesOrderBy(){
        $countries = $this->dbcommon->getAllOrderBy("county", "name", "ASC");
        //print_r($countries);
        if(!empty($countries)){
            return $countries;
        }else{
            return false;
        }
    }


    function blockedCounties(){
        $sql = "SELECT id, code, name FROM county WHERE is_blocked = '1'";

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }


    function getCountiesByStateID($state_id){
        $sql = "SELECT c.* FROM county c INNER JOIN state as s on s.id = c.state_id WHERE s.id = ".$state_id;
        //echo $sql;
        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }


    //get name of country by id
    function getCountyNameByID($id){
        $sql = "SELECT name FROM county WHERE id = ".$id;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
		//print_r($query);
		if(!empty($query)){
			return $query[0]->name;
		}else{
			return false;
		}
    }


    function updateCounty($id, $object_update){
        $this->db->where('id', $id);
        $this->db->update('county', $object_update);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }

    //Check if country name exists, return false otherwise
    function countyExistsByName($name){
        return $this->dbcommon->existsByColumn("county", "name", $name);
    }

    //Check if country id exists, return false otherwise
    function countyExistsByID($id){
        return $this->dbcommon->existsByColumn("county", "id", $id);
    }

    //Delete country
    function deleteCounty($id){
        return $this->dbcommon->deleteRowByID("id", $id, "county");
    }

    function insertIntoCounty($aCounty) {
        if($this->dbcommon->insertIntoTable("county", $aCounty)){
            return true;
        }else{
            return false;
        }
    }
}