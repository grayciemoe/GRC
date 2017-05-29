
<?PHP
$units_data = [];
$submission_times = [];
$units_penalty = [];
foreach ($data['obligations'] as $key => $value) {
    $name = $value['environment']['name'] ? $value['environment']['name'] : "No Name";
    if ($value['environment']['environment_level'] == 1) {
        $name = "CORP";
    }
    if (!isset($units_data[$name])) {
        $units_data[$name] = 0;
    }
    if (!isset($units_penalty[$name])) {
        $units_penalty[$name] = 0;
    }
    $date_month = strftime("%Y %b", strtotime($value['submission_deadline']));
    if (!isset($submission_times[$date_month])) {
        $submission_times[$date_month] = 0;
    }
    $units_penalty[$name] += $value['noncompliance_penalty'];
    $submission_times[$date_month] ++;
    $units_data[$name] ++;
}
?>
<div class="row">
    <div class="col-sm-12">
        <!-- CHART 1 -->
        <div class="card">
            <div class="card-block">

                <h4 class="card-title text-center">
                    No. of Obligations over Time
                </h4>
                <div id="morris-obligations-timely" style="height: 300px;"></div>
            </div>
        </div>
        <?php
        $barData = null;
        $series = null;
        foreach ($submission_times as $key => $value) {
            $barData .= "{y: '$key', a: $value},\n";
            $series .= "'$key', ";
        }
        //echo nl2br($barData);
        ?>
        <script>
            !function ($) {
                "use strict";
                var MorrisCharts = function () {};
                //creates Bar chart
                MorrisCharts.prototype.createBarChart = function (element, data, xkey, ykeys, labels, lineColors) {
                    Morris.Bar({
                        element: element,
                        data: data,
                        xkey: xkey,
                        ykeys: ykeys,
                        labels: labels,
                        hideHover: 'auto',
                        resize: true, //defaulted to true
                        gridLineColor: '#eeeeee',
                        barSizeRatio: 0.4,
                        xLabelAngle: 35,
                        barColors: lineColors
                    });
                },
                        MorrisCharts.prototype.init = function () {
                            //creating bar chart
                            var $barData = [
<?= $barData ?> // {y: '2009', a: 100, b: 90, c: 40},
                            ];
                            this.createBarChart('morris-obligations-timely', $barData, 'y', ['a'], [<?= $series ?>], ['#3db9dc']);
                        },
                        //init
                        $.MorrisCharts = new MorrisCharts, $.MorrisCharts.Constructor = MorrisCharts
            }(window.jQuery), function ($) {
                "use strict";
                $.MorrisCharts.init();
            }(window.jQuery);
        </script>
    </div>
    <div class="col-sm-6">
        <!-- CHART 1 -->
        <div class="card">
            <div class="card-block">
                <div class="card-title">
                    <h4 class="card-title text-center">No. of Obligations per Unit</h4>
                </div>
                <?php
                $chart_id = "units_data";
                $data = [];
                $index = 0;
                $colors = array("#bbbbbb", "#aa5555", "#88bb88", "#bbbb55");

                foreach ($units_data as $key => $value) {
                    $data[$index]['name'] = $key;
                    $data[$index]['value'] = $value;
                    $data[$index]['color'] = $colors[$index];
                    $index++;
                }
//                $data = array(
//                  //  $units_data
//                    array("name" => "Statutory Returns", "value" => $data['Stat_returns'], "color" => "#ff8800"),
//                    array("name" => "Legal Requirements", "value" => $data['Legal_req'], "color" => "#992222"),
//                    array("name" => "Business Compliance", "value" => $data['Business_req'], "color" => "#55cc55"),
//                );
                ?>
                <?= pie_chart_cs($chart_id, $data) ?>
                <div class="row m-t-10 text-muted">
                    <h6 class="text-center">Summary</h6>
                    <ul class="list-group">
                        <?php foreach ($units_data as $key => $value): ?>
                            <li class="list-group-item"><?= $key ?> : <?= $value ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <div class="col-sm-6">
        <!-- CHART 1 -->
        <div class="card">

            <div class="card-block">
                <h4 class="card-title text-center">
                    Amount of Obligation Penalties Per Unit
                </h4>
                <div id="morris-obligations-penalty-unit" style="height: 300px;"></div>
            </div>
        </div>

        <?php
        $barData = null;
        $series = null;
        foreach ($units_penalty as $key => $value) {
            $barData .= "{y: '$key', a: $value},\n";
            $series .= "'$key',";
        }
//echo nl2br($barData);
        ?>
        <script>
            !function ($) {
                "use strict";

                var MorrisCharts = function () {};

                //creates Bar chart
                MorrisCharts.prototype.createBarChart = function (element, data, xkey, ykeys, labels, lineColors) {
                    Morris.Bar({
                        element: element,
                        data: data,
                        xkey: xkey,
                        ykeys: ykeys,
                        labels: labels,
                        hideHover: 'auto',
                        resize: true, //defaulted to true
                        gridLineColor: '#eeeeee',
                        barSizeRatio: 0.4,
                        xLabelAngle: 35,
                        barColors: lineColors
                    });
                },
                        MorrisCharts.prototype.init = function () {


                            //creating bar chart
                            var $barData = [
<?= $barData ?>//{y: '2009', a: 100, b: 90, c: 40},
                            ];
                            this.createBarChart('morris-obligations-penalty-unit', $barData, 'y', ['a'], [<?= $series ?>], ['#3db9dc']);
                        },
                        //init
                        $.MorrisCharts = new MorrisCharts, $.MorrisCharts.Constructor = MorrisCharts
            }(window.jQuery), function ($) {
                "use strict";
                $.MorrisCharts.init();
            }(window.jQuery);
        </script>
    </div>


</div>


<?php
/*

 * 
 * 
  <div class="col-sm-6">
  <!-- CHART 1 -->
  <div class="card">

  <div class="card-block">
  <div class="card-title">
  Obligations Per Unit
  </div>
  <div id="morris-obligations-per-unit" style="height: 300px;"></div>
  </div>
  </div>
  <script>



  !function ($) {
  "use strict";

  var MorrisCharts = function () {};

  //creates Bar chart
  MorrisCharts.prototype.createBarChart = function (element, data, xkey, ykeys, labels, lineColors) {
  Morris.Bar({
  element: element,
  data: data,
  xkey: xkey,
  ykeys: ykeys,
  labels: labels,
  hideHover: 'auto',
  resize: true, //defaulted to true
  gridLineColor: '#eeeeee',
  barSizeRatio: 0.4,
  xLabelAngle: 35,
  barColors: lineColors
  });
  },
  MorrisCharts.prototype.init = function () {


  //creating bar chart
  var $barData = [
  {y: '2009', a: 100, b: 90, c: 40},
  {y: '2010', a: 75, b: 65, c: 20},
  {y: '2011', a: 50, b: 40, c: 50},
  {y: '2012', a: 75, b: 65, c: 95},
  {y: '2013', a: 50, b: 40, c: 22},
  {y: '2014', a: 75, b: 65, c: 56},
  {y: '2015', a: 100, b: 90, c: 60}
  ];
  this.createBarChart('morris-obligations-per-unit', $barData, 'y', ['a', 'b', 'c'], ['Series A', 'Series B', 'Series C'], ['#3db9dc', '#f1b53d', "#ff5d48"]);
  },
  //init
  $.MorrisCharts = new MorrisCharts, $.MorrisCharts.Constructor = MorrisCharts
  }(window.jQuery), function ($) {
  "use strict";
  $.MorrisCharts.init();
  }(window.jQuery);
  </script>
  </div>
 * 
 *  */?>