<?php

class incidentManagementModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "incident_management";
        $this->fields = $this->setFields();

        //$this->load->model("environment/environmentModel", "environment");
        //$this->load->model("risk/riskModel", "risk");
        //$this->load->model("risk/categoryModel", "category");
        //$this->load->model("compliance/breachModel", "breach");
        //$this->load->model("Compliance/ObligationModel", "obligation");
        //$this->load->model("Users/UserModel", "user");
        //$this->load->model("documents/documentsModel", "documents");
        //$this->load->model("IncidentManagement/incidentCategoryModel", "incidentCategory");
        //$this->load->model("IncidentManagement/incidentActionsModel", "incidentActions");
    }

    function getUser($user_id) {
        return $this->db->get_where($this->table, "(`incident_owner` = $user_id OR `responsible_manager` = $user_id) AND `draft` = 0 AND `delete` = 0")->result_array();
    }

    function handover_incident_owner($from, $to) {
        $data['incident_owner'] = $to;
        $this->db->where("incident_owner", $from);
        $this->db->update($this->table, $data);
    }

    function handover_responsible_manager($from, $to) {
        $data['responsible_manager'] = $to;
        $this->db->where("responsible_manager", $from);
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
                'module' => 'incident_management', 'table_name' => $this->table, 'record_id' => $data_array['id']
            );
            $files = $this->uploadModel->uploadMultipleFiles('attachments');
            foreach ($files as $key => $value) {
                $return_array['attachments'] .= $value . "|";
            }
        }
        return $return_array;
    }

    function getEnvironment($unit_id) {
        if ($unit_id == 1) {
            $this->db->where("draft=0 and delete=0 ");
            $this->db->order_by("id", "DESC");
            return $this->db->get($this->table)->result_array();
        } else {
            $this->db->where("draft=0 and delete=0 and environment=$unit_id");
            $this->db->order_by("id", "DESC");
            return $this->db->get($this->table)->result_array();
        }
    }

    function getMaxTotalCost() {
        $sql = "SELECT MAX(total_cost) AS `total` FROM `$this->table` ";
        $array = ($this->db->query($sql)->row_array());
        return $array['total'];
    }

    function draft($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        if ($key) {
            $this->db->where("`id` =  $key");
            $this->db->update($this->table, $this->checkFields($data));
//           // $this->refCode($key);
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

        if ($this->findMyDraft() and ! isset($data['breach'])) {

            return $this->findMyDraft();
        }
        $data['user'] = $this->user->getMyId();
        $data = $this->checkFields($data);
        $check = $this->db->insert($this->table, $data);
        if ($check) {
            return $this->last();
        } else {
            return false;
        }
    }

    function get($id) {
        //$this->db->where("draft=0");
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $array = $query->row_array();
        if (count($array) > 1) {
            $array["incident"] = $this->incidentActions->getIncidentState($id);
        }
        return $array;
    }

    function getIncidentReport($id) {
        $data = $this->get($id);
        $data['environment_tree'] = $this->environment->getTree($data['environment']);
        $data['environment'] = $this->environment->getUnit($data['environment']);
        $data['risk'] = $this->risk->getRisk($data['risk']);
        $data['evaluate_risk'] = false;
        if (isset($data['risk']['evaluation']) and count($data['risk']['evaluation']) == 0) {
            $data['evaluate_risk'] = true;
        } else if (isset($data['risk']['evaluation']) and count($data['risk']['evaluation']) > 0) {
            $last = $data['risk']['evaluation'][count($data['risk']['evaluation']) - 1];
            if (strtotime($last['time']) < strtotime($data['created'])) {
                $data['evaluate_risk'] = true;
            } else {
                $data['evaluate_risk'] = false;
            }
        }
        $data['risk_category'] = $this->risk_category->get($data['risk_category']);
        $data['breach'] = $this->breach->getBreach($data['breach']);
        $data['user'] = $this->user->get($data['user']);
        $data['responsible_manager'] = $this->user->get($data['responsible_manager']);
        //$data['attachments'] = $this->documents->fetchDocuments($data['attachments']);
        return $data;
    }

    function getCategoryIncidents($category_id) {
        $this->db->where(array("risk_level" => "Risk Category", "risk_category" => $category_id));
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $array = $q->result_array();
        foreach ($array as $key => $value) {
            $array[$key]["incident"] = $this->incidentActions->getIncidentState($value['id']);
        }
        return $array;
    }

    function getRisk($risk_id) {
        $this->db->where("risk", $risk_id);
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $array = $q->result_array();
        foreach ($array as $key => $value) {
            $array[$key]["incident"] = $this->incidentActions->getIncidentState($value['id']);
        }
//        print_pre($array); exit;
        return $array;

        /// return $q->result_array();
    }

    function delete($id) {
        $this->notification->incident_delete($id);
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $this->db->delete($this->table);
        $this->incidentActions->deleteIncident($id);
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
        //return $q->result_array();
        $array = $q->result_array();
        foreach ($array as $key => $value) {
            $array[$key]["incident"] = $this->incidentActions->getIncidentState($value['id']);
        }
        return $array;
    }

    function getIncidents() {
        $this->db->where("draft=0");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $array = $q->result_array();
        foreach ($array as $key => $value) {
            $array[$key]["incident"] = $this->incidentActions->getIncidentState($value['id']);
            $array[$key]['risk'] = $this->risk->get($value['risk']);
            $array[$key]['category'] = $this->incidentCategory->getCategoryById($value['category']);
            $array[$key]['environment'] = $this->environment->get($value['environment']);
            $array[$key]['responsible_manager'] = $this->user->get($value['responsible_manager']);
            $array[$key]['risk_category'] = $this->category->get($value['risk_category']);
        }
//        print_pre($array); exit;
        return $array;
    }

    function getAllIncidents() {

        $this->db->where("draft=0");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $array = $q->result_array();
        foreach ($array as $key => $value) {
            $array[$key]["incident"] = $this->incident->getIncidentState($value['state']);
        }
        return $array;
    }

    function getAllIncidentsWithTotalLoss() {
        $this->db->where("(`total_cost` > 0) AND draft=0");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $array = $q->result_array();
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

    function edit($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        $record = $this->get($key);

        if ($key) {
            $this->db->where("`id` = $key");
            $this->db->limit(1);
            $data['draft'] = 0;
            $check = $this->db->update($this->table, $this->checkFields($data));
            if (am_user_type(array(5)) and ! isset($data['approved']) and $record['draft'] != 0) {
                $this->auto_approve($key);
            }
            return $check;
        }
        return false;
    }

    function auto_approve($key) {
        $sql = "UPDATE `{$this->table}` SET `approved` = 'approved' WHERE `id` = $key LIMIT 1";
        $this->db->query($sql);
        //$this->notification->obligation_approved($key);
    }

    //Filter
    function incidentData() {

        $incidents = $this->getAll();

        return $incidents;
    }

    //Filter
    function incidentDataByDate($filter_date, $start_date, $end_date) {
        $sql = "SELECT * FROM  `incident_management` WHERE "
                . "\n (`$filter_date`  BETWEEN '$start_date' AND '$end_date') AND  "
                . "\n `draft`=0 AND `delete`=0 ";

        //echo print_pre($sql);
        $incidents = $this->db->query($sql)->result_array();
        //$incidents = $q->result_array();
//            $array = $q->result_array();
//        foreach ($array as $key => $value) {
//            $array[$key]["incident"] = $this->incidentActions->getIncidentState($value['id']);
//        }
//        return $array;
//    
        foreach ($incidents as $key => $value) {
            $incidents[$key]["incident"] = $this->incidentActions->getIncidentState($value['id']);
            $incidents[$key]['risk'] = $this->risk->getRisk($value['risk']);
            $incidents[$key]['category'] = $this->incidentCategory->getCategoryById($value['category']);
            $incidents[$key]['environment'] = $this->environment->get($value['environment']);
            $incidents[$key]['responsible_manager'] = $this->user->get($value['responsible_manager']);
            $incidents[$key]['risk_category'] = $this->category->get($value['risk_category']);
        }
        return $incidents;
    }

    function getAllRaw() {
        $this->db->where("draft=0 AND delete=0");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $array = $q->result_array();
        foreach ($array as $key => $value) {
            $array[$key]["incident"] = $this->incidentActions->getIncidentState($value['id']);
        }
        return $array;
    }

    function getCategory($c_id) {
        $this->db->where("draft=0 AND delete=0 AND category=$c_id");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $array = $q->result_array();
        foreach ($array as $key => $value) {
            $array[$key]["incident"] = $this->incidentActions->getIncidentState($value['id']);
        }
        return $array;
    }

    function getAllIncidentsRisks() {
        $array = $this->db->query("SELECT DISTINCT `risk` FROM `{$this->table}`;")->result_array();
        $risks = [];

        foreach ($array as $key => $value) {
            if (!$value['risk']) {
                continue;
            }
            $risk = $this->risk->get($value['risk']);
            if (count($risk) == 0) {
                continue;
            }
            $risks[] = $this->risk->get($value['risk']);
        }
//         print_pre($risks);
        return $risks;
    }

    function getInactive() {
        $this->db->where("(`approved` != 'approved') AND (`draft`=0 AND `delete` = 0)");
        $array = $this->db->get($this->table)->result_array();
        //print_pre($array); die;
        foreach ($array as $key => $value) {
            // $array[$key] = $this->enrichIncidentArray($value);
        }
        return $array;
    }

    function getIncidentByUser($id) {
        $this->db->where("user=$id or responsible_manager=$id");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $array = $q->result_array();
        foreach ($array as $key => $value) {
            $array[$key]["incident"] = $this->incidentActions->getIncidentState($value['id']);
            $array[$key]['risk'] = $this->risk->get($value['risk']);
            $array[$key]['environment'] = $this->environment->get($value['environment']);
            $array[$key]['responsible_manager'] = $this->user->get($value['responsible_manager']);
            $array[$key]['risk_category'] = $this->category->get($value['risk_category']);
        }
        return $array;
    }

    // Charts Model
}
