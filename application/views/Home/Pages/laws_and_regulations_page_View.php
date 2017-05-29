<?php 
if (!am_user_type(array(1, 6, 5)) ) {
    restricted_view();
    return false;
}
?><?php
$$data['repository']['source'] = $data['repository'][$data['repository']['source']]
?><div class='container-fluid'>
    <div class='card card-block'>
        <div class='card-title'>
            <h4> Law & Regulations </h4>
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
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>
