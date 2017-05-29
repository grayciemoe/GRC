<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



if (!function_exists('show_comments')) {

    function show_comments($module = false, $table_name = false, $record_id = false, $parent_id = 0) {
        $ci = & get_instance();
        $ci->load->model('Comments/CommentsModel', "comments");
        $ci->load->model('Audit/IssueModel', "issue");


        $comments = $ci->comments->getComments($module, $table_name, $record_id, $parent_id);
        $issue = $ci->issue->get($record_id);
        if($issue['published_board'] == 1){
           $hid = 'hidden'; 
        }  else {
            $hid = ''; 
        }
        if ($module == "Audit") {

            $audit_script = "";
            $action_form = "Comments/commentAuditPost";
            $texteditor = "
                <div class='card $hid'>
                        <div class='card-block'>
            <input type='hidden' class='form-control'  name='parent' id='txt-g_comments-parent' value='{$parent_id}' placeholder='parent' />
            <input type='hidden' class='form-control'  name='module' id='txt-g_comments-module' value='{$module}' placeholder='module' />
            <input type='hidden' class='form-control'  name='table_name' id='txt-g_comments-table_name' value='{$table_name}' placeholder='table_name' />
            <input type='hidden' class='form-control'  name='record_id' id='txt-g_comments-record_id' value='{$record_id}' placeholder='record_id' />
            <div class='form-group row'>
                        <label  for='txt-issue-comment'  class='col-sm-2 form-control-label'>Comment</label>
                <div class='col-sm-12'>"
                    . "<textarea class='form-control noresize' rows='2'  name='comment' id='txt-issue-comment' placeholder='Make A Comment' ></textarea>"
                    . " </div>
            </div>
            <button type='submit' class='btn btn-info-outline btn-rounded waves-effect waves-light pull-right'><i class='icon icon-speech'></i> Post</button>
            <div class='clearfix'></div>
        </div>
    </div>";
        } else {
            $audit_script = "commentsPost(this . id); return false;";
            $action_form = "Comments/post";
            $texteditor = "
<div class='card'>
        <div class='card-block'>
            <input type='hidden' class='form-control'  name='parent' id='txt-g_comments-parent' value='{$parent_id}' placeholder='parent' />
            <input type='hidden' class='form-control'  name='module' id='txt-g_comments-module' value='{$module}' placeholder='module' />
            <input type='hidden' class='form-control'  name='table_name' id='txt-g_comments-table_name' value='{$table_name}' placeholder='table_name' />
            <input type='hidden' class='form-control'  name='record_id' id='txt-g_comments-record_id' value='{$record_id}' placeholder='record_id' />
            <div class='form-group row'>                        
<label  for='txt-g_comments-comment'  class='col-sm-2 form-control-label'>Comment</label>
                <div class='col-sm-12'>"
                    . "<textarea class='form-control noresize' rows='2'  name='comment' id='txt-g_comments-comment' placeholder='Make A Comment' ></textarea>"
                    . " </div>
            </div>
            <button type='submit' class='btn btn-info-outline btn-rounded waves-effect waves-light pull-right'><i class='icon icon-speech'></i> Post</button>
            <div class='clearfix'></div>
        </div>
    </div>";
        }

        $html = form_open("$action_form", array('id' => "form-$module-$table_name-$record_id", 'class' => '',
                    'onsubmit' => "{$audit_script}"
                )) . "
                
            {$texteditor}
               
    " . form_close() . "
    <div class='card' id=\"comments-$module-$table_name-$record_id\">";


        foreach ($comments as $key => $value):
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

            $html .= "<div class='card-block' id='comments_{$value['id']}'>
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
        endforeach;
        $html .= "</div>";





        return $html;
    }

}


if (!function_exists('count_comments')) {

    function count_comments($module = "user", $table = NULL, $record = "NULL") {
        $ci = & get_instance();
        $ci->load->model('Comments/CommentsModel', "comments");
        $comments = $ci->comments->getComments($module, $table, $record);
        return count($comments);
    }

}

