<?php

class controlModel extends CI_Model {

    public $table, $fields, $risk_sources_initials, $color_codes;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "control";
        $this->fields = $this->setFields();
        //$this->load->model("risk/registerModel", "register");
        //$this->load->model("risk/categoryModel", "category");
        //$this->load->model("risk/controlCategoryModel", "controlCategory");
        //$this->load->model("risk/riskModel", "risk");
        //$this->load->model("Users/UserModel", "user");
        //$this->load->model("risk/analysisModel", "analysis");
        //$this->load->model("risk/controlActivityModel", "controlActivity");
        //$this->load->model("environment/environmentModel", "environment");
        //$this->load->model("risk/evaluationModel", "evaluation");
        //$this->load->model("risk/controlCategoriesModel", "evacontrolCategoriesluation");
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

    function setFields() {
        $sql = "SHOW FIELDS FROM {$this->table}";
        $data_types = $this->db->query($sql)->result_array();
        foreach ($data_types as $key => $value) {
            $this->fields[$value['Field']] = $value['Default'];
            $this->field_keys[$value['Field']] = $value['Field'];
        }
        return $this->fields;
    }

    function refCode($control_id) {
        return false;
    }

    function enrichRiskArray($array) {
        $array['owner'] = $this->user->get($array['owner']);
        $array['risk'] = $this->risk->get($array['risk']);

        return $array;
    }

    function getRisk($risk_id) {
        //$this->db->where("draft=0 AND delete=0 AND risk=$risk_id");
        $this->db->where(array("draft" => 0, "delete" => 0, "risk" => $risk_id));
        $this->db->order_by("id", "DESC");
        $query = $this->db->get($this->table);
        $array = $query->result_array();
        foreach ($array as $key => $value) {
            $array[$key]['risk_details'] = $this->risk->getRiskSummary($value['risk']);
            $array[$key]['owner'] = $this->user->getUser($value['owner']);
        }
        return $array;
    }

    function getRiskControlTypes($risk_id) {
        //$this->db->where("draft=0 AND delete=0 AND risk=$risk_id");
        $this->db->where(array("draft" => 0, "delete" => 0, "risk" => $risk_id));
        $this->db->order_by("id", "DESC");
        $query = $this->db->get($this->table);
        $array = $query->result_array();
        $return['proposed'] = [];
        $return['in place'] = [];
        foreach ($array as $key => $value) {
            $return[$value['type']][] = $value;
        }
        return $return;
    }

    function add($data) {
        $check = $this->db->insert($this->table, $this->checkFields($data));
        if ($check) {
            $last = $this->last();
            // $this->refCode($last['id']);
            return $last;
        } else {
            return false;
        }
    }

    function getControl($control_id) {
        // $this->refCode($control_id);
        $data['control'] = $this->get($control_id);

        $data['control']['activities'] = $this->controlActivity->getControl($data['control']['id']);
        $data['control']['control_category'] = $this->controlCategory->get($data['control']['control_categories']);
        $data['control']['control_categories'] = $data['control']['control_category'];
        $data['control']['risk'] = $this->risk->getRisk($data['control']['risk']);
        $data['control']['owner'] = $this->user->getUser($data['control']['owner']);
        $data['control']['repository'] = $data['control']['risk']['repository'];
        $repo_id = isset($data['control']['repository']['id']) ? $data['control']['repository']['id'] : 0;
        $data['control']['environment'] = $this->environment->get($repo_id);
        $data['control']['status'] = "Not Started";
        $data['control']['status_completion'] = 0;

        $complete = 0;
        $incomplete = 0;

        foreach ($data['control']['activities'] as $key => $value) {
            if ($value['status'] == 'complete') {
                $complete++;
            } else {
                $incomplete++;
            }
        }
        $sum = $complete + $incomplete;
        if (($sum) > 0 and $incomplete == 0) {
            $data['control']['status'] = "complete";
        } elseif ($sum > 0) {
            $data['control']['status'] = "incomplete";
        } else {
            $data['control']['status'] = "not started";
        }

        $data['control']['status_completion'] = ($sum) ? round((($complete / ($sum)) * 100), 2) : 0;

        $data['control']['can_see'] = [];
        $unique = [];
        $unique[] = $data['control']['owner']['id'];

        foreach ($data['control']['activities'] as $act) {
            if (in_array($act['owner'], $unique)) {
                continue;
            }
            $unique[] = $act['owner'];
        }

        $data['control']['can_see'] = $unique;

        return $data;
    }

    function get($id) {
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function edit($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        $record = $this->get($key);
        if ($key) {
            $data['draft'] = 0;
            if (am_user_type(array(5)) and $record['approval_status'] == 'pending' and ! isset($data['approval_status'])) {
                $data['approval_status'] = 'approved';
            }
            $this->db->where("`id` =  $key");
            $this->db->update($this->table, $this->checkFields($data));
            // $this->refCode($data['id']);
//            if (am_user_type(array(5))) {
//                $this->db->where("`id` =  $key");
//                $this->db->update($this->table, $this->checkFields($data));
//                //$this->notification->control_approved($key);
//            } else {
//                //$this->notification->control_propose($key);
//            }
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

    function getALl() {
        //return [];
        $this->db->order_by("id", "DESC");
        $this->db->where("delete", 0);
        $this->db->where("risk!=", 0);
        $this->db->where("draft", 0);

        $q = $this->db->get($this->table);
        $array = $q->result_array();
        foreach ($array as $key => $value) {
            $array[$key]['risk_details'] = $this->risk->getRiskSummary($value['risk']);
            $array[$key]['owner'] = $this->user->getUser($value['owner']);
            $array[$key]['control_categories'] = $this->controlCategory->get($value['control_categories']);
        }


        return $array;
    }

    function getUserControls($user_id) {
        $this->db->where("delete = 0 AND draft=0 AND owner = $user_id");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        return $q->result_array();
    }

    function getContorlControlCategory($control_category_id) {
        $this->db->where("control_categories", $control_category_id);
        $q = $this->db->get($this->table);
        return $q->result_array();
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

    function getInactive() {
        return [];
    }

    function getUnapprovedControls() {
        $this->db->where("(`approval_status` != 'approved')");
        $this->db->where("draft", 0);
        $this->db->where("delete", 0);
        $array = $this->db->get($this->table)->result_array();
        foreach ($array as $key => $value) {
            $array[$key] = $this->enrichRiskArray($value);
        }
        return $array;
    }

}
