<?php require_once '../libs/db.php'; ?>
<?php require_once '../libs/util.php'; ?>
<?php require_once '../libs/CategoryAdapter.php'; ?>
<?php

if(isset($_POST["insert"]) || isset($_POST["update"]) || isset($_POST["delete"]) || 
   isset($_POST["page"]) || isset($_POST["segment"])) {

    $categoryAdapter = CategoryAdapter::getInstance($dbh, $_POST["search"]);

    if(isset($_POST["insert"])) {   
       $categoryAdapter -> insert($_POST["name"], $_POST["parent"]);
    }

    if(isset($_POST["update"])) {
        $categoryAdapter -> update($_POST["code"], $_POST["name"], $_POST["parent"]);
    }

    if(isset($_POST["delete"])) {
        if($categoryAdapter -> hasChildren($_POST["code"])) {
            echo '<script type="text/javascript">alert("Xóa thể loại con của thể loại này trước");</script>';
        }
        else {
            if($categoryAdapter -> canDelete($_POST["code"])) {
                $categoryAdapter -> delete($_POST["code"]);
            }
            else {
                echo '<script type="text/javascript">alert("Không thể xóa thể loại sách này");</script>';
            }
        }
    }

    $totalRow = $categoryAdapter -> rowCount();
    $limit = 10;
    $totalPage = getTotalPage($totalRow, $limit);
    $currentPage = !isset($_POST['page']) ? 1 : $_POST['page'];
    $numPage = 5;
    $segment = !isset($_POST['segment']) ? 1 : $_POST['segment'];
    $beginPage = getBeginPage($segment, $numPage);
    $endPage = getEndPage($beginPage, $numPage, $totalPage);
    $currentPage = getCurrentPage($currentPage, $beginPage);
    $startRow = getStartRow($currentPage, $limit);
    $stmt = $categoryAdapter -> selectAll($startRow, $limit);
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
                <button class="btn btn-primary" type="button" id="btnSearch" data-url="category.php">
                    <span class="glyphicon glyphicon-search" />
                </button>
            </span>
        </div>
    </form>
		<button type="button" class="btn btn-success" 
                        data-toggle="modal"
                        data-target="#mdlInsert">Thêm thể loại sách</button>
	</div>
	<div class="row">&nbsp;</div>
</div>
<table class="table table-bordered table-hover">
    <thead>
        <tr class="info">
            <th>STT</th>
            <th>Tên thể loại</th>
            <th>Thể loại cha</th>
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
            <td><?php echo $row["TenTheLoai"]; ?></td>
            <td><?php echo $row["TenTheLoaiCha"] == '' ? "Không có" : $row["TenTheLoaiCha"]; ?></td>
            <td>
                <a class="edit" 
                   href="#"
                   data-toggle="modal"
                   data-target="#mdlUpdate"
                   data-code="<?php echo $row["MaTheLoai"] ?>"
                   data-name="<?php echo $row["TenTheLoai"]; ?>"
                   data-parent="<?php echo $row["MaTheLoaiCha"] == '' ? 0 : $row["MaTheLoaiCha"]; ?>">
                   <span class="glyphicon glyphicon-pencil"></span>
                </a>
                &nbsp;|&nbsp;
                <a class="delete"
                   href="#"
                   data-toggle="modal"
                   data-target="#mdlDelete"
                   data-code="<?php echo $row["MaTheLoai"] ?>"
                   data-name="<?php echo $row["TenTheLoai"]; ?>"
                   data-parent="<?php echo $row["MaTheLoaiCha"] == '' ? 0 : $row["MaTheLoaiCha"]; ?>">
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
            <td colspan="4">
                <ul class="pagination">
                    <li class="<?php echo $currentPage == 1 ? "disabled" : "" ?>">
                        <a href="#" class="page-number"
                           data-segment="<?php echo $segment == 1 ? 1 : $segment - 1; ?>"
                           data-page="<?php echo $beginPage - 1; ?>"
                           data-url="category.php"
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
                           data-url="category.php"
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
                           data-page="<?php echo $endPage + 1 ?>"
                           data-url="category.php"
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
                <h4 class="modal-title" id="exampleModalLabel">Thêm thể loại mới</h4>
            </div>
            <div class="modal-body">
                <form id="frmInsert" name="category">
										<div id="divInsertResult">
											<span>&nbsp;</span>
										</div>
                    <div class="form-group">
                        <label for="txtInsertName" class="control-label">Tên thể loại sách</label>
                        <input type="text" class="form-control" id="txtInsertName" name="txtInsertName" />
                        <input type="hidden" id = "txtInsertCode" name="txtInsertCode" value="" />
                    </div>
                    <div class="form-group">
                        <label for="cbxInsertParent" class="control-label">Tên thể loại cha</label>
                        <select class="form-control" id="cbxInsertParent" name="cbxInsertParent">
                            <option value="" selected>....Chọn thể loại....</option>
                            <?php
                            $stmt = $categoryAdapter ->selectParentCategory();
                            $stmt -> execute();
                            while($row = $stmt -> fetch()) {
                            ?>
                            <option value="<?php echo $row["MaTheLoai"]; ?>"><?php echo $row["TenTheLoai"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button id="btnInsertSubmit" name="txtInsertSubmit" type="button" class="btn btn-success" data-url="category.php">Thêm</button>
                        <button id="btnInsertCancel" name="txtInsertCancel" type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
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
                <h4 class="modal-title" id="exampleModalLabel">Cập nhật thông tin thể loại sách</h4>
            </div>
            <div class="modal-body">
                <form id="frmUpdate" name="category">
										<div id="divUpdateResult">
											<span>&nbsp;</span>
										</div>
                    <div class="form-group">
                        <label for="txtUpdateName" class="control-label">Tên thể loại sách</label>
                        <input type="text" class="form-control" id="txtUpdateName" />
                        <input type="hidden" id = "txtUpdateCode" name="txtUpdateCode" />
                    </div>
                    <div class="form-group">
                        <label for="cbxUpdateParent" class="control-label">Tên thể loại cha</label>
                        <select class="form-control" id="cbxUpdateParent" name="cbxUpdateParent">
                            <option class="0" value="">....Chọn thể loại....</option>
                            <?php
                            $stmt = $categoryAdapter ->selectParentCategory();
                            $stmt -> execute();
                            while($row = $stmt -> fetch()) {
                            ?>
                            <option class="<?php echo $row["MaTheLoai"] ?>" value="<?php echo $row["MaTheLoai"]; ?>"><?php echo $row["TenTheLoai"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button id="btnUpdateSubmit" type="button" class="btn btn-info" data-url="category.php">Cập nhật</button>
                        <button id="btnUpdateCancel" type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
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
                <h4 class="modal-title" id="exampleModalLabel">Xóa thể loại sách</h4>
            </div>
            <div class="modal-body">
                <form id="frmDelete" name="category">
                    <div class="form-group">
                        <label for="txtDeleteName" class="control-label">Tên thể loại sách</label>
                        <input type="text" class="form-control" id="txtDeleteName" />
                        <input type="hidden" id = "txtDeleteCode" name="txtDeleteCode" value="" />
                    </div>
                    <div class="form-group">
                        <label for="cbxDeleteParent" class="control-label">Tên thể loại cha</label>
                        <select class="form-control" id="cbxDeleteParent" name="cbxDeleteParent">
                            <option class="0" value="">....Chọn thể loại....</option>
                             <?php
                            $stmt = $categoryAdapter ->selectParentCategory();
                            $stmt -> execute();
                            while($row = $stmt -> fetch()) {
                            ?>
                            <option class="<?php echo $row["MaTheLoai"] ?>" value="<?php echo $row["MaTheLoai"]; ?>"><?php echo $row["TenTheLoai"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        Bạn thực sự muốn xóa ?
                    </div>
                    <div class="modal-footer">
                        <button id="btnDeleteSubmit" type="button" class="btn btn-warning" data-url="category.php">Xóa</button>
                        <button id="btnDeleteCancel" type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
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
<div>Không tìm thấy dữ liệu thể loại sách</div>
<?php
    }
}
else {
    echo '<meta http-equiv="refresh" content="0;URL=./">';
}
?>