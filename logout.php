<?php
	session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	if (isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'true'){
		unset($_SESSION['usernameKH']);
		unset($_SESSION['passKH']);
		try{
			setcookie("usernameKH", $user, time() - 3600, "/");
	        setcookie("passKH", $pass, time() - 3600, "/");
	        unset($_COOKIE['usernameKH']);
	        unset($_COOKIE['passKH']);
	        unset($_SESSION["giohang"]);
	    }
	    catch(Exception $e){}
		$_SESSION['DX'] = 'true';
		header('Refresh: 0; url=index.php');
	}
?>