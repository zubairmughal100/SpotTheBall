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


    ////////////////////////////////////////////////////////////////////////////////////////
    // HTML OPEN TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/headers/html/html_tag_open');

    ////////////////////////////////////////////////////////////////////////////////////////
    // HEAD OPEN TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/headers/html/header_head_tag_open');

    ////////////////////////////////////////////////////////////////////////////////////////
    // HEAD CSS, LINKS, TITLE, META TAG
    ////////////////////////////////////////////////////////////////////////////////////////
	$this->load->view('player/essentials/headers/css/header_head_css_links');
	$this->load->view('player/pages/myaccount/css/tel_input');

    ////////////////////////////////////////////////////////////////////////////////////////
    // HEAD CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/headers/html/header_head_tag_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY OPEN TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/body_tag_open');

    ////////////////////////////////////////////////////////////////////////////////////////
    // <MAIN NAV OPEN TAG>
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/main_nav_open');

    ////////////////////////////////////////////////////////////////////////////////////////
    // MAIN NAV
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/main_nav');

    ////////////////////////////////////////////////////////////////////////////////////////
    // </MAIN NAV CLOSE TAG>
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/main_nav_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // MAIN CONTENT OPEN TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    //Enable this for game look
    //$this->load->view('player/essentials/body/body_main_content_start');
    //Enable this for vanilla look
    $this->load->view('player/essentials/body/body_main_vanilla_content_start');

    $cursor = "".$assets."cursor/game_crosshair.cur";
    

?>

<style type="text/css">
    .timer-wrapper p {
                font-weight: 700;
                color: red;
            }
            .whole-box-wrapper {
    overflow: hidden;
}
.box-wrapper {
    width: 713px;
    height: 415px;
    border: 15px solid red;
    background-color: black;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.black-box h3 {
    color: white;
    font-size: 40px;
}
.black-box div {
    font-size: 40px;
    color: white;
}
.black-box div select {font-size: 20px;width: 21%;
    margin-left: 61%;
        margin-top: -6%;
    height: 51px;;}
.black-box {
    text-align: center;
}
    .custom-btn-green {
        background-color: #03FE01 !important;
        color: #fff;
        font-weight: 800;
        font-size: 1.8rem;
        text-shadow: 1px 1px #016e00;
        border-radius: 20px;
    }
    .custom-btn-green:hover {
        color: #fff;
    }
    .custom-btn-green:disabled,
    .custom-btn-green[disabled]{
      border: 1px solid #000;
      background-color: #cccccc;
      color: #000;
    }
    canvas:hover {
        cursor: url(<?php echo $cursor; ?>),auto;
    }
</style>

    <!-- Main component for a primary marketing message or call to action -->
    <div class="game game_content">
                    <div class="game_container">
                        <div class="row">
                            <div class="col-md-8" style="    margin-left: -1%;">
                                <div class="row">
                                    <div class="col-md-3">
                                        <!-- Active Level Bar -->
                                        <div class="player_level_progress" style="border-radius: 20px;color: #02A3E9;text-align: center;border-style: solid;border-width: 5px;padding-top: 5px;">
                                <font size="3"><h3 class="level_on">0 of<span id="test"> <?php echo $number_of_row; ?></span></h3></font>  
                            </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="player_game_time text-center game-info">
                                            <div class="timer-wrapper">
                                                <p class="countdown" style="font-size: 2.4rem;"><?php echo $game_timer; ?>.00</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="text-center" id="Message"style="font-weight: bold; font-size: 2.4rem;">
                                                         <p class="balance">
                                                            <span id="Currentbalance"><?php echo $balance;?></span>
                                                        </p>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-3">
                                    <div class="player_game_time text-center game-info" >
                                        <div class="timer">
                                            <p>Time</p>
                                            <hr>
                                            <p class="countdown"><?php //echo $game_timer; ?>.00</p>
                                        </div>
                                    </div>
                                    </div> -->
                                    <div class="col-md-3">
                                    <div class="player_add_credit game-info">
                                <a href="<?php echo $base; ?>/account/addfund" style="height:55px;    width: 109%;" class="btn btn-block btn-custom-addcredit">Add Credits</a>
                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    

                        <div class="game_holder">
                            <div class="play_game">
                                <div class="row">
                                    <div class="col-md-8">
                                        <br>
                            <!-- Canvas For Game Play -->
                            
                                           <div id="outterdiv" style="border: 19px solid red;cursor:none;">
                                               <div id="spot-the-ball-demo" style="background-color: black; height: 127%;"></div>
                                           </div> 
                            <div id="test1"class="black-box" style="background-color: black;border: 19px solid red;height: 100%;width: 100%;">
                                     <h3 style="margin-top: 10%;">Click Confirm<br> To Play Now</h3>
                              <div  style="    margin-left: -26%">
                                                Stake :
                                    <select  onchange="check(event)" name="sss" id="Stake_Row" class="form-control">
                            
                              <option value="" selected disabled>Select a <b style="color: black;">Stake</b></option>
                                <?php foreach ($ActiveStakes as $key => $ActiveStakes) { ?>
                                    <option value="<?php echo $ActiveStakes->Rows; ?>" name="<?php echo $ActiveStakes->Rows; ?>" <?php if($default_stake == $ActiveStakes->id){
                                        echo 'selected="selected"';
                                    } ?>><?php echo $ActiveStakes->Stake; ?></option>
                                <?php } ?>
                            
                        </select>
                        <div >
                                            <div class="btnConfirmGame" style= "   margin-left: 42%;
    margin-bottom: 10%;
    margin-top: 10px;
}">
                                                <!-- i class="glyphicon glyphicon-arrow-right" style="font-size: 4rem; position: absolute; margin-left: -73px; color: red; top:15px;"></i> -->
                                                <!-- Button To Check Credit For Stake Play -->
                                                <button style="    margin-left: 2%;width: 38%;margin-bottom: 10%; margin-bottom: 10px;" type="button" id="check_credit" class="btn custom-btn-green btn-lg">Confirm</button>
                                                <!-- <i class="glyphicon glyphicon-arrow-left" style="font-size: 4rem; position: absolute; margin-left:8px; color:red; top:15px;"></i> -->
                                            </div>

                                            <div class="btnContinueGame d-none">
                                                <!-- Continue button -->
                                                <!-- <i class="glyphicon glyphicon-arrow-right" style="font-size: 4rem; position: absolute; margin-left: -73px; color: red; top:15px;"></i> -->
                                                <button type="button" id="btnContinue" class="btn custom-btn-green btn-lg" onclick="continuegame();">Continue</button>
                                                <!-- <i class="glyphicon glyphicon-arrow-left" style="font-size: 4rem; position: absolute; margin-left:8px; color:red; top:15px;"></i> -->
                                            </div>
                                        </div>
                    </div>
          </div>
                            <!-- <canvas id="imageCanvas" width="713" height="405" style="border:15px solid red; border-radius:5px;width:100%;">
                            </canvas> -->
                            
                            <div class="text-center game_message d-none" id="MessageDiv" style="width: 733px; background-color: red; padding: 10px;margin: 10px 0 0 0; border-radius: 5px;width:100%;">
                                <div style="background-color: black; width: 80%; margin: auto; padding: 0px; border-radius: 5px;">
                                    <!--<button type="button" id="btnContinue" class="btn btn-success" onclick="continuegame();">Continue</button>-->
                                    <div class="d-none" id="lose_message" style=" color: yellow; font-weight: 800; font-size: 2rem;">YOU LOSE</div>
                                    <div class="d-none" id="win_message " style=" color: yellow; font-weight: 800; font-size: 2rem;">SUPER</div>
                                </div>
                            </div>
                          
                            
                            <!--<div class="stake_holder d-none">
                                  <div class="confirm_game">
                                      <div class="col-md-12 text-center">
                                          
                                          
                                        <div id="lose_message" style="display: none;">YOU LOSE</div>
                                        <div id="win_message" style="display: none;">SUPER</div>
                                      </div>
                                  </div>
      
                                  <div class="stake">
                                      <form>
                                          <div class="form-group row">
                                              <label for="inputStake" class="col-sm-5 col-form-label text-right">Stake</label>
                                              <div class="col-sm-3">
                                                <input type="text" class="form-control" id="inputStake" placeholder="" value="100">
                                              </div>
                                          </div>
                                          <div class="form-group row">
                                              <label for="inputPayout" class="col-sm-5 col-form-label text-right">Payout</label>
                                              <div class="col-sm-3">
                                                <input type="text" class="form-control" id="inputPayout" placeholder="" value="88">
                                              </div>
                                          </div>
                                          <div class="form-group row">
                                              <label for="inputReturn" class="col-sm-5 col-form-label text-right">Return</label>
                                              <div class="col-sm-3">
                                                <input type="text" readonly class="form-control" id="inputReturn" placeholder="" value="188">
                                              </div>
                                          </div>
                                        </form>
                                  </div>
                            </div>-->
                                      <!--<div class='zoom-img'>
                                        <img id="map" src="<?php //echo $assets ?>game_images/empty/image.jpg">
                                      </div>-->
                                      <!-- <img id="zoomable" class="pic" src="<?php //echo $assets ?>game_images/empty/image.jpg" alt="" /> -->
                                    </div>


                                    <!-- Zoom Settings -->
                                    <!-- <div class="col-md-2">
                                        <div class="zoom">
                                            <div class="btn-group-wrap">
                                                <div class="btn-group">
                                                    <p class="zoom-text">Zoom Settings</p>
                                                </div>
                                              </div>
                                            <div class="btn-group-wrap">
                                                <div class="btn-group btn-toggle">
                                                    <input type="hidden" value="off" id="btnState">
                                                    <button class="btn btn-lg btn-default" style="border: 1px solid #0069D9; position:relative; margin-right:-5px;">ON</button>
                                                    <button class="btn btn-lg btn-primary active" style="border: 1px solid #0069D9; position:relative; margin-left:-5px; color:#fff;">OFF</button>
                                                  </div>
                                            </div>

                                        </div>
                                    </div> -->

                                </div>
                            </div>

                        </div>
                    </div>
    </div>


<?php
    ////////////////////////////////////////////////////////////////////////////////////////
    // JS Here
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/pages/game/js/row_game');
    ////////////////////////////////////////////////////////////////////////////////////////
    // FOOTER CONTENT
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/footers/html/footer_content');
?>

<!-- Modal -->
<div class="modal fade" id="winningmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php
    ////////////////////////////////////////////////////////////////////////////////////////
    // MAIN CONTENT CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
	$this->load->view('player/essentials/body/body_main_content_end');
	
	////////////////////////////////////////////////////////////////////////////////////////
    // Load JavaScript, Jquery File here
	////////////////////////////////////////////////////////////////////////////////////////
	$this->load->view('player/pages/myaccount/js/multi_step_js');
?>
<script type="text/javascript">
    function check(event)
    {
        Rows = event.target.value;
        $('#test').html(" "+Rows);
         max_stake = $("#Stake_Row option:selected").html();
        // alert(stakes);
    }
///Update stakes
// function SetRowValue()
// {
//     $default=$("#sss").val();
//    $.ajax({
// url : "",
//     type : 'post',
//     data : {
//         'Stake' : $default
//     },
//     dataType:'json',
//     success : function(response) {              
//         var uname = response[0].Rows;
//         $('#test').html(uname);
//     },
//     error : function(request,error)
//     {
//         alert("hello");
//     }

//     });
// }



$("#spot-the-ball-demo").hide();
$("#outterdiv").hide();

       // Global Variables
        // var canvas = document.getElementById('imageCanvas');
        // var ctx = canvas.getContext('2d');
        // var ctx_ball = canvas.getContext('2d');
        var Rows = 0;
        var img_id = 0;
        var img_x = 0;
        var img_y = 0;
        var img_url = 0;
        var username = "<?php echo $username; ?>";
        var max_stake = 0;
        var user_id = <?php echo $user_id; ?>;
        var level_on = 0;
       


        //Control paint on a canvas
        var has_paint = false;
        //Control Image loading
        var image_loaded = false;

        //Check is a game has been started
        var game_in_progress = false;


        //Global x and y
        var canvas_x;
        var canvas_y;

        //Control debugging
        var debug = false;

        //Current user balance on page load
        var current_balance = <?php echo $balance; ?>;
        var TestBal         = 0;
        startGame();


        //Check windows refresh
        $(window).bind('beforeunload',function(event){
            //Check if game_in_progress is set to true
            event.preventDefault();
            if(game_in_progress){
                //save info somewhere
                return 'Leaving this page will result in losing all progress, are you sure you want to leave?';
                //$('#exampleModalCenter').modal('show');
            }
            // event.preventDefault();
            // $('#exampleModalCenter').modal('show');
        });
// 

       /**********************************
        -----------Main Code---------
        **********************************/
        function main(results){
            //Canvas created
            // drawcanvas();
            //Check Balance
            $("#check_credit").click(function(event){
                 max_stake = $("#Stake_Row option:selected").html();
                 $("#outterdiv").show();
                //Set game_in_progress = true
                //adding status to db of user
                $("#test1").hide();
                Rows=$('#Stake_Row').val();
                document.getElementById("Stake_Row").disabled = true;
              TestBal = $("#Currentbalance").html();
              deductBalance();
            // inserUsergaeStatus();
                game_in_progress = true;
                //level_on = 1;
                $(".level_on").text(level_on + " of " + Rows);
                document.getElementById("check_credit").disabled = true;

                $("#btnContinue").text("Continue");
                //Disable continue button
                $('#btnContinue').prop("disabled",true);

                //document.getElementById("btnContinue").disabled = false;
                timeCounter();
                if(checkBalance()){

                    if(debug == true){
                        console.log('Player allowed to play');
                          // checkBalance();
                        
                    }
                    
                    $('.btnConfirmGame').addClass('d-none');
                    $('.btnContinueGame').removeClass('d-none');
                    $('.game_message').addClass('d-none');
                    //$('#lose_message').removeClass('d-none');
                    //$('#lose_message').text('INSUFFICIENT BALANCE');
                    createImage(results);

                }else{
                    $("#outterdiv").hide();
                    $('.game_message').removeClass('d-none');
                    $('#lose_message').removeClass('d-none');
                    $('#lose_message').text('INSUFFICIENT BALANCE');
                    if(debug == true){
                        console.log('Not enough balance');
                    }
                    
                }
            });
        }

        var interval;

        // HTML Time Counter
        function timeCounter(){
            var timer2 = "<?php echo $game_timer; ?>:00";
            interval = setInterval(function() {
              var timer = timer2.split(':');
              //by parsing integer, I avoid all extra string processing
              var minutes = parseInt(timer[0], 10);
              var seconds = parseInt(timer[1], 10);
              --seconds;
              minutes = (seconds < 0) ? --minutes : minutes;
              if (minutes < 0) clearInterval(interval);
              seconds = (seconds < 0) ? 59 : seconds;
              seconds = (seconds < 10) ? '0' + seconds : seconds;
              //minutes = (minutes < 10) ?  minutes : minutes;
              $('.countdown').html(minutes + ':' + seconds);
              timer2 = minutes + ':' + seconds;
              if(timer2 < "0:01"){
                // Update Record if player lose
                $('.countdown').html("0:00");
                var response = {"message":"timeout"};
                updateGamePlayRecord(response, '0', level_on);
                current_balance = current_balance - max_stake;
                        //Update new balance on UI
                        $(".balance").text( current_balance + '');

                        //$("#btnContinue").text("You Lose");
                        
                        $('.btnConfirmGame').removeClass('d-none');
                        $('.btnContinueGame').addClass('d-none');

                        $('.game_message').removeClass('d-none');
                        $('#lose_message').removeClass('d-none');
                        $('#lose_message').text('YOU LOSE');

                        document.getElementById("Stake_Row").disabled = false;
                        document.getElementById("btnContinue").disabled = true;
                        // const context = canvas.getContext('2d');
                        // context.clearRect(0, 0, canvas.width, canvas.height);
                        // drawcanvas();
                        // $('#spot-the-ball-demo').text("you lose");
                        // document.getElementById("slecetConfrm").style.display = "block";
                        clearInterval(interval);
                        // $("#spot-the-ball-demo").html("<h1 style='color:red;'>Lose</h1>");
                        // document.getElementById("slecetConfrm").style.display = "block";
                // deductBalance(response);
              }
              // console.log(timer2);
            }, 1000);
            // console.log(interval);
        }

        function playNextImage(results){
            if(checkBalance()){
                if(debug == true){
                    console.log('Player allowed to play');
                }
                createImage(results);
            }else{
                if(debug == true){
                    $('#lose_message').text('YOU LOSE');
                   console.log('Not enough balance'); 
                }
            }
        }

        //console.log(uniqueImage);

        /**********************************
        ----------Get Unique Image--------
        **********************************/
        //var results;
        function startGame(){
            // console.log('hello');
            var results = null;
            return $.ajax({
                url: "<?php echo $base; ?>/game/getGalleryAjax",
                type: "get",
                dataType: 'json',
                success: function (response) {
                    
                    if(debug){
                        console.log("Response: " + response['message']);
                    }
                    if(response['message'] == "no_data"){
                        drawcanvasblack("GAME OFFLINE!");
                        $('#lose_message').text("GAME OFFLINE!");
                    }else if(response['message'] == "unauthorized"){
                        drawcanvasblack("UNAUTHORIZED ACCESS, PLEASE LOGIN!");
                        $('#lose_message').text("UNAUTHORIZED ACCESS!");
                    }else{
                        results = response;
                        main(results);
                    }
                    //You will get response from your PHP page (what you echo or print)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   if(debug == true){
                        console.log(textStatus, errorThrown);
                   }
                }
            }).done(function(response){
                //console.log(response);
                results = response;
                //console.log(results);
            });
            //console.log(results);
            //hello();
            //return results;
        }

        //Check balance
        function checkBalance(){
            // Check condition he can play or not, balance
            debugger;
            var balance = TestBal;

            console.log(balance);
            var stake = max_stake;
            console.log(stake);
            var boolean = false;
            // Check Credit For Play 1
            // if(current_balance<0){
            //     boolean = false;
            //     clearInterval(interval);
            // }
            if(parseInt(balance, 10)>= parseInt(stake, 10)){
                boolean = true;
            }else{
                boolean = false;
                clearInterval(interval);
            }
            return boolean;
        }
        //##################################\\
        // function for Create image
        //by using spotthe ball library
        //*###################################
        function createImage(gallery_images){
            let cursorWidth = parseInt(<?php echo $general_settings[0]->cursor_size; ?>);
// 

            image_loaded = true;
            //console.log(gallery_images);
            //console.log(gallery_images['id']);
            var img = new Image();
            img_id = gallery_images['id'];
            img_x = gallery_images['x_value'];
            img_y = gallery_images['y_value'];
            img_url = gallery_images['challenge_img_url'];
            img.src = '<?php echo $assets; ?>game_images/gallery/'+img_url;

            img.onload = function(){
                (function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

var SpotTheBall = require('./spot-the-ball');

new SpotTheBall(document.getElementById('spot-the-ball-demo'), {
  size: {x: 750, y: 500, ball: cursorWidth},
  solution: {x: img_x, y: img_y},
  challengeImage: img.src,
  solutionImage: img.src,
  heatMap: [{"x":668,"y":458,"weight":0.6},{"x":607,"y":471,"weight":0.44},{"x":551,"y":450,"weight":0.59},{"x":566,"y":472,"weight":0.32},{"x":619,"y":453,"weight":0.67},{"x":640,"y":457,"weight":0.32},{"x":636,"y":434,"weight":0.28},{"x":603,"y":415,"weight":0.3},{"x":605,"y":397,"weight":0.4},{"x":649,"y":393,"weight":0.8},{"x":638,"y":411,"weight":0.26},{"x":688,"y":408,"weight":0.27},{"x":714,"y":407,"weight":0.41},{"x":716,"y":453,"weight":0.72},{"x":713,"y":475,"weight":0.96},{"x":698,"y":476,"weight":0.55},{"x":659,"y":480,"weight":0.67},{"x":594,"y":481,"weight":0.83},{"x":538,"y":477,"weight":0.37},{"x":499,"y":454,"weight":0.82},{"x":485,"y":471,"weight":0.59},{"x":482,"y":449,"weight":0.97},{"x":459,"y":480,"weight":0.22},{"x":459,"y":466,"weight":0.31},{"x":444,"y":435,"weight":0.24},{"x":423,"y":469,"weight":0.4},{"x":404,"y":450,"weight":0.61},{"x":383,"y":480,"weight":0.97},{"x":343,"y":480,"weight":0.92},{"x":348,"y":423,"weight":0.98},{"x":351,"y":425,"weight":0.66},{"x":382,"y":425,"weight":0.42},{"x":485,"y":417,"weight":0.96},{"x":517,"y":417,"weight":0.98},{"x":562,"y":366,"weight":0.49},{"x":567,"y":405,"weight":0.7},{"x":552,"y":347,"weight":0.63},{"x":610,"y":349,"weight":0.51},{"x":560,"y":335,"weight":0.57},{"x":557,"y":370,"weight":0.33}]
});
},{"./spot-the-ball":2}],2:[function(require,module,exports){
/*!
 * spot-the-ball.js v1.0.1
 * http://tomyouds.github.io/spot-the-ball.js
 *
 * Copyright (c) 2014 Tom Youds
 * Licensed under the MIT license
 */

(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define([], function () {
      return (root.returnExportsGlobal = factory());
    });
  } else if (typeof exports === 'object') {
    // Node. Does not work with strict CommonJS, but
    // only CommonJS-like enviroments that support module.exports,
    // like Node.
    module.exports = factory();
  } else {
    root['SpotTheBall'] = factory();
  }
}(this, function () {

  var GUESS_COLORS = [
    'skyblue',
    'yellow',
    'orange'
  ];

  var SVG = function(el) {
    var elem = new SVG.Element('svg', el);
    el.appendChild(elem.node);
    return elem;
  };

  var supportsSVG = function() {
    return !!document.createElementNS && !!document.createElementNS('http://www.w3.org/2000/svg', 'svg').createSVGRect;
  };

  var camelCase = function(s) {
    return s.toLowerCase().replace(/-(.)/g, function(m, g) {
      return g.toUpperCase();
    });
  };

  var localStorageKey = function(id, prefix) {
    if (prefix == null) {
      prefix = 'spot-the-ball';
    }

    return prefix + '.' + id;
  };

  var eventCoordinates = function(event) {
    x = event.clientX;
    y = event.clientY;

    if (webkit_mouse_bug44083 === 1 || (webkit_mouse_bug44083 === 0 && detectWebkitBug44083())) {
      x = event.pageX;
      y = event.pageY;
    }

    return {x: x, y: y};
  };

  // Safari bug getScreenCTM ignores scrolling
  // https://bugs.webkit.org/show_bug.cgi?id=44083
  // https://github.com/mbostock/d3/issues/1903
  // https://github.com/mbostock/d3/blob/d6598447cc972385fc34ca10f542fc53ad174183/src/event/mouse.js
  var webkit_mouse_bug44083 = /WebKit/.test(navigator.userAgent) ? 0 : -1;

  var detectWebkitBug44083 = function() {
    if (window.scrollX || window.scrollY) {
      var svg = SVG(document.body).style({
        position: 'absolute',
        top: 0,
        left: 0,
        margin: 0,
        padding: 0,
        border: 'none'
      });

      var ctm = svg.node.getScreenCTM();
      document.body.removeChild(svg.node);
      webkit_mouse_bug44083 = !(ctm.f || ctm.e) ? 1 : -1;
      return webkit_mouse_bug44083;
    }

    webkit_mouse_bug44083 = 0;
    return webkit_mouse_bug44083;
  };
  // SVG helper functions based on svg.js API
  SVG.Element = function(name, parent, nonSvg) {
    if (nonSvg) {
      this.node = document.createElement(name);
    }
    else {
      this.node = document.createElementNS('http://www.w3.org/2000/svg', name);
    }
    this.parent = parent;
  };

  SVG.Element.prototype.attr = function(attributes, value) {
    if (typeof attributes === 'object') {
      for (var v in attributes) {
        this.attr(v, attributes[v]);
      }
    }
    else {
      this.node.setAttribute(attributes, value.toString());
    }

    return this;
  };

  SVG.Element.prototype.style = function(attributes, value) {
    applyCSS(this.node, attributes, value);

    return this;
  };

  var applyCSS = function(node, attributes, value) {
    if (typeof attributes === 'object') {
      for (var v in attributes) {
        applyCSS(node, v, attributes[v]);
      }
    }
    else {
      node.style[camelCase(attributes)] = value;
    }
  };

  SVG.Element.prototype.image = function(src) {
    var elem = new SVG.Element('img', this, true);
    elem.attr({src: src, width: '100%'});
    elem.style({position: 'absolute', top: 0, left: 0});
    this.node.parentNode.appendChild(elem.node);
    return elem;
  };

  SVG.Element.prototype.circle = function(size) {
    var elem = new SVG.Element('circle');
    var radius = size/2;
    elem.attr({r: radius});
    this.node.appendChild(elem.node);
    return elem;
  };

  SVG.Element.prototype.rect = function(w, h) {
    var elem = new SVG.Element('rect');
    elem.attr({width: w, height: h});
    this.node.appendChild(elem.node);
    return elem;
  };

  SVG.Element.prototype.text = function(content) {
    var elem = new SVG.Element('text');
    var tspan = new SVG.Element('tspan');
    tspan.node.appendChild(document.createTextNode(content));
    elem.node.appendChild(tspan.node);
    this.node.appendChild(elem.node);
    return elem;
  };

  SVG.Element.prototype.group = function() {
    var elem = new SVG.Element('g');
    this.node.appendChild(elem.node);
    return elem;
  };

  SVG.Element.prototype.hide = function() {
    return this.style('opacity', '0');
  };

  SVG.Element.prototype.show = function() {
    return this.style('opacity', '1');
  };

  SVG.Element.prototype.on = function(event, func) {
    this.node.addEventListener(event, func);
  };

  SVG.Element.prototype.move = function(x, y) {
    this.attr({cx: x, cy: y});
  };
  function SpotTheBall(element, options) {
    if (supportsSVG()) {
      this.element = element;
      this.options = options || {};

      // Scale font-size based on viewBox width
      this.fontSize = 0.021333333*options.size.x;

      // Block all actions after guess is made
      this.complete = false;

      applyCSS(this.element, {
        'padding-top': (this.options.size.y/this.options.size.x)*100 + '%',
        width: '100%',
        display: 'block',
        height: 'auto',
        position: 'relative'
      });

      this.preloadImages(function() {
        // Create SVG elements
        this.createElements();

        // Add heatmap
        this.addHeatMap();

        if (this.options.id && localStorage.getItem(localStorageKey(this.options.id))) {
          var savedGuess = JSON.parse(localStorage.getItem(localStorageKey(this.options.id)));
          this.focus();
          this.makeGuess(savedGuess.guess.x, savedGuess.guess.y, true);
        }

        // Display bootstrapped guesses
        this.guesses = [];

        if (this.options.guesses) {
          this.options.guesses.forEach(function(guess, i) {
            this.displayGuess(guess.x, guess.y, GUESS_COLORS[i%GUESS_COLORS.length], false);
          }, this);
        }

        this.element.className = (this.element.className + ' ' + (this.complete ? 'complete' : 'incomplete')).trim();

        // Listen for events
        this.eventListeners();
      }.bind(this));
    }
    else {
      element.innerHTML = 'You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to play.';
    }
  }

  SpotTheBall.prototype = {
    createElements: function() {
      // Clear root element
      this.element.textContent = '';

      this.container = SVG(this.element).attr({
        viewBox: '0 0 ' + this.options.size.x + ' ' + this.options.size.y
      });

      this.container.style({
        width: '100%',
        height: '100%',
        position: 'absolute',
        top: 0,
        left: 0,
        overflow: 'hidden',
        // cursor: 'pointer'
      });


      this.challengeImage = this.container.image(this.options.challengeImage, this.options.size.x, this.options.size.y).attr('class', 'challenge');
      this.solutionImage = this.container.image(this.options.solutionImage, this.options.size.x, this.options.size.y).attr('class', 'solution').hide();

      // Fix for moving images on opacity change
      [this.challengeImage, this.solutionImage].forEach(function(img) {
        img.style({
          '-webkit-backface-visibility': 'hidden',
          'backface-visibility': 'hidden',
          '-webkit-transform': 'rotate(0)',
          'transform': 'rotate(0)'
        });
      });

      this.element.appendChild(this.challengeImage.node);
      this.element.appendChild(this.solutionImage.node);

      this.element.appendChild(this.container.node);

      this.heatMap = this.container.group().attr('class', 'heat-map').style({opacity: 0});

      this.cursor = this.container.circle(this.options.size.ball-8).attr({
        'class': 'cursor',
        fill: 'none',
        'stroke-width': '8',
        stroke: 'purple',
        opacity: 0.75,
        cx: this.options.size.x/2,
        cy: this.options.size.y/2
      }).hide();

      this.overlay = this.container.group().attr('class', 'overlay');
      this.overlay.rect(this.options.size.x, this.options.size.y).attr({fill: '#000', opacity: 0.5});

      var label;

      if(('ontouchstart' in window) || (window.DocumentTouch && document instanceof DocumentTouch)) {
        label = 'Touch where you think the ball is';
      }
      else {
        label = 'Click where you think the ball is';
      }


      this.addLabel({x: this.options.size.x/2, y: this.options.size.y/2, 'text-anchor': 'middle', 'alignment-baseline': 'middle'}, label, this.overlay);
    },

    preloadImages: function(next) {
      // Preload images
      var preloadChallenge = document.createElement('img');
      var preloadSolution = document.createElement('img');
      var loaded = 0;

      var preloaded = function() {
        loaded++;
        if (loaded >= 2) {
          next();
        }
      };

      preloadChallenge.onload = preloaded;
      preloadSolution.onload = preloaded;

      preloadChallenge.src = this.options.challengeImage;
      preloadSolution.src = this.options.solutionImage;
    },


    eventListeners: function() {
      this.container.on('mousemove', (function(event) {
        if (this.complete) return;

        this.focus();

        var point = this.scalePoint(eventCoordinates(event));

        this.cursor.move(point.x, point.y);
      }).bind(this));

      this.container.on('mouseleave', this.blur.bind(this));
      // this.container.on('mouseenter', this.focus.bind(this));

      this.container.on('touchstart', (function(event) {
        if (this.complete) return;
        window.clearTimeout(this.resetTimer);
        this.removeConfirmBox();
        this.focus();

        var point = this.scalePoint(eventCoordinates(event.touches[0]));
        this.cursor.move(point.x, point.y);

        event.preventDefault();
      }).bind(this));

      this.container.on('touchmove', (function(event) {
        if (this.complete) return;

        var point = this.scalePoint(eventCoordinates(event.touches[0]));
        this.cursor.move(point.x, point.y);

        event.preventDefault();
      }).bind(this));

      this.container.on('touchend', (function(event) {
        if (this.complete) return;

        var point = this.scalePoint(eventCoordinates(event.changedTouches[0]));
        this.cursor.move(point.x, point.y);

        // Moved out of view
        if (point.x < 0 || point.y < 0 || point.x > this.options.size.x || point.y > this.options.size.y) {
          return this.blur();
        }

        // Add a confirm label for touch
        if (point.x < this.options.size.x/2) {
          // Right
          pos = {x: point.x+(this.options.size.ball/2)+20, y: point.y, 'text-anchor': 'start'};
        }
        else {
          // Left
          pos = {x: point.x-(this.options.size.ball/2)-20, y: point.y, 'text-anchor': 'end'};
        }

        this.removeConfirmBox();

        this.confirmBox = this.container.group();

        this.addLabel(pos, 'Tap here to confirm guess', this.confirmBox);

        // Bind all touch events for confirm box
        this.confirmBox.on('touchstart', function(event) {
          event.stopPropagation();
          event.preventDefault();
        });

        this.confirmBox.on('touchmove', function(event) {
          event.stopPropagation();
          event.preventDefault();
        });

        this.confirmBox.on('touchend', (function(event) {
          this.makeGuess(point.x, point.y);
          this.container.node.removeChild(this.confirmBox.node);
          this.confirmBox = null;
        }).bind(this));


        // Reset if guess not confirmed after 10s
        this.resetTimer = window.setTimeout((function() {
          this.removeConfirmBox();
          this.blur();
        }).bind(this), 10000);

        event.preventDefault();
      }).bind(this));


      this.container.on('click', (function(event) {
        if (this.complete) return;
        this.focus();

        point = this.scalePoint(eventCoordinates(event));

        this.makeGuess(point.x, point.y);
      }).bind(this));
    },

    removeConfirmBox: function() {
      if (this.confirmBox) {
        this.container.node.removeChild(this.confirmBox.node);
        this.confirmBox = null;
      }
    },

    scalePoint: function(point) {
      var svgPoint = this.container.node.createSVGPoint();
      svgPoint.x = point.x;
      svgPoint.y = point.y;

      svgPoint = svgPoint.matrixTransform(this.container.node.getScreenCTM().inverse());

      return {x: svgPoint.x, y: svgPoint.y};
    },

    focus: function() {
      if (this.complete) return;
      this.overlay.hide();
      this.cursor.show();
    },

    blur: function() {
      if (this.complete) return;
      this.overlay.show();
      this.cursor.hide();
    },

    heatSpot: function(spot) {
      // this.heatMap.circle(this.options.size.ball).attr({cx: spot.x, cy: spot.y, fill: 'white', opacity: Math.min((spot.weight*2 || 1), 1)});
    },

    addHeatMap: function() {
      if (this.options.heatMap && this.options.heatMap.length) {
        this.options.heatMap.forEach(this.heatSpot, this);
      }
    },

    calculateDistance: function(x, y) {
      return Math.round(Math.sqrt(Math.pow(this.options.solution.x-x, 2)+Math.pow(this.options.solution.y-y, 2)));
    },

    makeGuess: function(x, y, previous) {
      if (this.complete) return;

      var guess = {x: x, y: y};

      // Check accuracy
      var distance = this.calculateDistance(x, y);

      var correct = distance < this.options.size.ball;

      // Show solution
      this.solutionImage.show();

      this.container.style({
        cursor: 'default'
      });

      this.complete = true;

      this.heatMap.style({opacity: 0.75});
      continuegame(img_x,img_y,x,y);
      if (this.guesses && this.guesses.length) {
        this.guesses.forEach(function(guess) {
          guess.style({opacity: 1});
        });
      }

      // Display actual guess
      this.displayGuess(guess.x, guess.y, correct ? 'limegreen' : 'red', true);

      if (previous) {
        this.container.attr('class', 'complete');
        return;
      }

      // Store guess in localStorage
      if (this.options.id) {
        localStorage.setItem(localStorageKey(this.options.id), JSON.stringify({guess: guess, distance: distance}));
      }

      if (this.options.onGuess) this.options.onGuess.call(this, guess, distance);
    },

    displayGuess: function(x, y, color, cursor) {
      if (cursor) {
        this.cursor.attr({
          'class': 'guess',
          cx: x,
          cy: y
        }).style('stroke', color);
      }
      else {
        this.guesses.push(this.container.circle(this.options.size.ball-8).attr({
          'class': 'guess',
          fill: 'none',
          'stroke-width': '8',
          stroke: color,
          opacity: 0.75,
          cx: x,
          cy: y
        }).hide());
      }
    },

    addLabel: function(pos, text, container) {
      if (!container) {
        container = this.container;
      }

      var labelText  = container.text(text).attr({'font-size': this.fontSize, fill: '#FFF', 'dominant-baseline': 'central'}).attr(pos);

      var labelBox = labelText.node.getBBox();

      container.rect(labelBox.width+28, labelBox.height+20).attr({
        fill: 'black',
        opacity: 0.75,
        x: labelBox.x-14,
        y: labelBox.y-10,
        rx: 5,
        ry: 5
      });

      container.node.appendChild(labelText.node);
    }
  };

  return SpotTheBall;


}));

},{}]},{},[1]);


//End of library

//##############################################
            }
            
            clearInterval(interval);
            timeCounter();
            if(debug == true){
                console.log("Image_X: " + gallery_images['x_value'] + " Image_Y: " + gallery_images['y_value']);
            }
            //ctx_circle.arc(gallery_images['x_value'],gallery_images['y_value'],20,0,2*Math.PI);
        }


        // function reDrawImage(){
        //     let cursorWidth = parseInt(<?php echo $general_settings[0]->cursor_size; ?>);

        //     var img = new Image();

        //     img.src = '<?php echo $assets; ?>game_images/gallery/'+img_url;

        //     img.onload = function(){
        //         ctx.drawImage(img,0,0,713,405);

        //         if(debug == true){
        //             // Draw Circle on Click
        //             var ctx_circle = canvas.getContext("2d");
        //             ctx_ball = ctx_circle;
        //             ctx_circle.beginPath();
        //             ctx_circle.strokeStyle = "red";
        //             ctx_circle.lineWidth   = 1;
        //             ctx_circle.arc(img_x,img_y, cursorWidth, 0, 2 * Math.PI);
        //             ctx_circle.stroke();
        //         }
        //     }
        // }


        
        //###############################################
        //function for when game is complete and user won 
        //###############################################
        function createImageGameComplete(){
            // TestBal = $("#Currentbalance").html();
             // alert(TestBal);
            alert("YOU HAVE WON!");
            // $('#winningmodal').modal('show')
            // document.body.style.backgroundColor = "yellow";
            document.getElementById("Stake_Row").disabled = false;
           
            // $('#spot-the-ball-demo').html('<h1>WIN</h1>');
            // document.getElementById("slecetConfrm").style.display = "block";
            $('.btnConfirmGame').removeClass('d-none');
            $('.btnContinueGame').addClass('d-none');
            clearInterval(interval);
            //timeCounter();
        }


//#######################################
//function for playAgain if user win or lose
//#######################################
        function playAgain(){
            var results = null;
            $.ajax({
                url: "<?php echo $base; ?>/game/getGalleryAjax",
                type: "get",
                dataType: 'json',
                success: function (response) {
                    if(debug){
                        console.log("Response: " + response['message']);
                    }
                    if(response['message'] == "no_data"){
                        drawcanvasblack("GAME OFFLINE!");
                        $('#lose_message').text("GAME OFFLINE!");
                    }else if(response['message'] == "unauthorized"){
                        drawcanvasblack("UNAUTHORIZED ACCESS, PLEASE LOGIN!");
                        $('#lose_message').text("UNAUTHORIZED ACCESS!");
                    }else{
                        results = response;
                        playNextImage(results);
                    }

                    //You will get response from your PHP page (what you echo or print)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   if(debug == true){
                        console.log(textStatus, errorThrown);
                   }
                }
            });
        }



        
        // @ Start @ //
        // On Mouse Click for Circle
        // canvas.addEventListener('mousedown', function(e) {
        //     getCursorPosition(canvas,img_id, e);
        // });

        function diff (num1, num2) {
          if (num1 > num2) {
            return (num1 - num2);
          } else {
            return (num2 - num1);
          }
        };
        /*********************************/
        //calculating distance for matching
        /**********************************/
        function dist(x1, y1, x2, y2) {
          var deltaX = diff(x1, x2);
          var deltaY = diff(y1, y2);
          var dist = Math.sqrt(Math.pow(deltaX, 2) + Math.pow(deltaY, 2));
          return (dist);
        };
/*********************************************************************************
this function chek all the credentials with save dataand show massages win or lose
/*********************************************************************************/
        function continuegame(img_x,img_y,x,y){
            //has_paint = false;
            // Get Distance
            var a = canvas_x - canvas_y;
            var b = img_x - img_y;
            //var c = Math.sqrt( a*a + b*b );
            var c = dist(img_x, img_y, x, y)
            // check Credentials Through AJAX
            // 
            //img_x = gallery_images['x_value'];
            //img_y = gallery_images['y_value'];
            
            //canvas_x = x;
            //canvas_y = y;

            if(debug == true){
                console.log("Distance: " + c);
            }

            $.ajax({
                url: "<?php echo $base; ?>/Game/Check_cordinates_rowgame",
                type: "post",
                data: {"distance" : c, "img_id": img_id, "user_id" : user_id, "max_stake" : max_stake, "username" : username, "img_url" : img_url} ,
                success: function (response) {
                    if(response == "win"){
                        //level_on must be updated immediately
                        level_on++;


                        // game completion
                        var isTrue = gameComplete();
                        if(debug){
                            if(isTrue){
                                console.log("Game has been completed, user has won!");
                            }else{
                                console.log("Continueing game!");
                            }
                        }
                        if(isTrue){
                            //end game

                            // TestBal = $("#Currentbalance").html();
                            createImageGameComplete();
                        }else{
                            $("#MessageDiv").show();
                            var message = "WELL DONE";
                            if( level_on === 1 ){
                                message = '<?php echo $row_game_messages[0]->message; ?>';
                            }else if( level_on === 2 ){
                                message = '<?php echo $row_game_messages[1]->message; ?>';
                            }else if( level_on === 3 ){
                                message = '<?php echo $row_game_messages[2]->message; ?>';
                            }else{
                               message = '<?php echo $row_game_messages[2]->message; ?>';
                            }

                            $('.game_message').removeClass('d-none');
                            $('#lose_message').removeClass('d-none');
                            $('#lose_message').text(message);

                            
                            if(debug){
                                console.log("Current Row: " + level_on);
                            }
                            $(".level_on").text(level_on + " of " + Rows);
                            playAgain();

                            return false; //For good fortune
                            // pictureload(response);
                        }
                        
                    }
                    else{
                        image_loaded = false;
                        let number_of_rows_won = level_on;
                        TestBal = $("#Currentbalance").html();
                        level_on = 0;
                        var delayInMilliseconds = 4000;
                        $("#MessageDiv").show();
                        $('.btnConfirmGame').removeClass('d-none');
                        $('.btnContinueGame').addClass('d-none');
                         // $("#Currentbalance").html(current_balance);
                        $('.game_message').removeClass('d-none');
                        $('#lose_message').removeClass('d-none');
                        $('#lose_message').text('YOU LOSE');
                        $(".level_on").text(level_on + " of "+Rows);
                        setTimeout(function() {
                        updateGamePlayRecord(response, '0', number_of_rows_won);
                        // (response);
                       // playAgain();
                        //Update new balance on UI
                        // $(".balance").text(current_balance + '');

                        //$("#btnContinue").text("You Lose");
                        
                        

                        document.getElementById("btnContinue").disabled = true;
                        // const context = canvas.getContext('2d');
                        // context.clearRect(0, 0, canvas.width, canvas.height);
                        // drawcanvas();
                        // $('#spot-the-ball-demo').text("you lose");
                        document.getElementById("Stake_Row").disabled = false;
                        clearInterval(interval);

                        }, delayInMilliseconds);
                        //get current balance
                        
                            return false;
                        
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   if(debug == true){
                        console.log(textStatus, errorThrown);
                   }
                }
            });
            $('#btnContinue').prop("disabled",true);
        }


        //Get mouse cursor
        // function getCursorPosition(canvas, img_id, event) {
        //     // if(has_paint == fals){
        //     //     console.log("Player allowed to create circle");
        //     // }else{
        //     //     console.log("Player not allowed to create circle");
        //     // }
            
        //     //reDrawImage();
            
        //     console.log("Image X: " + img_x);
        //     console.log("Image Y: " + img_y);

        //     if(image_loaded == true){
        //         //if(has_paint == false){
        //             //has_paint = true;
        //             const rect = canvas.getBoundingClientRect();
        //             const x = event.clientX - rect.left;
        //             const y = event.clientY - rect.top;


        //             // Draw Circle on Click
        //             var ctx = canvas.getContext("2d");



        //             let cursorWidth = parseInt(<?php  ?>);

        //             //Clear previous arc
        //             ctx.strokeStyle = "rgba(255, 255, 255, 0.7)";
        //             ctx.lineWidth   = cursorWidth;
        //             ctx.beginPath();
        //             ctx.arc(canvas_x,canvas_y,cursorWidth,0,2*Math.PI);
        //             ctx.fillStyle = "rgba(255, 255, 255, 0.7)";
        //             ctx.fill();
        //             ctx.stroke();
                    



        //             canvas_x = x;
        //             canvas_y = y;

                    

        //             //ctx.save();
                    

        //             ctx.strokeStyle = "red";
        //             ctx.lineWidth   = cursorWidth;
        //             ctx.beginPath();
        //             ctx.arc(x,y,cursorWidth,0,2*Math.PI);
        //             ctx.fillStyle = "red";
        //             ctx.fill();
        //             ctx.stroke();


        //             //context.restore();
        //             // This continue is for automatic
        //             // continuegame();
                    
        //             $('#btnContinue').prop("disabled",false);

        //            if(debug == true){
        //                 console.log("x: " + canvas_x + " y: " + canvas_y);
        //            }
        //         }
        //     //}
        // } //getCursorPosition End

        

        /**********************************
        -------Update Game PlayRecord-----
        **********************************/
        function updateGamePlayRecord(res, win_lost, number_of_rows_won){
            document.getElementById("check_credit").disabled = false;
            // $("#spot-the-ball-demo").html("");
            $("#spot-the-ball-demo").hide();
            $("#Currentbalance").html(current_balance);
            $("#outterdiv").hide();
            $("#MessageDiv").hide();
            $("#test1").show();
            $("#check_credit").text("Play Again");
            // $("#lose_message").show();
            //Call ajax
            if(debug){
                console.log("Sending Row Number to Script: " + number_of_rows_won);
            }
            $.ajax({
                url: "<?php echo $base; ?>/game/updateGamePlayRecords",
                type: "post",
                // dataType: 'json',
                data:{"billed_amount":max_stake,"type":"row","x": img_x,"y":img_y, "win_lost":win_lost, "number_of_rows_won":number_of_rows_won, "number_of_rows_won_out_of": Rows},
                success: function (response) {
                    // Message For Update Game Record
                    if(response == "success"){
                        // alert("Update Successfully record");
                        if(debug == true){
                            console.log("Update Successfully");
                        }
                    }else if(response == "unauthorized"){
                        //alert("Not authorized");
                        if(debug == true){
                            console.log("Not authorized");
                        }
                        //Refresh or redirect user to appropriate page
                    }else{
                        if(debug == true){
                            console.log("Could not update record");
                        }
                        //alert("Could not update record");
                    }
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   if(debug == true){
                        console.log(textStatus, errorThrown);
                   }
                }
            });
        }

        function increaseBalance(res){
            //Call ajax
            $.ajax({
                url: "<?php echo $base; ?>/game/increaseBalance",
                type: "post",
                // dataType: 'json',
                data:{"billed_amount":max_stake},
                success: function (response) {
                    // Message For Update Game Record
                    if(response == "success"){
                        //alert("Update Successfully");
                        if(debug == true){
                            console.log("Update Successfully");
                        }
                    }else if(response == "unauthorized"){
                        //alert("Not authorized");
                        if(debug == true){
                            console.log("Not authorized");
                        }
                        //Refresh or redirect user to appropriate page
                    }else{
                        if(debug == true){
                            console.log("Could not update record");
                        }
                        //alert("Could not update record");
                    }
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   if(debug == true){
                        console.log(textStatus, errorThrown);
                   }
                }
            });
        }
/**************************************************************\
deductbalce at the start of the game when user click on continue
/***************************************************************/
        function deductBalance(){
            debugger;
            if(current_balance < max_stake  || max_stake > current_balance)
            {
                $("#Currentbalance").html(current_balance)
                $('#lose_message').text('YOU LOSE');
            }
            else{
            //Call ajax
            $.ajax({
                url: "<?php echo $base; ?>/game/deductBalance",
                type: "post",
                // dataType: 'json',
                data:{"billed_amount":max_stake},
                success: function (response) {
                    // Message For Update Game Record
                    $("#Currentbalance").html(response);
                    // current_balance = $("#Currentbalance").html();
                    current_balance = $("#Currentbalance").html();
                    if(!response == ""){
                        // alert("Update Successfully cradit");
                        if(debug == true){
                            console.log("Update Successfully");
                        }
                    }else if(response == "unauthorized"){
                        //alert("Not authorized");
                        if(debug == true){
                            console.log("Not authorized");
                        }
                        //Refresh or redirect user to appropriate page
                    }else{
                        if(debug == true){
                            console.log("Could not update record");
                        }
                        //alert("Could not update record");
                    }
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   if(debug == true){
                        console.log(textStatus, errorThrown);
                   }
                }
            });
        }
        }

        /**********************************
        -----------Game Complete---------
        **********************************/
        function gameComplete(){
            image_loaded = false;
            if(debug){
                console.log("Row Number [gameComplete()]: " + level_on);
            }
            if(level_on == Rows){
                let number_of_rows_won = level_on;
                // document.getElementById("slecetConfrm").style.display = "block";
                level_on = 0;
                document.getElementById("check_credit").disabled = false;
                $("#check_credit").text("Play Again");
                clearInterval(interval);
                document.getElementById("btnContinue").disabled = true;
                $(".level_on").text(level_on + " of " + Rows);
                var res = null;
                updateGamePlayRecord(res, 1, number_of_rows_won);
                $.ajax({
                    url: "<?php echo $base; ?>/game/updateGameWin",
                    type: "post",
                    // dataType: 'json',
                    data:{"billed_amount":max_stake},
                    success: function (response) {
                        // Message For Update Game Record
                        // alert('Gamecomplete');
                     if(debug == true){
                        console.log("Bill Updated");   
                     }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                       if(debug == true){
                            console.log(textStatus, errorThrown);
                       }
                    }
                });   
                return true;          
            }else{
                return false;
            }
        }

        
        /**********************************
        -------------Draw Canvas-----------
        **********************************/
        function drawcanvas(){
            //Draw canvas
        
            // Fill Background
            ctx.fillStyle = "black";
            ctx.fillRect(0,0,canvas.width, canvas.height);

            // Font Colouring
            ctx.font = "50px Arial";
            ctx.fillStyle = "white";
            ctx.textAlign= "center";
            ctx.fillText("Click Confirm", canvas.width/2, (canvas.height/2)-30);
            ctx.fillText("To Play Now", canvas.width/2, (canvas.height/2)+25);
            ctx.font = "50px Arial";
            ctx.fillText("Stake : ", (canvas.width/2)-85, (canvas.height/2)+85);
            ctx.beginPath();
            // Box
            ctx.rect((canvas.width/2), (canvas.height/2)+48, 180, 48);
            ctx.fillStyle = "red";
            ctx.fill();
            // 100 Text
            ctx.fillStyle = "black";
            ctx.fillStyle = "white";
            ctx.fillText(max_stake, (canvas.width/2) + 97, (canvas.height/2) + 89);
        
        }

        function drawcanvasblack(message){
            //Draw canvas
        
            // Fill Background
            ctx.fillStyle = "black";
            ctx.fillRect(0,0,canvas.width, canvas.height);

            // Font Colouring
            ctx.font = "50px Arial";
            ctx.fillStyle = "white";
            ctx.textAlign= "center";
            //ctx.fillText("YOU HAVE WON", canvas.width/2, (canvas.height/2)-30);
            ctx.fillText(message, canvas.width/2, (canvas.height/2)+25);
            // ctx.font = "50px Arial";
            // ctx.fillText("Stake : ", (canvas.width/2)-85, (canvas.height/2)+85);
            // ctx.beginPath();
            // // Box
            // ctx.rect((canvas.width/2), (canvas.height/2)+48, 180, 48);
            // ctx.fillStyle = "red";
            // ctx.fill();
            // // 100 Text
            // ctx.fillStyle = "black";
            // ctx.fillStyle = "white";
            // ctx.fillText("100", (canvas.width/2) + 97, (canvas.height/2) + 89);
        
        }

    




    

    

</script>
<?php

    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/body_tag_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // HTML CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/footers/html/html_tag_close');
?>

