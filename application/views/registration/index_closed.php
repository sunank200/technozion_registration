<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <legend>Status</legend>
    <table class="table table-bordered">
        <tr>
            <td><p>Hospitality Status:     <span class="label label-<?php echo ($hospitality === 0)?"danger":"success"; ?>"> <?php echo ($hospitality === 0)? "NOT PAID":"PAID"; ?> </span></p></td>
            <td><p>Registration Status:  <span class="label label-<?php echo ($registration === 0)?"danger":"success"; ?>"> <?php echo ($registration === 0)? "NOT PAID":"PAID"; ?> </span></p></td>
        </tr>
    </table>

</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <?php if ($registration === 0) { ?>

    <form action="<?php echo base_url("hospitality/register"); ?>" role="form" method="POST">
        <legend>Payment for Hospitality </legend>

        <div class="jumbotron">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                     <!-- <h1>Registrations are closed. </h1> -->
                  <p><input required type="checkbox" name="registration"<?php //echo ($registration === 0)? "":"checked disabled"; ?><!--> <!--<label for="registration">REGISTRATION (Rs.<?php //echo REGISTRATION_COST; ?><!--)</label> </p>-->
                    <p>REGISTRATION (Rs. <?php echo REGISTRATION_COST; ?>)</p>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

                    <input required type="checkbox"> I agree to the <a target="_blank" href="<?php //echo base_url("help/terms"); ?><!--">terms and conditions.</a>-->

                    <p>
                     <input type="submit" value="PROCEED TO PAYMENT" class=" btn-md btn btn-primary"><br>
                        <small class="text-danger" style="font-size:13px">3% extra will be charged by payment gateway.</small>
                    </p>
                </div>
            </div>
        </div>
        <button type = "submit" >Submit</button>
    </form>

    <?php } ?>
</div>