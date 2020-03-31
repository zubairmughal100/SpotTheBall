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

      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800">Create admin</h1>
      <p class="mb-4">Only a super level admin can create another admin!</p>

      <!-- Content Row -->
      <div class="row">

        <div class="col-xl-12 col-lg-11">

          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Admin Details</h6>
            </div>
            <div class="card-body">
                <?php
                    $message_success = $this->session->flashdata('success');
                    if(strlen($message_success) > 0){
                        echo '<div class="alert alert-success alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        echo $message_success;
                        echo '</div><br>';
                    }

                    $message_error = $this->session->flashdata('error');
                    if(strlen($message_error) > 0){
                        echo '<div class="alert alert-danger alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        echo $message_error;
                        echo '</div><br>';
                    }
                ?>

                <form action="<?php echo $base; ?>/admin/createadmin" method="POST" class="needs-validation" novalidate>
                  <div class="form-group">
                    <label for="first_name">First Name</label>
                    <small class="text-danger"><?php echo form_error('first_name'); ?></small>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" value="<?php echo set_value('first_name'); ?>" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter first name
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <small class="text-danger"><?php echo form_error('last_name'); ?></small>
                    <input type="text" value="<?php echo set_value('last_name'); ?>" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter last name
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <small class="text-danger"><?php echo form_error('email'); ?></small>
                    <input type="email" value="<?php echo set_value('email'); ?>" class="form-control" id="email" name="email" placeholder="Enter email" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter email
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="user_type">Account Type</label>
                    <small class="text-danger"><?php echo form_error('user_type'); ?></small>
                    <select class="form-control" id="user_type" name="user_type" required>
                      <option value="<?php if(!empty(set_value('user_type'))){echo set_value('user_type');}else{echo "";} ?>" selected><?php if(!empty(set_value('user_type'))){echo set_value('user_type');}else{echo "Select an account type";} ?></option>
                      <option value="super">Super</option>
                      <option value="admin">Admin</option>
                      <option value="Moderator">Moderator</option>
                      <option value="Editor">Editor</option>
                    </select>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please select an account type
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="status">Account Status</label>
                    <small class="text-danger"><?php echo form_error('status'); ?></small>
                    <select class="form-control" id="status" name="status" required>
                      <option value="<?php if(!empty(set_value('status'))){echo set_value('status');}else{echo "";} ?>" selected><?php if(!empty(set_value('status'))){echo set_value('status');}else{echo "Select an account status";} ?></option>
                      <option value="1">Active</option>
                      <option value="0">Disabled</option>
                    </select>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please select an account status
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="username">Username</label>
                    <small class="text-danger"><?php echo form_error('username'); ?></small>
                    <input type="text" class="form-control" id="username" name="username" aria-describedby="usernameHelp" value="<?php echo set_value('username'); ?>" placeholder="Enter username" required>
                    <small id="usernameHelp" class="form-text text-muted">Username must be unique!</small>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter a username
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <small class="text-danger"><?php echo form_error('password'); ?></small>
                    <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" placeholder="Enter Password" required>
                    <small id="passwordHelp" class="form-text text-muted">Enter a strong password, include letters, numbers and symbols!</small>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter a password
                    </div>
                  </div>
                  <input class="btn btn-primary btn-lg" type="submit" name="btnCreateAdmin" value="Create Admin">
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->

<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>

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