//events
load_suppliers();
clear_added_grn();


$('#pay_type').change(function () {
    var pay_type = $(this).val();
    if (pay_type == 1) {
        $('#bank_Ref_section').addClass('d-none');
        $('#check_Ref_section').addClass('d-none');
    } else if (pay_type == 2) {
        $('#bank_Ref_section').addClass('d-none');
        $('#check_Ref_section').removeClass('d-none');
    } else {
        $('#bank_Ref_section').removeClass('d-none');
        $('#check_Ref_section').addClass('d-none');
    }


});

$('#supplier').change(function () {
    load_avilable_grns();
});

$('#add_grn').click(function () {
    add_grn_for_payments();
});

$('#add_payment').click(function () {
    add_payment();
});

$('#reset').click(function () {
    reset_form();
});

//functions---------------------------------------------------------------------

function load_suppliers() {
    var dataArray = {action: 'load_suppliers'};
    $.post('./model/grn_model.php', dataArray, function (reply) {
        $('#supplier').html(reply);  // Populate items dropdown
        chosenRefresh();  //Refresh chosen dropdown (custom dropdown plugin)
    });
}

function load_avilable_grns() {
    var supplier_id = $('#supplier').val();
    var dataArray = {action: 'load_avilable_grns', supplier_id: supplier_id};
    $.post('./model/supplier_payments_model.php', dataArray, function (reply) {
        $('#grn').html(reply);  // Populate items dropdown
    });
}

function add_grn_for_payments() {
    var selected_grn = $('#grn').val();
    var dataArray = {action: 'add_grn_for_payments', selected_grn: selected_grn};
    $.post('./model/supplier_payments_model.php', dataArray, function (reply) {
        if (reply == 1) {
            load_added_grn_for_payments();
        } else {
            alertify.error('GRN Adding Fail');
        }
    });
}

function load_added_grn_for_payments() {
    var dataArray = {action: 'load_added_grn_for_payments'};
    $.post('./model/supplier_payments_model.php', dataArray, function (reply) {
        reply = reply.split('~');
        $('#selected_grn').html(reply[0]);
        $('#tot_amount').val(reply[1]);
        localStorage.setItem('payGRNqunt', reply[2]);
        localStorage.setItem('tot_amount', reply[1]);
        if (reply[2] == 1) {
            $('#tot_amount').attr('readonly', false);
        } else {
            $('#tot_amount').attr('readonly', true);
        }
    });
}

function add_payment() {
    var supplier_id = $('#supplier').val();
    var selected_grn = $('#selected_grn').val();
    var total_payable_amt = $('#tot_amount').val();
    var pay_types = $('#pay_type').val();

    var payGrnQnt = localStorage.getItem('payGRNqunt');
    var tot = localStorage.getItem('tot_amount');
    var balance = parseFloat(tot) - parseFloat(total_payable_amt);

    var reference = "";
    var cheque_date = "";
    var cheque_number = "";

    if (pay_types == 1) {
        reference = "";
        cheque_date = "";
        cheque_number = "";
    } else if (pay_types == 2) {
        cheque_date = $('#cheque_date').val();
        cheque_number = $('#cheque_number').val();
    } else {
        reference = $('#ref_number').val();
    }

    var dataArray = {action: 'add_payment', supplier_id: supplier_id, selected_grn: selected_grn, total_payable_amt: total_payable_amt, pay_types: pay_types, reference: reference, cheque_date: cheque_date, cheque_number: cheque_number, payGrnQnt: payGrnQnt, balance: balance};
    $.post('./model/supplier_payments_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('Payment Successfully Added');
            reset_form();
        } else {
            alertify.error('Payment Adding Process Failed');
        }
    });
}

function clear_added_grn() {
    var dataArray = {action: 'clear_added_grn'};
    $.post('./model/supplier_payments_model.php', dataArray, function (reply) {

    });
}

function reset_form() {
    load_suppliers();
    clear_added_grn();
    $('#selected_grn').html('');
    $('#grn').html('');
    $('#tot_amount').val('');
}