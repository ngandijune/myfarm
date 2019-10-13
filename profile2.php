

<?php
require_once('db.php');

$result3 ="SELECT * FROM users";
while($row3 = mysqli_fetch_array($mysqli,$result3))

{
    $first_name=$row3['first_name'];
    $last_name=$row3['last_name'];
    $email=$row3['email'];
    $password=$row3['password'];
    $picture=$row3['picture'];
    $gender=$row3['gender'];
}
?>
<table width="398" border="0" align="center" cellpadding="0">
    <tr>
        <td height="26" colspan="2">Your Profile Information </td>
        <td><div align="right"><a href="index.php">logout</a></div></td>
    </tr>
    <tr>
        <td width="129" rowspan="5"><img src="<?php echo $picture ?>" width="129" height="129" alt="no image found"/></td>
        <td width="82" valign="top"><div align="left">FirstName:</div></td>
        <td width="165" valign="top"><?php echo $first_name ?></td>
    </tr>
    <tr>
        <td valign="top"><div align="left">LastName:</div></td>
        <td valign="top"><?php echo $last_name ?></td>
    </tr>
    <tr>
        <td valign="top"><div align="left">Gender:</div></td>
        <td valign="top"><?php echo $gender ?></td>
    </tr>
    <tr>
        <td valign="top"><div align="left">email:</div></td>
        <td valign="top"><?php echo $email ?></td>
    </tr>
    <tr>
        <td valign="top"><div align="left">password.: </div></td>
        <td valign="top"><?php echo $password ?></td>
    </tr>
</table>
<p align="center"><a href="index.php"></a></p>