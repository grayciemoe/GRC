<?php

class Account extends CI_Controller {

    public $page_title;

    function __construct() {
        parent::__construct();
        $this->page_title = "My Account";

        $this->load->model("Documents/UploadModel", "uploadModel");
        $this->load->model("Documents/DocumentsModel", "documentsModel");
        $this->load->model("Documents/CropModel", "cropModel");

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

        $this->load->model("IncidentManagement/IncidentActionsModel", "incidentActions");
        $this->load->model("IncidentManagement/IncidentCategoryModel", "incidentCategory");
        $this->load->model("IncidentManagement/IncidentCategoryModel", "category");
        $this->load->model("IncidentManagement/IncidentManagementModel", "incident");

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
        
        if (!$this->auth->checkLogin()) {
            redirect("Login/?message=Please login to proceed");
        }
    }

    function e404Hundler($filepath) {
        if (!file_exists("application/views/" . $filepath . ".php")) {
            $filename = "application/views/" . $filepath . ".php";
            /* echo "Error : File ('$filename') does not exist"; */ return false; // old code file put content removed
        } else {
            return true;
        }
    }

    function sql() {
        if (am_user_type()) {
            $data['results'] = [];
            $this->page("SQLView", $data);
        } else {
            redirect("");
        }
    }

    function build_table($array) {
        // start table
        $html = '<div class="table-responsive"><table class="table table-sm table-striped">';
        // header row
        $html .= '<tr>';
        $table = isset($array[0]) ? $array[0] : [];
        foreach ($table as $key => $value) {
            $html .= '<th>' . $key . '</th>';
        }
        $html .= '</tr>';

        // data rows
        foreach ($array as $key => $value) {
            $html .= '<tr>';
            foreach ($value as $key2 => $value2) {
                $html .= '<td>' . $value2 . '</td>';
            }
            $html .= '</tr>';
        }

        // finish table and return it

        $html .= '</table></div>';
        echo "(" . count($array) . ") Results Found;";
        return $html;
    }

    function sqlPost() {
        if (am_user_type()) {
            $query = $this->db->query($this->input->post("sql"));
            $data['results'] = ($query->result_array());
            //echo "Affected Rows " . $query->affected_rows();
            echo $this->build_table($data['results']);
        } else {
            redirect("");
        }



//$this->page("SQLView", $data);
    }

    function page($pageName = "", $pageData = array(), $scripts = array(), $stylesheets = array()) {

        $data['me'] = $this->user->getMe();
        $filename = "MyAccount/Pages/" . ucwords($pageName);
        if ($this->e404Hundler($filename)) {
//redirect("index.php/MyAccount");
        }
        $data['message'] = ($this->input->get("message")) ? "<div style='padding:7px'>" . ucwords($this->input->get("message")) . "</div>" : NULL;
        $data['KRAs'] = count($this->repository->getPending());
        $data['risks'] = count($this->risk->getInactive());
        $data['controls'] = count($this->control->getUnapprovedControls());
        $data['control_activity'] = 0; //  count($this->activity->getInactive());
        $data['obligations'] = 0; // count($this->obligation->getInactive());
        $data['breaches'] = count($this->breach->getInactive());
        $data['complies'] = count($this->comply->getInactive());
        $data['incidents'] = count($this->incident->getInactive());
        $data['data'] = $pageData;
        $data['page_title'] = $this->page_title;
        $data['me'] = $this->user->getMe();
        $data['stylesheets'] = $stylesheets;
        $data['scripts'] = $scripts;
        $this->load->view("Includes/HeadView", $data);
        $this->load->view("Includes/MainNavView", $data);
        $this->load->view("MyAccount/Includes/MyAccountHeaderView");
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
        $this->load->view("Includes/FooterView");
    }

    function form($formName = "", $data = array(), $scripts = array(), $stylesheets = array()) {
        $data['me'] = $this->user->getMe();
        $filename = "MyAccount/Forms/" . ucwords($formName);
        if ($this->e404Hundler($filename)) {
//redirect("index.php/MyAccount");
        }
        $data['message'] = ($this->input->get("message")) ? "<div style='padding:7px'>" . ucwords($this->input->get("message")) . "</div>" : NULL;
        $data['page_title'] = $this->page_title;
        $data['data'] = $data;
        $data['scripts'] = $scripts;
        $data['stylesheets'] = $stylesheets;
        $this->load->view("Includes/HeadView", $data);
        $this->load->view("Includes/MainNavView", $data);
        $this->load->view("MyAccount/Includes/MyAccountHeaderView");
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
        $this->load->view("Includes/FooterView");
    }

    function modal($modalName = "", $pageData = array(), $scripts = array(), $stylesheets = array()) {
//        if ($this->input->post("requestView") != "modal") {
//            redirect("Account/index/");
//        }
        $filename = "MyAccount/Modals/" . ucwords($modalName);
        if ($this->e404Hundler($filename)) {
//redirect("index.php/MyAccount");
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
        $filename = "MyAccount/Ajax/" . ucwords($fileName);
        if ($this->e404Hundler($filename)) {
//redirect("index.php/MyAccount");
        }
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
        $filename = "MyAccount/NotificationsPopup/$pageName";
        if ($this->e404Hundler($filename)) {
//redirect("index.php/MyAccount");
        }
        $data['data'] = $pageData;
        $data['me'] = $this->user->getMe();
        if ($this->e404Hundler($filename)) {
            $this->load->view($filename, $data);
        } else {
            echo "Error : ('$filename') File does not exit";
        }
    }

    function changePic($user_id = 0) {
        if ($user_id == 0) {
            $user_id = $this->user->getMyId();
        }
        $data['user'] = $this->user->get($user_id);
        $this->modal("changePicModal", $data);
    }

    function updateProfilePic() {
        $data = $this->input->post();
        $this->user->edit($data);
        $message = "?message=Profile Picture updated";
        $redirect = $data['id'] == $this->user->getMyId() ? "Account/settings$message" : "home/users/{$data['id']}$message";
        redirect($redirect);
    }

    function editMe() {
        $data = $this->input->post();
        $me = $this->user->getMe();
        $data['id'] = $me['user']['id'];
        $this->user->edit($data);
        $message = "?message=Changes Saved";
        redirect("Account/profile{$message}");
    }

    function changePassword() {
        $me = $this->user->getMe();
        $oldPassword = $this->input->post("oldPassword");
        $newPassword = $this->input->post("newPassword");
        $confirmPassword = $this->input->post("confirmPassword");
        $data['id'] = $me['user']['id'];
        $data['password'] = md5($oldPassword);
        if ($newPassword != $confirmPassword) {
            $message = "Passwords did not match";
            redirect("Account/profile/?message=$message");
        }
        if ($this->user->checkPassword($data)) {
            $data['password'] = md5($newPassword);
            $this->user->edit($data);
            $message = "Password Changed Successfully";
            redirect("Account/profile/?message=$message");
        } else {

            $message = "Incorrect Password";
            redirect("Account/profile/?message=$message");
        }
        redirect("Account/profile/");
    }

    function index() {
        $this->risk();
    }

    function risk() {
        $me = $this->user->getMe();
        $this->page_title .= " | Risks";
        $data['risks'] = $this->risk->getUserRisks($me['user']['id']);
        $this->page("MyRiskView", $data);
    }

    function compliance() {
        $me = $this->user->getMe();
        $this->page_title .= " | Compliance";

        $data['obligation'] = $this->obligation->getAllObligationsByUser($me['user']['id']);
        $this->page("MyComplianceView", $data);
    }

    function incidentManagement() {
        $me = $this->user->getMe();
        $this->page_title .= " | Incident Management";
        $data['incidents'] = $this->incident->getIncidentByUser($me['user']['id']);
        $this->page("MyIncidentManagementView", $data);
    }

    function incidentActions() {
        $me = $this->user->getMe();
        $data['incidentActions'] = $this->incidentActions->getIncidentActionsByOwner($me['user']['username']);
        $this->page("IncidentActionsView", $data);
    }

    function audit() {
        $this->page("MyAuditView");
    }

    function settings() {
        $message = $this->input->get();
        $this->page_title .= " | Settings";
        $this->page("SettingsView", $message);
    }

    function documents() {
        $data['files'] = $this->doc->sortDocuments($this->doc->getMyDocuments());
        $this->page_title .= " | Documents";
        $this->page("DocumentsView", $data);
    }

    function emailNotificationMessage($id) {
        $data['notification'] = $this->notification->get($id);
        $this->ajax("EmailNotificationMessage", $data);
    }

    function notifications() {
        $this->page_title .= " | Notifications";
        $data['my_notifications'] = $this->notification->getMe();
        $data['unread'] = $this->notification->countNewMessages();

//$data['notification'] = $this->notification->get($email);
        $this->page("NotificationsView", $data);
    }

    function messages() {
        $this->page_title .= " | Messages";
        $this->page("MessagesView");
    }

    function profile() {
        $me = $this->user->getMe();
        $this->page_title .= " | Profile";
        $this->page("ProfileView", $me);
    }

    function drafts() {
        $this->page_title .= " | Drafts";
        $this->page("DraftsView");
    }

}
