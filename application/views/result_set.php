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
		$call_codes = array(
			  array('code'=>'EMS','desciption'=>'Emergency Medical Services'),
			  array('code'=>'ACCF','desciption'=>'Auto Accident '),
			  array('code'=>'OUTU','desciption'=>'On a call - Unavailable'),
			  array('code'=>'RA/ EMS','desciption'=>'Request Assistance / Emergency Medical Services'),
			  array('code'=>'ALARMF','desciption'=>'Fire Alarm Activation'),
			  array('code'=>'UNK/ EMS','desciption'=>'Unknow Circumstance / Emergency Medical Services'),
			  array('code'=>'FINFO','desciption'=>'Information'),
			  array('code'=>'RA','desciption'=>'Request Assistance '),
			  array('code'=>'RA/ ACCF','desciption'=>'Request Assistance /  Auto Accident '),
			  array('code'=>'OUTA','desciption'=>'On a call - Available'),
			  array('code'=>'UNK/ WATER1','desciption'=>'Water Rescue Level 1 (low)'),
			  array('code'=>'UNK/ FINFO','desciption'=>'Information'),
			  array('code'=>'TEST1','desciption'=>'System Test - First Alarm (1 engine)'),
			  array('code'=>'WATER2','desciption'=>'Water Rescue Level 2 (high)'),
			  array('code'=>'VEH','desciption'=>'Vehicle Fire'),
			  array('code'=>'UNK','desciption'=>'Unknown Circumstance '),
			  array('code'=>'ASSIST','desciption'=>'Public Assistance'),
			  array('code'=>'FASIGN','desciption'=>'Busy on Assignment'),
			  array('code'=>'FIRST/ TEST1','desciption'=>'First Alarm Level 1 (1 engine) / System Test'),
			  array('code'=>'RA/ ASSIST','desciption'=>'Request Assistance / Public Assistance'),
			  array('code'=>'BOMBF','desciption'=>'Bomb'),
			  array('code'=>'ALARMF/ STRU2','desciption'=>'Alarm Structure Level 2 (high) '),
			  array('code'=>'RA/ VEH','desciption'=>'Request Assistance / Vehicle Fire'),
			  array('code'=>'FIRST/ ASSIST','desciption'=>'First Alarm Level 1 (1 engine) / Public Assistance'),
			  array('code'=>'STRU2','desciption'=>'Structure Fire Level 2 (multiple engines)'),
			  array('code'=>'FUEL1','desciption'=>'Fuel Spill Under 100 Gallons'),
			  array('code'=>'UNK/ STRU2','desciption'=>'Unknow Circumstance / Structure Fire Level 2 (multiple engines)'),
			  array('code'=>'BRUSH1','desciption'=>'Brush Fire Level 1 (1 engine)'),
			  array('code'=>'BURN','desciption'=>'Illegal or Unapproved Burn '),
			  array('code'=>'UNK/ ACCF','desciption'=>'Unknow Circumstance / Auto Accident ')
			);
		for($i = 4; $i <= 9; $i++) {
			foreach($call_codes AS $c) {
				$code = $c["code"];
				${"temp" . $i . "_types"}[$code] = 0;
			}
		}
		foreach($calls AS $station_num => $c) {
			$call_data[] = "{
				name: 'Station #" . $station_num . "',
				data: [" . count($c["calls"]["04"]) . ", " . count($c["calls"]["05"]) . ", " . count($c["calls"]["06"]) . ", " . count($c["calls"]["07"]) . ", " . count($c["calls"]["08"]) . ", " . count($c["calls"]["09"]) . "]
			}";
			for($i = 4; $i <= 9; $i++) {
				${"temp" . $i} = array();
				${"temp" . $i . "_total"} = array();
				foreach($c["calls"]["0" . $i] AS $k => $v) {
					if ($v["time_to_onscene"] > 30) {
						${"temp" . $i}[] = $v["time_to_onscene"];
						${"temp" . $i . "_total"}[] = $v["time_to_onscene"];
					}
					$type = $v["call_type"];
					//${"temp" . $i . "_types"}[$type]++;
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
			$avg_data[] = "{
				name: 'Station #" . $station_num . "',
				data: [" . number_format((array_sum($temp4_total) / count($temp4_total) / 60), 2) . ",
				" . number_format((array_sum($temp5_total) / count($temp4_total) / 60), 2) . ",
				" . number_format((array_sum($temp6_total) / count($temp4_total) / 60), 2) . ",
				" . number_format((array_sum($temp7_total) / count($temp4_total) / 60), 2) . ",
				" . number_format((array_sum($temp8_total) / count($temp4_total) / 60), 2) . ",
				" . number_format((array_sum($temp9_total) / count($temp4_total) / 60), 2) . "
				]
			}";
			
		}
		?>
		
	</div>
	<div id="chart_calls" class="grid_6"></div>
	<div id="chart_min" class="grid_6"></div>
	<br class="clear" /><br />
	<div id="chart_max" class="grid_6"></div>
	<div id="chart_avg" class="grid_6"></div>

	<div id="feedback" class="grid_12">
		<?php
		$num = $this->db->from("user_feedback")->where("station_id", $station_num)->count_all_results();
		if ($num > 0) {
			$q = $this->db->from("user_feedback")->where("station_id", $station_num)->get();
			$totals = array();
			$comments = "";
			foreach($q->result() AS $r) {
				$totals[] = $r->rating;
				$comments .= "<hr />" . $r->user_comments;
			}
			echo "<p>" . count($totals) . " user(s) rate this station an average of " . number_format(array_sum($totals) / count($totals), 2) . "</p><h2>User Comments</h2>";
			echo $comments;
			echo "<hr />";
		} else {
			echo "<p>No users have submitted any comments on this station yet. Be the first!";
		}
		?>
		<form action="home/save_feedback" method="post" id="feedback_form">
			<p>
				<input type="hidden" name="station_id" id="station_id" value="<?php echo $s->station_num; ?>" />
				<label for="name">Your Name:</label>
				<input type="text" name="name" id="name" class="text" style="width: 150px;" />
			</p>
			<p>
				<label for="rating">Rate This Station:</label>
				<select name="rating" id="rating">
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
				</select>
			</p>
			<p>
				<label for="comments">Comments:</label>
				<textarea name="comment" id="comments" rows="10" style="width: 300px;"></textarea>
			</p>
			<p>
				<button class="button">Submit Feedback</button>
			</p>
		</form>
	</div>

<?php $this->load->view("_page_end", array("show_chart" => true, "calls" => $call_data, "min_response" => $min_data, "max_response" => $max_data, "avg_response" => $avg_data)); ?>
