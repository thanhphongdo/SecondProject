<?php require_once '../libs/db.php'; ?>
<?php require_once '../libs/BillAdapter.php';?>
<?php
session_start();
if(isset($_SESSION['adminUsername'])){
	if(isset($_POST['MaDonHang'])){
		$bill = BillAdapter::getInstance($dbh);
		for($i=0;$i<count($_POST['MaDonHang']);$i++){
			$bill->delete($_POST['MaDonHang'][$i]);
		}
		echo '<meta http-equiv="refresh" content="0;URL=hoadon.php">';
	}
}
?>