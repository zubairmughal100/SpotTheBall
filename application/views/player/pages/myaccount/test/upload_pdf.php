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

<!DOCTYPE html>
<html>
<body>


<h3>Upload file</h3>
<form action="<?php echo $base ?>/authorization/proccesstestupload" method="post" enctype="multipart/form-data">
  Select a file: <input type="file" name="myFile" id="myFile"><br><br>
  <input type="submit" value="Upload File">
</form>

<br>
<hr>

<h3>Upload image</h3>
<form action="<?php echo $base ?>/authorization/proccesstestupload" method="post" enctype="multipart/form-data">
  Select a file: <input type="file" name="myImage" id="myImage"><br><br>
  <input type="submit" value="Upload File">
</form>


</body>
</html>