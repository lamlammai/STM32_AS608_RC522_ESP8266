<?php
	$Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
	file_put_contents('UIDContainer.php',$Write);
?>

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
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<link href="css/quanly.css" rel="stylesheet">
		<script src="js/bootstrap.min.js"></script>
		<script src="jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
		<script>
			$(document).ready(function(){
				 $("#getUID").load("UIDContainer.php");
				setInterval(function() {
					$("#getUID").load("UIDContainer.php");	
				}, 500);
			});
		</script>
		<style>
		html {
			font-family: Arial;
			display: inline-block;
			margin: 0px auto;
			text-align: center;
		}

		ul.topnav {
			list-style-type: none;
			margin: auto;
			padding: 0;
			overflow: hidden;
			background-color: #4CAF50;
			width: 70%;
		}

		ul.topnav li {float: left;}

		ul.topnav li a {
			display: block;
			color: white;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
		}

		ul.topnav li a:hover:not(.active) {background-color: #3e8e41;}

		ul.topnav li a.active {background-color: #333;}

		ul.topnav li.right {float: right;}

		@media screen and (max-width: 600px) {
			ul.topnav li.right, 
			ul.topnav li {float: none;}
		}
		
		td.lf {
			padding-left: 15px;
			padding-top: 12px;
			padding-bottom: 12px;
		}
		</style>
		
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
                            <a class="nav-link  " href="diemdanh.html">Điểm Danh</a>
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

		
		<p id="getUID" hidden></p>
		<div class="container_swap">
		<div class="div_left">
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
                        <input required="true" type="text"  class="form-control" id="uid" name="id" value="<?=$s_id?>">
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
		</div>
		<div id="show_user_data"class="div_right" >
			<form action="quanly.php">
				<table  width="452" border="1" bordercolor="#10a0c5" cellpadding="0" cellspacing="1"  bgcolor="#000" style="padding: 2px">
					<tr>
						<td  height="40"   bgcolor="#10a0c5"><font  color="#FFFFFF">
							<b>User Data</b>
							</font>
						</td>
					</tr>
					<tr>
						<td  bgcolor="#f9f9f9">
							<table width="452"  border="0"  cellpadding="5"  cellspacing="0">
								<tr>
									<td width="113" align="left" class="lf">UID</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
								<tr bgcolor="#f2f2f2">
									<td align="left" class="lf">Name</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
								<tr>
									<td align="left" class="lf">MSSV</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
								<tr bgcolor="#f2f2f2">
									<td align="left" class="lf">Email</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
								<tr>
									<td align="left" class="lf">Mobile Number</td>
									<td style="font-weight:bold">:</td>
									<td align="left">--------</td>
								</tr>
							</table>	
						</td>
					</tr>	
				</table>
			</form>	
		</div>	
		
		</div>
		
		

		
		

		<script>
			var myVar = setInterval(myTimer, 1000);
			var myVar1 = setInterval(myTimer1, 1000);
			var oldID="";
			clearInterval(myVar1);

			function myTimer() {
				var getID=document.getElementById("getUID").innerHTML;
				oldID=getID;
				if(getID!="") {
					myVar1 = setInterval(myTimer1, 500);
					showUser(getID);
					clearInterval(myVar);
					
				}
			}
			
			function myTimer1() {
				var getID=document.getElementById("getUID").innerHTML;
				if(oldID!=getID) {
					myVar = setInterval(myTimer, 500);
					clearInterval(myVar1);
				}
			}
			
			function showUser(str) {
				if (str == "") {
					document.getElementById("show_user_data").innerHTML = "";

					return;
				} else {
					if (window.XMLHttpRequest) {
						// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
					} else {
						// code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById("show_user_data").innerHTML = this.responseText;
					
						}
					};
					xmlhttp.open("GET","read tag user data.php?id="+str,true);
					xmlhttp.send();
				
				}
			}
			
			var blink = document.getElementById('blink');
			setInterval(function() {
				blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
			}, 750); 
			
			
        function UID(){
           
            document.getElementById("uid").innerHTML = $data['id'];
        }
		</script>
	</body>
	<style>

.container_swap{

width: 100%;

}

.div_left{

width: 50%;

float: left;



}

.div_right{

width: 40%;
margin-left: 10%;
margin-top: 10%;
float: left;

text-align: center;

}

</style>
</html>
