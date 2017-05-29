<?php

class CommsModel extends CI_Model {

    public $field_keys;

    function __construct() {
        parent::__construct();
    }

    function sendEmail($to = null, $subject = "GRC Notification", $message = NULL, $cc = NULL) {

        $this->load->library('email');
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user'] = SYS_smtp_user;
        $config['smtp_pass'] = SYS_smtp_pass;
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not      

        $this->email->initialize($config);

        $this->email->from(SYS_smtp_user, 'GRC ' . SESSION_INDEX);
        $this->email->to($to);
        if(!empty($cc)){
            $cc = json_decode($cc, TRUE);
            $this->email->cc($cc);
        }
        $this->email->subject($subject);
        $this->email->message($message);

        return $this->email->send();
    }

    function sendSMS() {
        
    }

}

function feedback() {
    
}
