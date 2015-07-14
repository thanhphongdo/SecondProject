<?php session_start(); ?>
<?php require_once './header.php'; ?>
<?php require_once '../libs/db.php'; ?>
<?php require_once '../libs/CustomerAdapter.php';?>
<?php
    if(!isset($_SESSION['adminUsername'])) {
        if(!isset($_POST['btnLogin'])) {
?>
<div id="page-content">
    <div class="row">&nbsp;</div>
    <div class="row">&nbsp;</div>
    <div class="row">&nbsp;</div>
    <div class="row">&nbsp;</div>
    <div class="col-sm-2">&nbsp;</div>
    <div class="col-sm-8">
        <form role="form" action="index.php" method="POST" class="form-horizontal">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    ĐĂNG NHẬP HỆ THỐNG
                </div>
                <div class="panel-body">
                    <div class="form-group input-group-sm has-success">
                        <label class="control-label col-sm-4 masterTooltip">Tên đăng nhập</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" name="txtUsername" id="txtUsername" placeholder="Nhập tên đăng nhập" />
                        </div>
                    </div>
                    <div class="form-group input-group-sm has-success">
                        <label class="control-label col-sm-4">Mật khẩu</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="password" name="txtPassword" id="txtPassword" placeholder="Nhập mật khẩu" />
                        </div>
                    </div>
                    <div class="form-group input-group-sm">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-7 text-right">
                            <button class="btn btn-success" type="submit" name="btnLogin" id="btnLogin" value="Đăng nhập">
                                <span>Đăng nhập</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-2"></div>
    <div class="row">&nbsp;</div>
    <div class="row">&nbsp;</div>
    <div class="row">&nbsp;</div>
    <div class="row">&nbsp;</div>
</div>
<?php
        }
        else {
            $stmt = $dbh -> prepare("SELECT  * " . 
                                    "FROM    quantri " . 
                                    "WHERE   TaiKhoan=? AND " .
                                    "        MatKhau=?");
            $stmt -> bindParam(1, $_POST['txtUsername'], PDO::PARAM_STR);
            $stmt -> bindParam(2, md5($_POST['txtPassword']), PDO::PARAM_STR);
            $stmt -> execute();
            if($stmt -> rowCount() > 0) {
                $_SESSION['adminUsername'] = $_POST['txtUsername'];
                echo "<script>alert('Đăng nhập thành công');</script>";
            }
            else {
                echo "<script>alert('Đăng nhập thất bại');</script>";
            }
            echo '<meta http-equiv="refresh" content="0;URL=./">';
        }
    }
    else {
?>
<?php require_once './menu.php'; ?>
<div id="thanhvien">
</div><!-- Dong id hoadon -->
<div id="page-content">
<?php
    }
?>
<?php
if(isset($_SESSION['adminUsername'])){
?>
<div class="col-sm-12">
    <div class="panel panel-primary">
        <input type="hidden" id="tv" value="1">
        <div class="panel-body" id="resultCus">
        </div>
    </div>
</div>
<?php
}
?>
</div>

<?php require_once './footer.php'; ?>

