<?php

class evaluationModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "risk_evaluation";
        $this->fields = $this->setFields();
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
        //$this->load->model("Users/UserModel", "user");
        $me = $this->user->getMe();
        $data['user'] = $me['user']['id'];

//        if ($data['target'] > 0) {
//            $data['deviation'] = (round(($data['current_level'] / $data['target']), 4)) * 100;
//        } else if ($data['tolerance_upper_limit'] > 0) {
//            $data['deviation'] = (round(($data['current_level'] / $data['tolerance_upper_limit']), 4)) * 100;
//        } else if ($data['appetite'] > 0) {
//            $data['deviation'] = (round(($data['current_level'] / $data['appetite']), 4)) * 100;
//        } else {
//            $data['deviation'] = $data['current_level'];
//        }
//        if (
//                ( $data['capacity'] < $data['appetite']) or 
//                ( $data['capacity'] < $data['target']) or
//                ( $data['capacity'] < $data['tolerance_upper_limit']) or 
//                ( $data['capacity'] < $data['tolerance_lower_limit']) or 
//                ( $data['capacity'] < $data['current_level'])
//                ) {
//            return "Incorrect value for evaluation capacity";
//        }

        $data['deviation'] = $data['current_level'];
        $check = $this->db->insert($this->table, $this->checkFields($data));
        if ($check) {
            $last = $this->last();
            $risk = array("id" => $last['risk'], "current_level" => $last['current_level'], "deviation" => $last['deviation']);
            $this->risk->edit($risk);
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

    function lastRiskEvaluation($risk_id) {
        $this->db->limit(1);
        $this->db->where("risk", $risk_id);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get($this->table);
        return $query->row_array();
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

}
