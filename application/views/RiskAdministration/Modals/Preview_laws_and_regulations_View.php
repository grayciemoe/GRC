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
                <dt class='col-sm-3'> ref_code </dt>
                <dd class='col-sm-9'> <?= $laws_and_regulations['ref_code'] ?> </dd>
                <div class="clearfix"></div>
                <dt class='col-sm-3'> name </dt>
                <dd class='col-sm-9'> <?= $laws_and_regulations['name'] ?> </dd>
                <div class="clearfix"></div>
                <dt class='col-sm-3'> type </dt>
                <dd class='col-sm-9'> <?= $laws_and_regulations['type'] ?> </dd>
                <div class="clearfix"></div>
                <dt class='col-sm-3'> effective_date </dt>
                <dd class='col-sm-9'> <?= $laws_and_regulations['effective_date'] ?> </dd>
                <div class="clearfix"></div>
                <dt class='col-sm-3'> legislative_authority </dt>
                <dd class='col-sm-9'> <?= $laws_and_regulations['legislative_authority'] ?> </dd>
                <div class="clearfix"></div>
                <dt class='col-sm-3'> enforcing_authority </dt>
                <dd class='col-sm-9'> <?= $laws_and_regulations['enforcing_authority'] ?> </dd>
                <div class="clearfix"></div>
                <dt class='col-sm-3'> last_revised_date </dt>
                <dd class='col-sm-9'> <?= $laws_and_regulations['last_revised_date'] ?> </dd>
                <div class="clearfix"></div>
                <dt class='col-sm-3'> type_2 </dt>
                <dd class='col-sm-9'> <?= $laws_and_regulations['type_2'] ?> </dd>
                <div class="clearfix"></div>
                <dt class='col-sm-3'> environment </dt>
                <dd class='col-sm-9'> <?= $laws_and_regulations['environment'] ?> </dd>
                <div class="clearfix"></div>
                <dt class='col-sm-3'> approved </dt>
                <dd class='col-sm-9'> <?= $laws_and_regulations['approved'] ?> </dd>
                <div class="clearfix"></div>
                <dt class='col-sm-3'> created </dt>
                <dd class='col-sm-9'> <?= $laws_and_regulations['created'] ?> </dd>
                <div class="clearfix"></div>
            </dl>
            
        </div>
    </div>
</div>
