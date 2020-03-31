<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LevelPrizeImageModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getAllLevelPrizes(){
        $users = $this->dbcommon->getAll("levelprizeimage");
        
    }


    function getLevelPrizeImagesByID($id){
        $sql = "SELECT * FROM levelprizeimage WHERE levelprize_id = " .$id;

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
    
    function updateLevelPrizeImage($id, $level_prize_image_object_update){
        $this->db->where('id', $id);
        $this->db->update('levelprizeimage', $level_prize_image_object_update);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }


    function insertIntolevelPrizeImage($aPrize) {
        if($this->dbcommon->insertIntoTable("rowprizeimage", $aPrize)){
            return true;
        }else{
            return false;
        }
        
    }
}