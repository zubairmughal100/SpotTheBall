<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CountryModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();
        
        $this->load->library('dbcommon');
    }
    
    function getAllCountries(){
        $countries = $this->dbcommon->getAllOrderBy("country", "name", "ASC");
        //print_r($countries);
        if(!empty($countries)){
            return $countries;
        }else{
            return false;
        }
    }


    function blockedCountries(){
        $sql = "SELECT id, code, name FROM country WHERE is_blocked = '1'";

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }


    function getCointriesByCountryID($continent_id){
        $sql = "SELECT c.* FROM country c INNER JOIN continents as ct on ct.id = c.continent_id WHERE ct.id = ".$continent_id;

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
    function getCountryNameByID($id){
        $sql = "SELECT name FROM country WHERE id = ".$id;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
		//print_r($query);
		if(!empty($query)){
			return $query[0]->name;
		}else{
			return false;
		}
    }

    function getCountryCodeByID($id){
        $sql = "SELECT code FROM country WHERE id = ".$id;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query[0]->code;
        }else{
            return false;
        }
    }


    function updateCountry($id, $object_update){
        $this->db->where('id', $id);
        $this->db->update('country', $object_update);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }

    //Check if country name exists, return false otherwise
    function countryExistsByName($name){
        return $this->dbcommon->existsByColumn("country", "name", $name);
    }

    //Check if country id exists, return false otherwise
    function countryExistsByID($id){
        return $this->dbcommon->existsByColumn("country", "id", $id);
    }

    //Delete country
    function deleteCountry($id){
        return $this->dbcommon->deleteRowByID("id", $id, "country");
    }

    function insertIntoCountry($aCountry) {
        if($this->dbcommon->insertIntoTable("country", $aCountry)){
            return true;
        }else{
            return false;
        }
    }
}