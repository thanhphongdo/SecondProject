<?php session_start(); ?>
<?php require_once './header.php'; ?>
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
        <div class="panel panel-primary">
            <div class="panel-heading">
                ĐĂNG NHẬP HỆ THỐNG
            </div>
            <div class="panel-body">
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                <div class="form-group">
                        <label for="txtUsername" class="col-sm-3 control-label">Tên đăng nhập</label>
                                            <div class="col-sm-9">
                        <input class="form-control" type="text" name="txtUsername" id="txtUsername" placeholder="Nhập tên đăng nhập" />
                                            </div>
                </div>
                                    <div class="form-group">
                        <label for="txtPassword" class="col-sm-3 control-label">Mật khẩu</label>
                                        <div class="col-sm-9">
                        <input class="form-control" type="password" name="txtPassword" id="txtPassword" placeholder="Nhập mật khẩu" />
                                        </div>
                                    </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <input class="btn btn-success" type="submit" name="btnLogin" id="btnLogin" value="Đăng nhập" />
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
<div id="page-content">
    
</div>
<?php
    }
?>
<?php require_once './footer.php'; ?>
