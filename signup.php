<?php require_once './header.php'; ?>
<script type="text/javascript" src="js/script-dk.js"></script>
<div class="container page-width-limited" id="page-content">
    <div id="page-main-content" class="col-sm-9">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading" style="text-align:center">Đăng ký thành viên</div>
            	<div class="panel-body">
					<form method="POST" id="frmDangKy" action="<?php echo($_SERVER['PHP_SELF']) ?>" class="form-horizontal frmThemSV">
						<div class="form-group has-success has-feedback">
						    <label class="control-label col-sm-3">Tài khoản:</label>
						    <div class="col-sm-7">
						      	<input type="textbox" name="txtDKUser" class="form-control" id="txtDKUser" placeholder="Tên đăng nhập" data-info = "Tên đăng nhập không được để trống!">
						      	<!--<div id="message-user"></div>-->
						    </div>
						</div>
						<div class="form-group has-success has-feedback">
						    <label class="control-label col-sm-3">Họ và tên:</label>
						    <div class="col-sm-7">
						      	<input type="textbox" name="txtDKHoTen" class="form-control" id="txtDKHoTen" placeholder="Họ và tên" data-info = "Họ và tên không được để trống!">
						    </div>
						</div>
						<div class="form-group has-success">
						    <label class="control-label col-sm-3">Ngày sinh:</label>
						    <div class="col-sm-7">
						    	<input type="date" name="txtDKNgaySinh" name="bday" max="2050-12-31" id="txtDKNgaySinh" class="form-control" data-info = "Bạn chưa nhập ngày sinh!">
						    </div>
						</div>
						<div class="form-group has-success has-feedback">
						    <label class="control-label col-sm-3">Giới tính:</label>
						    <div class="col-sm-7">
						      	<select name="slGioiTinh" class="form-control" id="slGioiTinh">
						      		<option value="Nam">Nam</option>
						      		<option value="Nữ">Nữ</option>
						      	</select>
						    </div>
						</div>
						<div class="form-group has-success has-feedback">
						    <label class="control-label col-sm-3">Địa chỉ:</label>
						    <div class="col-sm-7">
						      	<input type="textbox" name="txtDKDiaChi" class="form-control" id="txtDKDiaChi" placeholder="Địa chỉ" data-info = "Địa chỉ không được để trống!">
						    </div>
						</div>
						<div class="form-group has-success has-feedback">
						    <label class="control-label col-sm-3">Mật khẩu:</label>
						    <div class="col-sm-7">
						      	<input type="password" name="txtDKMatKhau" class="form-control" id="txtDKMatKhau" placeholder="Nhập Mật khẩu" data-info = "Mật khẩu không được để trống!">
						    </div>
						</div>
						<div class="form-group has-success has-feedback">
						    <label class="control-label col-sm-3">Xác nhận mật khẩu:</label>
						    <div class="col-sm-7">
						      	<input type="password" name="txtDKXNMatKhau" class="form-control" id="txtDKXNMatKhau" placeholder="Xác nhận mật khẩu" data-info = "Xác nhận sai">
						    </div>
						</div>
						<div class="form-group has-success has-feedback">
						    <label class="control-label col-sm-3">Điện thoại:</label>
						    <div class="col-sm-7">
						      	<input type="text" name="txtDKDienThoai" class="form-control" id="txtDKDienThoai" placeholder="Số điện thoại" data-info = "Số điện thoại không được để trống!">
						    </div>
						</div>
						<div class="form-group has-success has-feedback">
						    <label class="control-label col-sm-3">Email:</label>
						    <div class="col-sm-7">
						      	<input type="email" name="txtDKEmail" class="form-control" id="txtDKEmail" placeholder="Nhập email" data-info = "Email không được để trống!">
						    </div>
						</div>
						<div class="form-group has-success has-feedback">
						    <label class="control-label col-sm-3">Quy định:</label>
						    <div class="col-sm-7">
						    	<iframe src="" width="100%" id="ifQD"></iframe>
						    </div>
						</div>
						<div class="form-group has-success has-feedback">
						    <label class="control-label col-sm-3"></label>
						    <div class="col-sm-7">
						      	<input type="checkbox" name="chkDongY" class="" id="chkDongY">
						      	<label class="control-label">Bạn có đồng ý với những quy định trên?</label>
						    </div>
						</div>
						<div class="form-group">
							<div class="col-sm-3"></div>				    
							<div class="col-sm-7" style="text-align:right">
						      	<button type="submit" name="btnSM" id="btnSM" class="btn btn-primary" onclick="return testSubmit()">
						      	<span class="glyphicon glyphicon-floppy-saved"> Register</span></button>
						      	<button type="reset" id="btnReset" class="btn btn-primary">
						      	<span class="glyphicon glyphicon-refresh"> Refresh</span></button>
						    </div>
						</div>
					</form>
            	</div>
            </div>
        </div> 
    </div>
    <?php require_once './rightside.php'; ?>
</div>
<div id="error" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title active">Thông báo lỗi</h4>
            </div>
            <form name="DangXuat" action="" class="form-horizontal">
            <div class="modal-body" id="mess">
            	Thông tin đăng ký không phù hợp. Bạn có muốn đăng ký lại?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnSignUp" data-dismiss="modal">Đăng ký lại</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div id="success" class="modal fade" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title active">Thông báo</h4>
            </div>
            <form name="DangXuat" action="" class="form-horizontal">
            <div class="modal-body" id="mess">
            	Đăng ký thành công!
            </div>
            <div class="modal-footer">
                <button type="button" id="btnDong" class="btn btn-primary" data-dismiss="modal">Đóng</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php
	if(isset($_POST['btnSM'])){
		require "./libs/db.php";
		$user = strtoupper($_POST['txtDKUser']);
		$hoten = $_POST['txtDKHoTen'];
		$ngaysinh = $_POST['txtDKNgaySinh'];
		$gioitinh = $_POST['slGioiTinh'];
		$diachi = $_POST['txtDKDiaChi'];
		$matkhau = md5($_POST['txtDKMatKhau']);
		$dienthoai = $_POST['txtDKDienThoai'];
		$email = $_POST['txtDKEmail'];
		$locked = '0';
		$sql = "INSERT INTO `thanhvien` (`TaiKhoan`, `MatKhau`, `HoTen`, `NgaySinh`, `GioiTinh`, `DiaChi`, `DienThoai`, `Email`, `Locked`) VALUES (?,?,?,?,?,?,?,?,'0')";
		$stmt = $dbh->prepare($sql);
        $stmt->bindParam(1,$user,PDO::PARAM_STR);
        $stmt->bindParam(2,$matkhau,PDO::PARAM_STR);
        $stmt->bindParam(3,$hoten,PDO::PARAM_STR);
        $stmt->bindParam(4,$ngaysinh,PDO::PARAM_STR);
        $stmt->bindParam(5,$gioitinh,PDO::PARAM_STR);
        $stmt->bindParam(6,$diachi,PDO::PARAM_STR);
        $stmt->bindParam(7,$dienthoai,PDO::PARAM_STR);
        $stmt->bindParam(8,$email,PDO::PARAM_STR);
		$stmt->execute();
		echo('<input type="hidden" value="true" id="sign">');
		echo '<meta http-equiv="refresh" content="1;URL=index.php">';
	}
?>
<?php require_once './footer.php'; ?>