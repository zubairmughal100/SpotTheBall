<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RowPrizeCollectionModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getAllRowPrizeCollection(){
        return $this->dbcommon->getAll("rowprizecollection");
    }

    function getRowPrizeCollectionByID($id){
        $sql = "SELECT * FROM rowprizecollection WHERE id = " .$id;

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }


    function getAllRowPrizeCollectionBySent($sent){
        $sql = "SELECT * FROM rowprizecollection WHERE sent = '" .$sent. "' ORDER BY date_collected DESC";

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }


    function samePrizeClaimExistsIn24Hours($user_id, $rowprize_id){
        $sql = "SELECT * FROM rowprizecollection WHERE rowprizecollection.date_collected > DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND user_id = ".$user_id." AND rowprize_id = ".$rowprize_id;
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return true;
        }else{
            return false;
        }
    }


    function getAllLevelPrizeCollectionByUserID($user_id){
        $sql = "SELECT * FROM rowprizecollection WHERE user_id = " .$user_id. " ORDER BY date_collected DESC";
        //echo $sql;
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    function getAllRowPrizeCollectionByOrder(){
        $sql = "SELECT * FROM rowprizecollection ORDER BY date_collected DESC";

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    function getAllRowPrizeCollectionByStatus($status){
        $sql = "SELECT * FROM rowprizecollection WHERE status = '" .$status. "' ORDER BY date_collected DESC";

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
    
    function updateRowPrizeCollection($id, $level_prize_collection_object_update){
        $this->db->where('id', $id);
        $this->db->update('rowprizecollection', $level_prize_collection_object_update);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }

    //Delete country
    function deleteRowPrizeCollection($id){
        return $this->dbcommon->deleteRowByID("id", $id, "rowprizecollection");
    }


    function insertIntoRowPrizeCollection($aPrizeCollection) {
        if($this->dbcommon->insertIntoTable("rowprizecollection", $aPrizeCollection)){
            return true;
        }else{
            return false;
        }
        
    }
}