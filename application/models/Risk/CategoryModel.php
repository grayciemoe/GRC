<?php

class categoryModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "risk_category";
        $this->fields = $this->setFields();
        //$this->load->model("Users/UserModel", "user");
        //$this->load->model("incidentManagement/incidentManagementModel", "incident");
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
        $me = $this->user->getMe();
        $data['user'] = $me['user']['id'];
        $check = $this->db->insert($this->table, $this->checkFields($data));
        if ($check) {
            return $this->last();
        } else {
            return false;
        }
    }

    function addCategoryRisk($data) {
        $me = $this->user->getMe();
        $data['user'] = $me['user']['id'];
//        $this->db->insert("category_risks", $data);
    }

    function get($id) {
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function edit($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        $data['draft'] = 0;
        if ($key) {
            $this->db->where("`id` =  $key");
            return $this->db->update($this->table, $this->checkFields($data));
        }
        return false;
    }

    function getRiskCategories($risk_id) {
        return [];
        $me = $this->user->getMe();
        $this->db->where("risk", $risk_id);
        $q = $this->db->get("category_risks");
        $array = $q->result_array();
        $results = array();
        foreach ($array as $value) {
            $category = $this->get($value[$this->table]);
            if (($category['published'] == 1 or
                    $category['user'] == $me['user']['id']) and ( $category['draft'] + $category['delete']) == 0) {
                $results[count($results)] = $category;
            }
        }
        return $results;
    }

    function delete($id) {
        //$this->deleteCategoryRisks($id);
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $this->db->delete($this->table);
    }

    function deleteCategoryRisks($category) {
        $this->db->where($this->table, $category);
        //$this->db->delete("category_risks");
    }

    function getAllRisks($category_id) {
        $this->db->where("level_1 = $category_id OR level_2 = $category_id OR id = $category_id");
        $q = $this->db->get($this->table);
        $array = $q->result_array();
        $risks = [];
        foreach ($array as $key => $value) {
            $all = $this->risk->getCategory($value['id']);
            $risks[] = $all;
        }

        return $risks;
    }

    function deleteRiskCategories($risk_id) {
        $this->db->where("risk", $risk_id);
        $this->db->delete("category_risks");
    }

    function last() {
        $this->db->limit(1);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function getAllCategories() {
        return [];
    }

    function getAll() {
        $me = $this->user->getMe();
        $this->db->where("draft=0 AND delete=0");
        $this->db->order_by("id", "DESC");
        //$this->db->order_by("category", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
            //    $results[$key]['risks'] = $this->getRisks($value['id']);
        }
        return $results;
    }

    function getCategoryRoot($category_id) {
        $return = [];
        $category = $this->get($category_id);
        $hold['tmp'] = $this->get($category['level_1']);
        if (count($hold['tmp'])) {
            $return[] = $hold['tmp'];
        }

        $hold['tmp'] = $this->get($category['level_2']);
        if (count($hold['tmp'])) {
            $return[] = $hold['tmp'];
        }
        $return[] = $category;
        return $return;
    }

    function findCategoryLevel($category_id) {
        $category = $this->get($category_id);
        $level = 0;
        if ($category['level_1'] == 0 and $category['level_2'] == 0) {
            $level = 1;
        }
        if ($category['level_1'] != 0 and $category['level_2'] == 0) {
            $level = 2;
        }
        if ($category['level_1'] != 0 and $category['level_2'] != 0) {
            $level = 3;
        }
        return $level;
    }

    function getChildLevels($parent_id = 0, $level = 0) { // levels = 1/ 2/ 3
        //$level = $this->findCategoryLevel($parent_id);
        switch ($level) {
            case 1:
                $this->db->where(array("level_1" => 0, "level_2" => 0));
                break;
            case 2:
                $this->db->where(array("level_1" => $parent_id, "level_2" => 0));
                break;
            case 3:
                $this->db->where(array("level_2" => $parent_id));
                break;
            default:
                $this->db->where(array("level_1" => 0, "level_2" => 0));
                break;
        }
        $this->db->where(array("draft" => 0));
        $this->db->order_by("id", "DESC");
        return ($this->db->get($this->table)->result_array());
    }

    function getCategory($category_id) {
        $data['category'] = $this->get($category_id);
        $data['risks'] = $this->getRisks($category_id);
        $data['incidents'] = $this->incident->getCategoryIncidents($category_id);
        $data['category']['category'] = $this->get($data['category']['category']);
        return $data;
    }

    function getCategoryIncidents($category_id) {
        return $this->incident->getCategoryIncidents($category_id);
    }

    function getRisks($cat_id) {
        $categories = [];
        $this->db->where("id=$cat_id or level_1=$cat_id or level_2=$cat_id");
        $q = ($this->db->get($this->table));
        $categories = $q->result_array();
        //pritn_pre($categories);
        $risk_blocks = [];
        $return = [];
        foreach ($categories as $key => $value) {
            $risk_blocks[] = $this->risk->getCategory($cat_id);
        }
        foreach ($risk_blocks as $risks) {
            foreach ($risks as $key => $value) {
                $return[] = $value;
            }
        }
        // print_pre($return);
        return $return;
    }
    
    ////////////////Alex Code On Audit ///////////////
    function getAllApprovedRisks($category_id) {
        $this->db->where("level_1 = $category_id OR level_2 = $category_id OR id = $category_id");
        $q = $this->db->get($this->table);
        $array = $q->result_array();
        $risks = [];
        foreach ($array as $key => $value) {
            $all = $this->risk->getCategoryApproved($value['id']);
            $risks[] = $all;
        }

        return $risks;
    }
    
    function getAllProposedRisks($category_id) {
        $this->db->where("level_1 = $category_id OR level_2 = $category_id OR id = $category_id");
        $q = $this->db->get($this->table);
        $array = $q->result_array();
        $risks = [];
        foreach ($array as $key => $value) {
            $all = $this->risk->getCategoryProposed($value['id']);
            $risks[] = $all;
        }

        return $risks;
    }
    
    
    
    //////////////////////////////////////////

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
