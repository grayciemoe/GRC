<?php

class registerModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "risk_register";
        $this->fields = $this->setFields();
        //$this->load->model("Users/UserModel", "user");
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
        $me = $this->user->getMe();
        $data['user'] = $me['user']['id'];
        $check = $this->db->insert($this->table, $this->checkFields($data));
        if ($check) {
            return $this->last();
        } else {
            return false;
        }
    }

    function addRegisterRisk($data) {
        $me = $this->user->getMe();
        $data['user'] = $me['user']['id'];
        $this->db->insert("register_risks", $data);
    }

    function get($id) {
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function edit($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        $data['draft'] = 0;
        if ($key) {
            $this->db->where("`id` =  $key");
            return $this->db->update($this->table, $this->checkFields($data));
        }
        return false;
    }

    function getRiskRegisters($risk_id) {
        $me = $this->user->getMe();
        $this->db->where("risk", $risk_id);
        $q = $this->db->get("register_risks");
        $array = $q->result_array();
        $results = array();
        foreach ($array as $value) {
            $register = $this->get($value[$this->table]);
            if (($register['published'] == 1 or
                    $register['user'] == $me['user']['id']) and ( $register['draft'] + $register['delete']) == 0) {
                $results[count($results)] = $register;
            }
        }
        return $results;
    }

    function delete($id) {
        $this->deleteRegisterRisks($id);
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $this->db->delete($this->table);
    }

    function deleteRegisterRisks($register) {
        return false;
        $this->db->where($this->table, $register);
        $this->db->delete("register_risks");
    }

    function deleteRiskRegisters($risk) {
        $this->db->where("risk", $risk);
        $this->db->delete("register_risks");
    }

    function last() {
        $this->db->limit(1);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function getAll() {
        $me = $this->user->getMe();
        $this->db->where("draft=0 AND delete=0 AND  (published=1 OR user={$me['user']['id']})");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['risks'] = $this->getRisks($value['id']);
        }
        return $results;
    }

    function getRegister($register_id) {
        $data['register'] = $this->get($register_id);
        $data['risks'] = $this->getRisks($register_id);
        return $data;
    }

    function getRisk($risk_id) {
        return [];
    }

    function getRiskRegistersIds($risk_id) {
        return [];
    }

    function getRisks($reg_id) {
        return [];
        $this->db->where($this->table, $reg_id);
        $q = $this->db->get("register_risks");
        $array = $q->result_array();
        $risks = array();
        foreach ($array as $key => $value) {
            $risks[count($risks)] = $this->risk->get($value['risk']);
        }
        return $risks;
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
