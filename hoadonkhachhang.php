<?php require_once './header.php'; ?>
<?php
if(isset($_SESSION["usernameKH"])) {

    $stmt = $dbh -> prepare("
                            SELECT donhang.MaDonHang, NgayDH, NgayGH, TrangThai
                            FROM thanhvien, donhang, chitietdonhang
                            WHERE thanhvien.TAIKHOAN = donhang.TAIKHOAN 
                            and donhang.MaDonHang = chitietdonhang.MaDonHang 
                            and donhang.TAIKHOAN = ?
                            GROUP BY donhang.MaDonHang
                            ");
    $stmt -> bindParam(1, $_SESSION["usernameKH"], PDO::PARAM_STR);
    $stmt -> execute();
    $count = $stmt->rowCount();
?>
<div class="container page-width-limited" id="page-content">
    <div id="page-main-content" class="col-sm-9">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    DANH SÁCH ĐƠN HÀNG ĐÃ ĐẶT
                </div>
                <div class="panel-body">
                    <a href="index.php" class="btn btn-primary"> <span class="glyphicon glyphicon-plus-sign"></span> Tiếp tục mua sách mới </a>                  
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="info">
                                <th width="5%">STT</th>
                                <th>Mã đơn hàng</th>
                                <th width="25%">Ngày đặt hàng</th>
                                <th width="25%">Ngày giao hàng</th>
                                <th width="10%">Trạng thái</th>
                                <th>Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            while($row = $stmt -> fetch()) {
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row["MaDonHang"]; ?></td>
                                <td><?php echo $row["NgayGH"]; ?></td>
                                <td><?php echo $row["NgayDH"]; ?></td>
                                <td><?php echo (($row["TrangThai"]=="1"?"đã giao":"chưa giao")); ?></td>
                                <td>
                                    <a 
                                       href='?madh=<?php echo $row["MaDonHang"] ?>'>
                                       <span class="glyphicon glyphicon-eye-open"></span> Xem chi tiết
                                    </a>

                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
            if(isset($_GET['madh'])){
                $madonhang = $_GET['madh'];
        ?>
            
            
        <?php
                 $stmt = $dbh -> prepare("
                            SELECT TenSach, SoLuong FROM chitietdonhang, sach, donhang WHERE sach.MaSach = chitietdonhang.MaSach and donhang.MaDonHang = chitietdonhang.MaDonHang and donhang.TaiKhoan = ? and chitietdonhang.MaDonHang = ?
                            ");
                            $stmt -> bindParam(1, $_SESSION["usernameKH"] , PDO::PARAM_STR);
                            $stmt -> bindParam(2, $madonhang , PDO::PARAM_STR);
                            $stmt -> execute();
                            $count = $stmt->rowCount();

                            if($count>0){
                            ?>
                <b>CHI TIẾT ĐƠN HÀNG <?php echo $madonhang ?></b>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="info">
                                <th width="5%">STT</th>
                                <th>Tên sách</th>
                                <th width="15%">Số lượng</th>
                            </tr>
                        </thead>
                            <?php
                            $i = 1;
                            while($row = $stmt -> fetch()) {
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row["TenSach"]; ?></td>
                                <td><?php echo $row["SoLuong"]; ?></td>
                            </tr>
                            <?php
                            }
                            echo "</table>";
                        }
                        
            }
        ?>
                </div>
            </div>
        </div>

    </div>
    <?php require_once './rightside.php'; ?>
</div>

<?php
}
else {
    echo '<meta http-equiv="refresh" content="0;URL=index.php">';
}
?>
<?php require_once './footer.php'; ?>