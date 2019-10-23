<html></html>

<style>
    body {font-family: Arial, Helvetica, sans-serif;}
    * {box-sizing: border-box;}

    .form-inline {
        display: flex;
        flex-flow: row wrap;
        align-items: center;
    }

    .form-inline label {
        margin: 5px 10px 5px 0;
    }

    .form-inline input {
        vertical-align: middle;
        margin: 5px 10px 5px 0;
        padding: 10px;
        background-color: #fff;
        border: 1px solid #ddd;
    }

    .form-inline button {
        padding: 10px 20px;
        background-color: dodgerblue;
        border: 1px solid #ddd;
        color: white;
        cursor: pointer;
    }

    .form-inline button:hover {
        background-color: royalblue;
    }

    @media (max-width: 800px) {
        .form-inline input {
            margin: 10px 0;
        }

        .form-inline {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>
</head>

<html lang="en">
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
require('db.php');
//include("auth.php");
$status = "";
//if(isset($_POST['new']) && $_POST['new']==1){
    if(isset($_POST['submit'])){

    $p_date = date("Y-m-d H:i:s");
    $p_quantity = $_POST['p_quantity'];
    $p_cost = $_POST["p_cost"];
    $p_name = $_POST["p_name"];
    $ins_query="insert into purchasesheet(`p_date`,`p_name`,`p_quantity`,`p_cost`)values
    ('$p_date','$p_name','$p_quantity','$p_cost')";

//    print_r($ins_query);
//    exit();

    mysqli_query($mysqli,$ins_query)
    or die(mysqli_error($mysqli));
    $status = "New Record Inserted Successfully.
    <!--</br></br><a href='viewpurchase_records.php'>View Inserted Record</a>";
}
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
    <title>Insert New purchase Record</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<!--<body>-->
<!--<div class="form">-->
<!--    <p><a href="dashboard.php">Dashboard</a>-->
<!--        | <a href="view.php">View Records</a>-->
<!--        | <a href="logout.php">Logout</a></p>-->
<!--    <div>-->

        <h1 align="center">Insert New Purchase Record</h1>
        <form name="form" method="post" action=""  class="form-inline">
            <input type="hidden" name="new" value="1" />
        Name    <p><input type="text" name="p_name" placeholder="Enter Item name" required /></p><br>
      Quantity   <br>   <p><input type="text" name="p_quantity" placeholder="Enter Quantity" required /></p><br>
         Cost   <p><input type="text" name="p_cost" placeholder="Enter Cost" required /></p><br>
<!--            <p><input type="text" name="p_date" placeholder="Enter Date" required /></p>-->

<!--            <p><input name="submit" type="submit" value="Submit" class="btn btn-primary" /></p>-->
            <button name='submit' type="submit" value="Submit" class="btn btn-primary" >Submit</button>
        </form>
        <p style="color:#FF0000;"><?php echo $status; ?></p>
    </div>
</div>
</body>
</html>

    <div>
<!--        <h3 style="color: #f9f9f9;">View Purchase Records</h3>-->
    </div>
    <div class="clearfix"> </div>
    </div>
    </div>
    <div class="">

        <div class="table-scrol">
<!--            <h3 style="color: #f9f9f9;">View Purchase Records</h3>-->
<!--            <h1 align="center">View Purchase Records</h1>-->

            <div class="table-responsive"><!--this is used for responsive display in mobile and other devices-->


                <table class="table table-bordered table-hover table-striped" style="table-layout: fixed">
                    <thead>

                    <tr>
                        <th>item_id</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Cost</th>
                        <th>Date</th>

                        <th>Delete User</th>
                        <th>Edit User</th>

                    </tr>
                    </thead>

                    <?php
                    include("db.php");
                    $view_users_query="select * from purchasesheet";//select query for viewing users.
                    $run=mysqli_query($mysqli,$view_users_query);//here run the sql query.
                    $sum=0;
                    while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.
                    {
                        $sitem_id=$row[0];
                        $p_name=$row[1];
                        $p_quantity=$row[2];
                        $p_cost=$row[4];
                        $p_date=$row[3];
                        $sum +=(int)$p_cost;




                        ?>

                        <tr>
                            <!--here showing results in the table -->
                            <td><?php echo $sitem_id;  ?></td>
                            <td><?php echo $p_name;  ?></td>
                            <td><?php echo $p_quantity;  ?></td>
                            <td><?php echo $p_cost;  ?></td>
                            <td><?php echo $p_date;  ?></td>

                            <td><a href="deletepurchase_records.php?del=<?php echo $sitem_id ?>"><button class="btn btn-danger">Delete</button></a></td> <!--btn btn-danger is a bootstrap button to show danger-->
                            <td><a href="editpurchase_records.php?del=<?php echo $sitem_id ?>"><button class="btn btn-primary">Edit</button></a></td> <!--btn btn-danger is a bootstrap button to show danger-->
                        </tr>

                    <?php } ?>

                </table>
                <?php

                echo "Total ". $sum;
                ?>
            </div>
        </div>
        <a href="inventory.php" class="btn btn-primary">Go Back</a>

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
