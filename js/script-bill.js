var MaHD = [];
var Ma = "";
var KH = "";
var step1 = 0;
var step2 = 0;
var searched = 0;
var currentPage = "1";

function exec(start, limit){
	var url = "ajax_bill.php";
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
                $('#result').html(data);
            }
            else {
                alert('Khong tim thay du lieu');
            }
        }
    });
}

function execSearch(key,start, limit){
	var url = "ajax_bill.php";
	var param = {'key':key,'limit':limit,'start':start};
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
                $('#result').html(data);
            }
            else {
                alert('Khong tim thay du lieu');
            }
        }
    });
}

function execSearchUpgade(start, limit){
	searched = 1;
	var dk = [];
	dk[0] = $("#txtTuNgayDH").val();
	dk[1] = $("#txtDenNgayDH").val();
	dk[2] = $("#txtTuNgayGH").val();
	dk[3] = $("#txtDenNgayGH").val();
	dk[4] = $('input[name="hd"]:checked').val();
	if(typeof(dk[4]) == "undefined") dk[4] = "";
	//$("#test").text(dk[0] + " " + dk[1] + " " + dk[2] + " " + dk[3] + " " + dk[4]);
	var url = "ajax_bill.php";
	var param = {'dk':dk,'start':start,'limit':limit};
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
                $('#result').html(data);
            }
            else {
                alert('Khong tim thay hoa don');
            }
        }
    });
}

$(document).ready(function(){
	exec(0,10);
});

$(document).on("click",".page",function(){
	if(searched == 0){
		if($("#txtSearch").val() == ""){
			exec((parseInt($(this).text())-1)*10,10);
			currentPage = $(this).text();
			$("#text").text(currentPage);
		}
		else{
			execSearch($("#txtSearch").val(),(parseInt($(this).text())-1)*10,10);
			currentPage = $(this).text();
			$("#text").text(currentPage);
		}
	}
	else{
		execSearchUpgade((parseInt($(this).text())-1)*10,10);
	}
	step1 = 0;
	step2 = 0;
});
$(document).on("click","#next",function(){
	$(".page").each(function(){
		if($("#next").parent().prop("class")!="disabled"){
	        $(this).text(parseInt($(this).text())+5);
	        if(parseInt($(this).text()) > Math.ceil(parseInt($("#num").val())/10))
	        {
	        	$(this).hide();
	        }
	    }
    });
    $(".page").each(function(){
	    if(parseInt($(this).text()) >= Math.ceil(parseInt($("#num").val())/10))
	    	$("#next").parent().addClass("disabled");
	    else $("#prev").parent().removeClass();
	    if($(this).text() == currentPage) $(this).parent().addClass("active");
	    else $(this).parent().removeClass();
	    if($(this).parent().prop("class") == "active") currentPage = $(this).text();
    });
});
$(document).on("click","#prev",function(){
	if($("#prev").parent().prop("class")!="disabled"){
		$(".page").each(function(){
	        $(this).text(parseInt($(this).text())-5);
		    if(parseInt($(this).text()) < 6){
		    	$("#prev").parent().addClass("disabled");
		    }
	        $(this).show();
	        $("#next").parent().removeClass();
	        if($(this).text() == currentPage) $(this).parent().addClass("active");
	        else $(this).parent().removeClass();
	    	if($(this).parent().prop("class") == "active") currentPage = $(this).text();
	    });
	}
});
$(document).on("click",".select",function(){
	if($(this).css("background-color") != "rgb(255, 255, 0)"){
		$(this).css("background-color","yellow");
		Ma = $(this).children().eq(1).text();
		KH = $(this).children().eq(2).text();
	}
	else {
		$(this).css("background-color","");
		Ma = "";
		KH = "";
	}
});
$(document).on("click",".select",function(e){
	if(e.ctrlKey){
		if(step1 == 0) step1 = $(this).children().eq(0).text();
		else if(step2 == 0) step2 = $(this).children().eq(0).text();
		if(step2 != 0){
			if(parseInt(step2) < parseInt(step1)){
				var temp = step1;
				step1 = step2;
				step2 = temp;
			}
			$(".select").each(function(){
				if(parseInt($(this).children().eq(0).text()) > parseInt(step1) && parseInt($(this).children().eq(0).text()) < parseInt(step2))
					$(this).css("background-color","yellow");
			});
			step1 = 0;
			step2 = 0;
		}
	}
});

$(document).ready(function(){
	$("#btnXoa").click(function(){
		MaHD = [];
		$(".select").each(function(){
			if($(this).css("background-color") == "rgb(255, 255, 0)"){
				MaHD[MaHD.length] = $(this).children().eq(1).text();
			}
		});
		var url = "delete-bill.php";
		var param = {"MaDonHang":MaHD};
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
	            alert("Đã xóa!");
	            location.reload();
	        }
	    });
	});
});

//Tim hoa don Search_Or()

$(document).ready(function(){
	$("#txtSearch").keyup(function(){
		if($(this).val() != "")
			execSearch($(this).val(),0,10);
		else exec((currentPage-1)*10,10);
		searched = 0;
	});
});

$(document).ready(function(){
	$("#btnSearch2").click(function(){
		if($(this).val() != "")
			execSearch($(this).val(),0,10);
		else exec((currentPage-1)*10,10);
		searched = 0;
	});
});

//Tim kiem nang cao

$(document).ready(function(){
	$("#btnSearchUpgade").click(function(){
		execSearchUpgade(0,10);
	});
});

//Xem hoa don chi tiet

$(document).ready(function(){
	$("#view").click(function(){
		var url = "ajax_bill.php";
		var param = {"MaDonHang":Ma,"KhachHang":KH};
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
	                $('#view-result').html(data);
	            }
	            else {
	                alert('Khong tim thay du lieu');
	            }
	        }
	    });
	});
});

$(document).ready(function(){
	$("#btnGiaoHang").click(function(){
		var url = "ajax_bill.php";
		var GH = 'true';
		var param = {"MaDonHang":Ma,"GiaoHang":GH};
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
	        	if($("#txtSearch").val() == ""){
					exec((parseInt(currentPage)-1)*10,10);
				}
				else{
					execSearch($("#txtSearch").val(),(parseInt(currentPage)-1)*10,10);
				}
	        }
	    });

	});
});

$(document).ready(function(){
	$(".danhmuc").click(function(){
		$("#hoadon").hide();
	});
	$("#menu-hoadon").click(function(){
		$("#hoadon").show();
	});
});