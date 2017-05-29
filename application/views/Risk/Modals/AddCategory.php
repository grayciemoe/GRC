<?php
$risk_categories = $data['riskCategories'];
//print_pre($risk_categories);
//die();
 ?>
<?= form_open_multipart("Risk/saveCategory") ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"> Add Category</span></h4>
        </div>
        <div class="modal-body">
            <div class='form-group row'>
                    <label  for="txt-riskCategory"  class='col-sm-4 form-control-label'>Title</label>
                    <div class='col-sm-10'>
                      <input type='text' class='form-control'  name='category_title' id='txt-riskCategory' placeholder='Category Title' />
                    </div>
            </div>
            <div class='form-group row'>
                    <label  for="txt-riskCascade"  class='col-sm-4 form-control-label'>Cascaded From</label>
                    <div class='col-sm-10'>
                      <select  name="category" id="txt-risk-category"  class="form-control">
                                <option>SELECT </option>
                                <?php
                                foreach ($risk_categories as $key => $value):
                                    ?>
                                    <option <?= $value['id'] == $value['category'] ? "selected='selected'" : NULL ?> value="<?= $value['id'] ?>"><?= $value['title'] ?> </option>
                                <?php endforeach; ?>
                        </select>
                    </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            <a class="btn btn-danger waves-effect waves-light">Save</a>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>