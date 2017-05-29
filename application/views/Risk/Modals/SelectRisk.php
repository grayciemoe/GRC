<?php
$risks = $data['risks'];
// print_pre($risks);
// die();
 ?>
<?= form_open_multipart("Risk/saveSelectRisk") ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"> Select Risks</span></h4>
        </div>
        <div class="modal-body">
        <div class="checkbox checkbox-custom">
        	<?php
                                foreach ($risks as $key => $value):
                                    ?>
                                    <input <?= $value['id'] == $value['title'] ? "checked" : NULL ?> value="<?= $value['id'] ?>" type="checkbox">
                                    <label for="$value['title']">
                                                <?php echo $value['title']; ?>
                                            </label> <br />
                                <?php endforeach; ?>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            <a class="btn btn-danger waves-effect waves-light">Save</a>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>