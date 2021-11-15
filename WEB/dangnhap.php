<?php
include 'config.php';
$email = $_POST["email"];
$pwd = $_POST["pwd"];
$sai = true;
$sql = "SELECT * FROM dangky WHERE Email ='$email' and Password='$pwd'";
$rs = mysqli_query($conn,$sql);


if(mysqli_num_rows($rs) > 0){
    header("location: quanly.php");
    $sai = true;
}
else {
    header("location: index.php?error=wrongpassword");
    $sai = false;
  
}

?>