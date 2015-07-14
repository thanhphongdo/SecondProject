$(document).ready(function() {
    $('.masterTooltip').hover(function() {
        var title = $(this).attr('title');
        $(this).data('tipText', title).removeAttr('title');
        $('<div class="showTooltip"></div>')
                .text(title)
                .appendTo('body')
                .fadeIn('slow');
    }, function() {
        $(this).attr('title', $(this).data('tipText'));
        $('.showTooltip').remove();
    }).mousemove(function(e) {
        var mousex = e.pageX + 20; 
        var mousey = e.pageY + 10; 
        $('.showTooltip')
                .css({top: mousey, left: mousex})
    });
    
    function loadPage(segment, page, url, search) {
        $.ajax({
            url: url,
            data: {
                page: page,
                segment: segment,
								search: search
            },
            type: "POST",
            dataType: "HTML",
            error: function() {},
            beforeSend: function() {
                $('#page-content').html("<div id='loading' class='text-center'> " +
                                   "    <img src='../images/loading.gif' /> " +
                                   "    <span class='text-info'>ĐANG TẢI DỮ LIỆU, VUI LÒNG CHỜ XÍU</span> " +
                                   "    </div>");
            },
            complete: function() {
                $('#loading').remove();
            },
            success: function(data) {
                if(data) {
                    
                    $('#page-content').html(data);
                }
                else {
                    alert('Khong tim thay du lieu');
                }
            }
        });
    }
    
    $('#publisher, #author, #category, #book').click(function(e) {
        e.preventDefault();
        loadPage(1, 1, $(this).prop("href"), "");
    });
    
        $("#changePassword").click(function(e) {
             e.preventDefault();
                $.ajax({
            url: $(this).prop("href"),
            data: {},
            type: "POST",
            dataType: "HTML",
            error: function() {},
            beforeSend: function() {
                $('#page-content').html("<div id='loading' class='text-center'> " +
                                   "    <img src='../images/loading.gif' /> " +
                                   "    <span class='text-info'>CHỜ XÍU</span> " +
                                   "    </div>");
            },
            complete: function() {
                $('#loading').remove();
            },
            success: function(data) {
                                $('#page-content').html(data);
            }
        });
        });
        
        $(document).on("click", "#btnSubmitChangePassword", function(e) {
            e.preventDefault();
            if(readyChangePassword()) {
                $.ajax({
            url: "changepassword.php",
            data: {
                            oldPassword: $("#txtOldPassword").val(),
                            newPassword: $("#txtNewPassword").val()
                        },
            type: "POST",
            dataType: "HTML",
            error: function() {},
            beforeSend: function() {
                $('#page-content').html("<div id='loading' class='text-center'> " +
                                   "    <img src='../images/loading.gif' /> " +
                                   "    <span class='text-info'>CHỜ XÍU</span> " +
                                   "    </div>");
            },
            complete: function() {
                $('#loading').remove();
            },
            success: function(data) {
                                $('#page-content').html(data);
            }
        });
            }
        });
        
    $(document).on('click', '.page-number', function(e) {
        e.preventDefault();
        if(!$(this).parent().hasClass("disabled")) {
            loadPage($(this).data("segment"), $(this).data("page"), $(this).data("url"), $(this).data("search"));
        }    
    });
    
		 $(document).on('click', '#btnSearch', function(e) {
		
        e.preventDefault();
            loadPage(1, 1, $(this).data("url"), $("#txtSearch").val());  
    });
		
        var aTag = null;
        
    $(document).on('click', '.edit', function() {
                aTag = $(this);
                
        $(document).on('shown.bs.modal', function (event) {
            $("#txtUpdateCode").val(aTag.data("code"));
            $("#txtUpdateName").val(aTag.data("name"));
            if($("#frmUpdate").prop("name") == "category") {
                $("#cbxUpdateParent").children().removeAttr("selected");
                $("#cbxUpdateParent").children().filter("."+aTag.data("parent")).prop("selected", true);
            }
            else
            if($("#frmUpdate").prop("name") == "book") {

                $("#cbxUpdateCategory").children().removeAttr("selected");
                $("#cbxUpdateCategory").children().filter("."+aTag.data("category")).prop("selected", true);
                $("#cbxUpdateAuthor").children().removeAttr("selected");
                $("#cbxUpdateAuthor").children().filter("."+aTag.data("author")).prop("selected", true);
                $("#cbxUpdatePublisher").children().removeAttr("selected");
                $("#cbxUpdatePublisher").children().filter("."+aTag.data("publisher")).prop("selected", true);
                $("#txtUpdateDate").val(aTag.data("date"));
                $("#txtUpdateHeight").val(aTag.data("size").substr(0, aTag.data("size").indexOf("x") - 1));
                $("#txtUpdateWidth").val(aTag.data("size").substr(aTag.data("size").indexOf("x") + 2));
                $("#txtUpdateWeight").val(aTag.data("weight"));
                $("#txtUpdatePrice").val(aTag.data("price"));
                $("#txtUpdateQuantity").val(aTag.data("quantity"));
                $("#txtUpdateSumary").val(aTag.data("sumary"));
            }
        });
    });
    
    $(document).on('click', '.delete', function() {
        aTag = $(this);
        $(document).on('shown.bs.modal', function (event) {
                
            $("#txtDeleteCode").val(aTag.data("code"));
            $("#txtDeleteName").val(aTag.data("name"));
            $("#txtDeleteCode").prop("disabled", true);
            $("#txtDeleteName").prop("disabled", true);
            if($("#frmDelete").prop("name") == "category") {
                $("#cbxDeleteParent").children().removeAttr("selected");
                $("#cbxDeleteParent").children().filter("."+aTag.data("parent")).prop("selected", true);
                $("#cbxDeleteParent").prop("disabled", true);
            }
            else
            if($("#frmDelete").prop("name") == "book") {
                                $("#txtDeleteImage").val(aTag.data("image"));
                                $("#txtDeleteImage").prop("disabled", true); 
                $("#cbxDeleteCategory").children().removeAttr("selected");
                $("#cbxDeleteCategory").children().filter("."+aTag.data("category")).prop("selected", true);
                $("#cbxDeleteAuthor").children().removeAttr("selected");
                $("#cbxDeleteAuthor").children().filter("."+aTag.data("author")).prop("selected", true);
                $("#cbxDeletePublisher").children().removeAttr("selected");
                $("#cbxDeletePublisher").children().filter("."+aTag.data("publisher")).prop("selected", true);
                $("#txtDeleteDate").val(aTag.data("date"));
                $("#txtDeleteHeight").val(aTag.data("size").substr(0, aTag.data("size").indexOf("x") - 1));
                $("#txtDeleteWidth").val(aTag.data("size").substr(aTag.data("size").indexOf("x") + 2));
                $("#txtDeleteWeight").val(aTag.data("weight"));
                $("#txtDeletePrice").val(aTag.data("price"));
                $("#txtDeleteQuantity").val(aTag.data("quantity"));
                $("#txtDeleteSumary").val(aTag.data("sumary"));
                $("#cbxDeleteCategory").prop("disabled", true);
                $("#cbxDeleteAuthor").prop("disabled", true);
                $("#cbxDeletePublisher").prop("disabled", true);
                $("#txtDeleteDate").prop("disabled", true);
                $("#txtDeleteHeight").prop("disabled", true);
                $("#txtDeleteWidth").prop("disabled", true);
                $("#txtDeleteWeight").prop("disabled", true);
                $("#txtDeletePrice").prop("disabled", true);
                $("#txtDeleteQuantity").prop("disabled", true);
                $("#txtDeleteSumary").prop("disabled", true);
            }    
        });
    });
    var data;
    function getInsertData(formName) {
        data;  
        if (formName == "publisher" || formName == "author") {
            data = {
                'insert': true,
                'code': $('#txtInsertCode').val(),
                'name': $('#txtInsertName').val(),
								'search': ""
            };
        }
        else
        if(formName == "category") {
            data = {
                'insert': true,
                'code': $("#txtInsertCode").val(),
                'name': $("#txtInsertName").val(),
                'parent': $("#cbxInsertParent > option:selected(true)").val(),
								'search': ""
            };
        }
        else
        if(formName == "book") {
            data = {
                'insert': true,
                'code': $("#txtInsertCode").val(),
                'name': $("#txtInsertName").val(),
                'category': $("#cbxInsertCategory > option:selected(true)").val(),
                'author': $("#cbxInsertAuthor > option:selected(true)").val(),
                'publisher': $("#cbxInsertPublisher > option:selected(true)").val(),
                'date': $("#txtInsertDate").val(),
                'size': $("#txtInsertHeight").val() + " x " + $("#txtInsertWidth").val(),
                'weight': $("#txtInsertWeight").val(),
                'price': $("#txtInsertPrice").val(),
                'quantity': $("#txtInsertQuantity").val(),
                'sumary': $("#txtInsertSumary").val(),
								'search': ""
            };
            
        }
        return data;
    }
    
    function getUpdateData(formName) {
        data;  
        if (formName == "publisher" || formName == "author") {
            data = {
                'update': true,
                'code': $('#txtUpdateCode').val(),
                'name': $('#txtUpdateName').val(),
								'search': ""
            };
        }
        else
        if(formName == "category") {
            data = {
                'update': true,
                'code': $("#txtUpdateCode").val(),
                'name': $("#txtUpdateName").val(),
                'parent': $("#cbxUpdateParent > option:selected(true)").val(),
								'search': ""
            };
        }
        else
        if(formName == "book") {
            data = {
                'update': true,
                'code': $("#txtUpdateCode").val(),
                'name': $("#txtUpdateName").val(),
                'category': $("#cbxUpdateCategory > option:selected(true)").val(),
                'author': $("#cbxUpdateAuthor > option:selected(true)").val(),
                'publisher': $("#cbxUpdatePublisher > option:selected(true)").val(),
                'date': $("#txtUpdateDate").val(),
                'size': $("#txtUpdateHeight").val() + " x " + $("#txtUpdateWidth").val(),
                'weight': $("#txtUpdateWeight").val(),
                'price': $("#txtUpdatePrice").val(),
                'quantity': $("#txtUpdateQuantity").val(),
                'sumary': $("#txtUpdateSumary").val(),
								'search': ""
            };
        }
        return data;
    }
    
    function getDeleteData(formName) {       
        if(formName != "book") {
                    data = {
                                    'delete': true,
                                    'code': $('#txtDeleteCode').val(),
																		'search': ""
            };
                }
                else {
                    data = {
                'delete': true,
                'code': $('#txtDeleteCode').val(),
                "currentPath": $("#txtDeleteImage").val(),
								'search': ""
                        };
                }
        return data;
    }
    
    var btn;
    $(document).on('click', '#btnInsertSubmit', function(e) {
            if(ready("Insert") == true) {
        btn = $(this);
        $('#mdlInsert').modal('hide'); 
        $(document).on('hidden.bs.modal', function(e) {
            if($(btn).prop("id") == "btnInsertSubmit") {
                                $.ajax({
                    url: $("#btnInsertSubmit").data("url"),
                    data: getInsertData($('#frmInsert').prop("name")),
                    type: "POST",
                    dataType: "HTML",
                    error: function() {},
                    beforeSend: function() {
                        $('#page-content').html("<div id='loading' class='text-center'> " +
                                           "    <img src='../images/loading.gif' /> " +
                                           "    <span class='text-info'>ĐANG TẢI DỮ LIỆU, VUI LÒNG CHỜ XÍU</span> " +
                                           "</div>");

                    }, 
                    complete: function() {
                        $('#loading').remove();
                    },
                    success: function(data) {
                        $('#page-content').html(data);
                    }
                });
                btn = null;
            }
        });
            }
  });
   
    $(document).on('click', '#btnUpdateSubmit', function(e) {
                if(ready("Update") == true) {
                    btn = $(this);
                    $('#mdlUpdate').modal('hide'); 
                    $(document).on('hidden.bs.modal', function(e) {
                            if($(btn).prop("id") == "btnUpdateSubmit") {
                                $.ajax({
                                        url: $("#btnUpdateSubmit").data("url"),
                                        data: getUpdateData($('#frmUpdate').prop("name")),
                                        type: "POST",
                                        dataType: "HTML",
                                        error: function() {},
                                        beforeSend: function() {
                                            $('#page-content').html("<div id='loading' class='text-center'> " +
                                                                                                            "    <img src='../images/loading.gif' /> " +
                                                                                                            "    <span class='text-info'>ĐANG TẢI DỮ LIỆU, VUI LÒNG CHỜ XÍU</span> " +
                                                                                                            "</div>");
                                        }, 
                                        complete: function() {
                                            $('#loading').remove();
                                        },
                                        success: function(data) {
                       $('#page-content').html(data);
                                        }
                });
                btn = null;
                            }
                    });
                }
    });
    
    $(document).on('click', '#btnDeleteSubmit', function(e) {
        btn = $(this);
        $('#mdlDelete').modal('hide'); 
        $(document).on('hidden.bs.modal', function(e) {
            if($(btn).prop("id") == "btnDeleteSubmit") {
                $.ajax({
                    url: $("#btnDeleteSubmit").data("url"),
                    data: getDeleteData($('#frmDelete').prop("name")),
                    type: "POST",
                    dataType: "HTML",
                    error: function() {},
                    beforeSend: function() {
                        $('#page-content').html("<div id='loading' class='text-center'> " +
                                           "    <img src='../images/loading.gif' /> " +
                                           "    <span class='text-info'>ĐANG TẢI DỮ LIỆU, VUI LÒNG CHỜ XÍU</span> " +
                                           "    </div>");

                    }, 
                    complete: function() {
                        $('#loading').remove();
                    },
                    success: function(data) {
                        $('#page-content').html(data);
                    }
                });
                btn = null;
            }
        });
    });
        
        var imgTag;
        $(document).on('click', '.editImage', function() {
        imgTag = $(this);
                if($(mgTag).prop("className") == "editImage") {
                    $(document).on('shown.bs.modal', function (event) {
                            $("#txtUpdateImageCode").val(imgTag.attr("data-code"));
                            $("#txtUpdateImagePath").val(imgTag.attr("data-path"));
                    });
                }
    });
        
         $(document).on('click', '#btnUpdateImageSubmit', function(e) {
        btn = $(this);
        $('#mdlUpdateImage').modal('hide'); 
        $(document).on('hidden.bs.modal', function(e) {
            if($(btn).prop("id") == "btnUpdateImageSubmit") {
                            fileChooser = document.getElementById("fcrUpdateImagePath");
                            objImage = fileChooser.files[0];
                            data = new FormData();
                            data.append("objImage", objImage);              
                            data.append("code", $(imgTag).data("code"));
                            data.append("currentPath", $(imgTag).data("path"));
                            tmpImgTag = $(imgTag);
               $.ajax({
                   url: "uploadimage.php",
                   data: data,
                   type: "POST",
                   enctype: 'multipart/form-data',
                                    processData: false,
                                    contentType: false, 
                    error: function() {},
                    beforeSend: function() {}, 
                    complete: function() {},
                    success: function(data) {
                                
                            $(tmpImgTag).attr("src", "../" + data);
                            $(tmpImgTag).attr("data-path", data);
                            $("#fcrUpdateImagePath").val("");
                    }
                });
                imgTag = null;
                btn = null; 
            }
        });
        });
});

function ready(formType) {
    if($("#txt" + formType + "Name").val() != "") {
        $("#div" + formType + "Result").children().removeClass("glyphicon glyphicon-alert text-danger");
        $("#div" + formType + "Result").children().text("");
        if($("#frm" + formType + "").prop("name") == "book") {
            if($("#cbx" + formType + "Category > option:selected(true)").val() != "") {
                if($("#cbx" + formType + "Author > option:selected(true)").val() != "") {
                    if($("#cbx" + formType + "Publisher > option:selected(true)").val() != "") {
                        if($("#txt" + formType + "Height").val() != "") {
                            if(!isNaN($("#txt" + formType + "Height").val())) {
                                if($("#txt" + formType + "Width").val() != "") {
                                    if(!isNaN($("#txt" + formType + "Width").val())) {
                                        if($("#txt" + formType + "Weight").val() != "") {
                                            if(!isNaN($("#txt" + formType + "Weight").val())) {
                                                if($("#txt" + formType + "Date").val() != "") {
                                                    if($("#txt" + formType + "Price").val() != "") {
                                                        if(!isNaN($("#txt" + formType + "Price").val())) {
                                                            if($("#txt" + formType + "Quantity").val() != "") {
                                                                if(!isNaN($("#txt" + formType + "Quantity").val())) {
                                                                    if(Math.round(Number($("#txt" + formType + "Quantity").val())) - parseInt($("#txt" + formType + "Quantity").val()) == 0) {
                                                                        $("#div" + formType + "Result").children().removeClass("glyphicon glyphicon-alert text-danger");
                                                                        $("#div" + formType + "Result").children().text("");
                                                                        return true;
                                                                    }
                                                                    else {
                                                                        $("#div" + formType + "Result").children().addClass("glyphicon glyphicon-alert text-danger");
                                                                        $("#div" + formType + "Result").children().text(" Số lượng phải là số nguyên 2.");
                                                                        return false;
                                                                    }
                                                                }
                                                                else {
                                                                    $("#div" + formType + "Result").children().addClass("glyphicon glyphicon-alert text-danger");
                                                                    $("#div" + formType + "Result").children().text(" Số lượng phải là số nguyên 1.");
                                                                    return false;
                                                                }
                                                            }
                                                            else {
                                                                $("#div" + formType + "Result").children().addClass("glyphicon glyphicon-alert text-danger");
                                                                $("#div" + formType + "Result").children().text(" Số lượng không được rỗng.");
                                                                return false;
                                                            }
                                                        }
                                                        else {
                                                            $("#div" + formType + "Result").children().addClass("glyphicon glyphicon-alert text-danger");
                                                            $("#div" + formType + "Result").children().text(" Giá bìa phải là giá trị số.");
                                                            return false;
                                                        }
                                                    }
                                                    else {
                                                        $("#div" + formType + "Result").children().addClass("glyphicon glyphicon-alert text-danger");
                                                        $("#div" + formType + "Result").children().text(" Giá bìa không được rỗng.");
                                                        return false;
                                                    }
                                                }
                                                else {
                                                    $("#div" + formType + "Result").children().addClass("glyphicon glyphicon-alert text-danger");
                                                    $("#div" + formType + "Result").children().text("Ngày xuất bản không được rỗng.");
                                                    return false;
                                                }
                                            }
                                            else {
                                                $("#div" + formType + "Result").children().addClass("glyphicon glyphicon-alert text-danger");
                                                $("#div" + formType + "Result").children().text(" Trọng lượng phải là giá trị số.");
                                                return false;
                                            }
                                        }
                                        else {
                                            $("#div" + formType + "Result").children().addClass("glyphicon glyphicon-alert text-danger");
                                            $("#div" + formType + "Result").children().text(" Trọng lượng sách không được rỗng.");
                                            return false;
                                        }
                                    }
                                    else {
                                        $("#div" + formType + "Result").children().addClass("glyphicon glyphicon-alert text-danger");
                                        $("#div" + formType + "Result").children().text(" Chiều rộng sách phải là giá trị số.");
                                        return false;
                                    }
                                }
                                else {
                                    $("#div" + formType + "Result").children().addClass("glyphicon glyphicon-alert text-danger");
                                    $("#div" + formType + "Result").children().text(" Chiều rộng sách không được rỗng rỗng.");
                                    return false;
                                }
                            }
                            else {
                                $("#div" + formType + "Result").children().addClass("glyphicon glyphicon-alert text-danger");
                                $("#div" + formType + "Result").children().text(" Chiều dài sách phải là giá trị số.");
                                return false;
                            }
                        }
                        else {
                            $("#div" + formType + "Result").children().addClass("glyphicon glyphicon-alert text-danger");
                            $("#div" + formType + "Result").children().text(" Chiều dài sách không được rỗng.");
                            return false;
                        }
                    }
                    else {
                        $("#div" + formType + "Result").children().addClass("glyphicon glyphicon-alert text-danger");
                        $("#div" + formType + "Result").children().text(" Chưa chọn nhà xuất bản.");
                        return false;
                    }
                }
                else {
                    $("#div" + formType + "Result").children().addClass("glyphicon glyphicon-alert text-danger");
                    $("#div" + formType + "Result").children().text(" Chưa chọn tác giả.");
                    return false;
                }
            }
            else {
                $("#div" + formType + "Result").children().addClass("glyphicon glyphicon-alert text-danger");
                $("#div" + formType + "Result").children().text(" Chưa chọn thể loại.");
                return false;
            }
        }
        else {
            return true;
        }
    }
    else {
        $("#div" + formType + "Result").children().addClass("glyphicon glyphicon-alert text-danger");
        $("#div" + formType + "Result").children().text(" Tên không được rỗng.");
        return false;
    }
}

function readyChangePassword() {
    if($("#txtOldPassword").val() != "") {
        if($("#txtNewPassword").val() != "") {
            if($("#txtNewPassword").val() == $("#txtReNewPassword").val()) {
                $("#divChangePasswordResult").children().removeClass("glyphicon glyphicon-alert text-danger");
                $("#divChangePasswordResult").children().text(" &nbsp;");
                return true;
            }
            else {
                $("#divChangePasswordResult").children().addClass("glyphicon glyphicon-alert text-danger");
                $("#divChangePasswordResult").children().text(" Xác nhận mật khẩu chưa chính xác.");
                return false;
            }
        }
        else {
            $("#divChangePasswordResult").children().addClass("glyphicon glyphicon-alert text-danger");
            $("#divChangePasswordResult").children().text(" Chưa nhập mật khẩu mới.");
            return false;
        }
    }
    else {
        $("#divChangePasswordResult").children().addClass("glyphicon glyphicon-alert text-danger");
        $("#divChangePasswordResult").children().text(" Chưa nhập mật khẩu cũ.");
        return false;
    }
}
