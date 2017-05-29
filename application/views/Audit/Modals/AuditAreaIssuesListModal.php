<?php //print_pre($data); exit;?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"><?= $data['auditarea']['title'] ?> </h4>
        </div>
        <div class="">
            <table class="modal-body table table-small table-sm table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Issue Title</th>
                        <th>Audit Name</th>
                        <th>Issue Rating</th>
                        <th>Issue Status</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($data['issues'] as $key => $value): ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><a href="<?= base_url("index.php/Audit/issue/{$value['id']}");?>"><?= ucwords($value['title']) ?></a></td>
                            <td><?= $value['audit']['audit_name'] ?></td>
                            <td><?= $value['issue_rating'] ?></td>
                            <td><?= $value['issue_status'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>



        </div>
    </div>
</div>

