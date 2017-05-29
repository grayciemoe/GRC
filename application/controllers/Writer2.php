<?php

//require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
//
//use google\appengine\api\cloud_storage\CloudStorageTools;
//if ($_SERVER['HTTP_HOST'] != 'localhost') {
//    exit("Uncomment Line 3 to 5 in " . __FILE__);
//}
//if ($_SERVER['HTTP_HOST'] == 'localhost') {
//    require_once APPPATH . 'third_party/PHPWord/bootstrap.php';
//}else{
require_once APPPATH . 'third_party/vsword/VsWord.php';

VsWord::autoLoad();

//    require_once 'http://52.30.190.90/PhpOffice/PHPWord/bootstrap.php';
//}




/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Writer2 extends CI_Controller {

    public function __construct() {
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

        $this->load->model("Bridge/BridgeModel", "bridge");
        $this->load->model("Comments/CommentsModel", "comments");
    }

    function index() {
// Creating the new document...
        
        $doc = new VsWord();
        $parser = new HtmlParser($doc);
        $parser->parse('<h1>Hello world!</h1>');
        $parser->parse('<h3>Hello world!</h3>');
        $parser->parse('<p>Hello world!</p>');
        $parser->parse('<h2>Header table</h2> <table> <tr><td><div style="background:#ff0000;>Coll 1</div></td><td>Coll 2</td></tr> </table>');
        $parser->parse('<div style="background:#ff0000; border:1px solid #eeeeee; padding:5px 10px">edrfgthyjk</div>');
        $html = '<table class="MsoTableGrid" border="1" cellspacing="0" cellpadding="0" style="border: none;">
 <tbody><tr>
  <td width="312" valign="top" style="width:233.75pt;border:solid windowtext 1.0pt;
  mso-border-alt:solid windowtext .5pt;padding:0in 5.4pt 0in 5.4pt">
  <p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal"><o:p>&nbsp;</o:p></p>
  </td>
  <td width="312" valign="top" style="width:233.75pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;background:red;padding:0in 5.4pt 0in 5.4pt">
  <p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal"><o:p>&nbsp;</o:p></p>
  </td>
 </tr>
 <tr>
  <td width="312" valign="top" style="width:233.75pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt">
  <p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal"><o:p>&nbsp;</o:p></p>
  </td>
  <td width="312" valign="top" style="width:233.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:yellow;padding:0in 5.4pt 0in 5.4pt">
  <p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal"><o:p>&nbsp;</o:p></p>
  </td>
 </tr>
 <tr>
  <td width="312" valign="top" style="width:233.75pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt">
  <p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal"><o:p>&nbsp;</o:p></p>
  </td>
  <td width="312" valign="top" style="width:233.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:#0070C0;padding:0in 5.4pt 0in 5.4pt">
  <p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal"><o:p>&nbsp;</o:p></p>
  </td>
 </tr>
 <tr>
  <td width="312" valign="top" style="width:233.75pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0in 5.4pt 0in 5.4pt">
  <p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal"><o:p>&nbsp;</o:p></p>
  </td>
  <td width="312" valign="top" style="width:233.75pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:#00B050;padding:0in 5.4pt 0in 5.4pt">
  <p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal"><o:p>&nbsp;</o:p></p>
  </td>
 </tr>
</tbody></table>';
        $parser->parse($html);

        echo '<pre>' . ($doc->getDocument()->getBody()->look()) . '</pre>';

        $doc->saveAs('docs/test.docx');
    }

    function report(
    $id) {
        $data['audit'] = $this->audit->get($id);
        $data['environ'] = jsonToArray($data['audit']['environment']);

        foreach ($data['environ'] as $key => $value) {
            $data['environment'][] = $this->environment->get($value);
        }
        $data['auditor'] = $this->user->get($data['audit']['auditor']);
        $data['audit_ar'] = jsonToArray($data['audit']['audit_area']);


        $doc = new VsWord();
        $body = $doc->getDocument()->getBody();

        $parser = new HtmlParser($doc);
        $parser->parse('<br /> <br /> <br /> <br /> <br />');

        $title = new PCompositeNode();
        $title->addPNodeStyle(new AlignNode(AlignNode::TYPE_CENTER));
        $rTitle = new RCompositeNode();
        $title->addNode($rTitle);
        $rTitle->addTextStyle(new BoldStyleNode());
        $rTitle->addTextStyle(new ColorStyleNode('2F5496'));
        $rTitle->addTextStyle(new FontSizeStyleNode(16));
        $rTitle->addText($data['audit']['audit_name']);
        $body->addNode($title);


        $title = new PCompositeNode();
        $title->addPNodeStyle(new AlignNode(AlignNode::TYPE_CENTER));
        $rTitle = new RCompositeNode();
        $title->addNode($rTitle);
        $rTitle->addTextStyle(new BoldStyleNode());
        $rTitle->addTextStyle(new ColorStyleNode('2F5496'));
        $rTitle->addTextStyle(new FontSizeStyleNode(14));
        $rTitle->addText('Audit type');

        $rTitle2 = new RCompositeNode();
        $title->addNode($rTitle2);
        $rTitle2->addTextStyle(new ColorStyleNode('2F5496'));
        $rTitle2->addTextStyle(new FontSizeStyleNode(14));
        $rTitle2->addText(': ' . $data['audit']['audit_type'] . '.  .');

        $rTitle3 = new RCompositeNode();
        $title->addNode($rTitle3);
        $rTitle3->addTextStyle(new ColorStyleNode('2F5496'));
        $rTitle3->addTextStyle(new BoldStyleNode());
        $rTitle3->addTextStyle(new FontSizeStyleNode(14));
        $rTitle3->addText("Audit by");

        $rTitle4 = new RCompositeNode();
        $title->addNode($rTitle4);
        $rTitle4->addTextStyle(new ColorStyleNode('2F5496'));
        $rTitle4->addTextStyle(new FontSizeStyleNode(14));
        $rTitle4->addText(': ' . $data['auditor']['names']);
        $body->addNode($title);

        $title = new PCompositeNode();
        $title->addPNodeStyle(new AlignNode(AlignNode::TYPE_CENTER));
        $rTitle = new RCompositeNode();
        $title->addNode($rTitle);
        $rTitle->addTextStyle(new BoldStyleNode());
        $rTitle->addTextStyle(new ColorStyleNode('2F5496'));
        $rTitle->addTextStyle(new FontSizeStyleNode(14));
        $rTitle->addText("Business Units: ");
        $body->addNode($title);
        foreach ($data['environment'] as $key => $value) {
            $title = new PCompositeNode();
            $title->addPNodeStyle(new AlignNode(AlignNode::TYPE_CENTER));
            $rTitle2 = new RCompositeNode();
            $title->addNode($rTitle2);
            $rTitle2->addTextStyle(new FontSizeStyleNode(12));
            $rTitle2->addText($value['name']);
            $body->addNode($title);
        }

        $body->addNode(new PageBreakNode());
        $details = array();
//        print_pre($data['audit_ar']);
        foreach ($data['audit_ar'] as $key => $value) {
            $details['audit_area'] = $this->auditArea->get($value);
            $details['issues'] = $this->issue->getAllIssuesInAuditArea($value);
//            print_pre($details);

            $title = new PCompositeNode();
            $title->addPNodeStyle(new AlignNode(AlignNode::TYPE_CENTER));
            $rTitle = new RCompositeNode();
            $title->addNode($rTitle);
            $rTitle->addTextStyle(new BoldStyleNode());
            $rTitle->addTextStyle(new ColorStyleNode('2F5496'));
            $rTitle->addTextStyle(new FontSizeStyleNode(14));
            $rTitle->addText('Audit Area');

            $rTitle2 = new RCompositeNode();
            $title->addNode($rTitle2);
            $rTitle2->addTextStyle(new ColorStyleNode('2F5496'));
            $rTitle2->addTextStyle(new FontSizeStyleNode(14));
            $rTitle2->addText(': ' . $details['audit_area']['title']);
            $body->addNode($title);

            if (empty($details['issues'])) {
                $paragraph = new PCompositeNode();
                $rParagraph = new RCompositeNode();
                $paragraph->addNode($rParagraph);
                $rParagraph->addTextStyle(new FontSizeStyleNode(14));
                $rParagraph->addText("No Issues on this Audit Area");
                $body->addNode($paragraph);
            } else {
                foreach ($details['issues'] as $key => $issue_details) {
                    //*****************************************//
                    $paragraph = new PCompositeNode();
                    $paragraph->addPNodeStyle(new AlignNode(AlignNode::TYPE_LEFT));
                    $rParagraph = new RCompositeNode();
                    $paragraph->addNode($rParagraph);
                    $rParagraph->addTextStyle(new BoldStyleNode());
                    $rParagraph->addTextStyle(new FontSizeStyleNode(11));
                    $rParagraph->addText("Issue Title");


                    $rParagraph2 = new RCompositeNode();
                    $paragraph->addNode($rParagraph2);
                    $rParagraph2->addTextStyle(new FontSizeStyleNode(11));
                    $rParagraph2->addText(": " . htmlspecialchars($issue_details['title']));
                    $body->addNode($paragraph);
                    //********************************************//
                    $paragraph = new PCompositeNode();
                    $paragraph->addPNodeStyle(new AlignNode(AlignNode::TYPE_LEFT));
                    $rParagraph = new RCompositeNode();
                    $paragraph->addNode($rParagraph);
                    $rParagraph->addTextStyle(new BoldStyleNode());
                    $rParagraph->addTextStyle(new FontSizeStyleNode(11));
                    $rParagraph->addText("Issue Subheading");


                    $rParagraph2 = new RCompositeNode();
                    $paragraph->addNode($rParagraph2);
                    $rParagraph2->addTextStyle(new FontSizeStyleNode(11));
                    $rParagraph2->addText(": " . $issue_details['issue_subheading']);
                    $body->addNode($paragraph);
                    //*******************************************//
                    $paragraph = new PCompositeNode();
                    $paragraph->addPNodeStyle(new AlignNode(AlignNode::TYPE_LEFT));
                    $rParagraph = new RCompositeNode();
                    $paragraph->addNode($rParagraph);
                    $rParagraph->addTextStyle(new BoldStyleNode());
                    $rParagraph->addTextStyle(new FontSizeStyleNode(11));
                    $rParagraph->addText("Issue Rating");


                    $rParagraph2 = new RCompositeNode();
                    $paragraph->addNode($rParagraph2);
                    $rParagraph2->addTextStyle(new FontSizeStyleNode(11));
                    $rParagraph2->addText(": " . $issue_details['issue_rating']);
                    $body->addNode($paragraph);
                    //*******************************************//
                    $paragraph = new PCompositeNode();
                    $paragraph->addPNodeStyle(new AlignNode(AlignNode::TYPE_LEFT));
                    $rParagraph = new RCompositeNode();
                    $paragraph->addNode($rParagraph);
                    $rParagraph->addTextStyle(new BoldStyleNode());
                    $rParagraph->addTextStyle(new FontSizeStyleNode(11));
                    $rParagraph->addText("Issue Status");


                    $rParagraph2 = new RCompositeNode();
                    $paragraph->addNode($rParagraph2);
                    $rParagraph2->addTextStyle(new FontSizeStyleNode(11));
                    $rParagraph2->addText(": " . $issue_details['issue_status']);
                    $body->addNode($paragraph);
                    //*******************************************//
                    $paragraph = new PCompositeNode();
                    $paragraph->addPNodeStyle(new AlignNode(AlignNode::TYPE_LEFT));
                    $rParagraph = new RCompositeNode();
                    $paragraph->addNode($rParagraph);
                    $rParagraph->addTextStyle(new BoldStyleNode());
                    $rParagraph->addTextStyle(new FontSizeStyleNode(11));
                    $rParagraph->addText("Implication Type");


                    $rParagraph2 = new RCompositeNode();
                    $paragraph->addNode($rParagraph2);
                    $rParagraph2->addTextStyle(new FontSizeStyleNode(11));
                    $rParagraph2->addText(": " . $issue_details['implication_type']);
                    $body->addNode($paragraph);
                    //*******************************************//
                    $paragraph = new PCompositeNode();
                    $paragraph->addPNodeStyle(new AlignNode(AlignNode::TYPE_LEFT));
                    $rParagraph = new RCompositeNode();
                    $paragraph->addNode($rParagraph);
                    $rParagraph->addTextStyle(new BoldStyleNode());
                    $rParagraph->addTextStyle(new FontSizeStyleNode(11));
                    $rParagraph->addText("Issue Owner");


                    $rParagraph2 = new RCompositeNode();
                    $paragraph->addNode($rParagraph2);
                    $rParagraph2->addTextStyle(new FontSizeStyleNode(11));
                    $rParagraph2->addText(": " . $issue_details['issue_owner']['names']);
                    $body->addNode($paragraph);
                    //*******************************************//
                    $paragraph = new PCompositeNode();
                    $paragraph->addPNodeStyle(new AlignNode(AlignNode::TYPE_LEFT));
                    $rParagraph = new RCompositeNode();
                    $paragraph->addNode($rParagraph);
                    $rParagraph->addTextStyle(new BoldStyleNode());
                    $rParagraph->addTextStyle(new FontSizeStyleNode(11));
                    $rParagraph->addText("Observation");


//                    $rParagraph2 = new RCompositeNode();
                    $parser = new HtmlParser($doc);
                    $parser->parse("<b>Observation:</b> <br />" . $issue_details['observation']);
//                    $paragraph->addNode($rParagraph2);
//                    $rParagraph2->addTextStyle(new FontSizeStyleNode(11));
//                    $rParagraph2->addText(": " . $issue_details['observation']);
//                    $body->addNode($paragraph);
                    //*******************************************//
//                    $paragraph = new PCompositeNode();
//                    $paragraph->addPNodeStyle(new AlignNode(AlignNode::TYPE_LEFT));
//                    $rParagraph = new RCompositeNode();
//                    $paragraph->addNode($rParagraph);
//                    $rParagraph->addTextStyle(new BoldStyleNode());
//                    $rParagraph->addTextStyle(new FontSizeStyleNode(11));
//                    $rParagraph->addText("Implication");
//
//
//                    $rParagraph2 = new RCompositeNode();
//                    $paragraph->addNode($rParagraph2);
//                    $rParagraph2->addTextStyle(new FontSizeStyleNode(11));
//                    $rParagraph2->addText(": " . $issue_details['implication']);
//                    $body->addNode($paragraph);
                    //*******************************************//
//                    $paragraph = new PCompositeNode();
//                    $paragraph->addPNodeStyle(new AlignNode(AlignNode::TYPE_LEFT));
//                    $rParagraph = new RCompositeNode();
//                    $paragraph->addNode($rParagraph);
//                    $rParagraph->addTextStyle(new BoldStyleNode());
//                    $rParagraph->addTextStyle(new FontSizeStyleNode(11));
//                    $rParagraph->addText("Recommendation");
//
//
//                    $rParagraph2 = new RCompositeNode();
//                    $paragraph->addNode($rParagraph2);
//                    $rParagraph2->addTextStyle(new FontSizeStyleNode(11));
//                    $rParagraph2->addText(": " . $issue_details['recommendation']);
//                    $body->addNode($paragraph);
                }
            }
            $body->addNode(new PageBreakNode());
        }

        $filename = "{$data['audit']['audit_name']}_" . time();
//        print_pre($data);
        echo '<pre>' . ($doc->getDocument()->getBody()->look()) . '</pre>';
        $doc->saveAs('docs/' . $filename . '.docx');
    }

    function align() {


        $doc = new VsWord();

        $paragraph = new PCompositeNode();
        $paragraph->addPNodeStyle(new AlignNode(AlignNode::TYPE_RIGHT));
        $paragraph->addText("Some more text ... More text about... Some more text ... More text about... Some more text ... More text about...");
        $doc->getDocument()->getBody()->addNode($paragraph);

        $paragraph = new PCompositeNode();
        $paragraph->addPNodeStyle(new AlignNode(AlignNode::TYPE_LEFT));
        $paragraph->addText("Some more text ... More text about... Some more text ... More text about... Some more text ... More text about...");
        $doc->getDocument()->getBody()->addNode($paragraph);

        $paragraph = new PCompositeNode();
        $paragraph->addPNodeStyle(new AlignNode(AlignNode::TYPE_CENTER));
        $paragraph->addText("Some more text ... More text about... Some more text ... More text about... Some more text ... More text about...");
        $doc->getDocument()->getBody()->addNode($paragraph);

        $paragraph = new PCompositeNode();
        $paragraph->addPNodeStyle(new AlignNode(AlignNode::TYPE_BOTH));
        $paragraph->addText("Some more text ... More text about... Some more text ... More text about... Some more text ... More text about...");
        $doc->getDocument()->getBody()->addNode($paragraph);
        /**/
        echo '<pre>' . ($doc->getDocument()->getBody()->look()) . '</pre>';

        $doc->saveAs('docs/align.docx');
    }

    function base() {


        $doc = new VsWord();
        $body = $doc->getDocument()->getBody();

        $title = new PCompositeNode();
        $rTitle = new RCompositeNode();
        $title->addNode($rTitle);
        $rTitle->addTextStyle(new BoldStyleNode());
        $rTitle->addTextStyle(new FontSizeStyleNode(36));
        $rTitle->addText("Header 1");
        $body->addNode($title);

        $paragraph = new PCompositeNode();
        $rParagraph = new RCompositeNode();
        $paragraph->addNode($rParagraph);
        $rParagraph->addTextStyle(new FontSizeStyleNode(14));
        $rParagraph->addText("Some more text ... More text about... Some more text ... More text about... Some more text ... More text about...");
        $body->addNode($paragraph);

        $paragraph2 = new PCompositeNode();
        $rParagraph2 = new RCompositeNode();
        $paragraph2->addNode($rParagraph2);
        $rParagraph2->addTextStyle(new FontSizeStyleNode(14));
        $rParagraph2->addText("Some more text ... More text about... Some more text ... More text about... Some more text ... More text about...");


        $rParagraph3 = new RCompositeNode();
        $paragraph2->addNode($rParagraph3);
        $rParagraph3->addTextStyle(new FontSizeStyleNode(11));
        $rParagraph3->addTextStyle(new ItalicStyleNode());
        $rParagraph3->addText('Italic text');

        $body->addNode($paragraph2);


        $doc->saveAs('docs/base.docx');
    }

    function pagebreak() {


        $doc = new VsWord();
        $body = $doc->getDocument()->getBody();

        $title = new PCompositeNode();
        $rTitle = new RCompositeNode();
        $title->addNode($rTitle);
        $rTitle->addTextStyle(new BoldStyleNode());
        $rTitle->addTextStyle(new FontSizeStyleNode(36));
        $rTitle->addText("Header 1");
        $body->addNode($title);

        $body->addNode(new PageBreakNode());

        $title = new PCompositeNode();
        $rTitle = new RCompositeNode();
        $title->addNode($rTitle);
        $rTitle->addTextStyle(new BoldStyleNode());
        $rTitle->addTextStyle(new FontSizeStyleNode(36));
        $rTitle->addText("Header 2");
        $body->addNode($title);


        $doc->saveAs('docs/pagebreak.docx');
    }

    function table2() {


        $data = array(
            array(
                "Name" => "A. Pushkin",
                "Age" => "31",
                "Phone" => "none",
                "Address" => "SPb, pr. Moyki 17",
                "Mail" => "none",
            ),
            array(
                "Name" => "M. Ivanov",
                "Age" => "54",
                "Phone" => "521-8798",
                "Address" => "Moskov, pr. Lenina 56",
                "Mail" => "m.ivanov@info.com",
            ),
            array(
                "Name" => "M. Chernova",
                "Age" => "23",
                "Phone" => "+7-911-7865421",
                "Address" => "Penza, pr. Lenina 12",
                "Mail" => "none",
            ),
            array(
                "Name" => "V. Ut",
                "Age" => "34",
                "Phone" => "none",
                "Address" => "SPb, pr. Lenina 12",
                "Mail" => "none",
            ),
        );



        $doc = new VsWord();
        $body = $doc->getDocument()->getBody();

        $table = new TableCompositeNode();
        $body->addNode($table);
        $style = new TableStyle(1);
        $table->setStyle($style);
        $doc->getStyle()->addStyle($style);

        $first = TRUE;
        foreach ($data as $item) {

            if ($first) {//add header
                $tr = new TableRowCompositeNode();
                $table->addNode($tr);
                foreach ($item as $key => $value) {
                    $col = new TableColCompositeNode();
                    $tr->addNode($col);

                    $rTitle = new RCompositeNode();
                    $col->getLastPCompositeNode()->addNode($rTitle);
                    $rTitle->addTextStyle(new BoldStyleNode());
                    $rTitle->addTextStyle(new FontSizeStyleNode(18));
                    $rTitle->addText($key);
                }
                $first = false;
            }

            $tr = new TableRowCompositeNode();
            $table->addNode($tr);
            foreach ($item as $key => $value) {

                if ($key == "Mail") {
                    $col = new TableColCompositeNode();
                    $tr->addNode($col);
                    $link = new HyperlinkCompositeNode();
                    $rLink = new RCompositeNode();
                    $rLink->addText($value);
                    $link->addNode($rLink);
                    $col->getLastPCompositeNode()->addNode($link);
                    $col->getLastPCompositeNode()->addNode(new BrNode());
                } else {
                    $col = new TableColCompositeNode();
                    $col->addText($value);
                    $col->getLastPCompositeNode()->addNode(new BrNode());
                    $tr->addNode($col);
                }
            }
        }

        echo '<pre>' . ($doc->getDocument()->getBody()->look()) . '</pre>';

        $doc->saveAs('docs/table2.docx');
    }

    function table() {
        $doc = new VsWord();
        $body = $doc->getDocument()->getBody();

        $table = new TableCompositeNode();
        $body->addNode($table);
        $style = new TableStyle(1);
        $table->setStyle($style);
        $doc->getStyle()->addStyle($style);

//add row
        $tr = new TableRowCompositeNode();
        $table->addNode($tr);
//add cols
        $col = new TableColCompositeNode();
        $col->addText("Large text... Large text...Large text...Large text...Large text...Large text...Large text...");
        $col->getLastPCompositeNode()->addNode(new BrNode());
        $tr->addNode($col);

        $col = new TableColCompositeNode();
        $col->addText("Large text... Large text...Large text...Large text...Large text...Large text...Large text...");
        $col->getLastPCompositeNode()->addNode(new BrNode());
        $tr->addNode($col);
//add row
        $tr = new TableRowCompositeNode();
        $table->addNode($tr);

        $col = new TableColCompositeNode();
        $tr->addNode($col);

        $list = new ListCompositeNode();
        $col->addNode($list);
        $col->getLastPCompositeNode()->addNode(new BrNode());

        for ($i = 1; $i <= 10; $i ++) {
            $item = new ListItemCompositeNode();
            $item->addText("List item $i");
            $list->addNode($item);
        }

//add image in col
        $attach = $doc->getAttachImage(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'img1.jpg');
        $drawingNode = new DrawingNode();
        $drawingNode->addImage($attach);

        $col = new TableColCompositeNode();
        $tr->addNode($col);
        $col->getLastPCompositeNode()->addNode($drawingNode);


        $doc->saveAs('docs/table.docx');
    }

    function htmlparser_yourstyle() {
        $doc = new VsWord();
        $parser = new HtmlParser($doc);
        $parser->addHandlerInitNode(new MyInitNode());

        $parser->parse('<p class="BigText">Image 1</p><br/><img  alt="image1" src="img1.jpg"><i>The cat =)</i>');

        echo '<pre>' . ($doc->getDocument()->getBody()->look()) . '</pre>';

        $doc->saveAs('docs/htmlparser_yourstyle.docx');
    }

}

class MyInitNode implements IInitNode {

    /**
     * @param string $tagName
     * @param mixed $attributes
     * @return Node
     */
    function initNode($tagName, $attributes) {
        if ($tagName == 'p' && isset($attributes['class']) && $attributes['class'] == 'BigText') {
            $p = new PCompositeNode();
            $r = new RCompositeNode();
            $p->addNode($r);
            $r->addTextStyle(new BoldStyleNode());
            $r->addTextStyle(new FontSizeStyleNode(36));
            return $p

            ;
        }
        return NULL;
    }

}
