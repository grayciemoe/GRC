<?php

class environmentModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "environment";
        $this->fields = $this->setFields();

        //$this->load->model("risk/riskModel", "risk");
        //$this->load->model("environment/environmentLevelModel", "environmentLevel");
        //$this->load->model("Environment/RepositoryModel", "repository");
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

    function handover($from, $to) {
        $data['unit_owner'] = $to;
        $this->db->where("unit_owner", $from);
        $this->db->update($this->table, $data);
    }

    function getUser($user_id) {
        return $this->db->get_where($this->table, array("unit_owner" => $user_id, "draft" => 0, "delete" => 0))->result_array();
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

    function getUnits($parent_id) {
        $this->db->where("parent_id", $parent_id);
        $this->db->order_by('id', "DESC");
        $this->db->where("draft", 0);
        $this->db->where("environment_level !=", 6);
        $query = $this->db->get($this->table);
        $array = $query->result_array();
        foreach ($array as $key => $value) {
            $array[$key]['risks'] = count($this->getRisks($value['id']));
            $array[$key]['sub_units'] = count($this->getSubUnits($value['id']));
            $array[$key]['owner'] = $this->user->getUser($value['unit_owner']);
            $array[$key]['level'] = $this->environmentLevel->get($value['environment_level']);

            //$array[$key]['key_risk_areas'] = count($this->kraClipboard->getEnvironment($value['id']));
        }
        return $array;
    }

    function getUnitsByLevel($environment_level) {
        $this->db->where("environment_level", $environment_level);
        $this->db->order_by('id', "DESC");
        $this->db->where("draft", 0);
        $query = $this->db->get($this->table);
        $array = $query->result_array();
        foreach ($array as $key => $value) {
            $array[$key]['risks'] = count($this->getRisks($value['id']));
            $array[$key]['sub_units'] = count($this->getSubUnits($value['id']));
            $array[$key]['owner'] = $this->user->getUser($value['unit_owner']);
            $array[$key]['level'] = $this->environmentLevel->get($value['environment_level']);

            //$array[$key]['key_risk_areas'] = count($this->kraClipboard->getEnvironment($value['id']));
        }
        return $array;
    }

    function getSubUnits($unit_id) {
        $this->db->where("parent_id", $unit_id);
        $this->db->where("draft", 0);
        $this->db->order_by('id', "DESC");
        $this->db->where("environment_level !=", 5);
        $query = $this->db->get($this->table);
        $array = $query->result_array();
        return $array;
    }

    function getUnit($unitID) {
        // $this->refCode($unitID);
        $data = $this->get($unitID);
        $data['unit_owner'] = $this->user->getUser($data['unit_owner']);
        $data['environment_level'] = $this->environmentLevel->get($data['environment_level']);
        $data['sub_units'] = $this->getFamily($data['id']);
        foreach ($data['sub_units'] as $key => $value) {
            $data['sub_units'][$key]['unit_owner'] = $this->user->getPerson($value['unit_owner']);
        }
        return $data;
    }

    function nextLevel($unitId) {
        $unit = $this->get($unitId);
        $next_level = $unit['environment_level'] + 1;
        return ($next_level < 5) ? $this->environmentLevel->get($next_level) : false;
    }

    function getFamilyTree($environment_id) {
        $parent = $this->getUnits($environment_id);
        foreach ($parent as $key => $value) {
            $parent[$key]["units"] = $this->getFamilyTree($value['id']);
        }
        return $parent;
    }

    function getFamily($environment_id) {
        $units = array();
        $parent = $this->getUnits($environment_id);
        foreach ($parent as $value) {
            $units[count($units)] = $value;
            $this->getFamily($value['id']);
        }
        return $units;
    }

    function getRisks($environment_id) {
        return [];
        return $this->risk->getRisksBy(array("environment" => $environment_id));
    }

    function getProjects($environment_id) {
        $environment = $this->get($environment_id);
        if ($environment['environment_level'] != 1) {
            return false;
        } else {
            $this->db->where("environment_level", 6);
            $this->db->where("draft", 0);
            $this->db->order_by("id", "DESC");
            $query = $this->db->get($this->table);
            $array = $query->result_array();
            foreach ($array as $key => $value) {

                $array[$key]['owner'] = $this->user->getUser($value['unit_owner']);
                $array[$key]['risks'] = count($this->getRisks($value['id']));
                //$array[$key]['sub_units'] = count($this->getSubUnits($value['id']));
                $array[$key]['repository'] = [];
            }
            return $array;
        }
    }

    function refCode($env_id) {
        return false;
    }

    function add($data) {
        $check = $this->db->insert($this->table, $this->checkFields($data));
        if ($check) {
            return $this->last();
        } else {
            return false;
        }
    }

    function blank() {
        $record = $this->fields;
        foreach ($record as $key => $value) {
            $record[$key] = NULL;
        }
        return $record;
    }

    function get($id) {
        $this->db->where("`id` = $id");
        $env = $this->db->get($this->table)->row_array();
        if (count($env) > 0) {
            return $env;
        } else {
            return $this->blank();
        }
    }

    function edit($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        $check = false;
        if ($key) {
            $unit = $this->get($key);
            $this->db->where("`id` = $key");
            $data['draft'] = 0;
            $check = $this->db->update($this->table, $this->checkFields($data));
            if ($unit['draft'] != 0) {
                $this->notification->unit_create($data['id']);
            } else {
                $this->notification->unit_edit($data['id']);
            }
            $new = $this->get($data['id']);

            if (($unit['draft'] == 0) and ( $unit['unit_owner'] != $new['unit_owner'])) {
                // echo "Assign User";
                $this->notification->unit_assign($data['id']);
                ///exit;
            }
        }
        return $check;
    }

    function delete($id) {
        $this->db->where("`id` = $id");
        return $this->db->delete($this->table);
    }

    function last() {
        $this->db->limit(1);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function getEnvironments() {
        $envs = $this->getAll();
        foreach ($envs as $key => $value) {
            $envs[$key]['environment_level'] = $this->environmentLevel->get($value['environment_level']);
            //    $envs[$key]['repository'] = $this->repository->get($value['id']);
        }
        return $envs;
    }

    function getAll() {
        $this->db->order_by("id", "ASC");
        $this->db->where("draft", 0);
        $q = $this->db->get($this->table);
        $array = $q->result_array();
        foreach ($array as $key => $value) {
            $array[$key]['owner'] = $this->user->getUser($value['unit_owner']);
            $array[$key]['level'] = $this->environmentLevel->get($value['environment_level']);
        }
        return $array;
    }

    function getEnvironment($id) {
        $array = $this->get($id);
        if ($array and count($array) > 0) {
            //print_pre($array);
            $array['level'] = $this->environmentLevel->get($array['environment_level']);
            $array['tree'] = $this->getTree($id);
            return $array;
        } else {
            return [];
        }
    }

    function getRepository($unit_id) {
        return $this->repository->getEnvironment($unit_id);
    }

    function getTree($unit_id) {
        $environment_id = $unit_id;
        $tree = array();

        do {
            $environment = $this->get($environment_id);
            $environment['environment_level'] = $this->environmentLevel->get($environment['environment_level']);
            //print_pre($environment);
            $tree[count($tree)] = $environment;
            $environment_id = $environment["parent_id"];
        } while ($environment["parent_id"] != 0);
        return $tree;
    }

    function getSortedEnvironments() {
        $unsorted = $this->environment->getEnvironments();
        $sorted = [];
        foreach ($unsorted as $key => $env) {
            if (!isset($sorted[$env['environment_level']['name']])) {
                $sorted[$env['environment_level']['name']] = [];
            }
            $sorted[$env['environment_level']['name']][] = $env;
        }
        return $sorted;
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

    // final Changes

    function allUnits($environment_id) {
        $parent = $this->getUnits($environment_id);
        foreach ($parent as $key => $value) {
            $parent[$key]["units"] = $this->allUnits($value['id']);
        }
        return $parent;
    }

    function getEnvironmentSubUnits($environment_id) {
        $environments = $this->allUnits($environment_id);
        foreach ($environments as $key => $value) {
            unset($value['owner']);
            unset($value['level']);
            unset($value['sub_units']);
            $environments[$key] = $value;
        }
        return $environments;
    }

    // **** Alex's Code ***///

    function getCorporates() {
        $this->db->where('environment_level', 2);
        $corp = $this->db->get($this->table)->result_array();

        return $corp;
    }

    function getEnvs($corpId) {
        $this->db->where("`id` = $corpId");
        $corporate = $this->db->get($this->table)->result_array();
        $result = array();
        foreach ($corporate as $key => $value) {
            $corporate[$key]['environment_level'] = $this->environmentLevel->get($value['environment_level']);
        }
        $result[$key]['Corporate'] = $corporate;
        $bu = $this->getUnits($corporate[0]['id']);
        if (!empty($bu)) {
            foreach ($bu as $key => $value) {
                $bu[$key]['environment_level'] = $this->environmentLevel->get($value['environment_level']);
            }
            foreach ($bu as $key => $value) {
                $fu = $this->getUnits($value['id']);
            }
            $result[$key]['Business Unit'] = $bu;
        }
        if (!empty($fu)) {
            foreach ($fu as $key => $value) {
                $fu[$key]['environment_level'] = $this->environmentLevel->get($value['environment_level']);
            }
            $result[$key]['Functional Unit'] = $fu;
        }
        $proj = $this->getProjects(1);
        foreach ($proj as $key => $value) {
            $proj[$key]['environment_level'] = $this->environmentLevel->get($value['environment_level']);
        }
        $result[$key]['Project'] = $proj;
        if((isset($result[0])) && (is_array($result[0])) && (isset($result[1])) && (is_array($result[1]))){
        $result = array_merge($result[0], $result[1]);  
        }
        return $result;
    }

    ///********************////////
}
