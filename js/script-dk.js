var success = false;
var fail = [];

function testUser(){
    var user = $("#txtDKUser").val();
    if(user.length == 0){
        $('#txtDKUser').next().remove();
        $('#txtDKUser').after('<div><span class="glyphicon glyphicon-remove form-control-feedback"></span><div class="alert alert-danger alert2">'
        +'User không được để trống! '+'</div></div>');
        $('#txtDKUser').parent().parent().removeClass().addClass("form-group has-error has-feedback");
        message = "User không được để trống!";
        success = false;
        fail[fail.length]='txtDKUser';
        return;
    }
    var url="testuser.php";
    var param = {'user':user};
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
            if (data){
                $('#txtDKUser').next().remove();
                $('#txtDKUser').after('<div><span class="glyphicon glyphicon-remove form-control-feedback"></span><div class="alert alert-danger alert2">'
                +'Tài khoản này đã tồn tại! '+'</div></div>');
                $('#txtDKUser').parent().parent().removeClass().addClass("form-group has-error has-feedback");
                success = false;
                fail[fail.length]='txtDKUser';
            }
            else{
                $('#txtDKUser').next().remove();
                $('#txtDKUser').after('<div><span class="glyphicon glyphicon-ok form-control-feedback"></span></div>');
                $('#txtDKUser').parent().parent().removeClass().addClass("form-group has-success has-feedback");
                success = true;
            }
        }
    });
}
function testOther(tagID){
    $('#'+tagID).next().remove();
    var val = $('#'+tagID).val();
    if(tagID == 'txtDKXNMatKhau'){
        if(val != $('#txtDKMatKhau').val()){
            $('#'+tagID).after('<div><span class="glyphicon glyphicon-remove form-control-feedback"></span>');
            $('#'+tagID).parent().parent().removeClass().addClass("form-group has-error has-feedback");
            success = fail;
        }
        else{
            $('#'+tagID).after('<div><span class="glyphicon glyphicon-ok form-control-feedback"></span></div>');
            $('#'+tagID).parent().parent().removeClass().addClass("form-group has-success has-feedback");
        }
        return;
    }
    if(val.length == 0){
        $('#'+tagID).after('<div><span class="glyphicon glyphicon-remove form-control-feedback"></span><div class="alert alert-danger alert2">'
            +$('#'+tagID).data('info')+'</div></div>');
        $('#'+tagID).parent().parent().removeClass().addClass("form-group has-error has-feedback");
    }
    else{
        $('#'+tagID).after('<div><span class="glyphicon glyphicon-ok form-control-feedback"></span></div>');
        $('#'+tagID).parent().parent().removeClass().addClass("form-group has-success has-feedback");
    }
}

$(document).ready(function(){
    $("[id^=txtDK]").blur(function(){
        if($(this).prop('id') != 'txtDKUser')
        testOther($(this).prop('id'));
    });
    $("[id^=txtDK]").keyup(function(){
        if($(this).prop('id') != 'txtDKUser' || $(this).prop('id') != 'txtDKXNMatKhau')
        testOther($(this).prop('id'));
    });
    $("#btnReset").click(function(){
        $("[id^=txtDK]").next().remove();
        $("[id^=txtDK]").parent().parent().removeClass().addClass("form-group has-success has-feedback");
    });
    $("#txtDKUser").blur(function(){
        testUser();
    });
});
function testSubmit(){
    var success = true;
    if($('#txtDKUser').val().length == 0) {
        success = false;
        fail[fail.length]='txtDKUser';
    }
    if($('#txtDKHoTen').val().length == 0) {
        success = false;
        fail[fail.length]='txtDKHoTen';
    }
    if($('#txtDKNgaySinh').val().length == 0) {
        success = false;
        fail[fail.length]='txtDKNgaySinh';
    }
    if($('#slGioiTinh').val().length == 0) {
        success = false;
        fail[fail.length]='slGioiTinh';
    }
    if($('#txtDKDiaChi').val().length == 0) {
        success = false;
        fail[fail.length]='txtDKDiaChi';
    }
    if($('#txtDKMatKhau').val().length == 0) {
        success = false;
    }
    if($('#txtDKXNMatKhau').val() != $('#txtDKMatKhau').val()) {
        success = false;
    }
    if($('#txtDKDienThoai').val().length == 0) {
        success = false;
        fail[fail.length]='txtDKDienThoai';
    }
    if($('#txtDKEmail').val().length == 0) {
        success = false;
        fail[fail.length]='txtDKEmail';
    }
    if(!$('#chkDongY').prop('checked')){
        success = false;
    }
    if(success == false) {
        $("#error").modal('show');
        return success;
    }
    return true;
}

$(document).ready(function(){
    $("#btnSignUp").click(function(){
        for(var i = 0;i<fail.length;i++){
            $("#"+fail[i]).val("");
            testOther(fail[i]);
        }
        fail = [];
        $('#txtDKMatKhau').val("");
        $('#txtDKXNMatKhau').val("");
        $('#txtDKMatKhau').next().remove();
        $('#txtDKMatKhau').parent().parent().removeClass().addClass("form-group has-success has-feedback");
        $('#txtDKXNMatKhau').next().remove();
        $('#txtDKXNMatKhau').parent().parent().removeClass().addClass("form-group has-success has-feedback");
    });
});

$(document).ready(function(){
    if($("#sign").val()=="true"){
        $("#success").modal('show');
        $("#sign").remove();
    }
});
$(document).ready(function(){
    $("#btnDong").click(function(){  
        window.location.href = "index.php";
    });
});