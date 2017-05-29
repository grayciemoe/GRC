<link href="<?= base_url("assets/plugins/jquery.filer/css/jquery.filer.css") ?>" rel="stylesheet" />
<link href="<?= base_url("assets/plugins/multiselect/css/multi-select.css") ?>"  rel="stylesheet" type="text/css" />
<link href="<?= base_url("assets/plugins/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url("assets/css/style.css") ?>" rel="stylesheet" type="text/css" />
<?php
$audit = $data['audit'];
//$audit_area_list = jsonToArray($audit['audit_area']);
//foreach ($data['audit_area'] as $key => $value) {
//    if (in_array($value['id'], $audit_area_list)) {
//        echo "selected='selected'";
//    } else {
//        print_pre($audit_area_list);
//    }
//}
//print_pre($data);
//exit;
?>
<?= form_open_multipart("Audit/postAudit", array('id' => 'frm_audit_form', 'class' => '')) ?>

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Audit </h4>
        </div>
        <div class='modal-body'>
            <div class="row">
                <input type='hidden' class='form-control' onchange="draftSystem();"  name='id' id='txt-audit-id' value='<?= $audit['id'] ?>' />

                <div class='form-group col-sm-12'>
                    <label  for="txt-audit-name"  class='col-sm-12 form-control-label'>Audit Name</label>
                    <div class='col-sm-12'>
                        <input type='text' onchange="draftSystem();" class='form-control'  name='audit_name'  required  id='txt-audit-name' value='<?= $audit['audit_name'] ?>' placeholder='Audit Name' />
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class='form-group col-sm-4'>
                    <label  for="txt-audit-ref"  class='col-sm-12 form-control-label'>Ref Code</label>
                    <div class='col-sm-12'>
                        <input type='text' onchange="draftSystem();" class='form-control' required name='ref_code' id='txt-audit-ref' value='<?= $audit['ref_code'] ?>' placeholder='Ref Code' />
                    </div>
                </div>

                <!--                <div class='form-group col-sm-4'>
                                    <label  for="txt-audit-environment"  class='col-sm-12 form-control-label'>Unit</label>
                                    <div class='col-sm-12'>
                                        <select  class='form-control select2' onchange="draftSystem();" required  name='environment' id='txt-audit-environment'> 
                
                                            <option value="">SELECT UNIT</option>
                <?php
                foreach ($data['environments'] as $key => $level):
                    ?>
                                                        <optgroup label="<?= $key ?>">
                    <?php
                    foreach ($level as $key => $value):
                        $sel = $value['id'] == $audit['environment'] ? "selected='selected'" : NULL;
                        ?>
                                                                        <option <?= $sel ?> value='<?= $value['id'] ?>' 
                        <?= $sel ?> > <?= $value['environment_level']['initials'] . " : " . $value['name'] ?> 
                                                                        </option>
                    <?php endforeach; ?>
                                                        </optgroup>
                <?php endforeach; ?>
                                        </select>
                
                                    </div>
                                </div>-->
                <div class='form-group col-sm-4'>
                    <label  for="txt-audit-environment"  class='col-sm-12 form-control-label'>Unit</label>
                    <div class='col-sm-12'>
                        <select  class="select2 form-control select2-multiple" multiple="multiple" multiple data-placeholder="Choose ..." onchange="draftSystem();" required  name='environment[]' id='txt-audit-environment'> 

                            <?php
                            if(is_array(jsonToArray($audit['environment']))){
                                $env_list = jsonToArray($audit['environment']);
                            }else{
                                $env_list = array();
                            }                            
                            foreach ($data['environments'] as $key => $level):
                                ?>
                                <optgroup label="<?= $key ?>">
                                    <?php
                                    foreach ($level as $key => $value):
//                                        $sel = $value['id'] == $data['environment'] ? "selected='selected'" : NULL;
                                        ?>
                                        <option value='<?= $value['id'] ?>' 
                                        <?php
                                        if (in_array($value['id'], $env_list)) {
                                            echo "selected='selected'";
                                        }
                                        ?> > <?= $value['environment_level']['initials'] . " : " . $value['name'] ?> 
                                        </option>
                                <?php endforeach; ?>
                                </optgroup>
<?php endforeach; ?>
                        </select>

                    </div>
                </div>

                <div class='form-group col-sm-4'>
                    <label  for="txt-audit-area"  class='col-sm-12 form-control-label'>Audit Area
                        <a class="pull-right" href="<?= base_url('index.php/Audit/auditAreaForm/0/'.$audit['corporate'].'/' . $audit['id'] . '/audit') ?>" <?= MODAL_AJAX ?>>Add An Audit Area</a>
                    </label>
                    <div class='col-sm-12'>
                        <select  class="select2 form-control select2-multiple" multiple="multiple" multiple name='audit_area[]' onchange="draftSystem();"  required  id='txt-audit-owner'> 

                            <?php
                            $audit_area_list = jsonToArray($audit['audit_area']);
                            foreach ($data['audit_area'] as $key => $value):
                                ?>   
                                <option value='<?= $value['id'] ?>' <?php
                                if (!empty($audit_area_list)) {
                                    if (in_array($value['id'], $audit_area_list)) {
                                        echo "selected='selected'";
                                    }
                                }
                                ?> >  <?= $value['title'] ?> </option>
<?php endforeach; ?>
                        </select>
                    </div>
                </div>


                <div class="clearfix"></div>
                <div class='form-group col-sm-4'>
                    <label  for="txt-audit-owner"  class='col-sm-12 form-control-label'>Auditor</label>
                    <div class='col-sm-12'>
                        <select  class='form-control' onchange="draftSystem();" name='auditor'  required  id='txt-audit-owner'> 
                            <option value=''>SELECT</option>
                            <?php
                            foreach ($data['auditor'] as $key => $value):
                                $select = $value['id'] == $audit['auditor'] ? "selected='selected'" : NULL;
                                ?>   
                                <option value='<?= $value['id'] ?>' <?= $select ?> >  <?= $value['names'] ?> </option>
<?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class='form-group col-sm-4'>
                    <label  for="txt-audit-type"  class='col-sm-12 form-control-label'>Audit Type</label>
                    <div class='col-sm-12'>
                        <select  class='form-control' onchange="draftSystem();" required name='audit_type' id='txt-audit-type'> 
                            <option value=''>SELECT</option>
                            <option value='External' <?= $audit['audit_type'] == 'External' ? "selected='selected'" : NULL; ?> > External </option>
                            <option value='Internal' <?= $audit['audit_type'] == 'Internal' ? "selected='selected'" : NULL; ?> > Internal </option>
                        </select>
                    </div>
                </div>

                <div class='form-group col-sm-4'>
                    <label  for="txt-audit_date"  class='col-sm-12 form-control-label'>Audit as at</label>
                    <div class='col-sm-12'>
                        <input type='date' onchange="draftSystem();" class='form-control' required  name='audit_date' id='txt-audit_date' value='<?= strftime("%Y-%m-%d", strtotime($audit['audit_date'])) ?>' />
                    </div>
                </div>

                <div class="clearfix"></div>

<?= files_upload("audit", "audit", $audit['id']); ?>
            </div>

        </div>
        <div class='modal-footer'>
            <div class="hidden pull-left" id="drafting"><span class="fa icon icon-hourglass fa-spin"></span> Drafting</div>
            <div class="btn-group pull-right">
<?php if ($audit['draft'] != 0): ?>
                    <a class='btn btn-secondary btn-sm waves-effect waves-light pull-right' href="<?= base_url("index.php/Audit/deleteAudit/{$audit['id']}/true") ?>"> Discard Draft </a>

<?php endif; ?>
                <a class='btn btn-secondary btn-sm waves-effect' data-dismiss='modal'>Save Draft</a>
                <button type='submit' class='btn btn-sm btn-primary waves-effect'>Save </button>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script src="<?= base_url("assets/plugins/jquery.filer/js/jquery.filer.min.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/plugins/multiselect/js/jquery.multi-select.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/plugins/jquery-quicksearch/jquery.quicksearch.js") ?>"></script>
<script src="<?= base_url("assets/plugins/select2/js/select2.full.min.js") ?>"></script>
<script>
                            $(document).ready(function () {
                                $(".select2").select2();
                                //$(".multi-select").multiSelect();

                            });
                            function discardDraft() {
                                document.getElementById('frm_audit_form').reset();
                                draftSystem();
                            }



                            function draftSystem() {

                                for (instance in CKEDITOR.instances) {
                                    CKEDITOR.instances[instance].updateElement();
                                }


                                $("#drafting").removeClass("hidden");
                                var url = "<?= base_url("index.php/Audit/auditDraft/") ?>";
                                var formId = "frm_audit_form";
                                $.post(url, $("#" + formId).serialize(), function (response) {
                                    //alert(response);
                                    $("#drafting").addClass("hidden");
                                });
                            }
</script>

<?= form_close(); ?>