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
            <h4> Best Practice </h4>
        </div>
        <div class='card-text'>

            <?php if ($data['repository']['approved'] == "pending"  and am_user_type(array(1, 5))): ?>
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
                <div class="col-sm-5">
                    <table class="table table-small">
                        <tbody>
                            <tr>
                                <td> Name </td>
                                <td> <?= $best_practices['name'] ?> </td>
                            </tr>
                            <tr>
                                <td> Created </td>
                                <td> <?= strftime("%b %d %Y", strtotime($data['repository']['created'])); ?> </td>
                            </tr>
                            <tr>
                                <td> Approval </td>
                                <td> <span class="label label-pill label-rounded label-<?= $data['repository']['approved'] ? "success" : "danger" ?>"><?= $data['repository']['approved'] ? "Approved" : "Pending" ?></span> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-7">
                    <?= $best_practices['description'] ?> 
                </div>
                <div class="col-sm-12">
                    <?= show_documents("environment", "repository", $data['repository']['id']); ?>
                </div>

            </div>
        </div>
    </div>
</div>
