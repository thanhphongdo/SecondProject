<?php
	if(isset($_POST['user'])){
		require "./libs/db.php";
		$user = strtoupper($_POST['user']);
		$stmt = $dbh -> prepare("SELECT * FROM  `thanhvien` WHERE TaiKhoan = ?");
        $stmt->bindParam(1,$user,PDO::PARAM_STR);
        $stmt -> execute();
        if($row = $stmt -> fetch()){
    	?>
			<div></div>
    	<?php
        }
	}
?>