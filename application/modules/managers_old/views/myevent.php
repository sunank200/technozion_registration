<!DOCTYPE html>
<html>
<head>
	<title><?php echo $eventids[0]['ename']; ?></title>
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
			<a class="navbar-brand" href="#">Technozion 14| <?php echo $this->session->userdata('username') ?></a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li class="active"><a href="<?php echo base_url('managers') ?>">Event Managers</a></li>
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
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="alert alert-warning">
					All are requested to change password immediately. No account should have default password.
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Insructions</h3>
					</div>
					<div class="panel-body">
						<ul>
							<li>For any technical assistance, please contact ECC core team</li>
							<li> use ctrl + F to search :p</li>
							<li>Change password periodically</li>
						</ul>
					</div>
				</div>

				<?php if(validation_errors() === TRUE ) :?>
					<div class="alert alert-danger"><?php echo validation_errors(); ?></div>
				<?php endif; ?>

			</div>
		</div>
		<div class="row">

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs">
					<li class="active"><a href="#team" data-toggle="tab">List of Teams <span class="badge"><?php echo count($teams) ?></span></a></li>
					<li ><a href="#participant" data-toggle="tab">List of Participants <span class="badge"></span></a></li>
				</ul>
				<!-- Tab panes -->
				<div class="tab-content">

					<div class="tab-pane active" id="team">
						<table class="table table-hover table-bordered" id="teamtable">
							<thead>
								<tr>
									<th>S.No.</th>
									<th>Team ID</th>
									<th>Team Member</th>
									<!-- <th>Status</th> -->
									<th>Team Registered on</th>
									<th>Team Status</th>
								</tr>
							</thead>
							<tbody>
								<?php $count = 1; ?>
								<?php foreach($teams as $teamid => $teamDetails): ?>
									<tr>
										<td><?php echo $count++; ?></td>
										<td><?php echo $teamDetails['teamid']; ?></td>

										<td>
											<ol>
												<?php foreach($teamDetails['users'] as $index => $user): ?>
													<li>
														<address>
															<strong><?php echo $user['name']; ?></strong> <span class="label	label-<?php echo ($user['registration'] === '1') ? 'success' : 'danger' ?>">	<?php echo ($user['registration'] === '1') ? "confirm" : "confirm/proceed to payment" ?></span> <br>
															<a href="mailto:<?php echo $user['email']; ?>"> <?php echo $user['email']; ?></a><br>
															<?php echo $user['phone'] ?><br>
															<?php echo $user['college'] ?><br>
															<?php echo $user['city'].', '.$user['state'] ?>

														</address>
													</li>
												<?php endforeach; ?>
											</ol>
										</td>
										<!-- <td><?php echo $teamDetails['status']; ?></td> -->
										<td><?php echo $teamDetails['timestamp'] ?></td>
										<td>
											<form name="_<?php echo $teamDetails['teamid']; ?>">
												<div class="form-group">
													<!-- <select data-previous="<?php echo $teamDetails['status_code'];?>" name="changestatus" data-teamid="<?php echo $teamDetails['teamid']; ?>" class="form-control">

														<?php foreach($status as $index => $state):?>
															<option value="<?php echo $state->status_code ?>"><?php echo $state->status_name; ?></option>
														<?php endforeach; ?>
														<script>document._<?php echo $teamDetails['teamid']; ?>.changestatus.value = <?php echo $teamDetails['status_code']; ?></script>
													</select> -->

													<span class="label	label-<?php echo ($teamDetails['status_code'] === '1') ? "success" : "danger" ?>">	<?php echo ($teamDetails['status_code'] === '1') ? "confirm" : "confirm/proceed to payment" ?></span>
												</div>
											</form>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<div class="tab-pane" id="participant">
						<!-- <legend>Participant List </legend> -->
						<table class="table table-hover table-bordered table-responsive" id="participant_table">
							<?php $count = 1; ?>
							<th>#</th>
							<th>Team No.</th>
							<th>Name</th>
							<th>email</th>
							<th>phone</th>
							<th>college</th>
							<th>city</th>
							<th>state</th>
							<th>registered</th>
							<?php foreach($teams as $teamid => $teamDetails): ?>
								<?php foreach($teamDetails['users'] as $index => $user): ?>
									<tr>

										<td><?php echo $count++; ?></td>
										<td><?php echo $teamDetails['teamid']; ?></td>
										<td><?php echo $user['name']; ?></td>
										<td><a href="mailto:<?php echo $user['email']; ?>"> <?php echo $user['email']; ?></a></td>
										<td><?php echo $user['phone'] ?></td>
										<td><?php echo $user['college'] ?></td>
										<td><?php echo $user['city'] ?></td>
										<td><?php echo $user['state'] ?></td>
										<td><span class="label	label-<?php echo ($user['registration'] === '1') ? 'success' : 'danger' ?>">	<?php echo ($user['registration'] === '1') ? "yes" : "no" ?></span></td>
									</tr>
								<?php endforeach; ?>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>


</body>
<script src="<?=asset_url()?>js/jquery.dataTables.js"></script>
<script>
$('#teamtable').dataTable();
$('#participant_table').dataTable();

	// $('select').on('change', function () {
	// 	newstatus = this.value;
	// 	prestatus = $(this).data('previous');
	// 	teamid = $(this).data('teamid');
	// 	var test = $(this);
	// 	if(newstatus == prestatus)
	// 		alert('same status as previous!! no change in status')
	// 	$.ajax({
	// 		url: '<?php echo base_url("managers/changestatus/") ?>'+ '/' +teamid,
	// 		type: 'POST',
	// 		data: {'changestatus': newstatus},
	// 		beforeSend:function(){

	// 		},
	// 		success: function (data) {
	// 			if(data == '1')
	// 			{
	// 				test.data('previous' ,newstatus);
	// 				alert('status successfully changed');
	// 			}
	// 			else
	// 			{
	// 				alert('unable to change status')
	// 			}
	// 		}
	// 	});
	// });
</script>
</html>