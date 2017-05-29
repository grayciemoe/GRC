<?php 
if (!am_user_type(array(1, 9, 6, 5)) ) {
    restricted_view();
    return false;
}
?><?php
$$data['repository']['source'] = $data['repository'][$data['repository']['source']]
?><div class='container-fluid'>
    <div class='card card-block'>
        <div class='card-title'>
            <h4> Corporate Policy </h4>
        </div>
        <div class='card-text'>
            

            <?php if ($data['repository']['approved'] == "pending" and am_user_type(array(1, 5))): ?>
                <div class="alert alert-warning alert-dismissible fade in text-center" role="alert">
                    <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Do you want to approve this <strong><?= ucwords(str_replace("_", " ", $data['repository']['source'])) ?></strong>
                    <br>
                    <a href="<?= base_url("index.php/Home/repositoryApprove/{$data['repository']['id']}"); ?>" <?= MODAL_LINK ?> class="btn btn-danger btn-small btn-sm ">Approve </a>
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
                            <td> approved </td>
                            <td> <span class="label label-pill label-rounded label-<?= $data['repository']['approved'] ? "success" : "danger" ?>"><?= $data['repository']['approved'] ? "Approved" : "Pending" ?></span> </td>
                        </tr>

                    </table>
                </div>
                <div class="col-sm-7">
                    <?= $corporate_policy['description']?>
                </div>
            </div>

        </div>
    </div>
</div>
