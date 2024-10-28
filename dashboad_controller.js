//events------------------------------------------------------------------------
get_system_summeries();
load_ongoing_orders_to_tbl();

//functions---------------------------------------------------------------------
function get_system_summeries() {
    var dataArray = {action: 'get_system_summeries'};
    $.post('./model/dashboad_model.php', dataArray, function (reply) {
        var x = reply.split('~');
        $('#cus_total').html(x[0]);
        $('#montly_total').html(x[1]);
        $('#stock_value').html();
        $('#active_orders').html(x[2]);
    });
}


function load_ongoing_orders_to_tbl() {
   // var search = $('#search').val();
    var dataArray = {action: 'load_ongoing_orders_to_tbl'};
    $.post('./model/dashboad_model.php', dataArray, function (reply) {
        $('#ongoing_orders tbody').html('').append(reply);
    });
}