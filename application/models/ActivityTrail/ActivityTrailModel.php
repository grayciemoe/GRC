<?php

class activityTrailModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "activity_trail";
        $this->fields = $this->setFields();
    }

//public $field_keys;
    function setFields() {
        $sql = "SHOW FIELDS FROM {$this->table}";
        $data_types = $this->db->query($sql)->result_array();
        foreach ($data_types as $key => $value) {
            $this->fields[$value['Field']] = $value['Default'];
            $this->field_keys[$value['Field']] = $value['Field'];
        }
        return $this->fields;
    }

    function checkFields($data_array) {
        $return_array = array();
        foreach ($data_array as $key => $value) {
            if (in_array($key, $this->field_keys) and ! is_array($value) and $key != 'id') {
                $return_array[$key] = $value;
            }
        }
        return $return_array;
    }

    function add($data) {

        $me = $this->user->getMe();
        $data['user'] = $me['user']['id'];
        return $this->db->insert($this->table, $this->checkFields($data));
    }

    function get($id) {
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function getAll($page = 1) {
        $page = $page < 1 ? 1 : $page;

        $offset = ($page - 1) * 20;
        $this->db->order_by("id", "DESC");
        return $this->db->get_where($this->table, array())->result_array();
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
        $this->db->delete($this->table);
    }

    function read($id) {
        $data = $this->get($id);
        $data['user_read'] = 'yes';
        return $this->edit($data);
    }

    function send_emails() {
        
    }

    function email($id) {
        
    }

    // == USERS Activity == //

    function user_created() {
        $data['module'] = "";
        $data['table'] = "";
        $data['record'] = "";

        $data['title'] = "";
        $data['message'] = "";
        $data['link'] = "";
    }

    function user_deleted() {
        
    }

    function user_edited() {
        
    }

    function user_roles_transfer() {
        
    }

    // == END USERS Activity == //

    function risk_proposed() {
        
    }

    function risk_created() {
        
    }

}

class notification extends CI_Model {

    public $field_keys;

    function __construct() {
        parent::__construct();
    }

    function risk_proposed($id) {
        $emails = []; // risk_manager / risk_owner / unit_owner / 
    }

}
