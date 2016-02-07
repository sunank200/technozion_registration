<div class="row">
<?php //echo count($transactions) ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="row" id="name">
			<center>
				<h2>Online Transaction Details of Participants</h2>
			</center>
			<hr>
		</div>
		<?php 
		if($this->session->flashdata('success') == TRUE) 
			echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>'.$this->session->flashdata('success').'</div>';

		if($this->session->flashdata('warning') == TRUE) 
			echo '<div class="alert alert-warning"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>'.$this->session->flashdata('warning').'</div>';

		if($this->session->flashdata('info') == TRUE)
			echo '<div class="alert alert-info"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>'.$this->session->flashdata('info').'</div>';

		if($this->session->flashdata('danger') == TRUE)
			echo '<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>'.$this->session->flashdata('danger').'</div>';


		if(validation_errors() == TRUE)
			echo '<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>'.validation_errors().'</div>';

		if(isset($status))
		{
			if($status === '1')
				echo '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a><h2>Technozion ID: '.$userid.'</h2>Please collet the money.</div>';
			else
				echo '<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>'.$message.'</div>';
		}
		?>

		<div class="row">
			<div class="col-lg-6">
				<form action="<?php echo base_url('onspot/verification/find') ?>"  class="form-horizontal" method="POST" role="form">
					<div class="input-group">
						<input type="text" required="required" name="userid" class="form-control" placeholder="Enter Technozion Id">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-default" type="button">Search</button>
						</span>
					</div><!-- /input-group -->
				</form>
			</div><!-- /.col-lg-6 -->
			<div class="col-lg-6">
				<!--<form action=""  class="form-horizontal" method="POST" role="form">
					<div class="input-group">
						<input type="email" required="required" name="email" class="form-control" placeholder="Enter Registered Email Id">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-default" type="button">Search</button>
						</span>
					</div><!-- /input-group
				</form>-->
			</div><!-- /.col-lg-6 -->
		</div><!-- /.row -->
	</div>
</div>
<br>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php if(isset($user))if($user === FALSE): ?>
			<div class="alert alert-danger">User profile details not available. Contact Web Team immediately</div>

		<?php 
		unset($user); unset($wteam); unset($transactions);
		endif;
		?>
		<div class="row">
			<?php if(isset($user)): ?>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Profile</h3>
						</div>
						<div class="panel-body">
							<?php //echo print_r($user) ?>
							<table class="table table-hover">
								<tbody>
									<tr>
										<td>Technozion ID</td>
										<th><?php echo $user->userid; $userid = $user->userid; ?></th>
									</tr>
									<tr>
										<td>Name</td>
										<td><?php echo $user->name ?></td>
									</tr>
									<tr>
										<td>Email</td>
										<td><?php echo $user->email ?></td>
									</tr>
									<tr>
										<td>Phone</td>
										<td><?php echo $user->phone ?></td>
									</tr>
									<tr>
										<td>College Id</td>
										<td>	<?php echo $user->collegeid ?></td>
									</tr>
									<tr>
										<td>College</td>
										<td><?php echo $user->college ?></td>
									</tr>
									<tr>
										<td>City</td>
										<td><?php echo $user->city ?></td>
									</tr>
									<tr>
										<td>State</td>
										<td><?php echo $user->state ?></td>
									</tr>
									<tr>
										<td>Account created on</td>
										<td><?php echo $user->creation ?></td>
									</tr>
									<!-- <tr>
										<td>Registered by</td>
										<td><?php echo $user->registered_by ?></td>
									</tr> 
									<tr>
										<td>Registration type</td>
										<td><?php echo ($user->onspot === '1' ? "On Spot" : "Online") ?></td>
									</tr>-->
								</tbody>
							</table>
						</div>

					</div>
				</div>
			<?php endif; ?>
			<?php if(isset($user)): ?>
				<!--<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Hospitality and Logistics <span class="pull-right">Online Status</span></h3>
						</div>
						<div class="panel-body">

							<form action="<?php echo base_url('onspot/editor/verify') ?>" class="form-horizontal" method="POST" role="form">
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
										<div class="form-group">
											<label for="inputreceipt" class="control-label col-md-5">Receipt ID</label>
											<div class="col-md-7">
												<input type="text" autocomplete="off" class="form-control" required name="receipt" id="inputreceipt">
											</div>
										</div>
										<div class="form-group">
											<label for="inputroomno" class="control-label col-md-5">Room Alloted</label>
											<div class="col-md-7">
												<input type="text" class="form-control" name="roomno" id="inputroomno" required>
												<input type="hidden" class="form-control" name="userid" id="inputuserid" value="<?php echo $user->userid; ?>">
												<span class="help-block">Type default value is 0 if room not alloted</span>
											</div>
										</div>
										<div class="form-group">
											<label for="inputgoodies" class="control-label col-md-5">Goodies</label>
											<div class="col-md-7">
												<input type="checkbox" name="goodies" id="inputgoodies">
											</div>
										</div>
										<div class="form-group">
											<label for="inputextram_amount" class="control-label col-md-5">extra_amount</label>
											<div class="col-md-7">
												<input type="number" min="0" class="form-control" name="extra_amount" id="inputextram_amount" required>
												<span class="help-block">type default value 0 if no extra  amount paid</span>
											</div>
										</div>
										<div class="form-group">
											<label for="inputRemark" class="control-label col-md-5">Remark</label>
											<div class="col-md-7">
												<input type="text" name="remark" class="form-control" id="inputRemark" required>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-offset-2 col-md-10">
												<!-- <br> -->
												<!-- <center>
													<input required="required" type="checkbox" class="" name="verify" id="inputverify"> I declare that all the information mention here is correct
												</center>
											</div> -->
											<!-- <label for="inputverify" class="control-label col-md-8 pull-left"> -->

											<!-- </label> -->

										<!-- </div>
									</div>-->
									<!-- <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
										<table class="table table-hover">
											<tbody>
												<tr>
													<td>Registration Status</td>
													<td>
													<?php echo ($user->registration === '1') ? "paid" : "not paid"; ?>
													</td>
													<td>
														<input type="checkbox" name="registration" id="inputregistration" class="amt" <?php echo ($user->registration === '1') ? "checked" : ""; ?>>
														<input type="hidden" class="form-control" required name="cregistration" value="<?php echo $user->registration; ?>">

													</td>
												</tr>
												<tr>
													<td>Hospitality Status</td>
													<td><?php echo ($user->hospitality === '1') ? "paid" : "not paid"; ?></td>
													<td>
														<input type="checkbox" name="hospitality" id="inputhospitality" class="amt" <?php echo ($user->hospitality === '1') ? "checked" : ""; ?>>
														<input type="hidden" class="form-control" required name="chospitality" value="<?php echo $user->hospitality ?>" >
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<button type="submit" class="btn btn-lg btn-primary col-md-offset-4">Confirm and Submit</button>

								</div>
							</form>
						</div>
					</div>
				</div>--> 
			<?php endif; ?>
			<?php if(isset($wteams)): foreach ($wteams as $index => $wteam): ?>
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Workshop</h3>
						</div>
						<div class="panel-body">
							<?php //echo print_r($wteam) ?>
							<table class="table table-hover">
								<tbody>
									<tr>
										<td>Workshop ID</td>
										<td><?php echo $index ?></td>
									</tr>
									<tr>
										<td>Workshop Name</td>
										<td><?php echo $wteam['workshopName'] ?></td>
									</tr>
									<tr>
										<td>Status</td>
										<td><?php echo $wteam['status']; ?></td>
									</tr>
									<tr>
										<td>Team Members</td>
										<td>
											<ol>
												<?php 
												foreach ($wteam['users'] as $key => $user) {
													echo '<li>';
													echo $user;
													echo '</li>';											}
													?>
												</ol>
											</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>
				<?php endforeach; endif;?>
			</div>
			<div class="row">
				<?php $individual_hospitality_cost=0;
				      $individual_registration_cost=0;
				if(isset($transactions))
				foreach($transactions as $index => $transaction):  
				$registrationids = json_decode($transaction->registrationids);
				$hospitalityids = json_decode($transaction->hospitalityids);
					$registration_cost = count($registrationids)*REGISTRATION_COST;
					$hospitality_cost = count($hospitalityids)*HOSPITALITY_COST;
					$tshirt_cost = $transaction->tshirts*TSHIRT_COST;
					$workshop_cost = $transaction->cost;
			
				if($transaction->userid === $userid)
				{
					foreach($hospitalityids as $id)
					if($id === $userid)
					{
					$individual_hospitality_cost = HOSPITALITY_COST;
					//$registration_cost = REGISTRATION_COST;
					}
					foreach($registrationids as $id)
					if($id === $userid)
					{
					//$hospitality_cost = HOSPITALITY_COST;
					$individual_registration_cost = REGISTRATION_COST;
					}
					$individual_should_pay =  ceil(($individual_hospitality_cost + $individual_registration_cost)*100/97);
				}
				$should_pay = ceil(($hospitality_cost + $registration_cost + $tshirt_cost + $workshop_cost)*100/97);
				$difference_amt = $should_pay - $transaction->amount;
				
				?>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">
								<?php 
								switch($transaction->status)
								{
									case "0": echo "<span class='label label-danger'>No transaction</span>";break;
									case "-1": echo "<span class='label label-danger'>Card Authentication Failure</span>";break;
									case "-2": echo "<span class='label label-danger'>Failed</span>";break;
									case "5": echo "<span class='label label-success'>Success</span>";break;
									default: echo "<span class='label label-danger'>invalid Status</span>";break;
								}
								?>
							</h3>
						</div>
						<div class="panel-body">
							<?php //echo print_r($transaction) ?>
							<table class="table table-hover">
								<tbody>
									<tr>
										<td>Technozion ID</td>
										<td>
											<?php echo $transaction->userid;
											if($transaction->userid === $userid)
												echo ' <span class="text-info">(This user)</span>';
											else
												echo ' <span class="text-danger">(Not this user)</span>';
											?>
										</td>
									</tr>
									<tr>
										<td>Transaction ID</td>
										<td><?php echo $transaction->transactionid ?></td>
									</tr>
									<tr>
										<td>Status</td>
										<td>
											<?php 
											switch($transaction->status)
											{
												case "0": echo "No transaction";break;
												case "-1": echo "Card Authentication Failure";break;
												case "-2": echo "Failed";break;
												case "5": echo "Success";break;
												default: echo "invalid Status";break;
											}
											?>
										</td>
									</tr>
									<tr>
										<td>Paid on</td>
										<td><?php echo $transaction->timeinitial ?></td>
									</tr>
									<tr>
										<td>Amount Paid</td>
										<td>&#8377; <?php echo $transaction->amount ?></td>
									</tr>
									<?php if($transaction->status === "5"): ?>
										<tr>
											<td>Total Payment should be</td>
											<td>
												&#8377; <?php echo $should_pay ?>
												<span class="help-block">Payment gateway charges 3<?php //echo (100/97-1)*100; ?>% included</span>
											</td>
										</tr>
										<tr class="text-danger">
											<td>Difference Amount</td>
											<td>&#8377; <?php echo $difference_amt ?></td>
										</tr>

									<tr>
										<td colspan="2">
										<?php 
										 if($transaction->userid !== $userid):?>
										<p class="lead text-success" style="text-align:justify">This user need not to pay the above money. The person who has done the transaction should pay the amount</p>
										<?php else: ?>
										<lead class="text-danger">This user must pay the difference amount if not Rs 0.</lead>
											<?php endif; ?>	
										</td>
									</tr>
									<?php endif; ?>
									<tr>
										<td>Workshop Name</td>
										<td><?php echo $transaction->wname ?> <br>
											(&#8377; <?php echo $workshop_cost ?>)</td>
										</tr>
										<tr>
											<td>Workshop Team ID</td>
											<td><?php echo $transaction->teamid ?></td>
										</tr>
										<tr>
											<td>Registration IDs</td>
											<td>
												<ol>
													<?php 

													foreach ($registrationids as $key => $id) {
														echo '<li>';
														echo $id;
														if($id === $userid) echo ' <span class="text-info">(This user)</span>';
													}
													?>

												</ol>
												(&#8377; <?php echo $registration_cost  ?>)
											</td>
										</tr>
										<tr>
											<td>Hospitality IDs</td>
											<td>
												<ol>
													<?php 
													foreach ($hospitalityids as $key => $id) {
														echo '<li>';
														echo $id;
														if($id === $userid) echo ' <span class="text-info">(This user)</span>';
														echo '</li>';
													}
													?>
												</ol>
												(&#8377; <?php echo $hospitality_cost ?>)
											</td>
										</tr>
										<tr>
											<td>Tshirts</td>
											<td>
												<?php echo $transaction->tshirts ?> <br>
												(&#8377; <?php echo $tshirt_cost; ?>)
											</td>
										</tr>
										<tr>
											<td>Tshirt Sizes</td>
											<td>
												<ol>
													<?php if($transaction->tshirtssizes  != "'[]'"){
													$tshirtssizes = ($transaction->tshirtssizes);

													foreach ($tshirtssizes as $key => $size) {
														echo '<li>';
														echo $size;
														echo '</li>';
													}
													}else{
                                                        echo "no t-shirts";
                                                    }
                                                    ?>
												</ol>
											</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>
				<?php endforeach; ?>

			</div>

		</div>
	</div>
</div>
</div>