
<?php
$register = $data['register'];
//print_pre($register); exit;
?>
<?= form_open_multipart("Compliance/registerPost", array('id' => '', 'class' => '')) ?>
<input type='hidden' class='form-control'  name='id' id='txt-compliance_register-id' value='<?= $register['id'] ?>' />
<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Compliance Register </h4>
        </div>
        <div class='modal-body'>
            <div class="row">
                <div class="col-sm-5">
                    <div class='form-group'>
                        <label  for="txt-compliance_register-title"  class='col-sm-12 form-control-label'>Title</label>
                        <div class='col-sm-12'>
                            <input type='text' class='form-control'   name='title'  required=''  id='txt-compliance_register-title' value='<?= $register['title'] ?>' placeholder='title' />
                        </div>
                    </div>
                    <!--                    <div class='form-group'>
                                            <label  for="txt-compliance_register-category"  class='col-sm-12 form-control-label'>Category</label>
                                            <div class='col-sm-12'>
                                                <input type='text' class='form-control'  name='category' id='txt-compliance_register-category' value='<?= $register['category'] ?>' placeholder='category' />
                                            </div>
                                        </div>-->
                    <div class='form-group'>
                        <label  for="txt-compliance_register-owner"  class='col-sm-12 form-control-label'>Owner</label>
                        <div class='col-sm-12'>
                            <select  class='form-control'  name='owner' id='txt-compliance_register-owner'>
                                <option value=''>SELECT</option>
                                <?php foreach ($data['owners'] as $key => $value): ?>
                                    <option value="<?= $value['id'] ?>" <?= $value['id'] == $register['user'] ? "selected" : null ?>> <?= $value['names'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!--                    <div class='form-group'>
                                            <label  for="txt-compliance_register-type"  class='col-sm-12 form-control-label'>Type</label>
                                            <div class='col-sm-12'>
                                                <input type='text' class='form-control'  name='type' id='txt-compliance_register-type' value='<?= $register['category'] ?>' placeholder='type' />
                                            </div>
                                        </div>-->

                </div>
                <div class="col-sm-7">
                    <div class='form-group'>
                        <label  for="txt-compliance_register-summary"  class='col-sm-12 form-control-label'>Summary</label>
                        <div class='col-sm-12'>
                            <textarea class='form-control wysiwyg' rows="11" name='summary' id='txt-compliance_register-summary' placeholder='summary' ><?= $register['summary'] ?></textarea>
                        </div>
                    </div>

                </div>
            </div>



        </div>
        <div class='modal-footer'>
            <div id="drafting" class="loading hidden"><i class="icon icon-pencil fa fa-spin "></i> Drafting ...</div>

            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='submit' class='btn btn-secondary waves-effect' >Save</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>
<script>
    CKEDITOR.replace('txt-compliance_register-summary');

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

</script>