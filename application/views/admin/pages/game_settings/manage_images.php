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
              <h6 class="m-0 font-weight-bold text-primary">Manage Images</h6>
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

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Live</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Demo</a>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                      <?php if($gallery_live != false){ ?>
                      <div class="table-responsive p-3">
                          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                              <tr>
                                <th>Thumbnail</th>
                                <th>Game Title</th>
                                <th>Data Added</th>
                                <th>Image Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th>Thumbnail</th>
                                <th>Game Title</th>
                                <th>Data Added</th>
                                <th>Image Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                              </tr>
                            </tfoot>
                            <tbody>
                                <?php foreach ($gallery_live as $key => $image) { ?>
                                    <tr>
                                        <td width="10%"><img width="80%" src="<?php echo $assets; ?>/game_images/gallery/<?php echo $image->solution_img_url; ?>"></td>
                                        <?php
                                            $status = "Disabled";
                                            if($image->status == '1'){
                                              $status = "Active";
                                            }

                                            $date = strtotime($image->date_added);
                                        ?>
                                        <td><?php echo $image->title; ?></td>
                                        <td><?php echo date('d-m-Y', $date); ?></td>
                                        <td><span class="text-capitalize"><?php echo $image->move; ?></span></td>
                                        <td><?php echo $status; ?></td>
                                        <td width="20%" class="text-center">
                                            <a href="<?php echo $base; ?>/admin/deletegalleryimage?id=<?php echo $image->id; ?>">Delete</a> |
                                            <a href="<?php echo $base; ?>/admin/enablegalleryimage?id=<?php echo $image->id; ?>">Enable</a> |
                                            <a href="<?php echo $base; ?>/admin/disablegalleryimage?id=<?php echo $image->id; ?>">Disable</a> |
                                            <a href="<?php echo $base; ?>/admin/movedemogalleryimage?id=<?php echo $image->id; ?>">Move Demo</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                          </table>
                      </div>
                      <?php }else{ ?>
                          <div class="border border-warning rounded p-3 mt-3">
                              No images found
                          </div>
                      <?php } ?>
                  </div>
                  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                      <?php if($gallery_demo != false){ ?>
                      <div class="table-responsive p-3">
                          <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                            <thead>
                              <tr>
                                <th>Thumbnail</th>
                                <th>Game Title</th>
                                <th>Data Added</th>
                                <th>Image Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th>Thumbnail</th>
                                <th>Game Title</th>
                                <th>Data Added</th>
                                <th>Image Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                              </tr>
                            </tfoot>
                            <tbody>
                                <?php foreach ($gallery_demo as $key => $image) { ?>
                                    <tr>
                                        <td width="10%"><img width="80%" src="<?php echo $assets; ?>/game_images/gallery/<?php echo $image->solution_img_url; ?>"></td>
                                        <?php
                                            $status = "Disabled";
                                            if($image->status == '1'){
                                              $status = "Active";
                                            }

                                            $date = strtotime($image->date_added);
                                        ?>
                                        <td><?php echo $image->title; ?></td>
                                        <td><?php echo date('d-m-Y', $date); ?></td>
                                        <td class="text-transform: capitalize;"><?php echo $image->move; ?></td>
                                        <td><?php echo $status; ?></td>
                                        <td width="20%" class="text-center">
                                            <a href="<?php echo $base; ?>/admin/deletegalleryimage?id=<?php echo $image->id; ?>">Delete</a> |
                                            <a href="<?php echo $base; ?>/admin/enablegalleryimage?id=<?php echo $image->id; ?>">Enable</a> |
                                            <a href="<?php echo $base; ?>/admin/disablegalleryimage?id=<?php echo $image->id; ?>">Disable</a> |
                                            <a href="<?php echo $base; ?>/admin/movelivegalleryimage?id=<?php echo $image->id; ?>">Move Live</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                          </table>
                      </div>
                      <?php }else{ ?>
                          <div class="border border-warning rounded p-3 mt-3">
                              No images found
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