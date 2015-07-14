<?php require_once './header.php'; ?>
<?php
if(isset($_GET["masach"])) {
    //
    //Update luot xem
    $masach=$_GET["masach"];
    $stmt=$dbh->prepare("UPDATE sach SET LuotXem=LuotXem+ 1 WHERE MaSach=?");
    $stmt->bindParam(1, $_GET["masach"], PDO::PARAM_INT);
    $stmt->execute();
    
    $matheloai="";
    $stmt = $dbh -> prepare("SELECT      * " .
                            "FROM        sach, tacgia, nhaxuatban, theloaisach " .
                            "WHERE       sach.MaTacGia = tacgia.MaTacGia AND " .
                            "            sach.MaNhaXuatBan = nhaxuatban.MaNhaXuatBan AND " .
                            "            sach.MaTheLoai = theloaisach.MaTheLoai AND " .
                            "            sach.MaSach = ?");
    $stmt -> bindParam(1, $_GET["masach"], PDO::PARAM_INT);
    $stmt -> execute();
    $row = $stmt -> fetch();
    $matheloai = $row["MaTheLoai"];
?>
<div class="container page-width-limited" id="page-content">
    <div id="page-main-content" class="col-sm-9">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    THÔNG TIN SÁCH
                </div>
                <div class="panel-body">
                    <div class="col-sm-4">
                        <img class="small" src="<?php echo $row["Hinh"]; ?>" width="200px" height="250px" />
                    </div>
                    <div class="col-sm-8">
                        <div>
                        <span class="text-primary text-uppercase"><b><?php echo $row["TenSach"]; ?></b></span><br />
                        Thể loại: <a href="booklist.php?matheloai=<?php echo $row["MaTheLoai"]; ?>"><?php echo $row["TenTheLoai"]; ?></a><br />
                        Tác giả: <a href="booklist.php?matacgia=<?php echo $row["MaTacGia"]; ?>"><?php echo $row["TenTacGia"]; ?></a><br />
                        Nhà xuất bản: <?php echo $row["TenNhaXuatBan"]; ?><br/>
                        Kích thước: <?php echo $row["KichThuoc"]; ?><br/>
                        Trong lượng: <?php echo $row["TrongLuong"]; ?> (gram)<br/>
                        Giá bán: <span class="text-danger"><?php echo $row["GiaBia"]; ?> VNĐ</span>
                        </div>
                        <?php
                            if($row["SoLuongTon"]>0){                            
                        ?>
                        <form action="giohang-exe.php" method="post">
                            <input name="masach" type="hidden" value="<?php echo $masach;?>">
                            <button style="margin-top:20px;" class="btn btn-success">
                                <span class="glyphicon glyphicon-shopping-cart"></span> Thêm vào giỏ hàng
                            </button>
                        </form>
                        <?php
                            }
                            else{
                        ?>
                            <a href="#" class="btn btn-warning">
                                <span class="glyphicon glyphicon-shopping-cart"></span> Đã hết hàng
                            </a>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    SÁCH KHÁC CÙNG THỂ LOẠI
                </div>
                <div class="panel-body">
                    <div class="list-group list-inline">
                        <?php
                        $stmt = $dbh -> prepare("SELECT      * " . 
                                                "FROM        sach, tacgia, theloaisach " .
                                                "WHERE       sach.MaTacGia = tacGia.MaTacGia and theloaisach.MaTheLoai=sach.MaTheLoai " .
                                                "and   sach.MaTheLoai = ".$matheloai." " .
                                                "ORDER BY    LuotXem DESC " . 
                                                "LIMIT       0, 6");
                        $stmt -> execute();
                        while($row = $stmt -> fetch()) { 
                        ?>
                        <li class="col-sm-2">
                            <div class="list-group">
                                <a class="list-group-item" href="bookdetail.php?masach=<?php echo $row["MaSach"]; ?>">
                                    <img class="masterTooltip" src="<?php echo $row["Hinh"]; ?>" title="<?php echo $row["TenSach"]; ?>" width="100" height="150" />
                                </a>
                            </div>
                        </li>
                        <?php
                        }
                        ?>
                    </div>
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