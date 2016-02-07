            <div class="row">
            <div class="col-md-4">

                <div class="panel-group" id="accordion">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        get TZ id from Email
                      </a>
                  </h4>
              </div>
              <div id="collapseOne" class="panel-collapse collapse">
                  <div class="panel-body">
                     <div id="gettzid-email">
                        <div id="gettzid-email-status" class="tzid-status">
                        </div>
                        <form class="form" id="gettzid-email-form">
                            Enter Registered Email:
                            <br>
                            <input required type="email" id="gettzid-email-email">
                            <br>
                            <br>
                            <button class="btn btn-primary" type="submit" data-loading-text="Loading..." id="gettzid-email-submit">Get TZ ID</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                  get TZ id from Phone  No.
              </a>
          </h4>
      </div>
      <div id="collapseTwo" class="panel-collapse collapse">
          <div class="panel-body">
             <div id="gettzid-phone">
                <div id="gettzid-phone-status" class="tzid-status">

                </div>
                <form class="form" id="gettzid-phone-form">
                    Enter Phone:
                    <br>
                    <input required type="tel" id="gettzid-phone-phone">
                    <br>
                    <br>
                    <button class="btn btn-primary" type="submit" data-loading-text="Loading..." id="gettzid-phone-submit">Get TZ ID</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
          Register New participant
      </a>
  </h4>
</div>
<div id="collapseThree" class="panel-collapse collapse in">
  <div class="panel-body">
    <div id="createtzid">
        <div id="createtzid-status" class="tzid-status">

        </div>
        <form id="createtzid-form" class="form-horizontal" role="form">
            <div class="form-group">
                <label for="signup-inputName" class="col-sm-3 control-label">Name</label>
                <div class="col-sm-9">
                    <input required type="text" name="Name" class="form-control createtzid-form-required" id="signup-inputName" placeholder="eg: Sachin Tendulkar">
                </div>
            </div>
            <div class="form-group">
                <label for="signup-inputEmail" class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                    <input required type="email" name="Email" class="form-control createtzid-form-required" id="signup-inputEmail" placeholder="sachin@tendulkar.com" >
                </div>
            </div>
            <div class="form-group">
                <label for="signup-inputPhone" class="col-sm-3 control-label">Phone</label>
                <div class="col-sm-9">
                    <input required type="tel" name="Phone" class="form-control createtzid-form-required" id="signup-inputPhone" placeholder="+919876543210" >
                </div>
            </div>
            <div class="form-group hidden">
                <label for="signup-inputCollege" class="col-sm-3 control-label">College</label>
                <div class="col-sm-9">
                    <input required value="Onspot" type="text" name="College" class="form-control createtzid-form-required" id="signup-inputCollege" placeholder="your college here" >
                </div>
            </div>
            <div class="form-group">
                <label for="signup-inputNitw" class="col-sm-3 control-label">NITW?</label>
                <div class="col-sm-9">
                    <input type="checkbox" name="Nitw" class="createtzid-form-required" id="signup-inputNitw">
                </div>
            </div>
            <div class="form-group hidden">
                <label for="signup-inputCollegeId" class="col-sm-3 control-label">Student-id</label>
                <div class="col-sm-9">
                    <input required value="Onspot" type="text" name="CollegeId" class="form-control createtzid-form-required" id="signup-inputCollegeId" placeholder="Enter your student-id in here" >
                </div>
            </div>
            <!-- Year -->
            <!-- Department -->
            <div class="form-group hidden">
                <label for="signup-inputCity" class="col-sm-3 control-label">City</label>
                <div class="col-sm-9">
                    <input required value="Onspot" type="text" name="City" class="form-control createtzid-form-required" id="signup-inputCity" placeholder="where is your college from?" >
                </div>
            </div>
            <div class="form-group hidden">
                <label for="signup-inputState" class="col-sm-3 control-label">State</label>
                <div class="col-sm-9">
                    <select name="State" class="form-control" id="signup-inputState" value="">
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
                        <option select="selected" value="Onspot">Onspot</option>
                    </select>


                </div>
            </div>
            <div class="form-group hidden">
                <label for="signup-inputPassword" class="col-sm-3 control-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" name="Password" class="form-control" id="signup-inputPassword" value="technozion">
                </div>
            </div>
            <div class="form-group">
             <div class="col-sm-9">
                <button class="btn btn-primary" type="submit" data-loading-text="Loading..." id="createtzid-submit">Create Account</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
          Edit Existing participant details
      </a>
  </h4>
</div>
<div id="collapseFour" class="panel-collapse collapse">
  <div class="panel-body">
          <div id="editid-status" class="tzid-status">

        </div>
      <div class="edittzid">
            <form id="edittzid-tzid-form" class="form-horizontal" role="form">
            <div class="form-group">
                <label for="signup-inputName" class="col-sm-4 control-label">TZ ID</label>
                <div class="col-sm-8">
                    <input required type="text" name="find-tzid" class="form-control edittzid-form-required" id="find-tzid" placeholder="Enter Technozion ID">
                </div>
                 <label for="edit-name" class="col-sm-4 control-label">New Name</label>
                <div class="col-sm-8">
                    <input required type="text" name="edit-name" class="form-control edittzid-form-required" id="edit-name" placeholder="New name">
                </div>
            </div>

            <div class="form-group">
             <div class="col-sm-9">
                <button class="btn btn-primary" type="submit" data-loading-text="Loading..." id="edittzid-tzid-submit">Update details</button>
                </div>
            </div>
        </form>
      </div>
  </div>
</div>
</div>
</div>




</div>




<?php
//if (isset($scripts)) {
//    foreach ($scripts as $index => $script) {
//        ?>
<!--        <script src="--><?php //echo $script; ?><!--"></script>-->
<!--        --><?php
//    }
//    unset($scripts[0]);
//}
?>

<script>
    function clearStatuses()
    {
        $('.tzid-status').each(function() {
            $(this).html(' ');
        });
    }
    $(function() {
        $("#gettzid-email-form").on('submit', function() {
            clearStatuses();
            var butt = $("#gettzid-email-submit");
            butt.button('loading');
            var email = $("#gettzid-email-email").val();
            if(window.location.hostname == 'localhost'){
                var BASE_LOCATION = 'http://localhost:8888/tz/tz_registration';
            }else{
                var BASE_LOCATION = 'http://'+window.location.hostname;
            }
            $.ajax({
                url : BASE_LOCATION + "/onspot/accounts/gettzid/email/"+email,
                type: "POST",
                data : "",
                success: function(data, textStatus, jqXHR)
                {
                    data = JSON.parse(data);
                    if (data.status === true) {
                        $("#gettzid-email-status").attr('class', 'alert alert-success');
                        $("#gettzid-email-status").html('Userid: ' + data.userid);
                    } else {
                        $("#gettzid-email-status").attr('class', 'alert alert-danger');
                        $("#gettzid-email-status").html(data.message);
                    }
                    butt.button('reset');
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    $("#gettzid-email-status").html("Error in request. Please try again");
                    butt.button('reset');
                }
            });
            return false;
        });
$("#gettzid-phone-form").on('submit', function() {
    clearStatuses();
     $("#editid-status").html('');
    var butt = $("#edittzid-tzid-submit");
    butt.button('loading');
    var phone = $("#gettzid-phone-phone").val();
    if(window.location.hostname == 'localhost'){
        var BASE_LOCATION = 'http://localhost:8888/tz/tz_registration';
    }else{
        var BASE_LOCATION = 'http://'+window.location.hostname;
    }
    $.ajax({
        url : BASE_LOCATION+ "/onspot/accounts/gettzid/phone/"+phone,
        type: "POST",
        data : "",
        success: function(data, textStatus, jqXHR)
        {
            data = JSON.parse(data);
            if (data.status === true) {
                $("#gettzid-phone-status").attr('class', 'alert alert-success');
                $("#gettzid-phone-status").html('Userid: ' + data.userid);
            } else {
                $("#gettzid-phone-status").attr('class', 'alert alert-danger');
                $("#gettzid-phone-status").html(data.message);
            }
            butt.button('reset');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $("#gettzid-phone-status").html("Error in request. Please try again");
            butt.button('reset');
        }
    });
    return false;
});

$("#edittzid-tzid-form").on('submit', function() {
    clearStatuses();
    var butt = $("#edittzid-tzid-submit");
    butt.button('loading');
    var tzid = $("#find-tzid").val();
    var name = $("#edit-name").val();
    if(window.location.hostname == 'localhost'){
        var BASE_LOCATION = 'http://localhost:8888/tz/tz_registration';
    }else{
        var BASE_LOCATION = 'http://'+window.location.hostname;
    }
    $.ajax({
        url : BASE_LOCATION+ "/onspot/accounts/edit/"+tzid,
        type: "POST",
        data : {"name": name},
        success: function(data, textStatus, jqXHR)
        {
            data = JSON.parse(data);
            if (data.status === true) {
                $("#editid-status").attr('class', 'alert alert-success');
                $("#editid-status").html(data.message);
            } else {
                $("#editid-status").attr('class', 'alert alert-danger');
                $("#editid-status").html(data.message);
            }
            butt.button('reset');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $("#gettzid-phone-status").html("Error in request. Please try again");
            butt.button('reset');
        }
    });
    return false;
});

$("#createtzid-form").on('submit', function() {
    clearStatuses();
    var butt = $("#createtzid-submit");
    butt.button('loading');
    $('.createtzid-form-required').each(function() {
        if ($(this).val() == '') {
            alert('Field ' + $(this).attr('name') +  ' is empty');
            return false;
        }
    });

    var formData = "";
    formData += "Name=" + $("#signup-inputName").val();
    formData += "&Email=" + $("#signup-inputEmail").val();
    formData += "&Phone=" + $("#signup-inputPhone").val();
    formData += "&College=" + $("#signup-inputCollege").val();
    formData += "&CollegeId=" + $("#signup-inputCollegeId").val();
    formData += "&City=" + $("#signup-inputCity").val();
    formData += "&State=" + $("#signup-inputState").val();
    formData += "&Password=" + $("#signup-inputPassword").val();
    if ($("#signup-inputNitw").is(':checked')) formData += "&Nitw=on";
    if(window.location.hostname == 'localhost'){
        var BASE_LOCATION = 'http://localhost:8888/tz/tz_registration';
    }else{
        var BASE_LOCATION = 'http://'+window.location.hostname;
    }
    $.ajax({
        url : BASE_LOCATION+"/onspot/accounts/create",
        type: "POST",
        data : formData,
        success: function(data, textStatus, jqXHR)
        {
            data = JSON.parse(data);
            if (data.status === true) {
                $("#createtzid-status").attr('class', 'alert alert-success');
                $("#createtzid-status").html('Successfully created account. <br> Userid: ' + data.userid);
            } else {
                $("#createtzid-status").attr('class', 'alert alert-danger');
                $("#createtzid-status").html(data.message);
            }
            butt.button('reset');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $("#createtzid-status").html("Error in request. Please try again");
            butt.button('reset');
        }
    });
    return false;
});
});
</script>

</body>
</html>