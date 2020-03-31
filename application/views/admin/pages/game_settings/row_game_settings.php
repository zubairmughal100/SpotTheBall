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
<div class="container-fluid" style="    border: 1px solid goldenrod;
    border-radius: 4px;
    padding: 19px;
    margin-bottom: 10px">
    
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Prize Name</th>
                <th>Prize Value</th>
                <th>Prize type</th>
                <th>Status</th>
                <th>Stake Id</th>
                <th>Actions</th>
            </tr>
        </thead>
        <?php if($the_row_prize){?>
        <tbody>
             <?php foreach ($the_row_prize as $key => $the_row_prize) { ?>
            <tr>
                <td><?php echo $the_row_prize->id; ?></td>
                <td><?php echo $the_row_prize->prize_name; ?></td>
                <td><?php echo $the_row_prize->prize_value; ?></td>
                <td><?php echo $the_row_prize->prize_type; ?></td>
                <td><?php echo $the_row_prize->status; ?></td>
                <td><?php echo $the_row_prize->Stake_id ; ?></td>
                <td><a href="#" data-toggle="modal"  class="edit_data" id="<?php echo $the_row_prize->id; ?>"><i class="fas fa-edit "></i></a> / <a href="<?php echo $base; ?>/admin/deleteprizes?id=<?php echo $the_row_prize->id ; ?>" style="color: red"><i class="fas fa-trash-alt"></i></a></i></td>
            </tr>
           <?php } ?>
        </tbody>
      <?php }else { echo "";}?>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>
    </table>
</div>
<!-- edit model -->
<div id="add_data_Modal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                      
                </div>  
                <div class="modal-body">  
                     <form action="<?php echo $base; ?>/admin/updaterowprize" method="post" enctype="multipart/form-data"> 
                          <label> Name</label>  
                          <input type="text" name="prize_name" value="" id="prize_name" class="form-control" />  
                          <br />  
                          <label>Prize value</label>  
                          <input name="prize_value" id="prize_value" class="form-control"></input>  
                          <br />  
                          <label>Prize type</label>  
                          <select name="prize_type" id="Prize_type" class="form-control">  
                               <option value="Asset">Asset</option>  
                               <option value="Money">Money</option>  
                          </select>  
                          <br />  
                          <label>Stake Id</label>  
                          <select name="Stake_Row" id="Stake_Row" class="form-control" required>
                            
                              <option value="" selected disabled>Select a <b style="color: black;">ID</b></option>
                                <?php foreach ($ActiveStakes as $key => $ActiveStakes) { ?>
                                    <option value="<?php echo $ActiveStakes->id; ?>" ><?php echo $ActiveStakes->id; ?></option>
                                <?php } ?>
                            
                            
                        </select>  
                          <br />  
                          <label>Prize Image</label>  
                           <input type="file" name="img_1" id="img_1" class="form-control" accept=".jpg">  
                          <br />  
                          <input type="hidden" name="id" id="id" value="">
                          <input type="submit" name="btnUpdateRowPrize" id="btnUpdateRowPrize" class="btn btn-custom-pink text-white" value="Update">
                     </form>  
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>  
<!-- end of Edit model -->

                        <!-- <div class="row mt-3 mb-3">
                            <div class="col-md-8 ">
                                <div class="form border border-warning rounded p-3">
                                    <form action="<?php echo $base; ?>/admin/uploadrowwinningimage" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="id" id="id" value="<?php echo $the_row_game[0]->id; ?>">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group row">
                                                    <label for="inputFile" class="col-sm-5">Upload Winning Image</label>
                                                    <input type="file" name="inputFile" id="inputFile" class="form-control col-sm-7">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="submit" class="btn btn-custom-pink btn-block text-white" name="btnUploadImage" id="btnUploadImage" value="Upload Image">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <?php if(!empty($the_row_game[0]->winning_image)){ ?>
                                    <div class="border border-warning rounded p-3">
                                        <a href="<?php echo $assets; ?>game_images/row/<?php echo $the_row_game[0]->winning_image; ?>" download>
                                            <img width="50%" class="img-responsive" src="<?php echo $assets; ?>game_images/row/<?php echo $the_row_game[0]->winning_image; ?>?<?php echo date('s'); ?>">
                                        </a>
                                    </div>
                                <?php }else{ ?>
                                    <div class="border border-warning rounded p-3">
                                        You did not upload a file yet!
                                    </div>
                                <?php } ?>
                            </div>
                        </div> -->

                        <!-- Row Prize -->
                       

                    <div class="border border-warning rounded p-3">
                        <p>Row Game Settings <button style="margin-left: 73%; background-color: rgb(186,98,98);height: 38px;
    margin-radius: 16px;
    border-radius: 7px;" data-toggle="modal" data-target="#exampleModalCenter" >AddStakes</button></p>
                        <hr>
                        <form action="<?php echo $base; ?>/admin/updaterowgamesettings" method="post" >
                            <input type="hidden" name="id" id="id" value="<?php echo $the_row_game[0]->id; ?>">
                            <div class="form-group row">
                              <label for="min_stake" class="col-sm-1 col-form-label">Min Stake</label>
                              <div class="col-sm-2">
                                <input type="number" class="form-control" id="min_stake" name="min_stake" value="<?php echo $the_row_game[0]->min_stake; ?>">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="max_stake" class="col-sm-1 col-form-label">Max Stake</label>
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
                        </form>
                            
                            <div class="border text-center p-3">
                                <h1 style="    margin-left: -110px;">How many in a row you have to get?</h1>
                                
                                <?php foreach ($Stake_Row as $key => $stake) { ?>
                                 <div class="row" style="margin-left: 60px;">
                                  <form class="form-inline" action="<?php echo $base; ?>/admin/updateStake" method="POST" >
                                    <h2 style=" color: black;">ID:<?php echo $stake->id; ?></h2>
                                   <i style="    margin-left: 24px;
    margin-right: 10px;
     color: black;
    font-size: 25px;
    font-weight: 800;">rows</i> <input type="text" name="row" style="width: 7%;    padding-left: 17px;
    font-weight: 900;
    font-size: 21px" value="<?php echo $stake->Rows; ?>">
                                   <i style="    margin-left: 24px;
    margin-right: 10px;
    color: black;
    font-size: 25px;
    font-weight: 800;">stake</i><input type="text" name="stake" style="width: 7%;    padding-left: 17px;
    font-weight: 900;
    font-size: 21px" value="<?php echo $stake->Stake; ?>">
                                   <label class="switch" style="    margin-left: 21px;">
  <input name="status"  type="checkbox"<?php if($stake->Status == "on")
  {
    echo "checked";
  }?>
  >
  <span class="slider round"></span>
</label>
<input type="hidden" name="id" value="<?php echo $stake->id; ?>">
<button style="margin-left: 21px; background-color: rgb(49,87,201);color: #fff;" class="btn" type="submit">update</button>
                                  </form>
                                 </div>
                                  <?php }?>
 
    
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
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">ADD Stakes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <h3 style="margin-left: 70px;">Id Will Added Automaticaly</h3>
      <form action="<?php echo $base; ?>/admin/SaveStake" method="post">
      <div class="modal-body">
        
       <div class="row">
        <div class="col-md-6">
            <label>Stakes
                <input type="text" name="Stakes" class="form-control">
            </label>
        </div>
        <div class="col-md-6">
            <label><b>Rows</b>
                <input type="text" name="Rows" class="form-control">
            </label>
        </div>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
  </form>
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