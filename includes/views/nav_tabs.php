<?php
$tab = $_GET['page'];
?>

<link rel="stylesheet" href="<?php echo constant('SAMLTUD_AUTH_URL') . '/includes/samltud.css';?>">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
<div class="wrap">
  <h1>Single Sign-On</h1>
  <h2 class="nav-tab-wrapper">
    <a href="?page=samltud_general.php" class="nav-tab<?php if($tab == 'samltud_general.php'){echo ' nav-tab-active';}?>">General <span class="badge badge-important" id="samltud_errors"><?php if($status->num_errors != 0) echo $status->num_errors; ?></span></a>
    <a href="?page=samltud_idp.php" class="nav-tab<?php if($tab == 'samltud_idp.php'){echo ' nav-tab-active';}?>">Identity Provider</a>
    <a href="?page=samltud_sp.php" class="nav-tab<?php if($tab == 'samltud_sp.php'){echo ' nav-tab-active';}?>">Service Provider</a>
  </h2>
</div>
