<?php session_start(); ?>
<?php require_once './header.php'; ?>
<?php require_once '../libs/db.php'; ?>
<?php require_once '../libs/BillAdapter.php';?>
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
<div id="hoadon">
<nav class="navbar navbar-default" style="padding-right:15px;padding-top:7px;margin-right:15px;margin-left:15px;">
    <div class="col-sm-5">
        <button class="btn btn-success" type="button" id="view" data-toggle="modal" data-target="#mdlView">
            <span class="glyphicon glyphicon-eye-open"></span> Xem chi tiết
        </button>
        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#mdlDelete">
            <span class="glyphicon glyphicon-remove-sign"></span> Xóa
        </button>
    </div>
    <form class="form-inline" style="float:right" onsubmit="return false">
        <div class="input-group">
            <input type="text" name="txtSearch" id="txtSearch" class="form-control" placeholder="Bạn cần tìm gì?">
            <span class="input-group-btn">
                <button class="btn btn-primary" type="button" id="btnSearch2">
                    <span class="glyphicon glyphicon-search" />
                </button>
            </span>
        </div>
        <div class="input-group">
            <button class="btn btn-info" type="button" data-toggle="modal" data-target="#mdlSearch">
                <span class="glyphicon glyphicon-plus-sign"></span> Tìm kiếm nâng cao
            </button>
        </div>
    </form>
</nav>
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
        <div class="panel-heading">
            Danh mục hóa đơn
        </div>
        <div class="panel-body" id="result">
        <?php //require('ajax_bill.php'); ?>
        </div>
    </div>
</div>
<?php
}
    //$bill->insert($i,'XUANHOANG33','2014-02-01','2014-02-05','1',($i*50000+$i*$i),($i*$i)/100,'5000');
?>
</div>
<div class="modal fade" id="mdlDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content panel panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Xóa đơn hàng</h4>
            </div>
            <div class="modal-body">
                <div><h3>Bạn có chắc chắn muốn xóa?</h3></div>
                <div class="modal-footer">
                    <button class="btn btn-info" type="button" id="btnXoa" data-dismiss="modal">
                        <span class="glyphicon glyphicon-plus-sign"></span> Đồng ý
                    </button>
                    <button class="btn btn-info" type="button" id="btnDong" data-dismiss="modal">
                        <span class="glyphicon glyphicon-plus-sign"></span> Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdlSearch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content panel panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Tìm kiếm nâng cao</h4>
            </div>
            <div class="modal-body">
                <div><h4>Chọn các điều kiện cần tìm</h4></div>
                <div>
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-6 control-label" style="text-align:left">
                                Ngày lập hóa đơn:
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Từ ngày:</label>
                            <div class="col-sm-4">
                                <input type="date" id="txtTuNgayDH" max="2050-12-31" 
                                id="txtNL-TuNgay" class="form-control">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 control-label">Đến ngày:</label>
                            <div class="col-sm-4">
                                <input type="date" id="txtDenNgayDH" max="2050-12-31" 
                                id="txtNL-DenNgay" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-6 control-label" style="text-align:left">
                                Ngày giao hàng:
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Từ ngày:</label>
                            <div class="col-sm-4">
                                <input type="date" id="txtTuNgayGH" max="2050-12-31" 
                                id="txtNG-TuNgay" class="form-control">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 control-label">Đến ngày:</label>
                            <div class="col-sm-4">
                                <input type="date" id="txtDenNgayGH" max="2050-12-31" 
                                id="txtNG-DenNgay" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 radio">
                                <label style="font-weight: bold;">
                                    <input type="radio" name="hd" value="1"> Hóa đơn đã giao
                                </label>
                            </div>
                            <div class="col-sm-6 radio">
                                <label style="font-weight: bold;">
                                    <input type="radio" name="hd" value="0"> Hóa đơn chưa giao
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="btnSearchUpgade" data-dismiss="modal">Tìm kiếm</button>
                    <button type="button" class="btn btn-primary" id="btnDong" data-dismiss="modal">Đóng</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdlView" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content panel panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Hóa đơn chi tiết</h4>
            </div>
            <div class="modal-body">
                <div id="view-result"></div>
                <div class="modal-footer">
                    <button class="btn btn-info" type="button" id="btnGiaoHang" data-dismiss="modal">
                        <span class="glyphicon glyphicon-send"></span> Giao hàng
                    </button>
                    <button class="btn btn-primary" type="button" id="btnDong" data-dismiss="modal">
                        <span class=""></span> Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once './footer.php'; ?>

