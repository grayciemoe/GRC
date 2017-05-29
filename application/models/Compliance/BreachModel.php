<?php

class breachModel extends CI_Model {

    public $table, $fields, $risk_sources_initials;
    public $field_keys;

    function __construct() {
        parent::__construct();
        $this->table = "breach";
        $this->fields = $this->setFields();
        //$this->load->model("Users/UserModel", "user");
        //$this->load->model("Compliance/ObligationModel", "obligation");

        $this->risk_sources_initials = array(
            "best_practices" => "BP",
            "contract" => "CTT",
            "corporate_policy" => "CP",
            "laws_and_regulations" => "LR",
            "process" => "PS",
            "strategic_objectives" => "SO",
        );
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

    function exists($data) {
        $obligation_date = isset($data['obligation_date']) ? $data['obligation_date'] : false;
        $obligation = isset($data['obligation']) ? $data['obligation'] : false;
        $this->db->where(array("obligation" => $obligation, "obligation_date" => $obligation_date));
        $q = $this->db->get($this->table);
        $this->db->flush_cache();
        return $q->num_rows() === 0 ? true : false;
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

    function refCode($id) {
        return false;
    }

    function add($data) {
        $me = $this->user->getMe();
        $data['user'] = $me['user']['id'];
        $check = $this->db->insert($this->table, $this->checkFields($data));
        if ($check) {
            $last = $this->last();
            return $last;
        } else {
            return false;
        }
    }

    function create($obligation_id, $status = "no") {
        $me = $this->user->getMe();
        $freq = array(
            'annually' => "Year",
            'semi annually' => "Half",
            'quarterly' => "Quarter",
            'monthly' => "Month",
            'weekly' => "Week",
            'daily' => "Day");

        $obligation = $this->obligation->get($obligation_id);
        $data['obligation'] = $obligation['id'];
        $data['user'] = $me['user']['id'];
        $data['title'] = "Not complied : " . $obligation['title'] . " : " . $obligation['submission_deadline'];
        $data['status'] = "open";
        $data['ref_code'] = $obligation['ref_code'];
        $data['submission_deadline'] = $obligation['submission_deadline'];
        $data['period'] = $obligation['next_submission_period'];
        $data['period_name'] = $freq[$obligation['frequency']];
        $data['period_initials'] = substr($data['period_name'], 0, 1);
        $breach = $this->add($data);
        return $breach;
    }

    function get($id) {
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function getTotalPenalty() {
        return $this->db->query("SELECT SUM(`penalty`) AS `penalty` FROM `$this->table` WHERE `approved` LIKE 'approved' AND `draft` = 0 AND `delete` = 0")->row_array();
    }

    function getTotalObligationPenalty($obligation) {
        return $this->db->query("SELECT SUM(`penalty`) AS `penalty` FROM `$this->table` WHERE `approved` LIKE 'approved' AND `draft` = 0 AND `delete` = 0 AND `obligation` = $obligation ")->row_array();
    }

    function getApprovedBreaches() {
        $this->db->where("`approved` LIKE 'approved'");
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    function getBreach($breach) {
        $breach = $this->get($breach);
        if (!$breach) {
            return false;
        }
        $breach['obligation'] = $this->obligation->get($breach['obligation']);
        $breach['compliance_requirement'] = $this->complianceRequirement->get($breach['obligation']['compliance_requirement']);
        $breach['compliance_register'] = $this->complianceRequirement->get($breach['compliance_requirement']['compliance_register']);
        return $breach;
    }

    function getBreachType($type) {
        $this->db->where("type", $type);
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['obligations'] = $this->obligation->getAuthority($value['id']);
        }
        return $results;
    }

    function edit($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        if ($key) {
            $data['draft'] = 0;
            $record = $this->breach->get($key);
            $this->db->where("`id` =  $key");
            $check = $this->db->update($this->table, $this->checkFields($data));

            if ($check) {
                //$this->obligation->resetPeriod($data['obligation']);
            }
            //$this->obligation->edit(array("id" => $data['obligation'], "last_submission_status" => "breach"));

            if ($check) {
                if ($record['draft'] != 0) {
                    $this->notification->create_breach($key);
                } else if ($record['draft'] != 1) {
                    $this->notification->approve_breach($key);
                }
            }

            return $check;
        }
        return false;
    }

    function getObligation($obligation_id) {
        $this->db->where("obligation", $obligation_id);
        $this->db->where("draft", 0);

        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        return $q->result_array();
    }

    function getObligationPendingBreachesTotal($obligation_id) {
        $this->db->where("obligation", $obligation_id);
        $this->db->where("draft", 0);
        $this->db->where("delete", 0);
        $this->db->where("approved", 'pending');
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        return $q->num_rows();
    }

    function getObligationTotalPenulty($obligation_id) {
        $this->db->select("SUM(`penalty`) AS penalty");
        $this->db->where("obligation", $obligation_id);
        $this->db->where("draft", 0);
        $this->db->where("delete", 0);
        $this->db->where("approved", 'approved');
        $row = $this->db->get($this->table)->row_array();
        return $row['penalty'];
    }

    function delete($id) {
        $this->db->where("`id` = $id");
        $this->db->limit(1);
        $this->db->delete($this->table);
    }

    function last() {
        $this->db->limit(1);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function getAll() {
        //return [];
        $me = $this->user->getMe();
        //$this->db->where("draft=0 AND delete=0 OR (user={$me['user']['id']})");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['obligations'] = $this->obligation->getAuthority($value['id']);
        }
        return $results;
    }

    function getStatsData() {
        $results = $this->getAll();
        $return = array();
        foreach ($results as $key => $value) {

            $obligation = $this->obligation->get($value['obligation']);
            $value['authority'] = $obligation['authority'];
            $authority = $this->authority->get($value['authority']);
            $compliance_requirement = $this->complianceRequirement->get($obligation['compliance_requirement']);
            //$key_risk_area = $this->kraClip->getKRAclip($compliance_requirement['key_risk_area'], $compliance_requirement['risk_source']);
            if (!$value['authority']) {
                continue;
            }

            $environment = $this->environment->get($compliance_requirement['environment']);
            $responsible_manager_1 = $this->user->getUser($obligation['responsible_manager_1']);
            $responsible_manager_2 = $this->user->getUser($obligation['responsible_manager_2']);
            foreach ($value as $label => $val) {
                $return[$key]["breach:" . $label] = $val;
            }foreach ($obligation as $label => $val) {
                $return[$key]["obligation:" . $label] = $val;
            }
            foreach ($authority as $label => $val) {
                $return[$key]["authority:" . $label] = $val;
            }
            foreach ($compliance_requirement as $label => $val) {
                $return[$key]["compliance_requirement:" . $label] = $val;
            }
            foreach ($environment as $label => $val) {
                $return[$key]["environment:" . $label] = $val;
            }
            $return[$key]["risk_source:"] = $compliance_requirement['risk_source'];
            if (!$responsible_manager_1) {
                $responsible_manager_1 = array();
            }
            foreach ($responsible_manager_1 as $label => $val) {
                $return[$key]["responsible_manager_1:" . $label] = $val;
            }
            if (!$responsible_manager_2) {
                $responsible_manager_2 = array();
            }
            foreach ($responsible_manager_2 as $label => $val) {
                $return[$key]["responsible_manager_2:" . $label] = $val;
            }
        }
        return $return;
    }

    function getInactive() {
        $this->db->where("(`approved` != 'approved') AND (`draft`=0 AND `delete` = 0)");
        $array = $this->db->get($this->table)->result_array();
        foreach ($array as $key => $value) {
            if ($value['status'] == '') {
                $value['status'] = 'open';
                $this->edit($value);
            }
        }

//        print_pre($array);
//        exit;
        return $array;
    }

    function getObligationPenalty($obligaton) {
        $sql = "SELECT SUM(`penalty`) as `penalty_total`  FROM `breach` WHERE `obligation` = $obligaton AND `delete` = 0 AND `draft` = 0 AND `approved` = 'approved'";
        $data = $this->db->query($sql)->row_array();
        return ($data['penalty_total']);
        // exit;
    }

    function toggleField($key, $column, $options = array(0, 1)) {
        /*
         * 
         * $key = A SPECIFIC RECORD ID IN DATABASE TO EDIT
         * $colum = THIS COLUMN TO TOGGLE
         * $options = an array such as $array("active","inactive") or (true , false) or (0,1)
         * 
         * e.g. toggleField(1,"column_name",array("opt_1","opt_2"));
         * 
         */
        $record = $this->get($key);
        $value = isset($record[$column]) ? $record[$column] : false;
        $new_value = ($value === $options[0]) ? $options[1] : $options[0];
        if (isset($record[$column])) {
            $this->edit(array("id" => $key, $column => $new_value));
            return $new_value;
        } else {
            return false;
        }
    }

}
