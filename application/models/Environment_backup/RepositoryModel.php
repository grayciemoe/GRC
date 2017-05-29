<?php

class repositoryModel extends CI_Model {

    public $table, $fields, $blank_attributes;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "repository";
        $this->fields = $this->setFields();

        $current_time = strftime("%Y-%m-%d", time());
        $this->blank_attributes = array(
            "best_practices" => "{\"id\":\"1\",\"created\":\"$current_time\",\"ref_code\":\"\",\"name\":\"\",\"description\":\"\",\"created_by\":\"0\",\"attachment\":\"\",\"environment\":\"0\",\"approved\":\"0\",\"kra_clipboard\":\"0\"}",
            "contract" => "{\"id\":\"1\",\"ref_code\":\"\",\"name\":\"\",\"description\":\"\",\"effective_date\":\"$current_time\",\"expiry_date\":\"$current_time\",\"link\":\"\",\"type\":\"\",\"contract_owner\":\"0\",\"signed_by\":\"0\",\"status\":\"\",\"attachment\":\"\",\"environment\":\"0\",\"approved\":\"0\",\"kra_clipboard\":\"0\",\"created\":\"$current_time\"}",
            "corporate_policy" => "{\"id\":\"1\",\"ref_code\":\"\",\"type\":\"\",\"name\":\"\",\"description\":\"\",\"attachment\":\"\",\"environment\":\"0\",\"approved\":\"0\",\"kra_clipboard\":\"0\",\"created\":\"$current_time\"}",
            "counter_party" => "{\"id\":\"1\",\"contract\":\"0\",\"name\":\"\",\"email\":\"\",\"phone\":\"\",\"company\":\"\"}",
            "laws_and_regulations" => "{\"id\":\"1\",\"ref_code\":\"\",\"name\":\"\",\"type\":\"\",\"effective_date\":\"$current_time\",\"legislative_authority\":\"\",\"enforcing_authority\":\"\",\"last_revised_date\":\"$current_time\",\"type_2\":\"\",\"environment\":\"0\",\"approved\":\"0\",\"kra_clipboard\":\"0\",\"created\":\"$current_time\"}",
            "process" => "{\"id\":\"1\",\"ref_code\":\"\",\"owner\":\"0\",\"name\":\"\",\"description\":\"\",\"created\":\"$current_time\",\"link\":\"\",\"status\":\"\",\"system_involved\":\"\",\"environment\":\"0\",\"approved\":\"0\",\"kra_clipboard\":\"0\"}",
            "strategic_objectives" => "{\"id\":\"1\",\"ref_code\":\"\",\"title\":\"\",\"name\":\"\",\"description\":\"\",\"year\":\"0\",\"BSC_perspective\":\"\",\"cascaded_from\":\"0\",\"owner\":\"0\",\"KPI_measure\":\"\",\"KPI_measure_leading\":\"\",\"KPI_measure_lagging\":\"\",\"KPI_target_leading\":\"\",\"KPI_target_lagging\":\"\",\"current_KPI\":\"\",\"current_KPI_date\":\"$current_time\",\"environment\":\"0\",\"approved\":\"0\",\"kra_clipboard\":\"0\",\"created\":\"$current_time\"}",
        );
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

    function getRiskSources() {
        $raw_sources = $this->blank_attributes;
        $sources = [];
        foreach ($raw_sources as $key => $value) {
            $sources[$key] = ucwords(str_replace("_", " ", $key));
        }
        return $sources;
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

    function getPool() {
        $this->db->where("`draft` = 0 AND `pool` = 1 AND `approved` LIKE 'approved'");
        $this->db->order_by("id", "DESC");

        $results = $this->db->get($this->table)->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['imported_to'] = $this->getRepositoryImports($value['id']);
            $results[$key]['compliance_requirements'] = $this->complianceRequirement->getRepository($value['id']);
            $results[$key]['risks'] = $this->risk->getRepository($value['id']);

            //$results[$key]['environment'] = $this->environment->get($value['environment']);
        }
        return $results;
    }

    function getRepositoryImports($pool_source) {
        $this->db->where("pool_source", $pool_source);
        $this->db->where("draft", 0);
        $this->db->where("parent_id", 0);
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        return $q->result_array();
    }

    function approve($id, $option = "pending") {
        $data['id'] = $id;
        $data['approved'] = $option;
        if ($option == 'approved') {
            $data['pool'] = 1;
        }
        $this->edit($data);
        if ($option == 'approved') {
            $this->notification->repository_approve($data['id']);
        }
    }

    function reject($id) {
        $data['id'] = $id;
        $data['approved'] = 0;
        $data['pool'] = 1;
        $this->edit($data);
        $this->notification->repository_approve($data['id']);
    }

    function getEnvironment($environment_id) {
        $this->db->where(array("environment" => $environment_id, "draft" => 0, "parent_id" => 0, "approved" => "approved"));
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $array = $q->result_array();
        foreach ($array as $key => $value) {
            $array[$key]['risks'] = $this->risk->getRepository($value['id']);
            $array[$key]['compliance_requirements'] = $this->complianceRequirement->getRepository($value['id']);
        }

        return $array;
    }

    function add($data) {
        $me = $this->user->getMe();
        $data['json_data'] = $this->blank_attributes[$data['source']];
        $data['draft'] = $me['user']['id'];
        $data['user'] = $me['user']['id'];
        $data['serial'] = md5(time() . "-" . rand(100, 999));
        $check = $this->db->insert($this->table, $this->checkFields($data));
        if ($check) {
            return $this->last();
        } else {
            return false;
        }
    }

    function directAdd($data) {
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
        $repository = $this->get($data['id']);
        if (isset($_FILES['attachments']) and count($_FILES['attachments']['name']) > 0) {
            $this->uploadModel->destination = array(
                'module' => 'environment', 'table_name' => $this->table, 'record_id' => $key
            );
            $files = $this->uploadModel->uploadMultipleFiles('attachments');
        }
        
//        print_pre($data);
//        exit;
        
        $data['draft'] = 0;
        $data['modified'] = strftime("%Y-%m-%d %H:%M:%S", time());
        $this->updatePoolParty($data);
        $this->db->where("id=$key");

        $set_data = $this->checkFields($data);
        $check = $this->db->update($this->table, $set_data);
        if ($repository['draft'] != 0 and ! am_user_type(array(5))) {
            $this->notification->repository_create($repository['id']);
        }
        if (am_user_type(array(5)) and isset($data['approved']) and $data['approved'] == 'pending') {
            $this->auto_approve($key);
        }
        return false;
    }

    function auto_approve($key) {
        
        $sql = "UPDATE `{$this->table}` SET `approved` = 'approved', `pool` = 1 WHERE `id` = $key LIMIT 1";
    //        echo $sql;
    //        exit;
        $this->db->query($sql);
        //$this->notification->obligation_approved($key);
    }

    function updatePoolParty($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        $data['draft'] = 0;
        $data['modified'] = strftime("%Y-%m-%d %H:%M:%S", time());
        array_shift($data);
        unset($data['environment']);
        unset($data['pool']);
        unset($data['parent_id']);
        unset($data['pool_source']);
        unset($data['serial']);
        unset($data['user']);
//        print_pre($data);
//        exit;
        if ($key) {
            $this->updatePoolParty($data);
            $this->db->where("pool_source=$key");
            return $this->db->update($this->table, $this->checkFields($data));
        }
        return false;
    }

    function delete($id) {
        $repo = $this->get($id);
        if ($repo['environment'] != 0 and $repo['pool'] == 1) {
            $data['id'] = $repo['id'];
            $data['environment'] = 0;
            $this->edit($data);
        } else {
            $this->db->where("`id` = $id");
            $this->db->limit(1);
            return $this->db->delete($this->table);
        }
    }

    function last() {
        $this->db->limit(1);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function getALl() {
        $this->db->order_by("id", "ASC");
        $this->db->where("draft", 0);
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

    function importRepository($data) {
//           print_pre($data);
//           exit;
        foreach ($data['pool'] as $key => $value) {
            $record = $this->get($value);
            $new = array_shift($record);
            $record['environment'] = $data['environment'];
            $record['pool_source'] = $new;
            $record['pool'] = 0;
            //print_pre($record);
            $this->directAdd($record);

            //$doc['table_name'] = $value['source'];
            //$doc['record_id'] = $value['id'];
            //$this->
            //$this->doc->copyFile("environment", $this->table, $value);
        }
//        $doc['table_name'] = $value['source'];
//        $doc['record_id'] = $value['id'];
        //$this->
        //$this->doc->copyFile();
    }

    function getRepository($id) {
        $repository = $this->get($id);
        $repository[$repository['source']] = jsonToArray($repository['json_data']);
        $array = ["owner", "contract_owner", "signed_by"];
        foreach ($array as $value) {
            if (isset($repository['source']) and isset($repository[$repository['source']]) and isset($repository[$repository['source']][$value])) {
                $repository[$repository['source']][$value] = $this->user->getUser($repository[$repository['source']][$value]);
            }
        }
        return $repository;
    }

    function getPending() {
        $this->db->where("(`approved` != 'approved') AND (`draft`=0)");
        $array = $this->db->get($this->table)->result_array();
        foreach ($array as $key => $value) {
            $array[$key]['environment'] = $this->environment->get($value['environment']);
        }
        //print_pre($array);
        return $array;
    }

}
