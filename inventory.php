
<!---->
<?php
//require('db.php');
//include("auth.php");
//?>
<!--<!DOCTYPE html>-->
<!--<html>-->
<!--<head>-->
<!--    <meta charset="utf-8">-->
<!--    <title>Dashboard - Secured Page</title>-->
<!--    <link rel="stylesheet" href="css/style.css" />-->
<!--</head>-->
<!--<body>-->
<!--<div class="form">-->
<!--    <p>Welcome to Dashboard.</p>-->
<!--    <p><a href="index.php">Home</a><p>-->
<!--    <p><a href="insert.php">Insert New Record</a></p>-->
<!--    <p><a href="view.php">View Records</a><p>-->
<!--    <p><a href="logout.php">Logout</a></p>-->
<!--</div>-->
<!--</body>-->
<!--</html>-->
<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>The Former Flat Responsive Agriculture bootstrap Website Template | Home :: w3layouts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <meta name="keywords" content="Bootstrap Responsive Templates, Iphone Compatible Templates, Smartphone Compatible Templates, Ipad Compatible Templates, Flat Responsive Templates"/>
    <script src="js/jquery-1.11.0.min.js"></script>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link href='http://fonts.googleapis.com/css?family=Arimo:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="home" class="header">
    <div class="top-header">
        <div class="container">
            <div class="logo">
                <a href="index.php"><img src="images/logo.png" alt=""></a>
            </div>
            <!--start-top-nav-->
            <div class="top-nav">
                <ul>
                    <li class="active"><a class="play-icon popup-with-zoom-anim" href="#small-dialog"><span> </span>Log out</a></li>

                </ul>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>

    <div class="navgation">
        <div class="menu">
            <a class="toggleMenu" href="#"><img src="images/menu-icon.png" alt="" /> </a>
            <ul class="nav" id="nav">
                <li><a href="insertpurchase_records.php">Insert New Purchase Records</a></li>
                <li><a href="insertsale_records.php">Insert New Sale Records</a></li>
                <?php
                echo $_SESSION['role'];
                if($_SESSION['role']==1) {

                    ?>
                    <li><a href="view_users.php">Manage Users</a></li>
                    <?php
                }
                ?>
                <li><a href="viewpurchase_records.php">View Purchase Records</a></li>
                <li><a href="viewsale_records.php">View Sale Records</a></li>
<!--                <li><a href="colourharvester/web/index.php">Visuals</a></li>-->
            </ul>
            <!----start-top-nav-script---->
            <script type="text/javascript" src="js/responsive-nav.js"></script>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $(".scroll").click(function(event){
                        event.preventDefault();
                        $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
                    });
                });
            </script>
            <!----//End-top-nav-script---->