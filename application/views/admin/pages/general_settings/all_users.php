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
              <h6 class="m-0 font-weight-bold text-primary">All Users</h6>
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

                <?php
                    $reg_success = $this->session->flashdata('reg_success');
                    if(strlen($reg_success) > 0){
                        echo '<div class="alert alert-success alert-dismissible fade show border border-success" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        echo $reg_success;
                        echo '</div><br>';
                    }

                    $reg_error = $this->session->flashdata('reg_error');
                    if(strlen($reg_error) > 0){
                        echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        echo $reg_error;
                        echo '</div><br>';
                    }
                ?>

                <?php if($active_users != false){ ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>WARNING!</strong> Deleting a <strong>User</strong> will result in deleting all <strong>Data</strong> associated with the <strong>User</strong>. This action should be performed by a <strong>High Level Admin.</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="table-responsive">
                      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>IP</th>
                            <th>Last Seen</th>
                            <th>Option</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>IP</th>
                            <th>Last Seen</th>
                            <th>Option</th>
                          </tr>
                        </tfoot>
                        <tbody>
                          <?php foreach ($active_users as $key => $user) { ?>
                            <tr>
                              <td><?php echo $user->first_name. " " .$user->last_name; ?></td>
                              <td><?php echo $user->email; ?></td>
                              <td><?php echo $user->ip; ?></td>
                              <td><?php if(!empty($user->last_seen)){echo date("d/m/Y H:i:s", strtotime($user->last_seen));}else{echo "N/A";} ?></td>
                              <td class="text-center">
                                  
                                  <a href="<?php echo $base; ?>/admin/edituser?id=<?php echo $user->id; ?>" class="btn btn-info btn-circle">
                                    <i class="fas fa-pencil-alt"></i>
                                  </a>
                                  <a href="<?php echo $base; ?>/admin/deleteuser?id=<?php echo $user->id; ?>&email=<?php echo $user->email; ?>" class="btn btn-danger btn-circle ">
                                    <i class="fas fa-trash"></i>
                                  </a>

                              </td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                <?php }else{ ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <strong>Holy guacamole!</strong> Database is empty, no users found.
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                <?php } ?>
            </div>
          </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4 border border-danger">
                <div class="card-header py-3 bg-danger">
                  <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-exclamation-triangle"></i> Users needs attention</h6>
                </div>
                <div class="card-body">
                    <?php if($user_pending_docs != false){ ?>
                      <div class="alert alert-warning alert-dismissible fade show border border-warning" role="alert">
                          <strong>WARNING!</strong> one or more user have pending documents.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                      </div>

                      <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Email</th>
                              <th>IP</th>
                              <th>Last Seen</th>
                              <th>Option</th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th>Name</th>
                              <th>Email</th>
                              <th>IP</th>
                              <th>Last Seen</th>
                              <th>Option</th>
                            </tr>
                          </tfoot>
                          <tbody>
                            <?php foreach ($user_pending_docs as $key => $user) { ?>
                              <tr>
                                <td><?php echo $user->first_name. " " .$user->last_name; ?></td>
                                <td><?php echo $user->email; ?></td>
                                <td><?php echo $user->ip; ?></td>
                                <td><?php if(!empty($user->last_seen)){echo date("d/m/Y H:i:s", strtotime($user->last_seen));}else{echo "N/A";} ?></td>
                                <td class="text-center">
                                    
                                    <a href="<?php echo $base; ?>/admin/edituser?id=<?php echo $user->id; ?>" class="btn btn-info btn-circle">
                                      <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="<?php echo $base; ?>/admin/deleteuser?id=<?php echo $user->id; ?>&email=<?php echo $user->email; ?>" class="btn btn-danger btn-circle ">
                                      <i class="fas fa-trash"></i>
                                    </a>

                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                  <?php }else{ ?>
                      <div class="alert alert-success alert-dismissible fade show border border-success" role="alert">
                        <strong>All caught up!</strong> No users needs attention.
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