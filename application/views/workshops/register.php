<div id="workshops-form-wrapper">
    <?php
    if (isset($error) && $error !== '')  {
        ?>
        <!--<script> alert(" <?php echo $error; ?>");</script> -->
        <?php
    }
    ?>
    <form action="<?php echo base_url("workshops/registerteam"); ?>" method="POST" class="form">
        <div class="form-group">
            <div class="row">
                <div class="col-md-5 col-sm-6 col-xs-12 col-lg-5">
                    <label for="workshop" class="col-sm-3">Select workshop</label>
                    <div class="col-sm-9">

                      <select name="workshopid" class="form-control" id="workshop-selected" required>
                        <!--   <option value="">--Select one workshop--</option>-->
                        <option data-min="1" data-max="1" data-cost="950" value="18"> Big Data</option>
                        <option data-min="1" data-max="1" data-cost="1000" value="19">Android App Design </option>
                        <option data-min="1" data-max="1" data-cost="1100" value="20">Automobile Design</option>
                        <option data-min="3" data-max="5" data-cost="6000" value="21"> Quadcopter</option>
                        <option data-min="3" data-max="5" data-cost="6000" value="4">Sixth Sense Technologies</option>
                        <option data-min="2" data-max="5" data-cost="1" value="5">Accelero-Botix</option>
                        <option data-min="1" data-max="1" data-cost="1100" value="6">Touch and Augmented Control</option>
                        <option data-min="1" data-max="1" data-cost="1" value="7"> Cyber-Security</option>
                        <option data-min="2" data-max="5" data-cost="6000" value="16"> Bridge Design and Fabrication</option>
                        <option data-min="2" data-max="5" data-cost="6500" value="17"> Autonomous Robotics (NRC)</option>
                        <option data-min="1" data-max="1" data-cost="700" value="22"> RC IC Engine Workshop - Day 1</option>
                        <option data-min="1" data-max="1" data-cost="700" value="23"> RC IC Engine Workshop - Day 2</option>
                        <option data-min="1" data-max="1" data-cost="200" value="101"> Design Mafia</option>
                    </select>

                </div>
            </div>
            <div class="clearfix visible-xs">
                <br>    
            </div>
            <div class="col-md-6 col-xs-12 col-sm-6 col-lg-6">
                <div class="col-sm-3">
                    <label for="workshop-details"> Workshops details</label>
                </div>
                <div class="col-sm-9">
                    <p id="workshop-details"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="well">
            <h4>Instructions to register for any workshop</h4>
            <small> 
                <ul> 
                    <li>All the team members should make an Technozion account on ( <a href="http://technozion.in">register.technozion.org</a> )</li>
                    <li>Registrations fees of each team members is automatically added during workshop registrations. </li>
                    <li>Hospitality fees for each members can be paid duign workshop registrations</li>
                    <li>Only Technozion Id is required for adding team members</li>
                </ul>
            </small>
        </div>
    </div>
    <div class="form-group">
        <div class="alert" id="participant-status">
        </div>
        <table class="table table-condensed col-sm-12" id="participants">
            <thead>
                <tr>
                    <th class="hidden-xs"><span class="visible-xs"><small> # </small></span><span class="hidden-xs">Sr. No.</span></th>
                    <th><span class="visible-xs"><small> TZ Id   </small></span><span class="hidden-xs">Technozion Id</span></th>
                    <th>Name</th>
                    <th class="hidden-xs">College</th>
                    <th class="hidden-xs">Roll Number</th>
                    <th class="tips" title="Do you need Food and Accomodation?">Hospitality?</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr class="participant">
                    <td class="hidden-xs">1.</td>
                    <td ><input name="userid" class="participant-id form-control input-sm" data-registration="<?php echo ($selfDetails->registration === "0")?"no":"yes"; ?>" type="text" readonly value="<?php echo $selfDetails->userid; ?>">
                        <input type="text" hidden name="registration" class="participant-registration" value="<?php echo ($selfDetails->registration === "0")?"yes":"no"; ?>" ></td>
                        <td><input class="participant-name        form-control input-sm" type="text" disabled value="<?php echo $selfDetails->name; ?>"></td>
                        <td class="hidden-xs"><input class="participant-college     form-control input-sm" type="text" disabled value="<?php echo $selfDetails->college; ?>"></td>
                        <td class="hidden-xs"><input class="participant-collegeid   form-control input-sm" type="text" disabled value="<?php echo $selfDetails->collegeid; ?>"></td>
                        <td><center><input name="hospitality" class="participant-hospitality" type="checkbox" <?php echo ($selfDetails->hospitality === "0")? "":"checked"; ?>></center></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-3">
                    <table class="table">
                        <tbody>
                            <tr><td>Workshops Cost: </td><td><span id="workshops-cost" class="badge"></span> <br></td></tr>
                            <tr><td>Registration Cost: </td><td><span id="registration-cost" class="badge"></span> <br></td></tr>
                            <tr><td>Hospitality Cost: <br> (Food + Accommodation) </td><td><span id="hospitality-cost" class="badge"></span> <br></td></tr>
                            <tr title="Online payment incurs 3% transaction fees"><td>Transaction Charges (3%): </td><td><span id="total-op" class="badge"></span> <br></td></tr>
                            <tr><td>Total Cost: </td><td><span id="total-cost" class="badge"></span> <br></td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-3 col-sm-offset-6">
                    <button class="btn btn-primary btn-block btn-sm" id="add-teammate"><span class="glyphicon glyphicon-plus"></span> Add more team members</button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <input type="checkbox" id="terms-conditions" required> I agree to have read and accepted the following <a href="<?php echo base_url('help/terms'); ?>" target="_blank">Terms &amp; Conditions</a>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-4">
                <br>
                <button class="btn btn-primary btn-block btn-lg" id="register-team">
                    REGISTER WORKSHOP
                </button>
                <br><br>
            </div>

        </div>
    </form>
</div>