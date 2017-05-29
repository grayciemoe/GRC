
<div class="modal-dialog">
    <?= form_open_multipart("Documents/post") ?>
    <input type="hidden" class="form-control" value="<?= $data['file']['id'] ?>" id="" name="id" placeholder="">

    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"><?= $data['file']['title'] ?></h4>
        </div>
        <div class="modal-body">
            
            <fieldset class="form-group">
                <label for="exampleInputEmail1">File Title</label>
                <input type="text" required class="form-control" value="<?= $data['file']['title'] ?>" id="" name="title" placeholder="">

            </fieldset>
            <fieldset class="form-group">
                <label for="exampleTextarea">File Cation</label>
                <textarea name="caption" id="" class="form-control" ><?= $data['file']['caption'] ?></textarea>
            </fieldset>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
        </div>
    </div><!-- /.modal-content -->
    <?= form_close() ?>
</div><!-- /.modal-dialog -->
