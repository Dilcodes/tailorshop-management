//events------------------------------------------------------------------------
load_expenses_categories();

$('#add').click(function () {
    validate_required_form(1);
    //add_expense_details();
});

$('#amount').keyup(function () {
    this.value = this.value.replace(/[^0-9\.]/g, '');  //Remove non-numeric characters
});

$('#category').change(function () {
    load_added_expenses_details();
});

$('#month').on('keypress', function (e) {
    if (e.which == 13) {
        load_added_expenses_details();
    }
});

$('#search').keyup(function () {
    //load_expenses_categories();
    load_added_expenses_details();
});

$('#reset').click(function () {
    reset_form();
});

//funtions----------------------------------------------------------------------
function load_expenses_categories() {
    //var search = $('#search').val(); ????????????????????????????????????
    var dataArray = {action: 'load_expenses_categories'};
    $.post('./model/expenses_model.php', dataArray, function (reply) {
        $('#category').html(reply);
    });
}

function add_expense_details() {
    var category = $('#category').val();
    var amount = $('#amount').val();
    var description = $('#description').val();
    var date = $('#date').val();
    var dataArray = {action: 'add_expense_details', category: category, amount: amount, description: description, date: date};
    $.post('./model/expenses_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('Successfully Added Expenses Details');
            load_added_expenses_details();
        } else {
            alertify.error('System Error');

        }

    });

}

function load_added_expenses_details() {
    var search = $('#search').val();
    var category = $('#category').val();
    var month = $('#month').val();
    var dataArray = {action: 'load_added_expenses_details', category: category, month: month, search: search};
    $.post('./model/expenses_model.php', dataArray, function (reply) {
        $('#expense_detail_tbl tbody').html(reply);

        // Bind the delete button event handler using event delegation
        $('.delete').click(function () {
            delete_expenses_details($(this).val());
        });

    });
}

//**************************************************************
/*
 function load_added_expenses_details() {
 var search = $('#search').val();
 var category = $('#category').val();
 var month = $('#month').val();
 var tableData = "";
 var dataArray = {action: 'load_added_expenses_details', category: category, month: month, search:search};
 
 $.post('./model/expenses_model.php', dataArray, function (reply) {
 
 $.each(reply, function (index, value) {
 tableData += '<tr>';
 tableData += '<td>' + value.exp_amount + '</td>';
 tableData += '<td>' + value.exp_description + '</td>';
 tableData += '<td>' + value.exp_issue_date + '</td>';
 tableData += '<td><button type="button" class="btn btn-primary select" value="' + value.exp_id + '">Select</button><button type="button" class="btn btn-danger delete" value="' + value.customer_id + '">Delete</button></td>';
 tableData += '</tr>';
 });
 $('#expense_detail_tbl tbody').html('').append(tableData);
 
 $('.select').click(function () {
 $('#save').addClass('d-none');
 $('#update').removeClass('d-none');
 get_customer_details_for_update($(this).val());
 });
 
 $('.delete').click(function () {
 delete_customer_details($(this).val());
 });
 
 }, 'json');
 }
 */
//************************************************************
function validate_required_form(type) {
    var allOk = true;

    var category = $('#category').val();
    var amount = $('#amount').val();
    var description = $('#description').val();
    var date = $('#date').val();

    if (category == "0") {
        $('#category_msg').removeClass('d-none');
        allOk = false;
    } else {
        $('#category_msg').addClass('d-none');
    }
    if (amount.length == 0) {
        $('#amount_msg').removeClass('d-none');
        allOk = false;
    } else {
        $('#amount_msg').addClass('d-none');
    }
    if (description.length == 0) {
        $('#description_msg').removeClass('d-none');
        allOk = false;
    } else {
        $('#description_msg').addClass('d-none');
    }
    if (date.length == 0) {
        $('#date_msg').removeClass('d-none');
        allOk = false;
    } else {
        $('#date_msg').addClass('d-none');
    }
    if (allOk) {
        if (type == 1) {
            add_expense_details();
        }
    }
}

function delete_expenses_details(exp_id) {
    //alert(exp_id);
    alertify.confirm('Confirm Delete', 'Are You Suir You Want To Delete This Record...?', function () {
        var dataArray = {action: 'delete_expenses_details', exp_id: exp_id};
        $.post('./model/expenses_model.php', dataArray, function (reply) {
            if (reply == 1) {
                alertify.success('Sucssesfully Delete Data');
                load_added_expenses_details();  // Reload the data after deletion();
            } else {
                alertify.error('Data Delete Failed');
            }
        });
    }, function () {
        alertify.error('Cancel Delete');
    });
}

function reset_form() {
   // load_suppliers();
   // clear_added_grn();
    $('#category').val(0);
    $('#amount').val('');
    $('#description').val('');
    $('#date').val('');
}