<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StakeRowsModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    function SaveStakes($Stake,$Rows)
	{
	$query="insert into roe_game_stake(`Stake`, `Rows`) values('$Stake','$Rows')";
	if($this->db->query($query)){
            return true;
        }else{
            return false;
        }
	}
	function getStake(){
  $this->db->select("id,Stake,Rows,Status"); 
  $this->db->from('roe_game_stake');
  $query = $this->db->get();
  return $query->result();
}
function UserStake($stake)
{
 
  $query = $this->db->get_where('roe_game_stake', array('id' => $stake));
  return $query->result();
}
function getStakesActive()
{
 
	$query = $this->db->get_where('roe_game_stake', array('Status' => 'on'));
	return $query->result();
}
function update_stake($id,$data)
{
  $this->db->where('id', $id);
        $this->db->update('roe_game_stake', $data);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            //print_r($this->db->error());
            return false;
        }
}
}