<?php
$recommendation = $data['recommendation'];
?>
<div class="container-fluid">
    <div class="row">

        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div class="card">
                <div class="card-block">
                    <div class="btn-group pull-right">

                        <a href="<?= base_url('index.php/audit/recommendationForm/' . $recommendation['id'].'/' .$recommendation['issue']) ?>" <?= MODAL_LINK ?>  class="btn btn-primary-outline btn-sm"><i  class="icon icon-pencil"></i> Edit </a>


                        <a href="<?= base_url('index.php/audit/deleteRecommendation/' . $recommendation['id'] . '') ?>" <?= MODAL_LINK ?>  class="btn btn-danger-outline btn-sm"><i  class="icon icon-trash"></i> Delete</a>

                    </div>
                    <h5 class="card-title">Details</h5>
                    <hr />
                    <table class="table table-small table-sm m-t-10">

                        <tr>
                            <th>Recommendation</th>
                            <td><?= $recommendation['recommendation'] ?></td>
                        </tr>
                        <tr>
                            <th>Respond by Date</th>
                            <td  class="<?= (strtotime($recommendation['respond_by_date']) < strtotime(date('Y-m-d')) && ((count_comments('Audit', 'recommendation', $recommendation['id']) == 0))) ? "text-danger" : "text-success"?>"><?= strftime("%b-%d-%Y", strtotime($recommendation['respond_by_date'])) ?></td>
                        </tr>
                        <tr>
                            <th>Issue</th>
                            <td><a href="<?= base_url('index.php/Audit/issue/'.$recommendation['issue'])?>"><?= $data['issue']['title'] ?></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-block">
                    <h4 class="card-title">Comments</h4>
                    <?= show_comments("Audit", "recommendation", $recommendation['id']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div class="card">
                <div class="card-block">
                    <a href="<?= base_url("index.php/Audit/actionplanForm/0/{$recommendation['id']}")?>" <?= MODAL_LINK ?>  class="btn btn-secondary btn-sm pull-right"><i  class="icon icon-plus"></i> New Management Action Plan </a>
                    <h5 class="card-title">Management Action Plans</h5>
                    <table id="datatable-buttons" class="table table-striped table-bordered table-responsive table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Action Plan</th>
                                <th>Action by Date</th>
                                <th>Action Plan Owner</th>
                                <th>Assigned To</th>
                                <th>Review Date</th>
                                <th>Verification Status</th>
                                <th>Implementation Status</th>
                                <th>Approval Status</th>
                                <th>Active Status</th>
                            </tr>
                        </thead>


                        <tbody>

                            <?php 
                            $num = 0;
                            foreach ($data['action_plans'] as $key => $value) :
                                $num++; ?>
                                <tr>
                                    <td><?= $num ?></td>
                                    <td><a href="<?= base_url('index.php/Audit/action_plan/'.$value['id'].'')?>"><?= ucwords($value['action_plan']) ?></a></td>
                                    <td class="<?= ((strtotime($value['action_by_date']) < strtotime(date('Y-m-d'))) && ($value['verification_status'] == 'Unverified')) ? "text-danger" : "text-success"?>"><?= strftime("%b-%d-%Y", strtotime($value['action_by_date'])) ?></td>
                                    <td><?= $value['action_plan_owner'] ?></td>
                                    <td><?= $value['assigned_to'] ?></td>
                                    <td class="<?= ((strtotime($value['review_date']) < strtotime(date('Y-m-d'))) && ($value['verification_status'] == 'Unverified')) ? "text-danger" : "text-success"?>"><?= strftime("%b-%d-%Y", strtotime($value['review_date'])) ?></td>
                                    <td><?= $value['verification_status'] ?></td>
                                    <td><?= $value['implementation_status'] ?></td>
                                    <td><?= $value['approval_status'] ?></td>
                                    <td><?= $value['active_status'] ?></td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>

                </div>
            </div>

        </div>

    </div>
</div>



<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').DataTable();

        //Buttons examples
        var table = $('#datatable-buttons').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'colvis'],
        });

        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });

</script>