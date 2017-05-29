
<?php
$compliance_requirement = $data['compliance_requirement'];
?>
<link href="<?= base_url("assets/plugins/jquery.filer/css/jquery.filer.css") ?>" rel="stylesheet" />
<link href="<?= base_url("assets/plugins/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url("assets/css/style.css") ?>" rel="stylesheet" type="text/css" />
<?= form_open_multipart("Compliance/postComplianceRequirement", array('id' => 'frm_compliance_requirement_form', 'class' => '')) ?>

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Compliance Requirements </h4>
        </div>
        <div class='modal-body'>
            <div class="row">
                <input type='hidden' class='form-control' onchange="draftSystem();"  name='id' id='txt-compliance_requirement-id' value='<?= $compliance_requirement['id'] ?>' />

                <?php // print_pre($data); ?>
                <div class='form-group col-sm-8'>
                    <label  for="txt-compliance_requirement-title"  class='col-sm-12 form-control-label'>Title</label>
                    <div class='col-sm-12'>
                        <input type='text' class='form-control' onchange="draftSystem();"    name='title'  required=''  id='txt-compliance_requirement-title' value='<?= $compliance_requirement['title'] ?>' placeholder='title' />
                    </div>
                </div>
                <div class='form-group col-sm-4'>
                    <label  for="txt-compliance_requirement-short_code"  class='col-sm-12 form-control-label'>Short Code</label>
                    <div class='col-sm-12'>
                        <input type='text' class='form-control'  onchange="draftSystem();"  name='short_code' id='txt-compliance_requirement-short_code' value='<?= $compliance_requirement['short_code'] ?>' placeholder='short_code' />
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class='form-group col-sm-4'>
                    <label  for="txt-compliance_requirement-short_code"  class='col-sm-12 form-control-label'>Effective Date</label>
                    <div class='col-sm-12'>
                        <input type='date' class='form-control'  onchange="draftSystem();"  name='effective_date' id='txt-compliance_requirement-effective_date' value='<?= strftime("%Y-%m-%d",strtotime($compliance_requirement['effective_date'])) ?>' placeholder='short_code' />
                    </div>
                </div>
                <div class='form-group col-sm-4'>
                    <label  for="txt-compliance_requirement-environment"  class='col-sm-12 form-control-label'>Unit</label>
                    <div class='col-sm-12'>
                        <select  class='form-control select2' required onchange="unitRepositoryOptions(this.value, <?= $compliance_requirement['id'] ?>,<?= $compliance_requirement['repository'] ?>)"  name='environment' id='txt-compliance_requirement-environment'> 

                            <option value="">SELECT UNIT</option>
                            <?php
                            foreach ($data['environments'] as $key => $level):
                                ?>
                                <optgroup label="<?= $key ?>">
                                    <?php
                                    foreach ($level as $key => $value):
                                        $sel = $value['id'] == $compliance_requirement['environment'] ? "selected='selected'" : NULL;
                                        ?>
                                        <option <?= $sel ?> value='<?= $value['id'] ?>' 
                                                            <?= $sel ?> > <?= $value['environment_level']['initials'] . " : " . $value['name'] ?> 
                                        </option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>

                    </div>
                </div>
                <div class='form-group col-sm-4'>
                    <?php // print_pre($data['repository_unsorted']);  ?>
                    <label  for="txt-compliance_requirement-repository"  class='col-sm-12 form-control-label'>Source Document</label>

                    <div class='col-sm-12'>
                        <select  class='form-control select2'  onchange="draftSystem();" required  name='repository' id='txt-compliance_requirement-repository'> 
                            <option value="">SELECT SOURCE DOCUMENT</option>
                            <?php
                            foreach ($data['repository_unsorted'] as $key => $value):
                                ?>   

                                <?php
                                $select = $value['id'] == $compliance_requirement['repository'] ? "selected='selected'" : NULL;
                                ?>   
                                <option value='<?= $value['id'] ?>' <?= $select ?> >  <?= $value['name'] ?> </option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class='form-group col-sm-4'>
                    <label  for="txt-compliance_requirement-type"  class='col-sm-12 form-control-label'>Compliance Requirement Type</label>
                    <div class='col-sm-12'>
                        <select  class='form-control'name='type'  onchange="draftSystem();"  id='txt-compliance_requirement-type'> 
                            <option value=''>SELECT</option>
                            <option value='Statutory Returns' <?= $compliance_requirement['type'] == 'Statutory Returns' ? "selected='selected'" : NULL; ?> > Statutory Compliance </option>
                            <option value='Legal / Regulatory Requirements' <?= $compliance_requirement['type'] == 'Legal / Regulatory Requirements' ? "selected='selected'" : NULL; ?> > Legal / Regulatory Compliance </option>
                            <option value='Business Compliance Requirements' <?= $compliance_requirement['type'] == 'Business Compliance Requirements' ? "selected='selected'" : NULL; ?> > Business Compliance </option>
                        </select>
                    </div>
                </div>
                <div class='form-group col-sm-4'>
                    <label  for="txt-compliance_requirement-priority"  class='col-sm-12 form-control-label'>Priority Level</label>
                    <div class='col-sm-12'>
                        <select  class='form-control'name='priority'  onchange="draftSystem();"  id='txt-compliance_requirement-priority'> 

                            <option value='High' <?= $compliance_requirement['priority'] == 'High' ? "selected='selected'" : NULL; ?> > High </option>
                            <option value='Medium' <?= $compliance_requirement['priority'] == 'Medium' ? "selected='selected'" : NULL; ?> > Medium </option>
                            <option value='Low' <?= $compliance_requirement['priority'] == 'Low' ? "selected='selected'" : NULL; ?> > Low </option>
                        </select>
                    </div>
                </div>
                <div class='form-group col-sm-4'>
                    <label  for="txt-compliance_requirement-status"  class='col-sm-12 form-control-label'>Status</label>
                    <div class='col-sm-12'>
                        <select  class='form-control'name='status'  onchange="draftSystem();"  id='txt-compliance_requirement-status'> 
                            <option value='active' <?= $compliance_requirement['status'] == 'active' ? "selected='selected'" : NULL; ?> > Active </option>
                            <option value='inactive' <?= $compliance_requirement['status'] == 'inactive' ? "selected='selected'" : NULL; ?> > Inactive </option>
                        </select>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class='form-group col-sm-4'>
                    <label  for="txt-compliance_requirement-owner"  class='col-sm-12 form-control-label'>Primary Owner</label>
                    <div class='col-sm-12'>
                        <select  class='form-control' name='owner_0'  onchange="draftSystem();"  id='txt-compliance_requirement-owner'> 
                            <option value=''>SELECT</option>
                            <?php
                            foreach ($data['unit_owners'] as $key => $value):
                                $select = $value['id'] == $compliance_requirement['owner_0'] ? "selected='selected'" : NULL;
                                ?>   
                                <option value='<?= $value['id'] ?>' <?= $select ?> >  <?= $value['names'] ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class='form-group col-sm-4'>
                    <label  for="txt-compliance_requirement-owner"  class='col-sm-12 form-control-label'>Secondary Owner</label>
                    <div class='col-sm-12'>
                        <select  class='form-control' name='owner_1'  onchange="draftSystem();"  id='txt-compliance_requirement-owner'> 
                            <option value=''>SELECT</option>
                            <?php
                            foreach ($data['staff_members'] as $key => $value):
                                $select = $value['id'] == $compliance_requirement['owner_1'] ? "selected='selected'" : NULL;
                                ?>   
                                <option value='<?= $value['id'] ?>' <?= $select ?> >  <?= $value['names'] ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class='form-group col-sm-4'>
                    <label  for="txt-compliance_requirement-owner"  class='col-sm-12 form-control-label'>Tertiary Owner</label>
                    <div class='col-sm-12'>
                        <select  class='form-control' name='owner_2' onchange="draftSystem();"  id='txt-compliance_requirement-owner'> 
                            <option value=''>SELECT</option>
                            <?php
                            foreach ($data['risk_managers'] as $key => $value):
                                $select = $value['id'] == $compliance_requirement['owner_2'] ? "selected='selected'" : NULL;
                                ?>   
                                <option value='<?= $value['id'] ?>' <?= $select ?> >  <?= $value['names'] ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class='form-group'>
                    <label  for="txt-compliance_requirement-summary"  class='col-sm-12 form-control-label'>Summary</label>
                    <div class='col-sm-12'>
                        <textarea class='form-control wysiwyg' rows="5"  onchange="draftSystem();"   name='summary' id='txt-compliance_requirement-summary' placeholder='summary' ><?= $compliance_requirement['summary'] ?></textarea>
                    </div>
                </div>
                <?= files_upload("compliance", "compliance_requirement", $compliance_requirement['id']); ?>
            </div>

        </div>
        <div class='modal-footer'>
            <div id="drafting" class="loading hidden pull-left"><i class="icon icon-pencil fa fa-spin "></i> Drafting ...</div>
            <?php if ($compliance_requirement['draft'] != 0): ?>
                <a href="<?= base_url("index.php/Compliance/deleteComplianceRequirement/{$compliance_requirement['id']}/true"); ?>" class='btn btn-secondary waves-effect'>Cancel</a>
            <?php endif; ?>
            <?php if ($compliance_requirement['draft'] != 0): ?>
                <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Save Draft</button>
            <?php else : ?>
                <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Cancel</button>
            <?php endif; ?>
            <button type='submit' class='btn btn-primary waves-effect'>Save </button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script src="<?= base_url("assets/plugins/jquery.filer/js/jquery.filer.min.js") ?>"></script>
<script src="<?= base_url("assets/plugins/select2/js/select2.full.min.js") ?>"></script>

<script type="text/javascript">
                            unitRepositoryOptions($("#txt-compliance_requirement-environment").val(), <?= $compliance_requirement['id'] ?>,<?= $compliance_requirement['repository'] ?>);
                            function unitRepositoryOptions(unit_id, cr, repo) {
                                var url = "<?= base_url("index.php/Compliance/unitRepositoryOptions/") ?>/" + unit_id + "/" + cr + "/" + repo;
                                //alert()
                                $("#txt-compliance_requirement-repository").html("<option>..Loading..</option>");
                                $("#txt-compliance_requirement-repository").attr("disabled", true);
                                $.post(url, {data: "data"}, function (response) {
                                    $("#txt-compliance_requirement-repository").attr("disabled", false);
                                    $("#txt-compliance_requirement-repository").html(response);
                                });

                            }

                            $('#Comp_req-attachments').filer({
                                limit: 4,
                                maxSize: 3,
                                extensions: ['pdf', 'doc', 'xlsx', 'docx'],
                                changeInput: true,
                                showThumbs: true,
                                addMore: true
                            });
                            function draftSystem() {
                                for (instance in CKEDITOR.instances) {
                                    CKEDITOR.instances[instance].updateElement();
                                }


                                $("#drafting").removeClass("hidden");
                                var url = "<?= base_url("index.php/Compliance/complianceRequirementDraft/") ?>";
                                var formId = "frm_compliance_requirement_form";
                                $.post(url, $("#" + formId).serialize(), function (response) {
                                    //alert(response);
                                    $("#drafting").addClass("hidden");
                                });
                            }

                            $(document).ready(function () {
                                // Select2
                                $(".select2").select2();

                            });
                            CKEDITOR.replace('txt-compliance_requirement-summary');
</script>

<?= form_close(); ?>