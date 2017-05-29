
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Delete Comment</h4>
        </div>
        <div class="modal-body">
            <p>Are you sure</p>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">No</button>
            <a href="<?= base_url("index.php/Comments/delete/{$data['id']}/true") ?>" onclick="deleteComment(this.href, 'comments',<?= $data['id'] ?>); return false;" class="btn btn-danger waves-effect waves-light">Yes</a>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>


    function deleteComment(url, element_id, record_id) {
        var id_name = "#" + element_id + "_" + record_id;
        var class_name = "." + element_id + "_" + record_id;
        $.post(url, {data: "data"}, function () {
            $(id_name).hide('fast');
            $(class_name).hide('fast');
            $('.close').click();
        });
    }
</script>