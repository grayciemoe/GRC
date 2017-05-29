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
                <dd class='col-sm-9'> <?= $counter_party['id'] ?> </dd>
                <dt class='col-sm-3'> contract </dt>
                <dd class='col-sm-9'> <?= $counter_party['contract'] ?> </dd>
                <dt class='col-sm-3'> name </dt>
                <dd class='col-sm-9'> <?= $counter_party['name'] ?> </dd>
                <dt class='col-sm-3'> email </dt>
                <dd class='col-sm-9'> <?= $counter_party['email'] ?> </dd>
                <dt class='col-sm-3'> phone </dt>
                <dd class='col-sm-9'> <?= $counter_party['phone'] ?> </dd>
                <dt class='col-sm-3'> company </dt>
                <dd class='col-sm-9'> <?= $counter_party['company'] ?> </dd>
            </dl>

        </div>
    </div>
</div>
