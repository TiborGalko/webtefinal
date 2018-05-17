$(document).ready(function(){
	$("#show_button").click(function(){
		$("#add_form").show(200);
		$("#show_button").hide();
	});
	$("#close_icon").click(function(){
		$("#add_form").hide(200);
		$("#show_button").show();
	});
	$("#add_button").click(function(){
		var from = $("#from").val();
		var to = $("#to").val();

		$("#add_form").hide(200);
		$("#show_button").show();

		$.ajax({
			url: "../scripts/add_trace.php",
			method: "POST",
			data: { postfrom: from, postto: to},
			success: function(data) {
				var ret = $.trim(data);				

				if(ret == 1){
					$("#alert-success").show(200);
				} else {
					$("#alert-fail").show(200);
				}

			},
			error: function(){
				$("#alert-fail").show(200);
			}
		});

		$.ajax({
			url: "../scripts/get_all_traces.php",
			method: "POST",
			success: function(data) {
				$("#traces_table").html(data);
			},
			error: function(){
			}
		});

	});
});