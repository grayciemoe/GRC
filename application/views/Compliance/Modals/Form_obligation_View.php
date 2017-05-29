
<link href="<?= base_url("assets/plugins/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css" />
<?php
$obligations = $data['obligation'];
//print_pre($obligations);
$cr_short_code = $data['cr_short_code'];
?>
<?= form_open_multipart("Compliance/obligationPost", array('id' => 'frm_obligation_form', 'class' => 'form-vertical', "onsubmit" => "return validateObligationForm()")) ?>
<input type='hidden' class='form-control'  name='id' id='txt-obligations-id' value='<?= $obligations['id'] ?>' />

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Obligation </h4>
        </div>
        <div class="clearfix"></div>
        <div class='modal-body'>
            <div class="row">

                <div class="alert alert-danger hidden" id="js_response"></div>
                <div class="col-sm-5">
                    <div class='form-group'>
                        <label  for="txt-obligations-title"  class='col-sm-12 form-control-label'>Title</label>
                        <div class='col-sm-12'>
                            <input type='text' class='form-control' onchange="draftSystem();" autofocus="true"  name='title'  required=''  id='txt-obligations-title' value='<?= $obligations['title'] ?>' placeholder='title' />
                        </div>
                    </div>
                    <div class='form-group'hidden>
                        <label  for="txt-obligations-short_code"  class='col-sm-12 form-control-label'>Short Code</label>
                        <div class='col-sm-12'>
                            <input type='text' class='form-control'  onchange="draftSystem();"  name='short_code' id='txt-obligations-short_code' value='<?= $cr_short_code ?>:<?= $obligations['id'] ?>' placeholder='short_code' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-obligations-compliance_requirement"  class='col-sm-12 form-control-label'>Compliance Requirement</label>
                        <div class='col-sm-12'>
                            <select  class='form-control select2' onchange="findComplianceRequirementType(this.value)" required=""  name='compliance_requirement' id='txt-obligations-compliance_requirement'>
                                <option value=''>SELECT</option>
                                <?php
                                $type = array();
                                foreach ($data['compliance_requirements'] as $key => $value) {
                                    if (!isset($type[$value['type']])) {
                                        $type[$value['type']] = [];
                                    }
                                    $type[$value['type']][] = $value;
                                }
                                foreach ($type as $key => $cr):
                                    ?>
                                    <optgroup label="<?= $key ?>">
                                        <?php
                                        foreach ($cr as $key => $value):
                                            $selected = $obligations['compliance_requirement'] == $value['id'] ? "selected='selected'" : NULL;
                                            ?>

                                            <option <?= $selected ?> value="<?= $value['id'] ?>"><?= $value['title'] ?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-obligations-authority"  class='col-sm-12 form-control-label'>Authority</label>
                        <div class='col-sm-12'>
                            <select class='form-control select2'  onchange="draftSystem();" required=""  name='authority' id='txt-obligations-authority' >
                                <option value=''>SELECT</option>
                                <?php
                                foreach ($data['authorities'] as $key => $value):
                                    $selected = $obligations['authority'] == $value['id'] ? "selected='selected'" : NULL;
                                    ?>
                                    <option <?= $selected ?> value="<?= $value['id'] ?>"><?= $value['title'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-obligations-responsible_manager_1"  class='col-sm-12 form-control-label'>Primary Owner</label>
                        <div class='col-sm-12'>
                            <select class='form-control'  onchange="draftSystem();" required="" name='responsible_manager_1' id='txt-obligations-responsible_manager_1' >
                                <option value=''>SELECT</option>
                                <?php
                                foreach ($data['staff'] as $key => $value):
                                    $selected = $obligations['responsible_manager_1'] == $value['id'] ? "selected='selected'" : NULL;
                                    ?>
                                    <option <?= $selected ?> value="<?= $value['id'] ?>"><?= $value['names'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-obligations-responsible_manager_2"  class='col-sm-12 form-control-label'>Secondary Owner</label>
                        <div class='col-sm-12'>
                            <select class='form-control'  onchange="draftSystem();" required="" name='responsible_manager_2' id='txt-obligations-responsible_manager_2' >

                                <option value=''>SELECT</option>
                                <?php
                                foreach ($data['risk_managers'] as $key => $value):
                                    $selected = $obligations['responsible_manager_2'] == $value['id'] ? "selected='selected'" : NULL;
                                    ?>
                                    <option <?= $selected ?> value="<?= $value['id'] ?>"><?= $value['names'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-obligations-escalation_person"  class='col-sm-12 form-control-label'>Escalation Person</label>
                        <div class='col-sm-12'>
                            <select class='form-control' onchange="draftSystem();" required  name='escalation_person' id='txt-obligations-escalation_person' >
                                <option value=''>SELECT</option>
                                <?php
                                foreach ($data['escalation'] as $key => $value):
                                    $selected = $obligations['escalation_person'] == $value['id'] ? "selected='selected'" : NULL;
                                    ?>
                                    <option <?= $selected ?> value="<?= $value['id'] ?>"><?= $value['names'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <?php
                    $read_only = false;
                    if ($obligations['draft'] == 0) {
                        $read_only = true;
                    }
                    ?>
                    <div class='form-group'>
                        <label  for="txt-obligations-repeat"  class='col-sm-12 form-control-label'>Repeat</label>
                        <div class='col-sm-12'>
                            <select  class='form-control' name='<?= $read_only ? null : "repeat"; ?>' <?= $read_only ? "disabled='true'" : NULL; ?> onchange="repeat_options(this.value)" id='txt-obligations-repeat'> 
                                <option value="">SELECT</option>
                                <option value='one off' <?= $obligations['repeat'] == 'one off' ? "selected='selected'" : NULL; ?> > One Off </option>
                                <option value='continuous' <?= $obligations['repeat'] == 'continuous' ? "selected='selected'" : NULL; ?> > Continuous </option>
                                <option value='periodic' <?= $obligations['repeat'] == 'periodic' ? "selected='selected'" : NULL; ?> > Periodic </option>
                            </select>
                        </div>
                    </div>
                    <div class='form-group frequency periodic'>
                        <label  for="txt-obligations-frequency"  class='col-sm-12 form-control-label'>Frequency</label>
                        <div class='col-sm-12'>
                            <select  class='form-control' name='<?= $read_only ? null : "frequency' "; ?>' <?= $read_only ? "disabled='true" : NULL; ?>  onchange="draftSystem();"  id='txt-obligations-frequency'> 
                                <option value="">SELECT</option>
                                <option value='annually' <?= $obligations['frequency'] == 'annually' ? "selected='selected'" : NULL; ?> > Annually </option>
                                <option value='semi annually' <?= $obligations['frequency'] == 'semi annually' ? "selected='selected'" : NULL; ?> > Semi Annually </option>
                                <option value='quarterly' <?= $obligations['frequency'] == 'quarterly' ? "selected='selected'" : NULL; ?> > Quarterly </option>
                                <option value='monthly' <?= $obligations['frequency'] == 'monthly' ? "selected='selected'" : NULL; ?> > Monthly </option>
                                <option value='weekly' <?= $obligations['frequency'] == 'weekly' ? "selected='selected'" : NULL; ?> > Weekly </option>
                                <option value='daily' <?= $obligations['frequency'] == 'daily' ? "selected='selected'" : NULL; ?> > Daily </option>
                            </select>
                        </div>
                    </div>


                    <div class='form-group'>
                        <label  for="txt-obligations-first_compliance_period"  class='col-sm-12 form-control-label'>First Compliance Period</label>
                        <div class='col-sm-12'>
                            <input type='date' class='form-control' onchange="draftSystem();"    
                                   name='fcp' <?= $read_only ? "disabled='true'" : NULL; ?>  
                                   id='txt-obligations-first_compliance_period' 
                                   value='<?= strftime("%Y-%m-%d", strtotime($obligations['fcp'])) ?>' 
                                   placeholder='' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-obligations-submission_deadline" id='return_date' class='col-sm-12 form-control-label'>
                            <?= $data['compliance_requirement']['type'] == 'Statutory Returns' ? "Submission Deadline" : "Next Review" ?>    
                        </label> <!-- required  min="<?= strftime("%Y-%m-%d", time()) ?>" -->
                        <div class='col-sm-12'>
                            <input type='date' class='form-control'  onchange="draftSystem();"   name='<?= $read_only ? 'submission_deadline' : "submission_deadline"; ?>' <?= $read_only ? "disabled='true'" : NULL; ?> 
                                   onchange="document.getElementById('txt-obligations-notification_date').value = this.value" id='txt-obligations-submission_deadline' 
                                   value='<?= strftime("%Y-%m-%d", strtotime($obligations['submission_deadline'])) ?>' placeholder='submission_deadline' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-obligations-notification_date"  class='col-sm-12 form-control-label'>Notification Date</label>
                        <div class='col-sm-12'>
                            <input type='date' class='form-control'  onchange="draftSystem();"   name='<?= $read_only ? 'notification_date' : "notification_date"; ?>' <?= $read_only ? "disabled='true'" : NULL; ?>  id='txt-obligations-notification_date' 
                                   value='<?= strftime("%Y-%m-%d", strtotime($obligations['notification_date'])) ?>' placeholder='notification_date' />
                            <small class="text-danger" id="notification_message"></small>
                        </div>


                    </div>
                    <div class='form-group'>
                        <label  for="txt-obligations-priority"  class='col-sm-12 form-control-label'>Priority Level</label>
                        <div class='col-sm-12'>
                            <select  class='form-control'name='priority' onchange="draftSystem();"  id='txt-obligations-priority'> 
                                <option value='high' <?= $obligations['priority'] == 'high' ? "selected='selected'" : NULL; ?> > High </option>
                                <option value='medium' <?= $obligations['priority'] == 'medium' ? "selected='selected'" : NULL; ?> > Medium </option>
                                <option value='low' <?= $obligations['priority'] == 'low' ? "selected='selected'" : NULL; ?> > Low </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class='form-group'>
                        <label  for="txt-obligations-description"  class='col-sm-12 form-control-label'>Description</label>
                        <div class='col-sm-12'>
                            <textarea class='form-control wysiwyg' onchange="draftSystem();"  rows="10" name='description' id='txt-obligations-description' placeholder='description' ><?= $obligations['description'] ?></textarea>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-obligations-activity"class='col-sm-12 form-control-label'>Activity</label>
                        <div class='col-sm-12'>
                            <select  class='form-control'name='activity'  onchange="activity_options(this.value)"  id='txt-obligations-activity'> 
                                <option value='document submission' <?= $obligations['activity'] == 'document submission' ? "selected='selected'" : NULL; ?> > Document Submission </option>
                                <option value='web entry' <?= $obligations['activity'] == 'web entry' ? "selected='selected'" : NULL; ?> > Web Entry </option>
                                <option value='audit pass' <?= $obligations['activity'] == 'audit pass' ? "selected='selected'" : NULL; ?> > Audit Pass </option>
                            </select>
                        </div>
                    </div>
                    <div class='form-group actvity_control document_submission'>
                        <label  for="txt-obligations-document_name"  class='col-sm-12 form-control-label '>Document Name</label>
                        <div class='col-sm-12'>
                            <input type='text' class='form-control '  onchange="draftSystem();"  name='document_name' id='txt-obligations-document_name' value='<?= $obligations['document_name'] ?>' placeholder='' />
                        </div>
                    </div>
                    <div class='form-group actvity_control  document_submission'>
                        <label  for="txt-obligations-person_name"  class='col-sm-12 form-control-label'>Person Name</label>
                        <div class='col-sm-12'>
                            <input type='text' class='form-control '  onchange="draftSystem();"  name='person_name' id='txt-obligations-person_name' value='<?= $obligations['person_name'] ?>' placeholder='' />
                        </div>
                    </div>
                    <div class='form-group actvity_control document_submission'>
                        <label  for="txt-obligations-person_phone"  class='col-sm-12 form-control-label'>Person Phone</label>
                        <div class='col-sm-12'>
                            <input type='text' class='form-control '  onchange="draftSystem();"  name='person_phone' id='txt-obligations-person_phone' value='<?= $obligations['person_phone'] ?>' placeholder='' />
                        </div>
                    </div>
                    <div class='form-group actvity_control document_submission'>
                        <label  for="txt-obligations-person_address"   class='col-sm-12 form-control-label'>Person Address</label>
                        <div class='col-sm-12'>
                            <input type='text' class='form-control '  onchange="draftSystem();"  name='person_address' id='txt-obligations-person_address' value='<?= $obligations['person_address'] ?>' placeholder='' />
                        </div>
                    </div>
                    <div class='form-group actvity_control document_submission'>
                        <label  for="txt-obligations-person_email"  class='col-sm-12 form-control-label'>Person Email</label>
                        <div class='col-sm-12'>
                            <input type='text' class='form-control '  onchange="draftSystem();"  name='person_email' id='txt-obligations-person_email' value='<?= $obligations['person_email'] ?>' placeholder='' />
                        </div>
                    </div>
                    <div class='form-group actvity_control web_entry '>
                        <label  for="txt-obligations-url"  class='col-sm-12 form-control-label'>WEBSITE URL</label>
                        <div class='col-sm-12'>
                            <input type='text' class='form-control  '  onchange="draftSystem();"  name='url' id='txt-obligations-url' value='<?= $obligations['url'] ?>' placeholder='url' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-obligations-noncompliance_consequence"  class='col-sm-12 form-control-label'>Noncompliance Consequence</label>
                        <div class='col-sm-12'>
                            <textarea class='form-control wysiwyg'  onchange="draftSystem();"  name='noncompliance_consequence' id='txt-obligations-noncompliance_consequence' placeholder='noncompliance_consequence' ><?= $obligations['noncompliance_consequence'] ?></textarea>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-obligations-noncompliance_penalty"  class='col-sm-12 form-control-label'>Noncompliance Penalty</label>
                        <div class='col-sm-12'>
                            <input type='number' class='form-control'  onchange="draftSystem();"  name='noncompliance_penalty' id='txt-obligations-noncompliance_penalty' value='<?= $obligations['noncompliance_penalty'] ?>' placeholder='noncompliance_penalty' />
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
    CKEDITOR.replace('txt-obligations-description');
    activity_options($('#txt-obligations-activity').val());
    repeat_options($('#txt-obligations-repeat').val());


    function discardDraft() {
        document.getElementById('frm_obligation_form').reset();
        draftSystem();
    }

    function findComplianceRequirementType(compliance_requirement_id) {
        var url = "<?= base_url("index.php/Compliance/findComplianceRequirementType/"); ?>/" + compliance_requirement_id;
        $.post(url, {data: "data"}, function (response) {
            $("#return_date").html(response);
        });


    }

    function validateObligationForm() {


        var submission = new Date($("#txt-obligations-submission_deadline").val());
        var notification = new Date($("#txt-obligations-notification_date").val());
        if (submission < notification) {
            $('#notification_message').html("Notification date must be at least a day before the submission deadline ");
            document.getElementById('txt-obligations-notification_date').focus();
            return false;
        }



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

    function activity_options(value) {
        //alert(value);
        draftSystem();
        $('.actvity_control').hide('fast');
        if (value === 'document submission') {
            $('.actvity_control.document_submission').show('fast');
        }
        if (value === 'web entry') {
            $('.actvity_control.web_entry').show('fast');
        }
        if (value === 'audit pass') {
            $('.actvity_control.audit_pass').show('fast');
        }
    }
    function repeat_options(value) {//alert(value);
        draftSystem();
        $('.frequency').hide('fast');
        if (value === 'periodic') {
            $('.frequency.periodic').show('fast');
        }
        if (value === 'one off') {
            $('.frequency.periodic').hide('fast');
        }
        if (value === 'continuous') {
            $('.frequency.periodic').hide('fast');
        }
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