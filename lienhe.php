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
                    GÓP Ý - LIÊN HỆ 
                </div>
                <div class="panel-body">
                    <?php
                        $taikhoan=$_SESSION["usernameKH"];
                        $sql="select * from thanhvien where taikhoan='$taikhoan'";
                        $stmt = $dbh -> prepare($sql);
                        $stmt -> execute();
                        $row = $stmt -> fetch();
                    ?>
                            <h4 class="text-primary" style="line-height:0;"><b>Thông tin thành viên</b></h4>
                            <hr>
                            <p>- Tài khoản: <b id="taikhoan-gopy" class="text-primary"><?php echo $row["TaiKhoan"]; ?></b></p>
                            <p>- Họ tên: <b class="text-primary"><?php echo $row["HoTen"]; ?></b></p>
                            <p>- Giới tính: <b class="text-primary"><?php echo $row["GioiTinh"]; ?></b></p>
                            <p>- Địa chỉ: <b class="text-primary"><?php echo $row["DiaChi"]; ?></b></p>
                            <p>- Số điện thoại:<b class="text-primary"><?php echo $row["DienThoai"]; ?></b></p>
                            <p>- Email: <b class="text-primary"><?php echo $row["Email"]; ?></b></p>
                            <hr>

                		<div class="form-group">
                			<label class="text-primary">Tiêu đề</label>
                			<input id="tieude-gopy" class="form-control" type="text" placeholder="Nhập tiêu đề" autofocus >
                		</div>
                        <div class="form-group">
                            <label class="text-primary">Nội dung</label>
                            <textarea id="noidung-gopy" class="form-control" style="resize: none" 
                                rows="15" placeholder="Nhập nội dung"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="text-primary">
                                
                                <?php echo isset($_SESSION["tam"])?$_SESSION["tam"]:""; unset($_SESSION["tam"]); ?>
                            </label>
                            
                        </div>
                        <div class="form-inline">
                            <button id="gui-gopy" button="button" style="margin-right:10px;" 
                                    class="btn btn-info"><span class="glyphicon glyphicon-send"></span> Gửi</button>
                            <a href="index.php"><button button="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Huỷ</button></a>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once './rightside.php'; ?>
</div>
<?php require_once './footer.php'; } ?>