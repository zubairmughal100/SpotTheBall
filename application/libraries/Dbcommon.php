<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 /**
 * @package			none
 * @description 	Core Library Class for common database queries
 * @author			mull.codes
 * @version			1.0
 * @see				none
 */
 class dbcommon extends CI_Model {

     function __construct(){
        parent::__construct();
		$this->load->database();
     }

    /**
     * @author			mull.codes
     * @method          getAll()
     * @description		fetch all the data from specific table
     * @access			public
     * @param			string $tableName table to query from
     * @return			array or false
     * @see				none
     */
    public function getAll($tableName) {
        $this->db->select('*');
		$this->db->from($tableName);
		$query = $this->db->get()->result();
        
        //Check if result is not empty
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    /**
     * @author			mull.codes
     * @method          getAllOrderBy($tableName, $orderByColumn, $order)
     * @description		fetch all the data from specific table order by specific column in ascending order
     * @access			public
     * @param			string $tableName table to query from
     * @param			string $orderByColumn sort by column
     * @param           string $order asc or desc
     * @return			array or false
     * @see				none
     */
    public function getAllOrderBy($tableName, $orderByColumn, $order) {
        $this->db->select('*');
		$this->db->from($tableName);
		$this->db->order_by($orderByColumn, $order);
		$query = $this->db->get()->result();
        
        //Check if result is not empty
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

     /**
     * @author			mull.codes
     * @method          getAllWhere($tableName, $whereColumn, $whereValue)
     * @description		fetch all the data from specific table conditioned by where clause
     * @access			public
     * @param			string $tableName table to query from
     * @param			string $whereColumn where column
     * @param           string $whereValue where value
     * @return			array or false
     * @see				none
     */
    public function getAllWhere($tableName, $whereColumn, $whereValue){
        $this->db->select('*');
        $this->db->from($tableName);
        $this->db->where($whereColumn, $whereValue);
        $query = $this->db->get()->result();

        //Check if result is not empty
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    /**
     * @author			mull.codes
     * @method          getAllWhere($tableName, $whereColumn, $whereValue)
     * @description		fetch all the data from specific table conditioned by where clause
     * @access			public
     * @param			string $tableName table to query from
     * @param			string $whereColumn where column
     * @param           string $whereValue where value
     * @return			array of user object or false
     * @see				none
     */
    public function validateUser($username, $md5_password){
        /*$this->db->select('id, title, email, username');
        $this->db->from("user");
        $this->db->where("username", $whereValue);
        $this->db->or_where("email", $whereValue);
        $query = $this->db->get()->result();*/

        $this->db->select('
            id,
            status,
            title,
            first_name,
            last_name,
            username')
          ->from('user')
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


    public function getColumns($tableName, $columns){
        $this->db->select($columns);
        $this->db->from($tableName);
        $query = $this->db->get()->result();

        //Check if result is not empty
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    public function getLike($tableName, $likeColumn, $likeValue){
        $this->db->select('*');
        $this->db->from($tableName);
        $this->like($likeColumn, $like);
        $query = $this->db->get()->result();

        //Check if result is not empty
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    public function getLikeArray($tableName, $likeArray){
        $this->db->select('*');
        $this->db->from($tableName);
        $this->like($likeArray);
        $query = $this->db->get()->result();

        //Check if result is not empty
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    //Delete a row
    public function deleteRowByID($columnName, $id, $table){
        $this->db->where($columnName, $id);
        $this->db->delete($table);

        if($this->db->affected_rows() == 1){
            return true;
        }else{
            return false;
        }
    }

    //Exists by name
    public function existsByColumn($table, $columnName, $columnValue){
        $sql = "SELECT * FROM " .$table. " WHERE " .$columnName. " = '" .$columnValue. "'";
        //echo "SQL: " .$sql;exit;
        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return true;
        }else{
            return false;
        }
    }


    /**
     * @author			mull.codes
     * @method          insertIntoTable($tableName, $data)
     * @description     fetch all the data from specific table
     * @access			public
     * @param			string $tableName table to query from
     * @param           string $data array of object/s
     * @return			true or false
     * @see				none
     */
    public function insertIntoTable($tableName, $data) {
        $this->db->insert($tableName, $data);
		if($this->db->affected_rows() == 1){
			return true;
		}else{
			return false;
		}
    }
     
 }