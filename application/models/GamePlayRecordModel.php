<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GamePlayRecordModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();
        
        $this->load->library('dbcommon');
    }
    
    function getAllGamePlayRecord(){
        $gameplay = $this->dbcommon->getAllOrderBy("gameplayedrecord", "billed", "DESC");
        //print_r($countries);
        if(!empty($gameplay)){
            return $gameplay;
        }else{
            return false;
        }
    }


    function getLast24HoursRecordsByUserId($game_type ,$user_id){
        $sql = "SELECT * FROM gameplayedrecord gpr WHERE gpr.date_played > DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND gpr.win_lost = '1' AND gpr.game_type = '".$game_type."' AND gpr.user_id = ".$user_id. " LIMIT 1";
        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }


    //Get highest score order by number_of_rows
    function highestByNumberOfRows($limit){
        //$sql = "select g.*, SUM(g.billed) AS total_amount, COUNT(g.user_id) as total_games from gameplayedrecord g group by g.user_id order by g.date_played desc, number_of_rows_won desc limit " .$limit;
        $sql = "select g.*, SUM(g.billed) AS total_amount, COUNT(g.user_id) as total_games from gameplayedrecord g group by g.user_id order by g.number_of_rows_won desc limit " .$limit;
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


    function getTopWinnerGamePlayedRecordByDate($date, $limit){
        $sql = "select g.*, SUM(g.billed) AS total_amount, COUNT(g.user_id) as total_games from gameplayedrecord g WHERE date_played = '" .$date. "' AND g.win_lost = 'y' group by g.user_id order by g.billed desc limit " .$limit;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }



    function getTopLoserGamePlayedRecordByDate($date, $limit){
        $sql = "select g.*, SUM(g.billed) AS total_amount, COUNT(g.user_id) as total_games from gameplayedrecord g WHERE date_played = '" .$date. "' AND g.win_lost = 'n' group by g.user_id order by g.billed desc limit " .$limit;

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
    function getGamePlayedRecordByID($id){
        $sql = "SELECT name FROM gameplayedrecord WHERE id = ".$id;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
		//print_r($query);
		if(!empty($query)){
			return $query;
		}else{
			return false;
		}
    }


    //Check if country id exists, return false otherwise
    function gamePlayedRecordExistsByID($id){
        return $this->dbcommon->existsByColumn("gameplayedrecord", "id", $id);
    }

    //Delete country
    function deleteGamePlayedRecord($id){
        return $this->dbcommon->deleteRowByID("id", $id, "gameplayedrecord");
    }

    function insertIntoGamePlayedRecord($aGamePlay) {
        if($this->dbcommon->insertIntoTable("gameplayedrecord ", $aGamePlay)){
            return true;
        }else{
            return false;
        }
    }
}