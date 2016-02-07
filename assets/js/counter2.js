function show_message(status, message) {
    $('.message').html(message);
}


function show_details(name)
{
    return 'Name: '+name + '<br>';
}

function show_registration(registered)
{
    if(registered == "1")
    {
        // set the registration status one, no need to take Rs 400;
        return ("registration status: " + "<span class='label label-success'>paid</span>" ); 
    }
    else
    {
        //give a option to get Rs 400
        return ("registration status: " + "<span class='label label-danger'>not paid</span>" +'<div class="checkbox"> <label><input type="checkbox" required="required" name="registration" id="inputRegistration">Pay now</label> </div>');
    }
}

function show_hospitality(hospitalized)
{
    if(hospitalized == "1")
    {
        //now need to take Rs 600;
        
        return ("hospitality status: " + "<span class='label label-success'>paid</span>"+ show_roomno()); 
    }
    else
    {
        var element = "hospitality status: " + 
        "<span class='label label-danger'>not paid</span>" + 
        '<div class="checkbox">'+
            '<label><input onclick="'
            + "if(document.getElementById('inputHospitality').checked) $(this).parent().parent().append(show_roomno()); else $(this).parent().parent().last().remove();"+ '" type="checkbox" name="hospitality" id="inputHospitality">Pay now</label> </div>'
        return element;
    }
}
;

function show_roomno()
{
    return '<label for="">Room no. alloted</label><input type="text" name="roomno" id="inputRoomno" required="required" class="form-control" value="" required="required" title="Enter Valid Room Number">';
}

function show_goodies()
{
    return '<div class="checkbox"><label><input type="checkbox" id="inputgoodies" required="required" name="goodies" >Goodies</label></div>';
}


function show_extra_amount()
{
    //contain extra amount box, verification declaration and submit button for ajax:)
    var element = '<label for="inputExtra_amount">Extra amount paid now</label><input type="text" name="extra_amount" id="inputExtra_amount" required="required" class="form-control" value="" required="required" title="Enter Valid amount Number" placeholder="Enter 0 if no extra amount need to pay">' +
     '<div class="checkbox"><label><input required="required"  type="checkbox" id="inputVerification" required="required" name="verification">I hereby declare that the above information is correct and I verified it</label></div>' +
     '<label for="inputReceipt">Receipt ID</label><input type="text" name="receipt" id="inputReceipt" required="required" class="form-control" value="" required="required" title="Enter Valid amount Number" placeholder="Enter 0 if not required">'+
     '<button type="button" onclick="verify();" class="btn-verify btn btn-primary">Verify adn update</button>';

     return element;
}


function generate_form(registration, hospitality, name) {
   $('.details').html(show_details(name) + show_registration(registration) + show_hospitality(hospitality) + show_goodies() + show_extra_amount());
}

$('#form-userid').on('submit', function (e) {
    var userid = $('#inputUserid').val();
    if(userid == "" || !$.isNumeric(userid)) {
       show_message('0', 'Invalid User ID.');
       return false;
    }
    $.ajax({
        url: 'counter2/userid/' + userid,
        type: 'post',
        data: {},
        success: function (data) {
            if(data == "") {
                show_message("0", "Server Error, please reload page and try again");
            }
            data = jQuery.parseJSON(data);
            if(status.data == "0")
            {
                return show_message(data.status, data.message);
            }
            else
            {
                generate_form(data.registration, data.hospitality, data.name);
                return show_message("1", "Participant found");
            }
        }
    });
    return false;
});

$('.btn-verify').click(function (e) {
    e.preventDefault();
    alert("clicked")
});

function verify(){

    var userid = $('#inputUserid').val();
    if(userid == "")
        return show_message("0", "Userid is invalid");
    var registration = ($('#inputregistration').is(':checked') ? "1" : "0");
    var hospitality = ($('#inputHospitality').is(':checked') ? "1" : "0");
    var roomno = $('#inputRoomno').val() ;
    var receipt = $('#inputReceipt').val();
    if(receipt == "")
        return show_message('0', "Enter 0 if no receipt required");
    if(roomno == "")
        return show_message('0', "Invalid Room No. Please enter valid room no or 0")
    var goodies = ($('#inputgoodies').is(':checked') ? "1": "0" );
    var extra_amount = $('#inputExtra_amount').val();
    if(extra_amount == "" || !$.isNumeric(extra_amount))
        return show_message('0', "Enter valid amount or 0 ");
    var verification = ($('#inputVerification').is(':checked') ? "1" : "0");
    if(verification == "0")
        return show_message('0', "You must verify and proceed.")
    var datastring = {'userid': userid, 'registration':registration, 'hospitality':hospitality, 'roomno':roomno, 'goodies':goodies, 'extra_amount':extra_amount, 'verification':verification, "receipt":receipt};
    console.log(datastring);
    $.ajax({
            url: 'counter2/verify',
            type: 'post',
            data: datastring,
            success: function (data) {
                if(data.status == "0")
                    return show_message(data.status, data.message);
                else
                    console.log(data);
            }
        });
    return false;
}