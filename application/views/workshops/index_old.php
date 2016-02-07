<div class="container">
    
    <?php// echo print_r($teams)?>
    <div class="row">
        <div class="col-md-9 col-md-offset-1">
            Register for workshops <a href="<?php echo base_url("workshops/register"); ?>" class="btn-btn-primary">here</a>
        </div>
    </div>

<div class="row">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">List of registered workshops</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <?php
                    if ($workshopCount < 1) {
                        ?>
<!--                        <a class="btn btn-block btn-success"-->
<!--                        href="--><?php //echo base_url("workshops/register"); ?><!--"><i>Register For New workshops</i></a>-->
                        <br>
                        <?php
                    } else {
                        ?>
                        <a href="" class="btn btn-block btn-info disabled"><center>You can register for only one workshop</center></a>
                        <br>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <table class="table table-hover table-condensed">
                <!-- <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Workshop</th>
                        <th>Status</th>
                        <th>TeamID</th>
                        <th>Team Members</th>
                    </tr>
                </thead> -->
                <tbody>
                    <?php
                    if (count($teams) > 0) {
                        $count = 1;
                        foreach($teams as $teamid => $teamDetails) { ?>
                        <tr>
                            <td rowspan="4" class="hidden-xs"><?php echo $count++; ?></td>
                            <td class="col-md-2 col-lg-2 col-xs-4"><strong>Workshop Name</strong></td>
                            <td>:</td>
                            <td colspan="2">
                                <?php echo $teamDetails["workshopName"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Registration Status</strong></td>
                            <td>:</td>
                            <td colspan="2">
                                <span class="label label-<?php echo ($teamDetails["status"] != '5')? "danger" : "success"; ?>">
                                   <?php echo ($teamDetails["status"] != '5')? "WAITING LIST" : "CONFIRM"; ?>
                               </span>
                           </td>
                       </tr>
                       <tr>
                           <td><strong>Team Id</strong></td>
                           <td>:</td>
                           <td><?php echo $teamid; ?></td>
                       </tr>
                       <tr>
                        <td><strong>Team members</strong></td>
                        <td>:</td>
                        <td>
                            <?php
                            $output = "<ol>";
                            foreach($teamDetails["users"] as $index => $user) {
                                $output.="<li>".$user["name"]." ";
                                $output.= "</li>";
                            }
                            $output .= '</ol>';
                            echo $output;
                            ?>
                        </td>
                        <td class="hidden-xs">
                            <?php
                            $output = "<ul>";
                            foreach($teamDetails["users"] as $index => $user) {
                                $output.="<li>";
                                $output.= "<span class='label label-".($user["registration"] == "1"? "success":"danger")."'>".($user["registration"] == "1" ? "REGISTRATION CONFIRM" : "REGISTRATION PENDING")."</span>";
                                $output.= "<span class='label label-".($user["hospitality"] == "1"? "success":"danger")."'>".($user["hospitality"] == "1" ? "HOSPITALITY CONFIRM" : "HOSPITALITY PENDING")."</span>";
                                $output.= "</li>";
                            }
                            $output .= '</ul>';
                            echo $output;
                            ?>
                        </td>
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
</div>
</div>
</div>