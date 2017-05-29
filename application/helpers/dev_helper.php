<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('objectToArray')) {
    function objectToArray($object) {
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        if (is_array($object)) {
            return array_map(__FUNCTION__, $object);
        } else {
            return $object;
        }
    }
}

if (!function_exists('jsonToArray')) {
    function jsonToArray($json) {
        return objectToArray(json_decode($json));
    }
}

if (!function_exists('print_pre')) {
    function print_pre($array) {
       echo "<pre>";
       print_r($array);
       echo "</pre>";
    }
}



