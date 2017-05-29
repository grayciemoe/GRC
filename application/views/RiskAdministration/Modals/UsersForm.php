

<?php
$user = $data['user'];
?>
<?= form_open_multipart("Home/userPost", array('id' => '', 'class' => '')) ?>

<div class="modal-dialog modal-lg">

    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"> user </h4>
        </div>
        <div class="modal-body">
            <input type='hidden' class='form-control'  name='id' id='txt-user-id' value='<?= $user['id'] ?>' />
            <div class='form-group row'>
                <label  for="txt-user-username"  class='col-sm-2 form-control-label'>Username</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='username' id='txt-user-username' value='<?= $user['username'] ?>' placeholder='Person Email e.g. name@company.com' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-user-names"  class='col-sm-2 form-control-label'>Names</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='names' id='txt-user-names' value='<?= $user['names'] ?>' placeholder='Full Names' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-user-phone"  class='col-sm-2 form-control-label'>Phone</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='phone' id='txt-user-phone' value='<?= $user['phone'] ?>' placeholder='+254 --- --- ---' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-user-user_type"  class='col-sm-2 form-control-label'>User Type</label>
                <div class='col-sm-10'>
                    <select  class='form-control' required="" name='user_type' id='txt-user-user_type' >
                        <option value="">SELECT</option>
                        <?php foreach ($data['user_types'] as $key => $value): ?>    
                            <option value="<?= $value['id'] ?>" <?= $value['id'] == $user['user_type'] ? "selected='selected'" : NULL ?>><?= $value['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            <button type="submit" class='btn btn-secondary waves-effect'><i class='fa fa-save'></i> Save </button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<?= form_close(); ?>

