<?php
$$data['repository']['source'] = $data['repository'][$data['repository']['source']]
?><div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Best Practices </h4>
        </div>
        <div class='modal-body'>

            <dl class='dl-horizontal row'>
                <dt class='col-sm-3'> id </dt>
                <dd class='col-sm-9'> <?= $contract['id'] ?> </dd>
                <dt class='col-sm-3'> ref_code </dt>
                <dd class='col-sm-9'> <?= $contract['ref_code'] ?> </dd>
                <dt class='col-sm-3'> name </dt>
                <dd class='col-sm-9'> <?= $contract['name'] ?> </dd>
                <dt class='col-sm-3'> description </dt>
                <dd class='col-sm-9'> <?= $contract['description'] ?> </dd>
                <dt class='col-sm-3'> effective_date </dt>
                <dd class='col-sm-9'> <?= $contract['effective_date'] ?> </dd>
                <dt class='col-sm-3'> expiry_date </dt>
                <dd class='col-sm-9'> <?= $contract['expiry_date'] ?> </dd>
                <dt class='col-sm-3'> link </dt>
                <dd class='col-sm-9'> <?= $contract['link'] ?> </dd>
                <dt class='col-sm-3'> type </dt>
                <dd class='col-sm-9'> <?= $contract['type'] ?> </dd>
                <dt class='col-sm-3'> contract_owner </dt>
                <dd class='col-sm-9'> <?= $contract['contract_owner'] ?> </dd>
                <dt class='col-sm-3'> signed_by </dt>
                <dd class='col-sm-9'> <?= $contract['signed_by'] ?> </dd>
                <dt class='col-sm-3'> status </dt>
                <dd class='col-sm-9'> <?= $contract['status'] ?> </dd>
                <dt class='col-sm-3'> attachment </dt>
                <dd class='col-sm-9'> <?= $contract['attachment'] ?> </dd>
                <dt class='col-sm-3'> environment </dt>
                <dd class='col-sm-9'> <?= $contract['environment'] ?> </dd>
                <dt class='col-sm-3'> approved </dt>
                <dd class='col-sm-9'> <?= $contract['approved'] ?> </dd>
                <dt class='col-sm-3'> created </dt>
                <dd class='col-sm-9'> <?= $contract['created'] ?> </dd>
            </dl>

        </div>
    </div>
</div>
