
<?php $incident_category = $data['incident_category']; ?>
<?= form_open_multipart("IncidentManagement/incidentCategoryPost", array('id' => 'incidentCategoryForm',
    'class' => '', 'onsubmit' => "saveControlCategory('incidentCategoryForm'); return false; "))
?>
<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <a href="" class='close' aria-hidden='true'>×</a>
            <h4 class='modal-title' id='myModalLabel'> Incident Category </h4>
        </div>
        <div class='modal-body'>

            <div class="alert alert-success hidden" id="im_modal_response_message">

            </div>
            <input type='hidden' class='form-control'  name='id' id='txt-incident_category-id' value='<?= $incident_category['id'] ?>' />
            <div class='form-group row'>
                <label  for="txt-incident_category-title"  class= 'col-sm-2 form-control-label'>Title</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'   name='title'  required=''  id='txt-incident_category-title' value='<?= $incident_category['title'] ?>' placeholder='title' />
                </div>
            </div>
            <div class='form-group row'>
                <label  for="txt-incident_category-description"  class='col-sm-2 form-control-label'>Description</label>
                <div class='col-sm-10'>
                    <textarea class='form-control wysiwyg'  name='description' id='txt-incident_category-description' placeholder='description' ><?= $incident_category['description'] ?></textarea>
                </div>
            </div>
        </div>

        <div class='modal-footer'>
            <button type='submit' class='btn btn-secondary waves-effect'>Save Category</button>
        </div>
        <hr class="m-0">
        <div class='modal-body'>
<?php // print_pre($data['incident_categories']);   ?>
            <table class="table table-striped table-sm table-small">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Title</th>
                        <th class="text-right">Incidents</th> 
                        <th style="width:100px;"></th> 

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach ($data['incident_categories'] as $key => $value) :
                        $count++;
                        ?>
                        <tr>
                            <td ><?= $count; ?></td>
                            <td><strong><?= $value['title'] ?></strong></td>
                            <td class="text-right"><?= count($value['incidents']) ?></td>
                            <td class="text-right">
                                <div class="btn-group btn-group-sm">

                                    <a href="<?= base_url("index.php/IncidentManagement/incidentCateogoryForm/{$value['id']}"); ?>" <?= MODAL_AJAX ?> class="btn btn-secondary waves-effect waves-light"><i class="icon icon-pencil"></i></a>

                                    <?php if (count($value['incidents']) == 0): ?>
                                        <a href="<?= base_url("index.php/IncidentManagement/incidentCategoryDelete/{$value['id']}"); ?>" <?= MODAL_AJAX ?> class="btn btn-secondary waves-effect waves-light"><i class="icon icon-trash"></i></a>
    <?php endif; ?>

                                </div>
                            </td>
                        </tr>
<?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class='modal-footer'>
            <a href="" class='btn btn-secondary waves-effect'>Close</a>
        </div>
        <!-- /.modal-content -->
    </div>


</div><!-- /.modal-dialog -->
<?= form_close(); ?>
<script>

    CKEDITOR.replace('txt-incident_category-description');


    function saveControlCategory(formId) {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }


        $('#im_modal_response_message').html("Saving Data...");
        $('#im_modal_response_message').removeClass('hidden');//("Saving Data...");

        $(".modal-footer").html("<h3 class='text-muted'><i class='fa fa-spin fa-spinner'></i> loading ... .</h3>");
        $(".modal-footer").addClass("text-center");

        var url = ($("#" + formId).attr("action"));
        $.post(url,
                $("#" + formId).serialize(),
                function (response) {
                    document.getElementById(formId).reset();
                    $("#uploan_modal").html(response);
                    $('#im_modal_response_message').html("Changes Saved");
                    setTimeout(function () {
                        //alert("lkinja");
                        $('#im_modal_response_message').addClass('hidden');
                    }, 3000);
                });
    }

</script>