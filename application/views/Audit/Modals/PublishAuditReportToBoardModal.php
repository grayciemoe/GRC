<?php
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $report_url = base_url("index.php/Writer4/report/{$data['audit']['id']}");
} else {
    $report_url = "http://104.199.15.116/index.php/Writer4/report/{$data['audit']['id']}";
}
//$audit_report = $data['audit_report'];
//print_pre($data); exit;
?>
<?= form_open_multipart("Audit/publishAuditReportpost", array('id' => 'frm_publishAudit_form', 'class' => 'form-vertical', 'onsubmit' => 'return(auditReportvalidate());')) ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Publish To Board</h4>
        </div>
        <div class="modal-body">
            <?php if (empty($data['issues_pub'])): ?>
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h2 class="text-center">No issues are selected to be included in the Report</h2>
                    <a href="<?= base_url('index.php/audit/AuditReportSelectIssues/' . $data['audit']['id']) ?>" <?= MODAL_AJAX ?> class="btn btn-block btn-info-outline" ><i  class="icon icon-doc"></i> Select Issues for Audit Report</a>
                </div>
            <?php elseif ((!empty($data['issues_pub'])) && (empty($data['audit_report']))): ?>
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h2 class="text-center">Prepare Report first before publishing</h2>
                    <a href="<?= base_url('index.php/audit/PreviewIssueInReport/0/' . $data['audit']['id']) ?>" class="btn btn-block btn-info-outline" ><i  class="icon icon-doc"></i> Prepare Audit Report</a>
                </div>
            <?php else: ?>
                <a id="rport" onclick="report();" class="btn btn-success-outline btn-block" href="<?= $report_url ?>">Generate Report</a>
                <a id="rport2" class="btn btn-sm btn-success-outline btn-block hidden disabled"><i class="fa fa-spin fa-spinner"></i>  Generating Report</a>

                <div class="form-group">
                    <label class="form-control-label" for="audit_title">Title</label>
                    <input class="form-control" disabled="" type="text" id="audit_title" name="audit_name" value="<?= $data['audit']['audit_name'] ?>" />
                </div>
                <div class="form-group">
                    <input class="form-control hidden" type="text" id="audit_title" name="audit" value="<?= $data['audit']['id'] ?>" />
                </div>
                <hr />  
                <h5 class="card-title">Please Attach The Final Audit Report to be published to the board</h5>
                <div class="alert alert-danger" role="alert">
                    <strong><i class="fa fa-exclamation-circle"></i>  Once you publish you will not be able to edit this Audit</strong></div>
                <div class="form-control-file">
                    <?= files_upload("audit", "audit_report", $data['audit']['id']); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-danger waves-effect'>Publish </button>
            </div>
        <?php endif; ?>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
                    var whitelist = ['doc', 'docx', 'pdf', 'xml'];
                    function validateform() {
                        $("#frm_publishAudit_form").validate();

                        $("input.ipfile").each(function () {
                            $(this).rules("add", {
                                required: true,
                                accept: "jpg|jpeg"
                            });
                        });
                    }
                    function auditReportvalidate() {
                        validateform();
                        var inp = document.getElementById("audit-audit_report-<?= $data['audit']['id'] ?>");
                        var string = '';
                        var name;
                        var size;
                        var filetype;
                        if (inp.files.length === 0) {
                            event.preventDefault();
                            document.getElementById("auditreport-val").innerHTML = "Final Audit Report Attachment required";
                            inp.focus();
                            return;
                        } else {
                            for (var i = 0; i < inp.files.length; i++) {
                                name = inp.files.item(i).name;
                                size = (inp.files.item(i).size / (1024 * 1024)).toFixed(2);
                                if (size > 10) {
                                    alert("File is too large. Only 10MB size for one file is allowed");
                                    return;
                                }
                                filetype = inp.files.item(i).type;
                                string +=
                                        "<tr>" +
                                        "<td>" + name + "</td>" +
                                        "<td>" + size + " MB</td>" +
                                        "<td>" + filetype + "</td>" +
                                        "</tr>";
                            }
                            var html = string;
                            document.getElementById('files-audit-audit_report-<?= $data['audit']['id'] ?>').innerHTML = html;
                        }
                    }
                    CKEDITOR.replace('txt-audit_rep-objective');
                    CKEDITOR.replace('txt-audit_rep-conclusion');
                    function report() {
                        $('#rport').addClass('hidden');
                        $('#rport2').removeClass('hidden');
                        setTimeout(function () {
                            $('#rport').removeClass('hidden');
                            $('#rport2').addClass('hidden');
                        }, 20000);
                    }
</script>