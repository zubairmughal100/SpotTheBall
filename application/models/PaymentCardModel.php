<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentCardModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getAllPaymentCards(){
        $users = $this->dbcommon->getAll("paymentcard");
        
    }

    function getPaymentCardByUserID($user_id){
        return $this->dbcommon->getAllWhere("paymentcard", "user_id", $user_id);
    }


    function insertIntoPaymentCard($aPaymentCard) {
        if($this->dbcommon->insertIntoTable("paymentcard", $aPaymentCard)){
            return true;
        }else{
            return false;
        }
        
    }
}