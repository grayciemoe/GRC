<?php
$environment = $data['environment'];
?>

<?= form_open_multipart("Home/postUnit", array('id' => '', 'class' => '')) ?>
<?php
$title = NULL;

$index = $environment['draft'] == 0 ? "Edit" : "New";
$title = "$index {$data['environment_level']['name']} <strong class='text-info'>{$environment['name']}</strong>";
?>
<div class="modal-dialog modal-lg">

    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"> <?= $title ?></h4>
        </div>
        <div class="modal-body">
            <input type='hidden' class='form-control'  name='id' id='txt-environment-id' value='<?= $environment['id'] ?>' placeholder='parent_id' />
            <input type='hidden' class='form-control'  name='parent_id' id='txt-environment-parent_id' value='<?= $environment['parent_id'] ?>' placeholder='parent_id' />
            <input type='hidden' class='form-control'  name='environment_level' id='txt-environment-environment_level' value='<?= $environment['environment_level'] ?>' placeholder='environment_level' />
            <input type='hidden' class='form-control'  name='ref_code' id='txt-environment-ref_code' value='<?= $environment['ref_code'] ?>' placeholder='ref_code' />

            <div class='form-group row'>
                <label  for="txt-environment-name"  class='col-sm-2 form-control-label'>Name</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'   name='name'  required  id='txt-environment-name' value='<?= $environment['name'] ?>' placeholder='name' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-environment-description"  class='col-sm-2 form-control-label'>Description</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg' rows="5" name='description' id='txt-environment-description' placeholder='description' ><?= $environment['description'] ?></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <?php if ($data['environment_level']['id'] == 1): ?>
                    <label  for="txt-environment-unit_owner"  class='col-sm-2 form-control-label'>Corporate Admin</label>
                <?php else : ?>
                    <label  for="txt-environment-unit_owner"  class='col-sm-2 form-control-label'>Unit Owner</label>
                <?php endif; ?>

                <div class='col-sm-10'>
                    <select  class='form-control'   
                    <?php
                    if (!am_user_type(array(1, 9))) {
                        echo "disabled";
                    } else {
                        echo "name='unit_owner'";
                    }
                    ?> id='txt-environment-unit_owner' required>
                        <option value=''>SELECT</option>
                        <?php foreach ($data['users'] as $key => $value): ?>
                            <option value="<?= $value['id'] ?>" <?= $value['id'] == $environment['unit_owner'] ? "selected='selected'" : NULL ?>><?= $value['names'] ?></option>
                        <?php endforeach; ?>

                    </select>

                </div>
            </div>



        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            <button class='btn btn-primary waves-effect waves-light'><i class='fa fa-save'></i> Save </button>

        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<?= form_close(); ?>
<script>
    CKEDITOR.replace('txt-environment-description');
</script>

