<?php

class userModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "user";
        $this->fields = $this->setFields();
        //$this->load->model("users/userTypeModel", "userType");
        ;
    }

    function checkFields($data_array) {
        $return_array = array();
        foreach ($data_array as $key => $value) {
            if (in_array($key, $this->field_keys) and ! is_array($value)) {
                $return_array[$key] = $value;
            }
        }

        $destination = array('module' => 'user', 'table_name' => 'user', 'record_id' => 0);
        if (!empty($_FILES) and $_FILES['profile_pic']['size'] > 0) {
            //$this->load->model("uploadModel", "uploadModel");
            $uploads = $this->uploadModel->uploadImage('profile_pic', $destination);
            $return_array['profile_pic'] = $uploads;
        }

        return $return_array;
    }

    function getUserByUsername($username) {
        $this->db->where("username", $username);
        return $this->db->get($this->table)->row_array();
    }

    function getPerson($user) {
        return $this->getUser($user);
    }

    function unique($username) {
        return $this->db->get_where($this->table, array("username" => $username))->num_rows() == 0 ? true : false;
    }

    function deleteBlank() {
        $this->db->where("username", "");
        $this->db->delete($this->table);
    }

    function getRiskOwners() {
        $owners = $this->userType->getRiskOwners();
        foreach ($owners as $key => $value) {
            $this->db->or_where("user_type", $value['id']);
        }
        $this->db->order_by("names", "ASC");
        // $this->db->join('user_type', 'user.user_type = user_type.id');
        $query = $this->db->get($this->table);
        $results = $query->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['user_type'] = $this->userType->get($value['user_type']);
        }

        return $results;
    }

    function getRiskStaff() {
        $this->db->or_where("user_type", 7);
        $this->db->order_by("names", "ASC");
        $query = $this->db->get($this->table);
        $results = $query->result_array();
        return $results;
    }

    function getUserType($type) {
        $this->db->or_where("user_type", $type);
        $this->db->order_by("names", "ASC");
        $query = $this->db->get($this->table);
        $results = $query->result_array();
        return $results;
    }

    function get_actionBy($username) { // or email address
        $this->db->select('id', 'username', 'google_id', 'profile_pic', 'names', 'phone', 'user_type');
        $this->db->where("username", $username);
        $q = $this->db->get($this->table);
        $user = $q->row_array();
        return $this->getUser($user['id']);
    }

    function checkPassword($data) {
        $this->db->where($this->checkFields($data));
        $q = $this->db->get($this->table);
        return $q->num_rows();
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

    function userPasswordGen($user_id) {
        $string = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm12345678990!@%&";
        $data['id'] = $user_id;
        $password = substr(str_shuffle($string), 0, 10);
        $data['password'] = md5($password);
        $this->edit($data);
        return $password;
    }

    function get($id) {
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function getMe() {
        $this->load->model("Environment/EnvironmentModel", "environment");
        $id = isset($_SESSION[SESSION_INDEX]['GRC']['USER']['id']) ? $_SESSION[SESSION_INDEX]['GRC']['USER']['id'] : NULL;
        $data['user'] = $this->get($id);
        $data['user_type'] = $this->userType->get($data['user']['user_type']);
        $data['corporate'] = $this->environment->get($data['user']['corporate']);
        return $data;
    }

    function getMyId() {
        $me = $this->getMe();
        return $me['user']['id'];
    }

    function getMyUsername() {
        $me = $this->getMe();
        return $me['user']['username'];
    }

    function getUserEmail($user_id) {
        $user = $this->getUser($user_id);
        return $user['username'];
    }

    function getUserNames($user_id) {
        $user = $this->getUser($user_id);
        return $user['names'];
    }

    function edit($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        $data['draft'] = 0;
        if ($key) {
            $user = $this->get($key);
            $sql = $this->db->update_string($this->table, $this->checkFields($data), "id=$key");
            $check = $this->db->query($sql);
        } else {
            $this->add($data);
            return $this->notification->user_create($key);
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

    function getUsers() {
        $sql = "SELECT "
                . " `user`.`id` as `id`,"
                . " `user`.`names` as `names`,"
                . " `user`.`username` as `username`,"
                . " `user`.`profile_pic` as `profile_pic`,"
                . " `user`.`google_id` as `google_id`,"
                . " `user`.`user_type` as `user_type`,"
                . " `user_type`.`name` as `name`,"
                . " `user`.`phone` as `phone`,"
                . " `user_type`.`label` as `label` "
                . " FROM `user`"
                . " INNER JOIN `user_type` ON `user`.`user_type` = `user_type`.`id` "
                . " ORDER BY `user`.`id` DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function blank() {
        $array = [];
        foreach ($this->fields as $key => $value) {
            $array[$key] = $value;
        }
        return false;
    }

    function getUser($user_id = 0) {
        if (!$user_id) {
            return $this->blank();
        }

        $sql = "SELECT "
                . " `user`.`id` as `id`,"
                . " `user`.`names` as `names`,"
                . " `user`.`username` as `username`,"
                . " `user`.`corporate` as `corporate`,"
                . " `user`.`profile_pic` as `profile_pic`,"
                . " `user`.`google_id` as `google_id`,"
                . " `user`.`phone` as `phone`,"
                . " `user`.`created` as `created`,"
                . " `user`.`accessed` as `accessed`,"
                . " `user`.`activated` as `activated`,"
                . " `user`.`user_type` as `user_type`,"
                . " `user_type`.`name` as `name`,"
                . " `user_type`.`label` as `label` "
                . " FROM `user`"
                . " INNER JOIN `user_type` ON `user`.`user_type` = `user_type`.`id`"
                . " WHERE `user`.`id` = $user_id "
                . " LIMIT 1";

        $query = $this->db->query($sql);
        return $query->row_array();
    }

    function getUserDuties($user_id) {
        //$data = [];
        $data['units'] = $this->environment->getUser($user_id);
        $data['risks'] = $this->risk->getUser($user_id);
        $data['controls'] = $this->control->getUser($user_id);
        $data['control_activities'] = $this->controlActivity->getUser($user_id);
        $data['complaince_requirements'] = $this->compliance->getUser($user_id);
        $data['compliance_registers'] = $this->complianceRegister->getUser($user_id);
        $data['obligations'] = $this->obligation->getUser($user_id);
        $data['incidents'] = $this->incident->getUser($user_id);
        $data['incident_actions'] = $this->incidentActions->getUser($user_id);

        return $data;
    }

    function getUserDetials($user_id) {
        $user = $this->getUser($user_id);
        $user['duties'] = $this->getUserDuties($user_id);
        return $user;
    }

    function getUsersBy($array = array("id" => 1)) {
        // $this->db->select('id', 'username', 'google_id', 'profile_pic', 'names', 'phone', 'user_type');
        // commment back
        $this->db->where($array);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    function getManagers() {
        return $this->getUsersBy(array("user_type" => 6));
    }

    function getUnitOwners() {
        $unit_owners = $this->getManagers();
        $risk_managers = $this->getRiskManagers();
        $array = [];
        foreach ($unit_owners as $key => $value) {
            $array[] = $value;
        }
        foreach ($risk_managers as $key => $value) {
            $array[] = $value;
        }
        return $array;
    }

    function getCorporateAdmins() {
        return $this->getUsersBy(array("user_type" => 9));
        //return $array;
    }

    function getRiskManagers() {
        return $this->getUsersBy(array("user_type" => 5));
    }
    
    function getAuditors() {
        return $this->getUsersBy(array("user_type" => 8));
    }

    function getStaff() {
        return $this->getUsersBy(array("user_type" => 7));
    }
    
    function getCEO() {
        return $this->getUsersBy(array("user_type" => 2));
    }
    
    function getBoard() {
        return $this->getUsersBy(array("user_type" => 4));
    }
    
    function getCEObyCorp($id) {
        return $this->getUsersBy(array("corporate" => $id, "user_type"=>2));
    }
    function getManagersbyCorp($id) {
        return $this->getUsersBy(array("corporate" => $id, "user_type"=>6));
    }
    function getUnitOwnersbyCorp($id) {
        $unit_owners = $this->getManagersbyCorp($id);
        $risk_managers = $this->getRiskManagers();
        $array = [];
        foreach ($unit_owners as $key => $value) {
            $array[] = $value;
        }
        foreach ($risk_managers as $key => $value) {
            $array[] = $value;
        }
        return $array;
    }

    function getAll() {
        $this->db->where(array("draft" => 0));
        $this->db->order_by("names", "ASC");
        $q = $this->db->get($this->table);
        return $q->result_array();
    }

    function getComplianceOwners() {

        $array = $this->userType->getComplianceOwners();
        $users = array();
        $return = array();
        foreach ($array as $key => $value) {
            $users[count($users)] = $this->getUsersBy(array("user_type" => $value['id']));
        }
        foreach ($users as $key => $value) {
            foreach ($value as $key => $user) {
                $return[count($return)] = $user;
            }
        }
        return $return;
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

    public function auth($username, $password) {
        $this->db->select("id", "username", "password");
        $this->db->from("user");
        $this->db->where("username", $username);
        $this->db->where("password", md5($password));

        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $user = $query->result_array();
            $query = $this->db->query("SELECT * FROM `user` WHERE `id` = {$user[0]["id"]} ");
            $user = $query->row_array();
            $this->createSession($user);
            return true;
        } else {
            return false;
        }
    }

    public function checkLogin() {
        $url_link = isset($_SERVER['PATH_INFO']) ? ($_SERVER['PATH_INFO']) : isset($_SERVER['REDIRECT_QUERY_STRING']) ? $_SERVER['REDIRECT_QUERY_STRING'] : "/account"; // $_SERVER['REDIRECT_QUERY_STRING'];
        $urls = array(
            "/account/logout",
            "/welcome",
            "/welcome/index",
            "/notifications/allNotifications",
        );

        if ((count($this->input->post()) == 0) and ! in_array($url_link, $urls)) {
            $_SESSION[SESSION_INDEX]["GRC"]["redirect"] = $url_link;
        } else {
            $_SESSION[SESSION_INDEX]["GRC"]["redirect"] = "/account";
        }
        if (!isset($_SESSION[SESSION_INDEX])) {
            $_SESSION[SESSION_INDEX]["GRC"]["LOGIN"] = FALSE;
            $_SESSION[SESSION_INDEX]["GRC"]["USER"] = [];
            return false;
        }
        if (!isset($_SESSION[SESSION_INDEX]['GRC'])) {
            $_SESSION[SESSION_INDEX]["GRC"]["LOGIN"] = FALSE;
            $_SESSION[SESSION_INDEX]["GRC"]["USER"] = [];
            return false;
        }
        if (!isset($_SESSION[SESSION_INDEX]['GRC']['LOGIN'])) {
            $_SESSION[SESSION_INDEX]["GRC"]["LOGIN"] = FALSE;
            $_SESSION[SESSION_INDEX]["GRC"]["USER"] = [];
            return false;
        }
        if (!isset($_SESSION[SESSION_INDEX]['GRC']['USER'])) {
            $_SESSION[SESSION_INDEX]["GRC"]["LOGIN"] = FALSE;
            $_SESSION[SESSION_INDEX]["GRC"]["USER"] = [];
            return false;
        }
        if (count($_SESSION[SESSION_INDEX]["GRC"]["USER"]) === 0) {
            $_SESSION[SESSION_INDEX]["GRC"]["LOGIN"] = false;
            return false;
        }
        if (count($_SESSION[SESSION_INDEX]["GRC"]["USER"]) > 0 and $_SESSION[SESSION_INDEX]["GRC"]["LOGIN"]) {
            return true;
        }
    }

    function lockAccount() {
        
    }

    public function createSession($user) {
        //$this->load->model("users/userTypeActionsModel", "userTypeActions");
        $_SESSION[SESSION_INDEX]["GRC"]["LOGIN"] = TRUE;
        $_SESSION[SESSION_INDEX]["GRC"]["USER"] = $user;
        //   $_SESSION[SESSION_INDEX]["GRC"]["USER"]['ACTIONS'] = $this->userTypeActions->getUserTypeActionsList($user['user_type']);
    }

    public function logout() {
        $_SESSION[SESSION_INDEX]["GRC"]["LOGIN"] = FALSE;
        $_SESSION[SESSION_INDEX]["GRC"]["USER"] = [];
        unset($_SESSION[SESSION_INDEX]['GRC']['redirect']);
    }

}
