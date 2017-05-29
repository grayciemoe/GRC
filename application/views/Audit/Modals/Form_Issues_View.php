
<link href="<?= base_url("assets/plugins/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css" />
<?php
?>
<?= form_open_multipart("Audit/issuePost", array('id' => 'frm_issue_form', 'class' => 'form-vertical')) ?>
<input type='hidden' class='form-control'  name='id' id='txt-issue-id' value='<?= $issue['id'] ?>' />

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Issue </h4>
        </div>
        <div class="clearfix"></div>
        <div class='modal-body'>
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
                            <input type='text' class='form-control'  onchange="draftSystem();"  name='issue_subheading' id='txt-issue-issue_subheading' value='<?= $issue['risk_area'] ?>' placeholder='Issue Subheading' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-issue-rating"  class='col-sm-12 form-control-label'>Issue Rating</label>
                        <div class='col-sm-12'>
                            <select  class='form-control select2' required=""  name='issue_rating' id='txt-issue-issue_rating'>
                                <option value=''>SELECT</option>
                                <option value='Low'>Low</option>
                                <option value='Moderate'>Moderate</option>
                                <option value='High'>High</option>
                                <option value='Critical'>Critical</option>
                            </select>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-issue-issue_subheading"  class='col-sm-12 form-control-label'>Issue Subheading</label>
                        <div class='col-sm-12'>
                            <input type='text' class='form-control'  onchange="draftSystem();"  name='issue_subheading' id='txt-issue-issue_subheading' value='<?= $issue['risk_area'] ?>' placeholder='Issue Subheading' />
                        </div>
                    </div>
                    <!--<input type="hidden" value="<?php// $incident_management['risk']; ?>" id="txt-im-risk-actual" name="" />-->

                    <div class='form-group '>
                        <label  for="txt-issue-risk_category"  class='form-control-label'> Risk Category</label>
                        <div class='col-sm-12'>
                            <select class="form-control select2"  required    name="risk_category" onchange="searchRisksInCategoryOptions(this.value)" >
                                <option value="">Select Risk Category</option>
                                <?php //foreach ($data['categories'] as $key => $value): ?>
                                    <option <?php // $incident_management['risk_category'] == $value['id'] ? "selected='selected'" : NULL; ?>  value="<?php // $value['id'] ?>"><?php // $value['title'] ?></option>
                                <?php //endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class='form-group '>
                        <label  for="txt-issue-undefined_risk_title"  required class='form-control-label col-sm-12'>

                            <a class="pull-right" href="<?= base_url("index.php/Risk/riskPropose/") ?>" id="propose_risk" <?= MODAL_AJAX ?>>Propose Risk</a>

                            Risk Associated </label>

                        <input type="text" class="hidden" name="risk" id="actual_risk_id" value="<?php // $incident_management['risk']  ?>" />
                        <input type="text" class="form-control hidden" name=""  onchange="draftSystem()"  id="action_risk_label"/>
                        <div class='col-sm-12' id="cover-risk-dropdown">
                            <select class="form-control select2"  required id="txt-im-risk"  name="" >
                                <option value="">Select Risk Associated</option>
                                <option value=""><i>To be obtained</i></option>
                            </select>
<!--                            <select class="form-control select2"  required id="txt-im-risk"  name="" onchange="document.getElementById('actual_risk_id').value = this.value" >
                                <option value="">Select Risk Associated</option>
                            <?php //foreach ($data['risks'] as $key => $value): ?>
                                    <option  <?php // $incident_management['risk'] == $value['id'] ? "selected='selected'" : NULL;  ?>  value="<?php // $value['id']  ?>"><?php // $value['title']  ?></option>
                            <?php //endforeach; ?>
                            </select>-->
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-issue-notification_date"  class='col-sm-12 form-control-label'>Action Date</label>
                        <div class='col-sm-12'>
                            <input type='date' class='form-control'  onchange="draftSystem();" name='audit_date'  id='txt-issue-notification_date' 
                                   value='' />
                            <small class="text-danger" id="notification_message"></small>
<!--                            <input type='date' class='form-control'  onchange="draftSystem();"   name='<?= $read_only ? 'audit_date' : "audit_date"; ?>' <?= $read_only ? "disabled='true'" : NULL; ?>  id='txt-issue-audit_date' 
                                   value='<?= strftime("%Y-%m-%d", strtotime($obligations['audit_date'])) ?>' placeholder='audit_date' />
                            <small class="text-danger" id="notification_message"></small>-->
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-issue-risk_area"  class='col-sm-12 form-control-label'>Action By</label>
                        <div class='col-sm-12'>
                            <input type='text' class='form-control'  onchange="draftSystem();"  name='action_by' id='txt-issue-risk_area' value='<?= $issue['risk_area'] ?>' placeholder='Action By' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-issue-action_status"  class='col-sm-12 form-control-label'>Action Plan Status</label>
                        <div class='col-sm-12'>
                            <select class='form-control select2'  onchange="draftSystem();" required=""  name='action_plan_status' id='txt-issue-action_plan_status' >
                                <option value=''>SELECT</option>
                                <option value="outstanding">Outstanding</option>
                                <option value="implemented">Implemented</option>
                                <option value="unverified">Unverified</option>
                                <option value="superseded">Superseded</option>
                                <option value="not_adopted">Not Adopted</option>
                            </select>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-issue-issue_status"  class='col-sm-12 form-control-label'>Issue Status</label>
                        <div class='col-sm-12'>
                            <select class='form-control select2'  onchange="draftSystem();" required=""  name='issue_status' id='txt-issue-issue_status' >
                                <option value=''>SELECT</option>
                                <option value="open">Open</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-issue-implication_type"  class='col-sm-12 form-control-label'>Implication Type</label>
                        <div class='col-sm-12'>
                            <select class='form-control select2'  onchange="draftSystem();" required=""  name='implication_type' id='txt-issue-implication_type' >
                                <option value=''>SELECT</option>
                                <option value="loss_of_opportunity">Loss of Opportunity</option>
                                <option value="risk_exposure">Risk Exposure</option>
                            </select>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label  for="txt-issue-review_date"  class='col-sm-12 form-control-label'>Review Date</label>
                        <div class='col-sm-12'>
                            <input type='date' class='form-control' onchange="draftSystem();"    
                                   name='review_date'   id='txt-issue-review_date' 
                                   value='' />
<!--                            <input type='date' class='form-control' onchange="draftSystem();"    
                                   name='review_date'   id='txt-issue-review_date' 
                                   value='<?= strftime("%Y-%m-%d", strtotime($obligations['fcp'])) ?>' />-->
                        </div>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class='form-group'>
                        <label  for="txt-issue-description"  class='col-sm-12 form-control-label'>Description</label>
                        <div class='col-sm-12'>
                            <textarea class='form-control wysiwyg' onchange="draftSystem();"  rows="10" name='description' id='txt-issue-description' placeholder='description' ></textarea>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-issue-observation"  class='col-sm-12 form-control-label'>Observation</label>
                        <div class='col-sm-12'>
                            <textarea class='form-control wysiwyg' onchange="draftSystem();"  rows="10" name='observation' id='txt-issue-observation' placeholder='observation' ></textarea>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-issue-implication"  class='col-sm-12 form-control-label'>Implication</label>
                        <div class='col-sm-12'>
                            <textarea class='form-control wysiwyg' onchange="draftSystem();"  rows="10" name='implication' id='txt-issue-implication' placeholder='implication' ></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class='modal-footer'>
            <div id="drafting" class="loading hidden pull-left"><i class="icon icon-pencil fa fa-spin "></i> Drafting ...</div>
            <button type='button' onclick="discardDraft()" class='btn btn-secondary waves-effect' data-dismiss='modal'>Discard Draft</button>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Save Draft</button>
            <button type='submit' class='btn btn-secondary waves-effect'>Save Changes</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>

<script>
    CKEDITOR.replace('txt-issue-description');
    CKEDITOR.replace('txt-issue-observation');
    CKEDITOR.replace('txt-issue-implication');
    activity_options($('#txt-issue-activity').val());
    repeat_options($('#txt-issue-repeat').val());


    function discardDraft() {
        document.getElementById('frm_obligation_form').reset();
        draftSystem();
    }


    function draftSystem() {

        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }


        $("#drafting").removeClass("hidden");
        var url = "<?= base_url("index.php/Compliance/obligationDraft/") ?>";
        var formId = "frm_obligation_form";
        $.post(url, $("#" + formId).serialize(), function (response) {
            //alert(response);
            $("#drafting").addClass("hidden");
        });
    }
    
    function searchRisksInCategoryOptions(category_id) {
        $("#txt-im-risk").html("<option>Please Wait..</option>");
        $("#propose_risk").attr("href", "<?= base_url("index.php/Risk/riskPropose/") ?>" + category_id);
        var url = "<?= base_url("index.php/Risk/searchRisksInCategoryOptions/") ?>/" + category_id;
        draftSystem();
        $.post(url, {data: "modal"}, function (response) {
            //alert(response);
            if (response) {
                $("#txt-im-risk").html("<option value=''>SELECT</option>" + response);
            } else {
                $("#txt-im-risk").html("<option>No Risks Found</option>");
            }
        })
    }

</script>
<!-- -->

<script src="<?= base_url("assets/plugins/select2/js/select2.full.min.js") ?>"></script>
<script>
    $(document).ready(function () {
        // Select2
        $(".select2").select2();
    });

</script>