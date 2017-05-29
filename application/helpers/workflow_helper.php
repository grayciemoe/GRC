<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!function_exists('create_risk')) {

    function create_risk($item_id) {
        
    }

}


if (!function_exists('f_name')) {

    function f_name($item_id) {
        
    }

}
if (!function_exists('restricted_view')) {

    function restricted_view($title = "Restricted View", $message = "Sorry you do not have permission to access this page") {
        echo "<div class='container'><div class='card'><div class='card-block text-center'><h3 class='text-danger'>$title</h3><p>$message</p></div></div></div>";
    }

}


if (!function_exists('allow_action')) {

    function allow_action($method = NULL, $table_name = NULL, $record_id = 0) {
        $ci = & get_instance();

        return true;
    }

}

if (!function_exists('period_calc')) {

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

if (!function_exists('am_user_type')) {

    function am_user_type($user_types = false) {
        $am_user_type = $_SESSION[SESSION_INDEX]['GRC']['USER']['user_type'];
        if ($am_user_type == 1) {
            return true;
        }
        if (is_array($user_types)) {
            return (in_array($am_user_type, $user_types)) ? true : false;
        } else {
            return ($am_user_type == $user_types) ? true : false;
        }
    }

}

if (!function_exists('my_id')) {

    function my_id() {
        return $_SESSION[SESSION_INDEX]['GRC']['USER']['id'];
    }

}



    /*
     * if(am_user_type('1,5') or ($value['risk_woner'] == my_id()){
     * <a href="" >create risk</a>
     * }
     * 
     *  
     * 1 Administrator
     * 2 CEO
     * 3 Chairman
     * 4 Board
     * 5 Risk Manager
     * 6 Unit Owner
     * 7 Staff
     * 8 Auditor
     * 9 Corporate Admin
     * 10 Compliance Officer
     * 
     * 
     * */    