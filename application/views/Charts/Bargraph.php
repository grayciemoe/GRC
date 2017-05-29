
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="<?= base_url("assets/plugins/c3/c3.min.css") ?>" rel="stylesheet">

        <script src="<?= base_url("assets/js/jquery.min.js") ?>"></script>
        <script src="<?= base_url("assets/js/jquery.nicescroll.js") ?>"></script>
        <script src="<?= base_url("assets/plugins/d3/d3.min.js") ?>"></script>
        <script src="<?= base_url("assets/plugins/c3/c3.min.js") ?>"></script>


        <title>Bar Chart Example</title>
    </head>
    <body>


        <!--  <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div> -->

        <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
            <?php
            $array = array(
                array("series_name" => "s1", "color" => "#ff0000", "data" => array(60, 30, 90, 70, 80),),
                array("series_name" => "t1", "color" => "#00ff00", "data" => array(10   , 50, 60, 70, 80),),
                array("series_name" => "u1", "color" => "#0000ff", "data" => array(40, 50, 60, 70, 80),),
            );
            ?>
            <?= bar_graph_c3("cart_name_2", $array); ?>
        </div>        <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
            <?php
            $array = array(
                array("series_name" => "s1", "color" => "#ff0000", "data" => array(40, 50, 60, 70, 80),),
                array("series_name" => "t1", "color" => "#00ff00", "data" => array(40, 50, 60, 70, 80),),
                array("series_name" => "u1", "color" => "#0000ff", "data" => array(40, 50, 60, 70, 80),),
            );
            ?>
            <?= bar_graph_c3("cart_name", $array); ?>
        </div>        <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
            <?php
            $array = array(
                array("series_name" => "s1", "color" => "#ff0000", "data" => array(40, 50, 60, 70, 80),),
                array("series_name" => "t1", "color" => "#00ff00", "data" => array(40, 50, 60, 70, 80),),
                array("series_name" => "u1", "color" => "#0000ff", "data" => array(40, 50, 60, 70, 80),),
            );
            ?>
            <?= bar_graph_c3("cart_name_3", $array); ?>
        </div>

    </body>

</html>
