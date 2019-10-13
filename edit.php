<html>


<head lang="en">
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="bootstrap-3.2.0-dist\css\bootstrap.css"> <!--css file link in bootstrap folder-->
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link href='http://fonts.googleapis.com/css?family=Arimo:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <div id="home" class="header">
        <div class="top-header">
            <div class="container">
                <div class="logo">
                    <a href="index.php"><img src="images/logo.png" alt=""></a>
                </div>
                <!--start-top-nav-->
                <div class="top-nav">

                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>


<?php
//Database Connection
include 'db.php';
$message = null;
//Get ID from Database
if(isset($_GET['del'])){
    $id = $_GET['del'];
    $sql = "SELECT * FROM users WHERE id =".$_GET['del'];
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_array($result);
//    print_r($row);
}
//Update Information
if(isset($_POST['btn-update'])){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $update = "UPDATE users SET first_name='$first_name', last_name='$last_name',email='$email' WHERE id= ". $_GET['del'];
    $up = mysqli_query($mysqli, $update);
    if(!isset($sql)){
        die ("Error $sql" .mysqli_connect_error());
    }
    else
    {
        $message = ' <div class="alert alert-success">
  Updated data Sucessfully  <span class="closebtn pull-right" onclick="this.parentElement.style.display=\'none\';">&times;</span>
</div> ';
//        header("location: view_users.php");
    }
}
?>
<!--Create Edit form -->
<!doctype html>
<html>
<body>
<?php
if ($message){
    echo $message;
}
?>
<form method="post" action="edit.php?del=<?php echo $id ?>">
    <h1>Edit User Information</h1>
    <label>First Name:</label><input type="text" name="first_name" placeholder="First Name" value="<?php echo $row['first_name']; ?>"><br/><br/>
    <label>Last Name:</label><input type="text" name="last_name" placeholder="Last Name" value="<?php echo $row['last_name']; ?>"><br/><br/>
    <label>Email:</label><input type="text" name="email" placeholder="email" value="<?php echo $row['email']; ?>"><br/><br/>
    <button type="submit" class="btn btn-primary" name="btn-update" id="btn-update"><strong>Update</strong></button>
    <a href="view_users.php"><button type="button" button class="btn btn-danger" value="button">Cancel</button></a>
</form>
<!-- Alert for Updating -->
<a href="viewpurchase_records.php" class="btn btn-primary">Go Back</a>

<script>
    function goBack() {
        window.history.back();
    }
</script>
<div class="footer">
    <div class="container">
        <div class="footer-text">
            <p>DESIGN BY <a href="http://w3layouts.com/"> JUNE KATUNGE</a></p>
        </div>
    </div>
    <a href="#home" id="toTop" class="scroll" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
</div>

</body>
</html>





