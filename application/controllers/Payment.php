<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {


    public function __construct(){
		parent::__construct();
                //Sripe
//                $this->config->item('stripe_secret');
//                $this->config->item('stripe_key');
                
                $this->load->helper('form');
            		$this->load->library('form_validation');
            		$this->load->helper('html');
                $this->load->helper('url');
                // Load session through controller
                $this->load->library('session');
//                $this->load->model('StripeTransactionsModel');

                $this->load->model('StripeTransactionsModel');
                $this->load->model('AccountTransactionsModel');
                $this->load->model('UserModel');
                $this->load->model('PaypalTransactionsModel');
                $this->load->model('BitcoinTransactionsModel');
                $this->load->model('GeneralSettingsModel');
                $this->load->model('PaymentSettingsModel');

                require_once('application/libraries/vendor/autoload.php');
    }

    private function currencyExchanger($money_amount_to_convert, $currencyType){
        $general_settings = $this->GeneralSettingsModel->getSettings();
        $game_credit = 0;
        if($currencyType == "eur"){
            $game_credit = $money_amount_to_convert + (($general_settings[0]->euro_conversion / 100) * $money_amount_to_convert);
        }else if($currencyType == "gbp"){
            $game_credit = $money_amount_to_convert + (($general_settings[0]->pound_conversion / 100) * $money_amount_to_convert);
        }else if($currencyType == "usd"){
            $game_credit = $money_amount_to_convert + (($general_settings[0]->dollar_conversion / 100) * $money_amount_to_convert);
        }else{
            //The likelyhood of this else conversion is zero
            $game_credit = $money_amount_to_convert + (($general_settings[0]->dollar_conversion / 100) * $money_amount_to_convert);
        }
        //$money_to_exchange = $money_amount_to_convert;
        //$exchange_rate = 1.12; //Should get from db
        //$exchange_value = $money_to_exchange * $exchange_rate;
        return $game_credit;
    }

    public function confirm_payment_stripe(){
    # vendor using composer
        //Get stripe settings
            $stripe_cred = $this->PaymentSettingsModel->getSettingsByID("stripe");

            if($stripe_cred[0]->payment_mode == "sandbox"){
                 \Stripe\Stripe::setApiKey($stripe_cred[0]->sandbox_secret_key);
             }else if($stripe_cred[0]->payment_mode == "live"){
                \Stripe\Stripe::setApiKey($stripe_cred[0]->live_secret_key);
            }

            // \Stripe\Stripe::setApiKey('sk_test_AWd5hxpmYBBSElucrFaOyCPl00jO5BmvZu');

            header('Content-Type: application/json');

            # retrieve json from POST body
            $json_str = file_get_contents('php://input');
            $json_obj = json_decode($json_str);

            $currency_code = $json_obj->currencyType;
            // echo $json_obj->currencyType;exit;
            // Need To Change
            if(!empty($json_obj->add_amount)){
            $amountMultiply = $json_obj->add_amount * 100;
          }
            $intent = null;
            try {
              if (isset($json_obj->payment_method_id)) {
                
                # Create the PaymentIntent
                $intent = \Stripe\PaymentIntent::create([
                  'payment_method' => $json_obj->payment_method_id,
                  'amount' => $amountMultiply,
                  'currency' => $currency_code,
                  'confirmation_method' => 'manual',
                  'confirm' => true,
                   'setup_future_usage' => 'off_session',
                ]);
                
//                print_r($intent->payment_method);exit;
                // This creates a new Customer and attaches the PaymentMethod in one API call.
                \Stripe\Customer::create([
//                  'id' => 1,
                  'payment_method' => $intent->payment_method,
//                    'save_payment_method' => true
                ]);
              }
              if (isset($json_obj->payment_intent_id)) {
                $intent = \Stripe\PaymentIntent::retrieve(
                  $json_obj->payment_intent_id
                );
                $intent->confirm();
              }
              $this->generatePaymentResponse($intent, $json_obj);
            } catch (\Stripe\Error\Base $e) {
              # Display error on client
              echo json_encode([
                'error' => $e->getMessage()
                ]);
              
            }
            
           
        }
 // Generic for Confirmation 3D Security
    public function generatePaymentResponse($intent , $json_obj) {
      # Note that if your API version is before 2019-02-11, 'requires_action'
      # appears as 'requires_source_action'.
      # 
      # 
     if ($intent->status == 'requires_action' &&
          $intent->next_action->type == 'use_stripe_sdk') {
        # Tell the client to handle the action
        echo json_encode([
          'requires_action' => true,
          'payment_intent_client_secret' => $intent->client_secret
        ]);
        
      } else if ($intent->status == 'succeeded') {
        # The payment didn’t need any additional actions and completed!
        # Handle post-payment fulfillment
       echo json_encode([
          "success" => true
        ]);
      } else {
        # Invalid status
        http_response_code(500);
        echo json_encode(['error' => 'Invalid PaymentIntent status']);
      }
      
      
      /***************************************
           * Insert Database Record Below
       ****************************************/
    
                                            
                  
          // Insert data here. You ca fetch data by | $intent | and |  $json_obj |
          $amountOfCredit = $json_obj->add_amount;
          $currencyType = $json_obj->currencyType;
          //echo $currencyType;exit;
          $payment_Id = $intent->id;
          $this->paymentsuccess("stripe", $amountOfCredit , $payment_Id, $currencyType);
    }

    // Paypal Payment
    public function paypalPayment(){
        $payment_Id = $_POST['paymentID'];
        $amountOfCredit = $_POST['amount'];
        $this->paymentsuccess("paypal", $amountOfCredit , $payment_Id, $currencyType);
        echo "PAID SUCCESSFULLY";exit;
    }
    

    // Success Page
    // public function successpayments(){
    //     echo "Success";exit;
    // }

    //This code is redundant, please do not use this function
    public function paymentsuccess($cardType, $payment_amount, $trn_id, $curreny_type){



        ///////////////////////////////////////////////////////////////////////////////
        // Check if the payment has been success
        ///////////////////////////////////////////////////////////////////////////////
        // Boolean $payment_success = true (Payment has been successful)
        // Boolean $payment_success = false (Payment has not been successful)
        // 
        /////////////////////////////////////////////////////////////////////////////////
        // Write code here to get determine if the payment was success
        // If redirecting to this function on a success call
        // Then leave $payment_success = true (default)
        $payment_success = true;
        /////////////////////////////////////////////////////////////////////////////////



        if($payment_success){
            ///////////////////////////////////////////////////////////////////////////////
            // Check payment type
            ///////////////////////////////////////////////////////////////////////////////
            // String $cardType = "stripe"
            // String $cardType = "paypal"
            // Stripe $cardType = "bitcoin"
            // Switch payment based on card type
            ///////////////////////////////////////////////////////////////////////////////
            // Get the card type from response or custom logic
            $cardType = "stripe";
            ///////////////////////////////////////////////////////////////////////////////

            //Get logged in user data
            $logged_in_data = $this->session->userdata('player_logged_in_data');
            $user_object = $this->UserModel->getUserByUsername($logged_in_data['username']);
            //print_r($user_object);exit;

            switch ($cardType) {
                case 'stripe':
                    //TO-DO
                    //echo "Hello stripe";
                    //Prepare stripe stripe_payment_object
                    $stripe_payment_object = array(
                        "user_id" => $user_object[0]->id,
                        "user_email" => $user_object[0]->email,
                        "full_name" => $user_object[0]->first_name. "" . $user_object[0]->last_name,
                        "trn_date" => date('d-m-Y'),
                        "trn_amount" => $payment_amount, //response object
                        "trn_stripe_id" => $trn_id, //response object
                        "trn_status" => 'completed'
                    );
                    //print_r($stripe_payment_object);exit;
                    $this->StripeTransactionsModel->insertIntoStripeTransactions($stripe_payment_object);
                    ///////////////////////////////////////////////////////////////////////////////
                    // Check payment type
                    ///////////////////////////////////////////////////////////////////////////////
                    // Transaction table data holds data about the above transaction
                    // However, this data is associated with users bank
                    // As shown in db each user must have bank account (just like a regular bank)
                    // Each bank account always have details of each transaction
                    // This table will have the amount in real currency
                    ///////////////////////////////////////////////////////////////////////////////
                    $accounttransaction_object = array(
                        "description" => "stripe_payment_".date('dmy').$user_object[0]->id,
                        "trn_date" => date('d-m-Y'),
                        "credit" => $payment_amount, //response object
                        "trn_status" => "1",
                        "user_id" => $user_object[0]->id
                    );
                    //insert into accounttransactions table which represents the banks transactions
                    if($this->AccountTransactionsModel->insertIntoAccountTransactions($accounttransaction_object)){
                        //echo "<br>Inserted into accounttransactions";
                        //Update bank account balance
                        $amount_to_update = $this->currencyExchanger($payment_amount, $curreny_type);
                        //echo $amount_to_update;exit;
                        //$amount_to_update = 10;
                        if($this->UserModel->updateAddedBalance( $amount_to_update, $user_object[0]->id )){
                        }
                    }
                    break;
                case 'paypal':
                    //TO-DO
                    //echo "Hello paypal";
                    //Prepare paypal paypal_payment_object
                    $paypal_payment_object = array(
                        "user_id" => $user_object[0]->id,
                        "user_email" => $user_object[0]->email,
                        "full_name" => $user_object[0]->first_name. "" . $user_object[0]->last_name,
                        "trn_date" => date('d-m-Y'),
                        "trn_amount" => $payment_amount, //response object
                        "trn_stripe_id" => $trn_id, //response object
                        "trn_status" => 'completed'
                    );
                    $this->PaypalTransactionsModel->insertIntoPayPalTransactions($paypal_payment_object);
                    ///////////////////////////////////////////////////////////////////////////////
                    // Check payment type
                    ///////////////////////////////////////////////////////////////////////////////
                    // Transaction table data holds data about the above transaction
                    // However, this data is associated with users bank
                    // As shown in db each user must have bank account (just like a regular bank)
                    // Each bank account always have details of each transaction
                    // This table will have the amount in real currency
                    ///////////////////////////////////////////////////////////////////////////////
                    $accounttransaction_object = array(
                        "description" => "paypal_payment_".date('dmy').$user_object[0]->id,
                        "trn_date" => date('d-m-Y'),
                        "credit" => $payment_amount, //response object
                        "trn_status" => "1",
                        "user_id" => $user_object[0]->id
                    );
                    //insert into accounttransactions table which represents the banks transactions
                    if($this->AccountTransactionsModel->insertIntoAccountTransactions($accounttransaction_object)){
                        //echo "<br>Inserted into accounttransactions";
                        //Update bank account balance
                        $amount_to_update = $this->currencyExchanger($payment_amount, $curreny_type);
                        //$amount_to_update = 10;
                        if($this->UserModel->updateAddedBalance( $amount_to_update, $user_object[0]->id )){
                        }
                    }
                    break;
                case 'bitcoin':
                    //TO-DO
                     //echo "Hello bitcoin";
                     // Prepare bitcoin bitcoin_payment_object
                     // Please modify/altrer bitcoin table to handle the data received from the bitcoin response
                     $bitcoin_payment_object = array(
                        "user_id" => $user_object[0]->id,
                        "user_email" => $user_object[0]->email,
                        "full_name" => $user_object[0]->first_name. "" . $user_object[0]->last_name,
                        "trn_date" => date('d-m-Y'),
                        "trn_amount" => $payment_amount, //response object
                        "trn_stripe_id" => $trn_id, //response object
                        "trn_status" => 'completed'
                    );
                    $this->BitcoinTransactionsModel->insertIntoBitcoinTransactions($payment_object);
                    ///////////////////////////////////////////////////////////////////////////////
                    // Check payment type
                    ///////////////////////////////////////////////////////////////////////////////
                    // Transaction table data holds data about the above transaction
                    // However, this data is associated with users bank
                    // As shown in db each user must have bank account (just like a regular bank)
                    // Each bank account always have details of each transaction
                    // This table will have the amount in real currency
                    ///////////////////////////////////////////////////////////////////////////////
                    $accounttransaction_object = array(
                        "description" => "bitcoin_payment_".date('dmy').$user_object[0]->id,
                        "trn_date" => date('d-m-Y'),
                        "credit" => $payment_amount, //response object
                        "trn_status" => "1",
                        "user_id" => $user_object[0]->id
                    );
                    //insert into accounttransactions table which represents the banks transactions
                    if($this->AccountTransactionsModel->insertIntoAccountTransactions($accounttransaction_object)){
                        //echo "<br>Inserted into accounttransactions";
                        //Update bank account balance
                        $amount_to_update = $this->currencyExchanger($payment_amount, $curreny_type);
                        //$amount_to_update = 10;
                        if($this->UserModel->updateAddedBalance( $amount_to_update, $user_object[0]->id )){
                        }
                    }
                    break;
                default:
                    //TO-DO
                    break;
            }

            //Update accoutn status
            $this->UserModel->updateAccountStatus("1", $user_object[0]->id);
            //Update user game credit balance


            //redirect('account/settings');
        }
    }
    
        
        
        
}