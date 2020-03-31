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
    $stripe_cred = $stripe_payment_settings;
    // print_r($stripe_cred);exit;

?>
<script type="text/javascript">

//    function preceedPay() {

            <?php if($stripe_cred[0]->payment_mode == "sandbox"){ ?>
                 var stripe = Stripe('<?php echo $stripe_cred[0]->sandbox_public_key; ?>');
            <?php }else if($stripe_cred[0]->payment_mode == "live"){ ?>
                var stripe = Stripe('<?php echo $stripe_cred[0]->live_public_key; ?>');
           <?php } ?>

            var elements = stripe.elements();
            var cardElement = elements.create('card');
            cardElement.mount('#card-element');


            var add_amount = document.getElementById('moneyAmount');
   
//            var order_id = document.getElementById('order_id');
//            var email = document.getElementById('email');



            var cardholderName = document.getElementById('cardName');
            var cardButton = document.getElementById('card-button');
            var currencyType = document.getElementById('currency_type');

            cardButton.addEventListener('click', function (ev) {
                stripe.createPaymentMethod('card', cardElement, {
                    billing_details: {name: cardholderName.value}
                }).then(function (result) {
                    if (result.error) {
                        $(".payment-status").html('<p>' + result.error.message + '</p>');
                    } else {
                        $('#card-button').prop("disabled", true);
                        // add spinner to button
                        $('#card-button').html(
                                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
                                );
                        // Otherwise send paymentMethod.id to your server (see Step 2)
                        fetch('<?php echo $base ?>/Payment/confirm_payment_stripe', {
                            method: 'POST',
                            headers: {'Content-Type': 'application/json'},
                            body: JSON.stringify({payment_method_id: result.paymentMethod.id, name: cardholderName.value, add_amount: add_amount.value,currencyType : currencyType.value})
                        }).then(function (result) {
                            // Handle server response (see Step 3)
                            result.json().then(function (json) {
                                handleServerResponse(json);
                            })
//                            window.location = "cancellation.php";
                        });
                    }
                });
            });
            
            function handleServerResponse(response) {
            console.log(response);
                if (response.error) {
                    // Show error from server on payment form
                    $(".payment-status").html('<p>' + response.error + '</p>');
                    $('#card-button').prop("disabled", false);
                    $('#card-button').html(
                                `Submit`
                                );
                } else if (response.requires_action) {
                    // Use Stripe.js to handle required card action
                    stripe.handleCardAction(
                            response.payment_intent_client_secret
                            ).then(function (result) {
                        if (result.error) {
                            // Show error in payment form
                            $('#card-button').prop("disabled", false);
                            $('#card-button').html(
                                        `Submit`
                                        );
                            $(".payment-status").html('<p>' + result.error.message + '</p>');
                        } else {
                            // The card action has been handled
                            // The PaymentIntent can be confirmed again on the server
                            fetch('<?php echo $base ?>/Payment/confirm_payment_stripe', {
                                method: 'POST',
                                headers: {'Content-Type': 'application/json'},
                                body: JSON.stringify({payment_intent_id: result.paymentIntent.id})
                            }).then(function (confirmResult) {
                                //Success
                                alert("PAID SUCCESSFULLY");
                                window.location = '<?php echo $base ?>/account/settings';
                                return confirmResult.json();
                            }).then(handleServerResponse);
                        }
                    });
                } else {
                    //Success
                     alert("PAID SUCCESSFULLY");
                     window.location = '<?php echo $base ?>/account/settings';
                }
            }
//    }
    
</script>