<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DocumentModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getAllDocuments(){
        $users = $this->dbcommon->getAll("documents");
        
    }


    //Get documents by user id
    function getDocumentsByID($user_id){
        $sql = "SELECT * FROM documents WHERE userid = " .$user_id. "";
        //echo "SQL:".$sql;
        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }


    function updateDocumentStatusByID($status, $id){
        $sql = "UPDATE documents SET approved = '" .$status. "' WHERE id = " .$id;
        $this->db->query($sql);
        //echo $sql;

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }


    function updateDocument($id, $update_object){
        $this->db->where('id', $id);
        $this->db->update('documents', $update_object);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            //print_r($this->db->error());
            return false;
        }
    }


    function insertIntoDocument($aDocument) {
        if($this->dbcommon->insertIntoTable("documents", $aDocument)){
            return true;
        }else{
            return false;
        }
        
    }
}