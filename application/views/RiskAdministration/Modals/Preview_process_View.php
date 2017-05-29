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
	<dd class='col-sm-9'> <?= $process['id'] ?> </dd>
	<dt class='col-sm-3'> ref_code </dt>
	<dd class='col-sm-9'> <?= $process['ref_code'] ?> </dd>
	<dt class='col-sm-3'> owner </dt>
	<dd class='col-sm-9'> <?= $process['owner'] ?> </dd>
	<dt class='col-sm-3'> name </dt>
	<dd class='col-sm-9'> <?= $process['name'] ?> </dd>
	<dt class='col-sm-3'> description </dt>
	<dd class='col-sm-9'> <?= $process['description'] ?> </dd>
	<dt class='col-sm-3'> created </dt>
	<dd class='col-sm-9'> <?= $process['created'] ?> </dd>
	<dt class='col-sm-3'> link </dt>
	<dd class='col-sm-9'> <?= $process['link'] ?> </dd>
	<dt class='col-sm-3'> status </dt>
	<dd class='col-sm-9'> <?= $process['status'] ?> </dd>
	<dt class='col-sm-3'> system_involved </dt>
	<dd class='col-sm-9'> <?= $process['system_involved'] ?> </dd>
	<dt class='col-sm-3'> environment </dt>
	<dd class='col-sm-9'> <?= $process['environment'] ?> </dd>
	<dt class='col-sm-3'> approved </dt>
	<dd class='col-sm-9'> <?= $process['approved'] ?> </dd>
</dl>

        </div>
    </div>
</div>
