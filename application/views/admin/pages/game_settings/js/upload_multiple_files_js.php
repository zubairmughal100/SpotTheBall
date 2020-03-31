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
    
    $("#frmPrize").submit(function(event){
        event.preventDefault(); //prevent default action
        var post_url = $(this).attr("action"); //get form action url
        var request_method = $(this).attr("method"); //get form GET/POST method
        var form_data = $(this).serialize(); //Encode form elements for submission

        

        $.ajax({
          url : post_url,
          type: request_method,
          data : form_data
        }).done(function(response){ //
            console.log(response);
            if(response != "fail"){
                //console.log("Yuppa doodle");
                var form_data = new FormData();
                var ins = document.getElementById('prizefile').files.length;
                for (var x = 0; x < ins; x++) {
                    form_data.append("files[]", document.getElementById('prizefile').files[x]);
                }
                var level_id = $('#level_id').val();
                $.ajax({
                    url: 'uploadprizeimages?prizelid=' + response, // point to server-side PHP script 
                    //dataType: 'text', // what to expect back from the PHP script
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function (response) {
                        console.log(response);
                        if(response === "success"){
                            console.log("yuppa doodle");
                        }
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });

            }else{
                console.log("Sad days");
            }
            //Reload page in 10 seconds
            setTimeout(location.reload.bind(location), 1000);
        });
    });
    
</script>