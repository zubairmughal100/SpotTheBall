<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BitcoinTransactionsModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getAllBitcoinTransactions(){
        $users = $this->dbcommon->getAll("bitcointransactions");
        
    }


    //Check if user id exists, return false otherwise
    function bitcointransactionsExistsByID($id){
        $sql = "SELECT * FROM bitcointransactions WHERE id = ".$id;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
		//print_r($query);
		if(!empty($query)){
			return true;
		}else{
			return false;
		}
    }


    function insertIntoBitcoinTransactions($aTransaction) {
        if($this->dbcommon->insertIntoTable("bitcointransactions", $aTransaction)){
            return true;
        }else{
            return false;
        }
        
    }
}