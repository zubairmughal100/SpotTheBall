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
    // Disbale or Enable Debugging Display Content
    ////////////////////////////////////////////////////////////////////////////////////////
    $debug = false;



    ////////////////////////////////////////////////////////////////////////////////////////
    // LOAD HTML HEAD, INCLUDES {tags: doctype, html, head}
    ////////////////////////////////////////////////////////////////////////////////////////
    
    ////////////////////////////////////////////////////////////////////////////////////////



    ////////////////////////////////////////////////////////////////////////////////////////
    // LOAD HTML HEAD, INCLUDES {tags: meta, title, script and links to css}
    ////////////////////////////////////////////////////////////////////////////////////////
    
    ////////////////////////////////////////////////////////////////////////////////////////



    ////////////////////////////////////////////////////////////////////////////////////////
    // CALL CUSTOM {CSS LINK, JS SRC, META}
    ////////////////////////////////////////////////////////////////////////////////////////
    //$this->load->view('CALL HERE');
    ////////////////////////////////////////////////////////////////////////////////////////



    ////////////////////////////////////////////////////////////////////////////////////////
    // LOAD HTML HEAD, INCLUDES {tags: </head>}
    ////////////////////////////////////////////////////////////////////////////////////////
    
    ////////////////////////////////////////////////////////////////////////////////////////




    ////////////////////////////////////////////////////////////////////////////////////////
    // LOAD BODY START, INCLUDES {<body>, <div> wrapper start}
    ////////////////////////////////////////////////////////////////////////////////////////
    
    ////////////////////////////////////////////////////////////////////////////////////////




    ////////////////////////////////////////////////////////////////////////////////////////
    // LOAD HEADER NAV, INCLUDES {header navigation only}
    ////////////////////////////////////////////////////////////////////////////////////////
    
    ////////////////////////////////////////////////////////////////////////////////////////




    ////////////////////////////////////////////////////////////////////////////////////////
    // LOAD DEBUG VIEW
    ////////////////////////////////////////////////////////////////////////////////////////
    if($debug){
        //Load Debug View
    }
    ////////////////////////////////////////////////////////////////////////////////////////



    //Function to truncate / limit characters x
    function truncateCharacters($x, $length)
    {
      if(strlen($x)<=$length)
      {
        echo $x;
      }
      else
      {
        $y=substr($x,0,$length) . '...';
        return $y;
      }
    }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/favicon/favicon.png">
    <link rel="canonical" href="https://getbootstrap.com/docs/3.3/examples/navbar/">

    <title>Navbar Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo $cssbase; ?>bootstrap.min.css" rel="stylesheet">

  </head>

  <body>


      <!-- Static navbar -->
      <div class="main_nav">
          <div class="container">
              <div class="row">
                  <div class="col-md-12">
                      <nav class="navbar navbar-light transparent justify-content-between">
                          <div class="logo"> <a href="">Spot<br>The Ball</a> </div>
                          <form class="form-inline">
                            <input class="form-control mr-sm-2" type="username" placeholder="Username" aria-label="Username">
                            <input class="form-control mr-sm-2" type="password" placeholder="Password" aria-label="Password">
                            <button class="btn btn-outline-success btn-login-custom my-2" type="submit">Login</button>
                          </form>
                      </nav>
                      
                      <ul class="nav nav-pills nav-fill bg-nav-custom main-pill-menu">
                          <li class="nav-item">
                            <a class="nav-link active" href="#">Level Game</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#">Row Games</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#">Prizes</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#"><span class="glyphicon glyphicon-user"></span> Account Information</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#"><span class="glyphicon glyphicon-list-alt"></span></span> Billing Information</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#"><span class="glyphicon glyphicon-folder-open"></span> Documents</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#"><span class="glyphicon glyphicon-credit-card"> Payments</a>
                          </li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
            

      <!-- Main component for a primary marketing message or call to action -->
      <div class="game-body">
          <div class="container">
              <div class="game-container">


                <div class="game game_logo"></div>

                <div class="game game_header d-none">
                    <h1>Navbar example</h1>
                </div>

                <div class="game game_content">
                    <div class="game_container">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="player_level_progress game-info">
                                    <h3 class="text-white">Level: 1<h3>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 10%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                              <div class="player_balance text-center game-info">
                                  <p class="balance">Credits: 3,000</p>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="player_game_time text-center game-info">
                                  <div class="timer">
                                      <p>Time</p>
                                      <hr>
                                      <p>02:57</p>
                                  </div>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="player_add_credit game-info">
                                  <a href="#" class="btn btn-block btn-primary">Add Credits</a>
                              </div>
                            </div>
                        </div>

                        <div class="game_holder">
                            <div class="play_game">
                                <div class="row">
                                    <div class="col-md-10">
                                      <!--<div class='zoom-img'>
                                        <img id="map" src="<?php echo $assets ?>game_images/empty/image.jpg">
                                      </div>-->
                                      <img id="zoomable" class="pic" src="<?php echo $assets ?>game_images/empty/image.jpg" alt="" />
                                    </div>
                                    <div class="col-md-2">
                                        <div class="zoom">
                                            <div class="btn-group-wrap">
                                                <div class="btn-group">
                                                    <p class="text-white zoom-text">Zoom Settings</p>
                                                </div>
                                              </div>
                                            <div class="btn-group-wrap">
                                                <div class="btn-group btn-toggle">
                                                    <input type="hidden" value="off" id="btnState">
                                                    <button class="btn btn-lg btn-default" style="border: 1px solid #0069D9; position:relative; margin-right:-5px; color:#fff;">ON</button>
                                                    <button class="btn btn-lg btn-primary active" style="border: 1px solid #0069D9; position:relative; margin-left:-5px; color:#fff;">OFF</button>
                                                  </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="stake_holder d-none">
                                  <div class="confirm_game">
                                      <div class="col-md-12 text-center">
                                          <button id="singlebutton" name="singlebutton" class="btn btn-lg btn-success">Confirm</button> 
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
                            </div>
                        </div>
                    </div>
                </div>

                <div class="game game_footer">
                  <footer>
                      <div class="row">
                          <div class="col-md-4">
                              <h4 class="footer_title">Explore</h4>
                              <div class="footer_content">
                                  <ul class="regular">
                                      <li><a href="">ABOUT</a></li>
                                      <li><a href="">TERMS & CONDITIONS</a></li>
                                      <li><a href="">PRIVACY & POLICY</a></li>
                                      <li><a href="">HELP</a></li>
                                      <li><a href="">BLOG</a></li>
                                  </ul>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <h4 class="footer_title">Follow Us</h4>
                              <div class="footer_content">
                                  <ul class="social">
                                      <li><a href="">Facebook</a></li>
                                      <li><a href="">Twitter</a></li>
                                      <li><a href="">Instagram</a></li>
                                  </ul>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <h4 class="footer_title">News Letter</h4>
                              <div class="footer_content">
                                  <p><small class="text-muted">Subscribe to out newsletter to win prizes</small></p>
                                  <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                                      <button class="btn btn-default btn-subscribe" type="button"><span class="glyphicon glyphicon-envelope"></span></button>
                                    </span>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </footer>
                </div>


              </div>
          </div>
      </div>
      
      



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!--<script src="<?php echo $jsbase; ?>bootstrap/jquery-3.3.1.slim.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <!--<script src="<?php echo $jsbase; ?>bootstrap/popper.min.js"></script>-->
    <!--<script src="<?php echo $jsbase; ?>bootstrap/bootstrap.min.js"></script>-->
    <script src="<?php echo $jsbase; ?>zoom/blowup.min.js"></script>
    <script>
        $(document).ready(function () {
            //$(".pic").blowup();
            $("#zoomable").mouseover(function(){
                var btnState = "";
                btnState =  $("#btnState").val();
                console.log("Button State mouseover: " + btnState);
                if(btnState == "on"){
                    console.log("Button State blowup: on");
                    $(".pic").blowup({
                        "background" : "#F39C12",
                        "width" : 400,
                        "height" : 400,
                        "zIndex" : 9999999,
                        "scale" : 2
                    })
                }else{
                  console.log("Button State mouseover [else]: off");
                }
            });
            

            


            $('.btn-toggle').click(function() {
                $(this).find('.btn').toggleClass('active');

                var btnStateTwo =  $("#btnState").val();
                console.log("Button State onclick: " + btnStateTwo);
                //Set input value
                if(btnStateTwo == "on"){
                  $("#btnState").val("off");
                }else{
                  $("#btnState").val("on");
                }
                
                
                if ($(this).find('.btn-primary').length>0) {
                  $(this).find('.btn').toggleClass('btn-primary');
                }
                if ($(this).find('.btn-danger').length>0) {
                  $(this).find('.btn').toggleClass('btn-danger');
                }
                if ($(this).find('.btn-success').length>0) {
                  $(this).find('.btn').toggleClass('btn-success');
                }
                if ($(this).find('.btn-info').length>0) {
                  $(this).find('.btn').toggleClass('btn-info');
                }
                
                $(this).find('.btn').toggleClass('btn-default');
                  
            });
        })
    </script> 
    
  </body>
</html>
