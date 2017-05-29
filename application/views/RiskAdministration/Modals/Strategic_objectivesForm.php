<?php
$strategic_objectives = $data['repository'][$data['repository']['source']]
?>
<?= form_open_multipart("Home/repositoryPost", array('id' => '', 'class' => '')) ?>



<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Strategic Objectives </h4>
        </div>
        <div class='modal-body'>
            <input type='hidden' class='form-control'  name='id' id='txt-strategic_objectives-id' value='<?= $strategic_objectives['id'] ?>' />
            <div class='form-group row'>
                <label  for="txt-strategic_objectives-ref_code" readonly class='col-sm-2 form-control-label'>Ref Code</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control' readonly   name='ref_code' id='txt-strategic_objectives-ref_code' value='<?= $strategic_objectives['ref_code'] ?>' placeholder='ref_code' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-strategic_objectives-title"  class='col-sm-2 form-control-label'>Title</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'   name='title'  required=''  id='txt-strategic_objectives-title' value='<?= $strategic_objectives['title'] ?>' placeholder='title' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-strategic_objectives-name"  class='col-sm-2 form-control-label'>Name</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'   name='name'  required=''  id='txt-strategic_objectives-name' value='<?= $strategic_objectives['name'] ?>' placeholder='name' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-strategic_objectives-description"  class='col-sm-2 form-control-label'>Description</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg'  name='description' id='txt-strategic_objectives-description' placeholder='description' ><?= $strategic_objectives['description'] ?></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-strategic_objectives-current_KPI"  class='col-sm-2 form-control-label'>Current Kpi</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='current_KPI' id='txt-strategic_objectives-current_KPI' value='<?= $strategic_objectives['current_KPI'] ?>' placeholder='current_KPI' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-strategic_objectives-current_KPI_date"  class='col-sm-2 form-control-label'>Current Kpi Date</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='current_KPI_date' id='txt-strategic_objectives-current_KPI_date' value='<?= $strategic_objectives['current_KPI_date'] ?>' placeholder='current_KPI_date' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-strategic_objectives-year"  class='col-sm-2 form-control-label'>Year</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='year' id='txt-strategic_objectives-year' value='<?= $strategic_objectives['year'] ?>' placeholder='year' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-strategic_objectives-BSC_perspective"  class='col-sm-2 form-control-label'>Bsc Perspective</label>
                <div class='col-sm-10'>
                    <select  class='form-control' required="" name='BSC_perspective' id='txt-strategic_objectives-BSC_perspective'> 
                        <option value="">SELECT</option>
                        <option value='Strategic' <?= $strategic_objectives['BSC_perspective'] == 'Strategic' ? "selected='selected'" : NULL; ?> > Strategic </option>
                        <option value='Finance' <?= $strategic_objectives['BSC_perspective'] == 'Finance' ? "selected='selected'" : NULL; ?> > Finance </option>
                        <option value='Operational' <?= $strategic_objectives['BSC_perspective'] == 'Operational' ? "selected='selected'" : NULL; ?> > Operational </option>
                        <option value='Learning & Growth' <?= $strategic_objectives['BSC_perspective'] == 'Learning & Growth' ? "selected='selected'" : NULL; ?> > Learning & Growth </option>
                        <option value='Compliance' <?= $strategic_objectives['BSC_perspective'] == 'Compliance' ? "selected='selected'" : NULL; ?> > Compliance </option>
                        <option value='Reporting' <?= $strategic_objectives['BSC_perspective'] == 'Reporting' ? "selected='selected'" : NULL; ?> > Reporting </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-strategic_objectives-cascaded_from"  class='col-sm-2 form-control-label'>Cascaded From</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='cascaded_from' id='txt-strategic_objectives-cascaded_from' value='<?= $strategic_objectives['cascaded_from'] ?>' placeholder='cascaded_from' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-strategic_objectives-owner"  class='col-sm-2 form-control-label'>Owner</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='owner' id='txt-strategic_objectives-owner' value='<?= $strategic_objectives['owner'] ?>' placeholder='owner' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-strategic_objectives-KPI_measure"  class='col-sm-2 form-control-label'>Kpi Measure</label>
                <div class='col-sm-10'>
                    <select  class='form-control' required="" name='KPI_measure' id='txt-strategic_objectives-KPI_measure'>
                        <option value="">SELECT</option>
                        <option value='count' <?= $strategic_objectives['KPI_measure'] == 'count' ? "selected='selected'" : NULL; ?> > Count </option>
                        <option value='percentage' <?= $strategic_objectives['KPI_measure'] == 'percentage' ? "selected='selected'" : NULL; ?> > Percentage </option>
                        <option value='totals' <?= $strategic_objectives['KPI_measure'] == 'totals' ? "selected='selected'" : NULL; ?> > Totals </option>
                        <option value='average' <?= $strategic_objectives['KPI_measure'] == 'average' ? "selected='selected'" : NULL; ?> > Average </option>
                        <option value='ratio' <?= $strategic_objectives['KPI_measure'] == 'ratio' ? "selected='selected'" : NULL; ?> > Ratio </option>
                    </select>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-strategic_objectives-KPI_measure_leading"  class='col-sm-2 form-control-label'>Kpi Measure Leading</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg' class='form-control'  name='KPI_measure_leading' id='txt-strategic_objectives-KPI_measure_leading' value='<?= $strategic_objectives['KPI_measure_leading'] ?>' placeholder='KPI_measure_leading' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-strategic_objectives-KPI_measure_lagging"  class='col-sm-2 form-control-label'>Kpi Measure Lagging</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg' class='form-control'  name='KPI_measure_lagging' id='txt-strategic_objectives-KPI_measure_lagging' value='<?= $strategic_objectives['KPI_measure_lagging'] ?>' placeholder='KPI_measure_lagging' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-strategic_objectives-KPI_target_leading"  class='col-sm-2 form-control-label'>Kpi Target Leading</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='KPI_target_leading' id='txt-strategic_objectives-KPI_target_leading' value='<?= $strategic_objectives['KPI_target_leading'] ?>' placeholder='KPI_target_leading' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-strategic_objectives-KPI_target_lagging"  class='col-sm-2 form-control-label'>Kpi Target Lagging</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='KPI_target_lagging' id='txt-strategic_objectives-KPI_target_lagging' value='<?= $strategic_objectives['KPI_target_lagging'] ?>' placeholder='KPI_target_lagging' />
                </div>
            </div>

            <div class='form-group row'>
                <label  for="txt-strategic_objectives-environment"  class='col-sm-2 form-control-label'>Environment</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='environment' id='txt-strategic_objectives-environment' value='<?= $strategic_objectives['environment'] ?>' placeholder='environment' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-strategic_objectives-approved"  class='col-sm-2 form-control-label'>Approved</label>
                <div class='col-sm-10'>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-strategic_objectives-kra_clipboard"  class='col-sm-2 form-control-label'>Kra Clipboard</label>
                <div class='col-sm-10'>
                    <input type='number' class='form-control'  name='kra_clipboard' id='txt-strategic_objectives-kra_clipboard' value='<?= $strategic_objectives['kra_clipboard'] ?>' placeholder='kra_clipboard' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-strategic_objectives-created"  class='col-sm-2 form-control-label'>Created</label>
                <div class='col-sm-10'>
                    <input type='date' class='form-control'  name='created' id='txt-strategic_objectives-created' value='<?= $strategic_objectives['created'] ?>' placeholder='created' />
                </div>
            </div>



        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>

