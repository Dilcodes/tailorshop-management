//events------------------------------------------------------------------------
load_orders(0);
load_tailors();

//Event Listners for different buttons & dropdowns
$('#pending').click(function () {
    $('#tailorSection').addClass('d-none');
    load_orders(0);
});

$('#assigned').click(function () {
    $('#tailorSection').addClass('d-none');
    load_orders(1);
});

$('#tailor_wise').click(function () {
    $('#tailorSection').removeClass('d-none');
    load_orders(10);
});

$('#tailors').change(function () {
    load_orders(10);
});

$('#assign').click(function () {
    assign_order_to_tailor();
});

$('#search').keyup(function () {
     $('#search').keyup(function () {
        var searchTerm = $(this).val().toLowerCase();
        $('#order_tbl tbody tr').each(function () {
            var lineStr = $(this).text().toLowerCase();
            if (lineStr.indexOf(searchTerm) === -1) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    });
});

//functions---------------------------------------------------------------------
function load_orders(type) {
    if (type == 10) {
        var tailor_id = $('#tailors').val();
        var dataArray = {action: 'load_orders', type: type, tailor_id: tailor_id};
    } else {
        var dataArray = {action: 'load_orders', type: type};
    }
    $.post('./model/assign_order_model.php', dataArray, function (reply) {
        $('#order_tbl tbody').html('').append(reply);

        $('.selectorder').click(function () {
            localStorage.setItem('orderID', $(this).val());
        });
    });
}

function load_tailors() {
    var dataArray = {action: 'load_tailors'};
    $.post('./model/assign_order_model.php', dataArray, function (reply) {
        $('#tailors').html('').append(reply);
        $('#tailors_2').html('').append(reply);
    });
}

function assign_order_to_tailor() {
    var order_id = localStorage.getItem('orderID');
    var tailor_id = $('#tailors_2').val();

    var dataArray = {action: 'assign_order_to_tailor', tailor_id: tailor_id, order_id: order_id};
    $.post('./model/assign_order_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('Sucessfully Assign Tailor');
            load_orders(0);
            $('#assignTailorModel').modal("hide");
        } else {
            alertify.error('Tailor Assign Process Fail');

        }
    });


}