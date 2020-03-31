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
<!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo $base; ?>/admin">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-futbol"></i>
        </div>
        <div class="sidebar-brand-text mx-3">S THE BALL</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo $base; ?>/admin">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- <li class="nav-item <?php if($pagename == "blogpages"){echo "active";} ?>">
        <a class="nav-link" href="<?php echo $base; ?>/admin/blogpages">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Pages</span></a>
      </li> -->

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Notifications
      </div>

      <!-- Nav Item -  Menu -->
      <li class="nav-item <?php if($pagename == "prizeclaim"){echo "active";} ?>">
        <a class="nav-link" href="<?php echo $base; ?>/admin/prizeclaim">
          <i class="fas fa-gift"></i>
          <span>Prize Claim</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        General Settings
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item <?php if($pagename == "country"){echo "active";} ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-globe-americas"></i>
          <span>Country</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Country Settings:</h6>
            <a class="collapse-item" href="<?php echo $base; ?>/admin/addcountry">Add Country</a>
            <a class="collapse-item" href="<?php echo $base; ?>/admin/addstate">Add State</a>
            <a class="collapse-item" href="<?php echo $base; ?>/admin/addcityusa">Add City USA</a>
            <a class="collapse-item" href="<?php echo $base; ?>/admin/addcity">Add City</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Menu -->
      <li class="nav-item <?php if($pagename == "banned_list"){echo "active";} ?>">
        <a class="nav-link" href="<?php echo $base; ?>/admin/bannedlist">
          <i class="fas fa-user-slash"></i>
          <span>Banned List</span></a>
      </li>


      <!-- Nav Item -  Menu -->
      <li class="nav-item <?php if($pagename == "users"){echo "active";} ?>">
        <a class="nav-link" href="<?php echo $base; ?>/admin/users">
          <i class="fas fa-user-cog"></i>
          <span>Manage Users</span></a>
      </li>


      <!-- Nav Item -  Menu -->
      <li class="nav-item <?php if($pagename == "newuser"){echo "active";} ?>">
        <a class="nav-link" href="<?php echo $base; ?>/admin/newuser">
          <i class="fas fa-user-cog"></i>
          <span>Add New User</span></a>
      </li>


      <!-- Nav Item -  Menu -->
      <li class="nav-item <?php if($pagename == "messages"){echo "active";} ?>">
        <a class="nav-link" href="<?php echo $base; ?>/admin/messages">
          <i class="fas fa-cog"></i>
          <span>Game Messages</span></a>
      </li>


      <!-- Nav Item -  Menu -->
      <li class="nav-item <?php if($pagename == "general_settings"){echo "active";} ?>">
        <a class="nav-link" href="<?php echo $base; ?>/admin/settings">
          <i class="fas fa-cog"></i>
          <span>Settings</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Game Settings
      </div>


      <!-- Nav Item - Charts -->
      <li class="nav-item <?php if($pagename == "addgallery"){echo "active";} ?>">
        <a class="nav-link" href="<?php echo $base; ?>/admin/addgallery">
          <i class="fas fa-images"></i>
          <span>Add Gallery</span></a>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item <?php if($pagename == "manageimages"){echo "active";} ?>">
        <a class="nav-link" href="<?php echo $base; ?>/admin/manageimages">
          <i class="fas fa-images"></i>
          <span>Manage Images</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item d-none <?php if($pagename == "managelevels"){echo "active";} ?>">
        <a class="nav-link" href="<?php echo $base; ?>/admin/managelevels">
          <i class="fas fa-gamepad"></i>
          <span>Level Game</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item <?php if($pagename == "rowgame"){echo "active";} ?>">
        <a class="nav-link" href="<?php echo $base; ?>/admin/rowgame">
          <i class="fas fa-dice"></i>
          <span>Row Game Settings</span></a>
      </li>
      <li class="nav-item <?php if($pagename == "rowgame"){echo "active";} ?>">
        <a class="nav-link" href="<?php echo $base; ?>/admin/prizes">
          <i class="fas fa-cog"></i>
          <span>Prizes Settings</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item d-none <?php if($pagename == "prizes"){echo "active";} ?>">
        <a class="nav-link" href="<?php echo $base; ?>/admin/prizes">
          <i class="fas fa-gift"></i>
          <span>Prizes</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        API Settings
      </div>

      <!-- Nav Item - Tables -->
      <li class="nav-item <?php if($pagename == "apisettings"){echo "active";} ?>">
        <a class="nav-link" href="<?php echo $base; ?>/admin/apisettings">
          <i class="fas fa-network-wired"></i>
          <span>Payment Gateway</span></a>
      </li>


      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <li class="nav-item <?php if($pagename == "sitesettings"){echo "active";} ?>">
        <a class="nav-link" href="<?php echo $base; ?>/admin/sitesettings">
          <i class="fas fa-network-wired"></i>
          <span>Site Settings</span></a>
      </li>

      <!-- Heading -->
      <div class="sidebar-heading">
        Admin Settings
      </div>
      <!-- Nav Item - Tables -->
      <li class="nav-item <?php if($pagename == "new_admin"){echo "active";} ?>">
        <a class="nav-link" href="<?php echo $base; ?>/admin/newadmin">
          <i class="fas fa-user-shield"></i>
          <span>Create Admin</span></a>
      </li>
      <li class="nav-item <?php if($pagename == "manage_admins"){echo "active";} ?>">
        <a class="nav-link" href="<?php echo $base; ?>/admin/manageadmins">
          <i class="fas fa-user-lock"></i>
          <span>Manage Admins</span></a>
      </li>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->