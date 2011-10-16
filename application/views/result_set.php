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
		
		$call_data = array();
		$response_data = array();
		foreach($calls AS $station_num => $c) {
			$call_data[] = "{
				name: 'Station #" . $station_num . "',
				data: [" . count($c["calls"]["04"]) . ", " . count($c["calls"]["05"]) . ", " . count($c["calls"]["06"]) . ", " . count($c["calls"]["07"]) . ", " . count($c["calls"]["08"]) . ", " . count($c["calls"]["09"]) . "]
			}";
			for($i = 4; $i <= 9; $i++) {
				${"temp" . $i} = array();
				foreach($c["calls"]["0" . $i] AS $k => $v) {
					if ($v["time_to_onscene"] > 30) {
						${"temp" . $i}[] = $v["time_to_onscene"];
					}
				}
			}
			$min_data[] = "{
				name: 'Station #" . $station_num . "',
				data: [" . number_format((min($temp4) / 60), 2) . ", " . number_format((min($temp5) / 60), 2) . ", " . number_format((min($temp6) / 60), 2) . ", " . number_format((min($temp7) / 60), 2) . ", " . number_format((min($temp8) / 60), 2) . ", " . number_format((min($temp9) / 60), 2) . "]
			}";
			$max_data[] = "{
				name: 'Station #" . $station_num . "',
				data: [" . number_format((max($temp4) / 60), 2) . ", " . number_format((max($temp5) / 60), 2) . ", " . number_format((max($temp6) / 60), 2) . ", " . number_format((max($temp7) / 60), 2) . ", " . number_format((max($temp8) / 60), 2) . ", " . number_format((max($temp9) / 60), 2) . "]
			}";
		}
		?>
		<!-- 
		call breakdown last 30 days
		
		<p>Zip Code =

		<p>Station =
		-->
	</div>
	<div id="chart_calls" class="grid_6"></div>
	<div id="chart_min" class="grid_6"></div>
	<br class="clear" /><br />
	<div id="chart_max" class="grid_6"></div>

<?php $this->load->view("_page_end", array("show_chart" => true, "calls" => $call_data, "min_response" => $min_data, "max_response" => $max_data)); ?>