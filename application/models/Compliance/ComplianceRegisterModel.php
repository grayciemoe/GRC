<?php

class complianceRegisterModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "complaince_register";
        $this->fields = $this->setFields();
        //$this->load->model("Users/UserModel", "user");
        //$this->load->model("Compliance/ObligationModel", "obligation");
        //$this->load->model("compliance/complianceRequirementModel", "compliance");
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

    function getUser($user_id) {
        return $this->db->get_where($this->table, array("owner" => $user_id, "draft" => 0, "delete" => 0))->result_array();
    }

    function handover($from, $to) {
        $data['owner'] = $to;
        $this->db->where("owner", $from);
        $this->db->update($this->table, $data);
    }

    function draft($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        if ($key) {
            $this->db->where("`id` =  $key");
            $this->db->update($this->table, $this->checkFields($data));
            // $this->refCode($key);
        }
    }

    function findMyDraft() {
        $this->db->where("draft", $this->user->getMyId());
        $this->db->limit(1);
        $draft = $this->db->get($this->table);
        if ($draft->num_rows() == 1) {
            return $draft->row_array();
        } else {
            return false;
        }
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
        if ($this->findMyDraft()) {
            return $this->findMyDraft();
        }
        $me = $this->user->getMe();
        $data['user'] = $me['user']['id'];
        $data['owner'] = $data['user'];

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
        $register = $query->row_array();
        if ($register) {
            $register['register_owner'] = $this->user->get($register['owner']);
            return $register;
        }
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

    function getComplianceRegister($registerId) {
        if (!$registerId) {
            return false;
        }
        $data = $this->get($registerId);
        $data['compliance_requirements'] = $this->compliance->getComplianceRegister($registerId);
        $data['user'] = $this->user->getUser($data['user']);
        $data['owner'] = $this->user->getUser($data['owner']);
        $data['attachements'] = [];
        return $data;
    }

    function getAuthority($id) {
        return $this->get($id);
    }

    function delete($id) {
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $this->db->delete($this->table);
    }

    function last() {
        $this->db->limit(1);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function getAll() { // exit;
        $me = $this->user->getMe();
        $this->db->where("draft=0 AND delete=0 ");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['owner'] = $this->user->get($value['owner']);
            $results[$key]['register_owner'] = $results[$key]['owner'];
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
