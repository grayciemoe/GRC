<?php
$audit_area = $data['audit_area'];
// print_pre($data); exit;
?>
<?= form_open_multipart('Audit/auditAreaPost', array('id' => 'AuditAreaForm', 'class' => '', 'onsubmit' => "saveAuditArea('AuditAreaForm'); return false; ")) ?>
<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <?php if (isset($data['ref_form']) && $data['ref_form'] == "audit"): ?>
                <a class='close' href="<?= base_url('index.php/Audit/auditForm/' . $data['ref_id'] . '/' . $data['corpId']) ?>" <?= MODAL_AJAX ?> data-dismiss='modal' aria-hidden='true'>×</a>
            <?php elseif (isset($data['ref_form']) && $data['ref_form'] == "issue") : ?>
                <a class='close' href="<?= base_url('index.php/Audit/auditForm/' . $data['auditissue'] . '/' . $data['corpId']) ?>" <?= MODAL_AJAX ?> data-dismiss='modal' aria-hidden='true'>×</a>
            <?php else : ?>
                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
<?php endif; ?>

            <h4 class='modal-title' id='myModalLabel'> Audit Area </h4>
        </div>
        <div class='modal-body'>
<?php if ($data['message']): ?>
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">                

                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="text-center"><?= $data['message']; ?></div>
                </div>
<?php endif; ?>
            <input type='hidden' class='form-control'  name='corporate' id='txt-audit_area-id' value='<?= $data['corpId'] ?>' />
            <input type='hidden' class='form-control audit_area'  name='id' id='txt-audit_area-id' value='<?= $audit_area['id'] ?>' />
            <input class='form-control hidden'  name='ref_id' id='txt-audit_area-ref_id' value='<?php if (!empty($data['ref_id'])) {
    echo $data['ref_id'];
} else {
    echo "";
} ?>' />
            <input class='form-control hidden'  name='ref_form' id='txt-audit_area-ref_form' value='<?php if (!empty($data['ref_form'])) {
    echo $data['ref_form'];
} else {
    echo "";
} ?>' />
            <div class='form-group row'>

                <label  for="txt-audit_area-title"  class='col-sm-2 form-control-label'>Title</label>
                <div class="col-sm-10">
                    <input type='text' class='form-control'   name='title'  required=''  id='txt-audit_area-title' value='<?= $audit_area['title'] ?>' placeholder='title' />
                </div>
            </div>

        </div>
<?php //  endif;  ?>
        <div class='modal-footer'>
            <button type='submit' class='btn btn-secondary waves-effect'>Save Audit Area</button>
        </div>
        <hr class="m-0">
        <div class='modal-body'>
<?php //print_pre($data['audit_area']);   ?>
            <table class="table table-striped table-sm table-small">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Title</th>
                        <th>Audit</th>
                        <th>Issue</th>
                        <th style="width:100px;"></th> 

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach ($data['audit_areas'] as $key => $value) :
                        $count++;
                        if (($value['audit_count'] == 0) && ($value['issue_count'] == 0)) {
                            $disabled = "";
                        } else {
                            $disabled = "disabled";
                        }
                        ?>
                        <tr>
                            <td ><?= $count; ?></td>
                            <td><strong><?= ucwords(strtolower($value['title'])) ?></strong></td>
                            <td><span class="label label-success"> <?= $value['audit_count']?> </span></td>
                            <td><span class="label label-info"> <?= $value['issue_count']?> </span></td>


                            <td class="text-right">
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= base_url("index.php/Audit/auditAreaForm/{$value['id']}/{$value['corporate']}"); ?>" <?= MODAL_AJAX ?> class="btn btn-secondary waves-effect waves-light"><i class="icon icon-pencil"></i></a>

                                    <a href="<?= base_url("index.php/Audit/auditAreaDelete/{$value['id']}"); ?>" <?= MODAL_AJAX ?> class="btn btn-secondary waves-effect waves-light <?= $disabled ?>"><i class="icon icon-trash"></i></a>


                                </div>
                            </td>
                        </tr>
            <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class='modal-footer'>
<?php if (isset($data['ref_form']) && $data['ref_form'] == "audit"): ?>
                <a class='btn btn-secondary waves-effect' href="<?= base_url('index.php/Audit/auditForm/' . $data['ref_id'] . '/' . $data['corpId']) ?>" <?= MODAL_AJAX ?> data-dismiss='modal'>Close</a>
<?php elseif (isset($data['ref_form']) && $data['ref_form'] == "issue") : ?>
                <a class='btn btn-secondary waves-effect' href="<?php echo base_url('index.php/Audit/auditForm/' . $data['auditissue'] . '/' . $data['corpId']) ?>" <?= MODAL_AJAX ?> data-dismiss='modal'>Close</a>
<?php else : ?>
                <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
<?php endif; ?>
        </div>
        <!-- /.modal-content -->
    </div>


</div><!-- /.modal-dialog -->
<?= form_close(); ?>
<script>

    CKEDITOR.replace('txt-audit_area-description');


    function saveAuditArea(formId) {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }


        var url = ($("#" + formId).attr("action"));
        $(".modal-footer").html("<h3 class='text-muted'><i class='fa fa-spin fa-spinner'></i> loading ....</h3>");
        $(".modal-footer").addClass("text-center");

        $.post(url, $("#" + formId).serialize(), function (response) {
//            alert(response);
            //modalRequest();
            document.getElementById(formId).reset();
            $("#uploan_modal").html(response);
        });
    }

</script>