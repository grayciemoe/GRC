<?php

class RiskRegisterModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "risk_register";
        $this->fields = $this->setFields();

        //$this->load->model("environment/environmentModel", "environment");
        //  //$this->load->model("risk/riskModel", "risk");
        //    //$this->load->model("risk/categoryModel", "category");
        //  //$this->load->model("compliance/breachModel", "breach");
        //  //$this->load->model("Compliance/ObligationModel", "obligation");
        //$this->load->model("Users/UserModel", "user");
        //$this->load->model("documents/documentsModel", "documents");
    }

    function checkFields($data_array) {
        $return_array = array();
        foreach ($data_array as $key => $value) {
            if (in_array($key, $this->field_keys) and ! is_array($value)) {
                $return_array[$key] = $value;
            }
        }
        if (isset($_FILES['attachments']) and count($_FILES['attachments']['name']) > 0) {
            $files = $this->uploadModel->uploadMultipleFiles('attachments');
            foreach ($files as $key => $value) {
                $return_array['attachments'] .= $value . "|";
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

    function last() {
        $this->db->limit(1);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function getAll() {
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        return $q->result_array();
    }

}
