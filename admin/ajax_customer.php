<?php require_once '../libs/db.php'; ?>
<?php require_once '../libs/CustomerAdapter.php';?>
<?php
if(isset($_POST['limit']) & isset($_POST['start'])){
    $start = $_POST['start'];
    $limit = $_POST['limit'];
    $cus = CustomerAdapter::getInstance($dbh);
    $stmt = $cus->selectAll($start,$limit);
    $rowCount = $stmt -> rowCount();
    if($rowCount) {
?>
    <table class="table table-bordered table-hover">
        <thead>
            <tr class="info">
                <th>STT</th>
                <th>Tài khoản</th>
                <th>Họ tên</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
                <th>Địa chỉ</th>
                <th>Điện thoại</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
<?php
            $i=0;
            while($row=$stmt->fetch()){
                $i++;
?>
            <tr>
                <td class="text-center"><?php echo($start + $i); ?></td>
                <td><?php echo($row['TaiKhoan']); ?></td>
                <td><?php echo($row['HoTen']); ?></td>
                <td class="text-right"><?php echo($row['NgaySinh']); ?></td>
                <td class="text-left"><?php echo($row['GioiTinh']); ?></td>
                <td class="text-left"><?php echo($row['DiaChi']); ?></td>
                <td class="text-left"><?php echo($row['DienThoai']); ?></td>
                <td class="text-left"><?php echo($row['Email']); ?></td>
                <td class="text-center">
                <?php if($row['Locked'] == '0') {
                ?>
                    <button value="<?php echo($row['Locked']); ?>" class="btn btn-xs" style="background:none; padding:0px;">
                        <span class="glyphicon glyphicon-lock"></span></button>
                <?php
                    }
                    else{
                ?>
                    <button value="<?php echo($row['Locked']); ?>" class="btn btn-xs" style="background:none; padding:0px;">
                    <span class="glyphicon glyphicon-check"></span></button>
                <?php
                    } 
                ?>
                </td>
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
                <a style="cursor:pointer;<?php if($i>=ceil(($cus->numRow())/$limit))echo('display:none'); ?>" class="pageCus">
                    <?php echo($i+1); ?>
                </a>
            </li>
<?php
                }
            }
            echo('<input type="hidden" id="num" value="'.($cus->numRow()).'">');
?>
            <li class="<?php if(($cus->numRow())<=50 || 
                (ceil(ceil(($cus->numRow())/$limit)/5) == ceil(($start+1)/($limit*5))))echo('disabled'); ?>">
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
<?php
    if(isset($_POST['MaTV'])){
        $cus = CustomerAdapter::getInstance($dbh);
        $stmt = $cus->updateLocked($_POST['MaTV'],$_POST['Locked']);
    }
?>