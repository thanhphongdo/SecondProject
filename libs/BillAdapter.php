<?php
class BillAdapter{
	private static $dbh;
    public static function getInstance($dbh) {
        BillAdapter::$dbh = $dbh;
        return new BillAdapter();
    }
    public function selectAll($startRow, $limit) {
        $stmt = BillAdapter::$dbh -> prepare("SELECT MaDonHang, thanhvien.Hoten, NgayDH,NgayGH,TrangThai,TongTien,TongTrongLuong,PhiVanChuyen " . 
                                             "FROM donhang, thanhvien " .
                                             "WHERE donhang.TaiKhoan = thanhvien.TaiKhoan ".
                                             "order by MaDonHang ".
                                             "LIMIT " . $startRow . ", " . $limit);
        $stmt->execute();
        return $stmt;
    }

    public function numRow(){
    	$stmt = BillAdapter::$dbh -> prepare("SELECT count(*) as num FROM donhang");
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['num'];
    }

    public function insert($MaDonHang, $TaiKhoan, $NgayDH, $NgayGH, $TrangThai, $TongTien, $TongTL, $PhiVanChuyen) {
        $sql = "insert into donhang(MaDonHang,TaiKhoan,NgayDH,NgayGH,TrangThai,TongTien,TongTrongLuong,PhiVanChuyen)".
        		"values(?,?,?,?,?,?,?,?)";
        $stmt = BillAdapter::$dbh -> prepare($sql);
        $stmt -> bindParam(1, $MaDonHang, PDO::PARAM_INT);
        $stmt -> bindParam(2, $TaiKhoan, PDO::PARAM_STR);
        $stmt -> bindParam(3, date("y-m-d", strtotime($NgayDH)), PDO::PARAM_STR);
        $stmt -> bindParam(4, date("y-m-d", strtotime($NgayGH)), PDO::PARAM_STR);
        $stmt -> bindParam(5, $TrangThai, PDO::PARAM_STR);
        $stmt -> bindParam(6, $TongTien, PDO::PARAM_STR);
        $stmt -> bindParam(7, $TongTL, PDO::PARAM_STR);
        $stmt -> bindParam(8, $PhiVanChuyen, PDO::PARAM_STR);
        $stmt -> execute();
    }
    public function update($MaDonHang, $NgayDH, $NgayGH, $TrangThai, $TongTien, $TongTL, $PhiVanChuyen){
    	$sql = "update donhang set".
    			" NgayDH=?,".
    			" NgayGH=?,".
    			" TrangThai=?,".
    			" TongTien=?,".
    			" TongTrongLuong=?,".
    			" PhiVanChuyen=?".
    			" where MaDonHang=?";
    	$stmt = BillAdapter::$dbh -> prepare();
        $stmt -> bindParam(1, date("y-m-d", strtotime($NgayDH)), PDO::PARAM_STR);
        $stmt -> bindParam(2, date("y-m-d", strtotime($NgayGH)), PDO::PARAM_STR);
        $stmt -> bindParam(3, $TrangThai, PDO::PARAM_STR);
        $stmt -> bindParam(4, $TongTien, PDO::PARAM_STR);
        $stmt -> bindParam(5, $TongTL, PDO::PARAM_STR);
        $stmt -> bindParam(6, $PhiVanChuyen, PDO::PARAM_STR);
        $stmt -> bindParam(7, $MaDonHang, PDO::PARAM_INT);
        $stmt -> execute();
    }
    public function delete($MaDonHang){
        $sql = "SELECT * FROM chitietdonhang WHERE MaDonHang=?";
        $stmt = BillAdapter::$dbh -> prepare($sql);
        $stmt -> bindParam(1, $MaDonHang, PDO::PARAM_INT);
        $stmt -> execute();
        while($row = $stmt->fetch()){
            $sql = "Update `sach` set soluongton = soluongton+? where masach=?";
            $stmt2 = BillAdapter::$dbh -> prepare($sql);
            $stmt2 -> bindParam(1, $row['SoLuong'], PDO::PARAM_INT);
            $stmt2 -> bindParam(2, $row['MaSach'], PDO::PARAM_INT);
            $stmt2 -> execute();
        }
    	$sql = "delete from chitietdonhang where MaDonHang=?";
    	$stmt = BillAdapter::$dbh -> prepare($sql);
    	$stmt -> bindParam(1, $MaDonHang, PDO::PARAM_INT);
    	$stmt -> execute();
    	$sql = "delete from donhang where MaDonHang=?";
    	$stmt = BillAdapter::$dbh -> prepare($sql);
    	$stmt -> bindParam(1, $MaDonHang, PDO::PARAM_INT);
    	$stmt -> execute();
    }

    public function search_or($key, $startRow, $limit){
        $stmt = BillAdapter::$dbh -> prepare("SELECT MaDonHang , thanhvien . Hoten , NgayDH , NgayGH , TrangThai , TongTien , TongTrongLuong , PhiVanChuyen ".
                                             "FROM donhang , thanhvien ".
                                             "WHERE donhang.TaiKhoan = thanhvien . TaiKhoan ".
                                             "AND ( ".
                                             "MaDonHang LIKE   '%".$key."%' ".
                                             "OR thanhvien.TaiKhoan LIKE '%".$key."%' ".
                                             "OR NgayDH LIKE '%".$key."%' ". 
                                             "OR NgayGH LIKE '%".$key."%' ".
                                             "OR thanhvien.HoTen LIKE '%".$key."%' ".
                                             ") ".
                                             "ORDER BY MaDonHang ".
                                             "LIMIT " . $startRow . ", " . $limit);
        $stmt->execute();
        return $stmt;
    }

    public function numRow_Search_Or($key){
        $stmt = BillAdapter::$dbh -> prepare("SELECT count(*) as num ".
                                             "FROM donhang , thanhvien ".
                                             "WHERE donhang.TaiKhoan = thanhvien . TaiKhoan ".
                                             "AND ( ".
                                             "MaDonHang LIKE   '%".$key."%' ".
                                             "OR thanhvien.TaiKhoan LIKE '%".$key."%' ".
                                             "OR NgayDH LIKE '%".$key."%' ". 
                                             "OR NgayGH LIKE '%".$key."%' ".
                                             "OR thanhvien.HoTen LIKE '%".$key."%' ".
                                             ") ");
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['num'];
    }

    public function Search_Upgade($arr, $startRow, $limit){
        $where1 = "";
        $where2 = "";
        $where3 = "";
        if($arr[0] != "" && $arr[1] != ""){
            $where1 = "and NgayDH >= '$arr[0]' and NgayDH <= '$arr[1]' ";
        }
        if($arr[2] != "" && $arr[3] != ""){
            $where2 = "and NgayGH >= '$arr[2]' and NgayGH <= '$arr[3]' ";
        }
        if($arr[4] != ""){
            $where3 = "and TrangThai = ".$arr[4]." ";
        }
        $stmt = BillAdapter::$dbh -> prepare("SELECT MaDonHang, thanhvien.Hoten, NgayDH,NgayGH,TrangThai,TongTien,TongTrongLuong,PhiVanChuyen ". 
                                             "FROM donhang, thanhvien " .
                                             "WHERE donhang.TaiKhoan = thanhvien.TaiKhoan ".
                                             $where1.
                                             $where2.
                                             $where3.
                                             "order by MaDonHang ".
                                             "LIMIT " . $startRow . ", " . $limit);
        $stmt->bindParam(1,date("y-m-d", strtotime($arr[0])), PDO::PARAM_STR);
        $stmt->bindParam(2,date("y-m-d", strtotime($arr[1])), PDO::PARAM_STR);
        $stmt->bindParam(3,date("y-m-d", strtotime($arr[2])), PDO::PARAM_STR);
        $stmt->bindParam(4,date("y-m-d", strtotime($arr[3])), PDO::PARAM_STR);
        $stmt->bindParam(1,$arr[4]);
        $stmt->execute();
        return $stmt;
    }

    public function Count_Search_Upgade($arr){
        $where1 = "";
        $where2 = "";
        $where3 = "";
        if($arr[0] != "" && $arr[1] != ""){
            $where1 = "and NgayDH >= '$arr[0]' and NgayDH <= '$arr[1]' ";
        }
        if($arr[2] != "" && $arr[3] != ""){
            $where2 = "and NgayGH >= '$arr[2]' and NgayGH <= '$arr[3]' ";
        }
        if($arr[4] != ""){
            $where3 = "and TrangThai = ".$arr[4]." ";
        }
        $stmt = BillAdapter::$dbh -> prepare("SELECT count(*) as numRow ". 
                                             "FROM donhang, thanhvien " .
                                             "WHERE donhang.TaiKhoan = thanhvien.TaiKhoan ".
                                             $where1.
                                             $where2.
                                             $where3);
        $stmt->bindParam(1,date("y-m-d", strtotime($arr[0])), PDO::PARAM_STR);
        $stmt->bindParam(2,date("y-m-d", strtotime($arr[1])), PDO::PARAM_STR);
        $stmt->bindParam(3,date("y-m-d", strtotime($arr[2])), PDO::PARAM_STR);
        $stmt->bindParam(4,date("y-m-d", strtotime($arr[3])), PDO::PARAM_STR);
        $stmt->bindParam(1,$arr[4]);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['numRow'];
    }

    public function billDetail($MaDonHang){
        $stmt = BillAdapter::$dbh -> prepare("SELECT MaDonHang, sach.TenSach, SoLuong, GiaBia, SoLuong*GiaBia as ThanhTien ".
                                             "FROM chitietdonhang, sach ".
                                             "WHERE chitietdonhang.MaSach = sach.MaSach and MaDonHang = ?");
        $stmt->bindParam(1,$MaDonHang);
        $stmt->execute();
        return $stmt;
    }

    public function delivery($MaDonHang){
        $stmt = BillAdapter::$dbh -> prepare("UPDATE donhang set TrangThai = '1' ".
                                             "WHERE MaDonHang = ?");
        $stmt->bindParam(1,$MaDonHang);
        $stmt->execute();
    }
}
?>