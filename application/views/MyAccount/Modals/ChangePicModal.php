<?php
echo form_open_multipart("Account/updateProfilePic");
$user = $data['user'];
?>
<input type="hidden" name="id" value="<?= $user['id'] ?>">
<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Change Profile Picture</h4>
        </div>
        <div class="modal-body">
            <div class="row">

                <div class="col-sm-12">
                    <div class="thumbnail">


                        <img src="<?= $user['profile_pic'] ? img_src($user['profile_pic']) : base_url("//assets/img/avatars/user.jpg") ?>" class="img-responsive" id="p_pic_preview" style="width: 100%" />
                        <div class="form-group">

                            <div class="col-xs-12">
                                <br>
                                <input type="file" class="form-control" onchange="readURL(this, 'p_pic_preview')" id="file-p_pic" name="profile_pic">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">


                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>