<?php
	session_start();
	if(isset($_SESSION["giohang"])){
		$masach=$_POST["masach"];
		$sl=$_POST["sl"];
		$i=0;
		foreach($_SESSION["giohang"] as $item){
			if($item["masach"]==$masach){
				$_SESSION["giohang"][$i]["soluong"]=$sl;
			}
			$i++;
		}
	}
	
?>