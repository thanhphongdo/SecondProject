<div id="DN-Box" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title active">Đăng nhập</h4>
            </div>
            <form name="DangNhap" action="" class="form-horizontal">
            <div class="modal-body">
                    <div class="form-group has-success">
                        <label class="control-label col-sm-3">Tên đăng nhập:</label>
                        <div class="col-sm-9">
	                        <input type="textbox" id="txtUserName" name="txtUserName" 
                            class="form-control" placeholder="user name"
                            value="<?php if(isset($_COOKIE['usernameKH'])) echo($_COOKIE['usernameKH']) ?>">
                        </div>
                    </div>
                    <div class="form-group has-success">
                        <label class="control-label col-sm-3">Mật khẩu:</label>
                        <div class="col-sm-9">
                            <input type="password" id="txtPass" name="txtPass" 
                            class="form-control" placeholder="password"
                            value="<?php if(isset($_COOKIE['usernameKH'])) echo($_COOKIE['passKH']) ?>">
                        </div>
                    </div>
                    <div class="form-group has-success">
                        <div class="col-sm-3"></div>
                        <div class="checkbox col-sm-4">
                            <label><input type="checkbox" id="chkRemember" name="chkRemember" checked>Nhớ tôi!</label>
                        </div>
                        <div class="checkbox col-sm-5" style="text-align:right">
                        	<a href="http://www.24h.com.vn">Quên mật khẩu?</a> | 
                        	<a href="signup.php">Đăng ký</a>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default" id="btnDangNhap" data-dismiss="modal">Đăng nhập</button>
                <button type="button" class="btn btn-primary" id="btnDong" data-dismiss="modal">Đóng</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div id="DX-Box" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title active">Đăng nhập thất bại</h4>
            </div>
            <form name="DangXuat" action="" class="form-horizontal">
            <div class="modal-body">
                Username hoặc password sai hoặc tài khoản của bạn đã bị khóa!
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#DN-Box">Đăng nhập lại</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Đăng ký</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php
	if(!empty($_SESSION['loginfail']) && $_SESSION['loginfail'] == 'true'){
		echo('<input type="hidden" id="fail" value="true">');
		$_SESSION['loginfail'] == 'false';
	}
	if(isset($_POST['username'])){
		require "./libs/db.php";
		$user = strtoupper($_POST['username']);
		$pass = md5($_POST['pass']);
        $remember = $_POST['remember'];
		$stmt = $dbh -> prepare("SELECT * FROM  `thanhvien` ".
                                "WHERE TaiKhoan = ? and MatKhau = ? and Locked ='0'");
        $stmt->bindParam(1,$user,PDO::PARAM_STR);
        $stmt->bindParam(2,$pass,PDO::PARAM_STR);
        $stmt -> execute();
        if($row = $stmt -> fetch()){
			$_SESSION['usernameKH'] = $user;
			$_SESSION['passKH'] = $pass;
			$_SESSION['tenKH'] = $row['HoTen'];
            if($remember == "true"){
                setcookie("usernameKH", $_POST['username'], time() + (24*3600*30), "/");
                setcookie("passKH", $_POST['pass'], time() + (24*3600*30), "/");
            }
            else{
                setcookie("usernameKH", $user, time() - 3600, "/");
                setcookie("passKH", $pass, time() - 3600, "/");
            }
        }
        else{
        	$_SESSION['loginfail'] = 'true';
        }
		//header('Refresh: 0; url=index.php');
        echo '<meta http-equiv="refresh" content="0;URL=index.php">';
	}
	else{
		$_SESSION['loginfail'] = 'false';
	}
?>
<?php
if(isset($_COOKIE['usernameKH']) && empty($_SESSION['usernameKH'])){
    require "./libs/db.php";
    $user = strtoupper($_COOKIE['usernameKH']);
    $pass = md5($_COOKIE['passKH']);
    $remember = true;
    $stmt = $dbh -> prepare("SELECT * FROM  `thanhvien` ".
                            "WHERE TaiKhoan = ? and MatKhau = ? and Locked = '0'");
    $stmt->bindParam(1,$user,PDO::PARAM_STR);
    $stmt->bindParam(2,$pass,PDO::PARAM_STR);
    $stmt -> execute();
    if($row = $stmt -> fetch()){
        $_SESSION['usernameKH'] = $user;
        $_SESSION['passKH'] = $pass;
        $_SESSION['tenKH'] = $row['HoTen'];
        //$_SESSION['logged'] = 'true';
    }
}
?>
