<?php
   require_once ('dbhelp.php');

   $s_name = $s_id = $s_mssv = $s_email =  $s_mobile='';
   
   if (!empty($_POST)) {
       $s_stt = '';
   
       if (isset($_POST['name'])) {
           $s_name = $_POST['name'];
       }
   
       if (isset($_POST['id'])) {
           $s_id = $_POST['id'];
       }
   
       if (isset($_POST['mssv'])) {
           $s_mssv = $_POST['mssv'];
       }
       if (isset($_POST['email'])) {
        $s_email = $_POST['email'];
    }
    if (isset($_POST['mobile'])) {
        $s_mobile = $_POST['mobile'];
    }
       if (isset($_POST['stt'])) {
           $s_stt = $_POST['stt'];
       }
   
       $s_name = str_replace('\'', '\\\'', $s_name);
       $s_id      = str_replace('\'', '\\\'', $s_id);
       $s_email  = str_replace('\'', '\\\'', $s_email);
       $s_mssv  = str_replace('\'', '\\\'', $s_mssv);
       $s_mobile  = str_replace('\'', '\\\'', $s_mobile);
       $s_stt       = str_replace('\'', '\\\'', $s_stt);
   
       if ($s_stt != '') {
           //update
           $sql = "update user set name = '$s_name', mssv = '$s_mssv', id = '$s_id' ,email = '$s_email',mobile = '$s_mobile' where stt = " .$s_stt;
       } else {
           //insert
           $sql = "insert into user(name, mssv, id,email,mobile) value ('$s_name', '$s_mssv', '$s_id','$s_email','$s_mobile')";
       }
   
       // echo $sql;
   
       execute($sql);
   
       header('Location: quanly.php');
       die();
   }
   
   $stt = '';
   if (isset($_GET['stt'])) {
       $stt          = $_GET['stt'];
       $sql         = 'select * from user where stt = '.$stt;
       $studentList = executeResult($sql);
       if ($studentList != null && count($studentList) > 0) {
           $std        = $studentList[0];
           $s_name = $std['name'];
           $s_id      = $std['id'];
           $s_mssv  = $std['mssv'];
           $s_email  = $std['email'];
           $s_mobile  = $std['mobile'];
       } else {
           $stt = '';
       }
   }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Registation Form * Form Tutorial</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/quanly.css">
</head>

<body>
<div class="nen">
        <img src="./images/banner2.jpg" alt="" class="a2">
        <img src="./images/banner.png" alt="" class="a1">
    </div>
    <div class="menungang">
        <div class="container">
            <div class="row">
                <div class="menu">

                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="quanly.php">Danh Sách Sinh Viên</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="diemdanh.php">Điểm Danh</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">LOGOUT</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane container active" id="home"></div>
                        <div class="tab-pane container fade" id="menu1"></div>
                        <div class="tab-pane container fade" id="menu2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Add Student</h2>
            </div>
            <div class="panel-body">
                <form method="post"  >
                     <div class="form-group">
                        <label for="uid">UID:</label>
                       
                        <input type="number" name="stt" style="display: none;" value="<?=$stt?>" >
                        <input required="true" type="text" class="form-control" id="uid" name="id" value="<?=$s_id?>">
                    </div>
                    <div class="form-group">
                        <label for="usr">Fullname:</label>
                        <input required="true" type="text" class="form-control" id="usr" name="name" value="<?=$s_name?>">
                    </div>
                    <div class="form-group">
                        <label for="mssv">MSSV:</label>
                        <input type="text" class="form-control" id="mssv" name="mssv" value="<?=$s_mssv?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?=$s_email?>" >
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile Phone:</label>
                        <input type="text" class="form-control" id="email" name="mobile" value="<?=$s_mobile?>" >
                    </div>
                    <button class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    
</body>

</html>