<?php

class Risk extends CI_Controller {

    public $heatmap, $page_title, $breach_cramb;

    function __construct() {
        parent::__construct();

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

        $this->page_title = null;
        $this->load->model("Bridge/BridgeModel", "bridge");

        $this->load->model("Risk/RiskModel", "risk");
        $this->load->model("Risk/CategoryModel", "category");

        $this->load->model("Risk/CategoryModel", "risk_category");
        $this->load->model("Risk/RegisterModel", "register");
        $this->load->model("Risk/AnalysisModel", "analysis");
        $this->load->model("Risk/EvaluationModel", "evaluation");
        $this->load->model("Risk/ControlCategoryModel", "controlCategory");
        $this->load->model("Risk/ControlModel", "control");
        $this->load->model("Risk/ControlActivityModel", "activity");
        $this->load->model("Risk/ControlActivityModel", "controlActivity");

        $this->load->model("Environment/RepositoryModel", "repository");
        $this->load->model("Environment/EnvironmentModel", "environment");
        $this->load->model("Environment/EnvironmentLevelModel", "environmentLevel");

        $this->load->model("Compliance/ComplianceRequirementModel", "complianceRequirement");
        $this->load->model("Compliance/ComplianceVersionModel", "complianceVersion");
        $this->load->model("Compliance/BreachModel", "breach");
        $this->load->model("Compliance/ObligationComplyModel", "complies");
        $this->load->model("Compliance/ObligationModel", "obligation");
        $this->load->model("Compliance/AuthorityModel", "authority");
        $this->load->model("Compliance/ComplianceRegisterModel", "register");
        $this->load->model("Compliance/ObligationComplyModel", "comply");

        $this->load->model("IncidentManagement/IncidentManagementModel", "incident");
        $this->load->model("IncidentManagement/IncidentActionsModel", "incidentActions");
        $this->load->model("IncidentManagement/IncidentCategoryModel", "incidentCategory");


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

    function page($pageName = "", $pageData = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "Risk/Pages/" . ucwords($pageName);
        if ($this->e404Hundler($filename)) {
//redirect("index.php/Risk");
        }

        $data['message'] = ($this->input->get("message")) ? "<div style='padding:7px'>" . ucwords($this->input->get("message")) . "</div>" : NULL;
        $data['page_title'] = $this->page_title;
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
        $this->load->view("Risk/Includes/RiskHeaderView");

        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }

        $this->load->view("Includes/FooterView");
    }

    function form($formName = "", $data = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "Risk/Forms/" . ucwords($formName);
        if ($this->e404Hundler($filename)) {
//redirect("index.php/Risk");
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
        $data['data'] = $data;
        $data['scripts'] = $scripts;
        $data['stylesheets'] = $stylesheets;
        $this->load->view("Includes/HeadView", $data);
        $this->load->view("Includes/MainNavView", $data);
        $this->load->view("Risk/Includes/RiskHeaderView");
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
        $this->load->view("Includes/FooterView");
    }

    function modal($modalName = "", $pageData = array(), $scripts = array(), $stylesheets = array()) {
        $filename = "Risk/Modals/" . ucwords($modalName);
        if ($this->e404Hundler($filename)) {
//redirect("index.php/Risk");
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
        $filename = "Risk/Ajax/" . ucwords($fileName);
        if ($this->e404Hundler($filename)) {
//redirect("index.php/Risk");
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
        $filename = "Risk/NotificationsPopup/$pageName";
        if ($this->e404Hundler($filename)) {
//redirect("index.php/Risk");
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
        $data['risks'] = $this->risk->getAll();
        $data['registers'] = $this->register->getAll();
        $data['categories'] = $this->category->getAll();
        $data['business_units'] = $this->environment->getUnits(1);
        $data['risk_sources'] = $this->repository->getRiskSources();
        $this->page("riskDashboardView", $data);
        $this->page_title .= "Dashboard";
    }

    function actions() {
        $this->page("ActionsView");
    }

    /* REGISTER CONTROLLER */

    function register($id = 0) {
        $data['registers'] = $this->register->getAll();
        $data['register'] = $this->register->get($id);
        $data['risks'] = $this->bridge->getRegisterRisks($id);


        if (!$data['register']) {
            $data['register'] = isset($data['registers'][0]) ? $data['registers'][0] : [];
        }
        $title = (isset($data['register']['title'])) ? $data['register']['title'] : NULL;
        $this->page_title .= " Risk Registers  | $title";
        if (isset($data['register']['id']) and $data['register']['id'] != $id) {
            redirect("Risk/register/{$data['register']['id']}");
        }

        $this->page("RiskRegisterView", $data, array(), array(), array());
    }

    function registerForm($id = 0) {
        $me = $this->user->getMe();
        if ($id == 0) {
            $data['user'] = $me['user']['id'];
            $data['draft'] = $me['user']['id'];
            $data['published'] = 0;
            $new = $this->register->add($data);
            redirect("Risk/registerForm/{$new['id']}");
        }
        $data['register'] = $this->register->get($id);
        $this->modal("registerForm", $data);
    }

    function registerPublish($id = 0) {
        $data = $this->register->get($id);
        $data['published'] = 1;
        $_record = $data;
        $this->activityTrail->add(array(
            "module" => "risk",
            "table" => $this->register->table,
            "record" => $_record['id'],
            "title" => "Risk Register Published",
            "message" => "A risk Register  <strong>{$_record['title']}</strong> has been published",
            "link" => "Risk/register/{$_record['id']}"
        ));


        $this->register->edit($data);
        redirect("Risk/register/{$data['id']}?message=changes saved");
    }

    function registerDelete($id = 0, $confirmed = false) {
        if ($confirmed === false) {
            $data['register'] = $this->register->get($id);
            $this->modal("registerDeleteConfirm", $data);
        } else {
            $_record = $this->register->get($id);
            $this->activityTrail->add(array(
                "module" => "risk",
                "table" => $this->register->table,
                "record" => $_record['id'],
                "title" => "Risk Register Deleted",
                "message" => "A risk Register <strong>{$_record['title']}</strong> has been Deleted",
            ));

            $this->register->delete($id);
            redirect("Risk/register?message=Register <strong>{$_record['title']}</strong> has been Deleted");
        }
    }

    function registerSelectRisk($register = 0) {
        $data['register'] = $register;
        $data['risks'] = $this->risk->getAll();
        $data['register_risks'] = $this->bridge->getRegisterRisks($register);
        $data['risks_ids'] = [];
        foreach ($data['register_risks'] as $value) {
            $data['risks_ids'][] = $value['id'];
        }
        $this->modal("registerSelectRiskView", $data);
    }

    function setRegisterRisks() {
        $data = $this->input->post();
        //print_pre($data);
        $this->bridge->addRisksToRegister($data);
        redirect("Risk/register/{$data['risk_register']}?message=changes saved");
    }

    function registerAddRisks() {

        // redirect("Risk/register/{$data['register']}");
        redirect("Risk/register/");
    }

    function registerPost() {
        $data = $this->input->post();
        if (isset($data['id'])) {
            $_record = $this->register->get($data['id']);
            if ($_record['draft'] != 0) {
                $this->activityTrail->add(array(
                    "module" => "risk",
                    "table" => $this->register->table,
                    "record" => $_record['id'],
                    "title" => "New Risk Register",
                    "message" => "A new risk register has been created <strong>{$data['title']}</strong>",
                    "link" => "Risk/register/{$_record['id']}"
                ));
            } else {
                $this->activityTrail->add(array(
                    "module" => "risk",
                    "table" => $this->register->table,
                    "record" => $_record['id'],
                    "title" => "Risk Register Edited",
                    "message" => "A risk register <strong>{$data['title']}</strong> has been edited",
                    "link" => "Risk/register/{$_record['id']}"
                ));
                // add message
            }
        }
        $this->register->edit($data);
        redirect("Risk/register/{$data['id']}?message=changes saved");
    }

    /* END REGISTER CONTROLLER */

    /* CATEGORY VIEW */

    function category($id = 0) {
        $data['categories'] = $this->category->getChildLevels();
        $data['category'] = $this->category->get($id);
        $data['root'] = $this->category->getCategoryRoot($id);
        if (count($data['category']) == 0 and count($data['categories']) > 0) {
            $data['category'] = $data['categories'][0];
        }
        $data['risks'] = [];
        $this->page_title .= " Risk Category  | {$data['category']['title']}";
        $this->page("CategoryView", $data);
    }

    function draftRisk() {
        $data = $this->input->post();
        $this->risk->draft($data);
        //print_pre($data);
    }

    function fetchCategoryLevelOptions($category_id) {
        $category = $this->category->get($category_id);
        $level = 0;
        if ($category['level_1'] == 0 and $category['level_2'] == 0) {
            $level = 2;
        }
        if ($category['level_1'] != 0 and $category['level_2'] == 0) {
            $level = 3;
        }
        $categories = ($this->category->getChildLevels($category_id, $level));
        foreach ($categories as $key => $value) {
            echo "<option value='{$value['id']}'>" . $value['title'] . "</option>";
        }
    }

    function categoryAjax($id = 0) {
        $data['categories'] = $this->category->getChildLevels();
        $data['category'] = $this->category->get($id);
        $data['root'] = $this->category->getCategoryRoot($id);
        $data['risks'] = $this->category->getRisks($id);
        $this->ajax("CategoryView", $data);
    }

    function categoryDelete($id = 0, $confirmed = false) {
        if (!$confirmed) {
            $data['category'] = $this->category->get($id);
            $this->modal("categoryConfirmDelete", $data);
        } else {
            $_record = $this->category->get($id);
            $this->activityTrail->add(array(
                "module" => "risk",
                "table" => $this->category->table,
                "record" => $_record['id'],
                "title" => "Risk Category Deleted",
                "message" => "A risk category <strong>{$_record['title']}</strong> has been deleted",
            ));
            $this->category->delete($id);
            redirect("Risk/category/?message=Category Deleted");
        }
    }

    function categoryPublish() {
        $data = $this->category->get($id);
        $data['published'] = 1;
        $this->category->edit($data);
        redirect("Risk/category/{$data['id']}?message=changes saved");
    }

    function categoryPost() {
        $data = $this->input->post();
        if (isset($data['id'])) {
            $_record = $this->category->get($data['id']);
            if ($_record['draft'] != 0) {
                $this->activityTrail->add(array(
                    "module" => "risk",
                    "table" => $this->category->table,
                    "record" => $_record['id'],
                    "title" => "New Risk Category",
                    "message" => "A new risk category  <strong>{$data['title']}</strong> has been created",
                    "link" => "Risk/category/{$_record['id']}"
                ));
                // edit Message 
            } else {
                $this->activityTrail->add(array(
                    "module" => "risk",
                    "table" => $this->category->table,
                    "record" => $_record['id'],
                    "title" => "Risk Category Edited",
                    "message" => "A risk category <strong>{$data['title']}</strong> has been edited",
                    "link" => "Risk/category/{$_record['id']}"
                ));
                // add message
            }
        }

        $this->category->edit($data);
        redirect("Risk/category/{$data['id']}?message=changes saved");
    }

    function categoryForm($id = 0, $parent_category = 0) {
        $me = $this->user->getMe();
        if ($id == 0) {
            $data['user'] = $me['user']['id'];
            $data['draft'] = $me['user']['id'];
            $data['published'] = 0;
            $level = $this->category->findCategoryLevel($parent_category);
            $parent = $this->category->get($parent_category);
            if ($level == 2) {
                $data['level_1'] = $parent['level_1'];
                $data['level_2'] = $parent['id'];
            }
            if ($level == 1) {
                $data['level_1'] = $parent['id'];
            }
            $final_data = [];
            foreach ($data as $key => $value) {
                if ($value) {
                    $final_data[$key] = $value;
                }
            }
            $new = $this->category->add($final_data);
            redirect("Risk/categoryForm/{$new['id']}");
        }
        $data['categories'] = $this->category->getAll();
        $data['category'] = $this->category->get($id);

        $this->modal("categoryForm", $data);
    }

    function fetchSubCategory($parent_id) {
        $category = $this->category->get($parent_id);
        $level = 0;
        if ($category['level_1'] == 0 and $category['level_2'] == 0) {
            $level = 2;
        }
        if ($category['level_1'] != 0 and $category['level_2'] == 0) {
            $level = 3;
        }
        $categories = ($this->category->getChildLevels($parent_id, $level));
        $html = NULL;
        foreach ($categories as $value) {
            $icon = ($value['level_2'] == 0) ? "<i class=\"fa fa-chevron-right\"></i>" : "<i class=\"\"></i>";
            $html .= "<li><a href=\"" . base_url("index.php/Risk/fetchSubCategory/{$value['id']}") . " \"  onclick=\"openCategory(this); return false;\" class=\"ajax_tree\"  data-id=\"{$value['id']}\" data-target=\"level_{$value['id']}\">{$icon}</a>
                            <a href=\"" . base_url("index.php/Risk/categoryAjax/{$value['id']}") . "\" data-target=\"categoryView\" " . AJAX_LINK . " >{$value['title']}</a>
                            <ul class=\"category_sub_level\" id=\"level_{$value['id']}\"></ul>
                        </li>";
        }
        echo $html;
    }

    /* CATEGORY VIEW */

// == control category == //

    function controlCateogoryForm($id = 0) {
        $data['message'] = $this->input->get("message");
        if ($id == 0) {
            $data['control_category'] = $this->controlCategory->fields;
            foreach ($data['control_category'] as $key => $value) {
                $data['control_category'][$key] = NULL;
            }
        } else {
            $data['control_category'] = $this->controlCategory->get($id);
        }
        $data['control_categories'] = $this->controlCategory->getAll();
        $this->modal("controlCategoryForm", $data);
    }

    function controlCategoryDelete($id = 0, $confirmed = false) {
        if ($confirmed) {
            $_record = $this->controlCategory->get($id);
            $this->activityTrail->add(array(
                "module" => "risk",
                "table" => $this->risk->table,
                "record" => $_record['id'],
                "title" => "Deleted Control Category ",
                "message" => "A control category  <strong>{$_record['title']}</strong> has been deleted",
            ));
            $this->controlCategory->delete($id);
            redirect("Risk/controlCateogoryForm?message=Control Category <strong>{$_record['title']}</strong> has been deleted successfully");
        } else {
            $data['control_category'] = $this->controlCategory->get($id);
            $this->modal("controlCategoryDelete", $data);
        }
    }

    function controlCategoryPost() {
        $data = $this->input->post();
        if ($data['id']) {
            $new = $data;
            $this->controlCategory->edit($data);
            $_record = $this->controlCategory->get($data['id']);
            $this->activityTrail->add(array(
                "module" => "risk",
                "table" => $this->risk->table,
                "record" => $_record['id'],
                "title" => "Edited Control Category ",
                "message" => "A control category  <strong>{$_record['title']}</strong> has been edited",
                "link" => "Risk/controlCategory/{$_record['id']}"
            ));
        } else {
            $new = $this->controlCategory->add($data);
            $_record = $new;
            $this->activityTrail->add(array(
                "module" => "risk",
                "table" => $this->risk->table,
                "record" => $_record['id'],
                "title" => "Edited Control Category ",
                "message" => "A control category  <strong>{$_record['title']}</strong> has been edited",
                "link" => "Risk/controlCategory/{$_record['id']}"
            ));
        }
        redirect("Risk/controlCateogoryForm?message=changes saved");
    }

    function controlCategory($id) {
        
    }

    /* START RISKS */

    function risk($id = 0) {
        $data['risk'] = $this->risk->getRisk($id);
        if ($data['risk']) {
            $this->page_title .= " {$data['risk']['title']}";
            /////// Alex's Audit Code //////////////
            $riskId = $data['risk']['id'];
            $sql = "SELECT * FROM `g_bridge` WHERE `table_2` LIKE 'risk' AND `record_2` = $riskId";
            $issues = $this->db->query($sql)->result_array();
            foreach ($issues as $key => $value) {
                $data['riskIssues'][] = $this->issue->getIssueDetail($value['record_1']);
            }
            /////////
            $this->page("RiskView", $data);
        } else {
            redirect("Risk/?message=The risk has been deleted");
        }
    }

    function searchRisksInCategoryOptions($category_id) {
        $data = $this->category->getAllRisks($category_id);
        foreach ($data as $key => $array) {
            foreach ($array as $key => $value) {
                echo "<option value='{$value['id']}'>{$value['title']}</option>";
            }
        }
    }

    ///////////////Alex Code On Audit /////////////////

    public function searchRisksInCategoryOptionsAudit($issue, $category_id) {
        $data['approved'] = $this->category->getAllApprovedRisks($category_id);
        $data['proposed'] = $this->category->getAllProposedRisks($category_id);
        $data['issue'] = $this->issue->get($issue);
        $data['risks'] = jsonToArray($data['issue']['risk_associated']);
        foreach ($data['proposed'] as $key => $array) {
            echo "<optgroup label='Risk Proposed'>";
            foreach ($array as $key => $value) {
                $pc_list1[] = $value;
            }
            echo $this->searchSelectedRisksInAudit($pc_list1, $data['risks']);
            echo "</optgroup>";
        }
        foreach ($data['approved'] as $key => $array) {
            echo "<optgroup label='Approved Risks'>";
            foreach ($array as $key => $value) {
//                print_pre($value);
                $pc_list2[] = $value;
            }
            echo $this->searchSelectedRisksInAudit($pc_list2, $data['risks']);
            echo "</optgroup>";
        }
    }

    public function searchSelectedRisksInAudit($pc_list101, $risks) {
        foreach ($pc_list101 as $key => $pc_list) {
            if (in_array($pc_list['id'], $risks)) {
                echo "<option selected value='{$pc_list['id']}'>{$pc_list['title']}</option>";
            } else {
                echo "<option value='{$pc_list['id']}'>{$pc_list['title']}</option>";
            }
        }
    }

    function riskIssue() {
        $data['issues'] = $this->issue->getIssuesPublishedToBoardReport();
        foreach ($data['issues'] as $key => $value) {
            $issueId = $value['id'];
            $sql = "SELECT * FROM `g_bridge` WHERE `table_1` LIKE 'issue' AND `record_1` = $issueId";
            $risks = $this->db->query($sql)->result_array();
            foreach ($risks as $label => $value) {
                $data[$key]['issue'][$label]['riskIssues'][] = $this->risk->get($value['record_2']);
            }
        }
        print_pre($data);
        exit;
        $this->page("riskIssue", $data);
    }

    function selectRiskstoIssues($id) {
        $data['risks'] = $this->risk->getAll();
        $data['issue'] = $this->issue->get($id);
        $sql = "SELECT * FROM `g_bridge` WHERE `table_1` LIKE 'issue' AND `record_1` = $id";
        $risks = $this->db->query($sql)->result_array();
        foreach ($risks as $key => $value) {
            $data['selectedRisks'][] = $value['record_2'];
        }
        $this->modal("SelectRisks", $data);
    }

    function postSelectedRisks() {
        $data = $this->input->post();
        $me = $this->user->getMe();
        $data['user'] = $me['user']['id'];
        $result = $this->issue->postRiskIssue($data);
        if ($result) {
            $message = "Changes saved";
            redirect('Risk/RiskIssue?message=' . $message);
        }
    }

    ////////////////////


    function riskReport() {
        $data['risks'] = $this->risk->getRiskReportData();
        //print_pre($data);
        $this->page_title .= " Risk Report";
        $this->page("riskReportView", $data);
    }

    function riskApprove($id = 0, $approve = 'pending') {
        $data['id'] = $id;
        $data['approved'] = $approve;
        //$data['status'] = "Open";
        $this->risk->approve($id, $approve);
        $this->notification->risk_approved($data['id']);
        redirect("Risk/risk/$id?The Risk has been Approved");
    }

    function riskActivate($id = 0, $status = false) {
        $options = array("Active", "Inactive");
        $_record = $this->risk->get($id);
        if (in_array($status, $options)) {

            $this->activityTrail->add(array(
                "module" => "risk",
                "table" => $this->risk->table,
                "record" => $_record['id'],
                "title" => "Risk " . (($status == 'Active') ? "Activated" : "Deactivated"),
                "message" => "A risk <strong>{$_record['title']}</strong> has been " . (($status == 'Active') ? "Activated" : "Deactivated"),
                "link" => "Risk/risk/{$_record['id']}"
            ));

            $data['id'] = $id;
            $data['status'] = $status;
            $this->risk->edit($data);
            $this->notification->risk_activation($data['id']);
        }
        redirect("Risk/risk/$id?message=changes saved");
    }

    function riskStatusEdit($risk_id) {
        $data['risk'] = $this->risk->get($risk_id);
        $this->modal("riskStatusEdit", $data);
    }

    function riskDelete($id = 0, $confirmed = false) {
        if (!$confirmed) {
            $data['risk'] = $this->risk->get($id);
            $this->modal("riskConfirmDelete", $data);
        } else {
            $_record = $this->risk->get($id);
            $this->activityTrail->add(array(
                "module" => "risk",
                "table" => $this->risk->table,
                "record" => $_record['id'],
                "title" => "Risk Deleted",
                "message" => "A risk <strong>{$_record['title']}</strong> has been deleted",
            ));
            if ($_record['draft'] != 0) {
                $message = "Risk Draft Deleted";
            } else {
                $message = "Risk Deleted";
            }

            $this->risk->delete($id);
            redirect("Risk/?message=$message");
        }
    }

    function riskDeleteAjax($id = 0) {
        $data['risk'] = $this->risk->get($id);
        $this->modal("riskDeleteAjax", $data);
    }

    function riskCategorySelect($risk_id) {
        $data['all_categories'] = $this->category->getAll();

        $categories = [];

        foreach ($data['all_categories'] as $key => $value) {
            if ($value['level_2'] == 0 and $value['level_1'] == 0) {
                $categories[$value['id']] = $value;
                $categories[$value['id']]['sub_categories'] = [];
                continue;
            }
        }
        $data['categories'] = $categories;
        $data['risk'] = $this->risk->get($risk_id);
        $this->modal("riskCategorySelect", $data);
    }

    function selectRiskCategory($risk, $category) {
        $data['id'] = $risk;
        $data['category'] = $category;
        ($this->risk->draft($data));
        $this->riskForm($risk);
    }

    function riskForm($id = 0, $reposiroty = 0, $environment = 0) {
        if ($id == 0) {
            $data['repository'] = $reposiroty;
            $data['environment'] = $environment;
            $data['draft'] = $this->user->getMyId();
            $data['status'] = "Open";
            $data['owner'] = $data['draft'];

            $new = $this->risk->add($data);
            redirect("Risk/riskForm/{$new['id']}");
        }
        $data['risk'] = $this->risk->get($id);
        $data['environments'] = $this->environment->getSortedEnvironments();
        $data['categories'] = $this->category->getChildLevels(0);
        $data['all_categories'] = $this->category->getAll();

        $categories = [];

        foreach ($data['all_categories'] as $key => $value) {
            if ($value['level_2'] == 0 and $value['level_1'] == 0) {
                $categories[$value['id']] = $value;
                $categories[$value['id']]['sub_categories'] = [];
                continue;
            }
        }
        foreach ($categories as $label => $category) {
            foreach ($data['all_categories'] as $key => $value) {
                if ($value['level_1'] == $label and $value['level_2'] == 0) {
                    $categories[$label]['sub_categories'][$value['id']] = $value;
                    $categories[$label]['sub_categories'][$value['id']]['sub_categories'] = [];
                }
            }
        }

        foreach ($categories as $label => $category) {
            foreach ($category['sub_categories'] as $key => $value) {
                foreach ($data['all_categories'] as $_key => $_value) {
                    if ($_value['level_1'] != 0 and $_value['level_2'] != 0 and $_value['level_2'] == $key) {
                        $categories[$label]['sub_categories'][$key]['sub_categories'][] = $_value;
                    }
                }
            }
        }

        $data['sub_categories'] = $categories;
        $data['kra'] = $this->repository->getRepository($data['risk']['repository']);
        $environment_id = isset($data['kra']['environment']) ? $data['kra']['environment'] : 0;
        $data['environment'] = $this->environment->get($environment_id);
        $reporitory = $this->repository->getAll();
        foreach ($reporitory as $key => $value) {
            if (!isset($data['repository'][$value['source']])) {
                $data['repository'][$value['source']] = [];
            }
            $data['repository'][$value['source']][] = $value;
        }
        $data['risk_owners'] = $this->user->getRiskOwners();
        $data['category'] = $this->category->get($data['risk']['category']);
        $this->modal("riskForm", $data);
    }

    function riskUniqueRefCode($ref_code, $risk) {
        echo $this->risk->riskUniqueRefCode($ref_code, $risk) ? "yes" : "no";
    }

    function riskPost() {
        $data = $this->input->post();


        $data['status'] = "Open";
        if (isset($data['id'])) {
            $_record = $this->risk->get($data['id']);
            if ($_record['draft'] != 0) {
                $this->activityTrail->add(array(
                    "module" => "risk",
                    "table" => $this->risk->table,
                    "record" => $_record['id'],
                    "title" => "New Risk",
                    "message" => "A new risk  has been created <strong>{$_record['title']}</strong>",
                    "link" => "Risk/risk/{$_record['id']}"
                ));
                // edit Message 
            } else {
                $this->activityTrail->add(array(
                    "module" => "risk",
                    "table" => $this->risk->table,
                    "record" => $_record['id'],
                    "title" => "Risk  Edited",
                    "message" => "A risk  <strong>{$_record['title']}</strong> has been edited",
                    "link" => "Risk/risk/{$_record['id']}"
                ));
                // add message
            }
        }

        $this->risk->edit($data);

        redirect("Risk/risk/{$data['id']}?message=changes saved");
    }

    function riskFilter() {
        $filters = $this->input->post();
        $risks = $this->risk->riskData();
//        print_pre($risks);
//        exit;
        $results = [];
        foreach ($risks as $key => $value) {
            $flag = false;
            if (isset($filters['gross_risk'])) {
                if (in_array($value['gross_risk'], $filters['gross_risk'])) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            } else {
                false;
            }
            if (isset($filters['control_ratings'])) {
                if (in_array($value['control_ratings'], $filters['control_ratings'])) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            } else {
                false;
            }
            if (isset($filters['net_risk'])) {
                if (in_array($value['net_risk'], $filters['net_risk'])) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            } else {
                false;
            }
            if (isset($filters['risk_sources'])) {
                if (in_array($value['repository']['source'], $filters['risk_sources'])) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            } else {
                false;
            }
            if (isset($filters['categories'])) {
                if (in_array($value['category'], $filters['categories'])) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            } else {
                false;
            }
            if ($flag) {
                $results[] = $value;
            }
            if (count($filters) == 0) {
                $results[] = $value;
            }
        }
        $data['risks'] = $results;
        $this->ajax("riskRepost", $data);
    }

    function riskPropose($category = 0) {
        $data['category'] = $this->category->get($category);
        $this->modal("riskPropose", $data);
    }

    function riskProposeAudit($audit = NULL, $issue = Null, $category = 0) {
        $data['category'] = $this->category->get($category);
        $data['issue'] = $issue;
        $data['audit'] = $audit;
        $this->modal("riskProposeAudit", $data);
    }

    function riskProposePost() {
        $data = $this->input->post();
        $data['repository'] = 1;
        $new = $this->risk->add($data);
        $new['approved'] = 'Proposed';
        $this->risk->edit($new);
        echo $new['id'];
        //"<option value='{$new['id']}'>Proposed : {$new['title']}</option>";
        // echo $new['id'];
    }

    function riskProposeAuditPost() {
        $data = $this->input->post();
        $data['repository'] = 1;
        $new = $this->risk->add($data);
        $new['approved'] = 'Proposed';
        $this->risk->edit($new);
        redirect('Audit/issueForm/' . $data['issue'] . '/' . $data['audit']);
    }

    /* END RISKS */
    /* RISK ANALYSIS  */

    function analysis($id = 0) {
        $data['analysis'] = $this->analysis->get($id);
        $this->modal("analysisPreview", $data);
    }

    function riskAnalysis($risk_id = 0) {
        $data['risk_analysis'] = $this->analysis->getRisk($risk_id);
        $this->modal("riskAnalysisPreview", $data);
    }

    function analysisGross($risk_id = 0) {
        $data['risk'] = $risk_id;
        $new = $this->analysis->getLastRiskAnalysis($risk_id);

//        print_pre($array)
        $new['id'] = null;
        $dataArray['analyse'] = $new;

        $this->modal("grossRiskAnalysis", $dataArray);
    }

    function analysisControls($risk_id = 0) {
        $data['risk'] = $risk_id;
        $new = $this->analysis->getLastRiskAnalysis($risk_id);
        $new['id'] = null;
        $dataArray['analyse'] = $new;



        $this->modal("controlsRiskAnalysis", $dataArray);
    }

    function evaluations() {
        $this->page("evaluations");
    }

    function analysisPost() {
        $data = $this->input->post();
        if (isset($data['risk'])) {
            $_record = $this->risk->get($data['risk']);
            $this->activityTrail->add(array(
                "module" => "risk",
                "table" => $this->risk->table,
                "record" => $_record['id'],
                "title" => "New Risk Analysis",
                "message" => "Risk  <strong>{$_record['title']} been analysed </strong>",
                "link" => "Risk/risk/{$_record['id']}"
            ));
            // edit Message 
        }

        $this->analysis->add($data);
        redirect("Risk/risk/{$data['risk']}?message=changes saved");
    }

    function analysisDelete($id = 0, $confirmed = false) {
        $data['analysis'] = $this->analysis->get($id);
        if (!$confirmed) {
            $this->modal("analysisConfirmDelete", $data);
        } else {
            if (isset($data['analysis']['risk'])) {
                $_record = $this->risk->get($data['analysis']['risk']);
                $this->activityTrail->add(array(
                    "module" => "risk",
                    "table" => $this->risk->table,
                    "record" => $_record['id'],
                    "title" => "Deleted Risk Analysis",
                    "message" => "An analysis made on risk <strong>{$_record['title']} been deleted </strong>",
                    "link" => "Risk/risk/{$_record['id']}"
                ));
                // edit Message 
            }

            $this->analysis->delete($id);
            redirect("Risk/risk/{$data['anaysis']['risk']}?message=Analysis Rating Deleted");
        }
    }

    function analysisForm($id = 0, $risk = 0) {
        $data['analysis'] = $this->analysis->get($id);
        if ($id == 0) {
            $data = $this->analysis->getLastRiskAnalysis();
            $data['draft'] = $this->user->getMyId();
            $data['user'] = $data['draft'];

            $this->analysis->add($data);
        }
        $this->modal("analysisForm", $data);
    }

    function grossRisk($risk_id) {
        $data = $this->analysis->getLastRiskAnalysis();
        $data['draft'] = $this->user->getMyId();
        $data['user'] = $data['draft'];
        $this->analysis->add($data);
        $this->modal("analysisGossRiskForm", $data);
    }

    function controlRatingsForm($risk_id) {
        $data = $this->analysis->getLastRiskAnalysis();
        $data['draft'] = $this->user->getMyId();
        $data['user'] = $data['draft'];
        $this->analysis->add($data);
        $this->modal("analysisControlRatingsForm", $data);
    }

    function analysisApprove($id = 0) {
        $analysis = $this->analysis->get($id);
        $data['id'] = $id;
        $data['approved'] = 'approved';
        $this->analysis->edit($data);
        redirect("Risk/risk/{$analysis['risk']}?The Risk Analysis has been Approved");
    }

    // END RISK ANALYSIS  */
    // START CONTROLS  */

    function allControls() {
        $data['controls'] = $this->control->getAll();
        $this->page_title .= " Controls ";
        $this->page("RiskControlsView", $data, array(), array(), array());
    }

    function control($id = false) {

        if (!$id) {
            redirect("Risk/?message=control does not exist");
        }
        $data['control'] = $this->control->getControl($id);


        $this->page_title .= "<a href='" . base_url("index.php/Risk/risk/{$data['control']['control']['risk']['id']}") . "'> {$data['control']['control']['risk']['title']} </a> | {$data['control']['control']['title']}";
        $this->page("ControlView", $data);
    }

    function controlForm($id = 0, $risk = 0) {
        $data['control'] = $this->control->get($id);
        $data['owners'] = $this->user->getUnitOwners();
        $data['control_category'] = $this->controlCategory->getAll();
        $data['categories'] = []; // $this->control_category->getAll();
        if ($id == 0) {
            $data['draft'] = $this->user->getMyId();
            $data['risk'] = $risk;
            $data['user'] = $data['draft'];
            $data['owner'] = $data['draft'];
            $new = $this->control->add($data);
            redirect("Risk/controlForm/{$new['id']}");
        }
        $this->modal("controlForm", $data);
    }

    function controlApprove($id, $status) {
        $options = array('approved', 'rejected');
        if (in_array($status, $options)) {
            $control = $this->control->get($id);
            $data = $control;
            $data['approval_status'] = $status;
            $this->control->edit($data);
            $_record = $this->control->get($id);
            $this->activityTrail->add(array(
                "module" => "risk",
                "table" => $this->control->table,
                "record" => $_record['id'],
                "title" => "Control " . ucwords($status),
                "message" => "The control <strong>{$_record['title']}</strong> has been " . ucwords($status),
                "link" => "Risk/control/{$_record['id']}"
            ));
            $this->notification->control_approved($id);
        }
        redirect("Risk/control/{$control['id']}?message=The Control has been Approved");
    }

    function controlComplete($id) {
        $control = $this->control->get($id);
        $data = $control;
        $data['status'] = 'complete';

        $this->control->edit($data);
        redirect("Risk/control/{$control['id']}?message=changes saved");
    }

    function controlSetInPlace($id) {
        $control = $this->control->get($id);
        $data = $control;
        $data['type'] = 'in place';
        $data['approval_status'] = (am_user_type(array(5))) ? "approved" : "pending";
        $this->control->edit($data);
        $_record = $this->control->get($id);
        $this->activityTrail->add(array(
            "module" => "risk",
            "table" => $this->control->table,
            "record" => $_record['id'],
            "title" => "Control Set In Place",
            "message" => "The control <strong>{$_record['title']}</strong> has been  Set In Place",
            "link" => "Risk/control/{$_record['id']}"
        ));
        $this->notification->control_setInPlace($id);
        redirect("Risk/control/{$control['id']}?message=The Control has been set in place");
    }

    function controlDelete($id = false, $confirmed = false) {
        $control = $this->control->get($id);
        if ($confirmed === false) {
            $this->modal("controlConfirmDelete", array("control" => $control));
        } else {
            $_record = $this->control->get($id);
            $this->activityTrail->add(array(
                "module" => "risk",
                "table" => $this->control->table,
                "record" => $_record['id'],
                "title" => "Control Deleted",
                "message" => "The control <strong>{$_record['title']}</strong> has been Deleted",
            ));
            $this->control->delete($control['id']);
            redirect("Risk/risk/{$control['risk']}?message=Control Deleted");
        }
    }

    function controlPost() {
        $data = $this->input->post();
        $_record = $this->control->get($data['id']);

        $this->control->edit($data);

        if (isset($data['id'])) {
            if ($_record['draft'] != 0) {
                $_record = $this->control->get($data['id']);
                $type = am_user_type(array(5)) ? "Created And Approved" : "Proposed";
                $this->activityTrail->add(array(
                    "module" => "risk",
                    "table" => $this->control->table,
                    "record" => $_record['id'],
                    "title" => "New Control " . $type,
                    "message" => "A control has been  <strong>{$_record['title']}</strong> {$type}",
                    "link" => "Risk/control/{$_record['id']}"
                ));
                // edit Message 
            } else {
                $_record = $this->control->get($data['id']);
                $this->activityTrail->add(array(
                    "module" => "risk",
                    "table" => $this->control->table,
                    "record" => $_record['id'],
                    "title" => "Control Edited",
                    "message" => "A control <strong>{$_record['title']}</strong> has been edited",
                    "link" => "Risk/control/{$_record['id']}"
                ));
                // add message
            }
        }
        $control = $_record;
        $this->notification->control_propose($data['id']);
        redirect("Risk/control/{$control['id']}?message=changes saved");
    }

    /* END CONTROLS ACTIVITY */
    /* START CONTROLS ACTIVITY */

    function allActivites() {
        $data['activities'] = $this->activity->getAll();
        $this->page_title .= " Control Activities";
        $this->page("ControlActivityView", $data);
    }

    function activity($id = 0) {
        $data['activity'] = $this->activity->get($id);
        $data['activity']['owner'] = $this->user->getUser($data['activity']['owner']);
        $data['control'] = $this->control->get($data['activity']['control']);
        $data['risk'] = $this->risk->get($data['control']['risk']);
        $data['activity']['action_by'] = $this->user->get_actionBy($data['activity']['action_by']);
        $this->modal("activityView", $data);
    }

    function activityForm($id = 0, $control = 0) {
        $data['activity'] = $this->activity->get($id);
        $data['owners'] = $this->user->getUnitOwners();
        if ($id == 0) {
            $data['control'] = $control;
            $data['draft'] = $this->user->getMyId();
            $data['user'] = $data['draft'];
            $new = $this->activity->add($data);
            redirect("Risk/activityForm/" . $new['id']);
        }
        $this->modal("activityForm", $data);
    }

    function activityDelete($id = 0, $confirmed = false) {
        $data['activity'] = $this->activity->get($id);
        if ($confirmed === false) {
            $this->modal("confirmDeleteControlActivity", $data);
        } else {
            $_record = $this->activity->get($id);
            $this->activityTrail->add(array(
                "module" => "risk",
                "table" => $this->activity->table,
                "record" => $_record['id'],
                "title" => "Control Activity Deleted",
                "message" => "The control activity  <strong>{$_record['title']}</strong> has been deleted",
            ));


            $this->activity->delete($id);
            redirect("Risk/control/{$data['activity']['control']}?message=Control Activity Deleted");
        }
    }

    function activityApprove($id = 0, $status = false) {
        $activity = $this->activity->get($id);
        $control = $this->control->get($activity['control']);
        $data = $activity;
        $data['review_status'] = $status;
        $this->activity->edit($data);

        $this->notification->activity_approved($id);
        redirect("Risk/activity/{$activity['id']}?message=The Control Activity has been Approved");
    }

    function activityComplete($id) {
        $control = $this->control->get($id);
        $data = $control;
        $data['status'] = 'complete';
        $this->activity->edit($data);
        $_record = $this->activity->get($id);
        $this->activityTrail->add(array(
            "module" => "risk",
            "table" => $this->activity->table,
            "record" => $_record['id'],
            "title" => "Control Activity Complete",
            "message" => "The control activity  <strong>{$_record['title']}</strong> has been Completed",
            "link" => "Risk/risk/{$_record['id']}"
        ));
        redirect("Risk/activity/{$_record['id']}?message=Control Activity Complete");
    }

    function activityPost() {
        $data = $this->input->post();
        $_record = $this->activity->get($data['id']);
        $this->activity->edit($data);
        if ($_record['draft'] != 0) {
            if (!am_user_type(array(5))) {
                $this->notification->activity_approval($_record['id']);
            } else {
                $this->notification->activity_approved($_record['id']);
            }
            $_record = $this->activity->get($data['id']);
            $this->activityTrail->add(array(
                "module" => "risk",
                "table" => $this->activity->table,
                "record" => $_record['id'],
                "title" => "Control Activity Created",
                "message" => "A new control activity <strong>{$_record['name']}</strong> has been created",
                "link" => "Risk/control/{$_record['control']}"
            ));
            // edit Message 
        } else {
            $_record = $this->activity->get($data['id']);
            $this->activityTrail->add(array(
                "module" => "risk",
                "table" => $this->activity->table,
                "record" => $_record['id'],
                "title" => "Control Activity  Edited",
                "message" => "The control control activity <strong>{$_record['name']}</strong> has been edited",
                "link" => "Risk/control/{$_record['control']}"
            ));
            // add message
        }
        $activity = $this->activity->get($data['id']);



        redirect("Risk/control/{$activity['control']}?message=changes saved");
    }

    /* END CONTROLS ACTIVITY */

    /* START EVALUATION */

    function evaluation($id = 0) {
        $data['evaluation'] = $this->evaluation->get($id);
        // print_pre($data);
        $data['risk'] = $this->risk->get($data['evaluation']['risk']);
        $this->modal("evaluationView", $data);
    }

    function evaluationPost() {
        $ev = $this->evaluation->get($this->input->post('id'));
        $data = $this->input->post();
        $data['id'] = NULL;
        $new = $this->evaluation->add($data);
        $dataArray['id'] = $data['risk'];
        $dataArray['evaluate'] = 'no';
        $this->risk->edit($dataArray);
        $this->notification->risk_evaluate($data['risk']);
        // print_pre($data);
        $_record = $this->risk->get($data['risk']);
        $this->activityTrail->add(array(
            "module" => "risk",
            "table" => $this->risk->table,
            "record" => $_record['id'],
            "title" => "New Risk Evaluation",
            "message" => "The risk  <strong>{$_record['title']}</strong> has been evaluated",
            "link" => "Risk/risk/{$_record['id']}"
        ));

        redirect("Risk/risk/{$data['risk']}?message=changes saved");
    }

    function evaluationApprove($id = 0, $approved = 'approved') {
        $ev = $this->evaluation->get($id);
        $data['id'] = $id;
        $data['approved'] = $approved;

        $_record = $this->risk->get($data['risk']);
        $this->activityTrail->add(array(
            "module" => "risk",
            "table" => $this->risk->table,
            "record" => $_record['id'],
            "title" => ucwords($approved) . " Risk Evaluation",
            "message" => "An evaluation on risk  <strong>{$_record['title']}</strong> has been " . ucwords($approved),
            "link" => "Risk/risk/{$_record['id']}",
        ));
        $this->evaluation->edit($data);
        redirect("Risk/risk/{$ev['risk']}?message=changes saved");
    }

    function evaluationDelete($id = 0, $confirmed = 8) {
        $evaluation = $this->evaluation->get($id);
        if ($confirmed) {
            $data['evaluation'] = $evaluation;
            $this->modal("evaluationConfirmDelete", $data);
        } else {

            $_record = $this->risk->get($data['risk']);
            $this->activityTrail->add(array(
                "module" => "risk",
                "table" => $this->risk->table,
                "record" => $_record['id'],
                "title" => "Deleted Risk Evaluation",
                "message" => "An evaluation on risk  <strong>{$_record['title']}</strong> has been deleted",
                "link" => "Risk/risk/{$_record['id']}"
            ));

            $this->evaluation->delete($id);
            redirect("Risk/risk/{$evaluation['risk']}?message=Risk Evaluation Deleted");
        }
    }

    function evaluationForm($risk = 0) {
        $data = $this->evaluation->fields;
        $last = $this->evaluation->lastRiskEvaluation($risk);
        //print_pre($last);
        $dataArray['first'] = false;
        if (count($last) == 0) {
            foreach ($data as $key => $value) {
                $data[$key] = 1;
            }
            $data['id'] = 0;
            $data['appetite_measure'] = "";
            $data['key_risk_indicator'] = "";
            $data['si_units'] = "";
            $data['risk'] = $risk;
        }
        if (count($last) > 0) {
            $dataArray['evaluation'] = $last;
        } else {
            $dataArray['first'] = true;
            $dataArray['evaluation'] = $data;
        }
        $dataArray['risk'] = $this->risk->get($dataArray['evaluation']['risk']);

        $this->modal("evaluationForm", $dataArray);
    }

    function riskEvaluations($risk_id) {
        $data['evaluations'] = $this->evaluation->getRisk($risk_id);
        $this->modal("evaluationRiskView", $data);
    }

    /* END EVALUATION */

    function riskdetails($id) {// OPEN PAGE
//$this->page("RiskDetailsView", array(), array("chart.min", "chartjs.init", "d3.min", "c3.min"), array());
    }

    function riskregister($id = 0) {// OPEN PAGE
        $this->register($id);
    }

    function riskcategories() {// OPEN PAGE
        redirect("Risk/category");
        $data['riskCategories'] = $this->riskCategory->getAll();
        $data['riskCategoryTree'] = $this->tree();
        $this->page("RiskCategoriesView", $data, array('jstree.min'), array());
    }

    function riskcontrols() {// OPEN PAGE
        redirect("Risk/allControls/");
        $data['controls'] = $this->control->getAll();
        $this->page("RiskControlsView", $data, array(), array(), array());
    }

    function addControl() {
        $this->modal("AddControl");
    }

    function saveControl() {
        $data = $this->input->post();
        $this->control->edit($data);
        redirect("Risk/ControlsView?message=changes saved");
    }

    function controlactivity() {// OPEN PAGE
        redirect("Risk/allActivites");
    }

    function addCategory() {
        $data['riskCategories'] = $this->riskCategory->getAll();
        $this->modal("addCategory", $data);
    }

    function saveCategory() {
        $data = $this->input->post();
        $this->riskCategory->addCategory($data);
        redirect("Risk/riskcategories?message=changes saved");
    }

    function selectRisks() {
        $data['risks'] = $this->risk->getAll();
        $this->modal("selectRisk", $data);
    }

}
