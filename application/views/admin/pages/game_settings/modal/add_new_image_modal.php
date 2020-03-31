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
<script type="text/javascript" src="https://cdn.rawgit.com/asvd/dragscroll/master/dragscroll.js"></script>
<!-- Modal -->
<div class="modal fade" id="addNewImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content custom-card p-0">
      <div class="modal-header bg-light-blue p-0">
        <h5 class="modal-title" id="exampleModalLongTitle">Add New Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-gray-light">
          <form action="<?php echo $base; ?>/admin/addimagetodb" method="post" id="frmAddNewImage" class="frmAddNewImage needs-validation" novalidate>
            <input type="hidden" name="unique_image_id" id="unique_image_id" value="<?php echo $unique_image_id; ?>">

            <div class="form-group row">
              <label for="title" class="col-sm-2 col-form-label">Image Title</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="title" name="title" required>
              </div>
            </div>

            <div class="form-group row">
              <label for="description" class="col-sm-2 col-form-label">Image Description</label>
              <div class="col-sm-10">
                <textarea class="form-control form-control-sm" id="description" name="description" required></textarea>
              </div>
            </div>

            <div class="form-group row">
              <label for="tags" class="col-sm-2 col-form-label">Image Tags</label>
              <div class="col-sm-10">
                <small>Seperate tags by , (comma)</small>
                <input type="text" class="form-control form-control-sm" id="tags" name="tags" required>
              </div>
            </div>
<style type="text/css">
 
</style>
            
            
            
            <div class="form-group row mt-0">
              <label for="staticEmail" class="col-sm-2 col-form-label">Upload Images</label>
              <div class="col-sm-10">
                  <div class="form-row">
                      <div class="col-md-6">
                          <div class="form-row">
                              <div class="col-md-9 p-0">
                                  <div class="card main dragscroll" style="border:1px solid #595959 !important;width: 242px;
  height: 162px;
  overflow: hidden; border-radius: 0px !important;">
                                      <div id="div" >
                                        <img id="img_solution" style="border-radius: 0px !important; height: 160px;" class="zoomin card-img-top" src="<?php echo $assets; ?>images/empty_image.png" alt="Card image cap">
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-2 p-0" navbar>
                                  <div style="border:1px solid #595959; height: 100%;" class="text-center">
                                      <div class="form-group mt-5">
                                          <button type="button" onclick="zoomin()" class="btn btn-info btn-circle bg-white" style="color:#000; border:1px solid #000;"  >
                                            <i class="fas fa-plus"></i>
                                          </button>
                                      </div>

                                      <div class="form-group">
                                          <button type="button" class="btn btn-info btn-circle bg-white" onclick="zoomout()" style="color:#000; border:1px solid #000;" id="ZoomOut" >
                                            <i class="fas fa-minus"></i>
                                          </button>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <!-- Upload Image -->
                          <div class="form-group row mt-2">
                            <div class="col-sm-11">            
                              <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#uploadModal">Upload Solution</button>
                            </div>
                          </div>

                      </div>
                      <div class="col-md-6">
                          <div class="form-row">
                              <div class="col-md-9 p-0">
                                  <div class="card main dragscroll" style="border:1px solid #595959 !important;width: 242px;
  height: 162px;
  overflow: hidden; border-radius: 0px !important;" >
                                      <img id="img_challenge" style="border-radius: 0px !important; height: 160px;" class="card-img-top" src="<?php echo $assets; ?>images/empty_image.png" alt="Card image cap">
                                  </div>
                              </div>
                              <div class="col-md-2 p-0">
                                  <div style="border:1px solid #595959; height: 100%;" class="text-center">
                                      <div class="form-group mt-5">
                                          <button type="button" class="btn btn-info btn-circle bg-white" style="color:#000; border:1px solid #000;"onclick="zoomin1()">
                                            <i class="fas fa-plus"></i>
                                          </button>
                                      </div>

                                      <div class="form-group">
                                          <button type="button" class="btn btn-info btn-circle bg-white" style="color:#000; border:1px solid #000;"  onclick="zoomout1()">
                                            <i class="fas fa-minus"></i>
                                          </button>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <!-- Upload Image -->
                          <div class="form-group row mt-2">
                            <div class="col-sm-11">            
                              <div class="custom-file">
                                  <input type="file" onchange="BrowsechalangeImage()" name="img_browse_challenge" id="img_browse_challenge" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" style="cursor: pointer;">
                                  <label class="custom-file-label bg-info" style="color: #fff !important;" for="inputGroupFile01">Challenge Image</label>
                              </div>
                            </div>
                          </div>

                      </div>
                      <div class="clearfix"></div>
                  </div>
              </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-group row">
                      <label for="img_frquency" class="col-sm-4">Image Frequency</label>
                      <div class="col-sm-8">
                          <input type="number" class="form-control form-control-sm" name="img_frquency" id="img_frquency" value="<?php echo $general_settings[0]->same_picture_frequency; ?>" required>
                      </div>
                    </div>


                    <div class="form-group row">
                      <label for="status" class="col-sm-4 col-form-label">Status</label>
                      <div class="col-sm-8">
                        <select class="form-control form-control-sm" name="status" id="status" required>
                            <option value="1" selected>Active</option>
                            <option value="0">Disable</option>
                        </select>
                      </div>
                    </div>
                    

                    <div class="form-group row">
                      <label for="move" class="col-sm-4 col-form-label">Move</label>
                      <div class="col-sm-8">
                        <select class="form-control form-control-sm" name="move" id="move" required>
                            <option value="live" selected>Live</option>
                            <option value="demo">Demo</option>
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row border border-danger bg-warning rounded p-3 mr-3 ml-3">
                      <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" name="solution_img_name" id="solution_img_name" placeholder="Solution image name" required>
                        <div class="invalid-feedback">
                            Please select solution image*.
                        </div>
                      </div>

                      <div class="col-sm-6">
                          <input type="text" class="form-control form-control-sm" name="challenge_img_name" id="challenge_img_name" placeholder="Challenge image name" required>
                          <div class="invalid-feedback">
                              Please select challenge image*.
                          </div>
                      </div>
                    </div>

                    <div class="form-group row border border-danger bg-warning rounded p-3 mr-3 ml-3">
                      <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" name="x_axis" id="x_axis" placeholder="x-axis" required>
                        <div class="invalid-feedback">
                            x-axis required*.
                        </div>
                      </div>

                      <div class="col-sm-6">
                          <input type="text" class="form-control form-control-sm" name="y_axis" id="y_axis" placeholder="y-axis" required>
                          <div class="invalid-feedback">
                              y-axis required*.
                          </div>
                      </div>
                    </div>
                </div>
            </div>

            

            <div class="form-group row">
                <label class="col-sm-2"></label>
                <div class="col-sm-10">
                    <button type="button" class="btn btn-custom-pink btn-sm" id="btnCancelGalleryAdd">Cancel</button>
                    <button type="submit" class="btn btn-custom-pink btn-sm">Save</button>
                </div>
            </div>
          </form>
      </div>
      <div class="modal-footer bg-gray d-none">
        <button type="button" class="btn btn-custom-pink btn-sm" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-custom-pink btn-sm">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="uploadModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="width: 750px;margin: auto;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" style="font-size: 39px;">&times;</button>
        <!-- <h4 class="modal-title">File upload form</h4> -->
      </div>
      <div class="modal-body">

        <!-- Form -->
        <form method='post' action='' enctype="multipart/form-data">
          <h1 style="    color: black;
    margin-left: 145px;">Select Image for Solution</h1>
          Select file : <input type='file' name='file' id='file' class='form-control' onchange="loadFile(event)" style="height: 43px;" ><br>
          <!-- <canvas id="imageCanvas" width="713" height="405" style="border:1px solid #d3d3d3;"></canvas><br> -->

          <!-- <div class="form-group border border-success rounded p-3">
            <label for="cursor_size">Enter Cursor Size</label>
            <input type="number" class="form-control" id="cursor_size" name="cursor_size" aria-describedby="cursor_sizeHelp" placeholder="Enter cursor size" value="10">
            <small id="cursor_sizeHelp" class="form-text text-muted">Using this value you can control cursor size.</small>
          </div> -->

          <!-- spotthe ball library add in div for image x y axies -->
          <div id="spot-the-ball-demo" style="cursor:none;">
          </div>
          <input type='button' class='btn btn-info close' value='Upload' id='btn_upload' onclick="upload()" data-dismiss="modal">

        </form>

        <!-- Preview-->
        <div id='preview'></div>
      </div>
    </div>

  </div>
</div>



<!-- Modal Add New Level -->
<div class="modal fade" id="addNewLevelModal" tabindex="-1" role="dialog" aria-labelledby="addNewLevelModalModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content custom-card p-0">
      <div class="modal-header bg-light-blue p-0">
        <h5 class="modal-title" id="exampleModalCenterTitle">Add New Level</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo $base; ?>/admin/addlevel" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-body">
            <div class="form-group row">
              <label for="level_name" class="col-sm-4 col-form-label">Level Name</label>
              <div class="col-sm-8">
                <input type="text" class="form-control form-control-sm" id="level_name" name="level_name" placeholder="Level name" value="Level" readonly required>
                <div class="invalid-feedback">
                    Level name required*
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="level_number" class="col-sm-4 col-form-label">Level Number</label>
              <div class="col-sm-8">
                <input type="number" class="form-control form-control-sm" min="1" max="999" id="level_number" name="level_number" placeholder="Level number" value="<?php echo $new_level_number; ?>" readonly required>
                <div class="invalid-feedback">
                    Level number required*
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="percentage_increase" class="col-sm-4 col-form-label">Percentage Increase</label>
              <div class="col-sm-8">
                <input type="number" class="form-control form-control-sm" min="0.10" max="999" step="0.10" value="0.10" id="percentage_increase" name="percentage_increase" required>
                <div class="invalid-feedback">
                    Percentage increase required*
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="passmarks" class="col-sm-4 col-form-label">Pass Marks</label>
              <div class="col-sm-8">
                <input type="number" class="form-control form-control-sm" min="0.10" max="999" step="0.10" value="0.10" id="passmarks" name="passmarks" required>
                <div class="invalid-feedback">
                    Pass marks required*
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="min_stake" class="col-sm-4 col-form-label">Min Stake</label>
              <div class="col-sm-8">
                <input type="number" class="form-control form-control-sm" min="0.10" max="99999" value="0.10" step="0.10" id="min_stake" name="min_stake" required>
                <div class="invalid-feedback">
                    Min stake required*
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="max_stake" class="col-sm-4 col-form-label">Max Stake</label>
              <div class="col-sm-8">
                <input type="number" class="form-control form-control-sm" min="0.10" max="99999" value="0.10" step="0.10" id="max_stake" name="max_stake" required>
                <div class="invalid-feedback">
                    Max stake required*
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="status" class="col-sm-4 col-form-label">Status</label>
              <div class="col-sm-8">
                <select class="form-control form-control-sm" name="status" id="status" required>
                    <option value="1" selected>Active</option>
                    <option value="0">Disable</option>
                </select>
                <div class="invalid-feedback">
                    Status required*
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="status" class="col-sm-4 col-form-label">Level Image</label>
              <div class="col-sm-8">
                <input type="file" class="form-control form-control-sm" id="level_image" name="level_image" required>
                <div class="invalid-feedback">
                    Level Image required*
                </div>
              </div>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="btnAddLevel" id="btnAddLevel">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php



?>
