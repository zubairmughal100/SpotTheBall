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


      <!-- Content Row -->
      <div class="row">

        <div class="col-xl-12 col-lg-11">

          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Manage Levels</h6>
            </div>
            <div class="card-body">

                <?php
                    $success = $this->session->flashdata('success');
                    if(strlen($success) > 0){
                        echo '<div class="alert alert-success alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        echo $success;
                        echo '</div><br>';
                    }

                    $error = $this->session->flashdata('error');
                    if(strlen($error) > 0){
                        echo '<div class="alert alert-danger alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        echo $error;
                        echo '</div><br>';
                    }
                ?>

                <div class="row">
                          <div class="col-md-12">
                              
                              <?php if($levels != false){ ?>
                                <?php foreach ($levels as $key => $level) { ?>
                                  <form action="<?php echo $base; ?>/admin/updatelevel" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                                    <input type="hidden" name="level_id" id="level_id" value="<?php echo $level->id; ?>">
                                    <input type="hidden" name="level_number" id="level_number" value="<?php echo $level->level_number; ?>">
                                    <input type="hidden" name="percentage_increase" id="percentage_increase" value="<?php echo $level->percentage_increase; ?>">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td style="width: 20%;"><?php echo $level->level_title ." ".$level->level_number; ?></td>
                                                <td>
                                                    <a href="<?php echo $assets; ?>game_images/level/<?php echo $level->level_image; ?>" download><?php echo $level->level_image; ?></a>
                                                    <input type="file" id="level_image" name="level_image">
                                                </td>
                                                <td>
                                                    <div class="form-inline">
                                                        <label for="percentage_increase">% Increase</label>
                                                        <input type="text" name="percentage_increase" id="percentage_increase" class="form-control form-control-sm ml-3" value="<?php echo $level->percentage_increase; ?>" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-inline">
                                                        <label for="min_stake">Min Stake</label>
                                                        <input type="text" name="min_stake" id="min_stake" class="form-control form-control-sm ml-3" value="<?php echo $level->min_stake; ?>" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-inline">
                                                        <label for="max_stake">Max Stake</label>
                                                        <input type="text" name="max_stake" id="max_stake" class="form-control form-control-sm ml-3" value="<?php echo $level->max_stake; ?>" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-inline">
                                                        <label for="status">Status</label>
                                                        <select class="form-control form-control-sm ml-3" name="status" id="status" required>
                                                            <option value="1" <?php if($level->status == '1'){echo "selected";} ?> >Active</option>
                                                            <option value="0" <?php if($level->status == '0'){echo "selected";} ?>  >Disable</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-inline">
                                                        <label for="passmark">Pass Mark</label>
                                                        <input type="text" name="passmark" id="passmark" class="form-control form-control-sm ml-3" value="<?php echo $level->passmark; ?>" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="submit" class="btn btn-success btn-sm" value="Update">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                  </form>
                                  <?php } ?>
                              <?php }else{ ?>
                                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>Hmmmm!</strong> Database does not have any <strong>Level/s</strong>, click Add Another Level to add a Level
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                              <?php } ?>
                              

                              <div class="row actions p-3">
                                  <div class="col-md-6">
                                      <div class="order mb-4 p-3">
                                          <form action="<?php echo $base; ?>/admin/updatelevelgameimageorder" method="post">
                                              <div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="radio" name="levelgameimageorder" id="inlineRadio1" value="RAND" <?php if($general_settings[0]->level_game_image_order == "RAND"){echo 'checked';} ?> >
                                                  <label class="form-check-label" for="inlineRadio1">Random Order</label>
                                              </div>
                                              <div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="radio" name="levelgameimageorder" id="inlineRadio2" value="ASC" <?php if($general_settings[0]->level_game_image_order == "ASC"){echo 'checked';} ?> >
                                                  <label class="form-check-label" for="inlineRadio2">In Order</label>
                                              </div>
                                              <div class="form-check form-check-inline">
                                                  <button type="submit" class="btn btn-custom btn-sm">Save Game</button>
                                              </div>
                                          </form>
                                      </div>
                                  </div>
                                  <div class="col-md-6 text-right">
                                      <a href="<?php echo $base; ?>/admin/deletelastlevel?id=<?php echo $new_level_number-1; ?>" class="btn btn-custom btn-sm">Remove Last Level</a>
                                      <button data-toggle="modal" data-target="#addNewLevelModal" class="btn btn-custom btn-sm">Add Another Level</button>
                                  </div>
                              </div>
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
    $this->load->view('admin/pages/game_settings/modal/add_new_image_modal');

    ////////////////////////////////////////////////////////////////////////////////////////
    // ALL JS TAGS GOES UNDER THIS SECTION
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/footers/js/footer_common_js');

    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY HTML CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/footers/html/body_html_close_tag');
?>