<?php
if (isset($_POST['stt'])) {
	$stt = $_POST['stt'];

	require_once ('dbhelp.php');
	$sql = 'delete from user where stt = '.$stt;
	execute($sql);

	echo 'Xoá sinh viên thành công';
}