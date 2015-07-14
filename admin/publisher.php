<?php require_once '../libs/db.php'; ?>
<?php require_once '../libs/util.php'; ?>
<?php require_once '../libs/PublisherAdapter.php'; ?>
<?php

if(isset($_POST["insert"]) || isset($_POST["update"]) || isset($_POST["delete"]) || 
   isset($_POST["page"]) || isset($_POST["segment"])) {

    $publisherAdapter = PublisherAdapter::getInstance($dbh, $_POST["search"]);

    if(isset($_POST['insert'])) {   
       $publisherAdapter -> insert($_POST['name']);
    }

    if(isset($_POST['update'])) {
        $publisherAdapter -> update($_POST['code'], $_POST['name']);
    }

    if(isset($_POST["delete"])) {
        if($publisherAdapter -> canDelete($_POST["code"])) {
            $publisherAdapter -> delete($_POST["code"]);
        }
        else {
            echo '<script type="text/javascript">alert("Không thể xóa nhà xuất bản này");</script>';
        }
    }

    $totalRow = $publisherAdapter -> rowCount();
    $limit = 10;
    $totalPage = getTotalPage($totalRow, $limit);
    $currentPage = !isset($_POST['page']) ? 1 : $_POST['page'];
    $numPage = 5;
    $segment = !isset($_POST['segment']) ? 1 : $_POST['segment'];
    $beginPage = getBeginPage($segment, $numPage);
    $endPage = getEndPage($beginPage, $numPage, $totalPage);
    $currentPage = getCurrentPage($currentPage, $beginPage);
    $startRow = getStartRow($currentPage, $limit);
    $stmt = $publisherAdapter ->selectAll($startRow, $limit);
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
                <button class="btn btn-primary" type="button" id="btnSearch" data-url="publisher.php">
                    <span class="glyphicon glyphicon-search" />
                </button>
            </span>
        </div>
    </form>
		<button type="button" class="btn btn-success" 
                        data-toggle="modal"
                        data-target="#mdlInsert">Thêm nhà xuất bản</button>
	</div>
	<div class="row">&nbsp;</div>
</div>
<table class="table table-bordered table-hover">
    <thead>
        <tr class="info">
            <th>STT</th>
            <th>Tên nhà xuất bản</th>
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
            <td><?php echo $row["TenNhaXuatBan"]; ?></td>
            <td>
                <a class="edit" 
                   href="#"
                   data-toggle="modal"
                   data-target="#mdlUpdate"
                   data-code="<?php echo $row["MaNhaXuatBan"] ?>"
                   data-name="<?php echo $row["TenNhaXuatBan"]; ?>">
                   <span class="glyphicon glyphicon-pencil"></span>
                </a>
                <a class="delete"
                   href="#"
                   data-toggle="modal"
                   data-target="#mdlDelete"
                   data-code="<?php echo $row["MaNhaXuatBan"] ?>"
                   data-name="<?php echo $row["TenNhaXuatBan"]; ?>">
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
            <td colspan="3">
                <ul class="pagination">
                    <li class="<?php echo $currentPage == 1 ? "disabled" : "" ?>">
                        <a href="#" class="page-number"
                           data-segment="<?php echo $segment == 1 ? 1 : $segment - 1; ?>"
                           data-page="<?php echo $beginPage - 1; ?>"
                           data-url="publisher.php"
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
                           data-url="publisher.php"
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
                           data-url="publisher.php"
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
                <h4 class="modal-title" id="exampleModalLabel">Thêm nhà xuất bản mới</h4>
            </div>
            <div class="modal-body">
                <form id="frmInsert" name="publisher">
										<div id="divInsertResult">
											<span>&nbsp;</span>
										</div>
                    <div class="form-group">
                        <label for="txtInsertName" class="control-label">Tên nhà xuất bản</label>
                        <input type="text" class="form-control" id="txtInsertName" name="txtInsertName" />
                        <input type="hidden" id = "txtInsertCode" name="txtInsertCode" value="" />
                    </div>
                    <div class="modal-footer">
                        <button id="btnInsertSubmit" name="txtInsertSubmit" type="button" class="btn btn-success" data-url="publisher.php">Thêm</button>
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
                <h4 class="modal-title" id="exampleModalLabel">Cập nhật thông tin nhà xuất bản</h4>
            </div>
            <div class="modal-body">
                <form id="frmUpdate" name="publisher">
                    <div id="divUpdateResult">
											<span>&nbsp;</span>
										</div>
										<div class="form-group">
                        <label for="txtUpdateName" class="control-label">Tên nhà xuất bản</label>
                        <input type="text" class="form-control" id="txtUpdateName" />
                        <input type="hidden" id = "txtUpdateCode" name="txtUpdateCode" />
                    </div>
                    <div class="modal-footer">
                        <button id="btnUpdateSubmit" type="button" class="btn btn-info" data-url="publisher.php">Cập nhật</button>
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
                <h4 class="modal-title" id="exampleModalLabel">Xóa nhà xuất bản</h4>
            </div>
            <div class="modal-body">
                <form id="frmDelete" name="publisher">
                    <div class="form-group">
                        <label for="txtDeleteName" class="control-label">Tên nhà xuất bản</label>
                        <input type="text" class="form-control" id="txtDeleteName" />
                        <input type="hidden" id = "txtDeleteCode" name="txtDeleteCode" value="" />
                    </div>
                    <div>
                        Bạn thực sự muốn xóa ?
                    </div>
                    <div class="modal-footer">
                        <button id="btnDeleteSubmit" type="button" class="btn btn-warning" data-url="publisher.php">Xóa</button>
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
<div>Không tìm thấy dữ liệu nhà xuất bản</div>
<?php
    }
}
else {
    echo '<meta http-equiv="refresh" content="0;URL=./">';
}
?>