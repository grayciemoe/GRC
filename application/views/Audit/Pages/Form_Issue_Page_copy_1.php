<link href="<?= base_url("assets/plugins/multiselect/css/multi-select.css") ?>"  rel="stylesheet" type="text/css" />
<link href="<?= base_url("assets/plugins/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css" />
<?php
$issue = $data['issue'];
$audit_ar = jsonToArray($data['audit_details']['audit_area']);
//print_pre($audit_ar);
//print_pre($data);
//exit;
//$recommendation = $data['recommendation'];
?>
<style>
    #uplon_wizard .nav ul li,
    #uplon_wizard .nav ul {
        list-style: none; 
        margin: 0; 
        padding: 0;
    }
    #uplon_wizard .nav ul li {
        float: left; 
        width: 25% ;
        border: 1px solid #eee;
        padding: 10px;
        text-align: center;
        font-weight: bold;
        border-right: none;
        cursor: pointer;
    }
    #uplon_wizard .nav ul li.active {
        background: #eee;

    }
    #uplon_wizard .nav ul li:last-of-type {
        border-right: 1px solid #eee;
    }
    #uplon_wizard .nav {
        margin-bottom: 20px;
    }
    .wiz_item{ display: none;}
    .wiz_item.active{ 
        display: block;
    }
    #drafting {
        padding: 10px;
    }
</style>
<?= form_open_multipart("Audit/issuePost", array('id' => 'frm_issue_form', 'class' => '')) ?>
<input type='hidden' class='form-control'  name='id' id='txt-issue-id' value='<?= $issue['id'] ?>' />
<input hidden class='form-control'  name='audit' id='txt-issue-id' value='<?= $data['audit'] ?>' />

<div class='container-fluid'>
    <div class='card card-box'>
        <div class='card-title'>
            <h4><?= $issue['draft'] == 0 ? "Edit" : "Add" ?> Issue </h4>
        </div>
        <hr />
        <div class="row">
            <div id="uplon_wizard">
                <div class="nav">
                    <ul>
                        <li class="wiz_nav active" data-target="1" id="cmd_1">Basic Information</li>
                        <li class="wiz_nav " data-target="2" id="cmd_2">Observation & Implication</li>
                        <li class="wiz_nav " data-target="3" id="cmd_3">Risk</li>
                        <li class="wiz_nav " data-target="4" id="cmd_4">Attachments</li>
                        <div class="clearfix"></div>
                    </ul>
                </div>
                <div class="wizard_content">
                    <div class="wiz_item active " id="tab_1">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class='form-group'>
                                    <label  for="txt-issue-title"  class='col-sm-12 form-control-label'>Issue Title</label>
                                    <div class='col-sm-12'>
                                        <input type='text' class='form-control' onchange="draftSystem();"  name='title'  required=''  id='txt-issue-title' value='<?= $issue['title'] ?>' placeholder='Issue Title' />
                                        <small class="text-danger" id="txt-issue-title-val"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">

                            <div class='form-group'>
                                <label  for="txt-issue-audit_area"  class='col-sm-12 form-control-label'>Audit Area
                                    <a class="pull-right" href="<?= base_url('index.php/Audit/auditAreaForm/0/' . $issue['corporate'] . '/' . $issue['id'] . '/issue') ?>" <?= MODAL_LINK ?>>Add An Audit Area</a>
                                </label>
                                <div class='col-sm-12'>
                                    <select class="form-control select2"  required id="txt-issue-audit_area"   name="audit_area" onchange="draftSystem();">

                                        <?php
                                        $x = 0;
                                        $y = 0;
                                        foreach ($audit_ar as $key => $auditArId):
                                            foreach ($data['audit_areas'] as $key => $value):
                                                if ($auditArId == $value['id']):
                                                    ?>
                                                    <option <?php
//                                                    if ($audit_ar[0] == $value['id']) {
//                                                        echo "Selected";
//                                                    } else {
//                                                        NULL;
//                                                    }
                                                    ?>  value="<?= $value['id'] ?>"><?= $value['title'] ?></option>

                                                    <?php
                                                    $x++;
                                                    $y++;
                                                endif;
                                            endforeach;
                                        endforeach;
                                        ?>
                                    </select>
                                    <small class="text-danger" id="txt-issue-audit_area-val"></small>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label  for="txt-issue-issue_owner"  class='col-sm-12 form-control-label'>Issue Owner</label>
                                <div class='col-sm-12'>
                                    <select  class='form-control' name='issue_owner' required  onchange="draftSystem();"  id='txt-issue-issue_owner'> 
                                        <option value=''>SELECT</option>
                                        <?php
                                        foreach ($data['unit_owners'] as $key => $value):
                                            $select = $value['id'] == $issue['issue_owner'] ? "selected='selected'" : NULL;
                                            ?>   
                                            <option value='<?= $value['id'] ?>' <?= $select ?> >  <?= $value['names'] ?> </option>
<?php endforeach; ?>
                                    </select>
                                    <small class="text-danger" id="txt-issue-issue_owner-val"></small>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label  for="txt-issue-issue_subheading"  class='col-sm-12 form-control-label'>Issue Subheading</label>
                                <div class='col-sm-12'>
                                    <input type='text' class='form-control'  onchange="draftSystem();"  name='issue_subheading' id='txt-issue-issue_subheading' value='<?= $issue['issue_subheading'] ?>' placeholder='Issue Subheading' />
                                    <small class="text-danger" id="txt-issue-issue_subheading-val"></small>
                                </div>
                            </div>




                        </div>
                        <div class="col-sm-7">

                            <div class='form-group'>
                                <label  for="txt-issue-issue_rating"  class='col-sm-12 form-control-label'>Issue Rating</label>
                                <div class='col-sm-12'>
                                    <select  class='form-control' required=""  name='issue_rating' id='txt-issue-issue_rating'>
                                        <option value=''>SELECT</option>
                                        <option <?= $issue['issue_rating'] == 'Low' ? "selected='selected'" : NULL; ?> value='Low'>Low</option>
                                        <option <?= $issue['issue_rating'] == 'Moderate' ? "selected='selected'" : NULL; ?> value='Moderate'>Moderate</option>
                                        <option <?= $issue['issue_rating'] == 'High' ? "selected='selected'" : NULL; ?> value='High'>High</option>
                                        <option <?= $issue['issue_rating'] == 'Critical' ? "selected='selected'" : NULL; ?> value='Critical'>Critical</option>
                                    </select>
                                </div>
                                <small class="text-danger" id="txt-issue-issue_rating-val"></small>
                            </div>

                            <div class='form-group'>
                                <label  for="txt-issue-issue_status"  class='col-sm-12 form-control-label'>Issue Status</label>
                                <div class='col-sm-12'>
                                    <select class='form-control'  onchange="draftSystem();" required=""  name='issue_status' id='txt-issue-issue_status' >
                                        <option value=''>SELECT</option>
                                        <option <?= $issue['issue_status'] == 'Open' ? "selected='selected'" : NULL; ?> value="Open">Open</option>
                                        <option <?= $issue['issue_status'] == 'Closed' ? "selected='selected'" : NULL; ?> value="Closed">Closed</option>
                                    </select>
                                </div>
                                <small class="text-danger" id="txt-issue-issue_status-val"></small>
                            </div>


                            <!--                            <div class='form-group'>
                                                            <label  for="txt-issue-review_date"  class='col-sm-12 form-control-label'>Review Date</label>
                                                            <div class='col-sm-12'>
                                                                <input type='date' class='form-control' onchange="draftSystem();"    
                                                                       name='review_date'   id='txt-issue-review_date' 
                                                                       value='<?php // strftime("%Y-%m-%d", strtotime($issue['review_date']))     ?>' />
                                                            </div>
                                                            <small class="text-danger" id="txt-issue-review_date-val"></small>
                                                        </div>-->

                        </div>
                    </div>
                    <div class="wiz_item" id="tab_2">
                        <div class='form-group'>
                            <label  for="txt-issue-observation"  class='col-sm-12 form-control-label'>Observation</label>
                            <div class='col-sm-12'>
                                <textarea class='form-control wysiwyg' onchange="draftSystem();"  rows="10" name='observation' id='txt-issue-observation' placeholder='observation' ><?= $issue['observation'] ?></textarea>
                            </div>
                        </div>
                        <div class='form-group'>
                            <label  for="txt-issue-implication"  class='col-sm-12 form-control-label'>Implication</label>
                            <div class='col-sm-12'>
                                <textarea class='form-control wysiwyg' onchange="draftSystem();" rows="10" name='implication' id='txt-issue-implication' placeholder='implication' ><?= $issue['implication'] ?></textarea>
                            </div>
                        </div>
                        <div class='form-group'>
                            <label  for="txt-issue-implication_type"  class='col-sm-12 form-control-label m-t-15'>Implication Type</label>
                            <div class='col-sm-12'>
                                <select class='form-control m-b-15'  onchange="draftSystem();" required=""  name='implication_type' id='txt-issue-implication_type' >
                                    <option value='' <?= empty($issue['implication_type']) ? "selected='selected'" : NULL; ?>>SELECT</option>
                                    <option <?= $issue['implication_type'] == 'Loss of Opportunity' ? "selected='selected'" : NULL; ?> value="Loss of Opportunity">Loss of Opportunity</option>
                                    <option <?= $issue['implication_type'] == 'Risk Exposure' ? "selected='selected'" : NULL; ?> value="Risk Exposure">Risk Exposure</option>
                                    <option <?= $issue['implication_type'] == 'Actual Loss' ? "selected='selected'" : NULL; ?> value="Actual Loss">Actual Loss</option>
                                </select>
                            </div>
                            <small class="text-danger" id="txt-issue-implication_type-val"></small>

                        </div>

                        <div class='form-group'>
                            <label  for="txt-issue-recommendation"  class='col-sm-12 form-control-label'>Recommendation</label>
                            <div class='col-sm-12'>
                                <textarea class='form-control wysiwyg' onchange="draftSystem();"  rows="10" name='recommendation' id='txt-issue-recommendation' placeholder='recommendation' ><?= $issue['recommendation'] ?></textarea>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class="col-sm-12 m-t-30">
                                <label>Does this Issue <b>Require</b> an Action Plan?</label>
                                <div class="radio radio-info radio-inline m-l-5">
                                    <input onchange="draftSystem();" type="radio" required id="inlineRadio2" value="yes" name="action_plan_required" <?= $issue['action_plan_required'] == "yes" ? "checked" : "" ?>>
                                    <label for="inlineRadio2"> Yes </label>
                                </div>
                                <div class="radio radio-inline">
                                    <input onchange="draftSystem();" type="radio" required id="inlineRadio1" value="no" name="action_plan_required" <?= $issue['action_plan_required'] == "no" ? "checked" : "" ?>>
                                    <label for="inlineRadio1"> No </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wiz_item" id="tab_3">
                        <input type="hidden" value="<?= $issue['risk_associated']; ?>" id="txt-im-risk-actual" name="" />

                        <div class='form-group '>
                            <label  for="txt-issue-risk_category"  class='form-control-label'> Risk Category</label>
                            <div class='col-sm-12'>
                                <select class="form-control select2"  id="risk_category_audit"   name="risk_category" onchange="searchRisksInCategoryOptions(this.value)" >
                                    <option value="">Select Risk Category</option>
                                    <?php foreach ($data['categories'] as $key => $value): ?>
                                        <option <?php
                                        if ($issue['risk_category'] == $value['id']) {
                                            echo "Selected";
                                        } else {
                                            NULL;
                                        }
                                        ?>  value="<?= $value['id'] ?>"><?= $value['title'] ?></option>

<?php endforeach; ?>
                                </select>
                            </div>
                            <small class="text-danger" id="txt-issue-risk_category-val"></small>
                        </div>
                        <div class='form-group  <?= $issue['risk_category'] == NULL ? "hidden" : ""; ?>' id="risk_assoc">
                            <label  for="txt-issue-undefined_risk_title"  class='form-control-label col-sm-12'>

                                <a class="pull-right" href="<?= base_url("index.php/Risk/riskProposeAudit/") ?>" id="propose_risk" <?= MODAL_LINK ?>>Propose Risk</a>

                                Risk Associated </label>
        <!--                    <input type="text" name="risk[]" id="actual_risk_id" value="" onchange="searchRisksInCategoryOptions(document.getElementById('risk_category_audit').value)" />
                            <input type="text" class="form-control" name="[]"  id="action_risk_label"/>-->


                            <div class='col-sm-12' id="cover-risk-dropdown">
                                <select class="form-control multi-select" multiple="" data-plugin="multiselect" id="txt-im-risk" onchange="draftSystem();" name="risk_associated[]">

                                </select>
                            </div>
                            <small class="text-danger" id="txt-issue-risk-val"></small>

                        </div>

                    </div>
                    <div class="wiz_item" id="tab_4">
<?= files_upload("audit", "issue", $issue['id']); ?>
                    </div>
                </div>
            </div>
            <pre id="responce_pre"></pre>
            <input id="track" type="hidden" value="1"/>
        </div>
<?= form_close(); ?>
        <div class="card-block" style="
             padding-bottom: 40px;
             ">
            <hr />
            <div class="btn-group pull-left">
                <button type='button' id="cmd_prev" class='btn btn-secondary waves-effect'>Previous</button>
                <button type='button' id="cmd_next" class='btn btn-secondary waves-effect'>Next</button>
            </div>
            <div class="hidden pull-left" id="drafting"><span class="fa icon icon-hourglass fa-spin"></span> Drafting</div>

            <div class="btn-group pull-right">

                <?php if ($issue['draft'] == 0) { ?>
                    <a class='btn btn-secondary btn-sm waves-effect waves-light pull-right' href="<?= base_url("index.php/Audit/issue/{$issue['id']}") ?>"> Cancel </a>

                <?php } else { ?>
                    <a class='btn btn-secondary btn-sm waves-effect waves-light pull-right' href="<?= base_url("index.php/Audit/deleteIssue/{$issue['id']}/true") ?>"> Discard Draft </a>
                    <a class='btn btn-sm btn-secondary waves-effect' href="<?= base_url("index.php/Audit/audit/{$issue['audit']}") ?>" >Save Draft</a>
<?php } ?>
                <button type='submit' class='btn btn-sm btn-primary waves-effect' onclick="validate_issue()">Save </button>
            </div>
        </div>
    </div>
</div><!-- /.col-md-12 -->


<script>
<?php
foreach ($data['categories'] as $key => $value) {
    if ($issue['risk_category'] == $value['id']) {
        echo "window.onload = function() {
  searchRisksInCategoryOptions({$value['id']});
};";
    } else {
        NULL;
    }
}
?>
    CKEDITOR.replace('txt-issue-recommendation');
    CKEDITOR.replace('txt-issue-observation');
    CKEDITOR.replace('txt-issue-implication');



    function discardDraft() {
        document.getElementById('frm_issue_form').reset();
        draftSystem();
    }
    for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].on('change', function () {
            draftSystem();
        });
    }


    function draftSystem() {

        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        $("#drafting").removeClass("hidden");
        var url = "<?= base_url("index.php/Audit/issueDraft/") ?>";
        var formId = "frm_issue_form";
        $.post(url, $("#" + formId).serialize(), function (response) {
//            alert(response);
            $("#drafting").addClass("hidden");
        });
    }

    function validate_issue() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
            //alert("Me");
        }


        var flag = true;




        if (!$('#txt-issue-title').val()) {
            $("#txt-issue-title-val").html("The issue title is required");
            wiz_nav_to(1);
            flag = false;
        } else {
            $("#txt-issue-title-val").html("");
        }

        if (!$('#txt-issue-audit_area').val()) {
            $("#txt-issue-audit_area-val").html("The Audit Area is required");
            wiz_nav_to(1);
            flag = false;
        } else {
            $("#txt-issue-audit_area-val").html("");
        }

        if (!$('#txt-issue-issue_rating').val()) {
            $("#txt-issue-issue_rating-val").html("Please select an Issue Rating");
            wiz_nav_to(1);
            flag = false;
        } else {
            $("#txt-issue-issue_rating-val").html("");
        }


        if (!$('#txt-issue-issue_owner').val()) {
            $("#txt-issue-issue_owner-val").html("Please select an Issue Owner");
            wiz_nav_to(1);
            flag = false;
        } else {
            $("#txt-issue-issue_owner-val").html("");
        }


        if (!$('#txt-issue-issue_status').val()) {
            $("#txt-issue-issue_status-val").html("Please select the issue status");
            wiz_nav_to(1);
            flag = false;
        } else {
            $("#txt-issue-issue_status-val").html("");
        }

        if (!$('#txt-issue-implication_type').val()) {
            $("#txt-issue-implication_type-val").html("Please select an implication type");
            wiz_nav_to(2);
            flag = false;
        } else {
            $("#txt-issue-implication_type-val").html("");
        }

        return flag;

    }

</script>
<!-- -->

<script type="text/javascript" src="<?= base_url("assets/plugins/multiselect/js/jquery.multi-select.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/plugins/jquery-quicksearch/jquery.quicksearch.js") ?>"></script>
<script src="<?= base_url("assets/plugins/select2/js/select2.full.min.js") ?>"></script>

<script>


    $(document).ready(function () {
        $(".multi-select").multiSelect();

    });
    function searchRisksInCategoryOptions(category_id) {
//        alert(category_id);
        $('#risk_assoc').removeClass('hidden');
        $("#txt-im-risk").html("<option>Please Wait..</option>");
        $("#propose_risk").attr("href", "<?= base_url("index.php/Risk/riskProposeAudit/{$issue['audit']}/{$issue['id']}/") ?>" + category_id);
        var url = "<?= base_url("index.php/Risk/searchRisksInCategoryOptionsAudit/{$issue['id']}/") ?>" + category_id;
        draftSystem();
        $.post(url, {data: "modal"}, function (response) {
            if (response) {
//                alert(response);
                $('.multi-select').empty().multiSelect('refresh');
                $("#txt-im-risk").html(response);
                $('.multi-select').multiSelect('refresh');
            } else {
//                $("#txt-im-risk").html("<option>No Risks Found</option>");
            }
        })
    }

    $('#cmd_next').click(function () {
        var pos = $("#track").val();
        if (pos >= 4) {
            pos = 1;
        } else {
            pos++;
        }
        $("#track").val(pos);
        var tab_id = "#tab_" + pos;
        var cmd_id = "#cmd_" + pos;
        $('.wiz_nav').removeClass('active');
        $('.wiz_item').removeClass('active');
        $(tab_id).addClass('active');
        $(cmd_id).addClass('active');
    });

    $('#cmd_prev').click(function () {
        var pos = $("#track").val();
        if (pos <= 1) {
            pos = 4;
        } else {
            pos--;
        }
        $("#track").val(pos);
        var tab_id = "#tab_" + pos;
        var cmd_id = "#cmd_" + pos;
        $('.wiz_nav').removeClass('active');
        $('.wiz_item').removeClass('active');
        $(tab_id).addClass('active');
        $(cmd_id).addClass('active');

    });


    $('.wiz_nav').click(function () {
        var pos = $(this).data("target");
        //alert(pos);
        $("#track").val(pos);
        var tab_id = "#tab_" + pos;
        var cmd_id = "#cmd_" + pos;
        $('.wiz_nav').removeClass('active');
        $('.wiz_item').removeClass('active');
        $(tab_id).addClass('active');
        $(cmd_id).addClass('active');

    });

    function wiz_nav_to(target) {
        var pos = target;
        $("#track").val(pos);
        var tab_id = "#tab_" + pos;
        var cmd_id = "#cmd_" + pos;
        $('.wiz_nav').removeClass('active');
        $('.wiz_item').removeClass('active');
        $(tab_id).addClass('active');
        $(cmd_id).addClass('active');

    }

</script>
