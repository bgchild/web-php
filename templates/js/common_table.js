 $(document).ready(function(){
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