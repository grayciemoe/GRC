<?php

class auditCommentModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "audit_comments";
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
            $result = $this->last();
            $issue = $this->issue->get($result['issue']);
            if ($result['user_type'] == 8) {
                $this->notification->auditorCommentAdded($result['id']);
            } else {
                if ($issue['action_plan_required'] == 'no') {
                    $this->notification->managementCommentAdded($result['id']);
                }
            }

            return $check;
        }
    }

    function get($id) {
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function getIssueComment($id) {
        $this->db->where("`issue` = $id");
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get($this->table)->result_array();
        foreach ($query as $key => $value) {
            $query[$key]['user'] = $this->user->get($value['user']);
        }
        return $query;
    }

    function getAuditorIssueComment($id) {
        $this->db->where("`issue` = $id "
                . "AND `user_type` = 8 ");
        $this->db->limit(1);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function edit($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        if ($key) {
            $this->db->where("`id` =  $key");
            $this->db->update($this->table, $this->checkFields($data));
            if ($data['user_type'] == 8) {
                $this->notification->auditorCommentEdited($key);
            } else {
                $this->notification->managementCommentEdited($key);
            }
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
        return $this->db->delete($this->table);
    }

    function seekManagementCommentReminder() {
        $today = strftime("%Y-%m-%d", (time()));
        $sql = "SELECT * FROM `response_due` ORDER BY `id` DESC";
        $result = $this->db->query($sql)->result_array();
        
        foreach ($result as $key => $value) {
            $issueId = $value['issue'];
            $sql = "SELECT * FROM `audit_comments` WHERE `issue` = $issueId";
            $comments = $this->db->query($sql)->result_array();
            if ((($value['notified_once'] == 'no') || ($value['notified_twice'] == 'no') || ($value['notified_thrice'] == 'no')) && (empty($comments))) {
                $not_day = strftime("%Y-%m-%d", strtotime($value['respond_by_date']));
                $this->reminderUpdate($not_day, $issueId, $value['id']);
            }
            if (((strftime("%Y-%m-%d", strtotime($value['respond_by_date'])) < $today) && ($value['notified_overdue'] == 'no')) && (empty($comments))) {
                $not_day = strftime("%Y-%m-%d", strtotime($value['respond_by_date']));
                $this->overdueReminder($not_day, $issueId, $value['id']);
            }
        }
    }

    function reminderUpdate($day, $issueId, $id) {
        $sql = "SELECT * FROM `response_due` WHERE `id` = $id";
        $issueCommentRes = $this->db->query($sql)->row_array();
        $today = strftime("%Y-%m-%d", (time()));
        $tomorrow = strftime("%Y-%m-%d", (time() + (3600 * 24)));
        $twoDaysBefore = strftime("%Y-%m-%d", (time() + (7200 * 24)));
        if (($day == $twoDaysBefore) && ($issueCommentRes['notified_once'] == 'no')) {
            $this->notification->managementCommentReminder($issueId);
            $sql = "UPDATE `response_due` SET `notified_once` = 'yes' WHERE `response_due`.`id` = $id";
            $this->db->query($sql);
        } elseif (($day == $tomorrow) && ($issueCommentRes['notified_twice'] == 'no')) {
            $this->notification->managementCommentReminder($issueId);
            $sql = "UPDATE `response_due` SET `notified_twice` = 'yes', `notified_once` = 'yes'  WHERE `id` = $id";
            $this->db->query($sql);
        } elseif (($day == $today) && ($issueCommentRes['notified_thrice'] == 'no')) {
            $this->notification->managementCommentReminder($issueId);
            $sql = "UPDATE `response_due` SET `notified_thrice` = 'yes', `notified_twice` = 'yes', `notified_once` = 'yes' WHERE `id` = $id";
            $this->db->query($sql);
        }
    }

    function overdueReminder($day, $issueId, $id) {
        $today = strftime("%Y-%m-%d", (time()));
        if ($day < $today) {
            $this->notification->managementCommentOverdue($issueId);
            $sql = "UPDATE `response_due` SET `notified_overdue` = 'yes' WHERE `id` = $id";
            $this->db->query($sql);
        }
    }

}
