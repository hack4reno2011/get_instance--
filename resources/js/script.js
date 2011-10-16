$(document).ready(function() {
	$(function(){
		$("input, textarea, select, button").uniform();
	});


	$("#zip_code").change(function() {
		if ($(this).val() != "-99") {
			$("#station_number").attr("disabled", "disabled");
		} else {
			$("#station_number").removeAttr("disabled");
		}
	});
	$("#station_number").change(function() {
		if ($(this).val() != "-99") {
			$("#zip_code").attr("disabled", "disabled");
		} else {
			$("#zip_code").removeAttr("disabled");
		}
	});

	$(".tabs").tabs();

	$("#find form").submit(function() {

		$("#find").slideUp("fast", function() {
			$(this).html("Loading&hellip;").slideDown("fast");
		});
		$.ajax({
			url: 'home/locate_station',
			type: 'post',
			data: {address: $("#address").val()},
			success: function(r) {
				$("#find").slideUp("fast", function() {
					$(this).html(r).slideDown("fast");
				});
			}
		});
		return false;
	});

	$("#ask form").submit(function() {
		$("#ask").slideUp("fast", function() {
			$(this).html("Loading&hellip;").slideDown("fast");
		});		
	});

	$("#feedback_form").submit(function() {
		$.ajax({
			url: 'http://dmwc.biz/hack4reno/home/save_feedback',
			type: 'post',
			data: {station_id: $("#station_id").val(), name: $("#name").val(), rating: $("#rating").val(), comments: $("#comments").val()},
			success: function(r) {
				$("#feedback").slideUp("fast", function() {
					$(this).html(r).slideDown("fast");
				})
			}
		})
		return false;
	});
});