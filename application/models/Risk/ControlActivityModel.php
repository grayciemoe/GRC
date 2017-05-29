<?php

class controlActivityModel extends CI_Model {

    public $table, $fields, $me, $risk_sources_initials, $color_codes;
    public $field_keys;

    function __construct() {
        parent::__construct();
        //$this->load->model("Users/UserModel", "user");
        $this->me = $this->user->getMe();
        $this->table = "control_activity";
        $this->fields = $this->setFields();

        //$this->load->model("risk/registerModel", "register");
        // //$this->load->model("risk/categoryModel", "category");
        //$this->load->model("risk/riskModel", "risk");
        //$this->load->model("Users/UserModel", "user");
        //$this->load->model("risk/analysisModel", "analysis");
        //$this->load->model("risk/evaluationModel", "evaluation");
        //$this->load->model("risk/controlModel", "control");
        //  //$this->load->model("notification", "notification");
    }

    function getUser($user_id) {
        return $this->db->get_where($this->table, array("owner" => $user_id, "draft" => 0, "delete" => 0))->result_array();
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
        return $return_array;
    }

    function enrichRiskArray($array) {
        $array['owner'] = $this->user->get($array['owner']);
        $array['control'] = $this->control->get($array['control']);

        return $array;
    }

    function complete($control_activity_id) {
        $control_activity = $this->get($control_activity_id);
        $times = array(
            'annually' => 365.25,
            'semi_annually' => 182.6,
            'quarterly' => 91.3,
            'monthly' => 30.4,
            'weekly' => 7,
            'daily' => 1
        );
        $difference = $times[$control_activity['frequency_repeat']] * 24 * 3600;
        $next_review = $difference + time();
        echo time() . " -  " . $next_review;
        if ($control_activity['frequency'] == 'cyclical') {
            $data['id'] = $control_activity['id'];
            $data['last_review'] = strftime("%Y-%m-%d", time());
            $data['next_review'] = strftime("%Y-%m-%d", $next_review);
            $data['date_complete'] = strftime("%Y-%m-%d", time());
            $data['status'] = "incomplete";
        } else {
            $data['id'] = $control_activity['id'];
            $data['last_review'] = strftime("%Y-%m-%d", time());
            $data['next_review'] = null;
            $data['date_complete'] = strftime("%Y-%m-%d", time());
            $data['status'] = "complete";
        }
        $this->edit($data);
    }

    function getControlActivity($control_avtivity_id) {
        // $this->refCode($control_avtivity_id);
        $data['control_activity'] = $this->get($control_avtivity_id);
        $data['control_activity']['control'] = $this->control->get($data['control_activity']['control']);
        $data['control_activity']['control']['owner'] = $this->user->getUser($data['control_activity']['control']['owner']);
        $data['control_activity']['risk'] = $this->risk->getRisk($data['control_activity']['control']['risk']);
        $data['control_activity']['control']['risk'] = $data['control_activity']['risk'];
        //$data['control_activity']['environment'] = $this->environment->get($data['control_activity']['control']['risk']['environment']);
        $data['control_activity']['control']['risk']['environment'] = $data['control_activity']['control']['risk']['environment'];
        $data['control_activity']['owner'] = $this->user->getUser($data['control_activity']['owner']);
        //$data['control_activity']['user'] = $this->user->getUser($data['control_activity']['user']);
        $data['control_activity']['action_by'] = $this->user->get_actionBy($data['control_activity']['action_by']);
        return $data;
    }

    function getControl($control_id) {
        $where = "`delete`= 0 AND `draft` = 0 AND `control` = $control_id";
        $this->db->where($where);
        $this->db->order_by("id", "DESC");
        $query = $this->db->get($this->table);
        $array = $query->result_array();
        foreach ($array as $key => $value) {
            $array[$key]['user_owner'] = $this->user->getUser($value['owner']);
        }
        return $array;
    }

    function getRisk($risk_id) {
        $control = $this->control->get($risk_id);
        $risk = $this->risk->get($risk_id);
        $risk_controls = $this->control->getRisk($risk_id);
        $activities = [];
        foreach ($risk_controls as $key => $value) {
            $acts = $this->getControl($value['id']);
            foreach ($acts as $act) {
                $activities[] = $act;
            }
        }
        return $activities;
    }

    function getRiskSource($risk_source) {
        return [];
    }

    function getKeyRiskArea($key_risk_area) {
        return [];
    }

    function getEnvironment($environment_id) {
        return [];
    }

    function refCode($control_avtivity_id) {
        return false;
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
        $data['user'] = $this->me['user']['id'];
        $check = $this->db->insert($this->table, $this->checkFields($data));
        if ($check) {
            $last = $this->last();
            //$this->refCode($id);
            //$this->refCode($last['id']);

            return $last;
        } else {
            return false;
        }
    }

    function get($id) {
        //// $this->refCode($id);
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function edit($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        $record = $this->get($key);
        $data['draft'] = 0;
        if ($key) {
            $this->db->where("`id` =  $key");
            $check = $this->db->update($this->table, $this->checkFields($data));
            if ($record['draft'] != 0 and am_user_type(array(5))) {
                $this->auto_approve($key);
            }
            return $check;
        }
        return false;
    }

    function auto_approve($key) {
        $sql = "UPDATE `{$this->table}` SET `review_status` = 'approved' WHERE `id` = $key LIMIT 1";
        $this->db->query($sql);
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
        $this->db->where("delete = 0 AND draft=0");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $array = $q->result_array();

        foreach ($array as $key => $value) {
            $array[$key]['control'] = $this->control->get($value['control']);
            $array[$key]['risk_details'] = $this->risk->get($array[$key]['control']['risk']);
            $array[$key]['owner'] = $this->user->getUser($value['owner']);
        }
        return $array;
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

    function getUserControlActivities($user_id) {
        //$this->refCode($id);
        $this->db->where("delete = 0 AND draft=0 AND owner = $user_id");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        return $q->result_array();
    }

    function getInactive() {
        $this->db->where("(`review_status` != 'approved')");
        $this->db->where("draft", 0);
        $this->db->where("delete", 0);
        $array = $this->db->get($this->table)->result_array();
        foreach ($array as $key => $value) {
            $array[$key] = $this->enrichRiskArray($value);
        }
        return $array;
    }

}
