<?php
$laws_and_regulations = $data['repository'][$data['repository']['source']]
?>
<?= form_open_multipart("Home/repositoryPost", array('id' => '', 'class' => '')) ?>
<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Laws And Regulations </h4>
        </div>
        <div class='modal-body'>
            <input type='hidden' class='form-control'  name='repository_id' id='txt-best_practices-id' value='<?= $data['repository']['id'] ?>' />

            <input type='hidden' class='form-control'  name='id' id='txt-laws_and_regulations-id' value='<?= $laws_and_regulations['id'] ?>' />
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-ref_code"  class='col-sm-3 form-control-label'>Ref Code</label>
                <div class='col-sm-9'>
                    <input type='text' class='form-control'  name='ref_code' id='txt-laws_and_regulations-ref_code' value='<?= $laws_and_regulations['ref_code'] ?>' placeholder='ref_code' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-name"  class='col-sm-3 form-control-label'>Name</label>
                <div class='col-sm-9'>
                    <input type='text' class='form-control'   name='name'  required=''  id='txt-laws_and_regulations-name' value='<?= $laws_and_regulations['name'] ?>' placeholder='name' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-type"  class='col-sm-3 form-control-label'>Type</label>
                <div class='col-sm-9'>
                    <select  class='form-control'name='type' id='txt-laws_and_regulations-type'> 
                        <option value='Act' <?= $laws_and_regulations['type'] == 'Act' ? "selected='selected'" : NULL; ?> > Act </option>
                        <option value='Regulation' <?= $laws_and_regulations['type'] == 'Regulation' ? "selected='selected'" : NULL; ?> > Regulation </option>
                        <option value='Guideline' <?= $laws_and_regulations['type'] == 'Guideline' ? "selected='selected'" : NULL; ?> > Guideline </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-legislative_authority"  class='col-sm-3 form-control-label'>Legislative Authority</label>
                <div class='col-sm-9'>
                    <input type='text' class='form-control'  name='legislative_authority' id='txt-laws_and_regulations-legislative_authority' value='<?= $laws_and_regulations['legislative_authority'] ?>' placeholder='legislative_authority' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-enforcing_authority"  class='col-sm-3 form-control-label'>Enforcing Authority</label>
                <div class='col-sm-9'>
                    <input type='text' class='form-control'  name='enforcing_authority' id='txt-laws_and_regulations-enforcing_authority' value='<?= $laws_and_regulations['enforcing_authority'] ?>' placeholder='enforcing_authority' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-last_revised_date"  class='col-sm-3 form-control-label'>Last Revised Date</label>
                <div class='col-sm-9'>
                    <input type='date' class='form-control'  name='last_revised_date' id='txt-laws_and_regulations-last_revised_date' value='<?= $laws_and_regulations['last_revised_date'] ?>' placeholder='last_revised_date' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-type_2"  class='col-sm-3 form-control-label'>Frequency </label>
                <div class='col-sm-9'>
                    <select  class='form-control'name='type_2' id='txt-laws_and_regulations-type_2'> 
                        <option value='one time' <?= $laws_and_regulations['type_2'] == 'one time' ? "selected='selected'" : NULL; ?> > One Time </option>
                        <option value='perpetual' <?= $laws_and_regulations['type_2'] == 'perpetual' ? "selected='selected'" : NULL; ?> > Perpetual </option>
                    </select>
                </div>
            </div>
            <?= files_upload("environmen", "repository", $laws_and_regulations['id']); ?>
        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='submit' class='btn btn-secondary waves-effect' >Save</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>

