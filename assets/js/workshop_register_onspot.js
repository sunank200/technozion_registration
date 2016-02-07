function getRow(slno) {
    var row =
        '<tr class="participant">' +
        '<td>' + slno.toString() +'.</td>' +
        '<td>'+
        '<input name="userid" class="participant-id form-control" type="text" placeholder="Enter Technozion-ID">' +
        '</td>' +
        '<td><input class="participant-name        form-control" type="text" disabled></td>' +
        '<td><input class="participant-college     form-control" type="text" disabled></td>' +
        '<td><input class="participant-collegeid   form-control" type="text" disabled></td>' +
        '<td style="width:60px;"><button class="btn btn-block btn-danger remove-teammate" style="border-radius:50%;">&times;</button></td>' +
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
    // if ($("#participants tbody tr").index($(this).parents("tr")) === 0) {
    //    alert("You can't remove yourself :P");
    //    return false;
    // }
    var row = $(this).parents("tr");
    row.remove();
    $('.participant').each(function (index) {
        $(this).children().first().html((index+1).toString());
    });
    updateCost();
    return false;
}

function updateCost(e) {
    var workshopCount = 0;
    var cost = 0;
    cost += $("#workshop-selected option:selected").data("cost");
    $("#workshops-cost").html(cost);
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
        url : "../../accounts/user/"+userid,
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
                updateCost();
            } else {
                row.find(".participant-name").val('');
                row.find(".participant-college").val('');
                row.find(".participant-collegeid").val('');
                row.find(".participant-id").data('registration', '');
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
    var r = confirm("Make sure you took " + $("#workshops-cost").html() + " Rs");
    if(r === false)
    return false;
    //alert("Make sure you took " + $("#total-cost").html() + " Rs");

    var total = $('.participant-id').length;
    if (total < $("#workshop-selected option:selected").data('min') || total > $("#workshop-selected option:selected").data('max')) {
        alert("Number of participants is not in limits");
        return false;
    }

    $('.participant-id').each(function(index) {
        $(this).attr('name', $(this).attr('name')+(index+1).toString());
    });

    return true;
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
});