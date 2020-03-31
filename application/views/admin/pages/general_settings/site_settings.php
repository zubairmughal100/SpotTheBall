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

    $site_settings_url = str_replace("https", "http", $base). "/admin/sitesettings/";
?>
<!-- include summernote css/js -->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
<style type="text/css">
  .panel-heading {
    border-bottom:1px solid #ccc;
  }
  .note-popover {
    display: none;
  }
</style>
    
    <!-- Begin Page Content -->
    <div class="container-fluid">

      <?php
        $success = $this->session->flashdata('success');
        if(strlen($success) > 0){
            echo '<div class="alert alert-success alert-dismissible fade show border border-success" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            echo $success;
            echo '</div><br>';
        }

        $fail = $this->session->flashdata('fail');
        if(strlen($fail) > 0){
            echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            echo $fail;
            echo '</div><br>';
        } 


        $error = $this->session->flashdata('error');
        if(strlen($error) > 0){
            echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            echo $error;
            echo '</div><br>';
        } 
    ?>

    <div class="alert alert-info border border-info alert-dismissible fade show" role="alert">
        <p><i class="fa fa-info-circle"></i> Don't see HTML editor? <a href="<?php echo $site_settings_url; ?>">Clicki Here</a></p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>

      <!-- Content Row -->
      <div class="row">

        <div class="col-xl-6 col-lg-5">

          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Privacy & Policy</h6>
            </div>
            <div class="card-body">
                <form action="<?php echo $base; ?>/admin/updatesitesettings" method="post" class="needs-validation" novalidate>
                    <textarea id="summernote" name="privacy" class="form-control" required><?php echo $general_settings[0]->privacy_policy; ?></textarea>
                    <p id="total-caracteres" style="padding:5px; margin-top: 5px; background-color: #eee; width: 60px;">0</p>
                    <small>You can paste HTML code in here</small><br><br>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" name="btnUpdatePolicy" id="btnUpdatePolicy" value="Update Policy">
                    </div>
                </form>
            </div>
          </div>
        </div>


        <div class="col-xl-6 col-lg-5">

          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Terms & Conditions</h6>
            </div>
            <div class="card-body">
                <form action="<?php echo $base; ?>/admin/updatesitesettings" method="post" class="needs-validation" novalidate>
                    <textarea id="summernote2" name="terms" class="form-control" required><?php echo $general_settings[0]->terms_conditions; ?></textarea>
                    <p id="total-caracteres2" style="padding:5px; margin-top: 5px; background-color: #eee; width: 60px;">0</p>
                    <small>You can paste HTML code in here</small><br><br>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" name="btnUpdateTerms" id="btnUpdateTerms" value="Update Terms">
                    </div>
                </form>
            </div>
          </div>
        </div>

        <div class="col-xl-6 col-lg-5">

          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Site Copyright</h6>
            </div>
            <div class="card-body">
                <form action="<?php echo $base; ?>/admin/updatesitesettings" method="post" class="needs-validation" novalidate>
                    <div class="form-group">
                      <label for="copyright">Copyright</label>
                      <input type="text" class="form-control" id="copyright" name="copyright" aria-describedby="copyrightHelp" placeholder="Enter copyright here"
                      value="<?php if(!empty($general_settings[0]->copyright)){echo $general_settings[0]->copyright;} ?>">
                      <small style="margin-top:15px;" id="copyrightHelp" class="form-text text-muted">Copy <span style="padding:10px; background-color: #ccc; border-radius:3px;"><input type="text" value="&amp;copy;" disabled> for &copy;</span></small>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" name="btnUpdateCopyright" id="btnUpdateCopyright" value="Update Copyright">
                    </div>
                </form>
            </div>
          </div>
        </div>


        <div class="col-xl-6 col-lg-5">

          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Site Title</h6>
            </div>
            <div class="card-body">
                <form action="<?php echo $base; ?>/admin/updatesitesettings" method="post" class="needs-validation" novalidate>
                    <div class="form-group">
                      <label for="site_title">Website Title</label>
                      <input type="text" class="form-control" id="site_title" name="site_title" aria-describedby="site_titleHelp" placeholder="Enter copyright here"
                      value="<?php if(!empty($general_settings[0]->site_title)){echo $general_settings[0]->site_title;} ?>">
                      <small id="site_titleHelp" class="form-text text-muted">This is global site title</small>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" name="btnUpdateTitle" id="btnUpdateTitle" value="Update Website Title">
                    </div>
                </form>
            </div>
          </div>
        </div>



        <div class="col-xl-6 col-lg-5">

          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Signup Terms of Use</h6>
            </div>
            <div class="card-body">
                <form action="<?php echo $base; ?>/admin/updatesitesettings" method="post" class="needs-validation" novalidate>
                    <div class="form-group">
                      <label for="signup_terms_of_use">Terms of Use</label>
                      <textarea type="text" class="form-control" id="signup_terms_of_use" rows="6" name="signup_terms_of_use" aria-describedby="signup_terms_of_useHelp" placeholder="Enter signup terms of use here..."><?php if(!empty($general_settings[0]->terms_of_use)){echo $general_settings[0]->terms_of_use;} ?></textarea>
                      <small id="signup_terms_of_useHelp" class="form-text text-muted">This is signup terms of use</small>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" name="btnUpdateTermsOfUse" id="btnUpdateTermsOfUse" value="Update Signup terms of Use">
                    </div>
                </form>
            </div>
          </div>
        </div>


        <div class="col-xl-6 col-lg-5">

          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Site Logo</h6>
            </div>
            <div class="card-body">
                <form action="<?php echo $base; ?>/admin/updatesitesettings" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div style="width: 150px; height: 50px; background-repeat: no-repeat; background-size: 150px 50px; background-image: url(<?php echo $assets.'site/'.$general_settings[0]->logo_image; ?>);" class="display_logo"></div>
                    <div class="form-group">
                      <label for="logo_image">Website Logo</label>
                      <input type="file" class="form-control" id="logo_image" name="logo_image" aria-describedby="logo_imageHelp">
                      <small id="logo_imageHelp" class="form-text text-muted">This is global site logo, recommended size 150px (width) by 50px (height)</small>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" name="btnUpdateSiteLogo" id="btnUpdateSiteLogo" value="Update Logo">
                    </div>
                </form>
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
  ?>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
<script>
    $(document).ready(function() {

      $('#summernote').summernote({
          height: 300,                 // set editor height
          minHeight: null,             // set minimum height of editor
          maxHeight: null,             // set maximum height of editor
          focus: true ,                 // set focus to editable area after initializing summernote
          callbacks: {
              onKeydown: function(e) {
              var limiteCaracteres = 255;
              var caracteres = $(".note-editable").text();
              var totalCaracteres = caracteres.length;

              //Update value
              $("#total-caracteres").text(totalCaracteres);

              //Check and Limit Charaters
              if(totalCaracteres >= limiteCaracteres){
                return false;
              }         
              }
          }
        });


      $('#summernote2').summernote({
          height: 300,                 // set editor height
          minHeight: null,             // set minimum height of editor
          maxHeight: null,             // set maximum height of editor
          focus: true ,                 // set focus to editable area after initializing summernote
          callbacks: {
              onKeydown: function(e) {
              var limiteCaracteres = 255;
              var caracteres = $(".note-editable2").text();
              var totalCaracteres = caracteres.length;

              //Update value
              $("#total-caracteres").text(totalCaracteres);

              //Check and Limit Charaters
              if(totalCaracteres >= limiteCaracteres){
                return false;
              }         
              }
          }
        });

      });
</script>
  <?php

    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY HTML CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/footers/html/body_html_close_tag');
?>