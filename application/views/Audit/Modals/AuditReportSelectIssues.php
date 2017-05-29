<?= form_open("Audit/setIssuesInReport", array('id' => '', 'class' => '')) ?>
<?php
// print_pre($data); exit();
?>
<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Select Issues to Include in Report </h4>
        </div>
        <div class='modal-body'>
            <?php if(empty($data['issues'])): ?>
            <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h2 class="text-center">No issues are available to publish to Board</h2>
                    <p class="text-center">Please check if there are issues published to CEO</p>
                    <a href="<?= base_url('index.php/audit/publishSelected/' . $data['audit']['id'].'/ceo') ?>" <?= MODAL_AJAX ?> class="btn btn-block btn-info-outline" ><i  class="icon icon-login"></i> Check Issues published to CEO</a>
                </div>
            <?php else: ?>
            <input type='hidden' class='form-control'  name='audit' id='txt-risk_analysis-id' value='<?= $data['audit']['id'] ?>' />
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
                        <th></th>
                        <th>Issue Title</th>
                        <th>Issue Owner</th>
                        <th>Audit Area</th>
                        <th>Issue Rating</th>
                        <th>Issue Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['issues'] as $key => $value): ?>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" <?= in_array($value['id'], $data['published_issues_Id']) ? "checked" : NULL ?> class="m-0" id="risk-<?= $value['id'] ?>" name="issues[]" value="<?= $value['id'] ?>">
                            </td>
                            <td><label  class="m-0" for="risk-<?= $value['id'] ?>"><?= $value['title'] ?></label></td>
                            <td><?= $data['issue_owner']['names'] ?></td>
                            <td><?= $value['audit_area']['title']?></td>
                            <td>
                                <?php
                                if ($value['issue_rating'] == 'Low') {
                                    echo '<span class="label label-pill label-primary">';
                                } elseif ($value['issue_rating'] == 'Moderate') {
                                    echo '<span class="label label-pill label-warning">';
                                } elseif ($value['issue_rating'] == 'High') {
                                    echo '<span class="label label-pill label-danger">';
                                } else {
                                    echo '<span class="label label-pill label-danger">';
                                }
                                ?>
                                <?= $value['issue_rating'] ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                if ($value['issue_status'] == 'Open') {
                                    echo '<span class="label label-pill label-danger">';
                                } elseif ($value['issue_status'] == 'Closed') {
                                    echo '<span class="label label-pill label-info">';
                                } else {
                                    
                                }
                                ?>
                                <?= $value['issue_status'] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
            
        </div>
        <div class='modal-footer'>
            <div class="btn-group">
                <button type='button' class='btn btn-secondary waves-effect btn-sm btn-small' data-dismiss='modal'>Cancel</button>
                <button type='submit' class='btn btn-secondary waves-effect btn-sm btn-small'>Save Changes</button>
            </div>
        </div>
        <?php endif; ?>
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