<?php
if (!am_user_type(array(1, 6, 5, 9))) {
    restricted_view();
    return false;
}
?><?php
$$data['repository']['source'] = $data['repository'][$data['repository']['source']]
?><div class='container-fluid'>
    <div class='card card-block'>
        <div class='card-title'>
            <h4> Process</h4>
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
                <div class="col-sm-5">
                    <table class="table table-sm table-small">
                        <tbody>
                            <tr>
                                <td> name </td>
                                <td> <?= $process['name'] ?> </td>
                            </tr>                
                            <tr>
                                <td> description </td>
                                <td> <?= $process['description'] ?> </td>
                            </tr>                
                            <tr>
                                <td> created </td>
                                <td> <?= $process['created'] ?> </td>
                            </tr>                
                            <tr>
                                <td> link </td>
                                <td> <?= $process['link'] ?> </td>
                            </tr>                
                            <tr>
                                <td> status </td>
                                <td> <?= $process['status'] ?> </td>
                            </tr>                
                            <tr>
                                <td> system_involved </td>
                                <td> <?= $process['system_involved'] ?> </td>
                            </tr>                
                        </tbody>
                    </table>

                </div>
                <div class="col-sm-7">
                    <?= $process['description'] ?> 
                </div>
                <div class="col-sm-12">
                    <?= show_documents("environment", "repository", $process['id']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
