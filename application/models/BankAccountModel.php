<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BankAccountModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getAllBankAccounts(){
        $users = $this->dbcommon->getAll("bankaccount");
    }


    //Check if user id exists, return false otherwise
    function accountExistsByID($id){
        $sql = "SELECT * FROM bankaccount WHERE id = ".$id;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
		//print_r($query);
		if(!empty($query)){
			return true;
		}else{
			return false;
		}
    }


    //Update balance
    function updateBalance($new_balance, $id) {
        $sql = "UPDATE bankaccount SET balance = ".$new_balance. " WHERE id = " .$id;
        $this->db->query($sql);
        //echo $sql;

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }


    function insertIntoBankAccount($anAccount) {
        if($this->dbcommon->insertIntoTable("bankaccount", $anAccount)){
            return true;
        }else{
            return false;
        }
    }
}