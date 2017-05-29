<?php

class complianceVersionModel extends CI_Model {

    public $table, $fields, $risk_sources_initials;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "compliance_versions";
        $this->fields = $this->setFields();
        //$this->load->model("Users/UserModel", "user");
        //$this->load->model("compliance/authorityModel", "authority");
        //$this->load->model("compliance/complianceRequirementModel", "complianceRequirement");
        //$this->load->model("compliance/obligationComplyModel", "obligationComply");
        //$this->load->model("Compliance/ObligationModel", "obligation");
    }

    function checkFields($data_array) {
        $return_array = array();
        foreach ($data_array as $key => $value) {
            if (in_array($key, $this->field_keys) and ( $key != "attachments")) {
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

    function getComplaince($compliance_id) {
        $this->db->where("compliance_requirement", $compliance_id);
        $this->db->order_by("id", "DESC");
        $results = $this->db->get($this->table);
        $array = $results->result_array();
        if (count($array) == 0) {
            $this->initialVersion($compliance_id);
            $this->getComplaince($compliance_id);
        }
        return $array;
    }

    function getCurrentVersion($compliance_id) {
        $this->createVersion($compliance_id);
        $versions = $this->getComplaince($compliance_id);
        return isset($versions[0]) ? $versions[0] : 0;
    }

    function createVersion($compliance_id) {
        $data['compliance_requirement'] = $compliance_id;
        $obligations = $this->obligation->getComplianceRequirements($compliance_id);
        $data['obligaitons'] = json_encode($obligations);
        $data['total_obligations'] = count($obligations);
        $versions = count($this->getComplaince($compliance_id)); // $this->getComplaince($compliance_id);
        $allVersions = $this->getComplaince($compliance_id);

        $last = (count($allVersions) > 0) ? $allVersions[0] : false;
        $data['version'] = $versions;
        if (isset($last['total_obligations']) and $last['total_obligations'] != $data['total_obligations']) {
            $this->add($data);
        }
    }

    function initialVersion($compliance_id) {
        $data['compliance_requirement'] = $compliance_id;
        $obligations = $this->obligation->getComplianceRequirements($compliance_id);
        $data['obligaitons'] = json_encode($obligations);
        $data['total_obligations'] = count($obligations);
        $data['version'] = 0;
        $this->add($data);
    }

    function add($data) {
        $me = $this->user->getMe();
        $data['user'] = $me['user']['id'];
        $check = $this->db->insert($this->table, $this->checkFields($data));
        if ($check) {
            $last = $this->last();
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
        if ($data['compliance_requirement']) {
            $cr = $this->complianceRequirement->get($data['compliance_requirement']);
            $data['compliance_state'] = $cr['status'];
        } else {
            $data['compliance_state'] = 'inactive';
        }
        $check = false;
        if ($key) {
            $this->db->where("`id` =  $key");
            $check = $this->db->update($this->table, $this->checkFields($data));
            // $this->refCode($key);
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
        $this->db->where("draft=0 AND delete=0 OR (user={$me['user']['id']})");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['authority'] = $this->authority->get($value['authority']);
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

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

