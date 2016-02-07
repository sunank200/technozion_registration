<!DOCTYPE html>
<html>
<head>
   <title>
    <?php if(!empty($title)) echo $title.' | TECHNOZION '.date('y').', NIT Warangal'; else echo 'TECHNOZION '.date('y').', NIT  Warangal | Online Registrations'; ?>
</title>
<!-- SEO -->
<meta name="description" content="NIT Warangal Presents Technozion 2014. The annual Technical extravaganza. Events and workshop registrations are open.">
<!-- Facebook open graph -->
<meta property="og:title" content="Technozion 2014"/>
<meta property="og:type" content="Fest Website, non profit organisation"/>
<meta property="og:image" content="http://www.technozion.org/tz14/assets/images/favicon.png"/>
<meta property="og:url" content="http://www.technozion.org"/>
<meta property="og:description" content="Technozion is the annual celebration of engineering, science and technology organised wholly and solely by the students of NIT Warangal. Thus, one can not go wrong with the level of enthusiasm shown by the young engineering population, and the resulting magnificent ideas from it."/>
<!-- Twitter cards -->
<meta name="twitter:card" content="Technozion is the annual celebration of engineering, science and technology organised wholly and solely by the students of NIT Warangal. Thus, one can not go wrong with the level of enthusiasm shown by the young engineering population, and the resulting magnificent ideas from it." />
<meta name="twitter:site" content="@Technozion14" />
<meta name="twitter:title" content="Technozion , NITWarangal" />
<meta name="twitter:description" content="National Level Technical Fest of NIT-Warangal." />
<meta name="twitter:image" content="http://www.technozion.org/tz14/assets/images/header.png" />
<meta name="twitter:url" content="https://register.technozion.org/" />
<!-- Favicon -->
<link rel="shortcut icon" type="image/png" href="http://www.technozion.org/tz14/assets/images/favicon.png"/>

<link rel="stylesheet" href="<?php echo asset_url()."css/flatly.bootstrap.min.css"; ?>">
<link rel="stylesheet" href="<?php echo asset_url()."css/style.css"; ?>">
<link rel="stylesheet" href="<?php echo asset_url()."css/events_style.css"; ?>">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43671312-1', 'auto');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');

</script>

</head>
<body>
    <div id="layout">
        <div id="menu-wrapper" class="hidden-print">
            <img src="<?php echo get_tz_logo(); ?>" width="100%" alt="">
            <ul id="menu" class="nav nav-pills nav-stacked">
                <li class="<?php echo ($current_page === "profile") ? 'active' : ''; ?>">
                    <a href="<?php echo base_url("profile"); ?>">My TZ profile</a>
                </li>
                <!-- <li class="<?php echo ($current_page === "notifications") ? 'active' : ''; ?>">
                    <a href="<?php echo base_url("notifications"); ?>">NOTIFICATIONS</a>
                </li> -->
                <!--
                <li class="disabled">
                    <a href="<?php echo base_url("registration"); ?>">REGISTRATION</a>
                </li> -->
                <li class="separator"></li>
                <?php if($userDetails->registration==0):?>
                    <li class="<?php echo ($current_page === "registration") ? 'active' : ''; ?>">
                        <a href="<?php echo base_url("registration"); ?>">Technozion Registration</a>
                    </li>
                <?php endif;?>
                <li class="<?php echo ($current_page === "events") ? 'active' : ''; ?>">
                    <a href="<?php echo base_url("events"); ?>">Events</a>
                </li>
                <li class="<?php echo ($current_page === "workshops") ? 'active' : ''; ?>" style='<?php if($userDetails->registration==1 && $userDetails->workshop==0){echo $show;}else echo $none;?>'>
                    <a href="<?php echo base_url("workshops"); ?>">Workshops <span class="label label-danger">new</span></a>
                </li>                
                <?php if($userDetails->registration==1 && $userDetails->hospitality==0):?>
                    <li class="<?php echo ($current_page === "hospitality") ? 'active' : ''; ?>" style='<?php if($userDetails->registration==1 && $userDetails->hospitality==0){echo $show;}else echo $none;?>'>
                        <a href="<?php echo base_url("hospitality"); ?>">Hospitality Regisration</a>
                    </li>
                <?php endif;?>
               <!--  <li class="<?php echo ($current_page === "slip") ? 'active' : ''; ?>">
                    <a href="<?php echo base_url("slip"); ?>">REGISTRATION SLIP</a>
                </li> -->
                <li class="<?php echo ($current_page === "tshirt") ? 'active' : ''; ?>">
                    <a href="<?php echo base_url("tshirt"); ?>">TZ T-SHIRTS <span class="label label-danger">new</span></a>
                </li> 
               <!--  <li class="<?php echo ($current_page === "query") ? 'active' : ''; ?>">
                    <a href="<?php echo base_url("query"); ?>">FAQs</a>
                </li>
            -->
            <li class="separator"></li>
            <li class="<?php echo ($current_page === "help") ? 'active' : ''; ?>">
                <a href="<?php echo base_url("help"); ?>">Help & Support</a>
            </li>
            <li class="<?php echo ($current_page === "logout") ? 'active' : ''; ?>">
                <a href="<?php echo base_url("logout"); ?>">Logout</a>
            </li>
        </ul>
    </div>
    <div id="main-wrapper">
     <!--<div id="img-header"></div>-->
     <div class="container" id="main">
        <div id="header" class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <h2>
                    <?php echo $main_heading; ?>
                </h2>
                <h4>
                    <?php echo $side_heading; ?>
                </h4>
            </div><div class="hidden-xs col-sm-3 col-md-3 col-lg-3 tz-well well tz-link">
              <center>    <a href="<?php echo base_url('slip') ?>" type="button" class="btn-md btn btn-warning">Registration Slip</a></center>
            </div>
            <div class="hidden-xs col-sm-3 col-md-3 col-lg-3 tz-well well tz-link">
              <center>    <a href="<?php echo base_url('tshirt') ?>" type="button" class="btn-md btn btn-warning">Buy TZ T-Shirt</a></center>
            </div>

            <!-- \<div class="col-md-4">
                     <div class="btn-group btn-lg pull-right hidden-print">
                        
                        
                    </div>
                </div> -->
                <!-- <div class="col-md-3"></div> -->
            </div>
            <div id="content" class="row">