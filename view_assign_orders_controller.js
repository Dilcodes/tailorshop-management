//events------------------------------------------------------------------------
load_assign_orders();

$('#search').keyup(function () {
    load_assign_orders();
});



//functions---------------------------------------------------------------------
function load_assign_orders() {
    var search = $('#search').val();
    var dataArray = {action: 'load_assign_orders', search:search};
    $.post('./model/view_assign_orders_model.php', dataArray, function (reply) {
        $('#order_tbl tbody').html('').append(reply);

        $('.viewMes').click(function () {
            getCollectedMesDetails($(this).val());
        });

        $('.selectorder').click(function () {
            start_collect_messurement($(this).val());
        });

        $('.finishOrder').click(function () {
            var orderID = $(this).val();
            handle_finish_order(orderID); // Pass orderID to the function
        });

        $('.view_smpl_img').click(function () {
            var img = $(this).val();
            setTimeout(function () {
                $('#img_pre').attr('src', './others/upload_sample_image/' + img);
            }, 500);
        });

    });
}

function  start_collect_messurement(order) {
    alertify.confirm('Confirm Mesurement Collect', 'Are You Suir You Want To Collect Mesurements...?', function () {
        var x = order.split('~');
        window.location = './?location=getMes&item=' + x[1] + '&orderId=' + x[0] + '&itmName=' + x[2];
    }, function () {
        alertify.error('Cancel Delete');
    });
}

function getCollectedMesDetails(orderID) {
    var dataArray = {action: 'getCollectedMesDetails', orderID: orderID};
    $.post('./model/view_assign_orders_model.php', dataArray, function (reply) {
        var x = reply.split('~');
        setTimeout(function () {
            $('#order_id').val(orderID);
            $('#item').val(x[1]);
            $('#cusDetails').html(x[2]);
            $('#dynFormSection').html('').append(x[0]);
        }, 500);
    });
}

function handle_finish_order(orderID) {
    var dataArray = {action: 'handle_finish_order', orderID: orderID};
    $.post('./model/view_assign_orders_model.php', dataArray, function (reply) {
        if (reply == 0) {
            alertify.error('Notify faild');
        } else {
            var x = reply.split('~');
            var sms = "Dear valued customer, " + x[0] + ", Your Order(" + x[2] + ") has been completed Now.  Thank you for choosing Ajantha Tailors & Curtains.";
            sendSMS(x[1], sms);
            alertify.success('Successfully finish Order');
            load_assign_orders();
        }
    });
}






