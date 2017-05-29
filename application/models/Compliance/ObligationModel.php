<?php

class obligationModel extends CI_Model {

    public $table, $fields, $risk_sources_initials;
    public $field_keys;

    function __construct() {
        parent::__construct();

        $this->table = "obligations";
        $this->fields = $this->setFields();
    }

    function checkFields($data_array) {
        //print_pre($data_array);
        //exit;
        $return_array = array();
        foreach ($data_array as $key => $value) {
            if (in_array($key, $this->field_keys) and ( $key != "attachments")) {
                $return_array[$key] = $value;
            }
        }

//        print_pre($return_array);
//        exit;
        return $return_array;
    }

    function getUser($user_id) {
        return $this->db->get_where($this->table, "(`responsible_manager_1` = $user_id OR `responsible_manager_2` = $user_id OR `escalation_person` = $user_id) AND `draft` = 0 AND `delete` = 0")->result_array();
    }

    function handover_responsible_manager_1($from, $to) {
        $data['responsible_manager_1'] = $to;
        $this->db->where("responsible_manager_1", $from);
        $this->db->update($this->table, $data);
    }

    function handover_responsible_manager_2($from, $to) {
        $data['responsible_manager_2'] = $to;
        $this->db->where("responsible_manager_2", $from);
        $this->db->update($this->table, $data);
    }

    function handover_escalations_person($from, $to) {
        $data['escalation_person'] = $to;
        $this->db->where("escalation_person", $from);
        $this->db->update($this->table, $data);
    }

    function draft($data) {
        $key = isset($data['id']) ? $data['id'] : false;
        if ($key) {
            $this->db->where("`id` =  $key");
            $this->db->update($this->table, $this->checkFields($data));
        }
    }

    function findMyDraft() {
        $this->db->where("draft", $this->user->getMyId());
        $this->db->limit(1);
        $draft = $this->db->get($this->table);
        if ($draft->num_rows() == 1) {
            return $draft->row_array();
        } else {
            return false; //$draft->row_array();
        }
    }

    function getBreachObligations() {
        return $this->getOverdueObligations();
    }

    function getOverdueObligations() {
        $today = strftime("%Y-%m-%d", (time())) . " 23:59:59";

        $this->db->where(
                "`submission_deadline` < CURDATE() "
                . "AND approved = 'approved' "
                . "AND `draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `status` = 'active' "
                . "AND (`repeat` = 'periodic' OR ((`repeat` = 'one off') AND (`last_submission_status` = 'none'))  OR (`repeat` = 'continuous')  ) ");


        $this->db->order_by("submission_deadline", "DESC");
        $Q = $this->db->get($this->table);
        $results = $Q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['authority'] = $this->authority->get($value['authority']);
            $results[$key]['compliance_requirement'] = $this->compliance->get($value['compliance_requirement']);
            $results[$key]['compliance_requirement_type'] = $results[$key]['compliance_requirement']['type'];
        }
        return $results;
    }

    function getOverdueNotifications() {
        $today = strftime("%Y-%m-%d", (time())) . " 08:00:00";

        $this->db->where(
                "`notification_date` < CURDATE() "
                . "AND approved = 'approved' "
                . "AND `draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `status` = 'active' "
                . "AND (`repeat` = 'periodic' OR ((`repeat` = 'one off') AND (`last_submission_status` = 'none'))  OR (`repeat` = 'continuous')  )");


        $this->db->order_by("submission_deadline", "DESC");
        $Q = $this->db->get($this->table);
        $results = $Q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['authority'] = $this->authority->get($value['authority']);
            $results[$key]['compliance_requirement'] = $this->compliance->get($value['compliance_requirement']);
            $results[$key]['compliance_requirement_type'] = $results[$key]['compliance_requirement']['type'];
        }
        return $results;
    }

    function getBreachedObligations() {
        $obligations = $this->getAll();
        $return = array();
        $index = 0;
        foreach ($obligations as $key => $value) {
            $breaches = $this->breach->getObligation($value['id']);
            if (count($breaches) > 0) {
                $return[$index] = $value;
                $return[$index]['breaches'] = $breaches;
                $index++;
            }
        }

        return $return;
    }

    function getObligationsbyLastSubmissionStatus() {
        $this->db->where("`last_submission_status` = 'complied' "
                . "OR `last_submission_status` = 'partially' "
                . "OR `last_submission_status` = 'fully' ");
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    function getTotalObligationNonCompliancePenalty() {
        return $this->db->query("SELECT SUM(`noncompliance_penalty`) AS `noncompliance_penalty` FROM `$this->table` WHERE `approved` LIKE 'approved' AND `draft`= 0 AND `delete` = 0")->row_array();
    }

    function getObligation($id) {
        $data['obligation'] = $this->get($id);
        if (count($data['obligation']) == 0) {
            return false;
        }
        $data['compliance_requirement'] = $this->compliance->get($data['obligation']['compliance_requirement']);
        $data['register'] = $this->register->get($data['compliance_requirement']['compliance_register']);
        $data['obligation']['authority'] = $this->authority->get($data['obligation']['authority']);
        $data['obligation_dependent'] = $this->complianceDependent->getObligation($id);
        $data['authority'] = $data['obligation']['authority'];
        $data['repository'] = $this->repository->get($data['compliance_requirement']['repository']);
        $data['environment'] = $this->environment->get($data['repository']['environment']);
        $data['environmentTree'] = $this->environment->getTree($data['environment']['id']);

        $data['assignment']['escalation_person'] = $this->user->getUser($data['obligation']['escalation_person']);
        $data['assignment']['Primary_Owner'] = $this->user->getUser($data['obligation']['responsible_manager_1']);
        $data['assignment']['Secondary_Owner'] = $this->user->getUser($data['obligation']['responsible_manager_2']);
        $data['assignment']['Unit_Owner'] = $this->user->getUser($data['environment']['unit_owner']);

        $data['breaches'] = $this->breach->getObligation($id);
        $data['complies'] = $this->comply->getObligation($id);
        return $data;
    }

    function getPreviewObligation($id) {
        $data['obligation'] = $this->get($id);
        if (count($data['obligation']) == 0) {
            return false;
        }
        $data['obligation']['compliance_requirement'] = $this->compliance->get($data['obligation']['compliance_requirement']);
        $data['obligation']['authority'] = $this->authority->get($data['obligation']['authority']);
        $data['obligation']['responsible_manager_1'] = $this->user->getUser($data['obligation']['responsible_manager_1']);
        $data['obligation']['responsible_manager_2'] = $this->user->getUser($data['obligation']['responsible_manager_2']);
        $data['obligation']['escalation_person'] = $this->user->getUser($data['obligation']['escalation_person']);
        return $data;
    }

    function getObligationsByType($type) {
        $this->db->where("type", $type);
        $this->db->order_by("id", "DESC");
        $Q = $this->db->get($this->table);
        $results = $Q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['authority'] = $this->authority->get($value['authority']);
        }
        return $results;
    }

    function getOverDueObligationsByType($type) {
        $tomorrow = strftime("%Y-%m-%d", (time() + (3600 * 24))) . " 00:00:00";
        $this->db->where(
                "type = '$type'"
                . "AND submission_deadline < '" . $tomorrow . "'"
                . "AND approved = 'approved' "
                . "AND `draft` = 0 "
                . "AND `delete` = 0 "
                . "AND `status` = 'active' "
                . "AND (`repeat` = 'periodic' OR (`repeat` = 'one off' and `last_submission_status` = 'none') OR (`repeat` = 'continuous') )");
        $this->db->order_by("submission_deadline", "DESC");
        $Q = $this->db->get($this->table);
        $results = $Q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['authority'] = $this->authority->get($value['authority']);
            $results[$key]['compliance_requirement'] = $this->compliance->get($value['compliance_requirement']);
        }
        return $results;
    }

    function seekBreaches() {
        $obligations = $this->getOverdueObligations();
//        print_pre($obligations);
//        exit;
        foreach ($obligations as $key => $value) {
            //exit;

            $data['title'] = ($value['compliance_requirement_type'] == 'Statutory Returns') ?
                    "Breach" : "Late review";
            $data['title'] .= " : " . $value['title'] . " : " . ((strftime("%b %d %Y", strtotime($value['submission_deadline']))));
            $data['obligation'] = $value['id'];
            $data['status'] = 'open';
            $data['report_incident'] = 'no';
            $data['submission_deadline'] = $value['submission_deadline'];
            $data['period'] = $value['next_submission_period'];
            $data['penalty'] = $value['noncompliance_penalty'];
            $data['approved'] = 'pending';
            $data['type'] = ($value['compliance_requirement_type'] == 'Statutory Returns') ? "Breach" : "Late review";
            $next = $this->getNextSubmissionPeriod(false, $value);

            $data['period_name'] = isset($next['period_name']) ? $next['period_name'] : false;
            $data['period_initials'] = isset($next['period_initials']) ? $next['period_initials'] : false;

            if (!$data['period_name']) {
                unset($data['period_name']);
            }
            if (!$data['period_initials']) {
                unset($data['period_initials']);
            }
            $breach = $this->breach->add($data);
            unset($data);
            $data = $this->get($value['id']);
            if ($value['repeat'] == 'periodic') {
                $data['next_submission_period'] = $next['next_submission_period'];
                $data['submission_deadline'] = $next['submission_deadline'];
                $data['notification_date'] = $next['notification_date'];
            }
            if ($value['repeat'] == 'continuous') {
                $data['status'] = 'inactive';
            }
            $data['last_submission_status'] = ($value['compliance_requirement_type'] == 'Statutory Returns') ? "breach" : "late_review";
            $this->email_sent($data['id'], $data);
            unset($data);

            $this->notification->system_breach($breach['id']);
        }
    }

    function seekNotifications() {
        $obligations = $this->getOverdueNotifications();
        //print_pre($obligations);

        foreach ($obligations as $value) {
            $this->notification->obligation_reminder($value['id']);
        }
    }

    function resetPeriod($obligation_id) {
//        $obligation = $this->get($obligation_id);
//        if (!$obligation['repeat'] == 'periodic') {
//            $data = $this->getNextSubmissionPeriod($obligation_id);
//            $data['id'] = $obligation_id;
//            $this->edit($data);
//        }
    }

    function getNextSubmissionPeriod($id = false, $obligationArray = array()) {
        if ($id) {
            $obligation = $this->get($id);
        } else {
            $obligation = $obligationArray;
        }
        $data = [];
        if ($obligation['repeat'] == 'periodic') {
            switch ($obligation['frequency']) {
                case "annually" :
                    $data['next_submission_period'] = strftime("%Y", (strtotime($obligation['submission_deadline']) + (365 * 24 * 3600)));
                    $data['submission_deadline'] = period_calc($obligation['submission_deadline'], $obligation['frequency']); //strftime("%Y-%m-%d %H:%M:%S", (strtotime($obligation['submission_deadline']) + (365 * 24 * 3600)));
                    $data['notification_date'] = period_calc($obligation['notification_date'], $obligation['frequency']); //strftime("%Y-%m-%d %H:%M:%S", (strtotime($obligation['notification_date']) + (365 * 24 * 3600)));
                    $data['next_review'] = period_calc($obligation['next_review'], $obligation['frequency']); //strftime("%Y-%m-%d %H:%M:%S", (strtotime($obligation['next_review']) + (365 * 24 * 3600)));
                    $data['period_name'] = "Year";
                    $data['period_initials'] = "Yr";
                    break;
                case "semi annually" :
                    $period = (( $obligation['next_submission_period'] + 1) > 2) ? 1 : ($obligation['next_submission_period'] + 1);
                    $data['next_submission_period'] = $period;
                    $data['submission_deadline'] = period_calc($obligation['submission_deadline'], $obligation['frequency']); //strftime("%Y-%m-%d %H:%M:%S", (strtotime($obligation['submission_deadline']) + (182 * 24 * 3600)));
                    $data['notification_date'] = period_calc($obligation['notification_date'], $obligation['frequency']); //strftime("%Y-%m-%d %H:%M:%S", (strtotime($obligation['notification_date']) + (182 * 24 * 3600)));
                    $data['next_review'] = period_calc($obligation['next_review'], $obligation['frequency']); //strftime("%Y-%m-%d %H:%M:%S", (strtotime($obligation['next_review']) + (182 * 24 * 3600)));
                    $data['period_name'] = "Half";
                    $data['period_initials'] = "H";
                    break;
                case "quarterly" :
                    $period = (( $obligation['next_submission_period'] + 1) > 4) ? 1 : ($obligation['next_submission_period'] + 1);
                    $data['next_submission_period'] = $period;
                    $data['submission_deadline'] = period_calc($obligation['submission_deadline'], $obligation['frequency']); //strftime("%Y-%m-%d %H:%M:%S", (strtotime($obligation['submission_deadline']) + (91 * 24 * 3600)));
                    $data['notification_date'] = period_calc($obligation['notification_date'], $obligation['frequency']); //strftime("%Y-%m-%d %H:%M:%S", (strtotime($obligation['notification_date']) + (91 * 24 * 3600)));
                    $data['next_review'] = period_calc($obligation['next_review'], $obligation['frequency']); //strftime("%Y-%m-%d %H:%M:%S", (strtotime($obligation['next_review']) + (91 * 24 * 3600)));
                    $data['period_name'] = "Quarter";
                    $data['period_initials'] = "Q";
                    break;
                case "monthly" :
                    $period = (( $obligation['next_submission_period'] + 1) > 12) ? 1 : ($obligation['next_submission_period'] + 1);
                    $data['next_submission_period'] = $period;
                    $data['submission_deadline'] = period_calc($obligation['submission_deadline'], $obligation['frequency']); //strftime("%Y-%m-%d %H:%M:%S", (strtotime($obligation['submission_deadline']) + (30 * 24 * 3600)));
                    $data['notification_date'] = period_calc($obligation['notification_date'], $obligation['frequency']); //strftime("%Y-%m-%d %H:%M:%S", (strtotime($obligation['notification_date']) + (30 * 24 * 3600)));
                    $data['next_review'] = period_calc($obligation['next_review'], $obligation['frequency']); //strftime("%Y-%m-%d %H:%M:%S", (strtotime($obligation['next_review']) + (30 * 24 * 3600)));
                    $data['period_name'] = "Month";
                    $data['period_initials'] = "M";
                    break;
                case "weekly" :
                    $period = (( $obligation['next_submission_period'] + 1) > 52) ? 1 : ($obligation['next_submission_period'] + 1);
                    $data['next_submission_period'] = $period;
                    $data['submission_deadline'] = period_calc($obligation['submission_deadline'], $obligation['frequency']); //strftime("%Y-%m-%d %H:%M:%S", (strtotime($obligation['submission_deadline']) + (7 * 24 * 3600)));
                    $data['notification_date'] = period_calc($obligation['notification_date'], $obligation['frequency']); //strftime("%Y-%m-%d %H:%M:%S", (strtotime($obligation['notification_date']) + (7 * 24 * 3600)));
                    $data['next_review'] = period_calc($obligation['next_review'], $obligation['frequency']); //strftime("%Y-%m-%d %H:%M:%S", (strtotime($obligation['next_review']) + (7 * 24 * 3600)));
                    $data['period_name'] = "Week";
                    $data['period_initials'] = "W";
                    break;
                case "daily" :
                    $period = (( $obligation['next_submission_period'] + 1) > 365) ? 1 : ($obligation['next_submission_period'] + 1);
                    $data['next_submission_period'] = $period;
                    $data['submission_deadline'] = period_calc($obligation['submission_deadline'], $obligation['frequency']); //strftime("%Y-%m-%d %H:%M:%S", (strtotime($obligation['submission_deadline']) + ( 24 * 3600)));
                    $data['notification_date'] = period_calc($obligation['notification_date'], $obligation['frequency']); //strftime("%Y-%m-%d %H:%M:%S", (strtotime($obligation['notification_date']) + (24 * 3600)));
                    $data['next_review'] = period_calc($obligation['next_review'], $obligation['frequency']); //strftime("%Y-%m-%d %H:%M:%S", (strtotime($obligation['next_review']) + (24 * 3600)));
                    $data['period_name'] = "Day";
                    $data['period_initials'] = "D";
                    break;
                default:
                    break;
            }
        }
        return $data;
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
        if ($this->findMyDraft()) {
            return $this->findMyDraft();
        }
        $me = $this->user->getMe();
        $data['user'] = $me['user']['id'];
        $check = $this->db->insert($this->table, $this->checkFields($data));
        if ($check) {

            return $this->last();
        } else {
            return false;
        }
    }

    function get($id) {

        $this->db->where("`id` = $id");
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function obligationActiveness($conpliance_id, $activeness) {
        $compliance = $this->complianceRequirement->get($conpliance_id);
        $data['compliance_state'] = $compliance['status'];
        //$compliance['compliance_state'] = $compliance['status'];
        $this->db->where("compliance_requirement", $compliance['id']);
        $this->db->update($this->table, $data);
    }

    function email_sent($id, $data) {
        $this->db->where(array("id" => $id));
        $this->db->update($this->table, $data);
    }

    function edit($data) {
        $log_data['json_post'] = json_encode($data);

        $this->db->insert('log', $log_data);
        $key = isset($data['id']) ? $data['id'] : false;
        $data['notified'] = "no";
        $obligation = $this->get($key);

        if ($obligation['compliance_requirement']) {
            $cr = $this->complianceRequirement->get($obligation['compliance_requirement']);
            $data['compliance_state'] = $cr['status'];
            $this->complianceVersion->createVersion($obligation['compliance_requirement']);
        } else {
            $data['compliance_state'] = 'inactive';
        }
        $check = false;
        if ($key) {
            $this->db->where("`id` =  $key");
            $data['draft'] = 0;
            //print_pre($this->checkFields($data)) ; exit;
            $check = $this->db->update($this->table, $this->checkFields($data));
            if ($obligation['draft'] != 0 and am_user_type(array(5))) {
                $this->auto_approve($key);
            } else if ($obligation['draft'] != 0 and ! am_user_type(array(5))) {
                $this->notification->obligation_request_approval($key);
            }
        }
        $this->makeTitle($key);
        return $check;
    }

    function auto_approve($key) {
        $sql = "UPDATE `{$this->table}` SET `approved` = 'approved' WHERE `id` = $key LIMIT 1";
        $this->db->query($sql);
        $this->notification->obligation_approved($key);
    }

    function makeTitle($id) {
        $obligation = $this->get($id);
        if (str_replace(" ", "", strip_tags($obligation['title'])) == '') {
            $description = strip_tags($obligation['description']);
            $desc_array = str_word_count($description, 1);
            $min = 0;
            $max = count($desc_array) > TITLE_LENTH ? TITLE_LENTH : (count($desc_array) - 1);
            $title = NULL;
            for ($i = $min; $i < $max; $i++) {
                $title .= " " . $desc_array[$i];
            }
            $this->db->where("`id` = $id");
            $this->db->update($this->table, array("title" => $title));
        }
    }

    function setType($compliance_requirement, $type) {
        $this->db->where("compliance_requirement", $compliance_requirement);
        $this->db->update($this->table, array("type" => $type));
    }

    function delete($id) {
        $obligation = $this->get($id);
        $this->complianceVersion->createVersion($obligation['compliance_requirement']);
        $this->db->query("DELETE FROM `obligation_comply` WHERE `obligations` = $id;");
        $this->db->query("DELETE FROM `breach` WHERE `obligation` = $id;");
        $this->db->query("DELETE FROM `{$this->table}` WHERE `id` = $id;");
    }

    function getEscalationPersons() {
        $this->db->where("compliance_escalation!=", 0);
        $this->db->order_by("compliance_escalation", "DESC");
        $q = $this->db->get("user_type");
        return $q->result_array();
    }

    function last() {
        $this->db->limit(1);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function getAllObligations() {
        $me = $this->user->getMe();
        $this->db->where("draft=0 AND delete=0");
        $this->db->order_by("submission_deadline", "ASC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['authority'] = $this->authority->get($value['authority']);
            $results[$key]['compliance_requirement'] = $this->compliance->get($value['compliance_requirement']);
            $results[$key]['register'] = $this->register->get($results[$key]['compliance_requirement']['compliance_register']);
            $results[$key]['obligation']['authority'] = $this->authority->get($value['authority']);
            $results[$key]['responsible_manager_1'] = $this->user->getUser($value['responsible_manager_1']);
            $results[$key]['responsible_manager_2'] = $this->user->getUser($value['responsible_manager_2']);
            $results[$key]['repository'] = $this->repository->get($results[$key]['compliance_requirement']['repository']);
            $results[$key]['environment'] = $this->environment->get($results[$key]['repository']['environment']);
            $results[$key]['penalty_total'] = $this->breach->getObligationPenalty($value['id']);
        }
        return $results;
    }

    function getAllObligationsByUser($id) {
        $this->db->where("draft=0 AND delete=0 AND (user=$id OR responsible_manager_1=$id  OR responsible_manager_2=$id)");
        $this->db->order_by("submission_deadline", "ASC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['authority'] = $this->authority->get($value['authority']);
            $results[$key]['compliance_requirement'] = $this->compliance->get($value['compliance_requirement']);
            $results[$key]['register'] = $this->register->get($results[$key]['compliance_requirement']['compliance_register']);
            $results[$key]['obligation']['authority'] = $this->authority->get($value['authority']);
            $results[$key]['responsible_manager_1'] = $this->user->getUser($value['responsible_manager_1']);
            $results[$key]['responsible_manager_2'] = $this->user->getUser($value['responsible_manager_2']);
            $results[$key]['repository'] = $this->repository->get($results[$key]['compliance_requirement']['repository']);
            $results[$key]['environment'] = $this->environment->get($results[$key]['repository']['environment']);
            $results[$key]['penalty_total'] = $this->breach->getObligationPenalty($value['id']);
        }
        return $results;
    }

    function getAll() {
        $me = $this->user->getMe();
        $this->db->where("draft=0 AND delete=0");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['authority'] = $this->authority->get($value['authority']);
        }
        return $results;
    }

    function getUpcoming() {
        $me = $this->user->getMe();
        $year = strftime("%Y", time());
        $m1 = strftime("%m", time());
        $m2 = $m1 + 1;

        $this->db->where("YEAR(submission_deadline) = $year AND (MONTH(submission_deadline) BETWEEN $m1 AND $m2) AND draft=0 AND delete=0 ");
        $this->db->order_by("submission_deadline", "ASC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['authority'] = $this->authority->get($value['authority']);
        }
        return $results;
    }

    function getInactive() {
        $this->db->where("(`approved` != 'approved') AND (`draft`=0 AND `delete` = 0)");
        $array = $this->db->get($this->table)->result_array();
        foreach ($array as $key => $value) {
            
        }
        return $array;
    }

    function getAuthority($authority_id) {
        $me = $this->user->getMe();
        $my_id = isset($me['user']['id']) ? $me['user']['id'] : 0;
        $this->db->where("draft=0 AND delete=0 AND authority=$authority_id AND (draft={$my_id} OR user={$my_id})");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();

        foreach ($results as $key => $value) {
            $results[$key]['authority'] = $this->authority->get($value['authority']);
        }

        return $results;
    }

    function getComplianceRequirementsByDate($compliance_requirement_id, $start, $end) {
        // return [];
        $me = $this->user->getMe();
        $this->db->where("draft=0 AND delete=0 AND (submission_deadline BETWEEN '$start' AND '$end' ) AND  compliance_requirement=$compliance_requirement_id AND (draft={$me['user']['id']} OR user={$me['user']['id']})");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();
        foreach ($results as $key => $value) {
            $results[$key]['authority'] = $this->authority->get($value['authority']);
            $results[$key]['responsible_manager_1'] = $this->user->getUser($value['responsible_manager_1']);
            $results[$key]['responsible_manager_2'] = $this->user->getUser($value['responsible_manager_2']);
        }
        return $results;
    }

    function getComplianceRequirements($compliance_requirement_id) {

        //return [];
        $me = $this->user->getMe();

        $this->db->where("draft=0 AND delete=0 AND compliance_requirement=$compliance_requirement_id ");
        $this->db->order_by("id", "DESC");
        $q = $this->db->get($this->table);
        $results = $q->result_array();

        foreach ($results as $key => $value) {
            $results[$key]['authority'] = $this->authority->get($value['authority']);
            $results[$key]['responsible_manager_1'] = $this->user->getUser($value['responsible_manager_1']);
            $results[$key]['responsible_manager_2'] = $this->user->getUser($value['responsible_manager_2']);

            $results[$key]['pending_breaches'] = $this->breach->getObligationPendingBreachesTotal($value['id']);
            $results[$key]['pending_compliants'] = $this->comply->getObligationPendingCompliantTotal($value['id']);
        }
        return $results;
    }

    function getStatisticsData() {
        $obligations = $this->getAll();
        $data = array();
        $one_table = array();
        foreach ($obligations as $key => $value) {

            $compliance = $this->complianceRequirement->get($value['compliance_requirement']);

            if ($compliance and count($compliance)) {
                $data[$key]['obligation'] = $value;
                $data[$key]['compliance_requirement'] = $compliance;
                //$data[$key]['key_risk_area'] = $this->$compliance['risk_source']->get($compliance['key_risk_area']);
                $data[$key]['authority'] = $this->authority->get($value['authority']['id']);
                //$data[$key]['risk_source']['risk_source'] = $compliance['risk_source'];
                $data[$key]['environment'] = $this->environment->get($compliance['environment']);
                $data[$key]['compliance_register'] = $this->complianceRegister->get($compliance['compliance_register']);
//                print_pre($data[$key]['compliance_register']);
//                exit;
                foreach ($data[$key] as $label => $record) {
                    if (!is_array($record)) {
                        continue;
                    }
                    foreach ($record as $l => $v) {
                        $one_table[$key][$label . ":" . $l] = $v;
                    }
                }
            }
        }
        return $one_table;
    }

    function getAllKeyRiskAreas() {
        $obligations = $this->getAll();
        $data = array();
        $unique = array();
        foreach ($obligations as $key => $value) {
            
        }
        return $data;
    }

    function countRequirement($compliance_requirement) {
        $this->db->where("compliance_requirement", $compliance_requirement);
        $this->db->where("draft", 0);
        $q = $this->db->get($this->table);
        return $q->num_rows();
    }

    function complianceRquirementCompletion($compliance_requirement) {
        $where = "(`last_submission_status` LIKE 'complied' OR `last_submission_status` LIKE 'partially' OR `last_submission_status` LIKE 'fully') AND "
                . "`compliance_requirement` = $compliance_requirement AND "
                . "`draft` = 0 AND `delete` = 0";

        $this->db->where($where);
        $q = $this->db->get($this->table);
        $total = $this->countRequirement($compliance_requirement);
        return $total ? number_format((($q->num_rows() / $total) * 100), 2) : "N/A";
    }

    function deleteComplianceRequirements($id) {
        $obligations = $this->getComplianceRequirements($id);
        foreach ($obligations as $key => $value) {
            $this->delete($value['id']);
        }
        return true;
    }

    function getApprovedObligations() {
        $this->db->where("draft", 0);
        $this->db->where("delete", 0);
        $this->db->where("`approved` LIKE 'approved'");
        $query = $this->db->get($this->table);
        return $query->result_array();
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

    function getStatsData() {
        $results = $this->getAll();
        $return = array();
        foreach ($results as $key => $value) {
            $results[$key]['authority'] = $value['authority'];
            $value['authority'] = $value['authority']['id'];
            $authority = $this->authority->get($value['authority']);
            $compliance_requirement = $this->complianceRequirement->get($value['compliance_requirement']);
            if (!$value['authority']) {
                continue;
            }
            $environment = $this->environment->get($compliance_requirement['environment']);
            $compliance_register = $this->complianceRegister->get($compliance_requirement['compliance_register']);
            $responsible_manager_1 = $this->user->getUser($value['responsible_manager_1']);
            $responsible_manager_2 = $this->user->getUser($value['responsible_manager_2']);
            $complies = $this->obligationComply->getObligation($value['id']);
            $breaches = $this->breach->getObligation($value['id']);
            foreach ($value as $label => $val) {
                $return[$key]["obligation:" . $label] = $val;
            }
            foreach ($authority as $label => $val) {
                $return[$key]["authority:" . $label] = $val;
            }
            foreach ($compliance_requirement as $label => $val) {
                $return[$key]["compliance_requirement:" . $label] = $val;
            }
            foreach ($compliance_register as $label => $val) {
                $return[$key]["compliance_register:" . $label] = $val;
            }
            foreach ($environment as $label => $val) {
                $return[$key]["environment:" . $label] = $val;
            }
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
            $return[$key]['complies'] = $complies;
            $return[$key]['breaches'] = $breaches;
        }
        return $return;
    }

}
