<?php
if (!am_user_type(array(1, 9, 6, 5))) {
    restricted_view();
    return false;
}
?><div class="container-fluid">
    <?php
    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */
    $actions = $data["actions"];
    ?>
    <div class="card">
        <div class="card-block">
            <h5 class="card-title">Actions to be taken</h5>
            <br />
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Incident</th>
                        <th>Owner</th>
                        <th>Due Date</th>
                        <th>Completion Status</th>
                        <th style="width:80px">Edit/Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    //print_pre($actions);
                    foreach ($actions as $key => $value):
                        $edit_link = base_url("index.php/IncidentManagement/actionForm/{$value['id']}");
                        $delete_link = base_url("index.php/IncidentManagement/actionDelete/{$value['id']}");
                        //$date = NULL;
                        $date = strftime("%b %d %Y", strtotime($value['due_date']));
                        $timestamp = strtotime($value['due_date']);
                        //print_pre($value['incident']);
                        ?>
                        <tr>                               
                            <td> <a href="<?= base_url("index.php/IncidentManagement/previewAction/"); ?>" class="hidden" <?= MODAL_LINK ?>> <?= $value['title'] ?> </a> 
                                <?= $value['title'] ?> </td>
                            <td> <a href="<?= base_url("index.php/IncidentManagement/incidentPreview/{$value['incident']['id']}"); ?>" class="hidden" <?= MODAL_LINK ?>> <?= $value['incident']['title'] ?> </a> 
                                <?= $value['incident']['title'] ?> </td>
                            <td><a href="mailto:<?= $value['owner'] ?>"><?= $value['owner'] ?></a></td>
                            <td>
                                <span class="text-<?= ($timestamp < time() and ( $value['status'] != 'complete')) ? "danger" : "default" ?>">
                                    <?= $date ?>
                                </span>
                            </td>
                            <td>
                                <span class="label label-<?= $value['status'] == 'complete' ? "success" : "danger" ?>">
                                    <?= ucwords($value['status']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <?php if (am_user_type(array(1, 5)) or ( $value['incident']['responsible_manager'] == my_id())): ?>
                                        <a class="btn btn-secondary btn-sm"  <?= MODAL_LINK ?> href="<?= $edit_link ?>"><i class="icon icon-pencil"></i> </a>
                                    <?php endif; ?>
                                    <?php if (( am_user_type(array(1, 5)))): ?>
                                        <a class="btn btn-secondary btn-sm"  <?= MODAL_LINK ?> href="<?= $delete_link ?>"><i class="icon icon-trash"></i> </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').DataTable();

        //Buttons examples
        var table = $('#datatable-buttons').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'colvis'],
        });

        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });

</script>

<!-- App js -->
<script src="<?= base_url("assets/js/jquery.core.js") ?>"></script>
<script src="<?= base_url("assets/js/jquery.app.js") ?>"></script>
