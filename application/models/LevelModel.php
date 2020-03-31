<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LevelModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getAllGallery(){
        $users = $this->dbcommon->getAll("level");
        
    }

    function getlevelorderByAsc(){
        return $this->dbcommon->getAllOrderBy("level", "id", "ASC");
    }

    function getAllLevels(){
        $sql = "SELECT * FROM level ORDER BY level_number ASC";

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    function getLevelByID($id){
        $sql = "SELECT * FROM level WHERE id = ".$id;

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return json_decode(json_encode($query));
        }else{
            return false;
        }
    }

    function getAllLevelsByStatus($status){
        $sql = "SELECT * FROM level WHERE status = '" .$status. "' ORDER BY level_number ASC";

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }


    function getLastlevelNumber(){
        $sql = "SELECT level_number FROM level ORDER BY level_number DESC limit 1";

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
    
    function updateLevel($id, $level_object_update){
        $this->db->where('id', $id);
        $this->db->update('level', $level_object_update);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }

    function deleteLevel($id){
        $this->db->where('id', $id);
        $this->db->delete('level');
        if ( $this->db->affected_rows() == '1' ) {
            return TRUE;
        }else{
            return FALSE;
        }
    }


    function insertIntoGameLevel($aLevel) {
        if($this->dbcommon->insertIntoTable("level", $aLevel)){
            return true;
        }else{
            return false;
        }
        
    }
}