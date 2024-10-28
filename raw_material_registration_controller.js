//events
load_units(0);
load_categories(0);
load_raw_material_details_table();

// Initial prefix setting based on selected type
update_material_code_prefix();

$('#save_category').click(function () {
    add_new_category();
});

// ***************** prefix RM- and TL- **********************
// When the type dropdown value changes
$('#type').change(function () {
    load_categories(0);  // Load relevant categories
    load_units(0);  // Load relevant units
    update_material_code_prefix();  // Update the material code prefix based on the selected type
});
// When the user types in the material code input field
$('#material_code').on('input', function () {
    enforce_prefix();  // Ensure the prefix remains intact
    convert_to_uppercase(); // Convert the input to uppercase
});
// ************************************************************

$(document).ready(function () {
    $('#type').change(function () {
        if ($(this).val() != "0") {
            $('#additem').prop('disabled', false);
        } else {
            $('#additem').prop('disabled', true);
        }
    });
});

$(document).ready(function () {
    $('#type').change(function () {
        if ($(this).val() != "0") {
            $('#addunit').prop('disabled', false);
        } else {
            $('#addunit').prop('disabled', true);
        }
    });
});

$(document).ready(function () {
    $('#type').change(function () {
        if ($(this).val() == "2") {
            $('#reorder_level_area').hide();
            //$('#reorder_level_area').addClass('d-none');
        } else {
            $('#reorder_level_area').show();
            //$('#reorder_level_area').removeClass('d-none');
        }
    });
});
//***********************************************************************


$('#save_unit').click(function () {
    add_new_measurement();
});

$('#save').click(function () {
    if (validate_required_form_type()) {
        save_raw_material_details();
    } else {
        alertify.error('All Required Fields Must be Fill');
    }
});

$('#search').keyup(function () {
    load_raw_material_details_table();
});

$('#reset').click(function () {
    raw_material_form_reset();
});

$('#update').click(function () {
    if (validate_required_form_type()) {
        update_raw_material_details();
    } else {
        alertify.error('All Required Fields Must be Fill');

    }
});

//==============================================================================
//functions
function add_new_category() {
    var category = $('#new_category').val();
    var type = $('#type').val();
    var dataArray = {action: 'add_new_category', category: category, type: type};
    $.post('./model/raw_material_registration_model.php', dataArray, function (reply) {
        if (reply == 1) {
            //alert("OK");
            alertify.success('Successfully Added category');
            load_categories(0);
            $('#category_model').modal('toggle');  //add measurement then hide message box
        } else {
            //alert("Fail");
            alertify.error('Insert Category Failed');
        }
    });
}

function  load_categories(selected) {
    var type = $('#type').val();
    var dataArray = {action: 'load_categories', type: type, selected: selected};
    $.post('./model/raw_material_registration_model.php', dataArray, function (reply) {
        $('#category').html(reply);
    });
}

function add_new_measurement() {
    var type = $('#type').val();
    var unit = $('#unit').val();
    var dataArray = {action: 'add_new_measurement', unit: unit, type: type};
    $.post('./model/raw_material_registration_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('Successfully Added measurement');
            load_units(0);
            $('#measurement_model').modal('toggle');  //add measurement then hide message box
        } else {
            alertify.error('Insert Mesurement Failed');
        }
    });
}

function  load_units(selected) {
    var type = $('#type').val();
    var dataArray = {action: 'load_units', type: type, selected: selected};
    $.post('./model/raw_material_registration_model.php', dataArray, function (reply) {
        $('#unit_type').html(reply);
    });
}

function save_raw_material_details() {
    var category = $('#category').val();
    var name = $('#name').val();
    var material_code = $('#material_code').val();
    var description = $('#description').val();
    var unit_type = $('#unit_type').val();
    var reorder_level = $('#reorder_level').val();
    var dataArray = {action: 'save_raw_material_details', category: category, name: name, material_code: material_code, description: description, unit_type: unit_type, reorder_level: reorder_level};

    $.post('./model/raw_material_registration_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('You Successfully Insert Data');
            raw_material_form_reset();
        } else {
            alertify.error('Data insert Faild Try Again');
        }
    });
}

function load_raw_material_details_table() {
    console.log('load_raw_material_details_table');
    var search = $('#search').val();
    var tableData = "";
    var dataArray = {action: 'load_raw_material_details_table', search: search};
    $.post('./model/raw_material_registration_model.php', dataArray, function (reply) {

        $.each(reply, function (index, value) {
            tableData += '<tr>';
            tableData += '<td>' + value.m_details + '</td>';
            tableData += '<td>' + value.measure_unit_name + '</td>';
            tableData += '<td>' + value.item_reorder_level + '</td>';
            tableData += '<td><button type="button" class="btn btn-primary select" value="' + value.item_id + '">Select</button><button type="button" class="btn btn-danger delete" value="' + value.item_id + '">Delete</button></td>';
            tableData += '</tr>';
        });
        $('#raw_material_tbl tbody').html('').append(tableData);
        $('.select').click(function () {
            $('#save').addClass('d-none');
            $('#update').removeClass('d-none');

            $('#additem').prop('disabled', false);
            $('#addunit').prop('disabled', false);

            get_raw_material_details_for_update($(this).val());
        });

        $('.delete').click(function () {
            delete_raw_material_details($(this).val());
        });

    }, 'json');
}
//????????????????????????????????????????????????????????????????????????????????????????
function get_raw_material_details_for_update(item_id) {
    var dataArray = {action: 'get_raw_material_details_for_update', item_id: item_id};
    $.post('./model/raw_material_registration_model.php', dataArray, function (reply) {
        $.each(reply, function (index, value) {
            $('#type').val(value.item_category_type);
            load_categories(value.item_category_id);
//            $('#category').val(value.item_category_id);
            $('#name').val(value.item_name);
            $('#material_code').val(value.item_code);
            $('#description').val(value.item_description);
            load_units(value.item_messure);
            // $('#unit_type').val(value.item_messure);
            $('#reorder_level').val(value.item_reorder_level);
            localStorage.setItem('item_id', item_id);
        });
    }, 'json');
}

function raw_material_form_reset() {
    $('#type').val(0);
    $('#category').val(0);
    $('#name').val('');
    $('#material_code').val('');
    $('#description').val('');
    $('#unit_type').val(0);
    $('#reorder_level').val('');
    $('#save').removeClass('d-none');
    $('#update').addClass('d-none');
    $('#search').val('');
    // $('#type_msg').addClass('d-none');
    //$('#category_msg').addClass('d-none');
    //$('#name_msg').addClass('d-none');
    //$('#measure_unit_msg').addClass('d-none');
    //$('#reorder_level_msg').addClass('d-none');
    load_raw_material_details_table();
    load_categories(0);
    load_units(0);
    $('#additem').prop('disabled', true);
    $('#addunit').prop('disabled', true);
}

function update_raw_material_details() {
    var type = $('#type').val();
    var category = $('#category').val();
    var name = $('#name').val();
    var material_code = $('#material_code').val();
    var description = $('#description').val();
    var unit_type = $('#unit_type').val();
    var reorder_level = $('#reorder_level').val();
    var item_id = localStorage.getItem('item_id');
    var dataArray = {action: 'update_raw_material_details', type: type, category: category, name: name, material_code: material_code, description: description, unit_type: unit_type, reorder_level: reorder_level, item_id: item_id};

    $.post('./model/raw_material_registration_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('Sucssesfully update Data');
            raw_material_form_reset();
        } else {
            alertify.error('Data Update Failed');
        }
    });
}

function delete_raw_material_details(item_id) {
    alertify.confirm('Confirm Delete', 'Are You Suir You Want To Delete This Record...?', function () {
        var dataArray = {action: 'delete_raw_material_details', item_id: item_id};
        $.post('./model/raw_material_registration_model.php', dataArray, function (reply) {
            if (reply == 1) {
                alertify.success('Sucssesfully Delete Data');
                raw_material_form_reset();
            } else {
                alertify.error('Data Delete Failed');
            }
        });
    }, function () {
        alertify.error('Cancel Delete');
    });
}

//***************** prefix RM- and TL- *************************************
// Function to update the material code prefix based on the selected type
function update_material_code_prefix() {
    var type = $('#type').val();  // Get the selected type
    var material_code_prefix = '';

    if (type == '1') {
        material_code_prefix = 'RM-';  // Set prefix to 'RM-' for Raw Materials
    } else if (type == '2') {
        material_code_prefix = 'TL-';  // Set prefix to 'TL-' for Tools 
    }

    $('#material_code').val(material_code_prefix);  // Update the material code input field with the prefix
    $('#material_code').data('prefix', material_code_prefix); // Store the prefix in a data attribute
}

// Function to enforce the prefix in the material code input field
function enforce_prefix() {
    var $material_code = $('#material_code');  // Get the material code input field
    var prefix = $material_code.data('prefix');  //Get the stored prefix
    var current_value = $material_code.val(); // Get the current value of the input field

    // If the current value does not start with the prefix
    if (!current_value.startsWith(prefix)) {
        // Correct the value to maintain the prefix
        $material_code.val(prefix + current_value.substring(prefix.length));
    }
}
//***************************************************************************

// Function to convert the material code input to uppercase
function convert_to_uppercase() {
    var $material_code = $('#material_code'); // Get the material code input field
    $material_code.val($material_code.val().toUpperCase()); // Convert the value to uppercase
}


function validate_required_form_type() {
    var return_value = true;
    var type = $('#type').val();
    var category = $('#category').val();
    var name = $('#name').val();
    var material_code = $('#material_code').val();
    var unit_type = $('#unit_type').val();
    //var reorder_level = $('#reorder_level').val();

    // validate name
    if (name.length == 0) {
        $('#name_msg').removeClass('d-none');
        return_value = false;
    } else {
        $('#name_msg').addClass('d-none');
    }
    // validate material code
    if (material_code.length == 0) {
        $('#material_code_msg').removeClass('d-none');
        return_value = false;
    } else {
        $('#material_code_msg').addClass('d-none');
    }

    // Validate type
    if (type == "0") {
        $('#type_msg').removeClass('d-none');
        return_value = false;
    } else {
        $('#type_msg').addClass('d-none');
    }

    // Validate category
    if (category == "0") {
        $('#category_msg').removeClass('d-none');
        return_value = false;
    } else {
        $('#category_msg').addClass('d-none');
    }

    // Validate unit_type
    if (unit_type == 0) {
        $('#measure_unit_msg').removeClass('d-none');
        return_value = false;
    } else {
        $('#measure_unit_msg').addClass('d-none');
    }
    /*
     if (reorder_level.length == 0) {
     $('#reorder_level_msg').removeClass('d-none');
     return_value = false;
     } else {
     $('#reorder_level_msg').addClass('d-none');
     }
     */

    return return_value;
}











