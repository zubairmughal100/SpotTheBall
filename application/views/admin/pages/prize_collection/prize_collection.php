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

      <!-- Content Row -->
      <div class="row">

        <div class="col-xl-12 col-lg-11">

          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Prize Collection</h6>
            </div>
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <!-- <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#levelprizepending" role="tab" aria-controls="nav-home" aria-selected="true">Pending Level Prize Collection</a> -->
                      <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#rowprizepending" role="tab" aria-controls="nav-profile" aria-selected="false">Pending Row Prize Collection</a>
                      <!-- <a class="nav-item nav-link" id="x1-profile-tab" data-toggle="tab" href="#alllevelprizes" role="tab" aria-controls="nav-profile" aria-selected="false">Sent Level Prize Collection</a> -->
                      <a class="nav-item nav-link" id="x2-profile-tab" data-toggle="tab" href="#allrowprizes" role="tab" aria-controls="nav-profile" aria-selected="false">Sent Row Prize Collection</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active p-3" id="levelprizepending" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="border border-warning bg-dark text-white">
                            <div class="row p-1 text-center">
                                <div class="col-sm-1 border-right">
                                    Date
                                </div>
                                <div class="col-sm-1 border-right">
                                    Account Number
                                </div>
                                <div class="col-sm-2 border-right">
                                    Name
                                </div>
                                <div class="col-sm-1 border-right">
                                    Address
                                </div>
                                <div class="col-sm-1 border-right">
                                    Prize Name
                                </div>
                                <div class="col-sm-1 border-right">
                                    Sent
                                </div>
                                <div class="col-sm-1 border-right">
                                    <strong>Tracking #</strong>
                                </div>
                                <div class="col-sm-1 border-right">
                                    <strong>Tracking URL #</strong>
                                </div>
                                <div class="col-sm-1 border-right">
                                    Delivery Status
                                </div>
                                <div class="col-sm-1 border-right">
                                    Status
                                </div>
                                <div class="col-sm-1">
                                    Action
                                </div>
                            </div>
                        </div>

                        <?php if($pending_level_prizes != false){ ?>
                            <?php foreach ($pending_level_prizes as $key => $prize) { ?>
                                <div class="border">
                                    <form action="<?php echo $base; ?>/admin/updatelevelprizecollection" method="post">
                                        <input type="hidden" name="id" id="id" value="<?php echo $prize->id; ?>">
                                        <div class="row pt-2 pb-2 text-center">
                                            <div class="col-sm-1">
                                                <?php
                                                  $date = strtotime($prize->date_collected);
                                                  echo date('d/m/Y', $date);
                                                ?>
                                            </div>
                                            <div class="col-sm-1">
                                                <?php echo $prize->user_id; ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <?php echo $prize->user_fullname; ?>
                                            </div>
                                            <div class="col-sm-1">
                                                <?php echo $prize->address; ?>
                                            </div>
                                            <div class="col-sm-1">
                                                <?php echo $prize->prize_name; ?>
                                            </div>
                                            <div class="col-sm-1">
                                                <select class="form-control form-control-sm" name="sent" id="sent">
                                                    <option value="" selected disabled>Select option</option>
                                                    <option value="yes" <?php if($prize->sent == "yes"){echo 'selected';} ?> >Sent</option>
                                                    <option value="no" <?php if($prize->sent == "no"){echo 'selected';} ?> >Not Sent</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control form-control-sm" name="tracking" id="tracking" value="<?php echo $prize->tracking; ?>">
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control form-control-sm" name="tracking_url" id="tracking_url" value="<?php echo $prize->tracking_url; ?>">
                                            </div>
                                            <div class="col-sm-1">
                                                <select class="form-control form-control-sm" name="delivery_status" id="delivery_status">
                                                    <option value="" selected disabled>Select option</option>
                                                    <option value="delivered" <?php if($prize->delivered_status == "delivered"){echo 'selected';} ?> >Delivered</option>
                                                    <option value="not_delivered" <?php if($prize->delivered_status == "not_delivered"){echo 'selected';} ?> >Not Delivered</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-1">
                                                <select class="form-control form-control-sm" name="status" id="status">
                                                    <option value="" selected disabled>Select option</option>
                                                    <option value="approve" <?php if($prize->status == "approve"){echo 'selected';} ?> >Approve</option>
                                                    <option value="decline" <?php if($prize->delivered_status == "decline"){echo 'selected';} ?> >Decline</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="submit" class="btn btn-success btn-sm" value="Update">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>
                        <?php }else{ ?>
                            <div class="border border-warning rounded p-3">
                                No records found
                            </div>
                        <?php } ?>
                    </div>
                    <div class="tab-pane fade p-3" id="rowprizepending" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="border border-warning bg-dark text-white">
                            <div class="row p-1 text-center">
                                <div class="col-sm-1 border-right">
                                    Date
                                </div>
                                <div class="col-sm-1 border-right">
                                    Account Number
                                </div>
                                <div class="col-sm-2 border-right">
                                    Name
                                </div>
                                <div class="col-sm-1 border-right">
                                    Address
                                </div>
                                <div class="col-sm-1 border-right">
                                    Prize Name
                                </div>
                                <div class="col-sm-1 border-right">
                                    Sent
                                </div>
                                <div class="col-sm-1 border-right">
                                    <strong>Tracking #</strong>
                                </div>
                                <div class="col-sm-1 border-right">
                                    <strong>Tracking URL #</strong>
                                </div>
                                <div class="col-sm-1 border-right">
                                    Delivery Status
                                </div>
                                <div class="col-sm-1 border-right">
                                    Status
                                </div>
                                <div class="col-sm-1">
                                    Action
                                </div>
                            </div>
                        </div>

                        <?php if($pending_row_prizes != false){ ?>
                            <?php foreach ($pending_row_prizes as $key => $prize) { ?>
                                <div class="border">
                                    <form action="<?php echo $base; ?>/admin/updaterowprizecollection" method="post">
                                        <input type="hidden" name="id" id="id" value="<?php echo $prize->id; ?>">
                                        <div class="row pt-2 pb-2 text-center">
                                            <div class="col-sm-1">
                                                <?php
                                                  $date = strtotime($prize->date_collected);
                                                  echo date('d/m/Y', $date);
                                                ?>
                                            </div>
                                            <div class="col-sm-1">
                                                <?php echo $prize->user_id; ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <?php echo $prize->user_fullname; ?>
                                            </div>
                                            <div class="col-sm-1">
                                                <?php echo $prize->address; ?>
                                            </div>
                                            <div class="col-sm-1">
                                                <?php echo $prize->prize_name; ?>
                                            </div>
                                            <div class="col-sm-1">
                                                <select class="form-control form-control-sm" name="sent" id="sent">
                                                    <option value="" selected disabled>Select option</option>
                                                    <option value="yes" <?php if($prize->sent == "yes"){echo 'selected';} ?> >Sent</option>
                                                    <option value="no" <?php if($prize->sent == "no"){echo 'selected';} ?> >Not Sent</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control form-control-sm" name="tracking" id="tracking" value="<?php echo $prize->tracking; ?>">
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control form-control-sm" name="tracking_url" id="tracking_url" value="<?php echo $prize->tracking_url; ?>">
                                            </div>
                                            <div class="col-sm-1">
                                                <select class="form-control form-control-sm" name="delivery_status" id="delivery_status">
                                                    <option value="" selected disabled>Select option</option>
                                                    <option value="delivered" <?php if($prize->delivered_status == "delivered"){echo 'selected';} ?> >Delivered</option>
                                                    <option value="not_delivered" <?php if($prize->delivered_status == "not_delivered"){echo 'selected';} ?> >Not Delivered</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-1">
                                                <select class="form-control form-control-sm" name="status" id="status">
                                                    <option value="" selected disabled>Select option</option>
                                                    <option value="approve" <?php if($prize->status == "approve"){echo 'selected';} ?> >Approve</option>
                                                    <option value="decline" <?php if($prize->delivered_status == "decline"){echo 'selected';} ?> >Decline</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="submit" class="btn btn-success btn-sm" value="Update">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>
                        <?php }else{ ?>
                            <div class="border border-warning rounded p-3">
                                No records found
                            </div>
                        <?php } ?>
                    </div>
                    <div class="tab-pane fade p-3" id="alllevelprizes" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="border border-warning bg-dark text-white">
                            <div class="row p-1 text-center">
                                <div class="col-sm-1 border-right">
                                    Date
                                </div>
                                <div class="col-sm-1 border-right">
                                    Account Number
                                </div>
                                <div class="col-sm-2 border-right">
                                    Name
                                </div>
                                <div class="col-sm-1 border-right">
                                    Address
                                </div>
                                <div class="col-sm-1 border-right">
                                    Prize Name
                                </div>
                                <div class="col-sm-1 border-right">
                                    Sent
                                </div>
                                <div class="col-sm-1 border-right">
                                    <strong>Tracking #</strong>
                                </div>
                                <div class="col-sm-1 border-right">
                                    <strong>Tracking URL #</strong>
                                </div>
                                <div class="col-sm-1 border-right">
                                    Delivery Status
                                </div>
                                <div class="col-sm-1 border-right">
                                    Status
                                </div>
                                <div class="col-sm-1">
                                    Action
                                </div>
                            </div>
                        </div>

                        <?php if($sent_level_prizes != false){ ?>
                            <?php foreach ($sent_level_prizes as $key => $prize) { ?>
                                <div class="border">
                                    <form action="<?php echo $base; ?>/admin/updatelevelprizecollection" method="post">
                                        <input type="hidden" name="id" id="id" value="<?php echo $prize->id; ?>">
                                        <div class="row pt-2 pb-2 text-center">
                                            <div class="col-sm-1">
                                                <?php
                                                  $date = strtotime($prize->date_collected);
                                                  echo date('d/m/Y', $date);
                                                ?>
                                            </div>
                                            <div class="col-sm-1">
                                                <?php echo $prize->user_id; ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <?php echo $prize->user_fullname; ?>
                                            </div>
                                            <div class="col-sm-1">
                                                <?php echo $prize->address; ?>
                                            </div>
                                            <div class="col-sm-1">
                                                <?php echo $prize->prize_name; ?>
                                            </div>
                                            <div class="col-sm-1">
                                                <select class="form-control form-control-sm" name="sent" id="sent">
                                                    <option value="" selected disabled>Select option</option>
                                                    <option value="yes" <?php if($prize->sent == "yes"){echo 'selected';} ?> >Sent</option>
                                                    <option value="no" <?php if($prize->sent == "no"){echo 'selected';} ?> >Not Sent</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control form-control-sm" name="tracking" id="tracking" value="<?php echo $prize->tracking; ?>">
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control form-control-sm" name="tracking_url" id="tracking_url" value="<?php echo $prize->tracking_url; ?>">
                                            </div>
                                            <div class="col-sm-1">
                                                <select class="form-control form-control-sm" name="delivery_status" id="delivery_status">
                                                    <option value="" selected disabled>Select option</option>
                                                    <option value="delivered" <?php if($prize->delivered_status == "delivered"){echo 'selected';} ?> >Delivered</option>
                                                    <option value="not_delivered" <?php if($prize->delivered_status == "not_delivered"){echo 'selected';} ?> >Not Delivered</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-1">
                                                <select class="form-control form-control-sm" name="status" id="status">
                                                    <option value="" selected disabled>Select option</option>
                                                    <option value="approve" <?php if($prize->status == "approve"){echo 'selected';} ?> >Approve</option>
                                                    <option value="decline" <?php if($prize->delivered_status == "decline"){echo 'selected';} ?> >Decline</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="submit" class="btn btn-success btn-sm" value="Update">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>
                        <?php }else{ ?>
                            <div class="border border-warning rounded p-3">
                                No records found
                            </div>
                        <?php } ?>
                    </div>
                    <div class="tab-pane fade p-3" id="allrowprizes" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="border border-warning bg-dark text-white">
                            <div class="row p-1 text-center">
                                <div class="col-sm-1 border-right">
                                    Date
                                </div>
                                <div class="col-sm-1 border-right">
                                    Account Number
                                </div>
                                <div class="col-sm-2 border-right">
                                    Name
                                </div>
                                <div class="col-sm-1 border-right">
                                    Address
                                </div>
                                <div class="col-sm-1 border-right">
                                    Prize Name
                                </div>
                                <div class="col-sm-1 border-right">
                                    Sent
                                </div>
                                <div class="col-sm-1 border-right">
                                    <strong>Tracking #</strong>
                                </div>
                                <div class="col-sm-1 border-right">
                                    <strong>Tracking URL #</strong>
                                </div>
                                <div class="col-sm-1 border-right">
                                    Delivery Status
                                </div>
                                <div class="col-sm-1 border-right">
                                    Status
                                </div>
                                <div class="col-sm-1">
                                    Action
                                </div>
                            </div>
                        </div>

                        <?php if($sent_row_prizes != false){ ?>
                            <?php foreach ($sent_row_prizes as $key => $prize) { ?>
                                <div class="border">
                                    <form action="<?php echo $base; ?>/admin/updaterowprizecollection" method="post">
                                        <input type="hidden" name="id" id="id" value="<?php echo $prize->id; ?>">
                                        <div class="row pt-2 pb-2 text-center">
                                            <div class="col-sm-1">
                                                <?php
                                                  $date = strtotime($prize->date_collected);
                                                  echo date('d/m/Y', $date);
                                                ?>
                                            </div>
                                            <div class="col-sm-1">
                                                <?php echo $prize->user_id; ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <?php echo $prize->user_fullname; ?>
                                            </div>
                                            <div class="col-sm-1">
                                                <?php echo $prize->address; ?>
                                            </div>
                                            <div class="col-sm-1">
                                                <?php echo $prize->prize_name; ?>
                                            </div>
                                            <div class="col-sm-1">
                                                <select class="form-control form-control-sm" name="sent" id="sent">
                                                    <option value="" selected disabled>Select option</option>
                                                    <option value="yes" <?php if($prize->sent == "yes"){echo 'selected';} ?> >Sent</option>
                                                    <option value="no" <?php if($prize->sent == "no"){echo 'selected';} ?> >Not Sent</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control form-control-sm" name="tracking" id="tracking" value="<?php echo $prize->tracking; ?>">
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control form-control-sm" name="tracking_url" id="tracking_url" value="<?php echo $prize->tracking_url; ?>">
                                            </div>
                                            <div class="col-sm-1">
                                                <select class="form-control form-control-sm" name="delivery_status" id="delivery_status">
                                                    <option value="" selected disabled>Select option</option>
                                                    <option value="delivered" <?php if($prize->delivered_status == "delivered"){echo 'selected';} ?> >Delivered</option>
                                                    <option value="not_delivered" <?php if($prize->delivered_status == "not_delivered"){echo 'selected';} ?> >Not Delivered</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-1">
                                                <select class="form-control form-control-sm" name="status" id="status">
                                                    <option value="" selected disabled>Select option</option>
                                                    <option value="approve" <?php if($prize->status == "approve"){echo 'selected';} ?> >Approve</option>
                                                    <option value="decline" <?php if($prize->delivered_status == "decline"){echo 'selected';} ?> >Decline</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="submit" class="btn btn-success btn-sm" value="Update">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>
                        <?php }else{ ?>
                            <div class="border border-warning rounded p-3">
                                No records found
                            </div>
                        <?php } ?>
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