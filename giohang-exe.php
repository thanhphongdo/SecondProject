<?php
	session_start();
	//Them vao gio hang
		if(isset($_POST["masach"])){
	            //Tao gio hang neu chua co
	            if(!isset($_SESSION["giohang"])){
	                $_SESSION["giohang"]=array();
	            }
	            $masach=$_POST["masach"];
	            $tontai=0;
	            $i=0;
	            //Kiem tra sach da ton tai chua
	            foreach($_SESSION["giohang"] as $item){
	                if($item["masach"]==$masach){
	                    $_SESSION["giohang"][$i]["soluong"]=$item["soluong"]+1;
	                    $tontai=1;
	                }
	                $i++;
	            }
	            //Sach chua ton tai
	            if($tontai==0){
	                $sachmoi=array(
	                    "masach"=>$masach,
	                    "soluong"=>1
	                );
	                $_SESSION["giohang"][]=$sachmoi;
	            }
	            header("location: giohang.php");
	    }
	    else{
	       	header("location: index.php");
	    }
	//Xu ly chung
	if(isset($_SESSION["giohang"])){
		if(isset($_SESSION["usernameKH"])){
		//Thay doi so luong
		if(isset($_POST["sl"])){
			$masach=$_POST["masach-them"];
			$sl=$_POST["sl"];
			$i=0;
			foreach($_SESSION["giohang"] as $item){
				if($item["masach"]==$masach){
					$_SESSION["giohang"][$i]["soluong"]=$sl;
				}
				$i++;
			}
		}
		//Xoa sach tron gio hang
		if(isset($_POST["masach-xoa"])){
			$masach=$_POST["masach-xoa"];
			$i=0;
			foreach($_SESSION["giohang"] as $item){
				if($item["masach"]==$masach){
					unset($_SESSION["giohang"][$i]);
					$_SESSION["giohang"] = array_values($_SESSION["giohang"]);
				}
				$i++;
			}
		}
		//Luu csdl
		if(isset($_POST["luu-csdl"])){
			require "libs/db.php";
			//Don hang
			$taikhoan=$_SESSION["usernameKH"];
			$tongtien=$_POST["tongtien"];
			$tongtrong=$_POST["tongtrong"];
			$NgayDH = date("Y-m-d");

			$NgayGH=strtotime(date("Y-m-d", strtotime($NgayDH)) . " +15 day");
			$NgayGH = strftime("%Y-%m-%d",$NgayGH);

			$sql="INSERT INTO `donhang`(`TaiKhoan`, `NgayDH`, `NgayGH`, `TrangThai`, `TongTien`, `TongTrongLuong`,`PhiVanChuyen`) VALUES ('$taikhoan','$NgayDH','$NgayGH','Chua giao',$tongtien,$tongtrong,$tongtrong*10)";

			$stmt=$dbh->prepare($sql);
			$stmt->execute();
			//Chi tiet don hang
			$id=$dbh->lastInsertId();
			//$_SESSION["tam"]=$id;
			foreach($_SESSION["giohang"] as $item){
				$masach=$item["masach"];
				$soluong=$item["soluong"];
				//Them chi tiet
				$sql="INSERT INTO `chitietdonhang`(`MaDonHang`, `MaSach`, `SoLuong`) 
					VALUES ($id,$masach,$soluong)";
				$stmt=$dbh->prepare($sql);
				$stmt->execute();
				//Cap nhat so luong
				$sql="Update `sach` set soluongton = soluongton-$soluong where masach='$masach'";
				$stmt=$dbh->prepare($sql);
				$stmt->execute();
			}
			unset($_SESSION["giohang"]);
		}
	}
}
	
?>