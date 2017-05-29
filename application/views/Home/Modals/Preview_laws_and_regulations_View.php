<?php
$$data['repository']['source'] = $data['repository'][$data['repository']['source']]
?><div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Law & Regulations </h4>
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
                <div class="col-sm-12">
                    <table class="table table-sm table-sm ">
                        <tbody>               
                            <tr>
                                <td style="width: 200px;"> Name </td>
                                <td> <?= $laws_and_regulations['name'] ?> </td>
                            </tr>                
                            <tr>
                                <td> Type </td>
                                <td> <?= $laws_and_regulations['type'] ?> </td>
                            </tr>             
                            <tr>
                                <td> Legislative Authority </td>
                                <td> <?= $laws_and_regulations['legislative_authority'] ?> </td>
                            </tr>                
                            <tr>
                                <td> Enforcing Authority </td>
                                <td> <?= $laws_and_regulations['enforcing_authority'] ?> </td>
                            </tr>                
                            <tr>
                                <td> Last Revised Date </td>
                                <td> <?= $laws_and_regulations['last_revised_date'] ?> </td>
                            </tr>                
                            <tr>
                                <td> Type </td>
                                <td> <?= $laws_and_regulations['type_2'] ?> </td>
                            </tr> 
                            <tr>
                                <td> Approval Status </td>
                                <td> <span class="label label-pill label-rounded label-<?= $data['repository']['approved'] == "approved" ? "success" : (($data['repository']['approved'] == "pending") ? "warning" : "danger") ?>"><?= ucwords($data['repository']['approved']) ?></span> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-12"><?= show_documents("environment", "repository", $data['repository']['id'], TRUE); ?></div>

            </div>
        </div>

    </div>
</div>
