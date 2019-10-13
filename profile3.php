<html>
<head>
    <title><?php echo $first_name; ?> <?php echo $last_name; ?>s profile</title>

</head>
<body>
<?php
require_once('db.php');
if(isset($_GET['first_name'])){

    $first_name = $_GET['first_name'];
    mysqli_connect("localhost", "root", "") or die ("could not connect t the server");
    mysqli_select_db("users") or die("this database was not found");
    $userquery = mysqli_query("SELECT * FROM users WHERE first_name='$first_name'") or die("the query could be fale please try again");
    if(mysqli_num_rows($userquery) != 1){
        die("that first_name could not be found!");
    }
    while($row = mysqli_fetch_array($userquery, MYSQLI_ASSOC)){
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $email = $row['email'];
        $dbfirst_name = $row['first_name'];
        $activated = $row['activated'];
        $access = $row['access'];
    }
    if($first_name != $dbfirst_name){
        die ("there has been a fatal error please try again. ");
    }
    if($activated == 0){
        $active = "this account has not been activated";
    }else{
        $active = "ths  account has been activated";
    }

    if($access == 0){
        $admin = "this user is not administrator";
    }else{
        $admin = "this user is  an administrator";
    }
    ?>
    <h2><?php echo $first_name; ?> <?php echo $last_name; ?>s profile</h2>
    <table>
        <tr>
            <td>firstname:</td><td><?php echo $first_name; ?></td>
        </tr>
        <tr>
            <td>last_name:</td><td><?php echo $last_name; ?></td>
        </tr>
        <tr>
            <td>email:</td><td><?php echo $email; ?></td>
        </tr>
        <tr>
            <td>first_name:</td><td><?php echo $dbfirst_name; ?></td>
        </tr>
        <tr>
            <td>activated:</td><td><?php echo $active; ?></td>
        </tr>
        <tr>
            <td>access:</td><td><?php echo $admin; ?></td>
        </tr>

    </table>


    <?php
}else die("You need  to specify a first_name!");


?>

</body>
</html><?php
