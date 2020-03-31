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

                    <?php
                        $message = $this->session->flashdata('message');
                        if(strlen($message) > 0){
                            echo '<div style="width:100%; margin:auto;" class="alert alert-warning border border-warning"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><center>';
                            echo $message;
                            echo '</center></div><br>';
                        }
                    ?>

                    <?php if($user_object[0]->isDemoAccount == '1'){ ?>
                        <span class="badge badge-default float-right mt-2">Demo Balance: <?php if(!empty($user_object[0]->demo_balance) || $user_object[0]->demo_balance != NULL){echo round($user_object[0]->demo_balance);}else{echo '0.00';} ?></span>
                    <?php }else{ ?>
                    <?php } ?>
                    

                    <p class="card-title mt-2">Account Information</p>
                </div>
                <div class="card-body">
                        <div class="alert alert-succes border border-success rounded text-center">
                            <strong>Available Balance: <?php echo round($user_object[0]->balance); ?></strong>
                        </div>
                        <?php if($user_object[0]->isDemoAccount == '1'){ ?>
                            <div class="alert alert-succes border border-success rounded text-center">
                                <strong>DEMO Balance: <?php echo round($user_object[0]->demo_balance); ?><br></strong>
                            </div>
                        <?php } ?>
                        
                        <div id="message_account" class="alert d-none" role="alert"></div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="accountNumber">Account Number*</label>
                                <input type="text" id="accountNumber" class="form-control" value="<?php echo $user_object[0]->user_id; ?>" placeholder="Account Number" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="">Date of Birth</label>
                                <?php
                                    $dob = $user_object[0]->dob_day. '/' .$user_object[0]->dob_month. '/' .$user_object[0]->dob_year;
                                ?>
                                <input type="text" class="form-control" value="<?php echo $dob; ?>" placeholder="dd/mm/yyyy" disabled>
                                
                            </div>
                        </div>

                        <form id="frmUpdateUserInfo" action="<?php echo $base; ?>/account/updateuserinfo" method="post">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="first_name">First Name*</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo $user_object[0]->first_name; ?>" placeholder="First Name" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="last_name">Last Name*</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo $user_object[0]->last_name; ?>" placeholder="Last Name" readonly>
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_object[0]->user_id; ?>">
                                    <label for="email">Email*</label>
                                    <input type="text" id="email" name="email" class="form-control" value="<?php echo $user_object[0]->email; ?>" placeholder="Email" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="username">Username*</label>
                                    <input type="text" id="username" name="username" class="form-control" value="<?php echo $user_object[0]->username; ?>" placeholder="Username" readonly>
                                </div>
                            </div>

                            

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="phone">Phone*</label>
                                    <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $user_object[0]->phone; ?>" placeholder="Phone Number" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone"><b>Default Stake</b></label>
                                    <select onchange="hello(event)" name="sss" id="sss" class="form-control">
                            
                              <option value="" selected disabled>Select a <b style="color: black;">Stake</b></option>
                                <?php foreach ($ActiveStakes as $key => $ActiveStakes) { ?>
                                    <option value="<?php echo $ActiveStakes->id; ?>" <?php if($Stake_id == $ActiveStakes->id){
                                        echo 'selected="selected"';
                                    } ?>><?php echo $ActiveStakes->Stake; ?></option>
                                <?php } ?>
                            
                        </select>
                                </div>
                            </div>
                            <br>
                            <div class="form-group row">
                                <div class="col-md-3 custom">
                                    <button type="button" id="btnEditAccount" class="btn btn-custom btn-block"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
                                </div>
                                <div class="col-md-3 custom">
                                    <button type="submit" id="btnSaveUserInfo" class="btn btn-custom btn-block" >
                                        <span class="glyphicon glyphicon-floppy-disk"></span> 
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Address
                </div>
                <div class="card-body">
                    <div id="message_address" class="alert d-none" role="alert">
                            
                    </div>
                    <form id="frmUpdateAddress" action="<?php echo $base; ?>/account/updateaddress" method="post" class="needs-validation" novalidate>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input type="hidden" name="address_id" id="address_id" value="<?php echo $user_object[0]->address_id; ?>">
                                <label for="address_line1">Address 1*</label>
                                <input type="text" id="address_line1" name="address_line1" class="form-control" value="<?php echo $user_object[0]->address_line1; ?>" placeholder="Address Line 1" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="address_line2">Address 2*</label>
                                <input type="text" id="address_line2" name="address_line2" class="form-control" value="<?php echo $user_object[0]->address_line2; ?>" placeholder="Address Line 2" readonly>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="city">City*</label>
                                <select class="form-control" name="city_id" id="city_id" readonly required>
                                    <?php if(!empty($user_object[0]->city)){ ?>
                                        <option value="<?php echo $city_id; ?>" selected><?php echo $user_object[0]->city; ?></option>
                                    <?php }else{ ?>
                                        <option value="" selected>Select a city</option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="state">State*</label>
                                <select class="form-control" name="state_id" id="state_id" readonly>
                                    <?php if(!empty($user_object[0]->state)){ ?>
                                        <option value="<?php echo $state_id; ?>" selected><?php echo $user_object[0]->state; ?></option>
                                    <?php }else{ ?>
                                        <option value="" selected>Select a state</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="country">Country*</label>
                                <select class="form-control country" name="country_id" id="country_id" readonly required>
                                <option disabled selected value="">Select a country</option>
                                

                                <?php if($countries != false){ ?>
                                    <?php foreach($countries as $key => $country) { ?>
                                        <option value="<?php echo $country->id; ?>"
                                            <?php if($country->name == $user_object[0]->country){echo 'selected';} ?> >
                                            <?php echo $country->name; ?>
                                        </option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            </div>

                            <div class="col-md-6">
                                <label for="post_code">Postal Code*</label>
                                <input type="text" id="post_code" name="post_code" class="form-control" value="<?php echo $user_object[0]->post_code; ?>" placeholder="123456" readonly>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <div class="col-md-3 custom">
                                <button type="button" id="btnEditAddress" class="btn btn-custom btn-block"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
                            </div>
                            <div class="col-md-3 custom">
                                <button type="submit" id="btnUpdateAddress" class="btn btn-custom btn-block" disabled><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                            </div>
                        </div>

                        <!-- End 2 FA -->
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    Two factor Authentication
                </div>
                <div class="card-body">
                    <?php
                        $message_twofactor_success = $this->session->flashdata('message_twofactor_success');
                        if(strlen($message_twofactor_success) > 0){
                            echo '<div style="width:100%; margin:auto;" class="alert alert-success border border-success"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><center>';
                            echo $message_twofactor_success;
                            echo '</center></div><br>';
                        }

                        $message_twofactor_error = $this->session->flashdata('message_twofactor_error');
                        if(strlen($message_twofactor_error) > 0){
                            echo '<div style="width:100%; margin:auto;" class="alert alert-danger border border-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><center>';
                            echo $message_twofactor_error;
                            echo '</center></div><br>';
                        }
                    ?>

                    <style type="text/css">
                        .switch {
                          display: block;
                          margin: 30px;
                        }
                        .switch h3 {
                          font-weight: 400;
                          padding-bottom: 6px;
                        }
                        .switch input[type="checkbox"] {
                          display: none;
                        }
                        .switch input[type="checkbox"]:checked + label {
                          background-color: #2f7df9;
                        }
                        .switch input[type="checkbox"]:checked + label:after {
                          left: 33px;
                        }
                        .switch label {
                          transition: all 200ms ease-in-out;
                          display: inline-block;
                          position: relative;
                          height: 40px;
                          width: 70px;
                          border-radius: 40px;
                          cursor: pointer;
                          background-color: #ddd;
                          color: transparent;
                        }
                        .switch label:after {
                          transition: all 200ms ease-in-out;
                          content: " ";
                          position: absolute;
                          height: 34px;
                          width: 34px;
                          border-radius: 50%;
                          background-color: white;
                          top: 3px;
                          left: 3px;
                          right: auto;
                          box-shadow: 1px 1px 1px gray;
                        }
                        .switch.colored input[type="checkbox"]:checked + label {
                          background-color: #55c946;
                        }
                        .switch.colored label {
                          background-color: #ff4949;
                        }

                        .switch.cologreen input[type="checkbox"]:checked + label {
                          background-color: #01FF01;
                        }
                        .switch.cologreen label {
                          background-color: #01FF01;
                        }
                    </style>

                    <form action="<?php echo $base; ?>/account/change2factor" method="post">
                        <div class="form-group row">
                            <p>Two-factor authentication (2FA) is a security enhancement for your account that improves
protection against unauthorised access. You will need to enter a verification code as well as
your password every time you log in.</p>
                            <div class="col-sm-4 custom">
                                <div class="switch colored">
                                  <h3>Off / On</h3>
                                  <input value="1" type="checkbox" name="twofactorInput" id="cologreen" <?php if($twofact == '1'){echo "checked";} ?> >
                                  <label for="cologreen"></label>
                                </div>
                                <div class="input-group mb-3">
                                    <img src='<?php echo $qr; ?>'/>
                                </div>

                                <input type="hidden" id="inputTwoFactCode" value="<?php echo $secret; ?>" name="inputTwoFactCode" class="form-control" placeholder="Enter verification code">
                            </div>
                            
                        </div>
                       <div class="form-group row ">
                            <div class="col-sm-4 custom">
                                <input class="btn btn-custom btn-block" type="submit" name="btnUpdate2Factor" value="Save">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script >
    function hello(event)
    {
        var e = event.target.value;
        let element = document.getElementById('sss');
       element.value = e;
        // alert(e);
    }
</script>


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
    // JS, Custom JS
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/footers/js/footer_js');
    $this->load->view('player/pages/myaccount/settings/js/form_control_js');
    $this->load->view('api/change_state_city_on_country_selection');

?>

  <!-- 2 FA -->
    <script type="text/javascript">
         $(document).ready(function(){
            if($('#twofactorInput').is(':checkbox')){
                console.log('Checked');
            }else{
                console.log('Not checked');
            }
            $(function() {
                $('#twofactorInput').bootstrapToggle();
              });
        });


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

