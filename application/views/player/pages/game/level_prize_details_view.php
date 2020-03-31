<?php
    defined('BASEPATH') OR exit("ooops, we are sorry. It's not you, it's us! Please use the back navigation button to go back.");

    ////////////////////////////////////////////////////////////////////////////////////////
    // LOAD ASSETS
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->helper( 'url' );
    $assets = base_url() . "assets/";
    $cssbase = base_url() . "assets/css";
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
    $this->load->view('player/pages/game/css/xzoom_css');

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
        <div class="col-md-12">
            <div class="d-flex justify-content-center">
            
                <div class="large-5 column"><!-- Gallery Image Start -->
                    <div class="xzoom-container">
                        <?php
                            $first_image = $the_prize[0]->images[0]->image_url;
                        ?>
                        <img width="500" class="xzoom" id="xzoom-default" src="<?php echo $prize_img_base . $first_image; ?>" xoriginal="<?php echo $prize_img_base . $first_image; ?>" />
                        <br><br>
                        <div class="xzoom-thumbs">
                            <?php foreach ($the_prize[0]->images as $key => $image) { ?>
                                <?php
                                    $image_link = $image->image_url;
                                ?>
                                <a href="<?php echo $prize_img_base . $image_link; ?>"><img class="xzoom-gallery" width="80" src="<?php echo $prize_img_base . $image_link; ?>"  xpreview="<?php echo $prize_img_base . $image_link; ?>" title="<?php echo $the_prize[0]->prize_name; ?>"></a>
                            <?php } ?>
                        </div>
                    </div>        
                 </div><!-- Gallery Image End -->

            </div>

            <div class="d-flex justify-content-center">
                <!-- Product Details Start -->
                <div class="product-highlights">
                    <h4 class="text-center d-none"><?php echo $the_prize[0]->prize_name; ?></h4>
                    <ul class="d-none">
                        <li>The bag is great</li>
                        <li>Nice material</li>
                        <li>Luxuary product</li>
                        <li>Monogram Design</li>
                    </ul>
                    <div class="description_highlight mt-4">
                        <?php echo $the_prize[0]->description_highlight; ?>
                    </div>
                </div>
                 <!-- Product Details End -->
            </div>

            <style type="text/css" rel="stylesheet">
                .center-block {
                    display: block;
                    margin-left: auto;
                    margin-right: auto;
                }
            </style>

            <div class="container">
                <div class="row">
                <div class="col-md-3"></div>
                    <div class="col-md-6 col-md-offset-3">
                        <p class="text-muted"><?php echo $the_prize[0]->description; ?></p>
                        <br>
                        <div class="custom text-center">
                            <?php if($the_prize[0]->level_id <= $user_object[0]->current_level){ ?>
                                <a href="<?php echo $base; ?>/prize/claimprize?id=<?php echo $the_prize[0]->id; ?>" class="btn btn-lg btn-custom">Claim Prize</a>
                            <?php }else{ ?>
                                <a href="<?php echo $base; ?>/game/playlevel" class="btn btn-lg btn-custom">Yes, I want this</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
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
    // BODY CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/body_tag_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // JS Here
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/pages/game/js/xzoom_gallery_js');

    ////////////////////////////////////////////////////////////////////////////////////////
    // HTML CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/footers/html/html_tag_close');
?>

