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


<script>
    //$('#btnSaveAccount').prop('disabled', true);
    (function($){
          $(document).ready(function(){
            ////////////////////////////////////////////
            // Update user info
            ////////////////////////////////////////////
            // Enable save button, remove readonly attributres
            $( "#btnEditAccount" ).click(function() {
                //Enable all fields to editable
                $("#frmUpdateUserInfo").each(function(){
                    if($(this).find(':text, :file, :checkbox, select, textarea, input').is('[readonly]')){
                        $(this).find(':text, :file, :checkbox, select, textarea, input').removeAttr('readonly');
                        console.log("Inside Foreach");
                        return false; //For good measures, I know you are looking at my code, if you are a developer sure play around with it, you might learn a thing or two ;)
                    }
                });


                $( "#btnEditAccount" ).prop("disabled", true);

                // $( "#btnSaveUserInfo" ).prop("disabled", false);
            });
            //End of enable social media editing
            //Submit form user info
            $("#frmUpdateUserInfo").submit(function(event){
                event.preventDefault(); //prevent default action
                var post_url = $(this).attr("action"); //get form action url
                var request_method = $(this).attr("method"); //get form GET/POST method
                var form_data = $(this).serialize(); //Encode form elements for submission

                // $( "#btnSaveUserInfo" ).prop("disabled", true);
                $( "#btnSaveUserInfo" ).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
                );

                $.ajax({
                  url : post_url,
                  type: request_method,
                  data : form_data
                }).done(function(response){ //
                    console.log(response);
                  
                    if(response === "success"){
                          $( "#message_account" ).removeClass( "d-none" );
                          $( "#message_account" ).removeClass( "alert-danger" );
                          $( "#message_account" ).addClass( "alert-success" );
                          $( "#message_account" ).html("You have successfully updated your account information");
                    }else if(response === "fail"){
                          $( "#message_account" ).removeClass( "d-none" );
                          $( "#message_account" ).removeClass( "alert-success" );
                          $( "#message_account" ).addClass( "alert-danger" );
                          $( "#message_account" ).html("Error, could not update your account information");
                    }else{
                          $( "#message_account" ).removeClass( "d-none" );
                          $( "#message_account" ).removeClass( "alert-success" );
                          $( "#message_account" ).addClass( "alert-danger" );
                          $( "#message_account" ).html("500 server error, report has been sent, thank you");
                    }

                    //Disable all fields to editable
                    $("#frmUpdateUserInfo").each(function(){
                        if( $(this).find(':text, :file, :checkbox, select, textarea, input').is('[readonly]') === false ){
                            $(this).find(':text, :file, :checkbox, select, textarea, input').prop("readonly", true);
                            return false; //For good measures, I know you are looking at my code, if you are a developer sure play around with it, you might learn a thing or two ;)
                        }
                    });

                    $( "#btnSaveUserInfo" ).html(
                        '<span class="glyphicon glyphicon-floppy-disk"></span> Save'
                    );

                    $( "#btnEditAccount" ).prop("disabled", false);

                    // $( "#btnSaveUserInfo" ).prop("disabled", true);

                    //Reload page in 10 seconds
                    //setTimeout(location.reload.bind(location), 10000);
                });
            });



            
            ////////////////////////////////////////////
            // Update user address
            ////////////////////////////////////////////
            // Enable save button, remove readonly attributres
            $( "#btnEditAddress" ).click(function() {
                //Enable all fields to editable
                $("#frmUpdateAddress").each(function(){
                    if($(this).find(':text, :file, :checkbox, select, textarea, input').is('[readonly]')){
                        $(this).find(':text, :file, :checkbox, select, textarea, input').removeAttr('readonly');
                        console.log("Inside Foreach");
                        return false; //For good measures, I know you are looking at my code, if you are a developer sure play around with it, you might learn a thing or two ;)
                    }
                });


                $( "#btnEditAddress" ).prop("disabled", true);

                $( "#btnUpdateAddress" ).prop("disabled", false);
            });
            //End of enable social media editing
            //Submit form address
            $("#frmUpdateAddress").submit(function(event){
                event.preventDefault(); //prevent default action
                var post_url = $(this).attr("action"); //get form action url
                var request_method = $(this).attr("method"); //get form GET/POST method
                var form_data = $(this).serialize(); //Encode form elements for submission
                //console.log(form_data);return false;

                $( "#btnUpdateAddress" ).prop("disabled", true);
                $( "#btnUpdateAddress" ).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
                );

                $.ajax({
                  url : post_url,
                  type: request_method,
                  data : form_data
                }).done(function(response){ //
                    console.log(response);
                  
                    if(response === "success"){
                          $( "#message_address" ).removeClass( "d-none" );
                          $( "#message_address" ).removeClass( "alert-danger" );
                          $( "#message_address" ).addClass( "alert-success" );
                          $( "#message_address" ).html("You have successfully updated your address");
                    }else if(response === "fail"){
                          $( "#message_address" ).removeClass( "d-none" );
                          $( "#message_address" ).removeClass( "alert-success" );
                          $( "#message_address" ).addClass( "alert-danger" );
                          $( "#message_address" ).html("Error, could not update your address");
                    }else{
                          $( "#message_address" ).removeClass( "d-none" );
                          $( "#message_address" ).removeClass( "alert-success" );
                          $( "#message_address" ).addClass( "alert-danger" );
                          $( "#message_address" ).html("500 server error, report has been sent, thank you");
                    }

                    //Disable all fields to editable
                    $("#frmUpdateAddress").each(function(){
                        if( $(this).find(':text, :file, :checkbox, select, textarea, input').is('[readonly]') === false ){
                            $(this).find(':text, :file, :checkbox, select, textarea, input').prop("readonly", true);
                            $(this).find('select').attr("readonly", true);
                            return false; //For good measures, I know you are looking at my code, if you are a developer sure play around with it, you might learn a thing or two ;)
                        }
                    });

                    $( "#btnUpdateAddress" ).html(
                        '<span class="glyphicon glyphicon-floppy-disk"></span> Save'
                    );

                    $( "#btnEditAddress" ).prop("disabled", false);

                    $( "#btnUpdateAddress" ).prop("disabled", true);

                    //Reload page in 10 seconds
                    //setTimeout(location.reload.bind(location), 10000);
                });
            });


            ////////////////////////////////////////////
            // Show hide old password
            ////////////////////////////////////////////
            // Toggle show / hide old password
            $( "#show_old_pass" ).click(function() {
                if($( "#show_old_pass_icon" ).hasClass('glyphicon-eye-open')){
                    $( "#show_old_pass_icon" ).removeClass('glyphicon-eye-open');
                    $( "#show_old_pass_icon" ).addClass('glyphicon-eye-close');
                    $("#old_pass").prop({type:"text"});
                }else{
                    $( "#show_old_pass_icon" ).removeClass('glyphicon-eye-close');
                    $( "#show_old_pass_icon" ).addClass('glyphicon-eye-open');
                    $("#old_pass").prop({type:"password"});
                }
                
            });

            // Toggle show / hide password
            $( "#show_pass" ).click(function() {
                if($( "#show_pass_icon" ).hasClass('glyphicon-eye-open')){
                    $( "#show_pass_icon" ).removeClass('glyphicon-eye-open');
                    $( "#show_pass_icon" ).addClass('glyphicon-eye-close');
                    $("#new_pass").prop({type:"text"});
                }else{
                    $( "#show_pass_icon" ).removeClass('glyphicon-eye-close');
                    $( "#show_pass_icon" ).addClass('glyphicon-eye-open');
                    $("#new_pass").prop({type:"password"});
                }
                
            });

            // Toggle show / hide confirm password
            $( "#show_confirm_pass" ).click(function() {
                if($( "#show_confirm_pass_icon" ).hasClass('glyphicon-eye-open')){
                    $( "#show_confirm_pass_icon" ).removeClass('glyphicon-eye-open');
                    $( "#show_confirm_pass_icon" ).addClass('glyphicon-eye-close');
                    $("#new_pass_confirm").prop({type:"text"});
                }else{
                    $( "#show_confirm_pass_icon" ).removeClass('glyphicon-eye-close');
                    $( "#show_confirm_pass_icon" ).addClass('glyphicon-eye-open');
                    $("#new_pass_confirm").prop({type:"password"});
                }
                
            });
            //Submit form password
            $("#frmUpdatePassword").submit(function(event){
                event.preventDefault(); //prevent default action
                var post_url = $(this).attr("action"); //get form action url
                var request_method = $(this).attr("method"); //get form GET/POST method
                var form_data = $(this).serialize(); //Encode form elements for submission

                $( "#btnUpdatePassword" ).prop("disabled", true);
                $( "#btnUpdatePassword" ).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...'
                );

                $.ajax({
                  url : post_url,
                  type: request_method,
                  data : form_data
                }).done(function(response){ //
                    console.log(response);
                  
                    if(response === "success"){
                        $( "#message_password_change" ).removeClass( "d-none" );
                        $( "#message_password_change" ).removeClass( "alert-danger" );
                        $( "#message_password_change" ).addClass( "alert-success" );
                        $( "#message_password_change" ).html("You have successfully updated your password");
                    }else if(response === "fail"){
                        $( "#message_password_change" ).removeClass( "d-none" );
                        $( "#message_password_change" ).removeClass( "alert-success" );
                        $( "#message_password_change" ).addClass( "alert-danger" );
                        $( "#message_password_change" ).html("Error, could not update your password");
                    }else if(response === "pass_no_match"){
                        $( "#message_password_change" ).removeClass( "d-none" );
                        $( "#message_password_change" ).removeClass( "alert-success" );
                        $( "#message_password_change" ).addClass( "alert-danger" );
                        $( "#message_password_change" ).html("Error, password does not match");
                    }else if(response === "old_pass_wrong"){
                        $( "#message_password_change" ).removeClass( "d-none" );
                        $( "#message_password_change" ).removeClass( "alert-success" );
                        $( "#message_password_change" ).addClass( "alert-danger" );
                        $( "#message_password_change" ).html("Error, old password doesn't match");
                    }else if(response === "tampered"){
                        $( "#message_password_change" ).removeClass( "d-none" );
                        $( "#message_password_change" ).removeClass( "alert-success" );
                        $( "#message_password_change" ).addClass( "alert-danger" );
                        $( "#message_password_change" ).html("Error, please refresh page and try again");
                    }else{
                        $( "#message_password_change" ).removeClass( "d-none" );
                        $( "#message_password_change" ).removeClass( "alert-success" );
                        $( "#message_password_change" ).addClass( "alert-danger" );
                        $( "#message_password_change" ).html("500 server error, report has been sent, thank you");
                    }

                    //Disable all fields to editable
                    $("#frmUpdatePassword").each(function(){
                        $(this).find('input:password').val('');
                    });

                    $( "#btnUpdatePassword" ).html(
                        'Change Password'
                    );

                    $( "#btnUpdatePassword" ).prop("disabled", false);

                    //Reload page in 10 seconds
                    //setTimeout(location.reload.bind(location), 10000);
                });
            });


        });
    })(jQuery);
</script>