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

<!-- Custom fonts for this template-->
<link href="<?php echo $cssbase; ?>admin/font-awesome.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<!-- Custom styles for this template-->
<link href="<?php echo $cssbase; ?>admin/sb-admin-2.min.css" rel="stylesheet">
<link href="<?php echo $cssbase; ?>admin/dataTables.bootstrap4.min.css" rel="stylesheet">


<style type="text/css">
    .btn-custom {
        border: 1px solid #000!important;
        color: #000!important;
        padding-left: 40px!important;
        padding-right: 40px!important;
        background-color: #01ff01!important;
    }
    .btn-custom-pink {
        border: 1px solid #000!important;
        color: #000;
        padding-left: 40px!important;
        padding-right: 40px!important;
        background-color: #ba6363!important;
    }

    .switch {
          position: relative;
          display: inline-block;
          width: 60px;
          height: 34px;
        }

        .switch input { 
          opacity: 0;
          width: 0;
          height: 0;
        }

        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          -webkit-transition: .4s;
          transition: .4s;
        }

        .slider:before {
          position: absolute;
          content: "";
          height: 26px;
          width: 26px;
          left: 4px;
          bottom: 4px;
          background-color: white;
          -webkit-transition: .4s;
          transition: .4s;
        }

        .switch input:checked + .slider {
          *background-color: #2196F3;
          background-color: #00d100;
        }

        .switch input:focus + .slider {
          box-shadow: 0 0 1px #2196F3;
        }

        .switch input:checked + .slider:before {
          -webkit-transform: translateX(26px);
          -ms-transform: translateX(26px);
          transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
          border-radius: 34px;
        }

        .slider.round:before {
          border-radius: 50%;
        }


        a.close-btn {
            position: absolute;
            right: 0;
            top:0;
            padding: 0px 5px 5px 5px;
            background-color: #000;
            color: #fff;
            width: 25px;
            height: 25px;
            border-radius: 25px;
            text-align: center;
            margin-top: -10px;
            margin-right: -10px;
            text-decoration: none;
        }
        a.close-btn:hover {
            background-color: red;
        }

        .custom-card {
          border-radius: 0px !important;
        }
        .bg-light-blue {
          background-color: rgb(150,187,242) !important;
          color:#000;
          padding: 5px !important;
          border-radius: 0px !important;
        }
        .bg-gray {
          background-color:#a8a8a8;
        }
        .bg-gray-light {
          background-color:#e3e3e3;
        }

        .img_stat_left {
            position: absolute;
            left: 0;
            top:0%;
            padding: 0px 5px 5px 5px;
            background-color: rgba(120, 120, 120,0.8);
            color: #fff;
            width: 40px;
            height: 40px;
            line-height: 40px;
            border-radius: 3px;
            text-align: center;
            text-decoration: none;
            font-weight: 800;
            font-size: 1rem;
        }

        .img_stat_right {
            position: absolute;
            right: 0;
            bottom:0%;
            padding: 0px 5px 5px 5px;
            background-color: rgba(120, 120, 120,0.8);
            color: #fff;
            width: 40px;
            height: 40px;
            line-height: 40px;
            border-radius: 3px;
            margin-bottom: 49px;
            text-align: center;
            text-decoration: none;
            font-weight: 800;
            font-size: 1rem;
        }
        .gallery {
            max-height: 500px;
            overflow: auto;
        }

        .frmAddNewImage label{
          color: #000 !important;
        }
        .frmAddNewImage input, .frmAddNewImage textarea, .frmAddNewImage select {
          background-color:#e3e3e3 !important;
          border: 1px solid #858585;
          color: #000;
        }
        .frmAddNewImage input:focus, .frmAddNewImage textarea:focus, .frmAddNewImage select:focus {
          background-color:#d9d9d9 !important;
          border: 1px solid #858585;
          color: #000;
        }


        .vertical-center {
            min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
            min-height: 100vh; /* These two lines are counted as one :-)       */

            display: flex;
            align-items: center;
        }

        fieldset {
          border: 1px solid #b8b8b8 !important;
          padding: 10px;
          border-radius: 5px;
        } 
        
        legend {
          font-size: 16px;
          width: auto;
          color: #000;
        }

        /*Card Image for gallery*/
        .gallery_card_img {
          height: 150px;
          *background-size: contain;
          background-size: cover;
          background-repeat: no-repeat;
          background-position: 50% 50%;
        }
</style>