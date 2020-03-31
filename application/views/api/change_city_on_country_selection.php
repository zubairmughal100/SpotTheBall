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

        $("select#country_id").change(function(){

            var selectedCounties = $("#country_id option:selected").val();

            //console.log(selectedCounties);

            //var directory = "/SpotTheBallUKClient/index.php";

            var domain_name = "<?php echo $base; ?>/api/getcitiesbycountryid";

            $.ajax({

                type: "POST",

                url: domain_name,

                data: { country_id : selectedCounties }

            }).done(function(data){

                //console.log(data);

                $("#city_id").html(data);

            });

        });





        $("select#country_id_2").change(function(){

            var selectedCounties = $("#country_id_2 option:selected").val();

            //console.log(selectedCounties);

            //var directory = "/SpotTheBallUKClient/index.php";

            var domain_name = "<?php echo $base; ?>/api/getcitiesbycountryid";

            $.ajax({

                type: "POST",

                url: domain_name,

                data: { country_id : selectedCounties }

            }).done(function(data){

                //console.log(data);

                $("#city_id_2").html(data);

            });

        });





        $("select#country_id_3").change(function(){

            var selectedCounties = $("#country_id_3 option:selected").val();

            //console.log(selectedCounties);

            //var directory = "/SpotTheBallUKClient/index.php";

            var domain_name = "<?php echo $base; ?>/api/getcitiesbycountryid";

            $.ajax({

                type: "POST",

                url: domain_name,

                data: { country_id : selectedCounties }

            }).done(function(data){

                //console.log(data);

                $("#city_id_3").html(data);

            });

        });





        $("select#country_id_4").change(function(){

            var selectedCounties = $("#country_id_4 option:selected").val();

            //console.log(selectedCounties);

            //var directory = "/SpotTheBallUKClient/index.php";

            var domain_name = "<?php echo $base; ?>/api/getcitiesbycountryid";

            $.ajax({

                type: "POST",

                url: domain_name,

                data: { country_id : selectedCounties }

            }).done(function(data){

                //console.log(data);

                $("#city_id_4").html(data);

            });

        });

    });

</script>