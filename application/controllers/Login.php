<?php

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("Notification/NotificationModel", "notification");
        $this->load->model("Users/AuthModel", "auth");
        $this->load->model("Users/UserModel", "user");
        $this->load->model("Users/UserTypeModel", "userType");
    }
    
    

    function page($pageName = "", $pageData = array(), $scripts = array(), $stylesheets = array()) {
        if ($this->auth->checkLogin()) {
            redirect("Account/");
        }
        $filename = "Login/$pageName";
        $data['message'] = ($this->input->get("message")) ? "<div style='padding:7px'>" . ucwords($this->input->get("message")) . "</div>" : NULL;
        $data['data'] = $pageData;
        $data['stylesheets'] = $stylesheets;
        $data['scripts'] = $scripts;
        $data['page_title'] = "Welcome To GRC";
        $this->load->view("Includes/HeadView", $data);
        $this->load->view($filename, $data);
        $this->load->view("Includes/LoginFooterView");
    }

    function index() { // login page
        $this->page("LoginView");
    }

    function logout() {
        $this->user->logout();
        redirect("Login/");
    }

    function post() {
        redirect("Account/");
    }

    function authenticate() {
        $this->form_validation->set_rules("username", "Username", "required|valid_email");
        $this->form_validation->set_rules("password", "Password", "required");
        $user = $this->form_validation->run();
        $username = $this->input->post("username");
        $password = $this->input->post("password");
        if ($user and $this->auth->auth($username, $password)) {
            if (am_user_type(array(1, 2, 3, 4, 5, 6, 8, 9, 10))) {
                redirect("Home/dashboard");
            } else if (am_user_type(array(7))) {
                redirect("Account/compliance");
            }
        } else {
            redirect("Login?message=Incorrect Username or Password");
        }
    }

    function emailAuth($key) {
        //$this->user->logout();
        $notification = $this->notification->getAuth($key);
        if ($notification) {
            redirect("Login?message=Please login to proceed");
        } else {
            return false;
        }
    }

    function recoverpassword() {
        $this->page("RecoverUsernameView");
    }

    function passwordrecovery() {


        $username = $this->input->post("username");
        $new_passord = $this->auth->reset($username);

        if ($new_passord) {
            $data = $this->user->getUserByUsername($username);
            //print_pre($data);
            $this->notification->password_reset($data['id'], $new_passord);
             redirect("Login/recoverpassword?message=Recovery Email has been sent");
        } else {
             redirect("Login/recoverpassword?message=Sorry, the system was unable to reset your password.<br> Please contact system admin");
        }
    }

}
