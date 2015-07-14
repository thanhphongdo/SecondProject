<?php session_start(); ?>
<?php require_once '../libs/db.php'; ?>
<?php
if(isset($_POST["oldPassword"]) && isset($_POST["newPassword"])) {
	$stmt = $dbh -> prepare("SELECT		* " .
																		"FROM			quantri " .
																		"WHERE		TaiKhoan=? AND " .
																		"								MatKhau=?");
	$stmt -> bindParam(1, $_SESSION["adminUsername"], PDO::PARAM_STR);
	$stmt -> bindParam(2, md5($_POST["oldPassword"]), PDO::PARAM_STR);
	$stmt -> execute();
	if($stmt -> rowCount() > 0) {
		$stmt = $dbh -> prepare("UPDATE		quantri	"	.
																		"SET						MatKhau=? " .
																		"WHERE			TaiKhoan=?");
		$stmt -> bindParam(1, md5($_POST["newPassword"]), PDO::PARAM_STR);
		$stmt -> bindParam(2, $_SESSION["adminUsername"], PDO::PARAM_STR);
		$stmt -> execute();
		echo "<script>alert('Đổi mật khẩu thành công')</script>";
	}
	else {
		echo "<script>alert('Mật khẩu cũ không đúng')</script>";
	}
}
?>	
<div class="row">&nbsp;</div>
<div class="row">&nbsp;</div>
<div class="row">&nbsp;</div>
<div class="row">&nbsp;</div>
<div class="col-sm-2">&nbsp;</div>
<div class="col-sm-8">   
	<div class="panel panel-primary">
		<div class="panel-heading">
			ĐỔI MẬT KHẨU
		</div>
		<div class="panel-body">
			<form class="form-horizontal">
				<div id="divChangePasswordResult">
					<span>&nbsp;</span>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Tên đăng nhập</label>
					<div class="col-sm-8">
						<p class="form-control-static"><?php echo $_SESSION['adminUsername']; ?></p>
					</div>
				</div>
				<div class="form-group">
					<label for="txtOldPassword" class="col-sm-4 control-label">Mật khẩu</label>
					<div class="col-sm-8">
						<input type="password" class="form-control" id="txtOldPassword" name="txtOldPassword" placeholder="Nhập mật khẩu cũ">
					</div>
				</div>
				<div class="form-group">
					<label for="txtNewPassword" class="col-sm-4 control-label">Mật khẩu mới</label>
					<div class="col-sm-8">
						<input type="password" class="form-control" id="txtNewPassword" name="txtNewPassword" placeholder="Nhập mật khẩu mới">
					</div>
				</div>
				<div class="form-group">
					<label for="txtReNewPassword" class="col-sm-4 control-label">Nhập lại mật khẩu mới</label>
					<div class="col-sm-8">
						<input type="password" class="form-control" id="txtReNewPassword" name="txtReNewPassword" placeholder="Nhập lại mật khẩu mới">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<button type="button" id="btnSubmitChangePassword" name="btnSubmitChangePassword" class="btn btn-info">Đổi mật khẩu</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="col-sm-2"></div>
<div class="row">&nbsp;</div>
<div class="row">&nbsp;</div>
<div class="row">&nbsp;</div>
<div class="row">&nbsp;</div>
<?php require_once './footer.php'; ?>