<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImageActivityModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getAllImageActivities(){
        $users = $this->dbcommon->getAll("imageactivity");
        
    }

    function getAllImageActivitiesOrderBy(){
        $sql = "SELECT * FROM imageactivity ORDER BY id ASC";

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    function getAllImageActivitiesByID($id){
        $sql = "SELECT * FROM imageactivity WHERE id = " .$id;

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }


    function getLastRow(){
        $sql = "SELECT * FROM imageactivity ORDER BY id DESC limit 1";

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query[0]->level_number;
        }else{
            return 0;
        }
    }



    ///////////////////////////////////////////////
    // ALL UPDATE QUERIES GOES UNDER THIS LINE
    ///////////////////////////////////////////////
    
    function updateImageActivity($id, $image_activity_object_update){
        $this->db->where('id', $id);
        $this->db->update('imageactivity', $image_activity_object_update);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }

    //Delete country
    function deleteImageActivity($id){
        return $this->dbcommon->deleteRowByID("id", $id, "imageactivity");
    }


    function insertIntoImageActivity($anImageActivity) {
        if($this->dbcommon->insertIntoTable("imageactivity", $anImageActivity)){
            return true;
        }else{
            return false;
        }
        
    }
}