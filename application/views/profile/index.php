</script>
<div class="col-md-12 well tz-well">
    <ul>
        <li>Accomodation will be provided from october 16 </li>
        <li>All the transactions have been updated in the portal</li>
        <li>All the transaction related problems will be solved by 16th October morning. For issues email to <a href="mailto:anik@technozion.org">anik@technozion.org</a></li>
        <li>For updating your profile click <a href="<?php echo base_url() . 'update_profile' ?>">here</a></li>
    </ul>
    </div>
<div class="col-md-5">
	<table class="table table-condensed tz-table tz-well">
		<head>
			<tr class="tz-id">
				<th><strong>TZ ID:</strong></th>
				<th><strong> <?php echo $userDetails->userid; ?></strong> </th>
			</tr>
		</head>
	</table>
	<strong>Participant details:</strong>
	<hr class="tz-hr">
	<table class="table table-condensed tz-table tz-well">
		<tbody>
			<tr>
				<td>
					<span class="tz-name tips" title="Name of participant" ><?php echo $userDetails->name; ?></span> <br>
					College Id: <span class="tz-collegeid"><?php echo $userDetails->collegeid; ?></span><br>
					<span class="tz-college"><?php echo $userDetails->college; ?></span> <br>
					<span class="tz-city"><?php echo $userDetails->city; ?></span>, 
					<?php echo $userDetails->state; ?><br>

				</td>
			</tr>
			<tr>
				<td>
					<strong>Ph.</strong> <?php echo $userDetails->phone; ?><br>
					<strong><a href="mailto:<?php echo $userDetails->email; ?>"><?php echo $userDetails->email; ?></a> </strong>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="col-md-12 text-justify well tz-well">
		<p>Certificates issued by Technozion will now be of ISO and UNESCO standards </p>
		<!-- <a>Due to heavy web traffic we have extended the online payment procedure till 26th December.</a><br><br> -->
		<p>**Accommodation will be provided in NIT warangal hostels. Separate accommodation for GIRLS and boys is provided. Other terms and conditions are mention in rules and regulations section.</p>
	</div>
</div>
<div class="col-md-7">
	
	<div class="row"> 
		<?php if($userDetails->registration==0 && $userDetails->hospitality==0):?>
		<div class="col-md-12">
			<a href="registration">
				<div class="tz-well well">
					<span class="tz-title">TECHNOZION registration: 400 INR <span class="label label-danger">unpaid</span></span>
					<hr class="tz-hr">
					<small>One-Time payment - inclusive of all Events, Guest Lectures, Shows &  Exhibits</small>					
				</div>		
			</a>		
		</div>
		<?php else:?>
		<div class="col-md-12">
			<a href="#">
				<div class="tz-well well">
					<span class="tz-title">TECHNOZION registration: 400 INR <span class="label label-success">paid</span></span>
					<hr class="tz-hr">
					<small>Proceed to register for workshop or events</small>
				</div>		
			</a>		
		</div>
		<?php endif;?>
		
		<div class="col-md-12">
			<?php if($userDetails->registration==1 && $userDetails->hospitality==0):?>
			<a href="hospitality">
				<div class="tz-well well">
					<span class="tz-title">HOSPITALITY registration: 600 INR <span class="label label-danger">unpaid</span></span>
					<hr class="tz-hr">
					<small>One-Time Payment - inclusive of Food and Accomodations (stay) **</small>
					<?php elseif ($userDetails->registration==0 && $userDetails->hospitality==0):?>
					<a href="registration">
						<div class="tz-well well">
						<span class="tz-title">HOSPITALITY registration: 600 INR  <span class="label label-danger">unpaid</span></span>
						<hr class="tz-hr">
						<small>Please pay TECHNOZION registration fees to avail HOSPITALITY</small>
					<?php else:?>
					<a href="#">
					<div class="tz-well well">
					<span class="tz-title">HOSPITALITY registration: 600 INR  <span class="label label-success">paid</span></span>
					<hr class="tz-hr">
					<small>Proceed to registration of workshops or events</small>
					<?php endif;?>
				</div>
			</a>
		</div>
		
		
		<div class="col-md-12">
			<a href="workshops">
				<div class="tz-well well">
					<span class="tz-title">Register for WORKSHOPS</span>
					<hr class="tz-hr">
					<small>Payment depends on the selected workshops</small>
				</div>
			</a>
		</div>
		<div class="col-md-12">
			<a href="help">
				<div class="tz-well well">
					<span class="tz-title">Rules &amp; Regulations for registrations</span>
					<hr class="tz-hr">
					<small>DISCLAIMER: Read the rules carefully before registrations</small>
				</div>
				
			</div>
		</a>
	</div>
	<div class="clearfix">
		<br>
	</div>
</div>
