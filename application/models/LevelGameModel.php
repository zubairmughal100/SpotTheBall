<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LevelGameModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getAllLevelGames(){
        $users = $this->dbcommon->getAll("levelgame");
        
    }

    function getTheLevelGame(){
        $sql = "SELECT * FROM levelgame WHERE id = 1 LIMIT 1";

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
    
    // function updateRowGame($id, $row_game_update){
    //     $this->db->where('id', $id);
    //     $this->db->update('rowgame', $row_game_update);

    //     if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
    //         return true;
    //     }else{
    //         print_r($this->db->error());
    //         return false;
    //     }
    // }


    // function insertIntoRowGame($aRowGame) {
    //     if($this->dbcommon->insertIntoTable("rowgame", $aRowGame)){
    //         return true;
    //     }else{
    //         return false;
    //     }
        
    // }
}