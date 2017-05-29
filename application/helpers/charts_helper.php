<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!function_exists('gross_risk')) {

    function gross_risk($risks = []) {
        $html = "<div class='row'> \n <div class='col-sm-8' id='gross_risk_pdf'><div class='heat-map  text-center'>";

        $impact = explode(",", ",Insignificant,Minor,Moderate,Major,Catastrophic");
        $probability = explode(",", ",Rare,Unlikely,Probable,Likely,Almost Certain");
        $diff = 0;
        $product = 0;
        for ($j = 5; $j >= 0; $j--) {
            for ($i = 0; $i <= 5; $i++) {
                $color = "bg-gray-light";
                $product = $i * $j;
                $diff = ($i > $j) ? $j : $i;
                if ($product >= 20) {
                    $color = "ht-red";
                }
                if ($product < 20) {
                    $color = "ht-orange";
                }
                if ($product < 10) {
                    $color = "ht-yellow";
                }
                if ($product <= 6) {
                    $color = "ht-green";
                }
                if ($product < 3) {
                    $color = "ht-blue";
                }
                if ($product == 0) {
                    $color = "bg-gray-lighter";
                }
                if ($product == 5) {
                    $color = "ht-yellow";
                }

                $html .= " <div class='heat-box pull-left square {$color} '> "
                        . "<div class='" . (($product > 0) ? "overflowContainer" : NULL) . "'>";

                if ($product == 0) {
                    $html .= "<h3>" . heatmap_key("impact", $j) . (($j != 0) ? " ($j) " : null) . heatmap_key("probability", $i) . (($i != 0) ? "($i)" : null) . "</h3>";
                } else {
                    $html .= "<h4 class='p_label'>" . $product . "</h4>";
                }
                if ($product != 0) {
                    foreach ($risks as $key => $risk):
                        if (!isset($risk))
                            continue;
                        $risk_link = base_url() . "index.php/Risk/risk/{$risk["id"]}";
                        $risk_popUp_link = base_url() . "risks/riskPopup/{$risk["id"]}";
                        $words = str_word_count($risk['title'], 1);
                        $risk_name = isset($words[0]) ? $words[0] : NULL;
                        $risk_name .= isset($words[1]) ? " " . $words[1] : NULL;
                        $array = explode("-", $risk['ref_code']);
                        $risk_code = $risk['heat_map_ref'];
                        if ($risk['probability'] == $j and $risk['impact'] == $i) {
                            $html .= "<a href='{$risk_link}' 
                                                           class='risk_label' id='heat-map-gross_risk-{$risk['id']}' 
                                                           type='button' 
                                                           data-toggle='tooltip' data-placement='top' data-original-title='{$risk['title']}' > 
                                                            <strong >{$risk_code}</strong> 
                                                        </a>";
                        }
                    endforeach;
                }
                $html .= " </div></div>";
            }
        }
        $html .= " </div>"
                . "</div>"
                . "<div class='col-sm-4'>"
                . "<table class='table table-sm table-small table-hover'>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        foreach ($risks as $value) :

            $html .= "<tr>
            <td><small>" . substr($value['heat_map_ref'], 0, 5) . "</small></td>
            <td><a href='" . base_url("index.php/Risk/risk/{$value['id']}") . "'>" . substr($value['title'], 0, 25) . "</a></td>
          </tr>";

        endforeach;
        $html .= "
                    </tbody>
                </table>"
                . "</div>"
                . "</div>"
                . "<div class='clearfix'></div> ";
        return $html;
    }

}
if (!function_exists('net_risk')) {

    function net_risk($risks = []) {
        $html = "<div class='row'><div class='col-sm-8'><div class='heat-map  text-center'>";
        $gross_risk = explode(",", ",low,minimal,moderate,high,severe");
        $control_ratings = explode(",", ",excellent,good,moderate,weak,poor");
        $impact = explode(",", ",Insignificant,Minor,Moderate,Major,Catastrophic");
        $probability = explode(",", ",Rare,Unlikely,Probable,Likely,Almost Certain");
        $diff = 0;
        $product = 0;
        for ($j = 5; $j >= 0; $j--) {
            for ($i = 0; $i <= 5; $i++) {
                $color = "bg-gray-light";
                $product = $i * $j;
                $diff = ($i > $j) ? $j : $i;
                if ($product >= 20) {
                    $color = "ht-red";
                }
                if ($product < 20) {
                    $color = "ht-orange";
                }
                if ($product < 10) {
                    $color = "ht-yellow";
                }
                if ($product <= 6) {
                    $color = "ht-green";
                }
                if ($product < 3) {
                    $color = "ht-blue";
                }
                if ($product == 0) {
                    $color = "bg-gray-lighter";
                }
                if ($product == 5) {
                    $color = "ht-yellow";
                }
                $html .= " <div class='heat-box pull-left square {$color} '> "
                        . "<div class='" . (($product > 0) ? "overflowContainer" : NULL) . "'>";
                if ($product == 0) {
                    $html .= "<h3>" . heatmap_key('gross_risk', $j) . (($j != 0) ? "($j)" : null) . heatmap_key('control_ratings', $i) . (($i != 0) ? "($i)" : null) . "</h3>";
                } else {
                    $html .= "<h4 class='p_label'>" . $product . "</h4>";
                }
                if ($product != 0) {
                    foreach ($risks as $key => $risk):
                        $risk_link = base_url() . "index.php/Risk/risk/{$risk["id"]}";
                        $risk_popUp_link = base_url() . "index.php/risks/riskPopup/{$risk["id"]}";
                        $words = str_word_count($risk['title'], 1);
                        $risk_name = isset($words[0]) ? $words[0] : NULL;
                        $risk_name .= isset($words[1]) ? " " . $words[1] : NULL;

                        $array = explode("-", $risk['ref_code']);
                        $risk_code = $risk['heat_map_ref'];
                        $val_1 = NULL;
                        $val_2 = NULL;
                        if (isset($risk['analysis_types']) and in_array("control_ratings", $risk['analysis_types'])) {
                            $val_1 = 'gross_risk';
                            $val_2 = 'control_ratings';
                        } else {
                            $val_1 = 'probability';
                            $val_2 = 'impact';
                        }
                        if ($risk[$val_1] == $j and $risk[$val_2] == $i) {
                            $html .= "<a href='{$risk_link}' "
                                    . "class='risk_label'  "
                                    . "id='heat-map-net_risk-{$risk['id']}' 
                                        data-toggle='tooltip' 
                                        data-placement='top' 
                                        title='' 
                                        data-original-title='{risk['title']}' > 
                                                            <strong>{$risk_code}</strong> 
                                        </a>";
                        }
                    endforeach;
                }
                $html .= " </div></div>";
            }
        }
        $html .= " </div>"
                . "</div>"
                . "<div class='col-sm-4'>"
                . "<table class='table table-sm table-small table-hover'>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        foreach ($risks as $value) :

            $html .= "<tr>
            <td><small>" . substr($value['heat_map_ref'], 0, 5) . "</small></td>
            <td><a href='" . base_url("index.php/Risk/risk/{$value['id']}") . "'>" . substr($value['title'], 0, 25) . "</a></td>
          </tr>";

        endforeach;
        $html .= "
                    </tbody>
                </table>"
                . "</div>"
                . "</div>"
                . "<div class='clearfix'></div> ";
        return $html;
    }

}
if (!function_exists('control_ratings')) {

    function control_ratings($risks = []) {
        $html = NULL;
        $html = "<div class='row'><div class='col-sm-8'><div class='heat-map  text-center'>";

        $adequacy = explode(",", ",adequate,minor improvements,significant improvements,inadequate");
        $effectiveness = explode(",", ",satisfactory,minor improvements,significant improvements,unsatisfactory");
        for ($j = 4; $j >= 0; $j--) {
            for ($i = 0; $i <= 4; $i++) {
                $color = "bg-gray-light";
                $product = $i * $j;
                $diff = ($i > $j) ? $j : $i;
                if ($product == 1) {
                    $color = "cr-excellent";
                }
                if ($product == 2) {
                    $color = "cr-good";
                }
                if ($product < 5 and $product > 2) {
                    $color = "cr-moderate";
                }
                if ($product < 10 and $product >= 5) {
                    $color = "cr-weak";
                }
                if ($product > 10) {
                    $color = "cr-poor";
                }
                if ($product == 0) {
                    $color = "bg-gray-lighter";
                }

                $html .= "<div class='heat-box pull-left square controls-ratings {$color} '>"
                        . " <div class='" . (($product > 0) ? "overflowContainer" : NULL) . "'>\n";
                if ($product == 0) {
                    $html .= "<h3>" . heatmap_key('adequacy', $j) . (($j != 0) ? "($j)" : null) . heatmap_key('effectiveness', $i) . (($i != 0) ? "($i)" : null) . "</h3>";
                } else {
                    $html .= "<h4 class='p_label'>" . $product . "</h4>";
                }
                if ($product != 0) {

                    foreach ($risks as $key => $risk):
                        if (!isset($risk))
                            continue;
                        $risk_link = base_url() . "index.php/Risk/risk/{$risk["id"]}";
                        $risk_popUp_link = base_url() . "risks/riskPopup/{$risk["id"]}";
                        $words = str_word_count($risk['title'], 1);
                        $risk_name = isset($words[0]) ? $words[0] : NULL;
                        $risk_name .= isset($words[1]) ? " " . $words[1] : NULL;
                        $array = explode("-", $risk['ref_code']);
                        $risk_code = $risk['heat_map_ref'];
                        if ($risk['adequacy'] == $j and $risk['effectiveness'] == $i) {
                            $html .= "<a href='{$risk_link}' 
                                        class='risk_label' id='heat-map-control_rating-{$risk['id']}' 
                                        onmouseover='riskHeatMapHover({$risk['id']})'
                                        type='button' 
                                        data-toggle='tooltip' data-placement='top' title='' data-original-title='{$risk['title']}' > 
                                         <strong>{$risk_code}</strong> 
                                        </a>";
                        }
                    endforeach;
                }
                $html .= "</div></div>";
            }
        }

        $html .= " </div>"
                . "</div>"
                . "<div class='col-sm-4'>"
                . "<table class='table table-sm table-small table-hover'>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
        foreach ($risks as $value) :

            $html .= "<tr>
            <td><small>" . substr($value['heat_map_ref'], 0, 5) . "</small></td>
            <td><a href='" . base_url("index.php/Risk/risk/{$value['id']}") . "'>" . substr($value['title'], 0, 25) . "</a></td>
          </tr>";

        endforeach;
        $html .= "
                    </tbody>
                </table>"
                . "</div>"
                . "</div>"
                . "<div class='clearfix'></div> ";
        return $html;
        return $html;
    }

}

if (!function_exists('pie_chart_cs')) {

    function pie_chart_cs($chart_id = false, $dataArray = [], $height = 300) {
        // print_pre($dataArray);

        if (!$chart_id) {
            $chart_id = "pie_chart_cs" . rand(100, 10000) * rand(100, 10000);
        }
        $colors = NULL;

        $html = "<div id=\"{$chart_id}\" style=\"height: 300px;\"></div>"
                . "<script>"
                . "!function ($) {
                        \"use strict\";
                        var MorrisCharts = function () {};
                        //creates Donut chart
                        MorrisCharts.prototype.createDonutChart = function (element, data, colors) {
                            Morris.Donut({
                                element: element,
                                data: data,
                                resize: true, //defaulted to true
                                colors: colors
                            });
                        },
                                MorrisCharts.prototype.init = function () {
                                    //creating donut chart
                                    var \$donutData = [";
        foreach ($dataArray as $key => $value) {
            $html .= "{label: \"{$value['name']}\", value: {$value['value']}},";
            $colors .= "'{$value['color']}',";
        }
        $html .= "  ];
                    this.createDonutChart('$chart_id', \$donutData, [$colors]);
                },
                //init
                $.MorrisCharts = new MorrisCharts, $.MorrisCharts.Constructor = MorrisCharts;
    }(window.jQuery),
//initializing 
            function ($) {
                \"use strict\";
                $.MorrisCharts.init();
            }(window.jQuery);
</script>";
        return $html;
    }

}
if (!function_exists('pie_chart_js')) {

    function pie_chart_js($data = [], $tag_id = NULL, $tag_class = NULL) {
        
    }

}

if (!function_exists('line_chart_c3')) {

    function line_chart_c3($graph_id = false, $data_array = [], $height = 300) {
        $series = explode(",", "a,b,c,d,e,f,g,h,i,j,k,l,m,o,p,q,r,s,t,u,v,w,x,y,z");
        $s_labels = NULL;
        $s_colors = NULL;
        $s_key = NULL;
        $s_data = NULL;
        $new_array = NULL;
        $row = NULL;
        // print_pre($data_array);
        $html = "<div class=''>
    <div class='text-xs-center'>
        <ul class='list-inline chart-detail-list'>
           ";
        foreach ($data_array as $key => $value) {
            $html .= "
            <li class='list-inline-item'>
                <h6 style='color: {$value['color']};'><i class='zmdi zmdi-circle-o m-r-5'></i> {$value['series_name']}</h6>
            </li>\n";
            $s_labels .= "'{$value['series_name']}',";
            $s_key .= "'{$series[$key]}',";
            $s_colors .= "'{$value['color']}',";

            $new_array[] = $value['data'];
        }
        $nn = [];
        foreach ($new_array as $key => $array) {
            foreach ($array as $label => $value) {
                $nn[$label][] = $value;
            }
        }

        //{y: '2008', a: 50, b: 0},
        foreach ($nn as $key => $array) {
            $s_data .= "{ y: '$key' , ";
            foreach ($array as $label => $val) {
                $s_data .= $series[$label] . ":" . $val . ", ";
            }
            $s_data .= "},\n";
        }

        //print_pre($nn);
        // echo $s_data;
        $html .= "
        </ul>
    </div>
    <div id='$graph_id' style='height: $height px;'></div>
</div>
<script>
    !function ($) {
        'use strict';
        var MorrisCharts = function () {};
        //creates line chart
        MorrisCharts.prototype.createLineChart = function (element, data, xkey, ykeys, labels, opacity, Pfillcolor, Pstockcolor, lineColors) {
            Morris.Line({
                element: element,
                data: data,
                xkey: xkey,
                ykeys: ykeys,
                labels: labels,
                fillOpacity: opacity,
                pointFillColors: Pfillcolor,
                pointStrokeColors: Pstockcolor,
                behaveLikeLine: true,
                gridLineColor: '#eef0f2',
                hideHover: 'auto',
                lineWidth: '3px',
                pointSize: 0,
                preUnits: '',
                resize: true, //defaulted to true
                lineColors: lineColors
            });
        },
                MorrisCharts.prototype.init = function () {

                    //create line chart
                    var \$data = [
$s_data
                    ];
                    this.createLineChart('$graph_id', \$data, 'y', [$s_key], [$s_labels], ['10'], ['#ffffff'], ['#999999'], [$s_colors]);
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
";
        return $html;
    }

}


if (!function_exists('bar_graph_c3')) {

    function bar_graph_c3($graph_id = false, $data_array = [], $height = 300) {


        $series = explode(",", "a,b,c,d,e,f,g,h,i,j,k,l,m,o,p,q,r,s,t,u,v,w,x,y,z");
        $s_labels = NULL;
        $s_colors = NULL;
        $s_key = NULL;
        $s_data = NULL;
        $new_array = NULL;
        $row = NULL;
        // print_pre($data_array);
        $html = "<div class=''>
    <div class='text-xs-center'>
        <ul class='list-inline chart-detail-list'>
           ";
        foreach ($data_array as $key => $value) {
            $html .= "
            <li class='list-inline-item'>
                <h6 style='color: {$value['color']};'><i class='zmdi zmdi-circle-o m-r-5'></i> {$value['series_name']}</h6>
            </li>\n";
            $s_labels .= "'{$value['series_name']}',";
            $s_key .= "'{$series[$key]}',";
            $s_colors .= "'{$value['color']}',";

            $new_array[] = $value['data'];
        }
        $nn = [];
        foreach ($new_array as $key => $array) {
            foreach ($array as $label => $value) {
                $nn[$label][] = $value;
            }
        }

        //{y: '2008', a: 50, b: 0},
        foreach ($nn as $key => $array) {
            $s_data .= "{ y: '$key' , ";
            foreach ($array as $label => $val) {
                $s_data .= $series[$label] . ":" . $val . ", ";
            }
            $s_data .= "},\n";
        }
        //print_pre($nn);
        // echo $s_data;
        $html .= "
        </ul>
    </div>
    
    <div id='$graph_id' style='height: {$height}px;'></div>
</div>
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
                    var \$data = [
$s_data
                    ];
               
        this.createBarChart('$graph_id', \$data, 'y', [$s_key], [$s_labels], [$s_colors]);
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
";
        return $html;
    }

}



if (!function_exists('bar_graph_c4')) {

    function bar_graph_c4($graph_id = false, $data_array = [], $height = 300) {


        $series = explode(",", "a,b,c,d,e,f,g,h,i,j,k,l,m,o,p,q,r,s,t,u,v,w,x,y,z");
        $s_labels = NULL;
        $s_colors = NULL;
        $s_key = NULL;
        $s_data = NULL;
        $new_array = NULL;
        $row = NULL;
        // print_pre($data_array);
        $html = "<div class=''>
    <div class='text-xs-center'>
        <ul class='list-inline chart-detail-list'>
           ";
        foreach ($data_array as $key => $value) {
            $html .= "
            <li class='list-inline-item'>
                <h6 style='color: {$value['color']};'><i class='zmdi zmdi-circle-o m-r-5'></i> {$value['series_name']}</h6>
            </li>\n";
            $s_labels .= "'{$value['series_name']}',";
            $s_key .= "'{$series[$key]}',";
            $s_colors .= "'{$value['color']}',";

            $new_array[] = $value['data'];
        }
        $nn = $new_array;
        foreach ($new_array as $key => $array) {
            foreach ($array as $label => $value) {
                $nn[$label][] = $value;
            }
        }
        // echo __METHOD__;
        //{y: '2008', a: 50, b: 0},
        foreach ($nn as $key => $array) {
            $s_data .= "{ y: '$key' , ";
            foreach ($array as $label => $val) {
                $s_data .= $series[$label] . ":" . $val . ", ";
            }
            $s_data .= "},\n";
        }
        //print_pre($nn);
        // echo $s_data;
        $html .= "
        </ul>
    </div>
    
    <div id='$graph_id' style='height: {$height}px;'></div>
</div>
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
                    var \$data = [
$s_data
                    ];
               
        this.createBarChart('$graph_id', \$data, 'y', [$s_key], [$s_labels], [$s_colors]);
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
";
        return $html;
    }

}


    