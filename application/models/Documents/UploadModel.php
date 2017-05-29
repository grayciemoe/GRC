<?php
//
//require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
//
//use google\appengine\api\cloud_storage\CloudStorageTools;

//if ($_SERVER['HTTP_HOST'] != 'localhost') {
//    exit("Uncomment Line 2 to 5 in " . __FILE__);
//}

class uploadModel extends CI_Model {

    private $tableName, $tableFields;
    public $destination;
    public $field_keys;

    function __construct() {
        $this->destination = array('module' => NULL, 'table_name' => NULL, 'record_id' => 0);
        $this->tableFields = array("user" => NULL, 'filetype' => NULL, 'filename' => NULL, 'newname' => NULL, 'title' => NULL, 'caption' => NULL, 'uploaded' => time(), 'created' => time(), 'accessed' => time(), 'modified' => time(), 'fileinfo' => time(), 'status' => time());
        $this->tableName = "upload";
        //$this->load->model("Documents/cropModel");
        parent::__construct();
    }

    function upload($config, $index, $module = "user", $table_name = "user", $record_id = false) {
        $option = ['gs_bucket_name' => UPLOAD_BACKET];
        $upload_ur = CloudStorageTools::createUploadUrl('', $option);
        $upload_ur;
        $newFileName = $_FILES[$index]['name'];
        $source = $_FILES[$index]['tmp_name'];
        $fileArray = explode(".", $newFileName);
        $fileExt = $fileArray[count($fileArray) - 1];
        $filename = md5(time() . rand(1, 10000)) . "." . $fileExt;
        $config['file_name'] = $filename;
        //$this->load->library('upload', $config);
        $upload = ((move_uploaded_file($source, UPLOAD_PATH . $filename)));
        if (!$upload) {
            unset($config);
            return false;
        } else {
            //$data = $this->upload->data();
            $data['file_name'] = $filename;
            $data['file_name'] = $this->cropModel->toJpeg(UPLOAD_FOLDER, $data['file_name']);
            $data['module'] = $module;
            $data['table_name'] = $table_name;
            $data['record_id'] = $record_id ? $record_id : 0;
            $this->add($data);
            unset($config);
            return $data['file_name'];
        }
    }

    function multipleUpload($index, $module = "user", $table_name = "user", $record_id = false) {
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            return [];
        }
        $uploads = array();
        foreach ($_FILES[$index]['name'] as $key => $value) {
            $option = ['gs_bucket_name' => UPLOAD_BACKET];
            $upload_ur = CloudStorageTools::createUploadUrl('/upload', $option);
            $upload_ur;
            $newFileName = $value;
            $fileArray = explode(".", $newFileName);
            $fileExt = $fileArray[count($fileArray) - 1];
            $data['file_name'] = md5(time() . rand(1, 10000)) . "." . $fileExt;
            $data['file_size'] = $_FILES[$index]['size'][$key];
            $data['source'] = $_FILES[$index]['tmp_name'][$key];
            $data['file_type'] = $_FILES[$index]['type'][$key];
            $data['client_name'] = $value;
            $data['module'] = $module;
            $data['table_name'] = $table_name;
            $data['record_id'] = $record_id ? $record_id : 0;
            if (!accept_file($data['file_type'])) {
                continue;
            }
            if ((move_uploaded_file($data['source'], UPLOAD_PATH . $data['file_name']))) {
                $this->add($data);
                $uploads[count($uploads)] = $data['file_name'];
            }
        }
        return $uploads;
    }

    function uploadMultipleFiles($index) {
        $config['upload_path'] = UPLOAD_PATH;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        return $this->multipleUpload($index);
    }

    function uploadImage($index, $destination = false) {
        if ($destination) {
            $this->destination = $destination;
        }
        $config['upload_path'] = UPLOAD_PATH;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '50000000000';
        $config['max_width'] = '10000';
        $config['max_height'] = '12000';

        $filename = $this->upload($config, $index);
        if ($filename) {
            $this->cropModel->crop($filename, 300, 300);
        }
        return $filename;
    }

    function add($data) {
        $me = $this->user->getMyId();
        $user = $_SESSION[SESSION_INDEX]['GRC']['USER']['id'];

        $this->tableFields['module'] = $this->destination['module'];
        $this->tableFields['table_name'] = $this->destination['table_name'];
        $this->tableFields['record_id'] = $this->destination['record_id'];
        $this->tableFields['filetype'] = (isset($data['file_type']) and $data['file_type']) ? $data['file_type'] : "UNKNOWN";
        $this->tableFields['filename'] = (isset($data['file_name']) and $data['file_name']) ? $data['file_name'] : "UNKNOWN";
        $this->tableFields['newname'] = (isset($data['file_name']) and $data['file_name']) ? $data['file_name'] : "UNKNOWN";
        $this->tableFields['title'] = (isset($data['client_name']) and $data['client_name']) ? $data['client_name'] : "No Name";
        $this->tableFields['caption'] = (isset($data['client_name']) and $data['client_name']) ? $data['client_name'] : "No Caption";
        $this->tableFields['user'] = $user;
        $this->db->insert($this->tableName, $this->tableFields);
    }

}
