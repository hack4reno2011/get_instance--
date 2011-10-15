<?php $this->load->view("_page_start"); ?>
	<div id="main" role="main" class="grid_12">
		
		<p>Select your zip code, or the fire station number you wish to view information for:</p>

		<form action="<?php echo base_url(); ?>home/result_set" method="post">
			<p>
				<label for="zip_code">Zip Code:</label>
				<select name="zip_code" id="zip_code">
					<option value="-99">-- Select --</option>
					<?php
					$q = $this->db->select("DISTINCT(station_zip) AS zip")->from("stations")->order_by("zip", "ASC")->where("station_zip !=", 0)->get();
					if ($q->num_rows() > 0) {
						foreach($q->result() AS $r) {
							echo "<option>" . $r->zip . "</option>";
						}
					}
					?>
				</select>
			</p>
			<p>
				OR&hellip;
			</p>
			<p>
				<label for="station_number">Station #:</label>
				<select name="station_number" id="station_number">
					<option value="-99">-- Select --</option>
					<?php
					$q = $this->db->select("DISTINCT(station_num) AS station")->from("stations")->get();
					if ($q->num_rows() > 0) {
						foreach($q->result() AS $r) {
							echo "<option>" . $r->station . "</option>";
						}
					}
					?>
				</select>
			</p>

			<p>
				<button class="button"><strong>Let's See It!</strong></button>
			</p>
		</form>
	</div>
<?php $this->load->view("_page_end"); ?>