<?php

class AuditModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "audit";
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
//        print_pre($data);exit;
        if ($this->findMyDraft($data['corporate'])) {
            return $this->findMyDraft($data['corporate']);
        }
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

    function getAll($corpId = null) {
        if (!empty($corpId)) {
            $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `corporate` = $corpId ");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        foreach ($array as $key => $value) {
//            //$array[$key]['environment'] = jsonToArray($value['environment']);
//            print_pre(jsonToArray($value['environment']));
//                foreach (jsonToArray($value['environment']) as $key => $enve) {
//                    $value['environment'] = array();
//                    
//                    array_push($value['environment'], $this->environment->get($enve));
//                    print_pre($value['environment']);
////                    exit;
//                    
//                }
//            $array[$key]['environment'] = $this->environment->get($value['environment']);
            $array[$key]['auditor'] = $this->user->get($value['auditor']);
            $array[$key]['issues'] = $this->issue->getCountIssuesInAudit($value['id']);
        }
        return $array;
        }  else {
            $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 ");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        foreach ($array as $key => $value) {
//            //$array[$key]['environment'] = jsonToArray($value['environment']);
//            print_pre(jsonToArray($value['environment']));
//                foreach (jsonToArray($value['environment']) as $key => $enve) {
//                    $value['environment'] = array();
//                    
//                    array_push($value['environment'], $this->environment->get($enve));
//                    print_pre($value['environment']);
////                    exit;
//                    
//                }
//            $array[$key]['environment'] = $this->environment->get($value['environment']);
            $array[$key]['auditor'] = $this->user->get($value['auditor']);
            $array[$key]['issues'] = $this->issue->getCountIssuesInAudit($value['id']);
        }
        return $array;
        }
        
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

    function draft($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        if ($key) {
            $this->db->where("`id` =  $key");
            $this->db->update($this->table, $this->checkFields($data));
        }
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

    function publishAudit($data) {
        $id = $data['audit'];
        $reciepient = $data['reciepient'];
        $response = array('respond_by_date' => $data['respond_by_date']);
        $data['issues'] = $this->issue->getAllIssuesInAudit($id);
//        print_pre($data); exit;
        if (isset($data['respond_by_date']) && !empty($data['respond_by_date'])) {
            foreach ($data['issues'] as $key => $value) {
                $response = array('respond_by_date' => $data['respond_by_date'], 'published_management' => 1);
                $_record['issue'] = $value['id'];
                $_record['audit'] = $id;
                $_record['respond_by_date'] = $data['respond_by_date'];
//                print_pre($_record);
                $this->db->insert('response_due', $_record);

                $this->db->update('issue', $this->checkFields($response));
            }
        }
        $record = 'published_' . $reciepient;
        $info[$record] = 1;
        $this->db->where("`id` =  $id");

        return $this->db->update($this->table, $this->checkFields($info));
    }

    function publishAuditToBoard($id) {
        $info['published_board'] = 1;
        $this->notification->issuePublishedtoBoard($id);
        $this->db->where("`id` =  $id");
        
        return $this->db->update($this->table, $this->checkFields($info));
    }

    function getAuditCount($corpId) {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `corporate` = $corpId");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        $array = count($array);
        return $array;
    }

    function deletePreviousReport($id) {
        $data['delete'] = 1;
        $this->db->where("`audit` = $id");
        $this->db->update('audit_report', $this->checkFields($data));
    }

    function prepareReport($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        if ($key) {
            $info['draft'] = 0;
            $info["audit"] = $data['audit'];
            $info["details"] = json_encode($data);
            $me = $this->user->getMe();
            $info['user'] = $me['user']['id'];
            $this->db->where("`id` =  $key");
            return $this->db->update('audit_report', $info);
        }
        return false;
    }

    function pullLatestReportData($id, $audit) {
        $this->db->where("`id` = $id "
                . "AND `audit` = $audit "
                . "AND `delete` = 0 ");
        $query = $this->db->get('audit_report');
        return $query->row_array();
    }

    function pullLatestReportDataByAudit($id) {
        $this->db->where("`audit` = $id "
                . "AND `delete` = 0 "
                . "AND `draft` = 0 ");
        $this->db->order_by('id', "DESC");
        $this->db->limit(1);
        $query = $this->db->get('audit_report');
        return $query->row_array();
    }

    function getAuditAreaPerAuditCount($id) {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `audit_area` = $id");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        $array = count($array);
        return $array;
    }

    function AuditReportdraft($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        if ($key) {
            $info["audit"] = $data['audit'];
            $info["details"] = json_encode($data);
            $me = $this->user->getMe();
            $info['user'] = $me['user']['id'];
            $this->db->where("`id` =  $key");
            return $this->db->update('audit_report', $info);
        }
        return false;
    }

    function addAuditReport($data) {
        if ($this->findMyAuditReportDraft()) {
            return $this->findMyAuditReportDraft();
        }
        $info["audit"] = $data['audit'];
        $info["draft"] = $data['draft'];
        $info["details"] = json_encode($data);
        $me = $this->user->getMe();
        $info['user'] = $me['user']['id'];
        $check = $this->db->insert('audit_report', $info);
        if ($check) {
            return $this->lastAuditReport();
        } else {
            return false;
        }
    }

    function lastAuditReport() {
        $this->db->limit(1);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get('audit_report');
        return $query->row_array();
    }

    function findMyAuditReportDraft() {
        $this->db->where("draft", $this->user->getMyId());
        $this->db->limit(1);
        $draft = $this->db->get('audit_report');
        if ($draft->num_rows() == 1) {
            return $draft->row_array();
        } else {
            return false; //$draft->row_array();
        }
    }

    function findMyDraft($corpId) {
        $userId = $this->user->getMyId();
        $this->db->where("`draft` = $userId "
                . "AND `corporate` = $corpId ");
        $this->db->limit(1);
        $draft = $this->db->get($this->table);
        if ($draft->num_rows() == 1) {
            return $draft->row_array();
        } else {
            return false; //$draft->row_array();
        }
    }

}
