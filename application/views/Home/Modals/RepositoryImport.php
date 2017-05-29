<?= form_open_multipart("Home/repositoryImportPost", array('id' => '', 'class' => '')) ?>
<input type="hidden" name="environment" value="<?= $data['unit']['id'] ?>" />
<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Repository / Key Risk Area Pool</h4>
        </div>
        <div class='modal-body'>
            <?php if (count($data['pool']) == 0): ?>
                <div class="text-center text-muted"><h2  class="text-muted">All items in the pool already exists in this unit</h2></div>
            <?php else: ?>
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon icon-magnifier"></i></span>
                    <input type="search" onkeyup="myFunction()" value="" id="myInput" placeholder="Search" class="form-control" />
                </div>
                <table id="datatable1" class="table table-sm table-small table-striped">
                    <thead>
                        <tr>
                            <th style="width:40px"></th>
                            <th>Name</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        foreach ($data['pool'] as $key => $value):

                            $count++;
                            ?>
                            <tr>
                                <td><input type="checkbox"  class="" id="pool-<?= $value['id'] ?>" name="pool[]" value="<?= $value['id'] ?>" /></td>
                                <td onclick="document.getElementById('pool-<?= $value['id'] ?>').click()"><label class="control-label"  ><?= $value['name'] ?></label></td>
                                <td onclick="document.getElementById('pool-<?= $value['id'] ?>').click()"><label class="control-label"><?= ucwords(str_replace("_", " ", $value['source'])) ?></label></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php endif; ?>
        </div>
        <div class='modal-footer'>   
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='submit' class='btn btn-secondary waves-effect'>Import </button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script type="text/javascript">
    function myFunction() {
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

