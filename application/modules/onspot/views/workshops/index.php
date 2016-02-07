    <div class="col-md-8">
    <div class="col-md-6 <?php echo ($type === 'id') ? 'alert alert-success': 'well'; ?>">
        <?php if ($type === 'id' && isset($error)) {
            ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
            <?php
        } ?>
        <form method="POST" action="<?php echo base_url('onspot/workshops/details/id'); ?>" class="form">
           <label> Enter Technozion ID: </label>
             <div class="form-group">
            <input required type="number" name="tzid" <?php if (isset($id)) echo "value='$id'"; ?>>
            </div>
            <div class="form-group">
            <input type="submit" class="btn btn-primary">
            </div>
        </form>
    </div>
    <div class="col-md-6 <?php echo ($type === 'email') ? 'alert alert-success': 'well'; ?>">
        <?php if ($type === 'email' && isset($error)) {
            ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
            <?php
        } ?>
        <form method="POST" action="<?php echo base_url('onspot/workshops/details/email'); ?>" class="form">
            <label>Enter Email ID: </label>
            <br>
            <div class="form-group">
            <input required type="email" name="tzid" <?php if (isset($email)) echo "value='$email'"; ?>>
            </div>
             <div class="form-group">
            <input type="submit" class="btn btn-primary">
            </div>
        </form>
    </div>

<br>
<hr>
<br>
<div class="row">
    <div class="col-md-12">

<?php
if (isset($workshopCount)) {

    if (isset($id)) {
        $identity = $id;
    } else if (isset($email)) {
        $identity = $email;
    }
?>  
    
<?php
    if ($workshopCount < 1) {
    ?>
        <p><b><?php echo $identity; ?></b> has not registered for any workshops. <a class="btn btn-primary" href="<?php echo base_url("onspot/workshops/register"); ?>"><i>Register him for a workshop</i></a></p>
        <br>
    <?php
    } else {
    ?>
        <p>Workshops <b><?php echo $identity; ?></b> has registered for, are: </p>
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
                    if (count($teams) > 0) {
                        $count = 1;
                        foreach($teams as $teamid => $teamDetails) { ?>
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
<?php
    }
}
?>
    </div>
    </div>