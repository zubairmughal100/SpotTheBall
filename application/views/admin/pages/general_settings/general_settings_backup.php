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

      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800 d-none">Empty Title</h1>
      <p class="mb-4 d-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

      <?php
          $block_update_success = $this->session->flashdata('block_update_success');
          if(strlen($block_update_success) > 0){
              echo '<div class="alert alert-success alert-dismissible fade show border border-success" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
              echo $block_update_success;
              echo '</div><br>';
          }

          $block_update_error = $this->session->flashdata('block_update_error');
          if(strlen($block_update_error) > 0){
              echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
              echo $block_update_error;
              echo '</div><br>';
          }
      ?>

      <!-- Content Row -->
      <div class="row">

        <div class="col-md-5">
          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">General Settings</h6>
            </div>
            <div class="card-body">
                <?php
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
                ?>

                <form action="<?php echo $base; ?>/admin/updatesettings" method="post" class="needs-validation" novalidate>
                    <input type="hidden" name="settings_id" id="settings_id" value="<?php echo $general_settings[0]->id; ?>">
                    
                    <!-- <div class="form-row mb-3">
                      <div class="col-md-3">
                        <label>Signup Bonus</label>
                      </div>
                      <div class="col-md-2">
                        <label class="switch">
                          <input value="yes" type="checkbox" name="bonus_check" id="bonus_check" <?php if($general_settings[0]->signup_bonus == '1'){echo "checked";} ?> >
                          <span class="slider round"></span>
                        </label>
                      </div>
                    </div>


                    <div class="form-row mb-3">
                      <div class="col-md-3">
                        <label>Signup Bonus %</label>
                      </div>
                      <div class="col-md-2">
                        <input type="number" class="form-control form-control-sm" name="signup_percentage" id="signup_percentage" min="0" max="100" value="<?php echo $general_settings[0]->signup_bonus_percentage; ?>" required >
                        <div class="invalid-feedback">
                            Minimum value allowed 0.
                        </div>
                      </div>
                    </div> -->


                    <div class="form-row mb-3">
                      <div class="col-md-3">
                        <label>Same Picture Frequency</label>
                      </div>
                      <div class="col-md-2">
                        <input type="number" class="form-control form-control-sm" name="picture_frequency" id="picture_frequency" min="0" max="100" value="<?php echo $general_settings[0]->same_picture_frequency; ?>" required >
                        <div class="invalid-feedback">
                            Minimum value allowed 0.
                        </div>
                      </div>
                    </div>

                    <div class="form-row mb-3">
                      <div class="col-md-3">
                        <label>Default Account Status</label>
                      </div>
                      <div class="col-md-2">
                        <select class="form-control form-control-sm" name="default_account_status" id="default_account_status" required>
                          <option value="0" <?php if($general_settings[0]->default_account_status == '0'){echo "selected";} ?> >Not Live</option>
                          <option value="1" <?php if($general_settings[0]->default_account_status == '1'){echo "selected";} ?> >Live</option>
                        </select>
                      </div>
                    </div>

                    <!-- <div class="form-row mb-3">
                      <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-6">
                                <label>Allow Demo Mode</label>
                            </div>
                            <div class="col-md-6">
                                <label class="switch">
                                  <input value="yes" type="checkbox" name="demo_mode" id="demo_mode" <?php if($general_settings[0]->allow_demo_mode == '1'){echo "checked";} ?> >
                                  <span class="slider round"></span>
                                </label>
                            </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-6">
                                <label class="float-right">Demo Default Balance</label>
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control form-control-sm" name="demo_balance" id="demo_balance" min="0" max="100" value="<?php echo $general_settings[0]->default_demo_balance; ?>" required >
                                <div class="invalid-feedback">
                                    Minimum value allowed 0.
                                </div>
                            </div>
                          </div>
                      </div>
                    </div> -->


                    <!-- <div class="form-row mb-3">
                      <div class="col-md-3">
                        <label>Tax %</label>
                      </div>
                      <div class="col-md-2">
                        <input type="number" class="form-control form-control-sm" name="tax" id="tax" min="0" max="100" value="<?php echo $general_settings[0]->tax; ?>" required >
                        <div class="invalid-feedback">
                            Minimum value allowed 0.
                        </div>
                      </div>
                    </div>


                    <div class="form-row mb-3">
                      <div class="col-md-3">
                        <label>Admin Fees</label>
                      </div>
                      <div class="col-md-2">
                        <input type="number" class="form-control form-control-sm" name="admin_fees" id="admin_fees" min="0" max="100" value="<?php echo $general_settings[0]->admin_fees; ?>" required >
                        <div class="invalid-feedback">
                            Minimum value allowed 0.
                        </div>
                      </div>
                    </div> -->


                    <div class="form-row mb-3">
                      <div class="col-md-3">
                          <label>Challenge Timer</label>
                      </div>
                      <div class="col-md-2">
                          <input type="number" class="form-control form-control-sm " name="challenge_timer" id="challenge_timer" min="0" max="100" value="<?php echo $general_settings[0]->challenge_timer; ?>" required >
                          <div class="invalid-feedback">
                              Minimum value allowed 0.
                          </div>
                      </div>
                      <div class="col-md-2">
                          <select class="form-control form-control-sm" name="challenge_timer_type" id="challenge_timer_type" required>
                            <option value="h" <?php if($general_settings[0]->challenge_timer_type == 'h'){ echo "selected"; } ?> >Hour(s)</option>
                            <option value="d" <?php if($general_settings[0]->challenge_timer_type == 'd'){ echo "selected"; } ?> >Day(s)</option>
                          </select>
                          <div class="invalid-feedback">
                              Minimum value allowed 0.
                          </div>
                      </div>
                    </div>


                    <div class="form-row mb-3">
                        <div class="col-md-3">
                            <label>Game Timer</label>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control form-control-sm" name="game_timer" id="game_timer" min="0" max="100" value="<?php echo $general_settings[0]->game_timer; ?>" required>
                            <div class="invalid-feedback">
                                Minimum value allowed 0.
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control form-control-sm" name="game_timer_type" id="game_timer_type" required>
                              <option value="m" <?php if($general_settings[0]->game_timer_type == 'm'){ echo "selected"; } ?> >Min(s)</option>
                              <option value="h" <?php if($general_settings[0]->game_timer_type == 'h'){ echo "selected"; } ?> >Hour(s)</option>
                            </select>
                            <div class="invalid-feedback">
                                Minimum value allowed 0.
                            </div>
                        </div>
                      </div>


                    <div class="form-row mb-3">
                      <div class="col-md-3">
                        <label>Start Timer</label>
                      </div>
                      <div class="col-md-2">
                        <label class="switch">
                          <input type="checkbox" name="start_timer" id="start_timer" value="yes" <?php if($general_settings[0]->start_timer == '1'){ echo "checked"; } ?> >
                          <span class="slider round"></span>
                        </label>
                      </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="card custom-card">
                                <div class="card-header bg-light-blue">
                                    Game Credit Conversion
                                </div>
                                <div class="card-body">
                                    <div class="border border-success rounded p-3 mb-3">
                                        <strong>Game Credit Conversion</strong> converts real money into game credit.<br>E.g. 1 euro = 10 game credits
                                    </div>
                                    <div class="form-row mb-3">
                                      <div class="col-md-3 text-right">
                                        <label>1 Euro <i class="fas fa-equals"></i></label>
                                      </div>
                                      <div class="col-md-3">
                                        <input type="text" class="form-control form-control-sm" name="euro_conversion" id="euro_conversion" value="<?php echo $general_settings[0]->euro_conversion; ?>" required >
                                        <div class="invalid-feedback">
                                            Minimum value allowed 0.
                                        </div>
                                      </div>
                                    </div>


                                    <div class="form-row mb-3">
                                      <div class="col-md-3 text-right">
                                        <label>1 Pound <i class="fas fa-equals"></i></label>
                                      </div>
                                      <div class="col-md-3">
                                        <input type="text" class="form-control form-control-sm" name="pound_conversion" id="pound_conversion" value="<?php echo $general_settings[0]->pound_conversion; ?>" required >
                                        <div class="invalid-feedback">
                                            Minimum value allowed 0.
                                        </div>
                                      </div>
                                    </div>


                                    <div class="form-row mb-3">
                                      <div class="col-md-3 text-right">
                                        <label>1 US Dollar <i class="fas fa-equals"></i></label>
                                      </div>
                                      <div class="col-md-3">
                                        <input type="text" class="form-control form-control-sm" name="dollar_conversion" id="dollar_conversion" value="<?php echo $general_settings[0]->dollar_conversion; ?>" required >
                                        <div class="invalid-feedback">
                                            Minimum value allowed 0.
                                        </div>
                                      </div>
                                    </div>


                                    <div class="border border-success rounded p-3 mb-2 mt-4">
                                        <strong>Default Currency</strong> this is the default currency of this website.
                                    </div>
                                    <div class="form-row mb-3">
                                      <div class="col-md-3 text-right">
                                        <label>Default Currency</label>
                                      </div>
                                      <div class="col-md-3">
                                        <select class="form-control form-control-sm" name="default_currency">
                                            <option value="gbp" <?php if($general_settings[0]->default_currency == 'gbp'){echo 'selected';} ?> >Pound</option>
                                            <option value="eur" <?php if($general_settings[0]->default_currency == 'eur'){echo 'selected';} ?> >Euro</option>
                                            <option value="usd" <?php if($general_settings[0]->default_currency == 'usd'){echo 'selected';} ?> >Dollar</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Minimum value allowed 0.
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="card custom-card">
                                <div class="card-header bg-light-blue">
                                    Stake Conversion (Return on Stake) %
                                </div>
                                <div class="card-body">
                                    <div class="border border-success rounded p-3 mb-3">
                                        Formula for conversion:<br>
                                        Stake = What users enter<br>
                                        Return = Value user get for per 1 credit<br>
                                        <strong>Total Return = ((Stake / 100) * Percentage) + Stake</strong><br><br>
                                        <strong>Total return = <?php echo ((1 / 100) * $general_settings[0]->stake_conversion_level) + 1; ?> @ <?php echo $general_settings[0]->stake_conversion_level; ?>% for per 1 credit</strong>
                                    </div>
                                    <div class="form-row mb-3">
                                      <div class="col-md-4 text-right">
                                        <label>Level Game, 1 Credit <i class="fas fa-equals"></i></label>
                                      </div>
                                      <div class="col-md-3">
                                        <input type="text" class="form-control form-control-sm" name="stake_conversion_level" id="stake_conversion_level" value="<?php echo $general_settings[0]->stake_conversion_level; ?>" required >
                                        <div class="invalid-feedback">
                                            Minimum value allowed 0.
                                        </div>
                                      </div>
                                      <div>
                                          % return
                                      </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="card custom-card">
                                <div class="card-header bg-light-blue">
                                    Game Cursor
                                </div>
                                <div class="card-body">
                                    <div class="form-row mb-3">
                                      <div class="col-md-3">
                                        <label for="cursor_size">Set cursor size</label>
                                      </div>
                                      <div class="col-md-3">
                                        <input type="text" class="form-control form-control-sm" name="cursor_size" id="cursor_size" value="<?php echo $general_settings[0]->cursor_size; ?>" required >
                                        <div class="invalid-feedback">
                                            Minimum value allowed 0.
                                        </div>
                                      </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        
                        <div class="col-sm-4">
                            <input type="submit" name="btnSaveSettings" id="btnSaveSettings" value="Save" class="btn btn-success btn-block">
                        </div>
                    </div>
                </form>
            </div> <!-- End of card -->
          </div> <!-- End of card-shadow -->
        </div> <!-- End of col-md-6 -->

        <div class="col-md-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Exclude Countries, States or Towns</h6>
                </div>
                <div class="card-body">
                    <div class="form-row continents">
                        <div class="col-md-3">
                            <label>Exclude Continents</label>
                        </div>
                        <div class="col-md-9">
                            <div class="exclude_continents border border-secondary p-2">
                                <div>
                                    <?php if($blocked_continents != false){ ?>
                                        <?php foreach ($blocked_continents as $key => $value) { ?>
                                            <a href="<?php echo $base; ?>/admin/unblockcontinent?id=<?php echo $value->id; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-times-circle"></i> <?php echo $value->name; ?></a>
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <p class="border border-warning rounded p-2">No records found</p>
                                    <?php } ?>
                                </div>
                                <hr>
                                <div class="float-right m-3">
                                  <form action="<?php echo $base; ?>/admin/blockcontinent" method="post" class="form-inline needs-validation" novalidate>
                                      <select name="block_continent_id" id="block_continent_id" class="form-control form-control-sm ml-2" required>
                                          <option value="" selected disabled>Select Continent</option>
                                          <?php if($continents != false){ ?>
                                              <?php foreach ($continents as $key => $value) { ?>
                                                <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                              <?php } ?>
                                          <?php } ?>
                                      </select>
                                      <input type="submit" class="btn btn-secondary btn-sm ml-2" type="submit" name="btnExcludeContinent" value="Exclude">
                                  </form>
                              </div>
                              <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>


                    <div class="form-row countries mt-3">
                        <div class="col-md-3">
                            <label>Exclude Countries</label>
                        </div>
                        <div class="col-md-9">
                            <div class="exclude_countries border border-secondary">
                              <table class="table table-bordered">
                                <tbody>
                                  <?php if($blocked_countries != false){ ?>
                                      <tr>
                                          <td width="20%" class="d-none">
                                              <a href="" class="btn btn-sm"><i class="fas fa-times-circle"></i> Africa</a>
                                          </td>
                                          <td>
                                            <?php foreach ($blocked_countries as $key => $value) { ?>
                                              <a href="<?php echo $base; ?>/admin/unblockcountry?id=<?php echo $value->id; ?>" class="btn btn-outline-secondary btn-sm mb-2"><i class="fas fa-times-circle"></i> <?php echo $value->name; ?></a>
                                              <?php } ?>
                                          </td>
                                      </tr>
                                  <?php }else{ ?>
                                      <p class="border border-warning rounded p-2">No records found</p>
                                  <?php } ?>
                                </tbody>
                              </table>

                              <div class="float-right m-3">
                                  <form action="<?php echo $base; ?>/admin/blockcountry" method="post" class="form-inline needs-validation" novalidate>
                                      <select class="form-control form-control-sm ml-2" name="continent_id" id="continent_id" required>
                                        <option value="" selected disabled>Select Continent</option>
                                        <?php if($continents != false){ ?>
                                            <?php foreach ($continents as $key => $continent) { ?>
                                                <option value="<?php echo $continent->id; ?>"><?php echo $continent->name; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                      </select>

                                      <select class="form-control form-control-sm ml-2" name="country_id" id="country_id" required>
                                          <option value="" selected disabled>Select Country</option>
                                      </select>

                                      <input type="submit" class="btn btn-secondary btn-sm ml-2" type="submit" name="btnExcludeContinent" value="Exclude">
                                  </form>
                              </div>
                              <div class="clearfix"></div>

                            </div>
                        </div>
                    </div>


                    <div class="form-row states mt-3">
                        <div class="col-md-3">
                            <label>Exclude States</label>
                        </div>
                        <div class="col-md-9">
                            <div class="exclude_states border border-secondary">
                              <table class="table table-bordered">
                                <tbody>
                                  <?php if($blocked_states != false){ ?>
                                      <tr>
                                          <td width="20%" class="d-none">
                                              <a href="" class="btn btn-sm"><i class="fas fa-times-circle"></i> Africa</a>
                                          </td>
                                          <td>
                                            <?php foreach ($blocked_states as $key => $value) { ?>
                                              <a href="<?php echo $base; ?>/admin/unblockstate?id=<?php echo $value->id; ?>" class="btn btn-outline-secondary btn-sm mb-2"><i class="fas fa-times-circle"></i> <?php echo $value->name; ?></a>
                                              <?php } ?>
                                          </td>
                                      </tr>
                                  <?php }else{ ?>
                                      <p class="border border-warning rounded p-2">No records found</p>
                                  <?php } ?>
                                </tbody>
                              </table>
                                
                              <div class="float-right m-3">
                                  <form action="<?php echo $base; ?>/admin/blockstate" method="post" class="form-inline needs-validation" novalidate>
                                      <select class="form-control form-control-sm ml-2" name="continent_id" id="continent_id_2" required>
                                        <option value="" selected disabled>Select Continent</option>
                                        <?php if($continents != false){ ?>
                                            <?php foreach ($continents as $key => $continent) { ?>
                                                <option value="<?php echo $continent->id; ?>"><?php echo $continent->name; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                      </select>

                                      <select class="form-control form-control-sm ml-2" name="country_id" id="country_id_2" required>
                                          <option value="" selected disabled>Select Country</option>
                                      </select>

                                      <select class="form-control form-control-sm ml-2" name="state_id" id="state_id_2" required>
                                          <option value="" selected disabled>Select State</option>
                                      </select>

                                      <input type="submit" class="btn btn-secondary btn-sm ml-2" type="submit" name="btnExcludeContinent" value="Exclude">
                                  </form>
                              </div>
                              <div class="clearfix"></div>
                                
                            </div>
                        </div>
                    </div>



                    <div class="form-row cities mt-3">
                        <div class="col-md-3">
                            <label>Exclude Cities in States</label>
                        </div>
                        <div class="col-md-9">
                            <div class="exclude_states border border-secondary">
                              <table class="table table-bordered">
                                <tbody>
                                  <?php if($blocked_cities != false){ ?>
                                      <tr>
                                          <td width="20%" class="d-none">
                                              <a href="" class="btn btn-sm"><i class="fas fa-times-circle"></i> Africa</a>
                                          </td>
                                          <td>
                                            <?php foreach ($blocked_cities as $key => $value) { ?>
                                              <a href="<?php echo $base; ?>/admin/unblockcity?id=<?php echo $value->id; ?>" class="btn btn-outline-secondary btn-sm mb-2"><i class="fas fa-times-circle"></i> <?php echo $value->name; ?></a>
                                              <?php } ?>
                                          </td>
                                      </tr>
                                  <?php }else{ ?>
                                      <p class="border border-warning rounded p-2">No records found</p>
                                  <?php } ?>
                                </tbody>
                              </table>
                                
                              <div class="float-right m-3">
                                  <form action="<?php echo $base; ?>/admin/blockcity" method="post" class="form-inline needs-validation" novalidate>
                                      <select class="form-control form-control-sm ml-2 mb-2" name="continent_id" id="continent_id_3" required>
                                        <option value="" selected disabled>Select Continent</option>
                                        <?php if($continents != false){ ?>
                                            <?php foreach ($continents as $key => $continent) { ?>
                                                <option value="<?php echo $continent->id; ?>"><?php echo $continent->name; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                      </select>

                                      <select class="form-control form-control-sm ml-2 mb-2" name="country_id" id="country_id_3" required>
                                          <option value="" selected disabled>Select Country</option>
                                      </select>

                                      <select class="form-control form-control-sm ml-2 mb-2" name="state_id" id="state_id_3" required>
                                          <option value="" selected disabled>Select State</option>
                                      </select>

                                      

                                      <select class="form-control form-control-sm ml-2 mb-2" name="city_id" id="city_id_3" required>
                                          <option value="" selected disabled>Select City</option>
                                      </select>

                                      <input class="btn btn-secondary btn-sm ml-2 mb-2" type="submit" name="btnExcludeContinent" value="Exclude">
                                  </form>
                              </div>
                              <div class="clearfix"></div>
                                
                            </div>
                        </div>
                    </div>


                    <div class="form-row cities mt-3">
                        <div class="col-md-3">
                            <label>Exclude Cities</label>
                        </div>
                        <div class="col-md-9">
                            <div class="exclude_states border border-secondary">
                              <table class="table table-bordered">
                                <tbody>
                                  <?php if($blocked_cities != false){ ?>
                                      <tr>
                                          <td width="20%" class="d-none">
                                              <a href="" class="btn btn-sm"><i class="fas fa-times-circle"></i> Africa</a>
                                          </td>
                                          <td>
                                            <?php foreach ($blocked_cities as $key => $value) { ?>
                                              <a href="<?php echo $base; ?>/admin/unblockcity?id=<?php echo $value->id; ?>" class="btn btn-outline-secondary btn-sm mb-2"><i class="fas fa-times-circle"></i> <?php echo $value->name; ?></a>
                                              <?php } ?>
                                          </td>
                                      </tr>
                                  <?php }else{ ?>
                                      <p class="border border-warning rounded p-2">No records found</p>
                                  <?php } ?>
                                </tbody>
                              </table>
                                
                              <div class="float-right m-3">
                                  <form action="<?php echo $base; ?>/admin/blockcity" method="post" class="form-inline needs-validation" novalidate>
                                      <select class="form-control form-control-sm ml-2 mb-2" name="continent_id" id="continent_id_4" required>
                                        <option value="" selected disabled>Select Continent</option>
                                        <?php if($continents != false){ ?>
                                            <?php foreach ($continents as $key => $continent) { ?>
                                                <option value="<?php echo $continent->id; ?>"><?php echo $continent->name; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                      </select>

                                      <select class="form-control form-control-sm ml-2 mb-2" name="country_id" id="country_id_4" required>
                                          <option value="" selected disabled>Select Country</option>
                                      </select>

                                      <select class="form-control form-control-sm ml-2 mb-2" name="city_id" id="city_id_4" required>
                                          <option value="" selected disabled>Select City</option>
                                      </select>

                                      <input class="btn btn-secondary btn-sm ml-2 mb-2" type="submit" name="btnExcludeContinent" value="Exclude">
                                  </form>
                              </div>
                              <div class="clearfix"></div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div> <!-- End of row -->
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

    $this->load->view('api/change_country_on_continent_selection');
    $this->load->view('api/change_state_on_country_selection');
    $this->load->view('api/change_county_on_state_selection');
    //$this->load->view('api/change_city_on_county_selection');
    $this->load->view('api/change_city_on_country_selection');
    $this->load->view('api/change_city_on_state_selection');

    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY HTML CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/footers/html/body_html_close_tag');
?>