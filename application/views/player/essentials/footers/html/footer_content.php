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
    $footer_on = true;
?>


<?php if($footer_on == true){ ?>
    <div class="game mt-5">
        <footer>
            <div class="row">
            <!--
                <div class="col-md-4">
                    <h4 class="footer_title">Explore</h4>
                    <div class="footer_content">
                        <ul class="regular">
                            <li><a href="">ABOUT</a></li>
                            <li><a href="">TERMS & CONDITIONS</a></li>
                            <li><a href="">PRIVACY & POLICY</a></li>
                            <li><a href="">HELP</a></li>
                            <li><a href="<?php  echo $base;?>/blog">BLOG</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <h4 class="footer_title">Follow Us</h4>
                    <div class="footer_content">
                        <ul class="social">
                            <li><a href="">Facebook</a></li>
                            <li><a href="">Twitter</a></li>
                            <li><a href="">Instagram</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <h4 class="footer_title">News Letter</h4>
                    <div class="footer_content">
                        <p><small class="text-muted">Subscribe to out newsletter to win prizes</small></p>
                        <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-subscribe" type="button"><span class="glyphicon glyphicon-envelope"></span></button>
                        </span>
                        </div>
                    </div>
                </div>
            -->
                <div class="col-md-12" style="margin-top:100px;">
                    <hr>
                    <p class="text-center"><a style="text-decoration: underline;" href="<?php echo $base; ?>/privacy">Privacy Policy</a> . <a style="text-decoration: underline;" href="<?php echo $base; ?>/termsandconditions">Terms &amp; Conditions</a></p>
                    <p class="text-center"><?php if(!empty($general_settings[0]->copyright)){echo $general_settings[0]->copyright;}else{"Copyright &copy; Million Dollars";} ?></p>
                </div>
            </div>
        </footer>
    </div>
<?php } ?>
