<?php
if (!am_user_type(array(1, 9, 6, 5))) {
    restricted_view();
    return false;
}
?><div class="container-fluid">

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="row">
        <h3>&nbsp;Risk Details</h3>
        <hr />
    </div><!--end  row one-->

    <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card-box tilebox-one">
                <i class="icon-energy pull-xs-right text-muted"></i>
                <h6 class="text-muted text-uppercase m-b-20">Reviws</h6>
                <h2 class="m-b-20" data-plugin="counterup">14</h2>
                <span class="label label-warning"> +11% </span> <span class="text-muted"> High net risk</span>
            </div>
        </div>

        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card-box tilebox-one">
                <i class="icon-target pull-xs-right text-muted"></i>
                <h6 class="text-muted text-uppercase m-b-20">Controls</h6>
                <h2 class="m-b-20">$<span data-plugin="counterup">46</span></h2>
                <span class="label label-warning"> -29% </span> <span class="text-muted"> Not  acted upon </span>
            </div>
        </div>

        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card-box tilebox-one">
                <i class="icon-bubble pull-xs-right text-muted"></i>
                <h6 class="text-muted text-uppercase m-b-20">Incidents</h6>
                <h2 class="m-b-20">KES<span data-plugin="counterup">10000000</span></h2>
                <span class="label label-success"> 3% </span> <span class="text-muted"> Let to actual losses</span>
            </div>
        </div>

        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card-box tilebox-one">
                <i class="icon-rocket pull-xs-right text-muted"></i>
                <h6 class="text-muted text-uppercase m-b-20">Activities</h6>
                <h2 class="m-b-20" data-plugin="counterup">1,</h2>
                <span class="label label-danger"> +5% </span> <span class="text-muted"> Control  activities</span>
            </div>
        </div>
    </div>



    <div class="row  risk-detail-page">
        <div class="col-md-3   risk-basic-detail">
            <div class="card">
                <div class="card-block">
                    <h6 class="card-title">Risk Validation</h6>
                    <hr />

                    <div class="btn-group justified">
                        <a class="btn waves-effect waves-light btn-secondary btn-sm"> <i class="fa fa-plus">Open</i> </a>

                        <a class="btn waves-effect waves-light btn-danger btn-sm"> <i class="fa fa-plus">Active</i> </a>
                        <a class="btn waves-effect waves-light btn-primary btn-sm"> <i class="fa fa-plus">Inactive</i> </a>
                    </div>



                </div>
                <div class="card-block">
                </div>
            </div><!--end of Risk Validation-->


            <div class="card">
                <div class="card-block">
                    <h6 class="card-title">Risk Review</h6>
                    <hr />

                    <div class="list-group">

                        <a href="" <?= MODAL_LINK ?>  class="list-group-item">Analyze Risk</a>
                        <a href=""  <?= MODAL_LINK ?> class="list-group-item">Analyze Control</a>
                        <a href=""  <?= MODAL_LINK ?>  class="list-group-item">Evaluate Risk</a>

                    </div>
                </div>

            </div><!--end of Risk Review-->

            <div class="card">
                <div class="card-block">
                    <h5 class="card-title">Risk Summary</h5><a class=" .btn-primary-outline pull-right" href=""  > <i class="fa fa-edit"></i> </a>

                </div>

                <div class="card-block">
                    <table class="table table-condensed table-sm">
                        <tbody>
                            <tr>
                                <td class="text-right" style="width:120px;"><strong>Risk Name</strong></td>
                                <td><small>Very good system</small></td>
                            </tr>
                            <tr>
                                <td class="text-right"><strong>Risk ID</strong></td>
                                <td><small>EARe::R:2</small></td>
                            </tr>

                            <tr>
                                <td class="text-right"><strong>Environment</strong></td>
                                <td>Corporate</td>
                            </tr>
                            <tr>
                                <td class="text-right"><strong>Environment</strong></td>
                                <td>Corporate</td>
                            </tr>
                            <tr>
                                <td class="text-right"><strong>Environment</strong></td>
                                <td>Corporate</td>
                            </tr>
                            <tr>
                                <td class="text-right"><strong>Environment</strong></td>
                                <td>Corporate</td>
                            </tr>


                        </tbody>


                    </table>
                </div>
            </div><!--end of Risk Summary-->


        </div><!--end of col-md 3-->



        <div class="col-md-9 yellow">

            <div class="row">

                <div class="card">
                    <div class="card-block">
                        <h6 class="card-title"> Trend Analysis</h6>
                        <hr />

                        <canvas id="lineChart" height="300"></canvas>
                        <div class="row ">

                            <div class="col-sm-4"><canvas id="doughnut" height="260"></canvas></div>
                        </div><!--end of risk analysis-->
                    </div>
                </div>
            </div><!--end of row graph-->

            <div class="row  card">Spedometer</div>


            <div class="row  card">
                <div class="card-box">
                    <ul class="nav nav-tabs m-b-10" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="compliance-tab" data-toggle="tab" href="#compliance"
                               role="tab" aria-controls="compliance" aria-expanded="true">Compliance</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="breach-tab" data-toggle="tab" href="#breach"
                               role="tab" aria-controls="breach">Breach</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="compliance">
                        <div role="tabpanel" class="tab-pane fade in active" id="home"
                             aria-labelledby="compliance-tab">
                            <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt
                                tofu stumptown aliqua, retro synth master cleanse. Mustache cliche
                                tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro
                                keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry
                                richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan
                                aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
                        </div>
                        <div class="tab-pane fade" id="breach" role="tabpanel"
                             aria-labelledby="breach-tab">
                            <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla
                                single-origin coffee squid. Exercitation +1 labore velit, blog sartorial
                                PBR leggings next level wes anderson artisan four loko farm-to-table
                                craft beer twee. Qui photo booth letterpress, commodo enim craft beer
                                mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud
                                organic, assumenda labore aesthetic magna delectus mollit. Keytar
                                helvetica VHS salvia yr, vero magna velit sapiente labore stumptown.
                                Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts
                                beard ut DIY ethical culpa terry richardson biodiesel. Art party
                                scenester stumptown, tumblr butcher vero sint qui sapiente accusamus
                                tattooed echo park.</p>
                        </div>
                    </div>
                </div>

            </div><!--fghjkl;--->

            <div class="row">

                <div class="card">
                    <div class="card-block">

                        <table class="table table-striped ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th> Name</th>
                                    <th>Status</th>
                                    <th>Criticality</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                </div>

            </div><!--end rw-->



            <div class="row">

                <div class="card">
                    <div class="card-block">
                        <div class="card-title"><h6>Incidents</h6></div>
                        <table class="table table-striped ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th> Name</th>
                                    <th>Status</th>
                                    <th>Criticality</th>
                                    <th>Status</th>
                                    <th>Criticality</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>



        </div><!--end colmun-->
    </div><!--end main row-->

</div><!--end container-->
<!-- jQuery  -->
<script src="<?= base_url("assets/js/jquery.min.js") ?>"></script>
<script src="<?= base_url("assets/js/tether.min.js") ?>"></script><!-- Tether for Bootstrap -->
<script src="<?= base_url("assets/js/bootstrap.min.js") ?>"></script>
<script src="<?= base_url("assets/js/waves.js") ?>"></script>
<script src="<?= base_url("assets/js/jquery.nicescroll.js") ?>"></script>
<script src="<?= base_url("assets/plugins/switchery/switchery.min.js") ?>"></script>

<!-- controlled scripts -->
<?php
$UPLON_SCRIPTS = objectToArray(json_decode(UPLON_SCRIPTS));
foreach ($scripts as $key => $value) {
    if (array_key_exists($value, $UPLON_SCRIPTS)) {
        echo "<script src=\"" . base_url($UPLON_SCRIPTS[$value]) . "\"></script> \n";
    }
}
?>


<!-- App js -->
<script src="<?= base_url("assets/js/jquery.core.js") ?>"></script>
<script src="<?= base_url("assets/js/jquery.app.js") ?>"></script>
