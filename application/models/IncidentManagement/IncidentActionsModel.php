<?php

class incidentActionsModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "incident_actions";
        $this->fields = $this->setFields();

        //$this->load->model("environment/environmentModel", "environment");
        //  //$this->load->model("risk/riskModel", "risk");
        //    //$this->load->model("risk/categoryModel", "category");
        //  //$this->load->model("compliance/breachModel", "breach");
        //  //$this->load->model("Compliance/ObligationModel", "obligation");
        //$this->load->model("Users/UserModel", "user");
        //$this->load->model("documents/documentsModel", "documents");
    }

    function getUser($user_id) {
        return $this->db->get_where($this->table, array("owner" => $user_id, "draft" => 0))->result_array();
    }

    function handover($from, $to) {
        $data['owner'] = $to;
        $this->db->where("owner", $from);
        $this->db->update($this->table, $data);
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

    function add($data) {
        $data = $this->checkFields($data);
        $check = $this->db->insert($this->table, $data);
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

    function getIncidentActions($id) {
        $this->db->where("draft=0");
        $this->db->where("incident", $id);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    function getIncidentState($im_id = 0) {
        $sql = "SELECT * FROM `{$this->table}` WHERE `incident` = $im_id ";
        $total = $this->db->query($sql)->num_rows();

        $sql = "SELECT * FROM `{$this->table}` WHERE `incident` = $im_id AND `status` = 'complete'";
        $complete = $this->db->query($sql)->num_rows();

        if ($total > 0) {
            $pec = ($complete / $total) * 100;
        } else {
            $pec = 0;
        }
        return (($total == $complete) and ( $total > 0)) ? "closed" : "open";
    }

    function edit($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        $record = $this->get($key);
        $data['draft'] = 0;
        if ($key) {
            $data = $this->checkFields($data);
            $this->db->where("`id` =  $key");
            $check = $this->db->update($this->table, $data);
            if ($record['draft'] != 0) {
                $this->notification->incident_action_add($key);
            } else {
                $this->notification->incident_action_edit($key);
            }
            return $check;
        }
        return false;
    }

    function delete($id) {
        //$this->notification->incident_action_delete($id);
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $this->db->delete($this->table);
    }

    function deleteIncident($id) {
        $this->db->where("incident", $id);
        return $this->db->delete($this->table);
    }

    function last() {
        $this->db->limit(1);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function getAll() {
        $this->db->where("draft=0");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $array = $q->result_array();
        foreach ($array as $key => $value) {
            $array[$key]["incident"] = $this->incident->get($value['incident']);
        }
        return $array;
    }

    function getIncidentActionsByOwner($owner) {
        $this->db->where("draft=0");
        $this->db->where("owner", $owner);
        $this->db->order_by("due_date", "ASC");
        $query = $this->db->get($this->table);
        $array = $query->result_array();

        foreach ($array as $key => $value) {
            $array[$key]["incident"] = $this->incident->get($value['incident']);
        }

        return $array;
    }

}
