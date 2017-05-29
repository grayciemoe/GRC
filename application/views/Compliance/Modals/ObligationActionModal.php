<?php
$obligation = $data['obligation'];
$compliance_requirement = $data['compliance_requirement'];
$authority = $data['authority'];
?>
<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <button href="<?= base_url("index.php/Compliance/__/{$obligation['id']}"); ?>" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Obligation Action</h4>
        </div>
        <div class="modal-body">
            <p class="text-center">Have you complied to <strong><?= $obligation['title'] ?></strong> </p>
        </div>
        <div class="modal-footer text-center">
            <a href="<?= base_url("index.php/Compliance/compliantForm/0/{$data['obligation']['id']}/yes") ?>" <?= MODAL_AJAX ?> class="btn btn-primary-outline btn-rounded waves-effect waves-light">Yes</a>
            <a href="<?= base_url("index.php/Compliance/compliantForm/0/{$data['obligation']['id']}/partially") ?>" <?= MODAL_AJAX ?> class="btn btn-warning-outline btn-rounded waves-effect waves-light">Partially</a>
            <a href="<?= base_url("index.php/Compliance/breachForm/0/{$data['obligation']['id']}") ?>" <?= MODAL_AJAX ?> class="btn btn-danger-outline btn-rounded waves-effect waves-light">No</a>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->