<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NotificationModel extends CI_Model {

    public $table, $fields;
    public $field_keys;

    function __construct() {
        parent::__construct();
        ini_set('max_execution_time', 0);

        $this->table = "g_notification";
        $this->fields = $this->setFields();
        $this->load->helper('email');

        //$this->load->model("Notification/CommsModel", "comms");
        //$this->load->model("Environment/RepositoryModel", "repository");
        //$this->load->model("Users/UserModel", "user");
        //$this->load->model("IncidentManagement/incidentActionsModel", "action");
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

    function getAll($sent = false) {
        if ($sent === 0 or $sent === 1) {
            $this->db->where("message_sent", $sent);
        }
        $this->db->limit(150);
        $this->db->order_by("id", "DESC");
        return $this->db->get($this->table)->result_array();
    }

    function countNewMessages() {
        $me = $this->user->getMe();
        $this->db->where("`username` LIKE '{$me['user']['username']}' AND `message_sent` = 0");
        return $this->db->get($this->table)->num_rows();
    }

    function getMe($sent = false) {
        if ($sent === 0 or $sent === 1) {
            $this->db->where("message_sent", $sent);
        }
        $me = $this->user->getMe();
        $this->db->limit(150);
        $this->db->where("`username` LIKE '{$me['user']['username']}' ");
        $this->db->order_by("id", "DESC");
        return $this->db->get($this->table)->result_array();
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

    function getAuth($key) {
        if ($key and strlen($key) > 1) {
            $record = $this->getRecord("`authKey` = '$key'");
            if (!empty($record['username'])) {
                $user = $this->user->getUserByUsername($record['username']);
                $username = $user['username'];
                $password = $user['password'];
                if ($this->auth->easyAuth($username, $password)) {
                    if ($this->checkLogin($key)) {
                        return true;
                    } else {
                        //$this->auth->logout();
                        $_SESSION['redirect'] = $record['url'];
                        $_SESSION['username'] = $username;
                    }
                    return true;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function checkLogin($key) {
        if ($this->auth->checkLogin()) {
            $user = $this->user->getMe();
            $username = $user['username'];
        } else {
            return false;
        }
        if ($key and strlen($key) > 1) {
            $record = $this->getRecord("`authKey` = '$key'");
        } else {
            return false;
        }
        return (isset($record['username']) and $username == $record['username']) ? true : false;
    }

    function add($data, $boardIdentity = Null) {
        if ((isset($boardIdentity)) && ($boardIdentity == "board")) {
            $data['authKey'] = $boardIdentity;
        } else {
            $data['authKey'] = md5(time() . substr(str_shuffle("1234567890!@#$%^&*()qwertyuiop[]asdfghjkl;'zxcvbnm,./"), 0, 5));
        }

        $user = $this->user->getUserByUsername($data['username']);
        if (isset($user['names'])) {
            $data['description'] = str_replace("<username>", $user['names'], $data['description']);
        } else {
            $data['description'] = str_replace("<username>", NULL, $data['description']);
        }
        if ($data['username'] == $this->user->getMyUsername() or ( strlen($data['username']) == 0)) {
            $data['message_sent'] = 1;
        } else {
            $data['message_sent'] = 0;
        }
        //print_pre($data);
        $check = $this->db->insert($this->table, $this->checkFields($data));
        //exit;
        if ($check) {
            return $this->last();
        } else {
            return false;
        }
    }

    function getRecord($where) {
        $this->db->where($where);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function get($id) {
        $this->db->where("`id` = $id");
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

    function last() {
        $this->db->limit(1);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function delete($id) {
        $this->db->where("`id` = $id");
        return $this->db->delete($this->table);
    }

    function getPending() {
        $this->db->where("message_sent", 0);
        return $this->db->get($this->table)->result_array();
    }

    function autosendEmails() {
        $emails = $this->getPending();
        foreach ($emails as $key => $value) {
            if ($value['authKey'] == "board") {
                $message = $value['description'];
            } else {
                $auth_url = base_url("index.php/Login/emailAuth/" . $value['authKey']);
                $message = str_replace($value['url'], $auth_url, $value['description']);
            }
            $to = $value['username'];
            if (!empty($value['cc'])) {
                $cc = $value['cc'];
            } else {
                $cc = NULL;
            }
            $subject = $value['subject'];
            if ($this->comms->sendEmail($to, $subject, $message, $cc)) {
                $this->edit(array("id" => $value['id'], "message_sent" => 1));
            }
        }
    }

    // -- risk -- //

    function risk_assignment($risk_id) {
        $risk = $this->risk->get($risk_id);
        $owner = $this->user->getUser($risk['risk_owner']);
        // $emails = [];
        $subject = "New Risk Created";
        $url = base_url("index.php/Risk/risk/{$risk['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        //$approved = $repository['approved'] ? "Approved" : "Rejected";
        // $name = $repository['name'];
        $message = "Hi <username>,<br>
The risk <strong>{$risk['title']}</strong>  "
                . "has been created and assigned to "
                . "<strong>{$owner['names']}</strong> as the risk owner. "
                . "Follow this $link to view this risk.";
        $to = $owner['username']; //$this->user->getUnitOwners();

        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        //file_put_contents("txt.txt", "\n\r\t". strftime("%c",time()) . file_get_contents("txt.txt"));
    }

    function risk_approval_request($risk_id) {
        $risk = $this->risk->get($risk_id);
        $owner = $this->user->getUser($risk['risk_owner']);
        // $emails = [];
        $subject = "A new proposed Risk";
        $url = base_url("index.php/Risk/risk/{$risk['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        //$approved = $repository['approved'] ? "Approved" : "Rejected";
        // $name = $repository['name'];
        $message = "Hi <username>,<br>
The risk <strong>{$risk['title']}</strong>  "
                . "has been created and requires approval <br>"
                . "Follow this $link to review this risk.";
        $users = $this->user->getRiskManagers();
        $emails = [];
        foreach ($users as $key => $value) {
            $emails[] = $value['username'];
        }
        $unique = array();
        foreach ($emails as $to) {
            if (in_array($to, $unique) or ! valid_email($to) or ( !$to) or $to == $this->user->getMyUsername()) {
                continue;
            }
            $unique[] = $to;
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
    }

    function risk_create($risk_id) {
        $risk = $this->risk->get($risk_id);
        $repository = $this->repository->getRepository($risk['repository']);
        $environment = $this->environment->get($repository['environment']);
        $unit_owner = $this->user->get($environment['unit_owner']);
        $env = (isset($environment['name']) and $environment['name']) ? $environment['name'] : "Pool";
        $emails = [];
        $subject = "Repository Approval Status";
        $url = base_url("index.php/Home/repository/{$repository['id']}");
        $link = "<a href='" . $url . "'>Click Here</a>";
        $name = $repository['name'];
        $approved = $repository['approved'] ? "Approved" : "Rejected";
        $message = "Hi <username>,<br>
The Key Risk Area <strong>$name </strong> has been <strong>" . $approved . "</strong> $link to view this Key Risk Area";
        $users = $unit_owner['username']; //$this->user->getUnitOwners();
        foreach ($users as $email) {
            $emails[] = $email['username'];
        }
        $unique = [];
        $me = $this->user->getMe();
        foreach ($emails as $to) {
            if (in_array($to, $unique) or ! valid_email($to) or ( !$to) or $to == $this->user->getMyUsername()) {
                continue;
            }
            $unique[] = $to;
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
    }

    function risk_edit($risk_id) {
        $risk = $this->risk->get($risk_id);
        $owner = $this->user->getUser($risk['risk_owner']);
        // $emails = [];
        $subject = "The Risk {$risk['title']} has been edited";
        $url = base_url("index.php/Risk/risk/{$risk['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        //$approved = $repository['approved'] ? "Approved" : "Rejected";
        // $name = $repository['name'];
        $message = "Hi <username>,<br> "
                . "The risk <strong>{$risk['title']}</strong>  "
                . "has been edited. "
                . "Follow this $link to review this risk.";
        $users = $this->user->getRiskManagers();
        $emails = [];
        foreach ($users as $key => $value) {
            $emails[] = $value['username'];
        }
        $unique = [];
        foreach ($emails as $to) {
            if (in_array($to, $unique) or ! valid_email($to) or ( !$to) or $to == $this->user->getMyUsername()) {
                continue;
            }
            $unique[] = $to;
            //$this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
    }

    function risk_analyze($risk_id) {
        $risk = $this->risk->get($risk_id);
        $owner = $this->user->getUser($risk['risk_owner']);
        $subject = "The Risk {$risk['title']} has been analyzed";
        $url = base_url("index.php/Risk/risk/{$risk['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        $message = "Hi <username>,<br>
The risk <strong>{$risk['title']}</strong>  "
                . "has been analyzed  "
                . "Follow this $link to view this risk.";
        $to = $owner['username']; //$this->user->getUnitOwners();

        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
    }

    function risk_evaluate($risk_id) {
        $risk = $this->risk->get($risk_id);
        $owner = $this->user->getUser($risk['risk_owner']);
        $subject = "The Risk {$risk['title']} has been evaluated";
        $url = base_url("index.php/Risk/risk/{$risk['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        $message = "Hi <username>,<br>
The risk <strong>{$risk['title']}</strong>  "
                . "has been evaluated  "
                . "Follow this $link to view this risk.";
        $to = $owner['username']; //$this->user->getUnitOwners();

        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
    }

    // == control work flow notifications == //

    function control_propose($control_id) {
        $control = $this->control->get($control_id);
        $risk = $this->risk->get($control['risk']);
        $owner = $this->user->getUser($risk['risk_owner']);
        // $emails = [];
        $subject = "A new proposed control {$control['title']} has been created";
        $url = base_url("index.php/Risk/control/{$control['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        //$approved = $repository['approved'] ? "Approved" : "Rejected";
        // $name = $repository['name'];
        $message = "Hi <username>,<br>
The proposed control <strong>{$control['title']}</strong>  "
                . "has been created requires approval <br>"
                . "Follow this $link to review this control.";
        $users = $this->user->getRiskManagers();
        $emails = [];
        $unique = [];
        foreach ($users as $key => $value) {
            $emails[] = $value['username'];
        }
        foreach ($emails as $to) {
            if (in_array($to, $unique) or ! valid_email($to) or ( !$to) or $to == $this->user->getMyUsername()) {
                continue;
            }
            $unique[] = $to;
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
    }

    function risk_approved($risk_id) {
        $risk = $this->risk->get($risk_id);
        $risk_owner = $this->user->getUser($risk['risk_owner']);
        // $emails = [];
        $subject = "Risk Approval Status";
        $url = base_url("index.php/Risk/{$risk['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        //$approved = $repository['approved'] ? "Approved" : "Rejected";
        // $name = $repository['name'];
        $message = "Hi <username>,<br>
The risk <strong>{$risk['title']}</strong> has been {$risk['approved']} <br>"
                . "Follow this $link to view this risk.";

        $to = $risk_owner['username'];

        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
    }

    function risk_activation($risk_id) {
        $risk = $this->risk->get($risk_id);
        $risk_owner = $this->user->getUser($risk['risk_owner']);
        // $emails = [];
        $subject = "Risk Activation Status";
        $url = base_url("index.php/Risk/risk/{$risk['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        //$approved = $repository['approved'] ? "Approved" : "Rejected";
        // $name = $repository['name'];
        $status = $risk['status'] == 'Active' ? "activated" : "deactivated";
        $message = "Hi <username>,<br>      
The Risk <strong>{$risk['title']}</strong> has been <strong>$status</strong> <br> Follow this $link to view this risk.";

        $to = $risk_owner['username'];

        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
    }

    function control_approved($control_id) {
        $control = $this->control->get($control_id);
        $control_owner = $this->user->get($control['owner']);
        $risk = $this->risk->get($control['risk']);
        $risk_owner = $this->user->getUser($risk['risk_owner']);
        // $emails = [];
        $subject = "The Control {$control['title']} has been " . $control['approval_status'];
        $url = base_url("index.php/Risk/control/{$control['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        //$approved = $repository['approved'] ? "Approved" : "Rejected";
        // $name = $repository['name'];
        $message = "Hi <username>,<br> The Control <strong>{$control['title']}</strong> has been approved and assigned to <strong> {$control_owner['names']}</strong> as the control owner Follow this $link to view this control.";
        $emails[] = $control_owner['username'];
        $emails[] = $risk_owner['username'];
        $unique = [];
        foreach ($emails as $to) {
            if (in_array($to, $unique) or ! valid_email($to) or ( !$to) or $to == $this->user->getMyUsername()) {
                continue;
            }
            $unique[] = $to;
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
    }

    function control_setInPlace($control_id) {
        $control = $this->control->get($control_id);
        $risk = $this->risk->get($control['risk']);
        $owner = $this->user->getUser($risk['risk_owner']);
        // $emails = [];
        $subject = "Control put In Place";
        $url = base_url("index.php/Risk/control/{$control['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        //$approved = $repository['approved'] ? "Approved" : "Rejected";
        // $name = $repository['name'];
        $message = "Hi <username>,<br>
The control <strong>{$control['title']}</strong>  "
                . "has been put in place<br>"
                . "Follow this $link to view is control.";
        //$users = $this->user->getRiskManagers();
        $emails = [];
        $emails[] = $owner['username'];
        $unique = [];
//        foreach ($users as $key => $value) {
//            $emails[] = $value['username'];
//        }

        foreach ($emails as $to) {
            if (in_array($to, $unique) or ! valid_email($to) or ( !$to) or $to == $this->user->getMyUsername()) {
                continue;
            }
            $unique[] = $to;
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
        //$this->control_approved($control_id);
    }

    // == activity work flow notification == //

    function activity_assignment($activity_id) {
        
    }

    function activity_approved($activity_id) {
        $unique = [];
        $emails = [];
        $activity = $this->activity->get($activity_id);
        $control = $this->control->get($activity['control']);
        $control_owner = $this->user->getUser($control['owner']);
        $emails[] = $control_owner['username'];

        $subject = "Control Activity Approval ";
        $url = base_url("index.php/Risk/control/{$activity['control']}");
        $link = "<a href='" . $url . "'>Link</a>";

        $message = "Hi <username>,<br>
The control activity <strong>{$activity['name']}</strong> 
<hr>
Name : {$activity['name']}<br>
Action by : {$activity['name']}<br>
Control Owner : {$control_owner['names']}<br>
Control : {$control['title']}<br>
Action Due Date : {$activity['action_due_date']}<br>
Status : {$activity['status']}<br>
Approval : {$activity['review_status']}<br>
Criticality : {$activity['criticality']}<br>
    <h5>Description</h5>
{$activity['description']}<br><br>
    

    
" . "Follow this $link to view is control.";
        ;
        $emails[] = $activity['action_by'];
        $owner = $this->user->get($activity['owner']);
        $emails[] = $owner['username'];

        // ($emails);
        foreach ($emails as $to) {
            if (in_array($to, $unique) or ! valid_email($to) or ( !$to) or $to == $this->user->getMyUsername()) {
                continue;
            }
            $unique[] = $to;
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
        // $this->control_approved($control_id);
        //         
    }

    function activity_approval($activity_id) {
//        ($activity_id);
        $emails = [];
        $unique = [];
        $activity = $this->activity->get($activity_id);

        //($activity);
        $subject = "Control Activity Proposed ";
        $url = base_url("index.php/Risk/control/{$activity['control']}");
        $link = "<a href='" . $url . "'>Link</a>";
        //$approved = $repository['approved'] ? "Approved" : "Rejected";
        // $name = $repository['name'];
        $control = $this->control->get($activity['control']);
        $control_owner = $this->user->getUser($control['owner']);


        $message = "Hi <username>,<br>
The control activity <strong>{$activity['name']}</strong> 
<hr>
Name : {$activity['name']}<br>
Action by : {$activity['name']}<br>
Control Owner : {$control_owner['names']}<br>
Control : {$control['title']}<br>
Action Due Date : {$activity['action_due_date']}<br>
Status : {$activity['status']}<br>
Approval : {$activity['review_status']}<br>
Criticality : {$activity['criticality']}<br>
    <h5>Description</h5>
{$activity['description']}<br><br>
    

    
" . "Follow this $link to view is control.";

        $risk_managers = $this->user->getRiskManagers();
        foreach ($risk_managers as $key => $value) {
            $emails[] = $value['username'];
        }
        $owner = $this->user->get($activity['owner']);
        $emails[] = $owner['username'];

        foreach ($emails as $to) {
            if (in_array($to, $unique) or ! valid_email($to) or ( !$to) or $to == $this->user->getMyUsername()) {
                continue;
            }
            $unique[] = $to;
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
        // $this->control_approved($control_id);
        //         
    }

    function activity_create($activity_id) {
//        ($activity_id);

        $activity = $this->activity->get($activity_id);
        //($activity);
        $subject = "A New Control Activity ";
        $url = base_url("index.php/Risk/control/{$activity['control']}");
        $link = "<a href='" . $url . "'>Link</a>";
        //$approved = $repository['approved'] ? "Approved" : "Rejected";
        // $name = $repository['name'];
        $control = $this->control->get($activity['control']);
        $control_owner = $this->user->getUser($control['owner']);


        $message = "Hi <username>,<br>
The control activity <strong>{$activity['name']}</strong> 
<hr>
Name : {$activity['name']}<br>
Action by : {$activity['name']}<br>
Control Owner : {$control_owner['names']}<br>
Control : {$control['title']}<br>
Action Due Date : {$activity['action_due_date']}<br>
Status : {$activity['status']}<br>
Approval : {$activity['review_status']}<br>
Criticality : {$activity['criticality']}<br>
    <h5>Description</h5>
{$activity['description']}<br><br>
    

    
" . "Follow this $link to view is control.";


        $unique = [];
        $emails[] = $activity['action_by'];
        $owner = $this->user->get($activity['owner']);
        $emails[] = $owner['username'];

        // ($emails);
        foreach ($emails as $to) {
            if (in_array($to, $unique) or ! valid_email($to) or ( !$to) or $to == $this->user->getMyUsername()) {
                continue;
            }
            $unique[] = $to;
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
        // $this->control_approved($control_id);
        // 
    }

    // -- compliance  --  //

    function obligation_create($obligation_id) {

        if (!am_user_type(array(5))) {
            $this->obligation_request_approval($obligation_id);
        }
    }

    function obligation_request_approval($obligation_id = 0) {
        $obligation = $this->obligation->get($obligation_id);
        //$risk_owner = $this->user->getUser($risk['risk_owner']);
        // $emails = [];
        $subject = "Obligation Approval";
        $url = base_url("index.php/Compliance/obligation/{$obligation['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        //$approved = $repository['approved'] ? "Approved" : "Rejected";
        // $name = $repository['name'];
        $message = "Hi <username>,<br>
An obligation <strong>{$obligation['title']}</strong> has been created<br>"
                . "Follow this $link to review";
        $emails = [];
        $rms = $this->user->getRiskManagers();
        foreach ($rms as $value) {
            $emails[] = $value['username'];
        }
        foreach ($emails as $to) {
            //$to = $risk_owner['username'];
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
    }

    function obligation_assignment($obligation_id = 0) {
        $obligation = $this->obligation->get($obligation_id);
        //$risk_owner = $this->user->getUser($risk['risk_owner']);
        // $emails = [];
        $subject = "New Obligation Created";
        $url = base_url("index.php/Compliance/obligation/{$obligation['id']}");
        $link = "<a href='" . $url . "'>Link</a>";

        $rm_1 = $this->user->get($obligation['responsible_manager_1']);
        $emails[] = $rm_1['username'];


        $rm_2 = $this->user->get($obligation['responsible_manager_2']);
        $emails[] = $rm_2['username'];
        $message = "Hi <username>,<br>
An obligation <strong>{$obligation['title']}</strong> has been created with the following assignments:<br>"
                . ""
                . "<ul>"
                . "<li>Primary Owner : {$rm_1['names']} </li>"
                . "<li>Secondary Owner : {$rm_2['names']}</li>"
                . "</ul>"
                . "Follow this $link to view the obligation";
        $unique = [];

        foreach ($emails as $to) {
            if (in_array($to, $unique)) {
                continue;
            }
            $unique[] = $to;

            //$to = $risk_owner['username'];
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
    }

    function obligation_approved($obligation_id = 0) {
        return $this->obligation_assignment($obligation_id);
    }

    function obligation_reminder($obligation_id) {
        $obligation = $this->obligation->get($obligation_id);
        //echo __METHOD__;

        if ($obligation['notified'] == 'yes') {
            return false;
        }
        $subject = "Obligation Review Reminder";
        $url = base_url("index.php/Compliance/obligation/{$obligation['id']}");
        $link = "<a href='" . $url . "'>Link</a>";

        $rm_1 = $this->user->get($obligation['responsible_manager_1']);
        $emails[] = $rm_1['username'];

        $rm_2 = $this->user->get($obligation['responsible_manager_2']);
        $emails[] = $rm_2['username'];
        $message = "Hi <username>,<br>
The obligation <strong>{$obligation['title']}</strong> is due on " . strftime("%b %d %Y", (strtotime($obligation['notification_date']))) . " :<br>"
                . ""
                . "Follow this $link to view the obligation";
        $unique = [];

        $obligation['notified'] = "yes";
        $this->obligation->email_sent($obligation_id, $obligation);
        unset($obligation);

        foreach ($emails as $to) {
            if (in_array($to, $unique)) {
                continue;
            }
            $unique[] = $to;

            //$to = $risk_owner['username'];
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
    }

    function obligation_overdue() {
        
    }

    function create_compliance($comply_id) {
        $comply = $this->comply->get($comply_id);
        $obligation = $this->obligation->get($comply['obligations']);
        $subject = "Obligation Comply  ";
        $url = base_url("index.php/Compliance/obligation/{$obligation['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        $message = "Hi <username>,<br>
The Obligation <strong>{$obligation['title']}</strong> has been complied "
                . "Follow this $link to view";
        $emails = [];

        $owner0 = $this->user->get($obligation['responsible_manager_1']);
        $owner1 = $this->user->get($obligation['responsible_manager_2']);

        $emails[] = $owner0['username'];
        $emails[] = $owner1['username'];


        $unique = array();
        foreach ($emails as $to) {
            if (in_array($to, $unique)) {
                continue;
            }
            $unique[] = $to;

            //$to = $risk_owner['username'];
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
    }

    function approve_compliance($comply_id) {
        //echo __METHOD__;
        $comply = $this->comply->get($comply_id);
        $obligation = $this->obligation->get($comply['obligations']);

        $subject = "Obligation Complied ";
        $url = base_url("index.php/Compliance/obligation/{$obligation['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        $message = "Hi <username>,<br>
The obligation  <strong>{$obligation['title']}</strong> has been complied <br>"
                . "Follow this $link to review obligation";
        $emails = [];

        $owner0 = $this->user->get($obligation['responsible_manager_1']);
        //$owner1 = $this->user->get($obligation['responsible_manager_2']);

        $emails[] = $owner0['username'];
        //$emails[] = $owner1['username'];
        $rms = $this->user->getRiskManagers();

        foreach ($rms as $email) {
            $emails[] = $email['username'];
        }
        $unique = array();
        foreach ($emails as $to) {

            if (in_array($to, $unique)) {
                continue;
            }
            $unique[] = $to;

            //$to = $risk_owner['username'];
            ($this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message)));
        }
    }

    function system_breach($breach_id) {
        $breach = $this->breach->get($breach_id);
        $obligation = $this->obligation->get($breach['obligation']);
        $compliance = $this->compliance->get($obligation['compliance_requirement']);
        $subject = $compliance['type'] == 'Statutory Returns' ? "System Breach Created " : "System Late Review ";
        $breach_type = $compliance['type'] == 'Statutory Returns' ? "System Breach " : "System Late Review ";
        $url = base_url("index.php/Compliance/obligation/{$breach['obligation']}");
        $link = "<a href='" . $url . "'>Link</a>";

        $message = "Hi <username>,<br>
A $breach_type <strong>{$breach['title']}</strong> has occured <br>"
                . "Follow this $link to view";
        $emails = [];

        $owner0 = $this->user->get($obligation['responsible_manager_1']);
        $owner1 = $this->user->get($obligation['responsible_manager_2']);
        $owner3 = $this->user->get($obligation['escalation_person']);

        $emails[] = $owner0['username'];
        $emails[] = $owner1['username'];
        $emails[] = $owner3['username'];


        $unique = array();
        foreach ($emails as $to) {
            if (in_array($to, $unique)) {
                continue;
            }
            $unique[] = $to;

            //$to = $risk_owner['username'];
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
    }

    function create_breach($breach_id) {
        $breach = $this->breach->get($breach_id);
        $obligation = $this->obligation->get($breach['obligation']);
        //$compliance = $this->compliance->get($obligation['compliance_requirement']);
        $subject = "Breach Created ";
        $url = base_url("index.php/Compliance/obligation/{$breach['obligation']}");
        $link = "<a href='" . $url . "'>Link</a>";
        $message = "Hi <username>,<br>
A breach <strong>{$breach['title']}</strong> has occured"
                . "Follow this $link to view";
        $emails = [];

        $owner0 = $this->user->get($obligation['responsible_manager_1']);
        $owner1 = $this->user->get($obligation['responsible_manager_2']);

        $emails[] = $owner0['username'];
        $emails[] = $owner1['username'];


        $unique = array();
        foreach ($emails as $to) {
            if (in_array($to, $unique)) {
                continue;
            }
            $unique[] = $to;

            //$to = $risk_owner['username'];
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
    }

    function approve_breach($breach_id) {
        $breach = $this->breach->get($breach_id);
        $obligation = $this->obligation->get($breach['obligation']);
        $subject = "Breach Approval";
        $url = base_url("index.php/Compliance/obligation/{$obligation['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        $message = "Hi <username>,<br>
The obligation <strong>{$obligation['title']}</strong> is overdue and a breach <strong>{$breach['title']}</strong> has been created<br>"
                . "Follow this $link to review the obligation";
        $emails = [];

        $owner0 = $this->user->get($obligation['responsible_manager_1']);
        $owner1 = $this->user->get($obligation['responsible_manager_2']);
        $owner3 = $this->user->get($obligation['escalation_person']);

        $emails[] = $owner0['username'];
        $emails[] = $owner1['username'];
        $emails[] = $owner3['username'];


        $unique = array();
        foreach ($emails as $to) {
            if (in_array($to, $unique)) {
                continue;
            }
            $unique[] = $to;
            //$to = $risk_owner['username'];
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
    }

    // -- incident mamangement -- //


    function incident_create($im_id) {
        //exit;
        $report = $this->incident->getIncidentReport($im_id);
        $emails = [];
        $subject = "Incident Created";
        $url = base_url("index.php/IncidentManagement/incident/{$report['id']}");
        $link = "<a href='" . $url . "'>this link</a>";
        //$message = "Hi <username>, <br> A new incident <strong>{$report['title']}</strong> has been reported.<br> Use $link to access it ";

        $user = $this->user->getUser($report['incident_owner']);

        $emails[] = $user['username'];
        $emails[] = $report['user']['username'];
        $emails[] = $report['responsible_manager']['username'];
        $emails[] = $report['risk']['risk_owner']['username'];
        $rms = $this->user->getRiskManagers();

        foreach ($rms as $email) {
            $emails[$user['names']] = $email['username'];
        }
        $unique = [];
        foreach ($emails as $names => $to) {
            if (!$to or ! valid_email($to)) {
                continue;
            }
            if (in_array($to, $unique)) { // or ($this->user->getUserEmail($this->user->getMyId()))) {
                continue;
            }
            $unique[] = $to;

            $message = "Hi <username>   <br>
    An Incident has been created on the GRC system.<hr>
     <strong>Name :</strong> {$report['title']}<br>
     <strong>Approval Status :</strong> " . ucwords($report['approved']) . "<br>
     <strong>Responsible Manager :</strong> {$report['responsible_manager']['names']} <br>
     <strong>Risk Category :</strong> {$report['risk_category']['title']}<br>
     <strong>Risk Associated :</strong> {$report['risk']['title']}<br>
     <strong>Experience Type :</strong> {$report['experience_type']}<br>
     <strong>Date Reported :</strong> " . strftime("%b %d %Y", strtotime($report['date_reported'])) . "<br>
     <strong>Date of Incident :</strong> " . strftime("%b %d %Y", strtotime($report['date_of_incident'])) . "<br>
<hr>
    Click $link to view the incident.";
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
    }

    function incident_approval($im_id) {
        $report = $this->incident->getIncidentReport($im_id);
        $emails = [];
        $subject = "Incident " . ucwords($report['approved']);
        $url = base_url("index.php/IncidentManagement/incident/{$report['id']}");
        $link = "<a href='" . $url . "'>this link</a>";
        //$message = "Hi <username>, <br> A new incident <strong>{$report['title']}</strong> has been reported.<br> Use $link to access it ";

        $user = $this->user->getUser($report['incident_owner']);

        $emails[] = $user['username'];
        $emails[] = $report['user']['username'];
        $emails[] = $report['responsible_manager']['username'];
        $emails[] = $report['risk']['risk_owner']['username'];
        $rms = $this->user->getRiskManagers();

        foreach ($rms as $email) {
            $emails[$user['names']] = $email['username'];
        }
        $unique = [];
        foreach ($emails as $names => $to) {
            if (!$to or ! valid_email($to)) {
                continue;
            }
            if (in_array($to, $unique)) { // or ($this->user->getUserEmail($this->user->getMyId()))) {
                continue;
            }
            $unique[] = $to;

            $message = "Hi <username>   <br>
   Incident  <strong>{$report['title']}</strong> has been <strong>  " . strtoupper($report['approved']) . "</strong> on the GRC system.<hr>
     <strong>Name :</strong> {$report['title']}<br>
     <strong>Approval Status :</strong> " . ucwords($report['approved']) . "<br>
     <strong>Responsible Manager :</strong> {$report['responsible_manager']['names']} <br>
     <strong>Risk Category :</strong> {$report['risk_category']['title']}<br>
     <strong>Risk Associated :</strong> {$report['risk']['title']}<br>
     <strong>Experience Type :</strong> {$report['experience_type']}<br>
     <strong>Date Reported :</strong> " . strftime("%b %d %Y", strtotime($report['date_reported'])) . "<br>
     <strong>Date of Incident :</strong> " . strftime("%b %d %Y", strtotime($report['date_of_incident'])) . "<br>
<hr>
    Click $link to view the incident.";
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
    }

    function incident_edit($im_id) {
        $report = $this->incident->getIncidentReport($im_id);
        $emails = [];
        //     ($report);
        // $risk_category = $this->riskCategory->get($);
        $subject = "Incident Edited";
        $url = base_url("index.php/IncidentManagement/incident/{$report['id']}");
        $link = "<a href='" . $url . "'>this link</a>";
        $message = "Hi <username>, \r\n A new incident <strong>{$report['title']}</strong> has been edited. \r\n Use $link to access it ";

        $user = $this->user->getUser($report['incident_owner']);

        $emails[] = $user['username'];
        $emails[] = $report['user']['username'];
        $emails[] = $report['risk']['risk_owner']['username'];
        //$user = $this->user->getUserEmail($report['risk']['repository']['environment']['unit_owner']);
        //$emails[] = $user['username'];
        $rms = $this->user->getRiskManagers();

        foreach ($rms as $email) {
            $emails[$user['names']] = $email['username'];
        }
        $unique = [];
        foreach ($emails as $names => $to) {
            if (!$to or ! valid_email($to)) {
                continue;
            }
            if (in_array($to, $unique)) {
                continue;
            }
            $unique[] = $to;

            $message = "Hi <username>   <br>
    An Incident has been edited on the GRC system.<hr>
     Name: {$report['title']}<br>
     Risk Category: {$report['risk_category']['title']}<br>
     Risk Associated: {$report['risk']['title']}<br>
     Experience Type: {$report['experience_type']}<br>
     Date Reported: " . strftime("%b %d %Y", strtotime($report['date_reported'])) . "<br>
     Date of Incident: " . strftime("%b %d %Y", strtotime($report['date_of_incident'])) . "<br>
<hr>
    Click this $link to view the incident.";
            // $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
            //echo $message;
            //$this->comms->sendEmail($to, $subject, $message); // comment to increase speed
        }
    }

    function incident_delete($im_id) {
        $report = $this->incident->getIncidentReport($im_id);
        $emails = [];
        //     ($report);
        // $risk_category = $this->riskCategory->get($);
        $subject = "Incident Deleted";
        $url = base_url("index.php/IncidentManagement/incident/{$report['id']}");
        $link = "<a href='" . $url . "'>this link</a>";
        $message = "Hi <username>, \r\n A new incident <strong>{$report['title']}</strong> has been reported. \r\n Use $link to access it ";

        $user = $this->user->getUser($report['incident_owner']);

        $emails[] = $user['username'];
        $emails[] = $report['user']['username'];
        $emails[] = $report['risk']['risk_owner']['username'];
        //$user = $this->user->getUserEmail($report['risk']['repository']['environment']['unit_owner']);
        //$emails[] = $user['username'];
        $rms = $this->user->getRiskManagers();

        foreach ($rms as $email) {
            $emails[$user['names']] = $email['username'];
        }
        $unique = [];
        foreach ($emails as $names => $to) {
            if (!$to or ! valid_email($to)) {
                continue;
            }
            if (in_array($to, $unique)) {
                continue;
            }
            $unique[] = $to;

            $message = "
Hi   <br>
    An Incident has been deleted on the GRC system.<hr>
     Name: {$report['title']}<br>
     Risk Category: {$report['risk_category']['title']}<br>
     Risk Associated: {$report['risk']['title']}<br>
     Experience Type: {$report['experience_type']}<br>
     Date Reported: " . strftime("%b %d %Y", strtotime($report['date_reported'])) . "<br>
     Date of Incident: " . strftime("%b %d %Y", strtotime($report['date_of_incident'])) . "<br>
<hr>";
            // $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
            //  echo $message;
            //$this->comms->sendEmail($to, $subject, $message); // comment to increase speed
        }
//        echo ($message);
//        ($emails);
//        ($unique);
//        ($report);
//        
    }

    function incident_action_add($im_action) {

        $action = $this->incidentActions->get($im_action);

        $report = $this->incident->getIncidentReport($action['incident']);
        $emails = [];
        $subject = "Incident Action";
        $url = base_url("index.php/IncidentManagement/incident/{$report['id']}");
        $link = "<a href='" . $url . "'>Click Here</a>";


        $message = "Hi <username> <br>

An Incident Action has been created on the GRC system and has been assigned to  {$action['owner']}.
 <hr>
 Incident Name : {$report['title']}<br>
 Action Title : {$action['title']}<br>
 Owner : {$action['owner']}<br>
 Due Date : " . strftime("%b %d %Y", strtotime($action['due_date'])) . "<br>
 Completion Status : {$action['status']}<br>
    

Click this $link to view this incident.
";
        $emails[] = $action['owner'];
        $emails[] = $report['user']['username'];
        $emails[] = $report['risk']['risk_owner']['username'];
        $emails[] = $this->user->getUserEmail($report['risk']['repository']['environment']);
        $rms = $this->user->getRiskManagers();

        foreach ($rms as $email) {
            $emails[] = $email['username'];
        }
        $unique = [];
        foreach ($emails as $to) {
            if (in_array($to, $unique) or ! valid_email($to)) {
                continue;
            }
            $unique[] = $to;

            //$this->comms->sendEmail($to, $subject, $message);
        }
        foreach ($unique as $to) {
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
    }

    function incident_action_edit($im_action) {

        $action = $this->incidentActions->get($im_action);

        $report = $this->incident->getIncidentReport($action['incident']);
        $emails = [];
        $subject = "Incident Action Edit";
        $url = base_url("index.php/IncidentManagement/incident/{$report['id']}");
        $link = "<a href='" . $url . "'>Click Here</a>";


        $message = "Hi <username> <br>

An Incident Action  has been edited from the GRC system 
 <hr>
 Incident Name : {$report['title']}<br>
 Action Title : {$action['title']}<br>
 Owner : {$action['owner']}<br>
 Due Date : " . strftime("%b %d %Y", strtotime($action['due_date'])) . "<br>
 Completion Status : {$action['status']}<br>
    

";
        $emails[] = $action['owner'];
        $emails[] = $report['user']['username'];
        $emails[] = $report['risk']['risk_owner']['username'];
        $emails[] = $this->user->getUserEmail($report['risk']['repository']['environment']);
        $rms = $this->user->getRiskManagers();

        foreach ($rms as $email) {
            $emails[] = $email['username'];
        }
        $unique = [];
        foreach ($emails as $to) {
            if (in_array($to, $unique) or ! valid_email($to) or ( !$to) or $to == $this->user->getMyUsername()) {
                continue;
            }
            $unique[] = $to;
            // $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
            // $this->comms->sendEmail($to, $subject, $message);
        }
    }

    function incident_action_overdue() {
        
    }

    function incident_approve($im_id) {
        $incident = $this->incident->get($im_id);
        $rm = $this->user->get($incident['responsible_manager']);
        $to = $rm['username'];


        // $emails = [];
        $subject = "Incident Approval Status";
        $url = base_url("index.php/IncidentManagement/incident/{$incident['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        //$approved = $repository['approved'] ? "Approved" : "Rejected";
        // $name = $repository['name'];
        $message = "Hi <username>,<br>
The incident <strong>{$incident['title']}</strong> has been {$incident['approved']}"
                . "Follow this $link to view this incident.";


        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
    }

    // -- environment --  //

    function environment_create($unit_id) {
        $report = $this->environment->getUnit($im_id);
        $emails = [];
        $subject = "Incident Created";
        $url = base_url("index.php/IncidentManagement/incident/{$report['id']}");
        $link = "<a href='" . $url . "'>this link</a>";
        $message = "Hi <username>, \r\n A new incident <strong>{$report['title']}</strong> has been reported. \r\n Use $link to access it ";

        $user = $this->user->getUser($report['incident_owner']);

        $emails[] = $user['username'];
        $emails[] = $report['user']['username'];
        $emails[] = $report['responsible_manager']['username'];
        $emails[] = $report['risk']['risk_owner']['username'];
        //$user = $this->user->getUserEmail($report['risk']['repository']['environment']['unit_owner']);
        //$emails[] = $user['username'];
        $rms = $this->user->getRiskManagers();

        foreach ($rms as $email) {
            $emails[$user['names']] = $email['username'];
        }
        $unique = [];
        foreach ($emails as $names => $to) {
            if (!$to or ! valid_email($to)) {
                continue;
            }
            if (in_array($to, $unique)) { // or ($this->user->getUserEmail($this->user->getMyId()))) {
                continue;
            }
            $unique[] = $to;

            $message = "Hi <username>   <br>
    An Incident has been created on the GRC system.<hr>
     Name: {$report['title']}<br>
     Risk Category: {$report['risk_category']['title']}<br>
     Risk Associated: {$report['risk']['title']}<br>
     Experience Type: {$report['experience_type']}<br>
     Date Reported: " . strftime("%b %d %Y", strtotime($report['date_reported'])) . "<br>
     Date of Incident: " . strftime("%b %d %Y", strtotime($report['date_of_incident'])) . "<br>
<hr>
    Click $link to view the incident.";
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
            //   echo $message;
            //$this->comms->sendEmail($to, $subject, $message);  // comment to increase speed
        }
//        echo ($message);
//        ($emails);
//        ($unique);
//        ($report);
//        
    }

    function repository_create($id) {
        $repository = $this->repository->getRepository($id);
        $environment = $this->environment->get($repository['environment']);

        $env = (isset($environment['name']) and $environment['name']) ? $environment['name'] : "Pool";
        // $repository = $this->incident->getIncidentReport($action['incident']);
        //($environment);

        $emails = [];
        $subject = "A New Repository Needs Approval";
        $url = base_url("index.php/Home/repository/{$repository['id']}");
        $link = "<a href='" . $url . "'>Link</a>";


        $message = "Hi <username>,\n
The Key Risk Area <strong>{$repository['name']}</strong> has been created in <strong>{$env}</strong> and needs your approval.

Follow this $link to review this Key Risk Area";

        $rms = $this->user->getRiskManagers();

        foreach ($rms as $email) {
            $emails[] = $email['username'];
        }
        $unique = [];
        foreach ($emails as $to) {
            if (in_array($to, $unique) or ! valid_email($to) or ( !$to) or $to == $this->user->getMyUsername()) {
                continue;
            }
            $unique[] = $to;
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
    }

    function repository_approve($id) {
        $repository = $this->repository->getRepository($id);
        $environment = $this->environment->get($repository['environment']);
        $unit_owner = $this->user->get($environment['unit_owner']);
        $env = (isset($environment['name']) and $environment['name']) ? $environment['name'] : "Pool";
        $emails = [];
        $subject = "Repository Approval Status";
        $url = base_url("index.php/Home/repository/{$repository['id']}");
        $link = "<a href='" . $url . "'>link</a>";
        $name = $repository['name'];
        $approved = $repository['approved'] ? "Approved" : "Rejected";
        $message = "Hi <username>,
The Key Risk Area <strong>$name </strong> has been <strong>" . $approved . "</strong> Follow this $link to view this Key Risk Area";
        $users = $unit_owner['username']; //$this->user->getUnitOwners();
        $emails[] = $users;

        $unique = [];
        foreach ($emails as $to) {
            if (in_array($to, $unique) or ! valid_email($to) or ( !$to) or $to == $this->user->getMyUsername()) {
                continue;
            }
            $unique[] = $to;
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
    }

    function unit_create($id) {
        $environment = $this->environment->get($id);
        $environment_level = $this->environmentLevel->get($environment['environment_level']);
        $owner = $this->user->getUser($environment['unit_owner']);
        $env = (isset($environment['name']) and $environment['name']) ? $environment['name'] : "Pool";
        $emails = [];
        $subject = "A new {$environment_level['name']} has been created";
        $url = base_url("index.php/Home/dashboard/{$environment['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        //$approved = $repository['approved'] ? "Approved" : "Rejected";
        // $name = $repository['name'];
        $message = "Hi <username>,<br>
The <strong>{$environment_level['name']} {$environment['name']}</strong> "
                . "has been created and assigned to "
                . "<strong>{$owner['names']}</strong> as the unit owner "
                . "Follow this $link to view this unit.";
        $to = $owner['username']; //$this->user->getUnitOwners();

        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
    }

    function unit_assign($id) {
        $environment = $this->environment->get($id);
        $environment_level = $this->environmentLevel->get($environment['environment_level']);
        $owner = $this->user->getUser($environment['unit_owner']);
        $env = (isset($environment['name']) and $environment['name']) ? $environment['name'] : "Pool";
        $emails = [];
        $subject = "Unit Assignment";
        $url = base_url("index.php/Home/dashboard/{$environment['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        //$approved = $repository['approved'] ? "Approved" : "Rejected";
        // $name = $repository['name'];
        $message = "Hi <username>,<br>
The <strong>{$environment_level['name']} {$environment['name']}</strong> "
                . "has been created and assigned to "
                . "you as the unit owner "
                . "Follow this $link to view this unit.";
        $to = $owner['username']; //$this->user->getUnitOwners();

        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
    }

    function unit_edit($id) {

        $environment = $this->environment->get($id);
        $environment_level = $this->environmentLevel->get($environment['environment_level']);
        $owner = $this->user->getUser($environment['unit_owner']);
        $env = (isset($environment['name']) and $environment['name']) ? $environment['name'] : "Pool";
        $emails = [];
        $subject = "Unit {$environment['name']} Edited";
        $url = base_url("index.php/Home/dashboard/{$environment['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        $message = "Hi <username>,<br> "
                . "Changes have been made to <strong>{$environment_level['name']} {$environment['name']}</strong>."
                . "<br> The unit is assigned to {$owner['names']}  "
                . "Follow this $link to view this unit.";
        $to = $owner['username']; //$this->user->getUnitOwners();
        // $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
    }

    function user_create($user_id) {
        $user = $this->user->getUser($user_id);
        $emails[] = $user['username'];
        $subject = "Welcome To GRC";
        $url = base_url("index.php/Account/profile/?message=Please change your password#Change_Password");
        $link = "<a href='" . $url . "'>Link</a>";
        $message = "Hi <username>,<br>
An account has been created for you as {$user['name']} with the details below :<br>
Username : {$user['username']}<br>
Password : " . ($this->user->userPasswordGen($user_id)) . "<br>
<br>
Kindly access the system through this $link.";

        $unique = [];
        foreach ($emails as $to) {
            if (in_array($to, $unique) or ! valid_email($to) or ( !$to) or $to == $this->user->getMyUsername()) {
                continue;
            }
            $unique[] = $to;
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
        }
    }

    function password_reset($user_id, $new_password) {

        $user = $this->user->getUser($user_id);
        //$user_type = $this->userType->get($user['user_type']);
        // print_pre($user);
        $emails[] = $user['username'];
        $subject = "GRC System Password Reset";
        $url = base_url("index.php/Account/profile/?message=Please change your password#Change_Password");
        $link = "<a href='" . $url . "'>Link</a>";
        $message = "Hi <username>,<br>
Your GRC Password has been reset to :<br>
Password :  {$new_password}
<br>
<br>
Kindly access the system through this  $link .";

        $unique = [];
        foreach ($emails as $to) {
            if (in_array($to, $unique) or ! valid_email($to) or ( !$to) or $to == $this->user->getMyUsername()) {
                continue;
            }
            $unique[] = $to;
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
            // $this->comms->sendEmail($to, $subject, $message);
        }
    }

    // -- environment -- //
    // *********** Audit Notifications ******** //

    /*
     * Function to send notification when an issue is 
     * published to management
     * 
     */
    function issuePublishedtoManagement($id) {
        $issue = $this->issue->get($id);
        $owner = $this->user->getUser($issue['issue_owner']);
        $audit = $this->audit->get($issue['audit']);
        $sql = "SELECT * FROM `response_due` WHERE `issue` = $id AND `recipient` = 'management' ORDER BY `id` DESC LIMIT 1";
        $response_date = $this->db->query($sql)->row_array();
        $to = $owner['username'];
        $url = base_url("index.php/Audit/issue/" . $issue['id']);
        $link = "<a href='" . $url . "'>Link</a>";
        $subject = 'New Audit Issue Has Been Published';
        $message = "Dear " . $owner['names'] . ", <br>
            <br>
        The issue <strong>" . $issue['title'] . "</strong> has been published to management 
        under the audit <strong>" . $audit['audit_name'] . "</strong> and has been assigned to you as the issue owner. <br>
        Kindly add your management comment by <strong>" . strftime("%b-%d-%Y", strtotime($response_date['respond_by_date'])) . "</strong> <br>
        Follow this $link to access the system. 
            <br>
            <br>
        GRC";
        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message));
    }

    function issuePublishedtoCEO($id) {
        $issue = $this->issue->get($id);
        $ceo = $this->user->getCEObyCorp($issue['corporate']);
        if (empty($ceo)) {
            return FALSE;
        } else {

            $owner = $this->user->getUser($issue['issue_owner']);
            $audit = $this->audit->get($issue['audit']);
            $sql = "SELECT * FROM `response_due` WHERE `issue` = $id AND `recipient` = 'ceo' ORDER BY `id` DESC LIMIT 1";
            $response_date = $this->db->query($sql)->row_array();
            if ((isset($response_date['respond_by_date'])) && (!empty($response_date['respond_by_date']))) {
                $response_txt = "Kindly review the management comment by <strong>" . strftime("%b-%d-%Y", strtotime($response_date['respond_by_date'])) . "</strong>";
            } else {
                $response_txt = "";
            }
            $to = $ceo[0]['username'];
            $cc = json_encode(array($owner['username']));
            $url = base_url("index.php/Audit/issue/" . $issue['id']);
            $link = "<a href='" . $url . "'>Link</a>";
            $subject = 'New Audit Issue Has Been Published';
            $message = "Dear " . $ceo[0]['names'] . ", <br>
        The issue <strong>" . $issue['title'] . "</strong> has been published to CEO 
        under the audit <strong>" . $audit['audit_name'] . "</strong> and has been assigned to " . $owner['names'] . " as the issue owner. <br>
         $response_txt <br>
        Follow this $link to access the system. <br>
            <br>

        GRC";
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message, "cc" => $cc));
        }
    }

    function issuePublishedtoBoard($id) {
        $audit = $this->audit->get($id);
        $board = $this->user->getBoard();
        $boardIdentity = "board";
        $where = array("table_name" => 'audit_report', "record_id" => $id);
        $file = $this->doc->getRecordDocuments($where);
        $url = getFileLink($file[0]['filename']);
        $link = "<a href='" . $url . "'>Link</a>";
        $subject = 'New Audit Report Has Been Published';
        foreach ($board as $key => $value) {
            $to = $value['username'];
            $message = "Dear " . $value['names'] . ", <br>
            The Audit <strong>" . $audit['audit_name'] . "</strong> has been published to Board <br>
            Follow this $link to access the Audit Report and Review. <br>
            <br>
            GRC";
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message), $boardIdentity);
        }
    }

    function managementCommentReminder($id) {
        $issue = $this->issue->get($id);
        $owner = $this->user->getUser($issue['issue_owner']);
        $audit = $this->audit->get($issue['audit']);
        $auditor = $this->user->getUser($audit['auditor']);
        $sql = "SELECT * FROM `response_due` WHERE `issue` = $id AND `recipient` = 'management' ORDER BY `id` DESC LIMIT 1";
        $response_date = $this->db->query($sql)->row_array();
        $to = $owner['username'];
        $cc = json_encode(array($auditor['username']));
        $url = base_url("index.php/Audit/issue/{$issue['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        $subject = 'Audit Issue Needs Management comment';
        $message = "Dear " . $owner['names'] . " <br> <br>
                The issue <strong>" . $issue['title'] . "</strong> 
            under the audit <strong>" . $audit['audit_name'] . "</strong> 
            needs your management comment by <strong>" . strftime("%b-%d-%Y", strtotime($response_date['respond_by_date'])) . "</strong> <br>
        Kindly add your management comment by <strong>" . strftime("%b-%d-%Y", strtotime($response_date['respond_by_date'])) . "</strong> <br>
        Follow this $link to access the system. <br>
            <br>
        GRC";
        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message, "cc" => $cc));
    }

    function managementCommentOverdue($id) {
        $issue = $this->issue->get($id);
        $owner = $this->user->getUser($issue['issue_owner']);
        $audit = $this->audit->get($issue['audit']);
        $auditor = $this->user->getUser($audit['auditor']);
        $sql = "SELECT * FROM `response_due` WHERE `issue` = $id AND `recipient` = 'management' ORDER BY `id` DESC LIMIT 1";
        $response_date = $this->db->query($sql)->row_array();
        $to = $owner['username'];
        $cc = json_encode(array($auditor['username']));
        $url = base_url("index.php/Audit/issue/{$issue['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        $subject = 'Management Comment Overdue';
        $message = "Dear " . $owner['names'] . " <br> <br>
                The issue <strong>" . $issue['title'] . "</strong> "
                . "under the audit <strong>" . $audit['audit_name'] . "</strong>"
                . " needed your management comment by <strong>" . strftime("%b-%d-%Y", strtotime($response_date['respond_by_date'])) . "</strong> <br>"
                . "Follow this $link to access the system and add your management comment. <br> "
                . "<br>"
                . " GRC";
        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message, "cc" => $cc));
    }

    function managementCommentAdded($id) {
        $comment = $this->auditComment->get($id);
        $issue = $this->issue->get($comment['issue']);
        $editor = $this->user->getUser($comment['user']);
        $owner = $this->user->getUser($issue['issue_owner']);
        $audit = $this->audit->get($issue['audit']);
        $auditor = $this->user->getUser($audit['auditor']);
        $ceo = $this->user->getCEObyCorp($issue['corporate']);
        if (!empty($ceo)) {
            $ceo = $ceo[0]['username'];
            array_push($ceo, $owner['username']);
            $cc = json_encode($ceo);
        } else {
            $cc = json_encode(array($owner['username']));
        }
        $to = $auditor['username'];
        $url = base_url("index.php/Audit/issue/{$issue['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        $subject = 'Management comment has been added';
        $message = "Dear " . $auditor['names'] . ", <br>
        A management comment under the issue <strong>" . $issue['title'] . "</strong> 
        has been added by " . $editor['names'] . " <br>
        Follow this $link to access the system. <br> 
            <br>

        GRC";
        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message, "cc" => $cc));
    }

    function managementCommentEdited($id) {
        $comment = $this->auditComment->get($id);
        $issue = $this->issue->get($comment['issue']);
        $editor = $this->user->getUser($comment['user']);
        $owner = $this->user->getUser($issue['issue_owner']);
        $audit = $this->audit->get($issue['audit']);
        $auditor = $this->user->getUser($audit['auditor']);
        $ceo = $this->user->getCEObyCorp($issue['corporate']);
        if (!empty($ceo)) {
            $ceo = $ceo[0]['username'];
            array_push($ceo, $owner['username']);
            $cc = json_encode($ceo);
        } else {
            $cc = json_encode(array($owner['username']));
        }
        $to = $auditor['username'];
        $url = base_url("index.php/Audit/issue/{$issue['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        $subject = 'Management Comment Has Been Edited';
        $message = "Dear " . $auditor['names'] . ", <br>
        The management comment under the issue <strong>" . $issue['title'] . "</strong> 
        has been edited by " . $editor['names'] . " <br>
        Follow this $link to access system. <br> 
            <br>

        GRC";
        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message, "cc" => $cc));
    }

    function auditorCommentAdded($id) {
        $comment = $this->auditComment->get($id);
        $issue = $this->issue->get($comment['issue']);
        $editor = $this->user->getUser($comment['user']);
        $owner = $this->user->getUser($issue['issue_owner']);
        $audit = $this->audit->get($issue['audit']);
        $auditor = $this->user->getUser($audit['auditor']);
        $ceo = $this->user->getCEObyCorp($issue['corporate']);
        if (!empty($ceo)) {
            $ceo[] = $ceo[0]['username'];
            array_push($ceo, $auditor['username']);
            $cc = json_encode($ceo);
        } else {
            $cc = json_encode(array($auditor['username']));
        }
        $to = $owner['username'];
        $url = base_url("index.php/Audit/issue/{$issue['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        $subject = 'Auditor Comment Has Been Added';
        $message = "Dear " . $owner['names'] . ", <br>
        An auditor's comment has been added under the issue <strong>" . $issue['title'] . "</strong> <br>
        Follow this $link to access the system. <br> 
            <br>

        GRC";
        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message, "cc" => $cc));
    }

    function auditorCommentEdited($id) {
        $comment = $this->auditComment->get($id);
        $issue = $this->issue->get($comment['issue']);
        $editor = $this->user->getUser($comment['user']);
        $owner = $this->user->getUser($issue['issue_owner']);
        $audit = $this->audit->get($issue['audit']);
        $auditor = $this->user->getUser($audit['auditor']);
        $ceo = $this->user->getCEObyCorp($issue['corporate']);
        if (!empty($ceo)) {
            $ceo[] = $ceo[0]['username'];
            array_push($ceo, $auditor['username']);
            $cc = json_encode($ceo);
        } else {
            $cc = json_encode(array($auditor['username']));
        }
        $to = $owner['username'];
        $url = base_url("index.php/Audit/issue/{$issue['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        $subject = 'Auditor Comment Has Been Edited';
        $message = "Dear " . $owner['names'] . ", <br>
        An auditor's comment has been edited under the issue <strong>" . $issue['title'] . "</strong> <br>
        Follow this $link to access the system. <br> 
            <br>

        GRC";
        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message, "cc" => $cc));
    }

    function managementActionPlanCreated($id) {
        $actionPlan = $this->action_plans->get($id);
        $issue = $this->issue->get($actionPlan['issue']);
        $owner = $this->user->getUser($issue['issue_owner']);
        $audit = $this->audit->get($issue['audit']);
        $auditor = $this->user->getUser($audit['auditor']);
        $to = $auditor['username'];
        $cc = json_encode(array($owner['username']));
        $url = base_url("index.php/Audit/issue/{$issue['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        $subject = 'Management Action Plan Has Been Created';
        $message = "Dear " . $auditor['names'] . ", <br>
        A management action plan <strong>" . $actionPlan['action_plan'] . "</strong> under the issue <strong>" . $issue['title'] . "</strong> has been created and requires your approval. <br>
        Follow this $link to access the system. <br> 
            <br>

        GRC";
        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message, "cc" => $cc));
    }

    function managementActionPlanApprovalStatus($id) {
        $actionPlan = $this->action_plans->get($id);
        $issue = $this->issue->get($actionPlan['issue']);
        $owner = $this->user->getUser($issue['issue_owner']);
        $audit = $this->audit->get($issue['audit']);
        $auditor = $this->user->getUser($audit['auditor']);
        if ($actionPlan['approval_status'] == 'Yes') {
            $to = $actionPlan['assigned_to'];
            $cc = json_encode(array($owner['username'], $auditor['username']));
            $url = base_url("index.php/Audit/issue/{$issue['id']}");
            $link = "<a href='" . $url . "'>Link</a>";
            $subject = 'New Management Action Plan Has Been Assigned';
            $message = "Hi " . $actionPlan['assigned_to'] . ", <br>
            A new management action plan <strong>" . $actionPlan['action_plan'] . "</strong> has been added 
            under the issue <strong>" . $issue['title'] . "</strong> and has been assigned to you as the action plan owner. <br>
            Follow this $link to access the issue and review. <br> <br>
            GRC";
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message, "cc" => $cc));
        } elseif ($actionPlan['approval_status'] == 'No') {
            $to = $owner['username'];
            $cc = json_encode(array($auditor['username']));
            $url = base_url("index.php/Audit/issue/{$issue['id']}");
            $link = "<a href='" . $url . "'>Link</a>";
            $subject = 'Management Action Plan Has Been Rejected';
            $message = "Dear " . $owner['names'] . ", <br>
            Management action plan <strong>" . $actionPlan['action_plan'] . "</strong>
            under the issue <strong>" . $issue['title'] . "</strong> has been rejected. <br>
            Follow this $link to access the system. <br> 
                <br>
            GRC";
            $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message, "cc" => $cc));
        }
    }

    function managementActionPlanImplementationStatus($id) {
        $actionPlan = $this->action_plans->get($id);
        $issue = $this->issue->get($actionPlan['issue']);
        $owner = $this->user->getUser($issue['issue_owner']);
        $audit = $this->audit->get($issue['audit']);
        $auditor = $this->user->getUser($audit['auditor']);
        $to = $auditor['username'];
        $cc = json_encode(array($owner['username']));
        $url = base_url("index.php/Audit/issue/{$issue['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        $subject = 'Management Action Plan Has Been ' . ucwords($actionPlan['implementation_status']) . '';
        $message = "Dear " . $auditor['names'] . ", <br> 
            Management action plan <strong>" . $actionPlan['action_plan'] . "</strong> 
            under the issue <strong>" . $issue['title'] . "</strong> has been <strong>" . $actionPlan['implementation_status'] . "</strong>. <br>
            and requires to be verified <br>
            Follow this $link to access the system. <br> 
                <br>
            GRC";
        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message, "cc" => $cc));
    }

    function managementActionPlanVerified($id) {
        $actionPlan = $this->action_plans->get($id);
        $issue = $this->issue->get($actionPlan['issue']);
        $owner = $this->user->getUser($issue['issue_owner']);
        $audit = $this->audit->get($issue['audit']);
        $auditor = $this->user->getUser($audit['auditor']);
        $to = $owner['username'];
        $cc = json_encode(array($auditor['username']));
        $url = base_url("index.php/Audit/issue/{$issue['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        $subject = 'Management Action Plan Verification';
        $message = "Dear " . $owner['names'] . ", <br>
            Management action plan <strong>" . $actionPlan['action_plan'] . "</strong> 
            under the issue <strong>" . $issue['title'] . "</strong> has been Verified. <br>
            Follow this $link to access the system. <br> 
                <br>
                
            GRC";
        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message, "cc" => $cc));
    }

    function managementActionPlanUnverified($id) {
        $actionPlan = $this->action_plans->get($id);
        $issue = $this->issue->get($actionPlan['issue']);
        $owner = $this->user->getUser($issue['issue_owner']);
        $audit = $this->audit->get($issue['audit']);
        $auditor = $this->user->getUser($audit['auditor']);
        $to = $owner['username'];
        $cc = json_encode(array($auditor['username']));
        $url = base_url("index.php/Audit/issue/{$issue['id']}");
        $link = "<a href='" . $url . "'>Link</a>";
        $subject = 'Management Action Plan Verification';
        $message = "Dear " . $owner['names'] . ", <br>
            Management action plan <strong>" . $actionPlan['action_plan'] . "</strong> status 
            under the issue <strong>" . $issue['title'] . "</strong> has been Rejected. <br>
            It's current implementation status has therefore been reset to outstanding. <br>
            Follow this $link to access the system. <br> 
                <br>
                
            GRC";
        $this->add(array("username" => $to, "url" => $url, "subject" => $subject, "description" => $message, "cc" => $cc));
    }

    // *********** End Audit Notifications ****** //
}
