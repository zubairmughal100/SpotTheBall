<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    ///////////////////////////////////////////////
    // ALL SELECT QUERIES GOES UNDER THIS LINE
    ///////////////////////////////////////////////
    
    function getAllUsers(){
        return $this->dbcommon->getAll("user");
    }


    function getAllUsersLastLoggedIn(){
        $sql = "SELECT u.*,MAX(l.last_seen_datetime) last_seen FROM user u LEFT JOIN loginactivity l ON(u.id=l.user_id) GROUP BY u.id";

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    function getTotalSignupByDate($date){
        $sql = "SELECT COUNT(id) as total FROM user WHERE date_added = '" .$date. "' GROUP BY date_added";
        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query[0]->total;
        }else{
            return false;
        }
    }

    function totalSignupThisMonth(){
        $sql = "SELECT COUNT(id) as total FROM user GROUP BY MONTH(date_added)";

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query[0]->total;
        }else{
            return false;
        }
    }

    function totalSignupThisYear(){
        $sql = "SELECT COUNT(id) as total FROM user GROUP BY YEAR(date_added)";

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query[0]->total;
        }else{
            return false;
        }
    }

    function totalSignupAllTime(){
        $sql = "SELECT COUNT(id) as total FROM user";

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query[0]->total;
        }else{
            return false;
        }
    }
function GetwinRow($id){
        $sql = "SELECT * FROM gameplayedrecord
                WHERE user_id = $id AND win_lost=1 ";
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

    function getUserByUsername($username){
        $sql = "SELECT * FROM user WHERE username = '" .$username. "'";
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

    //Get all banned users
    function getAllBannedUsers(){
        $sql = "SELECT * FROM user WHERE status = '3'";
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

    function getAllActiveUsers(){
        $sql = "SELECT * FROM user WHERE status = '1'";
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

    function getUserById($id){
        $sql = "SELECT * FROM user WHERE id = " .$id. "";
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

    //Get user who have pending documents
    function getUsersWithPendingDocuments(){
        $sql = "SELECT DISTINCT u.* FROM user u INNER JOIN documents as d on d.userid = u.id WHERE d.approved = '0'";

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }



    function getUserAddressBankDocumentsByID($id){
        $user_object = $this->getUserAddressbankByID($id);
        if(!empty($user_object) || $user_object != false){
            //$user_object has data
            $data = array(
                "user_id" => $user_object[0]->user_id,
                "title" => $user_object[0]->title,
                "email" => $user_object[0]->email,
                "username" => $user_object[0]->username,
                "first_name" => $user_object[0]->first_name,
                "last_name" => $user_object[0]->last_name,
                "dob_day" => $user_object[0]->dob_day,
                "dob_month" => $user_object[0]->dob_month,
                "dob_year" => $user_object[0]->dob_year,
                "phone" => $user_object[0]->phone,
                "country_id" => $user_object[0]->country_id,
                "current_level" => $user_object[0]->current_level,
                "status" => $user_object[0]->status,
                "address_id" => $user_object[0]->address_id,
                "address_line1" => $user_object[0]->address_line1,
                "address_line2" => $user_object[0]->address_line2,
                "post_code" => $user_object[0]->post_code,
                "city" => $user_object[0]->city,
                "state" => $user_object[0]->state,
                "country" => $user_object[0]->country,
                "bankaccount_id" => $user_object[0]->bankaccount_id,
                "balance" => $user_object[0]->balance,
                "last_update_date" => $user_object[0]->last_update_date,
                "documents" => $this->dbcommon->getAllWhere("documents", "userid", $user_object[0]->user_id),
                "bankcards" => $this->dbcommon->getAllWhere("paymentcard", "userid", $user_object[0]->user_id)

            );
        }else{
            //$user_object does not have any data
            return false;
        }
    }


    function getUserAddressbankByUsername($username){
        $sql = "SELECT u.id as user_id, u.isDemoAccount, u.title, u.email, u.username, u.first_name, u.last_name, u.dob_day, u.dob_month, u.dob_year, u.phone, u.country_id, u.current_level, u.status, a.id as address_id, a.address_line1, a.address_line2, a.post_code, a.city, a.state, a.country, b.id as bankaccount_id, b.balance, b.last_update_date FROM user u LEFT JOIN address as a on a.user_id = u.id LEFT JOIN bankaccount as b on b.user_id = u.id WHERE u.username = '" .$username. "' LIMIT 1";
        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    function getUserAddressByUsername($username){
        $sql = "SELECT u.id as user_id, u.isDemoAccount, u.balance, u.demo_balance, u.title, u.email, u.username, u.first_name, u.last_name, u.dob_day, u.dob_month, u.dob_year, u.phone, u.country_id, u.current_level, u.status, a.id as address_id, a.address_line1, a.address_line2, a.post_code, a.city, a.state, a.country FROM user u LEFT JOIN address as a on a.user_id = u.id WHERE u.username = '" .$username. "' LIMIT 1";
        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }


    function getUserAddressByID($id){
        $sql = "SELECT u.*, a.id as address_id, a.address_line1, a.address_line2, a.post_code, a.city, a.state, a.country FROM user u LEFT JOIN address as a on a.user_id = u.id WHERE u.id = " .$id. " LIMIT 1";
        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    function getUserAddressbankByID($id){
        $sql = "SELECT u.id as user_id, u.isDemoAccount, u.title, u.email, u.username, u.first_name, u.last_name, u.dob_day, u.dob_month, u.dob_year, u.phone, u.country_id, u.state, u.current_level, u.status, a.id as address_id, a.address_line1, a.address_line2, a.post_code, a.city, a.state, a.country, b.id as bankaccount_id, b.balance, b.last_update_date FROM user u LEFT JOIN address as a on a.user_id = u.id LEFT JOIN bankaccount as b on b.user_id = u.id WHERE u.id = " .$id. " LIMIT 1";
        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    

    function getUserAndbankAccountByUsername($username){
        $sql = "SELECT u.*, b.id as bankaccount_id FROM user u INNER JOIN bankaccount as b on b.user_id = u.id WHERE username = '".$username."'";
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
        $sql = "SELECT id, status, title, two_factor_login,fa_token,first_name, last_name, username FROM user WHERE username = '".$username."' OR email = '".$username."' AND password = '".$md5_password."'";
        //echo "SQL:".$sql;exit;
        //Execute query on db and get result
        $query = $this->db->query($sql)->result();

        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function getSingleUserById($id)
    {
       
        $sql = "SELECT id, status, title,two_factor_login,fa_token, first_name, last_name, username FROM user WHERE id = '".$id."'";
        //echo "SQL:".$sql;exit;
        //Execute query on db and get result
        $query = $this->db->query($sql)->result();

        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function updateTwoFactor($id,$value)
    {
        return $this->db->set('two_factor_login',$value)
                        ->where('id',$id)
                        ->update('user');
    }


    //Check if user id exists, return false otherwise
    function userExistsByID($id){
        $sql = "SELECT * FROM user WHERE id = ".$id;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
		//print_r($query);
		if(!empty($query)){
			return true;
		}else{
			return false;
		}
    }

    //Check if user email exists, return false otherwise
    function userExistsByEmail($email){
        $sql = "SELECT * FROM user WHERE email = '".$email."'";

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
		//print_r($query);
		if(!empty($query)){
			return true;
		}else{
			return false;
		}
    }

    //Check if user username exists, return false otherwise
    function userExistsByUsername($username){
        $sql = "SELECT * FROM user WHERE username = '".$username."'";

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
		//print_r($query);
		if(!empty($query)){
			return true;
		}else{
			return false;
		}
    }


    ///////////////////////////////////////////////
    // ALL UPDATE QUERIES GOES UNDER THIS LINE
    ///////////////////////////////////////////////
    
    //Update balance
    function updateBalance($new_balance, $id) {
        $sql = "UPDATE user SET balance = ".$new_balance. " WHERE id = " .$id;
        $this->db->query($sql);
        //echo $sql;

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }


    function increaseBalance($new_balance, $id){
        $sql = "UPDATE user SET balance = balance + ".$new_balance. " WHERE id = ".$id;
        $this->db->query($sql);
        //echo $sql;

        if($this->db->affected_rows() == 1){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }

    function deductBalance($new_balance, $id){
        $sql = "UPDATE user SET balance = balance - ".$new_balance. " WHERE id = ".$id;
        $this->db->query($sql);
        //echo $sql;

        if($this->db->affected_rows() == 1){

            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }



    function increaseDemoBalance($new_balance, $id){
        $sql = "UPDATE user SET demo_balance = demo_balance + ".$new_balance. " WHERE id = ".$id;
        $this->db->query($sql);
        //echo $sql;

        if($this->db->affected_rows() == 1){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }

    function deductDemoBalance($new_balance, $id){
        $sql = "UPDATE user SET demo_balance = demo_balance - ".$new_balance. " WHERE id = ".$id;
        $this->db->query($sql);
        //echo $sql;

        if($this->db->affected_rows() == 1){

            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }


    function updateAddedBalance($new_balance, $id) {
        $sql = "UPDATE user SET balance = balance + ".$new_balance. " WHERE id = " .$id;
        $this->db->query($sql);
        //echo $sql;

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){

            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }

    function updateNotes($notes, $id) {
        $sql = "UPDATE user SET notes = '".$notes."' WHERE id = " .$id;
        $this->db->query($sql);
        //echo $sql;

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }

    //Update account info
    function updateUserinfo($id, $user_object_update){
       
        $this->db->where('id', $id);
        $this->db->update('user', $user_object_update);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            //echo "successfully updated";
            return true;
        }else{
            //print_r($this->db->error());
            return false;
        }
        //print_r($this->db->error());
    }

    //Update password
    function updatePassword($id, $password){
        $pass = array(
            "password" => $password
        );
        $this->db->where('id', $id);
        $this->db->update('user', $pass);

        if($this->db->affected_rows() == 1){
            return true;
        }else{
            //print_r($this->db->error());
            return false;
        }
    }

    //Update user status
    function updateAccountStatus($status, $id){
        $sql = "UPDATE user SET status = '" .$status. "' WHERE id = " .$id;
        $this->db->query($sql);
        //echo $sql;

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }

    function updateCryptoKey($key, $id){
        $sql = "UPDATE user SET crypto_address = '" .$key. "' WHERE id = " .$id;
        $this->db->query($sql);
        //echo $sql;

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }

    function updateDemoMode($status, $id){
        $sql = "UPDATE user SET isDemoAccount = '" .$status. "' WHERE id = " .$id;
        $this->db->query($sql);
        //echo $sql;

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }

    function updateDemoBalance($balance, $id){
        $sql = "UPDATE user SET demo_balance = '" .$balance. "' WHERE id = " .$id;
        $this->db->query($sql);
        //echo $sql;

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }
    //current balance
    function currentBalance($id)
    {

        $sql = "SELECT balance from user  WHERE id = " .$id;
        $query = $this->db->query($sql)->result();
 
        if(!empty($query)){
            return round($query[0]->balance);
        }else{
            return false;
        }
    }
    function updateAccountStatusByEmail($status, $email){
        $sql = "UPDATE user SET status = '" .$status. "' WHERE email = '" .$email. "'";
        $this->db->query($sql);
        //echo $sql;

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }


    ///////////////////////////////////////////////
    // ALL INSERT QUERIES GOES UNDER THIS LINE
    ///////////////////////////////////////////////

    //Delete country
    function deleteUser($id){
        return $this->dbcommon->deleteRowByID("id", $id, "user");
    }

    function insertIntoUser($aUser) {
        if($this->dbcommon->insertIntoTable("user", $aUser)){
            return true;
        }else{
            return false;
        }
        
    }
}