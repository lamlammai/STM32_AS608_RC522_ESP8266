<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/login.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="dangky2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="text-center">Đăng ký tài khoản</h2>
                </div>
                <div class="panel-body">
                    <div class="dangky">
                        <form action="dangky.php" method="POST">
                            <div class="form-group">
                                <?php
                                $emaildaco = isset($_GET['error']) ? $_GET['error'] : '';
                                if ($emaildaco == "emaildaco") {
                                echo '<div class="alert alert-danger">
                                Đã Tồn Tại Email!!
                                </div>';
                                }
                                ?>
                                <label for="usr">Name: </label>
                                <input required="true" type="text" class="form-control" id="usr" name="name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input required="true" type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="form-group">
                                <label for="birthday">Birthday:</label>
                                <input required="true" type="date" class="form-control" id="birthday" name="ngaysinh">
                            </div>
                            <div class="form-group">
                                <?php
                                $khongkhop = isset($_GET['error']) ? $_GET['error'] : '';
                                if ($khongkhop == "khongkhop") {
                                echo '<div class="alert alert-danger">
                                PassWord không khớp!!
                                </div>';
                                }
                                ?>
                                <label for="pwd">Password:
                                </label>
                                <input required="true" type="password" class="form-control" id="pwd" name="password">
                            </div>
                            <div class="form-group">
                                <label for="confirmation_pwd">Confirmation Password:</label>
                                <input required="true" type="password" class="form-control" id="confirmation_pwd"
                                    name="nhaplaipassword">
                            </div>
                            <button class="btn btn-success">Register</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>


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