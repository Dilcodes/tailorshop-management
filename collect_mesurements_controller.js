//events
$('#finish').click(function () {
    finish_measurements();
});

setTimeout(function () {
    create_measurements_collect_form();
}, 250);

$('#reset').click(function () {
    form_reset();
});
//------------------------------------------------------------------------------


function create_measurements_collect_form() {
    var itemID = $('#itemID').val();
    var dataArray = {action: 'create_measurements_collect_form', itemID: itemID};
    $.post('./model/collect_mesurements_model.php', dataArray, function (reply) {
        var x = reply.split('~');
        $('#dynSection').html(x[0]);
        $('#formcount').val(x[1]);

        $('.mesurement_input').keyup(function () {
            var val = $(this).val();
            var floatValues = /[+-]?([0-9]*[.])?[0-9]+/;
            if (val.match(floatValues) && !isNaN(val)) {

            } else {
                $(this).focus();
                $(this).select();
                alertify.error('Invalid Reading');
            }
        });

    });
}

//function
function finish_measurements() {
    var formcount = $('#formcount').val();
    var order = $('#order').val();
    var itemID = $('#itemID').val();
    var array = [];
    for (x = 1; x <= formcount; x++) {
        var z = $('#input_' + x).val();
        if (z.length == 0) {
            alertify.error('All fields are must fill');
            return;
        }
        var a = $('#input_' + x).data('type');
        var data = a + ':' + z;
        array.push(data);
    }
    var dataArray = {action: 'finish_measurements', array: array, order: order, itemID: itemID};
    //console.log(array);
    $.post('./model/collect_mesurements_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('successfully Insert Data');
            setTimeout(function () {
                window.location = "./?location=view_assign_orders";
            }, 300);
        } else {
            alertify.error('Data Insert Failed');
        }
    });
}

/*
 function () {
 $('#item_name').val('');
 $('#dynSection').html('');
 }
 */

function form_reset() {
    // Reset only the dynamic input fields within #dynSection ****
    $('#dynSection').find('input').each(function () {
        $(this).val('');  // Clear the value of each input field
    });
}
