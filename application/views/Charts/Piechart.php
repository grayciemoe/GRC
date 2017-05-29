
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="<?= base_url("assets/plugins/c3/c3.min.css") ?>" rel="stylesheet">

        <title>Pie Chart Example</title>
        <script src="<?= base_url("assets/js/jquery.min.js") ?>"></script>
        <script src="<?= base_url("assets/js/jquery.nicescroll.js") ?>"></script>
        <script src="<?= base_url("assets/plugins/d3/d3.min.js") ?>"></script>
        <script src="<?= base_url("assets/plugins/c3/c3.min.js") ?>"></script>


    </head>

    <body>
        <?php
        $chart_id = "chart_name_variable_rules";
        $data = array(
            array("name" => "Item 1", "value" => rand(1, 100), "color" => "#108000"),
            array("name" => "Item 2", "value" => rand(1, 100), "color" => "#008010"),
            array("name" => "Item 3", "value" => rand(1, 100), "color" => "#008400"),
            array("name" => "Item 4", "value" => rand(1, 100), "color" => "#0080f0"),
            array("name" => "Item 5", "value" => rand(1, 100), "color" => "#f08000"),
        );
        ?>
        <?= pie_chart_cs($chart_id, $data) ?>

        <?php
        $chart_id = "chart_name_variable_rules_2";
        $data = array(
            array("name" => "Item 1", "value" => rand(1, 100), "color" => "#108000"),
            array("name" => "Item 2", "value" => rand(1, 100), "color" => "#008010"),
            array("name" => "Item 3", "value" => rand(1, 100), "color" => "#008400"),
            array("name" => "Item 4", "value" => rand(1, 100), "color" => "#0080f0"),
            array("name" => "Item 5", "value" => rand(1, 100), "color" => "#f08000"),
        );
        ?>
        <?= pie_chart_cs($chart_id, $data) ?>

        <?php
        $chart_id = "chart_name_variable_rules_3";
        $data = array(
            array("name" => "Item 1", "value" => rand(1, 100), "color" => "#108000"),
            array("name" => "Item 2", "value" => rand(1, 100), "color" => "#008010"),
            array("name" => "Item 3", "value" => rand(1, 100), "color" => "#008400"),
            array("name" => "Item 4", "value" => rand(1, 100), "color" => "#0080f0"),
            array("name" => "Item 5", "value" => rand(1, 100), "color" => "#f08000"),
        );
        ?>
        <?= pie_chart_cs($chart_id, $data) ?>


    </body>
</html>
