<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RowPrizeModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getAllRowPrizes(){
        $users = $this->dbcommon->getAll("rowprize");
        
    }

function getRowPrizeEdit($id)
{
    $sql = "SELECT * FROM rowprize WHERE id = '".$id."'";
     $query = $this->db->query($sql)->result();
    if(!empty($query)){
            return $query;
        }else{
            return false;
        }
}

    //Check if user id exists, return false otherwise
    function getRowPrize(){
        //echo $id;exit;
        // $sql = "SELECT * FROM rowprize WHERE unique_id = '".$unique_id."'";
        $sql = "SELECT rowprize.*,roe_game_stake.Stake,roe_game_stake.Rows FROM rowprize INNER JOIN roe_game_stake ON rowprize.Stake_id=roe_game_stake.id";
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

    function updateRowPrize($id, $row_prize_object_update){
        $this->db->where('id', $id);
        $this->db->update('rowprize', $row_prize_object_update);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            //print_r($this->db->error());
            return false;
        }
    }
    // function getPrizebyId($id)
    // {
    //      $sql = "SELECT * FROM rowprize WHERE id = '".$id."'";
    // }

    //Delete country
     function deleteRowPrize($id)
     {
        
        return $this->dbcommon->deleteRowByID("id", $id, "rowprize");
    }


    function insertIntoRowPrize($aRowPrize) {
        if($this->dbcommon->insertIntoTable("rowprize", $aRowPrize)){
            return true;
        }else{
            return false;
        }
        
    }
}