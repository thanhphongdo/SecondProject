<?php
class CustomerAdapter{
	private static $dbh;
    public static function getInstance($dbh) {
        CustomerAdapter::$dbh = $dbh;
        return new CustomerAdapter();
    }
    public function selectAll($startRow, $limit) {
        $stmt = CustomerAdapter::$dbh -> prepare("SELECT * FROM thanhvien ".
                                                 "order by TaiKhoan ".
                                                 "LIMIT " . $startRow . ", " . $limit);
        $stmt->execute();
        return $stmt;
    }

    public function numRow() {
        $stmt = CustomerAdapter::$dbh -> prepare("SELECT count(*) as numRow FROM thanhvien");
        $stmt->execute();
        $row=$stmt->fetch();
        return $row['numRow'];
    }

    public function updateLocked($TaiKhoan, $Locked){
        $stmt = CustomerAdapter::$dbh -> prepare("UPDATE thanhvien SET Locked = ? WHERE TaiKhoan = ?");
        $stmt->bindParam(1,$Locked);
        $stmt->bindParam(2,$TaiKhoan);
        $stmt->execute();
    }
}
?>