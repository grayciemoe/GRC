<?php
if (am_user_type(array(1))) {
    $messages = $data['all_notifications'];
} else {
    $messages = $data['my_notifications'];
}
?><div class="container-fluid">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-block">
                    <h4>Notifications</h4>
                </div>
                <div class="" id="height_size" style="overflow-y: scroll;">
                    <table class="table table-small table-sm table-condensed">

                        <tbody>
                            <?php foreach ($messages as $key => $value): ?>
                                <tr style="<?= $value['message_sent'] == 0 ? "background:#f9f9f9" : NULL ?>">
                                    <td><i class="fa fa-2x fa-envelope-o"></i></td>
                                    <td><a href="<?= base_url("index.php/Home/emailNotificationMessage/{$value['id']}") ?>" <?= AJAX_LINK ?> data-target="emailNotificationMessage">
                                            <?= $value['subject'] ?><br>
                                            <small class="text-muted"><?= $value['username'] ?></small></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-8" id="emailNotificationMessage">
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#height_size").height($(window).innerHeight() - 300)
    })
</script>