<?php

class riskModel extends CI_Model {

    public $table, $fields, $risk_sources_initials, $color_codes;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "risk";
        $this->fields = $this->setFields();
    }

    function filter_risks($data) {
        
    }

    function riskUniqueRefCode($ref_code, $risk_id = 0) {
        $sql = "`heat_map_ref` = '$ref_code' AND `id` != $risk_id";
        $this->db->where($sql);
        return ($this->db->get($this->table)->num_rows() == 0) ? true : false;
    }

    function getUser($user_id) {
        return $this->db->get_where($this->table, array("risk_owner" => $user_id, "draft" => 0, "delete" => 0))->result_array();
    }

    function handover($from, $to) {
        $data['risk_owner'] = $to;
        $this->db->where("risk_owner", $from);
        $this->db->update($this->table, $data);
    }

    function checkFields($data_array) {
        $return_array = array();
        foreach ($data_array as $key => $value) {
            if (in_array($key, $this->field_keys) and ! is_array($value) and $key != 'id') {
                $return_array[$key] = $value;
            }
        }


        if (isset($_FILES['attachments']) and count($_FILES['attachments']['name']) > 0) {
            $this->uploadModel->destination = array(
                'module' => 'risk', 'table_name' => $this->table, 'record_id' => $data_array['id']
            );
            $files = $this->uploadModel->uploadMultipleFiles('attachments');
            foreach ($files as $key => $value) {
                $return_array['attachments'] .= $value . "|";
            }
        }
        return $return_array;
    }

    function proposeRiskFromIncident($riskName = "Suggested Name", $category_id) {
        $data['title'] = $riskName;
        $data['type'] = "proposed";
        $data['category'] = $category_id;
        $newRisk = $this->add($data);
        return $newRisk['id'];
    }

    function getCategory($category_id) {
        $this->db->where("category", $category_id);
        $q = $this->db->get($this->table);

        return $q->result_array();
    }

    function getRisk($risk_id = 0) {
        $risk = $this->get($risk_id);
        if (!$risk) {
            return false;
        }
        $risk['repository'] = $this->repository->getRepository($risk['repository']);
        $environment = isset($risk['repository']['environment']) ? $risk['repository']['environment'] : 0;
        $risk['environment'] = $this->environment->getEnvironment($environment);
        $risk['author'] = $this->user->getUser($risk['user']);
        $risk['user'] = $risk['author'];
        $risk['risk_owner'] = $this->user->getUser($risk['risk_owner']);
        $risk['analysis'] = $this->analysis->getRisk($risk['id']);
        $risk['evaluation'] = $this->evaluation->getRisk($risk['id']);
        $risk['controls'] = $this->control->getRisk($risk['id']);
        $risk['activities'] = $this->controlActivity->getRisk($risk['id']);
        $risk['category'] = $this->risk_category->get($risk['category']);
        $risk['incidents'] = $this->incident->getRisk($risk['id']);
        $risk['can_see'] = [];
        $unique = [];
        $unique[] = $risk['risk_owner']['id'];
        foreach ($risk['activities'] as $act) {
            if (in_array($act['user_owner']['id'], $unique)) {
                continue;
            }
            $unique[] = $act['user_owner']['id'];
        }

        foreach ($risk['controls'] as $act) {
            if (in_array($act['owner']['id'], $unique)) {
                continue;
            }
            $unique[] = $act['owner']['id'];
        }
        $risk['can_see'] = $unique;

        return $risk;
    }

    function draft($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        if ($key) {
            $this->db->where("`id` =  $key");
            $this->db->update($this->table, $this->checkFields($data));
        }
        return $this->get($key);
    }

    function getRiskSummary($risk_id) {
        $risk = $this->get($risk_id);
        if (count($risk) == 0) {
            return $risk;
        }

        $risk['repository'] = $this->repository->getRepository($risk['repository']);
        $ENV = isset($risk['repository']['environment']) ? $risk['repository']['environment'] : 0;
        $risk['user'] = $this->user->getUser($risk['user']);
        $risk['risk_owner'] = $this->user->getUser($risk['risk_owner']);
        $risk['environment'] = $this->environment->get($ENV);
        return $risk;
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
        if ($this->findMyDraft()) {
            return $this->findMyDraft();
        }
        $check = $this->db->insert($this->table, $this->checkFields($data));
        if ($check) {
            return $this->last();
        } else {
            return false;
        }
    }

    function findMyDraft() {
        $this->db->where("draft", $this->user->getMyId());
        $this->db->limit(1);
        $draft = $this->db->get($this->table);
        if ($draft->num_rows() == 1) {
            return $draft->row_array();
        } else {
            return false; //$draft->row_array();
        }
    }

    function get($id) {
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function refCode($risk_id) {
        return false;
    }

    function edit($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        $original = $this->get($key);
        $data['ref_code'] = NULL; // $this->refCode($key);
        $data['draft'] = 0;
        if (am_user_type(array(5)) and ( $original['approved'] == "Pending" or $original['approved'] == "Proposed") and ( !isset($data['approved']))) {
            $data['approved'] = 'Approved';
        }

        $check = false;
        if ($key) {
            $this->db->where("`id` = {$key}");
            $check = $this->db->update($this->table, $this->checkFields($data));
        }
        if ($check and $original['draft'] != 0) {
            if (am_user_type(array(5))) {
                if (isset($data['risk_owner']) and ( $original['risk_owner'] != $data['risk_owner'] or $original['draft'] != 0)) {
                    $this->notification->risk_assignment($key);
                }
            } else {
                $this->notification->risk_approval_request($key);
            }
            return $check;
        }
        return false;
    }

    function approve($key, $approve) {
        $options = array('Approved', 'Rejected');
        if (in_array($approve, $options)) {
            if ($approve == 'Approved') {
                $this->auto_approve($key);
            } else {
                $sql = "UPDATE `{$this->table}` SET `approved` = '$approve' WHERE `id` = $key";
                $this->db->query($sql);
                $this->notification->risk_assignment($key);
            }
        }
    }

    function auto_approve($key) {
        $sql = "UPDATE `{$this->table}` SET `approved` = 'Approved' WHERE `id` = $key";
        $this->db->query($sql);
        $this->notification->risk_assignment($key);
//$this->notification->obligation_approved($key);
    }

    function delete($id) {
        $this->db->where("`id` = {$id}");
        return $this->db->delete($this->table);
    }

    function last() {
        $this->db->limit(1);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function getALL() {
        $this->db->where("draft=0 AND delete=0");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
// $this->refCode($value['id']);
            $results[$key]['controls'] = $this->control->getRisk($value['id']);
        }
        return $results;
    }

    function getReport() {
        $this->db->where("draft=0 AND delete=0");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['registers'] = $this->register->getRiskRegisters($value['id']);
            $results[$key]['categories'] = $this->category->getRiskCategories($value['id']);
            $results[$key]['categories_list'] = array();
            $results[$key]['registers_list'] = array();
            foreach ($results[$key]['registers'] as $index => $record) {
                $results[$key]['registers_list'][count($results[$key]['registers_list'])] = $record['id'];
            }
            foreach ($results[$key]['categories'] as $index => $record) {
                $results[$key]['categories_list'][count($results[$key]['categories_list'])] = $record['id'];
            }
        }
        return $results;
    }

    function riskData() {
        $risks = $this->getAllRaw();
        foreach ($risks as $key => $value) {
            $risks[$key]['registers'] = $this->register->getRisk($value['id']);
            $risks[$key]['repository'] = $this->repository->get($value['repository']);
            $risks[$key]['environment'] = $this->environment->get($risks[$key]['repository']['environment']);
            $risks[$key]['category'] = $this->category->get($value['category']);
            $risks[$key]['analysis_types'] = $this->analysis->getRiskAnalysisTypes($value['id']);
        }
        return $risks;
    }

    function getAllRaw() {
        $this->db->where("draft=0 AND delete=0");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        return $results;
    }

    function getRepository($repo_id) {
        $this->db->where("draft=0 AND delete=0 AND repository=$repo_id");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        return $results;
    }

    function getRisksByEnvironment($id) {
        $repository = $this->repository->getEnvironment($id);
        $all_risks = [];
        foreach ($repository as $key => $value) {
            $array = $this->getRepository($value['id']);
            if (count($array) > 0) {
                $all_risks[] = $array;
            }
        }
        $risks = [];
        foreach ($all_risks as $array) {
            foreach ($array as $key => $value) {
                $risks[] = $value;
            }
        }
        return $risks;
    }

    function getEnvironment($environment_id) {
        return $this->getRisksBy(array("environment" => $environment_id));
    }

    function getRisksBy($array = array()) {
        if (!isset($array['draft'])) {
            $array['draft'] = 0;
        }
        if (!isset($array['delete'])) {
            $array['delete'] = 0;
        }
        if (!isset($array['approved'])) {
            $array["approved!="] = "Rejected";
        }
        $this->db->where($array);
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['controls'] = $this->control->getRisk($value['id']);
        }
        return $results;
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

    function getUserRisks($user_id) {
        $this->db->where("draft=0 AND delete=0 AND (user= $user_id OR risk_owner=$user_id)");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
//$results[$key]['controls'] = $this->control->getRisk($value['id']);
            $results[$key] = $this->enrichRiskArray($value);
        }
        return $results;
    }

    function init() {
        return 0;
    }

    function getStatistics($riskArray) {
        $stats = array(
            "gross_risk" => array("Severe" => $this->init(), "High" => $this->init(), "Moderate" => $this->init(), "Minimal" => $this->init(), "Low" => $this->init(), "Undefined" => $this->init()),
            "control_ratings" => array("Poor" => $this->init(), "Weak" => $this->init(), "Moderate" => $this->init(), "Good" => $this->init(), "Excellent" => $this->init(), "Undefined" => $this->init()),
            "net_risk" => array("Severe" => $this->init(), "High" => $this->init(), "Moderate" => $this->init(), "Minimal" => $this->init(), "Low" => $this->init(), "Undefined" => $this->init())
        );
        $index = array();
        foreach ($stats as $type => $group) {
            $count = 5;
            foreach ($group as $key => $value) {
                $index[$type][$count] = $key;
                $count--;
            }
        }
        foreach ($riskArray as $key => $value) {
            $stats['gross_risk'][$index['gross_risk'][$value['gross_risk']]] ++;
            $stats['net_risk'][$index['net_risk'][$value['net_risk']]] ++;
            $stats['control_ratings'][$index['control_ratings'][$value['control_ratings']]] ++;
        }
        return $stats;
    }

    function enrichRiskArray($array) {
        $array['repository'] = $this->repository->get($array['repository']);
        $array['environment'] = $this->environment->get($array['repository']['environment']);
        $array['risk_owner'] = $this->user->get($array['risk_owner']);
        $array['controls'] = $this->control->getRiskControlTypes($array['id']);
        $array['category'] = $this->category->get($array['category']);

        return $array;
    }

    function enrichRiskReportArray($array) {
        $array['repository'] = $this->repository->get($array['repository']);
        $array['environment'] = $this->environment->get($array['repository']['environment']);
        $array['risk_owner'] = $this->user->get($array['risk_owner']);
        $array['controls'] = $this->control->getRiskControlTypes($array['id']);
        $array['category'] = $this->category->getCategoryRoot($array['category']);

        return $array;
    }

    function getRiskReportData() {
        $this->db->where("draft", 0);
        $this->db->where("delete", 0);
        $array = ($this->db->get($this->table)->result_array());

        foreach ($array as $key => $value) {
            $array[$key] = $this->enrichRiskReportArray($value);
        }
        return $array;
    }

    function getInactive() {
        $this->db->where("(`approved` != 'approved') AND (`draft`=0 AND `delete` = 0)");
        $array = $this->db->get($this->table)->result_array();
        foreach ($array as $key => $value) {
            $array[$key] = $this->enrichRiskArray($value);
        }
        return $array;
    }

    function getUndefined() {
        $this->db->where("(`gross_risk` =0 OR `net_risk` = 0)AND (`draft`=0 AND `delete` = 0)");
        $array = $this->db->get($this->table)->result_array();
        foreach ($array as $key => $value) {
            $array[$key] = $this->enrichRiskArray($value);
        }

        return $array;
    }

    function getAllHighNetRisk() {
        $this->db->where("(`net_risk` > 3)AND (`draft`=0 AND `delete` = 0)");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        return $results;
    }
    
    //////////////Alex Code On Audit /////////////////
    function getProposedRisks() {
        $this->db->where("(`approved` = 'Proposed')AND (`draft`=0 AND `delete` = 0)");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        return $results;
    }
    
    function getApprovedRisks() {
        $this->db->where("(`approved` = 'Approved')AND (`draft`=0 AND `delete` = 0)");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        return $results;
    }
    
    function getCategoryApproved($category_id) {
        $this->db->where("(`approved` = 'Approved') AND (`category` = $category_id)");
        $q = $this->db->get($this->table);

        return $q->result_array();
    }
    
    function getCategoryProposed($category_id) {
        $this->db->where("`approved` = 'Proposed' AND `category` = $category_id");
        $q = $this->db->get($this->table);
        return $q->result_array();
    }
    function getrisktitlebyId($id) {
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $array = $query->row_array();
        return $array['title'];
    }
    
    function postIssues($data) {
        $id = $data['id'];
        $info['issue'] = $data['issue'];
        $this->db->where("`id` = $id");
        $q = $this->db->update($this->table, $info);
        return $q;
    }
    
    ///////////////////////////////////////////////

}
