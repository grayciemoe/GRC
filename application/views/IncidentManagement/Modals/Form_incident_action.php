<?php
$incident_action = $data['action'];
//print_pre($data);
//die();
?>
<?= form_open_multipart("IncidentManagement/actionPost") ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"><?= $incident_action['draft'] == 0 ? "Edit" : "Add" ?> Action</h4>
        </div>
        <div class="modal-body">

            <input type="number" name="id" value="<?= $incident_action['id'] ?>" hidden/>
            <input type="number" name="incident" value="<?= $incident_action['incident'] ?>" hidden/>
            <div class="form-group">
                <label for="txt-title" class="form-control-label">Title</label>
                <input type="text" name="title" class="form-control" required id="title" placeholder="Title" value="<?= $incident_action['title'] ?>" />
            </div>
            <div class="form-group">
                <label for="txt-owner" class="form-control-label">Owner</label>
                <input type="email" required="" name="owner" class="form-control" id="owner" placeholder="Owner Email : e.g. name@company.com" value="<?= $incident_action['owner'] ?>" />
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">

                        <label for="txt-title" class="form-control-label">Due Date</label>
                        <input type="date" required="" min="<?= strftime("%Y-%m-%d",time()) ?>" name='due_date' class="form-control" id="due_date" value="<?= 
        
        
        strftime("%Y-%m-%d", strtotime($incident_action['due_date'])) ?>" />

                    </div>
                    <div class="col-sm-6">
                        <label for="txt-title" class="form-control-label">Completion Status</label>
                        <select  class='form-control' name='status' id='txt-action-status' <?= $incident_action['draft'] == 0 ? NULL : "disabled" ?>> 
                            <option value='incomplete' <?= $incident_action['status'] == 'incomplete' ? "selected='selected'" : NULL; ?> > Incomplete </option>
                            <option value='complete' <?= $incident_action['status'] == 'complete' ? "selected='selected'" : NULL; ?> > Complete </option>
                        </select>
                    </div>

                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>