
<?php $authority = $data['authority']; ?>

<?= form_open_multipart("Compliance/authorityPost/", array('id' => 'frm-authority', 'class' => '', 'onsubmit' => 'ajaxFormPost("frm-authority")')) ?>

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Authority </h4>
        </div>
        <div class='modal-body'>
            <input type='hidden' class='form-control'  name='id' id='txt-authority-id' value='<?= $authority['id'] ?>' />
            <div class="response"></div>
            <div class='form-group row'>
                <label  for="txt-authority-type"  class='col-sm-2 form-control-label'>Type</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='type' id='txt-authority-type'> 
                        <option value=''>SELECT</option>
                        <option value='government' <?= $authority['type'] == 'government' ? "selected='selected'" : NULL; ?> > Government </option>
                        <option value='legal' <?= $authority['type'] == 'legal' ? "selected='selected'" : NULL; ?> > Legal </option>
                        <option value='regulatory' <?= $authority['type'] == 'regulatory' ? "selected='selected'" : NULL; ?> > Regulatory </option>
                        <option value='internal' <?= $authority['type'] == 'internal' ? "selected='selected'" : NULL; ?> > Internal </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-authority-title"  class='col-sm-2 form-control-label'>Title</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'   name='title'  required=''  id='txt-authority-title' value='<?= $authority['title'] ?>' placeholder='title' />
                </div>
            </div>
            <div class='form-group row hidden'>
                <label  for="txt-authority-category"  class='col-sm-2 form-control-label'>Category</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='category' id='txt-authority-category' value='<?= $authority['category'] ?>' placeholder='category' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-authority-report_sent_to"  class='col-sm-2 form-control-label'>Report Sent To</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='report_sent_to' id='txt-authority-report_sent_to' value='<?= $authority['report_sent_to'] ?>' placeholder='Full Names' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-authority-contact_name"  class='col-sm-2 form-control-label'>Contact Name</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='contact_name' id='txt-authority-contact_name' value='<?= $authority['contact_name'] ?>' placeholder='Full Names' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-authority-contact_email"  class='col-sm-2 form-control-label'>Contact Email</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='contact_email' id='txt-authority-contact_email' value='<?= $authority['contact_email'] ?>' placeholder='' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-authority-contact_address"  class='col-sm-2 form-control-label'>Contact Address</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='contact_address' id='txt-authority-contact_address' value='<?= $authority['contact_address'] ?>' placeholder='' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-authority-contact_phone"  class='col-sm-2 form-control-label'>Contact Phone</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='contact_phone' id='txt-authority-contact_phone' value='<?= $authority['contact_phone'] ?>' placeholder='' />
                </div>
            </div>


        </div>
        <div class='modal-footer'>

            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='submit' class='btn btn-primary waves-effect' >Save Changes</button>

        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>