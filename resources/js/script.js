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
});