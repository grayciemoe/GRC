<?php $risk_category = $data['category'];?>
<?= form_open_multipart("Risk/categoryPost", array('id' => '', 'class' => '')) ?>

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <?php if($risk_category['level_1'] > 0): ?>
            <h4 class='modal-title' id='myModalLabel'> Add Risk Sub Category </h4>
            <?php else :?>
            <h4 class='modal-title' id='myModalLabel'>Add Risk Category </h4>
            <?php endif;?>
        </div>
        <div class='modal-body'>
            <input type='hidden' class='form-control'  name='id' id='txt-risk_category-id' value='<?= $risk_category['id'] ?>' />
            <div class='form-group row'>
                <label  for="txt-risk_category-title"  class='col-sm-2 form-control-label'>Title</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'   name='title'  required=''  id='txt-risk_category-title' value='<?= $risk_category['title'] ?>' placeholder='Category Title/Name' required/>
                </div>
            </div>
        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Cancel</button>
            <button type='submit' class='btn btn-secondary waves-effect'>Save </button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>