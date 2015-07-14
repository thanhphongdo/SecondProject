$(document).ready(function() {
    //Hoang
    $("[type='number']").keypress(function (evt) {
        evt.preventDefault();
    });
    //Thay doi so luong
    $('.soluong').change(function(){
        var soluong=$(this).val();
        var masach=$(this).next().val();

        var dongia=$(this).parent().next().children(".dongia").text();
        var thanhtien=soluong*parseInt(dongia);
        $(this).parent().next().next().children(".thanhtien").text(thanhtien);
        var tongtien=0;
        $('.thanhtien').each(function() {
            var tt=$(this).text();
            tongtien += parseInt(tt);
        });
        $('#tongtien').text(tongtien);
        //
        var dontrong=$(this).parent().next().children(".dontrong").val();
        var trongluongnew=soluong*parseInt(dontrong);
        $(this).parent().next().next().children(".trongluong").val(trongluongnew);
        //
        var tongtrong=0;
        $('.trongluong').each(function() {
            var tt=$(this).val();
            tongtrong += parseInt(tt);
        });
        $('#tongtrong').val(tongtrong);
        
        var url="giohang-exe.php";
        var param = {"masach-them":masach,"sl":soluong};
        $.ajax({
            url: url,
            data: param,
            type: "POST",
            dataType: "HTML",
            error: function(){},
            beforeSend: function(){
            },
            complete: function(){
            },
            success: function(data){
            }
        });
    });
    //Xoa san pham
    $('.xoa-hang').click(function(){
        var masach=$(this).next().val();
        var url="giohang-exe.php";
        var param = {"masach-xoa":masach};
        $.ajax({
            url: url,
            data: param,
            type: "POST",
            dataType: "HTML",
            error: function(){},
            beforeSend: function(){
            },
            complete: function(){
            },
            success: function(data){
                window.setTimeout('location.reload()');
            }
        });
    });
    //Luu CSDL gio hang
    $('#dat-sach').click(function(){
        var luu=1;
        var tongtien=$("#tongtien").text();
        var tongtrong=$("#tongtrong").val();
        var url="giohang-exe.php";
        var param = {"luu-csdl":luu,"tongtien":tongtien,"tongtrong":tongtrong};
        $.ajax({
            url: url,
            data: param,
            type: "POST",
            dataType: "HTML",
            error: function(){},
            beforeSend: function(){
            },
            complete: function(){
            },
            success: function(data){
                window.setTimeout('location.reload()',0);
            }
        });
    });
    //Gui gop y
    $('#gui-gopy').click(function(){
        var taikhoan=$("#taikhoan-gopy").text();
        var tieude=$("#tieude-gopy").val();
        var noidung=$("#noidung-gopy").val();
        var url="lienhe-xuly.php";
        var param = {"taikhoan":taikhoan,"tieude":tieude,"noidung":noidung};
        $.ajax({
            url: url,
            data: param,
            type: "POST",
            dataType: "HTML",
            error: function(){},
            beforeSend: function(){
            },
            complete: function(){
            },
            success: function(data){
                window.setTimeout('location.reload()',0);
            }
        });
    });
});
/*Phong*/
$(document).ready(function(){
    $("#DangNhap").click(function(){
        $("#DN-Box").modal('show');
        document.getElementById("txtUserName").focus();
    });
});

$(document).ready(function(){
    if($("#fail").val() == "true"){
        $("#DX-Box").modal('show');
    }
});

$(document).ready(function(){
    $("#btnDangNhap").click(function(){
        var username = $("#txtUserName").val();
        var pass = $("#txtPass").val();
        var remember = $("#chkRemember").prop("checked");
        var url="index.php";
        var param = {'username':username,'pass':pass, 'remember':remember};
        $.ajax({
            url: url,
            data: param,
            type: "POST",
            dataType: "HTML",
            error: function(){},
            beforeSend: function(){
            },
            complete: function(){
            },
            success: function(data){
                location.reload();
            }
        });
    });
});


/*end Phong*/