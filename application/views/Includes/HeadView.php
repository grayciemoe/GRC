<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="GRC eMomentum">
        <meta name="author" content="GRC">
        <!-- App Favicon -->
        <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon.png?v=dLBj3pRae6">
        <link rel="icon" type="image/png" href="/favicon-32x32.png?v=dLBj3pRae6" sizes="32x32">
        <link rel="icon" type="image/png" href="/favicon-16x16.png?v=dLBj3pRae6" sizes="16x16">
        <link rel="manifest" href="/manifest.json?v=dLBj3pRae6">
        <link rel="mask-icon" href="/safari-pinned-tab.svg?v=dLBj3pRae6" color="#5bbad5">
        <link rel="shortcut icon" href="/favicon.ico?v=dLBj3pRae6">
        <meta name="theme-color" content="#ffffff">
        <!-- App title -->
        <title><?= "GRC | " . SESSION_INDEX . " | ". str_replace(SESSION_INDEX, "", strip_tags($page_title)) ?></title>
        <!-- Switchery css -->
        <link rel="stylesheet" href="<?= base_url("assets/css/font.css") ?>">
        <link href="<?= base_url("assets/plugins/switchery/switchery.min.css") ?>" rel="stylesheet" />

        <link href="<?= base_url("assets/plugins/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css" />


        <!-- Treeview css -->
        <link href="<?= base_url("assets/plugins/jstree/style.css") ?>" rel="stylesheet" type="text/css" />


        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="<?= base_url("assets/plugins/morris/morris.css") ?>">

        <link href="<?= base_url("assets/plugins/c3/c3.min.css") ?>" rel="stylesheet">
        <link href="<?= base_url("assets/plugins/ion-rangeslider/ion.rangeSlider.css") ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= base_url("assets/plugins/ion-rangeslider/ion.rangeSlider.skinModern.css") ?>" rel="stylesheet" type="text/css"/>

        <link href="<?= base_url("assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css"); ?>" rel="stylesheet">
        <link href="<?= base_url("assets/plugins/datatables/dataTables.bootstrap4.min.css") ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url("assets/plugins/datatables/buttons.bootstrap4.min.css") ?>" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="<?= base_url("assets/plugins/datatables/responsive.bootstrap4.min.css") ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url("assets/plugins/c3/c3.min.css") ?>" rel="stylesheet">
        <link href="<?= base_url("assets/css/style.css") ?>" rel="stylesheet" type="text/css" />
        <!-- App CSS -->

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="<?= base_url("https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js") ?>"></script>
        <script src="<?= base_url("https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js") ?>"></script>
        <![endif]-->
        <!-- Modernizr js -->

        <link href="<?= base_url("assets/css/custom.css?var=10") ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url("assets/css/kinja.css") ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url("assets/css/kalekye.css") ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url("assets/css/grace.css") ?>" rel="stylesheet" type="text/css" />

        <script src="<?= base_url("assets/js/jquery.min.js") ?>"></script>
        <script src="<?= base_url("assets/js/bootstrap.min.js") ?>"></script> 
        <script src="<?= base_url("assets/js/modernizr.min.js") ?>"></script>         
        <!-- jQuery  -->
        <script src="<?= base_url("assets/js/tether.min.js") ?>"></script><!-- Tether for Bootstrap -->
        <script src="<?= base_url("assets/js/waves.js") ?>"></script>
        <script src="<?= base_url("assets/js/jquery.nicescroll.js") ?>"></script>
        <script src="<?= base_url("assets/plugins/switchery/switchery.min.js") ?>"></script>

        <script src="<?= base_url("assets/plugins/ckeditor/ckeditor.js") ?>"></script>

        <script src="<?= base_url("assets/plugins/jquery-ui/jquery-ui.min.js") ?>"></script>
        <script src="<?= base_url("assets/js/jquery.nicescroll.js") ?>"></script>
        <script src="<?= base_url("assets/plugins/d3/d3.min.js") ?>"></script>
        <script src="<?= base_url("assets/plugins/c3/c3.min.js") ?>"></script>

        <script src="<?= base_url("assets/plugins/ion-rangeslider/ion.rangeSlider.min.js") ?>"></script>
        <script src="<?= base_url("assets/plugins/moment/moment.js") ?>"></script>
        <script src="<?= base_url("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js") ?>"></script>
        
        <script src="<?= base_url("assets/plugins/jsPDF/dist/jspdf.min.js"); ?>"></script>
        <script src="<?= base_url("assets/plugins/jsPDF/dist/html2canvas.js"); ?>"></script>
        
        <!-- Required datatable js -->
        <script src="<?= base_url("assets/plugins/datatables/jquery.dataTables.min.js"); ?>"></script>
        <script src="<?= base_url("assets/plugins/datatables/dataTables.bootstrap4.min.js"); ?>"></script>
        <!-- Buttons examples -->
        <script src="<?= base_url("assets/plugins/datatables/dataTables.buttons.min.js"); ?>"></script>
        <script src="<?= base_url("assets/plugins/datatables/buttons.bootstrap4.min.js"); ?>"></script>
        <script src="<?= base_url("assets/plugins/datatables/jszip.min.js"); ?>"></script>
        <script src="<?= base_url("assets/plugins/datatables/pdfmake.min.js"); ?>"></script>
        <script src="<?= base_url("assets/plugins/datatables/vfs_fonts.js"); ?>"></script>
        <script src="<?= base_url("assets/plugins/datatables/buttons.html5.min.js"); ?>"></script>
        <script src="<?= base_url("assets/plugins/datatables/buttons.print.min.js"); ?>"></script>
        <script src="<?= base_url("assets/plugins/datatables/buttons.colVis.min.js"); ?>"></script>
        <!-- Responsive examples -->
        <script src="<?= base_url("assets/plugins/select2/js/select2.full.min.js"); ?>" type="text/javascript"></script>
        <!-- Tree view js -->
        <script src="<?= base_url("assets/plugins/jstree/jstree.min.js"); ?>"></script>
        <script src="<?= base_url("assets/pages/jquery.tree.js"); ?>"></script>
        <!--Morris Chart-->
        <script src="<?= base_url("assets/plugins/morris/morris.min.js") ?>"></script>
        <script src="<?= base_url("assets/plugins/raphael/raphael-min.js") ?>"></script>

        <script src="<?= base_url("assets/plugins/parsleyjs/parsley.min.js"); ?>"></script>

        


        <!--Form Wizard-->
        <script src="<?= base_url("assets/plugins/jquery.steps/build/jquery.steps.min.js"); ?>" type="text/javascript"></script>
        
        <!--wizard initialization-->


    </head>
    <body>