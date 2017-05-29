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
            <h4> Strategic Objective </h4>
        </div>
        <div class='card-text'>
            
            <?php if ($data['repository']['approved'] == "pending" and am_user_type(array(5))): ?>
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
                            <td> KPI Measure Landing </td>
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
                    </table>
                </div>
                <div class="col-sm-7">
                    <?= $strategic_objectives['description'] ?>
                </div>

            </div>
        </div>
    </div>
</div>
