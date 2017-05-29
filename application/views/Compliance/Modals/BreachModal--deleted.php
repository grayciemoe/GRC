<?php
$create = $data['create'];
$compliance_requirement = $data['compliance_req'];
//print_pre($data);
//die();
?>
<link href="<?= base_url("assets/plugins/jquery.filer/css/jquery.filer.css") ?>" rel="stylesheet" />
<link href="<?= base_url("assets/css/style.css") ?>" rel="stylesheet" type="text/css" />
<?= form_open_multipart("", array('id' => '', 'class' => '')) ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title text-center" id="myModalLabel"><?= $compliance_requirement['type'] == "Statutory Returns" ? "Breach" : "Late Review "; ?></h4>
        </div>


        <div class="modal-body">
           
            <div class="form-group">
                <label for="ref_code">Ref Code</label>
                <input class="form-control" type="text" value="<?= $create ['ref_code'] ?>" id="ref_code" name="ref_code" disabled />
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <!--<input class="form-control" type="text" value="<?= $create ['title'] ?>" id="title" name="title" disabled/>-->
                <textarea class="form-control" rows="2" id="breachTitle" disabled><?= $create ['title'] ?></textarea>
            </div>
            <div class="form-group">
                <label>Penalty</label>
                <input type="number" value="0.00" class="form-control" />
            </div>
            <div class="form-group">
                <label class="form-control-label" for="status">Status</label>
                <select class="form-control" disabled>
                    <option value="<?= $create ['status'] ?>"><?= $create ['status'] ?></option>
                </select>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control wysiwyg" rows="3" id="breachDescription"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script src="<?= base_url("assets/plugins/jquery.filer/js/jquery.filer.min.js") ?>"></script>
<script type="text/javascript">
    $('#obComply-attachments').filer({
        limit: 4,
        maxSize: 3,
        extensions: ['pdf', 'doc', 'xlsx', 'docx'],
        changeInput: true,
        showThumbs: true,
        addMore: true
    });
</script>

<?= form_close(); ?>