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

    

?>

<nav class="navbar navbar-light transparent justify-content-between">
                                    <div class="logo">
                                      <?php if(!empty($general_settings[0]->logo_image)){ ?>
                                          <img width="150px" height="50px" src="<?php echo $assets.'site/'.$general_settings[0]->logo_image; ?>">
                                      <?php }else{ ?>
                                          <a href="">Spot<br>The Ball</a>
                                      <?php } ?>
                                    </div>
                                    <?php if($this->session->userdata('player_logged_in_data')){  $user_data = $this->session->userdata('player_logged_in_data');?>
                                      <div class="form-inline">
                                          <p>Welcome, <?php echo $user_data['first_name']. ' ' .$user_data['last_name'] ?></p>
                                      </div>
                                    <?php } ?>
                                </nav>
                                
                                <?php if($this->session->userdata('player_logged_in_data')){ ?>
                                  <ul class="nav nav-pills nav-fill_disabled bg-nav-custom main-pill-menu float-left">
                                      <li class="nav-item d-none">
                                        <a class="nav-link <?php if($pagename == 'level_game'){echo 'active';} ?>" href="<?php echo $base. '/game/playlevel' ?>">Level Game</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link <?php if($pagename == 'row_game'){echo 'active';} ?>" href="<?php echo $base. '/game/playrow' ?>">Game</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link <?php if($pagename == 'prizes'){echo 'active';} ?>" href="<?php echo $base. '/prize' ?>">Prizes</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link <?php if($pagename == 'settings'){echo 'active';} ?>" href="<?php echo $base . '/account/settings' ?>"><span class="glyphicon glyphicon-cog"></span> Settings</a>
                                      </li>


                                      <!-- <?php if($blogs != false){ ?>
                                        <?php foreach ($blogs as $key => $blog) {?>
                                          <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base; ?>/blog/page?id=<?php echo $blog->id; ?>/<?php echo str_replace(" ","-",$blog->title); ?>"><?php echo $blog->tab_name; ?></a>
                                          </li>
                                        <?php } ?>
                                      <?php } ?> -->

                                  </ul>

                                  <ul class="nav nav-pills nav-fill_disabled bg-nav-custom main-pill-menu float-right">
                                    <li class="nav-item">
                                      <a class="nav-link" style="padding-right:0px !important;" href="<?php echo $base. '/authorization/logout' ?>">Logout</a>
                                    </li>
                                  </ul>
                                <?php }else{ ?>
                                  <ul class="nav nav-pills nav-fill_disabled bg-nav-custom main-pill-menu float-left">
                                    <li class="nav-item">
                                      <a class="nav-link <?php if($pagename == 'level_game'){echo 'active';} ?>" href="<?php echo $base. '/game/playlevel' ?>">Level Game</a>
                                    </li>
                                    <li class="nav-item">
                                      <a class="nav-link <?php if($pagename == 'row_game'){echo 'active';} ?>" href="<?php echo $base. '/game/playrow' ?>">Row Games</a>
                                    </li>
                                    <li class="nav-item">
                                      <a class="nav-link <?php if($pagename == 'prizes'){echo 'active';} ?>" href="<?php echo $base. '/prize' ?>">Prizes</a>
                                    </li>
                                  </ul>

                                  <ul class="nav nav-pills nav-fill_disabled bg-nav-custom main-pill-menu float-right">
                                    <li class="nav-item">
                                      <a class="nav-link <?php if($pagename == 'login'){echo 'active';} ?>" href="<?php echo $base. '/account/login' ?>">Login</a>
                                    </li>
                                 </ul>
                                <?php } ?>
                                

                                