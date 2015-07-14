<?php
    session_start();
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    if(!isset($_SESSION["usernameKH"])){
        echo '<meta http-equiv="refresh" content="0;URL=index.php">';
    }
    else{
    require_once './header.php'; 
?>
<div class="container page-width-limited" id="page-content">
    <div id="page-main-content" class="col-sm-9">
		<div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    THÔNG TIN KHÁCH HÀNG 
                </div>
                <div class="panel-body">
                    <?php
                        $taikhoan=$_SESSION["usernameKH"];
                        $sql="select * from thanhvien where taikhoan='$taikhoan'";
                        $stmt = $dbh -> prepare($sql);
                        $stmt -> execute();
                        $row = $stmt -> fetch();
                    ?>
                    <form name="frmCapNhatKhachHang" method="POST" action="thongtinkhachhang-xuly.php">
                            <h4 class="text-primary" style="line-height:0;"><b>Cập nhật thông tin thành viên</b></h4>
                            <hr>
                            <div class="form-group">
                                <label class="text-primary">Họ tên</label>
                                <input required class="form-control" name="txtHoTen" value="<?php echo $row["HoTen"]; ?>" autofocus >
                            </div>
                            <?php
                                if($row["GioiTinh"]=="Nam"){
                            ?>
                                <div class="form-group">
                                    <label class="text-primary">Giới tính</label>
                                    <input  name="rdoGioiTinh" type="radio" value="Nam" checked="checked" /> Nam
                                    <input  name="rdoGioiTinh" type="radio" value="Nu"  /> Nữ
                                </div>
                            <?php
                                }
                                else{
                            ?>
                                <div class="form-group">
                                    <label class="text-primary">Giới tính</label>
                                    <input  name="rdoGioiTinh" type="radio" value="Nam"  /> Nam
                                    <input  name="rdoGioiTinh" type="radio" value="Nu" checked="checked"/> Nữ
                                </div>
                            <?php
                                }
                            ?>
                            
                            <div class="form-group">
                                <label class="text-primary">Địa chỉ</label>
                                <input required class="form-control" name="txtDiaChi" type="text" value="<?php echo $row["DiaChi"]; ?>" autofocus >
                            </div>
                            <div class="form-group">
                                <label class="text-primary">Số điện thoại</label>
                                <input required class="form-control" name="txtSDT" type="text" value="<?php echo $row["DienThoai"]; ?>" autofocus >
                            </div>
                            <div class="form-group">
                                <label class="text-primary">Email</label>
                                <input required class="form-control" name="txtEmail" type="email" value="<?php echo $row["Email"]; ?>" autofocus >
                            </div>
                            
                        <div class="form-group">
                            <label class="text-primary">
                                
                                <?php echo isset($_SESSION["tam"])?$_SESSION["tam"]:""; unset($_SESSION["tam"]); ?>
                            </label>
                            
                        </div>
                        <div class="form-inline">
                            <button id="luuthongtin" type="submit" name="btnSubmit" style="margin-right:10px;" 
                                    class="btn btn-info"><span class="glyphicon glyphicon-floppy-disk"></span> Lưu thông tin</button>
                            <a href="index.php" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Đóng</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php require_once './rightside.php'; ?>
</div>
<?php require_once './footer.php'; } ?>