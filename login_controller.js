//events
// Trigger the login function when the user clicks the login button
$('#login').click(function () {
    system_login();   // Call the system login function
});

// Focus on the password field when the user presses "Enter" in the username field
$('#uname').on('keypress', function (e) {
    if (e.which == 13) {   // Check if the "Enter" key (key code 13) is pressed
        $('#pass').focus();  // Move focus to the password input field
    }
});

// Trigger the login function when the user presses "Enter" in the password field
$('#pass').on('keypress', function (e) {
    if (e.which == 13) {   // Check if the "Enter" key (key code 13) is pressed
        system_login();   // Call the system login function
    }
});


//------------------------------------------------------------------------------
//functions
// Function to handle the system login process
function system_login() {
    var logType = $('#logType').val();  // Get the selected login type (e.g., Admin, User)
    var username = $('#uname').val(); // Get the entered username
    var password = $('#pass').val();  // Get the entered password
    var dataArray = {action: 'system_login', username: username, password: password, logType: logType}
    $.post('./model/login_model.php', dataArray, function (reply) {
        if (reply == 1) {
            alertify.success('Successfully  Login To system');
            setTimeout(function () {
                window.location = "./?location=dashboard";
            }, 600);
        } else if (reply == 0) {  // If the server returns 0, the user is invalid
            alertify.error('Invalid User');
        } else if (reply == 99) {  // If the server returns 99, the user is temporarily blocked
            alertify.error('Sorry You are Currently Temporary Block please contact system admin');
        } else {
            alertify.error('Username/Password Incorrect');
        }
    });
}