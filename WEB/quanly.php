<?php
    include 'dbhelp.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/quanly.css">
    <title>Document</title>
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
    <div class="bottom"   >
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Quản lý thông tin sinh viên
                <form method="get">
                    <input type="text" name="s" class="form-control" style="margin-top: 15px; margin-bottom: 15px;"
                        placeholder="Tìm kiếm theo tên">
                </form>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>UID</th>
                            <th>Họ & Tên</th>
                            <th>MSSV</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th width="60px"></th>
                            <th width="60px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                       $sql = "SELECT * FROM user";
                       $studentList = executeResult($sql);
                       $index = 1;
                       foreach ($studentList as $std) {
                            echo ' <tr>
                            <td>'.($index++).'</td>
                            <td>'.$std['id'].'</td>
                            <td>'.$std['name'].'</td>
                            <td>'.$std['mssv'].'</td>
                            <td>'.$std['email'].'</td>
                            <td>'.$std['mobile'].'</td>
                            <td><button class="btn btn-warning" onclick=\'window.open("input.php?stt='.$std['stt'].'","_self")\'>Edit</button></td>
                            <td><button class="btn btn-danger" onclick="deleteStudent('.$std['stt'].')">Delete</button></td>
                        </tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <div class="chia">
                <button class="btn btn-success" onclick="window.open('read tag.php', '_self')">Add Student</button>
                </div>
          

           
            </div>
        </div>
    </div>
    </div>
    
    <script type="text/javascript">
		function deleteStudent(stt) {
			option = confirm('Bạn có muốn xoá sinh viên này không')
			if(!option) {
				return;
			}

			console.log(stt)
			$.post('delete.php', {
				'stt': stt
			}, function(data) {
				alert(data)
				location.reload()
			})
		}
	</script>

 

</body>

</html>