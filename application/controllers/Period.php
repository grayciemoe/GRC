<?php

class Period extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function period_calc($timestamp, $period = "annually") {

        list($_date, $_time) = explode(" ", $timestamp);
        list($year, $month, $date) = explode("-", $_date);

        $return = $timestamp;

        switch ($period) {
            case "annually" :
                $year++;
                while (!checkdate($month, $date, $year)) {
                    $date--;
                }
                $return = $year . "-" . $month . '-' . $date . ' ' . $_time;
                break;
            case "semi annually" :
                $month += 6;
                if ($month > 12) {
                    $month -= 12;
                    $year++;
                }
                while (!checkdate($month, $date, $year)) {
                    $date--;
                }
                $return = $year . "-" . $month . '-' . $date . ' ' . $_time;
                break;
            case "quarterly" :
                $month += 3;
                if ($month > 12) {
                    $month -= 12;
                    $year++;
                }
                while (!checkdate($month, $date, $year)) {
                    $date--;
                }
                $return = $year . "-" . $month . '-' . $date . ' ' . $_time;
                break;
            case "monthly" :
                $month += 1;
                if ($month > 12) {
                    $month -= 12;
                    $year++;
                }
                while (!checkdate($month, $date, $year)) {
                    $date--;
                }
                $return = $year . "-" . $month . '-' . $date . ' ' . $_time;
                break;
            case "weekly" :
                $return = strftime("%Y-%m-%d %H:%M:%S", (strtotime($timestamp) + (24 * 3600 * 7 )));
                break;
            case "daily" :
                $return = strftime("%Y-%m-%d %H:%M:%S", (strtotime($timestamp) + (24 * 3600 )));
                break;
            default:
                break;
        }

        return $return;
    }

}
