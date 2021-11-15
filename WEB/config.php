<?php
define('HOST', 'localhost');
define('DATABASE', 'quanlysinhvien');
define('USERNAME', 'root');
define('PASSWORD', '');
    $conn = mysqli_connect("localhost","root","","quanlysinhvien");
    mysqli_set_charset($conn,"utf8");