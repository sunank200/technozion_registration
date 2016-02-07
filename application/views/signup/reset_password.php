<!DOCTYPE html>
<html>
<head>
	<title>Technozion 13</title>
	<link rel="stylesheet" href="<?php echo asset_url()."css/flatly.bootstrap.min.css"; ?>">
	<link rel="stylesheet" href="<?php echo asset_url()."css/signup.css"; ?>">
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-43671312-1', 'technozion.in');
		ga('send', 'pageview');

	</script>
</head>
<body>
	<div class="container">
		<div class="row" id="header">

		</div>
		<div class="row" id="main">
			<div class="col-md-6">
				<div class="row" id="logo">
					<center><img src="<?php echo get_tz_logo('side-menu'); ?>" class="img-responsive img-rounded" height="450" width="450" alt="Technozion Logo"></center>
				</div>
				<div class="row" id="name">
					<h2>Technozion - 2013</h2>
					<h4>NIT Warangal's Technical Festival</h4>
				</div>

			</div>
			<div class="col-xs-12 col-sm-12  col-md-6 col-lg-6" id="signinarea">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php 
						if($this->session->flashdata('success') == TRUE) 
							echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>'.$this->session->flashdata('success').'</div>';

						if($this->session->flashdata('warning') == TRUE) 
							echo '<div class="alert alert-warning"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>'.$this->session->flashdata('warning').'</div>';

						if($this->session->flashdata('info') == TRUE)
							echo '<div class="alert alert-info"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>'.$this->session->flashdata('info').'</div>';

						if($this->session->flashdata('danger') == TRUE)
							echo '<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>'.$this->session->flashdata('danger').'</div>';
						?>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<form action="<?php echo base_url('forgot_password/newpassword') ?>" method="POST" role="form">
					<legend>Reset Password</legend>
				<div class="form-group">

						<label for="">New Password</label>
						<input type="password" name="newpassword" id="inputNewpassword" class="form-control" required="required" >
						<br>
						<label for="">Confirm New Password</label>
						<input type="password" name="confirmnewpassword" id="inputConfirmnewpassword" class="form-control" required="required" >
						<input type="hidden" name="userid" id="inputUserid" class="form-control" value="<?php echo $user->userid; ?>">
						<input type="hidden" name="code" id="inputCode" class="form-control" value="<?php echo $user->forgot_password; ?>">
						<input type="hidden" name="email" id="inputEmail" class="form-control" value="<?php echo $user->email; ?>">
					</div>
					<button type="submit" class="btn btn-primary">Reset Password</button>
				</form>
			</div>
		</div>
		<div class="row" id="footer">
			<p class="pull-left help-block">page rendered in <strong>{elapsed_time}</strong> seconds</p>
			<p class="pull-right help-block">&copy; 2013, Web Team Technozion</p>
		</div>
	</div>
	<script src="<?php echo asset_url()."js/jquery.min.js"; ?>"></script>
	<script src="<?php echo asset_url()."js/bootstrap.min.js"; ?>"></script>
	<script src="<?php echo asset_url()."js/signup.js"; ?>"></script>
</body>
</html>