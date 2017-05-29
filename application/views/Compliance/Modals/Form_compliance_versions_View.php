
            

<?= form_open_multipart("",array('id'=>'','class'=>''))?>

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Compliance Versions </h4>
        </div>
        <div class='modal-body'>
		<input type='hidden' class='form-control'  name='id' id='txt-compliance_versions-id' value='<?= $compliance_versions['id']?>' />
				<div class='form-group row'>
<label  for="txt-compliance_versions-compliance_requirement"  class='col-sm-2 form-control-label'>Compliance Requirement</label>
<div class='col-sm-10'>
<input type='number' class='form-control'  name='compliance_requirement' id='txt-compliance_versions-compliance_requirement' value='<?= $compliance_versions['compliance_requirement']?>' placeholder='compliance_requirement' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-compliance_versions-version"  class='col-sm-2 form-control-label'>Version</label>
<div class='col-sm-10'>
<input type='text' class='form-control'  name='version' id='txt-compliance_versions-version' value='<?= $compliance_versions['version']?>' placeholder='version' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-compliance_versions-obligaitons"  class='col-sm-2 form-control-label'>Obligaitons</label>
<div class='col-sm-10'>
<textarea class='form-control wysiwyg'  name='obligaitons' id='txt-compliance_versions-obligaitons' placeholder='obligaitons' ><?= $compliance_versions['obligaitons']?></textarea>
</div>
</div>
<div class='form-group row'>
<label  for="txt-compliance_versions-timestamp"  class='col-sm-2 form-control-label'>Timestamp</label>
<div class='col-sm-10'>
<input type='date' class='form-control'  name='timestamp' id='txt-compliance_versions-timestamp' value='<?= $compliance_versions['timestamp']?>' placeholder='timestamp' />
</div>
</div>
<div class='form-group row'>
<label  for="txt-compliance_versions-total_obligations"  class='col-sm-2 form-control-label'>Total Obligations</label>
<div class='col-sm-10'>
<input type='number' class='form-control'  name='total_obligations' id='txt-compliance_versions-total_obligations' value='<?= $compliance_versions['total_obligations']?>' placeholder='total_obligations' />
</div>
</div>


			
            </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>