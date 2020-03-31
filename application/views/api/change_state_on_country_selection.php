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

            var selectedContinent = $("#country_id option:selected").val();

            //var directory = "/SpotTheBallUKClient/index.php";

            var domain_name = "<?php echo $base; ?>/api/getstates";

            $.ajax({

                type: "POST",

                url: domain_name,

                data: { country_id : selectedContinent }

            }).done(function(data){

                //console.log(data);

                $("#state_id").html(data);

            });

        });





        $("select#country_id_2").change(function(){

            var selectedContinent = $("#country_id_2 option:selected").val();

            //var directory = "/SpotTheBallUKClient/index.php";

            var domain_name = "<?php echo $base; ?>/api/getstates";

            $.ajax({

                type: "POST",

                url: domain_name,

                data: { country_id : selectedContinent }

            }).done(function(data){

                //console.log(data);

                $("#state_id_2").html(data);

            });

        }); 





        $("select#country_id_3").change(function(){

            var selectedContinent = $("#country_id_3 option:selected").val();

            //var directory = "/SpotTheBallUKClient/index.php";

            var domain_name = "<?php echo $base; ?>/api/getstates";

            $.ajax({

                type: "POST",

                url: domain_name,

                data: { country_id : selectedContinent }

            }).done(function(data){

                //console.log(data);

                $("#state_id_3").html(data);

            });

        }); 





        $("select#country_id_4").change(function(){

            var selectedContinent = $("#country_id_4 option:selected").val();

            //var directory = "/SpotTheBallUKClient/index.php";

            var domain_name = "<?php echo $base; ?>/api/getstates";

            $.ajax({

                type: "POST",

                url: domain_name,

                data: { country_id : selectedContinent }

            }).done(function(data){

                //console.log(data);

                $("#state_id_4").html(data);

            });

        }); 

    });

</script>