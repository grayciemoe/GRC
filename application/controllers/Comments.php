<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Comments extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("Users/UserModel", "user");
        $this->load->model("Users/AuthModel", "auth");
        $this->load->model("Users/UserTypeModel", "userType");

        if (!$this->auth->checkLogin()) {
            redirect("Login/?message=Please login to proceed");
        }
        $this->load->model("Comments/CommentsModel", "comments");
    }

    function e404Hundler($filepath) {
        if (!file_exists("application/views/" . $filepath . ".php")) {
            $filename = "application/views/" . $filepath . ".php";
            /* echo "Error : File ('$filename') does not exist"; */ return false; // old code file put content removed
        } else {
            return true;
        }
    }

    function modal($modalName = "", $pageData = array()) {

        $filename = "Comments/Modals/" . ucwords($modalName);
        $data['data'] = $pageData;
        $data['me'] = $this->user->getMe();
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
    }

    function commentEditPost() {
        $data = $this->input->post();
        $this->comments->edit($data);
        redirect(ucwords($data['module']).'/'.$data['table_name'].'/'.$data['record_id']);
    }
    
    function commentAuditPost() {
        $data = $this->input->post();
//        print_pre($data);exit;
        $result = $this->comments->add($data);
        if($result){
            redirect("Audit/issue/{$data['record_id']}");
        }  else {
            
        }
        
    }

    function post() {
        $data = $this->input->post();
//        print_pre($data); exit;
        if ($data['comment']) {
            $value = $this->comments->add($data);
            $user = $this->user->getMe();
            $value['user'] = $user['user'];
            $date = str_replace(strftime("%Y", time()), "", str_replace("*", "", str_replace("*0", "", date('F dS Y', strtotime($value['timestamp'])))));
            $time = strftime('%A *%b *%d %Y', strtotime($value['timestamp']));
            $buttons = NULL;
            $delete_link = base_url("index.php/Comments/delete/{$value['id']}");
            $edit_link = base_url("index.php/Comments/edit/{$value['id']}");
            if (am_user_type(1, 5) or $value['user']['id'] == my_id()) {
                if ($value['module'] == "audit") {
                    $buttons = "<a href='$delete_link' class='btn btn-sm btn-small btn-secondary' " . MODAL_LINK . "><i class='icon icon-trash'></i></a>"
                            . "<a href='$edit_link' class='btn btn-sm btn-small btn-secondary' " . MODAL_LINK . "><i class='icon icon-pencil'></i></a>";
                } else {
                    $buttons = "<a href='$delete_link' class='btn btn-sm btn-small btn-secondary' " . MODAL_LINK . "><i class='icon icon-trash'></i></a>";
                }
            }
            $html = "<div class='card-block' id='comments_{$value['id']}'>
                <div class='row'>
                    <div class='col-sm-2 col-md-1 text-center '>
                        <img src='" . img_src($value['user']['profile_pic'], 60, 60) . "' class='img-circle img-responsive' />
                    </div>
                    <div class='col-sm-10 col-md-11'>
                    <div class='text-right pull-right'>
                        <strong  class=' text-right'>" . $date . " </strong>
                        <div class='btn-group'>
                            $buttons
                        </div>
                    </div>
                        <h6 class='card-title  m-b-0'>{$value['user']['names']}</h6>
                        <div class='clearfix'></div>
                        <p>{$value['comment']}</p>
                    </div>
                    

                </div>
                
            </div> <hr class='m-0'>";
            echo $html;
        } else {
            return false;
        }
    }

    function delete($id = 0, $confirm = false) {
        if ($confirm) {
            $this->comments->delete($id);
        } else {
            $data = $this->comments->get($id);
            $this->modal("CommentsDelete", $data);
        }
    }

    function edit($id) {
        $data = $this->comments->getComment($id);
        $this->modal("CommentEdit", $data);
    }

}
