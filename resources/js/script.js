$(document).ready(function() {
	$(function(){
		$("textarea, select, button").uniform();
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
					console.log(r);
				});
			}
		});
		return false;
	});


});