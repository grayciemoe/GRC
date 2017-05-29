<?php
$$data['repository']['source'] = $data['repository'][$data['repository']['source']]
?><div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Corporate Policy </h4>
        </div>
        <div class='modal-body'>


            <?php if ($data['repository']['approved'] == 'pending' and am_user_type(array(1, 5))): ?>
                <div class="alert alert-warning alert-dismissible fade in text-center" role="alert">
                    <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Do you want to approve this <strong><?= ucwords(str_replace("_", " ", $data['repository']['source'])) ?></strong>
                    <br>
                    <a href="<?= base_url("index.php/Home/repositoryApprove/{$data['repository']['id']}/approved"); ?>" <?= MODAL_AJAX ?> class="btn btn-success btn-small btn-sm ">Yes </a>
                    <a href="<?= base_url("index.php/Home/repositoryApprove/{$data['repository']['id']}/rejected"); ?>" <?= MODAL_AJAX ?> class="btn btn-danger btn-small btn-sm ">No </a>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-sm-5"> <table class="table table-sm table-small ">
                        <tr>
                            <td> Type </td>
                            <td> <?= $corporate_policy['type'] ?> </td>
                        </tr>
                        <tr>
                            <td> Name </td>
                            <td> <?= $corporate_policy['name'] ?> </td>
                        </tr>
                        <tr>
                            <td> Approval Status </td>
                            <td> <span class="label label-pill label-rounded label-<?= $data['repository']['approved'] == "approved" ? "success" : (($data['repository']['approved'] == "pending") ? "warning" : "danger") ?>"><?= ucwords($data['repository']['approved']) ?></span> </td>
                        </tr>


                    </table>
                </div>
                <div class="col-sm-7">
                    <?= $corporate_policy['description'] ?>
                </div>
                <div class="col-sm-12"><?= show_documents("environment", "repository", $data['repository']['id'], TRUE); ?></div>

            </div>

        </div>
    </div>
</div>
