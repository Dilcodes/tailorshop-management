//events
load_supplier_registration_details_table();

$('#save').click(function () {
    validate_required_form(1);
    //save_supplier_details()--> call check after validation (209-216)
});

$('#search').keyup(function () {
    load_supplier_registration_details_table();
});

$('#reset').click(function () {
    supplier_form_reset();
});

$('#update').click(function () {
    validate_required_form(2);
    //update_supplier_details --> call check after validation (209-216)
});

$('#email').keyup(function () {
    check_email();
});

$('#contact').keyup(function () {
    check_contact();
});

//===================================================================================================================
//functions
function save_supplier_details() {
    var sname = $('#sname').val();
    var nic = $('#nic').val();
    var contact = $('#contact').val();
    var email = $('#email').val();
    var address = $('#address').val();


    var dataArray = {action: 'save_supplier_details', sname: sname, nic: nic, contact: contact, email: email, address: address}

    $.post('./model/supplier_registration_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('You Successfully Insert Data');
            supplier_form_reset();
        } else {
            alertify.error('Data insert Faild Try Again');
        }
    });
}

function load_supplier_registration_details_table() {
    console.log('load_supplier_registration_details_table');
    var search = $('#search').val();
    var tableData = "";
    var dataArray = {action: 'load_supplier_registration_details_table', search: search};

    $.post('./model/supplier_registration_model.php', dataArray, function (reply) {

        $.each(reply, function (index, value) {
            tableData += '<tr>';
            tableData += '<td>' + value.supplier_details + '</td>';
            tableData += '<td><button type="button" class="btn btn-primary select" value="' + value.supplier_id + '">Select</button><button type="button" class="btn btn-danger delete" value="' + value.supplier_id + '">Delete</button></td>';
            tableData += '</tr>';
        });
        $('#supplier_tbl tbody').html('').append(tableData);

        $('.select').click(function () {
            $('#save').addClass('d-none');
            $('#update').removeClass('d-none');
            get_supplier_details_for_update($(this).val());
        });

        $('.delete').click(function () {
            delete_supplier_details($(this).val());
        });

    }, 'json');
}

function get_supplier_details_for_update(supplier_id) {

    var dataArray = {action: 'get_supplier_details_for_update', supplier_id: supplier_id}

    $.post('./model/supplier_registration_model.php', dataArray, function (reply) {
        $.each(reply, function (index, value) {
            $('#sname').val(value.supplier_name);
            $('#contact').val(value.supplier_contact);
            $('#email').val(value.supplier_email);
            $('#address').val(value.supplier_address);
            localStorage.setItem('supplier_id', supplier_id);
        });
    }, 'json');
}

function supplier_form_reset() {
    $('#sname').val('');
    $('#contact').val('');
    $('#email').val('');
    $('#address').val('');
    load_supplier_registration_details_table();
}

function update_supplier_details() {
    var sname = $('#sname').val();
    var contact = $('#contact').val();
    var email = $('#email').val();
    var address = $('#address').val();
    var sysId = localStorage.getItem('supplier_id');

    var dataArray = {action: 'update_supplier_details', sname: sname, contact: contact, email: email, address: address, sysId: sysId}

    $.post('./model/supplier_registration_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('Sucssesfully update Data');
            supplier_form_reset();
        } else {
            alertify.error('data update Failed');
        }
    });

}

function delete_supplier_details(supplier_id) {
    alertify.confirm('Confirm Delete', 'Are You Suir You Want To Delete This Record...?', function () {
        var dataArray = {action: 'delete_supplier_details', supplier_id: supplier_id}
        $.post('./model/supplier_registration_model.php', dataArray, function (reply) {
            if (reply == 1) {
                alertify.success('Sucssesfully Delete Data');
                supplier_form_reset();
            } else {
                alertify.error('Data Delete Failed');
            }
        });
    }, function () {
        alertify.error('Cancel Delete');
    });
}

function validate_required_form(type) {
    var allOk = true;

    var sname = $('#sname').val();
    var contact = $('#contact').val();
    //var email = $('#email').val();
    //var address = $('#address').val();

    if (sname.length == 0) {
        $('#sname_msg').removeClass('d-none');
        allOk = false;
    } else {
        $('#sname_msg').addClass('d-none');
    }
    if (contact.length == 0) {
        $('#contact_msg').removeClass('d-none');
        allOk = false;
    } else {
        $('#contact_msg').addClass('d-none');
    }
    if (allOk) {
        if (type == 1) {
            save_supplier_details();
        } else {
            update_supplier_details();
        }
    }
}

function check_email() {
    var email = $('#email').val();
    if (email.length != 0) {
        ///^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
        if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,6})+$/.test(email)) {
            $('#email_msg_check').addClass('d-none');
            $('#save').prop("disabled", false);
            $('#update').prop("disabled", false);
        } else {
            $('#email_msg_check').removeClass('d-none');
            $('#save').prop("disabled", true);
            $('#update').prop("disabled", true);
        }
    } else {
        $('#email_msg_check').addClass('d-none');
        $('#save').prop("disabled", false);
        $('#update').prop("disabled", false);
    }
}

function check_contact() {
    var contact = $('#contact').val();
    var mobile = new RegExp('^(070|071|072|073|074|075|076|077|078|079)\\d{7}$');
    var land = new RegExp('^(063|025|036|055|057|065|032|011|091|033|047|051|021|067|034|081|035|037|023|066|041|054|031|052|038|027|045|026|024)\\d{7}$');
    if (contact.length == 10 && (mobile.test(contact) || land.test(contact))) {
        $('#contact_check').addClass('d-none');
        $('#save').prop("disabled", false);
        $('#update').prop("disabled", false);
    } else {
        $('#contact_check').removeClass('d-none');
        $('#save').prop("disabled", true);
        $('#update').prop("disabled", true);
    }
}
























