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
?>

<!-- include summernote css/js -->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
<style type="text/css">
  .panel-heading {
    border-bottom:1px solid #ccc;
  }
  .note-popover {
    display: none;
  }
</style>

<?php
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
      

      <!-- Content Row -->
      <div class="row">

        <div class="col-xl-6">
          <!-- Area Chart -->
          <div class="card custom-card shadow mb-4">
            <div class="card-header bg-light-blue py-3">
              <h6 class="m-0 font-weight-bold">Edit Blog Page</h6>
            </div>
            <div class="card-body">
                <form action="<?php echo $base; ?>/admin/updateblog" method="post" class="needs-validation" novalidate>
                  <input type="hidden" name="id" value="<?php echo $the_blog[0]->id; ?>">
                  <div class="form-group row">
                      <label class="col-sm-3 col-form-label" for="is_public">Blog page type</label>
                      <div class="col-sm-4">
                          <select class="form-control" name="is_public" id="is_public" required>
                              <option value="1" <?php if($the_blog[0]->is_draft == '1'){echo 'selected';} ?>>Public</option>
                              <option value="0" <?php if($the_blog[0]->is_draft == '0'){echo 'selected';} ?>>Logged In</option>
                          </select>
                      </div>
                      <div class="col-sm-5 text-right">
                          <input type="submit" name="btnDraftBlog" class="btn btn-outline-secondary" value="Save Draft">
                          <input type="submit" name="btnPublishBlog" class="btn btn-primary" value="Publish">
                      </div>
                  </div>

                  <div class="form-group">
                      <input type="text" style="color:#000 !important;" name="tab_name" class="form-control" placeholder="Tab name" value="<?php echo $the_blog[0]->tab_name; ?>" required>
                  </div>

                  <div class="form-group">
                      <input type="text" name="title" class="form-control" style="color:#000 !important;" placeholder="Enter title" value="<?php echo $the_blog[0]->title; ?>" required>
                  </div>

                  <textarea id="summernote" name="message" class="form-control" required><?php echo $the_blog[0]->message; ?></textarea>
                  <p id="total-caracteres" style="padding:5px; margin-top: 5px; background-color: #eee; width: 60px;">0</p>

                </form>
            </div>
          </div>
        </div>

        <div class="col-xl-6">
          <!-- Area Chart -->
          <div class="card custom-card shadow mb-4">
            <div class="card-header bg-light-blue py-3">
              <h6 class="m-0 font-weight-bold">Empty Header</h6>
            </div>
            <div class="card-body">
                <?php if($blogpages != false){ ?>
                    <table class="table">
                      <thead class="thead-dark">
                        <tr>
                          <th>Title</th>
                          <th>Content</th>
                          <th>Is Public</th>
                          <th>Draft</th>
                          <th width="17%">Option</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($blogpages as $key => $blog) { ?>
                          <tr>
                            <td scope="col"><?php echo $blog->title; ?></td>
                            <td scope="col"><textarea style="width:100%; overflow: hidden; background-color:#fff; border: none; resize: none;" disabled><?php echo trimtext($blog->message, 0, 100); ?>...</textarea></td>
                            <td scope="col"><?php if($blog->is_public == '1'){echo "Public";}else{echo 'Logged in';} ?></td>
                            <td><?php if($blog->is_draft == '0'){echo "Published";}else{echo "Draft";} ?></td>
                            <td>
                                <a href="<?php echo $base; ?>/admin/editblog?id=<?php echo $blog->id; ?>" class="btn btn-outline-secondary btn-sm">Edit</a>
                                <a href="<?php echo $base; ?>/admin/deleteblog?id=<?php echo $blog->id; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
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
?>
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
<script>
    $(document).ready(function() {
      $('#summernote').summernote({
          height: 300,                 // set editor height
          minHeight: null,             // set minimum height of editor
          maxHeight: null,             // set maximum height of editor
          focus: true ,                 // set focus to editable area after initializing summernote
          callbacks: {
              onKeydown: function(e) {
              var limiteCaracteres = 255;
              var caracteres = $(".note-editable").text();
              var totalCaracteres = caracteres.length;

              //Update value
              $("#total-caracteres").text(totalCaracteres);

              //Check and Limit Charaters
              if(totalCaracteres >= limiteCaracteres){
                return false;
              }         
              }
          }
        });
      });
</script>

<?php
    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY HTML CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/footers/html/body_html_close_tag');
?>