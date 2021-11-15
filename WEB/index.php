<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>dangky</title>
    <link rel="stylesheet" href="css/index.css">

</head>

<body>
    <div class="container">
        <form class="form_login" action="dangnhap.php" method="POST">
            <div class="dangnhap">
                <div class="form-group">
                    <?php
                    $saipass = isset($_GET['error']) ? $_GET['error'] : '';
                    if ($saipass == "wrongpassword") {
                    echo '<div class="alert alert-danger">
                        Wrong password!!
                    </div>';
                    }
                    ?>
                    <label class="text" for=" email">Email
                        address:</label>
                    <input type="email" class="form-control" placeholder="Enter email" name="email" id="email">
                </div>
                <div class="form-group">
                    <label class="text" for="pwd">Password:</label>
                    <input type="password" class="form-control" placeholder="Enter password" name="pwd" id="pwd">
                </div>
                <div class="form-group form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox"> Remember me
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Đăng Nhập</button>
                <a href="login.php">Tạo tài khoản</a>
            </div>
        </form>
    </div>



</body>
<style>
body {
    background-image: url('images/banner1.jpg');
    background-size: cover;
    font-family: sans-serif;
}
</style>

</html>