<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!function_exists('heatmap_constants')) {

    function heatmap_constants($scale = "gross_risk", $index = false, $value = false) {
        return objectToArray(json_decode(HEAT_MAP));
    }

}
if (!function_exists('heatmap_key')) {

    function heatmap_key($scale = "gross_risk", $index = false, $value = false) {
        if(!$index) { }
        $array = objectToArray(json_decode(HEAT_MAP));
        if ($index) {
            return isset($array[$scale][$index]) ? $array[$scale][$index] : "Unknown";
        }
        if ($value and ! $index) {
            return isset($array[$scale][$value]);
        }
        //return "Unknown";
    }

}
if (!function_exists('invert_heatmap_keys')) {

    function invert_heatmap_keys() {
        $options = objectToArray(json_decode(HEAT_MAP));
        $array = [];
        foreach ($options as $key => $scale) {
            $array[$key] = [];
            foreach ($scale as $label => $value) {
                $array[$key][$value] = $label;
            }
        }
        return $array;
    }

}