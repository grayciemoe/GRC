<?php
//$issue = $data['issues'];
// print_pre($data);
// die();
?>
<?= form_open("Risk/postSelectedRisks"); ?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"> Select Issues</h4>
        </div>
        <div class="modal-body">
            <input class="hidden" name="issue" value="<?= $data['issue']['id'] ?>"/> 
            <div class="row">
                <div class="form-group col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon" style="border:none;background-color: none;"><i class="icon icon-magnifier pull-left"></i></span>
                        <input type="search" value="" id="myInput" onkeyup="myFunction();" placeholder="Search" class="form-control" style="border:none; margin: 0;" />
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="btn-group pull-right">
                        <button type='button' class='btn btn-secondary waves-effect btn-sm btn-small' data-dismiss='modal'>Cancel</button>
                        <button type='submit' class='btn btn-secondary waves-effect btn-sm btn-small' >Save Changes</button>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-sm table-small" id="datatable1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Risk Title</th>
                        <th class="text-center">Gross Risk</th>
                        <th class="text-center">Control Ratings</th>
                        <th class="text-center">Net Risk</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach ($data['risks'] as $key => $value):
                        $count++;
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" <?php
                                if (!empty($data['selectedRisks'])) {
                                    if (in_array($value['id'], $data['selectedRisks'])) {
                                        echo "checked";
                                    } else {
                                        echo '';
                                    }
                                }
                                ?> class="m-0" id="issue-<?= $value['id'] ?>" name="risks[]" value="<?= $value['id'] ?>">
                            </td>
                            <td><a  href="<?= base_url("index.php/Risk/risk/{$value['id']}") ?>" > <?= $value['title'] ?> </a></td>
                            <td  class="gross_risk-<?= strtolower(heatmap_key("gross_risk", $value['gross_risk'])) ?>"><span></span> <?= heatmap_key("gross_risk", $value['gross_risk']); ?></td>
                            <td class="control_ratings-<?= strtolower(heatmap_key("control_ratings", $value['control_ratings'])) ?>"><?= heatmap_key("control_ratings", $value['control_ratings']); ?></td>
                            <td class="net_risk-<?= strtolower(heatmap_key("net_risk", $value['net_risk'])) ?>"><?= heatmap_key("net_risk", $value['net_risk']); ?></td>
                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <div class="btn-group pull-right">
                <button type='button' class='btn btn-secondary waves-effect btn-sm btn-small' data-dismiss='modal'>Cancel</button>
                <button type='submit' class='btn btn-secondary waves-effect btn-sm btn-small' >Save Changes</button>
            </div>
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
