<?php
$$data['repository']['source'] = $data['repository'][$data['repository']['source']]
?><div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Strategic Objective </h4>
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

                    <table class="table table-small table-sm">
                        <tr>
                            <td style="width: 200px;"> Name </td>
                            <td> <?= $strategic_objectives['name'] ?> </td>
                        </tr>
                        <tr>
                            <td> Year </td>
                            <td> <?= $strategic_objectives['year'] ?> </td>
                        </tr>
                        <tr>
                            <td> BSC Perspective </td>
                            <td> <?= $strategic_objectives['BSC_perspective'] ?> </td>
                        </tr>
                        <tr class="hidden">  
                            <td> Cascaded From </td>
                            <td> <?= $strategic_objectives['cascaded_from'] ?> </td>
                        </tr>
                        <tr>
                            <td> KPI Measure </td>
                            <td> <?= $strategic_objectives['KPI_measure'] ?> </td>
                        </tr>
                        <tr>
                            <td> KPI Measure Leading </td>
                            <td> <?= $strategic_objectives['KPI_measure_leading'] ?> </td>
                        </tr>
                        <tr>
                            <td> KPI Measure Lagging </td>
                            <td> <?= $strategic_objectives['KPI_measure_lagging'] ?> </td>
                        </tr>
                        <tr>
                            <td> KPI Target Leading </td>
                            <td> <?= $strategic_objectives['KPI_target_leading'] ?> </td>
                        </tr>
                        <tr>
                            <td> KPI Target Lagging </td>
                            <td> <?= $strategic_objectives['KPI_target_lagging'] ?> </td>
                        </tr>
                        <tr>
                            <td> Current KPI </td>
                            <td> <?= $strategic_objectives['current_KPI'] ?> </td>
                        </tr>
                        <tr>
                            <td> Current KPI date </td>
                            <td> <?= $strategic_objectives['current_KPI_date'] ?> </td>
                        </tr>
                        <tr>
                            <td> Approval Status </td>
                            <td> <span class="label label-pill label-rounded label-<?= $data['repository']['approved'] == "approved" ? "success" : (($data['repository']['approved'] == "pending") ? "warning" : "danger") ?>"><?= ucwords($data['repository']['approved']) ?></span> </td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-7">
                    <?= $strategic_objectives['description'] ?>
                </div>
                <div class="col-sm-12">    <?= show_documents("environment", "repository", $data['repository']['id'], TRUE); ?>
                </div>
            </div>
        </div>
    </div>
</div>
