<?php

class authModel extends CI_Model {

    public $field_keys;

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Africa/Nairobi');
        //$this->load->model("users/userTypeModel", "userType");
    }

    public function auth($username, $password) {
        $this->db->where("username", $username);
        $this->db->limit(1);
        $query = $this->db->get("user");
        if ($query->num_rows() == 0) {
            return FALSE;
        }
        $user = $query->row_array();
        $this->db->where("id", $user['id']);
        $this->db->where("password", md5($password));
        $query = $this->db->get("user");
        if ($query->num_rows() == 1) {
            $user = $query->result_array();
            $query = $this->db->query("SELECT * FROM `user` WHERE `id` = {$user[0]["id"]} ");
            $user = $query->row_array();

            $time = date("Y-m-d H:i:s");
            $this->db->query("UPDATE `user` SET `accessed` = NOW() WHERE `id` = {$user['id']}");
            $this->createSession($user);
            if ((isset($_SESSION['redirect']) and $_SESSION['redirect']) and ( isset($_SESSION['username']) and ( $_SESSION['username'] == $user['username']))) {
                $redirect = $_SESSION['redirect'];
                unset($_SESSION['redirect']);
                unset($_SESSION['username']);
                redirect(str_replace(base_url("index.php"), "", $redirect));
            }
            return true;
        } else {
            return false;
        }
    }

    public function reset($username) {
        $string = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm12345678990!@%&";
        //$data['id'] = $user_id;
        $password = substr(str_shuffle($string), 0, 10);
        $data['password'] = md5($password);
        $this->db->where("username", $username);
        $check = $this->db->update("user", $data);
        return $check ? $password : false;
    }

    public function easyAuth($username, $password) {
        //$this->db->select("id", "username", "password");
        //$this->db->from("user");
        $this->db->where("username", $username);
        $this->db->where("password", $password);

        $query = $this->db->get("user");
        //print_pre($query->row_array());

        if ($query->num_rows() == 1) {
            $user = $query->result_array();

            $query = $this->db->query("SELECT * FROM `user` WHERE `id` = {$user[0]["id"]} ");
            $user = $query->row_array();
            //$this->createSession($user);
            return true;
        } else {
            return false;
        }
    }

    public function checkLogin() {
//        $url_link = isset($_SERVER['PATH_INFO']) ? ($_SERVER['PATH_INFO']) : isset($_SERVER['REDIRECT_QUERY_STRING']) ? $_SERVER['REDIRECT_QUERY_STRING'] : "/account"; // $_SERVER['REDIRECT_QUERY_STRING'];
//        $urls = array(
//            "/account/logout",
//            "/welcome",
//            "/welcome/index",
//            "/notifications/allNotifications",
//        );
//
//        if ((count($this->input->post()) == 0) and ! in_array($url_link, $urls)) {
//            $_SESSION[SESSION_INDEX]["GRC"]["redirect"] = $url_link;
//        } else {
//            $_SESSION[SESSION_INDEX]["GRC"]["redirect"] = "/Account";
//        }
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
        //  $_SESSION[SESSION_INDEX]["GRC"]["USER"]['ACTIONS'] = $this->userTypeActions->getUserTypeActionsList($user['user_type']);
    }

    public function logout() {

        $_SESSION[SESSION_INDEX]["GRC"]["LOGIN"] = FALSE;
        $_SESSION[SESSION_INDEX]["GRC"]["USER"] = [];
        unset($_SESSION[SESSION_INDEX]['GRC']['redirect']);
    }

}
