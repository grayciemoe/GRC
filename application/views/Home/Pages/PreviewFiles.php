<?php
if (!am_user_type(array(1, 9, 2, 8, 6, 5))) {
    restricted_view();
    return false;
}
?><div class="container-fluid">
<?php // print_pre($data['files']); exit;?>
    <div class="card-box ">

        <ul class="nav nav-tabs m-b-10" id="myTab" role="tablist">

            <?php foreach ($data['files'] as $label => $module_files): ?>
                <li class="nav-item">
                    <a class="nav-link <?= $label == 'all' ? "active" : NULL ?>" id="<?= $label ?>-tab" data-toggle="tab" href="#<?= $label ?>"
                       role="tab" aria-controls="<?= $label ?>" aria-expanded="true"><?= ucwords(str_replace("_", " ", $label)) ?></a>
                </li>
            <?php endforeach; ?>

        </ul>
        <div class="tab-content" id="myTabContent">
            <?php foreach ($data['files'] as $label => $module_files): ?>
                <div role="tabpanel" class="tab-pane fade in <?= $label == 'all' ? "active" : NULL ?>" id="<?= $label ?>"
                     aria-labelledby="<?= $label ?>-tab">
                    <table class="table table-striped table-condensed table-sm datatable " id="">
                        <thead>
                            <tr>
                                <th style="width:40px;">#</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Module</th>
                                <th>Size</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($module_files as $key => $value): ?>
                                <tr class="upload_<?= $value['id'] ?>">
                                    <td scope="row"> <?= $key + 1 ?></td>
                                    <td>
                                        <a class="" target="_blank"  href="<?= (getFileLink($value['filename'])) ?>"> <?= $value['title'] ?></a>
                                    </td>
                                    <td> <?= $value['filetype'] ?></td>
                                    <td> <?= ucwords(str_replace("_", " ", $value['module'])) ?></td>
                                    <td> <?= getFileSize($value['filename']) ?> </td>
                                    <td style="widtd:170px;">
                                        <div class="btn-group btn-group-sm pull-right">
                                            <a class="btn btn-dark-outline waves-effect waves-light" <?= MODAL_LINK ?> href="<?= (getFileLink($value['filename'])) ?>"><i class="icon ion-eye"></i></a>
                                            <a class="btn btn-success-outline waves-effect waves-light" download="<?= $value['title'] ?>"href="<?= (getFileLink($value['filename'])) ?>" ><i class="icon ion-android-download"></i></a>
                                            <a class="btn btn-warning-outline waves-effect waves-light" <?= MODAL_LINK ?> href="<?= base_url("index.php/Documents/editDocument/{$value['id']}") ?>"><i class="icon icon-pencil"></i></a>
                                            <a class="btn btn-danger-outline waves-effect waves-light" <?= MODAL_LINK ?> href="<?= base_url("index.php/Documents/deleteDocument/{$value['id']}") ?>"><i class="icon icon-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.datatable').DataTable();

        //Buttons examples
        var table = $('#datatable-buttons').DataTable({
            lengthChange: false,
            // buttons: ['excel', 'pdf', 'colvis'],
            ColumnDefs: [
                {'Sortable': false, 'orderable': false, 'Targets': [-1]}
            ]
        });


        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });

</script>
