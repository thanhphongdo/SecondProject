<?php
class PublisherAdapter {
    private static $dbh;
		private static $search;
    public static function getInstance($dbh, $search) {
        PublisherAdapter::$dbh = $dbh;
				PublisherAdapter::$search = $search;
        return new PublisherAdapter();
    }
    
		public function rowCount() {
			$stmt = PublisherAdapter::$dbh -> prepare("SELECT     COUNT(*) AS Total " . 
																																						"FROM       	nhaxuatban " .
																																						"WHERE			TenNhaXuatBan LIKE '%" . PublisherAdapter::$search . "%'");
			$stmt -> execute();
			$row = $stmt -> fetch();
			return $row["Total"];
		}
		
    public function selectAll($startRow = null, $limit = null) {
        $stmt = null;
        if($startRow == null && $limit == null) {
            $stmt = PublisherAdapter::$dbh -> prepare("SELECT     * " . 
                                                      "FROM       nhaxuatban");
        }
        else {
            $stmt = PublisherAdapter::$dbh -> prepare("SELECT     * " . 
                                                      "FROM       nhaxuatban " .
																											"WHERE			TenNhaXuatBan LIKE '%" . PublisherAdapter::$search . "%' " .
                                                      "LIMIT      " . $startRow . ", " . $limit);
        }
        return $stmt;
    }
    
    public function insert($name) {
        $stmt = PublisherAdapter::$dbh -> prepare("INSERT INTO NhaXuatBan (TenNhaXuatBan) " .
                                                  "VALUES (?)");
        $stmt -> bindParam(1, $name, PDO::PARAM_STR);
        $stmt -> execute();
    }
    
    public function update($code, $name) {
        $stmt = PublisherAdapter::$dbh -> prepare("UPDATE   NhaXuatBan " .
                                                  "SET      TenNhaXuatBan=? " .
                                                  "WHERE    MaNhaXuatBan=?");
        $stmt -> bindParam(1, $name, PDO::PARAM_STR);
        $stmt -> bindParam(2, $code, PDO::PARAM_STR);
        $stmt -> execute();
    }
    
    public function delete($code) {
        $stmt = PublisherAdapter::$dbh -> prepare("DELETE FROM NhaXuatBan " .
                                                  "WHERE    MaNhaXuatBan=?");
        $stmt -> bindParam(1, $code, PDO::PARAM_STR);
        $stmt -> execute();
    }
    
    public function canDelete($code) {
         $stmt = PublisherAdapter::$dbh -> prepare("SELECT  * " .
                                                   "FROM    sach " .
                                                   "WHERE   MaNhaXuatBan=?");
         $stmt -> bindParam(1, $code, PDO::PARAM_INT);
         $stmt -> execute();
         return $stmt -> rowCount() == 0;
    }
}
?>

