//events
load_user_selectbox();

$('#users').change(function () {
    load_available_privileges();
    load_assigned_privileges();

});

$('#custom_add').click(function () {
    custom_add_privileges();
});

$('#all_add').click(function () {
    allprivileges_add();
});

$('#custom_remove').click(function () {
    custom_remove_privileges();
});

$('#all_remove').click(function () {
    all_privileges_remove();
});
//==============================================================================

//functions
function load_user_selectbox() {
    var options = "";
    var dataArray = {action: 'load_user_selectbox'}; // Data to be sent to the server
    $.post('./model/user_privilege_model.php', dataArray, function (reply) {  // POST request to server
        options += '<option>Select a User</option>';
        $.each(reply, function (index, value) {  // Loop through the response
            options += '<option value="' + value.system_user_id + '">' + value.user_details + '</option>';  // Add each user as an option
        });
        $('#users').html('').append(options);  // Update the select box with the options
    }, 'json');  // Specify the response format
}

function load_available_privileges() {
    var options = '';
    var userId = $('#users').val();  // Get the selected user ID
    var dataArray = {action: 'load_available_privileges', userId: userId};
    $.post('./model/user_privilege_model.php', dataArray, function (reply) {
        $.each(reply, function (index, value) {
            options += '<option value="' + value.privilage_id + '~' + value.privilage_type + '">' + value.privilage_name + '</option>';  // Add each privilege as an option
        });
        $('#aval_pri').html('').append(options);  // Update the select box with the options
    }, 'json');
}

function load_assigned_privileges() {
    var options = '';
    var userId = $('#users').val();
    var dataArray = {action: 'load_assigned_privileges', userId: userId}
    $.post('./model/user_privilege_model.php', dataArray, function (reply) {
        $.each(reply, function (index, value) {
            options += '<option value="' + value.assigned_privilage_id + '">' + value.privilage_name + '</option>';
        });
        $('#assign_pri').html('').append(options);
    }, 'json');
}

function form_reset() {
    load_assigned_privileges();  // Reload assigned privileges
    load_available_privileges();  // Reload available privileges
}

function custom_add_privileges() {
    var userId = $('#users').val();  // Get the selected user ID
    var selected_privilege = $('#aval_pri').val();  // Get the selected privilege
    //alert(selected_privilege)
    var dataArray = {action: 'custom_add_privileges', userId: userId, selected_privilege: selected_privilege};
    $.post('./model/user_privilege_model.php', dataArray, function (reply) {
        if (reply == 1) {   // Check if the response indicates success
            alertify.success('Successfully Privileges Assign');
            form_reset();  //reset the form
        } else {
            alertify.error('Privilege Assign Fail');
        }
    });
}

function allprivileges_add() {
    alertify.confirm('Confirm All Privileges Add', 'Are You Suir You Want To  All Add  Privileges...?', function () {
        var userId = $('#users').val();
        //alert(selected_privilege)
        var dataArray = {action: 'allprivileges_add', userId: userId}
        $.post('./model/user_privilege_model.php', dataArray, function (reply) {
            if (reply == 1) {
                alertify.success('Successfully privileges assign');
                form_reset();
            } else {
                alertify.error('Privilege Assign Fail');
            }
        });
    }, function () {
        alertify.error('Cancel All Add Privileges');
    });



}

/*
 function allprivileges_add() {
 var userId = $('#users').val();
 //alert(selected_privilege)
 var dataArray = {action: 'allprivileges_add', userId: userId}
 $.post('./model/user_privilege_model.php', dataArray, function (reply) {
 if (reply == 1) {
 alertify.success('Successfully privileges assign');
 form_reset();
 } else {
 alertify.error('Privilege Assign Fail');
 }
 });
 }
 */

function custom_remove_privileges() {
    var userId = $('#users').val();
    var selected_privilege = $('#assign_pri').val();
    //alert(selected_privilege)
    var dataArray = {action: 'custom_remove_privileges', userId: userId, selected_privilege: selected_privilege}
    $.post('./model/user_privilege_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('Successfully privileges Remove');
            form_reset();
        } else {
            alertify.error('Privilege Remove Fail');
        }
    });
}

function all_privileges_remove() {
    alertify.confirm('Confirm All Remove', 'Are You Suir You Want To Remove All Assigned  Privileges...?', function () {
        var userId = $('#users').val();
        //alert(selected_privilege)
        var dataArray = {action: 'all_privileges_remove', userId: userId};
        $.post('./model/user_privilege_model.php', dataArray, function (reply) {
            if (reply == 1) {
                alertify.success('Successfully all privileges Remove');
                form_reset();
            } else {
                alertify.error('All Privilege Remove Fail');
            }
        });
    }, function () {
        alertify.error('Cancel Remove All Privileges');
    });
}

/*
 function all_privileges_remove() {
 var userId = $('#users').val();
 //alert(selected_privilege)
 var dataArray = {action: 'all_privileges_remove', userId: userId}
 $.post('./model/user_privilege_model.php', dataArray, function (reply) {
 if (reply == 1) {
 alertify.success('Successfully all privileges Remove');
 form_reset();
 } else {
 alertify.error('All Privilege Remove Fail');
 }
 });
 }  
 
 */