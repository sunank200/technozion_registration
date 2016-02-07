<div id="workshops-form-wrapper">
    <?php
        if (isset($error) && $error !== '')  {
    ?>
        <!--<script> alert(" <?php echo $error; ?>");</script> -->
    <?php
        }
    ?>
    <form action="<?php echo base_url("onspot/workshops/registerteam"); ?>" method="POST" class="form-horizontal">
        <div class="form-group">
            <div class="col-md-5">
                <label for="workshop" class="col-sm-3">Select workshop</label>
                <div class="col-sm-9">
                     <select name="workshopid" class="form-control" id="workshop-selected" required>
                        <!--   <option value="">--Select one workshop--</option>-->
                         <option data-min="1" data-max="1" data-cost="950" value="18"> Big Data</option>
                         <option data-min="1" data-max="1" data-cost="1000" value="19">Android App Design </option>
                         <option data-min="1" data-max="1" data-cost="1100" value="20">Automobile Design</option>
                         <option data-min="3" data-max="5" data-cost="6000" value="21"> Quadcopter</option>
                         <option data-min="3" data-max="5" data-cost="6000" value="4">Sixth Sense Technologies</option>
                         <option data-min="2" data-max="5" data-cost="7000" value="5">Accelero-Botix</option>
                         <option data-min="1" data-max="1" data-cost="1100" value="6">Touch and Augmented Control</option>
                         <option data-min="1" data-max="1" data-cost="1200" value="7"> Cyber-Security</option>
                         <option data-min="2" data-max="5" data-cost="6000" value="16"> Bridge Design and Fabrication</option>
                         <option data-min="2" data-max="5" data-cost="6500" value="17"> Autonomous Robotics (NRC)</option>
                         <option data-min="1" data-max="1" data-cost="700" value="22"> RC IC Engine Workshop - Day 1</option>
                         <option data-min="1" data-max="1" data-cost="700" value="23"> RC IC Engine Workshop - Day 2</option>
                         <option data-min="1" data-max="1" data-cost="200" value="101"> Design Mafia</option>
                    </select>

                </div>
            </div>
            <div class="col-md-6">
                <div class="col-sm-3">
                    <label for="workshop-details"> Workshops details</label>
                </div>
                <div class="col-sm-9">
                    <p id="workshop-details"></p>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="alert" id="participant-status">

            </div>
            <table class="table col-sm-12" id="participants">
                <thead>
                    <tr>
                        <th>S.NO.</th>
                        <th>TECHNOZION ID</th>
                        <th>NAME</th>
                        <th>COLLEGE</th>
                        <th>ROLL NUMBER</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-3">
                    <table class="table">
                        <tbody>
                            <tr><td>Workshops Cost: </td><td><span id="workshops-cost" class="badge"></span> <br></td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-3 col-sm-offset-6">
                    <button class="btn btn-primary btn-block" id="add-teammate">ADD TEAM MATE</button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="receiptid" class="col-sm-4 col-sm-offset-2">Receipt ID:</label>
            <div class="col-sm-6">
                <input required type="text" id="receiptid" name="receiptid">
            </div>
        </div>
        <div class="form-group">
            <label for="remarks" class="col-sm-4 col-sm-offset-2">Remarks:</label>
            <div class="col-sm-6">
                <input type="text" id="remarks" name="remarks">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-5 col-sm-2">
                <button class="btn btn-primary btn-block" id="register-team">
                    REGISTER
                </button>
            </div>
        </div>
    </form>
</div>