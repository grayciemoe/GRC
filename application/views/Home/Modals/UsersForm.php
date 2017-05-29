

<?php
$user = $data['user'];
//print_pre($data); exit;
?>
<?= form_open_multipart("Home/userPost", array('id' => '', 'class' => '')) ?>

<div class="modal-dialog modal-lg">

    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"> user </h4>
        </div>
        <div class="modal-body">
            <input type='hidden' class='form-control'  name='id' id='txt-user-id' value='<?= $user['id'] ?>' />
            <div class='form-group row'>
                <label  for="txt-user-username"  class='col-sm-2 form-control-label'>Username</label>
                <div class='col-sm-10'>
                    <input type='email' class='form-control' <?= ($user['id']) ? "readonly" : NULL ?> name='<?= ($user['id']) ? NULL : "username" ?>' id='txt-user-username' value='<?= $user['username'] ?>' placeholder='Person Email e.g. name@company.com' required/>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-user-names"  class='col-sm-2 form-control-label'>Names</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='names' id='txt-user-names' value='<?= $user['names'] ?>' placeholder='Full Names' required/>
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-user-phone"  class='col-sm-2 form-control-label'>Phone</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='phone' id='txt-user-phone' value='<?= $user['phone'] ?>' placeholder='+254 --- --- ---' />
                </div>
            </div>
            
            <div class='form-group row'>
                <label  for="txt-user-user_type"  class='col-sm-2 form-control-label'>User Type</label>
                <div class='col-sm-10'>
                    <select  class='form-control' required name='user_type' id='txt-user-user_type' onchange="sel_corporate(this.value)" >
                        <option value=''>SELECT</option>
                        <?php foreach ($data['user_types'] as $key => $value): ?>    
                        <option value="<?= $value['id'] ?>" <?= $value['id'] == $user['user_type'] ? "selected='selected'" : NULL ?>><?= $value['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class='form-group row corporate_sel'>
                <label  for="txt-user-corporate"  class='col-sm-2 form-control-label'>Corporate</label>
                <div class='col-sm-10'>
                    <select  class='form-control corp_user_sel' name='corporate' id='txt-user-corporate' >
                        <option value=''>SELECT</option>
                        <?php foreach ($data['corporates'] as $key => $value): ?>    
                            <option value="<?= $value['id'] ?>" <?= $value['id'] == $user['corporate'] ? "selected='selected'" : NULL ?>><?= $value['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            <button type="submit" class='btn btn-secondary waves-effect'><i class='fa fa-save'></i> Save </button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
    $(document).ready(function () {
        sel_corporate("<?= $user['user_type'] ?>");
    });
    
    function sel_corporate(corp){
        if(corp == 6 || corp == 2){
            $('.corp_user_sel').attr('required', true);
            $('.corporate_sel').show('fast');
            
        }else{
            $('.corp_user_sel').attr('required', false);
            $('.corporate_sel').hide('fast');
        }
    }
</script>
<?= form_close(); ?>

