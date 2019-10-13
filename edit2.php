<?php
// connect to the database
include('db.php');
// get results from database
$result = mysqli_query($mysqli,"SELECT * FROM users")
or die(mysqli_error());
?>
<html>
<head>
    <title>Update Data</title>
    <link rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" >
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</head>
<body>
    <h1>Product list update</h1>
    <hr>
    <table style=" width:'50%'!important " class='table'>
        <tr bgcolor='#CCCCCC'>
            <th>id</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Email</th>
            <th>Password</th>
        </tr>
        <?php while ($res = mysqli_fetch_array($result)) { ?>
        <tr>
            <form action="edit2.php" method="post">
                <td><input type="text" name="first_name" value="<?php echo $res['first_name']; ?>"></td>
                <td><input type="text" name="last_name" value="<?php echo $res['last_name']; ?>"></td>
                <td><input type="text" name="email" value="<?php echo $res['email']; ?>"></td>
                <td><input type="text" name="password" value="<?php echo $res['password']; ?>"></td>
                <td>
<!--                    Size for DVD: <input type="text" name="sizedvd_p" value="--><?php //echo $res['sizedvd_product']; ?><!--"><br>-->
<!--                    Weight for Book: <input type="text" name="weightbook_p" value="--><?php //echo $res['weightbook_product']; ?><!--"><br>-->
<!--                    For Furniture<br>-->
<!--                    H: <input type="text" name="heightfurn_p" value="--><?php //echo $res['heightfurn_product']; ?><!--"><br>-->
<!--                    W: <input type="text" name="widthfurn_p" value="--><?php //echo $res['widthfurn_product']; ?><!--"><br>-->
<!--                    L: <input type="text" name="lengthfurn_p" value="--><?php //echo $res['lengthfurn_product']; ?><!--"><br>-->
                </td>
                <input type="hidden" name="id" value="<?php echo $res['id']; ?>">
                <input type="submit" name="update" value="Submit">
            </form>
        </tr>
        <?php } ?>
        <a href="view_users.php">Home</a>
    </table>
</body>
</html>

<?php
include'db.php';
// Create connection

if (isset($_POST['update'])) {
    $sql = "UPDATE products SET name_product = '$_POST[name_p]', price_product = '$_POST[price_p]', sku_product = '$_POST[sku_p]', type_product = '$_POST[type_p]', sizedvd_product = '$_POST[sizedvd_p]', weightbook_product = '$_POST[weightbook_p]', heightfurn_product = '$_POST[heightfurn_p]', widthfurn_product = '$_POST[widthfurn_p]', lengthfurn_product = '$_POST[lengthfurn_p]', WHERE id_product = '$_POST[id_p]'";
} else {
    echo "Nothing was posted";
}

if (mysqli_query($db, $sql)) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysqli_error($db);
}

mysqli_close($db);
?>