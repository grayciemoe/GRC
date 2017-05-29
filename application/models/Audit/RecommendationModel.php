<?php

class RecommendationModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "recommendation";
        $this->fields = $this->setFields();
    }

//public $field_keys;
    function setFields() {
        $sql = "SHOW FIELDS FROM {$this->table}";
        $data_types = $this->db->query($sql)->result_array();
        foreach ($data_types as $key => $value) {
            $this->fields[$value['Field']] = $value['Default'];
            $this->field_keys[$value['Field']] = $value['Field'];
        }
        return $this->fields;
    }

    function checkFields($data_array) {
        $return_array = array();
        foreach ($data_array as $key => $value) {
            if (in_array($key, $this->field_keys) and ! is_array($value) and $key != 'id') {
                $return_array[$key] = $value;
            }
        }
        return $return_array;
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

    function get($id) {
        $this->db->where("`id` = $id ");
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function getAll() {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 ");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        return $array;
    }
    
    function getRecommendationByIssue($id) {
        $this->db->where("`issue` = $id "
                . "AND `draft` = 0 "
                . "AND `delete` = 0 ");
        $this->db->order_by("id", "DESC");
        $query = $this->db->get($this->table);
        return $query->result_array();
    }
    
    function getRecommendationByIssueCount($id) {
        $this->db->where("`issue` = $id "
                . "AND `draft` = 0 "
                . "AND `delete` = 0 ");
        $this->db->order_by("id", "DESC");
        $query = $this->db->get($this->table)->result_array();
        return count($query);
    }


    function edit($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        if ($key) {
            $data['draft'] = 0;
            $this->db->where("`id` =  $key");
            return $this->db->update($this->table, $this->checkFields($data));
        }
        return false;
    }
    
    function last() {
        $this->db->limit(1);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function delete($id) {
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $this->db->delete($this->table);
    }
}