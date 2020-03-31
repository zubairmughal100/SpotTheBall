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
    //Get stripe payment settings
    
    $paypal_cred = $paypal_payment_settings;

?>
<script>
  var add_amount = document.getElementById('creditAmount');
  var currency_type = document.getElementById('curreny_type').value;
  var lower_currency = currency_type.toUpperCase();
  paypal.Button.render({
    // Configure environment
    <?php if($paypal_cred[0]->payment_mode == "sandbox"){ ?>
          env: 'sandbox',
          client: {
            sandbox: '<?php echo $paypal_cred[0]->sandbox_public_key; ?>',
            production: '<?php echo $paypal_cred[0]->sandbox_secret_key; ?>'
          },
            <?php }else if($paypal_cred[0]->payment_mode == "live"){ ?>
          env: 'live',
          client: {
            sandbox: '<?php echo $paypal_cred[0]->live_public_key; ?>',
            production: '<?php echo $paypal_cred[0]->live_secret_key; ?>'
          },
      <?php } ?>

   
    // Customize button (optional)
    locale: 'en_US',
    style: {
      size: 'small',
      color: 'gold',
      shape: 'pill',
    },

    // Enable Pay Now checkout flow (optional)
    commit: true,

    // Set up a payment
    payment: function(data, actions) {
      return actions.payment.create({
        transactions: [{
          amount: {
            total: add_amount.value,
            currency: lower_currency
          }
        }]
      });
    },
    // Execute the payment
     //<?php //echo $base ?>/Authorization/paypalPayment'
    onAuthorize: function(data, actions) {
      return actions.payment.execute().then(function() {
        // Show a confirmation message to the buyer
      }).then(function(res) {
          return actions.request.post('<?php echo $base ?>/Authorization/paypalPayment', {
            // paymentID: data.paymentID,
            // payerID:   data.payerID,
            paymentID: data.paymentID,
            amount : add_amount.value,
            currency_type : lower_currency
          }).then(function(response) {
            window.location = '<?php echo $base ?>/account/settings';
          })
        });
    }
  }, '#paypal-button');

</script>