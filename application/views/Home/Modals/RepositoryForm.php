
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"> 
                <span class="text-info">
                    <?= $data['repository']['name'] ?>
                </span><br>
                <small class="font-11" style="font-size: 12px;"><?= ucwords(str_replace("_", " ", $data['repository']['source'])) ?></small>
            </h4>
        </div>
        <div class="modal-body">
            <?php print_pre($data)?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->