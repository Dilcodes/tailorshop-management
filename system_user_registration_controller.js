//events
// Initializing the system user registration table on page load
load_system_user_registration_details_table();

// Event listeners
$('#save').click(function () {
    validate_required_form(1);  // validate from before saving
    //save_system_user_details()---> call check after validation 
});

$('#search').keyup(function () {
    load_system_user_registration_details_table();  // Reload table on search input
});

$('#reset').click(function () {
    system_user_form_reset();  // reset the form fields
});

$('#update').click(function () {
    validate_required_form(2);  // Validate form before updating
});

$('#username').keyup(function () {
    check_username();  // Check username availability
});

$('#cpassword').keyup(function () {
    check_password();  // Validate password confirmation
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

//==============================================================================
//functions
// Function to save system user details
function save_system_user_details() {
    var fullname = $('#fullname').val();
    var nic = $('#nic').val();
    var contact = $('#contact').val();
    var email = $('#email').val();
    var address = $('#address').val();
    var username = $('#username').val();
    var password = $('#password').val();
    //var cpassword = $('#cpassword').val();

    var dataArray = {action: 'save_system_user_details', fullname: fullname, nic: nic, contact: contact, email: email, address: address, username: username, password: password}

    $.post('./model/system_user_registration_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('You Successfully Insert Data');
            system_user_form_reset();  //Reset form after successful save
        } else {
            alertify.error('Data insert Faild Try Again');
        }
    });
}

// Function to load system user registration details table
function load_system_user_registration_details_table() {
    var search = $('#search').val();
    var tableData = "";
    var dataArray = {action: 'load_system_user_registration_details_table', search: search};
    $.post('./model/system_user_registration_model.php', dataArray, function (reply) {
        $.each(reply, function (index, value) {
            tableData += '<tr>';
            tableData += '<td>' + value.Sys_uder_details + '</td>';
            tableData += '<td><button type="button" class="btn btn-primary select" value="' + value.system_user_id + '">Select</button><button type="button" class="btn btn-danger delete" value="' + value.system_user_id + '">Delete</button></td>';
            tableData += '</tr>';
        });
        $('#system_user_tbl tbody').html('').append(tableData);

        $('.select').click(function () {
            $('#save').addClass('d-none');
            $('#password_section').addClass('d-none');
            $('#update').removeClass('d-none');
            get_System_user_details_for_update($(this).val());  //Load user details for update
        });

        $('.delete').click(function () {
            delete_system_user_details($(this).val()); //Delete user record
        });

    }, 'json');
}

// Function to get system user details for update
function get_System_user_details_for_update(system_user_id) {

    var dataArray = {action: 'get_System_user_details_for_update', system_user_id: system_user_id}

    $.post('./model/system_user_registration_model.php', dataArray, function (reply) {
        $.each(reply, function (index, value) {
            $('#fullname').val(value.system_user_fullname);
            $('#nic').val(value.system_user_nic);
            $('#contact').val(value.system_user_contact);
            $('#email').val(value.system_user_email);
            $('#address').val(value.system_user_address);
            $('#username').val(value.system_user_username);
            localStorage.setItem('system_user_id', system_user_id);
        });
    }, 'json');
}

//Function to rest form
function system_user_form_reset() {
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
    load_system_user_registration_details_table();
    $('#password_section').removeClass('d-none');
}

// Function to update system user details
function update_system_user_details() {
    var fullname = $('#fullname').val();
    var nic = $('#nic').val();
    var contact = $('#contact').val();
    var email = $('#email').val();
    var address = $('#address').val();
    var username = $('#username').val();
    var password = $('#password').val();
    var cpassword = $('#cpassword').val();
    var sysId = localStorage.getItem('system_user_id');

    var dataArray = {action: 'update_system_user_details', fullname: fullname, nic: nic, contact: contact, email: email, address: address, username: username, password: password, cpassword: cpassword, sysId: sysId}

    $.post('./model/system_user_registration_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('Sucssesfully update Data');
            system_user_form_reset(); // Reset form after successful update
        } else {
            alertify.error('data update Failed');
        }
    });

}

// Function to delete system user details
function delete_system_user_details(system_user_id) {
    alertify.confirm('Confirm Delete', 'Are You Suir You Want To Delete This Record...?', function () {
        var dataArray = {action: 'delete_system_user_details', system_user_id: system_user_id}
        $.post('./model/system_user_registration_model.php', dataArray, function (reply) {
            if (reply == 1) {
                alertify.success('Sucssesfully Delete Data');
                system_user_form_reset();  // Reset form after successful delete
            } else {
                alertify.error('Data Delete Failed');
            }
        });
    }, function () {
        alertify.error('Cancel Delete')
    });
}

// Function to validate the required form fields
function validate_required_form(type) {
    var allOk = true;

    var fullname = $('#fullname').val();
    var nic = $('#nic').val();
    var contact = $('#contact').val();
    var username = $('#username').val();
    var password = $('#password').val();

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
    if (contact.length == 0) {
        $('#contact_msg').removeClass('d-none');
        allOk = false;
    } else {
        $('#contact_msg').addClass('d-none');
    }
    if (username.length == 0) {
        $('#uname_msg').removeClass('d-none');
        allOk = false;
    } else {
        $('#uname_msg').addClass('d-none');
    }
    if (type == 1) {
        if (password.length == 0) {
            $('#password_msg').removeClass('d-none');
            allOk = false;
        } else {
            $('#password_msg').addClass('d-none');
        }
    }

    if (allOk) {
        if (type == 1) {
            save_system_user_details();  // Save details if validation passes
        } else {
            update_system_user_details(); // Update details if validation passes
        }
    }
}

// Function to check username availability
function check_username() {
    var username = $('#username').val();

    var dataArray = {action: 'check_username', username: username};

    $.post('./model/system_user_registration_model.php', dataArray, function (reply) {
        if (reply == 1) {
            $('#uname_check').removeClass('d-none');
            $('#save').prop('disabled', true);
        } else {
            $('#uname_check').addClass('d-none');
            $('#save').prop('disabled', false);
        }
    });
}

// Function to validate password confirmation
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

// Function to validate NIC
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

// Function to validate email
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

// Function to validate contact number
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

