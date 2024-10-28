//events
load_configID();
localStorage.setItem('config', '');
load_rawmaterials();
load_units();
$('#add').click(function () {
    new_config_add();
});
$('#add_usage').click(function () {
    add_usage_details();
});
$('#cusD').click(function () {
    $('#usage_section').addClass('d-none');
});
$('#preD').click(function () {
    $('#usage_section').removeClass('d-none');
});
$('#finish').click(function () {
    alertify.confirm('Confirm Finish', 'Are You Suir Finish This Configuration...?', function () {
        configuration_finish();
        //validate_require_form();
    }, function () {
        alertify.error('Cancel Fnish')
    });
});
//===========================================================================================
//functions
function load_configID() {
    var dataArray = {action: 'load_configID'};
    $.post('./model/measurement_config_model.php', dataArray, function (reply) {
        $('#confID').val(reply);
        load_added_materials();
    });
}

function add_usage_details() {
    var material = $('#material').val();
    var customer_selection = $("input[name='cus_selection']:checked").val();
    var usage_define = $("input[name='usage']:checked").val();
    var usage = $('#usage').val();
    var units = $('#unit_type').val();
    var dataArray = {action: 'add_usage_details', material: material, customer_selection: customer_selection, usage_define: usage_define, usage: usage, units: units};
    $.post('./model/measurement_config_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('You Successfully Added Mesurement Configuration');
            load_added_materials();
        } else {
            alertify.error('Mesurement Configuration Process Failed');
        }
    });
}

function configuration_finish() {
    var item_name = $('#item_name').val();
    var config_data = localStorage.getItem('config');
    var dataArray = {action: 'configuration_finish', item_name: item_name, config_data: config_data}
    $.post('./model/measurement_config_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('Successfully Completed Item Configuration');
            form_reset();
        } else {
            alertify.error('Item Configuration Process Failed');
        }
    });
}

function new_config_add() {
    var config = $('#measurement').val();
    var added_conf = localStorage.getItem('config');
    if (added_conf.length != 0) {
        added_conf += '~' + config;
        localStorage.setItem('config', added_conf);
        load_config_tbl();
    } else {
        localStorage.setItem('config', config);
        load_config_tbl();
    }
    alertify.success('You Successfully Added Mesurement');
    $('#measurement').focus();
    $('#measurement').val('');
}

function load_config_tbl() {
    var tableData = '';
    var data = localStorage.getItem('config');
    if (data.length != 0) {
        var z = data.split('~');
//        console.log(z);
        for (var i = 0; i < z.length; i++) {
            tableData += '<tr>';
            tableData += '<td>' + z[i] + '</td>';
            tableData += '<td><button class="btn btn-danger remove" value="' + z[i] + '">Remove</button></td>';
            tableData += '</tr>';
        }
        $('#config_tbl tbody').html('').append(tableData);
        $('.remove').click(function () {
            var new_arry = '';
            var deleted_val = $(this).val();
            var data = localStorage.getItem('config');
            var x = data.split('~');
            for (var i = 0; i < x.length; i++) {
                if (x[i] != deleted_val) {
                    if (i == 0) {
                        new_arry = x[i];
                    } else {
                        new_arry += '~' + x[i];
                    }
                }
            }
            localStorage.setItem('config', new_arry);
            load_config_tbl();
        });
    } else {
        $('#config_tbl tbody').html('');
    }
}

function  load_rawmaterials() {
    var dataArray = {action: 'load_rawmaterials'};
    $.post('./model/measurement_config_model.php', dataArray, function (reply) {
        $('#material').html(reply);
    });
}

function  load_units() {
    var type = $('#type').val();
    var dataArray = {action: 'load_units', type: type};
    $.post('./model/measurement_config_model.php', dataArray, function (reply) {
        $('#unit_type').html(reply);
    });
}

function load_added_materials() {
    var confID = $('#confID').val();
    var dataArray = {action: 'load_added_materials', confID: confID};
    $.post('./model/measurement_config_model.php', dataArray, function (reply) {
        $('#usage_table tbody').html(reply);
    });
}

function form_reset() {
    $('#item_name').val('');
    $('#usage').val('');
    $('#measurement').val('');
    load_configID();
    localStorage.setItem('config', '');
    new_config_add();
}
/*
function validate_require_form() {
    var allOk = true;
    var item_name = $('#item_name').val();
    var measurement = $('#measurement').val();
    var material = $('#material').val();
    var usage = $('#usage').val();

    if (measurement.length == 0) {
        $('#measurement_msg').removeClass('d-none');
        allOk = false;
    } else {
        $('#measurement_msg').addClass('d-none');
    }
    if (usage.length == 0) {
        $('#usage_msg').removeClass('d-none');
        allOk = false;
    } else {
        $('#usage_msg').addClass('d-none');
    }

    if (allOk) {
        configuration_finish();
    } else {
        alertify.error('Please fill the require fields');
    }
    
    return allOk;

}
*/