<?php
$risk = $data['risk'];

//print_pre($data['riskIssues']); exit;

$total = 0;
foreach ($risk['incidents'] as $key => $value) {

    if ($value['experience_type'] == 'Indirect Financial Loss') {
        if ($value['experience_type_level'] == 'Actual Loss') {
            $total += $value['total_cost'];
        } else {
            //  $potential += $value['maximum_potential_loss'];
            //  $expected += $value['expected_loss'];
        }
    } elseif ($value['experience_type'] == 'Direct Financial Loss') {
        if ($value['experience_type_level'] == 'Actual Loss') {
            $total += $value['total_cost'];
        } else {
            //  $potential += $value['maximum_potential_loss'];
            //  $expected += $value['expected_loss'];
        }
    }
}
if (!am_user_type(array(1, 5)) and ! in_array($me['user']['id'], $risk['can_see'])) {
    restricted_view();
    return false;
}
?>
<div class="container-fluid">
    <?php if ($risk['approved'] == 'Rejected' and am_user_type(array(1, 5))): ?>
        <?php if (allow_action("riskDelete", 'risk', $risk['id'])): ?>
            <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>This is a rejected, you can delete it.</h4> <br>
                <a href="<?= base_url("index.php/Risk/riskDelete/{$risk['id']}") ?>" <?= MODAL_LINK ?> class="btn btn-sm btn-small btn-danger-outline btn-rounded waves-effect waves-light">Delete Risk</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (($risk['approved'] == 'Pending' or $risk['approved'] == 'Proposed') and am_user_type(array(1, 5))): ?>
        <?php if (allow_action("riskApprove", 'risk', $risk['id'])): ?>
            <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>Approve risk</h4> <br>
                <a href="<?= base_url("index.php/Risk/riskApprove/{$risk['id']}/Approved") ?>" class="btn btn-sm btn-small btn-success-outline btn-rounded waves-effect waves-light">Approve</a>
                <a href="<?= base_url("index.php/Risk/riskApprove/{$risk['id']}/Rejected") ?>" class="btn btn-sm btn-small btn-danger-outline btn-rounded waves-effect waves-light">Reject</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($risk['approved'] == 'Approved' and $risk['status'] == "Open" and am_user_type(array(1, 5))): ?>
        <?php if (allow_action("riskActivate", 'risk', $risk['id'])): ?>
            <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>Activate / Deactivate risk</h4> <br>
                <a href="<?= base_url("index.php/Risk/riskActivate/{$risk['id']}/Active") ?>" class="btn btn-sm btn-small btn-success-outline btn-rounded waves-effect waves-light">Activate</a>
                <a href="<?= base_url("index.php/Risk/riskActivate/{$risk['id']}/Inactive") ?>" class="btn btn-sm btn-small btn-secondary-outline btn-rounded waves-effect waves-light">Deactivate</a>
            </div>
        <?php endif; ?>
    <?php endif; ?> 
    <?php if ($risk['approved'] == 'Approved' and $risk['status'] == "Inactive" and am_user_type(array(1, 5))): ?>
        <?php if (allow_action("riskActivate", 'risk', $risk['id'])): ?>
            <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>This risk is inactive, activate it.</h4> <br>
                <a href="<?= base_url("index.php/Risk/riskActivate/{$risk['id']}/Active") ?>" class="btn btn-sm btn-small btn-success-outline btn-rounded waves-effect waves-light">Activate</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($risk['evaluate'] == 'yes'): ?>
        <?php if (allow_action("evaluationForm", 'risk', $risk['id'])): ?>
            <div class="alert text-center alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>An incident related to this risk has been recored, kindly re-evaluate this risk </h4> <br>
                <a href="<?= base_url("index.php/Risk/evaluationForm/{$risk['id']}") ?>" <?= MODAL_LINK ?> class="btn btn-sm btn-small btn-danger-outline btn-rounded waves-effect waves-light">Re Evaluate Risk</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card-box tilebox-one">
                <i class="icon-check pull-xs-right text-muted"></i>
                <h6 class="text-muted text-uppercase m-b-20">Reviews</h6>
                <h2 class="m-b-20" ><span class="text-info" data-plugin="counterup"><?= count($risk['analysis']) + count($risk['evaluation']) ?></span><small> Reviews</small></h2>
<!--                <span class="label label-warning"> +11% </span> <span class="text-muted"> High net risk</span>-->
            </div>
        </div>

        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card-box tilebox-one">
                <i class="icon-wrench pull-xs-right text-muted"></i>
                <h6 class="text-muted text-uppercase m-b-20">Controls</h6>
                <h2 class="m-b-20"><span class="text-success" data-plugin="counterup"><?= count($risk['controls']) ?></span><small>  </small></h2>
<!--                <span class="label label-warning"> -29% </span> <span class="text-muted"> Not  acted upon </span>-->
            </div>
        </div>

        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card-box tilebox-one">
                <i class="icon-puzzle pull-xs-right text-muted"></i>
                <h6 class="text-muted text-uppercase m-b-20">Activities</h6>
                <h2 class="m-b-20" data-plugin="counterup"><?= count($risk['activities']) ?></h2>
<!--                <span class="label label-danger"> +5% </span> <span class="text-muted"> Control  activities</span>-->
            </div>
        </div>

        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card-box tilebox-one">
                <i class="icon-fire pull-xs-right text-muted"></i>
                <h6 class="text-muted text-uppercase m-b-20">Incidents</h6>
                <h2 class="m-b-20"><span class="text-danger">KES</span> <span data-plugin="counterup" class="text-danger"><?= number_format($total, 2) ?></span><small> Loss</small></h2>
<!--                <span class="label label-success"> 3% </span> <span class="text-muted"> Let to actual losses</span>-->
            </div>
        </div>


    </div>

    <div class="card">
        <div class="card-block">
            <div class="btn-group ">
                <h5 class="card-title"><?= $risk['title'] ?></h5>
            </div>
        </div>
    </div>
    <div class="row  risk-detail-page">
        <div class="col-md-3 risk-basic-detail">

            <?php if ($risk['approved'] == 'Approved' and $risk['status'] == "Active"): ?>
                <div class="card">
                    <div class="card-block">
                        <h6 class="card-title">Risk Review</h6>
                        <hr />
                        <div class="list-group">
                            <?php if (am_user_type(array(1, 5))): ?>
                                <a href="<?= base_url("index.php/Risk/analysisGross/{$risk['id']}") ?>" <?= MODAL_LINK ?> class="list-group-item"><i class="icon ion-qr-scanner"></i>&nbsp; Analyze Gross Risk</a>
                            <?php endif; ?>
                            <?php if (count($risk['controls']) > 0): ?>
                                <?php if (am_user_type(array(1, 5))): ?>
                                    <a href="<?= base_url("index.php/Risk/analysisControls/{$risk['id']}") ?>" <?= MODAL_LINK ?> class="list-group-item"><i class="icon icon-calculator"></i> &nbsp;Analyze Overall Controls</a>
                                    <?php
                                endif;

                            endif;
                            ?>
                            <?php if (am_user_type(array(1, 5))): ?>
                                <a href="<?= base_url("index.php/Risk/evaluationForm/{$risk['id']}") ?>" <?= MODAL_LINK ?> class="list-group-item"><i class="icon icon-equalizer"></i> &nbsp;Evaluate Risk</a>
                            <?php endif; ?>    
                            <?php
                            if (count($data['risk']['analysis']) > 0 and am_user_type(array(1, 5, 6))):
                                ?>
                                <?php if (allow_action("controlForm", 'control', 0) or $risk['risk_owner'] == $me['user']['id']): ?>
                                    <a href="<?= base_url("index.php/Risk/controlForm/0/{$risk['id']}") ?>" <?= MODAL_LINK ?> class="list-group-item"><i class="fa fa-stethoscope"></i>&nbsp; Treat Risk With Controls </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                </div><!--end of Risk Review-->
            <?php endif; ?>


            <div class="card">

                <div class="card-block">
                    <div class="btn-group pull-right">
                        <?php if (am_user_type(array(1, 5, 6)) or $risk['risk_owner'] == $me['user']['id']):
                            ?>
                            <a class="btn btn-sm btn-primary-outline " href="<?= base_url("index.php/Risk/riskForm/{$risk['id']}"); ?>" <?= MODAL_LINK ?> > <i class="icon icon-pencil"></i> Edit </a>
                        <?php endif; ?>
                        <?php if (am_user_type(array(1, 5))): ?>
                            <?php if (allow_action("riskDelete", 'risk', $risk['id'])): ?>
                                <a class="btn btn-sm btn-danger-outline " href="<?= base_url("index.php/Risk/riskDelete/{$risk['id']}"); ?>" <?= MODAL_LINK ?> > <i class="icon icon-trash"></i> Trash </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <h5 class="card-title">Risk Summary</h5>
                </div>
                <div class="card-block">
                    <table class="table table-condensed table-sm">
                        <tbody>
                            <tr>
                                <td style="width:120px;"><strong>Risk Title</strong></td>
                                <td><small><?= $risk['title'] ?></small></td>
                            </tr>
                            <tr>
                                <td><strong>Risk ID</strong></td>
                                <td><small><?= $risk['heat_map_ref'] ?></small></td>
                            </tr>
                            <tr>
                                <td><strong>Environment</strong></td>
                                <td><?= $risk['environment']['name'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Risk Owner</strong></td>
                                <td><?= $risk['risk_owner']['names'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Management Control Capability</strong></td>
                                <td><?= $risk['management_control'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>
                                    <?php if ($risk['approved'] == 'Approved' and $risk['status'] == 'Active'): ?>
                                        <?php if (allow_action("riskStatusEdit", 'risk', $risk['id'])): ?>
                                            <a href="<?= base_url("index.php/Risk/riskStatusEdit/{$risk['id']}") ?>" <?= MODAL_LINK ?> class="pull-right  text-danger"><i class="zmdi zmdi-pause-circle-outline"></i> Deactivate</a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <span class="label label-pill 
                                          label-<?=
                                          $risk['status'] == 'Open' ? "warning" :
                                                  ($risk['status'] == 'Active' ? "success" : "default")
                                          ?>"><?= $risk['status'] ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Approval </strong></td>
                                <td><span class="label label-pill label-<?= $risk['approved'] == 'Approved' ? "success" : ($risk['approved'] == 'pending' ? "warning" : "danger") ?>"><?= $risk['approved'] ?></span></td>

                            </tr>

                            <tr>
                                <td><strong>Frequency</strong></td>
                                <td><?= $risk['frequency'] ?></td>
                            </tr>

                            <tr>
                                <td><strong>Incident Capacity Limit</strong></td>
                                <td><?= $risk['incidents_capacity'] ?></td>
                            </tr>

                            <tr>
                                <td><strong>Risk Category</strong></td>
                                <td><?= ucwords(str_replace("_", " ", $risk['category']['title'])) ?></td>
                            </tr> 
                            <?php if (isset($risk['repository']['name'])): ?>
                                <tr>
                                    <td><strong>Risk Source</strong></td>
                                    <td><?= (count($risk['repository']) > 1) ? ucwords(str_replace("_", " ", $risk['repository']['source'])) : "Blank"; ?></td>
                                </tr> 
                            <?php endif; ?>
                            <?php if (isset($risk['repository']['name'])): ?>
                                <tr>
                                    <td><strong>Key Risk Area</strong></td>
                                    <td><?= (count($risk['repository']) > 1) ? ucwords(str_replace("_", " ", $risk['repository']['name'])) : "Blank"; ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td><strong>Insurable Status</strong></td>
                                <td><?= ucwords(strtolower($risk['insurable_status'])) ?></td>
                            </tr>
                            <?php if ($risk['insurable_status'] === 'YES'): ?>
                                <tr>
                                    <td><strong>Insurance Status</strong></td>
                                    <td><?= ucwords(strtolower($risk['insurance_status'])) ?></td>
                                </tr>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <!--end of Risk Summary-->

            <?= NULL // show_documents("risk", "risk", $risk['id'])          ?>

        </div><!--end of col-md 3-->


        <script>
            $(document).ready(function () {


            $('.analysis_trail').click(function () {
            $(".analysis_content").addClass('hidden');
            $(".analysis_trail").toggleClass('hidden');
            $($(this).data("target")).removeClass('hidden');
            });
            $('.evaluation_trail').click(function () {
            $(".evaluation_content").addClass('hidden');
            $(".evaluation_trail").toggleClass('hidden');
            $($(this).data("target")).removeClass('hidden');
            });
            });
        </script>
        <div class="col-md-9 ">
            <?php
            if (count($data['risk']['analysis']) > 0):
                $current = $data['risk']['analysis'][0];
                //print_pre($current);
                ?>
                <div class="card">
                    <div class="card-block">
                        <a href="javascript:void()" data-target="#analysis_data" class="analysis_trail btn btn-secondary btn-rounded pull-right"><i class="icon icon-list"></i> Data Table</a>
                        <a href="javascript:void()" data-target="#analysis_graph" class="analysis_trail hidden btn btn-secondary btn-rounded pull-right"><i class="icon icon-graph"></i> Graph</a>
                        <h4 class="card-title">Analysis Trend  </h4>
                    </div>
                    <hr class="m-0" />
                    <div class="card-block analysis_content " id="analysis_graph">
                        <table class="table table-condensed ">
                            <thead>
                                <tr>
                                    <th>Latest Analysis Ratings</th>
                                    <th class="text-center ">Probability</th>
                                    <th class="text-center">Impact</th>
                                    <th class="text-center">Gross Risk</th>
                                    <th class="text-center">Adequacy</th>
                                    <th class="text-center">Effectiveness</th>
                                    <th class="text-center">Control Ratings</th>
                                    <th class="text-center">Net Risk</th>
                                </tr>
                            </thead> 
                            <tbody>
                                <tr>
                                    <td><?= strftime("%b %d %Y", strtotime($current['timestamp'])) ?></td>
                                    <td class="text-center text-capitalize"> <?= (strtolower(heatmap_key("probability", $current['probability']))) ?> </td>
                                    <td class="text-center text-capitalize"> <?= (heatmap_key("impact", $current['impact'])) ?> </td>
                                    <td class="text-center text-capitalize gross_risk-<?= strtolower(heatmap_key("gross_risk", $current['gross_risk'])) ?>"> <?= ucwords(strtolower(heatmap_key("gross_risk", $current['gross_risk']))) ?> </td>
                                    <td class="text-center text-capitalize"> <?= heatmap_key("adequacy", $current['adequacy']) ?> </td>
                                    <td class="text-center text-capitalize"> <?= heatmap_key("effectiveness", $current['effectiveness']) ?> </td>
                                    <td class="text-center text-capitalize control_ratings-<?= strtolower(heatmap_key("control_ratings", $current['control_ratings'])) ?>"> <?= ucwords(strtolower(heatmap_key("control_ratings", $current['control_ratings']))) ?> </td>
                                    <td class="text-center text-capitalize net_risk-<?= strtolower(heatmap_key("net_risk", $current['net_risk'])) ?>"> <?= ucwords(strtolower(heatmap_key("net_risk", $current['net_risk']))) ?> </td>
                                </tr>  
                            </tbody>
                        </table>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="row m-t-10">
                                    <h4 class="text-center"> Risk Analysis Over Time</h4>
                                </div>
                                <?php
                                $analysis = $data['risk']['analysis'];
                                array_reverse($analysis);
                                $gross_risk = [];
                                $net_risk = [];
                                $control_ratings = [];
                                $index = 0;

                                foreach ($analysis as $key => $value) {
                                    $index = $value['timestamp']; //  strftime("%Y-%b",  strtotime($value['timestamp']));
                                    $gross_risk[$index] = $value['gross_risk'];
                                    $net_risk[$index] = $value['net_risk'];
                                    $control_ratings[$index] = $value['control_ratings'];
                                }
//print_pre($analysis);

                                $array = array(
                                    array("series_name" => "Gross Risk", "color" => "#ff0000", "data" => $gross_risk),
                                    array("series_name" => "Control Ratings", "color" => "#0000ff", "data" => $control_ratings,),
                                    array("series_name" => "Net Risk", "color" => "#00ff00", "data" => $net_risk),
                                );
                                ?>
                                <?= line_chart_c3("Gross-Risk-Trend-Analysis", $array); ?>
                            </div>

                        </div><!--end of risk analysis-->
                    </div>
                    <div class="card-block analysis_content hidden" id="analysis_data">

                        <table class="table table-condensed ">
                            <thead>
                                <tr>
                                    <th>Current Ratings</th>
                                    <th class="text-center ">Probability</th>
                                    <th class="text-center">Impact</th>
                                    <th class="text-center">Gross Risk</th>
                                    <th class="text-center">Adequacy</th>
                                    <th class="text-center">Effectiveness</th>
                                    <th class="text-center">Control Ratings</th>
                                    <th class="text-center">Net Risk</th>
                                </tr>
                            </thead> 
                            <tbody>
                                <?php foreach ($analysis as $key => $value): ?>
                                    <tr>
                                        <td><?= strftime("%b %d %Y", strtotime($value['timestamp'])) ?></td>
                                        <td class="text-center text-capitalize"> <?= heatmap_key("probability", $value['probability']) ?> </td>
                                        <td class="text-center text-capitalize"> <?= heatmap_key("impact", $value['impact']) ?> </td>
                                        <td class="text-center text-capitalize gross_risk-<?= strtolower(heatmap_key("gross_risk", $value['gross_risk'])) ?>"> <?= ucwords(strtolower(heatmap_key("gross_risk", $value['gross_risk']))) ?> </td>
                                        <td class="text-center text-capitalize"> <?= heatmap_key("adequacy", $value['adequacy']) ?> </td>
                                        <td class="text-center text-capitalize"> <?= heatmap_key("effectiveness", $value['effectiveness']) ?> </td>
                                        <td class="text-center text-capitalize control_ratings-<?= strtolower(heatmap_key("control_ratings", $value['control_ratings'])) ?>"> <?= ucwords(strtolower(heatmap_key("control_ratings", $value['control_ratings']))) ?> </td>
                                        <td class="text-center text-capitalize net_risk-<?= strtolower(heatmap_key("net_risk", $value['net_risk'])) ?>"> <?= ucwords(strtolower(heatmap_key("net_risk", $value['net_risk']))) ?> </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            <?php else : ?>
                <div class="card text-center">
                    <div class="card-block">
                        <h2 class="text-muted ">No Analysis </h2>
                    </div>
                </div>
            <?php endif; ?>
            <?php
            if (count($risk['evaluation']) > 0):
                $condition_1 = true; // 
                $con_1 = $risk['evaluation'][0]['tolerance_upper_limit'] == $risk['evaluation'][0]['tolerance_lower_limit'];
                $condition_2 = $risk['evaluation'][0]['tolerance_upper_limit'] >= $risk['evaluation'][0]['tolerance_lower_limit'];

                if ($condition_1 and $condition_2):
                    ?>



                    <div class="card">
                        <div class="card-block">
                            <a href="javascript:void()" id="cmd-evaluation-data" data-target="#evaluation_data" class="evaluation_trail btn btn-secondary btn-rounded pull-right"><i class="icon icon-list"></i> Data Table</a>
                            <a href="javascript:void()" id="cmd-evaluation-graph" data-target="#evaluation_graph"  class="evaluation_trail hidden btn btn-secondary btn-rounded pull-right"><i class="icon icon-graph"></i> Graph</a>

                            <h4 class="card-title">Risk Evaluation  </h4>
                        </div>
                        <hr class="m-0" />
                        <div class="card-block evaluation_content hidden" id="evaluation_data">
                            <table class="table table-sm table-small table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th class="text-center">Capacity</th>
                                        <th class="text-center">Appetite</th>
                                        <th class="text-center">Target</th>
                                        <th class="text-center">Upper Limit</th>
                                        <th class="text-center">Lower Limit</th>
                                        <th class="text-center">Current Level</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($risk['evaluation'] as $key => $value): ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td><?= strftime("%Y %b %d", strtotime($value['time'])) ?></td>
                                            <td class="text-center"><?= $value['capacity'] ?></td>
                                            <td class="text-center"><?= $value['appetite'] ?></td>
                                            <td class="text-center"><?= $value['target'] ?></td>
                                            <td class="text-center"><?= $value['tolerance_upper_limit'] ?></td>
                                            <td class="text-center"><?= $value['tolerance_lower_limit'] ?></td>
                                            <td class="text-center"><?= $value['current_level'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>


                            </table>
                        </div>
                        <div class="card-block evaluation_content " id="evaluation_graph">
                            <div class="row ">

                                <!--                           
                                                          
                            
                                <?php
                                //  echo "Alex";
                                $target = $evaluation[0]['target'];
                                $capacity = $evaluation[0]['capacity'];
                                $lower_limit = isset($evaluation[0]) ? $evaluation[0]['tolerance_lower_limit'] : 1;
                                $lower_limit_original = isset($evaluation[0]) ? $evaluation[0]['tolerance_lower_limit'] : 1;
                                $upper_limit_original = isset($evaluation[0]) ? $evaluation[0]['tolerance_upper_limit'] : 100;
                                $upper_limit = isset($evaluation[0]) ? $evaluation[0]['tolerance_upper_limit'] : 100;
                                $current_level = isset($evaluation[0]) ? $evaluation[0]['current_level'] : $lower_limit;
                                $measure_type = ($risk['evaluation_type'] == 'positive') ? 1 : 0;


                                $lower_limit = ($lower_limit < $current_level) ? $lower_limit : $current_level - 1;
                                $upper_limit = ($upper_limit > $current_level) ? $upper_limit : $current_level + 1;
                                if ($con_1) {
                                    $upper_limit += 10;
                                    $lower_limit -= 10;
                                }
                                $start_value = $lower_limit;
                                if (($upper_limit - $lower_limit) < 10) {
                                    $upper_limit += 10;
                                }
                                $si_units = $evaluation[0]['si_units'];

                                $diff = $upper_limit - $lower_limit;
                                $qs = $diff / 10;

                                $range = $upper_limit - $lower_limit;
                                if ($range > 0) {
                                    $range * -1;
                                }
                                $nearest_range = ($range);
                                ?> -->
                                <link href="<?= base_url("assets/plugins/gauge/css/export.css") ?>" rel="stylesheet" type="text/css" />


                                <!-- Export plugin includes and styles -->
                                <script src="<?= base_url("assets/plugins/gauge/js/amcharts.js") ?>"></script>
                                <script src="<?= base_url("assets/plugins/gauge/js/gauge.js") ?>"></script>
                                <script src="<?= base_url("assets/plugins/gauge/js/export.js") ?>"></script>


                                <style>
                                    #chartdiv {
                                        width: 400px;
                                        height: 400px;
                                    }
                                </style>

                                <script type="text/javascript">
                    var chart = AmCharts.makeChart("chartdiv", {
                    "type": "gauge",
                            "titles": [{
                            "text": "Risk Evaluation",
                                    "size": 15
                            }],
                            "axes": [{
                            "startValue":0,
                                    "axisThickness": 1,
                                    "endValue": 100,
                                    "valueInterval": 10,
                                    "bottomTextYOffset": - 40,
                                    "bottomText":
        <?php
        $eva_1 = $risk['evaluation'][0];
        $pec = ($eva_1['tolerance_upper_limit'] != 0) ? round((($eva_1['current_level'] / $eva_1['tolerance_upper_limit']) * 100), 2) ." % ": "N/A";
        ?>
                            "  <?php echo "Current Level: {$eva_1['current_level']} " . ucwords($si_units) . " " ?>\n \n  <?php echo "Capacity : {$eva_1['capacity']}" ?>\n <?php echo "Tolerance Upper : {$eva_1['tolerance_upper_limit']}" ?>\n <?php echo "Tolerance Lower : {$eva_1['tolerance_lower_limit']}" ?>\n <?php echo "Appetite : {$eva_1['appetite']}" ?>\n <?php echo "Target : {$eva_1['target']}" ?>\n ",
        <?php if ($risk['evaluation_type'] == 'positive'): ?>
                                "bands": [{
                                "startValue": 0,
                                        "endValue": 33.33,
                                        "color": "#00CC00",
                                        "innerRadius": "90%"
                                }, {
                                "startValue": 33.33,
                                        "endValue": 66.66,
                                        "color": "#ffac29",
                                        "innerRadius": "90%"
                                }, {
                                "startValue": 66.66,
                                        "endValue": 100,
                                        "color": "#ea3838",
                                        "innerRadius": "90%"
                                }]
        <?php else : ?>

                                "bands": [{
                                "startValue": 0,
                                        "endValue": 33.33,
                                        "color": "#ea3838",
                                        "innerRadius": "90%"
                                }, {
                                "startValue": 33.33,
                                        "endValue": 66.66,
                                        "color": "#ffac29",
                                        "innerRadius": "90%"
                                }, {
                                "startValue": 66.66,
                                        "endValue": 100,
                                        "color": "#00CC00",
                                        "innerRadius": "90%"
                                }]
        <?php endif; ?>

                            }],
                            "arrows": [{
                            "value": <?= ($current_level / $diff ) * 100 ?>
                            }],
                            "export": {
                            "enabled": false
                            }
                    });
                    //setInterval(randomValue, 2000);
                    // set random value
                    function randomValue() {
                    var value = Math.round(Math.random() * 200);
                    chart.arrows[ 0 ].setValue(value);
                    chart.axes[ 0 ].setBottomText(value);
                    }
                                </script>
                                <div class="col-sm-5">
                                    <div id="chartdiv"></div>

                                </div>
                                <div class="col-sm-7">
                                    <?php $evaluation = count($risk['evaluation']) ? $risk['evaluation'][0] : NULL ?>

                                    <?php // print_pre($evaluation); ?>
                                    <table class="table table-sm table-small">
                                        <tbody>
                                            <tr>
                                                <th style="width:200px;">Units Of Measure</th>
                                                <td><?= $evaluation['si_units'] ?></td>
                                            </tr>

                                            <tr>
                                                <th>Capacity</th>
                                                <td><?= $evaluation['capacity'] ?></td>
                                            </tr>

                                            <tr>
                                                <th>Appetite</th>
                                                <td><?= $evaluation['appetite'] ?></td>
                                            </tr>

                                            <tr>
                                                <th>Target</th>
                                                <td><?= $evaluation['target'] ?></td>
                                            </tr>

                                            <tr>
                                                <th>Tolerance Upper Limit</th>
                                                <td><?= $evaluation['tolerance_upper_limit'] ?></td>
                                            </tr>

                                            <tr>
                                                <th>Tolerance Lower Limit</th>
                                                <td><?= $evaluation['tolerance_lower_limit'] ?></td>
                                            </tr>

                                            <tr>
                                                <th>Current Level</th>
                                                <td><?= $evaluation['current_level'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Appetite Measure</th>
                                                <td><?= $evaluation['appetite_measure'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Key Risk Indicator</th>
                                                <td><?= $evaluation['key_risk_indicator'] ?></td>
                                            </tr>

                                        </tbody>
                                    </table>

                                </div>

                                <div class="col-sm-12 ">
                                    <hr>
                                    <div class="row m-t-10">
                                        <h4 class="text-center"> Risk Evaluations Over Time</h4>
                                    </div>
                                    <?php
                                    $evaluation = $data['risk']['evaluation'];
                                    $capacity = [];
                                    $appetite = [];
                                    $target = [];
                                    $tolerance_upper_limit = [];
                                    $tolerance_lower_limit = [];
                                    $current_level = [];
                                    $index = NULL;
                                    foreach ($evaluation as $key => $value) {
                                        $index = $value['time'];
                                        $capacity[$index] = $value['capacity'];
                                        $appetite[$index] = $value['appetite'];
                                        $target[$index] = $value['target'];
                                        $tolerance_upper_limit[$index] = $value['tolerance_upper_limit'];
                                        $tolerance_lower_limit[$index] = $value['tolerance_lower_limit'];
                                        $current_level[$index] = $value['current_level'];
                                    }
                                    $array = array(
                                        array("series_name" => "Capacity", "color" => "#CC0000", "data" => array_reverse($capacity)),
                                        array("series_name" => "Appetite", "color" => "#800080", "data" => array_reverse($appetite)),
                                        array("series_name" => "Target", "color" => "#005500", "data" => array_reverse($target)),
                                        array("series_name" => "Tolerance_Upper_Limit", "color" => "#ff9900", "data" => array_reverse($tolerance_upper_limit)),
                                        array("series_name" => "Tolerance_Lower_Limit", "color" => "#00FF88", "data" => array_reverse($tolerance_lower_limit)),
                                        array("series_name" => "Current_Level", "color" => "#151B8D", "data" => array_reverse($current_level)),
                                            //array("series_name" => "Control_Ratings", "color" => "#0000ff", "data" => $control_ratings,),
                                            //array("series_name" => "Net_Risk", "color" => "#00ff00", "data" => $net_risk),
                                    );
                                    ?>
                                    <?= line_chart_c3("Trend-Evaluation", $array); ?>
                                </div>
                            </div><!--end of risk analysis-->
                        </div>

                    </div>


                    <?php
                else :
                    $skip = array("user", "risk", "ref_code", "si_units", "appetite_measure", "key_risk_indicator", "deviation", "review", "approved", "draft");
                    ?>
                    <div class="card text-center">
                        <table class="table table-sm table-small table-striped">
                            <thead>
                                <?php foreach ($data['risk']['evaluation'] as $key => $array):
                                    ?>
                                    <tr>
                                        <?php
                                        foreach ($array as $label => $value):
                                            if (in_array($label, $skip)) {
                                                continue;
                                            }
                                            ?>
                                            <td><?= $label ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <?php
                                    break;
                                endforeach;
                                ?>
                            </thead>

                            <tbody>
                                <?php foreach ($data['risk']['evaluation'] as $key => $array): ?>
                                    <tr>
                                        <?php
                                        foreach ($array as $label => $value):
                                            if (in_array($label, $skip)) {
                                                continue;
                                            }
                                            ?>
                                            <td><?= $value ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>


                        <div class="card-block">
                            <h2 class="text-muted ">Data Error </h2>
                            <p>Tolerance upper limit cannot be equal to Tolerance lower limit </p>
                        </div>
                    </div>

                <?php endif; ?>

            <?php else : ?>
                <div class="card text-center">
                    <div class="card-block">
                        <h2 class="text-muted ">No Evaluations </h2>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-block">
                    <ul class="nav nav-tabs m-b-10 specific-details-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="description-tab" data-toggle="tab" href="#risk_description"
                               role="tab" aria-controls="description" aria-expanded="true">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="event_of_risk-tab" data-toggle="tab" href="#event_of_risk"
                               role="tab" aria-controls="event_of_risk" aria-expanded="true">  Risk Event</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="effects_of_risk-tab" data-toggle="tab" href="#effects_of_risk"
                               role="tab" aria-controls="effects_of_risk">Effect Of Risk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="source_of_risk-tab" data-toggle="tab" href="#source_of_risk"
                               role="tab" aria-controls="source_of_risk">Source Of Risk</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="risk-tab">
                        <div role="tabpanel" class="tab-pane fade in active" id="risk_description" aria-labelledby="risk_description-tab">
                            <?= $risk['description'] ?>
                        </div>
                        <div role="tabpanel" class="tab-pane fade " id="event_of_risk" aria-labelledby="event_of_risk-tab">
                            <?= $risk['event_of_risk'] ?>
                        </div>
                        <div class="tab-pane fade" id="effects_of_risk" role="tabpanel" aria-labelledby="effects_of_risk-tab">
                            <?= $risk['effects_of_risk'] ?>
                        </div>
                        <div class="tab-pane fade" id="source_of_risk" role="tabpanel" aria-labelledby="source_of_risk-tab">
                            <?= $risk['source_of_risk'] ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (count($risk['controls']) > 0): ?>
                <div class="card">
                    <div class="card-block">

                        <?php if ($risk['approved'] == 'Approved' and $risk['status'] == "Active"): ?>
                            <?php if (allow_action("controlForm", 'control', 0)): ?>
                                <a href="<?= base_url("index.php/Risk/controlForm/0/{$risk['id']}") ?>" <?= MODAL_LINK ?> class="btn btn-primary-outline btn-rounded btn-sm waves-effect pull-right waves-light"><i class="fa fa-stethoscope"></i> Treat Risk with controls </a>
                            <?php endif; ?>
                        <?php endif; ?>
                        <h4 class="card-title">Risk Controls</h4>
                    </div>
                    <hr class="m-0">
                    <div class="card-block">

                        <table class="table table-striped table-control " id="datatable-buttons"  >
                            <thead>
                                <tr>
                                    <th style="width:40px">No</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Criticality</th>
                                    <th>Owner</th>
                                    <th>Type</th>
                                    <th>Approval Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 0;
                                foreach ($risk['controls'] as $key => $value):
                                    $count++;
                                    ?>
                                    <tr>
                                        <td><?= $count ?></td>
                                        <td><a href="<?= base_url("index.php/Risk/control/{$value['id']}") ?>"><?= $value['title'] ?></a></td>
                                        <td><span class="label label-pill label-<?=
                                            $value['status'] == 'incomplete' ? "default" :
                                                    "success"
                                            ?>" > 
                                                <?= $value['status'] ?> </span></td>

                                        <td><span class="label label-pill label-<?=
                                            $value['criticality'] == 'high' ? "danger" :
                                                    ($value['criticality'] == 'medium' ? "warning" : "primary")
                                            ?>">
                                                      <?= $value['criticality'] ?>
                                            </span>
                                        </td>
                                        <td><?= $value['owner']['names'] ?></td>
                                        <td><span class="label label-pill label-<?= $value['type'] == 'proposed' ? "default" : "success" ?>" >
                                                <?= $value['type'] ?> </span></td>     
                                        <td><span class="label label-pill label-<?= $value['approval_status'] == 'approved' ? "success" : "warning" ?>" >
                                                <?= $value['approval_status'] ?> </span></td>     

                                        <td>
                                            <?php if (am_user_type(array(1, 5))): ?>
                                                <a href="<?= base_url("index.php/Risk/controlDelete/{$value['id']}"); ?>" <?= MODAL_LINK ?> class="btn btn-sm btn-small pull-right btn-secondary waves-effect waves-light"><i class="icon icon-trash"></i></a>
                                            <?php endif; ?>
                                        </td>        

                                    </tr>


                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else : ?>
                <div class="card text-center">
                    <div class="card-block">
                        <h2 class="text-muted ">No Controls </h2>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (count($risk['incidents']) > 0): ?>
                <div class="card">
                    <div class="card-block">
                        <div class="card-title">
    <!--                            <a href="<?= base_url("index.php/Risk/controlForm/0/{$risk['id']}") ?>" <?= MODAL_LINK ?> class="btn btn-danger-outline btn-rounded btn-sm waves-effect pull-right waves-light"><i class="icon icon-fire"></i> Report Incident </a>-->
                            <h6>Incidents</h6></div>
                        <table class="table table-striped " >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Date Of Incident</th>
                                    <th>Experience Type</th>
                                    <th>Cost Involved (KES)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 0;
                                foreach ($risk['incidents'] as $key => $value):
                                    $count++;
                                    $index = array('Actual Loss' => 'total_cost', 'Potential Loss' => "maximum_potential_loss", 'Near Miss' => "expected_loss");
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $count ?></th>
                                        <td><a href="<?= base_url("index.php/IncidentManagement/incidentDetail/{$value['id']}"); ?>"><?= $value['title'] ?></a></td>
                                        <td><?= $value['status'] ?></td>
                                        <td><?= $value['date_of_incident'] ?></td>
                                        <td><?= $value['experience_type'] ?></td>
                                        <td><?= ($total) ? number_format($total, 2) : NULL; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>


                </div>
            <?php else : ?>
                <div class="card text-center">
                    <div class="card-block">
                        <h2 class="text-muted ">No Incidents </h2>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($risk['issue'])): ?>
                <div class="card">
                    <div class="card-block">
                        <div class="card-title">
                            <h6>Issues</h6></div>
                        <table class="table table-striped " >
                            <thead>
                    <tr>
                        <th>#</th>
                        <th>Issue Title</th>
                        <th>Issue Owner</th>
                        <th>Audit Area</th>
                        <th>Issue Rating</th>
                        <th>Issue Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 0;
                    foreach ($data['riskIssues'] as $key => $value): 
                        $count ++;?>
                        <tr>
                            <th scope="row"><?= $count ?></th>
                            <td><a href="<?= base_url("index.php/Audit/issue/".$value[0]['id']) ?>"><?= $value[0]['title'] ?></a></td>
                            <td><?= $value[0]['issue_owner']['names'] ?></td>
                            <td><?= $value[0]['audit_area']['title'] ?></td>
                            <td>
                                <?php
                                if ($value[0]['issue_rating'] == 'Low') {
                                    echo '<span class="label label-pill label-primary">';
                                } elseif ($value[0]['issue_rating'] == 'Moderate') {
                                    echo '<span class="label label-pill label-warning">';
                                } elseif ($value[0]['issue_rating'] == 'High') {
                                    echo '<span class="label label-pill label-danger">';
                                } else {
                                    echo '<span class="label label-pill label-danger">';
                                }
                                ?>
                                <?= $value[0]['issue_rating'] ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                if ($value[0]['issue_status'] == 'Open') {
                                    echo '<span class="label label-pill label-danger">';
                                } elseif ($value[0]['issue_status'] == 'Closed') {
                                    echo '<span class="label label-pill label-info">';
                                } else {
                                    
                                }
                                ?>
                                <?= $value[0]['issue_status'] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

                        </table>
                    </div>


                </div>
            <?php else : ?>
                <div class="card text-center">
                    <div class="card-block">
                        <h2 class="text-muted ">No Issues </h2>
                    </div>
                </div>
            <?php endif; ?>
            <?php
            $properties = documents_properties("Risk", "risk", $risk['id']);
            if ($properties['files'] > 0):
                ?>
                <div class="card">
                    <div class="card-block"><h3 class="card-title">Documents</h3>
                        <?= show_documents("Risk", "risk", $risk['id']); ?>
                    </div>
                </div>   
            <?php else : ?>
                <div class="card text-center">
                    <div class="card-block">
                        <h2 class="text-muted ">No Documents</h2>
                    </div>
                </div>
            <?php endif; ?>

            <?= show_comments("risk", "risk", $risk['id']); ?>


        </div><!--end colmun-->
    </div><!--end main row-->

</div><!--end container-->



<script type="text/javascript">
    $(document).ready(function () {
    $('#datatable').DataTable();
    //Buttons examples
    var table = $('#datatable-buttons').DataTable({
    // lengthChange: false,
    //  buttons: ['copy', 'excel', 'pdf', 'colvis'],
    });
    table.buttons().container()
            .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });

</script>
