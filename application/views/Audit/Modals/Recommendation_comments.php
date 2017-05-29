<link href="<?= base_url("assets/css/style.css") ?>" rel="stylesheet" type="text/css" />
<?php
$recommendation = $data['recommendation'];
?>
<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Recommendation </h4>
        </div>
        <div class='modal-body'>
            <div class="row m-b-20">
                <div class="col-sm-12">
                <input type='hidden' class='form-control'  name='id' id='txt-audit-id' value='' />

                <div class='form-group col-sm-8'>
                    <label  for="txt-recommendation"  class='form-control-label'><b>Recommendation</b></label>
                    <div>
                        <?= $recommendation['recommendation'] ?>
                    </div>
                </div>

                <div class='form-group col-sm-4'>
                    <label  for="txt-issue-respond_by_date"  class='form-control-label'><b>Respond By Date</b></label>
                    <div>
                        <?= strftime("%Y-%m-%d", strtotime($recommendation['respond_by_date'])) ?>
                    </div>
                </div>
                </div>
            </div>
            <?= show_comments("Audit", "recommendation", $recommendation['id']) ?>

        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Cancel</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


