<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CityModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();
        
        $this->load->library('dbcommon');
    }
    
    function getAllCitiesOrderBy(){
        $countries = $this->dbcommon->getAllOrderBy("cities", "name", "ASC");
        //print_r($countries);
        if(!empty($countries)){
            return $countries;
        }else{
            return false;
        }
    }


    function blockedCities(){
        $sql = "SELECT id, code, name FROM cities WHERE is_blocked = '1'";

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }


    function getCitiesByStateID($state_id){
        $sql = "SELECT c.* FROM cities c INNER JOIN state as s on s.id = c.state_id WHERE s.id = ".$state_id;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }


    function getCitiesByCountryID($country_id){
        $sql = "SELECT c.* FROM cities c INNER JOIN country as s on s.id = c.country_id WHERE c.country_id = ".$country_id;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }


    function getCitiesByCountyID($county_id){
        $sql = "SELECT c.* FROM cities c INNER JOIN county as s on s.id = c.county_id WHERE s.id = ".$county_id;

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
    function getCityNameByID($id){
        $sql = "SELECT name FROM cities WHERE id = ".$id;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
		//print_r($query);
		if(!empty($query)){
			return $query[0]->name;
		}else{
			return false;
		}
    }


    function getCityIDByName($name){
        $sql = "SELECT id FROM cities WHERE name = '".$name."'";

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query[0]->id;
        }else{
            return false;
        }
    }


    function updateCity($id, $object_update){
        $this->db->where('id', $id);
        $this->db->update('cities', $object_update);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }

    //Check if country name exists, return false otherwise
    function cityExistsByName($name){
        return $this->dbcommon->existsByColumn("cities", "name", $name);
    }

    //Check if country id exists, return false otherwise
    function cityExistsByID($id){
        return $this->dbcommon->existsByColumn("cities", "id", $id);
    }

    //Delete country
    function deleteCity($id){
        return $this->dbcommon->deleteRowByID("id", $id, "cities");
    }

    function insertIntoCity($aCity) {
        if($this->dbcommon->insertIntoTable("cities", $aCity)){
            return true;
        }else{
            return false;
        }
    }
}