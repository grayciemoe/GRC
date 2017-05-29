
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"><?= $data['compliance_requirement']['title'] ?> </h4>
        </div>
        <div class="">
            <table class="modal-body table table-small table-sm table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Authority</th>
                        <th>Frequency </th>
                        <th>Responsible Manager</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($data['obligations'] as $key => $value): ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><a href="<?= base_url("index.php/Compliance/obligation/{$value['id']}");?>"><?= $value['title'] ?></a></td>
                            <td><?= $value['authority']['title'] ?></td>
                            <td><?= ucwords($value['frequency']) ?></td>
                            <td><?= $value['responsible_manager_1']['names'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>



        </div>
    </div>
</div>

