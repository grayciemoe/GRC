<?php

class Compliance extends CI_Controller {

    public $sources, $frequency_periods, $page_title;

    function __construct() {
        parent::__construct();

        $this->load->model("Documents/UploadModel", "uploadModel");
        $this->load->model("Documents/DocumentsModel", "documentsModel");
        $this->load->model("Documents/CropModel", "cropModel");

        $this->load->model("Users/UserModel", "user");
        $this->load->model("Users/AuthModel", "auth");
        $this->load->model("Users/UserTypeModel", "userType");


        if (!$this->auth->checkLogin()) {
            redirect("Login/?message=Please login to proceed");
        }

        $this->load->model("Notification/NotificationModel", "notification");

        $this->load->model("Risk/RiskModel", "risk");
        $this->load->model("Risk/CategoryModel", "category");
        $this->load->model("Risk/AnalysisModel", "analysis");
        $this->load->model("Risk/EvaluationModel", "evaluation");
        $this->load->model("Risk/ControlCategoryModel", "controlCategory");
        $this->load->model("Risk/ControlModel", "control");
        $this->load->model("Risk/ControlActivityModel", "activity");

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



        $this->page_title = NULL;
        $sources = array('best_practices', 'strategic_objectives', 'process', 'laws_and_regulations', 'corporate_policy', 'contract');
        foreach ($sources as $key => $value) {
            $this->sources[$value] = ucwords(str_replace("_", " ", $value));
        }
        $start = strftime("%Y", time());
        $stop = 2000;
        $years = [];
        for ($i = $start; $i > $stop; $i--) {
            $years[] = $i;
        }
        $this->frequency_periods = array(
            'annually' => $years,
            'semi annually' => array(1, 2),
            'quarterly' => array(1, 2, 3, 4),
            'monthly' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
            'weekly' => [],
            'daily' => []
        );
        $this->load->model("Compliance/ComplianceRequirementModel", "compliance");
        $this->load->model("Compliance/ComplianceRegisterModel", "complianceRegister");
        $this->load->model("Compliance/ObligationComplyModel", "comply");
        $this->load->model("Compliance/BreachModel", "breach");
        $this->load->model("Compliance/ObligationModel", "obligation");
        $this->load->model("Bridge/BridgeModel", "bridge");
        $this->load->model("Compliance/ComplianceDependentModel", "complianceDependent");

        $this->load->model("DataIndexModel", "dataIndex");
        $this->seekBreach();
    }

    function e404Hundler($filepath) {
        if (!file_exists("application/views/" . $filepath . ".php")) {
            $filename = "application/views/" . $filepath . ".php";
            /* echo "Error : File ('$filename') does not exist"; */ return false;
        } else {
            return true;
        }
    }

    function seekBreach() {
        $this->obligation->seekBreaches();
    }

    function page($pageName = "", $pageData = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "Compliance/Pages/" . ucwords($pageName);
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
        $data['title'] = $this->page_title;
        $data['page_title'] = $this->page_title;
        $data['repository_sources'] = $this->sources;
        $data['data'] = $pageData;
        $data['me'] = $this->user->getMe();
        $data['stylesheets'] = $stylesheets;
        $data['scripts'] = $scripts;
        $data['periods'] = $this->frequency_periods;
        $this->load->view("Includes/HeadView", $data);
        $this->load->view("Includes/MainNavView", $data);
        $this->load->view("Compliance/Includes/ComplianceHeaderView");
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
        $this->load->view("Includes/FooterView");
    }

    function form($formName = "", $data = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "Compliance/Forms/" . ucwords($formName);
        if ($this->e404Hundler($filename)) {
//redirect("index.php/Compliance");
        }
        $data['KRAs'] = count($this->repository->getPending());
        $data['risks'] = count($this->risk->getInactive());
        $data['controls'] = count($this->control->getUnapprovedControls());
        $data['control_activity'] = count($this->activity->getInactive());
        $data['obligations'] = count($this->obligation->getInactive());
        $data['breaches'] = count($this->breach->getInactive());
        $data['complies'] = count($this->comply->getInactive());
        $data['incidents'] = count($this->incident->getInactive());
        $data['page_title'] = $this->page_title;
        $data['data'] = $data;
        $data['scripts'] = $scripts;
        $data['stylesheets'] = $stylesheets;
        $this->load->view("Includes/HeadView", $data);
        $this->load->view("Includes/MainNavView", $data);
        $this->load->view("Compliance/Includes/ComplianceHeaderView");
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
        $this->load->view("Includes/FooterView");
    }

    function modal($modalName = "", $pageData = array(), $scripts = array(), $stylesheets = array()) {
        //print_pre($this->input->post());
//        if ($this->input->post("requestView") != "modal") {
//            redirect("Compliance/index/");
//      
        $filename = "Compliance/Modals/" . ucwords($modalName);
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
        $filename = "Compliance/Ajax/" . ucwords($fileName);
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
        $filename = "Compliance/NotificationsPopup/$pageName";
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

    function index() {
        $this->page_title = "Dashboard";
        $compliance_index = $this->dataIndex->getCompliance();

        $data = objectToArray(json_decode($compliance_index['data']));
        $data['obligations'] = $this->obligation->getUpcoming();

        foreach ($data['obligations'] as $key => $value) {
            $data['obligations'][$key]['compliance'] = $this->complianceRequirement->get($value['compliance_requirement']);
        }
        $this->page("DashboardView", $data, array("jquery-ui.min", "jquery.dataTables.min", "dataTables.bootstrap4.min", "dataTables.buttons.min", "buttons.bootstrap4.min", "jszip.min", "pdfmake.min", "vfs_fonts", "buttons.html5.min", "buttons.print.min", "buttons.colVis.min", "dataTables.responsive.min", "responsive.bootstrap4.min", "moment", "fullcalendar.min"), array());
    }

    function actions() { // only to aid ui developement
        $this->page("ActionsView");
    }

// START DASHBOARDS */

    function statutory() { // OPEN PAGE
        $data['type'] = "Statutory Returns";
        $this->page_title = $data['type'];
        $data['obligations'] = $this->compliance->getTypeObligations("Statutory Returns");
        $data['compliance_requirements'] = $this->compliance->getTypeComplianceRequirements("Statutory Returns");
        $data['registers'] = $this->complianceRegister->getAll();

//$data[];
        $this->page("StatutoryView", $data);
    }

    function legal() {// OPEN PAGE
        $data['type'] = "Legal / Regulatory Requirements";
        $this->page_title = $data['type'];
        $data['obligations'] = $this->compliance->getTypeObligations($data['type']);
        $data['compliance_requirements'] = $this->compliance->getTypeComplianceRequirements("Legal / Regulatory Requirements");
        $data['registers'] = $this->complianceRegister->getAll();

        $this->page("LegalView", $data, array("chart.min", "moment", "bootstrap-timepicker.min", "bootstrap-datepicker.min", "daterangepicker", "jquery.dataTables.min", "dataTables.bootstrap4.min", "dataTables.buttons.min", "buttons.bootstrap4.min", "jszip.min", "pdfmake.min", "vfs_fonts", "buttons.html5.min", "buttons.print.min", "buttons.colVis.min", "dataTables.responsive.min", "responsive.bootstrap4.min"), array());
    }

    function business() {// OPEN PAGE
        $data['type'] = "Business Compliance Requirements";
        $this->page_title = $data['type'];
        $data['obligations'] = $this->compliance->getTypeObligations("Business Compliance Requirements");
        $data['compliance_requirements'] = $this->compliance->getTypeComplianceRequirements("Business Compliance Requirements");
        $data['registers'] = $this->complianceRegister->getAll();
        $this->page("BusinessView", $data, array("chart.min", "moment", "bootstrap-timepicker.min", "bootstrap-datepicker.min",
            "daterangepicker", "jquery.dataTables.min", "dataTables.bootstrap4.min", "dataTables.buttons.min", "buttons.bootstrap4.min", "jszip.min", "pdfmake.min", "vfs_fonts", "buttons.html5.min", "buttons.print.min", "buttons.colVis.min", "dataTables.responsive.min", "responsive.bootstrap4.min"), array());
    }

    function report() {// OPEN PAGE
        $this->page_title = "Report";
        $data['obligations'] = $this->compliance->getTypeObligations("Statutory Returns");
        $data['compliance_requirements'] = $this->compliance->getAll();
        $data['registers'] = $this->complianceRegister->getAll();
        $data['authority'] = $this->authority->getAll();
        $data['environments'] = $this->environment->getSortedEnvironments();
        $data['units'] = $data['environments'];
        foreach ($data['obligations'] as $key => $value) {
            $data['test'] = $this->compliance->getTypeOblComplianceRequirements($value['id']);
        }


        $this->page("ReportView", $data, array("chart.min", "moment", "bootstrap-timepicker.min", "bootstrap-datepicker.min",
            "daterangepicker", "jquery.dataTables.min", "dataTables.bootstrap4.min", "dataTables.buttons.min", "buttons.bootstrap4.min", "jszip.min", "pdfmake.min", "vfs_fonts", "buttons.html5.min", "buttons.print.min", "buttons.colVis.min", "dataTables.responsive.min", "responsive.bootstrap4.min"), array());
    }

    function information() {// OPEN PAGE
        $this->page_title = "Compliance Report";
        $this->page("InformationView", array(), array("jquery-ui.min"), array());
    }

    function obligations_filter() {
        $filters = $this->input->post();

        if ($filters['start'] and $filters['end'] and ( strtotime($filters['start']) < strtotime($filters['end']))) {
            $obligation = $this->compliance->getTypeDateObligations($filters['compliance_requirement_type'], $filters['start'], $filters['end']);
        } else {
            $obligation = $this->compliance->getTypeObligations($filters['compliance_requirement_type']);
        }

        $data['cr_title'] = ($filters['compliance_requirement_type'] == 'Statutory Returns') ? "Submission Deadline" : "Next Review";
        $results = [];
        $flag = true;

        foreach ($obligation as $key => $value) {
            //print_pre($filters);
            $flag = true;
            if (isset($filters['register']) and $filters['register'] != 0) {
                if (in_array($filters['register'], $value['registers'])) { // prev condition 
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            if (isset($filters['compliance_requirements']) and $filters['compliance_requirements'] != 0 and $flag) {
                if ($value['compliance_requirement']['id'] == $filters['compliance_requirements']) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            if (isset($filters['frequency']) and $filters['frequency'] != null and $flag) {
                if ($value['frequency'] == $filters['frequency']) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            if ($flag) {
                $results[] = $value;
            }
        }

// echo count($results);
//echo "\n\n\n";
//        print_pre($obligation);

        $data['obligations'] = $results;

        $this->ajax("obligations_filters", $data);
// print_pre($filters);
    }

    function report_filter() {
        $filters = $this->input->post();
        $obligation = $this->obligation->getAllObligations();
        $breach = $this->breach->getAll();
        $results = [];
        $flag = true;
        foreach ($obligation as $key => $value) {
            $flag = true;


            if (isset($filters['compliance_requirement_type']) and count($filters['compliance_requirement_type']) > 0 and $flag) {
                if (in_array($value['compliance_requirement']['type'], $filters['compliance_requirement_type'])) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }if (isset($filters['compliance_register']) and count($filters['compliance_register']) != 0 and $flag) {
                if (in_array($value['register']['id'], $filters['compliance_register'])) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            if (isset($filters['compliance_requirement']) and count($filters['compliance_requirement']) != 0 and $flag) {
                if (in_array($value['compliance_requirement']['id'], $filters['compliance_requirement'])) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            if (isset($filters['frequency']) and count($filters['frequency']) != 0 and $flag) { //echo $value['frequency'] ."<br>";
                if (in_array($value['frequency'], $filters['frequency'])) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            if (isset($filters['authority']) and count($filters['authority']) != 0 and $flag) { //echo $value['frequency'] ."<br>";
                if (in_array($value['authority']['id'], $filters['authority'])) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            if ($flag) {
                $results[] = $value;
            }
        }
        $data['obligations'] = $results;
        $pages = array("obligationChart", "obligatonsTableReportView");
        $page = in_array($filters['active_view'], $pages) ? $filters['active_view'] : "obligationChart";
        $this->ajax($page, $data);
    }

    // -- END DASHBOARDS */
    //  -- START REGISTERS */

    function registers($register = 0) {
        $this->register($register);
    }

    function registerForm($id = 0) { // OPEN FORM OR PAGE
        if ($id == 0) {
            $data['draft'] = $this->user->getMyId();
            $data['user'] = $data['draft'];
            $data['owner'] = $data['draft'];
            $new = $this->complianceRegister->add($data);
            redirect("Compliance/registerForm/{$new['id']}");
        }
        $data['register'] = $this->complianceRegister->get($id);
        $data['owners'] = $this->user->getRiskManagers();

        $this->modal("RegisterFormView", $data);
    }

    function registerPost() { // FORM ACTION
        $data = $this->input->post();

        if (isset($data['id'])) {
            $_record = $this->complianceRegister->get($data['id']);
            if ($_record['draft'] != 0) {
                $this->activityTrail->add(array(
                    "module" => "compliance",
                    "table" => $this->complianceRegister->table,
                    "record" => $_record['id'],
                    "title" => "New Compliance Register",
                    "message" => "A new Compliance Register <strong>{$data['title']}</strong> has been created",
                    "link" => "Compliance/register/{$_record['id']}"
                ));
                // edit Message 
            } else {
                $this->activityTrail->add(array(
                    "module" => "compliance",
                    "table" => $this->complianceRegister->table,
                    "record" => $_record['id'],
                    "title" => "Compliance Register Edited",
                    "message" => "A Compliance Register <strong>{$_record['title']}</strong> has been edited",
                    "link" => "Compliance/register/{$_record['id']}"
                ));
                // add message
            }
        }
        $this->complianceRegister->edit($data);

        redirect("Compliance/register/{$data['id']}?message=changes saved");
    }

    function registerDraft() {
        $data = $this->input->post();
        $this->compliance->draft($data);
    }

    function register($register = 0) {

        $data['registers'] = $this->complianceRegister->getAll();
        $data['register'] = $this->complianceRegister->get($register);

        if (count($data['registers']) > 0 and count($data['register']) == 0) {
            $data['register'] = $data['registers'][0];
            $this->page_title = "Compliance Registers | {$data['register']['title']}";
        } else {
            $this->page_title = "Compliance Registers | {$data['register']['title']}";
        }
        $data['compliance_requirements'] = $this->bridge->getRegisterCompliance_requirements($data['register']['id']);
        $this->page("registersView", $data);
    }

    function registerSelectCompliance($register = 0) {
        $data['compliance_requirements'] = $this->compliance->getAll();
        $data['register_compliance_requirements'] = $this->bridge->getRegisterCompliance_requirements($register);
        $data['register'] = $this->complianceRegister->get($register);
        $data['list'] = [];
        foreach ($data['register_compliance_requirements'] as $value) {
            $data['list'][] = $value['id'];
        }
        $this->modal("selectRegisterCompliances", $data);
//print_pre($data);
    }

    function setRegisterCompliances() {
        $data = $this->input->post();
        $this->bridge->addCompliance_requirementsToRegister($data);
        redirect("Compliance/register/{$data['compliance_register']}?message=changes saved");
// print_pre($data);
    }

    function registerDelete($id = 0, $confirmed = false) { // CONFRIM DELETE POPUP / MODAL
        if (!$confirmed) {
            $data['register'] = $this->complianceRegister->get($id);
            $this->modal("deleteRegisterModal", $data);
        } else {
            $_record = $this->complianceRegister->get($id);
            $this->activityTrail->add(array(
                "module" => "compliance",
                "table" => $this->complianceRegister->table,
                "record" => $_record['id'],
                "title" => "Compliance Register Deleted",
                "message" => "A Compliance Register <strong>{$_record['title']}</strong> has been deleted"
            ));
            $this->complianceRegister->delete($id);
            redirect("Compliance/register?message=changes saved");
        }
    }

    function approveRegister($id = 0) { // APPROVE POPUP / MODAL
        $this->registerApprove($id);
    }

    function registerApprove($id = 0) { // APPROVE POPUP / MODAL
        $this->modal("approveRegisterModal");
    }

    // -- END REGISTERS */
    // -- END COMPLIANCE REQUIREMENTS */

    function complianceRequirement($id = 0) {// PAGE
        $cr = $this->compliance->getComplianceRequirement($id);

        if ($id !== 0 and $cr) {
            $data['compliance_requirement'] = $cr;
            $this->page_title = $cr['title'];
            $data['obligations'] = $this->obligation->getComplianceRequirements($cr['id']);
            $this->page("ComplianceRequirementView", $data);
        } else {
            $this->page_title = "Compliance Requirements";
            $data['compliance_requirements'] = $this->compliance->getAll();
            $this->page("ComplianceRequirementsView", $data);
        }
    }

    function complianceObligationsList($cr) {
        $data['compliance_requirement'] = $this->compliance->get($cr);
        $data['obligations'] = $this->obligation->getComplianceRequirements($cr);
        $this->modal("ComplianceObligationsListModal", $data);
    }

    function complianceRequirementForm($id = 0, $type = false, $register = 0) {// PAGE OR FORM
        if ($id == 0) {
            $type = urldecode($type);
            $me = $this->user->getMe();
            if (!$type) {
                $type = "Statutory Returns";
            } else {
                $type = urldecode($type);
            }
            $data['type'] = $type;
            $data['register'] = $register;
            $data['status'] = "active";
            $data['draft'] = $me['user']['id'];
            $data['user'] = $me['user']['id'];
            $data['owner'] = $me['user']['id'];

            $new = $this->compliance->add($data);
            redirect("compliance/complianceRequirementForm/{$new['id']}");
        }
        $data['compliance_requirement'] = $this->compliance->get($id);
        $data['owners'] = $this->user->getComplianceOwners();

        $data['staff_members'] = $this->user->getStaff();
        $data['unit_owners'] = $this->user->getUnitOwners();
        $data['risk_managers'] = $this->user->getRiskManagers();


        $data['environments_unsorted'] = $this->environment->getEnvironments();
        $data['repository_unsorted'] = $this->repository->getAll();
        $data['registers'] = $this->complianceRegister->getAll();

        foreach ($data['repository_unsorted'] as $key => $value) {
            if (!isset($data['repository'][$value['source']])) {
                $data['repository'][$value['source']] = [];
            }
            $data['repository'][$value['source']][] = $value;
        }


        foreach ($data['environments_unsorted'] as $key => $env) {
            if (!isset($data['environments'][$env['environment_level']['name']])) {
                $data['environments'][$env['environment_level']['name']] = [];
            }
            $data['environments'][$env['environment_level']['name']][] = $env;
        }

        $this->modal("Form_compliance_requirement_View", $data);
    }

    function displayUnitSourceRepositoryOptions($unit) {
        $repo = $this->environment->repository($unit);
    }

    function ComplianceRequirementChart($compliance_requirement_id) {
        $data['compliance_requirement'] = $this->compliance->getComplianceRequirement($compliance_requirement_id);
        $this->modal("ComplianceRequirementChartModal", $data);
    }

    function unitRepositoryOptions($unti_id, $compliance_requirement = 0, $repo) {
        $repository = $this->repository->getEnvironment($unti_id);
        $html = NULL;
        foreach ($repository as $key => $value) {
            $select = $value['id'] == $repo ? "selected='selected'" : NULL;
            $html .= "<option value = ' {$value['id']}' $select > {$value['name']} </option>";
        }


        echo $html ? $html : "<option value=''>Nothing Found</option>";
    }

    function postComplianceRequirement($ajaxResponse = false) { // FORM FORM ACTION
        $data = $this->input->post();

        if (isset($data['id'])) {
            $_record = $this->compliance->get($data['id']);
            if ($_record['draft'] != 0) {
                $this->activityTrail->add(array(
                    "module" => "compliance",
                    "table" => $this->compliance->table,
                    "record" => $_record['id'],
                    "title" => "New Compliance Requirement",
                    "message" => "A new Compliance Requirement <strong>{$data['title']}</strong> has been created",
                    "link" => "Compliance/complianceRequirement/{$_record['id']}"
                ));
                // edit Message 
            } else {
                $this->activityTrail->add(array(
                    "module" => "compliance",
                    "table" => $this->compliance->table,
                    "record" => $_record['id'],
                    "title" => "Compliance Requirement Edited",
                    "message" => "A Compliance Requirement <strong>{$_record['title']}</strong> has been edited",
                    "link" => "Compliance/complianceRequirement/{$_record['id']}"
                ));
                // add message
            }
        }

        $this->compliance->edit($data);
        redirect("Compliance/complianceRequirement/{$data['id']}?message=changes saved");
    }

    function complianceRequirementDraft() {
        $data = $this->input->post();
        $this->compliance->draft($data);
    }

    function approveComplianceRequirement($id = 0) { // APPROVE POPUP / MODAL
        $this->modal("approveComplianceRequirementModal");
    }

    function deleteComplianceRequirement($id = 0, $confirmed = false) {// MODAL
        $data['compliance_requirement'] = $this->compliance->get($id);
        $data['obligations'] = $this->obligation->getComplianceRequirements($id);
        if (!$confirmed) {
            $this->modal("deleteComplainceRequirementModal", $data);
        } else {
            $_record = $this->compliance->get($id);
            $this->activityTrail->add(array(
                "module" => "compliance",
                "table" => $this->compliance->table,
                "record" => $id,
                "title" => "Compliance Requirement Deleted",
                "message" => "A Compliance Requirement <strong>{$_record['title']}</strong> has been deleted"
            ));
            if ($data['compliance_requirement']['draft'] == 0) {
                $message = "Compliance Requirement Deleted Successfully";
            } else {
                $message = "Compliance Requirement Draft Deleted Successfully";
            }

            $this->compliance->delete($id);
            redirect("Compliance/complianceRequirement/?message=$message");
        }
    }

    // -- END COMPLIANCE REQUIREMENTS */
    // -- START OBLIGATION */

    function obligation($id = 0) { // PAGE
        $data = $this->obligation->getObligation($id);
        if (!$data) {
            redirect("Compliance/?message=Obligation does not exist");
        }
        $this->page_title .= "<a href='" . base_url("index.php/Compliance/complianceRequirement/{$data['compliance_requirement']['id']}") . "'> {$data['compliance_requirement']['title']} </a> | {$data['obligation']['title']}";
        $this->page("ObligationDetailsView", $data);
    }

    function obligationPreview($obligation_id) {
        $data['obligations'] = $this->obligation->getPreviewObligation($obligation_id);
        $this->modal("obligationPreviewView", $data);
    }

    function obligationAction($id) {
        $data['obligation'] = $this->obligation->get($id);
        $data['authority'] = $this->authority->get($id);
        $data['compliance_requirement'] = $this->complianceRequirement->get($id);

        $this->modal("ObligationActionModal", $data);
    }

    function findComplianceRequirementType($id) {
        $compliance_requirement = $this->complianceRequirement->get($id);
        echo $compliance_requirement['type'] == 'Statutory Returns' ? "Submission Deadline" : "Next Review";
    }

    function obligationForm($id = 0, $compliance_requirement = 0, $authority = 0) { // FORM PAGE
        $data['obligation'] = $this->obligation->get($id);
        $data['compliance_requirements'] = $this->compliance->getAll();
        $data['authorities'] = $this->authority->getAll();
        $data['risk_managers'] = $this->user->getRiskManagers();
        $data['staff'] = $this->user->getStaff();
        //$data['responsible_managers'] = $this->userType->getObligationManager();
        $data['escalation'] = $this->userType->getEscalation();
        if ($compliance_requirement != 0) {
            $data['comp_req'] = $this->compliance->get($compliance_requirement);
        }
//print_pre($data['escalation']);
        $me = $this->user->getMe();
        if (!$data['obligation']) {
            $data['compliance_requirement'] = $compliance_requirement;
            $data['authority'] = $authority;
            $data['draft'] = $me['user']['id'];
            $data['priority'] = 'medium';
            $data['user'] = $me['user']['id'];
            $new = $this->obligation->add($data);
            redirect("Compliance/obligationForm/{$new['id']}");
        }
        $data['compliance_requirement'] = $this->compliance->get($data['obligation']['compliance_requirement']);
        $data['cr_short_code'] = $data['compliance_requirement']['short_code'];
        $this->modal("Form_obligation_View", $data);
    }

    function obligationApprove($id = 0, $approval = false) {// APPROVE POPUP / MODAL
        if ($approval) {
            $data['id'] = $id;
            $data['approved'] = $approval;
            $this->obligation->edit($data);
            if ($approval == "approved") {
                $this->notification->obligation_approved($id);
            }
            redirect("Compliance/obligation/{$data['id']}?message=Obligation Approved Successfully");
        }
        $this->modal("obligationApproveModal");
    }

    function obligationComply($status = null, $id = 0) { // POPUP
        if ($status == 'yes' or $status == 'partially') {
            $obligation = $this->obligation->get($id);
            $next = $this->obligation->getNextSubmissionPeriod($id);
            $data['title'] = $obligation['title'];
            $data['completion'] = $status;
            $data['submission_deadline'] = $obligation['submission_deadline'];

            $this->activityTrail->add(array(
                "module" => "compliance",
                "table" => $this->obligation->table,
                "record" => $id,
                "title" => "Obligation Complied",
                "message" => "An Obligation <strong>{$obligation['title']}</strong> has been complied",
                "link" => "Compliance/{$obligation['id']}"
            ));

            $this->comply->add($data);
            unset($data);
            $data = $next;
            $data['id'] = $id;
            $data['last_submission_status'] = "complied";
            $this->obligation->edit($data);
        } else {
            
        }
    }

    function obligationDelete($id = 0, $confirmed = false) { // MODAL BOX
        $data['obligation'] = $this->obligation->get($id);
        if (!$confirmed) {
            $this->modal("obligationDeleteModal", $data);
        } else {

            $_record = $this->obligation->get($id);
            $this->activityTrail->add(array(
                "module" => "compliance",
                "table" => $this->obligation->table,
                "record" => $id,
                "title" => "Obligation Deleted",
                "message" => "An Obligation <strong>{$_record['title']}</strong> has been deleted"
            ));
            $this->obligation->delete($id);
            redirect("Compliance/complianceRequirement/{$data['obligation']['compliance_requirement']}?message=obligation deleted");
        }
    }

    function approveObligationComply() {
        
    }

    function obligationActivate($obligation_id, $status) {
        $options = array('active', 'inactive');
        $data['id'] = $obligation_id;
        $data['status'] = $status;
        if (in_array($status, $options)) {
            $this->obligation->edit($data);
        }
        redirect("Compliance/Obligation/{$obligation_id}");
    }

    function resetSubmissionDeadline($obligation_id) {
        $data = $this->obligation->getObligation($obligation_id);
        $this->modal("ResetSubmissionDeadline", $data);
    }

    function obligationPost() {
        $data = $this->input->post();

        if (isset($data['id'])) {
            $_record = $this->obligation->get($data['id']);
            if ($_record['draft'] != 0) {
                $this->activityTrail->add(array(
                    "module" => "compliance",
                    "table" => $this->obligation->table,
                    "record" => $_record['id'],
                    "title" => "New Obligation",
                    "message" => "A new Obligation <strong>{$data['title']}</strong> has been created",
                    "link" => "Compliance/Obligation/{$_record['id']}"
                ));
                // edit Message 
            } else {
                $this->activityTrail->add(array(
                    "module" => "compliance",
                    "table" => $this->obligation->table,
                    "record" => $_record['id'],
                    "title" => "Obligation Edited",
                    "message" => "Obligation <strong>{$_record['title']}</strong> has been edited",
                    "link" => "Compliance/Obligation/{$_record['id']}"
                ));
                // add message
            }
        }
        if ($this->obligation->edit($data)) {
            redirect("Compliance/Obligation/{$data['id']}?message=changes saved");
        } else {
            return false;
        }
    }

    function obligationDraft() {
        $data = $this->input->post();
        $this->obligation->draft($data);
    }

    function obligationAutoSeekBreach() { // CRON JOB
    }

    // -- END OBLIGATION */
    // -- START BREACH */

    function breach($id = 0) { // MODAL
        $data['breaches'] = $this->breach->getBreach($id);
        $this->modal("breachPreview", $data);
    }

    function breachDelete($id = 0, $confirmed = false) { // MODAL BOX
        $data['breaches'] = $this->breach->getBreach($id);
        $oligation = $data['breaches']['obligation'];
        if (!$confirmed) {
            $this->modal("breachDeleteModal", $data);
        } else {

            $_record = $this->breach->get($id);
            $this->activityTrail->add(array(
                "module" => "compliance",
                "table" => $this->breach->table,
                "record" => $id,
                "title" => "Breach Deleted",
                "message" => "A Breach <strong>{$_record['title']}</strong> has been deleted"
            ));

            $this->obligation->delete($id);
            redirect("Compliance/obligation/{$oligation}?message=Breach Deleted ");
        }
    }

    function breachForm($id = 0, $obligation_id = 0, $s_deadline = false) { // OPEN PAGE 
        $s_deadline = urldecode($s_deadline);
        $data['breaches'] = $this->breach->get($id);
        $obligation = $this->obligation->get($obligation_id);
        $compliance_reqirement = $this->complianceRequirement->get($obligation['compliance_requirement']);
        $data['obligation'] = $obligation;


        if ($id == 0) {
            $data['breaches']['title'] = "Breach " . $obligation['title'] . " : " . strftime("%b %d %Y", strtotime(( $s_deadline ? $s_deadline : $obligation['submission_deadline'])));
            $data['breaches']['obligation'] = $obligation_id;
            $data['breaches']['type'] = 'Noncompliance';
            $data['breaches']['status'] = 'open';
            $data['breaches']['draft'] = $this->user->getMyId();

            $data['breaches']['submission_deadline'] = ( $s_deadline ? $s_deadline : $obligation['submission_deadline']);
//$data['breaches']['period'] = ( $s_deadline ? $s_deadline : $obligation['next_submission_period']);
            $new = $this->breach->add($data['breaches']);
            redirect("Compliance/breachForm/{$new['id']}");
        }
        $data['obligation'] = $this->obligation->get($data['breaches']['obligation']);
        $this->modal("BreachFormView", $data);
    }

    function ObligationBulkActionApprove($obligation_id) {
        $data['obligation'] = $this->obligation->getObligation($obligation_id);
        $this->modal("ObligationBulkActionApprove", $data);
    }

    function QuickObligationApprove($breach_id, $approved = null) {
        return $this->breachApprove($breach_id, $approved, true);
    }

    function QuickObligationComplianceApprove($compliance, $approved = null) {
        return $this->compliantApprove($compliance, $approved);
    }

    function breachApprove($id = 0, $approve = false, $comply_approve = false) { // MODAL BOX
        if ($approve == 'approved') {

            $breach = $this->breach->get($id);
            $obligation = $this->obligation->get($breach['obligation']);
            $options = array("approved", "rejected");
            $data['approved'] = $approve;
            $data['id'] = $id;
            $data['title'] = "Breach : {$obligation['title']} : " . strftime("%b %d %Y", strtotime($breach['submission_deadline']));
            $data['type'] = "breach";
            $this->breach->edit($data);

            $obligation['last_submission_status'] = "breach";
            $this->obligation->edit($obligation);

            $this->activityTrail->add(array(
                "module" => "compliance",
                "table" => $this->breach->table,
                "record" => $id,
                "title" => "Breach Approved",
                "message" => "A Breach <strong>{$breach['title']}</strong> has been approved",
                "link" => "Compliance/Obligation/{$breach['obligation']}"
            ));

            $this->notification->approve_breach($id);
            redirect("Compliance/breachForm/{$id}?message=Changes Saved");
        } else if ($approve == 'rejected') {
            $breach = $this->breach->get($id);
            unset($data);
            $data['approved'] = $approve;
            $data['id'] = $id;
            $new = $this->comply->convertBreachToComply($breach['id'], "yes", $comply_approve);
            $this->activityTrail->add(array(
                "module" => "compliance",
                "table" => $this->breach->table,
                "record" => $id,
                "title" => "Breach Rejected and Comply Created",
                "message" => "A Breach <strong>{$breach['title']}</strong> has been rejected and comply <strong>{$new['title']}</strong> created",
                "link" => "Compliance/Obligation/{$breach['obligation']}"
            ));
            $this->breach->edit($data);
            $this->notification->reject_breach($id);
            //print_pre($);
            redirect("Compliance/compliantForm/{$new['id']}?message=Changes Saved");
        } else {
            
        }
    }

    function breachToCompliance($id) { // REDIRET TO COMPLIANT FORM
    }

    function breachToIncident($id) { // REDIRET TO COMPLIANT FORM
        $breach = $this->breach->get($id);
        $obligation = $this->obligation->get($breach['obligation']);
        $compliance = $this->complianceRequirement->get($obligation['compliance_requirement']);

        $fields = $this->incidentManagement->fields;
        foreach ($fields as $key => $value) {
//$data[$key] = NULL;
        }
        $data['compliance'] = $compliance['id'];
        $data['obligation'] = $obligation['id'];
        $data['breach'] = $breach['id'];
        $data['risk_category'] = 53;
        $data['title'] = "Compliance Breach : " . $obligation['title'];
        $data['total_cost'] = $obligation['noncompliance_penalty'];
        $new = $this->incidentManagement->add($data);
        redirect("IncidentManagement/incidentForm/{$new['id']}");
    }

    function breachState($id = 0, $state = false) { // MODAL BOX
        $this->modal("breachStateModal");
    }

    function breachStatus($id = 0, $status = false) { // MODAL BOX
        $data['id'] = $id;
        $data['status'] = $status;
        $this->breach->edit($data);
        redirect("Compliance/breach/{$id}?message=Changes Saved");
    }

    function breachPost() {
        $data = $this->input->post();
//        print_pre($data);
//        exit;        
        if ($data['id']) {
            $this->breach->edit($data);
            $_record = $this->breach->get($data['id']);
            $this->activityTrail->add(array(
                "module" => "compliance",
                "table" => $this->breach->table,
                "record" => $_record['id'],
                "title" => "Breach Edited",
                "message" => "Breach <strong>{$_record['title']}</strong> has been edited",
                "link" => "Compliance/obligation/{$data['obligation']}"
            ));
        } else {
            $this->breach->add($data);

            $_record = $this->breach->get($data['id']);
            $this->activityTrail->add(array(
                "module" => "compliance",
                "table" => $this->breach->table,
                "record" => $_record['id'],
                "title" => "New Breach",
                "message" => "A new Breach <strong>{$data['title']}</strong> has been created",
                "link" => "Compliance/obligation/{$data['obligation']}"
            ));
        }
//print_pre($data);
        redirect("Compliance/obligation/{$data['obligation']}?message=Changes Saved");
    }

    // -- END BREACH */
    // -- START COMPLIED */

    function compliantForm($compliant = 0, $obligation = 0, $status = "yes") {    // subject to compliance requirement type
        $data['complies'] = $this->comply->getComply($compliant);
        if ($compliant == 0) {
            $new = $this->comply->create($obligation, $status);
            redirect("Compliance/compliantForm/{$new['id']}");
        }
        $this->modal("CompliantFormView", $data);
    }

    function compliant($compliant = 0) {
        $data['complies'] = $this->comply->getComply($compliant); //   modal popup
        $this->modal("CompliantPreview", $data);
    }

    function compliantApprove($id = 0, $approved = false) { //   modal popup
        if ($approved == 'approved') {
            $comply = $this->comply->get($id);
            $options = array("approved", "rejected");
            $data['approved'] = $approved;
            $data['id'] = $id;

            $this->activityTrail->add(array(
                "module" => "compliance",
                "table" => $this->comply->table,
                "record" => $id,
                "title" => "Comply Approved",
                "message" => "A Comply <strong>{$comply['title']}</strong> has been approved",
                "link" => "Compliance/obligation/{$comply['obligations']}"
            ));

            $this->comply->edit($data);
            redirect("Compliance/compliant/{$id}?message=Changes Saved");
        } else if ($approved == 'rejected') {
            $comply = $this->comply->get($id);
            $url = "Compliance/breachForm/0/{$comply['obligations']}/{$comply['submission_deadline']}?message=Changes Saved";
            //  "Compliance/breachForm/0/{$comply['obligations']}/{$comply['submission_deadline']}";

            $data['id'] = $comply['obligations'];
            $data['last_submission_status'] = "breach";

            $this->activityTrail->add(array(
                "module" => "compliance",
                "table" => $this->comply->table,
                "record" => $id,
                "title" => "Comply Rejected",
                "message" => "A Comply <strong>{$comply['title']}</strong> has been rejected",
                "link" => "Compliance/obligation/{$comply['obligations']}"
            ));

            $this->obligation->edit($data);

            $this->comply->delete($comply['id']);
            redirect($url);
        }
    }

    function compliantDelete($compliant = 0, $confirmed = 0) { // confirm popup
        $data['complies'] = $this->comply->getComply($compliant);
        if (!$confirmed) {
            $this->modal("compliantDeleteModal", $data);
        } else {

            $_record = $this->comply->get($id);
            $this->activityTrail->add(array(
                "module" => "compliance",
                "table" => $this->comply->table,
                "record" => $id,
                "title" => "Comply Deleted",
                "message" => "A Comply <strong>{$_record['title']}</strong> has been deleted"
            ));

            $this->comply->delete($id);
            redirect("Compliance/Dashboard");
        }
    }

    function compliantConvertToBreach($compliant = 0) { // subject to compliance requirement type
    }

    function compliantPost() {
        $data = $this->input->post();
        $comply = $this->comply->get($data['id']);
        $obligaton = $this->obligation->get($comply['obligations']);
        if ($comply['draft'] != 0 and ( $comply['submission_deadline'] == $obligaton['submission_deadline'])) {
            $next_period = $this->obligation->getNextSubmissionPeriod(false, $obligaton);
            $next_period['last_submission_status'] = $data['completion'];
            $next_period['id'] = $obligaton['id'];
            $this->obligation->edit($next_period);
        }
        if ($obligaton['repeat'] == 'continuous') {
            $obligation_data["id"] = $obligaton['id'];
            $obligation_data["status"] = "inactive";
            $this->obligation->edit($obligation_data);
            unset($obligation_data);
        }
        $this->activityTrail->add(array(
            "module" => "compliance",
            "table" => $this->comply->table,
            "record" => $data['id'],
            "title" => "New Comply",
            "message" => "A new Comply <strong>{$data['title']}</strong> has been created",
            "link" => "Compliance/obligation/{$obligaton['id']}"
        ));

        $this->comply->edit($data);
        redirect("Compliance/Obligation/{$obligaton['id']}?message=Changes Saved");
    }

    // -- END COMPLIED */
    // -- START AUTHORITY */

    function authority($id = 0) { //
        $data['authority'] = $this->authority->get($id);
        $this->modal("authorityModal", $data);
    }

    function authorityDelete($id = 0, $confirmed = 0) {
        $data['authority'] = $this->authority->get($id);
        if (!$confirmed) {
            $this->modal("authorityDeleteModal", $data);
        } else {

            $_record = $this->authority->get($id);
            $this->activityTrail->add(array(
                "module" => "compliance",
                "table" => $this->authority->table,
                "record" => $id,
                "title" => "Authority Deleted",
                "message" => "An Authority <strong>{$_record['title']}</strong> has been deleted"
            ));

            $this->authority->delete($id);
            redirect("Compliance/authorityForm/?message=Authority Deleted ");
        }
    }

    function authorityApprove($id = 0) {


        $this->modal("authorityApproveModal");
    }

    function authorityForm($id = 0) {
        $data['authorities'] = $this->authority->getAll();
        $data['authority'] = $this->authority->get($id);
        $this->modal("Form_authority_View", $data);
    }

    function authorityPost() {
        $data = $this->input->post();
        if ($data['id']) {
//            $_record = $this->authority->get($data['id']);
            $this->activityTrail->add(array(
                "module" => "compliance",
                "table" => $this->authority->table,
                "record" => $data['id'],
                "title" => "Authority Edited",
                "message" => "An Authority <strong>{$data['title']}</strong> has been edited",
                "link" => "Compliance/authorityForm"
            ));
            $this->authority->edit($data);
        } else {
            $this->authority->add($data);
            $this->activityTrail->add(array(
                "module" => "compliance",
                "table" => $this->authority->table,
                "record" => $data['id'],
                "title" => "New Authority",
                "message" => "A new Authority <strong>{$data['title']}</strong> has been created",
                "link" => "Compliance/authorityForm"
            ));
        }
        redirect("Compliance/authorityForm/?message=Changes Saved");
    }

    function obligation_dependent($obligation_id = 0) { //
        $data['obligation_dependents'] = $this->complianceDependent->getObligation($obligation_id);
        $this->ajax("obligation_dependent", $data);
    }

    function obligation_dependentDelete($id = 0, $confirmed = false) {

        $data['obigation_dependent'] = $this->complianceDependent->get($id);
        if (!$confirmed) {
            $this->modal("obligationDepenedetDelete", $data);
        } else {
            $_record = $this->complianceDependent->get($id);
            $this->activityTrail->add(array(
                "module" => "compliance",
                "table" => $this->complianceDependent->table,
                "record" => $id,
                "title" => "Compliance Dependent Deleted",
                "message" => "A Compliance Dependent <strong>{$_record['title']}</strong> has been deleted"
            ));

            $this->complianceDependent->delete($id);
            redirect("Compliance/obligation/{$data['obigation_dependent']['obligations']}/?message=Dependent Deleted#complianceDependentsTable");
        }
    }

    function obligation_dependentForm($id = 0, $obligations = 0) {

        $data['obligation_dependent'] = $this->complianceDependent->get($id);
        if (count($data['obligation_dependent']) == 0) {
            $data['obligation_dependent'] = $this->complianceDependent->fields;
            foreach ($data['obligation_dependent'] as $key => $value) {
                $data['obligation_dependent'][$key] = NULL;
            }
            $data['obligation_dependent']['obligations'] = $obligations;
        }
        $this->modal("Form_compliance_dependent_View", $data);

//        $data['authorities'] = $this->authority->getAll();
//        $data['authority'] = $this->authority->get($id);
//        $this->modal("Form_authority_View", $data);
    }

    function obligation_dependentPost() {
        $data = $this->input->post();

        if ($data['id']) {
            $this->complianceDependent->edit($data);
            $this->activityTrail->add(array(
                "module" => "compliance",
                "table" => $this->complianceDependent->table,
                "record" => $data['id'],
                "title" => "Compliance Dependent Edited",
                "message" => "A Compliance Dependent <strong>{$data['title']}</strong> has been edited",
                "link" => "Compliance/obligation/{$data['obligations']}"
            ));
        } else {
            $_record = $this->complianceDependent->add($data);

            $this->activityTrail->add(array(
                "module" => "compliance",
                "table" => $this->complianceDependent->table,
                "record" => $_record['id'],
                "title" => "New Compliance Dependent",
                "message" => "A new Compliance Dependent <strong>{$data['title']}</strong> has been created",
                "link" => "Compliance/obligation/{$data['obligations']}"
            ));
        }
        redirect("Compliance/obligation/{$data['obligations']}/?message=changes saved#complianceDependentsTable");
    }

    // -- END AUTHORITY */
//    function compliance(){}


    function riskForm($id = 0, $repository = 0, $environment = 0) {
        $me = $this->user->getMe();
        if ($id == 0) {
            $data['draft'] = $me['user']['id'];
            $data['repository'] = $repository;
            $data['environment'] = $environment;
            $new = $this->risk->add($data);
            redirect("Risk/riskForm/{$new['id']}");
        }

        $data['risk'] = $this->risk->get();
    }

    public function flotChart() {
        $this->page("flotChart");
    }

    function complianceFilter() {
        $filters = $this->input->post();
        $risks = $this->compliance->complianceFilter();
//print_pre($filters);
    }

}
