<?php require_once '../libs/db.php'; ?>
<?php require_once '../libs/BillAdapter.php';?>

<!-- Danh sach hoa don -->

<?php
// session_start();
// if(isset($_SESSION['adminUsername'])){
    if(!isset($_POST['dk']) && !isset($_POST['key']) && isset($_POST['limit']) 
        && isset($_POST['start'])){
        $start = $_POST['start'];
        $limit = $_POST['limit'];
        $bill = BillAdapter::getInstance($dbh);
        $stmt = $bill->selectAll($start,$limit);
        $rowCount = $stmt -> rowCount();
        if($rowCount) {
?>
    <table class="table table-bordered table-hover">
        <thead>
            <tr class="info">
                <th>STT</th>
                <th style="display:none">Mã hóa đơn</th>
                <th>Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Ngày giao</th>
                <th>Trạng thái</th>
                <th>Tổng tiền</th>
                <th>Tổng trọng lượng</th>
                <th>Phí vận chuyển</th>
            </tr>
        </thead>
        <tbody>
<?php
            $i=0;
            while($row=$stmt->fetch()){
                $i++;
?>
            <tr class="select">
                <td class="text-center"><?php echo($start + $i); ?></td>
                <td style="display:none"><?php echo($row['MaDonHang']); ?></td>
                <td><?php echo($row['Hoten']); ?></td>
                <td class="text-right"><?php echo(date("d/m/Y", strtotime($row['NgayDH']))); ?></td>
                <td class="text-right"><?php echo(date("d/m/Y", strtotime($row['NgayGH']))); ?></td>
                <td class="text-center">
                    <?php if($row['TrangThai']=='1') echo("đã giao");else echo("chưa giao"); ?>
                </td>
                <td class="text-right"><?php echo(number_format($row['TongTien'])); ?></td>
                <td class="text-right"><?php echo(number_format($row['TongTrongLuong'],2)); ?></td>
                <td class="text-right"><?php echo(number_format($row['PhiVanChuyen'])); ?></td>
            </tr>
<?php
            }
?>
        </tbody>
    </table>
    <nav style="text-align:right;">
        <ul class="pagination" style="margin:0px">
            <li class="<?php if($start<=40)echo("disabled") ?>">
                <a aria-label="Previous" style="cursor:pointer" id="prev">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
<?php
            for($i=floor(($start+1)/(5*$limit))*5;$i<(floor(($start+1)/(5*$limit))*5 + 5);$i++){
                if($i < ceil(($start+1)/(5*$limit))*5) {
            
?>
            <li class="<?php if($i == $start/10)echo'active'; ?>">
                <a style="cursor:pointer;<?php if($i>=ceil(($bill->numRow())/$limit))echo('display:none'); ?>" class="page">
                    <?php echo($i+1); ?>
                </a>
            </li>
<?php
                }
                
            }
            echo('<input type="hidden" id="num" value="'.($bill->numRow()).'">');
?>
            <li class="<?php if(($bill->numRow())<=50 || 
                (ceil(ceil(($bill->numRow())/$limit)/5) == ceil(($start+1)/($limit*5))))echo('disabled'); ?>">
                <a aria-label="Next" style="cursor:pointer" id="next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
<?php
        }
    }
// }
// else{
//     //$i<ceil(($bill->numRow())/$limit)
//     echo '<meta http-equiv="refresh" content="0;URL=index.php">';
// }
?>

<!-- Tim kiem hoa don Search_Or() -->

<?php
// session_start();
// if(isset($_SESSION['adminUsername'])){
    if(isset($_POST['key']) && isset($_POST['limit']) && isset($_POST['start'])){
        $start = $_POST['start'];
        $limit = $_POST['limit'];
        $key = $_POST['key'];
        $bill = BillAdapter::getInstance($dbh);
        $stmt = $bill->search_or($key,$start,$limit);
        $rowCount = $stmt -> rowCount();
        if($rowCount) {
?>
    <table class="table table-bordered table-hover">
        <thead>
            <tr class="info">
                <th>STT</th>
                <th style="display:none">Mã hóa đơn</th>
                <th>Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Ngày giao</th>
                <th>Trạng thái</th>
                <th>Tổng tiền</th>
                <th>Tổng trọng lượng</th>
                <th>Phí vận chuyển</th>
            </tr>
        </thead>
        <tbody>
<?php
            $i=0;
            while($row=$stmt->fetch()){
                $i++;
?>
            <tr class="select">
                <td class="text-center"><?php echo($start + $i); ?></td>
                <td style="display:none"><?php echo($row['MaDonHang']); ?></td>
                <td><?php echo($row['Hoten']); ?></td>
                <td class="text-right"><?php echo(date("d/m/Y", strtotime($row['NgayDH']))); ?></td>
                <td class="text-right"><?php echo(date("d/m/Y", strtotime($row['NgayGH']))); ?></td>
                <td class="text-center">
                    <?php if($row['TrangThai']=='1') echo("đã giao");else echo("chưa giao"); ?>
                </td>
                <td class="text-right"><?php echo(number_format($row['TongTien'])); ?></td>
                <td class="text-right"><?php echo(number_format($row['TongTrongLuong'],2)); ?></td>
                <td class="text-right"><?php echo(number_format($row['PhiVanChuyen'])); ?></td>
            </tr>
<?php
            }
?>
        </tbody>
    </table>
    <nav style="text-align:right;">
        <ul class="pagination" style="margin:0px">
            <li class="<?php if($start<=40)echo("disabled") ?>">
                <a aria-label="Previous" style="cursor:pointer" id="prev">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
<?php
            for($i=floor(($start+1)/(5*$limit))*5;$i<(floor(($start+1)/(5*$limit))*5 + 5);$i++){
                if($i < ceil(($start+1)/(5*$limit))*5) {
            
?>
            <li class="<?php if($i == $start/10)echo'active'; ?>">
                <a style="cursor:pointer;<?php if($i>=ceil(($bill->numRow_Search_Or($key))/$limit))echo('display:none'); ?>" class="page">
                    <?php echo($i+1); ?>
                </a>
            </li>
<?php
                }
                
            }
            echo('<input type="hidden" id="num" value="'.($bill->numRow_Search_Or($key)).'">');
?>
            <li class="<?php if(($bill->numRow_Search_Or($key))<=50 || 
                (ceil(ceil(($bill->numRow_Search_Or($key))/$limit)/5) == ceil(($start+1)/($limit*5))))echo('disabled'); ?>">
                <a aria-label="Next" style="cursor:pointer" id="next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
        
    </nav>
<?php
        }
    }
?>

<!-- Danh sach hoa don chi tiet -->

<?php
    if(isset($_POST['MaDonHang']) && $_POST['MaDonHang'] != ''){
        $bill = BillAdapter::getInstance($dbh);
        $stmt = $bill->billDetail($_POST['MaDonHang']);
?>
    <table class="table table-bordered table-hover">
        <thead>
            <tr><th colspan="5"><span style="margin-right:30px">
                                    <?php echo('Khách hàng: '.$_POST['KhachHang']); ?>
                                </span>
                                <span>
                                    <?php echo('Mã HĐ: '.$_POST['MaDonHang']); ?>
                                </span></th></tr>
            <tr class="text-center">
                <th>STT</th>
                <th>Tên sách</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
<?php
        $i = 0;
        $sum = 0;
        while ($row = $stmt->fetch()) {
            $i++;
            $sum += $row['ThanhTien'];
?>
            <tr>
                <td class="text-center"><?php echo($i); ?></td>
                <td><?php echo($row['TenSach']) ?></td>
                <td class="text-right"><?php echo($row['SoLuong']) ?></td>
                <td class="text-right"><?php echo(number_format($row['GiaBia'])) ?></td>
                <td class="text-right"><?php echo(number_format($row['ThanhTien'])) ?></td>
            </tr>
<?php
        }
?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-center">Tổng cộng:</th>
                <th class="text-right"><?php echo(number_format($sum)); ?></th>
            </tr>
        </tfoot>
    </table>
<?php
    }
?>

<!-- Giao hang -->
<?php
    if(isset($_POST['GiaoHang']) && isset($_POST['MaDonHang'])){
        $bill = BillAdapter::getInstance($dbh);
        $stmt = $bill->delivery($_POST['MaDonHang']);
    }
?>

<!-- Tim kiem nang cao -->
<?php
if(isset($_POST['dk']) && isset($_POST['limit']) && isset($_POST['start'])){
    $start = $_POST['start'];
    $limit = $_POST['limit'];
    $bill = BillAdapter::getInstance($dbh);
    $stmt = $bill->Search_Upgade($_POST['dk'],$start,$limit);
    $rowCount = $stmt -> rowCount();
    if($rowCount) {
?>
    <table class="table table-bordered table-hover">
        <thead>
            <tr class="info">
                <th>STT</th>
                <th style="display:none">Mã hóa đơn</th>
                <th>Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Ngày giao</th>
                <th>Trạng thái</th>
                <th>Tổng tiền</th>
                <th>Tổng trọng lượng</th>
                <th>Phí vận chuyển</th>
            </tr>
        </thead>
        <tbody>
<?php
            $i=0;
            while($row=$stmt->fetch()){
                $i++;
?>
            <tr class="select">
                <td class="text-center"><?php echo($start + $i); ?></td>
                <td style="display:none"><?php echo($row['MaDonHang']); ?></td>
                <td><?php echo($row['Hoten']); ?></td>
                <td class="text-right"><?php echo(date("d/m/Y", strtotime($row['NgayDH']))); ?></td>
                <td class="text-right"><?php echo(date("d/m/Y", strtotime($row['NgayGH']))); ?></td>
                <td class="text-center">
                    <?php if($row['TrangThai']=='1') echo("đã giao");else echo("chưa giao"); ?>
                </td>
                <td class="text-right"><?php echo(number_format($row['TongTien'])); ?></td>
                <td class="text-right"><?php echo(number_format($row['TongTrongLuong'],2)); ?></td>
                <td class="text-right"><?php echo(number_format($row['PhiVanChuyen'])); ?></td>
            </tr>
<?php
            }
?>
        </tbody>
    </table>
    <nav style="text-align:right;">
        <ul class="pagination" style="margin:0px">
            <li class="<?php if($start<=40)echo("disabled") ?>">
                <a aria-label="Previous" style="cursor:pointer" id="prev">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
<?php
            for($i=floor(($start+1)/(5*$limit))*5;$i<(floor(($start+1)/(5*$limit))*5 + 5);$i++){
                if($i < ceil(($start+1)/(5*$limit))*5) {
            
?>
            <li class="<?php if($i == $start/10)echo'active'; ?>">
                <a style="cursor:pointer;<?php if($i>=ceil(($bill->Count_Search_Upgade($_POST['dk']))/$limit))echo('display:none'); ?>" class="page">
                    <?php echo($i+1); ?>
                </a>
            </li>
<?php
                }
                
            }
            echo('<input type="hidden" id="num" value="'.($bill->Count_Search_Upgade($_POST['dk'])).'">');
?>
            <li class="<?php if(($bill->Count_Search_Upgade($_POST['dk']))<=50 || 
                (ceil(ceil(($bill->Count_Search_Upgade($_POST['dk']))/$limit)/5) == ceil(($start+1)/($limit*5))))echo('disabled'); ?>">
                <a aria-label="Next" style="cursor:pointer" id="next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
<?php
    }
}
?>