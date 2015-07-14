<?php require_once './header.php';
    if(isset($_GET["huygiohang"])){
        unset($_SESSION["giohang"]);
    }
?>
<div class="container page-width-limited" id="page-content">
    <div id="page-main-content" class="col-sm-9">
        <div class="row">
            <div id="sliderFrame">
                <div id="slider">
                    <a href="#"><img src="images/slide1.jpg" alt="Chú thích 01"/></a>
                    <a href="#"><img src="images/slide2.jpg" alt="Chú thích 02"/></a>
                    <a href="#"><img src="images/slide3.jpg" alt="Chú thích 03"/></a>
                    <a href="#"><img src="images/slide4.jpg" alt="Chú thích 04"/></a>
                    <a href="#"><img src="images/slide5.jpg" alt="Chú thích 05"/></a>
                    <a href="#"><img src="images/slide6.jpg" alt="Chú thích 06"/></a>
                </div>
            </div>
        </div>
        <div class="row">&nbsp;</div>
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    MỚI NHẤT
                </div>
                <div class="panel-body">
                    <div class="list-group list-inline">
                        <?php
                        $stmt = $dbh -> prepare("SELECT      * " . 
                                                "FROM        sach, tacgia " .
                                                "WHERE       sach.MaTacGia = tacGia.MaTacGia " .
                                                "ORDER BY    NgayXuatBan DESC " . 
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
        
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    BÁN CHẠY NHẤT
                </div>
                <div class="panel-body">
                    <div class="list-group list-inline">
                        <?php
                        $stmt = $dbh -> prepare("SELECT      sach.MaSach, sach.Hinh, sach.TenSach, sum(SoLuong) as SumSoLuong 
                                                FROM        sach, chitietdonhang 
                                                WHERE       sach.MaSach = chitietdonhang.MaSach 
                                                GROUP BY    sach.MaSach, sach.Hinh, sach.TenSach
                                                ORDER BY    SumSoLuong DESC 
                                                LIMIT       0, 6");
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
        
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    XEM NHIỀU NHẤT
                </div>
                <div class="panel-body">
                    <div class="list-group list-inline">
                        <?php
                        $stmt = $dbh -> prepare("SELECT      * " . 
                                                "FROM        sach, tacgia " .
                                                "WHERE       sach.MaTacGia = tacGia.MaTacGia " .
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
<?php require_once './footer.php'; ?>