<?php $authority = $data['authority'] ?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"><?= $data['authority']['title'] ?> </h4>
        </div>
        <div class="modal-body">
            <dl class='dl-horizontal row'>
                <div class="clearfix"></div>
                <dt class='col-sm-3'> Type </dt>
                <dd class='col-sm-9'> <?= ucwords($authority['type']) ?> </dd>
                <div class="clearfix"></div>
                <dt class='col-sm-3'> Title </dt>
                <dd class='col-sm-9'> <?= $authority['title'] ?> </dd>
                <div class="clearfix"></div>
                <div class="clearfix"></div>
                <dt class='col-sm-3'> Report Sent To </dt>
                <dd class='col-sm-9'> <?= $authority['report_sent_to'] ?> </dd>
                <div class="clearfix"></div>
                <dt class='col-sm-3'> Contact Name </dt>
                <dd class='col-sm-9'> <?= $authority['contact_name'] ?> </dd>
                <div class="clearfix"></div>
                <dt class='col-sm-3'> Contact Email </dt>
                <dd class='col-sm-9'> <a href="mailto:<?= $authority['contact_email'] ?>"><?= $authority['contact_email'] ?></a> </dd>
                <div class="clearfix"></div>
                <dt class='col-sm-3'> Contact Address </dt>
                <dd class='col-sm-9'> <?= $authority['contact_address'] ?> </dd>
                <div class="clearfix"></div>
                <dt class='col-sm-3'> Contact Phone </dt>
                <dd class='col-sm-9'> <?= $authority['contact_phone'] ?> </dd>
                <div class="clearfix"></div>
            </dl>
        </div>
        <div class="modal-footer">
            <a href="<?= base_url("index.php/Compliance/authorityForm/{$data['authority']['id']}"); ?>" 
               class="btn btn-secondary"
               <?= MODAL_AJAX ?>><i class="icon icon-pencil"></i> Edit</a>

        </div>
    </div>
</div>



