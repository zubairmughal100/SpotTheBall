<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LevelPrizeCollectionModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getAllLevelPrizeCollection(){
        return $this->dbcommon->getAll("levelprizecollection");
    }

    function getLevelPrizeCollectionByID($id){
        $sql = "SELECT * FROM levelprizecollection WHERE id = " .$id;

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    function samePrizeClaimExistsIn24Hours($user_id, $levelprize_id){
        $sql = "SELECT * FROM levelprizecollection WHERE levelprizecollection.date_collected > DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND user_id = ".$user_id." AND levelprize_id = ".$levelprize_id;
        //echo $sql;exit;
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return true;
        }else{
            return false;
        }
    }

    function getAllLevelPrizeCollectionBySent($sent){
        $sql = "SELECT * FROM levelprizecollection WHERE sent = '" .$sent. "' ORDER BY date_collected DESC";

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }


    function getAllLevelPrizeCollectionByUserID($user_id){
        $sql = "SELECT * FROM levelprizecollection WHERE user_id = " .$user_id. " ORDER BY date_collected DESC";
        //echo $sql;
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }


    function getAllLevelPrizeCollectionByOrder(){
        $sql = "SELECT * FROM levelprizecollection ORDER BY date_collected DESC";

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    function getAllLevelPrizeCollectionByStatus($status){
        $sql = "SELECT * FROM levelprizecollection WHERE status = '" .$status. "' ORDER BY date_collected DESC";

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
    
    function updateLevelPrizeCollection($id, $level_prize_collection_object_update){
        $this->db->where('id', $id);
        $this->db->update('levelprizecollection', $level_prize_collection_object_update);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }

    //Delete country
    function deleteLevelPrizeCollection($id){
        return $this->dbcommon->deleteRowByID("id", $id, "levelprizecollection");
    }


    function insertIntoLevelPrizeCollection($aPrizeCollection) {
        if($this->dbcommon->insertIntoTable("levelprizecollection", $aPrizeCollection)){
            return true;
        }else{
            return false;
        }
        
    }
}