//events

load_tailor_registration_details_table();

$('#save').click(function () {
    //save_tailor_details(); --> call check after validation
    validate_required_form(1);
});

$('#search').keyup(function () {
    load_tailor_registration_details_table();
});

$('#reset').click(function () {
    tailor_form_reset();
});

$('#update').click(function () {
    //update_tailor_details(); --> call check after validation
    validate_required_form(2);
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

//-----------------------------------------------------------------------------

//functions
function save_tailor_details() {
    var fullname = $('#fullname').val();
    var nic = $('#nic').val();
    var gender = $('input[name="gender"]:checked').val();
    var appointment_date = $('#appointment_date').val();
    var contact = $('#contact').val();
    var email = $('#email').val();
    var address = $('#address').val();
    var username = $('#username').val();
    var password = $('#password').val();

    var dataArray = {action: 'save_tailor_details', fullname: fullname, nic: nic, gender: gender, appointment_date: appointment_date, contact: contact, email: email, address: address, username: username, password: password}

    $.post('./model/tailor_registration_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('Successfully Insert Data');
            tailor_form_reset();
        } else {
            alertify.error('Data Insert Faild');
        }
    });
}

function load_tailor_registration_details_table() {
    //alert();
    var search = $('#search').val();
    var tableData = "";
    var dataArray = {action: 'load_tailor_registration_details_table', search: search};

    $.post('./model/tailor_registration_model.php', dataArray, function (reply) {
        // console.log(reply);
        $.each(reply, function (index, value) {
            tableData += '<tr>';
            tableData += '<td>' + value.tailors_detail + '</td>';
            tableData += '<td><button type="button" class="btn btn-primary select" value="' + value.tailor_id + '">Select</button> <button type="button" class="btn btn-danger delete" value="' + value.tailor_id + '">Delete</button></td>';
            tableData += '</tr>';
        });
        $('#tailor_tbl tbody').html('').append(tableData);

        $('.select').click(function () {
            $('#save').addClass('d-none');
            $('#update').removeClass('d-none');
            get_tailor_details_for_update($(this).val());
        });

        $('.delete').click(function () {
            delete_tailor_details($(this).val());
        });

    }, 'json');
}

// if select button click load details to update
function get_tailor_details_for_update(tailor_id) {
    var dataArray = {action: 'get_tailor_details_for_update', tailor_id: tailor_id}
    $.post('./model/tailor_registration_model.php', dataArray, function (reply) {
        $.each(reply, function (index, value) {
            $('#fullname').val(value.tailor_fullname);
            $('#nic').val(value.tailor_nic);

            if (value.tailor_gender == 'male') {
                $('#male').prop('checked', true);
            } else {
                $('#female').prop('checked', true);
            }

            $('#appointment_date').val(value.tailor_appointment_date);
            $('#contact').val(value.tailor_contact);
            $('#email').val(value.tailor_email);
            $('#address').val(value.tailor_address);
            localStorage.setItem('tailor_id', tailor_id);


            $('#user_log_details_section').addClass('d-none');


        });
    }, 'json');

}

function tailor_form_reset() {
    $('#fullname').val('');
    $('#nic').val('');
    $('#male').val('');
    $('#female').val('');
    //$('input[name="gender"]:checked').val('');
    $('.gender').prop('checked', false);
    $('#appointment_date').val('');
    $('#contact').val('');
    $('#email').val('');
    $('#address').val('');
    $('#username').val('');
    $('#password').val('');
    $('#cpassword').val('');
    $('#save').removeClass('d-none');
    $('#update').addClass('d-none');
    $('#search').val('');
    $('#user_log_details_section').removeClass('d-none');
    load_tailor_registration_details_table();
}

function update_tailor_details() {
    var fullname = $('#fullname').val();
    var nic = $('#nic').val();
    var gender = $('input[name="gender"]:checked').val();
    var appointment_date = $('#appointment_date').val();
    var contact = $('#contact').val();
    var email = $('#email').val();
    var address = $('#address').val();
    var username = $('#username').val();
    var password = $('#password').val();
    var cpassword = $('#cpassword').val();
    var sysId = localStorage.getItem('tailor_id');

    var dataArray = {action: 'update_tailor_details', fullname: fullname, nic: nic, gender: gender, appointment_date: appointment_date, contact: contact, email: email, address: address, username: username, password: password, cpassword: cpassword, sysId: sysId}

    $.post('./model/tailor_registration_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('Sucssesfully update Data');
            tailor_form_reset();
        } else {
            alertify.error('Data update Failed');
        }
    });
}

function delete_tailor_details(tailor_id) {
    alertify.confirm('Confirm Delete', 'Are You Suir You Want To Delete This Record...?', function () {
        var dataArray = {action: 'delete_tailor_details', tailor_id: tailor_id}
        $.post('./model/tailor_registration_model.php', dataArray, function (reply) {
            if (reply == 1) {
                alertify.success('Sucssesfully Delete Data');
                tailor_form_reset();
            } else if (reply == 2) {
                alertify.error("This tailor can't delete, Order assign details available under this tailor");
            } else {
                alertify.error('Data Delete Failed');
            }
        });
    }, function () {
        alertify.error('Cancel Delete')
    });
}

function validate_required_form(type) {
    var allOk = true;

    var fullname = $('#fullname').val();
    var nic = $('#nic').val();
    var appointment_date = $('#appointment_date').val();
    var contact = $('#contact').val();
    var username = $('#username').val();
    var password = $('#password').val();
    var cpassword = $('#cpassword').val();


    if (fullname.length == 0) {
        $('#fname_msg').removeClass('d-none');
        allOk = false;
    } else {
        $('#fname_msg').addClass('d-none');
    }

    if (nic.length == 0) {
        $('#nic_msg').removeClass('d-none');
        allOk = false;
    } else {
        $('#nic_msg').addClass('d-none');
    }

    if (appointment_date.length == 0) {
        $('#appointment_date_msg').removeClass('d-none');
        allOk = false;
    } else {
        $('#contact_msg').addClass('d-none');
    }
    if (contact.length == 0) {
        $('#contact_msg').removeClass('d-none');
        allOk = false;
    } else {
        $('#contact_msg').addClass('d-none');
    }

    if (type == 1) {
        if (username.length == 0) {
            $('#uname_msg').removeClass('d-none');
            allOk = false;
        } else {
            $('#uname_msg').addClass('d-none');
        }
    }

    if (type == 1) {
        if (password.length == 0) {
            $('#password_msg').removeClass('d-none');
            allOk = false;
        } else {
            $('#password_msg').addClass('d-none');
        }
    }

    if (type == 1) {
        if (cpassword.length == 0) {
            $('#cpsswd_msg').removeClass('d-none');
            allOk = false;
        } else {
            $('#cpsswd_msg').addClass('d-none');
        }
    }

    if (allOk) {
        if (type == 1) {
            save_tailor_details();
        } else {
            update_tailor_details();
        }
    }
}

function check_username() {
    var username = $('#username').val();

    var dataArray = {action: 'check_username', username: username}

    $.post('./model/tailor_registration_model.php', dataArray, function (reply) {
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


