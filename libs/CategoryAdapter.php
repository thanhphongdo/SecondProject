<?php
class CategoryAdapter {
    private static $dbh;
		private static $search;
    public static function getInstance($dbh, $search) {
        CategoryAdapter::$dbh = $dbh;
				CategoryAdapter::$search = $search;
        return new CategoryAdapter();
    }
    
		public function rowCount() {
			$stmt = CategoryAdapter::$dbh -> prepare("SELECT     COUNT(*) AS Total " . 
																																						"FROM       	theloaisach " .
																																						"WHERE			TenTheLoai LIKE '%" . CategoryAdapter::$search . "%'");
			$stmt -> execute();
			$row = $stmt -> fetch();
			return $row["Total"];
		}
		
    public function selectAll($startRow = null, $limit = null) {
        $stmt = null;
        if($startRow == null && $limit == null) {
            $stmt = CategoryAdapter::$dbh -> prepare("SELECT    * " . 
                                                     "FROM      theloaisach " .
                                                     "WHERE     TheLoaiCha IS NOT NULL");
        }
        else {
            $stmt = CategoryAdapter::$dbh -> prepare("SELECT    theloaisach.MaTheLoai, theloaisach.TenTheLoai, " .
                                                     "          tmptheloaicha.MaTheLoai AS MaTheLoaiCha, tmptheloaicha.TenTheLoai AS TenTheLoaiCha " . 
                                                     "FROM      theloaisach LEFT JOIN ( " .
                                                     "                                SELECT     MaTheLoai, TenTheLoai " .
                                                     "                                FROM       theloaisach " .
                                                     "                                WHERE      TheLoaiCha IS NULL " .
                                                     "                                ) AS tmptheloaicha ON theloaisach.TheLoaiCha = tmptheloaicha.MaTheLoai " .
																										 "WHERE			theloaisach.TenTheLoai LIKE '%" . CategoryAdapter::$search . "%' " .
                                                     "LIMIT      ?, ?");
            $stmt -> bindParam(1, $startRow, PDO::PARAM_INT);
            $stmt -> bindParam(2, $limit, PDO::PARAM_INT);
        }
        return $stmt;
    }
    
    public function selectParentCategory() {
        $stmt = null;
        $stmt = CategoryAdapter::$dbh -> prepare("SELECT    * " . 
                                                 "FROM      theloaisach " .
                                                 "WHERE     TheLoaiCha IS NULL");
        return $stmt;
    }
    
    public function insert($name, $parent) {
        $stmt = CategoryAdapter::$dbh -> prepare("INSERT INTO theloaisach (TenTheLoai, TheLoaiCha) " .
                                                  "VALUES (?, ?)");
        $stmt -> bindParam(1, $name, PDO::PARAM_STR);
        $stmt -> bindParam(2, $parent == "" ? null : $parent, PDO::PARAM_INT);
        $stmt -> execute();
    }
    
    public function update($code, $name, $parent) {
        $stmt = CategoryAdapter::$dbh -> prepare("UPDATE    theloaisach " .
                                                 "SET       TenTheLoai=?, " .
                                                 "          TheLoaiCha=? " .
                                                 "WHERE     MaTheLoai=?");
        $stmt -> bindParam(1, $name, PDO::PARAM_STR);
        $stmt -> bindParam(2, $parent == "" ? null : $parent, PDO::PARAM_INT);
        $stmt -> bindParam(3, $code, PDO::PARAM_STR);
        $stmt -> execute();
    }
    
    public function delete($code) {
        $stmt = CategoryAdapter::$dbh -> prepare("DELETE FROM theloaisach " .
                                                 "WHERE    MaTheLoai=?");
        $stmt -> bindParam(1, $code, PDO::PARAM_STR);
        $stmt -> execute();
    }
    
    public function canDelete($code) {
         $stmt = CategoryAdapter::$dbh -> prepare("SELECT  * " .
                                                  "FROM    sach " .
                                                  "WHERE   MaTheLoai=?");
         $stmt -> bindParam(1, $code, PDO::PARAM_INT);
         $stmt -> execute();
         return $stmt -> rowCount() == 0;
    }
    
    public function hasChildren($code) {
        $stmt = CategoryAdapter::$dbh -> prepare("SELECT    * " .
                                                  "FROM     theloaisach " .
                                                  "WHERE    TheLoaiCha=?");
         $stmt -> bindParam(1, $code, PDO::PARAM_INT);
         $stmt -> execute();
         return $stmt -> rowCount() > 0;
    }
}
?>

