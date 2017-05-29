


<?= form_open_multipart("", array('id' => '', 'class' => '')) ?>

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Breach </h4>
        </div>
        <div class='modal-body'>
            <input type='hidden' class='form-control'  name='id' id='txt-breach-id' value='<?= $breach['id'] ?>' />
            <div class='form-group row'>
                <label  for="txt-breach-type"  class='col-sm-2 form-control-label'>Type</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='type' id='txt-breach-type'> 
                        <option value=''>SELECT</option>
                        <option value='Late review' <?= $breach['type'] == 'Late review' ? "selected='selected'" : NULL; ?> > Late Review </option>
                        <option value='non compliance' <?= $breach['type'] == 'non compliance' ? "selected='selected'" : NULL; ?> > Non Compliance </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-breach-obligation"  class='col-sm-2 form-control-label'>Obligation</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='obligation' id='txt-breach-obligation' value='<?= $breach['obligation'] ?>' placeholder='obligation' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-breach-title"  class='col-sm-2 form-control-label'>Title</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'   name='title'  required=''  id='txt-breach-title' value='<?= $breach['title'] ?>' placeholder='title' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-breach-description"  class='col-sm-2 form-control-label'>Description</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg'  name='description' id='txt-breach-description' placeholder='description' ><?= $breach['description'] ?></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-breach-status"  class='col-sm-2 form-control-label'>Status</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='status' id='txt-breach-status'> 
                        <option value='open' <?= $breach['status'] == 'open' ? "selected='selected'" : NULL; ?> > Open </option>
                        <option value='closed' <?= $breach['status'] == 'closed' ? "selected='selected'" : NULL; ?> > Closed </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-breach-report_incident"  class='col-sm-2 form-control-label'>Report Incident</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='report_incident' id='txt-breach-report_incident'> 
                        <option value=''>SELECT</option>
                        <option value='yes' <?= $breach['report_incident'] == 'yes' ? "selected='selected'" : NULL; ?> > Yes </option>
                        <option value='no' <?= $breach['report_incident'] == 'no' ? "selected='selected'" : NULL; ?> > No </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-breach-created"  class='col-sm-2 form-control-label'>Created</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='created' id='txt-breach-created' value='<?= $breach['created'] ?>' placeholder='created' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-breach-action"  class='col-sm-2 form-control-label'>Action</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='action' id='txt-breach-action'> 
                        <option value='pending' <?= $breach['action'] == 'pending' ? "selected='selected'" : NULL; ?> > Pending </option>
                        <option value='declined' <?= $breach['action'] == 'declined' ? "selected='selected'" : NULL; ?> > Declined </option>
                        <option value='reported' <?= $breach['action'] == 'reported' ? "selected='selected'" : NULL; ?> > Reported </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-breach-ref_code"  class='col-sm-2 form-control-label'>Ref Code</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='ref_code' id='txt-breach-ref_code' value='<?= $breach['ref_code'] ?>' placeholder='ref_code' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-breach-obligation_date"  class='col-sm-2 form-control-label'>Obligation Date</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='obligation_date' id='txt-breach-obligation_date' value='<?= $breach['obligation_date'] ?>' placeholder='obligation_date' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-breach-penalty"  class='col-sm-2 form-control-label'>Penalty</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='penalty' id='txt-breach-penalty' value='<?= $breach['penalty'] ?>' placeholder='penalty' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-breach-approved"  class='col-sm-2 form-control-label'>Approved</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='approved' id='txt-breach-approved'> 
                        <option value=''>SELECT</option>
                        <option value='approved' <?= $breach['approved'] == 'approved' ? "selected='selected'" : NULL; ?> > Approved </option>
                        <option value='rejected' <?= $breach['approved'] == 'rejected' ? "selected='selected'" : NULL; ?> > Rejected </option>
                        <option value='pending' <?= $breach['approved'] == 'pending' ? "selected='selected'" : NULL; ?> > Pending </option>
                    </select>
                </div>
            </div>



        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>