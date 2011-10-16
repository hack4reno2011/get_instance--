<?php $this->load->view("_page_start"); ?>
	<div id="main" role="main" class="grid_12">
		
		<p>FireBot utilizes public information from the Reno Fire Department to create an easy to understand view of the various station's response time to different types of calls.</p>
		
		<div class="tabs">
			<ul>
				<li><a href="#find">Find Closest Fire Station</a></li>
				<li><a href="#ask">Ask FireBot Something</a></li>
			</ul>

			<div id="find">
				<form action="home/locate_station" method="post">
					<label for="address">Enter Address:</label>
					<input type="text" name="address" id="address" style="width: 50%">
					<button class="button">Find Closest Station</button>
				</form>
			</div>

			<div id="ask">
				<p>Ask FireBot something...</p>
			</div>
		</div>
	</div>
<?php $this->load->view("_page_end"); ?>
