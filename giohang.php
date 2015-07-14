<?php
    session_start();
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    if(!isset($_SESSION["usernameKH"])){
        echo '<meta http-equiv="refresh" content="0;URL=index.php">';
    }
    else
    if(isset($_SESSION["giohang"])){
    require_once './header.php';
    
?>
<div class="container page-width-limited" id="page-content">
    <div id="page-main-content" class="col-sm-9">
		<div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    GIỎ HÀNG <?php echo isset($_SESSION["tam"])?$_SESSION["tam"]:""; unset($_SESSION["tam"]); ?>
                </div>
                <div class="panel-body">
                	<table class="table table-bordered table-condensed table-hover">
                		<thead >
                			<tr class="info giohang-thead">
                				<th>STT</th>
                				<th colspan="2">Sản phẩm</th>
                				<th>Số lượng</th>
                				<th>Đơn giá</th>
                				<th>Thành tiền</th>
                				<th>Xoá</th>
                			</tr>
                		</thead>

                		<tbody>
                            <?php
                                $i=1;
                                $tongtien=0;
                                foreach($_SESSION["giohang"] as $item){
                                    $stmt = $dbh -> prepare("SELECT      * " .
                                                            "FROM        sach, tacgia, nhaxuatban, theloaisach " .
                                                            "WHERE       sach.MaTacGia = tacgia.MaTacGia AND " .
                                                            "            sach.MaNhaXuatBan = nhaxuatban.MaNhaXuatBan AND " .
                                                            "            sach.MaTheLoai = theloaisach.MaTheLoai AND " .
                                                            "            sach.MaSach = ?");
                                    $stmt -> bindParam(1, $item["masach"], PDO::PARAM_INT);
                                    $stmt -> execute();
                                    $row = $stmt -> fetch();
                                    $thanhtien = $row["GiaBia"] * $item["soluong"];
                                    $trongluong=$row["TrongLuong"]*$item["soluong"];
                                    $tongtrong=$tongtrong+$trongluong;
                                    $tongtien=$tongtien+$thanhtien;
                            ?>
                			<tr class="giohang-tbody">
                				<td class="giohang-stt"><?php echo $i++; ?></td>
                				<td class="giohang-image">
                                    <img width="101px" height="140" class="masterTooltip" 
                                        title="<?php echo $row["TenSach"];?>"
                                        src="<?php echo $row["Hinh"];?>">
                                </td>
                				<td id="giohang-sp">
                					<a class="text-capitalize" href="bookdetail.php?masach=<?php echo $row['MaSach']; ?>"><b><?php echo $row["TenSach"];?></b></a>
                					<div id="giohang-sanpham" class="text-muted">
                						<p>
                                            <small>Tác giả: <b><a href="booklist.php?matacgia=<?php echo $row['MaTacGia']; ?>"><?php echo $row["TenTacGia"];?></a></b></small>
                                        </p>
                					</div>
                				</td>
                				<td id="giohang-soluong">
                                    <input class="form-control soluong" type="number" min="1" max="<?php echo $row['SoLuongTon'];?>"  value="<?php echo $item["soluong"]; ?>">
                                    <input id="<?php echo('masach'.$i) ?>" type="hidden" value="<?php echo $item["masach"]?>">
                				</td>
                				<td id="giohang-dongia">
                                    <b class="dongia"><?php echo $row["GiaBia"] ?> đ</b>
                                    <input type="hidden" class="dontrong" value="<?php echo $row['TrongLuong']; ?>">
                                </td>
                				<td id="giohang-thanhtien">
                                    <b class="thanhtien"><?php echo $thanhtien; ?> </b><b> đ</b>
                                    <input type="hidden" class="trongluong" value="<?php echo $trongluong; ?>">
                                </td>
                                <td id="giohang-xoa">
                                    <a style="cursor:pointer;" class="xoa-hang">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                    <input id="<?php echo('xoa'.$i) ?>" type="hidden" value="<?php echo $item["masach"]?>">
                                </td>
                				</tr>
                            <?php } ?>
                		</tbody>

                		<tfoot id="giohang-footer">
                			<tr class="info">
                				<td colspan="4"></td>
                				<td><b>Tổng cộng</b></td>
                				<td>
                                    <b id="tongtien"><?php echo $tongtien; ?> </b><b> đ</b>
                                    <input id="tongtrong" type="hidden" value="<?php echo $tongtrong; ?>">
                                </td>
                                <td>
                                </td>
                			</tr>
                		</tfoot>
                	</table>
                	
                	<form id="giohang-form" action="#" class="form-inline">
                		<a href="index.php">
                            <button class="btn btn-info" type="button">
                                <span class="glyphicon glyphicon-plus-sign"></span> Thêm sách vào giỏ hàng
                            </button>
                        </a >
                		  <button id="dat-sach" class="btn btn-success" type="button"><span class="glyphicon glyphicon-ok-sign"></span> Đặt sách</button>
                		<a href="index.php?huygiohang=true">
                            <button class="btn btn-danger" type="button">
                                <span class="glyphicon glyphicon-remove-sign"></span> Huỷ giỏ hàng
                            </button>
                        </a>
                	</form>
                	
                </div>
            </div>
        </div>    
    </div>
    <?php require_once './rightside.php'; ?>
</div>
<?php require_once './footer.php'; ?>
<?php
    }
    else{
        header("location: index.php");
    }
?>