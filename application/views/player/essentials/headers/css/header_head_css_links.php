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

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="assets/images/favicon/favicon.png">
<link rel="canonical" href="https://getbootstrap.com/docs/3.3/examples/navbar/">

<title><?php if(!empty($general_settings[0]->site_title)){echo $general_settings[0]->site_title;}else{"Million Dollars";} ?></title>

<!-- Bootstrap core CSS -->
<link href="<?php echo $cssbase; ?>bootstrap.min.css" rel="stylesheet">
<script src="https://js.stripe.com/v3/"></script>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>