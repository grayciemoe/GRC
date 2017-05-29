<?= form_open("Compliance/obligation_dependentPost", array('id' => 'frm-compliance_dependent', 'class' => '', 'onsubmit' => 'return submit_form_dependent();')) ?>
<?php
$compliance_dependent = $data['obligation_dependent'];
?>
<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Compliance Dependent </h4>
        </div>
        <div class='modal-body'>
            <input type='hidden' class='form-control'  name='id' id='txt-compliance_dependent-id' value='<?= $compliance_dependent['id'] ?>' />
            <input type='hidden' class='form-control'  name='obligations' id='txt-compliance_dependent-obligations' value='<?= $compliance_dependent['obligations'] ?>' />
            <div class='form-group row'>
                <label  for="txt-compliance_dependent-type"  class='col-sm-2 form-control-label'>Type</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='type' required="" id='txt-compliance_dependent-type'> 
                        <option value=''>SELECT</option>
                        <option value='customer' <?= $compliance_dependent['type'] == 'customer' ? "selected='selected'" : NULL; ?> > Customer </option>
                        <option value='external' <?= $compliance_dependent['type'] == 'external' ? "selected='selected'" : NULL; ?> > External </option>
                        <option value='internal' <?= $compliance_dependent['type'] == 'internal' ? "selected='selected'" : NULL; ?> > Internal </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-compliance_dependent-title"  class='col-sm-2 form-control-label'>Title</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control' required  name='title' id='txt-compliance_dependent-title' value='<?= $compliance_dependent['title'] ?>' placeholder='title' />
                    <small id="msg-compliance_dependent-title" class="text-danger"></small>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-compliance_dependent-desciption"  class='col-sm-2 form-control-label'>Description</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg'  name='desciption' id='txt-compliance_dependent-desciption' placeholder='desciption' ><?= $compliance_dependent['desciption'] ?></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-compliance_dependent-what_is_needed"  class='col-sm-2 form-control-label'>What Is Needed</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg'  name='what_is_needed' id='txt-compliance_dependent-what_is_needed' placeholder='what_is_needed' ><?= $compliance_dependent['what_is_needed'] ?></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-compliance_dependent-activities"  class='col-sm-2 form-control-label'>Activities</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='activities' id='txt-compliance_dependent-activities' value='<?= $compliance_dependent['activities'] ?>' placeholder='activities' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-compliance_dependent-contact_name"  class='col-sm-2 form-control-label'>Contact Name</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='contact_name' id='txt-compliance_dependent-contact_name' value='<?= $compliance_dependent['contact_name'] ?>' placeholder='contact_name' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-compliance_dependent-contact_phone"  class='col-sm-2 form-control-label'>Contact Phone</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='contact_phone' id='txt-compliance_dependent-contact_phone' value='<?= $compliance_dependent['contact_phone'] ?>' placeholder='contact_phone' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-compliance_dependent-contact_email"  class='col-sm-2 form-control-label'>Contact Email</label>
                <div class='col-sm-10'>
                    <input type='email' class='form-control'  name='contact_email' id='txt-compliance_dependent-contact_email' value='<?= $compliance_dependent['contact_email'] ?>' placeholder='contact_email' />
                    <small id="msg-compliance_dependent-contact_email" class="text-danger"></small>
                </div>
            </div>



        </div>
        <div class='modal-footer' id="footer_model_dependent">
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='button' onclick="submit_form_dependent()" class='btn btn-secondary waves-effect' >Save</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>

<script>

    function submit_form_dependent() {

        if ($("#txt-compliance_dependent-title").val() === "") {
            $("#msg-compliance_dependent-title").html("This field is required");
            return false;
        }
        if (!validateEmail($("#txt-compliance_dependent-contact_email").val())) {
            $("#msg-compliance_dependent-contact_email").html("Please Provide a valid email");
            return false;
        }

        document.getElementById('footer_model_dependent').innerHTML = '<p><i class=\'fa fa-spin fa-spinner\'></i> Saving Changes</p>';
        document.getElementById('frm-compliance_dependent').submit();

        return true;
    }
    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }


</script>