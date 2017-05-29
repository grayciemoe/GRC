<?php

class auditAreaModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "audit_area";
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
        $check = $this->db->insert($this->table, $this->checkFields($data));
        if ($check) {
            $last = $this->last();
            // $this->refCode($last['id']);
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
            $data['draft'] = 0;
            $this->db->where("`id` =  $key");
            $this->db->update($this->table, $this->checkFields($data));
            // $this->refCode($data['id']);
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

    function getAll($corpId = Null) {
        if (!empty($corpId)) {
            $this->db->where("`corporate` = $corpId ");
            $this->db->order_by("id", "DESC");
            $q = $this->db->get($this->table);
            $array = $q->result_array();
            foreach ($array as $key => $value) {
                $array[$key]['issue_count'] = $this->issue->getIssuesByAuditArea($value['id']);
                $array[$key]['audit_count'] = $this->AuditAreaCountInAudit($value['id']);
            }
            return $array;
        } else {
            $this->db->order_by("id", "DESC");
            $q = $this->db->get($this->table);
            $array = $q->result_array();
            foreach ($array as $key => $value) {
                $array[$key]['issue_count'] = $this->issue->getIssuesByAuditArea($value['id']);
                $array[$key]['audit_count'] = $this->AuditAreaCountInAudit($value['id']);
            }
            return $array;
        }
    }

    function AuditAreaCountInAudit($id) {
        $sql = "SELECT `audit_area` FROM audit WHERE `draft` = 0 AND `delete` = 0";
        $auditAreas = $this->db->query($sql)->result_array();
        foreach ($auditAreas as $key => $value) {
            if (!empty($value['audit_area'])) {
                $ARList[] = jsonToArray($value['audit_area']);
            }
        }
        if (isset($ARList)) {
            $haystack = $this->array_flatten($ARList);
            $haystack_count = array_count_values($haystack);
            if (in_array($id, $haystack)) {
                return $haystack_count[$id];
            }
        } else {
            $count = 0;
            return $count;
        }
    }

    function array_flatten($array) {
        if ((!is_array($array)) || (empty($array))) {
            return FALSE;
        }
        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->array_flatten($value));
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
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
