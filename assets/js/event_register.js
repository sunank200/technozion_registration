function getRow(slno) {
    var row =
    '<tr class="participant">' +
    '<td class="hidden-xs">' + slno.toString() +'.</td>' +
    '<td><input title="Enter Teammate TZ-ID" required class="participant-id tips form-control input-sm" type="text" placeholder="Enter teammate TZ-ID"></td>' +
    '<td><input class="participant-name form-control input-sm" type="text" disabled></td>' +
    '<td class="hidden-xs"><input class="participant-college   form-control input-sm" type="text" disabled></td>' +
    '<td class="hidden-xs"><input class="participant-collegeid form-control input-sm" type="text" disabled></td>' +
    '<td><button class="btn btn-danger btn-sm remove-teammate" >X</button></td>' +
    '</tr>';
    return row;
}

function addRow(e) {
    e.preventDefault();

    console.log($("#event-selected option:selected").data('max'));

    if ($('.participant-id').length < $("#event-selected option:selected").data('max')) {
        var numTeamMembers = $('.participant').length+1;
        var newRow = getRow(numTeamMembers);
        $("#participants tbody").append(newRow);
    } else {
        alert("Maximum team size: " + $("#event-selected option:selected").data('max') + "  reached");
    }
    return false;
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
    return false;
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
                // row.find(".participant-id").data("valid", "true");
                // row.removeClass().addClass('participant success');
            } else {
                // row.addClass('participant danger');
                // row.find(".participant-id").data("valid", "false");
                row.find(".participant-name").val('');
                row.find(".participant-college").val('');
                row.find(".participant-collegeid").val('');
                $("#participant-status").removeClass().addClass('alert alert-danger').html('<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>'+data.message);
                self.val('');
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $("#participant-status").removeClass().addClass('alert alert-danger').html('<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>Error occured. Please try later.');
        }
    });
return false;
}

function submitTeam() {

    var total = $('.participant-id').length;

    if (total < $("#event-selected option:selected").data('min') || total > $("#event-selected option:selected").data('max')) {
        alert("Number of participants is not in limits");
        return false;
    }

    var inputData = {};
    inputData.eventid = $("#event-selected").val();
    inputData.userids = [];
    $('.participant-id').each(function(index) {
        // if ($(this).data("valid") === true) {
            inputData.userids.push($(this).val());
        // }
    });
    var jsonData = JSON.stringify(inputData);

    $.ajax({
        url : "registerteam",
        type: "POST",
        data : "registerData="+jsonData,
        success: function(data, textStatus, jqXHR)
        {
            data = JSON.parse(data);
            if (data.status === "success") {
                $("#participant-status").removeClass().addClass('alert alert-success').html(data.message);
            } else {
                $("#participant-status").removeClass().addClass('alert alert-danger').html(data.message);
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $("#participant-status").removeClass().addClass('alert alert-danger').html("Error occured. Please try later.");
        }
    });

    return false;
}

function showEventDetails(e) {
    var selectedElement = $("#event-selected").children("option:selected");
    $("#event-details").html("Minimum number of team members: " +
        '<span class="label label-info">' +
        selectedElement.data('min') +
        "</span><br>" +
        "Maximum number: " +
        '<span class="label label-info">' +
        selectedElement.data('max') +
        '</span>');
}

$(function() {
    $("#add-teammate").click(addRow);
    $(document).on('click', ".remove-teammate", removeRow);
    $(document).on('change', ".participant-id", fetchDetails);
    $("#register-team").click(submitTeam);
    showEventDetails();
    $("#event-selected").change(showEventDetails);
});
