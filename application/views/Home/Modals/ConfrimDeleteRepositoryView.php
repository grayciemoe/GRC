
<?php $delete_link = base_url("index.php/Home/repositoryDelete/{$data['repository']['id']}/true");
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">
                <?= ($data['repository']['pool'] == 0) ? "Delete" : "Remove"; ?>
                <span class="text-danger"><?= ucwords(str_replace("_", " ", $data['repository']['source'])) ?></span></h4>
        </div>
        <div class="modal-body">
            <?= ($data['repository']['pool'] == 0) ? "<p>Do you want to delete <strong>" . $data['repository']['name'] . "</strong></p>" : "<p>Do you want to remove <strong>" . $data['repository']['name'] . "</strong></p>"; ?>
        </div>
        <div class="modal-footer">
            <button type='button' class='btn btn-secondary waves-effect' id='close_modal' data-dismiss='modal'>No</button>
            <a href="<?= $delete_link ?>" onclick="repositoryDelete(this.href,<?= $data['repository']['id'] ?>); return false;" class="btn btn-danger waves-effect waves-light">Yes</a>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
    function repositoryDelete(url, id) {
        //alert(url);
        $("#uploan_modal").html("<div class='modal-dialog'><div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button><h4 class='modal-title ' id='myModalLabel'><div class='text-center'> Please wait <i class='fa fa-spin fa-spinner '></i></div> </h4></div><div class='modal-body'><div class=''> <br><br><br><br> </div></div></div></div>");

        $.post(url, {data: "data"}, function (response) {
            $("#repository-" + id).hide("fast");
            $("#repository-" + id).html("");
            $('#close_modal').click();
            $('.close').click();
            
            $("#system_alert_box").show("fast");
            $("#system_alert_box").html("<div><div style=\"padding:7px\">Source Repository Removed successfully</div></div>");
            setTimeout((function () {
                $("#system_alert_box").hide("fast");

            }), 5000);
        });

    }
</script>