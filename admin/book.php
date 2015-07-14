<?php session_start(); ?>
<?php require_once '../libs/db.php'; ?>
<?php require_once '../libs/util.php'; ?>
<?php require_once '../libs/PublisherAdapter.php'; ?>
<?php require_once '../libs/CategoryAdapter.php'; ?>
<?php require_once '../libs/AuthorAdapter.php'; ?>
<?php require_once '../libs/BookAdapter.php'; ?>
<?php

if(isset($_POST["insert"]) || isset($_POST["update"]) || isset($_POST["delete"]) || 
   isset($_POST["page"]) || isset($_POST["segment"])) {

    $publisherAdapter = PublisherAdapter::getInstance($dbh, null);
    $categoryAdapter = CategoryAdapter::getInstance($dbh, null);
    $authorAdapter = AuthorAdapter::getInstance($dbh, null);
    $bookAdapter = BookAdapter::getInstance($dbh, $_POST["search"]);
    
    if(isset($_POST['insert'])) {
        $bookAdapter -> insert($_POST['name'], $_POST['category'], 
                              $_POST['author'], $_POST['publisher'], $_POST['date'], 
                              $_POST['size'], $_POST['weight'], $_POST['price'], 
                              $_POST['quantity'], $_POST['sumary']);
    }

    if(isset($_POST['update'])) {
        $bookAdapter -> update($_POST['code'], $_POST['name'], $_POST['category'], 
                               $_POST['author'], $_POST['publisher'], $_POST['date'], 
                               $_POST['size'], $_POST['weight'], $_POST['price'], 
                               $_POST['quantity'], $_POST['sumary']);
    }

    if(isset($_POST["delete"])) {
        if($bookAdapter -> canDelete($_POST["code"])) {
            $bookAdapter -> delete($_POST["code"]);
						if($_POST["currentPath"] != "") {
							unlink("../" . $_POST["currentPath"]);
						}
        }
        else {
            echo '<script type="text/javascript">alert("Không thể xóa cuốn sách này");</script>';
        }
    }

    $totalRow = $bookAdapter -> rowCount();
    $limit = 3;
    $totalPage = getTotalPage($totalRow, $limit);
    $currentPage = !isset($_POST['page']) ? 1 : $_POST['page'];
    $numPage = 5;
    $segment = !isset($_POST['segment']) ? 1 : $_POST['segment'];
    $beginPage = getBeginPage($segment, $numPage);
    $endPage = getEndPage($beginPage, $numPage, $totalPage);
    $currentPage = getCurrentPage($currentPage, $beginPage);
    $startRow = getStartRow($currentPage, $limit);
    $stmt = $bookAdapter ->selectAll($startRow, $limit);
    $stmt -> execute();
    $rowCount = $stmt -> rowCount();
    if($rowCount) {
?>
 <div class="container-fluid">
	<div class="row">
    <form class="form-inline" style="float:right" onsubmit="return false">
        <div class="input-group">
            <input type="text" name="txtSearch" id="txtSearch" class="form-control" placeholder="Bạn cần tìm gì?">
            <span class="input-group-btn">
                <button class="btn btn-primary" type="button" id="btnSearch" data-url="book.php">
                    <span class="glyphicon glyphicon-search" />
                </button>
            </span>
        </div>
    </form>
		<button type="button" class="btn btn-success" 
                        data-toggle="modal"
                        data-target="#mdlInsert">Thêm sách</button>
	</div>
	<div class="row">&nbsp;</div>
</div>       
<table class="table table-bordered table-hover">
    <thead>
        <tr class="info">
            <th>STT</th>
            <th>Tên sách</th>
            <th>Thể loại</th>
            <th>Tác giả</th>
            <th>NXB</th>
            <th>Ngày XB</th>
            <th>Kích thước</th>
            <th>Trọng lượng</th>
            <th>Giá bìa</th>
            <th>SL tồn</th>
            <th>Hình</th>
            <th>Tóm tắt</th>
            <th>Lượt xem</th>
            <th>
                Sửa||Xóa
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        while($row = $stmt -> fetch()) {
        ?>
        <tr>
            <td><?php echo ++$startRow; ?></td>
            <td><?php echo $row["TenSach"]; ?></td>
            <td><?php echo $row["TenTheLoai"]; ?></td>
            <td><?php echo $row["TenTacGia"]; ?></td>
            <td><?php echo $row["TenNhaXuatBan"]; ?></td>
            <td><?php echo date("Y-m-d", strtotime($row["NgayXuatBan"])); ?></td>
            <td><?php echo $row["KichThuoc"]; ?></td>
            <td><?php echo $row["TrongLuong"]; ?></td>
            <td><?php echo $row["GiaBia"]; ?></td>
            <td><?php echo $row["SoLuongTon"]; ?></td>
            <td><img src="<?php echo "../" . $row["Hinh"]; ?>" width="50px" height="85px" data-toggle="modal" data-target="#mdlUpdateImage"  data-code="<?php echo $row["MaSach"]; ?>" data-path="<?php  echo $row["Hinh"]; ?>" class="editImage" /></td>
            <td><textarea rows="4" readonly><?php echo $row["TomTat"]; ?></textarea></td>
            <td><?php echo $row["LuotXem"]; ?></td>
            <td>
                <a class="edit" 
                   href="#"
                   data-toggle="modal"
                   data-target="#mdlUpdate"
                   data-code="<?php echo $row["MaSach"] ?>"
                   data-name="<?php echo $row["TenSach"]; ?>"
                   data-category="<?php echo $row["MaTheLoai"]; ?>"
                   data-author="<?php echo $row["MaTacGia"] ?>"
                   data-publisher="<?php echo $row["MaNhaXuatBan"]; ?>"
                   data-date="<?php echo $row["NgayXuatBan"]; ?>"
                   data-size="<?php echo $row["KichThuoc"]; ?>"
                   data-weight="<?php echo $row["TrongLuong"]; ?>"
                   data-price="<?php echo $row["GiaBia"]; ?>"
                   data-quantity="<?php echo $row["SoLuongTon"]; ?>"
                   data-sumary="<?php echo $row["TomTat"]; ?>">
                   <span class="glyphicon glyphicon-pencil"></span>
                </a>
                &nbsp;|&nbsp;
                <a class="delete"
                   href="#"
                   data-toggle="modal"
                   data-target="#mdlDelete"
                   data-code="<?php echo $row["MaSach"] ?>"
                   data-name="<?php echo $row["TenSach"]; ?>"
                   data-category="<?php echo $row["MaTheLoai"]; ?>"
                   data-author="<?php echo $row["MaTacGia"] ?>"
                   data-publisher="<?php echo $row["MaNhaXuatBan"]; ?>"
                   data-date="<?php echo $row["NgayXuatBan"]; ?>"
                   data-size="<?php echo $row["KichThuoc"]; ?>"
                   data-weight="<?php echo $row["TrongLuong"]; ?>"
                   data-price="<?php echo $row["GiaBia"]; ?>"
                   data-quantity="<?php echo $row["SoLuongTon"]; ?>"
									 data-image="<?php echo $row["Hinh"]; ?>"
                   data-sumary="<?php echo $row["TomTat"]; ?>">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="14">
                <ul class="pagination">
                    <li class="<?php echo $currentPage == 1 ? "disabled" : "" ?>">
                        <a href="#" class="page-number"
                           data-segment="<?php echo $segment == 1 ? 1 : $segment - 1; ?>"
                           data-page="<?php echo $beginPage - 1; ?>"
                           data-url="book.php"
													 data-search="<?php echo $_POST["search"]; ?>">
                            &laquo;
                        </a>
                        <?php
                        for($i = $beginPage; $i <= $endPage; ++$i) {
                        ?>
                    <li class="<?php echo $currentPage == $i ? 'active' : '' ?>">
                        <a href="#" class="page-number"
                           data-segment="<?php echo $segment; ?>"
                           data-page="<?php echo $i; ?>"
                           data-url="book.php"
													 data-search="<?php echo $_POST["search"]; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                        <?php
                        }
                        ?>
                    <li class="<?php echo $endPage == $totalPage ? "disabled" : "" ?>">
                        <a href="#" class="page-number"
                           data-segment="<?php echo $segment + 1; ?>"
                           data-page="<?php echo $endPage + 1; ?>"
                           data-url="book.php"
													 data-search="<?php echo $_POST["search"]; ?>">
                            &raquo;
                        </a>
                    </li>
                </ul>
            </td>
        </tr>
    </tfoot>
</table>
<div class="modal fade" id="mdlInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content panel panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Thêm sách mới</h4>
            </div>
            <div class="modal-body">
                <form id="frmInsert" name="book" method="post" action="uploadimage.php" enctype="multipart/form-data">
										<div id="divInsertResult">
											<span>&nbsp;</span>
										</div>
                    <div class="form-group">
                        <label for="txtInsertName" class="control-label">Tên sách</label>
                        <input type="text" class="form-control" id="txtInsertName" name="txtInsertName" />
                        <input type="hidden" id = "txtInsertCode" name="txtInsertCode" value="" />
                    </div>
                    <div class="form-group">
                        <label for="cbxInsertCategory" class="control-label">Thể loại</label>
                        <select class="form-control" id="cbxInsertCategory" name="cbxInsertCategory">
                            <option value="">....Chọn thể loại....</option>
                            <?php
                            $stmt = $categoryAdapter -> selectAll();
                            $stmt -> execute();
                            while($row = $stmt -> fetch()) {
                            ?>
                            <option value="<?php echo $row["MaTheLoai"]; ?>"><?php echo $row["TenTheLoai"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cbxInsertAuthor" class="control-label">Tác giả</label>
                        <select class="form-control" id="cbxInsertAuthor" name="cbxInsertAuthor">
                            <option value="">....Chọn tác giả....</option>
                            <?php
                            $stmt = $authorAdapter -> selectAll();
                            $stmt -> execute();
                            while($row = $stmt -> fetch()) {
                            ?>
                            <option value="<?php echo $row["MaTacGia"]; ?>"><?php echo $row["TenTacGia"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cbxInsertPublisher" class="control-label">Nhà xuất bản</label>
                        <select class="form-control" id="cbxInsertPublisher" name="cbxInsertPublisher">
                            <option value="">....Chọn nhà xuất bản....</option>
                            <?php
                            $stmt = $publisherAdapter -> selectAll();
                            $stmt -> execute();
                            while($row = $stmt -> fetch()) {
                            ?>
                            <option value="<?php echo $row["MaNhaXuatBan"]; ?>"><?php echo $row["TenNhaXuatBan"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group container-fluid">
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtInsertHeight" class="control-label">Chiều dài (cm)</label>
                                    <input type="text" class="form-control" id="txtInsertHeight" name="txtInsertHeight" />
                                </div>
                            </div>
                            <div class="form-group col-sm-2">
                                <div class="row">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtInsertWidth" class="control-label">Chiều rộng (cm)</label>
                                    <input type="text" class="form-control" id="txtInsertWidth" name="txtInsertWidth" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group container-fluid">
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtInsertWeight" class="control-label">Trong lượng (gram)</label>
                                    <input type="text" class="form-control" id="txtInsertWeight" name="txtInsertWeight" />
                                </div>
                            </div>
                            <div class="form-group col-sm-2">
                                <div class="row">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtInsertDate" class="control-label">Ngày xuất bản</label>
                                    <input type="date" class="form-control" id="txtInsertDate" name="txtInsertDate" />         
                                </div>
                            </div>
                        </div>       
                    </div>
                    <div class="form-group container-fluid">
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtInsertPrice" class="control-label">Giá bìa (VNĐ)</label>
                                    <input type="text" class="form-control" id="txtInsertPrice" name="txtInsertPrice" />                          
                                </div>
                            </div>
                            <div class="form-group col-sm-2">
                                <div class="row">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtInsertQuantity" class="control-label">Số lượng (Cuốn)</label>
                                    <input type="text" class="form-control" id="txtInsertQuantity" name="txtInsertQuantity" />
                                </div>
                            </div>                    
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txtInsertSumary" class="control-label">Tóm tắt</label>
                        <textarea class="form-control" rows="4" wrap="hard" id="txtInsertSumary" name="txtInsertSumary"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button id="btnInsertSubmit" name="btnInsertSubmit" type="button" class="btn btn-success" data-url="book.php">Thêm</button>
                        <button id="btnInsertCancel" name="btnInsertCancel" type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdlUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content panel panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Cập nhật thông tin sách</h4>
            </div>
            <div class="modal-body">
                <form id="frmUpdate" name="book">
										<div id="divUpdateResult">
											<span>&nbsp;</span>
										</div>
                    <div class="form-group">
                        <label for="txtUpdateName" class="control-label">Tên sách</label>
                        <input type="text" class="form-control" id="txtUpdateName" name="txtUpdateName" />
                        <input type="hidden" id="txtUpdateCode" name="txtUpdateCode" value="" />
                    </div>
                    <div class="form-group">
                        <label for="cbxUpdateCategory" class="control-label">Thể loại</label>
                        <select class="form-control" id="cbxUpdateCategory" name="cbxUpdateCategory">
                            <option class="0" value="">....Chọn thể loại....</option>
                            <?php
                            $stmt = $categoryAdapter -> selectAll();
                            $stmt -> execute();
                            while($row = $stmt -> fetch()) {
                            ?>
                            <option class="<?php echo $row["MaTheLoai"]; ?>" value="<?php echo $row["MaTheLoai"]; ?>"><?php echo $row["TenTheLoai"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cbxUpdateAuthor" class="control-label">Tác giả</label>
                        <select class="form-control" id="cbxUpdateAuthor" name="cbxUpdateAuthor">
                            <option class="0" value="">....Chọn tác giả....</option>
                            <?php
                            $stmt = $authorAdapter -> selectAll();
                            $stmt -> execute();
                            while($row = $stmt -> fetch()) {
                            ?>
                            <option class="<?php echo $row["MaTacGia"]; ?>" value="<?php echo $row["MaTacGia"]; ?>"><?php echo $row["TenTacGia"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cbxUpdatePublisher" class="control-label">Nhà xuất bản</label>
                        <select class="form-control" id="cbxUpdatePublisher" name="cbxUpdatePublisher">
                            <option class="0" value="">....Chọn nhà xuất bản....</option>
                            <?php
                            $stmt = $publisherAdapter -> selectAll();
                            $stmt -> execute();
                            while($row = $stmt -> fetch()) {
                            ?>
                            <option class="<?php echo $row["MaNhaXuatBan"]; ?>" value="<?php echo $row["MaNhaXuatBan"]; ?>"><?php echo $row["TenNhaXuatBan"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group container-fluid">
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtUpdateHeight" class="control-label">Chiều dài (cm)</label>
                                    <input type="text" class="form-control" id="txtUpdateHeight" name="txtUpdateHeight" />
                                </div>
                            </div>
                            <div class="form-group col-sm-2">
                                <div class="row">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtUpdateWidth" class="control-label">Chiều rộng (cm)</label>
                                    <input type="text" class="form-control" id="txtUpdateWidth" name="txtUpdateWidth" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group container-fluid">
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtUpdateDate" class="control-label">Ngày xuất bản</label>
                                    <input type="date" class="form-control" id="txtUpdateDate" name="txtUpdateDate" />
                                </div>
                            </div>
                            <div class="form-group col-sm-2">
                                <div class="row">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtUpdateWeight" class="control-label">Trong lượng (gram)</label>
                                    <input type="text" class="form-control" id="txtUpdateWeight" name="txtUpdateWeight" />
                                </div>
                            </div>
                        </div>       
                    </div>
                    <div class="form-group container-fluid">
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtUpdatePrice" class="control-label">Giá bìa (VNĐ)</label>
                                    <input type="text" class="form-control" id="txtUpdatePrice" name="txtUpdatePrice" />
                                </div>
                            </div>
                            <div class="form-group col-sm-2">
                                <div class="row">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtUpdateQuantity" class="control-label">Số lượng (Cuốn)</label>
                                    <input type="text" class="form-control" id="txtUpdateQuantity" name="txtUpdateQuantity" />
                                </div>
                            </div>                    
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txtUpdateSumary" class="control-label">Tóm tắt</label>
                        <textarea class="form-control" rows="4" wrap="hard" id="txtUpdateSumary" name="txtUpdateSumary"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button id="btnUpdateSubmit" name="txtUpdateSubmit" type="button" class="btn btn-info" data-url="book.php">Cập nhật</button>
                        <button id="btnUpdateCancel" name="txtUpdateCancel" type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdlDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content panel panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Xóa sách</h4>
            </div>
            <div class="modal-body">
                <form id="frmDelete" name="book">
                    <div class="form-group">
                        <label for="txtDeleteName" class="control-label">Tên sách</label>
                        <input type="text" class="form-control" id="txtDeleteName" name="txtDeleteName" />
                        <input type="hidden" id="txtDeleteCode" name="txtDeleteCode" value="" />
												<input type="hidden" id="txtDeleteImage" name="txtDeleteImage" value="" />
                    </div>
                    <div class="form-group">
                        <label for="cbxDeleteCategory" class="control-label">Thể loại</label>
                        <select class="form-control" id="cbxDeleteCategory" name="cbxDeleteCategory">
                            <option class="0" value="">....Chọn thể loại....</option>
                            <?php
                            $stmt = $categoryAdapter -> selectAll();
                            $stmt -> execute();
                            while($row = $stmt -> fetch()) {
                            ?>
                            <option class="<?php echo $row["MaTheLoai"]; ?>" value="<?php echo $row["MaTheLoai"]; ?>"><?php echo $row["TenTheLoai"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cbxDeleteAuthor" class="control-label">Tác giả</label>
                        <select class="form-control" id="cbxDeleteAuthor" name="cbxDeleteAuthor">
                            <option class="0" value="">....Chọn tác giả....</option>
                            <?php
                            $stmt = $authorAdapter -> selectAll();
                            $stmt -> execute();
                            while($row = $stmt -> fetch()) {
                            ?>
                            <option class="<?php echo $row["MaTacGia"]; ?>" value="<?php echo $row["MaTacGia"]; ?>"><?php echo $row["TenTacGia"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cbxDeletePublisher" class="control-label">Nhà xuất bản</label>
                        <select class="form-control" id="cbxDeletePublisher" name="cbxDeletePublisher">
                            <option class="0" value="">....Chọn nhà xuất bản....</option>
                            <?php
                            $stmt = $publisherAdapter -> selectAll();
                            $stmt -> execute();
                            while($row = $stmt -> fetch()) {
                            ?>
                            <option class="<?php echo $row["MaNhaXuatBan"]; ?>" value="<?php echo $row["MaNhaXuatBan"]; ?>"><?php echo $row["TenNhaXuatBan"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group container-fluid">
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtDeleteHeight" class="control-label">Chiều dài (cm)</label>
                                    <input type="text" class="form-control" id="txtDeleteHeight" name="txtDeleteHeight" />
                                </div>
                            </div>
                            <div class="form-group col-sm-2">
                                <div class="row">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtDeleteDate" class="control-label">Ngày xuất bản</label>
                                    <input type="date" class="form-control" id="txtDeleteDate" name="txtDeleteDate" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group container-fluid">
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtDeleteWidth" class="control-label">Chiều rộng (cm)</label>
                                    <input type="text" class="form-control" id="txtDeleteWidth" name="txtDeleteWidth" />
                                </div>
                            </div>
                            <div class="form-group col-sm-2">
                                <div class="row">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtDeleteWeight" class="control-label">Tromg lượng (gram)</label>
                                    <input type="text" class="form-control" id="txtDeleteWeight" name="txtDeleteWeight" />
                                </div>
                            </div>
                        </div>       
                    </div>
                    <div class="form-group container-fluid">
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtDeletePrice" class="control-label">Giá bìa (VNĐ)</label>
                                    <input type="text" class="form-control" id="txtDeletePrice" name="txtDeletePrice" />
                                </div>
                            </div>
                            <div class="form-group col-sm-2">
                                <div class="row">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtDeleteQuantity" class="control-label">Số lượng (Cuốn)</label>
                                    <input type="text" class="form-control" id="txtDeleteQuantity" name="txtDeleteQuantity" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txtDeleteSumary" class="control-label">Tóm tắt</label>
                        <textarea class="form-control" rows="4" wrap="hard" id="txtDeleteSumary" name="txtDeleteSuamry"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Bạn thực sự muốn xóa ?</label>
                        
                    </div>
                    <div class="modal-footer">
                        <button id="btnDeleteSubmit" name="txtDeleteSubmit" type="button" class="btn btn-warning" data-url="book.php">Xóa</button>
                        <button id="btnDeleteCancel" name="txtDeleteCancel" type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdlUpdateImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content panel panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Thêm hình cho sách</h4>
            </div>
            <div class="modal-body">
                <form id="frmUpdateImage" name="book">
                    <div class="form-group">
                        <label for="txtUpdateImageName" class="control-label">Chọn hình</label>
                        <input type="file" class="form-control" id="fcrUpdateImagePath" name="fcrUpdateImagePath" />
                    </div>
                    <div class="modal-footer">
                        <button id="btnUpdateImageSubmit" name="btnUpdateImageSubmit" type="button" class="btn btn-info" data-url="uploadimage.php">Cập nhật</button>
                        <button id="btnUpdateImageCancel" name="btnUpdateImageCancel" type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<?php
    }
    else {
?>
<div>Không tìm thấy dữ liệu sách 
    <button type="button" id="btnInsert" name="btnInsert" class="btn btn-success" 
            data-toggle="modal"
            data-target="#mdlInsert">
        Thêm sách mới
    </button>
</div>
<div class="modal fade" id="mdlInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content panel panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Thêm sách mới</h4>
            </div>
            <div class="modal-body">
                <form id="frmInsert" name="book" method="" action="">
                    <div class="form-group">
                        <label for="txtInsertName" class="control-label">Tên sách</label>
                        <input type="text" class="form-control" id="txtInsertName" name="txtInsertName" />
                        <input type="hidden" id = "txtInsertCode" name="txtInsertCode" value="" />
                    </div>
                    <div class="form-group">
                        <label for="cbxInsertCategory" class="control-label">Thể loại</label>
                        <select class="form-control" id="cbxInsertCategory" name="cbxInsertCategory">
                            <option value="">....Chọn thể loại....</option>
                            <?php
                            $stmt = $categoryAdapter -> selectAll();
                            $stmt -> execute();
                            while($row = $stmt -> fetch()) {
                            ?>
                            <option value="<?php echo $row["MaTheLoai"]; ?>"><?php echo $row["TenTheLoai"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cbxInsertAuthor" class="control-label">Tác giả</label>
                        <select class="form-control" id="cbxInsertAuthor" name="cbxInsertAuthor">
                            <option value="">....Chọn tác giả....</option>
                            <?php
                            $stmt = $authorAdapter -> selectAll();
                            $stmt -> execute();
                            while($row = $stmt -> fetch()) {
                            ?>
                            <option value="<?php echo $row["MaTacGia"]; ?>"><?php echo $row["TenTacGia"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cbxInsertPublisher" class="control-label">Nhà xuất bản</label>
                        <select class="form-control" id="cbxInsertPublisher" name="cbxInsertPublisher">
                            <option value="">....Chọn nhà xuất bản....</option>
                            <?php
                            $stmt = $publisherAdapter -> selectAll();
                            $stmt -> execute();
                            while($row = $stmt -> fetch()) {
                            ?>
                            <option value="<?php echo $row["MaNhaXuatBan"]; ?>"><?php echo $row["TenNhaXuatBan"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group container-fluid">
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtInsertHeight" class="control-label">Chiều dài (cm)</label>
                                    <input type="text" class="form-control" id="txtInsertHeight" name="txtInsertHeight" />
                                </div>
                            </div>
                            <div class="form-group col-sm-2">
                                <div class="row">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtInsertWidth" class="control-label">Chiều rộng (cm)</label>
                                    <input type="text" class="form-control" id="txtInsertWidth" name="txtInsertWidth" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group container-fluid">
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtInsertWeight" class="control-label">Trong lượng (gram)</label>
                                    <input type="text" class="form-control" id="txtInsertWeight" name="txtInsertWeight" />
                                </div>
                            </div>
                            <div class="form-group col-sm-2">
                                <div class="row">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtInsertDate" class="control-label">Ngày xuất bản</label>
                                    <input type="date" class="form-control" id="txtInsertDate" name="txtInsertDate" />         
                                </div>
                            </div>
                        </div>       
                    </div>
                    <div class="form-group container-fluid">
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtInsertPrice" class="control-label">Giá bìa (VNĐ)</label>
                                    <input type="text" class="form-control" id="txtInsertPrice" name="txtInsertPrice" />                          
                                </div>
                            </div>
                            <div class="form-group col-sm-2">
                                <div class="row">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="form-group col-sm-5">
                                <div class="row">
                                    <label for="txtInsertQuantity" class="control-label">Số lượng (Cuốn)</label>
                                    <input type="text" class="form-control" id="txtInsertQuantity" name="txtInsertQuantity" />
                                </div>
                            </div>                    
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txtInsertSumary" class="control-label">Tóm tắt</label>
                        <textarea class="form-control" rows="4" wrap="hard" id="txtInsertSumary" name="txtInsertSumary"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button id="btnInsertSubmit" name="btnInsertSubmit" type="button" class="btn btn-success" data-url="book.php">Thêm</button>
                        <button id="btnInsertCancel" name="btnInsertCancel" type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    }
}
else {
    echo '<meta http-equiv="refresh" content="0;URL=./">';
}
?>