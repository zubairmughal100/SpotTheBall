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
    if(!$hasPendingDocuments){
        $this->load->view('player/essentials/body/main_nav_open');
        $this->load->view('player/essentials/body/main_nav');
        $this->load->view('player/essentials/body/main_nav_close');
    }
    

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
        <?php if(!$hasPendingDocuments){ ?>
            <div class="col-md-4">
                <?php $this->load->view('player/pages/myaccount/settings/settings_menu_left'); ?>
            </div>
        <?php } ?>
        <div class="<?php if($hasPendingDocuments){echo "col-md-12";}else{echo "col-md-8";} ?>">
            <div class="card" style="margin-bottom:30px;">
                <div class="card-header">
                    Documents
                    <?php if($hasPendingDocuments){ ?>
                        <a href="<?php echo $base; ?>/authorization/logout" class="float-right">Logout</a>
                        <div class="clearfix"></div>
                    <?php } ?>
                </div>
                <div class="card-body">
                    <?php
                        if($this->session->userdata('player_logged_in_data')){  
                            $user_data = $this->session->userdata('player_logged_in_data');
                        }
                    ?>
                    <?php if($hasPendingDocuments){ ?>
                        <p>Welcome back, <?php echo $user_data['first_name']. ' ' .$user_data['last_name']; ?>
                            
                           
                        </p>
                        <!-- <div class="col-md-6"> -->
                        <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text">Login URL</span>
                              </div>
                              <input type="text" id="text-copy" class="form-control" value="<?php echo $base; ?>/account/login" aria-label="url">
                              <div class="input-group-append">
                                <button class="input-group-text" id="urlCopied" onclick="copy();">Copy</button>
                              </div>
                            </div>
                        <!-- </div> -->
                    <?php } ?>

                    <?php
                        $documents_pending = $this->session->flashdata('documents_pending');
                        if(strlen($documents_pending) > 0){
                            echo '<div class="alert alert-danger alert-dismissible fade show" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                            echo $documents_pending;
                            echo '</div><br>';
                        }
                    ?>



                    <table class="table table-striped">
                        <thead>
                            <tr>
                              <th scope="col"></th>
                              <th scope="col">Document Type</th>
                              <th scope="col">Status</th>
                            </tr>
                        </thead>
                      <tbody>
                        <?php if($documents != false){ ?>
                            <?php foreach ($documents as $key => $document) {?>
                                <?php
                                    if($document->approved == '0'){
                                        $color = "table-danger";
                                    }else{
                                        $color = "table-success";
                                    }
                                ?>
                                <tr>
                                    <th scope="row"><span class="glyphicon glyphicon-file"></span></th>
                                    <td>
                                        <?php
                                            $doc_type = "";
                                            if($document->document_type == 'bank_statement'){
                                                $doc_type = "Bank Statement";
                                            }else if($document->document_type == 'proof_of_id'){
                                                $doc_type = "Proof of ID";
                                            }else if($document->document_type == 'utility_bill'){
                                                $doc_type = "Utility Bill";
                                            }
                                        ?>
                                        <a href="<?php echo $assets; ?>account_documents/<?php echo $document->image_url; ?>" download><?php echo $doc_type; ?></a>
                                    </td>
                                    <td class="<?php echo $color; ?>">
                                        <?php
                                            if($document->approved == '1'){
                                                echo "Approved";
                                            }else{
                                                echo "Pending Approval";
                                            }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php }else{ ?>
                            <div class="border border-danger alert alert-danger rounded p-3">
                                User does not have any documents!
                            </div>
                        <?php } ?>
                      </tbody>
                    </table>

<?php if($hasPendingDocuments){ ?>
    <div class="alert alert-info">
        <h3>Bit more information needed</h3>
        <h6>Please upload any of these documents to verify your Identity.</h6>
        <div class="passport">
            <h4>Driving License or Passport <br>Utility bill &amp; Bank statement</h4> 
        </div>
    </div>

    <div class="error">
        <?php
            $update_success = $this->session->flashdata('update_success');
            if(strlen($update_success) > 0){
                echo '<div class="alert alert-success alert-dismissible fade show border border-success" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                echo $update_success;
                echo '</div><br>';
            }
            $update_fail = $this->session->flashdata('update_fail');
            if(strlen($update_fail) > 0){
                echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" ole="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                echo $update_fail;
                echo '</div><br>';
            }
        ?>
    </div>

    <?php if($documents != false){ ?>
        <?php foreach ($documents as $key => $document) {
                if($document->document_type == "proof_of_id"){ ?>
                    <?php if($document->approved == '0'){ ?>
                        <div class="alert alert-danger border border-danger rounded pt-5 pl-4 pr-4 mb-3">
                            <form action="<?php echo $base; ?>/authorization/reuploadproofofid" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $document->id; ?>">
                                <input type="hidden" name="old_file" value="<?php echo $document->image_url; ?>">

                                <div class="form-group row">
                                    <label class="col-sm-3">Upload Driving License / Passwort</label>
                                    <div class="col-sm-6">
                                        <input type="file" name="file_proof_of_id" id="file_proof_of_id" accept=".doc,.pdf,.jpeg,.jpg,.png">
                                    </div>
                                    <div class="col-sm-3 custom">
                                        <input class="btn btn-custom btn-block" type="submit" name="btnUploadID" id="btnUploadID" value="Re-upload">
                                    </div>
                                </div>
                            </form>
                        </div>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    <?php } ?>

    <?php if($documents != false){ ?>
        <?php foreach ($documents as $key => $document) {
                if($document->document_type == "utility_bill"){ ?>
                    <?php if($document->approved == '0'){ ?>
                        <div class="alert alert-danger border border-danger rounded pt-5 pl-4 pr-4 mb-3">
                            <form action="<?php echo $base; ?>/authorization/reuploadutility" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $document->id; ?>">
                                <input type="hidden" name="old_file" value="<?php echo $document->image_url; ?>">

                                <div class="form-group row">
                                    <label class="col-sm-3">Upload Utility Bill</label>
                                    <div class="col-sm-6">
                                        <input type="file" name="file_utility_bill" id="file_utility_bill" accept=".doc,.pdf,.jpeg,.jpg,.png">
                                    </div>
                                    <div class="col-sm-3 custom">
                                        <input class="btn btn-custom btn-block" type="submit" name="btnUploadID" id="btnUploadID" value="Re-upload">
                                    </div>
                                </div>       
                            </form>
                        </div>
                <?php } ?>
            <?php } ?> 
        <?php } ?>
    <?php } ?>

    <?php if($documents != false){ ?>
        <?php foreach ($documents as $key => $document) {
                if($document->document_type == "bank_statement"){ ?>
                    <?php if($document->approved == '0'){ ?>
                        <div class="alert alert-danger border border-danger rounded pt-5 pl-4 pr-4 mb-3">
                            <form action="<?php echo $base; ?>/authorization/reuploadbankstatement" method="post" enctype="multipart/form-data">  
                                <input type="hidden" name="id" value="<?php echo $document->id; ?>">
                                <input type="hidden" name="old_file" value="<?php echo $document->image_url; ?>">

                                <div class="form-group row">
                                    <label class="col-sm-3">Upload Bank Statement</label>
                                    <div class="col-sm-6">
                                        <input type="file" name="file_bank_statement" id="file_bank_statement" accept=".doc,.pdf,.jpeg,.jpg,.png">
                                    </div>
                                    <div class="col-sm-3 custom">
                                        <input class="btn btn-custom btn-block" type="submit" name="btnUploadID" id="btnUploadID" value="Re-upload">
                                    </div>
                                </div>
                            </form>
                        </div>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    <?php } ?>
    <div class="form-group">
        <div class="alert alert-info" role="alert">
            <p>(Bank statement &amp; Utility Bill Must be within the last 3 months)</p>
        </div>
    </div>
<?php } ?>
                    
                </div>
            </div>
        </div>
    </div>


<?php
    ////////////////////////////////////////////////////////////////////////////////////////
    // FOOTER CONTENT
    ////////////////////////////////////////////////////////////////////////////////////////
    //$this->load->view('player/essentials/footers/html/footer_content');

    ////////////////////////////////////////////////////////////////////////////////////////
    // MAIN CONTENT CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/body_main_content_end');


    ////////////////////////////////////////////////////////////////////////////////////////
    // JS, Custom JS
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/footers/js/footer_js');
    $this->load->view('player/pages/myaccount/settings/js/form_control_js');
?>
<script type="text/javascript">
            function copy() 
            {
                var copyText = document.getElementById("text-copy");
                copyText.select();
                document.execCommand("Copy");
                alert("Copied to clipboard!");
            }
        </script>
<?php

    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/body/body_tag_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // HTML CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('player/essentials/footers/html/html_tag_close');
?>

