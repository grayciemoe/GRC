<?php
$$data['repository']['source'] = $data['repository'][$data['repository']['source']]
?><div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Counter Party </h4>
        </div>
        <div class='modal-body'>

            <dl class='dl-horizontal row'>
                <dt class='col-sm-3'> ID </dt>
                <dd class='col-sm-9'> <?= $counter_party['id'] ?> </dd>
                <dt class='col-sm-3'> Contract </dt>
                <dd class='col-sm-9'> <?= $counter_party['contract'] ?> </dd>
                <dt class='col-sm-3'> Name </dt>
                <dd class='col-sm-9'> <?= $counter_party['name'] ?> </dd>
                <dt class='col-sm-3'> Email </dt>
                <dd class='col-sm-9'> <?= $counter_party['email'] ?> </dd>
                <dt class='col-sm-3'> Phone </dt>
                <dd class='col-sm-9'> <?= $counter_party['phone'] ?> </dd>
                <dt class='col-sm-3'> Company </dt>
                <dd class='col-sm-9'> <?= $counter_party['company'] ?> </dd>
            </dl>
    <div class="col-sm-12"><?= show_documents("environment", "repository", $data['repository']['id'], TRUE); ?></div>
            
        </div>
    </div>
</div>
