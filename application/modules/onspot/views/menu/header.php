<!DOCTYPE html>
<html>
<head>
    <title>TMS</title>
    <link rel="stylesheet" href="<?php echo asset_url() ?>css/bootstrap.min.css">
    <script src="<?php echo asset_url() ?>js/jquery.min.js"></script>
    <script src="<?php echo asset_url() ?>js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-inverse" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">TMS</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
            <li <?php if($current_page ==="registrationa") echo 'class="active"'; ?>><a href="<?php // echo base_url('onspot/counter1') ?>">Registration (A)</a></li>
                 <li <?php if($current_page ==="registration") echo 'class="active"'; ?>><a href="<?php echo base_url('onspot/counter2') ?>">Registration and Hospitality (B)</a></li>
                  <li <?php if($current_page ==="workshop") echo 'class="active"'; ?> ><a href="<?php echo base_url('onspot/workshops') ?>">Workshops (C)</a></li>
                  <li <?php if($current_page ==="transaction") echo 'class="active"'; ?>><a href="<?php echo base_url('onspot/verification') ?>">Profile &amp;Transactions</a></li>
                <!--                <li><a href="#">Link</a></li> -->
            </ul>
<!--            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form> -->
            <ul class="nav navbar-nav navbar-right">
                <!-- <li><a href="#">Link</a></li> -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Setting <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url('auth/change_password'); ?>">Change password</a></li>
                        <li><a href="<?php echo base_url('auth/logout'); ?>">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
    <div class="container">