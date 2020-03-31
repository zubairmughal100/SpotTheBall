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

      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <div>
              <?php
                  $add_gallery_success = $this->session->flashdata('add_gallery_success');
                  if(strlen($add_gallery_success) > 0){
                      echo '<div class="alert alert-success alert-dismissible fade show border border-success" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo $add_gallery_success;
                      echo '</div><br>';
                  }

                  $add_gallery_error = $this->session->flashdata('add_gallery_error');
                  if(strlen($add_gallery_error) > 0){
                      echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo $add_gallery_error;
                      echo '</div><br>';
                  }



                  $delete_gallery_success = $this->session->flashdata('delete_gallery_success');
                  if(strlen($delete_gallery_success) > 0){
                      echo '<div class="alert alert-success alert-dismissible fade show border border-success" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo $delete_gallery_success;
                      echo '</div><br>';
                  }

                  $delete_gallery_error = $this->session->flashdata('delete_gallery_error');
                  if(strlen($delete_gallery_error) > 0){
                      echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo $delete_gallery_error;
                      echo '</div><br>';
                  }



                  $level_delete_success = $this->session->flashdata('level_delete_success');
                  if(strlen($level_delete_success) > 0){
                      echo '<div class="alert alert-success alert-dismissible fade show border border-success" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo $level_delete_success;
                      echo '</div><br>';
                  }

                  $level_delete_error = $this->session->flashdata('level_delete_error');
                  if(strlen($level_delete_error) > 0){
                      echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo $level_delete_error;
                      echo '</div><br>';
                  }



                  $update_settings_success = $this->session->flashdata('update_settings_success');
                  if(strlen($update_settings_success) > 0){
                      echo '<div class="alert alert-success alert-dismissible fade show border border-success" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo $update_settings_success;
                      echo '</div><br>';
                  }

                  $update_settings_error = $this->session->flashdata('update_settings_error');
                  if(strlen($update_settings_error) > 0){
                      echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo $update_settings_error;
                      echo '</div><br>';
                  }


                  $level_not_found = $this->session->flashdata('level_not_found');
                  if(strlen($level_not_found) > 0){
                      echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                      echo $level_not_found;
                      echo '</div><br>';
                  }
              ?>
          </div>
          <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addNewImage" data-backdrop="static" data-keyboard="false"><i class="fas fa-images"></i> Add Image</a>
      </div>

      <!-- Content Row -->
      <div class="row">

        <div class="col-xl-12 col-lg-11">

          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Image Gallery</h6>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Live</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Demo</a>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent" style="border-left: 1px solid #eee; border-bottom: 1px solid #eee; border-right: 1px solid #eee;">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                      <div class="row p-3 gallery">

                        <?php if($gallery_live != false){ ?>
                            <?php foreach ($gallery_live as $key => $image) { ?>
                                <div class="col-md-2 mb-4">
                                    <div class="card" title="<?php echo $image->title; ?>">
                                      <a title="Delete Image?" href="<?php echo $base; ?>/admin/deletegalleryimage?id=<?php echo $image->id; ?>" class="close-btn">&times;</a>
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
                          

                          <!-- Start of Gallery design
                          <div class="col-md-2 mb-4">
                              <div class="card">
                                <a href="" class="close-btn">&times;</a>
                                <span class="img_stat_left">1</span>
                                <span class="img_stat_right">0</span>
                                <img class="card-img-top" src="<?php echo $assets; ?>images/football.jpg" alt="Card image cap">
                                <div class="card-footer">
                                    Image Title
                                </div>
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="card">
                                <a href="" class="close-btn">&times;</a>
                                <span class="img_stat_left">1</span>
                                <span class="img_stat_right">0</span>
                                <img class="card-img-top" src="<?php echo $assets; ?>images/football.jpg" alt="Card image cap">
                                <div class="card-footer">
                                    Image Title
                                </div>
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="card">
                                <a href="" class="close-btn">&times;</a>
                                <span class="img_stat_left">1</span>
                                <span class="img_stat_right">0</span>
                                <img class="card-img-top" src="<?php echo $assets; ?>images/football.jpg" alt="Card image cap">
                                <div class="card-footer">
                                    Image Title
                                </div>
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="card">
                                <a href="" class="close-btn">&times;</a>
                                <span class="img_stat_left">1</span>
                                <span class="img_stat_right">0</span>
                                <img class="card-img-top" src="<?php echo $assets; ?>images/football.jpg" alt="Card image cap">
                                <div class="card-footer">
                                    Image Title
                                </div>
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="card">
                                <a href="" class="close-btn">&times;</a>
                                <span class="img_stat_left">1</span>
                                <span class="img_stat_right">0</span>
                                <img class="card-img-top" src="<?php echo $assets; ?>images/football.jpg" alt="Card image cap">
                                <div class="card-footer">
                                    Image Title
                                </div>
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="card">
                                <a href="" class="close-btn">&times;</a>
                                <span class="img_stat_left">1</span>
                                <span class="img_stat_right">0</span>
                                <img class="card-img-top" src="<?php echo $assets; ?>images/football.jpg" alt="Card image cap">
                                <div class="card-footer">
                                    Image Title
                                </div>
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="card">
                                <a href="" class="close-btn">&times;</a>
                                <span class="img_stat_left">1</span>
                                <span class="img_stat_right">0</span>
                                <img class="card-img-top" src="<?php echo $assets; ?>images/football.jpg" alt="Card image cap">
                                <div class="card-footer">
                                    Image Title
                                </div>
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="card">
                                <a href="" class="close-btn">&times;</a>
                                <span class="img_stat_left">1</span>
                                <span class="img_stat_right">0</span>
                                <img class="card-img-top" src="<?php echo $assets; ?>images/football.jpg" alt="Card image cap">
                                <div class="card-footer">
                                    Image Title
                                </div>
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="card">
                                <a href="" class="close-btn">&times;</a>
                                <span class="img_stat_left">1</span>
                                <span class="img_stat_right">0</span>
                                <img class="card-img-top" src="<?php echo $assets; ?>images/football.jpg" alt="Card image cap">
                                <div class="card-footer">
                                    Image Title
                                </div>
                              </div>
                          </div>
                         End of Gallery Design-->
                      </div>

                      
                  </div>
                  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab" style="border-left: 1px solid #eee; border-bottom: 1px solid #eee; border-right: 1px solid #eee;">
                      <div class="row p-3 gallery">

                          <?php if($gallery_demo != false){ ?>
                              <?php foreach ($gallery_demo as $key => $image) { ?>
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

                          <!-- Start of gallery design
                          <div class="col-md-2 mb-4">
                              <div class="card">
                                <a href="" class="close-btn">&times;</a>
                                <span class="img_stat_left">1</span>
                                <span class="img_stat_right">0</span>
                                <img class="card-img-top" src="<?php echo $assets; ?>images/football.jpg" alt="Card image cap">
                                <div class="card-footer">
                                    Image Title
                                </div>
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="card">
                                <a href="" class="close-btn">&times;</a>
                                <span class="img_stat_left">1</span>
                                <span class="img_stat_right">0</span>
                                <img class="card-img-top" src="<?php echo $assets; ?>images/football.jpg" alt="Card image cap">
                                <div class="card-footer">
                                    Image Title
                                </div>
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="card">
                                <a href="" class="close-btn">&times;</a>
                                <span class="img_stat_left">1</span>
                                <span class="img_stat_right">0</span>
                                <img class="card-img-top" src="<?php echo $assets; ?>images/football.jpg" alt="Card image cap">
                                <div class="card-footer">
                                    Image Title
                                </div>
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="card">
                                <a href="" class="close-btn">&times;</a>
                                <span class="img_stat_left">1</span>
                                <span class="img_stat_right">0</span>
                                <img class="card-img-top" src="<?php echo $assets; ?>images/football.jpg" alt="Card image cap">
                                <div class="card-footer">
                                    Image Title
                                </div>
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="card">
                                <a href="" class="close-btn">&times;</a>
                                <span class="img_stat_left">1</span>
                                <span class="img_stat_right">0</span>
                                <img class="card-img-top" src="<?php echo $assets; ?>images/football.jpg" alt="Card image cap">
                                <div class="card-footer">
                                    Image Title
                                </div>
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="card">
                                <a href="" class="close-btn">&times;</a>
                                <span class="img_stat_left">1</span>
                                <span class="img_stat_right">0</span>
                                <img class="card-img-top" src="<?php echo $assets; ?>images/football.jpg" alt="Card image cap">
                                <div class="card-footer">
                                    Image Title
                                </div>
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="card">
                                <a href="" class="close-btn">&times;</a>
                                <span class="img_stat_left">1</span>
                                <span class="img_stat_right">0</span>
                                <img class="card-img-top" src="<?php echo $assets; ?>images/football.jpg" alt="Card image cap">
                                <div class="card-footer">
                                    Image Title
                                </div>
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="card">
                                <a href="" class="close-btn">&times;</a>
                                <span class="img_stat_left">1</span>
                                <span class="img_stat_right">0</span>
                                <img class="card-img-top" src="<?php echo $assets; ?>images/football.jpg" alt="Card image cap">
                                <div class="card-footer">
                                    Image Title
                                </div>
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="card">
                                <a href="" class="close-btn">&times;</a>
                                <span class="img_stat_left">1</span>
                                <span class="img_stat_right">0</span>
                                <img class="card-img-top" src="<?php echo $assets; ?>images/football.jpg" alt="Card image cap">
                                <div class="card-footer">
                                    Image Title
                                </div>
                              </div>
                          </div>
                          End of gallery design -->

                      </div>

                      <div class="row">
                          <div class="col-md-12">
                              <div class="order mb-4 p-3">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                      <label class="form-check-label" for="inlineRadio1">Random Order</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                      <label class="form-check-label" for="inlineRadio2">In Order</label>
                                  </div>
                              </div>
                              <table class="table">
                                <tbody>
                                  <tr>
                                    <th style="width: 70%;">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                  </tr>
                                  <tr>
                                    <th>2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                  </tr>
                                  <tr>
                                    <th>3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                  </tr>
                                </tbody>
                              </table>
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
    // Photo Setting JS
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/js/photo_settings');
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