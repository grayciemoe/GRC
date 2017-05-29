<?php
$incident_management = $data['incidents'];
?>
<link href="<?= base_url("assets/plugins/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css" />
<?= form_open_multipart("IncidentManagement/postIncident", array('id' => 'im-form', 'class' => '')) ?>
<link href="<?= base_url("assets/plugins/jquery.filer/css/jquery.filer.css") ?>" rel="stylesheet" />
<link href="<?= base_url("assets/css/style.css") ?>" rel="stylesheet" type="text/css" />
<?php
//$cancel_link = base_url("index.php/IncidentManagement/incidentDetail");
?>
<div class="container-fluid">
    <div class="card card-box">
        <h4 class="card-title">
            <div class="btn-group pull-right">

                <?php if ($incident_management['draft'] != 0): ?>
                    <a class='btn btn-secondary btn-sm waves-effect waves-light pull-right' href="<?= base_url("index.php/IncidentManagement/incidentDelete/{$incident_management['id']}/true") ?>"> Cancel </a>
                <?php endif; ?>
                <button type='button' class='btn btn-sm btn-secondary waves-effect' data-dismiss='modal'>Save Draft</button>
                <button type='submit' class='btn btn-sm btn-primary waves-effect'>Save </button>
            </div>
            <?= $incident_management['draft'] == 0 ? "Edit" : "Add" ?> Incident Form </h4>
        <hr />
        <div class="row">
            <div class="col-md-3">

                <input type='hidden' class='form-control'  name='id' id='txt-incident_management-id' value='<?= $incident_management['id'] ?>' />

                <div class='form-group '>
                    <label  for="txt-incident_management-title"  class='form-control-label'>Title</label>
                    <div class='col-sm-12'>
                        <input  type='text'  class='form-control' onchange="draftSystem()"  name='title'  required  id='txt-incident_management-title' value='<?= $incident_management['title'] ?>' placeholder='title' />
                    </div>
                </div>  

                <div class='form-group '>
                    <label  for="txt-incident_management-category select2"  class='col-sm-12 form-control-label'>Category of incident</label>
                    <div class='col-sm-12'>
                        <select  class='form-control select2'  onchange="draftSystem()"  required name='category' id='txt-incident_management-category'> 
                            <option value=''>SELECT</option>
                            <?php foreach ($data['incident_categories'] as $key => $value): ?>
                                <option value='<?= $value['id'] ?>' <?= $incident_management['category'] == $value['id'] ? "selected='selected'" : NULL; ?> ><?= $value['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <?php /* if (there is a problem in assosiated risk) {
                 * remove name attribute in select id txt-im-risk
                 * and set that name to input id txt-im-risk-actual
                 * 
                  }
                 */ ?>
                <input type="hidden" value="<?= $incident_management['risk']; ?>" id="txt-im-risk-actual" name="" />

                <div class='form-group '>
                    <label  for="txt-incident_management-undefined_risk_title"  class='form-control-label'> Risk Category</label>
                    <div class='col-sm-12'>
                        <select class="form-control select2"  required    name="risk_category" onchange="searchRisksInCategoryOptions(this.value)" >
                            <option value="">Select Risk Category</option>
                            <?php foreach ($data['categories'] as $key => $value): ?>
                                <option <?= $incident_management['risk_category'] == $value['id'] ? "selected='selected'" : NULL; ?>  value="<?= $value['id'] ?>"><?= $value['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class='form-group '>
                    <label  for="txt-incident_management-undefined_risk_title"  required class='form-control-label col-sm-12'>
                        <?php if (!am_user_type(array(5))): ?>
                            <a class="pull-right" href="<?= base_url("index.php/Risk/riskPropose/") ?>" id="propose_risk" <?= MODAL_LINK ?>>Propose Risk</a>
                        <?php endif; ?>
                        Risk Associated </label>

                    <input type="text" class="hidden" name="risk" id="actual_risk_id" value="<?= $incident_management['risk'] ?>" />
                    <input type="text" class="form-control hidden" name=""  onchange="draftSystem()"  id="action_risk_label"/>
                    <div class='col-sm-12' id="cover-risk-dropdown">
                        <select class="form-control select2"  required id="txt-im-risk"  name="" onchange="document.getElementById('actual_risk_id').value = this.value" >
                            <option value="">Select Risk Associated</option>
                            <?php foreach ($data['risks'] as $key => $value): ?>
                                <option  <?= $incident_management['risk'] == $value['id'] ? "selected='selected'" : NULL; ?>  value="<?= $value['id'] ?>"><?= $value['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class='form-group'>
                    <label  for="txt-compliance_requirement-environment"   class='col-sm-12 form-control-label'>Business Unit</label>
                    <div class='col-sm-12'>
                        <select  class='form-control select2' name='environment' required onchange="draftSystem()"  id='txt-compliance_requirement-environment'> 
                            <option value=''>SELECT</option>
                            <?php
                            foreach ($data['environments'] as $key => $level):
                                ?>
                                <optgroup label="<?= $key ?>">
                                    <?php
                                    foreach ($level as $key => $value):
                                        $sel = $value['id'] == $incident_management['environment'] ? "selected='selected'" : NULL;
                                        ?>
                                        <option <?= $sel ?> value='<?= $value['id'] ?>' 
                                                            <?= $sel ?> > <?= $value['environment_level']['initials'] . " : " . $value['name'] ?> </option>
                                                        <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>

                    </div>
                </div>

                <div class='form-group '>
                    <label  for="txt-incident_management-title"  class='form-control-label'>Where The Incident Occurred (Location)</label>
                    <div class='col-sm-12'>
                        <input type='text' class='form-control'   onchange="draftSystem()"  name='location'    id='txt-incident_management-location' value='<?= $incident_management['location'] ?>' placeholder='Where The Incident Occurred' />
                    </div>
                </div>

                <div class='form-group '>
                    <label  for="txt-incident_management-status"  class='form-control-label'>Status</label>
                    <div class='col-sm-12'>
                        <select  class='form-control'  onchange="draftSystem()"  name='status' id='txt-incident_management-status' <?= $incident_management['draft'] == 0 ? NULL : "disabled" ?>> 
                            <option value='active' <?= $incident_management['status'] == 'active' ? "selected='selected'" : NULL; ?> > Active </option>
                            <option value='inactive' <?= $incident_management['status'] == 'inactive' ? "selected='selected'" : NULL; ?> > Inactive </option>
                        </select>
                    </div>
                </div>


                <div class='form-group'>
                    <br />
                    <label for="radio_experience_type" class="form-control-label">Experience Type</label>
                    <br />
                    <div class="radio radio-success radio-single">
                        <input type="radio" id="near_miss" onchange="experience_type_1(this.value)" name="experience_type"  aria-label="Single radio One" value="Near Miss" <?= $incident_management['experience_type'] == 'Near Miss' ? "checked='checked'" : NULL; ?> >
                        <label for="near_miss">Near Miss</label>
                    </div>
                    <div class="radio radio-success radio-single">
                        <input type="radio" id="opportunity_cost" onchange="experience_type_1(this.value)" name="experience_type" aria-label="Single radio Two" value="Opportunity Cost" <?= $incident_management['experience_type'] == 'Opportunity Cost' ? "checked='checked'" : NULL; ?>>
                        <label for="opportunity_cost">Opportunity Cost</label>
                    </div>
                    <div class="radio radio-success radio-single">
                        <input type="radio" id="indirect_financial_loss" onchange="experience_type_1(this.value)" name="experience_type"  name="experience_type" aria-label="Single radio Three" value="Indirect Financial Loss" <?= $incident_management['experience_type'] == 'Indirect Financial Loss' ? "checked='checked'" : NULL; ?>>
                        <label for="indirect_financial_loss">Indirect Financial Loss</label>
                    </div>
                    <div class="radio radio-success radio-single">
                        <input type="radio" id="direct_financial_loss" onchange="experience_type_1(this.value)"  name="experience_type" aria-label="Single radio Four" value="Direct Financial Loss" <?= $incident_management['experience_type'] == 'Direct Financial Loss' ? "checked='checked'" : NULL; ?>>
                        <label for="direct_financial_loss">Direct Financial Loss</label>
                    </div>
                </div>
                <div class="option loss">
                    <div class="form-group text-center ">
                        <label for="radio_experience_type_level" class="form-control-label"></label>
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" id="inlineActual" onchange="experience_type_level_1(this.value)"  name="experience_type_level" value="Actual Loss" <?= $incident_management['experience_type_level'] == 'Actual Loss' ? "checked='checked'" : NULL; ?>>
                            <label for="inlineActual"> Actual Loss </label>
                        </div>
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" id="inlineEstimate" onchange="experience_type_level_1(this.value)" name="experience_type_level" value="Estimate Loss" <?= $incident_management['experience_type_level'] == 'Estimate Loss' ? "checked='checked'" : NULL; ?>>
                            <label for="inlineEstimate"> Estimate Loss </label>
                        </div>
                    </div>


                    <div class='form-group total_cost'>
                        <label  for="txt-incident_management-total_cost"  class='form-control-label'>Total Cost</label>
                        <div class='col-sm-12'>
                            <input type='number' class='form-control'  onchange="draftSystem()"  name='total_cost' id='txt-incident_management-total_cost' value='<?= $incident_management['total_cost'] ?>' placeholder='total_cost' />
                        </div>
                    </div>



                    <div class='form-group max_loss'>
                        <label  for="txt-incident_management-maximum_potential_loss"  class='form-control-label'>Maximum Potential Loss</label>
                        <div class='col-sm-12'>
                            <input type='number' class='form-control'  onchange="draftSystem()"  name='maximum_potential_loss' id='txt-incident_management-maximum_potential_loss' value='<?= $incident_management['maximum_potential_loss'] ?>' placeholder='maximum_potential_loss' />
                        </div>
                    </div>
                    <div class='form-group exp_loss'>
                        <label  for="txt-incident_management-expected_loss"  class='form-control-label'>Expected Loss</label>
                        <div class='col-sm-12'>
                            <input type='number' class='form-control'  onchange="draftSystem()"  name='expected_loss' id='txt-incident_management-expected_loss' value='<?= $incident_management['expected_loss'] ?>' placeholder='expected_loss' />
                        </div>
                    </div>
                </div>




            </div><!--end of col-4-->
            <div class="col-md-3">
                <div class='form-group '>
                    <label  for="txt-incident_management-cause_category"  class='form-control-label'>Cause Category</label>
                    <div class='col-sm-12'>

                        <select  class='form-control'  onchange="draftSystem()"  name='cause_category' id='txt-incident_management-source'> 
                            <option value='People' <?= $incident_management['cause_category'] == 'People' ? "selected='selected'" : NULL; ?> > People </option>
                            <option value='Systems' <?= $incident_management['cause_category'] == 'systems' ? "selected='selected'" : NULL; ?> > Systems </option>
                            <option value='External Events' <?= $incident_management['cause_category'] == 'External Events' ? "selected='selected'" : NULL; ?> > External Events</option>
                            <option value='Processes' <?= $incident_management['cause_category'] == 'Processes' ? "selected='selected'" : NULL; ?> > Processes</option>
                        </select>
                    </div>
                </div>
                <div class='form-group '>
                    <label  for="txt-incident_management-source"  class='form-control-label'>Source</label>
                    <div class='col-sm-12'>
                        <select  class='form-control' name='source' required="" onchange="draftSystem()"  id='txt-incident_management-source'> 

                            <option value=''>SELECT</option>
                            <option value='Email' <?= $incident_management['source'] == 'Email' ? "selected='selected'" : NULL; ?>> Email </option>
                            <option value='Phone' <?= $incident_management['source'] == 'Phone' ? "selected='selected'" : NULL; ?>> Phone </option>
                            <option value='In person' <?= $incident_management['source'] == 'In person' ? "selected='selected'" : NULL; ?>> In Person </option>
                            <option value='Social Media' <?= $incident_management['source'] == 'Social Media' ? "selected='selected'" : NULL; ?>> Social Media </option>
                            <option value='Media' <?= $incident_management['source'] == 'Media' ? "selected='selected'" : NULL; ?>> Media </option>
                        </select>
                    </div>
                </div>



                <div class='form-group '>
                    <label  for="txt-incident_management-escalation_level"  class='form-control-label'>Escalation Level</label>
                    <div class='col-sm-12'>
                        <select  class='form-control'   onchange="draftSystem()"  required name='escalation_level' id='txt-incident_management-escalation_level'> 
                            <option value='Management' <?= $incident_management['escalation_level'] == 'Management' ? "selected='selected'" : NULL; ?> > Management </option>
                            <option value='CEO' <?= $incident_management['escalation_level'] == 'CEO' ? "selected='selected'" : NULL; ?> > CEO </option>
                            <option value='Board' <?= $incident_management['escalation_level'] == 'Board' ? "selected='selected'" : NULL; ?> > Board </option>
                        </select>
                    </div>
                </div>

                <div class='form-group '>
                    <label  for="txt-incident_management-responsible_manager"  class='form-control-label'>Responsible Manager</label>
                    <div class='col-sm-12'>
                        <select  class='form-control'  onchange="draftSystem()" required name='responsible_manager' id='txt-incident_management-responsible_manager'> 
                            <option value=''>SELECT</option>
                            <?php foreach ($data['owners'] as $key => $value): ?>
                                <option value='<?= $value['id'] ?>' <?= $incident_management['responsible_manager'] == $value['id'] ? "selected='selected'" : NULL; ?> > <?= $value['names'] ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class='form-group '>
                    <label  for="txt-incident_management-reported_by"  class='form-control-label'>Reported By</label>
                    <div class='col-sm-12'>
                        <input type='text' class='form-control'  onchange="draftSystem()"  name='reported_by' id='txt-incident_management-reported_by' value='<?= $incident_management['reported_by'] ?>' placeholder='reported_by' />
                        <small class="text-muted">Enter the name of the person who reported</small>
                    </div>
                </div>
                <div class='form-group '>
                    <label  for="txt-incident_management-reporter_category"  class='form-control-label'>Reporter Category</label>
                    <div class='col-sm-12'>
                        <select  class='form-control'  onchange="draftSystem()"  name='reporter_category' id='txt-incident_management-reporter_category'> 
                            <option value=''>SELECT</option>
                            <option value='Employee' <?= $incident_management['reporter_category'] == 'Employee' ? "selected='selected'" : NULL; ?> > Employee </option>
                            <option value='Agent' <?= $incident_management['reporter_category'] == 'Agent' ? "selected='selected'" : NULL; ?> > Agent </option>
                            <option value='Supplier' <?= $incident_management['reporter_category'] == 'Supplier' ? "selected='selected'" : NULL; ?> > Supplier </option>
                            <option value='Customer' <?= $incident_management['reporter_category'] == 'Customer' ? "selected='selected'" : NULL; ?> > Customer </option>
                            <option value='Public' <?= $incident_management['reporter_category'] == 'Public' ? "selected='selected'" : NULL; ?> > Public </option>
                        </select>
                    </div>
                </div> 
                <div class='form-group '>
                    <label  for="txt-incident_management-detection-method"  class='form-control-label'>Detection Method</label>
                    <div class='col-sm-12'>
                        <input type='text' onchange="draftSystem()"  class='form-control'  name='detection_method' id='txt-incident_management-detection-method' value='<?= $incident_management['detection_method'] ?>' placeholder='detection_method' />
                    </div>
                </div>


                <div class='form-group '>
                    <label  for="txt-incident_management-created"  class='form-control-label'>Date Reported</label>
                    <div class='col-sm-12'>
                        <input type='date' onchange="draftSystem()"  class='form-control'  required name='created' id='txt-incident_management-created' value='<?= strftime("%Y-%m-%d", strtotime($incident_management['created'])) ?>' placeholder='created' />
                    </div>
                </div>
                <div class='form-group '>
                    <label  for="txt-incident_management-date_of_incident"  class='form-control-label'>Date Of Incident</label>
                    <div class='col-sm-12'>
                        <input type='date'  onchange="draftSystem()"  class='form-control'  required name='date_of_incident' id='txt-incident_management-date_of_incident' value='<?= strftime("%Y-%m-%d", strtotime($incident_management['date_of_incident'])) ?>' placeholder='date_of_incident' />
                    </div>
                </div>  
            </div><!--endof col-3-->
            <div class="col-md-6">
                <div class='form-group '>
                    <label  for="txt-incident_management-description"  class='form-control-label'>Description</label>
                    <div class='col-sm-12'>
                        <textarea  onchange="draftSystem()" class='form-control wysiwyg' rows="10" cols="20"  name='description' id='txt-incident_management-description' placeholder='description' ><?= $incident_management['description'] ?></textarea>
                    </div>
                </div>
                <div class='form-group '>
                    <label  for="txt-incident_management-cause"  class='form-control-label'>Cause</label>
                    <div class='col-sm-12'>
                        <textarea  onchange="draftSystem()" class='form-control wysiwyg' rows="5"  name='cause' id='txt-incident_management-cause' placeholder='cause' ><?= $incident_management['cause'] ?></textarea>
                    </div>
                </div>
                <?= files_upload("incident_management", "incident_management", $incident_management['id']) ?>
            </div><!--End row-->


        </div>
        <pre id="pre_response"></pre>

        <div class="card-block">
            <hr />
            <div id="drafting" class="loading hidden"><i class="icon icon-pencil fa fa-spin "></i> Drafting ...</div>
            <div class="btn-group pull-right">

                <?php if ($incident_management['draft'] != 0): ?>
                    <a class='btn btn-secondary btn-sm waves-effect waves-light pull-right' href="<?= base_url("index.php/IncidentManagement/incidentDelete/{$incident_management['id']}/true") ?>"> Cancel </a>

                <?php endif; ?>

                <button type='button' class='btn btn-sm btn-secondary waves-effect' data-dismiss='modal'>Save Draft</button>
                <button type='submit' class='btn btn-sm btn-primary waves-effect'>Save </button>
            </div>
        </div>

    </div>
</div>

<script>
    $(".select2").select2();
    CKEDITOR.replace('txt-incident_management-description');
    CKEDITOR.replace('txt-incident_management-cause');



    $(document).ready(function () {
        experience_type_1("<?= $incident_management['experience_type'] ?>");
        experience_type_level_1("<?= $incident_management['experience_type_level'] ?>");
        // alert("Kinja");
    });





    function experience_type_1(value) {
        switch (value) {
            case "Near Miss":
                $('.loss').hide('fast');
                $('.total_cost').hide('fast');
                $('.max_loss').hide('fast');
                $('.exp_loss').hide('fast');
                break;
            case "Opportunity Cost":
                $('.loss').hide('fast');
                $('.total_cost').hide('fast');
                $('.max_loss').hide('fast');
                $('.exp_loss').hide('fast');
                break;
            case "Indirect Financial Loss":
                $('.loss').show('fast');
                $('.total_cost').hide('fast');
                $('.max_loss').hide('fast');
                $('.exp_loss').hide('fast');
                break;
            case "Direct Financial Loss":
                $('.loss').show('fast');
                $('.total_cost').hide('fast');
                $('.max_loss').hide('fast');
                $('.exp_loss').hide('fast');
                break;

            default:

                break;
        }
        draftSystem();
    }


    function experience_type_level_1(value) {
        //alert(value);
        switch (value) {
            case "Actual Loss":
                $('.total_cost').show('fast');
                $('.max_loss').hide('fast');
                $('.exp_loss').hide('fast');
                break;
            case "Estimate Loss":
                $('.total_cost').hide('fast');
                $('.max_loss').show('fast');
                $('.exp_loss').show('fast');
                break;
            default:

                $('.total_cost').hide('fast');
                $('.max_loss').hide('fast');
                $('.exp_loss').hide('fast');
                break;

        }
        draftSystem();
    }
    function draftSystem() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        $("#drafting").removeClass("hidden");
        var url = "<?= base_url("index.php/IncidentManagement/incidentDraft/") ?>";
        var formId = "im-form";
        $.post(url, $("#" + formId).serialize(), function (response) {
            $("#drafting").addClass("hidden");
            $('#pre_response').html(response);
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
<?= form_close(); ?>
