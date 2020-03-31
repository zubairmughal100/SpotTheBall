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

    function trimtext($text, $start, $len){
        return substr($text, $start, $len);
    }
?>
    
    <!-- Begin Page Content -->
    <div class="container-fluid">

      

      <!-- Content Row -->
      <div class="row">

        <div class="col-xl-12 col-lg-11">

          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Row Game Settings</h6>
            </div>
            <div class="card-body">
                <?php
                    $update_row_game_success = $this->session->flashdata('update_row_game_success');
                    if(strlen($update_row_game_success) > 0){
                        echo '<div class="alert alert-success alert-dismissible fade show border border-success" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        echo $update_row_game_success;
                        echo '</div><br>';
                    }

                    $update_row_game_error = $this->session->flashdata('update_row_game_error');
                    if(strlen($update_row_game_error) > 0){
                        echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        echo $update_row_game_error;
                        echo '</div><br>';
                    }
                ?>

                <div class="row p-3 gallery">
                    <?php if($gallery_live != false){ ?>
                            <?php foreach ($gallery_live as $key => $image) { ?>
                                <div class="col-md-2 mb-4">
                                    <div class="card" title="<?php echo $image->title; ?>">
                                      <a href="" class="close-btn">&times;</a>
                                      <span class="img_stat_left" title="<?php echo $image->total_wins; ?> Wins"><?php echo $image->total_wins; ?></span>
                                      <span class="img_stat_right" title="<?php echo $image->total_lose; ?> Loses"><?php echo $image->total_lose; ?></span>
                                      <div class="gallery_card_img" style="background-image: url(<?php echo $assets; ?>game_images/gallery/<?php echo $image->solution_img_url; ?>);"></div>
                                      <!--<img class="card-img-top" src="<?php echo $assets; ?>game_images/gallery/<?php echo $image->solution_img_url; ?>" alt="Card image cap">-->
                                      <div class="card-footer" title="<?php echo $image->title; ?>">
                                          <?php echo trimtext($image->title, 0, 25); ?>...
                                      </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php }else{ ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                              <strong>Holy guacamole!</strong> No images in this gallery, perhaps click that blue button on top right.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                        <?php } ?>
                </div>

                <div class="row">
                    <div class="col-md-12">

                        

                        
                    <div class="border border-warning rounded p-3">
                        <p>Row Game Settings</p><hr>
                        <form action="<?php echo $base; ?>/admin/updaterowgamesettings" method="post" >
                            <input type="hidden" name="id" id="id" value="<?php echo $the_row_game[0]->id; ?>">
                            <!-- <div class="form-group row">
                              <label for="min_stake" class="col-sm-1 col-form-label">Min Stake</label>
                              <div class="col-sm-2">
                                <input type="number" class="form-control" id="min_stake" name="min_stake" value="<?php // echo $the_row_game[0]->min_stake; ?>">
                              </div>
                            </div> -->
                            <div class="form-group row">
                              <label for="max_stake" class="col-sm-1 col-form-label">Stake</label>
                              <div class="col-sm-2">
                                <input type="number" class="form-control" id="max_stake" name="max_stake" value="<?php echo $the_row_game[0]->max_stake; ?>">
                              </div>
                            </div>
                          
                            <div class="order mb-4 p-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="image_order" id="inlineRadio1" value="RAND" <?php if($the_row_game[0]->image_order == 'RAND'){echo "checked";} ?> >
                                    <label class="form-check-label" for="inlineRadio1">Random Order</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="image_order" id="inlineRadio2" value="ASC" <?php if($the_row_game[0]->image_order == 'ASC'){echo "checked";} ?>>
                                    <label class="form-check-label" for="inlineRadio2">In Order</label>
                                </div>
                            </div>
                            
                            <div class="border text-center p-3">
                                <h1>How many in a row you have to get?</h1>
                                <input type="number" name="number_of_row" id="number_of_row" style="width: 60px; margin: auto;" class="form-control form-control-sm" value="<?php echo $the_row_game[0]->number_of_row; ?>">
                            </div>
                            <div class="row actions p-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-custom-pink btn-sm text-white">Save Game</button>
                                    <a href="<?php echo $base; ?>/admin/rowgame" class="btn btn-custom-pink btn-sm text-white">Cancel</a>
                                </div>
                            </div>
                        </form>
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