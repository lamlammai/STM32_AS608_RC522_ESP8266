<?php
    require 'database.php';
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    $pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM user where id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	Database::disconnect();
	$sosanh = true;
	$msg = null;
	if (null==$data['name']) {
		$sosanh = false;
		$msg = "The ID of your Card / KeyChain is not registered !!!";
		$data['id']=$id;
		$data['name']="--------";
		$data['mssv']="--------";
		$data['email']="--------";
		$data['mobile']="--------";
	} else {
		$msg = null;
	}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
	<style>
		td.lf {
			padding-left: 15px;
			padding-top: 12px;
			padding-bottom: 12px;
		}
	</style>
</head>
 	<body>	
		 
		<div class="bottom">
			<form action="quanly.php">
				<table  width="400" border="1" bordercolor="#10a0c5"   cellpadding="0" cellspacing="1"  bgcolor="#000" style="padding: 2px">
					<tr>
						<td  height="40"  bgcolor="#10a0c5"><font  color="#FFFFFF">
						<b>User Data</b></font></td>
					</tr>
					<tr>
						<td bgcolor="#f9f9f9">
							<table width="400"  border="0"  cellpadding="5"  cellspacing="0">
								<tr>
									<td width="113" align="left" class="lf">UID</td>
									<td style="font-weight:bold">:</td>
									
									<td align="left">
									<button type="button"  class="select_btn" >
									<?php 
									echo $data['id'];		
									?>
									</button>
									</td>
								</tr>
								<tr bgcolor="#f2f2f2">
									<td align="left" class="lf">Name</td>
									<td style="font-weight:bold">:</td>
									<td align="left"><?php echo $data['name'];?></td>
								</tr>
								<tr>
									<td align="left" class="lf">MSSV</td>
									<td style="font-weight:bold">:</td>
									<td align="left"><?php echo $data['mssv'];?></td>
								</tr>
								<tr bgcolor="#f2f2f2">
									<td align="left" class="lf">Email</td>
									<td style="font-weight:bold">:</td>
									<td align="left"><?php echo $data['email'];?></td>
								</tr>
								<tr>
									<td align="left" class="lf">Mobile Number</td>
									<td style="font-weight:bold">:</td>
									<td align="left"><?php echo $data['mobile'];?></td>
								</tr>
							</table>
						</td>
					</tr>
					<!-- <button class="btn btn-success" >quaylai</button> -->
				</table>
			
			</form>
		</div>
		<p style="color:red;"><?php echo $msg;?></p>
	<?php
 	include 'dbhelp.php';

	date_default_timezone_set('Asia/Jakarta');
	
	$name = $data['name'];
    $id = $data['id'];
    $email = $data['email'];
    $mssv = $data['mssv'];
    $mobile = $data['mobile'];
	$timein = date("H:i:sa");
	$timeout = date("H:i:sa");

    $sql = "SELECT * FROM diemdanh WHERE id ='$id' and name='$name'";
	$old = mysqli_query($conn,$sql);
	$status = 0;
	// header("location: getUID.php?read=name");    
	if ($sosanh == true)
	{
		if(mysqli_num_rows($old) > 0)
		{
			$sql = "INSERT INTO diemdanh (name,id,email,mobile,mssv,timeout) VALUES ('$name','$id','$email','$mobile','$mssv','$timeout')";
			mysqli_query($conn,$sql);
		  	
		}
		else {
			$sql = "INSERT INTO diemdanh (name,id,email,mobile,mssv,timein) VALUES ('$name','$id','$email','$mobile','$mssv','$timein')";
			mysqli_query($conn,$sql);
		}
	}

	 
	
	?>
	</body>

</html>