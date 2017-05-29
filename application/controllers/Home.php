<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Home extends CI_Controller {

    public $sources, $page_title, $breach_cramb;

    function __construct() {
        parent::__construct();
        $this->page_title = " ";
        date_default_timezone_set('Africa/Nairobi');
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
        $this->load->model("Users/UserTypeActionsModel", "userTypeActions");

        if (!$this->auth->checkLogin()) {
            redirect("Login/?message=Please login to proceed");
        }
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
        
        $this->load->model("Audit/AuditModel", "audit");
        $this->load->model("Audit/IssueModel", "issue");
        $this->load->model("Audit/RecommendationModel", "recommendation");
        $this->load->model("Audit/ActionPlansModel", "action_plans");
        $this->load->model("Audit/AuditAreaModel", "auditArea");
        $this->load->model("Audit/AuditCommentModel", "auditComment");

        $this->load->model("ActivityTrail/ActivityTrailModel", "activityTrail");
    }

    function e404Hundler($filepath) {
        if (!file_exists("application/views/" . $filepath . ".php")) {
            $filename = "application/views/" . $filepath . ".php";
            /* echo "Error : File ('$filename') does not exist"; */ return false;
        } else {
            return true;
        }
    }

    function modal_link() {
        $this->modal("name");
    }

    function page($pageName = "", $pageData = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "Home/Pages/" . ucwords($pageName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/Home");
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
        $this->load->view("Includes/HeadView", $data);
        $this->load->view("Includes/MainNavView", $data);
        $this->load->view("Home/Includes/HomeHeaderView");
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
        $this->load->view("Includes/FooterView");
    }

    function form($formName = "", $data = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "Home/Forms/" . ucwords($formName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/Home");
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
        $data['data'] = $data;
        $data['scripts'] = $scripts;
        $data['stylesheets'] = $stylesheets;
        $this->load->view("Includes/HeadView", $data);
        $this->load->view("Includes/MainNavView", $data);
        $this->load->view("Home/Includes/HomeHeaderView");
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
        $filename = "Home/Modals/" . ucwords($modalName);
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

    function comments() {
        $data['comments'] = $this->comments->getAll();
        //print_pre($data);
        $this->page("commentsView", $data);
    }

    function ajax($fileName = "", $data = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "Home/Ajax/" . ucwords($fileName);
        if ($this->e404Hundler($filename)) {
            //redirect("index.php/Home");
        }
        $data['repository_sources'] = $this->sources;
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
        $filename = "Home/NotificationsPopup/$pageName";
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

    function chart() {
        $this->page("chart");
    }

    function unitForm($id = 0, $parent_id = 1) {
        $me = $this->user->getMe();
        $data['me'] = $me;
        if ($id == 0) {
            $next_level = $this->environment->nextLevel($parent_id);
            $data['parent_id'] = $parent_id;
            $data['environment_level'] = $next_level['id'];
            $data['unit_owner'] = $me['user']['id'];
            $data['draft'] = $me['user']['id'];
            $unit = $this->environment->add($data);
            redirect("Home/unitForm/{$unit['id']}");
        }
        $data['repository_sources'] = $this->sources;
        $data['environment'] = $this->environment->get($id);
        $data['environment_level'] = $this->environmentLevel->get($data['environment']['environment_level']);
        if ($data['environment_level']['id'] == 1) {
            $data['users'] = $this->user->getCorporateAdmins();
        } else {
            $data['users'] = $this->user->getUnitOwners();
        }

        $this->modal("UnitFormView", $data);
    }

    function projectForm($id = 0) {
        $me = $this->user->getMe();
        if ($id == 0) {
            $data['parent_id'] = 1;
            $data['environment_level'] = 5;
            $data['unit_owner'] = $me['user']['id'];
            $data['draft'] = $me['user']['id'];
            $unit = $this->environment->add($data);
            redirect("Home/unitForm/{$unit['id']}");
        }
        $data['repository_sources'] = $this->sources;
        $data['environment'] = $this->environment->get($id);
        $data['environment_level'] = $this->environmentLevel->get($data['environment']['environment_level']);
        $data['users'] = $this->user->getUnitOwners();
        $this->modal("UnitFormView", $data);
    }

    function unitDelete($id = 0, $confirmed = 0) {
        if ($confirmed) {
            $unit = $this->environment->get($id);
            $this->environment->delete($id);
            $_record = $unit;
            $this->activityTrail->add(array(
                "module" => "environment",
                "table" => $this->environment->table,
                "record" => $_record['id'],
                "title" => "Unit Deleted",
                "message" => "The unit  <strong>{$_record['name']}</strong> has been deleted",
            ));
            redirect("Home/dashboard/{$unit['parent_id']}?message=Unit Deleted");
        } else {
            $data['environment'] = $this->environment->getUnit($id);
            $this->modal("confrimDeleteUnit", $data);
        }
    }

    function postUnit() {
        $data = $this->input->post();
        $id = isset($data['id']) ? $data['id'] : NULL;
        $record = $this->environment->get($id);
        if ($record['draft'] != 0) {
            $_record = $this->environment->get($id);
            $this->activityTrail->add(array(
                "module" => "environment",
                "table" => $this->environment->table,
                "record" => $_record['id'],
                "title" => "Unit Created",
                "message" => "A unit <strong>{$_record['name']}</strong> has been created",
                "link" => "Home/dashboard/{$_record['id']}/",
            ));
        } else {
            $_record = $this->environment->get($id);
            $this->activityTrail->add(array(
                "module" => "environment",
                "table" => $this->environment->table,
                "record" => $_record['id'],
                "title" => "Unit Edited",
                "message" => "A unit <strong>{$_record['name']}</strong> has been edited",
                "link" => "Home/dashboard/{$_record['id']}/"
            ));
        }
//        print_pre($data); exit;
        $this->environment->edit($data);
////        redirect("Home/dashboard/{$data['parent_id']}?message=changes saved");
        redirect("Home/dashboard/{$record['parent_id']}?message=changes saved");
    }

//    function postUnit() {
//        $data = $this->input->post();
//        if (isset($data['id'])) {
//            $_record = $this->environment->get($data['id']);
//            if ($_record['draft'] != 0) {
//                $this->activityTrail->add(array(
//                    "module" => "enviroment",
//                    "table" => $this->environment->table,
//                    "record" => $_record['id'],
//                    "title" => "New Unit",
//                    "message" => "A new Unit has been created <strong>{$data['title']}</strong>",
//                    "link" => "Home/environment/{$_record['id']}"
//                ));
//                // edit Message 
//            } else {
//                $this->activityTrail->add(array(
//                    "module" => "environment",
//                    "table" => $this->environment->table,
//                    "record" => $_record['id'],
//                    "title" => "Unit Edited",
//                    "message" => "Unit <strong>{$data['title']}</strong> has been edited",
//                    "link" => "Home/environment/{$_record['id']}"
//                ));
//                // add message
//            }
//            
//           
//        }

    function index() {
        $this->dashboard(0);
    }

    function dashboard($unit_id = 1) {
        if (!$unit_id) {
            redirect("Home/dashboard/1/");
        }

        $data['environment'] = $this->environment->getUnit($unit_id);
        $data['tree'] = $this->environment->getTree($unit_id);

        $this->page_title .= $data['environment']['name'];

        $data['next_level'] = $this->environment->nextLevel($unit_id);
        $data['projects'] = $this->environment->getProjects($unit_id);
        $data['repository'] = $this->environment->getRepository($unit_id);

        /*

         * Alex
         * Please make sure that all the methods below are calling incidents from a specific unit.
         * 
         *          */
        $data['risk'] = $this->risk->getRisksByEnvironment($unit_id);
        if($unit_id == 1){
            $data['Audit'] = $this->audit->getAll();
        }else {
            $data['Audit'] = $this->audit->getAll($unit_id);
        }
        //$data['comp_req'] = $this->compliance->getminAllCR();
        $data['incidents'] = $this->incident->getEnvironment($unit_id);
        $data['overdue_ob'] = []; // $this->obligation->getOverdueObligations();
        $data['all_high_net_risk'] = []; //  $this->risk->getAllHighNetRisk();
        $data['IncidentsWithTotalLoss'] = $this->incident->getAllIncidentsWithTotalLoss();
        $this->page("DashboardView", $data);
    }

    /* REPOSITORY / KEY RISK AREAS / RISK SOURCES / KRA-CLIPBOARD */

    function repositoryForm($id = 0, $source = false, $environment = 1, $parent_id = 0) {
        if ($id == 0) {
            $data['source'] = $source;
            $data['environment'] = $environment;
            $record = $this->repository->add($data);
            redirect("Home/repositoryForm/{$record['id']}");
        }
        $data['owners'] = $this->user->getUnitOwners();
        $data['repository'] = $this->repository->getRepository($id);
        $this->modal($data['repository']['source'] . "Form", $data);
    }

    function repositoryDelete($id = 0, $confirmed = false) {
        if ($confirmed) {
            $repository = $this->repository->getRepository($id);
            $title = ucwords(str_replace("_", " ", $repository['source']));

            $message = ($repository['pool'] == 0) ? "$title Deleted " : "$title Removed ";
            $option = ($repository['pool'] == 0) ? " Deleted " : " Removed ";
            $this->repository->delete($id);
            $_record = $repository;

            $this->activityTrail->add(array(
                "module" => "environment",
                "table" => $this->repository->table,
                "record" => $_record['id'],
                "title" => "$title " . "Deleted",
                "message" => "$title <strong>{$_record['name']}</strong> has been " . ucwords($option),
                "link" => "Home/repositoryPreview/{$_record['id']}"
            ));


            redirect("Home/dashboard/{$repository['environment']}?message=$message");
        } else {


            $data['repository'] = $this->repository->getRepository($id);
            $this->modal("confrimDeleteRepositoryView", $data);
        }
    }

    function siteMap() {
        $this->page_title = " Site Map ";
        $data['site_map'] = $this->environment->getFamilyTree(1);
        $data['all_units'] = $this->environment->getAll();
        $this->page("siteMap", $data);
    }

    function repositoryPreview($id = 0) {
        $data['repository'] = $this->repository->getRepository($id);
        $this->modal("preview_{$data['repository']['source']}_View", $data);
    }

    function repository($id = 0) {
        $data['repository'] = $this->repository->getRepository($id);
//        print_pre($data);        exit();
        $this->page("{$data['repository']['source']}_page_View", $data);
    }

    function repositoryImport($unit_id) {
        $data['pool_raw'] = $this->repository->getPool();
        $data['unit'] = $this->environment->get($unit_id);
        $data['unit_repository'] = $this->repository->getEnvironment($unit_id);
        $data['repository_list'] = [];
        $data['pool'] = [];
        foreach ($data['unit_repository'] as $key => $value) {
            $data['repository_list'][] = $value['serial'];
        }
        foreach ($data['pool_raw'] as $key => $value) {
            if (!in_array($value['serial'], $data['repository_list'])) {
                $data['pool'][] = $value;
            }
        }
        $this->modal("repositoryImport", $data);
    }

    function repositoryImportPost() {
        $data = $this->input->post();
        $this->repository->importRepository($data);
        redirect("Home/dashboard/{$data['environment']}?message=changes saved");

        //  print_pre($_POST);
    }

    function repositoryApprove($id, $option = "pending") {
        if ($option == 'approved' or $option == 'rejected') {
            $this->repository->approve($id, $option);
            $_record = $this->repository->get($id);
            $title = ucwords(str_replace("_", " ", $_record['source']));

            $this->activityTrail->add(array(
                "module" => "environment",
                "table" => $this->repository->table,
                "record" => $_record['id'],
                "title" => "$title " . ucwords($option),
                "message" => "$title  <strong>{$_record['name']}</strong> has been " . ucwords($option),
                "link" => "Home/repositoryPreview/{$_record['id']}"
            ));
        }
        redirect("Home/repositoryPreview/{$id}?message=changes saved");
    }

    function repositoryPost() {
        $data = $this->input->post();
        $repository = $this->repository->get($data['repository_id']);
        $json_data = objectToArray(json_decode($repository['json_data']));
        foreach ($data as $key => $value) {
            if ($key == 'repository_id' or $key == 'id') {
                continue;
            }
            $json_data[$key] = $value;
        }
        if ($repository['environment'] == 0) {
            $repository['pool'] = 1;
        }
        $repository['name'] = (isset($data['name'])) ? $data['name'] : NULL;
        $repository['name'] = (isset($data['title'])) ? $data['title'] : $repository['name'];
        $repository['json_data'] = json_encode($json_data);

        $_record = $this->repository->get($data['repository_id']);

        $title = ucwords(str_replace("_", " ", $_record['source']));
        if ($_record['draft'] != 0) {
            $this->activityTrail->add(array(
                "module" => "environment",
                "table" => $this->repository->table,
                "record" => $_record['id'],
                "title" => "New $title",
                "message" => "A $title <strong>{$_record['name']}</strong> has been created ",
                "link" => "Home/repositoryPreview/{$_record['id']}"
            ));
        } else {
            $this->activityTrail->add(array(
                "module" => "environment",
                "table" => $this->repository->table,
                "record" => $_record['id'],
                "title" => "$title Edited",
                "message" => "A $title <strong>{$_record['name']}</strong> has been edited",
                "link" => "Home/repositoryPreview/{$_record['id']}"
            ));
        }
        $this->repository->edit($repository);
        if ($repository['environment'] != 0) {
            redirect("Home/dashboard/{$repository['environment']}?message=$title changes saved");
        } else {
            redirect("Home/repositoryPool/?message=$title changes saved");
        }
    }

    /* END REPOSITORY / KEY RISK AREAS / RISK SOURCES / KRA-CLIPBOARD */

    function repositoryPool() {
        $this->page_title .= "Repository Pool";
        $data['repository'] = $this->repository->getPool();
        $this->page('repositoryPool', $data);
    }

    function userTypes() {
        $actions = $this->userTypeActions->getAll();
        $userTypes = $this->userType->getAll();
        $data['user_type'] = $userTypes;
        $data['actions'] = $actions;
        $type = [];
        foreach ($actions as $key => $value) {
            foreach ($userTypes as $label => $record) {
                if (!isset($userTypes[$label]['actions'])) {
                    $userTypes[$label]['actions'] = [];
                }
                if ($record['id'] == $value['user_type']) {
                    $userTypes[$label]['actions'][] = $value;
                }
            }
        }
        $this->page('userTypes', $data);
    }

    function emailNotificationMessage($id) {
        $data['notification'] = $this->notification->get($id);
        $this->ajax("EmailNotificationMessage", $data);
    }

    function notifications($email = 0) {
        $data['all_notifications'] = $this->notification->getAll();
        $data['my_notifications'] = $this->notification->getMe();

        $data['notification'] = $this->notification->get($email);
        $this->page("Notifications", $data);
    }

    function documents($module = "all", $table = null, $record = null) {
        $this->page_title .= "System Documents";
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

    function findKRAsOptions($unit_id) {
        //sleep(10);
        $kras = $this->repository->getEnvironment($unit_id);
        $html = NULL;
        foreach ($kras as $key => $value) {
            $html .= "<option value='{$value['id']}'>{$value['name']}</option>";
        }
        echo $html;
    }

    function risks() {
        $data['risks'] = $this->risk->getInactive();
        $data['controls'] = $this->control->getInactive();
        $data['activities'] = $this->activity->getInactive();
        $data['undefined'] = $this->risk->getUndefined();
        $data['kra'] = $this->repository->getAll();
        $this->page("RisksView", $data);
    }

    function compliance() {
        $data['breaches'] = $this->breach->getInactive();
        $data['complies'] = $this->comply->getInactive();
        $this->page("ComplianceView", $data, array());
    }

    function incidentManagement() {
        $data['incidents'] = $this->incident->getInactive();
        $this->page("IncidentManagementView", $data, array());
    }

    function users($user_id = 0) {
        $data['users'] = $this->user->getAll();
        if (count($data['users']) > 0 and $user_id == 0) {
            $message = $this->input->get("message") ? "?message=" . $this->input->get("message") : NULL;
            redirect("Home/users/{$data['users'][0]['id']}/{$message}");
        }

        foreach ($data['users'] as $key => $value) {
            $data['users'][$key]['user_type'] = $this->userType->get($value['user_type']);
            if($value['corporate'] != 0){
                $data['users'][$key]['corporate'] = $this->environment->get($value['corporate']);
            }
        }
        $data['user'] = $this->user->getUserDetials($user_id);
        $data['user_corporate'] = $this->environment->get($data['user']['corporate']);
        $data['user_types'] = $this->userType->getAll();
        $data['me'] = $this->user->getme();
        $this->page("usersView", $data);
    }

    function riskAdministration() {
        $this->page("IncidentManagementView", array());
    }

    function usersForm($id = 0) {
        $me = $this->user->getMe();
        $this->user->deleteBlank();
        if ($id == 0) {
            $data['activated'] = 'false';
            $data['draft'] = $me['user']['id'];
            $data['created'] = date("Y-m-d H:i:s");
            $data['password'] = md5("password");
            $new = $this->user->add($data);
            redirect("Home/usersForm/{$new['id']}");
        }
        $data['corporates'] = $this->environment->getCorporates();
        $data['user'] = $this->user->get($id);
        $data['user_types'] = $this->userType->getAll();

        $this->modal("usersForm", $data);
    }

    function userPreview($id = 0) {
        
    }

    function activityList() {
        $data['trail'] = $this->activityTrail->getAll();
        $this->page("activityList", $data);
    }

    function activityListMore($page = 1) {
        $list = $this->activityTrail->getAll($page);
    }

    function usersDelete($id = 0, $confirmed = false) {
        if ($confirmed and $id) {
            $this->user->delete($id);
            redirect("Home/users/?message=User Deleted");
        } else {
            $data['user'] = $this->user->get($id);
            $this->modal("userDeleteConfirm", $data);
        }
    }

    function userHundover($user_id = 0, $confirmed = false) {
        $user = $this->user->getUser($user_id);
        $users = $this->user->getUsersBy(array("user_type" => $user['user_type']));
        //print_pre($users);
        $data['user'] = $user;
        $data['users'] = $users;
        $this->modal("userHundover", $data);
    }

    function userHundoverPost() {
        $data['from'] = $this->input->post("from");
        $data['to'] = $this->input->post("to");
        $from = $data['from'];
        $to = $data['to'];

        $user = $this->user->getUserDetials($from);
        ;
        $total = 0;
        foreach ($user['duties'] as $value) {
            $total += count($total);
        }
        $data['agree'] = $this->input->post("agree");
        $this->environment->handover($data['from'], $data['to']);
        $this->risk->handover($data['from'], $data['to']);

        $this->environment->handover($from, $to);
        $this->risk->handover($from, $to);
        $this->control->handover($from, $to);
        $this->controlActivity->handover($from, $to);
        $this->compliance->handover($from, $to);
        $this->complianceRegister->handover($from, $to);
        $this->obligation->handover_responsible_manager_1($from, $to);
        $this->obligation->handover_responsible_manager_2($from, $to);
        $this->obligation->handover_escalations_person($from, $to);
        $this->incident->handover_incident_owner($from, $to);
        $this->incident->handover_responsible_manager($from, $to);
        $this->incidentActions->handover($from, $to);
        $from_user = $this->user->get($from);
        $to_user = $this->user->get($to);

        redirect("Home/users/{$data['from']}?message=({$total}) responsibilities transfered from {$from_user['names']} to {$to_user['names']} successfully");
    }

    function userPost() {
        $data = $this->input->post();
        $username = isset($data['username']) ? $data['username'] : false;
        if (isset($data['id']) and $data['id']) {
            unset($data['username']);
            $this->user->edit($data);
            redirect("Home/users/{$data['id']}/?message=Changes Saved");
        } else {
            if ($username and $this->user->unique($username)) {
                $new = $this->user->add($data);
                $this->notification->user_create($new['id']);
                redirect("Home/users/{$new['id']}/?message=User {$new['names']} Created");
            } else {
                redirect("Home/users/?message=This Username already exists");
            }
        }
        //    
    }

    function settings() {
        $this->page("IncidentManagementView");
    }

}
