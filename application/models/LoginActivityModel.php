<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class LoginActivityModel extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
	}

	//Get all records that are x minutes old and status of 1
	function getOnlineUsers($minutes, $is_timed, $limit){
		if($is_timed){
			$sql = "SELECT la.*, u.* FROM loginactivity la INNER JOIN user as u on u.id = la.user_id WHERE login_date_time >= now() - interval " .$minutes. " minute AND session_status = '1' LIMIT " .$limit;
		}else{
			$sql = "SELECT la.*, u.* FROM loginactivity la INNER JOIN user as u on u.id = la.user_id WHERE session_status = '1' LIMIT " .$limit;
		}
		

		$query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
	}


	//Get a user's last active result
	function getLastActive($user_id){
		$sql = "SELECT * FROM loginactivity WHERE user_id = " .$user_id. " ORDER BY last_seen_datetime DESC LIMIT 1";

		$query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
	}


	//Check same ip address login
	//Returns true or false
	function isLoggedInSameIp($user_id, $get_object){
		$sql = "SELECT * FROM loginactivity WHERE user_id = " .$user_id. " AND session_status = '1'";
		//echo $sql;exit;
		$query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
        	if($get_object == true){
        		return $query;
        	}else{
        		return true;
        	}
        }else{
            return false;
        }
	}


	//Update login activity by user and session id
	function updateLoginSession($user_id, $session_id){
		$this->db->where('user_id', $user_id);
		$this->db->where('session_id', $session_id);

		//Update last last_seen_datetime
		$activity_data = array(
			"last_seen_datetime" => date("Y-m-d H:i:s")
		);

        $this->db->update('loginactivity', $activity_data);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            //print_r($this->db->error());
            return false;
        }
	}


	//Expire a user login activity
	function expireLoginActivity($user_id, $session_id){
		$this->db->where('user_id', $user_id);
		$this->db->where('session_id', $session_id);
		//Update last last_seen_datetime
		$activity_data = array(
			"logout_date_time" => date("Y-m-d H:i:s"),
			"session_status" => "0"
		);

        $this->db->update('loginactivity', $activity_data);

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            //print_r($this->db->error());
            return false;
        }
	}


	//Insert into login activity
	function insertLoginActivity($anActivity){
		if($this->dbcommon->insertIntoTable("loginactivity", $anActivity)){
            return true;
        }else{
            return false;
        }
	}
}



////////////////////////////////////////////
// Pre-populate data
////////////////////////////////////////////
// 
////////////////////////////////////////////

/*
 INSERT INTO `loginactivity` (`session_id`, `last_seen_datetime`, `logout_date_time`, `activity_type`, `ip_address`, `user_agent`, `user_id`, `session_status`) VALUES ('dsfsdfsdfsdfsdfsdfsdfsdfsdf', '2020-02-12 21:39:59', NULL, 'login', '::1', 'Chrome', '20200124146793', '1'), ('fcgvdfgdsfgdfgdfg', '2020-02-12 21:25:00', NULL, 'login', '::1', 'Chrome', '20200124809236', '1'), ('fdgdfgdfgfdgdfg', '2020-02-12 21:30:00', NULL, 'login', '::1', 'Chrome', '20200124146793', '1'), ('gfhfghfghfghfghfghfghfgh', '2020-02-12 21:30:00', NULL, 'login', '::3', 'Chrome', '20200124809236', '1'), ('sadasdasdasdsadsadsad', '2020-02-12 21:39:59', NULL, 'login', '::1', 'Firefox', '20200124809236', '1'), ('sdfsdfsdf', '2020-02-12 23:20:39', NULL, 'login', '::1', 'Chrome', '20200124146793', '1'), ('sdsdfsdfsdfsdfsdfsdfsdfdsf', '2020-02-12 21:35:00', NULL, 'login', '::3', 'Chrome', '20200124809236', '1'), ('vgcxvgvsdfsdfsdfsdfsdfdsf', '2020-02-12 21:39:59', NULL, 'login', '::2', 'Chrome', '20200124809236', '1')
*/