<div class="row"  id="slip">
<?php if(isset($error)): echo "<div class='alert alert-danger'>".$error."</div>"; else: ?>
	<div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
		<div class="row">
			<button type="button"  onclick="window.print()" class="btn btn-success hidden-print pull-right">Print Registration Slip</button>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<table class="table table-hover">
					<tbody>
						<tr>
							<td style="width:150px"><dt>Technozion Id:</dt></td>
							<td><?php echo $user->userid; ?></td>
						</tr>
						<tr>
							<td><dt>Name</dt></td>
							<td><?php echo $user->name; ?></td>
						</tr>
						<tr>
							<td><dt>Email ID</dt></td>
							<td><?php echo $user->email; ?></td>
						</tr>
						<tr>
							<td><dt>Contact No.</dt></td>
							<td><?php echo $user->phone; ?></td>
						</tr>
						<tr>
							<td><dt>College</dt></td>
							<td><?php echo $user->college; ?></td>
						</tr>
						<tr>
							<td><dt>College Id:</dt></td>
							<td><?php echo $user->collegeid; ?></td>
						</tr>
						<tr>
							<td><dt>State:</dt></td>
							<td><?php echo $user->state; ?></td>
						</tr>
						<tr>
							<td><dt>Alloted Room No:</dt></td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<table class="table table-hover">
					<tbody>
						<tr>
							<td style="width:170px"><dt>Registration status: </dt></td>
							<td><?php echo ($user->registration === '1' ? "paid" : "Not paid") ?></td>
						</tr>
						<tr>
							<td><dt>Hostpitality Status:</dt></td>
							<td><?php echo ($user->hospitality === '1')? "paid" : "not paid" ?></td>
						</tr>
						
					</tbody>
				</table>

			</div>
		</div>
		<?php if(count($teams) > 0): ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Events</h3>
				</div>
				<div class="panel-body">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>Event</th>
								<th>Status</th>
								<th>TeamID</th>
								<th>Team Members</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (count($teams) > 0) {
								$count = 1;
								foreach($teams as $teamid => $teamDetails) { ?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo $teamDetails["eventName"]; ?></td>
									<td>
										<span class="label label-<?php echo ($teamDetails["status"] != "1" ? "warning" : "success"); ?>">
											<?php echo $teamDetails["status_name"]; ?>
										</span> <br>
										<?php
										if ($teamDetails['status'] == '4') { ?>
										<span class="label label-info">
											<?php echo $teamDetails['count']."/".$teamDetails['total'].' registered'; ?>
										</span>
										<?php  }  ?>
									</td>
									<td><?php echo $teamid; ?></td>
									<td><?php
										$output = "";
										foreach($teamDetails["users"] as $index => $user) {
											$output.=$user.",";
										}
                                    // rtrim($output);
										echo $output;
										?></td>
									</tr>
									<?php
								}
							} else {
								?>
								<tr>
									<td colspan="5">
										<center><i>You haven't registered for any events</i></center>
									</td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div> <!-- event panel clo9se -->
		<?php endif; ?>
		
		<?php if(count($wteams) > 0): ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Workshop</h3>
				</div>
				<div class="panel-body">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>Workshop</th>
								<th>Status</th>
								<th>TeamID</th>
								<th>Team Members</th>
							</tr>
						</thead>
						<tbody>
							<?php
                            if (count($wteams) > 0) {
                                $count = 1;
                                foreach($wteams as $teamid => $teamDetails) { ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $teamDetails["workshopName"]; ?></td>
                                <td>
                                    <span class="label label-<?php echo ($teamDetails["status"] != '5')? "danger" : "success"; ?>">
                                       <?php echo ($teamDetails["status"] != '5')? "WAITING LIST" : "CONFIRM"; ?>
                                    </span>
                                </td>
                                <td><?php echo $teamid; ?></td>
                                <td><?php
                                    $output = "";
                                    foreach($teamDetails["users"] as $index => $user) {
                                        $output.=$user.",";
                                    }
                                    echo $output;
                                    ?></td>
                            </tr>
                        <?php
                                }
                            } else {
                                ?>
                            <tr>
                                <td colspan="5">
                                    <center><i>You haven't registered for any workshops yet.</center>
                                </td>
                            </tr>
                                <?php
                            }
                        ?>
						</tbody>
					</table>
				</div>
			</div> <!-- workshop pannel close -->
		<?php endif; ?>
		NOTE:
		<ul style="text-align:justify">
			<li>Accommodation will be provided on a sharing basis and on first come first serve basis.</li><li>Students who are getting laptops for workshops or any electronic gadgets or have jewellery on their body will themselves be responsible for protecting their belongings.</li>
            <li>Accommodation is provided from 16th evening to 19th evening.</li>
            <li>No accommodation will be provided after 19th Oct.</li>
			<li>Dinner is not provided on 16th and 19th evening.</li>
			<li>You are expected to carry your respective college identity cards or any other photo identity which will be verified at the Accommodation.Blankets won't be provided during your stay.</li>
			<li><strong> You are advised to get your own blanket as the weather is a bit chilly.</strong>
				<li>3 printouts of this form must be kept with you and should be produced whenever asked for.</li>
				<li>Certificates will be provided on the third day, i.e, 19th Oct</li>
					<li>Food coupons for the 3 days will be given to you. Reissue in case of Loss of the coupons is not entertained.</li>
					<li>Your credentials will be cross verified with your college ID at a stall near NITW Main gate. On successful completion, you would be directed towards SAC building for registration and allocation of accommodation.</li>
					<li>Stay in lines in the counters provided at SAC building. Your credentials will be verified with the online database and Technozion ID cards, food coupons will be presented to you.</li>
					<li>You MUST always carry with you the Technozion ID Card.</li>
						<li>Ill behaviour and any case of forgery in this form is highly condemned.</li>
					</ul>
					<h3>Stay Safe. Enjoy !</h3>



				</div>
			</div>
<?php endif; ?>
