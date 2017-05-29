<?php

class obligationComplyModel extends CI_Model {

    public $table, $fields, $risk_sources_initials;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "obligation_comply";
        $this->fields = $this->setFields();
        //$this->load->model("Users/UserModel", "user");
        //$this->load->model("documents/documentsModel", "documents");
        //$this->load->model("compliance/authorityModel", "authority");
        // //$this->load->model("environment/kraClipboardModel", "kraClip");
        //$this->load->model("compliance/complianceRequirementModel", "complianceRequirement");
        //$this->load->model("Compliance/ObligationModel", "obligation");
        //$this->load->model("uploadModel", "uploadModel");


        $this->risk_sources_initials = array(
            "best_practices" => "BP",
            "contract" => "CTT",
            "corporate_policy" => "CP",
            "laws_and_regulations" => "LR",
            "process" => "PS",
            "strategic_objectives" => "SO",
        );
        // authorityModel::
    }

    function checkFields($data_array) {
        $return_array = array();
        foreach ($data_array as $key => $value) {
            if ($key == 'id') {
                continue;
            }
            if (in_array($key, $this->field_keys) and ! is_array($value)) {
                $return_array[$key] = $value;
            }
        }

        if (isset($_FILES['attachments']) and count($_FILES['attachments']['name']) > 0) {
            $this->uploadModel->destination = array(
                'module' => 'compliance', 'table_name' => $this->table, 'record_id' => $data_array['id']
            );
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

    function refCode($id) {
        return false;
    }

    function add($data) {
        $me = $this->user->getMe();
        $data['user'] = $me['user']['id'];
        $check = $this->db->insert($this->table, $this->checkFields($data));
        if ($check) {
            $last = $this->last();
            // $this->refCode($last['id']);
            return $last;
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

    function edit($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        $record = $this->get($key);
        $data['draft'] = 0;
        $fields = $this->checkFields($data);
        $this->db->where("`id` =  $key");
        $data['updated'] = strftime("%Y-%m-%d %H:%M:%S");
        $check = $this->db->update($this->table, $fields);
        if ($check) {
            if ($record['draft'] != 0 and am_user_type(array(5))) {
                $data['approved'] = 'approved';
                $this->db->where("`id` =  $key");
                $this->db->update($this->table, $this->checkFields($data));
                //$this->notification->approve_compliance($key);
            } else if ($record['draft'] != 1) {
                $this->notification->approve_compliance($key);
            }
        }
        return $check;
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

    function getAll() {
        $me = $this->user->getMe();
        $my_id = isset($me['user']['id']) ? $me['user']['id'] : 0;
        $this->db->where("draft=0 AND delete=0 OR (user=$my_id)");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['obligation'] = $this->obligation->get($value['obligations']);
        }
        return $results;
    }

    function getComply($id) {
        $comply = $this->get($id);
        // $comply['attachments'] = $this->documents->fetchDocuments($comply['attachments']);
        $comply['obligation'] = $this->obligation->get($comply['obligations']);
        return $comply;
    }

    function getObligationPendingCompliantTotal($obligation_id) {
        $this->db->where("obligations", $obligation_id);
        $this->db->where("draft", 0);
        $this->db->where("approved", 'pending');

        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        return $q->num_rows();
    }

    function getComplyCompletion($completion) {
        $me = $this->user->getMe();
        $this->db->where("completion", $completion);
        $this->db->where("draft=0 AND delete=0");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['obligation'] = $this->obligation->get($value['obligations']);
        }
        return $results;
    }

    function create($obligation_id, $status = "yes") {
        $me = $this->user->getMe();
        $freq = array(
            'annually' => "Year",
            'semi annually' => "Half",
            'quarterly' => "Quarter",
            'monthly' => "Month",
            'weekly' => "Week",
            'daily' => "Day");

        $obligation = $this->obligation->get($obligation_id);
        $data['obligations'] = $obligation['id'];
        $data['user'] = $me['user']['id'];
        $data['draft'] = $me['user']['id'];
        $data['ref_code'] = $obligation['ref_code'];
        $data['completion'] = $status == "yes" ? "fully" : "partially";
        $data['title'] = $data['completion'] == "fully" ? "Complied To : " . $obligation['title'] . " : " . strftime("%b %d %Y", strtotime($obligation['submission_deadline'])) : "Partially Complied : " . $obligation['title'] . " : " . strftime("%b %d %Y", strtotime($obligation['submission_deadline']));
        $data['submission_deadline'] = $obligation['submission_deadline'];
        $data['period'] = $obligation['next_submission_period'];
        $data['period_name'] = $freq[$obligation['frequency']];
        $data['period_initials'] = substr($data['period_name'], 0, 1);
        $comply = $this->add($data);
        return $comply;
    }

    function convertBreachToComply($breach_id, $status = "yes", $comply_approve = false) {
        $breach = $this->breach->get($breach_id);
        $me = $this->user->getMe();
        $freq = array(
            'annually' => "Year",
            'semi annually' => "Half",
            'quarterly' => "Quarter",
            'monthly' => "Month",
            'weekly' => "Week",
            'daily' => "Day");

        $obligation = $this->obligation->get($breach['obligation']);
        $data['obligations'] = $obligation['id'];
        $data['user'] = $me['user']['id'];
        $data['draft'] = $comply_approve ? 0 : $me['user']['id'];
        $data['ref_code'] = $obligation['ref_code'];
        $data['completion'] = $status == "yes" ? "fully" : "partially";
        $data['title'] = $data['completion'] == "fully" ? "Complied To : " . $obligation['title'] . " : " . strftime("%b %d %Y", strtotime($breach['submission_deadline'])) : "Partially Complied : " . $obligation['title'] . " : " . strftime("%b %d %Y", strtotime($breach['submission_deadline']));
        $data['submission_deadline'] = $breach['submission_deadline'];
        $data['period'] = $breach['period'];
        $data['period_name'] = $breach['period_name'];
        $data['period_initials'] = $breach['period_initials'];
        if (am_user_type(array(5))) {
            $data['approved'] = "approved";
        }
        $comply = $this->add($data);
        unset($data);
        $data['id'] = $obligation['id'];
        $data['last_submission_status'] = 'complied';
        $this->obligation->edit($data);
        return $comply;
    }

    function exists($details) {
        $data['obligations'] = isset($details['obligations']) ? $details['obligations'] : NULL;
        $data['submission_deadline'] = isset($details['submission_deadline']) ? $details['submission_deadline'] : NULL;
        $this->db->where($data);
        $q = $this->db->get($this->table);
        return ($q->num_rows() === 0) ? false : true;
    }

    function getObligation($obligationId) {
        $this->db->order_by("id", "DESC");
        $this->db->where("obligations", $obligationId);
        $this->db->where("draft", 0);
        $this->db->where("delete", 0);


        $q = $this->db->get($this->table);
        $array = $q->result_array();
        foreach ($array as $key => $value) {
//            $array[$key]['files'] = $this->documents->fetchDocuments($value['attachments']);
        }
        return $array;
    }

    function getStatsData() {
        $results = $this->getAll();
        $return = array();
        foreach ($results as $key => $value) {

            $obligation = $this->obligation->get($value['obligations']);
            $value['authority'] = $obligation['authority'];
            $authority = $this->authority->get($value['authority']);
            $compliance_requirement = $this->complianceRequirement->get($obligation['compliance_requirement']);
            // $key_risk_area = $this->kraClip->getKRAclip($compliance_requirement['key_risk_area'], $compliance_requirement['risk_source']);
            if (!$compliance_requirement['key_risk_area']) {
                continue;
            }
            if (!$compliance_requirement['risk_source']) {
                continue;
            }
            if (!$value['authority']) {
                continue;
            }

            $environment = $this->environment->get($compliance_requirement['environment']);
            $responsible_manager_1 = $this->user->getUser($obligation['responsible_manager_1']);
            $responsible_manager_2 = $this->user->getUser($obligation['responsible_manager_2']);
            foreach ($value as $label => $val) {
                $return[$key]["comply:" . $label] = $val;
            }foreach ($obligation as $label => $val) {
                $return[$key]["obligation:" . $label] = $val;
            }
            foreach ($authority as $label => $val) {
                $return[$key]["authority:" . $label] = $val;
            }
            foreach ($compliance_requirement as $label => $val) {
                $return[$key]["compliance_requirement:" . $label] = $val;
            }
            foreach ($environment as $label => $val) {
                $return[$key]["environment:" . $label] = $val;
            }
            $return[$key]["risk_source:"] = $compliance_requirement['risk_source'];
            foreach ($key_risk_area as $label => $val) {
                $return[$key]["key_risk_area:" . $label] = $val;
            }
            foreach ($key_risk_area as $label => $val) {
                $return[$key]["key_risk_area:" . $label] = $val;
            }
            if (!$responsible_manager_1) {
                $responsible_manager_1 = array();
            }
            foreach ($responsible_manager_1 as $label => $val) {
                $return[$key]["responsible_manager_1:" . $label] = $val;
            }
            if (!$responsible_manager_2) {
                $responsible_manager_2 = array();
            }
            foreach ($responsible_manager_2 as $label => $val) {
                $return[$key]["responsible_manager_2:" . $label] = $val;
            }
        }
        return $return;
    }

    function getApprovedComplies() {
        $this->db->where("`approved` LIKE 'approved'");
        $query = $this->db->get($this->table);
        return $query->result_array();
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
        $this->db->where("(`approved` != 'approved') AND (`draft`=0 AND `delete` = 0)");
        $array = $this->db->get($this->table)->result_array();
        foreach ($array as $key => $value) {
            // $array[$key] = $this->enrichComplyArray($value);
        }
        return $array;
    }

}
