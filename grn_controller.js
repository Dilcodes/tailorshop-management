//events
added_items_load(); // load the initial list of added items

load_grn_number();
load_suppliers();
load_items();
// Add item button click event
$('#add_item').click(function () {
    validate_add_item(); //validate and add item when the button is clicked
});
$('#reset').click(function () {
    grn_form_reset();
});
// Finish button click event
$('#finish').click(function () {
    alertify.confirm('Confirm', 'Are You Suir You Want To Complete This GRN...?', function () {
        check_added_item_count();
    }, function () {
        alertify.error('Cancel GRN process'); // Show error if canceled
    });
});
$('#total_cost').keyup(function () {
    this.value = this.value.replace(/[^0-9\.]/g, ''); //Remove non-numeric characters
});
$('#quty').keyup(function () {
    this.value = this.value.replace(/[^0-9\.]/g, '');
});
//===========================================================================================================================
//functions

function check_added_item_count() {
    var grn_no = $('#grn_no').val();
    var dataArray = {action: 'check_added_item_count', grn_no: grn_no};
    $.post('./model/grn_model.php', dataArray, function (reply) {
        if (reply == 1) {
            validate_grn_finish();
            $('#added_item_check').addClass('d-none');
        } else {
            $('#added_item_check').removeClass('d-none');
        }
    });
}



// Load GRN number and update the input field
function load_grn_number() {
    var dataArray = {action: 'load_grn_number'};
    $.post('./model/grn_model.php', dataArray, function (reply) {
        $('#grn_no').val(reply); //Set GRN number
        load_grn_final_total(); //Load the final Total
        added_items_load(); //Load added Items
    });
}

// Load list of suppliers and update the dropdown
function load_suppliers() {
    var dataArray = {action: 'load_suppliers'};
    $.post('./model/grn_model.php', dataArray, function (reply) {
        $('#grn_supplier').html(reply); // Populate items dropdown
        chosenRefresh(); //Refresh chosen dropdown (custom dropdown plugin)
    });
}

// Load list of items and update the dropdown
function load_items() {
    var dataArray = {action: 'load_items'};
    $.post('./model/grn_model.php', dataArray, function (reply) {
        $('#grn_item').html(reply);
        chosenRefresh();
    });
}

// Add item to the GRN
function add_grn_item() {
    var grn_number = $('#grn_no').val();
    var grn_item_id = $('#grn_item').val();
    var grn_added_quty = $('#quty').val();
    var grn_total_cost = $('#total_cost').val();
    var sysId = localStorage.getItem('grn_item_tblid');
    var dataArray = {action: 'add_grn_item', grn_number: grn_number, grn_item_id: grn_item_id, grn_added_quty: grn_added_quty, grn_total_cost: grn_total_cost, sysId: sysId};
    $.post('./model/grn_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('Successfully Added Item');
            load_grn_final_total(); // Reload final total
            added_items_load(); // Reload added items
            $('#quty').val(''); // Clear quantity input
            $('#total_cost').val(''); // Clear total cost input
            $('#grn_item').focus(); // Focus on item input
        } else {
            alertify.error('Item adding failed');
        }
    });
}

// Load the final total of the GRN
function load_grn_final_total() {
    var grn_number = $('#grn_no').val();
    var dataArray = {action: 'load_grn_final_total', grn_number: grn_number}
    $.post('./model/grn_model.php', dataArray, function (reply) {
        $('#grn_total').val(reply); // Set GRN Final Total
    });
}

// Load added Items
function added_items_load() {
    var grn_number = $('#grn_no').val();
    var tableData = "";
    var dataArray = {action: 'added_items_load', grn_number: grn_number}
    $.post('./model/grn_model.php', dataArray, function (reply) {
        $.each(reply, function (index, value) {
            tableData += '<tr>';
            tableData += '<td>' + value.item_details + '</td>';
            tableData += '<td>' + value.grn_added_qty + '</td>';
            tableData += '<td>' + value.grn_total_cost_price + '</td>';
            tableData += '<td><button type="button" class="btn btn-danger delete" value="' + value.grn_item_tblid + '">Delete Item</button></td>';
            tableData += '</tr>';
        });
        $('#grn_added_itemtbl tbody').html('').append(tableData); // Populate table with items

        $('.delete').click(function () {
            delete_grn_details($(this).val()); //Delete Item
        });
    }, 'json');
}

//Reset GRN form details
function grn_form_reset() {
    $('#reservationdate').find('input').val('');
    $('#grn_supplier').val('').trigger('chosen:updated'); // If using Chosen jQuery plugin
    $('#grn_item').val('').trigger('chosen:updated'); // If using Chosen jQuery plugin
    $('#quty').val('');
    $('#total_cost').val('');
}

// Finish GRN process
function finish_grn() {
    var grn_no = $('#grn_no').val();
    var supplier = $('#grn_supplier').val();
    var grn_date = $('#grn_date').val();
    var grn_final_total = $('#grn_total').val();
    var dataArray = {action: 'finish_grn', supplier: supplier, grn_date: grn_date, grn_final_total: grn_final_total};
    $.post('./model/grn_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('Successfully Completed GRN');
            load_grn_number(); // Load new GRN number
            setTimeout(function () {
                window.location = "./?report=grn_summary&grn=" + grn_no; // Redirect to summary page
            }, 2500);
        } else {
            alertify.error('GRN Complete Process Failed');
        }
    });
}

//Delete GRN item details
function delete_grn_details(grn_item_tblid) {
    alertify.confirm('Confirm Delete', 'Are You Suir You Want To Delete This Record...?', function () {
        var dataArray = {action: 'delete_grn_details', grn_item_tblid: grn_item_tblid}
        $.post('./model/grn_model.php', dataArray, function (reply) {
            if (reply == 1) {
                alertify.success('Sucssesfully Delete Data');
                grn_form_reset(); // Reset form
            } else {
                alertify.error('Data Delete Failed');
            }
        });
    }, function () {
        alertify.error('Cancel Delete')
    });
}


function validate_add_item() {
    var allOk = true;
    var quantity = $('#quty').val();
    var totalcost = $('#total_cost').val();
    if (quantity.length == 0) {
        allOk = false;
        $('#add_quantity').removeClass('d-none');
    } else {
        $('#add_quantity').addClass('d-none');
    }
    if (totalcost.length == 0) {
        allOk = false;
        $('#add_total_cost').removeClass('d-none');
    } else {
        $('#add_total_cost').addClass('d-none');
    }

    if (allOk) {
        add_grn_item();
    }
}


function validate_grn_finish() {
    var allOk = true;
    var grn_supplier = $('#grn_supplier').val();
    var grn_date = $('#grn_date').val();
    if (grn_supplier == 0) {
        allOk = false;
        $('#grn_supplier_error').removeClass('d-none');
    } else {
        $('#grn_supplier_error').addClass('d-none');
    }

// Validate required date
    if (grn_date.length == 0) {
        allOk = false;
        $('#reservationdate_error').removeClass('d-none');
    } else {
        $('#reservationdate_error').addClass('d-none');
    }

    if (allOk) {
        finish_grn(); //Confirm and finish GRN process

    }
}

