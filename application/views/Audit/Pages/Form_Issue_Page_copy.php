
<link href="<?= base_url("assets/plugins/multiselect/css/multi-select.css") ?>"  rel="stylesheet" type="text/css" />
<link href="<?= base_url("assets/plugins/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css" />
<?php
$issue = $data['issue'];
?>
<?= form_open_multipart("Audit/issuePost", array('id' => 'frm_issue_form', 'class' => 'form-vertical')) ?>
<input type='hidden' class='form-control'  name='id' id='txt-issue-id' value='<?= $issue['id'] ?>' />

<div class='container-fluid'>
    <div class='card card-box'>
        <div class='card-title'>
            <h4> 
                <div class="btn-group pull-right">

                    <?php if ($issue['draft'] != 0): ?>
                        <a class='btn btn-secondary btn-sm waves-effect waves-light pull-right' href="<?= base_url("index.php/Audit/issueDelete/{$issue['id']}/true") ?>"> Cancel </a>
                    <?php endif; ?>
                    <button type='button' class='btn btn-sm btn-secondary waves-effect' data-dismiss='modal'>Save Draft</button>
                    <button type='submit' class='btn btn-sm btn-primary waves-effect'>Save </button>
                </div>
                <?= $issue['draft'] == 0 ? "Edit" : "Add" ?> Issue </h4>
        </div>
        <hr />
        <div class="row">

            <div class="alert alert-danger hidden" id="js_response"></div>
            <div class="col-sm-5">
                <div class='form-group'>
                    <label  for="txt-issue-title"  class='col-sm-12 form-control-label'>Title</label>
                    <div class='col-sm-12'>
                        <input type='text' class='form-control' onchange="draftSystem();"  name='title'  required=''  id='txt-issue-title' value='<?= $issue['title'] ?>' placeholder='title' />
                    </div>
                </div>
                <div class='form-group'>
                    <label  for="txt-issue-risk_area"  class='col-sm-12 form-control-label'>Risk Area</label>
                    <div class='col-sm-12'>
                        <input type='text' class='form-control'  onchange="draftSystem();"  name='risk_area' id='txt-issue-risk_area' value='<?= $issue['risk_area'] ?>' placeholder='risk_area' />
                    </div>
                </div>
                <div class='form-group'>
                    <label  for="txt-issue-issue_subheading"  class='col-sm-12 form-control-label'>Issue Subheading</label>
                    <div class='col-sm-12'>
                        <input type='text' class='form-control'  onchange="draftSystem();"  name='issue_subheading' id='txt-issue-issue_subheading' value='<?= $issue['issue_subheading'] ?>' placeholder='Issue Subheading' />
                    </div>
                </div>
                <div class='form-group'>
                    <label  for="txt-issue-rating"  class='col-sm-12 form-control-label'>Issue Rating</label>
                    <div class='col-sm-12'>
                        <select  class='form-control' required=""  name='issue_rating' id='txt-issue-issue_rating'>
                            <option value=''>SELECT</option>
                            <option <?= $issue['issue_rating'] == 'Low' ? "selected='selected'" : NULL; ?> value='Low'>Low</option>
                            <option <?= $issue['issue_rating'] == 'Moderate' ? "selected='selected'" : NULL; ?> value='Moderate'>Moderate</option>
                            <option <?= $issue['issue_rating'] == 'High' ? "selected='selected'" : NULL; ?> value='High'>High</option>
                            <option <?= $issue['issue_rating'] == 'Critical' ? "selected='selected'" : NULL; ?> value='Critical'>Critical</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" value="<?= $issue['risk_associated']; ?>" id="txt-im-risk-actual" name="" />

                <div class='form-group '>
                    <label  for="txt-issue-risk_category"  class='form-control-label'> Risk Category</label>
                    <div class='col-sm-12'>
                        <select class="form-control select2"  required id="risk_category_audit"   name="risk_category" onchange="searchRisksInCategoryOptions(this.value)" >
                            <option value="">Select Risk Category</option>
                            <?php foreach ($data['categories'] as $key => $value): ?>
                                <option <?= $issue['risk_category'] == $value['id'] ? "selected='selected'" : NULL; ?>  value="<?= $value['id'] ?>"><?= $value['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class='form-group <?= $issue['risk_category'] == NULL ? "hidden" : ""; ?>' id="risk_assoc">
                    <label  for="txt-issue-undefined_risk_title"  required class='form-control-label col-sm-12'>

                        <a class="pull-right" href="<?= base_url("index.php/Risk/riskProposeAudit/") ?>" id="propose_risk" <?= MODAL_LINK ?>>Propose Risk</a>

                        Risk Associated </label>
<!--                    <input type="text" name="risk[]" id="actual_risk_id" value="" onchange="searchRisksInCategoryOptions(document.getElementById('risk_category_audit').value)" />
                    <input type="text" class="form-control" name="[]"  id="action_risk_label"/>-->
                    

                    <div class='col-sm-12' id="cover-risk-dropdown">
                        <select class="form-control multi-select" multiple="" data-plugin="multiselect" required id="txt-im-risk"  name="risk_associated[]">
                            <!--<optgroup label="Risk Proposed">-->
                            <?php //foreach ($data['risks_proposed'] as $key => $value): ?>
                                <!--<option  <?= $issue['risk_associated'] == $value['id'] ? "selected='selected'" : NULL; ?>  value="<?= $value['id'] ?>"><?= $value['title'] ?></option>-->
                            <?php //endforeach; ?>
                            <!--</optgroup>-->
<!--                            <optgroup label="Approved Risks">
                            <?php //foreach ($data['risks_approved'] as $key => $value): ?>
                                <option  <?= $issue['risk_associated'] == $value['id'] ? "selected='selected'" : NULL; ?>  value="<?= $value['id'] ?>"><?= $value['title'] ?></option>
                            <?php //endforeach; ?>
                            </optgroup>-->
                        </select>
                    </div>

                </div>
                <div class='form-group'>
                    <label  for="txt-issue-action_date"  class='col-sm-12 form-control-label'>Action Date</label>
                    <div class='col-sm-12'>
                        <input type='date' class='form-control'  onchange="draftSystem();" name='audit_date'  id='txt-issue-action_date' 
                               value='<?= strftime("%Y-%m-%d", strtotime($issue['action_date'])) ?>' />
                        <small class="text-danger" id="notification_message"></small>
                    </div>
                </div>
                <div class='form-group'>
                    <label  for="txt-issue-action_by"  class='col-sm-12 form-control-label'>Action By</label>
                    <div class='col-sm-12'>
                        <input type='text' class='form-control'  onchange="draftSystem();"  name='action_by' id='txt-issue-action_by' value='<?= $issue['action_by'] ?>' placeholder='Action By' />
                    </div>
                </div>
                <div class='form-group'>
                    <label  for="txt-issue-action_status"  class='col-sm-12 form-control-label'>Action Plan Status</label>
                    <div class='col-sm-12'>
                        <select class='form-control'  onchange="draftSystem();" required=""  name='action_plan_status' id='txt-issue-action_plan_status' >
                            <option value=''>SELECT</option>
                            <option <?= $issue['action_plan_status'] == 'Outstanding' ? "selected='selected'" : NULL; ?> value="Outstanding">Outstanding</option>
                            <option <?= $issue['action_plan_status'] == 'Implemented' ? "selected='selected'" : NULL; ?> value="Implemented">Implemented</option>
                            <option <?= $issue['action_plan_status'] == 'Unverified' ? "selected='selected'" : NULL; ?> value="Unverified">Unverified</option>
                            <option <?= $issue['action_plan_status'] == 'Superseded' ? "selected='selected'" : NULL; ?> value="Superseded">Superseded</option>
                            <option <?= $issue['action_plan_status'] == 'Not Adopted' ? "selected='selected'" : NULL; ?> value="Not Adopted">Not Adopted</option>
                        </select>
                    </div>
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
                </div>
                <div class='form-group'>
                    <label  for="txt-issue-implication_type"  class='col-sm-12 form-control-label'>Implication Type</label>
                    <div class='col-sm-12'>
                        <select class='form-control'  onchange="draftSystem();" required=""  name='implication_type' id='txt-issue-implication_type' >
                            <option value=''>SELECT</option>
                            <option <?= $issue['implication_type'] == 'Loss of Opportunity' ? "selected='selected'" : NULL; ?> value="Loss of Opportunity">Loss of Opportunity</option>
                            <option <?= $issue['implication_type'] == 'Risk Exposure' ? "selected='selected'" : NULL; ?> value="Risk Exposure">Risk Exposure</option>
                        </select>
                    </div>
                </div>

                <div class='form-group'>
                    <label  for="txt-issue-review_date"  class='col-sm-12 form-control-label'>Review Date</label>
                    <div class='col-sm-12'>
                        <input type='date' class='form-control' onchange="draftSystem();"    
                               name='review_date'   id='txt-issue-review_date' 
                               value='<?= strftime("%Y-%m-%d", strtotime($issue['review_date'])) ?>' />
                    </div>
                </div>
            </div>
            <div class="col-sm-7">
                <div class='form-group'>
                    <label  for="txt-issue-description"  class='col-sm-12 form-control-label'>Description</label>
                    <div class='col-sm-12'>
                        <textarea class='form-control wysiwyg' onchange="draftSystem();"  rows="10" name='description' id='txt-issue-description' placeholder='description' ><?= $issue['description'] ?></textarea>
                    </div>
                </div>
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
            </div>
        </div>

        <div class="card-block">
            <hr />
            <div id="drafting" class="loading hidden"><i class="icon icon-pencil fa fa-spin "></i> Drafting ...</div>
            <div class="btn-group pull-right">

                <?php if ($issue['draft'] != 0): ?>
                    <a class='btn btn-secondary btn-sm waves-effect waves-light pull-right' href="<?= base_url("index.php/Audit/issueDelete/{$issue['id']}/true") ?>"> Cancel </a>

                <?php endif; ?>

                <button type='button' class='btn btn-sm btn-secondary waves-effect' data-dismiss='modal'>Save Draft</button>
                <button type='submit' class='btn btn-sm btn-primary waves-effect'>Save </button>
            </div>
        </div>
    </div>
</div><!-- /.col-md-12 -->


<script>
    CKEDITOR.replace('txt-issue-description');
    CKEDITOR.replace('txt-issue-observation');
    CKEDITOR.replace('txt-issue-implication');
    activity_options($('#txt-issue-activity').val());
    repeat_options($('#txt-issue-repeat').val());

    function discardDraft() {
        document.getElementById('frm_issue_form').reset();
        draftSystem();
    }
       
    

    function draftSystem() {

        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }


        $("#drafting").removeClass("hidden");
        var url = "<?= base_url("index.php/Audit/issueDraft/") ?>";
        var formId = "frm_issue_form";
        $.post(url, $("#" + formId).serialize(), function (response) {
            //alert(response);
            $("#drafting").addClass("hidden");
        });
    }
    

    function searchRisksInCategoryOptions(category_id) {
//        alert(category_id);
        $('#risk_assoc').removeClass('hidden');
        $("#txt-im-risk").html("<option>Please Wait..</option>");
        $("#propose_risk").attr("href", "<?= base_url("index.php/Risk/riskPropose/") ?>" + category_id);
        var url = "<?= base_url("index.php/Risk/searchRisksInCategoryOptionsAudit/") ?>/" + category_id;
        draftSystem();
        $.post(url, {data: "modal"}, function (response) {
            
            if (response) {
                alert(response);
                $("#txt-im-risk").html(response);
            } else {
                $("#txt-im-risk").html("<option>No Risks Found</option>");
            }
        })
    }

</script>
<!-- -->

<script type="text/javascript" src="<?= base_url("assets/plugins/multiselect/js/jquery.multi-select.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/plugins/jquery-quicksearch/jquery.quicksearch.js") ?>"></script>
<script src="<?= base_url("assets/plugins/select2/js/select2.full.min.js") ?>"></script>
<script>
  

    $(document).ready(function () {
        $(".multi-select").multiSelect();
        
        // Select2
//        $(".select2").select2();
    });
    function searchRisksInCategoryOptions(category_id) {
//        alert(category_id);
        $('#risk_assoc').removeClass('hidden');
        $("#txt-im-risk").html("<option>Please Wait..</option>");
        $("#propose_risk").attr("href", "<?= base_url("index.php/Risk/riskPropose/") ?>" + category_id);
        var url = "<?= base_url("index.php/Risk/searchRisksInCategoryOptionsAudit/") ?>/" + category_id;
        draftSystem();
        $.post(url, {data: "modal"}, function (response) {
            
            if (response) {
//                alert(response);
                $('.multi-select').empty().multiSelect('refresh');
              
//        $('.multi-select').multiSelect('addOption', { 
//            value: 'test2', text: 'test2', index: 0, nested: 'Risk Proposed'
//        });
                $("#txt-im-risk").html(response);
                 $('.multi-select').multiSelect('refresh');
            } else {
                $("#txt-im-risk").html("<option>No Risks Found</option>");
            }
        })
    }

</script>
<?= form_close(); ?>