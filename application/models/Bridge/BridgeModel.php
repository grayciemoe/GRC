<?php

class bridgeModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "g_bridge";
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
        // echo __METHOD__;
        //print_pre($data);
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
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function edit($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        if ($key) {
            $this->db->where("`id` =  $key");
            return $this->db->update($this->table, $this->checkFields($data));
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

    function getAll() {
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $array = $q->result_array();

        foreach ($array as $key => $value) {
            $user = $this->user->getMe();
            $array[$key]['user'] = $user['user'];
        }

        return $array;
    }

    function getRelationship($table_1, $table_2, $record_1 = 0, $record_2 = 0) {
        $this->db->where("table_1", $table_1);
        $this->db->where("table_2", $table_2);
        if ($record_1) {
            $this->db->where("record_1", $record_1);
        } else {
            $this->db->where("record_2", $record_2);
        }
        $q = $this->db->get($this->table);
        return $q->result_array();
    }

    function getRegisterRisks($register_id) { // will return all the risks in a register
        $records = $this->getRelationship("risk", "risk_register", 0, $register_id);
        $risks = [];
        foreach ($records as $key => $value) {
            $try = $this->risk->getRiskSummary($value['record_1']);
            if ($try) {
                $risks[] = $try;
            }
        }
        return $risks;
    }

    function getRiskRegisters($risk_id) { // will return all the registers that contain the risk_id
        $records = $this->getRelationship("risk", "risk_register", $risk_id, 0);
        $registers = [];
        foreach ($records as $value) {
            $try = $this->register->get($value['record_2']);
            if ($try) {
                $registers[] = $try;
            }
        }
        return $registers;
    }
    
    function getRisksinAudit($risk_id) { // will return all the registers that contain the risk_id
        $records = $this->getRelationship("risk", "risk_register", $risk_id, 0);
        $registers = [];
        foreach ($records as $value) {
            $try = $this->register->get($value['record_2']);
            if ($try) {
                $registers[] = $try;
            }
        }
        return $registers;
    }

    function addRisksToRegister($data) {
        $register = isset($data['risk_register']) ? $data['risk_register'] : 0;
        $risks = isset($data['risks']) ? $data['risks'] : [];
        $this->db->where(array("table_2" => "risk_register", "record_2" => $register));
        $this->db->delete($this->table);
        $record = array("table_1" => "risk", "table_2" => "risk_register", "record_2" => $register);
        $total = 0;
        foreach ($risks as $value) {
            $record['record_1'] = $value;
            $check = $this->add($record);
            //print_pre($check);
        }
        return $total;
    }

    function addRegistersToRisk($data) {
        $registers = $data['risk_registers'];
        $risk = $data['risk'];
        $this->db->where(array("table_1" => "risk", "record_1" => $risk));
        $this->db->delete($this->table);
        $record = array("table_1" => "risk", "table_2" => "risk_register", "record_1" => $risk);
        $total = 0;
        foreach ($registers as $value) {
            $record['record_2'] = $value;
            $check = $this->add($record);
            if (count($check)) {
                $total++;
            }
        }
        return $total;
    }

    function getRegisterCompliance_requirements($register_id) { // will return all the compliance_requirements in a register
        $records = $this->getRelationship("compliance_requirement", "complaince_register", 0, $register_id);
        $compliance_requirements = [];
        foreach ($records as $key => $value) {
            $try = $this->compliance->getComplianceRequirement($value['record_1']);
            if ($try) {
                $compliance_requirements[] = $try;
            }
        }
        return $compliance_requirements;
    }

    function getCompliance_requirementRegisters($compliance_requirement_id) { // will return all the registers that contain the compliance_requirement_id
        $records = $this->getRelationship("compliance_requirement", "complaince_register", $compliance_requirement_id, 0);
        $registers = [];
        $list = [];
        foreach ($records as $value) {
            $list[] = $value['record_2'];
        }
        return $list;
    }

    function addCompliance_requirementsToRegister($data) {
        $register = $data['compliance_register'];
        $compliance_requirements = isset($data['compliance_requirements']) ? $data['compliance_requirements'] : [];
        $this->db->where(array("table_2" => "complaince_register", "record_2" => $register));
        $this->db->delete($this->table);
        $record = array("table_1" => "compliance_requirement", "table_2" => "complaince_register", "record_2" => $register);
        $total = 0;
        foreach ($compliance_requirements as $value) {
            $record['record_1'] = $value;
            $check = $this->add($record);
        }
        return $total;
    }

    function addRegistersToCompliance_requirement($data) {
        $registers = $data['complaince_registers'];
        $compliance_requirement = $data['compliance_requirement'];
        $this->db->where(array("table_1" => "compliance_requirement", "record_1" => $compliance_requirement));
        $this->db->delete($this->table);
        $record = array("table_1" => "compliance_requirement", "table_2" => "complaince_register", "record_1" => $compliance_requirement);
        $total = 0;
        foreach ($registers as $value) {
            $record['record_2'] = $value;
            $check = $this->add($record);
            if (count($check)) {
                $total++;
            }
        }
        return $total;
    }
    
    function addRisksToIssue($issue, $risks, $user) {
        $risks = jsonToArray($risks);
        $issue = isset($issue) ? $issue : 0;
        $risks = isset($risks) ? $risks : [];
        $this->db->where(array("table_2" => "issue", "record_2" => $issue));
        $this->db->delete($this->table);
        $record = array("table_1" => "risk", "table_2" => "issue", "record_2" => $issue);
        $total = 0;
        foreach ($risks as $value) {
            $record['record_1'] = $value;
            $check = $this->add($record);
            //print_pre($check);
        }
        return $total;
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
