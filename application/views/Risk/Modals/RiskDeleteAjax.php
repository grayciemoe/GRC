<?php $delete_link = base_url("index.php/Risk/riskDelete/{$data['risk']['id']}/true"); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"> Delete Risk </h4>
        </div>
        <div class="modal-body">
            <p>Do you want to delete <strong><?= $data['risk']['title'] ?></strong></p>
        </div>
        <div class="modal-footer">
            <button type="button" id="close_risk_delete" class="btn btn-secondary waves-effect" data-dismiss="modal">No</button>
            <a href="<?= $delete_link ?>" onclick="riskDeleteAjax(<?= $data['risk']['id'] ?>, this.href); return false" class="btn btn-danger waves-effect waves-light">Yes</a>
        </div>
    </div><!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<script>
    function riskDeleteAjax(var_id, url) {
        $('#risk-' + var_id).animate({opacity: 0.4}, "fast");
        $.post(url, {data: "data"}, function () {
            $('#close_risk_delete').click();
            $('#risk-' + var_id).hide("fast");
        })
    }

</script>