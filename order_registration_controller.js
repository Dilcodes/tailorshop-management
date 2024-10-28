//events
// Initial function calls
load_customer_details();   // Load customer details on page load
load_order_types();  // Load order types on page load
load_order_id(); // Load the next available order ID on page load

// Event handler for changing the order type
$('#order_type').change(function () {
    set_form(); // Set the form fields based on selected order type
    var selected = $("#order_type option:selected").text();  // Get the selected order type text
    $('#selItem').html(selected);  // Display the selected order type
});

// Event handler for changing the required date
$("#required_date").on("change", function () {
    var date = $(this).val(); // Get the selected date
    $('#reqDate').html(date); // Display the selected date
});

// Event handler for focusing on the total amount field
$('#total_amt').focusin(function () {
    get_raw_material_cost();
});

// Event handler for clicking the cost calculation button
$('#cost_cal').click(function () {
    get_raw_material_cost();
});

// Event handler for entering the advanced amount
$('#advanced_amt').keyup(function () {
    this.value = this.value.replace(/[^0-9\.]/g, '');
    var total_amt = $("#total_amt").val();  // Get the total amount
    var advanced_amt = $("#advanced_amt").val(); // Get the advanced amount
    if (total_amt.length != 0) {
        var balance_amt = parseFloat(total_amt) - parseFloat(advanced_amt);  // Calculate the balance amount
        if (balance_amt >= 0) {
            $('#balance_amt').val(balance_amt);  // Set the balance amount
            $('#add_order_msg').addClass('d-none');  // Hide the add order message
            $('#advance_amt_message').addClass('d-none');
            $('#create_order').prop("disabled", false);  // Enable the create order button
        } else {
            $('#advance_amt_message').removeClass('d-none');
            $("#advanced_amt").focus();
            $("#advanced_amt").select(); // Select the advanced amount text
            $('#create_order').prop("disabled", true);  // Disable the create order button
        }
    } else {
        $("#total_amt").focus();
        $('#add_order_msg').removeClass('d-none');
    }
});

$('#total_amt').keyup(function () {
    this.value = this.value.replace(/[^0-9\.]/g, '');
    var total_amt = $("#total_amt").val();
    if (total_amt.length == 0) {
        $('#add_order_msg').removeClass('d-none');
    } else {
        $('#add_order_msg').addClass('d-none');
    }
});

//Event handler for entering the advanced amount
$('#advanced_amt').keyup(function () {
    var advanced_amt = $('#advanced_amt').val(); // Get the advanced amount
    var total_amt = $('#total_amt').val();
    var cost_cal = localStorage.getItem('cost'); // Correctly get the cost calculation value
    if (parseFloat(advanced_amt) <= parseFloat(total_amt) && parseFloat(advanced_amt) >= parseFloat(cost_cal)) {  //???????????????
        $('#advance_amt_message').addClass('d-none');
    } else {
        $('#advance_amt_message').removeClass('d-none');
    }
});


// Event handler for entering the total amount
$('#total_amt').keyup(function () {
    var total_amt = $('#total_amt').val();
    var raw_material_cost = $('#totRawCost').text(); // Get the raw material cost
    if (parseFloat(total_amt) < parseFloat(raw_material_cost)) {
        $('#greater_than_raw_material').removeClass('d-none');  // Show the raw material message
    } else {
        $('#greater_than_raw_material').addClass('d-none');
    }
});

// On clicking the create order button
$('#create_order').click(function () {
    if (form_required_field_validation()) { // Check if the form is valid
        add_new_order(); // Add the new order if the form is valid
    }
});

$('#reset').click(function () {
    form_reset();
});

$('#sampleImg').change(function () {
    sample_img_upload();
});

//------------------------------------------------------------------------------

//functions

// Function to upload sample image
function sample_img_upload() {
    var fd = new FormData();  // Create a FormData object
    var files = $('#sampleImg')[0].files[0];  // Get the selected file
    fd.append('file', files);  // Append the file to FormData

    $.ajax({
        url: './model/sample_img_upload_model.php', // URL for the AJAX request
        type: 'post', // Request type
        data: fd, // Data to be sent
        contentType: false,
        processData: false, //do not process data
        success: function (response) {
            if (response != 0) {
                var path = response;
                path = path.substring(2);  // Adjust the path
//                alert(path)
                setTimeout(function () {
                    $("#img_pre").attr("src", path);  //set the image source
                }, 1000);
            } else {
                alert('file not uploaded'); //alert if file not uploaded
            }
        },
    });
}

//function load customer details
function  load_customer_details() {
    var dataArray = {action: 'load_customer_details'};
    $.post('./model/order_registration_model.php', dataArray, function (reply) {
        $('#customer').html(reply);
        chosenRefresh();
    });
}

//function load order types
function  load_order_types() {
    var dataArray = {action: 'load_order_types'};
    $.post('./model/order_registration_model.php', dataArray, function (reply) {
        $('#order_type').html(reply);
        chosenRefresh();
        set_form();
    });
}

// Function to set form fields based on order type
function set_form() {
    var order_type = $('#order_type').val(); // getthe selected order types
    var dataArray = {action: 'set_form', order_type: order_type};  // Create data object
    $.post('./model/order_registration_model.php', dataArray, function (reply) {
        var x = reply.split('~');  // Split the reply
        $('#usageSection').removeClass('d-none');  // Show the usage section
        $('#usageSection').html('').append(x[0]);  // Update the usage section
        $('#formFeleds').val(x[1]);  // Set form fields
    });
}

function load_order_id() {
    var dataArray = {action: 'load_order_id'};
    $.post('./model/order_registration_model.php', dataArray, function (reply) {
        $('#order_id').val(reply);
    });
}

function add_new_order() {
    var customer = $('#customer').val();
    var order_type = $('#order_type').val();
    var required_date = $('#required_date').val();
    var advanced_amt = $('#advanced_amt').val();
    var total_amt = $('#total_amt').val();
    var balance_amt = $('#balance_amt').val();

    var raw_item_count = $('#formFeleds').val();
    raw_item_count = parseFloat(raw_item_count) - 1;
    var mat = '';
    var use = '';
    for (var x = 1; x <= raw_item_count; x++) {
        if (x == 1) {
            mat = $('#mat_' + x).val();
            use = $('#use_' + x).val();
        } else {
            mat += '~' + $('#mat_' + x).val();
            use += '~' + $('#use_' + x).val();
        }
    }
    var dataArray = {action: 'add_new_order', customer: customer, order_type: order_type, required_date: required_date, advanced_amt: advanced_amt, mat: mat, use: use, total_amt: total_amt, balance_amt: balance_amt};
    $.post('./model/order_registration_model.php', dataArray, function (reply) {
        if (reply != -1) {
            alertify.success('Successfully Create Order');
            form_reset();
            setTimeout(function () {
                window.location = "./?location=order_confirm&order_id=" + reply;
            }, 500);
        } else {
            alertify.error('Order Create Failed');
        }
    });
}

function get_raw_material_cost() {
    $('#cost_cal').addClass('d-none');
    $('#loadinBtn').removeClass('d-none');
    var raw_item_count = $('#formFeleds').val();
    raw_item_count = parseFloat(raw_item_count) - 1;
    var mat = '';
    var use = '';
    for (var x = 1; x <= raw_item_count; x++) {
        if (x == 1) {
            mat = $('#mat_' + x).val();
            use = $('#use_' + x).val();
        } else {
            mat += '~' + $('#mat_' + x).val();
            use += '~' + $('#use_' + x).val();
        }
    }
    var dataArray = {action: 'get_raw_material_cost', mat: mat, use: use, raw_item_count: raw_item_count};
    $.post('./model/order_registration_model.php', dataArray, function (reply) {
        setTimeout(function () {
            $('#cost_cal').removeClass('d-none');
            $('#loadinBtn').addClass('d-none');
            $('#totRawCost').html(reply);
            localStorage.setItem('cost', reply);
        }, 200);
    });
}

function form_reset() {
    load_order_id();
    load_customer_details();
    load_order_types();
    $('#advanced_amt').val('');
    $('#required_date').val('');
    $('#selItem').html('');
    $('#reqDate').html('');
    $('#totRawCost').html('');
    $('#total_amt').val('');
    $('#balance_amt').val('');
}

function form_required_field_validation() {
    var customer = $('#customer').val();
    var order_type = $('#order_type').val();
    var total_amt = $('#total_amt').val();
    var advanced_amt = $('#advanced_amt').val();
    var required_date = $('#required_date').val();
    var isValid = true;  // Initialize a flag to track if the form is valid

    // Validate customer
    if (customer == "0") {  // If customer is not selected (value is "0")
        $('#customer_msg').removeClass('d-none'); // Show the customer error message
        isValid = false; // Set the form validity flag to false
    } else {
        $('#customer_msg').addClass('d-none'); // Hide the customer error message
    }

    // Validate order type
    if (order_type == "0") {
        $('#order_item_msg').removeClass('d-none');
        isValid = false;
    } else {
        $('#order_item_msg').addClass('d-none');
    }

    // Validate total amount
    if (total_amt === "") {
        $('#Tot_amt_msg').removeClass('d-none');
        isValid = false;
    } else {
        $('#Tot_amt_msg').addClass('d-none');
    }

    // Validate advanced amount
    if (advanced_amt === "") {
        $('#advanced_amt_msg').removeClass('d-none');
        isValid = false;
    } else {
        $('#advanced_amt_msg').addClass('d-none');
    }

    // Validate required date
    if (required_date === "") {
        $('#required_date_msg').removeClass('d-none');
        isValid = false;
    } else {
        $('#required_date_msg').addClass('d-none');
    }

    return isValid;  // Return the form validity flag
}





