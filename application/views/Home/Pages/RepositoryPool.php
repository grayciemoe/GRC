<?php
if (!am_user_type(array(1, 2, 8, 5, 6, 9))) {
    restricted_view();
    return false;
}
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-block">
            <div class="btn-group pull-right">

                <?php if (am_user_type(array(1, 5))): ?>
                    <a href="#" data-toggle="dropdown" aria-expanded="false"
                       class="btn btn-sm pull-right  btn-secondary  waves-effect waves-light">
                        New Key Risk Area <i class="icon icon-arrow-down"></i> 
                    </a>
                    <div class="dropdown-menu">
                        <?php
                        $sources = $repository_sources;
                        foreach ($sources as $key => $value):
                            $link = base_url("index.php/Home/repositoryForm/0/$key/0")
                            ?>
                            <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= $link; ?>"><?= $value ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <h4 class="card-title"> Source Repository Pool </h4>
        </div>
        <table id="datatable-buttons" class="table table-sm table-small  ">
            <thead>
                <tr>
                    <th style="width:40px"></th>
                    <th>Name</th>
                    <th>Type</th>
                    <th class="text-center">Status </th>
                    <th>Date Created</th>
                    <th class="text-center">Departments </th>
                    <th style="width:100px"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 0;
                foreach ($data['repository'] as $key => $value):
                    $count++;
                    $approved_label = ($value['approved'] == "approved") ? "success" : (($value['approved'] == "pending") ? "warning" : "danger");
                    $edit_link = base_url("index.php/Home/repositoryForm/{$value['id']}");
                    $delete_link = base_url("index.php/Home/repositoryDelete/{$value['id']}");
                    $preview_link = base_url("index.php/Home/repositoryPreview/{$value['id']}");
                    ?>
                    <tr id="repository-<?= $value['id'] ?>">
                        <td><?= $count ?></td>
                        <td><a href="<?= $preview_link ?>" <?= MODAL_LINK ?>><?= $value['name'] ?></a></td>
                        <td><?= ucwords(str_replace("_", " ", $value['source'])) ?></td>
                        <td>
                            <span class="label label-pill label-<?= $approved_label ?>">
                                <?= ucwords($value['approved']) ?>
                            </span></td>
                        <td><?= strftime("%b %d %Y", strtotime($value['created'])) ?></td>
                        <td class="text-center"><?= count($value['imported_to']) ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <?php if (am_user_type(array(1, 5))): ?>
                                    <a class="btn btn-secondary btn-sm" <?= MODAL_LINK ?> href="<?= $edit_link ?>"><i class="icon icon-pencil"></i> </a>
                                <?php endif; ?>
                                <?php if (am_user_type(array(1, 5))):
                                    
                                    
                                    
                                    ?>
                                    <a class="btn btn-secondary btn-sm" <?= MODAL_LINK ?> href="<?= $delete_link ?>">
                                        <?php
                                        if ($value['pool'] == 1) {
                                            echo '<i class="icon icon-trash"></i> Delete';
                                        } else {
                                            echo '<i class="icon icon-close"></i> Remove';
                                        }
                                        ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').DataTable();

        var table = $('#datatable-buttons').DataTable({
            lengthChange: false,
            ColumnDefs: [
                {'Sortable': false, 'orderable': false, 'Targets': [-1]}
            ]
        });
        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });

</script>


<!-- App js -->

