<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Documents extends CI_Controller {

    public $page_title;

    function __construct() {
        parent::__construct();
        $this->load->model("Users/UserModel", "user");
        $this->load->model("Users/AuthModel", "auth");
        $this->load->model("Users/UserTypeModel", "userType");
        $this->load->model("Users/UserTypeActionsModel", "userTypeActions");



        $this->load->model("Environment/EnvironmentModel", "environment");
        $this->load->model("Environment/EnvironmentLevelModel", "environmentLevel");
        $this->load->model("Environment/RepositoryModel", "repository");
        $this->load->model("Comments/CommentsModel", "comments");
        $this->load->model("Notification/NotificationModel", "notification");

        $this->load->model("Risk/RiskModel", "risk");
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
        $this->load->model("Documents/DocumentsModel", "doc");
        $this->load->model("Notification/NotificationModel", "notification");

        $this->load->model("Documents/UploadModel", "uploadModel");
        $this->load->model("Documents/DocumentsModel", "documentsModel");
        $this->load->model("Documents/CropModel", "cropModel");
        
        $this->load->model("Audit/AuditModel", "audit");
        $this->load->model("Audit/IssueModel", "issue");
        $this->load->model("Audit/RecommendationModel", "recommendation");
        $this->load->model("Audit/ActionPlansModel", "action_plans");
        $this->load->model("Audit/AuditAreaModel", "auditArea");
        $this->load->model("Audit/AuditCommentModel", "auditComment");

        //sleep(3);
        if (!$this->auth->checkLogin()) {
            redirect("Login/?message=Please login to proceed");
        }
        $this->page_title = "Documents | ";
    }

    function e404Hundler($filepath) {
        if (!file_exists("application/views/" . $filepath . ".php")) {
            $filename = "application/views/" . $filepath . ".php";
            return file_put_contents($filename, "<div class=\"container\">\n <?= __FILE__ ?>\n<!-- ============================================================== -->\n<!-- Start right Content here -->\n<!-- ============================================================== -->\n</div>");
        }
    }

    function page($pageName = "", $pageData = array(), $scripts = array(), $stylesheets = array()) {
        $data['me'] = $this->user->getMe();
        $filename = "Documents/Pages/" . ucwords($pageName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/Documents");
        }
        $data['title'] = $this->page_title;
        $data['page_title'] = $this->page_title;


        $data['message'] = ($this->input->get("message")) ? "<div style='padding:7px'>" . ucwords($this->input->get("message")) . "</div>" : NULL;
        $data['KRAs'] = count($this->repository->getPending());
        $data['risks'] = count($this->risk->getInactive());
        $data['controls'] = count($this->control->getUnapprovedControls());
        $data['control_activity'] = count($this->activity->getInactive());
        $data['obligations'] = count($this->obligation->getInactive());
        $data['breaches'] = count($this->breach->getInactive());
        $data['complies'] = count($this->comply->getInactive());
        $data['incidents'] = count($this->incident->getInactive());
        $data['data'] = $pageData;
        $data['me'] = $this->user->getMe();
        $data['stylesheets'] = $stylesheets;
        $data['scripts'] = $scripts;
        $this->load->view("Includes/HeadView", $data);
        $this->load->view("Includes/MainNavView", $data);
        $this->load->view("Documents/Includes/DocumentsHeaderView");
        $this->load->view($filename, $data);
        $this->load->view("Includes/FooterView");
    }

    function form($formName = "", $data = array(), $scripts = array(), $stylesheets = array()) {
        $data['me'] = $this->user->getMe();
        $filename = "Documents/Forms/" . ucwords($formName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/Documents");
        }$data['message'] = ($this->input->get("message")) ? "<div style='padding:7px'>" . ucwords($this->input->get("message")) . "</div>" : NULL;
        $data['KRAs'] = count($this->repository->getPending());
        $data['risks'] = count($this->risk->getInactive());
        $data['controls'] = count($this->control->getUnapprovedControls());
        $data['control_activity'] = count($this->activity->getInactive());
        $data['obligations'] = count($this->obligation->getInactive());
        $data['breaches'] = count($this->breach->getInactive());
        $data['complies'] = count($this->comply->getInactive());
        $data['incidents'] = count($this->incident->getInactive());
        $data['data'] = $data;
        $data['scripts'] = $scripts;
        $data['stylesheets'] = $stylesheets;
        $this->load->view("Includes/HeadView", $data);
        $this->load->view("Includes/MainNavView", $data);
        $this->load->view("Documents/Includes/DocumentsHeaderView");
        $this->load->view($filename, $data);
        $this->load->view("Includes/FooterView");
    }

    function modal($modalName = "", $pageData = array(), $scripts = array(), $stylesheets = array()) {
//        if ($this->input->post("requestView") != "modal") {
//            redirect("Documents/index/");
//        }
        $filename = "Documents/Modals/" . ucwords($modalName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/Documents");
        }
        $data['data'] = $pageData;
        $data['me'] = $this->user->getMe();
        $data['scripts'] = $scripts;
        $data['stylesheets'] = $stylesheets;
        $this->load->view($filename, $data);
    }

    function ajax($fileName = "", $data = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "Documents/Ajax/" . ucwords($pageName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/Documents");
        }
        $data['data'] = $pageData;
        $data['me'] = $this->user->getMe();
        $data['scripts'] = $scripts;
        $data['stylesheets'] = $stylesheets;
        $this->load->view($filename, $data);
    }

    function notificationPopup($fileName = "", $data = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "Documents/NotificationsPopup/$pageName";
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/Documents");
        }
        $data['data'] = $pageData;
        $data['me'] = $this->user->getMe();
        $this->load->view($filename, $data);
    }

    function index() {
        $this->page("DashboardView");
    }

    function previewFiles($module = "all", $table = null, $record = null) {
        $data['files'] = $this->doc->getAll();
        $data_array = [];
        $data_array['all'] = [];
        foreach ($data['files'] as $key => $value) {
            if (!$value['module']) {
                continue;
                $value['module'] = 'others';
            }
            if (!isset($data_array[$value['module']])) {
                $data_array[$value['module']] = [];
            }
            $data_array['all'][] = $value;
            $data_array[$value['module']][] = $value;
        }
//        print_pre($data_array);
//        exit;
        $data['files'] = $data_array;
        $this->page("PreviewFiles", $data);
    }

    function previewFile($id) {
        $data['file'] = $this->doc->getFile($id);
        $this->db->limit(1);
        $q = $this->db->get("authority");

        $data['authority'] = $q->row_array();

        $this->modal("previewFile", $data);
    }

    function uploadFiles() {
        $data = $this->input->post();
        $this->doc->uploadFiles($data);
        $this->previewFiles();
    }

    function uploadForm() {
        $this->form("UploadForm");
    }

    function deleteDocument($id = 0, $confirmed = false) {
        if (!$confirmed) {
            $data['file'] = $this->doc->getFile($id);
            $this->modal("confirmDeleteDocument", $data);
        } else {
            $this->doc->delete($id);
            redirect("Documents/previewFiles?message=File Deleted");
        }
    }

    function post() {
        $data = $this->input->post();

        echo $this->doc->edit($data) ? "Changes Saved" : "Error";
        $this->previewFiles();
        // echo "Changes Saved"
    }

    function editDocument($id = 0) {
        $data['file'] = $this->doc->getFile($id);
        $this->modal("documentForm", $data);
    }

}
