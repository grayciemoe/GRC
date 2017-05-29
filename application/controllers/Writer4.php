<?php

// require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
//
// use google\appengine\api\cloud_storage\CloudStorageTools;
//if ($_SERVER['HTTP_HOST'] == 'localhost') {
//    exit("Comment Line 3 to 5 in " . __FILE__);
//}
//if ($_SERVER['HTTP_HOST'] == 'localhost') {
//echo "APPPATH";
//exit;
date_default_timezone_set('Africa/Nairobi');
require_once APPPATH . 'third_party/PHPWord3/bootstrap.php';

//}else{
//    require_once 'http://localhost/code_phpword/application/third_party/PHPWord/bootstrap.php';
//    require_once 'http://52.30.190.90/PhpOffice/PHPWord/bootstrap.php';
//}




/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Writer4 extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model("Documents/UploadModel", "uploadModel");
        $this->load->model("Documents/DocumentsModel", "documentsModel");
        $this->load->model("Documents/CropModel", "cropModel");

        $this->load->model("Users/UserModel", "user");
        $this->load->model("Users/AuthModel", "auth");
        $this->load->model("Users/UserTypeModel", "userType");
        $this->load->model("Users/UserTypeActionsModel", "userTypeActions");

//        if (!$this->auth->checkLogin()) {
//            redirect("Login/?message=Please login to proceed");
//        }
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
        $this->load->model("Comments/CommentsModel", "comments");
    }

    function remote() {
        $this->load->view("DocView");
    }

    function index() {
// Creating the new document...
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
//        $phpWord = new PhpWord();
        /* Note: any element you append to a document must reside inside of a Section. */

// Adding an empty Section to the document...
        $section = $phpWord->addSection();
// Adding Text element to the Section having font styled by default...
        $section->addText(
                '"Learn from yesterday, live for today, hope for tomorrow. '
                . 'The important thing is not to stop questioning." '
                . '(Albert Einstein)'
        );

        /*
         * Note: it's possible to customize font style of the Text element you add in three ways:
         * - inline;
         * - using named font style (new font style object will be implicitly created);
         * - using explicitly created font style object.
         */
        // Adding Text element with font customized inline...
        $section->addText(
                '"Great achievement is usually born of great sacrifice, '
                . 'and is never the result of selfishness." '
                . '(Napoleon Hill)', array('name' => 'Tahoma', 'size' => 10)
        );

// Adding Text element with font customized using named font style...
        $fontStyleName = 'oneUserDefinedStyle';
        $phpWord->addFontStyle(
                $fontStyleName, array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true)
        );
        $section->addText(
                '"The greatest accomplishment is not in never falling, '
                . 'but in rising again after you fall." '
                . '(Vince Lombardi)', $fontStyleName
        );

// Adding Text element with font customized using explicitly created font style object...
        $fontStyle = new \PhpOffice\PhpWord\Style\Font();
        $fontStyle->setBold(true);
        $fontStyle->setName('Tahoma');
        $fontStyle->setSize(13);
        $myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');
        $myTextElement->setFontStyle($fontStyle);
//        print_pre($phpWord);
//        exit;
// Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('docs/helloWorld4.docx');

// Saving the document as ODF file...
//        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
//        $objWriter->save('docs/helloWorld1.odt');
// Saving the document as HTML file...
//        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
//        $objWriter->save('docs/helloWorld1.html');

        /* Note: we skip RTF, because it's not XML-based and requires a different example. */
        /* Note: we skip PDF, because "HTML-to-PDF" approach is used to create PDF documents. */
//        $this->load->view("ViewerView");
    }

    function templateCloneRow() {
        include_once APPPATH . 'third_party/PHPWord/samples/Sample_Header.php';

// Template processor instance creation
        echo date('H:i:s'), ' Creating new TemplateProcessor instance...', EOL;
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('docs/Sample_07_TemplateCloneRow.docx');

// Variables on different parts of document
        $templateProcessor->setValue('weekday', date('l'));            // On section/content
        $templateProcessor->setValue('time', date('H:i'));             // On footer
        $templateProcessor->setValue('serverName', realpath(__DIR__)); // On header
// Simple table
        $templateProcessor->cloneRow('rowValue', 10);

        $templateProcessor->setValue('rowValue#1', 'Sun');
        $templateProcessor->setValue('rowValue#2', 'Mercury');
        $templateProcessor->setValue('rowValue#3', 'Venus');
        $templateProcessor->setValue('rowValue#4', 'Earth');
        $templateProcessor->setValue('rowValue#5', 'Mars');
        $templateProcessor->setValue('rowValue#6', 'Jupiter');
        $templateProcessor->setValue('rowValue#7', 'Saturn');
        $templateProcessor->setValue('rowValue#8', 'Uranus');
        $templateProcessor->setValue('rowValue#9', 'Neptun');
        $templateProcessor->setValue('rowValue#10', 'Pluto');

        $templateProcessor->setValue('rowNumber#1', '1');
        $templateProcessor->setValue('rowNumber#2', '2');
        $templateProcessor->setValue('rowNumber#3', '3');
        $templateProcessor->setValue('rowNumber#4', '4');
        $templateProcessor->setValue('rowNumber#5', '5');
        $templateProcessor->setValue('rowNumber#6', '6');
        $templateProcessor->setValue('rowNumber#7', '7');
        $templateProcessor->setValue('rowNumber#8', '8');
        $templateProcessor->setValue('rowNumber#9', '9');
        $templateProcessor->setValue('rowNumber#10', '10');

// Table with a spanned cell
        $templateProcessor->cloneRow('userId', 3);

        $templateProcessor->setValue('userId#1', '1');
        $templateProcessor->setValue('userFirstName#1', 'James');
        $templateProcessor->setValue('userName#1', 'Taylor');
        $templateProcessor->setValue('userPhone#1', '+1 428 889 773');

        $templateProcessor->setValue('userId#2', '2');
        $templateProcessor->setValue('userFirstName#2', 'Robert');
        $templateProcessor->setValue('userName#2', 'Bell');
        $templateProcessor->setValue('userPhone#2', '+1 428 889 774');

        $templateProcessor->setValue('userId#3', '3');
        $templateProcessor->setValue('userFirstName#3', 'Michael');
        $templateProcessor->setValue('userName#3', 'Ray');
        $templateProcessor->setValue('userPhone#3', '+1 428 889 775');

        echo date('H:i:s'), ' Saving the result document...', EOL;
        $templateProcessor->saveAs('docs/TemplateCloneRow.docx');

        echo getEndingNotes(array('Word2007' => 'docx'));
        if (!CLI) {
            include_once APPPATH . 'third_party/PHPWord/samples/Sample_Footer.php';
        }
    }

    function templateCloneBlock() {
        include_once APPPATH . 'third_party/PHPWord/samples/Sample_Header.php';

// Template processor instance creation
        echo date('H:i:s'), ' Creating new TemplateProcessor instance...', EOL;
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('docs/Sample_23_TemplateBlock.docx');

// Will clone everything between ${tag} and ${/tag}, the number of times. By default, 1.
        $templateProcessor->cloneBlock('CLONEME', 3);

// Everything between ${tag} and ${/tag}, will be deleted/erased.
        $templateProcessor->deleteBlock('DELETEME');

        echo date('H:i:s'), ' Saving the result document...', EOL;
        $templateProcessor->saveAs('docs/SampleBlock.docx');

        echo getEndingNotes(array('Word2007' => 'docx'));
        if (!CLI) {
            include_once APPPATH . 'third_party/PHPWord/samples/Sample_Footer.php';
        }
    }

    function report_gen($id) {
        $data['audit'] = $this->audit->get($id);
        $data['environment'] = $this->environment->get($data['audit']['environment']);
        $data['auditor'] = $this->user->get($data['audit']['auditor']);
        $data['issues'] = $this->issue->getAllIssuesInAudit($id);
        $data['audit_area'] = $this->auditArea->get($data['audit']['audit_area']);
        $data['issues_count'] = count($data['issues']);
//        $data['comments'] = $this->comments->getComments('Audit', 'issue', 24, 0);
//        $data['action_plans'] = $this->action_plans->getActionPlanByIssue(4);
//        print_pre($data);
//        exit;

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('docs/Audit_Report_Template.docx');

        $templateProcessor->setValue('AUDITNAME', $data['audit']['audit_name']);
        $templateProcessor->setValue('auditdate', strftime("%b-%d-%Y", strtotime($data['audit']['audit_date'])));
        $templateProcessor->setValue('audit_type', $data['audit']['audit_type']);
        $templateProcessor->setValue('audit_by', $data['auditor']['names']);
        $templateProcessor->setValue('business_unit', $data['environment']['name']);

        $templateProcessor->cloneRow('issuetitle', $data['issues_count']);
//        $templateProcessor->cloneBlock('CLONEBLOCK', $data['issues_count']);
//
//
        $x = 0;
        foreach ($data['issues'] as $key => $value) {
            $data['comments'] = $this->comments->getComments('Audit', 'issue', $value['id'], 0);
            $data['action_plans'] = $this->action_plans->getActionPlanByIssue($value['id']);
            $data['comments_count'] = count($data['comments']);
            $data['action_plans_count'] = count($data['action_plans']);
            $x++;
            $templateProcessor->setValue('issuetitle#' . $x, $value['title']);
            $templateProcessor->setValue('audit_area#' . $x, $value['audit_area']['title']);
            $templateProcessor->setValue('issue_subheading#' . $x, $value['issue_subheading']);
            $templateProcessor->setValue('issue_rating#' . $x, $value['issue_rating']);
            $templateProcessor->setValue('issue_status#' . $x, $value['issue_status']);
            $templateProcessor->setValue('implication_type#' . $x, $value['implication_type']);
            $templateProcessor->setValue('action_plan_status#' . $x, $value['action_plan_status']);
            $templateProcessor->setValue('action_by#' . $x, $value['action_by']);
//            $templateProcessor->setValue('observation#' . $x, strip_tags($value['observation']));
//            $templateProcessor->setValue('implication#' . $x, strip_tags($value['implication']));
//            $templateProcessor->setValue('recommendation#' . $x, strip_tags($value['recommendation']));
//$templateProcessor->cloneRow('comment', $data['comments_count']);
//            $templateProcessor->cloneBlock('COMMENTCLONE', $data['comments_count']);
//            foreach ($data['comments'] as $key => $comm) {
//                $templateProcessor->setValue('comment#' . $x, $comm['comment']);
//                $templateProcessor->setValue('user#' . $x, $comm['user']['names']);
//                $templateProcessor->setValue('comment_date#' . $x, $comm['timestamp']);
//            }
//$templateProcessor->cloneRow('action_plan', $data['action_plans_count']);
//            $templateProcessor->cloneBlock('ACTIONPLANCLONE', $data['action_plans_count']);
//            foreach ($data['action_plans'] as $key => $action) {
//                $templateProcessor->setValue('action_plan#' . $x, $action['action_plan']);
//                $templateProcessor->setValue('action_plan_date#' . $x, $action['action_by_date']);
//                $templateProcessor->setValue('assigned_to#' . $x, $action['assigned_to']);
//                $templateProcessor->setValue('review_date#' . $x, $action['review_date']);
//                $templateProcessor->setValue('active_status#' . $x, $action['active_status']);
//                $templateProcessor->setValue('verification#' . $x, $action['verification_status']);
//                $templateProcessor->setValue('implementation#' . $x, $action['implementation_status']);
//            }
        }

//                print_pre($data);
//        exit;

        $templateProcessor->saveAs('docs/First.docx');
    }

    function report($id) {
        $data['audit'] = $this->audit->get($id);
        $data['audit_report'] = $this->audit->pullLatestReportDataByAudit($id);
        $data['environ'] = jsonToArray($data['audit']['environment']);

        foreach ($data['environ'] as $key => $value) {
            $data['environment'][] = $this->environment->get($value);
        }
        $data['issue_table'] = $this->issue->getIssuesPublishedToBoardByAudit($id);
        $data['auditor'] = $this->user->get($data['audit']['auditor']);
        $data['audit_areas'] = jsonToArray($data['audit']['audit_area']);
        foreach ($data['audit_areas'] as $key => $value) {
            $data['audit_area'][] = $this->auditArea->get($value);
        }
        $data['audit_details'] = jsonToArray($data['audit_report']['details']);
        foreach ($data['audit_areas'] as $key => $value) {
            $data['audit_ar'][] = $this->auditArea->get($value);
            foreach ($data['audit_ar'] as $key => $txt) {
                $data['audit_ar'][$key]['issues'] = $this->issue->getIssuesPublishedToBoardByAuditArea($txt['id'], $id);
                foreach ($data['audit_ar'][$key]['issues'] as $key1 => $info) {
                    $data['audit_ar'][$key]['issues'][$key1]['comments'] = $this->auditComment->getIssueComment($info['id']);
                }
            }
        }
        $data['issues_count'] = count($data['issue_table']);
        $data['company'] = $this->environment->get($data['audit']['corporate']);
//        print_pre($data);
//        exit();
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        \PhpOffice\PhpWord\Settings::setZipClass(\PhpOffice\PhpWord\Settings::PCLZIP);
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultParagraphStyle(array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 'size' => 12,));

        // Define styles
        $fontStyle12 = array('spaceAfter' => 60, 'size' => 12);
        $firstpageStyle = array('size' => 14, 'bold' => true);
        $headerStyle1 = array('size' => 12, 'bold' => true);
        $headerStyle2 = array('size' => 13, 'bold' => true, 'color' => '2F5496');
        $centeralign = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $justify = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH);
        $txtbold = array('bold' => true);
        $paragraphOptions = array('spaceBefore' => 0, 'spaceAfter' => 0);
        $headingNumberingStyleName = 'headingNumbering1';
        $phpWord->addNumberingStyle(
                $headingNumberingStyleName, array('type' => 'multilevel',
            'levels' => array(
                array('pStyle' => 'Heading1', 'format' => 'decimal', 'text' => '%1.0'),
                array('pStyle' => 'Heading2', 'format' => 'decimal', 'text' => '%1.%2'),
                array('pStyle' => 'Heading3', 'format' => 'decimal', 'text' => '%1.%2.%3'),
            ),
                )
        );
        $headingNumberingStyleName2 = 'headingNumbering2';
        $phpWord->addNumberingStyle(
                $headingNumberingStyleName2, array('type' => 'multilevel',
            'levels' => array(
                array('pStyle' => 'Heading1', 'format' => 'decimal', 'text' => '%1.0'),
                array('pStyle' => 'Heading2', 'format' => 'decimal', 'text' => '%1.%2'),
                array('pStyle' => 'Heading3', 'format' => 'decimal', 'text' => '%1.%2.%3'),
            ),
                )
        );
        $phpWord->addTitleStyle(1, array('size' => 11, 'bold' => true));
        $phpWord->addTitleStyle(2, array('size' => 12, 'bold' => true), array('numStyle' => $headingNumberingStyleName, 'numLevel' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH));
        $phpWord->addTitleStyle(3, array('size' => 12, 'bold' => true), array('numStyle' => $headingNumberingStyleName, 'numLevel' => 1, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH));
        $phpWord->addTitleStyle(4, array('size' => 11, 'bold' => true), array('numStyle' => $headingNumberingStyleName, 'numLevel' => 2, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH));
        $phpWord->addTitleStyle(5, array('size' => 12, 'bold' => true), array('numStyle' => $headingNumberingStyleName2, 'numLevel' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH));
        $phpWord->addTitleStyle(6, array('size' => 12, 'bold' => true), array('numStyle' => $headingNumberingStyleName2, 'numLevel' => 1, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH));
        $phpWord->addTitleStyle(7, array('size' => 11, 'bold' => true), array('numStyle' => $headingNumberingStyleName2, 'numLevel' => 2, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH));
        $phpWord->addTitleStyle(8, array('size' => 11, 'italic' => true));
        $linestyle = array('weight' => 1, 'width' => 100, 'height' => 0, 'color' => 800000);

        $starter = $phpWord->addSection();
        $starter->addTextBreak(15);
        $starter->addText("{$data['company']['name']}", $firstpageStyle, $centeralign);
        $starter->addText("" . ucwords($data['audit']['audit_type']) . " Audit Report", $firstpageStyle, $centeralign);
        $starter->addText("{$data['audit']['audit_name']} As at "
                . strftime("%b-%d-%Y", strtotime($data['audit']['audit_date'])), $firstpageStyle, $centeralign);



        $firstpage = $phpWord->addSection();
        $firstheader = $firstpage->addHeader();
        $firstheader->addText("{$data['company']['name']}", $headerStyle1, $paragraphOptions);
        $firstheader->addText("" . ucwords($data['audit']['audit_type']) . " Audit Report As at "
                . strftime("%b-%d-%Y", strtotime($data['audit']['audit_date'])), $headerStyle1, $paragraphOptions);
        $firstheader->addTextBreak(1, null, $paragraphOptions);
//        $firstheader->addLine($lineStyle);
        $firstpage->addTitle('EXECUTIVE SUMMARY', 1);
        $firstpage->addTextBreak(1);
        $firstpage->addTitle('AUDIT BACKGROUND AND SCOPE', 2);
        \PhpOffice\PhpWord\Shared\Html::addHtml($firstpage, $data['audit_details']['background']);
        $firstpage->addTitle('MAIN AUDIT RECOMMENDATIONS', 2);
        \PhpOffice\PhpWord\Shared\Html::addHtml($firstpage, $data['audit_details']['main_recommendation']);
        $firstpage->addTitle('OVERALL ASSESSMENT', 2);
        \PhpOffice\PhpWord\Shared\Html::addHtml($firstpage, $data['audit_details']['overall_assessment']);
        $firstpage->addPageBreak();
        $firstpage->addTitle('AUDIT ISSUE RATING', 2);

        // Create Table
        $issueRatingTable = $phpWord->addSection();
        $issueRatingTableStyleName = 'Issue Rating';
        $issueRatingTableStyleName2 = 'Issue Rating Table';
        $fancyTableFontStyle = array('bold' => true);
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80);
        $firstTableCellStyle = array('valign' => 'center');

        $phpWord->addTableStyle($issueRatingTableStyleName2, $fancyTableStyle);

        $table2 = $firstpage->addTable($issueRatingTableStyleName2);

        $table2->addRow(1000);
        $table2->addCell(1500, $this->getIssueRatingColorCode('Low'))->addText("");
        $table2->addCell(2000, $firstTableCellStyle)->addText("Low", $fancyTableFontStyle);
        $table2->addCell(6000, $firstTableCellStyle)->addText("Issue represents a minor weakness, with minimal but reportable impact. Requires management action within a reasonable time.");
        $table2->addRow(500);
        $table2->addCell(1500, $this->getIssueRatingColorCode('Moderate'))->addText("");
        $table2->addCell(2000, $firstTableCellStyle)->addText("Moderate", $fancyTableFontStyle);
        $table2->addCell(6000, $firstTableCellStyle)->addText("Issue represents a weakness, which could have or is having a moderate adverse effect on the business. Requires short-term management action.");
        $table2->addRow(500);
        $table2->addCell(1500, $this->getIssueRatingColorCode('High'))->addText("");
        $table2->addCell(2000, $firstTableCellStyle)->addText("High", $fancyTableFontStyle);
        $table2->addCell(6000, $firstTableCellStyle)->addText("Issue represents a weakness, which could have or is having a major adverse effect on the business. Requires prompt management action.");
        $table2->addRow(500);
        $table2->addCell(1500, $this->getIssueRatingColorCode('Critical'))->addText("");
        $table2->addCell(2000, $firstTableCellStyle)->addText("Critical", $fancyTableFontStyle);
        $table2->addCell(6000, $firstTableCellStyle)->addText("Issue represents a weakness, which could cause or is causing a severe adverse effect on the business. Requires immediate notification to the Board Audit and Risk Committee.");

        $firstpage->addPageBreak();
        $firstpage->addTitle('ISSUES IN REPORT AND THIER RATINGS', 2);
        $phpWord->addTableStyle($issueRatingTableStyleName, $fancyTableStyle);
        $table = $firstpage->addTable($issueRatingTableStyleName);
        $table->addRow(500);
        $table->addCell(500)->addText("#");
        $table->addCell(8000, $firstTableCellStyle)->addText("Issue Name", $fancyTableFontStyle);
        $table->addCell(1500, $firstTableCellStyle)->addText("Issue Rating", $fancyTableFontStyle);

        $y = 0;
        foreach ($data['issue_table'] as $key => $value) {
            $y++;
            $table->addRow(500);
            $table->addCell(500)->addText("{$y}");
            $table->addCell(8000, $firstTableCellStyle)->addText(htmlspecialchars($value['title']), $fancyTableFontStyle);
            $table->addCell(1500, $this->getIssueRatingColorCode($value['issue_rating']))->addText("", $fancyTableFontStyle);
        }
        $firstpage->addPageBreak();
        $firstpage->addTitle('FOLLOW UP AUDIT', 2);
        \PhpOffice\PhpWord\Shared\Html::addHtml($firstpage, $data['audit_details']['follow_up']);

//        $firstpage->addText("Audit by: {$data['auditor']['names']}", $txtbold);

        if ((isset($data['audit_details']['business_review'])) && (!empty($data['audit_details']['business_review']))) {
            $firstpage->addPageBreak();
            $firstpage->addTitle('Business Review', 5);
            \PhpOffice\PhpWord\Shared\Html::addHtml($firstpage, $data['audit_details']['business_review']);
        }


        $x = 0;
        foreach ($data['audit_ar'] as $key => $value) {
            $x++;
            $Secname = "$" . "section{$x}";
            $Secname = $phpWord->addSection();

            $header = $Secname->addHeader();
            $header->addText("{$data['company']['name']}", $headerStyle1, $paragraphOptions);
            $header->addText("" . ucwords($data['audit']['audit_type']) . " Audit Report As at "
                    . strftime("%b-%d-%Y", strtotime($data['audit']['audit_date'])), $headerStyle1, $paragraphOptions);
            $header->addTextBreak(1, null, $paragraphOptions);

            $Secname->addTitle(htmlspecialchars($value['title']), 5);

            $name = "{$value['title']}_objective";
            $name = str_replace(" ", "_", $name);
            $con = "{$value['title']}_conclusion";
            $con = str_replace(" ", "_", $con);

            if ((isset($data['audit_details'][$name])) && (!empty($data['audit_details'][$name]))) {
                $Secname->addTitle('Summary', 6);
                \PhpOffice\PhpWord\Shared\Html::addHtml($Secname, $data['audit_details'][$name]);
            }

            if (!empty($value['issues'])) {
                foreach ($value['issues'] as $key => $info) {
                    $Secname->addTitle(htmlspecialchars(ucwords($info['title'])), 6);

                    $issueRateTableStyleName = 'Issue Rating on Issue';
                    $issueRateTableFontStyle = array('bold' => true);
                    $issueRateTableCellStyle = array('valign' => 'center');
                    $issueRateTableStyle = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT);
                    $phpWord->addTableStyle($issueRateTableStyleName, $issueRateTableStyle);
                    $issueRate = $Secname->addTable($issueRateTableStyleName);
                    $issueRate->addRow(200);
                    $issueRate->addCell(1500, $issueRateTableCellStyle)->addText(htmlspecialchars($info['issue_rating']), $issueRateTableFontStyle);
                    $issueRate->addCell(1500, $this->getIssueRatingColorCode($info['issue_rating']))->addText("", $issueRateTableFontStyle);

                    $Secname->addTextBreak(1);
                    $Secname->addTitle('Issue Details', 7);
//                    $Secname->addTextBreak(1);
//                    $textrun1 = $Secname->addTextRun();
                    $textrun2 = $Secname->addTextRun();
                    $textrun3 = $Secname->addTextRun();
                    $textrun4 = $Secname->addTextRun();
                    $textrun5 = $Secname->addTextRun();
                    $textrun6 = $Secname->addTextRun();
                    $textrun7 = $Secname->addTextRun();
                    $textrun8 = $Secname->addTextRun();
                    $textrun9 = $Secname->addTextRun();
                    $textrun10 = $Secname->addTextRun();
                    $textrun11 = $Secname->addTextRun();

                    if (!empty($info['issue_subheading'])) {
                        $textrun2->addText("Issue Subheading: ", $txtbold);
                        $textrun2->addText(htmlspecialchars($info['issue_subheading']));
                    }
                    $textrun3->addText("Issue Rating: ", $txtbold);
                    $textrun3->addText($info['issue_rating']);
                    $textrun3->addText("    Issue Status: ", $txtbold);
                    $textrun3->addText($info['issue_status']);
                    $textrun3->addText("    Implication Type: ", $txtbold);
                    $textrun3->addText($info['implication_type']);
                    if (!empty($info['observation'])) {
                        $Secname->addTitle("Observation", 7);
                        \PhpOffice\PhpWord\Shared\Html::addHtml($Secname, $info['observation']);
                    }
                    if (!empty($info['implication'])) {
                        $Secname->addTitle("Implication", 7);
                        \PhpOffice\PhpWord\Shared\Html::addHtml($Secname, $info['implication']);
                    }
                    if (!empty($info['recommendation'])) {
                        $Secname->addTitle("Recommendation", 7);
                    \PhpOffice\PhpWord\Shared\Html::addHtml($Secname, $info['recommendation']);
                    }
                    

                    if (!empty($info['comments'])) {
                        foreach ($info['comments'] as $key => $variable) {
                            if ($variable['auditor_comment_report'] == 'yes') {
                                if ($variable['user_type'] != 8) {
//                                    echo 'Manager';
//                                    print_pre($variable);
                                    $Secname->addTitle("Management Comment", 7);
                                    \PhpOffice\PhpWord\Shared\Html::addHtml($Secname, $variable['comment']);
                                } elseif ($variable['user_type'] == 8){
//                                    echo 'Auditor';
//                                    print_pre($variable);
                                    $Secname->addTitle("Auditor's Comment", 7);
                                    \PhpOffice\PhpWord\Shared\Html::addHtml($Secname, $variable['comment']);
                                }
                            } else {
                                if ($variable['user_type'] != 8) {
//                                    echo 'solo';
//                                    print_pre($variable);
                                    $Secname->addTitle("Management Comment", 7);
                                    \PhpOffice\PhpWord\Shared\Html::addHtml($Secname, $variable['comment']);
                                }
                            }
                        }
                    } else {
//                        $Secname->addTitle("No Management Comment on this issue", 8);
                    }
                }
            } else {
                
            }
            if ((isset($data['audit_details'][$name])) && (!empty($data['audit_details'][$con]))) {
                $Secname->addTitle('Conclusion', 6);
                \PhpOffice\PhpWord\Shared\Html::addHtml($Secname, $data['audit_details'][$con]);
            }
        }
//        exit;
        $company = $data['company']['name'];
        $auditName = $data['audit']['audit_name'];
        $properties = $phpWord->getDocInfo();
        $properties->setCreator('GRC_Alex');
        $properties->setCompany("{$company}");
        $properties->setTitle("{$auditName}");
        $properties->setLastModifiedBy('GRC System');
        $properties->setSubject('Audit Report');
//        $section->addTitle($data['audit']['audit_name'], 1);
// Saving the document as OOXML file...
        $filename = "{$data['audit']['audit_name']}_As_At_" . strftime("%b-%d-%Y", strtotime($data['audit']['audit_date'])) . "_gen_at_" . date("Y-m-d H:i:s");

//        if ($_SERVER['HTTP_HOST'] == 'localhost') {
        // Doc generated on the fly, may change so do not cache it; mark as public or
// private to be cached.
        header('Pragma: no-cache');
// Mark file as already expired for cache; mark with RFC 1123 Date Format up to
// 1 year ahead for caching (ex. Thu, 01 Dec 1994 16:00:00 GMT)
        header('Expires: 0');
// Forces cache to re-validate with server
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
// DocX Content Type
// header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Type: application/octet-stream');
// Tells browser we are sending file application/octet-stream
        header('Content-Disposition: attachment; filename=' . $filename . '.docx;');
// Tell proxies and gateways method of file transfer
        header('Content-Transfer-Encoding: binary');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        $objWriter->save("php://output");
//        echo 'Successful';
        exit;
        $x = 0;
        foreach ($data['issues'] as $key => $value) {
            $x++;
            $Secname = "$" . "section{$x}";
            $Secname = $phpWord->addSection();
//            print_pre($value);

            $header = $Secname->addHeader();
            $header->addText("{$data['company']['name']}", $headerStyle1);
            $header->addText("" . ucwords($data['audit']['audit_type']) . " Audit Report {$data['audit']['audit_name']} As at "
                    . strftime("%b-%d-%Y", strtotime($data['audit']['audit_date'])), $headerStyle1);
            $header->addLine($lineStyle);


            $data['comments'] = $this->comments->getComments('Audit', 'issue', $value['id'], 0);
            $data['action_plans'] = $this->action_plans->getActionPlanByIssue($value['id']);
            $data['comments_count'] = count($data['comments']);
            $data['action_plans_count'] = count($data['action_plans']);

            $Secname->addTitle(htmlspecialchars($value['title']), 1);
            $Secname->addTextBreak(1);
            $Secname->addTitle('Issue Details', 2);
            $Secname->addTextBreak(1);
            $textrun1 = $Secname->addTextRun();
            $textrun2 = $Secname->addTextRun();
            $textrun3 = $Secname->addTextRun();
            $textrun4 = $Secname->addTextRun();
            $textrun5 = $Secname->addTextRun();
            $textrun6 = $Secname->addTextRun();
            $textrun7 = $Secname->addTextRun();
            $textrun8 = $Secname->addTextRun();
            $textrun9 = $Secname->addTextRun();
            $textrun10 = $Secname->addTextRun();
            $textrun11 = $Secname->addTextRun();
//
//            $textrun1->addText("Audit Area: ", $txtbold);
//            foreach ($data['audit_area'] as $key => $value) {
//                $aud_ar[] = $value['title'];
//            }
//            $textrun1->addText(implode(" ", $aud_ar));
//
//            $textrun1->addText($value['audit_area']['title']);
            $textrun2->addText("Issue Subheading: ", $txtbold);
            $textrun2->addText(htmlspecialchars($value['issue_subheading']));
            $textrun3->addText("Issue Rating: ", $txtbold);
            $textrun3->addText($value['issue_rating']);
            $textrun4->addText("Issue Status: ", $txtbold);
            $textrun4->addText($value['issue_status']);
            $textrun5->addText("Implication Type: ", $txtbold);
            $textrun5->addText($value['implication_type']);
            $textrun6->addText("Action Plan Status: ", $txtbold);
            $textrun6->addText($value['action_plan_status']);
            $textrun7->addText("Issue Owner: ", $txtbold);
            $textrun7->addText($value['issue_owner']['names']);
            $textrun8->addText("Action Plan Status: ", $txtbold);
            $textrun8->addText($value['action_plan_status']);
            $textrun9->addText("Observation: ", $txtbold);
            $textrun9->addText(htmlspecialchars($value['observation']));
            $textrun10->addText("Implication: ", $txtbold);
            $textrun10->addText(htmlspecialchars($value['implication']));
            $textrun11->addText("Recommendation: ", $txtbold);
            $textrun11->addText(htmlspecialchars($value['recommendation']));

            $Secname->addTitle('Comments', 2);
            if ((isset($data['comments_count'])) && ($data['comments_count'] > 0)) {
                foreach ($data['comments'] as $key => $comm) {
                    $textrun12 = $Secname->addTextRun();
                    $textrun13 = $Secname->addTextRun();
                    $textrun12->addText("Comment: ", $txtbold);
                    $textrun12->addText(htmlspecialchars($comm['comment']));
                    $textrun13->addText("Comment By: ", $txtbold);
                    $textrun13->addText($comm['user']['names'] . "                ");
                    $textrun13->addText("Comment Date: ", $txtbold);
                    $textrun13->addText($comm['timestamp']);
                }
            } else {
                $Secname->addText("No Comments on this Issue", array('size' => 11, 'italic' => true));
            }

            $Secname->addTitle('Management Action Plans', 2);
            if ((isset($data['action_plans_count'])) && ($data['action_plans_count'] > 0)) {
                foreach ($data['action_plans'] as $key => $action) {
                    $textrun14 = $Secname->addTextRun();
                    $textrun15 = $Secname->addTextRun();
                    $textrun16 = $Secname->addTextRun();
                    $textrun17 = $Secname->addTextRun();
                    $textrun18 = $Secname->addTextRun();
                    $textrun19 = $Secname->addTextRun();
                    $textrun20 = $Secname->addTextRun();
                    $textrun21 = $Secname->addTextRun();

                    $textrun15->addText("Title: ", $txtbold);
                    $textrun15->addText(htmlspecialchars($action['action_plan']));
                    $textrun14->addText("Description: ", $txtbold);
                    $textrun14->addText(htmlspecialchars($action['description']));
                    $textrun16->addText("Action Plan Date: ", $txtbold);
                    $textrun16->addText($action['action_by_date']);
                    $textrun17->addText("Assigned to: ", $txtbold);
                    $textrun17->addText(htmlspecialchars($action['assigned_to']));
                    $textrun18->addText("Review Date: ", $txtbold);
                    $textrun18->addText($action['review_date']);
                    $textrun19->addText("Active Status: ", $txtbold);
                    $textrun19->addText($action['active_status']);
                    $textrun20->addText("Verification Status: ", $txtbold);
                    $textrun20->addText($action['verification_status']);
                    $textrun21->addText("Implementation Status: ", $txtbold);
                    $textrun21->addText($action['implementation_status']);
                }
            } else {
                $Secname->addText("No Management Actions on this Issue", array('size' => 11, 'italic' => true));
            }

            $Secname->addPageBreak();
        }

        // Create Table
        $issueRatingTable = $phpWord->addSection();
        $issueRatingTableStyleName = 'Issue Rating';
        $fancyTableFontStyle = array('bold' => true);
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $firstTableCellStyle = array('valign' => 'center');

        $phpWord->addTableStyle($issueRatingTableStyleName, $fancyTableStyle);

        $table = $issueRatingTable->addTable($issueRatingTableStyleName);
        $x = 0;
        foreach ($data['issues'] as $key => $value) {
            $x++;
            $table->addRow(500);
            $table->addCell(500)->addText("{$x}");
            $table->addCell(8000, $firstTableCellStyle)->addText(htmlspecialchars($value['title']), $fancyTableFontStyle);
//        $secondTableCellStyle = $this->getIssueRatingColorCode($value['issue_rating']);
            $table->addCell(1500, $this->getIssueRatingColorCode($value['issue_rating']))->addText(htmlspecialchars($value['issue_rating']), $fancyTableFontStyle);
            ;
//        print_pre($secondTableCellStyle);
        }
//        exit;
        $properties = $phpWord->getDocInfo();
        $properties->setCreator('GRC_Alex');
//        $section->addTitle($data['audit']['audit_name'], 1);
// Saving the document as OOXML file...
        $filename = "{$data['audit']['audit_name']}_As_At_" . strftime("%b-%d-%Y", strtotime($data['audit']['audit_date'])) . "_gen_at_" . date("Y-m-d H:i:s");

        $user_id = $this->user->getMyId();
        $doc_upload_data = array('user' => $user_id,
            'module' => 'Audit',
            'table_name' => 'audit',
            'record_id' => $id,
            'filetype' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'filename' => $filename,
            'newname' => $filename,
            'title' => $data['audit']['audit_name'],
            'caption' => $data['audit']['audit_name'],
            'filesize' => 0,
            'uploaded' => time(),
            'fileinfo' => 'Audit Report',
            'status' => 'No Status',);
//        if ($_SERVER['HTTP_HOST'] == 'localhost') {
        // Doc generated on the fly, may change so do not cache it; mark as public or
// private to be cached.
        header('Pragma: no-cache');
// Mark file as already expired for cache; mark with RFC 1123 Date Format up to
// 1 year ahead for caching (ex. Thu, 01 Dec 1994 16:00:00 GMT)
        header('Expires: 0');
// Forces cache to re-validate with server
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
// DocX Content Type
// header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Type: application/octet-stream');
// Tells browser we are sending file application/octet-stream
        header('Content-Disposition: attachment; filename=' . $filename . '.docx;');
// Tell proxies and gateways method of file transfer
        header('Content-Transfer-Encoding: binary');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        // $objWriter->save('docs/' . $filename . '.docx');
        // Send the file:
        // readfile('docs/' . $filename . '.docx');
        $objWriter->save("php://output");
//            print_pre($_FILES);
        // exit;
//            $this->db->insert('upload', $doc_upload_data);
//        } else {
//            $option = ['gs_bucket_name' => UPLOAD_BACKET];
//            $upload_ur = CloudStorageTools::createUploadUrl('', $option);
//            $upload_ur;
////            header("Content-Type:   application/octet-stream"); // you should look for the real header that a word2007 document needs!!!
//            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
//            header( "Content-Type:   application/vnd.openxmlformats-officedocument.wordprocessingml.document" );// you should look for the real header that a word2007 document needs!!!
//header( 'Content-Disposition: attachment; filename='.$filename.'.docx' );
//$h2d_file_uri = tempnam( "", "htd" );
//$objWriter = PHPWord_IOFactory::createWriter( $phpWord, "Word2007" );
//$objWriter->save( "php://output" );
//            $options = ['gs' => ['Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']];
//            $context = stream_context_create($options);
//            file_put_contents("gs://grc_uploads/{$filename}.docx", $objWriter->save("{$filename}.docx"), 0, $context);
//            $myfile = fopen("gs://grc_uploads/{$filename}.docx", "w");
//            fwrite($myfile, $objWriter->save("{$filename}.docx"));
//            fclose($myfile);
//            $objWriter->save('gs://grc_uploads/' . $filename . '.docx');
//            $objWriter->save('php://output');
//            $this->db->insert('upload', $doc_upload_data);
//        }
//        redirect('Audit/audit/' . $id);
    }

    function getIssueRatingColorCode($rating) {
        switch ($rating) {
            case $rating == 'Low':
                $result = array('valign' => 'center', 'bgColor' => '00B050');
                return $result;
                break;
            case $rating == 'Moderate':
                $result = array('valign' => 'center', 'bgColor' => 'FFFF00');
                return $result;
                break;
            case $rating == 'High':
                $result = array('valign' => 'center', 'bgColor' => 'FFC000');
                return $result;
                break;
            case $rating == 'Critical':
                $result = array('valign' => 'center', 'bgColor' => 'FF0000');
                return $result;
                break;
            default:
                $result = array('valign' => 'center');
                return $result;
                break;
        }
    }
    
    function separateComments($comments){
        
    }

    function createTable() {
        include_once APPPATH . 'third_party/PHPWord3/samples/Sample_Header.php';

// New Word Document
        echo date('H:i:s'), ' Create new PhpWord object', EOL;
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $header = array('size' => 16, 'bold' => true);

// 1. Basic table

        $rows = 10;
        $cols = 5;
        $section->addText('Basic table', $header);

        $table = $section->addTable();
        for ($r = 1; $r <= 8; $r++) {
            $table->addRow();
            for ($c = 1; $c <= 5; $c++) {
                $table->addCell(1750)->addText("Row {$r}, Cell {$c}");
            }
        }

// 2. Advanced table

        $section->addTextBreak(1);
        $section->addText('Fancy table', $header);

        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $fancyTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '66BBFF');
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $fancyTableFontStyle = array('bold' => true);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
        $table = $section->addTable($fancyTableStyleName);
        $table->addRow(900);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Row 1', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Row 2', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Row 3', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Row 4', $fancyTableFontStyle);
        $table->addCell(500, $fancyTableCellBtlrStyle)->addText('Row 5', $fancyTableFontStyle);
        for ($i = 1; $i <= 8; $i++) {
            $table->addRow();
            $table->addCell(2000)->addText("Cell {$i}");
            $table->addCell(2000)->addText("Cell {$i}");
            $table->addCell(2000)->addText("Cell {$i}");
            $table->addCell(2000)->addText("Cell {$i}");
            $text = (0 == $i % 2) ? 'X' : '';
            $table->addCell(500)->addText($text);
        }

        /**
         *  3. colspan (gridSpan) and rowspan (vMerge)
         *  ---------------------
         *  |     |   B    |    |
         *  |  A  |--------|  E |
         *  |     | C |  D |    |
         *  ---------------------
         */
        $section->addPageBreak();
        $section->addText('Table with colspan and rowspan', $header);

        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '999999');
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'FFFF00');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 2, 'valign' => 'center');
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $cellVCentered = array('valign' => 'center');

        $spanTableStyleName = 'Colspan Rowspan';
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);
        $table = $section->addTable($spanTableStyleName);

        $table->addRow();

        $cell1 = $table->addCell(2000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('A');
        $textrun1->addFootnote()->addText('Row span');

        $cell2 = $table->addCell(4000, $cellColSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('B');
        $textrun2->addFootnote()->addText('Column span');

        $table->addCell(2000, $cellRowSpan)->addText('E', null, $cellHCentered);

        $table->addRow();
        $table->addCell(null, $cellRowContinue);
        $table->addCell(2000, $cellVCentered)->addText('C', null, $cellHCentered);
        $table->addCell(2000, $cellVCentered)->addText('D', null, $cellHCentered);
        $table->addCell(null, $cellRowContinue);

        /**
         *  4. colspan (gridSpan) and rowspan (vMerge)
         *  ---------------------
         *  |     |   B    |  1 |
         *  |  A  |        |----|
         *  |     |        |  2 |
         *  |     |---|----|----|
         *  |     | C |  D |  3 |
         *  ---------------------
         * @see https://github.com/PHPOffice/PHPWord/issues/806
         */
        $section->addPageBreak();
        $section->addText('Table with colspan and rowspan', $header);

        $styleTable = ['borderSize' => 6, 'borderColor' => '999999'];
        $phpWord->addTableStyle('Colspan Rowspan', $styleTable);
        $table = $section->addTable('Colspan Rowspan');

        $row = $table->addRow();

        $row->addCell(null, ['vMerge' => 'restart'])->addText('A');
        $row->addCell(null, ['gridSpan' => 2, 'vMerge' => 'restart',])->addText('B');
        $row->addCell()->addText('1');

        $row = $table->addRow();
        $row->addCell(null, ['vMerge' => 'continue']);
        $row->addCell(null, ['vMerge' => 'continue', 'gridSpan' => 2,]);
        $row->addCell()->addText('2');
        $row = $table->addRow();
        $row->addCell(null, ['vMerge' => 'continue']);
        $row->addCell()->addText('C');
        $row->addCell()->addText('D');
        $row->addCell()->addText('3');

// 5. Nested table

        $section->addTextBreak(2);
        $section->addText('Nested table in a centered and 50% width table.', $header);

        $table = $section->addTable(array('width' => 50 * 50, 'unit' => 'pct', 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER));
        $cell = $table->addRow()->addCell();
        $cell->addText('This cell contains nested table.');
        $innerCell = $cell->addTable(array('alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER))->addRow()->addCell();
        $innerCell->addText('Inside nested table');

// Save file
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save("docs/tables.docx");
    }

    function sections() {
        include_once APPPATH . 'third_party/PHPWord/samples/Sample_Header.php';

// New Word Document
        echo date('H:i:s'), ' Create new PhpWord object', EOL;
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

// New portrait section
        $section = $phpWord->addSection(array('borderColor' => '00FF00', 'borderSize' => 12));
        $section->addText('I am placed on a default section.');

// New landscape section
        $section = $phpWord->addSection(array('orientation' => 'landscape'));
        $section->addText('I am placed on a landscape section. Every page starting from this section will be landscape style.');
        $section->addPageBreak();
        $section->addPageBreak();

// New portrait section
        $section = $phpWord->addSection(
                array('paperSize' => 'Folio', 'marginLeft' => 600, 'marginRight' => 600, 'marginTop' => 600, 'marginBottom' => 600)
        );
        $section->addText('This section uses other margins with folio papersize.');

// New portrait section with Header & Footer
        $section = $phpWord->addSection(
                array(
                    'marginLeft' => 200,
                    'marginRight' => 200,
                    'marginTop' => 200,
                    'marginBottom' => 200,
                    'headerHeight' => 50,
                    'footerHeight' => 50,
                )
        );
        $section->addText('This section and we play with header/footer height.');
        $section->addHeader()->addText('Header');
        $section->addFooter()->addText('Footer');

// Save file
        echo write($phpWord, basename(__FILE__, '.php'), $writers);
        if (!CLI) {
            include_once APPPATH . 'third_party/PHPWord/samples/Sample_Footer.php';
        }
    }

    function headerfooter() {

        include_once APPPATH . 'third_party/PHPWord/samples/Sample_Header.php';

// New Word document
        echo date('H:i:s'), ' Create new PhpWord object', EOL;
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

// New portrait section
        $section = $phpWord->addSection();

// Add first page header
        $header = $section->addHeader();
        $header->firstPage();
        $table = $header->addTable();
        $table->addRow();
        $cell = $table->addCell(4500);
        $textrun = $cell->addTextRun();
        $textrun->addText('This is the header with ');
        $textrun->addLink('https://github.com/PHPOffice/PHPWord', 'PHPWord on GitHub');
//        $table->addCell(4500)->addImage('resources/PhpWord.png', array('width' => 80, 'height' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END));
// Add header for all other pages
        $subsequent = $section->addHeader();
        $subsequent->addText('Subsequent pages in Section 1 will Have this!');
//        $subsequent->addImage('resources/_mars.jpg', array('width' => 80, 'height' => 80));
// Add footer
        $footer = $section->addFooter();
        $footer->addPreserveText('Page {PAGE} of {NUMPAGES}.', null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
        $footer->addLink('https://github.com/PHPOffice/PHPWord', 'PHPWord on GitHub');

// Write some text
        $section->addTextBreak();
        $section->addText('Some text...');

// Create a second page
        $section->addPageBreak();

// Write some text
        $section->addTextBreak();
        $section->addText('Some text...');

// Create a third page
        $section->addPageBreak();

// Write some text
        $section->addTextBreak();
        $section->addText('Some text...');

// New portrait section
        $section2 = $phpWord->addSection();

        $sec2Header = $section2->addHeader();
        $sec2Header->addText('All pages in Section 2 will Have this!');

// Write some text
        $section2->addTextBreak();
        $section2->addText('Some text...');

// Save file
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('docs/headerfooter.docx');
//        echo write($phpWord, basename(__FILE__, '.php'), $writers);
        if (!CLI) {
            include_once APPPATH . 'third_party/PHPWord/samples/Sample_Footer.php';
        }
    }

    function toc() {
        include_once APPPATH . 'third_party/PHPWord/samples/Sample_Header.php';

// New Word document
        echo date('H:i:s'), ' Create new PhpWord object', EOL;
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

// New section
        $section = $phpWord->addSection();

// Define styles
        $fontStyle12 = array('spaceAfter' => 60, 'size' => 12);
        $fontStyle10 = array('size' => 10);
        $phpWord->addTitleStyle(1, array('size' => 20, 'color' => '333333', 'bold' => true));
        $phpWord->addTitleStyle(2, array('size' => 16, 'color' => '666666'));
        $phpWord->addTitleStyle(3, array('size' => 14, 'italic' => true));
        $phpWord->addTitleStyle(4, array('size' => 12));

// Add text elements
        $section->addText('Table of contents 1');
        $section->addTextBreak(2);

// Add TOC #1
        $toc = $section->addTOC($fontStyle12);
        $section->addTextBreak(2);

// Filler
        $section->addText('Text between TOC');
        $section->addTextBreak(2);

// Add TOC #1
        $section->addText('Table of contents 2');
        $section->addTextBreak(2);
        $toc2 = $section->addTOC($fontStyle10);
        $toc2->setMinDepth(2);
        $toc2->setMaxDepth(3);

// Add Titles
        $section->addPageBreak();
        $section->addTitle('Foo n Bar', 1);
        $section->addText('Some text...');
        $section->addTextBreak(2);

        $section->addTitle('I am a Subtitle of Title 1', 2);
        $section->addTextBreak(2);
        $section->addText('Some more text...');
        $section->addTextBreak(2);

        $section->addTitle('Another Title (Title 2)', 1);
        $section->addText('Some text...');
        $section->addPageBreak();
        $section->addTitle('I am Title 3', 1);
        $section->addText('And more text...');
        $section->addTextBreak(2);
        $section->addTitle('I am a Subtitle of Title 3', 2);
        $section->addText('Again and again, more text...');
        $section->addTitle('Subtitle 3.1.1', 3);
        $section->addText('Text');
        $section->addTitle('Subtitle 3.1.1.1', 4);
        $section->addText('Text');
        $section->addTitle('Subtitle 3.1.1.2', 4);
        $section->addText('Text');
        $section->addTitle('Subtitle 3.1.2', 3);
        $section->addText('Text');

        echo date('H:i:s'), ' Note: Please refresh TOC manually.', EOL;

// Save file
        echo write($phpWord, basename(__FILE__, '.php'), $writers);
        if (!CLI) {
            include_once APPPATH . 'third_party/PHPWord/samples/Sample_Footer.php';
        }
    }

    function txtrun() {
        include_once APPPATH . 'third_party/PHPWord/samples/Sample_Header.php';

// New Word Document
        echo date('H:i:s'), ' Create new PhpWord object', EOL;
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

// Define styles
        $paragraphStyleName = 'pStyle';
        $phpWord->addParagraphStyle($paragraphStyleName, array('spacing' => 100));

        $boldFontStyleName = 'BoldText';
        $phpWord->addFontStyle($boldFontStyleName, array('bold' => true));

        $coloredFontStyleName = 'ColoredText';
        $phpWord->addFontStyle($coloredFontStyleName, array('color' => 'FF8080', 'bgColor' => 'FFFFCC'));

        $linkFontStyleName = 'NLink';
        $phpWord->addLinkStyle($linkFontStyleName, array('color' => '0000FF', 'underline' => \PhpOffice\PhpWord\Style\Font::UNDERLINE_SINGLE));

// New portrait section
        $section = $phpWord->addSection();

// Add text run
        $textrun = $section->addTextRun($paragraphStyleName);
        $textrun->addText('Each textrun can contain native text, link elements or an image.');
        $textrun->addText(' No break is placed after adding an element.', $boldFontStyleName);
        $textrun->addText(' Both ');
        $textrun->addText('superscript', array('superScript' => true));
        $textrun->addText(' and ');
        $textrun->addText('subscript', array('subScript' => true));
        $textrun->addText(' are also available.');
        $textrun->addText(' All elements are placed inside a paragraph with the optionally given paragraph style.', $coloredFontStyleName);
        $textrun->addText(' Sample Link: ');
        $textrun->addLink('https://github.com/PHPOffice/PHPWord', 'PHPWord on GitHub', $linkFontStyleName);
        $textrun->addText(' Sample Image: ');
        $textrun->addImage(APPPATH . 'third_party/PHPWord/samples/resources/_earth.jpg', array('width' => 18, 'height' => 18));
        $textrun->addText(' Sample Object: ');
        $textrun->addObject(APPPATH . 'third_party/PHPWord/samples/resources/_sheet.xls');
        $textrun->addText(' Here is some more text. ');

// Save file
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save("docs/txtrun.docx");
    }

    function list101() {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

// Define styles
        $fontStyleName = 'myOwnStyle';
        $phpWord->addFontStyle($fontStyleName, array('color' => 'FF0000'));

        $paragraphStyleName = 'P-Style';
        $phpWord->addParagraphStyle($paragraphStyleName, array('spaceAfter' => 95));

        $multilevelNumberingStyleName = 'multilevel';
        $phpWord->addNumberingStyle(
                $multilevelNumberingStyleName, array(
            'type' => 'multilevel',
            'levels' => array(
                array('format' => 'decimal', 'text' => '%1.', 'left' => 360, 'hanging' => 360, 'tabPos' => 360),
                array('format' => 'upperLetter', 'text' => '%2.', 'left' => 720, 'hanging' => 360, 'tabPos' => 720),
            ),
                )
        );

        $predefinedMultilevelStyle = array('listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER_NESTED);

// New section
        $section = $phpWord->addSection();

// Lists
        $section->addText('Multilevel list.');
        $section->addListItem('List Item I', 0, null, $multilevelNumberingStyleName);
        $section->addListItem('List Item I.a', 1, null, $multilevelNumberingStyleName);
        $section->addListItem('List Item I.b', 1, null, $multilevelNumberingStyleName);
        $section->addListItem('List Item II', 0, null, $multilevelNumberingStyleName);
        $section->addListItem('List Item II.a', 1, null, $multilevelNumberingStyleName);
        $section->addListItem('List Item III', 0, null, $multilevelNumberingStyleName);
        $section->addTextBreak(2);

        $section->addText('Basic simple bulleted list.');
        $section->addListItem('List Item 1');
        $section->addListItem('List Item 2');
        $section->addListItem('List Item 3');
        $section->addTextBreak(2);

        $section->addText('Continue from multilevel list above.');
        $section->addListItem('List Item IV', 0, null, $multilevelNumberingStyleName);
        $section->addListItem('List Item IV.a', 1, null, $multilevelNumberingStyleName);
        $section->addTextBreak(2);

        $section->addText('Multilevel predefined list.');
        $section->addListItem('List Item 1', 0, $fontStyleName, $predefinedMultilevelStyle, $paragraphStyleName);
        $section->addListItem('List Item 2', 0, $fontStyleName, $predefinedMultilevelStyle, $paragraphStyleName);
        $section->addListItem('List Item 3', 1, $fontStyleName, $predefinedMultilevelStyle, $paragraphStyleName);
        $section->addListItem('List Item 4', 1, $fontStyleName, $predefinedMultilevelStyle, $paragraphStyleName);
        $section->addListItem('List Item 5', 2, $fontStyleName, $predefinedMultilevelStyle, $paragraphStyleName);
        $section->addListItem('List Item 6', 1, $fontStyleName, $predefinedMultilevelStyle, $paragraphStyleName);
        $section->addListItem('List Item 7', 0, $fontStyleName, $predefinedMultilevelStyle, $paragraphStyleName);
        $section->addTextBreak(2);

        $section->addText('List with inline formatting.');
        $listItemRun = $section->addListItemRun();
        $listItemRun->addText('List item 1');
        $listItemRun->addText(' in bold', array('bold' => true));
        $listItemRun = $section->addListItemRun();
        $listItemRun->addText('List item 2');
        $listItemRun->addText(' in italic', array('italic' => true));
        $listItemRun = $section->addListItemRun();
        $listItemRun->addText('List item 3');
        $listItemRun->addText(' underlined', array('underline' => 'dash'));
        $section->addTextBreak(2);

// Numbered heading
        $headingNumberingStyleName = 'headingNumbering';
        $phpWord->addNumberingStyle(
                $headingNumberingStyleName, array('type' => 'multilevel',
            'levels' => array(
                array('pStyle' => 'Heading1', 'format' => 'decimal', 'text' => '%1'),
                array('pStyle' => 'Heading2', 'format' => 'decimal', 'text' => '%1.%2'),
                array('pStyle' => 'Heading3', 'format' => 'decimal', 'text' => '%1.%2.%3'),
            ),
                )
        );
        $phpWord->addTitleStyle(1, array('size' => 16), array('numStyle' => $headingNumberingStyleName, 'numLevel' => 0));
        $phpWord->addTitleStyle(2, array('size' => 14), array('numStyle' => $headingNumberingStyleName, 'numLevel' => 1));
        $phpWord->addTitleStyle(3, array('size' => 12), array('numStyle' => $headingNumberingStyleName, 'numLevel' => 2));

        $section->addTitle('Heading 1', 1);
        $section->addTitle('Heading 2', 2);
        $section->addTitle('Heading 3', 3);

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save("docs/list.docx");
    }

}
