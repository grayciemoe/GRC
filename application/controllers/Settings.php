<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Settings extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("Users/UserModel", "user");
        $this->load->model("Users/AuthModel", "auth");
        $this->load->model("Users/UserTypeModel", "userType");

        if (!$this->auth->checkLogin()) {
            redirect("Login/?message=Please login to proceed");
        }
    }

}
