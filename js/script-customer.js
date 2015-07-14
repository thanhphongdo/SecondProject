function execCus(start, limit){
	var url = "ajax_customer.php";
	var param = {'limit':limit,'start':start};
	$.ajax({
        url: url,
        data: param,
        type: "POST",
        dataType: "HTML",
        error: function() {},
        beforeSend: function() {
        },
        complete: function() {
        },
        success: function(data) {
            if(data) {
                $('#resultCus').html(data);
            }
            else {
                alert('Khong tim thay du lieu');
            }
        }
    });
}

$(document).ready(function(){
    //if($("#tv").val() == "1"){
		execCus(0,10);
    //}
});

$(document).on("click",".btn-xs",function(){
	var url = "ajax_customer.php";
	var MaTV = $(this).parent().parent().children().eq(1).text();
	var Locked = $(this).val();
	if(Locked == '1') Locked = '0';
	else Locked = '1';
	var param = {"MaTV":MaTV,"Locked":Locked};
	$.ajax({
        url: url,
        data: param,
        type: "POST",
        dataType: "HTML",
        error: function() {},
        beforeSend: function() {
        },
        complete: function() {
        },
        success: function() {
            if(Locked == "1") alert("Đã khóa tài khoản");
            else alert("Đã kích hoạt tài khoản");
            execCus((parseInt(currentPage)-1)*10,10);
        }
    });
});
var currentPage = "1";
$(document).on("click",".pageCus",function(){
    execCus((parseInt($(this).text())-1)*10,10);
    currentPage = $(this).text();
});