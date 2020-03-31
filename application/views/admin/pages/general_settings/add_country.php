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
              <h6 class="m-0 font-weight-bold text-primary">Add Country</h6>
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
                <form action="<?php echo $base; ?>/admin/addcountrytodb" method="post" class="needs-validation" novalidate>
                  <div class="form-group row">
                    <label for="continent_id" class="col-sm-2 col-form-label">Add Country</label>
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
                      <input type="text" class="form-control" name="country_name" id="country_name" placeholder="Country name" required>
                      <div class="invalid-feedback">
                        Country name required*
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="code" class="col-sm-2 col-form-label">2 Digits ISO</label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" name="code" id="code" placeholder="ISO Code" required>
                      <div class="invalid-feedback">
                        Country code required*
                      </div>
                    </div>
                  </div>
                  <div class="form-group float-right">
                      <input type="submit" class="btn btn-custom" id="btnAddCountry" name="btnAddCountry" value="Add Country">
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
              <h6 class="m-0 font-weight-bold text-primary">Country Lists</h6>
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

              <?php if($countries != false){ ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>WARNING!</strong> Deleting a <strong>Country</strong> will result in deleting all <strong>States</strong> within the <strong>Country</strong>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>

                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Country Name</th>
                          <th>Status</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Country Name</th>
                          <th>Status</th>
                          <th>Option</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php foreach ($countries as $key => $country) {?>
                          <tr>
                            <td><?php echo $country->name; ?></td>
                            <?php
                              $status = "Disabled";
                              if($country->status == '1'){
                                $status = "Active";
                              }
                            ?>
                            <td><?php echo $status; ?></td>
                            <td class="text-center">
                                <a href="<?php echo $base; ?>/admin/deletecountry?countryid=<?php echo $country->id; ?>&name=<?php echo $country->name; ?>" class="btn btn-danger btn-circle">
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

    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY HTML CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/footers/html/body_html_close_tag');
?>