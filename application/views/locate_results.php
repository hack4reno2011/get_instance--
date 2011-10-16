<?php $this->load->view("_page_start"); ?>
	<div id="main" role="main" class="grid_12">
		<p>Here are the closest fire stations to the location you entered.</p>
		<?php

		foreach($close AS $station => $d) {
			$addressa = explode(",", $all->destination_addresses[$station]);
			$address = explode(" ", $addressa[0]);
			$address =  $address[0] . " " . substr($address[1], 0, 4);

			$q = $this->db->select("station_num")->from("stations")->like("station_address", $address)->get();
			$station_id = 0;
			if ($q->num_rows() == 1) {
				$r = $q->row();
				$station_id = $r->station_num;
			}
			echo "&bull; <a href='home/result_set/" . $station_id . "'>Station #" . $station_id . " @ " . $all->destination_addresses[$station] . "</a> (" . $all->rows["0"]->elements[$station]->distance->text . ")<br />";
		}
		?>
	</div>
<?php $this->load->view("_page_end"); ?>