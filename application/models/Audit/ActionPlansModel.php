<?php

class ActionPlansModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "management_action_plan";
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

    function getAll($corpId) {
        if (!empty($corpId)) {
            $this->db->where("`draft` = 0 "
                    . "AND `delete` = 0 "
                    . "AND `corporate` = $corpId ");
            $this->db->order_by("id", "DESC");
            $array = $this->db->get($this->table)->result_array();
            foreach ($array as $key => $value) {
                $array[$key]['issue'] = $this->issue->get($value['issue']);
                $array[$key]['action_plan_owner'] = $this->user->get($value['action_plan_owner']);
            }
            return $array;
        } else {
            $this->db->where("`draft` = 0 "
                    . "AND `delete` = 0 ");
            $this->db->order_by("id", "DESC");
            $array = $this->db->get($this->table)->result_array();
            return $array;
        }
    }

    function getActionPlanByIssue($id) {
        $this->db->where("`issue` = $id "
                . "AND `draft` = 0 "
                . "AND `delete` = 0 ");
        $this->db->order_by("id", "DESC");
        $query = $this->db->get($this->table);
        $array = $query->result_array();
        foreach ($array as $key => $value) {
            $array[$key]['action_plan_owner'] = $this->user->get($value['action_plan_owner']);
        }
        return $array;
    }

    function edit($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        if ($key) {
            $data['draft'] = 0;
            if (isset($_FILES['attachments']) and count($_FILES['attachments']['name']) > 0) {
                $this->uploadModel->destination = array(
                    'module' => 'audit', 'table_name' => $this->table, 'record_id' => $key
                );
                $files = $this->uploadModel->uploadMultipleFiles('attachments');
            }
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

    function approveActionPlan($id, $status) {
        $data['approval_status'] = $status;
        if ($status == 'Yes') {
            $data['active_status'] = "Active";
            $data['implementation_status'] = "Outstanding";
        }
        $this->db->where("`id` =  $id");
        $this->db->update($this->table, $this->checkFields($data));
        $this->notification->managementActionPlanApprovalStatus($id);
    }

    function implementVerifyActionPlan($id, $status) {
        if ($status == "Implemented") {
            $data['implementation_status'] = $status;
            $data['verification_status'] = "Unverified";
            $this->db->where("`id` =  $id ");
            $this->db->update($this->table, $this->checkFields($data));
            $this->notification->managementActionPlanImplementationStatus($id);
        } elseif ($status == "Superseded") {
            $data['implementation_status'] = $status;
            $data['verification_status'] = "Unverified";
            $this->db->where("`id` =  $id ");
            $this->db->update($this->table, $this->checkFields($data));
            $this->notification->managementActionPlanImplementationStatus($id);
        } elseif ($status == "VerifyReject") {
            $data['implementation_status'] = "Outstanding";
            $data['verification_status'] = "";
            $data['superseded_reasons'] = "";
            $this->db->where("`id` =  $id ");
            $this->db->update($this->table, $this->checkFields($data));
            $this->notification->managementActionPlanUnverified($id);
        } else {
            $data['verification_status'] = $status;
            $data['active_status'] = "complete";
            $this->db->where("`id` =  $id ");
            $this->db->update($this->table, $this->checkFields($data));
            $this->notification->managementActionPlanVerified($id);
        }
    }

    function getAllCompleteActionPlansByIssue($id) {
        $this->db->where("`issue` = $id "
                . "AND `active_status` = 'Complete' ");
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    function getAllActiveActionPlansByIssue($id) {
        $this->db->where("`issue` = $id "
                . "AND `active_status` = 'Active' ");
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

}
