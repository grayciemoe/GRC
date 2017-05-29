
<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"><span class="text-danger">Delete</span> Compliance Requirement</h4>
        </div>
        <div class="modal-body">
            <?php if (count($data['obligations']) == 0): ?>
                <p>Do you want to delete this file <strong class="text-danger"><?= $data['compliance_requirement']['title'] ?></strong> </p>
            <?php else : ?>
                <p>You cannot delete this <strong class="text-success"><?= $data['compliance_requirement']['title'] ?></strong> because it contains (<?= count($data['obligations']) ?>) obligations .</p>
            <?php endif; ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">No</button>
            <?php if (count($data['obligations']) == 0): ?>
                <a href="<?= base_url("index.php/Compliance/deleteComplianceRequirement/{$data['compliance_requirement']['id']}/true") ?>" 
                   onclick="deleteRecord(this.href, 'upload',<?= $data['compliance_requirement']['id'] ?>);" 
                   class="btn btn-danger waves-effect waves-light">Yes</a>
            <?php endif; ?>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->