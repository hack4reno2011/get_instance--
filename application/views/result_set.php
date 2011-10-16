<?php $this->load->view("_page_start"); ?>
	<div id="main" role="main" class="grid_12">
		<?php
		$calls = array();
		foreach($set AS $s) {
			/*
			[station_num] => 15
		    [station_address] => 110 Quartz Lane
		    [station_city] => Sun Valley
		    [station_zip] => 89433
		    */
		    $q = $this->db->from("call_data")->where("station", $s->station_num)->get();
		    foreach($q->result() AS $r) {
		    	$calls[] = array(
		    		"call_type" => $r->call_type,
		    		"jurisdiction" => $r->jurisdiction,
		    		"station" => $r->station,
		    		"received_datetime" => $r->received_datetime,
		    		"dispatch_first_time" => $r->dispatch_first_time,
		    		"onscene_first_time" => $r->onscene_first_time,
		    		"fire_control_time" => $r->fire_control_time,
		    		"close_time" => $r->close_time
			    );
		    }
		}
		?>
		<!-- 
		# calls over last 30 days
		max/min/avg response times last 30 days
		call breakdown last 30 days
		
		<p>Zip Code =

		<p>Station =
		-->
		<div id="chart"></div>
	</div>
<?php $this->load->view("_page_end", array("show_chart" => true, "calls" => $call_data)); ?>