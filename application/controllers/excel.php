<?php

class excel extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {

        function date_correct($date) {
            $array = explode("/", $date);
            $date = $array[2] . "-" . $array[0] . "-" . $array[1] . " 00:00:00";
            return $date;
        }

        function notification_date($submission_deadline) {
            $array = explode("/", $submission_deadline);
            $date = $array[2] . "-" . $array[0] . "-" . ($array[1] - 1) . " 00:00:00";
            return $date;
        }

        $row = 1;
        echo "<pre>";
        $array = "array(<br>";

        if (($handle = fopen("../eare.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($row == 1) {
                    $row++;
                    continue;
                }
                $row++;
                //print_pre($data);


                $d_array['title'] = $data[0];
                $compliance_requirement = $data[1];
                $d_array['compliance_requirement'] = $compliance_requirement;
                $d_array['authority'] = 0;
                $authority = $data[2];

                $d_array['escalation_person'] = $data[3];
                $d_array['frequency'] = $data[4];
                $d_array['document_name'] = ($data[5]);
                $d_array['fcp'] = date_correct($data[6]);
                $d_array['last_submission_date'] = date_correct($data[7]);
                $d_array['submission_deadline'] = date_correct($data[7]);
                $d_array['notification_date'] = notification_date($data[7]);
                $d_array['activity'] = $data[10];
                $d_array['last_submission_status'] = $data[12];
                $d_array['approved'] = 'approved';








                //echo $row;
                //print_pre($d_array);

                $auth = $this->db->query("select * from `authority` where `title` like '$authority' limit 1")->row_array();

                if ($auth) {
                    $d_array['authority'] = $auth['id'];
                } else {
                    //$this->db->query("insert into `authority` (`type`,`title`,`user`) values ('legal','$authority','1'); ");
                }
                $cr = $this->db->query("select * from `compliance_requirement` where `title` like '$compliance_requirement' limit 1")->row_array();

                if ($cr) {
                    $d_array['compliance_requirement'] = $cr['id'];
                } else {
                    $sql = "insert into `compliance_requirement` "
                            . "(`repository`,`type`,`environment`,`title`,`user`) values "
                            . "(63,'Statutory Returns',1,'$compliance_requirement','1'); ";
                    echo $sql;
                    //$this->db->query($sql);
                }

                print_pre($d_array);
                //echo $this->db->insert("obligations", $d_array) ? "Insert Success" : "Error";
                echo "<br>";
            }
            $array .= ");<br>\n";
            fclose($handle);
        }
    }

}
