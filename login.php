<?php
// Start the session
session_start();

/* User login process, checks if user exists and password is correct */

// Escape email to protect against SQL injections
echo $_POST['email'];
echo $_POST['password'];
require_once ("db.php");
$email = $mysqli->escape_string($_POST['email']);
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'");

if ( $result->num_rows == 0 ){ // User with that email doesn't exist
    $_SESSION['message'] = "User with that email doesn't exist!";// the error message doesnt work
    header("location: index.php");

}
else { // User exists
    $user = $result->fetch_assoc();

    if ( password_verify($_POST['password'], $user['password']) ) {
        
        $_SESSION['email'] = $user['email'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['active'] = $user['active'];
        $_SESSION['role'] = $user['role'];
//        print_r($_SESSION);

//        exit;

        // This is how we'll know the user is logged in
        $_SESSION['logged_in'] = true;

        header("location: welcome.php");
    }
    else {
        $_SESSION['message'] = "You have entered wrong password, try again!";
        header("location: 404.html");
    }
}
?>