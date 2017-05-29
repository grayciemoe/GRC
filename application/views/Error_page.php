<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="GRC">
        <meta name="author" content="GRC">

        <!-- App Favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App title -->
        <title>GRC</title>


        <!-- App CSS -->
        <link href="<?= base_url("assets/css/style.css?v=100") ?>" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <!-- Modernizr js -->

    </head>


    <body>

        <!-- Navigation Bar-->
        <header id="topnav" style="background-color: #2b3d51;">

        </header>
        <!-- End Navigation Bar-->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="wrapper">

            <div class="ex-page-content text-xs-center">
                <div class="text-error" style="color: #000000;">G R C</div>
                <h1 class="text-black font-600">4<span class="ion-sad"></span>4</h1>
                <h3 class="text-uppercase text-black font-600">Page not Found</h3>
                <p class="text-black m-t-30">
                    It's looking like you may have taken a wrong turn. Don't worry... it happens to <br />
                    the best of us. You might want to check your internet connection. Here's a little tip that might <br />
                    help you get back on track. <br />
                    This page will refresh after <span id="timer"></span> seconds.
                </p>
                <br>
                <div class="btn-group">
                    <a class="btn btn-custom waves-effect waves-light" href="javascript:window.history.go(-2);"><i class="icon icon-arrow-left"></i> Go Back</a>
                    <a class="btn btn-custom waves-effect waves-light" href="<?= base_url(); ?>"><i class="icon icon-home"></i> Go Home</a>
                </div>

            </div>
        </div> <!-- End wrapper -->
        <script>
            var resizefunc = [];
            var count = 5;
            var counter = setInterval(timer, 1000); //1000 will  run it every 1 second

            function timer() {
                count = count - 1;
                if (count <= 0) {
                    clearInterval(counter);
                    window.location = "<?= base_url() ?>"
                    return;
                }
                document.getElementById("timer").innerHTML = count;

                //Do code for showing the number of seconds here
            }
        </script>

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/tether.min.js"></script><!-- Tether for Bootstrap -->
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/plugins/switchery/switchery.min.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

    </body>
</html>