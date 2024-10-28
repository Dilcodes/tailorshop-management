//events
load_customer_registration_details_table();

$('#save').click(function () {
    validate_required_form(1);
    //save_customer_details()--> call check after validation (209-216)
});

$('#search').keyup(function () {
    load_customer_registration_details_table();
});

$('#reset').click(function () {
    customer_form_reset();
});

$('#update').click(function () {
    validate_required_form(2);
    //update_customer_details --> call check after validation (209-216)
});

$('#username').keyup(function () {
    check_username();
});

$('#cpassword').keyup(function () {
    check_password();
});

$('#nic').keyup(function () {
    validate_nic();
});

$('#email').keyup(function () {
    check_email();
});

$('#contact').keyup(function () {
    check_contact();
});

//===================================================================================================================
//functions
function save_customer_details() {
    var fullname = $('#fullname').val();
    var nic = $('#nic').val();
    var contact = $('#contact').val();
    var email = $('#email').val();
    var address = $('#address').val();
    var username = $('#username').val();
    var password = $('#password').val();
    //var cpassword = $('#cpassword').val();

    var dataArray = {action: 'save_customer_details', fullname: fullname, nic: nic, contact: contact, email: email, address: address, username: username, password: password}

    $.post('./model/customer_registration_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('You Successfully Insert Data');
            customer_form_reset();
        } else {
            alertify.error('Data insert Faild Try Again');
        }
    });
}

function load_customer_registration_details_table() {
    console.log('load_customer_registration_details_table');
    var search = $('#search').val();
    var tableData = "";
    var dataArray = {action: 'load_customer_registration_details_table', search: search};

    $.post('./model/customer_registration_model.php', dataArray, function (reply) {

        $.each(reply, function (index, value) {
            tableData += '<tr>';
            tableData += '<td>' + value.cust_details + '</td>';
            tableData += '<td><button type="button" class="btn btn-primary select" value="' + value.customer_id + '">Select</button><button type="button" class="btn btn-danger delete" value="' + value.customer_id + '">Delete</button></td>';
            tableData += '</tr>';
        });
        $('#customer_tbl tbody').html('').append(tableData);

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

function get_customer_details_for_update(customer_id) {

    var dataArray = {action: 'get_customer_details_for_update', customer_id: customer_id}

    $.post('./model/customer_registration_model.php', dataArray, function (reply) {
        $.each(reply, function (index, value) {
            $('#fullname').val(value.customer_fullname);
            $('#nic').val(value.customer_nic);
            $('#contact').val(value.customer_contact);
            $('#email').val(value.customer_email);
            $('#address').val(value.customer_address);
            $('#username').val(value.customer_username);
            localStorage.setItem('customer_id', customer_id);
        });
    }, 'json');
}

function customer_form_reset() {
    $('#fullname').val('');
    $('#nic').val('');
    $('#contact').val('');
    $('#email').val('');
    $('#address').val('');
    $('#username').val('');
    $('#password').val('');
    $('#cpassword').val('');
    $('#save').removeClass('d-none');
    $('#update').addClass('d-none');
    $('#search').val('');
    load_customer_registration_details_table();
}

function update_customer_details() {
    var fullname = $('#fullname').val();
    var nic = $('#nic').val();
    var contact = $('#contact').val();
    var email = $('#email').val();
    var address = $('#address').val();
    var username = $('#username').val();
    var password = $('#password').val();
    var cpassword = $('#cpassword').val();
    var sysId = localStorage.getItem('customer_id');

    var dataArray = {action: 'update_customer_details', fullname: fullname, nic: nic, contact: contact, email: email, address: address, username: username, password: password, cpassword: cpassword, sysId: sysId}

    $.post('./model/customer_registration_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('Sucssesfully update Data');
            customer_form_reset();
        } else {
            alertify.error('data update Failed');
        }
    });

}

function delete_customer_details(customer_id) {
    alertify.confirm('Confirm Delete', 'Are You Suir You Want To Delete This Record...?', function () {
        var dataArray = {action: 'delete_customer_details', customer_id: customer_id};
        $.post('./model/customer_registration_model.php', dataArray, function (reply) {
            if (reply == 1) {
                alertify.success('Sucssesfully Delete Data');
                customer_form_reset();
            } else if (reply == 2) {
                alertify.error("This Customer can't delete, Order assign details available under this customer");
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

    var fullname = $('#fullname').val();
    // var nic = $('#nic').val();
    var contact = $('#contact').val();


    if (fullname.length == 0) {
        $('#fname_msg').removeClass('d-none');
        allOk = false;
    } else {
        $('#fname_msg').addClass('d-none');
    }
    /*if (nic.length == 0) {
     $('#nic_msg').removeClass('d-none');
     allOk = false;
     } else {
     $('#nic_msg').addClass('d-none');
     } */
    if (contact.length == 0) {
        $('#contact_msg').removeClass('d-none');
        allOk = false;
    } else {
        $('#contact_msg').addClass('d-none');
    }

    if (allOk) {
        if (type == 1) {
            save_customer_details();
        } else {
            update_customer_details();
        }
    }
}

function check_username() {
    var username = $('#username').val();
    var dataArray = {action: 'check_username', username: username}
    $.post('./model/customer_registration_model.php', dataArray, function (reply) {
        if (reply == 1) {
            $('#uname_check').removeClass('d-none');
            $('#save').prop('disabled', true);
        } else {
            $('#uname_check').addClass('d-none');
            $('#save').prop('disabled', false);
        }
    });
}

function check_password() {
    var password = $('#password').val();
    var cpassword = $('#cpassword').val();
    if (password != cpassword) {
        $('#password_check').removeClass('d-none');
        $('#save').prop('disabled', true);
    } else {
        $('#password_check').addClass('d-none');
        $('#save').prop('disabled', false);
    }
}

function validate_nic() {
    var nic = $('#nic').val();
    if (nic.length != 0) {
        var old_nic = new RegExp('^[0-9]{9}[V]$');
        var new_nic = new RegExp('^[0-9]{12}$');
        if (nic.length == 10 && old_nic.test(nic)) {
            $('#nic_msg_check').addClass('d-none');
            $('#save').prop("disabled", false);
        } else if (nic.length == 12 && new_nic.test(nic)) {
            $('#nic_msg_check').addClass('d-none');
            $('#save').prop("disabled", false);
        } else {
            $('#nic_msg_check').removeClass('d-none');
            $('#save').prop("disabled", true);
        }
    } else {
        $('#nic_msg_check').addClass('d-none');
        $('#save').prop("disabled", false);
    }
}

function check_email() {
    var email = $('#email').val();
    if (email.length != 0) {
        ///^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
        if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,6})+$/.test(email)) {
            $('#email_msg_check').addClass('d-none');
            $('#save').prop("disabled", false);
        } else {
            $('#email_msg_check').removeClass('d-none');
            $('#save').prop("disabled", true);
        }
    } else {
        $('#email_msg_check').addClass('d-none');
        $('#save').prop("disabled", false);
    }
}

function check_contact() {
    var contact = $('#contact').val();
    var mobile = new RegExp('^(070|071|072|073|074|075|076|077|078|079)\\d{7}$');
    var land = new RegExp('^(063|025|036|055|057|065|032|011|091|033|047|051|021|067|034|081|035|037|023|066|041|054|031|052|038|027|045|026|024)\\d{7}$');
    if (contact.length == 10 && (mobile.test(contact) || land.test(contact))) {
        $('#contact_check').addClass('d-none');
        $('#save').prop("disabled", false);
    } else {
        $('#contact_check').removeClass('d-none');
        $('#save').prop("disabled", true);
    }
}

























