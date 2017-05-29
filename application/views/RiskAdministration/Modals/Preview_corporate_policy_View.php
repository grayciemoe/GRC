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
	<dd class='col-sm-9'> <?= $corporate_policy['id'] ?> </dd>
	<dt class='col-sm-3'> ref_code </dt>
	<dd class='col-sm-9'> <?= $corporate_policy['ref_code'] ?> </dd>
	<dt class='col-sm-3'> type </dt>
	<dd class='col-sm-9'> <?= $corporate_policy['type'] ?> </dd>
	<dt class='col-sm-3'> name </dt>
	<dd class='col-sm-9'> <?= $corporate_policy['name'] ?> </dd>
	<dt class='col-sm-3'> description </dt>
	<dd class='col-sm-9'> <?= $corporate_policy['description'] ?> </dd>
	<dt class='col-sm-3'> attachment </dt>
	<dd class='col-sm-9'> <?= $corporate_policy['attachment'] ?> </dd>
	<dt class='col-sm-3'> environment </dt>
	<dd class='col-sm-9'> <?= $corporate_policy['environment'] ?> </dd>
	<dt class='col-sm-3'> approved </dt>
	<dd class='col-sm-9'> <?= $corporate_policy['approved'] ?> </dd>
	<dt class='col-sm-3'> created </dt>
	<dd class='col-sm-9'> <?= $corporate_policy['created'] ?> </dd>
</dl>

        </div>
    </div>
</div>
