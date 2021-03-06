<?php
if (!am_user_type(array(1, 9, 6, 5))) {
    restricted_view();
    return false;
}
?><?php
$obligations = $data['obligations'];
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-light">
            <?php if (am_user_type(array(1, 5))): ?>
                <a href="<?= base_url("index.php/Compliance/complianceRequirementForm/0/{$data['type']}") ?>" 
                   accesskey=""<?= MODAL_LINK ?> 
                   class="btn btn-secondary btn-sm btn-small pull-right">
                    <i class="icon icon-plus"></i> New Compliance Requirement
                </a>
            <?php endif; ?>
            <h4 class="card-title"><?= $data['type'] ?></h4>
        </div>
        <div class="card-block">
            <?= form_open_multipart("Compliance/obligations_filter", array("id" => "frm_obligations_filter", "class" => null)); ?>
            <div class="row">
                <div class="col-sm-4">
                    <div class="row">

                        <!--
                        "compliance_requirement_type" = 'Statutory Returns','Legal / Regulatory Requirements','Business Compliance Requirements'
                        -->
                        <input type="hidden" value="<?= $data['type'] ?>" name="compliance_requirement_type" />
                        <div class="col-sm-6">
                            <div class="form-group" style="">
                                <label class="control-label" form="txt-filter-register">Registers</label>
                                <select name="register" id="txt-filter-register" onchange="obligations_filter()" class="form-control form-control-sm">
                                    <option value="0">Select Register</option>
                                    <?php foreach ($data['registers'] as $key => $value): ?>
                                        <option value="<?= $value['id'] ?>"><?= $value['title'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" form="txt-filter-compliance_requirements">Compliance Requirements</label>
                                <select name="compliance_requirements" id="txt-filter-compliance_requirements" onchange="obligations_filter()" class="form-control form-control-sm">
                                    <option value="0">Select Compliance requirement</option>
                                    <?php foreach ($data['compliance_requirements'] as $key => $value): ?>
                                        <option value="<?= $value['id'] ?>"><?= $value['title'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-sm-offset-3 ">
                    <?php
                    $period_names = array(
                        '' => "Select Frequency",
                        'annually' => null,
                        'semi annually' => "Half",
                        'quarterly' => "Quarter",
                        'monthly' => null,
                            /*
                              'weekly' => null,
                              'daily' => null
                             */
                    );
                    $months = array(null, "jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec");
                    ?>
                    <div class="row">

                        <div class="col-sm-4">
                            <div class="form-group" style="">
                                <label class="control-label" for="txt-filter-frequency">Frequency</label>
                                <select name="frequency" id="txt-filter-frequency" onchange="obligations_filter()" class="form-control form-control-sm">

                                    <?php foreach ($period_names as $key => $value): ?>
                                        <option value="<?= $key ?>"><?= $key ? ucwords(str_replace("_", " ", $key)) : $value ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="" class="control-label">Start Date</label>
                                <input type="date" class="form-control form-control-sm" onchange="obligations_filter()" id="txt-filter-start" name="start" placeholder="start-period" />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="" class="control-label">End Date</label>
                                <input type="date" class="form-control form-control-sm" onchange="obligations_filter()" id="txt-filter-end" name="end" placeholder="start-period" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
    <div class="" id="obligations_filter_list">

    </div>
</div>
<script>

    $(document).ready(function () {
        obligations_filter();
        //  frequency_filter($("#txt-filter-frequency").val());

//        $('#datatable').DataTable();
//        //Buttons examples
//        var table = $('#datatable-buttons').DataTable({
//            lengthChange: false,
//            buttons: ['copy', 'excel', 'pdf', 'colvis'],
//            "columnDefs": [
//                {"visible": false, "targets": [0, 4, 5, 6, 7, 8, 11, 13, 14]}
//            ]
//        });
//
//        table.buttons().container()
//                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');    
    });

    function frequency_filter(value) {
        $('.filter-period').addClass('hidden');
        $('#period-' + value).removeClass('hidden');
        $('#txt-filter-period').focus();
        obligations_filter();
    }



    function obligations_filter() {
        //alert("kinja");
        var url = $("#frm_obligations_filter").attr("action");
        $.post(url, $("#frm_obligations_filter").serialize(), function (response) {
            $("#obligations_filter_list").html(response);
        });
        //setTimeout((function(){obligations_filter();}),1000);
    }

</script>

