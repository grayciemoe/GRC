
<?php $control_activity = $data['activity']; ?>

<?= form_open_multipart("Risk/activityPost", array('id' => '', 'class' => 'form-vertical')) ?>
<input type='hidden' class='form-control'  name='id' id='txt-control_activity-id' value='<?= $control_activity['id'] ?>' />

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Control Activity </h4>
        </div>
        <div class='modal-body'>
            <div class="row">
                <div class="col-sm-4">
                    <div class='form-group'>
                        <label  for="txt-control_activity-name"  class='col-sm-12 form-control-label'>Name</label>
                        <div class='col-sm-12'>
                            <input type='text' class='form-control'   name='name'  required id='txt-control_activity-name' value='<?= $control_activity['name'] ?>' placeholder='name' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-control_activity-owner"  class='col-sm-12 form-control-label'>Owner</label>
                        <div class='col-sm-12'>
                            <select  class='form-control'name='owner' required id='txt-control_activity-owner'> 
                                <option value=''>SELECT</option>
                                <?php foreach ($data['owners'] as $key => $value): ?>
                                    <option value='<?= $value['id'] ?>' <?= $control_activity['owner'] == $value['id'] ? "selected='selected'" : NULL; ?> > <?= $value['names'] ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label  for="txt-control_activity-action_by"  class='col-sm-12 form-control-label'>Action By</label>
                        <div class='col-sm-12'>
                            <input type='email' class='form-control' required name='action_by' id='txt-control_activity-action_by' value='<?= $control_activity['action_by'] ?>' placeholder='Enter Email e.g. user@domain.com' />

                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-control_activity-action_due_date" required class='col-sm-12 form-control-label'>Action Due Date</label>
                        <div class='col-sm-12'>
                            <input type='date' class='form-control' required  name='action_due_date' id='txt-control_activity-action_due_date' min="<?= strftime("%Y-%m-%d", time()) ?>" value='<?= strftime("%Y-%m-%d", strtotime($control_activity['action_due_date'])) ?>' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-control_activity-last_review" required class='col-sm-12 form-control-label'>Last Review Date</label>
                        <div class='col-sm-12'>
                            <input type='date' class='form-control' required  name='last_review' id='txt-control_activity-last_review_date' value='<?= strftime("%Y-%m-%d", strtotime($control_activity['last_review'])) ?>' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-control_activity-next_review" required class='col-sm-12 form-control-label'>Next Review Date</label>
                        <div class='col-sm-12'>
                            <input type='date' class='form-control'  name='next_review' id='txt-control_activity-next_review_date' min="<?= strftime("%Y-%m-%d", time()) ?>" value='<?= strftime("%Y-%m-%d", strtotime($control_activity['next_review'])) ?>' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-control_activity-status"  class='col-sm-12 form-control-label'>Status</label>
                        <div class='col-sm-12'>
                            <select  class='form-control' name='status' <?= $control_activity['draft'] != 0 ? 'disabled="true"' : "required" ?>  id='txt-control_activity-status'>
                                <option value="">SELECT</option>
                                <option value='complete' <?= $control_activity['status'] == 'complete' ? "selected='selected'" : NULL; ?> > Complete </option>
                                <option value='incomplete' <?= $control_activity['status'] == 'incomplete' ? "selected='selected'" : NULL; ?> > Incomplete </option>
                            </select>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-control_activity-type"  class='col-sm-12 form-control-label'>Type</label>
                        <div class='col-sm-12'>
                            <select  class='form-control' name='type' required id='txt-control_activity-type'>
                                <option value="">SELECT</option>
                                <option value='manual' <?= $control_activity['type'] == 'manual' ? "selected='selected'" : NULL; ?> > Manual </option>
                                <option value='automated' <?= $control_activity['type'] == 'automated' ? "selected='selected'" : NULL; ?> > Automated </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class='form-group'>
                        <label  for="txt-control_activity-frequency"  class='col-sm-12 form-control-label'>Frequency</label>
                        <div class='col-sm-12'>
                            <select  class='form-control' name='frequency' onchange="findfrequencyrepeat(this.value)" required id='txt-control_activity-frequency'>

                                <option value='once' <?= $control_activity['frequency'] == 'once' ? "selected='selected'" : NULL; ?> > Once </option>
                                <option value='cyclical' <?= $control_activity['frequency'] == 'cyclical' ? "selected='selected'" : NULL; ?> > Cyclical </option>
                            </select>
                        </div>
                    </div>
                    <div class='form-group hidden' id="frequency_repeat">
                        <label  for="txt-control_activity-frequency_repeat"  class='col-sm-12 form-control-label'>Frequency Repeat</label>
                        <div class='col-sm-12'>
                            <select  class='form-control' name='frequency_repeat' required id='txt-control_activity-frequency_repeat'>
                                <option value="">SELECT</option>
                                <option value='annually' <?= $control_activity['frequency_repeat'] == 'annually' ? "selected='selected'" : NULL; ?> > Annually </option>
                                <option value='semi_annually' <?= $control_activity['frequency_repeat'] == 'semi_annually' ? "selected='selected'" : NULL; ?> > Semi Annually </option>
                                <option value='quarterly' <?= $control_activity['frequency_repeat'] == 'quarterly' ? "selected='selected'" : NULL; ?> > Quarterly </option>
                                <option value='monthly' <?= $control_activity['frequency_repeat'] == 'monthly' ? "selected='selected'" : NULL; ?> > Monthly </option>
                                <option value='weekly' <?= $control_activity['frequency_repeat'] == 'weekly' ? "selected='selected'" : NULL; ?> > Weekly </option>
                                <option value='daily' <?= $control_activity['frequency_repeat'] == 'daily' ? "selected='selected'" : NULL; ?> > Daily </option>
                            </select>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label  for="txt-control_activity-criticality"  class='col-sm-12 form-control-label'>Criticality</label>
                        <div class='col-sm-12'>
                            <select  class='form-control'name='criticality' required id='txt-control_activity-criticality'>
                                <option value="">SELECT</option>
                                <option value='high' <?= $control_activity['criticality'] == 'high' ? "selected='selected'" : NULL; ?> > High </option>
                                <option value='medium' <?= $control_activity['criticality'] == 'medium' ? "selected='selected'" : NULL; ?> > Medium </option>
                                <option value='low' <?= $control_activity['criticality'] == 'low' ? "selected='selected'" : NULL; ?> > Low </option>
                            </select>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label  for="txt-control_activity-description" class='col-sm-12 form-control-label'>Description</label>
                        <div class='col-sm-12'>
                            <textarea class='form-control wysiwyg' rows="23" name='description' id='txt-control_activity-description' placeholder='description' ><?= $control_activity['description'] ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='submit' class='btn btn-secondary waves-effect' >Save</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>
<script>
    CKEDITOR.replace('txt-control_activity-description');
    findfrequencyrepeat(repeat);
    frequency_options($('#txt-control_activity-frequency').val());


    function findfrequencyrepeat(repeat) {
        if (repeat === "cyclical") {
            $('#frequency_repeat').removeClass('hidden');
        } else {
            $('#frequency_repeat').addClass('hidden');
        }

    }

</script>