<?php $obligations = $data['obligation'] ?>
<?= form_open_multipart("Compliance/obligationPost", array('id' => 'frm_obligation_form', 'class' => 'form-horizontal', "onsubmit" => "return validateObligationForm()")) ?>
<input type='hidden' class='form-control'  name='id' id='txt-obligations-id' value='<?= $obligations['id'] ?>' />

<div class="modal-dialog  ">
    <div class="modal-content"> 
        <div class="modal-header obligation-preview">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title " id="myModalLabel">Reset <?= $data['compliance_requirement']['type'] == 'Statutory Returns' ? "Submission Deadline" : "Review Date" ?> </h4>
        </div>
        <div class="modal-body">
            <div class="">
                <div class='form-group m-b-10'>
                    <label  for="txt-obligations-submission_deadline" id='return_date' class='col-sm-4 form-control-label'>
                        <?= $data['compliance_requirement']['type'] == 'Statutory Returns' ? "Submission Deadline" : "Next Review" ?>    
                    </label> <!-- required  min="<?= strftime("%Y-%m-%d", time()) ?>" -->
                    <div class='col-sm-8'>
                        <input type='date' class='form-control'  name='submission_deadline' min="<?= strftime("%Y-%m-%d", time()) ?>"
                               onchange="document.getElementById('txt-obligations-notification_date').value = this.value" id='txt-obligations-submission_deadline' 
                               value='<?= strftime("%Y-%m-%d", strtotime($obligations['submission_deadline'])) ?>' placeholder='submission_deadline' />
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class='form-group'>
                    <label  for="txt-obligations-notification_date"  class='col-sm-4 form-control-label'>Notification Date</label>
                    <div class='col-sm-8'>
                        <input type='date' class='form-control'  name='notification_date'  id='txt-obligations-notification_date' 
                               value='<?= strftime("%Y-%m-%d", strtotime($obligations['submission_deadline'])) ?>' placeholder='notification_date' />
                        <small class="text-danger" id="notification_message"></small>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class='form-group'>
                    <label class="form-control-label col-sm-4">Activation</label>
                    <div class="col-sm-8">

                        <div class="radio radio-success radio-inline">
                            <input type="radio" id="inlineRadio1" value="active" name="status" <?= $obligations['status'] == 'active' ? "checked" : NULL; ?>/>
                            <label for="inlineRadio1"> Active </label>
                        </div>
                        <div class="radio radio-inline">
                            <input type="radio" id="inlineRadio2" value="inactive" name="status" <?= $obligations['status'] == 'inactive' ? "checked" : NULL; ?>/>
                            <label for="inlineRadio2"> Inactive </label>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class='modal-footer'>
            <button type='submit' class='btn btn-secondary waves-effect'>Save Changes</button>
        </div>
    </div>
</div>
<?php
form_close()?>