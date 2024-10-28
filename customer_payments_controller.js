//alert();
//events------------------------------------------------------------------------
load_finish_orders();

$('#payType').change(function () {
    var type = $(this).val();
    if (type == 'Card') {
        $('#card-section').removeClass('d-none');
    } else {
        $('#card-section').addClass('d-none');
    }
});

$('#search').keyup(function (e) {
    if (e.which == 13) {
        $('#sel_1').focus();
        $('#sel_1').removeClass('btn-primary');
        $('#sel_1').addClass('btn-success');
    } else {
        $('#sel_1').addClass('btn-primary');
        $('#sel_1').removeClass('btn-success');
        load_finish_orders();
    }
});

$('#received').keyup(function (e) {
    this.value = this.value.replace(/[^0-9\.]/g, '');
    var received_amt = $(this).val();
    var balance_amt = localStorage.getItem('balance');
    var customer_balance = parseFloat(received_amt) - parseFloat(balance_amt);
    if (customer_balance > 0) {
        $('#cus_balance').val(customer_balance.toFixed(2));
    } else {
        $('#cus_balance').val('0.00');
    }

    if (parseFloat(received_amt) < parseFloat(balance_amt)) {
        $('#recAmt_check_msg').removeClass('d-none');
        $('#add_payment').prop('disabled', true);
    } else {
        $('#add_payment').focus();
        $('#add_payment').removeClass('btn-primary');
        $('#add_payment').addClass('btn-success');
        $('#recAmt_check_msg').addClass('d-none');
        $('#add_payment').prop('disabled', false);
    }

    if (e.which == 13) {
        if (received_amt.length != 0) {
            if (parseFloat(received_amt) < parseFloat(balance_amt)) {
                $('#recAmt_check_msg').removeClass('d-none');
                $('#add_payment').prop('disabled', true);
            } else {
                $('#add_payment').focus();
                $('#add_payment').removeClass('btn-primary');
                $('#add_payment').addClass('btn-success');
                $('#recAmt_check_msg').addClass('d-none');
                $('#add_payment').prop('disabled', false);
            }
        }
    }
});


$('#add_payment').click(function () {
    var received_amt = $('#received').val();
    var balance_amt = localStorage.getItem('balance');
    if (received_amt.length != 0) {
        if (parseFloat(received_amt) < parseFloat(balance_amt)) {
            $('#recAmt_check_msg').removeClass('d-none');
            $('#add_payment').prop('disabled', true);
            $('#received').focus().select();
            ;
        } else {
            $('#add_payment').prop('disabled', false);
            form_required_field_validation();
        }
    }
});


/*$('#add_payment').click(function () {
 form_required_field_validation() // Check if the form is valid
 });
 */

$('#reset').click(function () {
    reset_form();
});
//functions-----------------------------------------------------
function load_finish_orders() {
    var search = $('#search').val();
    var dataArray = {action: 'load_finish_orders', search: search};
    $.post('./model/customer_payments_model.php', dataArray, function (reply) {
        $('#finish_order_tbl tbody').html('').append(reply);

        $('.select').click(function () {
            var data = $(this).val();
            data = data.split('~');
            $('#total').val(data[0]);
            $('#advanced').val(data[1]);
            $('#pay').val(data[2]);
            localStorage.setItem('balance', data[2]);
            $('#received').focus();
            $('#received').select();
            localStorage.setItem('order_id', data[3]);
        });
    });
}

function add_customer_payment() {
    var order_id = localStorage.getItem('order_id');
    var payable_amt = $('#pay').val();
    var pay_type = $('#payType').val();
    var received_amt = $('#received').val();
    var balance_amt = $('#cus_balance').val();
    var card_type = $("input[name='options']:checked").val();
    var card_reference = $('#card_ref').val();

    var dataArray = {action: 'add_customer_payment', order_id: order_id, payable_amt: payable_amt, pay_type: pay_type, received_amt: received_amt, balance_amt: balance_amt, card_type: card_type, card_reference: card_reference};

    $.post('./model/customer_payments_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('Successfully collected payment');
            setTimeout(function () {
                window.location = "./?location=order_payment&order_id=" + order_id;
            }, 500);
        } else {
            alertify.error('System Error');

        }
    });
}


function form_required_field_validation() {
    var total = $('#total').val();
    var payType = $('#payType').val();
    var received = $('#received').val();
    var isValid = true;  // Initialize a flag to track if the form is valid

    // Validate total amount
    if (total.length == 0) {
        $('#Tot_amt_msg').removeClass('d-none');  // Show error message for total amount
        isValid = false;
    } else {
        $('#Tot_amt_msg').addClass('d-none');
    }

    // Validate paytype type
    if (payType.length == 0) {
        $('#paytype_msg').removeClass('d-none');  // Show error message for pay type
        isValid = false;
    } else {
        $('#paytype_msg').addClass('d-none');
    }

    // Validate received amount
    if (received.length == 0) {
        $('#recAmtEmpty_check_msg').removeClass('d-none');
        isValid = false;
    } else {
        $('#recAmtEmpty_check_msg').addClass('d-none');
    }

    if (isValid) {
        add_customer_payment();
    }
}

function reset_form() {
    $('#total').val('');
    $('#advanced').val('');
    $('#pay').val('');
    $('#received').val('');
    $('#cus_balance').val('');
    $('#payType').val('Cash');
    $('#card-section').addClass('d-none');
}



