<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Authorization extends CI_Controller {





    public function __construct(){

        parent::__construct();

        $this->load->helper('form');

        $this->load->library('form_validation');

        $this->load->helper('html');

        $this->load->helper('url');



        $this->load->library('user_agent');



        // Load session through controller

        $this->load->library('session');

        

        //Load UserModel

        $this->load->model('UserModel');



        //World Settings

        $this->load->model('ContinentModel');

        $this->load->model('CountryModel');

        $this->load->model('StateModel');

        $this->load->model('CityModel');



        $this->load->model('AddressModel');



        $this->load->model('PaymentCardModel');

        $this->load->model('DocumentModel');



        $this->load->model('AccountTransactionsModel');

        $this->load->model('StripeTransactionsModel');

        $this->load->model('PaypalTransactionsModel');

        $this->load->model('BitcoinTransactionsModel');

        $this->load->model('BankAccountModel');



        $this->load->model('GeneralSettingsModel');



        $this->load->model('PaymentSettingsModel');

        $this->load->model('LoginActivityModel');

        $this->load->model('CISessionModel');



        //Stripe

        require_once('application/libraries/vendor/autoload.php');

    }



    private function getUserIpAddr(){

        if(!empty($_SERVER['HTTP_CLIENT_IP'])){

            //ip from share internet

            $ip = $_SERVER['HTTP_CLIENT_IP'];

        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){

            //ip pass from proxy

            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

        }else{

            $ip = $_SERVER['REMOTE_ADDR'];

        }

        return $ip;

    }

    private function getUserAgent(){

        if ($this->agent->is_browser())

        {

                $agent = $this->agent->browser().' '.$this->agent->version();

        }

        elseif ($this->agent->is_robot())

        {

                $agent = $this->agent->robot();

        }

        elseif ($this->agent->is_mobile())

        {

                $agent = $this->agent->mobile();

        }

        else

        {

                $agent = 'unknown';

        }

        return $agent;

    }



    public function index(){

        //Redirect to unauthorized

        redirect('authorization/unauthorized');

    }



    //Unauthorized view

    public function unauthorized(){

        $this->load->view('player/pages/auth/unauthorized_view');

    }

    



    public function authorizelogin(){
        $data['pagename'] = "login";

        //echo $this->session->session_id;exit;

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('login_error', 'You have entered invalid username or password!, Please try again.');
            redirect('account/login');
            //$this->load->view('player/pages/myaccount/login_view', $data);
        }else{
            $username = $this->input->post('username');
            $password = $this->input->post('password');

             //Get user id by username
            $user_authenticated = $this->UserModel->getUserByUsername($username);
            //print_r($user_authenticated);exit();

            if($user_authenticated != false){
                if($this->LoginActivityModel->isLoggedInSameIp($user_authenticated[0]->id, false)){
                    //echo "User is logged into another computer!";
                    
                    //Get the object
                    $user_object = $this->UserModel->verifyUser($username, $password);

                    //Get the last active login record
                    $last_active_record = $this->LoginActivityModel->getLastActive($user_object[0]->id);
                    //print_r($last_active_record);exit;

                    $current_session = $this->CISessionModel->getSessionByID($last_active_record[0]->session_id);
                    //print_r($current_session);exit;
                    
                    //Update the login activity record
                    $this->LoginActivityModel->expireLoginActivity($user_object[0]->id, $last_active_record[0]->session_id);
                    
                    $this->CISessionModel->deleteCiSession($current_session[0]->id);
                    // if($this->CISessionModel->deleteCiSession($current_session[0]->id)){
                    //     echo "user should have been logged out, session deleted";
                    // }

                    // $sess_array = array(
                    //     'id' => $user_object[0]->id,
                    //     'title' => $user_object[0]->title,
                    //     'username' => $user_object[0]->username,
                    //     'first_name' => $user_object[0]->first_name,
                    //     'last_name' => $user_object[0]->last_name,
                    //     'status' => $user_object[0]->status,
                    //     //'expire' => time()+60*60*24*365,
                    //     'logged_in' => TRUE
                    // );
                    // $this->session->unset_userdata($sess_array);
                    // echo "User should be logged out from other ip!";
                    // exit;
                }else{
                    //echo "all good";
                }
            }

            //exit;
            
            //Regenerate session_id
            //$this->session->sess_regenerate();
            //echo $this->session->session_id;exit;
            
            //echo "Username: " .$username;

            //echo "<br>Password: " .$password;exit;
            //$loggin_session_id = $this->generateRandomString(30);
            //echo $loggin_session_id;exit;

            if($this->verify_login($username, $password) == true){

                $this->session->set_flashdata('login_success', 'You have successfully logged into our system.');
                //echo $this->session->session_id;
                
                //Get logged in user data
                $user = $this->session->userdata('player_logged_in_data');
                
                //$user = $this->session->all_userdata();
                //print_r($user);exit;

                //Insert into loginactivity
                $login_activity_data = array(
                    "session_id" => $this->session->session_id,
                    "activity_type" => "login",
                    "ip_address" => $this->getUserIpAddr(),
                    "user_agent" => $this->getUserAgent(),
                    "user_id" => $user['id'],
                    "session_status" => "1"
                );
                //print_r($login_activity_data);exit;
                $this->LoginActivityModel->insertLoginActivity($login_activity_data);
                redirect('account/settings');
            }else{
                $this->session->set_flashdata('login_error', 'Wrong username or password, please try again.');
                redirect('account/login');
            }

        } 

    }


    //Call db and pass username and password and verify that the user exists

    private function verify_login($username, $password){

        $user_found = false;

        $user_object = $this->UserModel->verifyUser($username, $password);

        //print_r($user_object);exit;

        //If not false we have a user matching

        if($user_object != false){

            //print_r($user_object);

            if($user_object[0]->status == '3'){

               $this->session->set_flashdata('login_banned', 'This account has been banned!');

                redirect('account/login'); 

            }else{

                if($user_object[0]->two_factor_login==1 && $user_object[0]->fa_token!=null)

                {

                    $_SESSION['userid']=$user_object[0]->id;

                    $_SESSION['secret']=$user_object[0]->fa_token;



                     redirect("authorization/createQr");

                    

                }

                else{
                    
                    $sess_array = array(
                        'id' => $user_object[0]->id,
                        'title' => $user_object[0]->title,
                        'username' => $user_object[0]->username,
                        'first_name' => $user_object[0]->first_name,
                        'last_name' => $user_object[0]->last_name,
                        'status' => $user_object[0]->status,
                        //'expire' => time()+60*60*24*365,
                        'logged_in' => TRUE
                    );
                    $this->session->set_userdata('player_logged_in_data', $sess_array);

                }

                $user_found =  true;

            }

        }

        return $user_found;

    }



    public function logout(){

        if($this->session->userdata('player_logged_in_data')){
            //Get logged in user data
            $user = $this->session->userdata('player_logged_in_data');
            //$user = $this->session->all_userdata();
            //print_r($user);exit;
            
            //Get the last active login record
            $last_active_record = $this->LoginActivityModel->getLastActive($user['id']);
            //print_r($last_active_record);exit;

            //print_r($login_activity_data);exit;
            //Update the login activity record
            $this->LoginActivityModel->expireLoginActivity($user['id'], $last_active_record[0]->session_id);

            $this->session->unset_userdata('player_logged_in_data');
        }

        redirect('account/login');

    }



    public function createQr()

    {

      if(!$_SESSION['userid'] && !$_SESSION["secret"])

      {

        redirect('account/login');

      }

      $this->load->library('GoogleAuthenticator');

      $user=$_SESSION['userid'];

      $secret=$_SESSION['secret'];

        session_destroy();

      $data['secret']=$secret;

      $data['userid']=$user;

      $this->load->view('player/pages/myaccount/scanqr',$data);

    }



    public function processTwoFactor()

    {

        $userid=$this->input->post('userid');

        $code=$this->input->post("code");

        $secret=$this->input->post("secret");

        // echo $secret;exit;

        $this->load->library('GoogleAuthenticator');

        $ga = new GoogleAuthenticator();

        $checkResult = $ga->verifyCode($secret,$code,2); 

        if($checkResult)

        {

            

            $userobject=$this->UserModel->getSingleUserById($userid);

            // echo $userid;exit;

            // echo '<pre>',print_r($userobject[0]);

            $sess_array = array(

                'id' => $userobject[0]->id,

                'title' => $userobject[0]->title,

                'username' => $userobject[0]->username,

                'first_name' => $userobject[0]->first_name,

                'last_name' => $userobject[0]->last_name,

                'status' => $userobject[0]->status,

                'two_factor_login'=>$userobject[0]->two_factor_login,

                'expire' => time()+60*60*24*365,

            );

            $this->session->set_userdata('player_logged_in_data', $sess_array);

            // echo '<pre>',print_r($this->session->userdata('player_logged_in_data', $sess_array));exit;

            $this->session->set_flashdata('login_success', 'You have successfully logged into our system.');

                redirect('account/settings');



        }

        else{

            $this->session->set_flashdata('login_banned', 'Login Failed Bad Credentials try again');

                redirect('account/login'); 

        }

    }

    





    //Check duplicate user

    public function duplicateUsernameFound($username){

        if($this->UserModel->userExistsByUsername($username) == true){

            $this->form_validation->set_message('username_check', 'Duplicate user found');

            return true;

        }else{

            return false;

        }

    }

    public function duplicateEmailFound($email){

        if($this->UserModel->userExistsByEmail($email) == true){

            $this->form_validation->set_message('email_check', 'Duplicate email found');

            return true;

        }else{

            return false;

        }

    }

    



    //Signup proccess

    public function getsignupdetails(){

        //Get general settings

        $general_settings = $this->GeneralSettingsModel->getSettings();

        //Serverside form validation

        $this->form_validation->set_rules('title', 'Title', 'required');

        $this->form_validation->set_rules('firstName', 'First Name', 'required');

        $this->form_validation->set_rules('lastName', 'Last Name', 'required');

        $this->form_validation->set_rules('dobDay', 'Day', 'required');

        $this->form_validation->set_rules('dobMonth', 'Month', 'required');

        $this->form_validation->set_rules('dobYear', 'Year', 'required');

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');



        $this->form_validation->set_rules('country_id', 'Country', 'required');

        //$this->form_validation->set_rules('state', 'State', 'required');

        //$this->form_validation->set_rules('postCode', 'Postal Code', 'required');

        $this->form_validation->set_rules('addressLineOne', 'Address', 'required');

        //$this->form_validation->set_rules('addressLineTwo', 'Address', 'required');

        //$this->form_validation->set_rules('townCity', 'Town / City', 'required');

        $this->form_validation->set_rules('phone', 'Phone', 'required|min_length[8]');



        //$this->form_validation->set_rules('drivingLicenseOrPassportFile', 'Driving License or Passport', 'required');

        //$this->form_validation->set_rules('utilityBillFile', 'Utility bill', 'required');

        //$this->form_validation->set_rules('bankStatementFile', 'Bank statement', 'required');



        $this->form_validation->set_rules('username', 'Username', 'required');

        $this->form_validation->set_rules('password', 'Password', 'required');

        $this->form_validation->set_rules('confirmPassword', 'Confirm password', 'required|matches[password]');



        //$this->form_validation->set_rules('moneyAmount', 'Amount', 'required');

        //$this->form_validation->set_rules('amountType', 'Currency', 'required');

        //$this->form_validation->set_rules('creditAmount', 'Credit amount', 'required');



        /*

        $this->form_validation->set_rules('paymentMethod', 'Payment method', 'required');



        

        $this->form_validation->set_rules('cardName', 'Card name', 'required');

        $this->form_validation->set_rules('cardNumber', 'Card number', 'required');

        $this->form_validation->set_rules('cardExpiryMonth', 'Card expiry month', 'required');

        $this->form_validation->set_rules('cardExpiryYear', 'Card expiry year', 'required');

        $this->form_validation->set_rules('cardCVV', 'Card cvv', 'required');

        */



        /*

        $this->form_validation->set_rules('agree', 'Card cvv', 'required',

            array('required' => 'You must agree to our terms of service.')

        );



        //Set delimiters

        $this->form_validation->set_error_delimiters('<div class="text-danger text-left"><small>', '</small></div>');

        */



        if($this->form_validation->run() == FALSE){

            $data['pagename'] = "signup";



            //get list of available countries

            $data['countries'] = $this->CountryModel->getAllCountries();



            //Set error message

            $this->session->set_flashdata('form_validation_error', 'Please check any fields marked in red, re-select documents &amp; re-enter password!');

    

            $this->load->view('player/pages/myaccount/signup_view', $data);

        }else{

            //Get title {Mr, Miss, Mrs}

            $title = $this->input->post('title');

            //Get first name

            $firstName = $this->input->post('firstName');

            //Get last name

            $lastName = $this->input->post('lastName');



            //Get dob.day

            $dobDay = $this->input->post('dobDay');

            //Get dob.month

            $dobMonth = $this->input->post('dobMonth');

            //Get dob.year

            $dobYear = $this->input->post('dobYear');

            //Create date of birth date()



            //Get email

            $email = $this->input->post('email');



            //Get country

            $country = $this->input->post('country_id');

            //Get state

            $state = $this->input->post('state_id');

            //Get city

            $city = $this->input->post('city_id');

            //Get address line 1

            $addressLineOne = $this->input->post('addressLineOne');

            //Get address line 2

            $addressLineTwo = $this->input->post('addressLineTwo');

            //Get city / town

            $cityTown = $this->input->post('townCity');

            //Get postal code

            $postCode= $this->input->post('postCode');

            //Get phone number

            $phone = $this->input->post('phone');



            //Get driving license / Passport

            $licensePassport = $this->input->post('drivingLicenseOrPassportFile');

            //Get utility bill

            $utilityBill = $this->input->post('utilityBillFile');

            //Get bank statement

            $bankStatement = $this->input->post('bankStatementFile');



            //Get username

            $username = $this->input->post('username');

            //Get password

            $password = $this->input->post('password');

            //Get confirm password

            $confirmPassword = $this->input->post('confirmPassword');

            

            //Get recharge real currency amount

            $currency = $this->input->post('moneyAmount');

            //Get currency / type

            $currencyType = $this->input->post('amountType');

            //Get converted amount

            $convertedAmount = $this->input->post('creditAmount');

            //Set price value into session

            //$this->session->set_userdata('amount_value', $currency);

            //$this->session->set_userdata('credit_amount', $convertedAmount);



            /*

            //Get type of payment method

            $paymentMethod = $this->input->post('paymentMethod');



            //Get card name

            $cardName = $this->input->post('cardName');

            //Get card number

            $cardNumber = $this->input->post('cardNumber');

            //Get card expiry month

            $cardExpiryMonth = $this->input->post('cardExpiryMonth');

            //Get card expiry year

            $cardExpiryYear = $this->input->post('cardExpiryYear');

            //Get card cvv

            $cardCVV = $this->input->post('cardCVV');

            */



            //User agreement

            $iAgree = $this->input->post('agree');



            //Generate unique user id

            $unique_user_id = $this->GenerateUniqueUserID();





            $state_name = "null";

            if(!empty($state)){

                $tmp_state_name = $this->StateModel->getStateNameByID($state);

                if($tmp_state_name != false){

                    $state_name = $tmp_state_name;

                }

            }





            //Prepare array for [user] table

            $user_object = array(

                "id" => $unique_user_id,

                "title" => $title,

                "email" => $email,

                "password" => md5($password),

                "username" => $username,

                "first_name" => $firstName,

                "last_name" => $lastName,

                "dob_day" => $dobDay,

                "dob_month" => $dobMonth,

                "dob_year" => $dobYear,

                "phone" => $phone,

                "tc_agree" => $iAgree,

                "ip" => $this->getUserIpAddr(),

                "browser" => $this->getUserAgent(),

                "country_id" => $country,

                "state" => $state_name,

                "current_level" => 0,

                "balance" => 0,

                "isDemoAccount" => '0',

                "demo_balance" => '0',

                "status" => '0'

            );

            //print_r($user_object);

            //Set user_object into session

            //$this->session->set_userdata('user_object', $user_object);

            

            //Unique address id

            $unique_address_id = $this->GenerateUniqueAddressID();

            //Prepare array for [address] table

            $address_object = array(

                "id" => $unique_address_id,

                "first_name" => $firstName,

                "last_name" => $lastName,

                "phone" => $phone,

                "address_line1" => $addressLineOne,

                "address_line2" => $addressLineTwo,

                "town" => $cityTown,

                "city" =>  $this->CityModel->getCityNameByID($city),

                "state" => $state_name,

                "country" => $this->CountryModel->getCountryNameByID($country),

                "post_code" => $postCode,

                "user_id" => $unique_user_id

            );

            //print_r($address_object);exit;

            //Set address_object into session

            //$this->session->set_userdata('address_object', $address_object);



            ///////////////////////////////////////////////////////////////////////////////

            // Setup a bank account for the user

            ///////////////////////////////////////////////////////////////////////////////

            // Prepare bank account data

            // Bank account will hold data about game currency

            // This is currency converted from the transaction amount

            // Each bank account opens with 0 (Zero) balance

            ///////////////////////////////////////////////////////////////////////////////

            /*

            $account_number = $this->GenerateUniqueBankAccountNumber();

            $bank_account_object = array(

                "id" => $account_number,

                "balance" => 0,

                "last_update_date" => date('d-m-Y'),

                "user_id" => $user_object['id']

            );

            */

            //Set bank_account_object into session

            //$this->session->set_userdata('bank_account_object', $bank_account_object);



            //If duplicate user not found proceed with data and insert into db

            if($this->UserModel->userExistsByUsername($username) == false || $this->UserModel->userExistsByEmail($email) == false){

                //Call the success function

                $this->proccesssignup($user_object, $address_object);



                //

                //$data['pagename'] = "myaccount";

                //load payment view

                //$this->load->view('player/pages/payment/payment_view', $data);

                

            } 

        }

    }

    // Paypal Payment

    public function paypalPayment(){

        $payment_Id = $_POST['paymentID'];

        $amountOfCredit = $_POST['amount'];

        $currency_type = $_POST['currency_type'];

        $this->paymentsuccess("paypal", $amountOfCredit , $payment_Id, $currency_type);

        redirect('account/settings');

    }





    // Stripe Payment Request

    public function stripepayment(){

        //Get stripe payment settings

        $data['stripe_payment_settings'] = $this->PaymentSettingsModel->getSettingsByID("stripe");

        

        $stripe_cred = $data['stripe_payment_settings'];

        

        //Get PayPal Settings

        $data['paypal_payment_settings'] = $this->PaymentSettingsModel->getSettingsByID("paypal");



        //Get Crypto Settings

        $data['crypto_payment_settings'] = $this->PaymentSettingsModel->getSettingsByID("crypto");

        //print_r($data['crypto_payment_settings']);exit;



        # vendor using composer

        if($stripe_cred[0]->payment_mode == "sandbox"){

            \Stripe\Stripe::setApiKey($stripe_cred[0]->sandbox_secret_key);

        }else if($stripe_cred[0]->payment_mode == "live"){

            \Stripe\Stripe::setApiKey($stripe_cred[0]->live_public_key);

        }







        header('Content-Type: application/json');



        # retrieve json from POST body

        $json_str = file_get_contents('php://input');

        $json_obj = json_decode($json_str);



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

              'currency' => $json_obj->currency_type,

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

          $this->generatePaymentResponse($intent, $json_obj, $json_obj->currency_type);

          //echo "<pre>";

          //print_r($abc);exit;

        } catch (\Stripe\Error\Base $e) {

          # Display error on client

          echo json_encode([

            'error' => $e->getMessage()

            ]);

          

        }

    }

        // Generic for Confirmation 3D Security

        public function generatePaymentResponse($intent , $json_obj, $currency_type) {

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

            // Example -> $json_obj->email

              // echo '<pre>';

              // print_r($intent);

              // echo '---------------------------------------------------';

              // echo "\r\n";

              // print_r($json_obj);exit;

              $amountOfCredit = $json_obj->add_amount;

              $payment_Id = $intent->id;

              $this->paymentsuccess("stripe", $amountOfCredit , $payment_Id, $currency_type);

              //echo "<pre>";

              //print_r($abcd);exit;

        }

        //Paypal Method

        



        

        //Initial commit

        public function teststripe(){

            $this->paymentsuccess("stripe", 10, "12125sadasdasd");

        }



        public function proccesstestupload(){

            //Get file extension before upload

            $fileExt = pathinfo($_FILES["myFile"]["name"], PATHINFO_EXTENSION);

      

            echo $fileExt;



            /*

            //Upload document

            $file_name = $this->uploadAndResizeDocument("myFile", "account_documents", "201954875214", "bank_statement");



            if (empty($file_name) || $file_name == false)

            {

                    echo "<br>Uplaod failed";



                    $this->load->view('player/pages/myaccount/test/upload_pdf');

            }

            else

            {

                echo $file_name ." uploaded successfully!<hr>";

                echo "<br><a href='http://localhost/SpotTheBallUKClient/index.php/authorization/testupload'>Upload Again</a>";

            }*/



            /*

            //Upload image

            $file_name = $this->uploadAndResizeImage("myImage", "account_documents", "2019105487595", "utility_bill");

            if (empty($file_name) || $file_name == false)

            {

                    echo "<br>Uplaod failed";



                    $this->load->view('player/pages/myaccount/test/upload_pdf');

            }

            else

            {

                echo $file_name ." uploaded successfully!<hr>";

                echo "<br><a href='http://localhost/SpotTheBallUKClient/index.php/authorization/testupload'>Upload Again</a>";

            }

            */



            /*

            //Delete image

            if($this->deletefile("assets/account_documents", "utility_bill_2019105487595.jpg")){

                echo "2019105487595 deleted successfully!";

            }else{

                echo "2019105487595 was not deleted successfully";

            }

            */

        }



        /*

    private function currencyExchanger($money_amount_to_convert){

        $money_to_exchange = $money_amount_to_convert;

        $exchange_rate = 1.12; //Should get from db

        $exchange_value = $money_to_exchange * $exchange_rate;

        return $exchange_value;

    }

    */

   

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







    //This code is redundant, please do not use this function

    public function paymentsuccess($cardType, $payment_amount, $trn_id, $currency_type){







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

                        $amount_to_update = $this->currencyExchanger($payment_amount, $currency_type);

                        //$amount_to_update = 10;

                        if($this->UserModel->updateBalance( $amount_to_update, $user_object[0]->id )){

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

                        $amount_to_update = $this->currencyExchanger($payment_amount, $currency_type);

                        //$amount_to_update = 10;

                        if($this->UserModel->updateBalance( $amount_to_update, $user_object[0]->id )){

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

                        $amount_to_update = $this->currencyExchanger($payment_amount, $currency_type);

                        //$amount_to_update = 10;

                        if($this->UserModel->updateBalance( $amount_to_update, $user_object[0]->id )){

                        }

                    }

                    break;

                default:

                    //TO-DO

                    break;

            }



            //Update accoutn status

            $this->UserModel->updateAccountStatus("1", $user_object[0]->id);



            //redirect('account/settings');

        }

    }





    public function reuploadproofofid(){

        if($this->session->userdata('player_logged_in_data')){

            if(!empty($_FILES['file_proof_of_id']['name'])){

                //Get document id

                $id = $this->input->post('id');

                //get old file name

                $old_file_name = $this->input->post('old_file');



                $logged_in_data = $this->session->userdata('player_logged_in_data');



                //Get just user info by username

                $user_object = $this->UserModel->getUserByUsername($logged_in_data['username']);



                //Get driving license or passport file extension

                $drivingLicenseOrPassportFileExt = pathinfo($_FILES["file_proof_of_id"]["name"], PATHINFO_EXTENSION);

                //Upload driving license or passport and store file name, so it can be used to unlink if error takes place

                $drivingLicenseOrPassportFileName = "";

                //Set a flag to store if upload was successfull

                $drivingLicenseOrPassportFileUploadStatus = false;

                //Check if the file type is either pdf|doc

                

                //Delete the old file

                $this->deletefile("assets/account_documents", $old_file_name);



                if($drivingLicenseOrPassportFileExt == "pdf" || $drivingLicenseOrPassportFileExt == "doc"){

                    //User is uploading a document type either pdf or doc

                    $uploaded_file_name = $this->uploadAndResizeDocument("file_proof_of_id", "account_documents", $user_object[0]->id, "proof_of_id");



                    if(!empty($uploaded_file_name)){

                        $update_object = array(

                            "image_url" => $uploaded_file_name

                        );

                        if($this->DocumentModel->updateDocument($id, $update_object)){

                            $this->session->set_flashdata('update_success', "You have successfully re-uploaded proof of ID!");

                        }else{

                            $this->session->set_flashdata('update_fail', "Proof of ID could not been re-uploaded!");

                        }

                    }else{

                        $this->session->set_flashdata('update_fail', "Proof of ID could not been re-uploaded!");

                    }

                //Check if the file type is either jpg|png|jpeg

                }else if($drivingLicenseOrPassportFileExt == "jpg" || $drivingLicenseOrPassportFileExt == "png" || $drivingLicenseOrPassportFileExt == "jpeg"){

                    //User is uploading a image

                    $uploaded_file_name = $this->uploadAndResizeImage("file_proof_of_id", "account_documents", $user_object[0]->id, "proof_of_id");

                    if(!empty($uploaded_file_name)){

                        $update_object = array(

                            "image_url" => $uploaded_file_name

                        );

                        if($this->DocumentModel->updateDocument($id, $update_object)){

                            $this->session->set_flashdata('update_success', "You have successfully re-uploaded proof of ID!");

                        }else{

                            $this->session->set_flashdata('update_fail', "Proof of ID could not been re-uploaded!");

                        }

                    }else{

                        $this->session->set_flashdata('update_fail', "Proof of ID could not been re-uploaded!");

                    }

                }else{

                    $this->session->set_flashdata('update_fail', "You have selected invalid file type!");

                }

            }else{

                $this->session->set_flashdata('update_fail', "Please select a file");

            }

            redirect('account/uploaddocuments');

        }else{

            redirect('account/login');

        }

    }



    public function reuploadutility(){

        if($this->session->userdata('player_logged_in_data')){

            if(!empty($_FILES['file_utility_bill']['name'])){

                //Get document id

                $id = $this->input->post('id');

                //get old file name

                $old_file_name = $this->input->post('old_file');



                $logged_in_data = $this->session->userdata('player_logged_in_data');



                //Get just user info by username

                $user_object = $this->UserModel->getUserByUsername($logged_in_data['username']);



                //Get driving license or passport file extension

                $drivingLicenseOrPassportFileExt = pathinfo($_FILES["file_utility_bill"]["name"], PATHINFO_EXTENSION);

                //Upload driving license or passport and store file name, so it can be used to unlink if error takes place

                $drivingLicenseOrPassportFileName = "";

                //Set a flag to store if upload was successfull

                $drivingLicenseOrPassportFileUploadStatus = false;



                //Delete the old file

                $this->deletefile("assets/account_documents", $old_file_name);



                //Check if the file type is either pdf|doc

                if($drivingLicenseOrPassportFileExt == "pdf" || $drivingLicenseOrPassportFileExt == "doc"){

                    //User is uploading a document type either pdf or doc

                    $uploaded_file_name = $this->uploadAndResizeDocument("file_utility_bill", "account_documents", $user_object[0]->id, "utility_bill");

                    if(!empty($uploaded_file_name)){

                        $update_object = array(

                            "image_url" => $uploaded_file_name

                        );

                        if($this->DocumentModel->updateDocument($id, $update_object)){

                            $this->session->set_flashdata('update_success', "You have successfully re-uploaded utility bill!");

                        }else{

                            $this->session->set_flashdata('update_fail', "Utility bill could not been re-uploaded!");

                        }

                    }else{

                        $this->session->set_flashdata('update_fail', "Utility bill could not been re-uploaded!");

                    }

                //Check if the file type is either jpg|png|jpeg

                }else if($drivingLicenseOrPassportFileExt == "jpg" || $drivingLicenseOrPassportFileExt == "png" || $drivingLicenseOrPassportFileExt == "jpeg"){

                    //User is uploading a image

                    $uploaded_file_name = $this->uploadAndResizeImage("file_utility_bill", "account_documents", $user_object[0]->id, "utility_bill");

                    if(!empty($uploaded_file_name)){

                        $this->session->set_flashdata('update_success', "You have successfully re-uploaded utility bill!");

                    }else{

                        $this->session->set_flashdata('update_fail', "Utility bill could not been re-uploaded!");

                    }

                }else{

                    $this->session->set_flashdata('update_fail', "You have selected invalid file type!");

                }

            }else{

                $this->session->set_flashdata('update_fail', "Please select a file");

            }

            redirect('account/uploaddocuments');

        }else{

            redirect('account/login');

        }

    }



    public function reuploadbankstatement(){

        if($this->session->userdata('player_logged_in_data')){

            if(!empty($_FILES['file_bank_statement']['name'])){

                //Get document id

                $id = $this->input->post('id');

                //get old file name

                $old_file_name = $this->input->post('old_file');



                $logged_in_data = $this->session->userdata('player_logged_in_data');



                //Get just user info by username

                $user_object = $this->UserModel->getUserByUsername($logged_in_data['username']);



                //Get driving license or passport file extension

                $drivingLicenseOrPassportFileExt = pathinfo($_FILES["file_bank_statement"]["name"], PATHINFO_EXTENSION);

                //Upload driving license or passport and store file name, so it can be used to unlink if error takes place

                $drivingLicenseOrPassportFileName = "";

                //Set a flag to store if upload was successfull

                $drivingLicenseOrPassportFileUploadStatus = false;



                //Delete the old file

                $this->deletefile("assets/account_documents", $old_file_name);



                //Check if the file type is either pdf|doc

                if($drivingLicenseOrPassportFileExt == "pdf" || $drivingLicenseOrPassportFileExt == "doc"){

                    //User is uploading a document type either pdf or doc

                    $uploaded_file_name = $this->uploadAndResizeDocument("file_bank_statement", "account_documents", $user_object[0]->id, "bank_statement");

                    if(!empty($uploaded_file_name)){

                        $update_object = array(

                            "image_url" => $uploaded_file_name

                        );

                        if($this->DocumentModel->updateDocument($id, $update_object)){

                            $this->session->set_flashdata('update_success', "You have successfully re-uploaded bank statement!");

                        }else{

                            $this->session->set_flashdata('update_fail', "Bank statement could not been re-uploaded!");

                        }

                    }else{

                        $this->session->set_flashdata('update_fail', "Bank statement could not been re-uploaded!");

                    }

                //Check if the file type is either jpg|png|jpeg

                }else if($drivingLicenseOrPassportFileExt == "jpg" || $drivingLicenseOrPassportFileExt == "png" || $drivingLicenseOrPassportFileExt == "jpeg"){

                    //User is uploading a image

                    $uploaded_file_name = $this->uploadAndResizeImage("file_bank_statement", "account_documents", $user_object[0]->id, "bank_statement");

                    if(!empty($uploaded_file_name)){

                        $this->session->set_flashdata('update_success', "You have successfully re-uploaded bank statement!");

                    }else{

                        $this->session->set_flashdata('update_fail', "Bank statement could not been re-uploaded!");

                    }

                }else{

                    $this->session->set_flashdata('update_fail', "You have selected invalid file type!");

                }

            }else{

                $this->session->set_flashdata('update_fail', "Please select a file");

            }

            redirect('account/uploaddocuments');

        }else{

            redirect('account/login');

        }

    }

    



    //Verify and proccess signup data

    private function proccesssignup($user_object, $address_object){

       //Get driving license or passport file extension

        $drivingLicenseOrPassportFileExt = pathinfo($_FILES["drivingLicenseOrPassportFile"]["name"], PATHINFO_EXTENSION);

        //Upload driving license or passport and store file name, so it can be used to unlink if error takes place

        $drivingLicenseOrPassportFileName = "";

        $drivingLicenseOrPassportFileObject = array();

        //Set a flag to store if upload was successfull

        $drivingLicenseOrPassportFileUploadStatus = false;

        //Check if the file type is either pdf|doc

        if($drivingLicenseOrPassportFileExt == "pdf" || $drivingLicenseOrPassportFileExt == "doc"){

            //User is uploading a document type either pdf or doc

            $drivingLicenseOrPassportFileName = $this->uploadAndResizeDocument("drivingLicenseOrPassportFile", "account_documents", $user_object['id'], "proof_of_id");

            //Set upload flag to true

            if($drivingLicenseOrPassportFileName != false){

                $drivingLicenseOrPassportFileUploadStatus = true;

                //echo "<br>drivingLicenseOrPassportFileUploadStatus true";

                $drivingLicenseOrPassportFileObject = array(

                    "image_url" => $drivingLicenseOrPassportFileName,

                    "document_type" => "proof_of_id",

                    "approved" => '0',

                    "userid" => $user_object['id']

                );

            }

        //Check if the file type is either jpg|png|jpeg

        }else if($drivingLicenseOrPassportFileExt == "jpg" || $drivingLicenseOrPassportFileExt == "png" || $drivingLicenseOrPassportFileExt == "jpeg"){

            //User is uploading a image

            $drivingLicenseOrPassportFileName = $this->uploadAndResizeImage("drivingLicenseOrPassportFile", "account_documents", $user_object['id'], "proof_of_id");

            //Set upload flag to true

            if($drivingLicenseOrPassportFileName != false){

                $drivingLicenseOrPassportFileUploadStatus = true;

                //echo "<br>drivingLicenseOrPassportFileUploadStatus true";

                $drivingLicenseOrPassportFileObject = array(

                    "image_url" => $drivingLicenseOrPassportFileName,

                    "document_type" => "proof_of_id",

                    "approved" => '0',

                    "userid" => $user_object['id']

                );

            }

        }else{

            //This means user may have tweaked the file using some plugin or malicious attack/attempt to upload invalid file and fool the system

            $drivingLicenseOrPassportFileUploadStatus = false;

            //Set file name for deletion

            $drivingLicenseOrPassportFileName = "proof_of_id_".$user_object['id'].".".$drivingLicenseOrPassportFileExt;

        }



        //Get utility bill file extension

        $utilityBillFileExt = pathinfo($_FILES["utilityBillFile"]["name"], PATHINFO_EXTENSION);

        //Upload utility bill and store file name, so it can be used to unlink if error takes place

        $utilityBillFileFileName = "";

        $utilityBillFileFileObject = array();

        //Set a flag to store if upload was successfull

        $utilityBillFileStatus = false;

        //Check if the file type is either pdf|doc

        if($utilityBillFileExt == "pdf" || $utilityBillFileExt == "doc"){

            //User is uploading a document type either pdf or doc

            $utilityBillFileFileName = $this->uploadAndResizeDocument("utilityBillFile", "account_documents", $user_object['id'], "utility_bill");

            //Set upload flag to true

            if($utilityBillFileFileName != false){

                $utilityBillFileStatus = true;

                //echo "<br>utilityBillFileStatus true";

                $utilityBillFileFileObject = array(

                    "image_url" => $utilityBillFileFileName,

                    "document_type" => "utility_bill",

                    "approved" => '0',

                    "userid" => $user_object['id']

                );

            }

        //Check if the file type is either jpg|png|jpeg

        }else if($utilityBillFileExt == "jpg" || $utilityBillFileExt == "png" || $utilityBillFileExt == "jpeg"){

            //User is uploading a image

            $utilityBillFileFileName = $this->uploadAndResizeImage("utilityBillFile", "account_documents", $user_object['id'], "utility_bill");

            //Set upload flag to true

            if($utilityBillFileFileName != false){

                $utilityBillFileStatus = true;

                //echo "<br>utilityBillFileStatus true";

                $utilityBillFileFileObject = array(

                    "image_url" => $utilityBillFileFileName,

                    "document_type" => "utility_bill",

                    "approved" => '0',

                    "userid" => $user_object['id']

                );

            }

        }else{

            //This means user may have tweaked the file using some plugin or malicious attack/attempt to upload invalid file and fool the system

            $utilityBillFileStatus = false;

            //Set file name for deletion

            $utilityBillFileFileName = "utility_bill".$user_object['id'].".".$utilityBillFileExt;

        }



        //Get bank statement file extension

        $bankStatementFileExt = pathinfo($_FILES["bankStatementFile"]["name"], PATHINFO_EXTENSION);

        //Upload bank statement and store file name, so it can be used to unlink if error takes place

        $bankStatementFileName = "";

        $bankStatementFileObject = array();

        //Set a flag to store if upload was successfull

        $bankStatementFileStatus = false;

        //Check if the file type is either pdf|doc

        if($bankStatementFileExt == "pdf" || $bankStatementFileExt == "doc"){

            //User is uploading a document type either pdf or doc

            $bankStatementFileName = $this->uploadAndResizeDocument("bankStatementFile", "account_documents", $user_object['id'], "bank_statement");

            //Set upload flag to true

            if($bankStatementFileName != false){

                $bankStatementFileStatus = true;

                //echo "<br>bankStatementFileStatus true";

                $bankStatementFileObject = array(

                    "image_url" => $bankStatementFileName,

                    "document_type" => "bank_statement",

                    "approved" => '0',

                    "userid" => $user_object['id']

                );

            }

        //Check if the file type is either jpg|png|jpeg

        }else if($bankStatementFileExt == "jpg" || $bankStatementFileExt == "png" || $bankStatementFileExt == "jpeg"){

            //User is uploading a image

            $bankStatementFileName = $this->uploadAndResizeImage("bankStatementFile", "account_documents", $user_object['id'], "bank_statement");

            //Set upload flag to true

            if($bankStatementFileName != false){

                $bankStatementFileStatus = true;

                //echo "<br>bankStatementFileStatus true";

                $bankStatementFileObject = array(

                    "image_url" => $bankStatementFileName,

                    "document_type" => "bank_statement",

                    "approved" => '0',

                    "userid" => $user_object['id']

                );

            }

        }else{

            //This means user may have tweaked the file using some plugin or malicious attack/attempt to upload invalid file and fool the system

            $bankStatementFileStatus = false;

            //Set file name for deletion

            $bankStatementFileName = "bank_statement".$user_object['id'].".".$bankStatementFileExt;

        }

        //Check to make sure all three files have been uploaded successfully

        //$drivingLicenseOrPassportFileUploadStatus, $utilityBillFileStatus, $bankStatementFileStatus

        if($drivingLicenseOrPassportFileUploadStatus == true && $utilityBillFileStatus == true && $bankStatementFileStatus == true){

            //Do some magic here

            //echo "<hr>All three files have been uploaded successfully";

            //Insert user object into db

            if($this->UserModel->insertIntoUser($user_object)){

                //echo "<br>User inserted successfully";

                if($this->AddressModel->insertIntoAddress($address_object)){

                    //echo "<br>Address inserted successfully";

                    

                    //$amount_to_update = $this->currencyExchanger(0);

                    //$amount_to_update = 10;

                    $docProofIDInserted = false;

                    if($this->DocumentModel->insertIntoDocument($drivingLicenseOrPassportFileObject)){

                        //echo "<br>proof_of_id inserted successfully";

                        $docProofIDInserted = true;

                    }



                    $docUtilityBillInserted = false;

                    if($this->DocumentModel->insertIntoDocument($utilityBillFileFileObject)){

                        //echo "<br>proof_of_id inserted successfully";

                        $docUtilityBillInserted = true;

                    }



                    $docBankStatementInserted = false;

                    if($this->DocumentModel->insertIntoDocument($bankStatementFileObject)){

                        //echo "<br>proof_of_id inserted successfully";

                        $docBankStatementInserted = true;

                    }



                    //Check if all documents objects have been inserted

                    //Send login credentials to be verified and log the user into the system

                    if($docProofIDInserted == true && $docUtilityBillInserted == true && $docBankStatementInserted == true){

                        if($this->verify_login($user_object['username'], $this->input->post('password')) == true){

                            $this->session->set_flashdata('login_success', 'You have successfully logged into our system.');

                            redirect('account/settings');

                        }else{

                            $this->session->set_flashdata('login_error', 'Wrong username or password, please try again.');

                            redirect('account/login');

                        }

                    }else{

                        echo "<br>Failed to insert documents into db";

                    }  

                }

            }

        }else{

            //Delete / unlink files something went wrong and files/documents couldn't be uploaded

            //Delete proof_of_id

            $this->deletefile("assets/account_documents", $drivingLicenseOrPassportFileName);

            //echo "<br>Deleting " .$drivingLicenseOrPassportFileName;

            //Delete utility_bill

            $this->deletefile("assets/account_documents", $utilityBillFileFileName);

            //echo "<br>Deleting " .$utilityBillFileFileName;

            //Delete bank_statement

            $this->deletefile("assets/account_documents", $bankStatementFileName);

            //echo "<br>Deleting " .$bankStatementFileName;

        }

    }





    private function GenerateUniqueUserID(){

        $unique_id = $this->GenerateRandomNumber(6);

        while($this->UserModel->userExistsByID($unique_id)){

            $unique_id = $this->GenerateRandomNumber(6);

        }

        return $unique_id;

    }





    private function GenerateUniqueAddressID(){

        $unique_id = $this->GenerateRandomNumber(6);

        while($this->AddressModel->addressExistsByID($unique_id)){

            $unique_id = $this->GenerateRandomNumber(6);

        }

        return $unique_id;

    }



    private function GenerateUniqueBankAccountNumber(){

        $unique_id = $this->GenerateRandomNumber(6);

        while($this->BankAccountModel->accountExistsByID($unique_id)){

            $unique_id = $this->GenerateRandomNumber(6);

        }

        return $unique_id;

    }


    private function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    private function GenerateRandomNumber($digits){

        //Generate the first number

        $randNum = rand(pow(10, $digits-1), pow(10, $digits)-1);

        return date("Ymd").$randNum;

    }

    



    private function GenerateDateFromDDMMYYYY($dobDay, $dobMonth, $dobYear){

        $dobString = strtotime($dobDay . "/" .$dobMonth. "/" .$dobYear);

        return date('Y-m-d',$dobString);

    }



    //////////////////////////////////////////////////////////////////////////

    // $file_input_name is the name of the field

    //////////////////////////////////////////////////////////////////////////

    private function uploadAndResizeImage($file_input_name, $folder, $ad_identifier, $image_type){

        //Used to control error or success



        $new_name = $image_type."_".$ad_identifier;



        $isUploadSuccess = false;



        $this->load->library('image_lib');

        $this->load->library('upload');



        $config['image_library'] = 'gd2';

        $config['upload_path'] = './assets/'.$folder;

        $config['overwrite'] = TRUE;

        $config['allowed_types'] = 'jpg|png|jpeg';

        //$config['max_size'] = '1000';

        //$config['max_width'] = '1024';

        //$config['max_height'] = '768';

        $config['file_name'] = $new_name;

        $config['maintain_ratio'] = TRUE;

        $config['width'] = 600;

        $config['height'] = 400;



        

        $this->image_lib->initialize($config);

        $this->upload->initialize($config);

        

        if($this->upload->do_upload($file_input_name)){

            //echo 'upload done<br>';

            $isUploadSuccess = true;

        }else{

            //Do some magic here

            echo $this->upload->display_errors();

            echo "<hr>Error uploading " .$new_name;

        }



        $upload_data = $this->upload->data();

        



        /*

        if(!$this->image_lib->resize()){

            //Do some magic here

            //echo $this->image_lib->display_errors();

            echo "<hr>Error resizing " .$new_name;

        }

        */



        $this->image_lib->clear();

        $new_name = "";



        //return $path;

        if($isUploadSuccess){

            return $upload_data['file_name'];

        }else{

            return false;

        }

        

    }

    

    //////////////////////////////////////////////////////////////////////////

    // $file_input_name is the name of the field

    //////////////////////////////////////////////////////////////////////////

    private function uploadAndResizeDocument($file_input_name, $folder, $ad_identifier, $document_type){



        $new_name = $document_type."_".$ad_identifier;



        $isUploadSuccess = false;



        $config['upload_path'] = './assets/'.$folder;

        $config['overwrite'] = TRUE;

        $config['allowed_types'] = 'pdf|doc';

        $config['file_name'] = $new_name;



        $this->load->library('upload', $config);



        //Requires to clear out previous data, otherwise CI_Model will over write file name

        $this->upload->initialize($config);

        if($this->upload->do_upload($file_input_name)){

            //echo 'upload done<br>';

            $isUploadSuccess = true;

        }else{

            //Do some magic here

            echo $this->upload->display_errors();

            echo "<hr>Error uploading " .$new_name;

        }



        $upload_data = $this->upload->data();



        $new_name = "";



        //return $path;

        if($isUploadSuccess){

            return $upload_data['file_name'];

        }else{

            return false;

        }

    }

    

    private function deletefile($directory, $file_name){

        $file_url = $directory. '/' .$file_name;

        if(is_readable($file_url) && unlink($file_url)){

            return true;

        }else{

            return false;

        }

    }

}