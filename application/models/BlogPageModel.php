<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BlogPageModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getBlog(){
        //return $this->dbcommon->getAllOrderBy('blogpage', 'date_created', 'DESC');
        $sql = "SELECT * FROM blogpage WHERE is_draft = '0'";
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

    function getBlogByID($whereValue){
        return $this->dbcommon->getAllWhere("blogpage", "id", $whereValue);
    }


    function getBlogByIDPublished($id){
        $sql = "SELECT * FROM blogpage WHERE id = '".$id."' AND is_draft = '0'";
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


    function getBlogsByPublicStatus($is_public) {
        $sql = "SELECT * FROM blogpage WHERE is_public = '".$is_public."' AND is_draft = '0' ORDER BY date_created DESC";
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


    //Update settings
    function updateBlog($id, $blog_object){
        $this->db->where('id', $id);
        $this->db->update('blogpage', $blog_object);
        //print_r($this->db->error());exit;
        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }


    function insertIntoBlogPage($aBlog) {
        if($this->dbcommon->insertIntoTable("blogpage", $aBlog)){
            return true;
        }else{
            return false;
        }
        
    }


    //Delete country
    function deleteBlog($id){
        return $this->dbcommon->deleteRowByID("id", $id, "blogpage");
    }
    
}