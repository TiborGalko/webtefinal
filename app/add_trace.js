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

				//console.log(data);
				$("#traces_body").append(data);
				$("#alert-success").show(200);

				$("#traces_table").find('tr').click( function(){
    				var from = $(this).find('td:eq(0)').text();
    				var to = $(this).find('td:eq(1)').text();

    				var res1 = from.split(",");
    				var res2 = to.split(",");

    				startLat = parseFloat(res1[0]);
       				startLng = parseFloat(res1[1]);
        			stopLat = parseFloat(res2[0]);
        			stopLng = parseFloat(res2[1]);
        			calculateAndDisplayRoute(directionsService, directionsDisplay);

    				$("td.td-active").html("Neaktivna");
    				$("td.td-active").attr('class', 'td-noactive');

    				$(this).find('td:eq(2)').html("Aktivna");
    				$(this).find('td:eq(2)').attr('class', 'td-active');	
    				$.ajax({
						url: "../scripts/change_active_trace.php",
						method: "POST",
						data: { postfrom: from, postto: to},
						success: function(data) {		
						},
						error: function(){
						}
					});
    			});				
			},
			error: function(){
				$("#alert-fail").show(200);
			}
		});

	});
	$("#traces_table").find('tr').click( function(){
    	var from = $(this).find('td:eq(0)').text();
    	var to = $(this).find('td:eq(1)').text();

    	if($(this).find('th:eq(2)').text() == "Aktívna/Neaktívna"){
    		return;
    	}

    	var res1 = from.split(",");
    	var res2 = to.split(",");

    	startLat = parseFloat(res1[0]);
        startLng = parseFloat(res1[1]);
        stopLat = parseFloat(res2[0]);
        stopLng = parseFloat(res2[1]);
        calculateAndDisplayRoute(directionsService, directionsDisplay);

    	$("td.td-active").html("Neaktivna");
    	$("td.td-active").attr('class', 'td-noactive');

    	$(this).find('td:eq(2)').html("Aktivna");
    	$(this).find('td:eq(2)').attr('class', 'td-active');	
    	$.ajax({
			url: "../scripts/change_active_trace.php",
			method: "POST",
			data: { postfrom: from, postto: to},
			success: function(data) {		
			},
			error: function(){
			}
		});
    });
    $("#filter_button").click(function(){
    	var text = $("#filter_text").val();

    	$.ajax({
			url: "../scripts/filter_trace.php",
			method: "POST",
			data: { posttext: text},
			success: function(data) {	
				$("#traces_table").html(data);	
			},
			error: function(){
			}
		});
    });
    $("#filter_cancel").click(function(){
    	$("#filter_text").val("");
    	$.ajax({
			url: "../scripts/cancel_filter_trace.php",
			method: "POST",
			success: function(data) {	
				$("#traces_table").html(data);	
			},
			error: function(){
			}
		});
    });
    $("#traces_table").tablesorter(); 
    $("#add_vykon").click(function(){
    	$("#show_vykon").show(200);
    	$("#add_vykon").hide();
    });
    $("#close_icon2").click(function(){
		$("#show_vykon").hide(200);
		$("#add_vykon").show();
	});
	$('#traces_table tr').each(function() {
    	if($(this).find("td:eq(2)").text() == "Aktivna"){
    		var from = $(this).find("td:eq(0)").text();
    		var to = $(this).find("td:eq(1)").text();
    		var res1 = from.split(",");
    		var res2 = to.split(",");

    		startLat = parseFloat(res1[0]);
        	startLng = parseFloat(res1[1]);
        	stopLat = parseFloat(res2[0]);
        	stopLng = parseFloat(res2[1]);
        	calculateAndDisplayRoute(directionsService, directionsDisplay);
    	}   
 	});
});