<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>[To Be Named]</title>
	<meta name="description" content="">
	<meta name="author" content="David Mosher, Robert Markin - @Hack4Reno">

	<meta name="viewport" content="width=device-width,initial-scale=1">
	<base href="<?php echo base_url(); ?>" />
	<link rel="stylesheet" href="resources/css/style.css">

	<script src="resources/js/modernizr-2.0.6.min.js"></script>
</head>
<body>

<div id="container" class="container_12">
	<header>
		<h1>[To Be Named]</h1>
	</header>
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
	<footer>

	</footer>
</div> <!--! end of #container -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="resources/js/jquery-1.6.2.min.js"><\/script>')</script>

<!-- scripts concatenated and minified via ant build script-->
<script src="resources/js/plugins.js"></script>
<script src="resources/js/script.js"></script>
<!-- end scripts-->

<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
	<script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
<![endif]-->

</body>
</html>
