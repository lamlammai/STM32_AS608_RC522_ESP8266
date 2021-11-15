<?php


	require_once ('dbhelp.php');
	$sql = 'delete from diemdanh';
	execute($sql);
	echo 'Xoá danh sách thành công';
