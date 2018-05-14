$(document).ready(function(){
	$(".news-clickable").click(function(){
		var id = $(this).attr("id");
		$.redirect("news-detail.php", { postid: id});
	});
});