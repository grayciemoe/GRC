<?= form_open_multipart("Risk/riskProposePost", array('id' => 'GRC_RISK_FORM', 'class' => '', 'onsubmit' => 'submitRisk(); return false')) ?>
<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header bg-faded'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Propose Risk </h4>
        </div>
        <div class='modal-body' >
            <?php // print_pre($data);?>

            <?php if (count($data['category']) == 0): ?>
                <div class="alert alert-danger">
                    <h4>No Category Selected</h4>
                    <p>Please select a category in order to propose a risk</p>
                </div>
            <?php else: ?>
                <input type='hidden' class='form-control' name='category'  required='' id='txt-risk-category' value='<?= $data['category']['id'] ?>' placeholder='title' />
                <div class='form-group row'>
                    <label  for="txt-risk-title"  class='col-sm-3 form-control-label'>Risk Title</label>
                    <div class='col-sm-12'>
                        <input type='text' class='form-control' name='title'  required='' id='txt-risk-title' value='' placeholder='title' />
                    </div>
                </div>
                <div class='form-group row'>
                    <label  for="txt-risk-description"  class='col-sm-3 form-control-label'>Description</label>
                    <div class='col-sm-12'>
                        <textarea class='form-control wysiwyg' rows="5" name='description' id='txt-risk-description' placeholder='description' ></textarea>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class='modal-footer'>


            <?php if (count($data['category']) == 0): ?>
            <?php else: ?>
                <div class="btn-group">
                    <button type='button' class='btn btn-secondary waves-effect' id="dismiss_modal" data-dismiss="modal">Cancel</button>
                    <button type='submit' class='btn btn-secondary waves-effect' >Save</button>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div><!-- /.modal-content -->
<?= form_close(); ?>


<script>
    /**
     * sub_category_level_1
     */
    function submitRisk() {
        $("#txt-im-risk").html("<option>Loading...</option>");
        var url = "<?= base_url("index.php/Risk/riskProposePost") ?>";
        $.post(url, {
            title: $("#txt-risk-title").val(),
            description: $("#txt-risk-description").val(),
            category: $("#txt-risk-category").val(),
        }, function (response) {
            //alert(response);
            $("#cover-risk-dropdown").hide('fast');// ('remove');
            $('#action_risk_label').val($("#txt-risk-title").val());
            $('#action_risk_label').removeClass('hidden');
            $("#actual_risk_id").val(response);
            document.getElementById('actual_risk_id').value = response;
            $('#dismiss_modal').click();
        })
    }


</script>