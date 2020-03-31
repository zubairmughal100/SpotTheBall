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

<style type="text/css">
    .custom-card {
      border-radius: 0px !important;
    }
    .bg-light-blue {
      background-color: rgb(150,187,242) !important;
      color:#000;
      padding: 5px !important;
      border-radius: 0px !important;
    }
</style>
    
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
              <h6 class="m-0 font-weight-bold text-primary">Add New user</h6>
            </div>
            <div class="card-body">
                
                <form action="<?php echo $base; ?>/admin/addnewusertodb" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                  <div class="card custom-card">
                      <div class="card-header bg-light-blue">
                          Account Information
                      </div>
                      <div class="card-body">
                        <div class="form-group row">
                            <label for="user_id" class="col-sm-3">Account Number</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control form-control-sm" id="user_id" name="user_id" placeholder="Account Number" value="<?php echo $unique_user_id; ?>" readonly required>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="username" class="col-sm-3">Username*</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control form-control-sm" id="username" name="username" placeholder="Username" required>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="password" class="col-sm-3">Password*</label>
                            <div class="col-sm-6">
                              <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Password" required>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="confirm_password" class="col-sm-3">Confirm Password*</label>
                            <div class="col-sm-6">
                              <input type="password" class="form-control form-control-sm" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="email" class="col-sm-3">Email*</label>
                            <div class="col-sm-6">
                              <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Email" required>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="confirm_email" class="col-sm-3">Confirm Email*</label>
                            <div class="col-sm-6">
                              <input type="email" class="form-control form-control-sm" id="confirm_email" name="confirm_email" placeholder="Confirm email" required>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="dob" class="col-sm-3">Date of Birth*</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control form-control-sm" id="dob" name="dob" placeholder="dd/mm/yyyy" required>
                            </div>
                          </div>
                      </div>
                  </div>

                  <div class="card custom-card mt-3">
                      <div class="card-header bg-light-blue">
                          Billing Information
                      </div>
                      <div class="card-body">
                          <div class="form-group row">
                              <label for="titleMr" class="col-sm-3">Title*</label>
                              <div class="col-sm-6">
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="title" id="titleMr" value="Mr" required>
                                    <label class="form-check-label" for="titleMr">Mr</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="title" id="titleMrs" value="Mrs" required>
                                    <label class="form-check-label" for="titleMrs">Mrs</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="title" id="titleMs" value="Ms" required>
                                    <label class="form-check-label" for="titleMs">Ms</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="title" id="titleMiss" value="Miss" required>
                                    <label class="form-check-label" for="titleMiss">Miss</label>
                                  </div>
                                  <div class="invalid-feedback">
                                    Please enter your First Name
                                  </div>
                              </div>
                          </div>

                          <div class="form-group row">
                            <label for="firstName" class="col-sm-3">First Name*</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control form-control-sm" id="firstName" name="firstName" placeholder="First name" required>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="lastName" class="col-sm-3">Last Name*</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control form-control-sm" id="lastName" name="lastName" placeholder="Last name" required>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="phone" class="col-sm-3">Phone*</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control form-control-sm" id="phone" name="phone" placeholder="Phone" required>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="address_line1" class="col-sm-3">Address 1*</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control form-control-sm" id="address_line1" name="address_line1" placeholder="Address 1" required>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="address_line2" class="col-sm-3">Address 2*</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control form-control-sm" id="address_line2" name="address_line2" placeholder="Address 1" required>
                            </div>
                          </div>

                          <div class="form-group row">
                              <label for="country_id" class="col-sm-3">Country</label>
                              <div class="col-sm-6">
                                  <select class="form-control form-control-sm" name="country_id" id="country_id" required>
                                    <option disabled selected value="">Select a country</option>
                                      <?php if($countries != false){ ?>
                                        <?php foreach($countries as $key => $country) { ?>
                                          <option value="<?php echo $country->id; ?>">
                                            <?php echo $country->name; ?>
                                          </option>
                                        <?php } ?>
                                      <?php } ?>
                                  </select>
                                  <div class="invalid-feedback">
                                    Continent required*
                                  </div>
                              </div>
                          </div>


                          <div class="form-group row">
                            <label for="state_id" class="col-sm-3">State*</label>
                            <div class="col-sm-6">
                              <select class="form-control form-control-sm" name="state_id" id="state_id">
                                  <option value="" selected disabled>Select State</option>
                              </select>
                              <div class="invalid-feedback">
                                State required*
                              </div>
                            </div>
                          </div>


                          <div class="form-group row">
                            <label for="city_id" class="col-sm-3">City*</label>
                            <div class="col-sm-6">
                              <select class="form-control form-control-sm city" name="city_id" id="city_id" required>
                                  <option disabled selected value="">Select a city</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="post_code" class="col-sm-3">Post Code*</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control form-control-sm" id="post_code" name="post_code" placeholder="Post code" required>
                            </div>
                          </div>
                      </div>
                  </div>


                  <div class="card custom-card mt-3">
                      <div class="card-header bg-light-blue">
                          Account Status
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <label for="status" class="col-sm-3">Enable</label>
                          <div class="col-sm-6">
                            <label class="switch">
                              <input type="checkbox" value="1" name="status" id="status">
                              <span class="slider round"></span>
                            </label>
                          </div>
                        </div>
                      </div>
                  </div>

                  <style type="text/css">
                      a.close-btn {
                          position: absolute;
                          right: 0;
                          top:0;
                          padding: 0px 5px 5px 5px;
                          background-color: #000;
                          color: #fff;
                          width: 25px;
                          height: 25px;
                          border-radius: 25px;
                          text-align: center;
                          margin-top: -10px;
                          margin-right: -10px;
                          text-decoration: none;
                      }
                      a.close-btn:hover {
                          background-color: red;
                      }
                  </style>


                  <div class="card custom-card mt-3">
                      <div class="card-header bg-light-blue">
                          Document Information
                      </div>
                      <div class="card-body">
                          <div class="row">
                              <div class="col-md-4">
                                <input type="file" name="drivingLicenseOrPassportFile" class="form-control" id="drivingLicenseOrPassportFile" accept=".pdf,.doc,.jpg,.png,.jpeg" required>
                              </div>

                              <div class="col-md-4">
                                  <input type="file" name="utilityBillFile" class="form-control" id="utilityBillFile" accept=".pdf,.doc,.jpg,.png,.jpeg" required>
                              </div>
                              <div class="col-md-4">
                                  <input type="file" name="bankStatementFile" class="form-control" id="bankStatementFile" accept=".pdf,.doc,.jpg,.png,.jpeg" required>
                              </div>
                          </div>
                      </div>
                  </div>


                  <div class="card custom-card mt-3 d-none">
                      <div class="card-header bg-light-blue">
                          Payment Information
                      </div>
                      <div class="card-body">
                          <div class="form-row">
                            <label for="inputPassword" class="col-sm-3">Card Name</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control form-control-sm" id="inputPassword" placeholder="Card name">
                            </div>
                          </div>
                          <div class="form-row mt-3">
                            <label for="inputPassword" class="col-sm-3">Card Number</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control form-control-sm" id="inputPassword" placeholder="Card number">
                            </div>
                          </div>

                          <div class="form-row mt-3">
                            <label for="inputPassword" class="col-sm-3">Expiry Date</label>
                            <div class="col-sm-6">
                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <div class="form-row">
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control form-control-sm" id="inputPassword" placeholder="mm">
                                            </div>/
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control form-control-sm" id="inputPassword" placeholder="yy">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-row">
                                            <label class="col-sm-8">CVV / CVC</label>
                                            <input type="text" class="form-control form-control-sm col-sm-4" id="inputPassword" placeholder="">
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                          </div>
                      </div>
                  </div>

                  

                  <div class="card custom-card mt-3">
                      <div class="card-header bg-light-blue">
                          Crypto Payment Information
                      </div>
                      <div class="card-body">
                          <div class="form-row">
                            <label for="crypto_address" class="col-sm-3">Crypto Address</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control form-control-sm" id="crypto_address" name="crypto_address" placeholder="Bitcoin address">
                            </div>
                          </div>
                      </div>
                  </div>


                  <div class="card custom-card mt-3">
                      <div class="card-header bg-light-blue">
                          Demo Mode
                      </div>
                      <div class="card-body">
                        <div class="form-row">
                          <label for="isDemoAccount" class="col-sm-3">Allow Demo Mode</label>
                          <div class="col-sm-6">
                            <label class="switch">
                              <input type="checkbox" name="isDemoAccount" id="isDemoAccount" value="1">
                              <span class="slider round"></span>
                            </label>
                          </div>
                        </div>

                        <div class="form-row mt-2">
                            <label for="demo_balance" class="col-sm-3">Demo Balance</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control form-control-sm" id="demo_balance" name="demo_balance" placeholder="1,000">
                            </div>
                        </div>
                      </div>
                  </div>

                  <div class="card custom-card mt-3">
                      <div class="card-header bg-light-blue">
                          Live Information
                      </div>
                      <div class="card-body">
                          <div class="form-row mt-2">
                            <label for="balance" class="col-sm-3">Balance</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control form-control-sm" id="balance" name="balance" placeholder="1,000">
                            </div>
                          </div>
                      </div>
                  </div>

                  <div class="card custom-card mt-3 d-none">
                      <div class="card-header bg-light-blue">
                          2-Factor Authentication
                      </div>
                      <div class="card-body">
                          <div class="form-row">
                            <label for="staticEmail" class="col-sm-3">Status</label>
                            <div class="col-sm-6">
                              <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider round"></span>
                              </label>
                            </div>
                          </div>

                          <div class="form-group mt-3">
                              <button type="button" class="btn btn-outline-dark">Reset 2-Factor Authentication</button>
                          </div>
                      </div>
                  </div>

                  <div class="card custom-card mt-3">
                      <div class="card-header bg-light-blue">
                          Notes
                      </div>
                      <div class="card-body">
                          <textarea class="form-control" rows="3"></textarea>
                      </div>
                  </div>
                  <div class="form-group mt-3">
                      <button type="submit" class="btn btn-success">Add New User</button>
                  </div>
                </form>
            </div>
          </div>
        </div>

        <div class="col-md-6">

          <!-- Area Chart -->
          <div class="card shadow mb-4 d-none">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Banned Lists</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>IP</th>
                        <th>Country</th>
                        <th>Date Banned</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>IP</th>
                        <th>Country</th>
                        <th>Date Banned</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <tr>
                        <td>Tiger Nixon</td>
                        <td>tiger@mailman.com</td>
                        <td>32.25.25.65.01</td>
                        <td>England</td>
                        <td>2011/04/25</td>
                      </tr>
                      <tr>
                        <td>Garrett Winters</td>
                        <td>hansel@mailto.co.uk</td>
                        <td>25.85.69.87.54</td>
                        <td>Japan</td>
                        <td>2011/07/25</td>
                      </tr>
                    </tbody>
                  </table>
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

    //$this->load->view('api/change_country_on_continent_selection');
    //$this->load->view('api/change_state_on_country_selection');
    //$this->load->view('api/change_county_on_state_selection');
    $this->load->view('api/change_state_city_on_country_selection');

    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY HTML CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/footers/html/body_html_close_tag');
?>