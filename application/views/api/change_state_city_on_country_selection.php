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

            var selectedCountry = $("#country_id option:selected").val();

            //var directory = "/SpotTheBallUKClient/index.php";

            var domain_name = "<?php echo $base; ?>/api/getstatessignup";

            $.ajax({

                type: "POST",

                url: domain_name,

                data: { country_id : selectedCountry }

            }).done(function(data){

                //console.log(data);

                if(data == 'not_found'){

                    $('#state_id').hide();



                    //Get city by country

                    //var selectedCountiesForCities = $("#county_id option:selected").val();

                    //console.log(selectedCountiesForCities);

                    //var directory = "/SpotTheBallUKClient/index.php";

                    var domain_name = "<?php echo $base; ?>/api/getcitiesbycountryid";

                    $.ajax({

                        type: "POST",

                        url: domain_name,

                        data: { country_id : selectedCountry }

                    }).done(function(data){

                        //console.log(data);

                        $("#city_id").html(data);

                    });



                }else{

                    $('#state_id').show();

                    $("#state_id").html(data);



                    //get cities by state

                    var selectedStates = $("#state_id option:selected").val();
                    //console.log("Selected State: " + selectedStates);

                    //console.log(selectedStates);

                    //var directory = "/SpotTheBallUKClient/index.php";

                    var domain_name = "<?php echo $base; ?>/api/getcitiesbystateid";

                    $.ajax({

                        type: "POST",

                        url: domain_name,

                        data: { state_id : selectedStates }

                    }).done(function(data){

                        //console.log(data);

                        $("#city_id").html(data);

                    });



                }

            });

        });

        $("select#state_id").change(function(){
            var selectedStates = $("#state_id option:selected").val();
                    //console.log("Selected State: " + selectedStates);

                    //console.log(selectedStates);

                    //var directory = "/SpotTheBallUKClient/index.php";

                    var domain_name = "<?php echo $base; ?>/api/getcitiesbystateid";

                    $.ajax({

                        type: "POST",

                        url: domain_name,

                        data: { state_id : selectedStates }

                    }).done(function(data){

                        //console.log(data);

                        $("#city_id").html(data);

                    });
        });

    });

</script>