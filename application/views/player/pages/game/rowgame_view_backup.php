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
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-3">
                                        <!-- Active Level Bar -->
                                        <div class="player_level_progress" style="width:100%; padding: 0px !important; border-radius: 20px; color: #02A3E9; border: 5px solid #02A3E9; text-align: center; margin-top:5px;">
                                            <h3 class="level_on" style="font-weight: 800; font-size: 2.2rem; padding-top: 2px; padding-bottom: 0px; padding-left: 5px; padding-right: 5px;">0 of <?php echo $number_of_row; ?><h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                    <div class="text-center" style="font-weight: bold; font-size: 2.2rem;">
                                        <p class="balance" style="margin-top: 7px;">$
                                            <span>
                                            <?php if($isDemoAccount == 1){
                                                echo $live_balance;
                                            } ?>
                                            </span>
                                        </p>
                                    </div>
                                    </div>
                                    <div class="col-md-3">
                                    <div class="player_game_time text-center game-info" >
                                        <div class="timer">
                                            <p>Time</p>
                                            <hr>
                                            <p class="countdown"><?php echo $game_timer; ?>.00</p>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-3">
                                    <div class="player_add_credit game-info" style="margin-top: 10px;">
                                        <a href="<?php echo $base; ?>/account/addfund" class="btn btn-block btn-custom-addcredit">Add Credits</a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="game_holder">
                            <div class="play_game">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="text-center p-2" style="width: 740px; border:10px solid red; border-radius: 5px;">
                                            <div class="btnConfirmGame">
                                                <i class="glyphicon glyphicon-arrow-right" style="font-size: 4rem; position: absolute; margin-left: -73px; color: red; top:15px;"></i>
                                                <!-- Button To Check Credit For Stake Play -->
                                                <button type="button" id="check_credit" class="btn custom-btn-green btn-lg">Confirm</button>
                                                <i class="glyphicon glyphicon-arrow-left" style="font-size: 4rem; position: absolute; margin-left:8px; color:red; top:15px;"></i>
                                            </div>

                                            <div class="btnContinueGame d-none">
                                                <!-- Continue button -->
                                                <i class="glyphicon glyphicon-arrow-right" style="font-size: 4rem; position: absolute; margin-left: -73px; color: red; top:15px;"></i>
                                                <button type="button" id="btnContinue" class="btn custom-btn-green btn-lg" onclick="continuegame();">Continue</button>
                                                <i class="glyphicon glyphicon-arrow-left" style="font-size: 4rem; position: absolute; margin-left:8px; color:red; top:15px;"></i>
                                            </div>
                                        </div><br>
                            <!-- Canvas For Game Play -->
                            <canvas id="imageCanvas" width="713" height="405" style="border:15px solid red; border-radius:5px;"></canvas>
                            
                            <div class="text-center game_message d-none" style="width: 733px; background-color: red; padding: 10px; border-radius: 5px;">
                                <div style="background-color: black; width: 80%; margin: auto; padding: 0px; border-radius: 5px;">
                                    <!--<button type="button" id="btnContinue" class="btn btn-success" onclick="continuegame();">Continue</button>-->
                                    <div class="d-none" id="lose_message" style=" color: yellow; font-weight: 800; font-size: 4rem;">YOU LOSE</div>
                                    <div class="d-none" id="win_message " style=" color: yellow; font-weight: 800; font-size: 4rem;">SUPER</div>
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
       // Global Variables
        var canvas = document.getElementById('imageCanvas');
        var ctx = canvas.getContext('2d');
        var ctx_ball = canvas.getContext('2d');
        var img_id = 0;
        var img_x = 0;
        var img_y = 0;
        var img_url = 0;
        var username = "<?php echo $username; ?>";
        var max_stake = <?php echo $max_stake; ?>;
        var user_id = <?php echo $user_id; ?>;
        var level_on = 0;


        //Control paint on a canvas
        var has_paint = false;
        //Control Image loading
        var image_loaded = false;


        //Global x and y
        var canvas_x;
        var canvas_y;

        //Control debugging
        var debug = false;

        //Current user balance on page load
        var current_balance = <?php echo $live_balance; ?>;

        startGame();


       /**********************************
        -----------Main Code---------
        **********************************/
        function main(results){
            //Canvas created
            drawcanvas();
            //Check Balance
            $("#check_credit").click(function(event){
                level_on = 1;
                $(".level_on").text(level_on + " of <?php echo $number_of_row; ?>");
                document.getElementById("check_credit").disabled = true;

                $("#btnContinue").text("Continue");
                //Disable continue button
                $('#btnContinue').prop("disabled",true);

                //document.getElementById("btnContinue").disabled = false;
                timeCounter();
                if(checkBalance()){
                    if(debug == true){
                        console.log('Player allowed to play');
                    }
                    
                    $('.btnConfirmGame').addClass('d-none');
                    $('.btnContinueGame').removeClass('d-none');
                    $('.game_message').addClass('d-none');
                    //$('#lose_message').removeClass('d-none');
                    //$('#lose_message').text('INSUFFICIENT BALANCE');
                    createImage(results);
                }else{
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
                updateGamePlayRecord(response, '0');
                deductBalance(response);
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
            //console.log('hello');
            var results = null;
            return $.ajax({
                url: "<?php echo $base; ?>/game/getGalleryAjax",
                type: "get",
                dataType: 'json',
                success: function (response) {
                    results = response;
                    main(results);
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
            var balance = <?php echo $live_balance; ?>;
            var stake = <?php echo $max_stake; ?>;
            var boolean = false;
            // Check Credit For Play 1
            if(current_balance > stake){
                boolean = true;
            }else{
                boolean = false;
            }
            return boolean;
        }

        //Create image
        function createImage(gallery_images){
            let cursorWidth = parseInt(<?php echo $general_settings[0]->cursor_size; ?>);

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
                ctx.drawImage(img,0,0,713,405);

                if(debug == true){
                    // Draw Circle on Click
                    var ctx_circle = canvas.getContext("2d");
                    ctx_ball = ctx_circle;
                    ctx_circle.beginPath();
                    ctx_circle.strokeStyle = "red";
                    ctx_circle.lineWidth   = 1;
                    ctx_circle.arc(gallery_images['x_value'],gallery_images['y_value'], cursorWidth, 0, 2 * Math.PI);
                    ctx_circle.stroke();
                }
            }
            
            clearInterval(interval);
            timeCounter();
            if(debug == true){
                console.log("Image_X: " + gallery_images['x_value'] + " Image_Y: " + gallery_images['y_value']);
            }
            //ctx_circle.arc(gallery_images['x_value'],gallery_images['y_value'],20,0,2*Math.PI);
        }


        function reDrawImage(){
            let cursorWidth = parseInt(<?php echo $general_settings[0]->cursor_size; ?>);

            var img = new Image();

            img.src = '<?php echo $assets; ?>game_images/gallery/'+img_url;

            img.onload = function(){
                ctx.drawImage(img,0,0,713,405);

                if(debug == true){
                    // Draw Circle on Click
                    var ctx_circle = canvas.getContext("2d");
                    ctx_ball = ctx_circle;
                    ctx_circle.beginPath();
                    ctx_circle.strokeStyle = "red";
                    ctx_circle.lineWidth   = 1;
                    ctx_circle.arc(img_x,img_y, cursorWidth, 0, 2 * Math.PI);
                    ctx_circle.stroke();
                }
            }
        }


        

        //Create image
        function createImageGameComplete(){
            drawcanvasblack();
            if(debug == true){
                console.log("Creating Winning Image...");
            }
            img = new Image();
            img.src = '<?php echo $assets; ?>game_images/row/<?php echo $the_row_game[0]->winning_image; ?>';
            img.onload = function(){
                ctx.drawImage(img,0,0,713,405);
            }
            $('.btnConfirmGame').removeClass('d-none');
            $('.btnContinueGame').addClass('d-none');
            clearInterval(interval);
            //timeCounter();
        }



        function playAgain(){
            var results = null;
            $.ajax({
                url: "<?php echo $base; ?>/game/getGalleryAjax",
                type: "get",
                dataType: 'json',
                success: function (response) {
                    results = response;
                    playNextImage(results);
                    
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
        }



        
        // @ Start @ //
        // On Mouse Click for Circle
        canvas.addEventListener('mousedown', function(e) {
            getCursorPosition(canvas,img_id, e);
        });

        function diff (num1, num2) {
          if (num1 > num2) {
            return (num1 - num2);
          } else {
            return (num2 - num1);
          }
        };

        function dist(x1, y1, x2, y2) {
          var deltaX = diff(x1, x2);
          var deltaY = diff(y1, y2);
          var dist = Math.sqrt(Math.pow(deltaX, 2) + Math.pow(deltaY, 2));
          return (dist);
        };

        function continuegame(){
            //has_paint = false;
            // Get Distance
            var a = canvas_x - canvas_y;
            var b = img_x - img_y;
            //var c = Math.sqrt( a*a + b*b );
            var c = dist(img_x, img_y, canvas_x, canvas_y)
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
                        // game completion
                        var isTrue = gameComplete();
                        if(isTrue){
                            //end game
                            createImageGameComplete();
                        }else{
                            var message = "WELL DONE";
                            if( level_on === 0 ){
                                message = '<?php echo $row_game_messages[0]->message; ?>';
                            }else if( level_on === 1 ){
                                message = '<?php echo $row_game_messages[1]->message; ?>';
                            }else if( level_on === 2 ){
                                message = '<?php echo $row_game_messages[2]->message; ?>';
                            }else{
                               message = '<?php echo $row_game_messages[2]->message; ?>';
                            }

                            $('.game_message').removeClass('d-none');
                            $('#lose_message').removeClass('d-none');
                            $('#lose_message').text(message);

                            level_on++;
                            $(".level_on").text(level_on + " of <?php echo $number_of_row; ?>");
                            playAgain();

                            return false; //For good fortune
                            // pictureload(response);
                        }
                        
                        
                    }else{
                        image_loaded = false;
                        level_on = 0;
                        $(".level_on").text(level_on + " of <?php echo $number_of_row; ?>");
                        //get current balance
                        updateGamePlayRecord(response, '0');
                        deductBalance(response);
                        current_balance = current_balance - max_stake;
                        //Update new balance on UI
                        $(".balance").text("$" + current_balance + '');

                        //$("#btnContinue").text("You Lose");
                        
                        $('.btnConfirmGame').removeClass('d-none');
                        $('.btnContinueGame').addClass('d-none');

                        $('.game_message').removeClass('d-none');
                        $('#lose_message').removeClass('d-none');
                        $('#lose_message').text('YOU LOSE');

                        document.getElementById("btnContinue").disabled = true;
                        const context = canvas.getContext('2d');
                        context.clearRect(0, 0, canvas.width, canvas.height);
                        drawcanvas();
                        clearInterval(interval);
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
        function getCursorPosition(canvas, img_id, event) {
            // if(has_paint == fals){
            //     console.log("Player allowed to create circle");
            // }else{
            //     console.log("Player not allowed to create circle");
            // }
            
            //reDrawImage();
            
            console.log("Image X: " + img_x);
            console.log("Image Y: " + img_y);

            if(image_loaded == true){
                //if(has_paint == false){
                    //has_paint = true;
                    const rect = canvas.getBoundingClientRect();
                    const x = event.clientX - rect.left;
                    const y = event.clientY - rect.top;


                    // Draw Circle on Click
                    var ctx = canvas.getContext("2d");



                    let cursorWidth = parseInt(<?php echo $general_settings[0]->cursor_size; ?>);

                    //Clear previous arc
                    ctx.strokeStyle = "rgba(255, 255, 255, 0.7)";
                    ctx.lineWidth   = cursorWidth;
                    ctx.beginPath();
                    ctx.arc(canvas_x,canvas_y,cursorWidth,0,2*Math.PI);
                    ctx.fillStyle = "rgba(255, 255, 255, 0.7)";
                    ctx.fill();
                    ctx.stroke();
                    



                    canvas_x = x;
                    canvas_y = y;

                    

                    //ctx.save();
                    

                    ctx.strokeStyle = "red";
                    ctx.lineWidth   = cursorWidth;
                    ctx.beginPath();
                    ctx.arc(x,y,cursorWidth,0,2*Math.PI);
                    ctx.fillStyle = "red";
                    ctx.fill();
                    ctx.stroke();


                    //context.restore();
                    // This continue is for automatic
                    // continuegame();
                    
                    $('#btnContinue').prop("disabled",false);

                   if(debug == true){
                        console.log("x: " + canvas_x + " y: " + canvas_y);
                   }
                }
            //}
        } //getCursorPosition End

        

        /**********************************
        -------Update Game PlayRecord-----
        **********************************/
        function updateGamePlayRecord(res, win_lost){
            document.getElementById("check_credit").disabled = false;
            $("#check_credit").text("Play Again");
            // $("#lose_message").show();
            //Call ajax
            $.ajax({
                url: "<?php echo $base; ?>/game/updateGamePlayRecords",
                type: "post",
                // dataType: 'json',
                data:{"billed_amount":max_stake,"type":"row","x": img_x,"y":img_y, "win_lost":win_lost},
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


        function deductBalance(res){
            //Call ajax
            $.ajax({
                url: "<?php echo $base; ?>/game/deductBalance",
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

        /**********************************
        -----------Game Complete---------
        **********************************/
        function gameComplete(){
            image_loaded = false;
            if(level_on >= <?php echo $number_of_row; ?>){
                level_on = 0;
                document.getElementById("check_credit").disabled = false;
                $("#check_credit").text("Play Again");
                document.getElementById("btnContinue").disabled = true;
                $(".level_on").text(level_on + " of <?php echo $number_of_row; ?>");
                var res = null;
                updateGamePlayRecord(res, 1);
                $.ajax({
                    url: "<?php echo $base; ?>/game/updateGameWin",
                    type: "post",
                    // dataType: 'json',
                    data:{"billed_amount":max_stake},
                    success: function (response) {
                        // Message For Update Game Record
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
            ctx.fillText("100", (canvas.width/2) + 97, (canvas.height/2) + 89);
        
        }

        function drawcanvasblack(){
            //Draw canvas
        
            // Fill Background
            ctx.fillStyle = "black";
            ctx.fillRect(0,0,canvas.width, canvas.height);

            // Font Colouring
            ctx.font = "50px Arial";
            ctx.fillStyle = "white";
            ctx.textAlign= "center";
            //ctx.fillText("YOU HAVE WON", canvas.width/2, (canvas.height/2)-30);
            ctx.fillText("YOU HAVE WON!", canvas.width/2, (canvas.height/2)+25);
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

