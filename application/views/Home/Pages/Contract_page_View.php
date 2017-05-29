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
            <h4>Contract </h4>
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
                <div class="col-sm-5"><table class="table table-sm table-small">
                        <tbody>
                            <tr>
                                <td style="width: 200px;"> name </td>
                                <td> <?= $contract['name'] ?> </td>
                            </tr>
                            <tr>
                                <td> effective date </td>
                                <td> <?= $contract['effective_date'] ?> </td>
                            </tr>
                            <tr>
                                <td> expiry date </td>
                                <td> <?= $contract['expiry_date'] ?> </td>
                            </tr>
                            <tr>
                                <td> link </td>                        <td> <?= $contract['link'] ?> </td>

                            </tr>
                            <tr>
                                <td> type </td>
                                <td> <?= $contract['type'] ?> </td>
                            </tr>
                            <tr>
                                <td> contract owner </td>
                                <td> <?= $contract['contract_owner'] ?> </td>
                            </tr>
                            <tr>
                                <td> signed by </td>
                                <td> <?= $contract['signed_by'] ?> </td>
                            </tr>
                            <tr>
                                <td> status </td>
                                <td> <?= $contract['status'] ?> </td>
                            </tr>
                        </tbody>
                    </table></div>
                <div class="col-sm-7"><?= $contract['description'] ?></div>
            </div>

        </div>
    </div>
</div>
