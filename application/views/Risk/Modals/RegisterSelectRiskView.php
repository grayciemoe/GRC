<?= form_open_multipart("Risk/setRegisterRisks", array('id' => '', 'class' => '')) ?>
<?php
// prin
?>
<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Select Risks  </h4>
        </div>
        <div class='modal-body'>
            <?php
            // print_pre($data);
            ?>
            <input type='hidden' class='form-control'  name='risk_register' id='txt-risk_analysis-id' value='<?= $data['register'] ?>' />

            <table class="table table-striped table-sm table-small" id="datatable1">
                <thead>
                    <tr>
                        <th style="width:40px;" class="text-center"><i class="icon icon-magnifier fa-2x"></i></th>
                        <th>
                            <div class="row">
                                <div class="col-sm-9">
                                    <input type="search" value="" id="myInput" onkeyup="myFunction();" placeholder="Search" class="form-control" style="border:none; margin: 0;" />
                                </div>
                                <div class="col-sm-3">
                                    <div class="btn-group pull-right">
                                        <button type='button' class='btn btn-secondary waves-effect btn-sm btn-small' data-dismiss='modal'>Cancel</button>
                                        <button type='submit' class='btn btn-secondary waves-effect btn-sm btn-small' >Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php //print_pre($data['risks_ids']);?>
                    <?php foreach ($data['risks'] as $key => $value): ?>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" <?= in_array($value['id'], $data['risks_ids']) ? "checked" : NULL ?> class="m-0" id="risk-<?= $value['id'] ?>" name="risks[]" value="<?= $value['id'] ?>">
                            </td>
                            <td><label  class="m-0" for="risk-<?= $value['id'] ?>"><?= $value['title'] ?></label></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='submit' class='btn btn-secondary waves-effect' >Save</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script type="text/javascript">
    function myFunction() {//alert("me");
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("datatable1");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";

                }
            }
        }
    }
</script>

<?= form_close(); ?>