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
    $this->load->view('player/essentials/body/main_nav_restricted');

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
    <div class="login" style="margin:120px 0px;">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <?php
                    $error = $this->session->flashdata('error');
                    if(strlen($error) > 0){
                        echo '<div style="width:100%; margin:auto;" class="alert alert-warning border border-warning"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><center>';
                        echo $error;
                        echo '</center></div><br>';
                    }

                    $success = $this->session->flashdata('success');
                    if(strlen($success) > 0){
                        echo '<div style="width:100%; margin:auto;" class="alert alert-success border border-success"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><center>';
                        echo $success;
                        echo '</center></div><br>';
                    }
                ?>

                <style type="text/css">
                    .logo-img {
                        background-size: contain;
                        *background-size: cover;
                        background-repeat: no-repeat;
                        background-position: 50% 50%;
                        height: 150px;
                    }
                </style>

                <div class="card">
                    <img src="<?php echo $assets; ?>images/logo/logo.jpg" class="img-responsive logo-img">
                    <div class="card-body">
                        <form method="POST" action="<?php echo $base. '/account/changepassword' ?>" class="needs-validation" novalidate>
                            <input type="hidden" name="secret_code" id="secret_code" value="<?php echo $secret_code; ?>">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                    <input type="dob" name="dob" id="dob" class="form-control" placeholder="dd/mm/yyyy" aria-label="old_password" aria-describedby="basic-addon1">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter your old password
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><span class="glyphicon glyphicon-lock"></span></span>
                                    </div>
                                    <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New password" aria-label="new_password" aria-describedby="basic-addon1">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter your new password
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><span class="glyphicon glyphicon-lock"></span></span>
                                    </div>
                                    <input type="password" name="confirm_new_password" id="confirm_new_password" class="form-control" placeholder="Confirm New password" aria-label="confirm_new_password" aria-describedby="basic-addon1">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter your confirm new password
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom">
                                    <input type="submit" name="btnChangePasssword" id="btnChangePasssword" class="btn btn-lg btn-block btn-custom" value="Change Password">
                                </div>
                            </div>
                        </form>
                        <a href="<?php echo $base; ?>/account/login">Login</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
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
    // JS Here
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/pages/common_js/jquery.php');
    $this->load->view('player/pages/common_js/properjs.php');
    $this->load->view('player/pages/common_js/bootstrapjs.php');

    //Login form UI validation
    $this->load->view('player/pages/myaccount/js/login_validation_js');

    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/body_tag_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // HTML CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/footers/html/html_tag_close');
?>

