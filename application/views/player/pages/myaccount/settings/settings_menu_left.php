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

<div class="list-group">
    <a href="<?php echo $base. '/account/settings' ?>" class="list-group-item list-group-item-action <?php if($subpage == "home"){echo ' active';} ?>">Home
    <span class="float-right">
        <span class="glyphicon glyphicon-home">
        </span>
    </span>
    </a>
    <a href="<?php echo $base. '/account/addfund' ?>" class="list-group-item list-group-item-action <?php if($subpage == "addfund"){echo ' active';} ?>">Add Fund
        <span class="float-right">
            <span class="glyphicon glyphicon-credit-card">
            </span>
        </span>
    </a>
    <a href="<?php echo $base. '/account/uploaddocuments' ?>" class="list-group-item list-group-item-action <?php if($subpage == "uploaddocuments"){echo ' active';} ?>">My Documents
        <span class="float-right">
            <span class="glyphicon glyphicon-file">
            </span>
        </span>
    </a>
    <a href="<?php echo $base. '/account/prizehistory' ?>" class="list-group-item list-group-item-action <?php if($subpage == "prizehistory"){echo ' active';} ?>">Prize History
        <span class="float-right">
            <span class="glyphicon glyphicon-gift">
            </span>
        </span>
    </a>
</div>