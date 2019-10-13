<?php
/* Registration process, inserts user info into the database 
   and sends account confirmation email message
 */

// Set session variables to be used on profile.php page
require_once ("db.php");



$_SESSION['email'] = $_POST['email'];
$_SESSION['first_name'] = $_POST['first_name'];
$_SESSION['last_name'] = $_POST['last_name'];

// Escape all $_POST variables to protect against SQL injections
$first_name = $mysqli->escape_string($_POST['first_name']);
$last_name = $mysqli->escape_string($_POST['last_name']);
$email = $mysqli->escape_string($_POST['email']);
$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
$hash = $mysqli->escape_string( md5( rand(0,1000) ) );

// Check if user with that email already exists
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());

if ( $result->num_rows > 0 ) {
    echo "the if statement was called";
    $_SESSION['message'] = 'User with this email already exists!';
    //dont forget to create error.php
    header("location: index.php");
    
}
else { // Email doesn't already exist in a database, proceed...

    // active is 0 by DEFAULT (no need to include it here)
    $sql = "INSERT INTO users (first_name, last_name, email, password, hash) " 
            . "VALUES ('$first_name','$last_name','$email','$password', '$hash')";
    $mysqli->query($sql) or die($mysqli->error());
    //trying the successfully registered messsage
//    echo "the if statement was called";
//    $_SESSION['message'] = 'successfully registered!';
            //Ask june for verification via email.
    header("location: index.php");


}
