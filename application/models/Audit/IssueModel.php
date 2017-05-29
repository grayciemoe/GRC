<?php

class IssueModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "issue";
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

    function getIssueDetail($id) {
        $this->db->where("`id` = $id ");
        $result = $this->db->get($this->table)->result_array();
        foreach ($result as $key => $value) {
            $result[$key]['audit_area'] = $this->auditArea->get($value['audit_area']);
            $result[$key]['issue_owner'] = $this->user->get($value['issue_owner']);
        }
        return $result;
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

    function getAll($corpId = null) {
        if (!empty($corpId)) {
            $this->db->where("`draft` = 0 "
                    . "AND `delete` = 0 "
                    . "AND `corporate` = $corpId ");
            $this->db->order_by("id", "DESC");
            $array = $this->db->get($this->table)->result_array();
            foreach ($array as $key => $value) {
                $array[$key]['audit'] = $this->audit->get($value['audit']);
                $array[$key]['audit_area'] = $this->auditArea->get($value['audit_area']);
                $array[$key]['issue_owner'] = $this->user->get($value['issue_owner']);
            }
            return $array;
        } else {
            $this->db->where("`draft` = 0 "
                    . "AND `delete` = 0 ");
            $this->db->order_by("id", "DESC");
            $array = $this->db->get($this->table)->result_array();
            foreach ($array as $key => $value) {
                $array[$key]['audit'] = $this->audit->get($value['audit']);
                $array[$key]['audit_area'] = $this->auditArea->get($value['audit_area']);
                $array[$key]['issue_owner'] = $this->user->get($value['issue_owner']);
            }
            return $array;
        }
    }

    function getAllIssuesInAudit($id) {
        $this->db->where(
                "`audit` = $id "
                . "AND `draft` = 0 "
                . "AND `delete` = 0 ");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        foreach ($array as $key => $value) {
            $array[$key]['audit'] = $this->audit->get($value['audit']);
            $array[$key]['audit_area'] = $this->auditArea->get($value['audit_area']);
            $array[$key]['issue_owner'] = $this->user->get($value['issue_owner']);
//            $data['risks'] = jsonToArray($array[$key]['risk_associated']);
//            foreach ($data['risks'] as $key => $value) {
//                $array[$key]['risk_associated'][] = $this->risk->get($value);
//            }
        }
        return $array;
    }

    function getAllIssuesInAuditArea($id) {
        $this->db->where(
                "`audit_area` = $id "
                . "AND `draft` = 0 "
                . "AND `delete` = 0 ");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        foreach ($array as $key => $value) {
            $array[$key]['audit'] = $this->audit->get($value['audit']);
            $array[$key]['audit_area'] = $this->auditArea->get($value['audit_area']);
            $array[$key]['issue_owner'] = $this->user->get($value['issue_owner']);
//            $data['risks'] = jsonToArray($array[$key]['risk_associated']);
//            foreach ($data['risks'] as $key => $value) {
//                $array[$key]['risk_associated'][] = $this->risk->get($value);
//            }
        }
        return $array;
    }

    function getCountIssuesInAudit($id) {
        $this->db->where(
                "`audit` = $id "
                . "AND `draft` = 0 "
                . "AND `delete` = 0 ");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        return count($array);
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

    function draft($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        if ($key) {
            $this->db->where("`id` =  $key");
            $this->db->update($this->table, $this->checkFields($data));
        }
    }

    function publishIssue($data) {
        $id = $data['issue'];
        $reciepient = $data['reciepient'];
        if ((isset($data['respond_by_date'])) && (!empty($data['respond_by_date']))) {
            $info['respond_by_date'] = $data['respond_by_date'];
            $response = array('issue' => $id, 'audit' => $data['audit'], 'respond_by_date' => $data['respond_by_date']);
            $this->db->insert('response_due', $response);
        }
        if ($reciepient == 'management'){
            $this->notification->issuePublishedtoManagement($id);
        }elseif($reciepient == 'ceo'){
            $this->notification->issuePublishedtoCEO($id);
        }
        $record = 'published_' . $reciepient;
        $info[$record] = 1;
        $this->db->where("`id` =  $id");

        return $this->db->update($this->table, $this->checkFields($info));
    }

    function publishIssueToReport($data) {
        $audit = $data['audit'];
        $data['all_issues'] = $this->getIssuestoPublishToBoard($audit);
//        print_pre($data); exit;
        foreach ($data['all_issues'] as $key => $value) {
            $id = $value['id'];
            $this->db->where("`audit` = $audit "
                    . "AND `id` = $id ");
            if (isset($data['issues']) && !empty($data['issues'])) {
                if (in_array($value['id'], $data['issues'])) {
                    $info['published_board'] = 1;
                    $this->db->update($this->table, $this->checkFields($info));
                } else {
                    $info['published_board'] = 0;
                    $this->db->update($this->table, $this->checkFields($info));
                }
            } else {
                $info['published_board'] = 0;
                $this->db->update($this->table, $this->checkFields($info));
            }
        }
    }

    function getIssueResponseDate($id) {
        $this->db->where("`issue` = $id "
                . "AND `recipient` = 'management' ");
        $this->db->limit(1);
        $query = $this->db->get('response_due');
        return $query->row_array();
    }

    function getCEOIssueResponseDate($id) {
        $this->db->where("`issue` = $id "
                . "AND `recipient` = 'ceo' ");
        $this->db->limit(1);
        $query = $this->db->get('response_due');
        return $query->row_array();
    }

    function getIssueCount($corpId) {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `corporate` = $corpId");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        $array = count($array);
        return $array;
    }

    function getIssueUnpublishedCount($corpId) {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `corporate` = $corpId "
                . "AND `published_management` = 0");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        $array = count($array);
        return $array;
    }

    function getIssuepublishedtoMgntCount($corpId) {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `corporate` = $corpId "
                . "AND `published_management` = 1");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        $array = count($array);
        return $array;
    }

    function getIssuepublishedtoCEOCount($corpId) {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `corporate` = $corpId "
                . "AND `published_ceo` = 1");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        $array = count($array);
        return $array;
    }

    function getIssuepublishedtoBoardCount($corpId) {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `corporate` = $corpId "
                . "AND `published_board` = 1");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        $array = count($array);
        return $array;
    }

    function getIssueOpenCount($corpId) {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `corporate` = $corpId "
                . "AND `issue_status` = 'Open'");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        $array = count($array);
        return $array;
    }

    function getIssueClosedCount($corpId) {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `corporate` = $corpId "
                . "AND `issue_status` = 'Closed'");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        $array = count($array);
        return $array;
    }

    function issueToggleStatus($id, $status) {
        $this->db->where("`id` = $id ");
        $data['issue_status'] = $status;
        return $this->db->update($this->table, $this->checkFields($data));
    }

    function getTopRisks() {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 ");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        $risks = array();
        foreach ($array as $key => $value) {
            array_push($risks, jsonToArray($value['risk_associated']));
        }
        $array['alex'] = $risks;
        return $array['alex'];
    }

    function getIssuesByAuditArea($id) {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `audit_area` = $id");
        $array = $this->db->get($this->table)->result_array();
        $array = count($array);
        return $array;
    }

    function getIssuestoPublishToBoard($id) {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `published_ceo` = 1 "
                . "AND `audit` = $id");
        $this->db->order_by("id", "DESC");
        $result = $this->db->get($this->table)->result_array();
        foreach ($result as $key => $value) {
            $result[$key]['audit_area'] = $this->auditArea->get($value['audit_area']);
        }
        return $result;
    }

    function getIssuesPublishedToBoard($id) {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `published_board` = 1 "
                . "AND `audit` = $id");
        $this->db->order_by("id", "DESC");
        $result = $this->db->get($this->table)->result_array();
        foreach ($result as $key => $value) {
            $result[$key]['audit_area'] = $this->auditArea->get($value['audit_area']);
        }
        return $result;
    }

    function getIssuesPublished($id, $reciepient) {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `published_{$reciepient}` = 0 "
                . "AND `audit` = $id");
        $this->db->order_by("id", "DESC");
        $result = $this->db->get($this->table)->result_array();
        return $result;
    }

    function getIssuesUnPublishedToGlobal($id, $reciepient) {

        if ($reciepient == 'management') {
            $this->db->where("`draft` = 0 "
                    . "AND `delete` = 0 "
                    . "AND `published_management` = 0 "
                    . "AND `published_ceo` = 0 "
                    . "AND `published_board` = 0 "
                    . "AND `audit` = $id");
            $this->db->order_by("id", "DESC");
            $result = $this->db->get($this->table)->result_array();
            foreach ($result as $key => $value) {
                $result[$key]['audit_area'] = $this->auditArea->get($value['audit_area']);
                $result[$key]['issue_owner'] = $this->user->get($value['issue_owner']);
            }
            return $result;
        } elseif ($reciepient == 'ceo') {
            $this->db->where("`draft` = 0 "
                    . "AND `delete` = 0 "
                    . "AND `published_management` = 1 "
                    . "AND `published_ceo` = 0 "
                    . "AND `published_board` = 0 "
                    . "AND `audit` = $id");
            $this->db->order_by("id", "DESC");
            $result = $this->db->get($this->table)->result_array();
            foreach ($result as $key => $value) {
                $result[$key]['audit_area'] = $this->auditArea->get($value['audit_area']);
                $result[$key]['issue_owner'] = $this->user->get($value['issue_owner']);
            }
            return $result;
        } else {
            $this->db->where("`draft` = 0 "
                    . "AND `delete` = 0 "
                    . "AND `published_management` = 1 "
                    . "AND `published_ceo` = 1 "
                    . "AND `published_board` = 0 "
                    . "AND `audit` = $id");
            $this->db->order_by("id", "DESC");
            $result = $this->db->get($this->table)->result_array();
            foreach ($result as $key => $value) {
                $result[$key]['audit_area'] = $this->auditArea->get($value['audit_area']);
                $result[$key]['issue_owner'] = $this->user->get($value['issue_owner']);
            }
            return $result;
        }
    }

    function getIssuesPublishedToGlobal($id, $reciepient) {

        if ($reciepient == 'management') {
            $this->db->where("`draft` = 0 "
                    . "AND `delete` = 0 "
                    . "AND `published_management` = 1 "
                    . "AND `published_ceo` = 0 "
                    . "AND `published_board` = 0 "
                    . "AND `audit` = $id");
            $this->db->order_by("id", "DESC");
            $result = $this->db->get($this->table)->result_array();
            return $result;
        } elseif ($reciepient == 'ceo') {
            $this->db->where("`draft` = 0 "
                    . "AND `delete` = 0 "
                    . "AND `published_management` = 1 "
                    . "AND `published_ceo` = 1 "
                    . "AND `published_board` = 0 "
                    . "AND `audit` = $id");
            $this->db->order_by("id", "DESC");
            $result = $this->db->get($this->table)->result_array();
            return $result;
        } else {
            $this->db->where("`draft` = 0 "
                    . "AND `delete` = 0 "
                    . "AND `published_management` = 1 "
                    . "AND `published_ceo` = 1 "
                    . "AND `published_board` = 1 "
                    . "AND `audit` = $id");
            $this->db->order_by("id", "DESC");
            $result = $this->db->get($this->table)->result_array();
            return $result;
        }
    }

    function PublishIssuesGlobal($data) {
        $reciepient = $data['reciepient'];
//        print_pre($data); exit;
        if ($reciepient == 'management') {
            if ((isset($data['respond_by_date'])) && (!empty($data['respond_by_date']))) {
                foreach ($data['issues'] as $key => $value) {
                    $response = array('issue' => $value, 'audit' => $data['audit'], 'respond_by_date' => $data['respond_by_date'], 'recipient' => $reciepient);
                    $this->db->insert('response_due', $response);
                    $record = 'published_' . $reciepient;
                    $info[$record] = 1;
                    $this->db->where("`id` =  $value");
                    $result = $this->db->update($this->table, $this->checkFields($info));
                }
            }
        } elseif ($reciepient == 'ceo') {
            if (!empty($data['respond_by_date'])) {
                foreach ($data['issues'] as $key => $value) {
                    $response = array('issue' => $value, 'audit' => $data['audit'], 'respond_by_date' => $data['respond_by_date'], 'recipient' => $reciepient);
                    
                    $this->db->insert('response_due', $response);
                    $record = 'published_' . $reciepient;
                    $info[$record] = 1;
                    $this->db->where("`id` =  $value ");

                    $result = $this->db->update($this->table, $this->checkFields($info));
                }
            } else {
                foreach ($data['issues'] as $key => $value) {
                    
                    $record = 'published_' . $reciepient;
                    $info[$record] = 1;
                    $this->db->where("`id` =  $value ");

                    $result = $this->db->update($this->table, $this->checkFields($info));
                }
            }
        } else {
            foreach ($data['issues'] as $key => $value) {
                $record = 'published_' . $reciepient;
                $info[$record] = 1;
                $this->db->where("`id` =  $value");

                $result = $this->db->update($this->table, $this->checkFields($info));
            }
        }
        return $result;
    }

    function getIssuesPublishedToBoardByAuditArea($id, $audit) {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `published_board` = 1 "
                . "AND `audit_area` = $id "
                . "AND `audit` = $audit ");
        $this->db->order_by("id", "DESC");
        $result = $this->db->get($this->table)->result_array();
        foreach ($result as $key => $value) {
            $result[$key]['audit_area'] = $this->auditArea->get($value['audit_area']);
            $result[$key]['issue_owner'] = $this->user->get($value['issue_owner']);
        }
        return $result;
    }

    function getIssuesPublishedToBoardByAudit($id) {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `published_board` = 1 "
                . "AND `audit` = $id ");
        $this->db->order_by("id", "DESC");
        $result = $this->db->get($this->table)->result_array();
//        foreach ($result as $key => $value) {
//                $result[$key]['audit_area'] = $this->auditArea->get($value['audit_area']);
//                $result[$key]['issue_owner'] = $this->user->get($value['issue_owner']);
//            }
        return $result;
    }

    function checkActionPlanStatus($id) {
        $complete = $this->action_plans->getAllCompleteActionPlansByIssue($id);
        $active = $this->action_plans->getAllActiveActionPlansByIssue($id);
        $complete_count = count($complete);
        $active_count = count($active);

        if ((!empty($complete)) && ($active_count = 0)) {
            $data['action_plan_status'] = 'Complete';
            $this->db->update($this->table, $this->checkFields($data));
        } else {
            $data['action_plan_status'] = 'Not Compete';
            $this->db->update($this->table, $this->checkFields($data));
        }
    }

    function getIssuesPublishedToBoardReport() {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `published_board` = 1 ");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        foreach ($array as $key => $value) {
            $array[$key]['audit'] = $this->audit->get($value['audit']);
            $array[$key]['audit_area'] = $this->auditArea->get($value['audit_area']);
            $array[$key]['issue_owner'] = $this->user->get($value['issue_owner']);
        }
        return $array;
    }
    
    function getIssuesPublishedToManagementandBelongToYou($corpId, $userId){
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `published_management` = 1 "
                . "AND `corporate` = $corpId "
                . "AND `issue_owner` = $userId");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        foreach ($array as $key => $value) {
            $array[$key]['audit'] = $this->audit->get($value['audit']);
            $array[$key]['audit_area'] = $this->auditArea->get($value['audit_area']);
            $array[$key]['issue_owner'] = $this->user->get($value['issue_owner']);
        }
        return $array;
    }
    
    function getIssuesPublishedToBoardandBelongToYouByAudit($userId, $audit) {
        $this->db->where("`draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `published_management` = 1 "
                . "AND `audit` = $audit "
                . "AND `issue_owner` = $userId");
        $this->db->order_by("id", "DESC");
        $array = $this->db->get($this->table)->result_array();
        foreach ($array as $key => $value) {
            $array[$key]['audit'] = $this->audit->get($value['audit']);
            $array[$key]['audit_area'] = $this->auditArea->get($value['audit_area']);
            $array[$key]['issue_owner'] = $this->user->get($value['issue_owner']);
        }
        return $array;
    }

    function postRiskIssue($data) {
        $issue = $data['issue'];
        $user = $data['user'];
        $sql = "SELECT * FROM `g_bridge` WHERE `table_1` LIKE 'issue' AND `record_1` = $issue";
        $existence = $this->db->query($sql)->result_array();
//        print_pre($existence);
//        print_pre($data);
//        exit;
        if (empty($existence)) {
            foreach ($data['risks'] as $key => $value) {
                $new_record = array('table_1' => 'issue', 'table_2' => 'risk', 'record_1' => $issue, 'record_2' => $value, 'user' => $user);
                $result = $this->db->insert('g_bridge', $new_record);
            }
        } else {
            $sql = "DELETE FROM `g_bridge` WHERE `table_1` LIKE 'issue' AND `record_1` = $issue";
            $this->db->query($sql);
            foreach ($data['risks'] as $key => $value) {
                $new_record = array('table_1' => 'issue', 'table_2' => 'risk', 'record_1' => $issue, 'record_2' => $value, 'user' => $user);
                $result = $this->db->insert('g_bridge', $new_record);
            }
        }
        return $result;
    }

}
