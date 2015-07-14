<?php
class AuthorAdapter {
    private static $dbh;
		private static $search;
    public static function getInstance($dbh, $search) {
        AuthorAdapter::$dbh = $dbh;
				AuthorAdapter::$search = $search;
        return new AuthorAdapter();
    }
		
		public function rowCount() {
			$stmt = AuthorAdapter::$dbh -> prepare("SELECT     COUNT(*) AS Total " . 
																																						"FROM       	tacgia " .
																																						"WHERE			TenTacGia LIKE '%" . AuthorAdapter::$search . "%'");
			$stmt -> execute();
			$row = $stmt -> fetch();
			return $row["Total"];
		}
		
    public function selectAll($startRow = null, $limit = null) {
        $stmt = null;
        if($startRow == null && $limit == null) {
             $stmt = AuthorAdapter::$dbh -> prepare("SELECT     * " . 
																																									"FROM       tacgia");
        }
        else {
            $stmt = AuthorAdapter::$dbh -> prepare("SELECT     * " . 
                                                   "FROM       tacgia " .
																									 "WHERE			TenTacGia LIKE '%" . AuthorAdapter::$search . "%' " .
                                                   "LIMIT      " . $startRow . ", " . $limit);
        }
        return $stmt;
    }
    
    public function insert($name) {
        $stmt = AuthorAdapter::$dbh -> prepare("INSERT INTO tacgia (TenTacGia) " .
                                               "VALUES (?)");
        $stmt -> bindParam(1, $name, PDO::PARAM_STR);
        $stmt -> execute();
    }
    
    public function update($code, $name) {
        $stmt = AuthorAdapter::$dbh -> prepare("UPDATE   tacgia " .
                                               "SET      TenTacGia=? " .
                                               "WHERE    MaTacGia=?");
        $stmt -> bindParam(1, $name, PDO::PARAM_STR);
        $stmt -> bindParam(2, $code, PDO::PARAM_STR);
        $stmt -> execute();
    }
    
    public function delete($code) {
        $stmt = AuthorAdapter::$dbh -> prepare("DELETE FROM     tacgia " .
                                               "WHERE           MaTacGia=?");
        $stmt -> bindParam(1, $code, PDO::PARAM_STR);
        $stmt -> execute();
    }
    
    public function canDelete($code) {
         $stmt = AuthorAdapter::$dbh -> prepare("SELECT  * " .
                                                "FROM    sach " .
                                                "WHERE   MaTacGia=?");
         $stmt -> bindParam(1, $code, PDO::PARAM_INT);
         $stmt -> execute();
         return $stmt -> rowCount() == 0;
    }
}
?>

