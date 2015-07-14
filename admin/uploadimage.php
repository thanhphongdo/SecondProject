<?php require_once '../libs/db.php'; ?>
<?php require_once '../libs/BookAdapter.php'; ?>
<?php
if($_POST["currentPath"] != "") {
	unlink("../" . $_POST["currentPath"]);
}
move_uploaded_file($_FILES["objImage"]["tmp_name"],"../images/". $_FILES["objImage"]["name"]);
$bookAdapter =  BookAdapter::getInstance($dbh, null);
$bookAdapter -> updateImage( $_POST["code"], "images/" . $_FILES["objImage"]["name"]);
echo "images/" . $_FILES["objImage"]["name"] ;
?>
