<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LevelPrizeModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }

    function getAll(){
        $sql = "SELECT * FROM levelprize";

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    
    function getAllLevelPrizes(){
        return $this->prepareLevelPrizeData($this->getAllprizeByStatus('1'));
    }

    function prizeDetails($id){
        return $this->prepareLevelPrizeData($this->getLevelPrizesByID($id));
    }

    function getLevelPrizesByID($id){
        $sql = "SELECT * FROM rowprize WHERE id = " .$id;

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    function getAllLevelPrizesByOrder(){
        $sql = "SELECT * FROM levelprize ORDER BY prize_value DESC";

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    function getAllprizeByStatus($status){
        $sql = "SELECT * FROM levelprize WHERE status = '" .$status. "' ORDER BY Stake_Id ASC";
        //echo $sql;
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    function checkLevelIDExists($level_id){
        $sql = "SELECT * FROM levelprize WHERE level_id = ".$level_id;

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return true;
        }else{
            return false;
        }
    }



    function prepareLevelPrizeData($level_prizes){
        if($level_prizes != false){
            foreach ($level_prizes as $key => $level_prize) {
                $data[] = array(
                    "id" => $level_prize->id,
                    "prize_name" => $level_prize->prize_name,
                    "prize_value" => $level_prize->prize_value,
                    "prize_type" => $level_prize->prize_type,
                    "level_id" => $level_prize->level_id,
                    "description_highlight" => $level_prize->description_highlight,
                    "description" => $level_prize->description,
                    "status" => $level_prize->status,
                    "images" => $this->getImagesByLevelID($level_prize->id)
                );
            }
            return json_decode(json_encode($data));
        }
    }


    function getImagesByLevelID($levelprize_id){
        $sql = "SELECT * FROM levelprizeimage WHERE levelprize_id = ".$levelprize_id;
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
    
    function updateLevelPrize($id, $level_prize_object_update){
        $this->db->where('id', $id);
        $this->db->update('levelprize', $level_prize_object_update);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }

    //Delete country
    function deletePrize($id){
        return $this->dbcommon->deleteRowByID("id", $id, "levelprize");
    }


    function insertIntolevelPrize($aPrize) {
        if($this->dbcommon->insertIntoTable("levelprize", $aPrize)){
            return true;
        }else{
            return false;
        }
        
    }
}