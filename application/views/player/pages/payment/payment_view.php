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
    //$this->load->view('player/essentials/body/main_nav');
    $this->load->view('player/essentials/body/main_nav');
    $this->load->view('player/essentials/body/main_nav_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // MAIN CONTENT OPEN TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    //Enable this for game look
    //$this->load->view('player/essentials/body/body_main_content_start');
    //Enable this for vanilla look
    $this->load->view('player/essentials/body/body_main_vanilla_content_start');
    

?>

    <!-- main Content Goes Here -->
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="alert alert-warning border border-warning" role="alert">
                <span class="glyphicon glyphicon-info-sign"></span> Please make a payment to activate your account
            </div>

            <select id="paymentMethod" class="form-control form-control-lg bg-primary text-white">
                <?php if($stripe_payment_settings[0]->sandbox_mode == '1'){ ?>
                    <option value="Stripe">Stripe</option>
                <?php } ?>
                
                <?php if($paypal_payment_settings[0]->sandbox_mode == '1'){ ?>
                    <option value="PayPal">PayPal</option>
                <?php } ?>

                <?php if($crypto_payment_settings[0]->sandbox_mode == '1'){ ?>
                    <option value="Bitcoin">Bitcoin</option>
                <?php } ?>
            </select><br><br><br><br>

            <div class="form-group row">
                <div class="col-sm-12">
                    <select class="form-control mb-1" name="curreny_type" id="curreny_type"
                    onchange="updatePrice('game_balance');" readonly>
                        <?php if($general_settings[0]->default_currency == 'eur'){ ?>
                            <option value="eur">Euro</option>
                        <?php }else if($general_settings[0]->default_currency == 'gbp'){ ?>
                            <option value="gbp" selected>Pound</option>
                        <?php }else if($general_settings[0]->default_currency == 'usd'){ ?>
                            <option value="usd">Dollar</option>
                        <?php }else{ ?>
                            <option value="eur">Euro</option>
                        <?php } ?>
                        
                        
                        
                    </select>
                </div>
                <div class="col-sm-6">
                    <label>Enter Amount</label>
                    <input class="form-control" step="0.5" id="creditAmount" placeholder="Amount" type="number" 
                    onkeyup="updatePrice('game_balance');" 
                    onchange="updatePrice('game_balance');"
                    onKeyPress="if(this.value.length==12) return false;"
                    autofocus="off" autocomplete="off" autosave="off">
                </div>
                <div class="col-sm-6">
                    <label>Game Credit</label>
                    <input class="form-control" name="game_balance" id="game_balance" type="text" placeholder="Game Credit" readonly>
                </div>
            </div>
            
            <!--Payment container code start-->
            <div class="row" id="paymentContainer">
                <div class="col-md-12">
                    <div class="stripe">
                        <div class="card">
                            <div class="card-header">
                                Stripe
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="alert-danger payment-status" role="alert"></div>
                                </div>
                                
                                <div class="form-group">
                                    <input type="text" name="cardName" id="cardName" class="form-control form-control-lg" placeholder="Name on card" required>
                                </div>
                                <div class="form-group">
                                    <div class="card_input form-control" id="card-element"></div>
                                </div>
                                <!-- Submit Button -->
                                <div class="modal-footer">
                                    <button class="btn btn-success btn-block" id="card-button">Submit Payment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="paypal d-none">
                        <div class="card">
                            <div class="card-header">
                                Paypal
                            </div>
                            <div class="card-body">
                                <!-- Set up a container element for the button -->
                                <div id="paypal-button"></div> <!-- End Paypal -->
                            </div>
                        </div>
                    </div>
                    <div class="bitcoin d-none">
                        <div class="card">
                            <div class="card-header">
                                Bitcoin
                            </div>
                            <div class="card-body">
                                Hello
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div> <!-- End Stripe -->
            

            

        </div>
        <div class="col-md-4"></div>
    </div>
<?php
    ////////////////////////////////////////////////////////////////////////////////////////
    // PAYMENT SECTION
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/pages/myaccount/js/paypal_payment');
    $this->load->view('player/pages/myaccount/js/stripe_payment');
    ////////////////////////////////////////////////////////////////////////////////////////
    // FOOTER CONTENT
    ////////////////////////////////////////////////////////////////////////////////////////
    //$this->load->view('player/essentials/footers/html/footer_content');

    ////////////////////////////////////////////////////////////////////////////////////////
    // MAIN CONTENT CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/body_main_content_end');

    ////////////////////////////////////////////////////////////////////////////////////////
    // Load JavaScript, Jquery File here
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/pages/myaccount/js/jquery_js');
    $this->load->view('player/pages/myaccount/js/change_payment_selection_js');
?>

<script>
    $(document).ready(function(){
        //Currency conversion, must move to ajax, this is only for test purposes
        /*
        $("#moneyAmount").keyup(function(){
            var moneyAmount = $(this).val();
            var exchangeRate = 0.76;
            var exchangeAmount = moneyAmount * exchangeRate;
            $("#creditAmount").val(exchangeAmount.toFixed(2));
        });
        */

        /*
        $("#creditAmount").on("change", function() {
            console.log('Hello change');
            $("#game_balance").val('0'); 
        });
        */
    });
</script>


<script type="text/javascript">

    $( document ).ready(function() {
        $('#paymentContainer').hide();
    });

    var myInput = document.querySelectorAll("input[type=number]");

    function keyAllowed(key) {
      var keys = [8, 9, 13, 16, 17, 18, 19, 20, 27, 46, 48, 49, 50,
        51, 52, 53, 54, 55, 56, 57, 91, 92, 93
      ];
      if (key && keys.indexOf(key) === -1)
        return false;
      else
        return true;
    }

    myInput.forEach(function(element) {
      element.addEventListener('keypress', function(e) {
        var key = !isNaN(e.charCode) ? e.charCode : e.keyCode;
        if (!keyAllowed(key))
          e.preventDefault();
      }, false);

      // Disable pasting of non-numbers
      element.addEventListener('paste', function(e) {
        var pasteData = e.clipboardData.getData('text/plain');
        if (pasteData.match(/[^0-9]/))
          e.preventDefault();
      }, false);
    })

    //updatePrice('0.5', 'game_balance');
    function updatePrice(element){
        var amount = parseInt($('#creditAmount').val());
        if(!amount){
            amount = 0;
            $('#paymentContainer').hide();
        }else{
            $('#paymentContainer').show();
        }

        //Get selected payment type
        var paymentMethod = $("#curreny_type").val();
        console.log("Currency Type: " + paymentMethod);
        switch(paymentMethod) {
            case 'eur':
                //var percentage = <?php echo $general_settings[0]->euro_conversion; ?>;
                var credit = <?php echo $general_settings[0]->euro_conversion; ?>;
                //game_credit = amount + (percentage / 100) * amount;
                game_credit = amount * credit;
                break;
            case 'gbp':
                //var percentage = <?php echo $general_settings[0]->pound_conversion; ?>;
                var credit = <?php echo $general_settings[0]->pound_conversion; ?>;
                //game_credit = amount + (percentage / 100) * amount;
                game_credit = amount * credit;
                break;
            case 'usd':
                //var percentage = <?php echo $general_settings[0]->dollar_conversion; ?>;
                var credit = <?php echo $general_settings[0]->dollar_conversion; ?>;
                //game_credit = amount + (percentage / 100) * amount;
                game_credit = amount * credit;
                break;
            default:
                // code block
        }

        update_amount = game_credit.toFixed(2);
        console.log(game_credit);
        document.getElementById(element).value = update_amount;
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

