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

</head>
<style>
    .login-panel {
        margin-top: 150px;
    }
    .table {
        margin-top: 50px;

    }

</style>

<body>
<div id="home" class="header">
<div class="navgation">
    <div class="menu">
        <a class="toggleMenu" href="#"><img src="images/menu-icon.png" alt="" /> </a>



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
    </div>
    <div>
        <h3 style="color: #f9f9f9;">View Users</h3>
    </div>
    <div class="clearfix"> </div>
</div>
</div>
<div class="">

<div class="table-scrol">

    <h1 align="center">All the Users</h1>

    <div class="table-responsive"><!--this is used for responsive display in mobile and other devices-->


        <table class="table table-bordered table-hover table-striped" style="table-layout: fixed">
            <thead>

            <tr>

                <th>User Id</th>
                <th>User First name</th>
                <th>User last name</th>
                <th>User E-mail</th>

                <th>Delete User</th>
                <th>Edit User</th>

            </tr>
            </thead>

            <?php
            include("db.php");
            $view_users_query="select * from users";//select query for viewing users.
            $run=mysqli_query($mysqli,$view_users_query);//here run the sql query.

            while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.
            {
                $id=$row[0];
                $first_name=$row[1];
                $last_name=$row[2];
                $email=$row[3];





                ?>

                <tr>
                    <!--here showing results in the table -->
                    <td><?php echo $id;  ?></td>
                    <td><?php echo $first_name;  ?></td>
                    <td><?php echo $last_name;  ?></td>
                    <td><?php echo $email;  ?></td>

                    <td><a href="delete.php?del=<?php echo $id ?>"><button class="btn btn-danger">Delete</button></a></td> <!--btn btn-danger is a bootstrap button to show danger-->
                    <td><a href="edit.php?del=<?php echo $id ?>"><button class="btn btn-primary">Edit</button></a></td> <!--btn btn-danger is a bootstrap button to show danger-->
                </tr>

            <?php } ?>

        </table>
    </div>
</div>
<button onclick="goBack()" a href="welcome.php" class="btn btn-primary">Go Back</button>

<script>
    function goBack() {
        window.history.back();
    }
</script>
    <button class="btn btn-primary"><a href="javascript:location.reload(true)"</a> Refresh</button>

<div class="footer">
    <div class="container">
        <div class="footer-text">
            <p>DESIGN BY <a href="http://w3layouts.com/"> JUNE KATUNGE</a></p>
        </div>
    </div>
    <a href="#home" id="toTop" class="scroll" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
</div>
</div>
</body>

</html>
