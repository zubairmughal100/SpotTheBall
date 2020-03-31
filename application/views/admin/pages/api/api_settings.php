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
    // HTML AND HEAD OPEN TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/headers/html/html_head_open_tag');

    ////////////////////////////////////////////////////////////////////////////////////////
    // META TAGS
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/headers/html/meta');

    ////////////////////////////////////////////////////////////////////////////////////////
    // CSS TAGS
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/headers/css/main_style');

    ////////////////////////////////////////////////////////////////////////////////////////
    // CLOSE HEAD TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/headers/html/close_head_tag');

    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY OPEN AND WRAPPER OPEN TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/body/body_open');
    $this->load->view('admin/essentials/body/page_wrapper_open');

    ////////////////////////////////////////////////////////////////////////////////////////
    // SIDEBAR MENU
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/menu/sidebar_menu');

    ////////////////////////////////////////////////////////////////////////////////////////
    // CONTENT WRAPPER OPEN
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/body/content_wrapper_open');

    ////////////////////////////////////////////////////////////////////////////////////////
    // MAIN CONTENT OPEN
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/body/main_content_open');

    ////////////////////////////////////////////////////////////////////////////////////////
    // TOP MENU BAR
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/menu/top_menu');
?>
    
    <!-- Begin Page Content -->
    <div class="container-fluid">


      <!-- Content Row -->
      <div class="row">

        <div class="col-xl-12 col-lg-11">

          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">API Settings</h6>
            </div>
            <div class="card-body">
                <div class="card custom-card mt-3">
                    <div class="card-header bg-light-blue">
                        Payment Gateway
                    </div>
                    <div class="card-body">
                        <!-- Stripe -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        Stripe Key
                                    </div>
                                    <div class="card-body">
                                        <?php
                                            $stripe_update_success = $this->session->flashdata('stripe_update_success');
                                            if(strlen($stripe_update_success) > 0){
                                                echo '<div class="alert alert-success alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                                echo $stripe_update_success;
                                                echo '</div><br>';
                                            }

                                            $stripe_update_error = $this->session->flashdata('stripe_update_error');
                                            if(strlen($stripe_update_error) > 0){
                                                echo '<div class="alert alert-danger alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                                echo $stripe_update_error;
                                                echo '</div><br>';
                                            }
                                        ?>
                                        <form action="<?php echo $base; ?>/admin/updatestripesettings" method="post">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label class="col-sm-3">Stripe Payment Mode</label>
                                                        <div class="col-sm-9">
                                                            <input type="radio" name="stripe_payment_mode" value="live" 
                                                            <?php if($stripe_payment_settings[0]->payment_mode == "live"){echo "checked";} ?> > Live
                                                            <input type="radio" name="stripe_payment_mode" value="sandbox" 
                                                            <?php if($stripe_payment_settings[0]->payment_mode == "sandbox"){echo "checked";} ?> > Sandbox
                                                        </div>
                                                    </div>
                                                    <fieldset>
                                                        <legend>Live</legend>
                                                        <div class="form-group row">
                                                            <label for="stripe_publishable_keys_live" class="col-sm-3 col-form-label">Publishable Key</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="stripe_publishable_keys_live" id="stripe_publishable_keys_live" class="form-control" placeholder="Stripe publishable key" value="<?php echo $stripe_payment_settings[0]->live_public_key; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="stripe_secret_keys_live" class="col-sm-3 col-form-label">Secret Key</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="stripe_secret_keys_live" id="stripe_secret_keys_live" class="form-control" placeholder="Stripe secret key" value="<?php echo $stripe_payment_settings[0]->live_secret_key; ?>" >
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label class="col-sm-3">Turn On/Off Payment</label>
                                                        <div class="col-sm-9">
                                                            <input type="radio" name="stripe_sandbox_mode" value="1" 
                                                            <?php if($stripe_payment_settings[0]->sandbox_mode == '1'){echo "checked";} ?> > On
                                                            <input type="radio" name="stripe_sandbox_mode" value="0" 
                                                            <?php if($stripe_payment_settings[0]->sandbox_mode == '0'){echo "checked";} ?> > Off
                                                        </div>
                                                    </div>
                                                    <fieldset>
                                                        <legend>Sandbox</legend>
                                                        <div class="form-group row">
                                                            <label for="stripe_publishable_keys_sandbox" class="col-sm-3 col-form-label">Publishable Key</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="stripe_publishable_keys_sandbox" id="stripe_publishable_keys_sandbox" class="form-control" placeholder="Stripe publishable key" value="<?php echo $stripe_payment_settings[0]->sandbox_public_key; ?>" >
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="stripe_secret_keys_sandbox" class="col-sm-3 col-form-label">Secret Key</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="stripe_secret_keys_sandbox" id="stripe_secret_keys_sandbox" class="form-control" placeholder="Stripe secret key" value="<?php echo $stripe_payment_settings[0]->sandbox_secret_key; ?>" >
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4">
                                                <input type="submit" class="btn btn-success pl-5 pr-5" name="btnSaveStripeSettings" id="btnSaveStripeSettings" class="form-control" value="Save">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PayPal -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        PayPal Key
                                    </div>
                                    <div class="card-body">
                                        <?php
                                            $paypal_update_success = $this->session->flashdata('paypal_update_success');
                                            if(strlen($paypal_update_success) > 0){
                                                echo '<div class="alert alert-success alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                                echo $paypal_update_success;
                                                echo '</div><br>';
                                            }

                                            $paypal_update_error = $this->session->flashdata('paypal_update_error');
                                            if(strlen($paypal_update_error) > 0){
                                                echo '<div class="alert alert-danger alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                                echo $paypal_update_error;
                                                echo '</div><br>';
                                            }
                                        ?>
                                        <form action="<?php echo $base; ?>/admin/updatepaypalsettings" method="post">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label class="col-sm-3">PayPal Payment Mode</label>
                                                        <div class="col-sm-9">
                                                            <input type="radio" name="paypal_payment_mode" value="live"
                                                            <?php if($paypal_payment_settings[0]->payment_mode == "live"){echo "checked";} ?> > Live
                                                            <input type="radio" name="paypal_payment_mode" value="sandbox" 
                                                            <?php if($paypal_payment_settings[0]->payment_mode == "sandbox"){echo "checked";} ?> > Sandbox
                                                        </div>
                                                    </div>
                                                    <fieldset>
                                                        <legend>Live</legend>
                                                        <div class="form-group row">
                                                            <label for="paypal_publishable_keys_live" class="col-sm-3 col-form-label">Publishable Key</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="paypal_publishable_keys_live" id="paypal_publishable_keys_live" class="form-control" placeholder="PayPal publishable key" value="<?php echo $paypal_payment_settings[0]->live_public_key; ?>" >
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="paypal_secret_keys_live" class="col-sm-3 col-form-label">Secret Key</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="paypal_secret_keys_live" id="paypal_secret_keys_live" class="form-control" placeholder="PayPal secret key" value="<?php echo $paypal_payment_settings[0]->live_secret_key; ?>" >
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label class="col-sm-3">Turn On/Off Payment</label>
                                                        <div class="col-sm-9">
                                                            <input type="radio" name="paypal_sandbox_mode" value="1" 
                                                            <?php if($paypal_payment_settings[0]->sandbox_mode == '1'){echo "checked";} ?> > On
                                                            <input type="radio" name="paypal_sandbox_mode" value="0" 
                                                            <?php if($paypal_payment_settings[0]->sandbox_mode == '0'){echo "checked";} ?> > Off
                                                        </div>
                                                    </div>
                                                    <fieldset>
                                                        <legend>Sandbox</legend>
                                                        <div class="form-group row">
                                                            <label for="paypal_publishable_keys_sandbox" class="col-sm-3 col-form-label">Publishable Key</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="paypal_publishable_keys_sandbox" id="paypal_publishable_keys_sandbox" class="form-control" placeholder="PayPal publishable key" value="<?php echo $paypal_payment_settings[0]->sandbox_public_key; ?>" >
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="paypal_secret_keys_sandbox" class="col-sm-3 col-form-label">Secret Key</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="paypal_secret_keys_sandbox" id="paypal_secret_keys_sandbox" class="form-control" placeholder="PayPal secret key" value="<?php echo $paypal_payment_settings[0]->sandbox_secret_key; ?>" >
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4">
                                                <input type="submit" class="btn btn-success pl-5 pr-5" name="btnSavePaypalSettings" id="btnSavePaypalSettings" class="form-control" value="Save">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Crypto -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        Crypto Key
                                    </div>
                                    <div class="card-body">
                                        <?php
                                            $crypto_update_success = $this->session->flashdata('crypto_update_success');
                                            if(strlen($crypto_update_success) > 0){
                                                echo '<div class="alert alert-success alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                                echo $crypto_update_success;
                                                echo '</div><br>';
                                            }

                                            $crypto_update_error = $this->session->flashdata('crypto_update_error');
                                            if(strlen($crypto_update_error) > 0){
                                                echo '<div class="alert alert-danger alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                                echo $crypto_update_error;
                                                echo '</div><br>';
                                            }
                                        ?>
                                        <form action="<?php echo $base; ?>/admin/updatecryptosettings" method="post">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label class="col-sm-3">Crypto Payment Mode</label>
                                                        <div class="col-sm-9">
                                                            <input type="radio" name="crypto_payment_mode" value="live" <?php if($crypto_payment_settings[0]->payment_mode == "live"){echo "checked";} ?> > Live
                                                            <input type="radio" name="crypto_payment_mode" value="sandbox" <?php if($crypto_payment_settings[0]->payment_mode == "sandbox"){echo "checked";} ?> > Sandbox
                                                        </div>
                                                    </div>
                                                    <fieldset>
                                                        <legend>Live</legend>
                                                        <div class="form-group row">
                                                            <label for="crypto_publishable_keys_live" class="col-sm-3 col-form-label">Publishable Key</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="crypto_publishable_keys_live" id="crypto_publishable_keys_live" class="form-control" placeholder="Crypto publishable key" value="<?php echo $crypto_payment_settings[0]->live_public_key; ?>" >
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="crypto_secret_keys_live" class="col-sm-3 col-form-label">Secret Key</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="crypto_secret_keys_live" id="crypto_secret_keys_live" class="form-control" placeholder="Crypto secret key" value="<?php echo $crypto_payment_settings[0]->live_secret_key; ?>" >
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label class="col-sm-3">Turn On/Off Payment</label>
                                                        <div class="col-sm-9">
                                                            <input type="radio" name="crypto_sandbox_mode" value="1" <?php if($crypto_payment_settings[0]->sandbox_mode == '1'){echo "checked";} ?> > On
                                                            <input type="radio" name="crypto_sandbox_mode" value="0" <?php if($crypto_payment_settings[0]->sandbox_mode == '0'){echo "checked";} ?> > Off
                                                        </div>
                                                    </div>
                                                    <fieldset>
                                                        <legend>Sandbox</legend>
                                                        <div class="form-group row">
                                                            <label for="crypto_publishable_keys_sandbox" class="col-sm-3 col-form-label">Publishable Key</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="crypto_publishable_keys_sandbox" id="crypto_publishable_keys_sandbox" class="form-control" placeholder="Crypto publishable key" value="<?php echo $crypto_payment_settings[0]->sandbox_public_key; ?>" >
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="crypto_secret_keys_sandbox" class="col-sm-3 col-form-label">Secret Key</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="crypto_secret_keys_sandbox" id="crypto_secret_keys_sandbox" class="form-control" placeholder="Crypto secret key" value="<?php echo $crypto_payment_settings[0]->sandbox_secret_key; ?>">
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4">
                                                <input type="submit" class="btn btn-success pl-5 pr-5" name="btnSaveCryptoSettings" id="btnSaveCryptoSettings" class="form-control" value="Save">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2FA -->
                        <!-- Crypto -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        TWO FA
                                    </div>
                                    <div class="card-body">
                                        <?php
                                            $two_fa_success = $this->session->flashdata('two_fa_success');
                                            if(strlen($two_fa_success) > 0){
                                                echo '<div class="alert alert-success alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                                echo $two_fa_success;
                                                echo '</div><br>';
                                            }

                                            $two_fa_error = $this->session->flashdata('two_fa_error');
                                            if(strlen($two_fa_error) > 0){
                                                echo '<div class="alert alert-danger alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                                echo $two_fa_error;
                                                echo '</div><br>';
                                            }
                                        ?>
                                        <form action="<?php echo $base; ?>/admin/updatefasettings" method="post">
                                            <div class="row">
                                                <div class="col-md-12">
                                                   
                                                    <fieldset>
                                                        <legend>App Authenticator</legend>
                                                        <div class="form-group row">
                                                            <label for="fa_name_mode" class="col-sm-3 col-form-label">Two Factor APP Name</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="fa_name_mode" id="fa_name_mode" class="form-control" placeholder="fa_name_mode name key" value="<?php echo $two_fa_name[0]->live_public_key; ?>" >
                                                            </div>
                                                        </div>

                                                       
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4">
                                                <input type="submit" class="btn btn-success pl-5 pr-5" name="btnSaveCryptoSettings" id="btnSaveCryptoSettings" class="form-control" value="Save">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->

<?php
    ////////////////////////////////////////////////////////////////////////////////////////
    // MAIN CONTENT CLOSE
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/body/main_content_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // FOOTER
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/footers/html/footer');

    ////////////////////////////////////////////////////////////////////////////////////////
    // CONTENT WRAPPER CLOSE
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/body/content_wrapper_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // CLOSE PAGE WRAPPER
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/body/page_wrapper_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // ALL MODALS GHOES UNDER THIS SECTION
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/footers/html/logout_modal');

    ////////////////////////////////////////////////////////////////////////////////////////
    // ALL JS TAGS GOES UNDER THIS SECTION
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/footers/js/footer_common_js');

    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY HTML CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/footers/html/body_html_close_tag');
?>