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
            <input type='hidden' class='form-control'  name='id' id='txt-laws_and_regulations-id' value='<?= $laws_and_regulations['id'] ?>' />
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-ref_code"  class='col-sm-2 form-control-label'>Ref Code</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='ref_code' id='txt-laws_and_regulations-ref_code' value='<?= $laws_and_regulations['ref_code'] ?>' placeholder='ref_code' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-name"  class='col-sm-2 form-control-label'>Name</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'   name='name'  required=''  id='txt-laws_and_regulations-name' value='<?= $laws_and_regulations['name'] ?>' placeholder='name' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-type"  class='col-sm-2 form-control-label'>Type</label>
                <div class='col-sm-10'>
                    <select  class='form-control' required="" name='type' id='txt-laws_and_regulations-type'> 
                        <option value="">SELECT</option>
                        <option value='Act' <?= $laws_and_regulations['type'] == 'Act' ? "selected='selected'" : NULL; ?> > Act </option>
                        <option value='Regulation' <?= $laws_and_regulations['type'] == 'Regulation' ? "selected='selected'" : NULL; ?> > Regulation </option>
                        <option value='Guideline' <?= $laws_and_regulations['type'] == 'Guideline' ? "selected='selected'" : NULL; ?> > Guideline </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-effective_date"  class='col-sm-2 form-control-label'>Effective Date</label>
                <div class='col-sm-10'>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-legislative_authority"  class='col-sm-2 form-control-label'>Legislative Authority</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='legislative_authority' id='txt-laws_and_regulations-legislative_authority' value='<?= $laws_and_regulations['legislative_authority'] ?>' placeholder='legislative_authority' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-enforcing_authority"  class='col-sm-2 form-control-label'>Enforcing Authority</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='enforcing_authority' id='txt-laws_and_regulations-enforcing_authority' value='<?= $laws_and_regulations['enforcing_authority'] ?>' placeholder='enforcing_authority' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-last_revised_date"  class='col-sm-2 form-control-label'>Last Revised Date</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='last_revised_date' id='txt-laws_and_regulations-last_revised_date' value='<?= $laws_and_regulations['last_revised_date'] ?>' placeholder='last_revised_date' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-type_2"  class='col-sm-2 form-control-label'>Type 2</label>
                <div class='col-sm-10'>
                    <select  class='form-control' required="" name='type_2' id='txt-laws_and_regulations-type_2'> 
                        <option value="">SELECT</option>
                        <option value='one time' <?= $laws_and_regulations['type_2'] == 'one time' ? "selected='selected'" : NULL; ?> > One Time </option>
                        <option value='perpetual' <?= $laws_and_regulations['type_2'] == 'perpetual' ? "selected='selected'" : NULL; ?> > Perpetual </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-environment"  class='col-sm-2 form-control-label'>Environment</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='environment' id='txt-laws_and_regulations-environment' value='<?= $laws_and_regulations['environment'] ?>' placeholder='environment' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-approved"  class='col-sm-2 form-control-label'>Approved</label>
                <div class='col-sm-10'>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-kra_clipboard"  class='col-sm-2 form-control-label'>Kra Clipboard</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='kra_clipboard' id='txt-laws_and_regulations-kra_clipboard' value='<?= $laws_and_regulations['kra_clipboard'] ?>' placeholder='kra_clipboard' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-laws_and_regulations-created"  class='col-sm-2 form-control-label'>Created</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='created' id='txt-laws_and_regulations-created' value='<?= $laws_and_regulations['created'] ?>' placeholder='created' />
                </div>
            </div>



        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>

