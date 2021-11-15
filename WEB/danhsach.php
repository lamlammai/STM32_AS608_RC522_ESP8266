<?php
    include 'dbhelp.php';
	date_default_timezone_set('Asia/Jakarta');
	$time = date("H:i:sa");
    $name = $data['name'];;
    $id = $data['id'];;
    $email = $data['email'];;
    $mssv = $data['mssv'];;
    $mobile = $data['mobile'];;
    $sql = "SELECT * FROM diemdanh ";
    $old = mysqli_query($conn,$sql);
     $sql = "INSERT INTO diemdanh (name,id,email,mobile,mssv) VALUES ('$name','$id','$email','$mssv','mobile')";
     mysqli_query($conn,$sql);
        

?>