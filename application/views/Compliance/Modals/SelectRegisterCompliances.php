<?= form_open_multipart("Compliance/setRegisterCompliances", array('id' => '', 'class' => '')) ?>

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Select Compliance Requirements  </h4>
        </div>
        <div class='modal-body'>
            <input type='hidden' class='form-control'  name='compliance_register' id='txt-risk_analysis-id' value='<?= $data['register']['id'] ?>' />

            <table class="table table-striped table-sm table-small" id="datatable1">
                <thead>
                    <tr>
                        <th style="width:40px;" class="text-center"><i class="icon icon-magnifier fa-2x"></i></th>
                        <th>
                            <div class="row">
                                <div class="col-sm-9">
                                    <input type="search" value="" onkeyup="myFunction()" id="myInput" placeholder="Search" class="form-control" style="border:none; margin: 0;" />
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
                    <?php foreach ($data['compliance_requirements'] as $key => $value): ?>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" <?= in_array($value['id'], $data['list']) ? "checked" : NULL ?> class="m-0" id="compliance_requirements-<?= $value['id'] ?>" name="compliance_requirements[]" value="<?= $value['id'] ?>">
                            </td>
                            <td><label  class="m-0" for="compliance_requirements-<?= $value['id'] ?>"><?= $value['title'] ?></label></td>
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