<?php

//sleep(1);
class IncidentManagement extends CI_Controller {

    public $risk_levels, $page_title;

    function __construct() {
        parent::__construct();


        $this->page_title = NULL;

        $this->load->model("Documents/UploadModel", "uploadModel");
        $this->load->model("Documents/DocumentsModel", "documentsModel");
        $this->load->model("Documents/CropModel", "cropModel");

        $this->load->model("Users/UserModel", "user");
        $this->load->model("Users/AuthModel", "auth");
        $this->load->model("Users/UserTypeModel", "userType");
        $this->load->model("Notification/NotificationModel", "notification");
        //$this->load->model("Documents/DocumentsModel", "document");


        if (!$this->auth->checkLogin()) {
            redirect("Login/?message=Please login to proceed");
        }
        //$this->load->model("Risk/RiskModel", "risk");
        // $this->load->model("risk/RiskCategoryModel", "riskCategory");
        $this->load->model("Environment/EnvironmentModel", "environment");
        $this->load->model("Environment/EnvironmentLevelModel", "environmentLevel");
        //$this->load->model("IncidentManagement/incidentReportModel", "incidentReport");

        $this->load->model("IncidentManagement/IncidentActionsModel", "incidentActions");
        $this->load->model("IncidentManagement/IncidentCategoryModel", "incidentCategory");
        $this->load->model("IncidentManagement/IncidentCategoryModel", "category");
        $this->load->model("IncidentManagement/IncidentManagementModel", "incident");

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
        $this->load->model("Compliance/BreachModel", "breach");
        $this->load->model("Compliance/ObligationComplyModel", "complies");
        $this->load->model("Compliance/ObligationModel", "obligation");
        $this->load->model("Compliance/AuthorityModel", "authority");
        $this->load->model("Compliance/ComplianceRegisterModel", "register");
        $this->load->model("Compliance/ObligationComplyModel", "comply");



        $this->load->model("Environment/RepositoryModel", "repository");
        $this->load->model("Environment/EnvironmentModel", "environment");
        $this->load->model("Environment/EnvironmentLevelModel", "environmentLevel");
        
        $this->load->model("Audit/AuditModel", "audit");
        $this->load->model("Audit/IssueModel", "issue");
        $this->load->model("Audit/RecommendationModel", "recommendation");
        $this->load->model("Audit/ActionPlansModel", "action_plans");
        $this->load->model("Audit/AuditAreaModel", "auditArea");
        $this->load->model("Audit/AuditCommentModel", "auditComment");


        $this->risk_levels = array(
            'breach' => "Compliance Breach",
            'Risk Category' => " Incident is related to a risk category",
            'Materialized Risk' => "A specific risk materialized",
            'Undefined Risk' => "Risk is not defined in the system"
        );

        $this->load->model("ActivityTrail/ActivityTrailModel", "activityTrail");
    }

    /**


     * 
     * @param type $filepath
     * @return type    / 
     */
    function e404Hundler($filepath) {
        if (!file_exists("application/views/" . $filepath . ".php")) {
            $filename = "application/views/" . $filepath . ".php";
            /* echo "Error : File ('$filename') does not exist"; */ return false; // old code file put content removed
        } else {
            return true;
        }
    }

    function page($pageName = "", $pageData = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "IncidentManagement/Pages/" . ucwords($pageName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/Compliance");
        }
        $data['message'] = ($this->input->get("message")) ? "<div style='padding:7px'>" . ucwords($this->input->get("message")) . "</div>" : NULL;
        $data['KRAs'] = count($this->repository->getPending());
        $data['risks'] = count($this->risk->getInactive());
        $data['controls'] = count($this->control->getUnapprovedControls());
        $data['control_activity'] = count($this->activity->getInactive());
        $data['obligations'] = count($this->obligation->getInactive());
        $data['breaches'] = count($this->breach->getInactive());
        $data['complies'] = count($this->comply->getInactive());
        $data['incidents'] = count($this->incident->getInactive());
        $data['page_title'] = $this->page_title;
        $data['me'] = $this->user->getMe();
        $data['data'] = $pageData;
        $data['me'] = $this->user->getMe();
        $data['stylesheets'] = $stylesheets;
        $data['scripts'] = $scripts;
        $this->load->view("Includes/HeadView", $data);
        $this->load->view("Includes/MainNavView", $data);
        $this->load->view("IncidentManagement/Includes/IncidentManagementHeaderView");
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
        $this->load->view("Includes/FooterView");
    }

    function form($formName = "", $data = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "IncidentManagement/Forms/" . ucwords($formName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/Compliance");
        }
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
        $data['data'] = $data;
        $data['scripts'] = $scripts;
        $data['stylesheets'] = $stylesheets;
        $this->load->view("Includes/HeadView", $data);
        $this->load->view("Includes/MainNavView", $data);
        $this->load->view("IncidentManagement/Includes/IncidentManagementHeaderView", $data);
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
        $this->load->view("Includes/FooterView");
    }

    function modal($modalName = "", $pageData = array(), $scripts = array(), $stylesheets = array()) {
//        if ($this->input->post("requestView") != "modal") {
//            redirect("IncidentManagement/index/");
//        }
        $filename = "IncidentManagement/Modals/" . ucwords($modalName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/Compliance");
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
        $filename = "IncidentManagement/Ajax/" . ucwords($fileName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/Compliance");
        }
        $data['data'] = $data;
        $data['scripts'] = $scripts;
        $data['stylesheets'] = $stylesheets;
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
    }

    function notificationPopup($fileName = "", $data = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "IncidentManagement/NotificationsPopup/$pageName";
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/Compliance");
        }
        $data['data'] = $pageData;
        $data['me'] = $this->user->getMe();
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
    }

    function actions() { // only to aid ui developement
        $this->page("ActionsView");
    }

    /* START DASHBOARDS */

    function index() {
        $data['incident_categories'] = $this->incidentCategory->getAll();
        $data['incidents'] = $this->incident->getIncidents();
        $data['incident_risks'] = $this->incident->getAllIncidentsRisks();
        $data['max_total_cost'] = $this->incident->getMaxTotalCost();
        $this->page_title = "Dashboard";
        $this->page("ReportView", $data);
    }

    function incidentReport() {
        redirect("IncidentManagement");
    }

    function incidentApprove($id = 0, $approval = false) {
        $options = array("approved", "rejected");
        if (in_array($approval, $options)) {
            $data['approved'] = $approval;
            $data['id'] = $id;
            $this->incident->edit($data);
            $im = $this->incident->get($id);
            $dataArray['id'] = $im['risk'];
            $dataArray['evaluate'] = "yes";
            $this->risk->edit($dataArray);

            $this->notification->incident_approval($data['id']);
        }
        redirect("IncidentManagement/incident/{$data['id']}?message=The Incident has been " . ucwords($approval));
    }

    function incidentForm($id = 0) {
        $me = $this->user->getMe();
        if ($id == 0) {
            $data['draft'] = $me['user']['id'];
            $new = $this->incident->add($data);
            redirect("/IncidentManagement/incidentForm/{$new['id']}");
        }
        $data['incidents'] = $this->incident->get($id);
        $data['users'] = $this->user->getUnitOwners();
        $data['risks'] = $this->risk->getAll();
        $data['risk_category'] = $this->riskCategory->getAll();
        $data['incident_categories'] = $this->incidentCategory->getAll();

        $data['categories'] = $this->riskCategory->getChildLevels(0);
        $data['all_categories'] = $this->riskCategory->getAll();

        $data['environments'] = $this->environment->getEnvironments();
        $data['risk_levels'] = $this->risk_levels;

        $data['owners'] = $this->user->getUnitOwners();

        $unsorted = $data['environments'];
        $sorted = [];
        foreach ($unsorted as $key => $env) {
            if (!isset($sorted[$env['environment_level']['name']])) {
                $sorted[$env['environment_level']['name']] = [];
            }
            $sorted[$env['environment_level']['name']][] = $env;
        }
        $data['environments'] = [];
        $data['environments'] = $sorted;
        $this->page("IncidentFormView", $data, array("jquery.filer.min"));
    }

    function incidentPreview() {
        $data = $this->incident->get($id);
        $this->modal("PreviewIncidentView", $data);
    }

    function incident($id = 0) {
        if ($id == 0) {
            redirect("IncidentManagement/?message={$this->input->get("message")}");
        }

        $data['incident'] = $this->incident->get($id);
        if (count($data['incident']) == 0) {
            redirect("IncidentManagement/?message=The incident does not exist");
        }

        $data['incident']['state'] = $this->incidentActions->getIncidentState($id);
        $data['incident_state'] = $data['incident']['state'];
        $data['unit'] = $this->environment->get($data['incident']['environment']);
        $data['responsible_manager'] = $this->user->getUser($data['incident']['responsible_manager']);
        $data['risk_category'] = $this->riskCategory->get($data['incident']['risk_category']);
        $data['category'] = $this->incidentCategory->get($data['incident']['category']);

        $data['risk'] = $this->risk->get($data['incident']['risk']);
        $this->page_title = $data['incident']['title'];
        $data['actions'] = $this->incidentActions->getIncidentActions($id);
        $this->page("IncidentDetailsView", $data);
    }

    function incidentDetail($id) {
        redirect("IncidentManagement/incident/$id");
    }

    function incidentDelete($id = 0, $confirmed = false) {
        if ($confirmed === false) {
            $data['incident'] = $this->incident->get($id);
            $this->modal("confrimDeleteIncidentView", $data);
        } else {
            $_record = $this->incident->get($id);
            $this->activityTrail->add(array(
                "module" => "incident_Management",
                "table" => $this->incident->table,
                "record" => $_record['id'],
                "title" => "Incident  Deleted",
                "message" => "An Incident <strong>{$data['title']}</strong> has been Deleted",
            ));

            $this->incident->delete($id);
            redirect("IncidentManagement/incident?message=The Incident has been Deleted");
        }
    }

    function incidentFilter() {


        $results = [];
        $filters = $this->input->post();

        $start_date = $filters['start_date'];
        $end_date = $filters['end_date'];

        $filter_date = $filters['filter_date'];

        $incident = $this->incident->incidentDataByDate($filter_date, $start_date, $end_date);
        foreach ($incident as $key => $value) {
            $flag = true;

            if (isset($filters['status'])) {
                if (in_array($value['status'], $filters['status'])) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            if (isset($filters['state'])) {
                if (in_array($value['incident'], $filters['state'])) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            if (isset($filters['category'])) {
                if (in_array($value['category']['id'], $filters['category'])) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            if (isset($filters['risk_category'])) {
                if (in_array($value['risk_category'], $filters['risk_category'])) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            if (isset($filters['risk'])) {
                if (in_array($value['risk']['id'], $filters['risk'])) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }

            if (isset($filters['total_cost'])) {
//                if (($value['total_cost'] <= $filters['total_cost'])) {
//                    $flag = true;
//                } else {
//                    $flag = false;
//                }
            }

            if ($value['approved'] != 'approved') {
                continue;
            }
            if ($flag) {
                $results[] = $value;
            }
        }
//        print_pre(count($results));
//        print_pre($filters);
        $data['active_tab'] = $filters['active_tab'];
        $data['incidents'] = $results;
        $this->ajax("incidentRepost", $data);
    }

    function incidentPost() {
        $data = $this->input->post();
        if (isset($data['id'])) {
            $_record = $this->incident->get($data['id']);
            
            if ($_record['draft'] != 0) {
                $this->activityTrail->add(array(
                    "module" => "incident_Management",
                    "table" => $this->incident->table,
                    "record" => $_record['id'],
                    "title" => "New Incident",
                    "message" => "A new Incident has been created <strong>{$data['title']}</strong>",
                    "link" => "IncidentManagement/incident/{$_record['id']}"
                ));
                // edit Message 
            } else {
                $this->activityTrail->add(array(
                    "module" => "incident_Management",
                    "table" => $this->incident->table,
                    "record" => $_record['id'],
                    "title" => "Incident Edited",
                    "message" => "Incident <strong>{$data['title']}</strong> has been edited",
                    "link" => "IncidentManagement/incident/{$_record['id']}"
                ));
                // add message
            }
        }

        $this->incident->edit($data);
        if ($_record['draft'] != 0) {
           // exit;
            
            am_user_type(array(5)) ? $this->notification->incident_approval($_record['id']) : $this->notification->incident_create($_record['id']);
        }
        redirect("IncidentManagement/incident/{$data['id']}?message=changes saved");
    }

    function incidentDraft() {
        $data = $this->input->post();
        $this->incident->draft($data);
        //print_pre($data);
    }

    function postIncident() {
        $this->incidentPost();
    }

    // actions
    function action($id = 0) {
        $data['action'] = $this->incidentActions->get($id);
        $this->modal("PreviewActionView", $data);
    }

    function actionForm($id = 0, $incident = 0) {
        if ($id == 0) {
            $data['incident'] = $incident;
            $data['draft'] = $this->user->getMyId();
            $new = $this->incidentActions->add($data);
            redirect("IncidentManagement/actionForm/{$new['id']}");
        }
        $data['action'] = $this->incidentActions->get($id);
        $this->modal("Form_incident_action", $data);
    }

    function actionDelete($id = 0, $confirmed = false) {
        $_record = $this->incidentActions->get($id);
        if ($confirmed === false) {
            $data['action'] = $this->incidentActions->get($id);
            $this->modal("ActionDeleteModal", $data);
        } else {

            $this->activityTrail->add(array(
                "module" => "incident_Management",
                "table" => $this->incidentActions->table,
                "record" => $_record['id'],
                "title" => "Incident Action Deleted",
                "message" => "An Incident Action <strong>{$_record['title']}</strong> has been Deleted",
                "link" => "IncidentManagement/incident/{$_record['id']}"
            ));

            $this->incidentActions->delete($id);
            $url = "IncidentManagement/incident/{$_record['incident']}?message=Action Deleted";
            redirect($url);
        }
    }

    function actionPost() {
        $data = $this->input->post();
        if (isset($data['id'])) {
            $_record = $this->incidentActions->get($data['id']);
            if ($_record['draft'] != 0) {
                $this->activityTrail->add(array(
                    "module" => "incident_Management",
                    "table" => $this->incidentActions->table,
                    "record" => $_record['id'],
                    "title" => "New Incident Action",
                    "message" => "A new Incident Action has been created <strong>{$data['title']}</strong>",
                    "link" => "IncidentManagement/incident/{$_record['id']}"
                ));
                // edit Message 
            } else {
                $this->activityTrail->add(array(
                    "module" => "incident_Management",
                    "table" => $this->incidentActions->table,
                    "record" => $_record['id'],
                    "title" => "Incident Action Edited",
                    "message" => "Incident Action  <strong>{$data['title']}</strong> has been edited",
                    "link" => "IncidentManagement/incident/{$_record['id']}"
                ));
                // add message
            }
        }

        $this->incidentActions->edit($data);
        redirect("IncidentManagement/incident/" . $data['incident'] . "?message=changes saved");
    }

    function actionPreview($id) {
        
    }

    function incidentActionStatusUpdate($id, $status) {
        $_record = $this->incidentActions->get();
        $options = array('complete', 'incomplete');
        if (in_array($status, $options)) {
            $data['id'] = $id;
            $data['status'] = $status;
            $this->incidentActions->edit($data);

            $this->activityTrail->add(array(
                "module" => "incident_Management",
                "table" => $this->incidentActions->table,
                "record" => $_record['id'],
                "title" => "Incident Action Status Updated",
                "message" => "Incident Action Status <strong>{$record['title']}</strong> has been Updataed",
                "link" => "IncidentManagement/incident/{$_record['id']}"
            ));
        }

        redirect("IncidentManagement/incident/{$_record['id']}");
    }

    function incidentsActions() {
        $data['actions'] = $this->incidentActions->getAll();
        $this->page_title = "Incidents Actions";
        $this->page("IncidentsActions", $data);
    }

    // category 

    function incidentCateogoryForm($id = 0) {
        if ($id == 0) {
            $data['incident_category'] = $this->incidentCategory->fields;
            foreach ($data['incident_category'] as $key => $value) {
                $data['incident_category'][$key] = NULL;
            }
        } else {
            $data['incident_category'] = $this->incidentCategory->get($id);
        }
        $data['incident_categories'] = $this->incidentCategory->getAll();
        $this->modal("IncidentCategoryForm", $data);
    }

//    function incidentCategoryDelete($id = 0, $confirmed = false) {
//        if ($confirmed) {
//            $this->incidentCategory->delete($id);
//            redirect("IncidentManagement/incidentCateogoryForm?message=Incident Category Deleted");
//        } else {
//            $data['incident_category'] = $this->incidentCategory->get($id);
//            $this->modal("IncidentCategoryDelete", $data);
//        }
//    }

    function incidentCategoryDelete($id = 0, $confirmed = false) {
        if ($confirmed === false) {
            $data['incident_category'] = $this->incidentCategory->get($id);
            $this->modal("IncidentCategoryDelete", $data);
        } else {
            $_record = $this->incidentCategory->get($id);
            $this->activityTrail->add(array(
                "module" => "incident_Management",
                "table" => $this->incidentCategory->table,
                "record" => $_record['id'],
                "title" => "Incident Category Deleted",
                "message" => "An Incident Category <strong>{$_record['title']}</strong> has been Deleted",
            ));

            $this->incidentCategory->delete($id);
            redirect("IncidentManagement/incidentCateogoryForm?message=Incident Category Deleted");
        }
    }

    function incidentCategoryPost() {
        $data = $this->input->post();
        if ($data['id']) {
            $this->incidentCategory->edit($data);
            $_record = $this->incidentCategory->get($data['id']);
            $this->activityTrail->add(array(
                "module" => "incident_Management",
                "table" => $this->incidentCategory->table,
                "record" => $_record['id'],
                "title" => "New Incident Category",
                "message" => "A new Incident Category has been created <strong>{$data['title']}</strong>",
                "link" => "IncidentManagement/incidentCateogoryForm"
            ));
        } else {
            $_record = $this->incidentCategory->add($data);
            $this->activityTrail->add(array(
                "module" => "incident_Management",
                "table" => $this->incidentCategory->table,
                "record" => $_record['id'],
                "title" => "Incident Category Edited",
                "message" => "Incident Category <strong>{$data['title']}</strong> has been edited",
                "link" => "IncidentManagement/incidentCateogoryForm"
            ));
        }
        redirect("IncidentManagement/incidentCateogoryForm?message=changes saved");
    }

    // old redirects 

    function report() { // OPEN PAGE
        redirect("IncidentManagement");
    }

}
