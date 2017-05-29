<?php
$$data['repository']['source'] = $data['repository'][$data['repository']['source']]
?><div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'>Contract </h4>
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
                <div class="col-sm-5"><table class="table table-sm table-small">
                        <tbody>
                            <tr>
                                <td style="width: 200px;"> Name </td>
                                <td> <?= $contract['name'] ?> </td>
                            </tr>
                            <tr>
                                <td> Effective Date </td>
                                <td> <?= $contract['effective_date'] ?> </td>
                            </tr>
                            <tr>
                                <td> Expiry Date </td>
                                <td> <?= $contract['expiry_date'] ?> </td>
                            </tr>
                            <tr>
                                <td> Link </td>                        
                                <td> <?= $contract['link'] ?> </td>

                            </tr>
                            <tr>
                                <td> Type </td>
                                <td> <?= $contract['type'] ?> </td>
                            </tr>
                            <tr>
                                <td> Contract Owner </td>
                                <td> <?= $contract['contract_owner']['names'] ?> </td>
                            </tr>
                            <tr>
                                <td> Signed by </td>
                                <td> <?= $contract['signed_by']['names'] ?> </td>
                            </tr>
                            <tr>
                                <td> Status </td>
                                <td> <?= $contract['status'] ?> </td>
                            </tr>
                            <tr>
                                <td> Approval Status </td>
                                <td> <span class="label label-pill label-rounded label-<?= $data['repository']['approved'] == "approved" ? "success" : (($data['repository']['approved'] == "pending") ? "warning" : "danger") ?>"><?= ucwords($data['repository']['approved']) ?></span> </td>
                            </tr>
                        </tbody>
                    </table></div>
                <div class="col-sm-7"><?= $contract['description'] ?></div>
                <div class="col-sm-12"><?= show_documents("environment", "repository", $data['repository']['id'], TRUE); ?></div>

            </div>

        </div>
    </div>
</div>
