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

        <div class="col-xl-6">
          <!-- Area Chart -->
          <div class="card custom-card shadow mb-4">
            <div class="card-header bg-light-blue py-3">
              <h6 class="m-0 font-weight-bold">All Messages</h6>
            </div>
            <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="text-center" width="25%">#</th>
                      <th class="text-center" width="25%">Message</th>
                      <th class="text-right" width="25%">Type (row/level)</th>
                      <th class="text-right" width="25%">Option</th>
                    </tr>
                  </thead>
                </table>
                

                <div class="row">
                    <?php if($messagesettings != false){ ?>
                        <?php foreach ($messagesettings as $key => $message) { ?>
                        <div class="col-md-12">
                            <form action="<?php echo $base; ?>/admin/updatemessagesettings" method="post" class="needs-validation" novalidate>
                                <table class="table table-borderless">
                                  <tbody>
                                    <tr>
                                        <td><input type="text" name="id" class="form-control form-control-sm" readonly value="<?php echo $message->id; ?>" required></td>
                                        <td><input type="text" name="message" class="form-control form-control-sm" value="<?php echo $message->message; ?>" required></td>
                                        <td><input type="text" name="type" class="form-control form-control-sm" value="<?php echo $message->type; ?>" required></td>
                                        <td>
                                            <input type="submit" name="btnUpdateMessage" value="Update" class="btn btn-success btn-sm">
                                            <?php if($message->id > 3){ ?>
                                                <input type="submit" name="btnDeleteMessage" value="Delete" class="btn btn-danger btn-sm">
                                            <?php } ?>
                                        </td>
                                    </tr>
                                  </tbody>
                                </table>
                            </form>
                        </div>
                        <?php } ?>
                    <?php }else{ ?>
                        <div class="alert alert-warning border border-warning rounded p-2 m-3">
                            No records found
                        </div>
                    <?php } ?>
                </div>
            </div>
          </div>
        </div>

        <div class="col-xl-6">
          <!-- Area Chart -->
          <div class="card custom-card shadow mb-4">
            <div class="card-header bg-light-blue py-3">
              <h6 class="m-0 font-weight-bold">Add Message</h6>
            </div>
            <div class="card-body">
                <form action="<?php echo $base; ?>/admin/addnewmessage" method="post" class="needs-validation" novalidate>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="message">Message</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="message" id="message" placeholder="Enter Message">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="message_type">Message Type</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="message_type" id="message_type">
                                <option value="row" selected>Row</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-6">
                            <input type="submit" name="btnAddMessage" id="btnAddMessage" value="Add Message" class="btn btn-success">
                        </div>
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

    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY HTML CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/footers/html/body_html_close_tag');
?>