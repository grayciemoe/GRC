
<?php $control_category = $data['control_category']; ?>
<?= form_open_multipart("Risk/controlCategoryPost", array('id' => 'controlCategoryForm', 'class' => '', 'onsubmit' => "saveControlCategory('controlCategoryForm'); return false; ")) ?>
<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Control Category </h4>
        </div>
        <?php if (am_user_type(array(1, 5))): ?>
            <div class='modal-body'>
                <?php if (true): ?>
                    <div class="alert alert-warning alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <div class="text-center"><?= $data['message']; ?></div>
                    </div>
                <?php endif; ?>
                <input type='hidden' class='form-control'  name='id' id='txt-control_category-id' value='<?= $control_category['id'] ?>' />
                <div class='form-group row'>
                    <label  for="txt-control_category-title"  class='col-sm-2 form-control-label'>Title</label>
                    <div class='col-sm-10'>
                        <input type='text' class='form-control'   name='title'  required=''  id='txt-control_category-title' value='<?= $control_category['title'] ?>' placeholder='title' />
                    </div>
                </div>
                <div class='form-group row'>
                    <label  for="txt-control_category-description"  class='col-sm-2 form-control-label'>Description</label>
                    <div class='col-sm-10'>
                        <textarea class='form-control wysiwyg'  name='description' id='txt-control_category-description' placeholder='description' ><?= $control_category['description'] ?></textarea>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class='modal-footer'>
            <button type='submit' class='btn btn-secondary waves-effect'>Save Category</button>
        </div>
        <hr class="m-0">
        <div class='modal-body'>
            <?php // print_pre($data['control_categories']);  ?>
            <table class="table table-striped table-sm table-small">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Title</th>

                        <th style="width:100px;"></th> 

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach ($data['control_categories'] as $key => $value) :
                        $count++;
                        ?>
                        <tr>
                            <td ><?= $count; ?></td>
                            <td><strong><?= $value['title'] ?></strong></td>


                            <td class="text-right">
                                <div class="btn-group btn-group-sm">
                                    <?php if (am_user_type(array(1, 5))): ?>
                                        <a href="<?= base_url("index.php/Risk/controlCateogoryForm/{$value['id']}"); ?>" <?= MODAL_AJAX ?> class="btn btn-secondary waves-effect waves-light"><i class="icon icon-pencil"></i></a>
                                    <?php endif; ?>
                                    <?php if (am_user_type(array(1, 5))): ?>
                                        <a href="<?= base_url("index.php/Risk/controlCategoryDelete/{$value['id']}"); ?>" <?= MODAL_AJAX ?> class="btn btn-secondary waves-effect waves-light"><i class="icon icon-trash"></i></a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
        </div>
        <!-- /.modal-content -->
    </div>


</div><!-- /.modal-dialog -->
<?= form_close(); ?>
<script>

    CKEDITOR.replace('txt-control_category-description');


    function saveControlCategory(formId) {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }


        var url = ($("#" + formId).attr("action"));
        $(".modal-footer").html("<h3 class='text-muted'><i class='fa fa-spin fa-spinner'></i> loading ... .</h3>");
        $(".modal-footer").addClass("text-center");

        $.post(url, $("#" + formId).serialize(), function (response) {
            //alert(response);
            //modalRequest();
            document.getElementById(formId).reset();
            $("#uploan_modal").html(response);
        });
    }

</script>