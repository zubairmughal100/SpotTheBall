<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaypalTransactionsModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getAllPayPalTransactions(){
        $users = $this->dbcommon->getAll("paypalransactions");
        
    }


    //Check if user id exists, return false otherwise
    function paypaltransactionsExistsByID($id){
        $sql = "SELECT * FROM paypalransactions WHERE id = ".$id;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
		//print_r($query);
		if(!empty($query)){
			return true;
		}else{
			return false;
		}
    }


    function insertIntoPayPalTransactions($aTransaction) {
        if($this->dbcommon->insertIntoTable("paypalransactions", $aTransaction)){
            return true;
        }else{
            return false;
        }
        
    }
}