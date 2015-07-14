<?php
class BookAdapter {
    private static $dbh;
		private static $search;
    public static function getInstance($dbh, $search) {
        BookAdapter::$dbh = $dbh;
				BookAdapter::$search = $search;
        return new BookAdapter();
    }
    
		public function rowCount() {
			$stmt = BookAdapter::$dbh -> prepare("SELECT     COUNT(*) AS Total " . 
																																						"FROM       	sach " .
																																						"WHERE			TenSach LIKE '%" . BookAdapter::$search . "%'");
			$stmt -> execute();
			$row = $stmt -> fetch();
			return $row["Total"];
		}
		
    public function selectAll($startRow, $limit) {
        $stmt = BookAdapter::$dbh -> prepare("SELECT        MaSach, TenSach, sach.MaTheLoai, TenTheLoai, sach.MaTacGia, TenTacGia, " .
                                             "              sach.MaNhaXuatBan, TenNhaXuatBan, NgayXuatBan,  KichThuoc, TrongLuong, " .
                                             "              GiaBia, SoLuongTon, Hinh, TomTat, LuotXem " .
                                             "FROM          sach, theloaisach, tacgia, nhaxuatban " .
                                             "WHERE         sach.MaTheLoai = theloaisach.MaTheLoai AND " .
                                             "              sach.MaTacGia = tacGia.MaTacGia AND " .
                                             "              sach.MaNhaXuatBan = nhaxuatban.MaNhaXuatBan AND " .
																						 "							TenSach LIKE '%" . BookAdapter::$search . "%' " .
                                             "ORDER BY      MaSach ASC " .
                                             "LIMIT      " . $startRow . ", " . $limit);
        return $stmt;
    }
    
    public function insert($name, $category, $author, $publisher, $date, $size, $weight, $price, $quantity, $sumary, $viewer = 0) {
        $stmt = BookAdapter::$dbh -> prepare("INSERT INTO   sach (TenSach, MaTheLoai, MaTacGia, MaNhaXuatBan, NgayXuatBan, " .
                                             "                    KichThuoc, TrongLuong, GiaBia, SoLuongTon, Hinh, TomTat, LuotXem) " .
                                             "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $image = "";
        $stmt -> bindParam(1, $name, PDO::PARAM_STR);
        $stmt -> bindParam(2, $category, PDO::PARAM_INT);
        $stmt -> bindParam(3, $author, PDO::PARAM_INT);
        $stmt -> bindParam(4, $publisher, PDO::PARAM_INT);
        $stmt -> bindParam(5, date("y-m-d", strtotime($date)), PDO::PARAM_STR);
        $stmt -> bindParam(6, $size, PDO::PARAM_STR);
        $stmt -> bindParam(7, $weight, PDO::PARAM_STR);
        $stmt -> bindParam(8, $price, PDO::PARAM_STR);
        $stmt -> bindParam(9, $quantity, PDO::PARAM_INT);
        $stmt -> bindParam(10, $image, PDO::PARAM_NULL);
        $stmt -> bindParam(11, $sumary, PDO::PARAM_STR);
        $stmt -> bindParam(12, $viewer, PDO::PARAM_INT);
        $stmt -> execute();
    }
    
    public function update($code, $name, $category, $author, $publisher, $date, $size, $weight, $price, $quantity, $sumary) {
        $str = "UPDATE      sach " .
               "SET         TenSach=?, " .
               "            MaTheLoai=?, " .
               "            MaTacGia=?, " .
               "            MaNhaXuatBan=?, " .
               "            NgayXuatBan=?, " .
               "            KichThuoc=?, " .
               "            TrongLuong=?, " .
               "            GiaBia=?, " .
               "            SoLuongTon=?, " .
               "            TomTat=? " .
               "WHERE       MaSach=?";
        $stmt = BookAdapter::$dbh -> prepare($str);
        $stmt -> bindParam(1, $name, PDO::PARAM_STR);
        $stmt -> bindParam(2, $category, PDO::PARAM_INT);
        $stmt -> bindParam(3, $author, PDO::PARAM_INT);
        $stmt -> bindParam(4, $publisher, PDO::PARAM_INT);
        $stmt -> bindParam(5, date("y-m-d", strtotime($date)), PDO::PARAM_STR);
        $stmt -> bindParam(6, $size, PDO::PARAM_STR);
        $stmt -> bindParam(7, $weight, PDO::PARAM_STR);
        $stmt -> bindParam(8, $price, PDO::PARAM_STR);
        $stmt -> bindParam(9, $quantity, PDO::PARAM_INT);
        $stmt -> bindParam(10, $sumary, PDO::PARAM_STR);
        $stmt -> bindParam(11, $code, PDO::PARAM_INT);
        $stmt -> execute();
    }

		public function updateImage($code, $image) {
			$stmt = BookAdapter::$dbh -> prepare("UPDATE		sach " . 
																														"SET						Hinh=? " .
																														"WHERE			MaSach=?");
			$stmt -> bindParam(1, $image, PDO::PARAM_STR);
      $stmt -> bindParam(2, $code, PDO::PARAM_INT);
			$stmt -> execute();
		}
		
    public function delete($code) {
        $stmt = BookAdapter::$dbh -> prepare("DELETE FROM   sach " .
                                             "WHERE         MaSach=?");
        $stmt -> bindParam(1, $code, PDO::PARAM_STR);
        $stmt -> execute();
    }
    
    public function canDelete($code) {
         $stmt = BookAdapter::$dbh -> prepare("SELECT  * " .
                                              "FROM    chitietdonhang " .
                                              "WHERE   MaSach=?");
         $stmt -> bindParam(1, $code, PDO::PARAM_INT);
         $stmt -> execute();
         return $stmt -> rowCount() == 0;
    }
}
?>

