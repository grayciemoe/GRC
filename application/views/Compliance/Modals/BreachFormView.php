<?php
$breaches = $data['breaches'];
//print_pre($data);
echo form_open("Compliance/breachPost");
$obligation = $data['obligation'];
$start_year = strftime("%Y", strtotime(($data['obligation']['fcp'])));
?>
<input type='hidden' class='form-control'   name='id'  id='txt-control-id' value='<?= $breaches['id'] ?>' placeholder='title' />
<input type='hidden' class='form-control'   name='obligation'  required=''  id='txt-control-title' value='<?= $breaches['obligation'] ?>' placeholder='title' />

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Breached Obligation</h4>
        </div>
        <div class="modal-body">

            <div class='form-group row'>
                <label  for="txt-control-title"  class='col-sm-2 form-control-label'>Title</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control' readonly  name='title' id='txt-control-title' value='<?= $breaches['title'] ?>' placeholder='title' />
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6">

                </div>


            </div>
            <div class='form-group row '>
                <label  for="txt-control-period"  class='col-sm-2 form-control-label'>Year</label>
                <div class='col-sm-10'>

                    <select  class='form-control'name='period' id='txt-control-period' > 
                        <?php for ($i = strftime("%Y", time()); $i >= $start_year; $i--): ?>
                            <option value='detect' <?= $breaches['period'] == '2016' ? "selected='selected'" : NULL; ?> > <?= $i ?> </option>
                        <?php endfor; ?>
                    </select>

                </div>
            </div>
            <?php if ($obligation['frequency'] == 'semi annually') : ?>
                <div class='form-group row '>
                    <label  for="txt-control-period"  class='col-sm-2 form-control-label'>Period</label>
                    <div class='col-sm-10'>

                        <select  class='form-control'name='period' id='txt-control-period' > 
                            <option value='1'> Half 1</option>

                            <option value='2'> Half 2</option>

                        </select>

                    </div>
                </div>
            <?php endif ?>
            <?php if ($obligation['frequency'] == 'quaterly') : ?>
                <div class='form-group row '>
                    <label  for="txt-control-period"  class='col-sm-2 form-control-label'>Period</label>
                    <div class='col-sm-10'>

                        <select  class='form-control'name='period' id='txt-control-period' > 
                            <option value='1'> Q1</option>
                            <option value='2'> Q2</option>
                            <option value='3'> Q3</option>
                            <option value='4'> Q4</option>

                        </select>

                    </div>
                </div>
            <?php endif ?>
            <?php if ($obligation['frequency'] == 'monthly') : ?>
                <div class='form-group row '>
                    <label  for="txt-control-period"  class='col-sm-2 form-control-label'>Period</label>
                    <div class='col-sm-10'>
                        <select  class='form-control'name='period' id='txt-control-period' > 
                            <option value='1'> Jan</option>
                            <option value='2'> Feb</option>
                            <option value='3'> Mar</option>
                            <option value='4'> Apr</option>
                            <option value='5'> May</option>
                            <option value='6'> Jun</option>
                            <option value='7'> Jul</option>
                            <option value='8'> Aug</option>
                            <option value='9'> Sep</option>
                            <option value='10'> Oct</option>
                            <option value='11'> Nov</option>
                            <option value='12'> Dec</option>
                        </select>
                    </div>
                </div>
            <?php endif ?>
            <div class='form-group row'>
                <label  for="txt-control-status"  class='col-sm-2 form-control-label'>Status</label>
                <div class='col-sm-10'>
                    <select  class='form-control'name='status' id='txt-control-status'> 
                        <option value='open' <?= $breaches['status'] == 'open' ? "selected='selected'" : NULL; ?> > Open </option>
                        <option value='closed' <?= $breaches['status'] == 'closed' ? "selected='selected'" : NULL; ?> > Closed </option>
                    </select>
                </div>
            </div>

            <div class='form-group row'>
                <label  for="txt-control-description"  class='col-sm-2 form-control-label'>Description</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg'  name='description' id='txt-control-description' placeholder='description' ><?= $breaches['description'] ?></textarea>
                </div>
            </div>


        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='submit' class='btn btn-secondary waves-effect'>Save</button>
        </div>
    </div>
</div>
<?= form_close(); ?>
<script>
    CKEDITOR.replace('txt-control-description');
</script>