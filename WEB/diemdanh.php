<?php
	$Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
	file_put_contents('UIDContainer.php',$Write);
	include 'dbhelp.php';
	include 'export.php';
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
                            <a class="nav-link"  href="quanly.php">Danh Sách Sinh Viên</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="điemanh.html">Điểm Danh</a>
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
		<div id="show_user_data" class="div_left">
	
			<form action="quanly.php">
				<table  width="400" border="1" bordercolor="#10a0c5"  cellpadding="0" cellspacing="1"  bgcolor="#000" style="padding: 2px">
					<tr>
						<td  height="40"  bgcolor="#10a0c5"><font  color="#FFFFFF">
							<b>User Data</b>
							</font>
						</td>
					</tr>
					<tr>
						<td  bgcolor="#f9f9f9">
							<table width="400"  border="0"  cellpadding="5"  cellspacing="0">
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
		<div class="div_right">
			
		<div class="panel-body">
		<button class="btn btn-danger" onclick="deletedanhsach()">Delete</button>
		
		<button class="btn btn-danger" name="export" >EXPORT FILE</button>
	
		
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th  height="40"  bgcolor="#10a0c5"><font  color="#FFFFFF">STT</th>
                            <th height="40"  bgcolor="#10a0c5"><font  color="#FFFFFF">UID</th>
                            <th height="40"  bgcolor="#10a0c5"><font  color="#FFFFFF">Họ & Tên</th>
                            <th height="40"  bgcolor="#10a0c5"><font  color="#FFFFFF">MSSV</th>
                            <th height="40"  bgcolor="#10a0c5"><font  color="#FFFFFF">Email</th>
                            <th height="40"  bgcolor="#10a0c5"><font  color="#FFFFFF">Mobile</th>
							<th height="40"  bgcolor="#10a0c5"><font  color="#FFFFFF">Time IN</th>
							<th height="40"  bgcolor="#10a0c5"><font  color="#FFFFFF">Time OUT</th>
                        </tr>
                    </thead>
					<?php
                       $sql = "SELECT * FROM diemdanh";
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
							<td>'.$std['timein'].'</td>    
							<td>'.$std['timeout'].'</td>        
                        </tr>';
						
                        }
					
                        ?>
						 <script>loadweb();</script>
                </table>
				
           
        </div>
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
				else{
					init_reload();
					function init_reload(){
						setInterval( function() {
								window.location.reload();
				
						},1000);
					}
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
					xmlhttp.open("GET","read_diemdanh.php?id="+str,true);
					xmlhttp.send();
				}
			}
			
			var blink = document.getElementById('blink');
			setInterval(function() {
				blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
			}, 750); 
		</script>
		    <script type="text/javascript">
		function deletedanhsach() {
			option = confirm('Bạn có muốn xoá danh sách không')
			if(!option) {
				return;
			}

			console.log()
			$.post('delete_danhsach.php', {
			
			}, function(data) {
				alert(data)
				location.reload()
			})
		}
	</script>
	<style>

.container_swap{

width: 100%;

}

.div_left{


width: 22.5%;

margin-top: 20px;
margin-left:2.5%;
float: left;

text-align: center;


}

.div_right{

	width: 70%;
	margin-left:5%;
	float: left;
	margin-top: 20px;

}

</style>
	</body>
</html>