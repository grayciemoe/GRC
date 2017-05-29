<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Obligation Action Center </h4>
        </div>
        <div class='modal-body'>

            <?php
            //print_pre($data);
            $breaches = [];
            foreach ($data['obligation']['breaches'] as $key => $value):
                if ($value['approved'] != "pending") {
                    continue;
                }
                $breaches[] = $value;
            endforeach;
            $complaince = [];
            foreach ($data['obligation']['complies'] as $key => $value):
                if ($value['approved'] != "pending") {
                    continue;
                }
                $complaince[] = $value;
            endforeach;
            ?>
            <?php if (count($breaches)) : ?>

                <h4>Breaches</h4>
                <table class="table table-small table-sm table-hover  <?= count($breaches) > 5 ? " table-striped" : NULL ?>">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th class="text-center">Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php ?>
                        <?php
                        foreach ($breaches as $key => $value):
                            if ($value['approved'] != "pending") {
                                continue;
                            }
                            ?>
                            <tr>
                                <td><?= $value['title'] ?></td>
                                <td><?= ucwords($value['type']) ?></td>
                                <td><?= strftime("%b %d %Y", strtotime($value['submission_deadline'])) ?></td>
                                <td class="text-center"><span class="label label-default label-pill label-rounded"><?= ucwords($value['status']) ?></span></td>
                                <td>
                                    <div class='btn-group pull-right'>
                                        <a href="<?= base_url("index.php/Compliance/breach/{$value['id']}") ?>" <?= MODAL_AJAX ?> class="btn btn-secondary btn-sm btn-small"><i class="icon icon-eye"></i> Preview</a>
                                        <a href="<?= base_url("index.php/Compliance/QuickObligationApprove/{$value['id']}/rejected") ?>" onclick="QuickObligationApprove(this.href);return false" class="btn btn-danger btn-sm btn-small"><i class="icon icon-check"></i> Reject</a>
                                        <a href="<?= base_url("index.php/Compliance/QuickObligationApprove/{$value['id']}/approved") ?>" onclick="QuickObligationApprove(this.href);return false" class="btn btn-success btn-sm btn-small"><i class="icon icon-close"></i> Approve</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?> 



                </table>

            <?php endif; ?>
            <?php if (count($complaince)) : ?>
                <h4>Complaince</h4>
                <table class="table table-small table-sm table-hover  <?= count($data['obligation']['breaches']) > 5 ? " table-striped" : NULL ?>">

                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Completion</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($complaince as $key => $value):
                        if ($value['approved'] != "pending") {
                            continue;
                        }
                        ?>
                        <tr>
                            <td><?= $value['title'] ?></td>
                            <td><?= ucwords($value['completion']) ?></td>
                            <td><?= strftime("%b %d %Y", strtotime($value['submission_deadline'])) ?></td>
                            <td>
                                <div class='btn-group pull-right'>
                                    <a href="<?= base_url("index.php/Compliance/compliant/{$value['id']}") ?>" <?= MODAL_AJAX ?> class="btn btn-secondary btn-sm btn-small"><i class="icon icon-eye"></i> Preview</a>
                                    <a href="<?= base_url("index.php/Compliance/QuickObligationComplianceApprove/{$value['id']}/rejected") ?>" onclick="QuickObligationApprove(this.href);return false" class="btn btn-success btn-sm btn-small"><i class="icon icon-close"></i> Reject</a>
                                    <a href="<?= base_url("index.php/Compliance/QuickObligationComplianceApprove/{$value['id']}/approved") ?>" onclick="QuickObligationApprove(this.href);return false" class="btn btn-danger btn-sm btn-small"><i class="icon icon-check"></i> Approve</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>


                </table>
            <?php endif; ?>
        </div>
        <div class='modal-footer'>

            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
    function QuickObligationApprove(url) {
        $.post(url, {
            data: "data"
        }, function (response) {
            ajaxFileModal("<?= base_url("index.php/Compliance/ObligationBulkActionApprove/{$data['obligation']['obligation']['id']}") ?>");
        });
    }
</script>