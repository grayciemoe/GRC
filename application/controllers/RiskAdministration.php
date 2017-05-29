<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RiskAdministration extends CI_Controller {

    public $sources;
    public $page_title;

    function __construct() {
        parent::__construct();
        $this->page_title = "Risk Admin ";
        $sources = array('best_practices', 'strategic_objectives', 'process', 'laws_and_regulations', 'corporate_policy', 'contract');
        foreach ($sources as $key => $value) {
            $this->sources[$value] = ucwords(str_replace("_", " ", $value));
        }

        $this->load->model("Documents/UploadModel", "uploadModel");
        $this->load->model("Documents/DocumentsModel", "documentsModel");
        $this->load->model("Documents/CropModel", "cropModel");

        $this->load->model("Users/UserModel", "user");
        $this->load->model("Users/AuthModel", "auth");
        $this->load->model("Users/UserTypeModel", "userType");
        $this->load->model("Notification/NotificationModel", "notification");

        if (!$this->auth->checkLogin()) {
            redirect("Login/?message=Please login to proceed");
        }



        $this->load->model("Users/UserModel", "user");
        $this->load->model("Users/AuthModel", "auth");
        $this->load->model("Users/UserTypeModel", "userType");

        $this->load->model("Notification/NotificationModel", "notification");

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

        $this->load->model("IncidentManagement/IncidentManagementModel", "incident");
        $this->load->model("IncidentManagement/IncidentManagementModel", "incidentManagement");
        $this->load->model("ActivityTrail/ActivityTrailModel", "activityTrail");

        $this->load->model("Environment/RepositoryModel", "repository");
        $this->load->model("Environment/EnvironmentModel", "environment");
        $this->load->model("Environment/EnvironmentLevelModel", "environmentLevel");
        
        $this->load->model("Audit/AuditModel", "audit");
        $this->load->model("Audit/IssueModel", "issue");
        $this->load->model("Audit/RecommendationModel", "recommendation");
        $this->load->model("Audit/ActionPlansModel", "action_plans");
        $this->load->model("Audit/AuditAreaModel", "auditArea");
        $this->load->model("Audit/AuditCommentModel", "auditComment");
    }

    function e404Hundler($filepath) {
        if (!file_exists("application/views/" . $filepath . ".php")) {
            $filename = "application/views/" . $filepath . ".php";
            /* echo "Error : File ('$filename') does not exist"; */ return false; // old code file put content removed
         }else {return true;}
    }

    function page($pageName = "", $pageData = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "RiskAdministration/Pages/" . ucwords($pageName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/RiskAdministration");
        }
        $data['page_title'] = $this->page_title;
        $data['message'] = ($this->input->get("message")) ? "<div style='padding:7px'>" . ucwords($this->input->get("message")) . "</div>" : NULL;

        $data['repository_sources'] = $this->sources;
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
        $data['me'] = $this->user->getMe();
        $this->load->view("Includes/HeadView", $data);
        $this->load->view("Includes/MainNavView", $data);
        $this->load->view("RiskAdministration/Includes/RiskAdministrationHeaderView");
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
        $this->load->view("Includes/FooterView");
    }

    function form($formName = "", $data = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "RiskAdministration/Forms/" . ucwords($formName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/RiskAdministration");
        }
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
        $this->load->view("RiskAdministration/Includes/RiskAdministrationHeaderView");
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
        $this->load->view("Includes/FooterView");
    }

    function modal($modalName = "", $pageData = array(), $scripts = array(), $stylesheets = array()) {
        if ($this->input->post("requestView") != "modal") {
            redirect("RiskAdministration/index/");
        }
        $filename = "RiskAdministration/Modals/" . ucwords($modalName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/RiskAdministration");
        }
        $data['data'] = $pageData;
        $data['message'] = ($this->input->get("message")) ? "<div style='padding:7px'>" . ucwords($this->input->get("message")) . "</div>" : NULL;
        $data['me'] = $this->user->getMe();
        $data['scripts'] = $scripts;
        $data['stylesheets'] = $stylesheets;
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
    }

    function comments() {
        $data['comments'] = $this->comments->getAll();
        //print_pre($data);
        $this->page("commentsView", $data);
    }

    function ajax($fileName = "", $data = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "RiskAdministration/Ajax/" . ucwords($pageName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/RiskAdministration");
        }
        $data['repository_sources'] = $this->sources;
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

    function notificationPopup($fileName = "", $data = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "RiskAdministration/NotificationsPopup/$pageName";
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/RiskAdministration");
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

    function unitForm($id = 0, $parent_id = 1) {
        $me = $this->user->getMe();
        if ($id == 0) {
            $next_level = $this->environment->nextLevel($parent_id);
            $data['parent_id'] = $parent_id;
            $data['environment_level'] = $next_level['id'];
            $data['unit_owner'] = $me['user']['id'];
            $data['draft'] = $me['user']['id'];
            $unit = $this->environment->add($data);
            redirect("RiskAdministration/unitForm/{$unit['id']}");
        }
        $data['repository_sources'] = $this->sources;
        $data['environment'] = $this->environment->get($id);
        $data['environment_level'] = $this->environmentLevel->get($data['environment']['environment_level']);
        $data['users'] = $this->user->getUnitOwners();
        $this->modal("UnitFormView", $data);
    }

    function postUnit() {
        $data = $this->input->post();
        $this->environment->edit($data);
        redirect("RiskAdministration/dashboard/{$data['parent_id']}?");
    }

    function index() {
        $data['risks'] = $this->risk->getInactive();
        $data['controls'] = $this->control->getUnapprovedControls();

        $data['activities'] = $this->activity->getInactive();
        $data['undefined'] = $this->risk->getUndefined();


        $this->page("RisksView", $data, array("jquery.dataTables.min", "dataTables.bootstrap4.min", "dataTables.buttons.min", "buttons.bootstrap4.min", "jszip.min", "pdfmake.min", "vfs_fonts", "buttons.html5.min", "buttons.print.min", "buttons.colVis.min", "dataTables.responsive.min", "responsive.bootstrap4.min"));
    }

    /* REPOSITORY / KEY RISK AREAS / RISK SOURCES / KRA-CLIPBOARD */

    //'best_practices','strategic_objectives','process','laws_and_regulations','corporate_policy','contract'

    function repositoryForm($id = 0, $source = false, $environment = 1, $parent_id = 0) {
        if ($id == 0) {
            $data['source'] = $source;
            $data['environment'] = $environment;
            $record = $this->repository->add($data);
            redirect("RiskAdministration/repositoryForm/{$record['id']}");
        }
        $data['repository'] = $this->repository->getRepository($id);

        $this->modal($data['repository']['source'] . "Form", $data);
    }

    function repositoryDelete($id = 0, $confirmed = false) {
        if ($confirmed) {
            $repository = $this->repository->getRepository($id);
            $this->repository->delete($id);
            redirect("RiskAdministration/dashboard/{$repository['environment']}");
        } else {
            $data['repository'] = $this->repository->getRepository($id);
            $this->modal("confrimDeleteRepositoryView", $data);
        }
    }

    function repositoryPreview($id = 0) {
        $data['repository'] = $this->repository->getRepository($id);
        $this->modal("preview_{$data['repository']['source']}_View", $data);
    }

    /* END REPOSITORY / KEY RISK AREAS / RISK SOURCES / KRA-CLIPBOARD */

    function findKRAsOptions($unit_id) {
        //sleep(10);
        $kras = $this->repository->getEnvironment($unit_id);
        $html = NULL;
        foreach ($kras as $key => $value) {
            $html .= "<option value='{$value['id']}'>{$value['name']}</option>";
        }
        echo $html;
    }

    function compliance() {
        $data['breaches'] = $this->breach->getInactive();
        $data['complies'] = $this->comply->getInactive();
        $data['obligations'] = $this->obligation->getInactive();

        $this->page("ComplianceView", $data, array("jquery.dataTables.min", "dataTables.bootstrap4.min", "dataTables.buttons.min", "buttons.bootstrap4.min", "jszip.min", "pdfmake.min", "vfs_fonts", "buttons.html5.min", "buttons.print.min", "buttons.colVis.min", "dataTables.responsive.min", "responsive.bootstrap4.min"));
    }

    function keyRiskArea() {
        $data['kra'] = $this->repository->getPending();
        $this->page("KeyRiskAreaView", $data, array("jquery.dataTables.min", "dataTables.bootstrap4.min", "dataTables.buttons.min", "buttons.bootstrap4.min", "jszip.min", "pdfmake.min", "vfs_fonts", "buttons.html5.min", "buttons.print.min", "buttons.colVis.min", "dataTables.responsive.min", "responsive.bootstrap4.min"));
    }

    function incidentManagement() {
        $data['incidents'] = $this->incident->getInactive();
        $this->page("IncidentManagementView", $data);
    }

    function users($user_id = 0) {
        $data['users'] = $this->user->getAll();
        foreach ($data['users'] as $key => $value) {
            $data['users'][$key]['user_type'] = $this->userType->get($value['user_type']);
        }
        $data['user'] = $this->user->getUser($user_id);

        $data['user_types'] = $this->userType->getAll();

        $data['me'] = $this->user->getme();
        $this->page("usersView", $data);
    }

    function riskAdministration() {


        $this->page("IncidentManagementView", array());
    }

    function usersForm($id = 0) {
        $me = $this->user->getMe();
        if ($id == 0) {
            $data['activated'] = 'false';
            $data['draft'] = $me['user']['id'];
            $data['password'] = "";
            $new = $this->user->add($data);
            redirect("RiskAdministration/usersForm/{$new['id']}");
        }
        $data['user'] = $this->user->get($id);

        $data['user_types'] = $this->userType->get($id);

        $this->modal("usersForm", $data);
    }

    function userPreview($id = 0) {
        
    }

    function usersDelete($id = 0, $confirmed = false) {
        if ($confirmed and $id) {
            $this->user->delete($id);
            redirect("RiskAdministration/users/?message=User Deleted");
        } else {
            $data['user'] = $this->user->get($id);
            $this->modal("userDeleteConfirm", $data);
        }
    }

    function userPost() {
        $data = $this->input->post();
        $this->user->edit($data);
        redirect("RiskAdministration/users/{$data['id']}?messsage=Changes Saved");
    }

    function settings() {
        $this->page("IncidentManagementView");
    }

}
