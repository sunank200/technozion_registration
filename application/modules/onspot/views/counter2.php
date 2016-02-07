    <div class="col-md-6">
        <div class="row">
            <div id="form-userid-status"></div>
            <form class="form" id="form-userid">
                <label for="inputUserid">Enter Technozion ID: </label>
                <br>
                <input type="text" name="userid" id="inputUserid" class="form-control" value="" required="required" pattern="[0-9]{7}" title="Enter Participant Technozion id">
                <br>
                <button type="submit" id="form-userid-button" class="btn-userid btn btn-default btn-primary" data-loading-text="Loading...">Get Details</button>
            </form>
        </div>
        <br>
        <hr>
        <!-- <div id="form-userid-status"></div> -->
        <!-- <hr> -->
        <br>
        <div class="row" id="details-status"></div>
        <div class="row details" id="details-form-parent">
        </div>
    </div>

<script>
if(window.location.hostname == 'localhost'){
    var BASE_LOCATION = 'http://localhost:8888/tz/tz_registration';
}else{
    var BASE_LOCATION = 'http://'+window.location.hostname;
}
    var strForm = '<form class="form form-horizontal" id="details-form"></form>';
    var strHiddenUserId = '<div class="form-group">' +
                    '<input type="hidden" id="details-userid">' +
                    '</div>'
    var strName = '<div class="form-group">' +
                    '<label for="details-name" class="col-md-6">Name: </label>' +
                    '<div class="col-md-6">' +
                        '<input type="text" class="form-control details" id="details-name" disabled>' +
                    '</div>' +
                '</div>';
    var strRegStatus = '<div class="form-group">' +
                    '<label for="details-registration-status" class="col-md-6">Registration Status</label>' +
                    '<div class="col-md-6">' +
                        '<span class="label" id="details-registration-status">Not Paid</span>' +
                    '</div>' +
                '</div>';

    var strRegPayment = '<div class="form-group">' +
                    '<label for="details-registration-payment" class="col-md-6">Pay for registration?</label>' +
                    '<div class="col-md-6">' +
                        '<input type="checkbox" class="details" id="details-registration-payment">' +
                    '</div>' +
                '</div>';
    var strHospStatus = '<div class="form-group">' +
                    '<label for="details-hospitality-status" class="col-md-6">Hospitality Status</label>' +
                    '<div class="col-md-6">' +
                        '<span class="label" id="details-hospitality-status">Not Paid</span>' +
                    '</div>' +
                '</div>';
    var strHospPayment = '<div class="form-group">' +
                    '<label for="details-hospitality-payment" class="col-md-6">Pay for Hospitality?</label>' +
                    '<div class="col-md-6">' +
                        '<input type="checkbox" class="details" id="details-hospitality-payment">' +
                    '</div>' +
                '</div>';
    var strRoomNo = '<div class="form-group hidden" id="details-roomno-parent">' +
                    '<label for="details-roomno" class="col-md-6">Room Number</label>' +
                    '<div class="col-md-6">' +
                '<input type="text" class="form-control details" id="details-roomno" >' +
                '</div>' +
            '</div>';
    var strGoodies ='<div class="form-group">' +
                    '<label for="details-goodies" class="col-md-6">Given Goodies?</label>' +
                    '<div class="col-md-6">' +
                        '<input type="checkbox" class="details" id="details-goodies">' +
                    '</div>' +
                '</div>';
    var strAmountPaid = '<div class="form-group">' +
                    '<label for="details-amout" class="col-md-6">Amount Paid</label>' +
                    '<div class="col-md-6">' +
                        '<input type="number" class="form-control details" id="details-amount">' +
                    '</div>' +
                '</div>';
    var strReceiptId = '<div class="form-group">' +
                    '<label for="details-receipt" class="col-md-6">Receipt ID</label>' +
                    '<div class="col-md-6">' +
                        '<input type="text" class="form-control details" id="details-receipt">' +
                    '</div>' +
                '</div>';
    var strRemarks ='<div class="form-group">' +
                    '<label for="details-remarks" class="col-md-6">remarks</label>' +
                    '<div class="col-md-6">' +
                        '<input type="text" class="form-control details" id="details-remarks">' +
                    '</div>' +
                '</div>';
    var strSubmit = '<div class="form-group">' +
                    '<div class="col-md-4 col-md-offset-4">' +
                        '<button id="details-submit" type="button" data-loading-text="Verifying..." class="btn btn-primary">Verify Participant</button>' +
                    '</div>';


function createForm(data, empty) {
    $("#details-form-parent").html(strForm);
    if (empty === true) return;
    var el = $("#details-form");
    // Name
    el.append(strName);
    $("#details-name").val(data.name);
    // Hidden Userid
    el.append(strHiddenUserId);
    $("#details-userid").val(data.userid);
    // Registration
    el.append(strRegStatus);
    if (data.registration == "1") {
        $("#details-registration-status").attr('class', 'label label-success').html("Paid");
    } else {
        $("#details-registration-status").attr('class', 'label label-danger').html("Not Paid");
        el.append(strRegPayment);
    }
    // Hospitality
    el.append(strHospStatus);
    if (data.hospitality == "1") {
        $("#details-hospitality-status").attr('class', 'label label-success').html("Paid");
    } else {
        $("#details-hospitality-status").attr('class', 'label label-danger').html("Not Paid");
        el.append(strHospPayment);
        el.append(strRoomNo);
    }
    // goodies
    el.append(strGoodies);
    if (data.goodies == "1") {
        $("#details-goodies").prop('checked', true);
    }
    // amount paid
    el.append(strAmountPaid);
    // receipt
    el.append(strReceiptId);
    el.append(strRemarks);
    // submit
    el.append(strSubmit);
}

function init(){
    $("#form-userid").on('submit', function() {
        $("#form-userid-status").hide();
        $("#form-userid-button").button('loading');
        $('#details-status').html('').hide();
        createForm('', true);
        var userid = $('#inputUserid').val();
        $.ajax({
            url: BASE_LOCATION+'/onspot/counter2/userid/' + userid,
            type: 'post',
            data: {},
            success: function (data) {
                data = jQuery.parseJSON(data);
                if(data.status === false) {
                    $("#form-userid-status").show().html(data.message).attr('class', 'alert alert-danger');
                } else if (data.status === true) {
                    createForm(data.user);
                    $("#form-userid-status").show().html(data.message).attr('class', 'alert alert-success');
                }
                $("#form-userid-button").button('reset');
            },
            error: function () {
                $("#form-userid-status").show().html("AJAX error. Try again later.").attr('class', 'alert alert-danger');
                $("#form-userid-button").button('reset');
            }
        });
        return false;
    });

    $(document).on('click', "#details-hospitality-payment", function() {
        var roomInput = $("#details-roomno-parent");
        if (roomInput.hasClass('hidden') === true) {
            roomInput.removeClass('hidden');
            // roomInput.prop('disabled', false);
        } else {
            roomInput.addClass('hidden');
            // roomInput.prop('disabled', true);
        }
    });

    $(document).on('click', '#details-submit', function() {
        $("#form-userid-status").hide();
        $("#details-submit").button('loading');
        var formData = 'userid=' + $('#details-userid').val();
        formData += '&receiptid=' + $('#details-receipt').val();
        formData += '&amount=' + $('#details-amount').val();
        if ($("#details-registration-status").html() == "Paid") {
            formData += '&registration=1';
        } else {
            formData += '&registration=' ;
            formData += ($("#details-registration-payment").is(':checked') == true)?'1':'0';
        }
        if ($("#details-hospitality-status").html() == "Paid") {
            formData += '&hospitality=1';
        } else {
            formData += '&hospitality=';
            formData += ($("#details-hospitality-payment").is(':checked') == true)?'1':'0';
            if ($("#details-hospitality-payment").is(':checked')) {
                formData += '&roomalloted=';
                formData += $('#details-roomno').val();
            }
        }
        formData += '&goodies=';
        formData += ($("#details-goodies").is(':checked'))?'1':'0';
        formData += '&remarks= ' + $('#details-remarks').val();

        console.log(formData);

        $.ajax({
            url: BASE_LOCATION + '/onspot/counter2/verify',
            type: 'POST',
            data: formData,
            success: function (data) {
                data = JSON.parse(data);
                if (data.status === true) {
                    $("#details-status").show().attr('class', 'row alert alert-success').html('Successfully Verified User. Proceed with the next person.');
                    $("#details-form-parent").empty();
                    $("#inputUserid").val('').focus();
                } else {
                    $("#details-status").show().attr('class', 'row alert alert-danger').html('Error verifying user. error: ' + data.message);
                }
                $("#details-submit").button('reset');
            },
            error: function() {
                alert("server error");
                $("#details-submit").button('reset');
            }
        });
        return false;
    });
}
$(init());
</script>