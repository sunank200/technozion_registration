<div class="container">
    <!--
    <div class="row">
        <div class="col-md-9 col-md-offset-1">
            Register for events <a href="<?php echo base_url("events/register"); ?>" class="btn-btn-primary">here</a>
        </div>
    </div>
    -->
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">List of registered events</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <a class="btn btn-block btn-success" href="<?php echo base_url("events/register"); ?>"><i>Register For New Event</i></a>-->
                        <br>
                    </div>
                </div>
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
                                    </span>
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
                                    <center><i>You haven't registered for any events yet.</i></center>
                                </td>
                            </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        
    </div>
</div>