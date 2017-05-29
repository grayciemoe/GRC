<?php

defined('MODAL_LINK') OR define('MODAL_LINK', " data-toggle='modal' data-target='#uploan_modal' onclick='modalRequest(this.href);'"); // highest automatically-assigned error code
defined('MODAL_AJAX') OR define('MODAL_AJAX', " onclick='ajaxFileModal(this.href); return false;'"); // highest automatically-assigned error code
defined('AJAX_LINK') OR define('AJAX_LINK', " onclick='ajaxFileRequest(this); return false;'"); // highest automatically-assigned error code

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    defined('UPLOAD_BACKET') OR define('UPLOAD_BACKET', '');
    defined('UPLOAD_PATH') OR define('UPLOAD_PATH', 'assets/uploads/');
    defined('UPLOAD_FOLDER') OR define('UPLOAD_FOLDER', 'assets/uploads/');
    defined('UPLOAD_BASE_URL') OR define('UPLOAD_BASE_URL', '');
    defined('TRASH_FOLDER') OR define('TRASH_FOLDER', 'assets/trash/');
} else {
    defined('UPLOAD_BACKET') OR define('UPLOAD_BACKET', 'grc_uploads');
    defined('UPLOAD_PATH') OR define('UPLOAD_PATH', 'gs://grc_uploads/');
    defined('CDN_BUCKET') OR define('CDN_BUCKET', 'gs://grc_cdn/');
    defined('UPLOAD_FOLDER') OR define('UPLOAD_FOLDER', 'gs://grc_uploads/');
    defined('UPLOAD_BASE_URL') OR define('UPLOAD_BASE_URL', 'https://storage.googleapis.com/');
    defined('TRASH_FOLDER') OR define('TRASH_FOLDER', 'assets/trash/');
}
//defined('UPLOAD_BACKET') OR define('UPLOAD_BACKET', 'grc_uploads');
//defined('UPLOAD_PATH') OR define('UPLOAD_PATH', 'gs://grc_uploads/');
//defined('UPLOAD_FOLDER') OR define('UPLOAD_FOLDER', 'gs://grc_uploads/');
//defined('UPLOAD_BASE_URL') OR define('UPLOAD_BASE_URL', 'https://storage.googleapis.com/');
//defined('TRASH_FOLDER') OR define('TRASH_FOLDER', 'assets/trash/');

defined('TITLE_LENTH') OR define('TITLE_LENTH', 15);
defined('TRASH_FOLDER') OR define('TRASH_FOLDER', 'gs://grc_trash/');
defined('SESSION_INDEX') OR define('SESSION_INDEX', 'eMomentum');
defined('COPORATE_ID') OR define('COPORATE_ID', 1); // HAS TO CHANGE IN ACCORDANCE TO THE DATABASE
defined('COMPLIANCE_RISK_SOURCES') OR define('COMPLIANCE_RISK_SOURCES', 'best_practices,corporate_policy,laws_and_regulations'); // HAS TO CHANGE IN ACCORDANCE TO THE DATABASE

defined("SYS_mailtype") OR define('SYS_mailtype', 'html');
defined("SYS_protocol") OR define('SYS_protocol', 'smtp');
defined("SYS_smtp_host") OR define('SYS_smtp_host', 'ssl://smtp.gmail.com');
defined("SYS_smtp_port") OR define('SYS_smtp_port', 465);
defined("SYS_smtp_user") OR define('SYS_smtp_user', "grc@eastafricare.com");
defined("SYS_smtp_pass") OR define('SYS_smtp_pass', "k@r1bu12345!");
defined("SYS_charset") OR define('SYS_charset', 'iso-8859-1');

defined("HT_AMBER") OR define('HT_AMBER', "rgba(255,0,0,1.00)");
defined("HT_RED") OR define('HT_RED', "rgba(255,100,0,1.00)");
defined("HT_ORANGE") OR define('HT_ORANGE', "rgba(255,200,0,1.00)");
defined("HT_GREEN") OR define('HT_GREEN', "rgba(0,255,21,1.00)");
defined("HT_BLUE") OR define('HT_BLUE', "rgba(0,190,255.00)");

defined("HT_RED_FADE") OR define('HT_RED_FADE', "rgba(255,0,0,0.75)");
defined("HT_ORANGE_FADE") OR define('HT_ORANGE_FADE', "rgba(255,100,0,0.75)");
defined("HT_YELLOW_FADE") OR define('HT_YELLOW_FADE', "rgba(255,200,0,0.75)");
defined("HT_GREEN_FADE") OR define('HT_GREEN_FADE', "rgba(0,255,21,0.75)");
defined("HT_BLUE_FADE") OR define('HT_BLUE_FADE', "rgba(0,190,255,0.75)");

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | Display Debug backtrace
  |--------------------------------------------------------------------------
  |
  | If set to TRUE, a backtrace will be displayed along with php errors. If
  | error_reporting is disabled, the backtrace will not display, regardless
  | of this setting
  |
 */
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
defined('FILE_READ_MODE') OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') OR define('DIR_WRITE_MODE', 0755);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */
defined('FOPEN_READ') OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
  |--------------------------------------------------------------------------
  | Exit Status Codes
  |--------------------------------------------------------------------------
  |
  | Used to indicate the conditions under which the script is exit()ing.
  | While there is no universal standard for error codes, there are some
  | broad conventions.  Three such conventions are mentioned below, for
  | those who wish to make use of them.  The CodeIgniter defaults were
  | chosen for the least overlap with these conventions, while still
  | leaving room for others to be defined in future versions and user
  | applications.
  |
  | The three main conventions used for determining exit status codes
  | are as follows:
  |
  |    Standard C/C++ Library (stdlibc):
  |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
  |       (This link also contains other GNU-specific conventions)
  |    BSD sysexits.h:
  |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
  |    Bash scripting:
  |       http://tldp.org/LDP/abs/html/exitcodes.html
  |
 */
defined('EXIT_SUCCESS') OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

defined("HEAT_MAP") OR define("HEAT_MAP", json_encode($heatmap = array(
                    "net_risk" => array(
                        0 => "Undefined",
                        1 => "Low",
                        2 => "Minimal",
                        3 => "Moderate",
                        4 => "High",
                        5 => "Severe",
                    ), "gross_risk" => array(
                        0 => "Undefined",
                        1 => "Low",
                        2 => "Minimal",
                        3 => "Moderate",
                        4 => "High",
                        5 => "Severe",
                    ), "control_ratings" => array(
                        0 => "Undefined",
                        1 => "Excellent",
                        2 => "Good",
                        3 => "Moderate",
                        4 => "Weak",
                        5 => "Poor",
                    ), "probability" => array(
                        0 => "undefined",
                        1 => "rare",
                        2 => "unlikely",
                        3 => "probable",
                        4 => "likely",
                        5 => "almost certain"
                    ), "impact" => array(
                        0 => "undefined",
                        1 => "insignificant",
                        2 => "minor",
                        3 => "moderate",
                        4 => "major",
                        5 => "catastrophic"
                    ), "adequacy" => array(
                        0 => "undefined",
                        1 => "adequate",
                        2 => "minor improvements",
                        3 => "significant improvements",
                        4 => "inadequate",
                    ), "effectiveness" => array(
                        0 => "undefined",
                        1 => "satisfactory",
                        2 => "minor improvements",
                        3 => "significant improvements",
                        4 => "unsatisfactory",
                    ),
        )));

defined('UPLON_SCRIPTS') OR
        define('UPLON_SCRIPTS', json_encode(array("jquery-ui.min" => "assets/plugins/jquery-ui/jquery-ui.min.js",
            "moment" => "assets/plugins/moment/moment.js",
            "fullcalendar.min" => "assets/plugins/fullcalendar/dist/fullcalendar.min.js",
            "jquery.fullcalendar" => "assets/pages/jquery.fullcalendar.js",
            "toastr.min" => "assets/plugins/toastr/toastr.min.js",
            "jstree.min" => "assets/plugins/jstree/jstree.min.js",
            "jstree.min" => "assets/pages/jquery.tree.js",
            "jquery.raty-fa" => "assets/plugins/raty-fa/jquery.raty-fa.js",
            "jquery.rating" => "assets/pages/jquery.rating.js",
            "ion.rangeSlider.min" => "assets/plugins/ion-rangeslider/ion.rangeSlider.min.js",
            "jquery.ui-sliders" => "assets/pages/jquery.ui-sliders.js",
            "sweet-alert.min" => "assets/plugins/bootstrap-sweetalert/sweet-alert.min.js",
            "jquery.sweet-alert.init" => "assets/pages/jquery.sweet-alert.init.js",
            "hopscotch.min" => "assets/plugins/hopscotch/js/hopscotch.min.js",
            "jquery.waypoints" => "assets/plugins/waypoints/lib/jquery.waypoints.js",
            "jquery.counterup.min" => "assets/plugins/counterup/jquery.counterup.min.js",
            "morris.min" => "assets/plugins/morris/morris.min.js",
            "raphael-min" => "assets/plugins/raphael/raphael-min.js",
            "jquery.waypoints" => "assets/plugins/waypoints/lib/jquery.waypoints.js",
            "jquery.counterup.min" => "assets/plugins/counterup/jquery.counterup.min.js",
            "chartist.min" => "assets/plugins/chartist/dist/chartist.min.js",
            "chartist-plugin-tooltip.min" => "assets/plugins/chartist/dist/chartist-plugin-tooltip.min.js",
            "jquery.knob" => "assets/plugins/jquery-knob/jquery.knob.js",
            "bootstrap-tagsinput" => "assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js",
            "jquery.multi-select" => "assets/plugins/multiselect/js/jquery.multi-select.js",
            "jquery.quicksearch" => "assets/plugins/jquery-quicksearch/jquery.quicksearch.js",
            "select2.full.min" => "assets/plugins/select2/js/select2.full.min.js",
            "bootstrap-maxlength.min" => "assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js",
            "jquery.mockjax" => "assets/plugins/autocomplete/jquery.mockjax.js",
            "jquery.autocomplete.min" => "assets/plugins/autocomplete/jquery.autocomplete.min.js",
            "countries" => "assets/plugins/autocomplete/countries.js",
            "jquery.autocomplete.init" => "assets/pages/jquery.autocomplete.init.js",
            "jquery.formadvanced.init" => "assets/pages/jquery.formadvanced.init.js",
            "parsley.min" => "assets/plugins/parsleyjs/parsley.min.js",
            "moment" => "assets/plugins/moment/moment.js",
            "bootstrap-timepicker.min" => "assets/plugins/timepicker/bootstrap-timepicker.min.js",
            "bootstrap-colorpicker.min" => "assets/plugins/mjolnic-bootstrap-colorpicker/js/bootstrap-colorpicker.min.js",
            "bootstrap-datepicker.min" => "assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js",
            "bootstrap-clockpicker" => "assets/plugins/clockpicker/bootstrap-clockpicker.js",
            "daterangepicker" => "assets/plugins/bootstrap-daterangepicker/daterangepicker.js",
            "jquery.form-pickers.init" => "assets/pages/jquery.form-pickers.init.js",
            "jquery.filer.min" => "assets/plugins/jquery.filer/js/jquery.filer.min.js",
            "moment" => "assets/plugins/moment/moment.js",
            "bootstrap-editable.min" => "assets/plugins/x-editable/js/bootstrap-editable.min.js",
            "bootstrap-editable.min" => "assets/plugins/x-editable/js/bootstrap-editable.min.js",
            "jquery.xeditable" => "assets/pages/jquery.xeditable.js",
            "jquery.dataTables.min" => "assets/plugins/datatables/jquery.dataTables.min.js",
            "dataTables.bootstrap4.min" => "assets/plugins/datatables/dataTables.bootstrap4.min.js",
            "dataTables.buttons.min" => "assets/plugins/datatables/dataTables.buttons.min.js",
            "buttons.bootstrap4.min" => "assets/plugins/datatables/buttons.bootstrap4.min.js",
            "jszip.min" => "assets/plugins/datatables/jszip.min.js",
            "pdfmake.min" => "assets/plugins/datatables/pdfmake.min.js",
            "vfs_fonts" => "assets/plugins/datatables/vfs_fonts.js",
            "vfs_fonts" => "assets/plugins/datatables/vfs_fonts.js",
            "buttons.html5.min" => "assets/plugins/datatables/buttons.html5.min.js",
            "buttons.print.min" => "assets/plugins/datatables/buttons.print.min.js",
            "buttons.colVis.min" => "assets/plugins/datatables/buttons.colVis.min.js",
            "dataTables.responsive.min" => "assets/plugins/datatables/dataTables.responsive.min.js",
            "responsive.bootstrap4.min" => "assets/plugins/datatables/responsive.bootstrap4.min.js",
            "rwd-table.min" => "assets/plugins/RWD-Table-Patterns/js/rwd-table.min.js",
            "tablesaw" => "assets/plugins/tablesaw/dist/tablesaw.js",
            "tablesaw-init" => "assets/plugins/tablesaw/dist/tablesaw-init.js",
            "jquery.flot" => "assets/plugins/flot-chart/jquery.flot.js",
            "jquery.flot.time" => "assets/plugins/flot-chart/jquery.flot.time.js",
            "jquery.flot.tooltip.min" => "assets/plugins/flot-chart/jquery.flot.tooltip.min.js",
            "jquery.flot.resize" => "assets/plugins/flot-chart/jquery.flot.resize.js",
            "jquery.flot.pie" => "assets/plugins/flot-chart/jquery.flot.pie.js",
            "jquery.flot.selection" => "assets/plugins/flot-chart/jquery.flot.selection.js",
            "jquery.flot.stack" => "assets/plugins/flot-chart/jquery.flot.stack.js",
            "jquery.flot.crosshair" => "assets/plugins/flot-chart/jquery.flot.crosshair.js",
            "jquery.flot.axislabels" => "assets/plugins/flot-chart/jquery.flot.axislabels.js",
            "jquery.flot.init" => "assets/pages/jquery.flot.init.js",
            "morris.min" => "assets/plugins/morris/morris.min.js",
            "raphael-min" => "assets/plugins/raphael/raphael-min.js",
            "jquery.morris.init" => "assets/pages/jquery.morris.init.js",
            "chart.min" => "assets/plugins/chart.js/chart.min.js",
            "chartjs.init" => "assets/pages/chartjs.init.js",
            "jquery.peity.min" => "assets/plugins/peity/jquery.peity.min.js",
            "chartist.min" => "assets/plugins/chartist/dist/chartist.min.js",
            "chartist-plugin-tooltip.min" => "assets/plugins/chartist/dist/chartist-plugin-tooltip.min.js",
            "jquery.chartist.init" => "assets/pages/jquery.chartist.init.js",
            "d3.min" => "assets/plugins/d3/d3.min.js",
            "c3.min" => "assets/plugins/c3/c3.min.js",
            "jquery.c3-chart.init" => "assets/pages/jquery.c3-chart.init.js",
            "jquery.sparkline.min" => "assets/plugins/jquery-sparkline/jquery.sparkline.min.js",
            "jquery.charts-sparkline" => "assets/pages/jquery.charts-sparkline.js",
            "jquery.knob" => "assets/plugins/jquery-knob/jquery.knob.js",
            "isotope.pkgd.min" => "assets/plugins/isotope/js/isotope.pkgd.min.js",
            "jquery.magnific-popup.min" => "assets/plugins/magnific-popup/js/jquery.magnific-popup.min.js",
                        )
                )
);

