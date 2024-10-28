//events
load_configID();  // Load the current configuration ID
localStorage.setItem('config', '');  // Initialize local storage for config
load_rawmaterials();  // Load raw materials into the relevant dropdown
load_units();  // Load units into the relevant dropdown

// Event listener for adding a new configuration
$('#add').click(function () {
    new_config_add();
});

// Event listener for adding usage details
$('#add_usage').click(function () {
    add_usage_details();
});

// Event listener to hide the usage section
$('#cusD').click(function () {
    $('#usage_section').addClass('d-none');
});

// Event listener to show the usage section
$('#preD').click(function () {
    $('#usage_section').removeClass('d-none');
});

// Event listener to finish the configuration process with a confirmation
$('#finish').click(function () {
    alertify.confirm('Confirm Finish', 'Are You Suir Finish This Configuration...?', function () {
        configuration_finish();
        //validate_require_form();
    }, function () {
        alertify.error('Cancel Fnish');
    });
});

// Event listener to restrict input in the usage field to numeric characters
$('#usage').keyup(function () {
    var val = $(this).val();
    var floatValues = /[+-]?([0-9]*[.])?[0-9]+/;
    if (val.match(floatValues) && !isNaN(val)) {
    } else {
        $(this).focus();
        $(this).select();
        alertify.error('Can not enter Letters');
    }
});

$('#reset').click(function () {
    form_reset();
});

/*
 $('#item_name').keyup(function () {
 this.value = this.value.replace(/[^A-Za-z]/g, '');
 });
 */
//===========================================================================================
//functions
// Function to load the current configuration ID
function load_configID() {
    var dataArray = {action: 'load_configID'};
    $.post('./model/measurement_config_model.php', dataArray, function (reply) {
        $('#confID').val(reply);
        load_added_materials();
    });
}

// Validate material selection
function add_usage_details() {
    var material = $('#material').val();
    var customer_selection = $("input[name='cus_selection']:checked").val();
    var usage_define = $("input[name='usage']:checked").val();
    var usage = $('#usage').val();

    if (material == 0) {
        $('#material_msg').removeClass('d-none');
        return;
    } else {
        $('#material_msg').addClass('d-none');
    }

    // Validate usage input if customer selection and usage define conditions are met
    if (customer_selection != 1 && usage_define != 0) {
        if (usage.length == 0) {
            $('#usage_msg').removeClass('d-none');
            return;  //Exit the function if measurement is empty
        } else {
            $('#usage_msg').addClass('d-none');
        }
    }


    //validation: check if usage is empty
    var units = $('#unit_type').val();
    var dataArray = {action: 'add_usage_details', material: material, customer_selection: customer_selection, usage_define: usage_define, usage: usage, units: units};
    $.post('./model/measurement_config_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('You Successfully Added Mesurement Configuration');
            load_added_materials();
            $('#usage').val('');
            $('#usage').focus();
            // Call the load_config_tbl function to refresh the table
            //load_config_tbl();
        } else {
            alertify.error('Mesurement Configuration Process Failed');
        }
    });
}

// Function to finish the configuration with validation and confirmation
function configuration_finish() {
    var item_name = $('#item_name').val();
    var config_data = localStorage.getItem('config');
    if (item_name.length == 0) {
        $('#garment_msg').removeClass('d-none');
        return;
    } else {
        $('#garment_msg').addClass('d-none');
        var dataArray = {action: 'configuration_finish', item_name: item_name, config_data: config_data}
        $.post('./model/measurement_config_model.php', dataArray, function (reply) {
            if (reply == 1) {
                alertify.success('Successfully Completed Item Configuration');
                $('#material_tbl_msg').addClass('d-none');
                form_reset();
            } else if (reply == 10) {
                $('#material_tbl_msg').removeClass('d-none');
                alertify.error('Item Configuration Process Failed');
            } else {
                $('#material_tbl_msg').addClass('d-none');
                alertify.error('Item Configuration Process Failed');
            }
        });
    }
}

// Function to add a new configuration to the local storage
function new_config_add() {
    var config = $('#measurement').val();
    // Validation: check if measurement is empty
    if (config.length == 0) {
        $('#measurement_msg').removeClass('d-none');
        return;  //Exit the function if measurement is empty
    } else {
        $('#measurement_msg').addClass('d-none');
    }
    var added_conf = localStorage.getItem('config');
    if (added_conf.length != 0) {
        added_conf += '~' + config;
        localStorage.setItem('config', added_conf);
        load_config_tbl();  // Reload the configuration table
    } else {
        localStorage.setItem('config', config);
        load_config_tbl();  // Load the configuration table
    }
    alertify.success('You Successfully Added Mesurement');
    $('#measurement').focus();
    $('#measurement').val('');
}

// Function to load the configuration table from the local storage
function load_config_tbl() {
    var tableData = '';
    var data = localStorage.getItem('config');
    if (data.length != 0) {
        var z = data.split('~');
//        console.log(z);
        for (var i = 0; i < z.length; i++) {
            if (z[i] != "-") {
                tableData += '<tr>';
                tableData += '<td>' + z[i] + '</td>';
                tableData += '<td><button class="btn btn-danger remove" value="' + z[i] + '">Remove</button></td>';
                tableData += '</tr>';
            }
        }
        $('#config_tbl tbody').html('').append(tableData);
        // Event listener to remove a configuration entry ***********
        $('.remove').click(function () {
            var new_arry = "-";
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
            load_config_tbl(); // Reload the configuration table
        });
    } else {
        $('#config_tbl tbody').html('');
    }
}

// Function to load raw materials into the relevant dropdown
function  load_rawmaterials() {
    var dataArray = {action: 'load_rawmaterials'};
    $.post('./model/measurement_config_model.php', dataArray, function (reply) {
        $('#material').html(reply);
    });
}

// Function to load units into the relevant dropdown based on the type selected
function  load_units() {
    var type = $('#type').val();
    var dataArray = {action: 'load_units', type: type};
    $.post('./model/measurement_config_model.php', dataArray, function (reply) {
        $('#unit_type').html(reply);
    });
}

// Function to load added materials into the usage table  ********************
function load_added_materials() {
    var confID = $('#confID').val();
    var dataArray = {action: 'load_added_materials', confID: confID};
    $.post('./model/measurement_config_model.php', dataArray, function (reply) {
        $('#usage_table tbody').html(reply);
        $('.remove').click(function () {
            remove_added_material($(this).val());
        });

    });
}

// Function to reset the form and reload necessary data
function form_reset() {
    load_configID();  // Reload the configuration ID
    localStorage.setItem('config', '');   // Clear local storage config
    $('#item_name').val('');
    $('#usage').val('');
    $('#material').val(0);
    $('#measurement').val('');
    load_config_tbl();   // Reload the configuration table
}


function  remove_added_material(tbl_id) {
    var dataArray = {action: 'remove_added_material', tbl_id: tbl_id};
    $.post('./model/measurement_config_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('Sucssesfully Remove Data');
            load_added_materials();
        } else {
            alertify.error('Data Remove Fail');
        }
    });
}
