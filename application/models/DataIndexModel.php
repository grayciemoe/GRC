<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dataIndexModel
 *
 * @author kevkinja
 */
class DataIndexModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function environment() {
        $this->db->query("UPDATE `environment` SET `obligations` = NULL WHERE 1");
        $this->db->query("UPDATE `environment` SET `incidents` = NULL WHERE 1");
        $this->db->query("UPDATE `environment` SET `audits` = NULL WHERE 1");
        $this->db->query("UPDATE `environment` SET `risks` = NULL WHERE 1");

        $obligations = $this->obligation->getAll();
        foreach ($obligations as $key => $value) {
            $obligations[$key]['authority'] = $value['authority']['id'];
            $cr = $this->compliance->get($value['compliance_requirement']);
            $repo = $this->repository->get($cr['repository']);
            $env = $this->environment->getTree($repo['environment']);
            $oblg = [];
            foreach ($env as $e) {
                $oblg = objectToArray(json_decode($e['obligations']));
                if (!$oblg) {
                    $oblg = [];
                }

                if (in_array($value['id'], $oblg)) {
                    continue;
                }
                $oblg[] = $value['id'];
                $e['obligations'] = json_encode($oblg);
                $this->environment->edit($e);
            }
        }

        $risks = $this->risk->getAll();
        foreach ($risks as $key => $value) {
            $repo = $this->repository->get($value['repository']);
            $env = $this->environment->getTree($repo['environment']);
            $risk = [];
            foreach ($env as $e) {
                $risk = objectToArray(json_decode($e['risks']));
                if (!$risk) {
                    $risk = [];
                }
                if (in_array($value['id'], $risk)) {
                    continue;
                }
                $risk[] = $value['id'];
                $e['risks'] = json_encode($risk);
                $this->environment->edit($e);
            }
        }

        $incidents = $this->incident->getAll();

        foreach ($incidents as $key => $value) {
            $env = $this->environment->getTree($value['environment']);
            $incs = [];
            foreach ($env as $e) {
                $incs = objectToArray(json_decode($e['incidents']));
                if (!$incs) {
                    $incs = [];
                }
                if (in_array($value['id'], $incs)) {
                    continue;
                }
                $incs[] = $value['id'];
                $e['incidents'] = json_encode($incs);
                $this->environment->edit($e);
            }
        }
        //print_pre($incs);
    }

    public function compliance() {


        $statutory = $this->compliance->getTypeObligations("Statutory Returns");
        $legal = $this->compliance->getTypeObligations("Legal / Regulatory Requirements");
        $business = $this->compliance->getTypeObligations("Business Compliance Requirements");

        $data['obligations'] = $this->obligation->getAll();
        $data['obligations_approved'] = count($this->obligation->getApprovedObligations());
        $count_obligations_approved = ($data['obligations_approved']);

        $data['breaches'] = $this->breach->getAll();
        $data['breaches_penalty'] = $this->breach->getTotalPenalty();
        $data['breaches_approved'] = count($this->breach->getApprovedBreaches());

        $data['obligation_last_sub_status'] = $this->obligation->getObligationsbyLastSubmissionStatus();
        $count_complies_approved = count($data['obligation_last_sub_status']);

        $data['complies'] = $this->comply->getAll();
        $data['complies_approved'] = count($this->comply->getApprovedComplies());
        // $count_complies_approved = count($data['complies_approved']);

        $data['comp_req'] = $this->compliance->getAll();
        $data['count_ob'] = count($data['obligations']);
        $data['count_breach'] = count($data['breaches']);

        foreach ($data['obligations'] as $key => $value) {
            $data['obligations'][$key]['compliance'] = $this->complianceRequirement->get($value['compliance_requirement']);
        }
        $count_obligations_approved = $count_obligations_approved > 0 ? $count_obligations_approved : 1;

        $data['overall compliance'] = round((($count_complies_approved / $count_obligations_approved) * 100), $precision = 2);


        //$stat = $this->compliance->getTypeObligations("Statutory Returns");

        $data['Stat_returns'] = count($statutory);
        $data['Legal_req'] = count($legal);
        $data['Business_req'] = count($business);
        $data['fully'] = $this->comply->getComplyCompletion("fully");
        $data['partially'] = $this->comply->getComplyCompletion("partially");
        $data['Noncompliance'] = $this->breach->getBreachType("Noncompliance");

//        print_pre($data['Noncompliance']); die();

        $business_fully = 0;
        $legal_fully = 0;
        $stat_fully = 0;
        $business_part = 0;
        $legal_part = 0;
        $stat_part = 0;
        $business_non_comp = 0;
        $legal_non_comp = 0;
        $stat_non_comp = 0;

        foreach ($statutory as $key => $value) {
            if ($value['last_submission_status'] == 'fully' or $value['last_submission_status'] == 'complied') {
                $stat_fully += 1;
            }
            if ($value['last_submission_status'] == 'partially') {
                $stat_part += 1;
            }
            if ($value['last_submission_status'] == 'late_review' or $value['last_submission_status'] == 'breach') {
                $stat_non_comp += 1;
            }
            if ($value['last_submission_status'] == 'none') {
                //$stat_fully += 1;
            }
        }
        foreach ($legal as $key => $value) {

            if ($value['last_submission_status'] == 'fully' or $value['last_submission_status'] == 'complied') {
                $legal_fully += 1;
            }
            if ($value['last_submission_status'] == 'partially') {
                $legal_part += 1;
            }
            if ($value['last_submission_status'] == 'late_review' or $value['last_submission_status'] == 'breach') {
                $legal_non_comp += 1;
            }
            if ($value['last_submission_status'] == 'none') {
                //$stat_fully += 1;
            }
        }
        foreach ($business as $key => $value) {


            if ($value['last_submission_status'] == 'fully' or $value['last_submission_status'] == 'complied') {
                $business_fully += 1;
            }
            if ($value['last_submission_status'] == 'partially') {
                $business_part += 1;
            }
            if ($value['last_submission_status'] == 'late_review' or $value['last_submission_status'] == 'breach') {
                $business_non_comp += 1;
            }
            if ($value['last_submission_status'] == 'none') {
                //$stat_fully += 1;
            }
        }


        $data['stat_fully'] = ($stat_fully);
        $data['stat_part'] = ($stat_part);
        $data['stat_non_comp'] = ($stat_non_comp);
        $data['legal_fully'] = ($legal_fully);
        $data['legal_part'] = ($legal_part);
        $data['legal_non_comp'] = ($legal_non_comp);
        $data['business_fully'] = ($business_fully);
        $data['business_part'] = ($business_part);
        $data['business_non_comp'] = ($business_non_comp);
        $fully = [$data['stat_fully'], $data['legal_fully'], $data['business_fully']];

        unset($data['obligations']);
//        unset($data['obligations_approved']);
        unset($data['obligation_last_sub_status']);
        unset($data['breaches']);
//        unset($data['breaches_approved']);
//        unset($data['complies_approved']);
        unset($data['complies']);
        unset($data['comp_req']);
        unset($data['fully']);
        unset($data['partially']);
        unset($data['Noncompliance']);
//        unset($data['Noncompliance']);
//        unset($data['Noncompliance']);
        //$this->db->query();


        $sql = "SELECT * FROM `data_index` WHERE `module` = 'compliance' LIMIT 1";
        $record = $this->db->query($sql)->row_array();
        if (!$record) {
            $this->db->insert("data_index", array("module" => "compliance"));
        }
        $data['breaches_penalty'] = $data['breaches_penalty']['penalty'];
        $this->db->where(array("module" => "compliance"));
        $json_data = json_encode($data);
        $this->db->update("data_index", array("data" => $json_data));

//        print_pre($record);
//        print_pre($data);
    }

    public function risk() {
        //echo __METHOD__;
    }

    public function incidentManagement() {
        //echo __METHOD__;
    }

    public function documents() {
        //echo __METHOD__;
    }

    public function audit() {
        //echo __METHOD__;
    }

    function getCompliance() {
        return $this->db->query("SELECT * FROM `data_index` WHERE `module` = 'compliance'")->row_array();
    }

}
