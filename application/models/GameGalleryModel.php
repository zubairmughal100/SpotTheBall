<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GameGalleryModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();

        // Load session through controller
		$this->load->library('session');
        
        $this->load->library('dbcommon');
    }
    
    function getAllGallery(){
        return $this->dbcommon->getAll("gamegallery");
        
    }

    function getGalleryImageByID($id){
        $sql = "SELECT * FROM gamegallery WHERE id = ".$id;

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    //Order = "DESC", Order = "ASC", Order = 'RAND()'
    //$live_demo = 'live' or $live_demo = 'demo'
    function getGalleryActivityByUserID($order, $user_id, $live_demo){
        if($order == "RAND()"){
            $sql = "SELECT ia.user_id as userid, COUNT(ia.id) as activity_count, g.* FROM gamegallery g INNER JOIN imageactivity as ia on ia.gamegallery_id = g.id INNER JOIN user as u on u.id = ia.user_id WHERE u.id = ".$user_id." AND move = '".$live_demo."' GROUP BY u.id, ia.gamegallery_id ORDER BY ".$order;
        }else{
            $sql = "SELECT ia.user_id as userid, COUNT(ia.id) as activity_count, g.* FROM gamegallery g INNER JOIN imageactivity as ia on ia.gamegallery_id = g.id INNER JOIN user as u on u.id = ia.user_id WHERE u.id = ".$user_id." AND move = '".$live_demo."' GROUP BY u.id, ia.gamegallery_id ORDER BY g.id ".$order;
        }

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    //Order = "DESC", Order = "ASC", Order = 'RAND()'
    //$live_demo = 'live' or $live_demo = 'demo'
    function getGalleryActivity($order, $live_demo){
        if($order == "RAND()"){
            $sql = "SELECT ia.user_id as userid, COUNT(ia.id) as activity_count, g.* FROM gamegallery g INNER JOIN imageactivity as ia on ia.gamegallery_id = g.id INNER JOIN user as u on u.id = ia.user_id WHERE g.move = '".$live_demo."' GROUP BY u.id, ia.gamegallery_id ORDER BY ".$order;
        }else{
            $sql = "SELECT ia.user_id as userid, COUNT(ia.id) as activity_count, g.* FROM gamegallery g INNER JOIN imageactivity as ia on ia.gamegallery_id = g.id INNER JOIN user as u on u.id = ia.user_id WHERE g.move = '".$live_demo."' GROUP BY u.id, ia.gamegallery_id ORDER BY g.id ".$order;
        }
        

        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }


    //Get a unique image from the gallery which have not been used by this user already more than the specified frequency by in settings
    function getUniqueGalleryImageByUserID($order, $user_id, $live_demo){
        if($order == "RAND()"){
            //$sql = "SELECT ia.user_id as userid, COUNT(ia.id) as activity_count, g.* FROM gamegallery g INNER JOIN imageactivity as ia on ia.gamegallery_id = g.id INNER JOIN user as u on u.id = ia.user_id WHERE g.move = '".$live_demo."' GROUP BY u.id, ia.gamegallery_id ORDER BY ".$order;
            $sql = "SELECT ia.user_id as userid, COUNT(DISTINCT g.id) as image_id_count, COUNT(ia.id) as activity_count, g.* FROM gamegallery g LEFT JOIN imageactivity ia ON ia.gamegallery_id = g.id WHERE g.move = '".$live_demo."' AND g.status != '0' GROUP BY g.id, ia.user_id ORDER BY g.id ".$order;
        }else{
            $sql = "SELECT ia.user_id as userid, COUNT(DISTINCT g.id) as image_id_count, COUNT(ia.id) as activity_count, g.* FROM gamegallery g LEFT JOIN imageactivity ia ON ia.gamegallery_id = g.id WHERE g.move = '".$live_demo."' AND g.status != '0' GROUP BY g.id, ia.user_id ORDER BY g.id ".$order;
        }


        $query = $this->db->query($sql)->result();
        //print_r($query);exit;
        if(!empty($query)){
            $hasData = false;
            foreach ($query as $key => $image) {
                if(($image->userid == $user_id && $image->activity_count <= $image->img_frequency) ||
                    ($image->userid != $user_id && $image->activity_count <= $image->img_frequency)){
                    $data[] = array(
                        "id" => $image->id,
                        "title" => $image->title,
                        "description" => $image->description,
                        "challenge_img_url" => $image->challenge_img_url,
                        "x_value" => $image->x_value,
                        "y_value" => $image->y_value,
                        "solution_img_url" => $image->solution_img_url,
                        "tags" => $image->tags,
                        "img_mode" => $image->img_mode,
                        "game_type" => $image->game_type,
                        "date_added" => $image->date_added,
                        "img_frequency" => $image->img_frequency,
                        "admin_id" => $image->admin_id,
                        "status" => $image->status,
                        "move" => $image->move,
                        "total_games_played" => $image->activity_count,
                        "total_wins" => $this->totalWinLosCount("win", $image->id),
                        "total_lose" => $this->totalWinLosCount("lose", $image->id)
                    );
                    if($hasData == false){
                        $hasData = true;
                    }
                }
            }
            if($hasData){
                return json_decode(json_encode($data));
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


    function getDetailedGallery($demo_live){
        $sql = "select g.*, count(ic.gamegallery_id) As activity_count from gamegallery g left join imageactivity ic on g.id=ic.gamegallery_id WHERE move = '".$demo_live."' group by g.id,g.title";
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return json_decode(json_encode($this->prepareDetailedGallery($query)));
        }else{
            return false;
        }
    }
    function prepareDetailedGallery($gallery){
        if($gallery != false){
            
            foreach ($gallery as $key => $image) {
                $data[] = array(
                    "id" => $image->id,
                    "title" => $image->title,
                    "description" => $image->description,
                    "challenge_img_url" => $image->challenge_img_url,
                    "x_value" => $image->x_value,
                    "y_value" => $image->y_value,
                    "solution_img_url" => $image->solution_img_url,
                    "tags" => $image->tags,
                    "img_mode" => $image->img_mode,
                    "game_type" => $image->game_type,
                    "date_added" => $image->date_added,
                    "img_frequency" => $image->img_frequency,
                    "admin_id" => $image->admin_id,
                    "status" => $image->status,
                    "move" => $image->move,
                    "total_games_played" => $image->activity_count,
                    "total_wins" => $this->totalWinLosCount("win", $image->id),
                    "total_lose" => $this->totalWinLosCount("lose", $image->id)
                );
            }
            return $data;
        }
    }

    // Get ImageGallery Record
    function galleryImageRecordById($img_id){
        $sql = "SELECT * FROM gamegallery WHERE id=".$img_id;
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    function totalWinLosCount($win_lose, $activity_id){

        if($win_lose == "win"){
            $sql = "SELECT * FROM imageactivity WHERE win = '1' AND gamegallery_id = " .$activity_id;
        }else if($win_lose == "lose"){
            $sql = "SELECT * FROM imageactivity WHERE lose = '1' AND gamegallery_id = " .$activity_id;
        }else{
            return false;
        }

        //echo $sql;
        

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return count($query);
        }else{
            return 0;
        }
    }


    //Check if user id exists, return false otherwise
    function galleryImageExistsByID($id){
        $sql = "SELECT * FROM gamegallery WHERE id = ".$id;

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
    
    function updateGalleryImage($id, $game_image_object_update){
        $this->db->where('id', $id);
        $this->db->update('gamegallery', $game_image_object_update);

        if($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0){
            return true;
        }else{
            print_r($this->db->error());
            return false;
        }
    }


    function deleteImage($id){
        $this->db->where('id', $id);
        $this->db->delete('gamegallery');
        if ( $this->db->affected_rows() == '1' ) {
            return TRUE;
        }else{
            return FALSE;
        }
    }


    function insertIntoGameGallery($anImage) {
        if($this->dbcommon->insertIntoTable("gamegallery", $anImage)){
            return true;
        }else{
            return false;
        }
        
    }
}