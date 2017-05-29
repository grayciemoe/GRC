<?php

class analysisModel extends CI_Model {

    public $table, $fields;
    public $analysis_key, $analysis_key_invert;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "risk_analysis";
        $this->fields = $this->setFields();
        $this->analysis_key = array(
            "impact" => array(
                "Undefined" => 0,
                "Insignificant" => 1,
                "Minor" => 2,
                "Moderate" => 3,
                "Major" => 4,
                "Catastrophic" => 5,
            ),
            "probability" => array(
                "Undefined" => 0,
                "Rare" => 1,
                "Unlikely" => 2,
                "Probable" => 3,
                "Likely" => 4,
                "Almost_Certain" => 5,
            ),
            "adequacy" => array(
                "Undefined" => 0,
                "Adequate" => 1,
                "Minor_Improvements" => 2,
                "Significant_Improvements" => 3,
                "Inadequate" => 4,
            ),
            "effectiveness" => array(
                "Undefined" => 0,
                "Satisfactory" => 1,
                "Minor_improvements" => 2,
                "Significant_Improvements" => 3,
                "Unsatisfactory" => 4,
            ),
            "gross_risk" => array(
                "Undefined" => 0,
                "Low" => 1,
                "Minimal" => 2,
                "Moderate" => 3,
                "High" => 4,
                "Severe" => 5,
            ),
            "control_ratings" => array(
                "Undefined" => 0,
                "Excellent" => 1,
                "Good" => 2,
                "Moderate" => 3,
                "Weak" => 4,
                "Poor" => 5,
            ),
            "net_risk" => array(
                "Undefined" => 0,
                "Low" => 1,
                "Minimal" => 2,
                "Moderate" => 3,
                "High" => 4,
                "Severe" => 5,
            ),
        );

        foreach ($this->analysis_key as $key => $value) {
            //sort($value);
            foreach ($value as $label => $val) {
                $this->analysis_key_invert[$key][$val] = $label;
            }
        }
    }

    function checkFields($data_array) {
        $return_array = array();
        foreach ($data_array as $key => $value) {
            if (in_array($key, $this->field_keys) and ! is_array($value)) {
                $return_array[$key] = $value;
            }
        }
        return $return_array;
    }

    function getRiskAnalysisTypes($risk_id) {
        $array = $this->db->query("select DISTINCT(type) from `risk_analysis` where risk = {$risk_id}")->result_array();
        $return = [];
        foreach ($array as $key => $value) {
            $return[] = $value['type'];
        }
        return $return;
    }

    function setFields() {
        $sql = "SHOW FIELDS FROM {$this->table}";
        $data_types = $this->db->query($sql)->result_array();
        foreach ($data_types as $key => $value) {
            $this->fields[$value['Field']] = $value['Default'];
            $this->field_keys[$value['Field']] = $value['Field'];
        }
        return $this->fields;
    }

    function add($data) {

        $check = $this->db->insert($this->table, $this->checkFields($data));
        if ($check) {
            $last = $this->last();
            $this->analyse($last['id']);
            return $last;
        } else {
            return false;
        }
    }

    function get($id) {
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function edit($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        if ($key) {
            $this->db->where("`id` =  $key");
            $check = $this->db->update($this->table, $this->checkFields($data));
            if ($check) {
                $this->notification->risk_analyze($data['risk']);
            }
        }
        return false;
    }

    function delete($id) {
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        return $this->db->delete($this->table);
    }

    function last() {
        $this->db->limit(1);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function getLastRiskAnalysis($risk_id) {
        $this->db->where("risk", $risk_id);
        $this->db->order_by("id", "DESC");
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $results = $query->row_array();
        if (count($results) == 0) {
            $fields = $this->fields;
            foreach ($fields as $key => $value) {
                $results[$key] = NULL;
            }
            $results['risk'] = $risk_id;
        }
        return $results;
    }

    function getALl() {
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        return $q->result_array();
    }

    function getRisk($risk_id) {
        $this->db->where("risk", $risk_id);
        $this->db->order_by("id", "DESC");
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    function toggleField($key, $column, $options = array(0, 1)) {
        /*
         * 
         * $key = A SPECIFIC RECORD ID IN DATABASE TO EDIT
         * $colum = THIS COLUMN TO TOGGLE
         * $options = an array such as $array("active","inactive") or (true , false) or (0,1)
         * 
         * e.g. toggleField(1,"column_name",array("opt_1","opt_2"));
         * 
         */
        $record = $this->get($key);
        $value = isset($record[$column]) ? $record[$column] : false;
        $new_value = ($value === $options[0]) ? $options[1] : $options[0];
        if (isset($record[$column])) {
            $this->edit(array("id" => $key, $column => $new_value));
            return $new_value;
        } else {
            return false;
        }
    }

    function getGossRisk($probability, $impact) {
        $product = $probability * $impact;
        if ($product == 0) {
            $return = 0;
        }
        if ($product <= 2) {
            $return = 1;
        }
        if ($product > 2 and $product < 8) {
            $return = 2;
        }
        if (($product < 10 and $product >= 8)) {
            $return = 3;
        }
        if ($product > 9 and $product < 20) {
            $return = 4;
        }
        if ($product >= 20) {
            $return = 5;
        }
        if ($product == 5) {
            $return = 3;
        }

        return $return;
    }

    function analyse($id) {
        $analysis = $this->get($id);
        $analysis['gross_risk'] = $this->getGossRisk($analysis['probability'], $analysis['impact']);
        $analysis['control_ratings'] = $this->getControlRatings($analysis['adequacy'], $analysis['effectiveness']);
        $analysis['net_risk'] = $this->getNetRisk($analysis['probability'], $analysis['impact'], $analysis['adequacy'], $analysis['effectiveness']);
        $this->edit($analysis);
        $data = array();
        foreach ($analysis as $key => $value) {
            if ($key != "user" and $key != "risk" and $key != "timestamp" and $key != "id") {
                $data[$key] = $value;
            }
        }
        $data['id'] = $analysis['risk'];

        $this->risk->edit($data);
    }

    function getControlRatings($adequacy, $effectiveness) {
        $product = $adequacy * $effectiveness;
        if ($product == 0) {
            return 0;
        }
        if ($product == 1) {
            return 1;
        }
        if ($product == 2) {
            return 2;
        }
        if ($product < 5 and $product > 2) {
            return 3;
        }
        if ($product < 10 and $product >= 5) {
            return 4;
        }
        if ($product >= 10) {
            return 5;
        }
    }

    function getNetRisk($probability, $impact, $adequacy, $effectiveness) {
        $gross_risk = $this->getGossRisk($probability, $impact);
        $pi = $probability * $impact;
        $multiple = 1;

//          echo "<br> PI  = " . $probability * $impact;
//          echo "<br> GROSS RISK = " . $gross_risk;
//
//          echo "<br>Adequacy" . $adequacy;
//          echo "<br>Adequacy * " . $adequacy * $multiple;
//
//          echo "<br>Effectiveness " . $effectiveness;
//          echo "<br>Effectiveness * " . $effectiveness * $multiple;
//
//          echo "<br>Control Ratings = " . $this->getControlRatings($adequacy, $effectiveness);
//          echo "<br>* Control Ratings = " . $this->getControlRatings($adequacy * $multiple, $effectiveness * $multiple);

        $control_rating = $this->getControlRatings(($adequacy * $multiple), ($effectiveness * $multiple));
        if ($control_rating > $gross_risk) {
            $control_rating = $gross_risk;
        }
        $product = $gross_risk * $control_rating;
        if ($product == 0) {
            $return = 0;
        }
        if ($product <= 2) {
            $return = 1;
        }
        if ($product > 2 and $product < 8) {
            $return = 2;
        }
        if (($product < 10 and $product >= 8)) {
            $return = 3;
        }
        if ($product > 9 and $product < 20) {
            $return = 4;
        }
        if ($product >= 20) {
            $return = 5;
        }
        if ($product == 5) {
            $return = 3;
        }
        return $return;
    }

}
