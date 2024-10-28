//events------------------------------------------------------------------------
load_items();

$('#select_item').change(function () {
    var item = $("#select_item option:selected").text();
    $('#selected_item').html(item);
    load_stock_update_summery();
});

//functions---------------------------------------------------------------------
function load_items() {
    var dataArray = {action: 'load_items'};
    $.post('./model/item_movement_model.php', dataArray, function (reply) {
        $('#select_item').html(reply);
       // chosenRefresh(); 
    });
}

function load_stock_update_summery() {
    var itemID = $('#select_item').val();
    var dataArray = {action: 'load_stock_update_summery', itemID: itemID};
    $.post('./model/item_movement_model.php', dataArray, function (reply) {
        reply = reply.split('~');
        $('#stock_update_summery').html(reply[0]);
        $('#all_update_qty').html(reply[1]);
        load_item_issue_summery(reply[1]);
    });
}

function load_item_issue_summery(addedQty) {
    var itemID = $('#select_item').val();
    var dataArray = {action: 'load_item_issue_summery', itemID: itemID};
    $.post('./model/item_movement_model.php', dataArray, function (reply) {
        reply = reply.split('~');
        $('#issue_details').html(reply[0]);
        $('#all_issue_qty').html(reply[1]);

        var balanceQty = parseFloat(addedQty) - parseFloat(reply[1]);
        $('#avialable_qty').html(balanceQty);
    });
}