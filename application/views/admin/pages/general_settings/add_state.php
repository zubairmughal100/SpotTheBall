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
      <h1 class="h3 mb-2 text-gray-800 d-none">Empty Title</h1>
      <p class="mb-4 d-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

      <!-- Content Row -->
      <div class="row">

        <div class="col-md-6">

          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Add State</h6>
            </div>
            <div class="card-body">
              <?php
                  $message_success = $this->session->flashdata('message_success');
                  if(strlen($message_success) > 0){
                      echo '<div class="alert alert-success alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo $message_success;
                      echo '</div><br>';
                  }

                  $message_error = $this->session->flashdata('message_error');
                  if(strlen($message_error) > 0){
                      echo '<div class="alert alert-danger alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo $message_error;
                      echo '</div><br>';
                  }
              ?>
                <form action="<?php echo $base; ?>/admin/addstatetodb" method="post" class="needs-validation" novalidate>
                  <div class="form-group row">
                    <label for="continent_id" class="col-sm-2 col-form-label">Add State</label>
                    <div class="col-sm-5">
                      <select class="form-control" name="continent_id" id="continent_id" required>
                        <option value="" selected disabled>Select Continent</option>
                        <?php if($continents != false){ ?>
                            <?php foreach ($continents as $key => $continent) { ?>
                                <option value="<?php echo $continent->id; ?>"><?php echo $continent->name; ?></option>
                            <?php } ?>
                        <?php } ?>
                      </select>
                      <div class="invalid-feedback">
                        Continent required*
                      </div>
                    </div>
                    <div class="col-sm-5">
                      <select class="form-control" name="country_id" id="country_id" required>
                          <option value="" selected disabled>Select Country</option>
                      </select>
                      <div class="invalid-feedback">
                        Country required*
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-sm-2"></div>
                      <div class="col-sm-5">
                          <input type="text" class="form-control" id="state_name" name="state_name" placeholder="State name" required>
                          <div class="invalid-feedback">
                            State required*
                          </div>
                      </div>
                      <div class="col-sm-5">
                          <input type="text" class="form-control" id="code" name="code" placeholder="2 Digit ISO Code">
                      </div>
                  </div>
                  <div class="form-group float-right">
                      <input type="submit" class="btn btn-custom" name="btnAddState" value="Add State">
                  </div>
                  <div class="clearfix"></div>
                </form>
            </div>
          </div>
        </div>

        <div class="col-md-6">

          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">State Lists</h6>
            </div>
            <div class="card-body">
              <?php
                  $delete_success = $this->session->flashdata('delete_success');
                  if(strlen($delete_success) > 0){
                      echo '<div class="alert alert-success alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo $delete_success;
                      echo '</div><br>';
                  }

                  $delete_error = $this->session->flashdata('delete_error');
                  if(strlen($delete_error) > 0){
                      echo '<div class="alert alert-danger alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo $delete_error;
                      echo '</div><br>';
                  }
              ?>
                <?php if($states != false){ ?>
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>WARNING!</strong> Deleting a <strong>State</strong> will result in deleting all <strong>Cities</strong> within the <strong>State</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <div class="table-responsive">
                          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                              <tr>
                                <th>State Name</th>
                                <th>Status</th>
                                <th>Option</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th>State Name</th>
                                <th>Status</th>
                                <th>Option</th>
                              </tr>
                            </tfoot>
                            <tbody>
                                <?php foreach ($states as $key => $state) { ?>
                                    <tr>
                                        <td><?php echo $state->name; ?></td>
                                        <?php
                                            $status = "Disabled";
                                            if($state->status == '1'){
                                              $status = "Active";
                                            }
                                        ?>
                                        <td><?php echo $status; ?></td>
                                        <td class="text-center">
                                            <a href="<?php echo $base; ?>/admin/deletestate?stateid=<?php echo $state->id; ?>&name=<?php echo $state->name; ?>" class="btn btn-danger btn-circle">
                                              <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                          </table>
                      </div>
                <?php } ?>
                
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
    $this->load->view('api/change_country_on_continent_selection');


    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY HTML CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/footers/html/body_html_close_tag');
?>