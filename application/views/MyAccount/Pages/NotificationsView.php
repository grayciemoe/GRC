<?php
$messages = $data['my_notifications'];
?><div class="container-fluid">
    <div class="card">
        <div class="row">
            <div class="col-lg-5 col-sm-6" style="border-right: 1px solid #eee;">

                <div class="card-block">

                    <table class=" table table-small table-sm table-condensed" id="datatable-buttons" >
                        <thead>
                            <tr>
                                <th></th>
                                <th>Subject</th>
                                <th class="text-right">Date</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($messages as $key => $value): ?>
                                <tr style="<?= $value['message_sent'] == 0 ? "background:#f9f9f9" : NULL ?>" >
                                    <td style="width:40px" class="text-muted"><i class="icon icon-envelope fa-2x" ></i></td>
                                    <td><a href="<?= base_url("index.php/Account/emailNotificationMessage/{$value['id']}") ?>" <?= AJAX_LINK ?> data-target="emailNotificationMessage">
                                            <?= $value['subject'] ?><br>
                                            <small class="text-muted"><?= $value['username'] ?></small></a></td>
                                    <td class="text-right"><small><?= strftime("%d-%Y<br> %H:%M%p", strtotime($value['timestamp'])) ?></small></td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-6 col-lg-7" id="emailNotificationMessage"> 
            </div>
        </div>
    </div>
</div>
<script>



    $(document).ready(function () {
        //alert("kinja");
        
        $('#datatable').DataTable();

        //Buttons examples
        var table = $('#datatable-buttons').DataTable({
            lengthChange: true,
            "scrollX": false,

        });

        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
        
        ajaxFileRequest_2("<?= base_url("index.php/Account/emailNotificationMessage/{$value['id']}") ?>", "emailNotificationMessage");

    });
</script>