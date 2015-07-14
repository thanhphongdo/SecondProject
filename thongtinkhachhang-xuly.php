<?php
	session_start();
	require "libs/db.php";
	if(isset($_POST["btnSubmit"])){
		$hoten=$_POST["txtHoTen"];
		$diachi=$_POST["txtDiaChi"];
		$SDT=$_POST["txtSDT"];
		$Email=$_POST["txtEmail"];
		$GioiTinh = $_POST["rdoGioiTinh"];

		$sql="UPDATE `thanhvien` SET HoTen = '".$hoten."', DiaChi = '".$diachi."', DienThoai = '".$SDT."', Email = '".$Email."', GioiTinh = '".$GioiTinh."' WHERE TaiKhoan = '".$_SESSION['usernameKH']."'";
		// $sql;
		$stmt=$dbh->prepare($sql);
		$stmt->execute();
		$_SESSION["tam"]="<span class='glyphicon glyphicon-ok'></span>"." "."Đã cập nhật thành công";
		header("location: thongtinkhachhang.php");
	}
?>