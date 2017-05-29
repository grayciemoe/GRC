<?php

class documentsModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        //$this->load->model("Documents/uploadModel");
        //$this->load->model("Users/UserModel", "user");

        $this->table = "upload";
        $this->fields = $this->setFields();
    }

    function checkFields($data_array) {
        $return_array = array();
        foreach ($data_array as $key => $value) {
            if (in_array($key, $this->field_keys) and ! is_array($value)) {
                $return_array[$key] = $value;
            }
        }
        if (isset($_FILES['attachments']) and count($_FILES['attachments']['name']) > 0) {
            $files = $this->uploadModel->uploadMultipleFiles('attachments', 'document', 'upload');
            foreach ($files as $key => $value) {
                //$return_array['attachments'] .= $value . "|";
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

    function get($id) {
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        return $this->db->get($this->table)->row_array();
    }

    function getFiles($string) {
        $this->db->order_by("id", "DESC");
//        $this->db->where("`id` = $id"); $this->db->limit(1);
//        $this->db->limit(1);
//        $query = $this->db->get($this->table);
//        return $query->row_array();
    }

    function getFile($id) {
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function getAll() {
        $this->db->order_by("id", "DESC");
        $this->db->where("`table_name` != 'user'");
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    function getRecordDocuments($where) {
        //print_pre($where);
        $this->db->where($where); // where is an array 
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    function uploadFiles($data) {
        $this->checkFields($data);
    }

    function delete($id) {
        $file = $this->getFile($id);
        $filename = UPLOAD_FOLDER . $file['filename'];
        if (file_exists($filename) and $file['filename']) {
            //copy($filename, TRASH_FOLDER . $file['filename']);
            //unlink($filename);
        }
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $this->db->update($this->table, array("module" => NULL, "table_name" => NULL, "record_id" => NULL));
        // $this->db->delete($this->table);
    }

    function getMyDocuments() {
        $me = $this->user->getMe();
        return $this->getUserDocuments($me['user']['id']);
    }

    function sortDocuments($array) {
        //'user','environment','risk','compliance','incident_management','audit','document'
        $documents['all'] = [];
        $documents['environment'] = [];
        $documents['user'] = [];
        $documents['risk'] = [];
        $documents['compliance'] = [];
        $documents['incident_management'] = [];
        $documents['audit'] = [];
        $documents['document'] = [];
        foreach ($array as $key => $value) {
            $documents["all"][] = $value;
            $documents[$value['module']][] = $value;
        }
        return $documents;
    }

    function getUserDocuments($user) {
        $this->db->where("user", $user);
        $this->db->order_by("id", "DESC");
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    function copyFile($module = null, $table = null, $record_id = 0) {
        $this->db->where("module", $module);
        $this->db->where("table_name", $table);
        $this->db->where("record_id", $record_id);
        $query = $this->db->get($this->table);
        $record = $query->row();
        unset($record['id']);
        $this->db->insert($this->table, $record);
    }

    function edit($data) {
        if (isset($data['id'])) {
            $key = $data['id'];
        } else {
            return false;
        }
        $this->db->where("`id` =  $key");
        //  return $this->db->update($this->table, $this->checkFields($data));
    }

}
