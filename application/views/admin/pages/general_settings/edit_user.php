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
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Management</h1>
        <a href="<?php echo $base; ?>/admin/users" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-user-cog fa-sm text-white-50"></i> View All Users</a>
      </div>

      <!-- Content Row -->
      <div class="row">

        <div class="col-md-6">

          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
            </div> 
            <div class="card-body">
                <div class="card custom-card">
                    <div class="card-header bg-light-blue">
                        Account Information
                    </div>
                    <div class="card-body">
                        <?php
                            $account_update_success = $this->session->flashdata('account_update_success');
                            if(strlen($account_update_success) > 0){
                                echo '<div class="alert alert-success alert-dismissible fade show border border-success" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                echo $account_update_success;
                                echo '</div><br>';
                            }

                            $account_update_error = $this->session->flashdata('account_update_error');
                            if(strlen($account_update_error) > 0){
                                echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                echo $account_update_error;
                                echo '</div><br>';
                            }
                        ?>

                        <form action="<?php echo $base; ?>/admin/updateaccount" method="post" class="needs-validation" novalidate>
                            <div class="form-group row">
                              <label for="user_id" class="col-sm-3">Account Number</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control form-control-sm" name="user_id" id="user_id" placeholder="Account Number" value="<?php echo $user_object[0]->id; ?>" readonly>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="first_name" class="col-sm-3">First Name*</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control form-control-sm" name="first_name" id="first_name" placeholder="First name" value="<?php echo $user_object[0]->first_name; ?>" required>
                                <div class="invalid-feedback">
                                  First name required*
                                </div>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="last_name" class="col-sm-3">Last Name*</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control form-control-sm" name="last_name" id="last_name" placeholder="Last name" value="<?php echo $user_object[0]->last_name; ?>" required>
                                <div class="invalid-feedback">
                                  Last name required*
                                </div>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="phone" class="col-sm-3">Phone*</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control form-control-sm" name="phone" id="phone" placeholder="Phone" value="<?php echo $user_object[0]->phone; ?>" required>
                                <div class="invalid-feedback">
                                  Phone required*
                                </div>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="username" class="col-sm-3">Username*</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control form-control-sm" name="username" id="username" placeholder="Username" value="<?php echo $user_object[0]->username; ?>" required>
                                <div class="invalid-feedback">
                                  Username required*
                                </div>
                              </div>
                            </div>

                            <div class="form-group row d-none">
                              <label for="password" class="col-sm-3">Password*</label>
                              <div class="col-sm-6">
                                <input type="password" class="form-control form-control-sm" id="password" placeholder="Password">
                              </div>
                            </div>

                            <div class="form-group row d-none">
                              <label for="password_confirm" class="col-sm-3">Confirm Password*</label>
                              <div class="col-sm-6">
                                <input type="password" class="form-control form-control-sm" id="password_confirm" placeholder="Confirm password">
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="email" class="col-sm-3">Email*</label>
                              <div class="col-sm-6">
                                <input type="email" class="form-control form-control-sm" name="email" id="email" placeholder="Email" value="<?php echo $user_object[0]->email; ?>" required>
                                <div class="invalid-feedback">
                                  Name required*
                                </div>
                              </div>
                            </div>

                            <div class="form-group row d-none">
                              <label for="confirm_email" class="col-sm-3">Confirm Email*</label>
                              <div class="col-sm-6">
                                <input type="email" class="form-control form-control-sm" id="confirm_email" placeholder="Confirm email">
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="dob_day" class="col-sm-3">Date of Birth*</label>
                              <div class="col-sm-6">
                                  <div class="form-inline">
                                        <input type="text" size="2" name="dob_day" id="dob_day" class="form-control form-control-sm mr-sm-2" placeholder="dd" value="<?php echo $user_object[0]->dob_day; ?>" > / 
                                        <input type="text" size="2" name="dob_month" id="dob_month" class="form-control form-control-sm mr-sm-2 ml-sm-2"  placeholder="mm" value="<?php echo $user_object[0]->dob_month; ?>"> /
                                        <input type="text" size="4" name="dob_year" id="dob_year" class="form-control form-control-sm ml-sm-2"  placeholder="yyyy" value="<?php echo $user_object[0]->dob_year; ?>">
                                  </div>
                                  <div class="form-inline">
                                      dd / mm / yyyy
                                  </div>
                              </div>
                            </div>

                            <div class="alert alert-danger border border-danger rounded p-2">
                                <i class="fas fa-exclamation-triangle"></i> Always reset both Level &amp; Progress to 0<br>
                                <strong>DO NOT RESET LEVEL WITHOUT RESETTING PROGRESS!</strong>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3" for="current_level">Current Level</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="current_level" id="current_level" value="<?php echo $user_object[0]->current_level; ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3" for="level_progress">Level Progress</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="level_progress" id="level_progress" value="<?php echo $user_object[0]->level_progress; ?>">
                                </div>
                            </div>

                            <div class="form-group row mt-4">
                                <label class="col-sm-3"></label>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-success btn-sm pr-4 pl-4">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card custom-card mt-3">
                    <div class="card-header bg-light-blue">
                        Billing Information
                    </div>
                    <div class="card-body">
                        <?php
                            $billing_update_success = $this->session->flashdata('billing_update_success');
                            if(strlen($billing_update_success) > 0){
                                echo '<div class="alert alert-success alert-dismissible fade show border border-success" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                echo $billing_update_success;
                                echo '</div><br>';
                            }

                            $billing_update_error = $this->session->flashdata('billing_update_error');
                            if(strlen($billing_update_error) > 0){
                                echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                echo $billing_update_error;
                                echo '</div><br>';
                            }
                        ?>

                        <?php if($user_address != false){ ?>
                          <form action="<?php echo $base; ?>/admin/updatebillinginformation" method="post" class="needs-validation" novalidate>
                              <input type="hidden" name="user_id" name="user_id" value="<?php echo $user_object[0]->id; ?>">
                              <input type="hidden" name="address_id" id="address_id" value="<?php echo $user_address[0]->id; ?>">
                              <div class="form-group row">
                                <label for="address_first_name" class="col-sm-3">First Name*</label>
                                <div class="col-sm-6">
                                  <input type="text" name="address_first_name" id="address_first_name" class="form-control form-control-sm" placeholder="First name" value="<?php echo $user_address[0]->first_name; ?>" required>
                                  <div class="invalid-feedback">
                                      First name required*
                                  </div>
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="address_last_name" class="col-sm-3">Last Name*</label>
                                <div class="col-sm-6">
                                  <input type="text" name="address_last_name" id="address_last_name" class="form-control form-control-sm" placeholder="Last name" value="<?php echo $user_address[0]->last_name; ?>" required>
                                  <div class="invalid-feedback">
                                      Last name required*
                                  </div>
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="address_phone" class="col-sm-3">Phone*</label>
                                <div class="col-sm-6">
                                  <input type="text" name="address_phone" id="address_phone" class="form-control form-control-sm" placeholder="Phone" value="<?php echo $user_address[0]->phone; ?>" required>
                                  <div class="invalid-feedback">
                                      Phone required*
                                  </div>
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="address_line1" class="col-sm-3">Address 1*</label>
                                <div class="col-sm-6">
                                  <input type="text" name="address_line1" id="address_line1" class="form-control form-control-sm" placeholder="Address 1" value="<?php echo $user_address[0]->address_line1; ?>" required>
                                  <div class="invalid-feedback">
                                      Address Line 1 required*
                                  </div>
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="address_line2" class="col-sm-3">Address 1*</label>
                                <div class="col-sm-6">
                                  <input type="text" name="address_line2" id="address_line2" class="form-control form-control-sm" placeholder="Address 1" value="<?php echo $user_address[0]->address_line2; ?>" required>
                                  <div class="invalid-feedback">
                                      Address Line 2 required*
                                  </div>
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="city" class="col-sm-3">City*</label>
                                <div class="col-sm-6">
                                  <input type="text" name="city" id="city" class="form-control form-control-sm" placeholder="First name" value="<?php echo $user_address[0]->city; ?>" required>
                                  <div class="invalid-feedback">
                                      City required*
                                  </div>
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="state" class="col-sm-3">State*</label>
                                <div class="col-sm-6">
                                  <input type="text" name="state" id="state" class="form-control form-control-sm" placeholder="Country" value="<?php echo $user_address[0]->state; ?>" required>
                                  <div class="invalid-feedback">
                                      State required*
                                  </div>
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="country" class="col-sm-3">Country*</label>
                                <div class="col-sm-6">
                                  <input type="text" name="country" id="country" class="form-control form-control-sm" placeholder="City" value="<?php echo $user_address[0]->country; ?>" required>
                                  <div class="invalid-feedback">
                                      Country required*
                                  </div>
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="post_code" class="col-sm-3">Post Code*</label>
                                <div class="col-sm-6">
                                  <input type="text" name="post_code" id="post_code" class="form-control form-control-sm" placeholder="Post code" value="<?php echo $user_address[0]->post_code; ?>" required>
                                  <div class="invalid-feedback">
                                      Post code required*
                                  </div>
                                </div>
                              </div>

                              <div class="form-group row mt-4">
                                  <label class="col-sm-3"></label>
                                  <div class="col-sm-6">
                                      <button type="submit" class="btn btn-success btn-sm pr-4 pl-4">Save</button>
                                  </div>
                              </div>
                          </form>
                        <?php }else{ ?>
                            <div class="alert alert-warning alert-dismissible fade show border border-warning" role="alert">
                                User does not have any billing address
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>
                    </div>
                </div>


                <div class="card custom-card mt-3">
                    <div class="card-header bg-light-blue">
                        Account Status
                    </div>
                    <div class="card-body">
                        <?php
                            $status_update_success = $this->session->flashdata('status_update_success');
                            if(strlen($status_update_success) > 0){
                                echo '<div class="alert alert-success alert-dismissible fade show border border-success" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                echo $status_update_success;
                                echo '</div><br>';
                            }

                            $status_update_error = $this->session->flashdata('status_update_error');
                            if(strlen($status_update_error) > 0){
                                echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                echo $status_update_error;
                                echo '</div><br>';
                            }
                        ?>

                        <form action="<?php echo $base; ?>/admin/updateaccountstatus" method="post">
                            <input type="hidden" name="user_id" name="user_id" value="<?php echo $user_object[0]->id; ?>">
                            <div class="row">
                              <label for="staticEmail" class="col-sm-3">Status</label>
                              <div class="col-sm-6">
                                <label class="switch">
                                  <input type="hidden" name="current_status" id="current_status" value="<?php echo $user_object[0]->status; ?>">
                                  <input name="account_status" id="account_status" type="checkbox" value="yes" <?php if($user_object[0]->status == '1'){echo "Checked";} ?> >
                                  <span class="slider round"></span>
                                </label>
                              </div>
                            </div>

                            <div class="form-group row mt-4">
                                <label class="col-sm-3"></label>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-success btn-sm pr-4 pl-4">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="card custom-card mt-3">
                    <div class="card-header bg-light-blue">
                        Document Information
                    </div>
                    <div class="card-body">
                        <?php if($documents != false){ $count = 0; ?>
                          <div class="row">
                              
                                <?php foreach ($documents as $key => $document) { ?>
                                  <?php
                                    $margin = "";
                                    if($count == 0){
                                      $margin = "mr-5";
                                    }else if($count == 1){
                                      $margin = "ml-5";
                                    }
                                    $count++;
                                  ?>
                                  <div class="col-md-3 <?php echo $margin; ?>">
                                      <div class="document-container">
                                          <div class="btn-top mb-1">
                                              <?php if($document->approved == "0"){ ?>
                                                  <a href="<?php echo $base; ?>/admin/approvedocument?docid=<?php echo $document->id; ?>&userid=<?php echo $user_object[0]->id; ?>" class="btn btn-success btn-sm">Approve</a>
                                              <?php }else{ ?>
                                                <a href="<?php echo $base; ?>/admin/rejectdocument?docid=<?php echo $document->id; ?>&userid=<?php echo $user_object[0]->id; ?>" class="btn btn-danger btn-sm">Reject</a>
                                              <?php } ?>
                                          </div>
                                          <div class="image-container">
                                              <div class="card">
                                                  <a href="" class="close-btn">&times;</a>
                                                  <img class="card-img-top" src="<?php echo $assets; ?>account_documents/<?php echo $document->image_url; ?>">
                                                  <div class="card-footer" style="text-transform: capitalize;">
                                                      <?php
                                                        $doc_type = explode("_", $document->document_type);
                                                        echo implode(" ", $doc_type);
                                                      ?>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="form-group mt-3 d-none">
                                        <div class="custom-file">
                                          <input type="file" class="custom-file-input" id="inputGroupFile01">
                                          <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                      </div>
                                  </div>
                                <?php } ?>
                          </div>
                        <?php }else{ ?>
                            <div class="alert alert-warning alert-dismissible fade show border border-warning" role="alert">
                                <strong>Uh no...!</strong> User does not have any documents.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>
                    </div>
                </div>


                <div class="card custom-card mt-3">
                    <div class="card-header bg-light-blue">
                        Payment Information
                    </div>
                    <div class="card-body">
                        <?php if($paymentcards != false){ ?>
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
                            <label for="expiry_month" class="col-sm-3">Expiry Date</label>
                            <div class="col-sm-6">
                                <div class="form-inline">
                                      <input type="text" size="2" name="expiry_month" id="expiry_month" class="form-control form-control-sm mr-sm-2" placeholder="mm" value="<?php echo $user_object[0]->dob_day; ?>" /> / 
                                      <input type="text" size="2" name="expiry_year" id="expiry_year" class="form-control form-control-sm mr-sm-2 ml-sm-2"  placeholder="yy" value="<?php echo $user_object[0]->dob_month; ?>"/>
                                      <label class="ml-5" for="cvv">CVV / CVC</label>
                                      <input type="text" size="4" name="cvv" id="cvv" class="form-control form-control-sm ml-sm-2"  placeholder="ccvv/cvc" value="<?php echo $user_object[0]->dob_year; ?>"/>
                                </div>
                            </div>
                          </div>
                        <?php }else{ ?>
                          <div class="alert alert-warning alert-dismissible fade show border border-warning" role="alert">
                              <strong>Hmmm...!</strong> User does not have a card.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                        <?php } ?>
                    </div>
                </div>

                

                <div class="card custom-card mt-3">
                    <div class="card-header bg-light-blue">
                        Crypto Payment Information
                    </div>
                    <div class="card-body">
                        <?php
                            $crypto_update_success = $this->session->flashdata('crypto_update_success');
                            if(strlen($crypto_update_success) > 0){
                                echo '<div class="alert alert-success alert-dismissible fade show border border-success" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                echo $crypto_update_success;
                                echo '</div><br>';
                            }

                            $crypto_update_error = $this->session->flashdata('crypto_update_error');
                            if(strlen($crypto_update_error) > 0){
                                echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                echo $crypto_update_error;
                                echo '</div><br>';
                            }
                        ?>

                        <form action="<?php echo $base; ?>/admin/updatecrypto" method="post">
                            <input type="hidden" name="user_id" name="user_id" value="<?php echo $user_object[0]->id; ?>">
                            <div class="form-row">
                              <label for="crypto_address" class="col-sm-3">Crypto Address</label>
                              <div class="col-sm-6">
                                <input type="text" name="crypto_address" id="crypto_address" class="form-control form-control-sm" placeholder="Bitcoin address" value="<?php echo $user_object[0]->crypto_address; ?>">
                              </div>
                            </div>
                            <div class="form-row mt-4">
                                <label class="col-sm-3"></label>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-success btn-sm pr-4 pl-4">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>



                <div class="card custom-card mt-3">
                    <div class="card-header bg-light-blue">
                        Demo Mode
                    </div>
                    <div class="card-body">
                        <?php
                            $demo_update_success = $this->session->flashdata('demo_update_success');
                            if(strlen($demo_update_success) > 0){
                                echo '<div class="alert alert-success alert-dismissible fade show border border-success" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                echo $demo_update_success;
                                echo '</div><br>';
                            }

                            $demo_update_error = $this->session->flashdata('demo_update_error');
                            if(strlen($demo_update_error) > 0){
                                echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                echo $demo_update_error;
                                echo '</div><br>';
                            }
                        ?>

                        <form action="<?php echo $base; ?>/admin/updatedemo" method="post">
                          <input type="hidden" name="user_id" name="user_id" value="<?php echo $user_object[0]->id; ?>">
                          <div class="form-row">
                            <label for="staticEmail" class="col-sm-3">Allow Demo Mode</label>
                            <div class="col-sm-6">
                              <label class="switch">
                                <input type="checkbox" name="demo_status" id="demo_status" value="yes" <?php if($user_object[0]->isDemoAccount == '1'){echo "Checked";} ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                          </div>

                          <div class="form-row mt-2">
                              <label for="demo_balance" class="col-sm-3">Demo Balance</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control form-control-sm" name="demo_balance" id="demo_balance" placeholder="1,000" value="<?php echo $user_object[0]->demo_balance; ?>">
                              </div>
                          </div>

                          <div class="form-row mt-4">
                              <label class="col-sm-3"></label>
                              <div class="col-sm-6">
                                  <button type="submit" class="btn btn-success btn-sm pr-4 pl-4">Save</button>
                              </div>
                          </div>
                        </form>
                    </div>
                </div>



                <div class="card custom-card mt-3">
                    <div class="card-header bg-light-blue">
                        Live Information
                    </div>
                    <div class="card-body">
                        <?php
                            $balance_update_success = $this->session->flashdata('balance_update_success');
                            if(strlen($balance_update_success) > 0){
                                echo '<div class="alert alert-success alert-dismissible fade show border border-success" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                echo $balance_update_success;
                                echo '</div><br>';
                            }

                            $balance_update_error = $this->session->flashdata('balance_update_error');
                            if(strlen($balance_update_error) > 0){
                                echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                echo $balance_update_error;
                                echo '</div><br>';
                            }
                        ?>

                        <form action="<?php echo $base; ?>/admin/updatebalance"  method="post">
                            <input type="hidden" name="user_id" name="user_id" value="<?php echo $user_object[0]->id; ?>">
                            <div class="form-row mt-2">
                              <label for="balance" class="col-sm-3">Balance</label>
                              <div class="col-sm-6">
                                <input type="text" name="balance" id="balance" class="form-control form-control-sm" placeholder="1,000" value="<?php echo $user_object[0]->balance; ?>">
                              </div>
                            </div>

                            <div class="form-row mt-4">
                                <label class="col-sm-3"></label>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-success btn-sm pr-4 pl-4">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>



                <div class="card custom-card mt-3">
                    <div class="card-header bg-light-blue">
                        2-Factor Authentication
                    </div>
                    <div class="card-body">
                      <?php
                            $account_update_twoFact_success = $this->session->flashdata('account_update_twoFact_success');
                            if(strlen($account_update_twoFact_success) > 0){
                                echo '<div class="alert alert-success alert-dismissible fade show border border-success" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                echo $account_update_twoFact_success;
                                echo '</div><br>';
                            }

                            $account_update_twoFact_error = $this->session->flashdata('account_update_twoFact_error');
                            if(strlen($account_update_twoFact_error) > 0){
                                echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                echo $account_update_twoFact_error;
                                echo '</div><br>';
                            }
                        ?>
                      <form action="<?php echo $base; ?>/admin/updatetwofactor" method="post">
                          <input type="hidden" name="user_id" name="user_id" value="<?php echo $user_object[0]->id; ?>">
                          <div class="form-row">
                          <label for="staticEmail" class="col-sm-3">Status</label>
                          <div class="col-sm-6">
                            <label class="switch">
                              <input name="twofactorInput" value="1" type="checkbox" <?php if($twofact == '1'){echo "checked";} ?> >
                              <span class="slider round"></span>
                            </label>
                          </div>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-outline-dark">Reset 2-Factor Authentication</button>
                        </div>
                      </form>
                        
                    </div>
                </div>


                <div class="card custom-card mt-3">
                    <div class="card-header bg-light-blue">
                        Notes
                    </div>
                    <div class="card-body">
                        <?php
                            $notes_update_success = $this->session->flashdata('notes_update_success');
                            if(strlen($notes_update_success) > 0){
                                echo '<div class="alert alert-success alert-dismissible fade show border border-success" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                echo $notes_update_success;
                                echo '</div><br>';
                            }

                            $notes_update_error = $this->session->flashdata('notes_update_error');
                            if(strlen($notes_update_error) > 0){
                                echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                echo $notes_update_error;
                                echo '</div><br>';
                            }
                        ?>

                        <form action="<?php echo $base; ?>/admin/updatenotes" method="post">
                            <input type="hidden" name="user_id" name="user_id" value="<?php echo $user_object[0]->id; ?>">
                            <div class="form-group">
                                <textarea name="notes" id="notes" style="max-height: 200px;" class="form-control"><?php echo $user_object[0]->notes; ?></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-sm pr-4 pl-4">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">

          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Pending Document Approval</h6>
            </div>
            <div class="card-body">
              <?php
                  $doc_approve_success = $this->session->flashdata('doc_approve_success');
                  if(strlen($doc_approve_success) > 0){
                      echo '<div class="alert alert-success alert-dismissible fade show border border-success" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo $doc_approve_success;
                      echo '</div><br>';
                  }

                  $doc_approve_error = $this->session->flashdata('doc_approve_error');
                  if(strlen($doc_approve_error) > 0){
                      echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo $doc_approve_error;
                      echo '</div><br>';
                  }



                  $doc_reject_success = $this->session->flashdata('doc_reject_success');
                  if(strlen($doc_reject_success) > 0){
                      echo '<div class="alert alert-warning alert-dismissible fade show border border-warning" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo $doc_reject_success;
                      echo '</div><br>';
                  }

                  $doc_reject_error = $this->session->flashdata('doc_reject_error');
                  if(strlen($doc_reject_error) > 0){
                      echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo $doc_reject_error;
                      echo '</div><br>';
                  }
              ?>

              <?php if($documents != false){ ?>
                
                <?php
                    $documents_pending = $this->session->flashdata('documents_pending');
                    if(strlen($documents_pending) > 0){
                        echo '<div class="alert alert-danger alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        echo $documents_pending;
                        echo '</div><br>';
                    }
                ?>

                <table class="table table-striped">
                    <thead>
                        <tr>
                          <th scope="col"></th>
                          <th scope="col">Document Type</th>
                          <th scope="col">Status</th>
                          <th></th>
                        </tr>
                    </thead>
                  <tbody>
                    <?php foreach ($documents as $key => $document) {?>
                        <?php
                            if($document->approved == '0'){
                                $color = "table-danger";
                            }else{
                                $color = "table-success";
                            }
                            $file_icon = "";
                            $file_extension = explode(".", $document->image_url);
                            $file_extension = $file_extension[1];

                            if($file_extension == "doc"){
                              $file_icon = "fa-file-word";
                            }else if($file_extension == "jpg" || $file_extension == "jpeg" || $file_extension == "png" || $file_extension == "gif"){
                              $file_icon = "fa-file-image";
                            }else if($file_extension == "pdf"){
                              $file_icon = "fa-file-pdf";
                            }
                        ?>
                        <tr>
                            <th scope="row"><i class="fas <?php echo $file_icon; ?> fa-file-alt"></i></th>
                            <td>
                                <?php
                                    $doc_type = "";
                                    if($document->document_type == 'bank_statement'){
                                        $doc_type = "Bank Statement";
                                    }else if($document->document_type == 'proof_of_id'){
                                        $doc_type = "Proof of ID";
                                    }else if($document->document_type == 'utility_bill'){
                                        $doc_type = "Utility Bill";
                                    }
                                ?>
                                <a href="<?php echo $assets; ?>account_documents/<?php echo $document->image_url; ?>" download><?php echo $doc_type; ?></a>
                            </td>
                            <td class="<?php echo $color; ?>">
                                <?php
                                    if($document->approved == '1'){
                                        echo "Approved";
                                    }else{
                                        echo "Pending Approval";
                                    }
                                ?>
                            </td>
                            <td class="text-center">
                                <?php if($document->approved == "0"){ ?>
                                    <a href="<?php echo $base; ?>/admin/approvedocument?docid=<?php echo $document->id; ?>&userid=<?php echo $user_object[0]->id; ?>" class="btn btn-success btn-sm">Approve</a>
                                <?php }else{ ?>
                                    <a href="<?php echo $base; ?>/admin/rejectdocument?docid=<?php echo $document->id; ?>&userid=<?php echo $user_object[0]->id; ?>" class="btn btn-danger btn-sm pl-3 pr-3">Reject</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    
                  </tbody>
                </table>

              <?php }else{ ?>
                  <div class="alert alert-warning alert-dismissible fade show border border-warning" role="alert">
                      <strong>Uh no...!</strong> User does not have any documents.
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
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