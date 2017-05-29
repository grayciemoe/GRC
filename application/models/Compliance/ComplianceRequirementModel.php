<?php

class complianceRequirementModel extends CI_Model {

    public $table, $fields, $risk_sources_initials;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "compliance_requirement";
        $this->fields = $this->setFields();
    }

    function checkFields($data_array) {
        $return_array = array();
        foreach ($data_array as $key => $value) {
            if (in_array($key, $this->field_keys) and $key != 'id') {
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

    function getUser($user_id) {
        return $this->db->get_where($this->table, array("owner" => $user_id, "draft" => 0, "delete" => 0))->result_array();
    }

    function handover($from, $to) {
        $data['owner'] = $to;
        $this->db->where("owner", $from);
        $this->db->update($this->table, $data);
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

    function getEnvironments() {
        $compliances = $this->getALL();
        $environments = array();
        $return = array();
        foreach ($compliances as $key => $value) {
            if (in_array($value['environment'], $environments)) {
                continue;
            }
            $environments[count($environments)] = $value['environment'];
            $return[count($return)] = $this->environment->get($value['environment']);
        }

        return $return;
    }

    function refCode($id) {
        return false;
    }

    function shortCode($id) {
        return false;
    }

    function simpleEdit($key, $dataArray) {
        $this->db->where(array("id" => $key));
        return $this->db->update($this->table, $dataArray);
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
        $me = $this->user->getMe();
        $data['user'] = $me['user']['id'];
        $check = $this->db->insert($this->table, $this->checkFields($data));
        if ($check) {
            $last = $this->last();
            $this->complianceVersion->initialVersion($last['id']);
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

    function getComplianceRequirement($id) {
        $data = $this->get($id);
        if ($data) {
            $data['owner'] = $this->user->getUser($data['owner']);
            $data['user'] = $this->user->getUser($data['user']);
            $data['owner_0'] = $this->user->getUser($data['owner_0']);
            $data['owner_1'] = $this->user->getUser($data['owner_1']);
            $data['owner_2'] = $this->user->getUser($data['owner_2']);
            $data['compliance_register'] = $this->complianceRegister->get($data['compliance_register']);
            $data['repository'] = $this->repository->get($data['repository']);
            $data['environment'] = $this->environment->get($data['repository']['environment']);
            $data['completion'] = $this->obligation->complianceRquirementCompletion($data['id']);
            $data['versions'] = $this->complianceVersion->getComplaince($id);
            $data['version'] = $this->complianceVersion->getCurrentVersion($id);
            $data['obligations'] = $this->getObligations($id);
            return $data;
        } else {
            return false;
        }
    }

    function edit($data) {
        $key = (isset($data['id']) and $data['id'] > 0) ? $data['id'] : false;
        $data['draft'] = 0;
        if ($key) {
            if (isset($data['status']) and $data['status'] == 'active') {
                $data['effective_date'] = strftime("%Y-%m-%d %H:%M:%S");
            }
            $this->db->where("`id` = $key");
            $this->db->limit(1);
            $this->db->limit(1);
            $return = $this->db->update($this->table, $this->checkFields($data));
            $data = $this->get($key);
            return $return;
        }
        return false;
    }

    function delete($id) {
        if ($id != 1) {
            $this->obligation->deleteComplianceRequirements($id);
        }
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
        $this->db->where("draft=0 AND delete=0 ");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['obligations'] = $this->obligation->countRequirement($value['id']);
            $results[$key]['completion'] = $this->obligation->complianceRquirementCompletion($value['id']);
            $results[$key]['repository'] = $this->repository->getRepository($value['repository']);
            $env = isset($results[$key]['repository']['environment']) ? $results[$key]['repository']['environment'] : 1;
            $results[$key]['environment'] = $this->environment->get($env);
        }
        return $results;
    }

    function getminAllCR() {
        $me = $this->user->getMe();
        $this->db->where("draft=0 AND delete=0 ");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);

        $results = $q->result_array();
        return $results;
    }

    function getObligations($compliance_requirement_id) {
        return $this->obligation->getComplianceRequirements($compliance_requirement_id);
    }

    function getObligation($obligation_id) {
        return $this->obligationRelationship->getObligation($obligation_id, "complianceRequirement");
    }

    function getKRAS() {
        return [];
    }

    function getTypeObligations($type = "Statutory Returns") {
        $compliances = $this->getTypeComplianceRequirements($type);
        $array = [];
        $obligations = [];
        $results = [];
        foreach ($compliances as $key => $cr) {
            $compliances[$key]['obligations'] = $this->obligation->getComplianceRequirements($cr['id']);
            $register = $this->register->get($cr['compliance_register']);

            $registers = $this->bridge->getCompliance_requirementRegisters($cr['id']);
//            print_pre($registers);
//            exit;

            $results[$key]['completion'] = $this->obligation->complianceRquirementCompletion($cr['id']);
            $results[$key]['repository'] = $this->repository->getRepository($cr['repository']);
            $env = isset($results[$key]['repository']['environment']) ? $results[$key]['repository']['environment'] : 1;
            $results[$key]['environment'] = $this->environment->get($env);
            $array = $compliances[$key]['obligations'];
            foreach ($array as $obligation) {
                $obligations[] = $obligation;
                $index = count($obligations) - 1;
                $obligations[$index]['compliance_requirement'] = $cr;
                $obligations[$index]['register'] = $register;
                $obligations[$index]['registers'] = $registers;
                $obligations[$index]['repository'] = $results[$key]['repository'];
                $obligations[$index]['environment'] = $results[$key]['environment'];
                $obligations[$index]['pending_breaches'] = $this->breach->getObligationPendingBreachesTotal($obligation['id']);
                $obligations[$index]['pending_compliants'] = $this->comply->getObligationPendingCompliantTotal($obligation['id']);
                $obligations[$index]['total_penulty'] = $this->breach->getObligationTotalPenulty($obligation['id']);
            }
        }
        return $obligations;
    }

    function getTypeDateObligations($type = "Statutory Returns", $start = null, $end = null) {
        $compliances = $this->getTypeComplianceRequirements($type);
        $array = [];
        $obligations = [];
        $results = [];
        foreach ($compliances as $key => $cr) {
            $compliances[$key]['obligations'] = $this->obligation->getComplianceRequirementsByDate($cr['id'], $start, $end);
            $register = $this->register->get($cr['compliance_register']);
            $registers = $this->bridge->getCompliance_requirementRegisters($cr['id']);
            $results[$key]['completion'] = $this->obligation->complianceRquirementCompletion($cr['id']);
            $results[$key]['repository'] = $this->repository->getRepository($cr['repository']);
            $env = isset($results[$key]['repository']['environment']) ? $results[$key]['repository']['environment'] : 1;
            $results[$key]['environment'] = $this->environment->get($env);
            $array = $compliances[$key]['obligations'];
            //$array[]['register'] = $register;
            foreach ($array as $obligation) {
                $submission_deadline = strtotime($obligation['submission_deadline']);
                $obligations[] = $obligation;
                $index = count($obligations) - 1;
                $obligations[$index]['compliance_requirement'] = $cr;
                $obligations[$index]['register'] = $register;
                $obligations[$index]['repository'] = $results[$key]['repository'];
                $obligations[$index]['environment'] = $results[$key]['environment'];
                $obligations[$index]['pending_breaches'] = $this->breach->getObligationPendingBreachesTotal($obligation['id']);
                $obligations[$index]['pending_compliants'] = $this->comply->getObligationPendingCompliantTotal($obligation['id']);
                $obligations[$index]['total_penulty'] = $this->breach->getObligationTotalPenulty($obligation['id']);
                $obligations[$index]['registers'] = $registers;
            }
        }

        return $obligations;
    }

    function getTypeOblComplianceRequirements($id) {
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        return $q->row_array();
    }

    function getTypeComplianceRequirements($type) {
        $this->db->where("type", $type);
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $array = $q->result_array();
        foreach ($array as $key => $value) {
            $array[$key]['owner_0'] = $this->user->getUser($value['owner_0']);
            $array[$key]['owner_1'] = $this->user->getUser($value['owner_1']);
            $array[$key]['owner_2'] = $this->user->getUser($value['owner_2']);
        }
        return $array;
    }

    function getRepository($repository_id) {
        $this->db->where("repository", $repository_id);
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        return $q->result_array();
    }

    function getComplianceRegister($register_id) {
        $me = $this->user->getMe();
        $this->db->where("`compliance_register` = $register_id and draft=0 AND delete=0 ");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['obligations'] = $this->getObligations($value['id']);
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

}
