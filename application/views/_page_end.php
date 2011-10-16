	<footer>
Here is the footer.
	</footer>
</div> <!--! end of #container -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="resources/js/jquery-1.6.2.min.js"><\/script>')</script>

<!-- scripts concatenated and minified via ant build script-->
<script src="resources/js/plugins.js"></script>
<script src="resources/js/script.js"></script>
<?php if (@$show_chart) {
?>
<script>
	$(document).ready(function() {
		call_chart = new Highcharts.Chart({
			chart: {
				renderTo: 'chart_calls',
				defaultSeriesType: 'line',
				marginRight: 130,
				marginBottom: 25
			},
			title: {
				text: 'Number of Calls',
				x: -20 //center
			},
			xAxis: {
				categories: ['Apr', 'May', 'Jun', 
					'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
			},
			yAxis: {
				title: {
					text: 'Call Volume'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				formatter: function() {
		                return '<b>'+ this.series.name +'</b><br/>'+
						this.x +': '+ this.y +' calls';
				}
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top',
				x: -10,
				y: 100,
				borderWidth: 0
			},
			series: [<?php
			$i = 0;
			foreach($calls AS $c) {
				if ($i == count($calls)) {
					echo $c;
				} else {
					echo $c . ",";
				}
				$i++;
			}
			?>]
		});

		min_chart = new Highcharts.Chart({
			chart: {
				renderTo: 'chart_min',
				defaultSeriesType: 'line',
				marginRight: 130,
				marginBottom: 25
			},
			title: {
				text: 'Minimum Response Times',
				x: -20 //center
			},
			xAxis: {
				categories: ['Apr', 'May', 'Jun', 
					'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
			},
			yAxis: {
				title: {
					text: 'Response Time (in minutes)'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				formatter: function() {
		                return '<b>'+ this.series.name +'</b><br/>'+
						this.x +': '+ this.y +' minutes(s)';
				}
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top',
				x: -10,
				y: 100,
				borderWidth: 0
			},
			series: [<?php
			$i = 0;
			foreach($min_response AS $c) {
				if ($i == count($calls)) {
					echo $c;
				} else {
					echo $c . ",";
				}
				$i++;
			}
			?>]
		});

		max_chart = new Highcharts.Chart({
			chart: {
				renderTo: 'chart_max',
				defaultSeriesType: 'line',
				marginRight: 130,
				marginBottom: 25
			},
			title: {
				text: 'Maximum Response Times',
				x: -20 //center
			},
			xAxis: {
				categories: ['Apr', 'May', 'Jun', 
					'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
			},
			yAxis: {
				title: {
					text: 'Response Time (in minutes)'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				formatter: function() {
		                return '<b>'+ this.series.name +'</b><br/>'+
						this.x +': '+ this.y +' minutes(s)';
				}
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top',
				x: -10,
				y: 100,
				borderWidth: 0
			},
			series: [<?php
			$i = 0;
			foreach($max_response AS $c) {
				if ($i == count($calls)) {
					echo $c;
				} else {
					echo $c . ",";
				}
				$i++;
			}
			?>]
		});
	});
</script>
<?php
}
?>
<!-- end scripts-->

<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
	<script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
<![endif]-->

</body>
</html>
