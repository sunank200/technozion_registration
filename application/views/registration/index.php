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

<h2>Registration Closed</h2>

    <?php } ?>
</div>