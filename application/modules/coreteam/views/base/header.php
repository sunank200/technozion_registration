<!DOCTYPE html>
<html>
<head>
	<title>Core Team | Statistics</title>
	<link rel="stylesheet" href="<?php echo asset_url() ?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo asset_url()."css/style.css"; ?>">
	<link rel="stylesheet" href="<?php echo asset_url()."css/jquery.dataTables.css"; ?>">
	<link rel="stylesheet" href="<?php echo asset_url()."css/events_style.css"; ?>">
	<script src="<?php echo asset_url() ?>js/jquery.min.js"></script>
	<script src="<?php echo asset_url() ?>js/bootstrap.min.js"></script>
	<script src="<?php echo asset_url() ?>js/jquery.dataTables.js"></script>
	<script src="<?php echo asset_url() ?>js/table.js"></script>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-43671312-1', 'technozion.in');
		ga('send', 'pageview');

	</script>

	<style>
		.row{
			margin-left: 0;
			margin-right: 0;
		}
	</style>
</head>
<body>
<h1>hello i m here </h1>
	<nav class="navbar navbar-inverse" role="navigation">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">TMS| Core Team Admin Portal</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li class=""><a href="<?php echo base_url('auth') ?>">Managers</a></li>
				<li class="active"><a href="<?php echo base_url('coreteam/statistics') ?>">Statistics</a></li>
				<!-- 				<li><a href="#">Link</a></li> -->
			</ul>
<!-- 			<form class="navbar-form navbar-left" role="search">
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
		<nav class="navbar navbar-default" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav">
				<li class='<?php if (isset($current_page) && $current_page === "workshops") echo " active" ?>' ><a href="<?php echo base_url('coreteam/statistics/workshops'); ?>">
						Workshops
					</a></li>
					<li class='<?php if (isset($current_page) && $current_page === "events") echo " active" ?>'><a href="<?php echo base_url('coreteam/statistics/events'); ?>">
						Events
					</a></li>
					<li class='<?php if (isset($current_page) && $current_page === "registrations") echo " active" ?>'><a href="<?php echo base_url('coreteam/statistics/registrations'); ?>">
						Registrations
					</a></li>
					<li class='<?php if (isset($current_page) && $current_page === "users") echo " active" ?>'><a href="<?php echo base_url('coreteam/statistics/users'); ?>">
						Users
					</a></li>
					<li class='<?php if (isset($current_page) && $current_page === "wlist") echo " active" ?>'><a href="<?php echo base_url('coreteam/statistics/wusers'); ?>">
						Workshop Users
					</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>
	</div>
	<div class="container-fluid">
		
		<div class="row">
			<div class="col-md-12">