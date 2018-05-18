/*
$(document).ready(function(){
	$("#news_button").click(function(){
		var title = $("#news_title").val();
		var text = $("#news_text").val();

		$.ajax({
			url: "../scripts/add_news.php",
			method: "POST",
			data: {posttitle: title, posttext: text},
			success: function(data) {	
				$("#alert-success2").show(200);
				console.log(data);
			},
			error: function(){
				$("#alert-fail2").show(200);
			}
		});
	});
});*/