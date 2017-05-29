<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Audit extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->page_title = "Audit";
        $this->corporate = NULL;

        $this->load->model("Documents/UploadModel", "uploadModel");
        $this->load->model("Documents/DocumentsModel", "documentsModel");
        $this->load->model("Documents/CropModel", "cropModel");

        $this->load->model("Users/UserModel", "user");
        $this->load->model("Users/AuthModel", "auth");
        $this->load->model("Users/UserTypeModel", "userType");
        $this->load->model("Users/UserTypeActionsModel", "userTypeActions");

        if (!$this->auth->checkLogin()) {
            redirect("Login/?message=Please login to proceed");
        }
        $this->load->model("Environment/EnvironmentModel", "environment");
        $this->load->model("Environment/EnvironmentLevelModel", "environmentLevel");
        $this->load->model("Environment/RepositoryModel", "repository");
        $this->load->model("Comments/CommentsModel", "comments");
        $this->load->model("Notification/NotificationModel", "notification");

        $this->load->model("Risk/CategoryModel", "riskCategory");

        $this->load->model("Risk/RiskModel", "risk");
        $this->load->model("Risk/CategoryModel", "risk_category");
        $this->load->model("Risk/RegisterModel", "register");
        $this->load->model("Risk/AnalysisModel", "analysis");
        $this->load->model("Risk/EvaluationModel", "evaluation");
        $this->load->model("Risk/ControlCategoryModel", "controlCategory");
        $this->load->model("Risk/ControlModel", "control");
        $this->load->model("Risk/ControlActivityModel", "activity");
        $this->load->model("Risk/ControlActivityModel", "controlActivity");

        $this->load->model("Compliance/ComplianceRequirementModel", "complianceRequirement");
        $this->load->model("Compliance/ComplianceVersionModel", "complianceVersion");
        $this->load->model("Compliance/BreachModel", "breach");
        $this->load->model("Compliance/ObligationComplyModel", "complies");
        $this->load->model("Compliance/ObligationModel", "obligation");
        $this->load->model("Compliance/AuthorityModel", "authority");
        $this->load->model("Compliance/ComplianceRegisterModel", "complianceRegister");
        $this->load->model("Compliance/ObligationComplyModel", "comply");

        $this->load->model("Documents/DocumentsModel", "doc");
        $this->load->model("IncidentManagement/IncidentManagementModel", "incident");
        $this->load->model("IncidentManagement/IncidentActionsModel", "incidentActions");
        $this->load->model("IncidentManagement/IncidentCategoryModel", "incidentCategory");
        $this->load->model("IncidentManagement/IncidentCategoryModel", "category");
        $this->load->model("Compliance/ComplianceRequirementModel", "compliance");

        $this->load->model("ActivityTrail/ActivityTrailModel", "activityTrail");

        $this->load->model("Audit/AuditModel", "audit");
        $this->load->model("Audit/IssueModel", "issue");
        $this->load->model("Audit/RecommendationModel", "recommendation");
        $this->load->model("Audit/ActionPlansModel", "action_plans");
        $this->load->model("Audit/AuditAreaModel", "auditArea");
        $this->load->model("Audit/AuditCommentModel", "auditComment");

        $this->load->model("Bridge/BridgeModel", "bridge");
    }

    function e404Hundler($filepath) {
        if (!file_exists("application/views/" . $filepath . ".php")) {
            $filename = "application/views/" . $filepath . ".php";
            /* echo "Error : File ('$filename') does not exist"; */ return false;
        } else {
            return true;
        }
    }

    function page($pageName = "", $pageData = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "Audit/Pages/" . ucwords($pageName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/Home");
        }
        $data['message'] = ($this->input->get("message")) ? "<div style='padding:7px'>" . ucwords($this->input->get("message")) . "</div>" : NULL;
        $data['data'] = $pageData;
        $data['title'] = $this->page_title;
        $data['page_title'] = $this->page_title;
        $data['corporate'] = $this->corporate;
        if (!empty($data['corporate'])) {
            $data['corporate_details'] = $this->environment->get($data['corporate']);
        }
        $data['me'] = $this->user->getMe();
        $data['stylesheets'] = $stylesheets;
        $data['scripts'] = $scripts;
        $this->load->view("Includes/HeadView", $data);
        $this->load->view("Includes/MainNavView", $data);
//print_pre($data); exit;
        $this->load->view("Audit/Includes/AuditHeaderView", $data);
//        print_pre($data); exit;
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
        $this->load->view("Includes/FooterView");
    }

    function form($formName = "", $data = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "Audit/Forms/" . ucwords($formName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/Home");
        }
        $data['message'] = ($this->input->get("message")) ? "<div style='padding:7px'>" . ucwords($this->input->get("message")) . "</div>" : NULL;
        $data['data'] = $data;
        $data['scripts'] = $scripts;
        $data['stylesheets'] = $stylesheets;
        $this->load->view("Includes/HeadView", $data);
        $this->load->view("Includes/MainNavView", $data);
        $this->load->view("Audit/Includes/AuditHeaderView");
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
        $this->load->view("Includes/FooterView");
    }

    function modal($modalName = "", $pageData = array(), $scripts = array(), $stylesheets = array()) {
//        if ($this->input->post("requestView") != "modal") {
//            redirect("Home/index/");
//        }
        $filename = "Audit/Modals/" . ucwords($modalName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/Home");
        }
        $data['data'] = $pageData;
        $data['me'] = $this->user->getMe();
        $data['scripts'] = $scripts;
        $data['stylesheets'] = $stylesheets;
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
    }

    function ajax($fileName = "", $data = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "Audit/Ajax/" . ucwords($fileName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/Home");
        }
//        $data['repository_sources'] = $this->sources;
        $data['data'] = $data;
        $data['me'] = $this->user->getMe();
        $data['scripts'] = $scripts;
        $data['stylesheets'] = $stylesheets;
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
    }

    function notificationPopup($fileName = "", $data = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "Audit/NotificationsPopup/$pageName";
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/Home");
        }
        $data['repository_sources'] = $this->sources;
        $data['data'] = $pageData;
        $data['me'] = $this->user->getMe();
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
    }

    function index() {
        $this->page_title = "Select Corporate";
        $corp = $this->environment->getCorporates();
//        $ss = array('Shared Services');
//        foreach ($corp as $key => $value) {
//            if(in_array($value['name'], $ss)){
//                unset($corp[$key]);
//            }
//        }
        $me = $this->user->getMe();
        $corpId = $me['user']['corporate'];
        $this->corporate = $corpId;
//        print_pre($me); exit;
        if (($me['user_type']['id'] == 6) || ($me['user_type']['id'] == 2)) {
            $this->dashboard($corpId);
        } else {
            $this->page("AuditStart", $corp);
        }

//        
//        redirect('Audit/allAudits');
    }

    function dashboard($corpId) {
        $this->page_title = "Dashboard";
        $this->corporate = $corpId;
        $data['me'] = $this->user->getMe();
        $userTypeId = $data['me']['user']['user_type'];
        $data['corpId'] = $corpId;
        $data['audits'] = $this->audit->getAuditCount($corpId);
        $data['issues'] = $this->issue->getIssueCount($corpId);
        $data['issuesunpublished'] = $this->issue->getIssueUnpublishedCount($corpId);
        $data['issuespublishedtoMgnt'] = $this->issue->getIssuepublishedtoMgntCount($corpId);
        $data['issuesunpublishedtoCEO'] = $this->issue->getIssuepublishedtoCEOCount($corpId);
        $data['issuesunpublishedtoBoard'] = $this->issue->getIssuepublishedtoBoardCount($corpId);
        $data['openIssues'] = $this->issue->getIssueOpenCount($corpId);
        $data['closedIssues'] = $this->issue->getIssueClosedCount($corpId);
        $data['auditslist'] = $this->audit->getAll($corpId);
        $data['auditArealist'] = $this->auditArea->getAll($corpId);
        if($userTypeId == 6){
            $data['issueslist'] = $this->issue->getIssuesPublishedToManagementandBelongToYou($corpId, $data['me']['user']['id']);
        }  else {
            $data['issueslist'] = $this->issue->getAll($corpId);
        }
        $data['audit_area'] = $this->auditArea->getAll($corpId);
        

        function cmp($a, $b) {
            return ($a['issue_count'] > $b['issue_count']) ? -1 : 1;
        }

        usort($data['audit_area'], "cmp");

        $this->page("DashboardView", $data);
    }

    function auditForm($id = 0, $corpId) {
        if ($id == 0) {
            $data['draft'] = $this->user->getMyId();
            $data['user'] = $data['draft'];
            $data['corporate'] = $corpId;
            $new = $this->audit->add($data);
            redirect("Audit/auditForm/{$new['id']}/{$new['corporate']}");
        }
        $data['audit'] = $this->audit->get($id);
        $data['auditor'] = $this->user->getAuditors();
        $data['audit_area'] = $this->auditArea->getAll($corpId);
//        $data['environments_unsorted'] = $this->environment->getEnvironments();
        $data['environments'] = $this->environment->getEnvs($corpId);
        
//        foreach ($data['corp_det'] as $key => $env) {
//            if (!isset($data['environments'][$env['environment_level']['name']])) {
//                $data['environments'][$env['environment_level']['name']] = [];
//            }
//            $data['environments'][$env['environment_level']['name']][] = $env;
//        }
//        print_pre($data['environments']); exit;
        $this->modal("Form_Audit_View", $data);
    }

    function deleteAudit($id = 0, $confirmed = false) {// MODAL
        $data['audit'] = $this->audit->get($id);
        if (!$confirmed) {
            $this->modal("deleteAuditModal", $data);
        } else {
            $_record = $this->audit->get($id);
            $this->activityTrail->add(array(
                "module" => "audit",
                "table" => $this->audit->table,
                "record" => $id,
                "title" => "Audit Deleted",
                "message" => "An Audit <strong>{$_record['audit_name']}</strong> has been deleted"
            ));
            if ($data['audit']['draft'] == 0) {
                $message = "Audit Deleted Successfully";
            } else {
                $message = "Audit Draft Deleted Successfully";
            }
            $corp = $_record['corporate'];
            $this->audit->delete($id);
            redirect("Audit/allAudits/{$corp}?message=$message");
        }
    }

    function postAudit($ajaxResponse = false) { // FORM FORM ACTION
        $data = $this->input->post();
        $data['environment'] = json_encode($data['environment']);
        $data['audit_area'] = json_encode($data['audit_area']);

        if (isset($data['id'])) {
            $_record = $this->audit->get($data['id']);
            if ($_record['draft'] != 0) {
                $this->activityTrail->add(array(
                    "module" => "audit",
                    "table" => $this->audit->table,
                    "record" => $_record['id'],
                    "title" => "New Audit",
                    "message" => "A new Audit <strong>{$data['audit_name']}</strong> has been created",
                    "link" => "Audit/{$_record['id']}"
                ));
                // edit Message 
            } else {
                $this->activityTrail->add(array(
                    "module" => "audit",
                    "table" => $this->audit->table,
                    "record" => $_record['id'],
                    "title" => "Audit Edited",
                    "message" => "An Audit <strong>{$_record['audit_name']}</strong> has been edited",
                    "link" => "Audit/{$_record['id']}"
                ));
                // add message
            }
        }

        $this->audit->edit($data);
        redirect("Audit/audit/{$data['id']}?message=changes saved");
    }

    function audit($id, $report = NULL) {
        $data['report'] = '$report';
        $data['me'] = $this->user->getMe();
        $userTypeId = $data['me']['user']['user_type'];
        $data['audit'] = $this->audit->get($id);
        $data['corpId'] = $data['audit']['corporate'];
        $this->corporate = $data['corpId'];
        $this->page_title = $data['audit']['audit_name'];
        $data['audit_ar'] = jsonToArray($data['audit']['audit_area']);
        if (!empty($data['audit_ar'])) {
            foreach ($data['audit_ar'] as $key => $value) {
                $data['audit_area'][] = $this->auditArea->get($value);
            }
        } else {
            $data['audit_area'] = array();
        }

        $data['environ'] = jsonToArray($data['audit']['environment']);

        foreach ($data['environ'] as $key => $value) {
            $data['environment'][] = $this->environment->get($value);
        }
//        $data['environment'] = $this->environment->get($data['audit']['environment']);
        $data['auditor'] = $this->user->get($data['audit']['auditor']);
        if($userTypeId == 6){
            $data['issues'] = $this->issue->getIssuesPublishedToBoardandBelongToYouByAudit($data['me']['user']['id'], $data['audit']['id']);
        }  else {
            $data['issues'] = $this->issue->getAllIssuesInAudit($data['audit']['id']);
        }
//        $data['audit_area'] = $this->auditArea->get($data['audit']['audit_area']);
//        print_pre($data); exit;

        $this->page("AuditDetailView", $data);
    }

    function auditDraft() {
        $data = $this->input->post();
        $data['environment'] = json_encode($data['environment']);
        $data['audit_area'] = json_encode($data['audit_area']);
        $this->audit->draft($data);
    }

    function saveAuditDraft() {
        $data = $this->input->post();
        $this->audit->draft($data);
        $message = "Audit Draft Saved Successfully";
        redirect('Audit/allAudits/');
    }

    function issue($id) {
        $this->page_title = "Issue";
        $data['issue'] = $this->issue->get($id);
        $data['me'] = $this->user->getMe();
        $data['corpId'] = $data['issue']['corporate'];
        $auditId = $data['issue']['audit'];
        $this->corporate = $data['corpId'];
        $data['audit'] = $this->audit->get($auditId);
        $data['environ'] = jsonToArray($data['audit']['environment']);
        foreach ($data['environ'] as $key => $value) {
            $data['environment'][] = $this->environment->get($value);
        }
        $data['auditor'] = $this->user->get($data['audit']['auditor']);
        $data['audit_area'] = $this->auditArea->get($data['issue']['audit_area']);
        $data['action_plans'] = $this->action_plans->getActionPlanByIssue($id);
        $data['issue_owner'] = $this->user->get($data['issue']['issue_owner']);
        //////
        $issueId = $id;
        $sql = "SELECT * FROM `g_bridge` WHERE `table_1` LIKE 'issue' AND `record_1` = $issueId";
        $risks = $this->db->query($sql)->result_array();
        foreach ($risks as $key => $value) {
            $data['riskIssues'][] = $this->risk->get($value['record_2']);
        }
        //////
        $data['issue_response_by_date'] = $this->issue->getIssueResponseDate($id);
        $data['ceo_issue_response_by_date'] = $this->issue->getCEOIssueResponseDate($id);
        $data['audit_comment'] = $this->auditComment->getIssueComment($data['issue']['id']);
        $data['auditor_comment'] = $this->auditComment->getAuditorIssueComment($data['issue']['id']);
        $data['auditor_comment_name'] = $this->user->get($data['auditor_comment']['user']);
        $this->page("IssueDetailView", $data);
    }

    //FYI
//ALTER TABLE `issue` CHANGE `implication_type` `implication_type` ENUM('Loss of Opportunity','Risk Exposure') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
    function issueForm($id = 0, $audit) {
        if ($id == 0) {
            $data['draft'] = $this->user->getMyId();
            $data['audit'] = $audit;
            $info = $this->audit->get($audit);
            $data['corporate'] = $info['corporate'];
            $data['user'] = $data['draft'];
            $new = $this->issue->add($data);
            redirect("Audit/issueForm/{$new['id']}/{$audit}");
        }
        $this->page_title = "Issue Form";
        $data['audit_details'] = $this->audit->get($audit);
        $data['audit_areas'] = $this->auditArea->getAll($data['audit_details']['corporate']);
        $data['audit'] = $audit;
        $data['corpId'] = $data['audit_details']['corporate'];
        $this->corporate = $data['corpId'];
        $data['issue'] = $this->issue->get($id);
        $data['categories'] = $this->riskCategory->getChildLevels(0);
        $data['risks'] = $this->risk->getAll();
        $data['unit_owners'] = $this->user->getUnitOwnersbyCorp($data['corpId']);
        $data['risks_proposed'] = $this->risk->getProposedRisks();
        $data['risks_approved'] = $this->risk->getApprovedRisks();
        $this->page("Form_Issue_Page_copy_1", $data);
    }

    function issueDraft() {
        $data = $this->input->post();
        $this->issue->draft($data);
    }

    function saveIssueDraft() {
        $data = $this->input->post();
        $this->issue->draft($data);
        $message = "Issue Draft Saved Successfully";
        redirect('Audit/audit/');
    }

    function issuePost($ajaxResponse = false) { // FORM FORM ACTION
        $data = $this->input->post();
        if (isset($data['risk_associated'])) {
            $data['risk_associated'] = json_encode($data['risk_associated']);
        }
        $data['user'] = $this->user->getMyId();
        if (isset($data['id'])) {
            $_record = $this->issue->get($data['id']);
            if ($_record['draft'] != 0) {
                $this->activityTrail->add(array(
                    "module" => "audit",
                    "table" => $this->issue->table,
                    "record" => $_record['id'],
                    "title" => "New Audit",
                    "message" => "A new Audit <strong>{$data['title']}</strong> has been created",
                    "link" => "Audit/{$_record['id']}"
                ));
                // edit Message 
            } else {
                $this->activityTrail->add(array(
                    "module" => "audit",
                    "table" => $this->issue->table,
                    "record" => $_record['id'],
                    "title" => "Audit Edited",
                    "message" => "An Audit <strong>{$_record['title']}</strong> has been edited",
                    "link" => "Audit/{$_record['id']}"
                ));
                // add message
            }
        }
        if (isset($data['risk_associated'])) {
            $this->bridge->addRisksToIssue($data['id'], $data['risk_associated'], $data['user']);
        }
        $this->issue->edit($data);
        redirect("Audit/issue/{$data['id']}?message=changes saved");
    }

    function deleteIssue($id = 0, $confirmed = false) {// MODAL
        $data['issue'] = $this->issue->get($id);
        if (!$confirmed) {
            $this->modal("deleteIssueModal", $data);
        } else {
            $_record = $this->issue->get($id);
            $this->activityTrail->add(array(
                "module" => "Audit",
                "table" => $this->issue->table,
                "record" => $id,
                "title" => "Issue Deleted",
                "message" => "An Issue <strong>{$_record['title']}</strong> has been deleted"
            ));
            if ($data['issue']['draft'] == 0) {
                $message = "Issue Deleted Successfully";
            } else {
                $message = "Issue Draft Deleted Successfully";
            }

            $this->issue->delete($id);
            redirect("Audit/audit/{$data['issue']['audit']}?message=$message");
        }
    }

    function recommendationForm($id = 0, $issue) {
        if ($id == 0) {
            $data['draft'] = $this->user->getMyId();
            $data['user'] = $data['draft'];
            $data['issue'] = $issue;
            $new = $this->recommendation->add($data);
            redirect("Audit/recommendationForm/{$new['id']}/$issue");
        }
        $data['recommendation'] = $this->recommendation->get($id);
//        print_pre($data['recommendation']);
        $this->modal("Form_Recommendation_View", $data);
    }

    function recommendationPost($ajaxResponse = false) { // FORM FORM ACTION
        $data = $this->input->post();

        if (isset($data['id'])) {
            $_record = $this->recommendation->get($data['id']);
            if ($_record['draft'] != 0) {
                $this->activityTrail->add(array(
                    "module" => "Audit",
                    "table" => $this->recommendation->table,
                    "record" => $_record['id'],
                    "title" => "New Recommendation",
                    "message" => "A new Recommendation <strong>{$data['recommendation']}</strong> has been created",
                    "link" => "Issue/{$_record['issue']}"
                ));
                // edit Message 
            } else {
                $this->activityTrail->add(array(
                    "module" => "Audit",
                    "table" => $this->recommendation->table,
                    "record" => $_record['id'],
                    "title" => "Recommendation Edited",
                    "message" => "A Recommendation <strong>{$_record['recommendation']}</strong> has been edited",
                    "link" => "Issue/{$_record['issue']}"
                ));
                // add message
            }
        }

        $this->recommendation->edit($data);
        redirect("Audit/issue/{$data['issue']}?message=changes saved");
    }

    function deleteRecommendation($id = 0, $confirmed = false) {// MODAL
        $data['recommendation'] = $this->recommendation->get($id);
        if (!$confirmed) {
            $this->modal("deleteRecommendationModal", $data);
        } else {
            $_record = $this->recommendation->get($id);
            $this->activityTrail->add(array(
                "module" => "Audit",
                "table" => $this->recommendation->table,
                "record" => $id,
                "title" => "Recommendation Deleted",
                "message" => "A Recommendation <strong>{$_record['recommendation']}</strong> has been deleted"
            ));
            if ($data['recommendation']['draft'] == 0) {
                $message = "Recommendation Deleted Successfully";
            } else {
                $message = "Recommendation Draft Deleted Successfully";
            }

            $this->recommendation->delete($id);
            redirect("Audit/issue/{$data['recommendation']['issue']}?message=$message");
        }
    }

    function recommendationCommentView($id) {
        $data['recommendation'] = $this->recommendation->get($id);
        $this->modal("Recommendation_comments", $data);
    }

    function recommendationView($id) {
        $this->page_title = "Recommendation";
        $data['recommendation'] = $this->recommendation->get($id);
        $data['issue'] = $this->issue->get($data['recommendation']['issue']);
        $data['action_plans'] = $this->action_plans->getActionPlanByRecommendation($id);
        $this->page("RecommendationDetailView", $data);
    }

    function actionplanForm($id = 0, $issue) {
        if ($id == 0) {
            $info['issue'] = $this->issue->get($issue);
            $data['draft'] = $this->user->getMyId();
            $data['user'] = $data['draft'];
            $data['issue'] = $issue;
            $data['corporate'] = $info['issue']['corporate'];
            $data['action_plan_owner'] = $info['issue']['issue_owner'];
            $new = $this->action_plans->add($data);

            redirect("Audit/actionplanForm/{$new['id']}/$issue");
        }
        $data['unit_owners'] = $this->user->getUnitOwners();
        $data['issue'] = $this->issue->get($issue);
        $data['action_plans'] = $this->action_plans->get($id);

        $this->modal("Form_ActionPlan_View", $data);
    }

    function actionplanPost($ajaxResponse = false) { // FORM FORM ACTION
        $data = $this->input->post();
        if (isset($data['id'])) {
            $_record = $this->action_plans->get($data['id']);
            if ($_record['draft'] != 0) {
                $this->notification->managementActionPlanCreated($data['id']);
                $this->activityTrail->add(array(
                    "module" => "Audit",
                    "table" => $this->action_plans->table,
                    "record" => $_record['id'],
                    "title" => "New Management Action Plan",
                    "message" => "A new Management Action Plan <strong>{$data['action_plan']}</strong> has been created",
//                    "link" => "I/{$_record['recommendation']}"
                ));
                // edit Message 
            } else {
                $this->activityTrail->add(array(
                    "module" => "Audit",
                    "table" => $this->action_plans->table,
                    "record" => $_record['id'],
                    "title" => "Management Action Plan Edited",
                    "message" => "A Management Action Plan <strong>{$_record['action_plan']}</strong> has been edited",
                    "link" => "Recommendation/{$_record['issue']}"
                ));
                // add message
            }
        }

        $this->action_plans->edit($data);
        redirect("Audit/issue/{$data['issue']}?message=changes saved");
    }

    function action_plan($id) {
        $this->page_title = "Management Action Plan";
        $me = $this->user->getMe();
        $data['me'] = $me['user']['id']; 
        $data['action_plan'] = $this->action_plans->get($id);
        $data['action_plan_owner'] = $this->user->get($data['action_plan']['action_plan_owner']);
        $data['issue'] = $this->issue->get($data['action_plan']['issue']);
        $data['audit'] = $this->audit->get($data['issue']['audit']);
//        $data['recommendation'] = $this->recommendation->get($data['action_plan']['recommendation']);
        $this->modal("ActionPlanViewDetail", $data);
    }

    function action_filter() {
        $filters = $this->input->post();
//        print_pre($filters); 
        $actionlist = $this->action_plans->getAll($filters['corpId']);
//       print_pre($actionlist); exit;
        $results = [];
        $flag = true;
        foreach ($actionlist as $key => $value) {
            $flag = true;
            if (isset($filters['audit']) and $filters['audit'] != 0) {
                if ($filters['audit'] == $value['issue']['audit']) { // prev condition 
                    $flag = true;
                } else {
;
                    $flag = false;
                }
            }

            if (isset($filters['issue']) and $filters['issue'] != 0) {
                if ($filters['issue'] == $value['issue']['id']) {
                    $flag = true;
                } else {
;
                    $flag = false;
                }
            }

            if (isset($filters['active_status']) and $filters['active_status'] != null) {
                if ($filters['active_status'] == $value['active_status']) { // prev condition 
                    $flag = true;
                } else {
                    $flag = false;
                }
            }

            if ($flag) {
                $results[] = $value;
            }
        }


        $data['actionlist'] = $results;

        $this->ajax("action_filter_list", $data);
    }

    function allActionPlans($corpId) {
        $this->corporate = $corpId;
        $this->page_title = "All Management Action Plans";
        $data['corpId'] = $corpId;
        $data['auditslist'] = $this->audit->getAll($corpId);
        $data['issueslist'] = $this->issue->getAll($corpId);

        $this->page("ActionPlanDashboard", $data);
    }

    function deleteActionPlan($id = 0, $confirmed = false) {// MODAL
        $data['action_plan'] = $this->action_plans->get($id);
        if (!$confirmed) {
            $this->modal("deleteActionPlanModal", $data);
        } else {
            $_record = $this->action_plans->get($id);
            $this->activityTrail->add(array(
                "module" => "audit",
                "table" => $this->audit->table,
                "record" => $id,
                "title" => "Action Plan Deleted",
                "message" => "An Action Plan <strong>{$_record['audit_name']}</strong> has been deleted"
            ));
            if ($data['audit']['draft'] == 0) {
                $message = "Action Plan Deleted Successfully";
            } else {
                $message = "Action Plan Draft Deleted Successfully";
            }

            $this->action_plans->delete($id);
            redirect("Audit/issue/{$data['action_plan']['issue']}?message=$message");
        }
    }

    function actionPlanApprove($id = 0, $status = NULL) {
        $_record = $this->action_plans->get($id);
        if ($status == "Yes") {
            $trail = "Approved";
        } else {
            $trail = "Rejected";
        }
        $this->activityTrail->add(array(
            "module" => "audit",
            "table" => $this->action_plans->table,
            "record" => $id,
            "title" => "Action Plan $trail",
            "message" => "An Action Plan <strong>{$_record['action_plan']}</strong> has been $trail"
        ));
        $message = "Action Plan: " . $_record['action_plan'] . " has beeen " . $trail . " Successfully";

        $this->action_plans->approveActionPlan($id, $status);
        redirect("Audit/action_plan/{$id}?message=$message");
    }

    function actionPlanImplementVerify($id = 0, $status = NULL) {
        $_record = $this->action_plans->get($id);

        $this->activityTrail->add(array(
            "module" => "audit",
            "table" => $this->action_plans->table,
            "record" => $id,
            "title" => "Action Plan {$_record['action_plan']}",
            "message" => "An Action Plan <strong>{$_record['action_plan']}</strong> is $status"
        ));
        $message = "Action Plan: " . $_record['action_plan'] . " has beeen " . $status . " Successfully";

        $this->action_plans->implementVerifyActionPlan($id, $status);
        if ($status == 'Verified') {
            $this->issue->checkActionPlanStatus($_record['issue']);
        }
        redirect("Audit/action_plan/{$id}?message=$message");
    }

    function supersedeReason($id) {
        $data['action_plan'] = $this->action_plans->get($id);
        $this->modal("SupersedeReasonModal", $data);
    }

    function supersedeReasonPost() {
        $data = $this->input->post();
        $data['implementation_status'] = "Superseded";
        $data['verification_status'] = "Unverified";
//        print_pre($data); exit;
        $this->action_plans->edit($data);
        $this->notification->managementActionPlanImplementationStatus($data['id']);
        redirect("Audit/issue/{$data['issue']}");
    }

    function allAudits($corpId) {
        $this->corporate = $corpId;
        $this->page_title = "All Audits";
        $data['corpId'] = $corpId;
        $data['audits'] = $this->audit->getAll($corpId);

        $this->page("AuditsView", $data);
    }

    function AuditIssuesList($id) {
        $data['issues'] = $this->issue->getAllIssuesInAudit($id);
        $data['audit'] = $this->audit->get($id);
        $this->modal("AuditIssuesListModal", $data);
    }

    function AuditAreaIssuesList($id) {
        $data['issues'] = $this->issue->getAllIssuesInAuditArea($id);
        $data['auditarea'] = $this->auditArea->get($id);
        $this->modal("AuditAreaIssuesListModal", $data);
    }

    function publishAuditReportToBoard($id) {
        $data['audit'] = $this->audit->get($id);
        $data['issue_owner'] = $this->user->get($data['audit']['user']);
        $data['issues_pub'] = $this->issue->getIssuesPublishedToBoard($id);
        $data['audit_report'] = $this->audit->pullLatestReportDataByAudit($id);
//        print_pre($data); exit;
        $this->modal("PublishAuditReportToBoardModal", $data);
    }

    function publishAuditReportpost() {
        $data = $this->input->post();
        $audit = $data['audit'];
        if (isset($_FILES['attachments']) and count($_FILES['attachments']['name']) > 0) {
            $this->uploadModel->destination = array(
                'module' => 'audit', 'table_name' => 'audit_report', 'record_id' => $audit
            );
            $files = $this->uploadModel->uploadMultipleFiles('attachments');
        }
        $this->audit->publishAuditToBoard($audit);
        redirect("Audit/audit/{$audit}");
    }

    function issueToggleOpenClose($id, $status) {
        $result = $this->issue->issueToggleStatus($id, $status);
        if ($result) {
            $message = "Issue has been {$status} successfully";
            redirect("Audit/issue/{$id}?message=$message");
        }
    }

    function publishAuditpost() {
        $data = $this->input->post();
        $id = $data['audit'];
        $reciepient = $data['reciepient'];
        $_record = $this->audit->get($id);
        $this->activityTrail->add(array(
            "module" => "audit",
            "table" => $this->audit->table,
            "record" => $id,
            "title" => "Issue Published",
            "message" => "An Audit <strong>{$_record['audit_name']}</strong> has been published to $reciepient"
        ));
        $message = "Audit Published to $reciepient Successfully";


        $this->audit->publishAudit($data);
        redirect("Audit/audit/{$id}?message=$message");
    }

    function publish($id, $reciepient) {
        $data['issue'] = $this->issue->get($id);
        $data['reciepient'] = $reciepient;
        $this->modal("PublishIssueModal", $data);
    }

    function publishSelected($id, $reciepient) {
        $data['reciepient'] = $reciepient;
        $data['audit'] = $this->audit->get($id);
        $data['issue_owner'] = $this->user->get($data['audit']['user']);
        $data['unpub_issues'] = $this->issue->getIssuesUnPublishedToGlobal($id, $reciepient);
        foreach ($data['unpub_issues'] as $key => $value) {
            $data['unpub_issues'][$key]['issueActionPlans'] = $this->action_plans->getActionPlanByIssue($value['id']);
        }
        $data['pub_issues'] = $this->issue->getIssuesPublishedToGlobal($id, $reciepient);
        $this->modal("PublishSelectAuditView", $data);
    }

    function publishpost() {
        $data = $this->input->post();
        $id = $data['issue'];
        $reciepient = $data['reciepient'];
        $_record = $this->issue->get($id);
        $data['audit'] = $_record['audit'];
        $this->activityTrail->add(array(
            "module" => "audit",
            "table" => $this->issue->table,
            "record" => $id,
            "title" => "Issue Published",
            "message" => "An Issue <strong>{$_record['title']}</strong> has been published to $reciepient"
        ));
        $message = "Issue Published to $reciepient Successfully";


        $this->issue->publishIssue($data);
        redirect("Audit/issue/{$id}?message=$message");
    }

    function publishSelectedIssues() {
        $data = $this->input->post();
        $reciepient = $data['reciepient'];
        $audit = $data['audit'];
        if(!empty($data['issues'])){
        $this->issue->PublishIssuesGlobal($data);
        $message = "Issues Published Successful to {$reciepient}";
        }else{
            $message = "No Issues have been selected for publishing";
        }
//        print_pre($data); exit;

        redirect("Audit/audit/{$audit}?message=$message");
    }

    function summer() {
        $this->page("Summernote");
    }

    function auditAreaForm($id = 0, $corpId, $ref_id = Null, $form = Null) {
        $data['message'] = $this->input->get("message");
        if ($id == 0) {
            $data['audit_area'] = $this->auditArea->fields;
            foreach ($data['audit_area'] as $key => $value) {
                $data['audit_area'][$key] = NULL;
            }
        } else {
            $data['audit_area'] = $this->auditArea->get($id);
        }
        $data['audit_areas'] = $this->auditArea->getAll($corpId);
        $data['corpId'] = $corpId;
        foreach ($data['audit_areas'] as $key => $value) {
            $data['audit_areas'][$key]['audits'] = $this->audit->getAuditAreaPerAuditCount($value['id']);
        }
        if (isset($ref_id) && isset($form)) {
            $data['ref_form'] = $form;
            $data['ref_id'] = $ref_id;
            if ($form == "issue") {
                $area = $this->issue->get($ref_id);
                $_record = $area;
                $data['auditissue'] = $_record['audit'];
            }
        }
//        print_pre($data); exit;
        $this->modal("AuditAreaForm", $data);
    }

    function auditAreaDelete($id = 0, $confirmed = false) {
        if ($confirmed) {
            $_record = $this->auditArea->get($id);
            $this->activityTrail->add(array(
                "module" => "Audit",
                "table" => $this->auditArea->table,
                "record" => $_record['id'],
                "title" => "Deleted Audit Area ",
                "message" => "An Audit Area  <strong>{$_record['title']}</strong> has been deleted",
            ));
            $this->auditArea->delete($id);
            redirect("Audit/auditAreaForm/0/" . $_record['corporate'] . "?message=Audit Area <strong>{$_record['title']}</strong> has been deleted successfully");
        } else {
            $data['audit_area'] = $this->auditArea->get($id);
            $this->modal("auditAreaDelete", $data);
        }
    }

    function auditAreaPost() {
        $data = $this->input->post();
        if ($data['id']) {
            $new = $data;
            $this->auditArea->edit($data);
            $_record = $this->auditArea->get($data['id']);
            $this->activityTrail->add(array(
                "module" => "audit",
                "table" => $this->auditArea->table,
                "record" => $_record['id'],
                "title" => "Edited Audit Area ",
                "message" => "An Audit area  <strong>{$_record['title']}</strong> has been edited",
                "link" => "Audit/auditArea/{$_record['id']}"
            ));
        } else {
            $new = $this->auditArea->add($data);
            $_record = $new;
            $this->activityTrail->add(array(
                "module" => "audit",
                "table" => $this->auditArea->table,
                "record" => $_record['id'],
                "title" => "Edited Audit Area ",
                "message" => "An Audit area  <strong>{$_record['title']}</strong> has been edited",
                "link" => "Audit/auditArea/{$_record['id']}"
            ));
        }
        if ((!empty($data['ref_form'])) && (!empty($data['ref_id']))) {
            redirect("Audit/auditAreaForm/0/" . $_record['corporate'] . '/' . $data['ref_id'] . "/" . $data['ref_form'] . "?message=changes saved");
        } else {
            redirect("Audit/auditAreaForm/0/" . $_record['corporate'] . "?message=changes saved");
        }
    }

    function auditArea($id) {
        
    }

    function topRisks() {
        $data = $this->issue->getTopRisks();
        $it = new RecursiveIteratorIterator(new RecursiveArrayIterator($data)); // convert to single dim array
        $l['all'] = iterator_to_array($it, false); // convert to single dim array   
        $l['array_count'] = array_count_values($l['all']);
        arsort($l['array_count']);
        $l['final'] = array_slice($l['array_count'], 0, 10, true);
        foreach ($l['final'] as $key => $value) {
            $l['final_keys'][$key] = $this->risk->getrisktitlebyId($key);
        }
        $l['finito'] = array_combine($l['final_keys'], $l['final']);
        return $l['finito'];
//        print_pre($l); // one Dimensional 
//        print_pre($data);
    }

    function AuditReportSelectIssues($id) {
        $data['audit'] = $this->audit->get($id);
        $data['issues'] = $this->issue->getIssuestoPublishToBoard($id);
        $data['published_issues'] = $this->issue->getIssuesPublishedToBoard($id);
        $data['issue_owner'] = $this->user->get($data['audit']['user']);
        $data['published_issues_Id'] = array();
        foreach ($data['published_issues'] as $key => $value) {
            $data['published_issues_Id'][] = $value['id'];
        }
        $this->modal('AuditReportSelectIssues', $data);
//        print_pre($data); exit;
    }

    function setIssuesInReport() {
        $data = $this->input->post();
        $this->issue->publishIssueToReport($data);
        $this->issue->getIssuesPublishedToBoard($data['audit']);
//        $this->audit->deletePreviousReport($data['audit']);
        redirect("Audit/audit/" . $data['audit']);
    }

    function PreviewIssueInReport($id = 0, $audit) {
        if ($id == 0) {
            $check = $this->audit->pullLatestReportDataByAudit($audit);
            if (!empty($check)) {
                redirect("Audit/PreviewIssueInReport/{$check['id']}/{$audit}");
            } else {
                $data['draft'] = $this->user->getMyId();
                $data['audit'] = $audit;
                $data['user'] = $data['draft'];
                $new = $this->audit->addAuditReport($data);
                redirect("Audit/PreviewIssueInReport/{$new['id']}/{$audit}");
            }
        }
        $this->page_title = "Prepare Audit Report";
        $info['report'] = $this->audit->pullLatestReportData($id, $audit);
        $info['audit'] = $this->audit->get($audit);
        $info['corpId'] = $info['audit']['corporate'];
        $this->corporate = $info['corpId'];
        $info['audit_areas'] = array();
        $info['audit_area'] = json_decode($info['audit']['audit_area'], TRUE);
        foreach ($info['audit_area'] as $key => $value) {
            $info['audit_areas'][$key] = $this->auditArea->get($value);
            $info['audit_areas'][$key]['issues'] = $this->issue->getIssuesPublishedToBoardByAuditArea($value, $audit);
        }
        $this->page('PrepareReport', $info);
    }

    function postAuditReport($ajaxResponse = false) {
        $data = $this->input->post();
        $this->audit->prepareReport($data);
        $message = "Audit Report Saved Successfully";
        redirect("Audit/audit/" . $data['audit'] . "?message=$message");
    }

    function auditReportDraft() {
        $data = $this->input->post();
        $this->audit->AuditReportdraft($data);
    }

    function saveAuditReportDraft() {
        $data = $this->input->post();
        $this->audit->AuditReportdraft($data);
        $message = "Audit Report Draft Saved Successfully";
        redirect("Audit/audit/" . $data['audit']);
    }

    function issues_filter() {
        $filters = $this->input->post();
        $user = $this->user->getMe();
        $userTypeId = $user['user']['user_type'];
        $userId = $user['user']['id'];
        if($userTypeId == 6){
            $issueslist = $this->issue->getIssuesPublishedToBoardandBelongToYou($filters['corpId'], $userId);
        }  else {
            $issueslist = $this->issue->getAll($filters['corpId']);
        }
//        $issueslist = $this->issue->getAll($filters['corpId']);
        $results = [];
        $flag = true;

//        print_pre($issueslist);
//        exit;

        foreach ($issueslist as $key => $value) {
//            print_pre($filters);
//            $flag = true;
            if (isset($filters['audit']) and $filters['audit'] != 0) {
                if ($filters['audit'] == $value['audit']['id']) { // prev condition 
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            if (isset($filters['auditArea']) and $filters['auditArea'] != 0) {
                if ($filters['auditArea'] == $value['audit_area']['id']) { // prev condition 
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            if (isset($filters['issue_rating']) and $filters['issue_rating'] != null) {
                if ($filters['issue_rating'] == $value['issue_rating']) { // prev condition 
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            if (isset($filters['implication_type']) and $filters['implication_type'] != null) {
                if ($filters['implication_type'] == $value['implication_type']) { // prev condition 
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            if (isset($filters['issue_status']) and $filters['issue_status'] != null) {
                if ($filters['issue_status'] == $value['issue_status']) { // prev condition 
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            if ($flag) {
                $results[] = $value;
            }
        }


        $data['issueslist'] = $results;

        $this->ajax("issue_filter_list", $data);
    }
    
    function testReminder() {
        
        $result = $this->auditComment->seekManagementCommentReminder();
//        $today = strftime("%Y-%m-%d", (time()));
//        $yesterday = strftime("%Y-%m-%d", (time() - (3600 * 24)));
//        $twoDaysBefore = strftime("%Y-%m-%d", (time() - (7200 * 24)));
//        foreach ($result as $key => $value) {
//           if((strftime("%Y-%m-%d", $value['respond_by_date']) == $twoDaysBefore) || (strftime("%Y-%m-%d", $value['respond_by_date']) == $yesterday) || (strftime("%Y-%m-%d", $value['respond_by_date']) == $today)){
//               $this->notification->managementCommentOverdue($value['id']); 
//           }
//        }
    }

    function testAR() {
$this->auditArea->AuditAreaCountInAudit();
    }

}
