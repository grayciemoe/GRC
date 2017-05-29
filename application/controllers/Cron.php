<?php

class Cron extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("Documents/UploadModel", "uploadModel");
        $this->load->model("Documents/DocumentsModel", "documentsModel");
        $this->load->model("Documents/CropModel", "cropModel");

        $this->load->model("Users/UserModel", "user");
        $this->load->model("Users/AuthModel", "auth");
        $this->load->model("Users/UserTypeModel", "userType");

        $this->load->model("Notification/NotificationModel", "notification");
        $this->load->model("Notification/CommsModel", "comms");

        $this->load->model("Risk/RiskModel", "risk");
        $this->load->model("Risk/CategoryModel", "category");
        $this->load->model("Risk/AnalysisModel", "analysis");
        $this->load->model("Risk/EvaluationModel", "evaluation");
        $this->load->model("Risk/ControlCategoryModel", "controlCategory");
        $this->load->model("Risk/ControlModel", "control");
        $this->load->model("Risk/ControlActivityModel", "activity");

        $this->load->model("Compliance/ComplianceRequirementModel", "compliance");
        $this->load->model("Compliance/ComplianceRequirementModel", "complianceRequirement");
        $this->load->model("Compliance/ComplianceVersionModel", "complianceVersion");
        $this->load->model("Compliance/BreachModel", "breach");
        $this->load->model("Compliance/ObligationComplyModel", "complies");
        $this->load->model("Compliance/ObligationModel", "obligation");
        $this->load->model("Compliance/AuthorityModel", "authority");
        $this->load->model("Compliance/ComplianceRegisterModel", "register");
        $this->load->model("Compliance/ObligationComplyModel", "comply");

        $this->load->model("IncidentManagement/IncidentActionsModel", "incidentActions");
        $this->load->model("IncidentManagement/IncidentCategoryModel", "incidentCategory");
        $this->load->model("IncidentManagement/IncidentCategoryModel", "category");
        $this->load->model("IncidentManagement/IncidentManagementModel", "incident");

        $this->load->model("ActivityTrail/ActivityTrailModel", "activityTrail");

        $this->load->model("Environment/RepositoryModel", "repository");
        $this->load->model("Environment/EnvironmentModel", "environment");
        $this->load->model("Environment/EnvironmentLevelModel", "environmentLevel");
        $this->load->model("DataIndexModel", "dataIndex");
        
        $this->load->model("Compliance/ComplianceRequirementModel", "compliance");
        $this->load->model("Compliance/ComplianceRegisterModel", "complianceRegister");
        $this->load->model("Compliance/ObligationComplyModel", "comply");
        $this->load->model("Compliance/BreachModel", "breach");
        $this->load->model("Compliance/ObligationModel", "obligation");
        $this->load->model("Bridge/BridgeModel", "bridge");
        $this->load->model("Compliance/ComplianceDependentModel", "complianceDependent");
        
        $this->load->model("Audit/AuditModel", "audit");
        $this->load->model("Audit/IssueModel", "issue");
        $this->load->model("Audit/RecommendationModel", "recommendation");
        $this->load->model("Audit/ActionPlansModel", "action_plans");
        $this->load->model("Audit/AuditAreaModel", "auditArea");
        $this->load->model("Audit/AuditCommentModel", "auditComment");
    }

    function index() {
        $this->seek_breach();
        $this->seek_notifications();
        $this->data_index();
        $this->send_email();
        $this->load->view("Cron");
    }

    function send_email() {
        $this->notification->autosendEmails();
    }

    function seek_breach() {
        $this->obligation->seekBreaches();
        //redirect("Compliance/seekBreach/");
    }

    function seek_notifications() {
        $this->obligation->seekNotifications();
        $this->auditComment->seekManagementCommentReminder();
        //redirect("Compliance/seekBreach/");
    }
    
    

    function data_index() {

        $this->dataIndex->environment();
        $this->dataIndex->compliance();
        $this->dataIndex->incidentManagement();
        $this->dataIndex->audit();
    }

}
