<?php $delete_link = base_url("index.php/Risk/analysisDelete/{$data['analysis']['id']}/true"); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"> Delete Risk Analysis </h4>
        </div>
        <div class="modal-body">
            <p>Do you want to delete this analysis done on <strong><?= $data['analysis']['timestamp'] ?></strong></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">No</button>
            <a href="<?= $delete_link ?>" onclick="analysisDelete(this.href); return false;"  class="btn btn-danger waves-effect waves-light">Yes</a>
        </div>
    </div><!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

<script>
    function analysisDelete(url) {
        $.post(url, {data: "data"}, function () {
            $('.close').click();
            setTimeout((function (response) {
                $("#risk_analysis-<?= $data['analysis']['id'] ?>").hide();
            }), 1000)


        })

    }

</script>