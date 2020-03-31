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
    
    $payout = (($min_stake / 100) * $general_settings[0]->stake_conversion_level);
    $return = $min_stake + $payout;

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
                                    <div class="col-md-3 mt-3">
                                        <!-- Active Level Bar -->
                                        <div class="player_level_progress game-info">
                                            <h3><u>Level:</u> <span class="level_on"><?php echo $current_level; ?></span><h3>
                                        </div>
                                        <div class="player_level_progress game-info">
                                            <div class="progress" style="border:3px solid black; height: 40px; border-radius:20px;">
                                                <div class="progress-bar" id="prog_bar" role="progressbar" style="width: <?php echo $current_progress; ?>%; background-color: #03FD06;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                    <div class="text-center" style="font-weight: bold; font-size: 1.2rem; position: absolute; bottom: -20px; right:0;">
                                        <p class="">Credits:
                                            <span style="font-size: 1.8rem;" class="balance">
                                            <?php if($isDemoAccount == 1){
                                                echo $live_balance;
                                            } ?>
                                            </span>
                                        </p>
                                    </div>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                    <div class="player_game_time text-center game-info" style="margin-top:10px;">
                                        <div class="timer">
                                            <p>TIME</p>
                                            <hr>
                                            <p class="countdown">0<?php echo $game_timer; ?>:00</p>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                    <div class="player_add_credit game-info">
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
                                                <button type="button" id="btnContinue" class="btn custom-btn-green btn-lg" onclick="continuegame();">Confirm</button>
                                                <i class="glyphicon glyphicon-arrow-left" style="font-size: 4rem; position: absolute; margin-left:8px; color:red; top:15px;"></i>
                                            </div>
                                            <div class="btnConfirmNextGame d-none">
                                                <!-- Continue button -->
                                                <i class="glyphicon glyphicon-arrow-right" style="font-size: 4rem; position: absolute; margin-left: -73px; color: red; top:15px;"></i>
                                                <button type="button" id="btnNextGame" class="btn custom-btn-green btn-lg" onclick="playAgain();">Continue</button>
                                                <i class="glyphicon glyphicon-arrow-left" style="font-size: 4rem; position: absolute; margin-left:8px; color:red; top:15px;"></i>
                                            </div>
                                        </div><br>
                            <!-- Canvas For Game Play -->
                            <canvas class="d-none" id="imageCanvas" width="713" height="405" style="border:15px solid red; border-radius:5px;"></canvas>

                            <style type="text/css">
                                .enter_stake {
                                    width: 743px;
                                    height: 405px;
                                    border:15px solid red;
                                    border-radius:5px;
                                    background-color: #000;
                                }
                                .enter_stake label {
                                    font-weight: 800 !important;
                                    color: #fff;
                                    font-size: 3rem;
                                    font-family: "Times New Roman", Times, serif;
                                }
                                .enter_stake input {
                                    background-color: red !important;
                                    color: #000 !important;
                                    text-align: center !important;
                                    border: none !important;
                                    font-size: 2.5rem;
                                    padding: 0px !important;
                                    outline: 0px !important;
                                    line-height: 10px !important;
                                }
                                .enter_stake input:focus {
                                    outline: 0px !important;
                                    border: 0px !important;
                                    border-color: #000;
                                    box-shadow: none !important;
                                    line-height: 10px !important;
                                }
                                .stake_holder {
                                    margin-top: 60px;
                                }
                            </style>
                            <div id="enter_stake" class="enter_stake">
                                <div class="stake_holder">
                                    <div class="form-group row">
                                        <label class="col-sm-5 text-right">Stake</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" style="font-weight: bold;" name="inputStake" id="inputStake" 
                                            value="<?php echo $min_stake; ?>"
                                            min="<?php echo $min_stake; ?>"
                                            max="???" min="???"
                                            autofocus
                                            onfocus="this.setSelectionRange(this.value.length,this.value.length);"
                                            autocomplete="off" autosave="off">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-5 text-right">Payout</label>
                                        <div class="col-sm-4">
                                            <input type="text" style="font-weight: bold;" class="form-control" name="inputStake" id="inputPayout"
                                            value="<?php echo $payout; ?>" 
                                             readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-5 text-right">Return</label>
                                        <div class="col-sm-4">
                                            <input type="text" style="font-weight: bold;" class="form-control" name="inputStake" id="inputReturn"
                                            value="<?php echo $return; ?>" 
                                            readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            
                            <div class="text-center game_message d-none" style="margin-top:10px; width: 743px; background-color: red; padding: 10px; border-radius: 5px;">
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
        var min_stake_value = <?php echo $min_stake; ?>;
        var max_stake_value = <?php echo $max_stake; ?>;

        $('#inputStake').bind('keyup paste', function(){
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $( "#inputStake" ).focusout(function() {
          
          //Get input value
          var input_stake_value = $('#inputStake').val();
          if(input_stake_value < min_stake_value){
            $('#inputStake').val('');
            $('#inputStake').val('<?php echo $min_stake; ?>');
          }

          if(input_stake_value > max_stake_value){
            $('#inputStake').val('');
            $('#inputStake').val(max_stake_value);
          }

          displyCalculation();
        });
        $( "#inputStake" ).on("input", function() {
            displyCalculation();
        });

        function displyCalculation(){
            //console.log("Keydown");
            max_stake = $('#inputStake').val();
            //console.log("Input Stake: " + max_stake);

            var payout = ((parseInt(max_stake) / 100) * parseInt(<?php echo $general_settings[0]->stake_conversion_level; ?>));
            var return_amount = parseInt(max_stake) + parseInt(payout);

            if(max_stake < min_stake_value){
                payout = null;
                return_amount = null;
            }

            if(max_stake > max_stake_value){
                payout = ((parseInt(max_stake_value) / 100) * parseInt(<?php echo $general_settings[0]->stake_conversion_level; ?>));
                return_amount = parseInt(max_stake_value) + parseInt(payout);
            }

            $('#inputPayout').val(parseInt(payout));
            $('#inputReturn').val(parseInt(return_amount));
        }
        

       // Global Variables
        var canvas = document.getElementById('imageCanvas');
        var ctx = canvas.getContext('2d');
        var ctx_ball = canvas.getContext('2d');
        var img_id = 0;
        var img_x = 0;
        var img_y = 0;
        var img_url = 0;
        var sol_img = '';
        var username = "<?php echo $username; ?>";
        var max_stake = 0;
        var user_id = <?php echo $user_id; ?>;
        var level_on = <?php echo $current_progress; ?>;
        var prog_width_increaser = <?php echo $percentage_increase; ?>;
        var pass_marks = <?php echo $pass_marks; ?>;
        //var current_progress = <?php echo $current_progress; ?>;
        var current_level = <?php echo $current_level; ?>;
        var level_image = '<?php echo $level_image; ?>';

        var stake_return = <?php echo $general_settings[0]->stake_conversion_level; ?>;
        //console.log("Stake return: " + stake_return);


        var image_count = 0;

        updateProgressBarTotal();
        

        //Global x and y
        var canvas_x;
        var canvas_y;

        //Current user balance on page load
        var current_balance = <?php echo $live_balance; ?>;

        startGame();


        function currencyFormatDE(num) {
          return (
            num
              .toFixed(2) // always two decimal digits
              .replace('.', ',') // replace decimal point character with ,
              .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
          ) // use . as a separator
        }

        function initLevel(){
            //Set current level
            console.log('Hello init');
            //Set current level progress

        }

        function updateProgressBarTotal(){
            //set the progress bar max value
            $('#prog_bar').attr("aria-valuemax", 100);
            $('#prog_bar').attr("aria-valuenow", (level_on/pass_marks) * 100);
            
        }

        function removeStake(){
            console.log("New Stake");
            //add class d-none to enter_stake
            $('#enter_stake').addClass('d-none');
            //remove class d-none from canvas
            $('#imageCanvas').removeClass('d-none');
        }

        function enterStake(){
            console.log("New Stake");
            //add class d-none to enter_stake
            $('#enter_stake').removeClass('d-none');
            //remove class d-none from canvas
            $('#imageCanvas').addClass('d-none');
        }

       /**********************************
        -----------Main Code---------
        **********************************/
        function main(results){
            //Canvas created
            drawcanvas();
            //Check Balance
            $("#check_credit").click(function(event){
                removeStake();

                //level_on = 1;
                $(".level_on").text(current_level);
                document.getElementById("check_credit").disabled = true;

                $("#btnContinue").text("Confirm");
                //Disable continue button
                $('#btnContinue').prop("disabled",true);

                //document.getElementById("btnContinue").disabled = false;
                timeCounter();
                if(checkBalance()){
                    console.log('Player allowed to play');
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
                    //console.log('Not enough balance');
                    clearInterval(interval);
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
                enterStake();
                loseGame(response);
              }
              // console.log(timer2);
            }, 100);
            // console.log(interval);
        }

        function playNextImage(results){
            console.log('Entering playNextImage()');
            if(checkBalance()){
                console.log('Player allowed to play');
                createImage(results);
            }else{
                console.log('Not enough balance');
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
                   console.log(textStatus, errorThrown);
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
            console.log('Creating an image');
            
            //console.log(gallery_images);
            //console.log(gallery_images['id']);
            var img = new Image();
            img_id = gallery_images['id'];
            img_x = gallery_images['x_value'];
            img_y = gallery_images['y_value'];
            img_url = gallery_images['challenge_img_url'];
            sol_img = gallery_images['solution_img_url'];
            //console.log("Solution Image: " + sol_img);
            img.src = '<?php echo $assets; ?>game_images/gallery/'+img_url;
            img.onload = function(){
                ctx.drawImage(img,0,0,713,405);
                // Draw Circle on Click
                var ctx_circle = canvas.getContext("2d");
                ctx_ball = ctx_circle;
                ctx_circle.beginPath();
                ctx_circle.strokeStyle = "red";
                ctx_circle.lineWidth   = 1;
                ctx_circle.arc(gallery_images['x_value'],gallery_images['y_value'], 20, 0, 2 * Math.PI);
                ctx_circle.stroke();
            }
            clearInterval(interval);
            timeCounter();
            console.log("Image_X: " + gallery_images['x_value'] + " Image_Y: " + gallery_images['y_value']);
            //ctx_circle.arc(gallery_images['x_value'],gallery_images['y_value'],20,0,2*Math.PI);
        }


        

        //Create image
        function createImageGameComplete(){
            img = new Image();
            img.src = '<?php echo $assets; ?>game_images/level/'+level_image;
            img.onload = function(){
                ctx.drawImage(img,0,0,713,405);
            }
            $('.btnConfirmGame').removeClass('d-none');
            $('.btnContinueGame').addClass('d-none');
            clearInterval(interval);
            //timeCounter();
        }

        function userConfirm(){

        }

        function playAgain(){
            $('.btnConfirmGame').addClass('d-none');
            $('.btnContinueGame').removeClass('d-none');
            $('.btnConfirmNextGame').addClass('d-none');

            console.log('Entering play again');
            var results = null;
            $.ajax({
                url: "<?php echo $base; ?>/game/getGalleryAjax",
                type: "get",
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    results = response;
                    playNextImage(results);
                    
                    //You will get response from your PHP page (what you echo or print)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
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

        function updateLevelProgress(new_level_progress){
            console.log("Updating new level progress");
            $.ajax({
                url: "<?php echo $base; ?>/game/updateUserCurrentProgress?new_level_progress="+new_level_progress,
                type: "get",
                // dataType: 'json',
                data:{"new_level_progress":new_level_progress},
                success: function (response) {
                    // Message For Update Game Record
                    console.log(response);
                    console.log("Level progress updated successfully");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
                }
            });
        }

        function nextLevel(){
            //We fetch next level
            console.log("Requesting next level for: " + current_level);
            $.ajax({
                url: "<?php echo $base; ?>/game/getNextLevelAjax?id="+current_level,
                type: "get",
                dataType: 'json',
                data:{"billed_amount":max_stake},
                success: function (response) {
                    // Message For Update Game Record
                    console.log("############################");
                    console.log("Next Level");
                    console.log(response);
                    console.log("############################");
                    if(response == "end_of_level"){
                        noMoreLevel();
                        document.getElementById("check_credit").disabled = true;
                        setInterval('autoRefreshPage()', 10000);
                    }else{
                        level_image = response.level_image;

                        console.log("Next Winning Image: " + level_image);
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                   //console.log(textStatus, errorThrown);
                   noMoreLevel();
                   document.getElementById("check_credit").disabled = true;
                   setInterval('autoRefreshPage()', 10000);
                }
            }); 
        }

        function showball(){
            //Show ball here
            var img = new Image();
            img.src = '<?php echo $assets; ?>game_images/gallery/'+sol_img;
            img.onload = function(){
                ctx.drawImage(img,0,0,713,405);
                var ctx_ball = canvas.getContext("2d");
                ctx_ball.strokeStyle = "red";
                ctx_ball.lineWidth   = parseInt(<?php echo $general_settings[0]->cursor_size; ?>);
                ctx_ball.beginPath();
                ctx_ball.arc(canvas_x,canvas_y,20,0,2*Math.PI);
                ctx_ball.fillStyle = "red";
                ctx_ball.fill();
                ctx_ball.stroke();
            }

            clearInterval(interval);
            //timeCounter();
        }

        function continuegame(){
            // Get Distance
            var a = canvas_x - canvas_y;
            var b = img_x - img_y;
            //var c = Math.sqrt( a*a + b*b );
            var c = dist(img_x, img_y, canvas_x, canvas_y)
            // check Credentials Through AJAX

            console.log("Distance: " + c);

            $.ajax({
                url: "<?php echo $base; ?>/Game/Check_cordinates_rowgame",
                type: "post",
                data: {"distance" : c, "img_id": img_id, "user_id" : user_id, "max_stake" : max_stake, "username" : username, "img_url" : img_url} ,
                success: function (response) {

                    if(response == "win"){
                        level_on = level_on + prog_width_increaser;
                        console.log("Current Progress: " + level_on + "%");
                        var elem = document.getElementById('prog_bar');
                        //prog_width_increaser+=10;
                        elem.style.width = ((level_on/pass_marks) * 100) + "%";
                        $('#prog_bar').attr("aria-valuenow", level_on);

                        
                        

                        // game completion
                        var isTrue = gameComplete();
                        console.log('Game Complete Status: ' + isTrue);
                        if(isTrue){
                            increaseBalance(response);
                            //current_balance = current_balance + max_stake;
                            current_balance = (((parseInt(max_stake) / 100) * parseInt(stake_return)) + parseInt(max_stake)) + parseInt(current_balance);
                            //Update new balance on UI
                            $(".balance").text(currencyFormatDE(current_balance) + '');
                            updateLevelProgress('0');
                            console.log('Game Complete');
                            //end game
                            createImageGameComplete();
                            //updateLevelProgress(0);
                            
                            current_level++;
                            $(".level_on").text(current_level);

                            elem.style.width =  0 + "%";
                            $('#prog_bar').attr("aria-valuenow", 0);

                            //fetch next level
                            nextLevel();

                            //we update passmark, percentage increase

                        }else{
                            updateLevelProgress(level_on);
                            console.log('Game not over');
                            
                            var message = "WELL DONE";
                            if( image_count === 0 ){
                                message = 'WELL DONE';
                            }else if( image_count === 1 ){
                                message = 'SUPER';
                            }else if( image_count === 2 ){
                                message = 'EXCELLENT';
                            }else{
                               message = 'EXCELLENT';
                            }

                            $('.game_message').removeClass('d-none');
                            $('#lose_message').removeClass('d-none');
                            $('#lose_message').text(message);

                            
                            showball();
                            $('.btnConfirmGame').addClass('d-none');
                            $('.btnContinueGame').addClass('d-none');
                            $('.btnConfirmNextGame').removeClass('d-none');
                            //playAgain();
                            image_count++;

                            return false; //For good fortune
                            // pictureload(response);
                        }
                        
                        
                    }else{
                        enterStake();
                        loseGame(response);
                        return false;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
                }
            });
            $('#btnContinue').prop("disabled",true);
        }

        function loseGame(response){
            level_on = 0;
            $(".level_on").text(current_level);
            //get current balance
            updateGamePlayRecord(response, '0');
            deductBalance(response);
            current_balance = current_balance - max_stake;
            //Update new balance on UI
            $(".balance").text(currencyFormatDE(current_balance) + '');

            //$("#btnContinue").text("You Lose");
            
            $('.btnConfirmGame').removeClass('d-none');
            $('.btnContinueGame').addClass('d-none');

            $('.game_message').removeClass('d-none');
            $('#lose_message').removeClass('d-none');
            $('#lose_message').text('YOU LOSE');

            document.getElementById("btnContinue").disabled = true;
            //document.getElementById("check_credit").disabled = true;
            
            const context = canvas.getContext('2d');
            context.clearRect(0, 0, canvas.width, canvas.height);
            drawcanvas();
            clearInterval(interval);
        }


        function autoRefreshPage(){
            window.location = window.location.href;
        }


        //Get mouse cursor
        function getCursorPosition(canvas, img_id, event) {
            const rect = canvas.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;

            canvas_x = x;
            canvas_y = y;

            // Draw Circle on Click
            var ctx = canvas.getContext("2d");
            ctx.strokeStyle = "red";
            ctx.lineWidth   = parseInt(<?php echo $general_settings[0]->cursor_size; ?>);
            ctx.beginPath();
            ctx.arc(x,y,20,0,2*Math.PI);
            ctx.fillStyle = "red";
            ctx.fill();
            ctx.stroke();
            // This continue is for automatic
            // continuegame();
            
            $('#btnContinue').prop("disabled",false);

           console.log("x: " + canvas_x + " y: " + canvas_y);
        } // getCursorPosition End

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
                data:{"billed_amount":max_stake,"type":"level","x": img_x,"y":img_y, "win_lost":win_lost},
                success: function (response) {
                    // Message For Update Game Record
                    if(response == "success"){
                        //alert("Update Successfully");
                        console.log("Update Successfully");
                    }else if(response == "unauthorized"){
                        //alert("Not authorized");
                        console.log("Not authorized");
                        //Refresh or redirect user to appropriate page
                    }else{
                        console.log("Could not update record");
                        //alert("Could not update record");
                    }
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
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
                    console.log("Credit to update: " + response);
                    // Message For Update Game Record
                    if(response == "success"){
                        //alert("Update Successfully");
                        console.log("Update Successfully");
                    }else if(response == "unauthorized"){
                        //alert("Not authorized");
                        console.log("Not authorized");
                        //Refresh or redirect user to appropriate page
                    }else{
                        console.log("Could not update record");
                        //alert("Could not update record");
                    }
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
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
                        console.log("Balance deducted successfully");
                    }else if(response == "unauthorized"){
                        //alert("Not authorized");
                        console.log("Not authorized");
                        //Refresh or redirect user to appropriate page
                    }else{
                        console.log("Could not update record");
                        //alert("Could not update record");
                    }
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
                }
            });
        }

        /**********************************
        -----------Game Complete---------
        **********************************/
        function gameComplete(){
            var complete = false;
            console.log("Current Progress: " + level_on + " Pass Marks: " + pass_marks);
            if(level_on == pass_marks){
                complete = true;
                level_on = 0;
                document.getElementById("check_credit").disabled = false;
                $("#check_credit").text("Play Again");
                document.getElementById("btnContinue").disabled = true;
                $(".level_on").text(current_level);
                var res = null;
                updateGamePlayRecord(res, 1);
                $.ajax({
                    url: "<?php echo $base; ?>/game/updateUserLevel",
                    type: "post",
                    // dataType: 'json',
                    data:{"billed_amount":max_stake},
                    success: function (response) {
                        // Message For Update Game Record
                     console.log(response);   
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                       console.log(textStatus, errorThrown);
                    }
                });   
                //return true;          
            }
            return complete;
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


        function noMoreLevel(){
            // Fill Background
            ctx.fillStyle = "black";
            ctx.fillRect(0,0,canvas.width, canvas.height);

            // Font Colouring
            ctx.font = "50px Arial";
            ctx.fillStyle = "white";
            ctx.textAlign= "center";
            ctx.fillText("GAME OVER", canvas.width/2, (canvas.height/2)-30);
            ctx.fillText("END OF LEVEL GAME", canvas.width/2, (canvas.height/2)+25);
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

