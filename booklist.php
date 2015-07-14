<?php require_once './header.php'; ?>
<?php
//Phân trang
    class Paging{ protected $_total; protected $_pages; // Phương thức tìm tổng số mẫu tin 
        public function findTotal($dbh, $get){   
            if(isset($_GET['total'])){    
                $this->_total = $_GET['total'];   
            }
            else{           
                $stmt = $dbh -> prepare("SELECT COUNT(*) " .
                            "FROM        sach, tacgia, nhaxuatban, theloaisach " .
                            "WHERE       sach.MaTacGia = tacgia.MaTacGia AND " .
                            "            sach.MaNhaXuatBan = nhaxuatban.MaNhaXuatBan AND " .
                            "            sach.MaTheLoai = theloaisach.MaTheLoai AND ".$get);
                $stmt -> execute();
                $row = $stmt -> fetch();
                $this ->_total = $row[0];   
            } 
        } 

        // Phương thức tính số trang 
        public function findPages($limit){   
            $this->_pages = ceil($this->_total / $limit); 
        } 

        // Phương thức tính vị trí mẫu tin bắt đầu từ vị trí trang 
        function rowStart($limit){   
            return (!isset($_GET['page'])) ? 0 :  ($_GET['page']-1) * $limit; 
        } 

        public function pagesList($curpage, $get){   
            $total = $this->_total;   
            $pages = $this->_pages;   
            if($pages <=1){
                return '';
            }   
            $page_list="";   
            // Tạo liên kết tới trang đầu và trang trang trước   
            if($curpage!=1){    
                $page_list .= '<a class="btn btn-default" href="'.$_SERVER['PHP_SELF'].'?'.$get.'&page=1&total='.$total.'" title="trang đầu"><span class="glyphicon glyphicon-fast-backward"></span> </a>';   
                $page_list .= " ";
            }   

            if($curpage  > 1){    
                $page_list .= '<a class="btn btn-default" href="'.$_SERVER['PHP_SELF'] .'?'.$get.'&page='.($curpage-1).'&total='.$total.'" title="trang trước"><span class="glyphicon glyphicon-backward"></span> </a>';   
                $page_list .= " ";
            }   

            // Tạo liên kết tới các trang   
            for($i=1; $i<=$pages; $i++){    
                if($i == $curpage){     
                    $page_list .= "<a class='btn btn-primary' href='#'><b>".$i."</b></a>";    
                }    
                else{     
                    $page_list .= '<a class="btn btn-default" href="'.$_SERVER['PHP_SELF'].'?'.$get.'&page='.$i.'&total='.$total.'" title="Trang '.$i.'">'.$i.'</a>';    
                }    
                $page_list .= " ";   
            }   

            // Tạo liên kết tới trang sau và trang cuối   
            if(($curpage+1)<=$pages){    
                $page_list .= '<a class="btn btn-default" href="'.$_SERVER['PHP_SELF'].'?'.$get.'&page='.($curpage+1).'&total='.$total.'" title="Đến trang sau"> <span class="glyphicon glyphicon-forward"></span> </a>';   
                $page_list .= " ";
            }   
                
            if(($curpage != $pages) && ($pages != 0)){    
                $page_list .= '<a class="btn btn-default" href="'.$_SERVER['PHP_SELF'].'?'.$get.'&page='.$pages.'&total='.$total.'" title="trang cuối"> <span class="glyphicon glyphicon-fast-forward"></span></a>';   
            }   

            return $page_list; 
        }// end pagesList 
    }// end class
?>
<?php
if(isset($_GET["matheloai"])) {   
    // Giới hạn số phần tử 1 trang 
    $paging = new Paging; $limit =3; 
    // Tổng số mẫu tin 
    $paging->findTotal($dbh,"theloaisach.MaTheLoai = ".$_GET["matheloai"]); 
    // Tổng số trang 
    $paging->findPages($limit); 
    // Bắt đầu từ mẫu tin 
    $start =$paging->rowStart($limit); 
    // Trang hiện tại 
    $curpage = ($start/$limit)+1;
    
    $stmt = $dbh -> prepare("SELECT      * " .
                            "FROM        sach, tacgia, nhaxuatban, theloaisach " .
                            "WHERE       sach.MaTacGia = tacgia.MaTacGia AND " .
                            "            sach.MaNhaXuatBan = nhaxuatban.MaNhaXuatBan AND " .
                            "            sach.MaTheLoai = theloaisach.MaTheLoai AND " .
                            "            theloaisach.MaTheLoai = ? LIMIT ".$start.",".$limit);
    $stmt -> bindParam(1, $_GET["matheloai"], PDO::PARAM_INT);
    $stmt -> execute();
    $count = $stmt->rowCount();
    
    //Lấy tên thể loại
    $stmt2 = $dbh -> prepare("SELECT      * " .
                            "FROM        theloaisach " .
                            "WHERE       MaTheLoai = ?");
    $stmt2 -> bindParam(1, $_GET["matheloai"], PDO::PARAM_INT);
    $stmt2 -> execute();
    $row2 = $stmt2 -> fetch();
?>
<div class="container page-width-limited" id="page-content">
    <div id="page-main-content" class="col-sm-9">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Thể loại sách <?php echo $row2["TenTheLoai"] ?>
                </div>
                
                    <?php
                        for($i=0; $i<$count; $i++){
                            $row = $stmt -> fetch();
                            $masach=$row["MaSach"];

                    ?>
                    <div class="panel-body">
                    <div class="col-sm-4">
                        <img class="small" src="<?php echo $row["Hinh"]; ?>" width="200px" height="250px" />
                    </div>
                    <div class="col-sm-8">
                        <span class="text-primary text-uppercase"><?php echo $row["TenSach"]; ?></span><br />
                        Thể loại: <?php echo $row["TenTheLoai"]; ?><br />
                        Tác giả: <a href="booklist.php?matacgia=<?php echo $row["MaTacGia"]; ?>"><?php echo $row["TenTacGia"]; ?></a><br />
                        Nhà xuất bản: <?php echo $row["TenNhaXuatBan"]; ?><br/>
                        Kích thước: <?php echo $row["KichThuoc"]; ?><br/>
                        Trong lượng: <?php echo $row["TrongLuong"]; ?> (gram)<br/>
                        Giá bán: <span class="text-danger"><?php echo $row["GiaBia"]; ?> VNĐ</span><br/>
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
                    <hr/>
                    <?php
                        }
                    ?>
                <div style="margin:10px; text-align:center">
                    <?php
                    // Xuất phân trang 
                    echo $paging->pagesList($curpage, 'matheloai='.$_GET["matheloai"]);
                    ?>
                </div>
            </div>
            
        </div>
       
    </div>
    <?php require_once './rightside.php'; ?>
</div>
<?php
}
else{
    if(isset($_GET["matacgia"])) {   
    // Giới hạn số phần tử 1 trang
    $paging = new Paging; $limit =3; 
    // Tổng số mẫu tin 
    $paging->findTotal($dbh,"tacgia.MaTacGia = ".$_GET["matacgia"]); 
    // Tổng số trang 
    $paging->findPages($limit); 
    // Bắt đầu từ mẫu tin 
    $start =$paging->rowStart($limit); 
    // Trang hiện tại 
    $curpage = ($start/$limit)+1;
    
    $stmt = $dbh -> prepare("SELECT      * " .
                            "FROM        sach, tacgia, nhaxuatban, theloaisach " .
                            "WHERE       sach.MaTacGia = tacgia.MaTacGia AND " .
                            "            sach.MaNhaXuatBan = nhaxuatban.MaNhaXuatBan AND " .
                            "            sach.MaTheLoai = theloaisach.MaTheLoai AND " .
                            "            tacgia.MaTacGia = ? LIMIT ".$start.",".$limit);
    $stmt -> bindParam(1, $_GET["matacgia"], PDO::PARAM_INT);
    $stmt -> execute();
    $count = $stmt->rowCount();
    
    //Lấy tên thể loại
    $stmt2 = $dbh -> prepare("SELECT      * " .
                            "FROM        tacgia " .
                            "WHERE       MaTacGia = ?");
    $stmt2 -> bindParam(1, $_GET["matacgia"], PDO::PARAM_INT);
    $stmt2 -> execute();
    $row2 = $stmt2 -> fetch();
    ?>
    <div class="container page-width-limited" id="page-content">
    <div id="page-main-content" class="col-sm-9">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Sách của tác giả <?php echo $row2["TenTacGia"] ?>
                </div>
                
                    <?php
                        for($i=0; $i<$count; $i++){
                            $row = $stmt -> fetch();
                            $masach=$row["MaSach"];

                    ?>
                    <div class="panel-body">
                    <div class="col-sm-4">
                        <img class="small" src="<?php echo $row["Hinh"]; ?>" width="200px" height="250px" />
                    </div>
                    <div class="col-sm-8">
                        <span class="text-primary text-uppercase"><?php echo $row["TenSach"]; ?></span><br />
                        Thể loại: <?php echo $row["TenTheLoai"]; ?><br />
                        Tác giả: <a href="booklist.php?matacgia=<?php echo $row["MaTacGia"]; ?>"><?php echo $row["TenTacGia"]; ?></a><br />
                        Nhà xuất bản: <?php echo $row["TenNhaXuatBan"]; ?><br/>
                        Kích thước: <?php echo $row["KichThuoc"]; ?><br/>
                        Trong lượng: <?php echo $row["TrongLuong"]; ?> (gram)<br/>
                        Giá bán: <span class="text-danger"><?php echo $row["GiaBia"]; ?> VNĐ</span><br/>
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
                    <hr/>
                    <?php
                        }
                    ?>
                <div style="margin:10px; text-align:center">
                    <?php
                    // Xuất phân trang 
                    echo $paging->pagesList($curpage, 'matacgia='.$_GET["matacgia"]);
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
        if(isset($_GET["txtTimKiem"])){
            // Giới hạn số phần tử 1 trang
    $paging = new Paging; $limit =3; 
    // Tổng số mẫu tin 
    $paging->findTotal($dbh,"sach.TenSach like ".$_GET["txtTimKiem"]); 
    // Tổng số trang 
    $paging->findPages($limit); 
    // Bắt đầu từ mẫu tin 
    $start =$paging->rowStart($limit); 
    // Trang hiện tại 
    $curpage = ($start/$limit)+1;
    
    $timkiem = trim(str_replace("+", "", $_GET["txtTimKiem"]));
    
    $stmt = $dbh -> prepare("SELECT      * " .
                            "FROM        sach, tacgia, nhaxuatban, theloaisach " .
                            "WHERE       sach.MaTacGia = tacgia.MaTacGia AND " .
                            "            sach.MaNhaXuatBan = nhaxuatban.MaNhaXuatBan AND " .
                            "            sach.MaTheLoai = theloaisach.MaTheLoai AND " .
                            "            sach.TenSach like '%".$timkiem."%' LIMIT ".$start.",".$limit);
    //$stmt -> bindParam(1, $_GET["txtTimKiem"], PDO::PARAM_INT);
    
    $stmt -> execute();
    $count = $stmt->rowCount();
    
    ?>
    <div class="container page-width-limited" id="page-content">
    <div id="page-main-content" class="col-sm-9">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Kết quả tìm kiếm
                </div>
                
                    <?php

                    if($count==0){
                        echo "Không tìm thấy...";
                    }
                    else{
                        for($i=0; $i<$count; $i++){
                            $row = $stmt -> fetch();
                            $masach=$row["MaSach"];                  
                    

                    ?>
                    <div class="panel-body">
                    <div class="col-sm-4">
                        <img class="small" src="<?php echo $row["Hinh"]; ?>" width="200px" height="250px" />
                    </div>
                    <div class="col-sm-8">
                        <span class="text-primary text-uppercase"><?php echo $row["TenSach"]; ?></span><br />
                        Thể loại: <?php echo $row["TenTheLoai"]; ?><br />
                        Tác giả: <a href="booklist.php?matacgia=<?php echo $row["MaTacGia"]; ?>"><?php echo $row["TenTacGia"]; ?></a><br />
                        Nhà xuất bản: <?php echo $row["TenNhaXuatBan"]; ?><br/>
                        Kích thước: <?php echo $row["KichThuoc"]; ?><br/>
                        Trong lượng: <?php echo $row["TrongLuong"]; ?> (gram)<br/>
                        Giá bán: <span class="text-danger"><?php echo $row["GiaBia"]; ?> VNĐ</span><br/>
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
                    <hr/>
                    <?php
                        }
                    }
                    ?>
                <div style="margin:10px; text-align:center">
                    <?php
                    // Xuất phân trang 
                    echo $paging->pagesList($curpage, 'txtTimKiem='.$_GET["txtTimKiem"]);
                    ?>
                </div>
                
            </div>
        </div>
       
    </div>
    <?php require_once './rightside.php'; ?>
</div>
    <?php
        }
        else{
            echo '<meta http-equiv="refresh" content="0;URL=index.php">';
        }       
    }
}

?>
<?php require_once './footer.php'; ?>