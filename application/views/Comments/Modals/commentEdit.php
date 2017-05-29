<?php
$comment = $data;
echo form_open('Comments/commentEditPost', array('id' => "form-{$comment['module']}-{$comment['table_name']}-{$comment['record_id']}", 'class' => '')); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Edit Comment</h4>
        </div>
        <div class='card'>
            <div class='card-block'>
                <input type='hidden' class='form-control'  name='parent' id='txt-g_comments-parent' value='<?= $comment['parent'] ?>' />
                <input type='hidden' class='form-control'  name='module' id='txt-g_comments-module' value='<?= $comment['module'] ?>' />
                <input type='hidden' class='form-control'  name='table_name' id='txt-g_comments-table_name' value='<?= $comment['table_name'] ?>' />
                <input type='hidden' class='form-control'  name='record_id' id='txt-g_comments-record_id' value='<?= $comment['record_id'] ?>' />
                <input type='hidden' class='form-control'  name='user' id='txt-g_comments-record_id' value='<?= $comment['user'] ?>' />
                <input type='hidden' class='form-control'  name='id' id='txt-g_comments-record_id' value='<?= $comment['id'] ?>' />
                <div class='form-group row'>
                    <label  for='txt-g_comments-comment'  class='col-sm-2 form-control-label'>Comment</label>
                    <div class='col-sm-12'>
                        <textarea class='form-control noresize' rows='2'  name='comment' id='txt-g_comments-comment' placeholder='Make A Comment' ><?= $comment['comment'] ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="btn-group">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type='submit' onclick="reloadPage()" class='btn btn-info-outline waves-effect waves-light pull-right'><i class='icon icon-speech'></i> Post</button>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
    CKEDITOR.replace('txt-g_comments-comment');
</script>
<?= form_close(); ?>
