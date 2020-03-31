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
    $(document).ready(function(){
        $("select#continent_id").change(function(){
            var selectedContinent = $("#continent_id option:selected").val();
            //var directory = "/SpotTheBallUKClient/index.php";
            var domain_name = "<?php echo $base; ?>/api/getcountries";
            $.ajax({
                type: "POST",
                url: domain_name,
                data: { continent_id : selectedContinent }
            }).done(function(data){
                console.log(data);
                $("#country_id").html(data);
            });
        }); 
    });
</script>