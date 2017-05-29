<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
                
                <link href="<?= base_url("assets/plugins/gauge/css/export.css") ?>" rel="stylesheet" type="text/css" />


		<!-- Export plugin includes and styles -->
                <script src="<?= base_url("assets/plugins/gauge/js/amcharts.js") ?>"></script>
                <script src="<?= base_url("assets/plugins/gauge/js/gauge.js") ?>"></script>
                <script src="<?= base_url("assets/plugins/gauge/js/export.js") ?>"></script>
                

		<style>
		body, html {
			height: 100%;
			padding: 0;
			margin: 0;
			overflow: hidden;
			font-size: 11px;
			font-family: Verdana;
		}
		#chartdiv {
			width: 100%;
			height: 100%;
		}
		</style>

		<script type="text/javascript">
			var chart = AmCharts.makeChart( "chartdiv", {
				"type": "gauge",
				"titles": [ {
					"text": "Speedometer",
					"size": 15
				} ],
				"axes": [ {
					"startValue": 0,
					"axisThickness": 1,
					"endValue": 220,
					"valueInterval": 10,
					"bottomTextYOffset": -20,
					"bottomText": "0 km/h",
					"bands": [ {
						"startValue": 0,
						"endValue": 90,
						"color": "#00CC00"
					}, {
						"startValue": 90,
						"endValue": 130,
						"color": "#ffac29"
					}, {
						"startValue": 130,
						"endValue": 220,
						"color": "#ea3838",
						"innerRadius": "95%"
					} ]
				} ],
				"arrows": [ {} ],
				"export": {
					"enabled": true
				}
			} );

			setInterval( randomValue, 2000 );

			// set random value
			function randomValue() {
				var value = Math.round( Math.random() * 200 );
				chart.arrows[ 0 ].setValue( value );
				chart.axes[ 0 ].setBottomText( value + " km/h" );
			}
		</script>
	</head>
	<body>
		<div id="chartdiv"></div>
	</body>
</html>