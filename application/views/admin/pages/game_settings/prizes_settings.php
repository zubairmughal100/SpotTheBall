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

      <!-- Content Row -->
      <div class="row">

        <div class="col-md-6">

          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Add Prize</h6>
            </div>
            <div class="card-body">
              <div class="alert alert-danger alert-dismissible fade show border border-danger" role="alert">
                <strong>ACTIVE FORM!</strong> This is a live <strong>RESPONSIVE FORM</strong>, please ensure all data are entered correctly before Clicking <strong>Add Prize</strong>.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

                <form action="<?php echo $base; ?>/admin/addprizzetodb" method="post" enctype="multipart/form-data" id="frm" name="frmPrize" class="needs-validation" novalidate>
                  <div class="form-group row">
                    <label for="prize_name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="prize_name" name="prize_name" placeholder="Enter name" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="prize_value" class="col-sm-2 col-form-label">Value</label>
                    <div class="col-sm-10">
                      <input type="number" step="0.50" class="form-control" id="prize_value" name="prize_value" placeholder="Enter value" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="prize_type" class="col-sm-2 col-form-label">Prize Type</label>
                    <div class="col-sm-10">
                        <select name="prize_type" id="prize_type" class="form-control" required>
                            <option value="asset" selected>Asset</option>
                            <option value="money">Money</option>
                        </select>
                    </div>
                  </div>

                  <div class="form-group row">
                      <label for="description_highlight" class="col-sm-2 col-form-label">Description Highlight</label>
                      <div class="col-sm-10">
                          <small>Use: <?php echo htmlentities("<p><strong>TEXT HERE</strong></p>"); ?>, you can add multiple lines</small>
                          <textarea class="form-control" rows="4" class="form-control" name="description_highlight" id="description_highlight"></textarea>
                      </div>
                  </div>

                  <div class="form-group row">
                      <label for="description" class="col-sm-2 col-form-label">Long Description</label>
                      <div class="col-sm-10">
                          <small>Use plain texts only</small>
                          <textarea class="form-control" rows="4" class="form-control" name="description" id="description"></textarea>
                      </div>
                  </div>


                  <div class="form-group row">
                    <label for="level_id" class="col-sm-2 col-form-label"><b>ID</b></label>
                    <div class="col-sm-10">
                        <select name="Stake_Row" onchange="hello(event)" id="Stake_Row" class="form-control" required>
                            <?php if($levels != false){ ?>
                              <option value="" selected disabled>Select a <b style="color: black;">ID</b></option>
                                <?php foreach ($ActiveStakes as $key => $ActiveStakes) { ?>
                                    <option value="<?php echo $ActiveStakes->id; ?>"><?php echo $ActiveStakes->id; ?></option>
                                <?php } ?>
                            <?php }else{ ?>
                                <option value="" selected disabled>No Level Found</option>
                            <?php } ?>
                            
                        </select>
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select name="status" id="status" class="form-control" required>
                            <option value="1" selected>Active</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>
                  </div>


                  <div class="form-group row">
                      <label for="level_id" class="col-sm-2 col-form-label">Upload Files</label>
                      <div class="col-md-10">
                          <input type="file" name="img_1" id="img_1" class="form-control" multiple="" required>
                      </div>
                  </div>

                  <div class="form-group row mt-4">
                      <div class="col-md-2"></div>
                      <div class="col-md-10">
                          <button type="submit" name="btnAddprize" id="btnAddprize" class="btn btn-custom-pink text-white">Add Prize</button>
                      </div>
                  </div>
                </form>
            </div>
          </div>
        </div>

        

        <div class="col-md-6">

          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List of prizes</h6>
            </div>
            <div class="card-body">
                <?php
                    $level_prize_delete_success = $this->session->flashdata('level_prize_delete_success');
                    if(strlen($level_prize_delete_success) > 0){
                        echo '<div class="alert alert-success alert-dismissible fade show border border-success" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        echo $level_prize_delete_success;
                        echo '</div><br>';
                    }

                    $level_prize_delete_error = $this->session->flashdata('level_prize_delete_error');
                    if(strlen($level_prize_delete_error) > 0){
                        echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        echo $level_prize_delete_error;
                        echo '</div><br>';
                    }
                ?>
                <?php if($prizes != false){ ?>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Value</th>
                            <th>Stake_ID</th>
                            <th>Option</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Value</th>
                            <th>Level</th>
                            <th>Option</th>
                          </tr>
                        </tfoot>
                        <tbody>
                          <?php foreach ($prizes as $key => $prize) { ?>
                            <tr>
                              <td></td>
                              <td><?php echo $prize->prize_name; ?></td>
                              <td><?php echo $prize->prize_value; ?></td>
                              <td> <?php echo $prize->Stake_id; ?></td>
                              <td class="text-center">
                                  
                                  <a href="<?php echo $base; ?>/admin/editprizes" class="btn btn-info btn-circle d-none">
                                    <i class="fas fa-pencil-alt"></i>
                                  </a>
                                  <a title="Delete Prize?" href="<?php echo $base; ?>/admin/deleteprizes?id=<?php echo $prize->id; ?>" class="btn btn-danger btn-circle">
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
    <script >
    function hello(event)
    {
        var e = event.target.value;
        let element = document.getElementById('Stake_Row');
       element.value = e;
        alert(e);
    }
</script>
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
    $this->load->view('admin/pages/game_settings/js/upload_multiple_files_js');

    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY HTML CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/footers/html/body_html_close_tag');
?>