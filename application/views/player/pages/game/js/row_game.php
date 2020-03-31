<?php
    defined('BASEPATH') OR exit("ooops, we are sorry. It's not you, it's us! Please use the back navigation button to go back.");

    ////////////////////////////////////////////////////////////////////////////////////////
    // LOAD ASSETS
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->helper( 'url' );
    $assets = base_url() . "assets/";
    $cssbase = base_url() . "assets/css/";
    $jsbase = base_url() . "assets/js/";

    $base = base_url() . index_page();
    ////////////////////////////////////////////////////////////////////////////////////////


?>
<!-- <script type="text/javascript">
	var canvas = document.getElementById('imageCanvas');
    var ctx = canvas.getContext('2d');

    // Fill Background
    ctx.fillStyle = "black";
	ctx.fillRect(0,0,canvas.width, canvas.height);

	// Font Colouring
    ctx.font = "50px Arial";
	ctx.fillStyle = "red";
	// ctx.textAlign= "center";
	ctx.fillText("Click Confirm", 205, 115);
	ctx.fillText("To Play Now", 215, 160);
	ctx.font = "35px Arial";
	ctx.fillText("Strake : ", 250, canvas.height/2);
	ctx.beginPath();
	// Box
	ctx.rect(380, 173, 125, 40);
	ctx.fillStyle = "red";
	ctx.fill();
	// 100 Text
	ctx.fillStyle = "black";
	ctx.fillText("100", 410, canvas.height/2);

	var balance = <?php // echo $live_balance; ?>;
	var strake = <?php // echo $max_stake; ?>;
	// Check Credit For Play
	$("#check_credit").click(function(event){
	  if(balance > strake){
	  	alert("Success");
	  }{
	  	alert("You don't have credit to Play");
	  }

	});
	// Code For Confirmation
	$(document).ready(function(){

        var canvas = document.getElementById('imageCanvas');
        var ctx = canvas.getContext('2d');
 		
        });
</script> -->