    <div class="col-md-6">
        <div class="row">
            <div id="form-userid-status"></div>
            <form class="form" id="form-userid">
                <label for="inputUserid">Enter Technozion ID: </label>
                <br>
                <input type="text" name="userid" id="inputUserid" class="form-control" value="" required="required" pattern="[0-9]{7}" title="Enter Participant Technozion id">
                <br>
                <button type="submit" class="btn-userid btn btn-default btn-primary" data-loading-text="Loading...">Pay Rs 400 Now</button>
            </form>         
        </div>
    </div>

<script>
    $("#form-userid").on('submit', function() {
        var userid = $('#inputUserid').val();
        if(window.location.hostname == 'localhost'){
            var BASE_LOCATION = 'http://localhost:8888/tz/tz_registration';
        }else{
            var BASE_LOCATION = 'http://'+window.location.hostname;
        }

        $.ajax({
            url: BASE_LOCATION+ '/onspot/counter2/userid/' + userid,
            type: 'post',
            data: {},
            success: function (data) {
                data = jQuery.parseJSON(data);
                if(data.status === false) {
                    $("#form-userid-status").html(data.message);
                } else if (data.status === true) {
                      $("#form-userid-status").html("One participant found");
                }
            },
            error: function () {
                $("#form-userid-status").html("Error in request");
            }
        });
        return false;
    });
</script>