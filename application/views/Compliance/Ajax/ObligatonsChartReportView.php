<div class="container-fluid">
    <?php 
     print_pre($data); 
 die();
    ?>
    <?php
    $months = array(null, "jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec");
    $obligations = $data['obligations'];
    $unit_sort = [];
    $current_period = [];
    echo now(); die;
    foreach ($obligations as $key => $value):
        
        if (!isset($current_period(strftime("%Y", strtotime($value['submission_deadline']))))) {
           echo "Alex";
        }
        
        
        if (!isset($unit_sort[$value['environment']['name']])) {
            // 'none','complied','partially','late_review','breach','fully'
            //  $unit_sort[$value['environment']['name']][$value['last_submission_status']] = 0;
            $unit_sort[$value['environment']['name']]['none'] = 0;
            $unit_sort[$value['environment']['name']]['complied'] = 0;
            $unit_sort[$value['environment']['name']]['partially'] = 0;
            $unit_sort[$value['environment']['name']]['late_review'] = 0;
            $unit_sort[$value['environment']['name']]['breach'] = 0;
            $unit_sort[$value['environment']['name']]['fully'] = 0;
        }
        $unit_sort[$value['environment']['name']][$value['last_submission_status']] ++;
        
        //print_pre (strftime("%b", strtotime($value['submission_deadline'])));// = strftime("%b", $value['submission_deadline']);

    endforeach;
    echo __FILE__;
 
    print_pre(($unit_sort));
    exit();
//    $current_status = array(
//    "Fully" => count($fully),
//    "Partially" => count($partially),
//    "None" => count($none)
//);

//    $array = array(
//        array("series_name" => "s1", "color" => "#ff0000", "data" => array(40, 50, 60, 70, 80),),
//        array("series_name" => "t1", "color" => "#00ff00", "data" => array(40, 50, 60, 70, 80),),
//        array("series_name" => "u1", "color" => "#0000ff", "data" => array(40, 50, 60, 70, 80),),
//    );
    $chart_array = [];
    $index = 0;
    
    foreach ($unit_sort as $key => $value) {
        $chart_array[$index]["series_name"] = $key;
        $chart_array[$index]["color"] = "#0000ff";
        $chart_array[$index]['data'] = $value;
        $index++;
    }
    
    //print_pre($chart_array);
    
//    echo bar_graph_c3("total_obligation_over_time", $chart_array);
//
//   return false;
    ?>

    <!-- Start right Content here -->
<!--   <div id="total_obligation_over_time"></div>
<script>
    !function ($) {
        'use strict';
        var MorrisCharts = function () {};
        //creates line chart
        MorrisCharts.prototype.createBarChart  = function(element, data, xkey, ykeys, labels, lineColors) {
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

                    //create line chart
                    var $data = [
{ y: 'none' , a:1, b:0, },
{ y: 'complied' , a:2, b:0, },
{ y: 'partially' , a:2, b:0, },
{ y: 'late_review' , a:48, b:39, },
{ y: 'breach' , a:14, b:8, },
{ y: 'fully' , a:3, b:0, },
 
                    ];
               
        this.createBarChart('total_obligation_over_time', $data, 'y', ['a','b',], ['EARe','HR and Admin',], ['#0000ff','#0000ff',]);
 },
                //init
                $.MorrisCharts = new MorrisCharts, $.MorrisCharts.Constructor = MorrisCharts
    }(window.jQuery),
//initializing 
            function ($) {
                'use strict';
                $.MorrisCharts.init();
            }(window.jQuery);
</script>
            <?//= bar_graph_c3("total_obligations_per_unit", $array, 400); ?>
        </div>
-->


    <!-- ============================================================== -->
    <div class="card card-block">
        <div class="col-sm-6">
            
            <?= bar_graph_c3("total_obligations_per_unit", $chart_array); ?>
        </div>
        <div class="col-sm-6">
            <?php
            $array = array(
                array("series_name" => "Total Obligation Over Time", "color" => "#999999", "data" => 0,),
            );
            ?>
            <?= bar_graph_c3("total_obligation_over_time", $array, 400); ?>
        </div>
    </div>
    <div class="card card-block">
        <div class="col-md-6">
            <?php
            $array = array(
                array("series_name" => "Penalty Over Time", "color" => "#999999", "data" => 0,),
            );
            ?>
            <?= bar_graph_c3("penalty_over_time", $array, 400); ?>
        </div>
        <div class="col-md-6">
            <?php
            $array = array(
                array("series_name" => "Penalty Per Unit", "color" => "#999999", "data" => 0,),
            );
            ?>
            <?= bar_graph_c3("penalty_per_unit", $array, 400); ?>
        </div>
    </div>
</div>