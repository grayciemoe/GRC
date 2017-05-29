<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AuditComment extends CI_Controller {

    function __construct() {
        parent::__construct();
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
            /* echo "Error : File ('$filename') does not exist"; */ return false; // old code file put content removed
        } else {
            return true;
        }
    }

    function modal($modalName = "", $pageData = array()) {

        $filename = "Audit/Modals/" . ucwords($modalName);
        $data['data'] = $pageData;
        $data['me'] = $this->user->getMe();
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
    }

    function auditComment($id, $auditor_manager ,$user = NULL) {
        $me = $this->user->getMe();
        if($user){
            $data['user_type'] = $user;
        }  else {
           $data['user_type'] = 6;
        }
        $data['issue'] = $id;
        $data['auditor_manager']=$auditor_manager;
        $data['audit_comment'] = $this->auditComment->getIssueComment($id);
        $this->modal("AuditCommentModal", $data);
    }

    function auditCommentPost() {
        $data = $this->input->post();
        $result = $this->auditComment->add($data);
        if ($result) {
            redirect("Audit/issue/{$data['issue']}");
        }
    }

    function editAuditComment($id,$auditor_manager) {
        $me = $this->user->getMe();
        $data['user'] = $me['user']['id'];
        $data['audit_comment'] = $this->auditComment->get($id);
        $data['auditor_manager']=$auditor_manager;
        $this->modal("AuditCommentEdit", $data);
    }

    function editComment() {
        $data = $this->input->post();
        $this->auditComment->edit($data);
        redirect("Audit/issue/{$data['issue']}");
    }

    function deleteAuditComment($id = 0, $confirm = false) {
         
        if ($confirm) {
            $data['audit_comment'] = $this->auditComment->get($id);
            $this->auditComment->delete($id);
            redirect('Audit/issue/'.$data['audit_comment']['issue']);
        } else {
            $data['audit_comment'] = $this->auditComment->get($id);
            $this->modal("AuditCommentDelete", $data);
        }
    }

}
