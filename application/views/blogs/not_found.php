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

  function shorten($string, $length){
    if (strlen($string) >= $length) {
        return substr($string, 0, $length). " ... " . substr($string, -5);
    }else {
        return $string;
    }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <title>Blog - 404 Not found</title>

    <style type="text/css">
        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,600,700');
@import url('https://fonts.googleapis.com/css?family=Catamaran:400,800');
.error-container {
  text-align: center;
  font-size: 106px;
  font-family: 'Catamaran', sans-serif;
  font-weight: 800;
  margin: 70px 15px;
}
.error-container > span {
  display: inline-block;
  position: relative;
}
.error-container > span.four {
  width: 136px;
  height: 43px;
  border-radius: 999px;
  background:
    linear-gradient(140deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.07) 43%, transparent 44%, transparent 100%),
    linear-gradient(105deg, transparent 0%, transparent 40%, rgba(0, 0, 0, 0.06) 41%, rgba(0, 0, 0, 0.07) 76%, transparent 77%, transparent 100%),
    linear-gradient(to right, #d89ca4, #e27b7e);
}
.error-container > span.four:before,
.error-container > span.four:after {
  content: '';
  display: block;
  position: absolute;
  border-radius: 999px;
}
.error-container > span.four:before {
  width: 43px;
  height: 156px;
  left: 60px;
  bottom: -43px;
  background:
    linear-gradient(128deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.07) 40%, transparent 41%, transparent 100%),
    linear-gradient(116deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.07) 50%, transparent 51%, transparent 100%),
    linear-gradient(to top, #99749D, #B895AB, #CC9AA6, #D7969E, #E0787F);
}
.error-container > span.four:after {
  width: 137px;
  height: 43px;
  transform: rotate(-49.5deg);
  left: -18px;
  bottom: 36px;
  background: linear-gradient(to right, #99749D, #B895AB, #CC9AA6, #D7969E, #E0787F);
}

.error-container > span.zero {
  vertical-align: text-top;
  width: 156px;
  height: 156px;
  border-radius: 999px;
  background: linear-gradient(-45deg, transparent 0%, rgba(0, 0, 0, 0.06) 50%,  transparent 51%, transparent 100%),
    linear-gradient(to top right, #99749D, #99749D, #B895AB, #CC9AA6, #D7969E, #ED8687, #ED8687);
  overflow: hidden;
  animation: bgshadow 5s infinite;
}
.error-container > span.zero:before {
  content: '';
  display: block;
  position: absolute;
  transform: rotate(45deg);
  width: 90px;
  height: 90px;
  background-color: transparent;
  left: 0px;
  bottom: 0px;
  background:
    linear-gradient(95deg, transparent 0%, transparent 8%, rgba(0, 0, 0, 0.07) 9%, transparent 50%, transparent 100%),
    linear-gradient(85deg, transparent 0%, transparent 19%, rgba(0, 0, 0, 0.05) 20%, rgba(0, 0, 0, 0.07) 91%, transparent 92%, transparent 100%);
}
.error-container > span.zero:after {
  content: '';
  display: block;
  position: absolute;
  border-radius: 999px;
  width: 70px;
  height: 70px;
  left: 43px;
  bottom: 43px;
  background: #FDFAF5;
  box-shadow: -2px 2px 2px 0px rgba(0, 0, 0, 0.1);
}

.screen-reader-text {
    position: absolute;
    top: -9999em;
    left: -9999em;
}
    
@keyframes bgshadow {
  0% {
    box-shadow: inset -160px 160px 0px 5px rgba(0, 0, 0, 0.4);
  }
  45% {
    box-shadow: inset 0px 0px 0px 0px rgba(0, 0, 0, 0.1);
  }
  55% {
    box-shadow: inset 0px 0px 0px 0px rgba(0, 0, 0, 0.1);
  }
  100% {
    box-shadow: inset 160px -160px 0px 5px rgba(0, 0, 0, 0.4);
  }
}

/* demo stuff */
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
body {
  background-color: #FDFAF5;
  margin-bottom: 50px;
}
html, button, input, select, textarea {
    font-family: 'Montserrat', Helvetica, sans-serif;
    color: #bbb;
}
h1 {
  text-align: center;
  margin: 30px 15px;
}
.zoom-area { 
  max-width: 490px;
  margin: 30px auto 30px;
  font-size: 19px;
  text-align: center;
}
.link-container {
  text-align: center;
}
a.more-link {
  text-transform: uppercase;
  font-size: 13px;
    background-color: #de7e85;
    padding: 10px 15px;
    border-radius: 0;
    color: #fff;
    display: inline-block;
    margin-right: 5px;
    margin-bottom: 5px;
    line-height: 1.5;
    text-decoration: none;
  margin-top: 50px;
  letter-spacing: 1px;
}
    </style>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
          <a class="navbar-brand" href="<?php echo $base; ?>/blog">Blog</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="nav-link" href="<?php echo $base; ?>">Play Game <span class="sr-only">(current)</span></a>
              </li>
            </ul>
          </div>
      </div>
    </nav>


    <div class="container">
        <div class="row mt-4 mb-4">
            <div class="col-md-12">
                <h1>404 Error Page not found</h1>
                
                <section class="error-container">
                  <span class="four"><span class="screen-reader-text">4</span></span>
                  <span class="zero"><span class="screen-reader-text">0</span></span>
                  <span class="four"><span class="screen-reader-text">4</span></span>
                </section>
                <div class="link-container">
                  <a href="<?php echo $base; ?>/blog" class="more-link">Visit Home</a>
                </div>
            </div>
        </div>

        <hr>
        <footer class="text-center">
            <p>Copy &copy; <?php echo date('Y'); ?></p>
        </footer>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </body>
</html>