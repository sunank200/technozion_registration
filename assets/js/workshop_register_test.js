function getRow(slno) {
    var row =
        '<tr class="participant">' +
        '<td class="hidden-xs">' + slno.toString() +'.</td>' +
        '<td>'+
        '<input name="userid" class="participant-id form-control input-sm" type="text" data-registration="no" placeholder="Enter your team-mates Technozion-ID">' +
        '<input type="text" hidden name="registration" class="participant-registration" value="" >' +
        '</td>' +
        '<td><input class="participant-name        form-control input-sm" type="text" disabled></td>' +
        '<td class="hidden-xs"><input class="participant-college     form-control input-sm" type="text" disabled></td>' +
        '<td class="hidden-xs"><input class="participant-collegeid   form-control input-sm" type="text" disabled></td>' +
        '<td style="vertical-align:middle"><center><input name="hospitality" class="participant-hospitality" type="checkbox"></center></td>' +
        '<td><button class="btn btn-sm btn-danger remove-teammate" >X</button></td>' +
        '</tr>';
    return row;
}

function addRow(e) {
    e.preventDefault();
    // alert($("#workshop-selected option:selected").data('max'));
    if ($('.participant-id').length < $("#workshop-selected option:selected").data('max')) {
        var numTeamMembers = $('.participant').length+1;
        var newRow = getRow(numTeamMembers);
        $("#participants tbody").append(newRow);
        return false;
    } else {
        alert("Maximum team size: " + $("#workshop-selected option:selected").data('max') + "reached");
        return false;
    }
}

function removeRow(e) {
    e.preventDefault();
    if ($("#participants tbody tr").index($(this).parents("tr")) === 0) {
        alert("You can't remove yourself :P");
        return false;
    }
    var row = $(this).parents("tr");
    row.remove();
    $('.participant').each(function (index) {
        $(this).children().first().html((index+1).toString());
    });
    updateCost();
    return false;
}

function updateCost(e) {
    var hospitalityCost = 1;
    var registrationCost = 1;
    var workshopCount = 0;
    var hospitalityCount = 0;
    var registrationCount = 0;
    $('.participant-id').each(function(index) {
        if ($(this).val() !== '') {
            workshopCount++;
            var temp = $(this).parent().parent().find(".participant-hospitality");
            if ( ! temp.is(":disabled") &&
                temp.is(":checked")) {
                hospitalityCount++;
            }
            if($(this).data('registration') === "no") {
                registrationCount++;
            }
        }
    });
    var cost = 0;
    cost += $("#workshop-selected option:selected").data("cost");
    $("#workshops-cost").html(cost);
    $("#registration-cost").html(registrationCount * registrationCost);
    cost += registrationCount * registrationCost;
    $("#hospitality-cost").html(hospitalityCount * hospitalityCost);
    cost += hospitalityCount * hospitalityCost;
    $("#total-op").html(Math.ceil((cost*3)/97));
    $("#total-cost").html(Math.ceil((cost*100.0)/97.0));
}

function fetchDetails(e) {
    var self = $(this);
    var row = $(this).parents("tr");
    var userid = $(this).val();
        var count = 0;
    $('.participant-id').each(function() {
        if ($(this).val() === userid) {
            count ++;
        }
    });
    if (count > 1) {
        alert("Person already added");
        $(this).val('');
        return false;
    }
    $.ajax({
        url : "../accounts/user/"+userid,
        type: "POST",
        data : "",
        success: function(data, textStatus, jqXHR)
        {
            data = JSON.parse(data);
            if (data.status === "success") {
                $("#participant-status").removeClass().addClass('alert').html('');
                row.find(".participant-name").val(data.data.name);
                row.find(".participant-college").val(data.data.college);
                row.find(".participant-collegeid").val(data.data.collegeid);
                row.find(".participant-id").data('registration', (data.data.registration === "0")?"no":"yes");
                row.find(".participant-registration").val((data.data.registration === "0")?"yes":"no");
                if (data.data.hospitality === "1") {
                    row.find(".participant-hospitality").prop('checked', true);
                    row.find(".participant-hospitality").prop('disabled', true);
                }
                updateCost();
            } else {
                // row.addClass('participant danger');
                // row.find(".participant-id").data("valid", "false");
                row.find(".participant-name").val('');
                row.find(".participant-college").val('');
                row.find(".participant-collegeid").val('');
                row.find(".participant-id").data('registration', '');
                row.find(".participant-hospitality").prop('checked', false);
                row.find(".participant-hospitality").prop('disabled', false);
                row.find(".participant-registration").val('');
                $("#participant-status").removeClass().addClass('alert alert-danger').html(data.message);
                self.val('');
            }
            updateCost();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $("#participant-status").removeClass().addClass('alert alert-danger').html("Error occured. Please try later.");
            updateCost();
        }
    });
    return false;
}

function submitTeam() {

    if (!$("#terms-conditions").is(':checked')) {
        alert("You have to read and accept the terms & conditions");
        return false;
    }

    var total = $('.participant-id').length;
    if (total < $("#workshop-selected option:selected").data('min') || total > $("#workshop-selected option:selected").data('max')) {
        alert("Number of participants is not in limits");
        return false;
    }

    $('.participant-id').each(function(index) {
        $(this).attr('name', $(this).attr('name')+(index+1).toString());
    });
    $('.participant-registration').each(function(index) {
        $(this).attr('name', $(this).attr('name')+(index+1).toString());
    });
    $('.participant-hospitality').each(function(index) {
        $(this).attr('name', $(this).attr('name')+(index+1).toString());
    });

    return true;
    // var inputData = {};
    // inputData.workshopid = $("#workshop-selected").val();
    // inputData.userids = [];
    // inputData.hospitality = [];
    // $('.participant-id').each(function(index) {
    //     if($(this).val() !== '') {
    //        inputData.userids.push($(this).val());
    //        var temp = $(this).parent().parent().find(".participant-hospitality");
    //        if ( !temp.is(":disabled") && temp.is(":checked")) {
    //             inputData.hospitality.push($(this).val());
    //         }
    //     }
    // });

    // var jsonData = JSON.stringify(inputData);

    // alert(jsonData);

    // $.ajax({
    //     url : "registerteam",
    //     type: "POST",
    //     data : "registerData="+jsonData,
    //     success: function(data, textStatus, jqXHR)
    //     {
    //         data = JSON.parse(data);
    //         if (data.status === "success") {
    //             $("#participant-status").removeClass().addClass('alert alert-success').html(data.message);
    //         } else {
    //             $("#participant-status").removeClass().addClass('alert alert-danger').html(data.message);
    //         }
    //     },
    //     error: function (jqXHR, textStatus, errorThrown)
    //     {
    //         $("#participant-status").removeClass().addClass('alert alert-danger').html("Error occured. Please try later.");
    //     }
    // });

    // return false;
}

function showWorkshopDetails(e) {
    var selectedElement = $("#workshop-selected").children("option:selected");
    $("#workshop-details").html("Minimum number of team members: " +
        '<span class="label label-info">' +
        selectedElement.data('min') +
        "</span><br>" +
        "Maximum number: " +
        '<span class="label label-info">' +
        selectedElement.data('max') +
        '</span><br>' +
        "Workshop Cost: " +
        '<span class="label label-info"> Rs. ' +
        selectedElement.data('cost') +
        '</span><br>'
        );
}

function workshopSelectionWrapper() {
    showWorkshopDetails();
    updateCost();
}

$(function() {
    $("#add-teammate").click(addRow);
    $(document).on('click', ".remove-teammate", removeRow);
    $(document).on('change', ".participant-id", fetchDetails);
    $("#register-team").click(submitTeam);
    showWorkshopDetails();
    $("#workshop-selected").change(workshopSelectionWrapper);
    updateCost();
    $(document).on('change', ".participant-hospitality", updateCost);
});