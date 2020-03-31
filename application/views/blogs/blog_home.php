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

    <title>Blog - Home</title>
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
        <div class="row mt-5 mb-5">
            <div class="col-md-12">

                <?php if($blogs != false){ ?>
                    <?php foreach ($blogs as $key => $blog) { ?>
                        <div class="card mb-3">
                          <div class="row no-gutters">
                            <div class="col-md-8">
                              <div class="card-body">
                                <h5 class="card-title"><?php echo $blog->title; ?></h5>
                                <p class="card-text"><?php echo shorten($blog->message, 50); ?>...</p>
                                <p class="card-text"><small class="text-muted">Posted on <?php $new_date = strtotime($blog->date_created) ; echo date('F d, Y', $new_date); ?></small></p>
                                <a class="btn btn-primary btn-sm" href="<?php echo $base; ?>/blog/page?id=<?php echo $blog->id; ?>">Read More</a>
                              </div>
                            </div>
                          </div>
                        </div>
                    <?php } ?>
                <?php }else{ ?>
                    <div class="alert alert-warning border border-warning rounded p-3">
                        No pages found!
                    </div>
                <?php } ?>
                

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