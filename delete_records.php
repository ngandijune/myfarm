<?php
/**
 * Created by PhpStorm.
 * User: Ehtesham Mehmood
 * Date: 11/24/2014
 * Time: 11:55 PM
 */
include("db.php");
$delete_id=$_GET['del'];
$delete_query="delete  from purchasesheet WHERE item_id='$delete_id'";
//print_r($delete_query);//delete query
$run=mysqli_query($mysqli,$delete_query);
if($run)
{
//javascript function to open in the same window
    echo "<script>window.open(vviewpurchase_records.phprds.php,'_self')</script>";
}

?>