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
<html lang="en">
<head>
	<title>Bootstrap Example</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link href="<?php echo $cssbase; ?>admin/font-awesome.css" rel="stylesheet" type="text/css">

	<style type="text/css">
		.well{
			height: 250px;
		} 

		.absCenter {
			margin: auto;
			position: absolute;
			top: 0; left: 0; bottom: 0; right: 0;
		}

		.absCenter.is-Responsive {
			width: 95%; 
			height: 60%;
			min-width: 200px;
			max-width: 400px;
		}

		#logo-container img{
			margin: auto;
			display: block;
			padding-bottom: 1em;
			width: 100%;
			min-width: 100px;
			max-width: 200px;
			max-height: 100%;
		}
		.logo-nipr { padding-left: 2%; padding-right: 6%; } /* visual eye-hack */

		.checkbox { font-size: 0.85em; }

		.footer {
			color: #013f82;
			font-size: 18px !important;
			font-weight: bold;
		}

		.btn-custom {
			border: 1px solid #000!important;
			color: #000!important;
			padding-left: 40px!important;
			padding-right: 40px!important;
			background-color: #01ff01!important;
		}
	</style>
</head>
<body class="bg-primary">

<div class="absCenter is-Responsive">
	<div class="alert alert-warning border border-warning alert-dismissible fade show " role="alert">
  <strong>Holy guacamole!</strong> You should check in on some of those fields below.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
    <div id="logo-container">
      <!--<img class="img-responsive logo-naic" src="http://dev.bea.cr/naic/images/naic_logo.png" alt="NAIC Logo">-->
      <h1 class="text-center text-white">Spot The Ball</h1><br>
    </div>
    <div class="card">
    	<div class="card-header">
    		Login
    	</div>
    	<div class="card-body">
    		<form action="<?php echo $base; ?>/admin/proccesslogin" method="post" id="loginForm" class="needs-validation" novalidate>
		      	<div class="input-group mb-3">
					<div class="input-group-prepend">
				    	<span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
					</div>
					<input type="text" name="username" id="username" class="form-control" placeholder="Username or email" aria-label="Username" aria-describedby="basic-addon1" required>
					<div class="invalid-feedback">
			        	Username required*
			        </div>
				</div>
				<div class="input-group mb-3">

					<div class="input-group-prepend">
				    	<span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
					</div>
					<input type="password" name="password" id="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required>
					<div class="invalid-feedback">
			        	Password required*
			        </div>
				</div>
		      	<div class="form-group">
		        	<input type="submit" name="btnLogin" id="btnLogin" class="btn btn-custom btn-block" value="Login">
		      	</div>
		      	<div class="form-group text-center">
		        	<a href="#">Forgot Password</a>
		      	</div>
		    </form>
    	</div>
    </div><br>
  <div class="footer text-center">Copyright &copy; <?php echo date('Y') ?> STB</div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
</body>
</html>
