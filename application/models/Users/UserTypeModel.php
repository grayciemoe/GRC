<?php

class userTypeModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "user_type";
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

    function getObligationManager() {
        //    $user_types = 
        $this->db->where("obligation_manager", 1);
        $this->db->from($this->table);
        $this->db->join("user", "user.{$this->table} = {$this->table}.id");
        $query = $this->db->get();
        $array = $query->result_array();
        return $array;
    }

    function getComplianceOwners() {
        $this->db->where("compliance_owner", 1);
        $this->db->order_by("id", "DESC");
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    function getRiskOwners() {

        $this->db->where("risk_owner", 1);
        $this->db->order_by("id", "DESC");
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    function getEscalation() {
        $this->db->where("compliance_escalation", 1);
        $q = $this->db->get($this->table);
        $array = $q->result_array();
        $user_types = [];
        $users = [];

        foreach ($array as $key => $value) {
            $user_types[] = $this->user->getUserType($value['id']);
        }
        foreach ($user_types as $array) {
            foreach ($array as $key => $value) {
                $users[] = $value;
            }
        }
        return $users;
    }

    function getUsers($type_id) {
        
    }

    function add($data) {
        $check = $this->db->insert($this->table, $this->checkFields($data));
        if ($check) {
            return $this->last();
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
            return $this->db->update($this->table, $this->checkFields($data));
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

    function getALl() {
        $this->db->order_by("id", "ASC");
        $q = $this->db->get($this->table);
        return $q->result_array();
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
