<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<form class="form form-horizontal" id="form-tshirt" action="<?php echo base_url('tshirt/add_tshirt') ?>" method="POST" role="form">
			<legend>Buy tshirts for your team, friends in one click</legend>

			<div class="form-group">
				<label class="col-sm-4 control-label">Number of T-shirt</label>
				<div class="col-sm-2">
					<input type="number" min="1" required="required" name="numtshirt" class="form-control input-sm numt " id="" placeholder="Input field" value="1">
				</div>
			</div>

			<div class="sizes">
				<div class="form-group">
					<label class="col-sm-4 control-label">Size of T-shirt</label>
					<div class="col-sm-3"><select name="tshirt_size[]" id="inputTshirt_size" class="form-control input-sm" required>
						<option value="">-- Select One --</option>
						<option value="S">Small</option>
						<option value="M">Medium</option>
						<option value="L">Large</option>
						<option value="XL">XL</option>
						<option value="XXL">XXL</option>
					</select></div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-8">
					<button type="submit" class="btn btn-primary btn-block btn-lg">BUY NOW @ 220 per T-Shirt</button>
				</div>
			</div>
		</form>
		<h1 id="tot" class="hidden" style="text-align:center">You have to pay Rs. <span class="total_amt">0</span></h1>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<img src="<?php echo base_url('assets/images/tshirt_large.jpg') ?>" alt="tshirt_image" class="img img-square col-md-8" >
			<div class="clearfix">
			
			</div>
		<p class="text-danger">+3 % extra will be charged by payment gateway.</p>
	</div>
</div>