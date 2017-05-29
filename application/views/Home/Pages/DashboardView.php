<?php
if (!am_user_type(array(1, 5, 6, 2, 8, 9))) {
    restricted_view();
    return false;
}
?>
<div class="container-fluid">
    <!-- Start right Content here -->
    <?php //   print_pre($data); die();?>

    <div class="content-page">

        <?php
        $incidents = count($data['incidents']);
        $comp_req = 0;

        foreach ($data['repository'] as $key => $value) {
            $comp_req += count($value['compliance_requirements']);
        }

        $risks = count($data['risk']);
        $overdue_ob = count($data['overdue_ob']);
        $all_high_risks = count($data['all_high_net_risk']);
        $incidentsWithTotalLoss = count($data['IncidentsWithTotalLoss']);

//        $dataArray = array(
//            array("label1", 30, "#ff0000"),
//            array("label2", 10, "#0000ff"),
//            array("label3", 60, "#00ff00"),
//        );
//        echo pie_chart_cs("chsrt", $dataArray);
        //print_pre($data['environment']['unit_owner']);
        ?>


        <div class="card">
            <div class="card-block m-b-0">
                <div class="btn-group pull-right">
                    <button data-target="#incident_details" class="toggle-block btn btn-secondary btn-sm btn-small"><i class="icon icon-arrow-down"></i> More</button>
                    <button data-target="#incident_details" class="toggle-block btn btn-secondary btn-sm btn-small hidden"><i class="icon icon-arrow-up"></i> Less</button>
                    <?php if (am_user_type(array(1, 9)) or $data['environment']['unit_owner']['id'] == $me['user']['id']): ?>
                        <a href="<?= base_url("index.php/Home/unitForm/{$data['environment']['id']}"); ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm btn-small"><i class="icon icon-pencil"></i> Edit</a>
                    <?php endif; ?>
                    <?php if (am_user_type(array(1, 9)) and count($data['repository']) == 0 and count($data['environment']['sub_units']) == 0): ?>
                        <a href="<?= base_url("index.php/Home/unitDelete/{$data['environment']['id']}"); ?>"  <?= MODAL_LINK ?> class="btn btn-secondary btn-sm btn-small"><i class="icon icon-trash"></i> Delete</a>
                    <?php endif; ?>
                </div>
                <h3 class="card-title m-b-0 p-b-0"><?= $data['environment']['name'] ?></h3>
                <p class="m-t-0 p-t-0">
                    <small>
                        <?php
                        $tree = array_reverse($data['tree']);
                        foreach ($tree as $key => $value) :
                            $link = base_url("index.php/Home/dashboard/{$value['id']}");
                            if ($key == (count($tree) - 1)) {
                                echo "<span title='{$value['environment_level']['name']}'>{$value['environment_level']['initials']}: {$value['name']} </span> ";
                            } else {
                                echo "<a href=\"{$link}\" title='{$value['environment_level']['name']}'><span >{$value['environment_level']['initials']}</span> : {$value['name']}</a> ";
                            }
                            if (count($data['tree']) > ($key + 1)) {
                                echo "<i class=\"icon icon-arrow-right\"></i>";
                            }
                            ?>
                        <?php endforeach; ?>
                    </small>
                </p>
                </p>
            </div>
            <hr class="row m-0 p-0">
            <div class="card-block m-t-0 hidden" id="incident_details">

                <?php $date = str_replace("*", "", str_replace("*0", "", strftime(" %b *%d %Y", strtotime($data['environment']['created'])))); ?>
                <div class="row">
                    <div class="col-sm-3">
                        <table class="table table-sm table-small " id="datatable-buttons">
                            <tbody>

                                <tr> <th style="width: 140px;">Name</th> <td> <?= $data['environment']['name'] ?></td> </tr>
                                <tr> <th>Created </th> <td> <i class="icon icon-calender"></i>  <?= $date ?> </td> </tr>
                                <tr> <th>Unit Owner</th> <td> <i class="icon icon-user"></i> <a href="<?= base_url("index.php/Home/user/{$data['environment']['unit_owner']['id'] }") ?>"> <?= $data['environment']['unit_owner']['names'] ?></a> </td> </tr>
                                <tr> <th>Risks</th> <td> <i class="icon icon-flash2"></i>  <span class="label label-rounded label-warning"><?= ($risks) ?></span> </td> </tr>
                                <tr> <th>Compliances</th> <td> <i class="icon icon-target"></i>   <span class="label label-rounded label-info"><?= ($comp_req) ?></span>   </td> </tr>
                                <tr> <th>Incidents</th> <td>  <i class="icon icon-energy"></i>  <span class="label label-rounded label-danger"><?= ($incidents) ?></span>   </td> </tr>

                            </tbody>
                        </table>


                    </div>
                    <div class="col-sm-9">
                        <h5 class="text-muted">Description </h5>
                        <hr class="m-0 p-0 m-b-10"/>
                        <?= nl2br($data['environment']['description']) ?>
                    </div>

                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('.toggle-block').click(function () {
                    $($(this).data('target')).toggleClass('hidden');
                    $('.toggle-block').toggleClass('hidden');
                })
            })
        </script>
        <div class="content">
            <div class="row"> 
                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card-box tilebox-one">
                        <span class="icon-flash2 pull-right text-muted"></span>
                        <h6 class="text-muted text-uppercase m-b-20">RISKS</h6>
                        <h2 class="m-b-20" data-plugin="counterup"><?= count(objectToArray(json_decode($data['environment']['risks']))) ?></h2>
<!--                        <span class="label label-default"><?= $all_high_risks ?> </span> <span class="text-muted"> High net risk</span>-->
                    </div>
                </div>

                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card-box tilebox-one">
                        <i class="icon-target pull-xs-right text-muted"></i>
                        <h6 class="text-muted text-uppercase m-b-20">Obligations</h6>
                        <h2 class="m-b-20"><span data-plugin="counterup"><?= count(objectToArray(json_decode($data['environment']['obligations']))) ?></span></h2>
<!--                        <span class="label label-warning"> <?= $overdue_ob ?> </span> <span class="text-muted"> Overdue Obligations</span>-->
                    </div>
                </div>

                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card-box tilebox-one">
                        <i class="icon-energy pull-xs-right text-muted"></i>
                        <h6 class="text-muted text-uppercase m-b-20">Incidents</h6>
                        <h2 class="m-b-20"><span data-plugin="counterup"><?= count(objectToArray(json_decode($data['environment']['incidents']))) ?></span></h2>
<!--                        <span class="label label-danger"> <?= $incidentsWithTotalLoss ?> </span> <span class="text-muted"> Led to actual losses</span>-->
                    </div>
                </div>

                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card-box tilebox-one">
                        <i class="icon-check pull-xs-right text-muted"></i>
                        <h6 class="text-muted text-uppercase m-b-20">Audits</h6>
                        <h2 class="m-b-20" data-plugin="counterup"><?= count($data['Audit'])?></h2>
<!--                        <span class="label label-default"> 0% </span> <span class="text-muted"> Audit Issues</span>
>-->
                    </div>
                </div>
            </div>
        </div><!--row1-->

        <div class="row">
            <!--Functional Units-->
            <div class="col-md-3">
                <?php if (isset($data['environment']['unit_owner']) and is_array($data['environment']['unit_owner']) and isset($data['environment']['unit_owner']['names']) and $data['environment']['unit_owner']['names']): ?>
                    <div class="card-box widget-user">
                        <?php if ($data['environment']['environment_level']['id'] == 1): ?>
                            <h5 class=""> Corporate Admin</h5>
                        <?php else : ?>
                            <h5 class=""> Unit Owner</h5>
                        <?php endif; ?>
                        <div>
                            <img src="<?php
                            if ($data['environment']['unit_owner']['profile_pic']) {
                                echo img_src($data['environment']['unit_owner']['profile_pic'], 60, 60);
                            } else {
                                echo img_src("user.jpg", 60, 60);
                            }
                            ?>" class="img-responsive img-circle" alt="user">
                            <div class="wid-u-info">
                                <h5 class="m-t-20 m-b-5"> <?= $data['environment']['unit_owner']['names'] ?></h5>
                                <p class="text-muted m-b-0 font-13"><?= $data['environment']['unit_owner']['username'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="card-box widget-user">
                        <h4>No Owner Selected</h4>
                    </div>
                <?php endif; ?>
                <?php
                if ($data['next_level']):
                    $link_add = base_url("index.php/Home/unitForm/0/{$data['environment']['id']}");
                    ?>
                    <div class="card">
                        <div class="card-block ">
                            <?php if (am_user_type(array(1, 9))): ?>
                                <a href="<?= $link_add; ?>" <?= MODAL_LINK ?> 
                                   class="btn btn-sm pull-right  btn-success btn-rounded waves-effect waves-light"><i class="icon icon-plus"></i> New</a>
                               <?php endif; ?>
                            <h4 class="card-title"><?= $data['next_level']['name'] ?>s</h4>
                            <div class=" ">
                                <table  class="table table-sm table-small  " >
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th class=" text-md-right text-muted"><i class="icon icon-user"></i> Unit Owner</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['environment']['sub_units'] as $key => $value): ?>
                                            <tr>
                                                <td><a class="link" href="<?= base_url("index.php/Home/dashboard/{$value['id']}") ?>"><?= $value['name'] ?></a></td>
                                                <td class="text-md-right "><small class="text-muted"><?= $value['unit_owner']['names'] ?></small></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php
                if ($data['environment']['environment_level']['id'] == 1):
                    $link_add = base_url("index.php/Home/projectForm/0");
                    ?>
                    <div class="card">
                        <div class="card-block">
                            <?php if (am_user_type(array(1, 9))): ?>
                                <a href="<?= $link_add; ?>" <?= MODAL_LINK ?> class="btn btn-sm pull-right  btn-success btn-rounded waves-effect waves-light"><i class="icon icon-plus"></i> New</a>
                            <?php endif; ?>
                            <h4 class="card-title">Projects</h4>
                            <div class="">
                                <table id="datatable-buttons" class="table table-sm table-small  ">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th class=" text-md-right text-muted"><i class="icon icon-user"></i> Project Owner</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['projects'] as $key => $value): ?>
                                            <tr>
                                                <td class=""><a class="link" href="<?= base_url("index.php/Home/dashboard/{$value['id']}") ?>"><?= $value['name'] ?></a></td>
                                                <td class="text-md-right "><small class="text-muted"><?= $value['owner']['names'] ?></small></td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                <?php endif; ?>
            </div>
            <!--Key Risk Area Tab-->

            <div class="col-md-9">
                <div class="card">
                    <div class="card-block">
                        <div class="btn-group pull-right">
                            <?php if (am_user_type(array(1, 5)) or $data['environment']['unit_owner']['id'] == $me['user']['id']): ?>
                                <a href="<?= base_url("index.php/Home/repositoryImport/{$data['environment']['id']}") ?>" <?= MODAL_LINK ?> 
                                   class="btn btn-sm pull-right  btn-secondary  waves-effect waves-light">
                                    <i class="ico icon-list"></i> Import
                                </a>
                            <?php endif; ?>
                            <?php if (am_user_type(array(1, 5)) or ( $data['environment']['unit_owner']['id'] == $me['user']['id'])) : ?>
                                <a href="#" data-toggle="dropdown" aria-expanded="false"
                                   class="btn btn-sm pull-right  btn-secondary  waves-effect waves-light">
                                    New Key Risk Area <i class="icon icon-arrow-down"></i> 
                                </a>
                                <div class="dropdown-menu">
                                    <?php
                                    $sources = $repository_sources;
                                    foreach ($sources as $key => $value):
                                        $link = base_url("index.php/Home/repositoryForm/0/$key/{$data['environment']['id']}")
                                        ?>
                                        <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= $link; ?>"><?= $value ?></a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <h4 class="card-title"> Source Repository</h4>


                        <table id="datatable" class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th style="width:40px"></th>
                                    <th>Name</th>
                                    <th class="text-center">Approval Status</th>
                                    <th>Type</th>
                                    <th class="text-center">Risks</th>
                                    <th class="text-center">Compliance</th>
                                    <th style="width:120px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 0;
                                foreach ($data['repository'] as $key => $value):
                                    $count++;
                                    $approved_label = ($value['approved'] == "approved") ? "success" : (($value['approved'] == "pending") ? "warning" : "danger");
                                    $edit_link = base_url("index.php/Home/repositoryForm/{$value['id']}");
                                    $delete_link = base_url("index.php/Home/repositoryDelete/{$value['id']}");
                                    $preview_link = base_url("index.php/Home/repositoryPreview/{$value['id']}");
                                    ?>
                                    <tr id="repository-<?= $value['id'] ?>">
                                        <td><?= $count ?></td>
                                        <td><a href="<?= $preview_link ?>" <?= MODAL_LINK ?>><?= $value['name'] ?></a></td>
                                        <td class="text-center">
                                            <span class="label label-pill label-<?= $approved_label ?>">
                                                <?= ucwords($value['approved']) ?>
                                            </span></td>
                                        <td><?= ucwords(str_replace("_", " ", $value['source'])) ?></td>
                                        <td class="text-center">
                                            <span class="label label-pill label-rounded label-<?= count($value['risks']) == 0 ? "default" : "danger" ?>">
                                                <?= count($value['risks']) ?>
                                            </span></td>
                                        <td class="text-center">
                                            <span class="label label-pill label-rounded label-<?= count($value['compliance_requirements']) == 0 ? "default" : "primary" ?>">
                                                <?= count($value['compliance_requirements']) ?>
                                            </span></td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <?php
                                                if (am_user_type(array(1, 5)) or
                                                        $data['environment']['unit_owner']['id'] == $me['user']['id']):
                                                    ?>

                                                    <?php if (count($value['risks']) == 0 and count($value['compliance_requirements']) == 0): ?>
                                                        <a class="btn btn-secondary btn-sm" <?= MODAL_LINK ?> href="<?= $delete_link ?>"><?php
                                                            echo '<i class="icon icon-close"></i> Remove';
                                                            ?>
                                                        </a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!--row2-->
        </div><!--content-->
    </div><!--content page-->
</div>
<!-- ============================================================== -->

<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').DataTable({
            ColumnDefs: [
                {'Sortable': false, 'orderable': false, 'Targets': [-1]}
            ]
        });

        //Buttons examples
        var table = $('#datatable-buttons').DataTable({
            lengthChange: false,
            // buttons: ['excel', 'pdf', 'colvis'],
            ColumnDefs: [
                {'Sortable': false, 'orderable': false, 'Targets': [-1]}
            ]
        });
        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });

</script>