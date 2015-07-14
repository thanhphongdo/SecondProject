<?php
	session_start();
	require "libs/db.php";
	if(isset($_POST["taikhoan"])){
		$taikhoan=$_POST["taikhoan"];
		$tieude=$_POST["tieude"];
		$noidung=$_POST["noidung"];
		$ngaygui=date("Y-m-d");

		$sql="INSERT INTO `gopy`(`TaiKhoan`, `TieuDe`, `NoiDung`, `NgayGui`) 
			  VALUES ('$taikhoan','$tieude','$noidung','$ngaygui')";
		$stmt=$dbh->prepare($sql);
		$stmt->execute();
		$_SESSION["tam"]="<span class='glyphicon glyphicon-ok'></span>"." "."Đã gửi thành công";
	}
?>