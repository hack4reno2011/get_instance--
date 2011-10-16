<?php $this->load->view("_page_start"); ?>
	<div id="main" role="main" class="grid_12">
		<p>To locate your nearest fire stations, enter you address below:</p>
		<form action="home/locate_station" method="post">
			<label for="address">Address</label>
			<input type="text" name="address" id="address" />
			<button class="button">Find It!</button>
		</form>
	</div>
<?php $this->load->view("_page_end"); ?>



