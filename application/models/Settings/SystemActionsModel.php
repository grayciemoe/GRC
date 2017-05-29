<?php

class systemActionsModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "system_actions";
        $this->fields = $this->setFields();
    }

    function addSystemAction($actionID) {
        $data = array("action" => addSystemAction, "title" => NULL);
        $this->add($data);
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

    function checkUnique($action) {
        $this->db->where("action", $action);
        $query = $this->db->get($this->table);
        return ($query->num_rows() == 0) ? TRUE : FALSE;
    }

    function refreshActions() {
        $new_string = NULL;
        $string = file_get_contents("perms.txt");
        $sep = "]:[";
        $array = explode($sep, $string);
        $action = array();
        foreach ($array as $key => $value) {
            if (!in_array($value, $action) and $value) {
                $action[count($action)] = $value;
                $new_string .= $value . "]:[";
            }
        }
        foreach ($action as $key => $value) {
            if ($this->checkUnique($value)) {
                $this->add(array("action" => $value));
            }
        }


        return $action;
        //file_put_contents("perms.txt", $new_string);
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
        $this->db->order_by("action", "ASC");
        $q = $this->db->get($this->table);
        return $q->result_array();
    }

    function toggleField($key, $column, $options = array(0, 1)) {
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
