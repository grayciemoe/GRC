<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"> Edit Risk Status </h4>
        </div>
        <div class="modal-body">
            <p class="text-center">Risk <strong><?= $data['risk']['title'] ?></strong>'s status is <strong> <?= $data['risk']['status'] ?></strong>, do you want to  </p>
            <div class=" text-center">
                <?php if ($data['risk']['status'] == 'Inactive'): ?>
                <a href="<?= base_url("index.php/Risk/riskActivate/{$data['risk']['id']}/Active")?>" class="btn btn-rounded btn-success-outline waves-effect waves-light"><i class="icon icon-check"></i> Activate</a>
                <?php endif; ?>
                <?php if ($data['risk']['status'] == 'Active'): ?>
                    <a href="<?= base_url("index.php/Risk/riskActivate/{$data['risk']['id']}/Inactive")?>" class="btn btn-rounded btn-danger-outline waves-effect waves-light"><i class="icon icon-close"></i> Deactivate  </a>
                <?php endif; ?>
            </div>
        </div>

    </div><!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->