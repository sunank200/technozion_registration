

<?php if(isset($message)){ ?>
    <p class="alert alert-success"><?php echo $message ?></p>
<?php }else{ ?>
    <p class="alert alert-success"> Please Update Your Profile. Registration Will be cancelled for empty profile.</p>
<?php } ?>
<div class="col-md-6" style="padding-bottom: 30px">



    <form action="" method="POST">
            <strong>Name:</strong>
            <input name="InputCollegeid" type="text" class="form-control input-sm" value="<?php echo $userDetails->name;?>" disabled>
        <br/>
        <strong>College ID/student ID:</strong>
            <input name="InputCollegeid" type="text" class="form-control input-sm" value="<?php echo $userDetails->collegeid == 0 ? 'not updated': $userDetails->collegeid; ?>" required="">
        <br/>
        <strong>City:</strong>
        <br/>
            <select name="InputCity" required class="form-control" id="signup-inputCity">
                <option value="">select city</option>
                <?php foreach ($citylist as $row):?>
                    <option value="<?=$row->city_id?>"><?=$row->city?></option>
                <?php endforeach;?>
                <option value="others">Others</option>
            </select>

            <input name = "InputCity" type="text" id = "signup-cityname" style = "display: none"/>
            <p>Note that if you change your city you have to update your college also.</p>
        <strong>College:</strong>
        <input type='text' class='form-control' value="<?php echo $userDetails->college == '0' ? 'not updated' : $userDetails->college; ?>" disabled>

        <select required="" name="College" class="form-control" id="signup-inputCollege">
            <option value="">Select college</option>
            </select>
            <input name="InputCollege" type='text' class='form-control' placeholder='your college name' id='signup-o-inputCollege' value="<?php echo $userDetails->college == '0'? 'not updated':  $userDetails->college ; ?>" style="display:none;">
            <strong>State:</strong>
        <br/>
            <select name="InputState" class="form-control" id="signup-inputState"  required="">
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
                    <option value="Telangana">Telangana</option>
                    <option value="Tripura">Tripura</option>
                    <option value="Uttaranchal">Uttaranchal</option>
                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                    <option value="West Bengal">West Bengal</option>
                </select>
        <?php
        //fucked up code for gender
        //i don't like to write these extra lines
        // just to determine... nevermind
        // -______________-
        $sex = "not decided yet";
        switch($userDetails->sex){
            case 0:
                //probalbly transgender or some fu***d up shit
                $sex = 'none';
                break;
            case 1:
                $sex = 'male'; //i guess
                break;
            case 2:
                $sex = /*definitely*/ 'female'; //lol
                break;
        }
        ?>
            <strong>Gender:</strong>
        <br/>

        <input class="form-control input-sm" type="text" value="<?php echo $sex  ?>" disabled/>
        <br/>
        <select class="form-control input-sm" name="InputGender" >
                <option value="1">Male</option>
                <option value="2">Female</option>
            </select>
            <strong>Phone:</strong>
            <input name="InputPhone" type="text" class="form-control input-sm" value="<?php echo $userDetails->phone == 0 ? '': $userDetails->phone; ?>"  required="">
            <strong>Email:</strong>
            <input name = "email" type="text" class="form-control input-sm" value="<?php echo $userDetails->email; ?>" disabled>
        <br/>
    <input type = "submit" class = "btn btn-block btn-success" />
    </form>
</div>
<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">Current Profile Details</div>
        <div class="panel-body">
            <strong>TZ ID:</strong>
            <strong> <?php echo $userDetails->userid; ?></strong><br/>
            <strong><?php echo $userDetails->name; ?></strong><br/>
            <strong><?php echo $userDetails->college == '0' ? 'not updated' : $userDetails->college; ?></strong>
            <strong><?php echo $userDetails->city == '0' ? 'not updated' : $userDetails->city ; ?></strong><br/>
            <strong><?php echo $userDetails->state; ?></strong><br/>
            <strong>Phone: </strong><strong><?php echo $userDetails->phone == 0 ? '': $userDetails->phone; ?></strong><br/>
            <strong>Gender: </strong><strong><?php echo $sex; ?></strong><br/>
        </div>
    </div>
</div>
