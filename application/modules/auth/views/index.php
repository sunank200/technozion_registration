<!DOCTYPE html>
<html>
<head>
	<title><?php echo "Core Team | Managers" ?></title>
	<link rel="stylesheet" href="<?php echo asset_url() ?>css/bootstrap.min.css">
	<script src="<?php echo asset_url() ?>js/jquery.min.js"></script>
	<script src="<?php echo asset_url() ?>js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="<?php echo asset_url()."css/jquery.dataTables.css"; ?>">
	<script src="<?php echo asset_url() ?>js/jquery.dataTables.js"></script>
	<script src="<?php echo asset_url() ?>js/table.js"></script>
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
			<a class="navbar-brand" href="#">Technozion 14 | Core Team Admin Portal</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li class="active"><a href="<?php echo base_url('auth') ?>">Managers</a></li>
				<li class=""><a href="<?php echo base_url('coreteam') ?>">Statistics</a></li>
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
	<h1><?php echo lang('index_heading');?></h1>
	<p><?php echo lang('index_subheading');?></p>
	<br>	
	<p><?php echo anchor('auth/create_user', lang('index_create_user_link'))?> | <?php echo anchor('auth/create_group', lang('index_create_group_link'))?></p>
	<div id="infoMessage"><?php echo $message;?></div>

	<table cellpadding=0 cellspacing=10 class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th>User ID</th>
			<th><?php echo lang('index_fname_th');?></th>
			<th><?php echo lang('index_lname_th');?></th>
			<th><?php echo lang('index_email_th');?></th>
			<th><?php echo lang('index_groups_th');?></th>
			<th><?php echo lang('index_status_th');?></th>
			<th><?php echo lang('index_action_th');?></th>
		</tr></thead>
		<tbody>
		<?php foreach ($users as $user):?>
			<tr>
				<td><?php echo $user->id;?></td>
				<td><?php echo $user->first_name;?></td>
				<td><?php echo $user->last_name;?></td>
				<td><?php echo $user->email;?></td>
				<td>
					<?php foreach ($user->groups as $group):?>
						<?php echo anchor("auth/edit_group/".$group->id, $group->name) ;?><br />
					<?php endforeach?>
				</td>
				<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
				<td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>
			</tr>
		<?php endforeach;?></tbody>
	</table>
</body>
</html>
