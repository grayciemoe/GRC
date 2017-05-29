<?php
$$data['repository']['source'] = $data['repository'][$data['repository']['source']]
?><div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Process</h4>
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
                <div class="col-sm-5">
                    <table class="table table-sm table-small">
                        <tbody>
                            <tr>
                                <td> Name </td>
                                <td> <?= $process['name'] ?> </td>
                            </tr>                
                            <tr>
                                <td> Description </td>
                                <td> <?= $process['description'] ?> </td>
                            </tr>                
                            <tr>
                                <td> Created </td>
                                <td> <?= $process['created'] ?> </td>
                            </tr>                
                            <tr>
                                <td> Link </td>
                                <td> <?= $process['link'] ?> </td>
                            </tr>                
                            <tr>
                                <td> Status </td>
                                <td> <?= $process['status'] ?> </td>
                            </tr>                
                            <tr>
                                <td> System Involved </td>
                                <td> <?= $process['system_involved'] ?> </td>
                            </tr>
                            <tr>
                                <td> Approval Status </td>
                                <td> <span class="label label-pill label-rounded label-<?= $data['repository']['approved'] == "approved" ? "success" : (($data['repository']['approved'] == "pending") ? "warning" : "danger") ?>"><?= ucwords($data['repository']['approved']) ?></span> </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="col-sm-7">
                    <?= $process['description'] ?> 
                </div>
                <div class="col-sm-12"><?= show_documents("environment", "repository", $data['repository']['id'], TRUE); ?></div>
            </div>
        </div>
    </div>
</div>
