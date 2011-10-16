<?php $this->load->view("_page_start"); ?>
	<h2 style="text-align: center;">Results For <?php echo $for; ?></h2>
	<div id="main" role="main" class="grid_12">
		<?php
		function hmstotime($hms) {
		    list($hours, $minutes, $seconds) = explode(":",$hms);
		    return $hours * 60 * 60 + $minutes * 60 + $seconds;
		}
		$calls = array();
		foreach($set AS $s) {
			$q = $this->db->from("call_data")->where("station", $s->station_num)->get();
		    $calls[$s->station_num] = array("info" => array("address" => $s->station_address, "city" => $s->station_city, "zip" => $s->station_zip), "calls" => array());
		    foreach($q->result() AS $r) {
		    	$month = date("m", strtotime($r->received_datetime));
		    	$time_to_onscene = hmstotime($r->onscene_first_time) - hmstotime($r->dispatch_first_time);
		    	$calls[$s->station_num]["calls"][$month][] = array(
		    		"call_type" => $r->call_type,
		    		"jurisdiction" => $r->jurisdiction,
		    		"station" => $r->station,
		    		"received_datetime" => $r->received_datetime,
		    		"dispatch_first_time" => $r->dispatch_first_time,
		    		"onscene_first_time" => $r->onscene_first_time,
		    		"time_to_onscene" => $time_to_onscene,
		    		"fire_control_time" => $r->fire_control_time,
		    		"close_time" => $r->close_time
			    );
		    }
		}
		

		// all of your data you need is in the calls array...
		// $month = 04, 05, 06, 07, 08, 09, or 10
		// $calls[$station_id]["calls"][$month][]
		
		?>
	</div>
<?php $this->load->view("_page_end"); ?>