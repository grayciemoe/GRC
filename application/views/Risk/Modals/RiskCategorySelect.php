
<div class="modal-dialog modal-sm">

    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"> Select Risk Category </h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-xs-12">

                    <input type="hidden" name="category" id="txt-riskCat-cat" class="form-control" value="<?= $data['risk']['category'] ?>" />
                    <div class='form-group row'>

                        <select name="" class="form-control" id="txt-category-level-1" onchange="fetchSubCategoryOptions(this.value, 'txt-category-level-2', 1);">
                            <option value=""> Select </option>

                            <?php foreach ($data['categories'] as $key => $value) : ?>
                                <option value="<?= $value['id'] ?>"> <?= $value['title'] ?> </option>

                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class='form-group row'>
                        <select name="" class="form-control" id="txt-category-level-2" onchange="fetchSubCategoryOptions(this.value, 'txt-category-level-3', 2);">

                        </select>
                    </div>
                    <div class='form-group row'>
                        <select name="" class="form-control" id="txt-category-level-3" onchange="document.getElementById('txt-riskCat-cat').value = this.value" >

                        </select>

                    </div>
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type='button' onclick="closeRiskCategoryModal(<?= $data['risk']['id'] ?>)" class='btn btn-secondary waves-effect' >Cancel   </button>
            <button type='button' onclick="selectRiskCategory(<?= $data['risk']['id'] ?>)"  class='btn btn-secondary waves-effect' >Select Category</button>


        </div>

    </div>

</div>
<script>

    function fetchSubCategoryOptions(value, next_id, level) {
        if (level == 1) {
            $("#txt-category-level-2").html("Loading");
            $("#txt-category-level-3").html("");
            $("#txt-category-level-2").attr("disabled", true);
            $("#txt-category-level-3").attr("disabled", true);
        }
        if (level == 2) {
            $("#txt-category-level-3").html("Loading");

            $("#txt-category-level-3").attr("disabled", true);
        }

        $("#txt-riskCat-cat").val(value);
        $.post("<?= base_url("index.php/Risk/fetchCategoryLevelOptions"); ?>/" + value, {data: "data"}, function (response) {
            if (response) {
                $("#" + next_id).html("<option>Select</option>" + response);
                $("#" + next_id).attr("disabled", false);
            } else {
                $("#" + next_id).attr("disabled", true);
                $("#" + next_id).html("<option>No Sub-categories</option>");
            }
            //alert(response);
        })
    }

    function closeRiskCategoryModal(risk_id) {
        ajaxFileModal("<?= base_url("index.php/Risk/riskForm"); ?>/" + risk_id);
    }

    function selectRiskCategory(risk_id) {
        ajaxFileModal("<?= base_url("index.php/Risk/selectRiskCategory"); ?>/" + risk_id + "/" + $("#txt-riskCat-cat").val());
    }


</script>