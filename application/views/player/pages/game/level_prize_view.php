<?php
    defined('BASEPATH') OR exit("ooops, we are sorry. It's not you, it's us! Please use the back navigation button to go back.");

    ////////////////////////////////////////////////////////////////////////////////////////
    // LOAD ASSETS
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->helper( 'url' );
    $assets = base_url() . "assets/";
    $cssbase = base_url() . "assets/css/";
    $jsbase = base_url() . "assets/js/";
    $game_img_base = $assets . "game_images/";
    $prize_img_base = $game_img_base . "prizes/";

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
        <div class="col-md-12">
            <?php
                $documents_pending = $this->session->flashdata('documents_pending');
                if(strlen($documents_pending) > 0){
                    echo '<div class="alert alert-danger alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    echo $documents_pending;
                    echo '</div><br>';
                }
            ?>
        </div>   
    </div>

    <div class="row">
        <?php foreach($the_row_prize as $key => $the_row_prize ) { ?>
        <div class="col-md-4 prize p-3"> <!-- Start of col -->
            <div class="custom-card"> <!-- Start of Custom card -->
                <div class="custom-card-header">
                    <h1 class="custom-card-title">Row Prize</h1>
                </div>
                <div class="custom-card-img" style="padding:5px !important; border-color: #edbf05 !important;">
                    <img title="<?php echo $the_row_prize->prize_name; ?>" src="<?php echo $assets; ?>game_images/row/<?php echo $the_row_prize->img_1; ?>" alt="Bouncy Castle">
                </div>
                <div class="custom-card-footer text-center">
                    <?php if($windata[0]->number_of_rows_won < "<?php echo $the_row_prize->Rows; ?>"){ ?>
                        <a href="<?php echo $base; ?>/prize/prizedetailsrow?id=<?php echo $the_row_prize->id; ?>" class="btn btn-success btn-lg"><?php echo $the_row_prize->Stake; ?>--<?php echo $the_row_prize->Rows; ?></a>
                    <?php }else{ ?>
                        <a href="<?php echo $base; ?>/prize/prizedetailsrow" class="btn btn-success btn-lg">Locked</a>
                    <?php } ?>
                </div>
            </div> <!-- End of Custom card  -->
        </div>
    <?php } ?>
      
               
        

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
    // BODY CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/body_tag_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // HTML CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/footers/html/html_tag_close');
?>

