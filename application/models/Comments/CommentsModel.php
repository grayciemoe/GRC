<?php

class CommentsModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "g_comments";
        //$this->load->model("Users/UserModel", "user");
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

    function getAll() {
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $array = $q->result_array();

        foreach ($array as $key => $value) {
            $user = $this->user->getMe();
            $array[$key]['user'] = $user['user'];
        }

        return $array;
    }
    
    function getComment($id) {
        $this->db->order_by("id", "DESC");
        $me = $this->user->getMe();
        
        $this->db->where('id', $id);
        $q = $this->db->get($this->table);
        $results = $q->row_array();
        
        return $results;
    }

    function getComments($module = null, $table_name = null, $record_id = null, $parent_id = null) {
        $this->db->order_by("id", "DESC");
        $me = $this->user->getMe();
        $array = [];
        if ($module) {
            $array['module'] = $module;
        }
        if ($table_name) {
            $array['table_name'] = $table_name;
        }
        if ($record_id) {
            $array['record_id'] = $record_id;
        }
        if ($parent_id) {
            $array['parent_id'] = $parent_id;
        }
        if (count($array) == 0) {
            $array['user'] = $me['user']['id'];
        }
        $this->db->where($array);
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
            $user = $this->user->getUser($value['user']);
            $results[$key]['user'] = $user;
        }

        return $results;
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
