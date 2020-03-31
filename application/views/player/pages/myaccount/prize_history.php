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
    // HTML OPEN TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/headers/html/html_tag_open');

    ////////////////////////////////////////////////////////////////////////////////////////
    // HEAD OPEN TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/headers/html/header_head_tag_open');

    ////////////////////////////////////////////////////////////////////////////////////////
    // HEAD CSS, LINKS, TITLE, META TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/headers/css/header_head_css_links');

    ////////////////////////////////////////////////////////////////////////////////////////
    // HEAD CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/headers/html/header_head_tag_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY OPEN TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/body_tag_open');

    ////////////////////////////////////////////////////////////////////////////////////////
    // <MAIN NAV OPEN TAG>
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/main_nav_open');

    ////////////////////////////////////////////////////////////////////////////////////////
    // MAIN NAV
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/main_nav');

    ////////////////////////////////////////////////////////////////////////////////////////
    // </MAIN NAV CLOSE TAG>
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/main_nav_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // MAIN CONTENT OPEN TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    //Enable this for game look
    //$this->load->view('player/essentials/body/body_main_content_start');
    //Enable this for vanilla look
    $this->load->view('player/essentials/body/body_main_vanilla_content_start');
    

?>

    <!-- main Content Goes Here -->
    <div class="row">
        <div class="col-md-4">
            <?php $this->load->view('player/pages/myaccount/settings/settings_menu_left'); ?>
        </div>
        <div class="col-md-8">
            <div class="card" style="margin-bottom:30px;">
                <div class="card-header">
                    Prize History
                </div>
                <div class="card-body">
                    <div class="mytabs">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item d-none">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Level Prize History</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><!-- Game --> Prize History</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active mt-3 d-none" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <?php if($level_prize_history != false){ ?>
                                    <table class="table table-striped">
                                      <thead>
                                        <tr>
                                          <th scope="col">Prize Name</th>
                                          <th scope="col">Address</th>
                                          <th scope="col">Date Claimed</th>
                                          <th scope="col">Status</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php foreach ($level_prize_history as $key => $prize) { ?>
                                            <tr>
                                              <th scope="row"><?php echo $prize->prize_name; ?></th>
                                              <td><?php echo $prize->address; ?></td>
                                              <td><?php $new_date = strtotime($prize->date_collected); echo date('d/m/Y', $new_date); ?></td>
                                              <td>
                                                  <?php
                                                    $status = 'Unknown';
                                                    if($prize->sent == 'yes' && ($prize->delivered_status == 'not_delivered' || empty($prize->delivered_status))){
                                                        $status = 'Sent';
                                                    }else if($prize->sent == 'no' && ($prize->delivered_status == 'not_delivered' || empty($prize->delivered_status))){
                                                        $status = 'Pending';
                                                    }else if($prize->delivered_status == 'delivered'){
                                                        $status = 'Delivered';
                                                    }

                                                    echo $status;
                                                  ?>
                                              </td>
                                            </tr>
                                        <?php } ?>
                                      </tbody>
                                    </table>
                                <?php }else{ ?>
                                    <div class="border border-warning rounded p-3 m-3">
                                        No records found
                                    </div>
                                <?php } ?>
                            </div>
                            
                            <div class="tab-pane fade show active mt-3" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <?php if($row_prize_history != false){ ?>
                                    <table class="table table-striped">
                                      <thead>
                                        <tr>
                                          <th scope="col">Prize Name</th>
                                          <th scope="col">Address</th>
                                          <th scope="col">Date Claimed</th>
                                          <th scope="col">Status</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php foreach ($row_prize_history as $key => $prize) { ?>
                                            <tr>
                                              <th scope="row"><?php echo $prize->prize_name; ?></th>
                                              <td><?php echo $prize->address; ?></td>
                                              <td><?php $new_date = strtotime($prize->date_collected); echo date('d/m/Y', $new_date); ?></td>
                                              <td>
                                                  <?php
                                                    $status = 'Unknown';
                                                    if($prize->sent == 'yes' && ($prize->delivered_status == 'not_delivered' || empty($prize->delivered_status))){
                                                        $status = 'Sent';
                                                    }else if($prize->sent == 'no' && ($prize->delivered_status == 'not_delivered' || empty($prize->delivered_status))){
                                                        $status = 'Pending';
                                                    }else if($prize->delivered_status == 'delivered'){
                                                        $status = 'Delivered';
                                                    }

                                                    echo $status;
                                                  ?>
                                              </td>
                                            </tr>
                                        <?php } ?>
                                      </tbody>
                                    </table>
                                <?php }else{ ?>
                                    <div class="border border-warning rounded p-3 m-3">
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


<?php
    ////////////////////////////////////////////////////////////////////////////////////////
    // FOOTER CONTENT
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/footers/html/footer_content');

    ////////////////////////////////////////////////////////////////////////////////////////
    // MAIN CONTENT CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/body_main_content_end');


    ////////////////////////////////////////////////////////////////////////////////////////
    // JS, Custom JS
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/footers/js/footer_js');
    $this->load->view('player/pages/myaccount/settings/js/form_control_js');


    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/body_tag_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // HTML CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/footers/html/html_tag_close');
?>

