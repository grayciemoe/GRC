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
            <input type='hidden' class='form-control'  name='repository_id' id='txt-best_practices-id' value='<?= $data['repository']['id'] ?>' />

            <div class="row">
                <div class="col-sm-6">

                    <div class='form-group row'>
                        <label  for="txt-strategic_objectives-name"  class='col-sm-12 form-control-label'>Name</label>
                        <div class='col-sm-12 '>
                            <input type='text' class='form-control'   name='name'  required=''  id='txt-strategic_objectives-name' value='<?= $strategic_objectives['name'] ?>' placeholder='name' />
                        </div>
                    </div>
                    <?php if ($data['repository']['environment'] != 1 and false): ?>
                        <div class='form-group row'>
                            <label  for="txt-strategic_objectives-cascaded_from"  class='col-sm-12 form-control-label'>Cascaded From</label>
                            <div class='col-sm-12 '>
                                <input type='number' class='form-control'  name='cascaded_from' id='txt-strategic_objectives-cascaded_from' value='<?= $strategic_objectives['cascaded_from'] ?>' placeholder='cascaded_from' />

                                <select  class='form-control'name='cascaded_from' id='txt-strategic_objectives-cascaded_from'> 
                                    <option value=''>SELECT</option>
                                    <?php foreach ($data['cascaded_from'] as $key => $value): ?>
                                        <option value='' <?= $strategic_objectives['cascaded_from'] == $value['id'] ? "selected='selected'" : NULL; ?> > <?= $value['names'] ?> </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class='form-group row'>
                        <label  for="txt-strategic_objectives-owner"  class='col-sm-12 form-control-label'>Owner</label>
                        <div class='col-sm-12'>
                            <select  class='form-control'name='owner' id='txt-strategic_objectives-owner'> 
                                <option value=''>SELECT</option>
                                <?php foreach ($data['owners'] as $key => $value): ?>
                                    <option value='<?= $value['id'] ?>' <?= $strategic_objectives['owner'] == $value['id'] ? "selected='selected'" : NULL; ?> > <?= $value['names'] ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label  for="txt-strategic_objectives-current_KPI"  class='col-sm-12 form-control-label'>Current KPI</label>
                        <div class='col-sm-12 '>
                            <input type='text' class='form-control'  name='current_KPI' id='txt-strategic_objectives-current_KPI' value='<?= $strategic_objectives['current_KPI'] ?>' placeholder='current_KPI' />
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label  for="txt-strategic_objectives-current_KPI_date"  class='col-sm-12 form-control-label'>Current KPI Date</label>
                        <div class='col-sm-12 '>
                            <input type='date' class='form-control'  name='current_KPI_date' id='txt-strategic_objectives-current_KPI_date' value='<?= $strategic_objectives['current_KPI_date'] ?>' placeholder='current_KPI_date' />
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label  for="txt-strategic_objectives-year"  class='col-sm-12 form-control-label'>Year</label>
                        <div class='col-sm-12 '>
                            <select name="year" class="form-control" id="txt-strategic_objectives-year">
                                <?php for ($i = strftime("%Y", time()); $i > 2000; $i--): ?>
                                    <option><?= $i ?></option>
                                <?php endfor; ?>
                            </select>



                        </div>
                    </div>
                    <div class='form-group row'>
                        <label  for="txt-strategic_objectives-BSC_perspective"  class='col-sm-12 form-control-label'>BSC Perspective</label>
                        <div class='col-sm-12 '>
                            <select  class='form-control'name='BSC_perspective' id='txt-strategic_objectives-BSC_perspective'> 
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
                        <label  for="txt-strategic_objectives-description"  class='col-sm-12 form-control-label'>Description</label>
                        <div class='col-sm-12 '>
                            <textarea class='form-control wysiwyg' rows="50" name='description' id='txt-strategic_objectives-description' placeholder='description' ><?= $strategic_objectives['description'] ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">

                    <div class='form-group row'>
                        <label  for="txt-strategic_objectives-KPI_measure"  class='col-sm-12 form-control-label'>KPI Measure</label>
                        <div class='col-sm-12 '>
                            <select  class='form-control'name='KPI_measure' id='txt-strategic_objectives-KPI_measure'> 
                                <option value='count' <?= $strategic_objectives['KPI_measure'] == 'count' ? "selected='selected'" : NULL; ?> > Count </option>
                                <option value='percentage' <?= $strategic_objectives['KPI_measure'] == 'percentage' ? "selected='selected'" : NULL; ?> > Percentage </option>
                                <option value='totals' <?= $strategic_objectives['KPI_measure'] == 'totals' ? "selected='selected'" : NULL; ?> > Totals </option>
                                <option value='average' <?= $strategic_objectives['KPI_measure'] == 'average' ? "selected='selected'" : NULL; ?> > Average </option>
                                <option value='ratio' <?= $strategic_objectives['KPI_measure'] == 'ratio' ? "selected='selected'" : NULL; ?> > Ratio </option>
                            </select>
                        </div>
                    </div>

                    <div class='form-group row'>
                        <label  for="txt-strategic_objectives-KPI_target_leading"  class='col-sm-12 form-control-label'>KPI Target Leading</label>
                        <div class='col-sm-12 '>
                            <input type='text' class='form-control'  name='KPI_target_leading' id='txt-strategic_objectives-KPI_target_leading' value='<?= $strategic_objectives['KPI_target_leading'] ?>' placeholder='KPI_target_leading' />
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label  for="txt-strategic_objectives-KPI_measure_leading"  class='col-sm-12 form-control-label'>KPI Measure Leading</label>
                        <div class='col-sm-12 '>
                            <textarea class='form-control wysiwyg' class='form-control'  name='KPI_measure_leading' id='txt-strategic_objectives-KPI_measure_leading'><?= $strategic_objectives['KPI_measure_leading'] ?></textarea>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label  for="txt-strategic_objectives-KPI_target_landing"  class='col-sm-12 form-control-label'>KPI Target Lagging</label>
                        <div class='col-sm-12 '>
                            <input type='text' class='form-control'  name='KPI_target_landing' id='txt-strategic_objectives-KPI_target_lagging' value='<?= $strategic_objectives['KPI_target_lagging'] ?>' placeholder='KPI_target_lagging' />
                        </div>
                    </div>

                    <div class='form-group row'>
                        <label  for="txt-strategic_objectives-KPI_measure_lagging"  class='col-sm-12 form-control-label'>KPI Measure Lagging</label>
                        <div class='col-sm-12 '>
                            <textarea class='form-control wysiwyg' rows="4" class='form-control'  name='KPI_measure_lagging' id='txt-strategic_objectives-KPI_measure_lagging'><?= $strategic_objectives['KPI_measure_lagging'] ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">

                </div>
            </div>


            <?= files_upload("environment", "strategic_objectives", $strategic_objectives['id']); ?>


        </div>
        <div class='modal-footer'>   
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='submit' class='btn btn-secondary waves-effect'>Save</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>

<script>
    CKEDITOR.replace('txt-strategic_objectives-KPI_measure_leading');
    CKEDITOR.replace('txt-strategic_objectives-KPI_measure_lagging');
    CKEDITOR.replace('txt-strategic_objectives-description');
</script>