<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getAllAdmins(){
        return $this->dbcommon->getAll("admin");
    }
    function getAdminByID($id){
        $sql = "SELECT * FROM admin WHERE id = " .$id;

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }


    //Check if user id exists, return false otherwise
    function addressExistsByID($id){
        $sql = "SELECT * FROM address WHERE id = ".$id;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
		//print_r($query);
		if(!empty($query)){
			return true;
		}else{
			return false;
		}
    }

    function getUserByUsername($username){
        $sql = "SELECT * FROM admin WHERE username = '" .$username. "'";
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


    function verifyUser($username, $password) {
        $md5_password = md5($password);

        $this->db->select('
            id,
            status,
            first_name,
            two_factor_login,
            last_name,
            username,
            user_type')
          ->from('admin')
          ->where("(email = '$username' OR username = '$username')")
          ->where('password', $md5_password);
          $this->db->limit(1);

        $query = $this->db->get()->result();
        //Check if result is not empty
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

   public function getSingleUserById($userid)
   {
       
        $this->db->select('
        id,
        status,
        two_factor_login,
        first_name,
        last_name,
        username,
        user_type')
        ->from('admin')
        ->where("(id = '$userid')");
        $this->db->limit(1);

        $query = $this->db->get()->result();
        //Check if result is not empty
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
   }

    ///////////////////////////////////////////////
    // ALL UPDATE QUERIES GOES UNDER THIS LINE
    ///////////////////////////////////////////////
    
    function updateAddress($id, $address_object_update){
        $this->db->where('id', $id);
        $this->db->update('address', $address_object_update);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }


    function insertIntoAddress($aAddress) {
        if($this->dbcommon->insertIntoTable("address", $aAddress)){
            return true;
        }else{
            return false;
        }
    }


    function insertIntoAdmin($anAdmin) {
        if($this->dbcommon->insertIntoTable("admin", $anAdmin)){
            return true;
        }else{
            return false;
        }
    }
    //Delete the ci_session by session_id
    function deleteAdminAccount($admin_id){
        $this->db->where('id', $admin_id);
        $this->db->delete('admin');

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }
    //Update login activity by user and session id
    function updateAdmin($admin_id, $admin_data){
        $this->db->where('id', $admin_id);
        $this->db->update('admin', $admin_data);

        if($this->db->affected_rows() == 1){
            return true;
        }else{
            //print_r($this->db->error());
            return false;
        }
    }
}