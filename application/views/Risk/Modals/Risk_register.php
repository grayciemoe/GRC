
<div class="container">


    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <


    <?= form_open_multipart("", array('id' => '', 'class' => '')) ?>

    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                <h4 class='modal-title' id='myModalLabel'> Risk Register </h4>
            </div>
            <div class='modal-body'>
                <input type='hidden' class='form-control'  name='id' id='txt-risk_register-id' value='<?= $risk_register['id'] ?>' />
                <div class='form-group row'>
                    <label  for="txt-risk_register-environment"  class='col-sm-2 form-control-label'>Environment</label>
                    <div class='col-sm-10'>
                        <input type='number' class='form-control'  name='environment' id='txt-risk_register-environment' value='<?= $risk_register['environment'] ?>' placeholder='environment' />
                    </div>
                </div>
                <div class='form-group row'>
                    <label  for="txt-risk_register-user"  class='col-sm-2 form-control-label'>User</label>
                    <div class='col-sm-10'>
                        <input type='number' class='form-control'  name='user' id='txt-risk_register-user' value='<?= $risk_register['user'] ?>' placeholder='user' />
                    </div>
                </div>
                <div class='form-group row'>
                    <label  for="txt-risk_register-ref_code"  class='col-sm-2 form-control-label'>Ref Code</label>
                    <div class='col-sm-10'>
                        <input type='text' class='form-control'  name='ref_code' id='txt-risk_register-ref_code' value='<?= $risk_register['ref_code'] ?>' placeholder='ref_code' />
                    </div>
                </div>
                <div class='form-group row'>
                    <label  for="txt-risk_register-title"  class='col-sm-2 form-control-label'>Title</label>
                    <div class='col-sm-10'>
                        <input type='text' class='form-control'   name='title'  required=''  id='txt-risk_register-title' value='<?= $risk_register['title'] ?>' placeholder='title' />
                    </div>
                </div>
                <div class='form-group row'>
                    <label  for="txt-risk_register-associated_business_goals"  class='col-sm-2 form-control-label'>Associated Business Goals</label>
                    <div class='col-sm-10'>
                        <textarea class='form-control wysiwyg'  name='associated_business_goals' id='txt-risk_register-associated_business_goals' placeholder='associated_business_goals' ><?= $risk_register['associated_business_goals'] ?></textarea>
                    </div>
                </div>
                <div class='form-group row'>
                    <label  for="txt-risk_register-description"  class='col-sm-2 form-control-label'>Description</label>
                    <div class='col-sm-10'>
                        <textarea class='form-control wysiwyg'  name='description' id='txt-risk_register-description' placeholder='description' ><?= $risk_register['description'] ?></textarea>
                    </div>
                </div>
                <div class='form-group row'>
                    <label  for="txt-risk_register-category"  class='col-sm-2 form-control-label'>Category</label>
                    <div class='col-sm-10'>
                        <select  class='form-control'name='category' id='txt-risk_register-category'> 
                            <option value='financial' <?= $risk_register['category'] == 'financial' ? "selected='selected'" : NULL; ?> > Financial </option>
                            <option value='operational' <?= $risk_register['category'] == 'operational' ? "selected='selected'" : NULL; ?> > Operational </option>
                            <option value='strategic' <?= $risk_register['category'] == 'strategic' ? "selected='selected'" : NULL; ?> > Strategic </option>
                            <option value='other' <?= $risk_register['category'] == 'other' ? "selected='selected'" : NULL; ?> > Other </option>
                        </select>
                    </div>
                </div>
                <div class='form-group row'>
                    <label  for="txt-risk_register-published"  class='col-sm-2 form-control-label'>Published</label>
                    <div class='col-sm-10'>
                    </div>
                </div>
                <div class='form-group row'>
                    <label  for="txt-risk_register-draft"  class='col-sm-2 form-control-label'>Draft</label>
                    <div class='col-sm-10'>
                        <input type='number' class='form-control'  name='draft' id='txt-risk_register-draft' value='<?= $risk_register['draft'] ?>' placeholder='draft' />
                    </div>
                </div>
                <div class='form-group row'>
                    <label  for="txt-risk_register-delete"  class='col-sm-2 form-control-label'>Delete</label>
                    <div class='col-sm-10'>
                    </div>
                </div>



            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    <?= form_close(); ?>