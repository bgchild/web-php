$(document).ready(function(){
	
	var initIndex=$("#currentTabIndex").val();
	$(".tab_item").children(".list-table:eq("+initIndex+")").removeClass("tab_none");
	$(".tab").children("ul").children("li:eq("+initIndex+")").addClass("tabact");
	
	$(".tab").children("ul").children("li").click(function(){
		var index=$(this).index();
		$(".tab").children("ul").children("li").each(function(){$(this).removeClass("tabact")});
		$(this).addClass("tabact");
		$(".tab_item").children(".list-table").each(function(){
			if($(this).index()==index) {
				$(this).removeClass("tab_none");
			}else {
				$(this).addClass("tab_none");
			}
		});
	});
	
	$(".list-table").children().children("tr").not(":first").hover(function(){
		$(this).children("td").each(function(){
				$(this).addClass("list-tr-hover");
		});
	},function(){
		$(this).children("td").each(function(){
			$(this).removeClass("list-tr-hover");
		});
	});
	
});

function getLength(s) {
	    var len = 0;
	    var a = s.split("");
	    for (var i=0;i<a.length;i++) {
	        if (a[i].charCodeAt(0)<299) {
		    len++;
		} else {
		    len+=2;
		}
	    }
	    return len;
	}