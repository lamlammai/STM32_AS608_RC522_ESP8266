<?php
include 'config.php';
$name = $_POST["name"];
$email = $_POST["email"];
$ngaysinh = $_POST["ngaysinh"];
$password = $_POST["password"];
$nhaplaipassword = $_POST["nhaplaipassword"];
$ispasswordMapping = true;
$sql = "SELECT * FROM dangky WHERE Email ='$email' ";
$old = mysqli_query($conn,$sql);
if($password == $nhaplaipassword)
{
    if(mysqli_num_rows($old) > 0){
        header("location: login.php?error=emaildaco");    
      //  header("location:index.php");
    }
else{
    $sql = "INSERT INTO dangky (Fullname,Email,Password) VALUES ('$name','$email','$password')";
    mysqli_query($conn,$sql);
    header("location:index.php");
}
}
else{
    header("location: login.php?error=khongkhop");  
}



?>