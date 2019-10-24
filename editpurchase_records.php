<html>

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
        background-color: #1B242F;
        border: 1px solid #ddd;
        color: white;
        cursor: pointer;
    }

    .form-inline button:hover {
        background-color: #0C94CE;
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

    //Update Information
    if(isset($_POST['btn-update'])){
        $p_name = $_POST['p_name'];
        $p_quantity = $_POST['p_quantity'];
        $p_cost = $_POST['p_cost'];
        $update = "UPDATE purchasesheet SET p_name='$p_name', p_quantity='$p_quantity',p_cost='$p_cost' WHERE item_id= ". $_GET['del'];
//        print_r($update);
        $up = mysqli_query($mysqli, $update);
        if(!isset($up)){
            die ("Error $up" .mysqli_connect_error());
        }
        else
        {
            $message = ' <div class="alert alert-success">
  Updated data Sucessfully  <span class="closebtn pull-right" onclick="this.parentElement.style.display=\'none\';">&times;</span>
</div> ';
//        header("location: view_users.php");
        }
    }
    if(isset($_GET['del'])){
        $item_id = $_GET['del'];
        $sql = "SELECT * FROM purchasesheet WHERE item_id =".$_GET['del'];
        $result = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_array($result);
//    print_r($row);
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
<h1 align="center">Edit Purchase Information</h1>
<form method="post" action="editpurchase_records.php?del=<?php echo $item_id?>" class="form-inline">
<!--    <h1>Edit Purchase Information</h1><br>-->
<!--    <h1 align="center">Edit Purchase Information</h1>-->
   <br> <label>Name:</label><input type="text" name="p_name" placeholder="Name" value="<?php echo $row['p_name']; ?>"><br/><br/>
    <label>Quantity:</label><input type="text" name="p_quantity" placeholder="Quantity" value="<?php echo $row['p_quantity']; ?>"><br/><br/>
    <label>Cost:</label><input type="text" name="p_cost" placeholder="Cost" value="<?php echo $row['p_cost']; ?>"><br/><br/>
    <button type="submit" class="btn btn-primary" name="btn-update" id="btn-update"><strong>Update</strong></button>
    <a href="viewpurchase_records.php"><button type="button" button class="btn btn-danger" value="button">Cancel</button></a>
</form>
<!-- Alert for Updating -->
<a href="insertpurchase_records.php" class="btn btn-primary">Go Back</a>

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






