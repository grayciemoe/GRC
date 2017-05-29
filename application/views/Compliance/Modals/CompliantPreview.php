
<div class="modal-dialog  modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Complied Obligation</h4>


        </div>
        <div class="modal-body">

            <?php if ($data['complies']['approved'] == 'pending' and am_user_type(array(5))): ?>
            
                <div class="alert alert-danger alert-dismissible" >
                    <div class="text-center">
                        <p>Approve this Comply ?</p>
                        <a href="<?= base_url("index.php/Compliance/compliantApprove/{$data['complies'] ['id']}/approved"); ?>" <?= MODAL_AJAX ?> class="btn btn-success btn-rounded "><i class="icon icon-check"></i> Approve</a>
                        <a href="<?= base_url("index.php/Compliance/compliantApprove/{$data['complies'] ['id']}/rejected"); ?>" <?= MODAL_AJAX ?> class="btn btn-danger btn-rounded"><i class="icon icon-close"></i> Reject</a>
                    </div>
                </div>
            <?php endif;
            
            ?>
            <div class="table-responsive">

                <table class="table table-sm  table-small">
                    <?php 
            $approved_label = $data['complies']['approved'] == "approved" ? "info" : (($data['complies']['approved'] == "pending") ? "warning" : "danger");
            ?>
                    <tbody>
                        <tr>
                            <th> Title</th>
                            <td><?= $data['complies'] ['title'] ?> </td>
                        </tr>
                        <tr>
                            <th> Completion</th>
                            <td> <?= $data['complies'] ['completion'] ?></td>
                        </tr>
                        <tr>
                            <th> Submission Deadline</th>
                            <td><?= $data['complies'] ['submission_deadline'] ?></td>
                        </tr>
                        <tr>
                            <th> Period</th>
                            <td><?= $data['complies'] ['period_name'] ?></td>
                        </tr>

                        <tr>
                            <th> Approval Status</th>
                            <td>
                                <span class="label label-pill label-<?= $approved_label ?>">
                                                    <?= $data['complies'] ['approved'] ?>
                                                </span>
                            </td>
                            
                        </tr>

                        <tr>
                            <th> Description</th>
                            <td><?= $data['complies'] ['description'] ?></td>
                        </tr>
                        <?= show_documents("compliance", "obligation_comply", $data['complies']['id']) ?>
                    </tbody>

                </table>
                <?= NULL // $data['complies']['id']?>;
            </div>
        </div>
    </div>









</div><!--end of card-->