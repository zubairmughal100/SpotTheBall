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
    

?>

    <!-- main Content Goes Here -->
    <div class="row">
        <div class="col-md-4">
            <?php $this->load->view('player/pages/myaccount/settings/settings_menu_left'); ?>
        </div>
        <div class="col-md-8">
            <div class="card" style="margin-bottom:30px;">
                <div class="card-header">
                    Add Fund
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="">Payment Method*</label>
                            <select id="paymentMethod" class="form-control form-control-lg">
                                <?php if($stripe_payment_settings[0]->sandbox_mode == '1'){ ?>
                                    <option value="Stripe">Stripe</option>
                                <?php } ?>
                                
                                <?php if($paypal_payment_settings[0]->sandbox_mode == '1'){ ?>
                                    <option value="PayPal">PayPal</option>
                                <?php } ?>

                                <?php if($crypto_payment_settings[0]->sandbox_mode == '1'){ ?>
                                    <option value="Bitcoin">Coinbase</option>
                                <?php } ?>
                                
                                
                            </select>
                            <br>
                            <div class="paymentContainer" id="paymentContainer">
                                <div class="stripe">
                                    <div class="card">
                                        <div class="card-header">
                                            Stripe
                                        </div>
                                        <div class="card-body">
                                            <!-- Stripe Start -->
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
                                            <div class="form-group">
                                                <button class="btn btn-success btn-block" id="card-button">Submit Payment</button>
                                            </div>
                                            <!-- StripeEnd -->
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
                                            Coinbase
                                        </div>
                                        <div class="card-body">
                                            Need URL
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Currency</label>
                                <select class="form-control" id="currency_type" name="currency_type" 
                                onchange="updatePrice('creditAmount');" readonly>
                                    <?php if($general_settings[0]->default_currency == 'eur'){ ?>
                                        <option value="eur" selected>Euro</option>
                                    <?php }else if($general_settings[0]->default_currency == 'gbp'){ ?>
                                        <option value="gbp" selected>Pound</option>
                                    <?php }else if($general_settings[0]->default_currency == 'usd'){ ?>
                                        <option value="usd" selected>Dollar</option>
                                    <?php }else{ ?>
                                        <option value="eur" selected>Euro</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="moneyAmount">Enter Amount</label>
                                <input type="number" step="0.5" id="moneyAmount" name="moneyAmount" class="form-control" placeholder="Enter Amount"
                                onkeyup="updatePrice('creditAmount');" 
                                onchange="updatePrice('creditAmount');"
                                onKeyPress="if(this.value.length==15) return false;"
                                autofocus="off" autocomplete="off" autosave="off">
                            </div>
                            <div class="form-group">
                                <label for="creditAmount">Credits</label>
                                <input type="text" id="creditAmount" name="creditAmount" class="form-control" placeholder="Credits" value="Credits" readonly>
                            </div>
                        </div>
                    </div><br>

                    <!--Stripe code start-->
                    <div class="row" id="">
                        <div class="col-md-8">
                            
                        </div>
                    </div> <!-- End Stripe -->
                </div>
            </div>

            <!-- We Will see later Select card -->

            <!-- <div class="card" style="margin-bottom:60px;">
                <div class="card-header">
                    Payment Information
                </div> 
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Card Number</th>
                                    <th scope="col">Card Type</th>
                                    <th scope="col">Expires</th>
                                    <th class="text-center" scope="col">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-muted">************4242</td>
                                    <td class="text-muted">Visa</td>
                                    <td class="text-muted">04/2022</td>
                                    <td class="text-center"><a href="#"><span class="glyphicon glyphicon-trash"></span></a></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">************4242</td>
                                    <td class="text-muted">Visa</td>
                                    <td class="text-muted">04/2022</td>
                                    <td class="text-center"><a href="#"><span class="glyphicon glyphicon-trash"></span></a></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">************4242</td>
                                    <td class="text-muted">Visa</td>
                                    <td class="text-muted">04/2022</td>
                                    <td class="text-center"><a href="#"><span class="glyphicon glyphicon-trash"></span></a></td>
                                </tr>
                            </tbody>
                            </table>
                    </div>
                </div>
            </div> -->
        </div>
    </div>


<?php
    ////////////////////////////////////////////////////////////////////////////////////////
    // PAYMENT SECTION
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/pages/myaccount/js/account_paypal_payment');
    $this->load->view('player/pages/myaccount/js/account_stripe_payment');
    ////////////////////////////////////////////////////////////////////////////////////////
    // FOOTER CONTENT
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/footers/html/footer_content');

    ////////////////////////////////////////////////////////////////////////////////////////
    // MAIN CONTENT CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/body_main_content_end');


    ////////////////////////////////////////////////////////////////////////////////////////
    // JS, Custom JS
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/pages/myaccount/js/jquery_js');
    //$this->load->view('player/pages/myaccount/settings/js/form_control_js');
    $this->load->view('player/pages/myaccount/js/change_payment_selection_js');

?>
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
        var amount = parseInt($('#moneyAmount').val());
        //console.log("Money Amount: " + amount);
        var game_credit = 0;
        if(!amount){
            amount = 0;
            $('#paymentContainer').hide();
        }else{
            $('#paymentContainer').show();
        }

        //Get selected payment type
        var paymentMethod = $("#currency_type").val();
        //console.log("Currency Type: " + paymentMethod);
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

        //console.log("Credit: " + game_credit);
        update_amount = game_credit.toFixed(2);
        
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

