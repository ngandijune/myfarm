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
        $s_name = $_POST['s_name'];
        $s_quantity = $_POST['s_quantity'];
        $s_cost = $_POST['s_cost'];
        $update = "UPDATE salesheet SET s_name='$s_name', s_quantity='$s_quantity',s_cost='$s_cost' WHERE sitem_id= ". $_GET['del'];
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
        $sitem_id = $_GET['del'];
        $sql = "SELECT * FROM salesheet WHERE sitem_id =".$_GET['del'];
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
<h1 align="center">Edit Sale Information</h1>
<form method="post" action="editsale_records.php?del=<?php echo $sitem_id?>" class="form-inline">
<!--    <h1>Edit Sale Information</h1>-->
    <label>Name:</label><input type="text" name="s_name" placeholder="Name" value="<?php echo $row['s_name']; ?>"><br/><br/>
    <label>Quantity:</label><input type="text" name="s_quantity" placeholder="Quantity" value="<?php echo $row['s_quantity']; ?>"><br/><br/>
    <label>Cost:</label><input type="text" name="s_cost" placeholder="Cost" value="<?php echo $row['s_cost']; ?>"><br/><br/>
    <button type="submit" class="btn btn-primary" name="btn-update" id="btn-update"><strong>Update</strong></button>
    <a href="viewsale_records.php"><button type="button" button class="btn btn-danger" value="button">Cancel</button></a>
</form>
<!-- Alert for Updating -->
<a href="viewsale_records.php" class="btn btn-primary">Go Back</a>

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






