//events
load_item_category(1);
load_current_stock(1, 0);

$('#search').keyup(function () {
    load_current_stock(0, 0);
});

$('#category').change(function () {
    load_current_stock(0, $(this).val());
});

$('#tools').click(function () {
    if ($('#tools').is(':checked')) {
        load_item_category(2);
        load_current_stock(2, 0);
        setTimeout(function () {
            $('#reorder_th').addClass('d-none');
            $('.reorder_th').addClass('d-none');
        }, 250);
    }
});

$('#materials').click(function () {
    if ($('#materials').is(':checked')) {
        load_item_category(1);
        load_current_stock(1, 0);
        setTimeout(function () {
            $('#reorder_th').removeClass('d-none');
            $('.reorder_th').removeClass('d-none');
        }, 250);
    }
});

/*
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
 */

//==============================================================================
//functions
function load_current_stock(type, cat_id) {
    if (type == 0) {
        if ($('#materials').is(':checked')) {
            type = 1;
        } else {
            type = 2;
        }
    }
    var search = $('#search').val();
    var tableData = "";
    var dataArray = {action: 'load_current_stock', search: search, type: type, cat_id: cat_id};
    $.post('./model/view_stock_model.php', dataArray, function (reply) {
        $.each(reply, function (index, value) {
            index++;
            tableData += '<tr>';
            tableData += '<td>' + index + '</td>';
            tableData += '<td>' + value.item_category_name + '</td>';
            tableData += '<td>' + value.item_code + '</td>';
            tableData += '<td>' + value.item_name + '</td>';
            tableData += '<td style="text-align: right; padding-right: 40px;" class="reorder_th">' + value.item_reorder_level + '</td>';
            tableData += '<td style="text-align: right; padding-right: 40px;">' + value.grn_avilable_qty + '</td>';
            tableData += '</tr>';
        });
        $('#view_tbl tbody').html('').append(tableData);
    }, 'json');
}

function load_item_category(type) {
    var dataArray = {action: 'load_item_category', type: type};
    $.post('./model/view_stock_model.php', dataArray, function (reply) {
        $('#category').html(reply);
    });
}
