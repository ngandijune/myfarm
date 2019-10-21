<?php
/**
 * Created by PhpStorm.
 * User: Ehtesham Mehmood
 * Date: 11/24/2014
 * Time: 11:55 PM
 */
include("db.php");
$delete_id=$_GET['del'];
$delete_query="delete  from salesheet WHERE sitem_id='$delete_id'";
//print_r($delete_query);//delete query
$run=mysqli_query($mysqli,$delete_query);
if($run)
{
//javascript function to open in the same window
    echo "<script>window.open('viewsale_records.php?deleted=user has been deleted','_self')</script>";
}

?>