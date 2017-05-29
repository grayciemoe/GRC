<?php $risk_evaluation = $data['evaluation']; ?>
<?= form_open_multipart("Risk/evaluationPost", array('id' => '', 'class' => '')) ?>

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Risk Evaluation </h4>
        </div>
        <div class='modal-body'>
            <input type='hidden' class='form-control'  name='id' id='txt-risk_evaluation-id' value='<?= $risk_evaluation['id'] ?>' />
            <input type='hidden' class='form-control'  name='risk' id='txt-risk_evaluation-risk' value='<?= $risk_evaluation['risk'] ?>' placeholder='risk' />

            <div class="row">
                <div class="col-sm-5">

                    <div class='form-group row'>
                        <label  for="txt-risk_evaluation-si_units"  class='col-sm-4 form-control-label'>Measure of Unit</label>
                        <div class='col-sm-8 '>
                            <input type='text'  class='form-control readOnly' <?= $data['first'] ? null : "readonly=''" ?>    name='si_units' id='txt-risk_evaluation-si_units' value='<?= $risk_evaluation['si_units'] ?>'  />
                        </div>
                    </div>

                    <div class='form-group row'>
                        <label  for="txt-risk_evaluation-capacity"  class='col-sm-4 form-control-label'>Capacity</label>
                        <div class='col-sm-8 '>
                            <input type='number' class='form-control readOnly' <?= $data['first'] ? null : "readonly=''" ?>  name='capacity' id='txt-risk_evaluation-capacity' value='<?= $risk_evaluation['capacity'] ?>' placeholder='capacity' />
                        </div>
                    </div>

                    <div class='form-group row'>
                        <label  for="txt-risk_evaluation-target"  class='col-sm-4 form-control-label'>Target</label>
                        <div class='col-sm-8 '>
                            <input type='number' class='form-control readOnly' <?= $data['first'] ? null : "readonly=''" ?>  name='target' id='txt-risk_evaluation-target' value='<?= $risk_evaluation['target'] ?>' placeholder='target' />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">

                            <div class='form-group row'>
                                <label required-text="Enter tolerance_upper_limit"  for="txt-risk_evaluation-tolerance_upper_limit"  class='col-sm-12 form-control-label'>Tolerance Upper Limit</label>
                                <div class='col-sm-12 '>
                                    <input type='number' onchange="limit_control(this.value)" class='form-control readOnly' <?= $data['first'] ? null : "readonly=''" ?>  name='tolerance_upper_limit' id='txt-risk_evaluation-tolerance_upper_limit' value='<?= $risk_evaluation['tolerance_upper_limit'] ?>' placeholder='tolerance_upper_limit' required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class='form-group row'>
                                <label  for="txt-risk_evaluation-tolerance_lower_limit"  class='col-sm-12 form-control-label'>Tolerance Lower Limit</label>
                                <div class='col-sm-12 '>
                                    <input type='number' class='form-control readOnly' <?= $data['first'] ? null : "readonly=''" ?>  name='tolerance_lower_limit' id='txt-risk_evaluation-tolerance_lower_limit' value='<?= $risk_evaluation['tolerance_lower_limit'] ?>' placeholder='tolerance_lower_limit' required="Enter tolerance_lower_limit"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label  for="txt-risk_evaluation-appetite"  class='col-sm-4 form-control-label'>Appetite</label>
                        <div class='col-sm-8 '>
                            <input type='number' class='form-control readOnly' <?= $data['first'] ? null : "readonly=''" ?>  name='appetite' id='txt-risk_evaluation-appetite' value='<?= $risk_evaluation['appetite'] ?>' placeholder='appetite' />
                        </div>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class='form-group row'>
                        <label  for="txt-risk_evaluation-appetite_measure"  class='col-sm-12 form-control-label'>Appetite Measure</label>
                        <div class='col-sm-12'>
                            <textarea class='form-control wysiwyg readOnly' rows="4" <?= $data['first'] ? null : "readonly=''" ?>  name='appetite_measure' id='txt-risk_evaluation-appetite_measure' placeholder='appetite_measure' ><?= $risk_evaluation['appetite_measure'] ?></textarea>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label  for="txt-risk_evaluation-key_risk_indicator"class='col-sm-12 form-control-label'>Key Risk Indicator</label>
                        <div class='col-sm-12'>
                            <textarea class='form-control wysiwyg readOnly'  <?= $data['first'] ? null : "readonly=''" ?>   rows="4" name='key_risk_indicator' id='txt-risk_evaluation-key_risk_indicator' placeholder='key_risk_indicator' ><?= $risk_evaluation['key_risk_indicator'] ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <hr class="m-0">
                    <div class='form-group row'>
                        <label  for="txt-risk_evaluation-current_level"  class='col-sm-4 form-control-label'>Current Level</label>
                        <div class='col-sm-12 '>

                            <?php
                            $max = null;
                            if ($risk_evaluation['capacity'] > 1) {
                                $max = $risk_evaluation['capacity'];
                            }

                            //print_pre($data);
                            if ($data['risk']['evaluation_type'] == 'positive') {
                                $condition = NULL;
//                                $condition = "max='{$max}'";
                            } else {

                                $condition = NULL;
                            }
                            ?>
                            <input type='number' class='form-control' required min="0" <?= $condition ?>  name='current_level' id='txt-risk_evaluation-current_level' value='<?= $risk_evaluation['current_level'] ?>' placeholder='current_level' required/>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class='modal-footer'>
            <?php if ($risk_evaluation['id']): ?>
                <button type="button" class="btn btn-secondary waves-effect pull-left" onclick="toggleReadOnlies()"><i class="icon icon-pencil"></i> Edit Details</button>
            <?php endif; ?>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='submit' class='btn btn-secondary waves-effect' >Save</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>
<script>
    function toggleReadOnlies() {
        $('.readOnly').removeAttr('readonly');
    }

    function limit_control(value) {
        document.getElementById('txt-risk_evaluation-appetite').max = value;
        document.getElementById('txt-risk_evaluation-tolerance_lower_limit').max = value;
        
    }
</script>