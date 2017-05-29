<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 
 */
class Chart extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("Users/UserModel", "user");
        $this->load->model("Users/AuthModel", "auth");
        $this->load->model("Users/UserTypeModel", "userType");

        if (!$this->auth->checkLogin()) {
            redirect("Login/?message=Please login to proceed");
        }
    }

    function upload() {
        $this->load->view("Upload");
    }

    function uploadPost() {
        $this->load->model("Upload_direct");
        $this->Upload_direct->upload();
    }

    function piecharts() {
        $this->load->view("Charts/piechart");
    }

    function barcharts() {
        $this->load->view("Charts/bargraph");
    }

    function linecharts() {
        $this->load->view("Charts/linegraph");
    }

    function gauge() {
        $this->load->view("Charts/gauge");
    }

}
