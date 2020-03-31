<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StripeTransactionsModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getAllStripeTransactions(){
        $users = $this->dbcommon->getAll("stripetransactions");
        
    }


    //Check if user id exists, return false otherwise
    function stripetransactionsExistsByID($id){
        $sql = "SELECT * FROM stripetransactions WHERE id = ".$id;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
		//print_r($query);
		if(!empty($query)){
			return true;
		}else{
			return false;
		}
    }


    function insertIntoStripeTransactions($aTransaction) {
        if($this->dbcommon->insertIntoTable("stripetransactions", $aTransaction)){
            return true;
        }else{
            return false;
        }
        
    }
}