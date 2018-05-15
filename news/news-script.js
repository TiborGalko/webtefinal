$(document).ready(function(){
	$(".news-clickable").click(function(){
		var id = $(this).attr("id");
		$.redirect("../news/news-detail.php", { postid: id});
	});
	$("#news-back").click(function(){
		parent.history.back();
		return false;
	});
});