<?php
/*
 *  Code By Alex
 *  Eat Code Sleep Repeat
 */
//print_pre($data); exit;
?>
<?= form_open("Audit/postAuditReport", array('id' => 'frm_audit-rep_form', 'class' => '')) ?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"><?= $data['audit']['audit_name'] ?> </h4>
        </div>
        <div class="modal-body row">
            <?php if (count($data['issues']) == 0): ?>
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h2 class="text-center">No issues are selected to be included in the Report</h2>
                    <a href="<?= base_url('index.php/audit/AuditReportSelectIssues/' . $data['audit']['id']) ?>" <?= MODAL_AJAX ?> class="btn btn-block btn-info-outline" ><i  class="icon icon-doc"></i> Select Issues for Audit Report</a>
                </div>
            <?php else: ?>
                <table class="col-sm-12 table table-small table-sm table-striped">
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

                        <?php
                        $issue_rep = array();
                        foreach ($data['issues'] as $key => $value):
                            $issue_rep[] = $value['id'];
                            ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><a href="<?= base_url("index.php/Audit/issue/{$value['id']}"); ?>"><?= ucwords($value['title']) ?></a></td>
                                <td><?= $data['issue_owner']['names'] ?></td>
                                <td><?= $value['audit_area']['title']?></td>
                                <td>
                                        <?php
                                        if ($value['issue_rating'] == 'Low') {
                                            echo '<span class="label label-pill label-primary">';
                                        } elseif ($value['issue_rating'] == 'Moderate') {
                                            echo '<span class="label label-pill label-warning">';
                                        } elseif ($value['issue_rating'] == 'High') {
                                            echo '<span class="label label-pill label-danger">';
                                        } else {
                                            echo '<span class="label label-pill label-danger">';
                                        }
                                        ?>
                                        <?= $value['issue_rating'] ?>
                                        </span>
                                    </td>
                                <td>
                                        <?php
                                        if ($value['issue_status'] == 'Open') {
                                            echo '<span class="label label-pill label-danger">';
                                        } elseif ($value['issue_status'] == 'Closed') {
                                            echo '<span class="label label-pill label-info">';
                                        } else {
                                            
                                        }
                                        ?>
                                        <?= $value['issue_status'] ?>
                                        </span>
                                    </td>
                            </tr>
    <?php endforeach; ?>
                    </tbody>

                </table>

                <div class='form-group'>
                    <input type="text" class="form-control" hidden name="issues[]" value='<?= json_encode($issue_rep) ?>'>
                </div>
                <div class='form-group'>
                    <input type="text" class="form-control" hidden name="audit" value='<?= $data['audit']['id'] ?>'>
                </div>
                <div class='form-group'>
                    <label  for="txt-audit_rep-objective"  class='col-sm-12 form-control-label'>Objective/Work Done</label>
                    <div class='col-sm-12'>
                        <textarea class='form-control wysiwyg'  rows="10" name='objective' id='txt-audit_rep-objective' ></textarea>
                    </div>
                </div>
                <div class='form-group'>
                    <label  for="txt-audit_rep-conclusion"  class='col-sm-12 form-control-label'>Conclusion</label>
                    <div class='col-sm-12'>
                        <textarea class='form-control wysiwyg'  rows="10" name='conclusion' id='txt-audit_rep-conclusion'></textarea>
                    </div>
                </div>
            </div>
            <div class='modal-footer'>
                <a class='btn btn-secondary btn-sm waves-effect' data-dismiss='modal'>Cancel</a>
                <button type='submit' class='btn btn-sm btn-primary waves-effect'>Save </button>
            </div>
<?php endif; ?>
    </div>
</div>
<script>

    CKEDITOR.replace('txt-audit_rep-objective');
    CKEDITOR.replace('txt-audit_rep-conclusion');
    function report() {
        $('#rport').addClass('hidden');
        $('#rport2').removeClass('hidden');
        setTimeout(function () {
            $('#rport').removeClass('hidden');
            $('#rport2').addClass('hidden');
        }, 15000);



    }
</script>
<?= form_close(); ?>