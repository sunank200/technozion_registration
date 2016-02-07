<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="row" id="name">
			<center>
				<h2>On Spot Registration | Technozion - 2013</h2>
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
		
		<form id="signup-form" onsubmit="return verify();" method="post" action="<?php echo base_url('onspot/onspot_registration/register') ?>" class="form-horizontal" role="form">
			<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">

				<div class="form-group">
					<label for="signup-inputName" class="col-sm-3 control-label">Name</label>
					<div class="col-sm-9">
						<input required type="text" name="Name" class="form-control" id="signup-inputName" placeholder="eg: Sachin Tendulkar" value="<?php echo set_value('Name') ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="signup-inputEmail" class="col-sm-3 control-label">Email</label>
					<div class="col-sm-9">
						<input required type="email" name="Email" class="form-control" id="signup-inputEmail" placeholder="sachin@tendulkar.com" value="<?php echo set_value('Email') ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="signup-inputPhone" class="col-sm-3 control-label">Phone</label>
					<div class="col-sm-9">
						<input required type="tel" name="Phone" class="form-control" id="signup-inputPhone" placeholder="+919876543210" value="<?php echo set_value('Phone') ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="signup-inputCollege" class="col-sm-3 control-label">College</label>
					<div class="col-sm-9">
						<input required type="text" name="College" class="form-control" id="signup-inputCollege" placeholder="your college here" value="<?php echo set_value('College') ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="signup-inputCollegeId" class="col-sm-3 control-label">Student-id</label>
					<div class="col-sm-9">
						<input required type="text" name="CollegeId" class="form-control" id="signup-inputCollegeId" placeholder="Enter your student-id in here" value="<?php echo set_value('CollegeId') ?>">
					</div>
				</div>
				<!-- Year -->
				<!-- Department -->
				<div class="form-group">
					<label for="signup-inputCity" class="col-sm-3 control-label">City</label>
					<div class="col-sm-9">
						<input required type="text" name="City" class="form-control" id="signup-inputCity" placeholder="where is your college from?" value="<?php echo set_value('City') ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="signup-inputState" class="col-sm-3 control-label">State</label>
					<div class="col-sm-9">
						<select name="State" class="form-control" id="signup-inputState" value="">
							<option value="">--Select One--</option>
							<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
							<option value="Andhra Pradesh">Andhra Pradesh</option>
							<option value="Arunachal Pradesh">Arunachal Pradesh</option>
							<option value="Assam">Assam</option>
							<option value="Bihar">Bihar</option>
							<option value="Chandigarh">Chandigarh</option>
							<option value="Chhattisgarh">Chhattisgarh</option>
							<option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
							<option value="Daman and Diu">Daman and Diu</option>
							<option value="Delhi">Delhi</option>
							<option value="Goa">Goa</option>
							<option value="Gujarat">Gujarat</option>
							<option value="Haryana">Haryana</option>
							<option value="Himachal Pradesh">Himachal Pradesh</option>
							<option value="Jammu and Kashmir">Jammu and Kashmir</option>
							<option value="Jharkhand">Jharkhand</option>
							<option value="Karnataka">Karnataka</option>
							<option value="Kerala">Kerala</option>
							<option value="Lakshadweep">Lakshadweep</option>
							<option value="Madhya Pradesh">Madhya Pradesh</option>
							<option value="Maharashtra">Maharashtra</option>
							<option value="Manipur">Manipur</option>
							<option value="Meghalaya">Meghalaya</option>
							<option value="Mizoram">Mizoram</option>
							<option value="Nagaland">Nagaland</option>
							<option value="Orissa">Orissa</option>
							<option value="Pondicherry">Pondicherry</option>
							<option value="Punjab">Punjab</option>
							<option value="Rajasthan">Rajasthan</option>
							<option value="Sikkim">Sikkim</option>
							<option value="Tamil Nadu">Tamil Nadu</option>
							<option value="Tripura">Tripura</option>
							<option value="Uttaranchal">Uttaranchal</option>
							<option value="Uttar Pradesh">Uttar Pradesh</option>
							<option value="West Bengal">West Bengal</option>
						</select>


					</div>
				</div>
				<div class="form-group hidden">
					<label for="signup-inputPassword" class="col-sm-3 control-label">Password</label>
					<div class="col-sm-9">
						<input type="password" name="Password" class="form-control" id="signup-inputPassword" value="technozion">
					</div>
				</div>
			</div>
			<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">

				<div class="form-group">
					<label for="signup-inputregistration" class="col-sm-9 control-label">Registration fees paid (Rs 400)</label>
					<div class="col-sm-3">
						<input  type="checkbox" name="registration" id="signup-inputregistration" checked>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-lg btn-primary btn-block" id="signup-button">Register</button>
					</div>
				</div>
				<div class="alert alert-warning">
					<!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
					<ul>
						<li>Default password of participant is "technozion", they can login and pay for T-shirt, registration fees, hostpitality fees online.</li>
						<li>Participant should chagne password as soon as he login.</li>
						<li>participant can use his technozion id for event and workshop registration</li>
					</ul>
				</div>
			</div>
			
		</form>
	</div>
</div>

<script>
function verify(){
	var r = window.confirm("participant gave you Rs. 400");
	if(r == true) 
		return true;
	else 
		return false;
}
</script>
