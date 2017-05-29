<?php
if (!am_user_type(array(1, 9, 6, 5))) {
    restricted_view();
    return false;
}
?><?php
$obligations = $data['obligations'];

//print_pre($obligations);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3">

            <?= form_open("Compliance/report_filter", array("id" => "form_report_filter", "class" => NULL)) ?>
            <input type="hidden" name="active_view" value="obligatonsChartReportView" id="txt-active_view" />
            
            <div class="card collapse-grc ">
                <div class="card-block">
                    <a href="#" data-target="#card_obligations" class="card-title h5 link collapse-cmd">
                        Compliance Requirement Type
                        <div class="pull-right " id="card_obligations_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_obligations">
                        <hr>
                        <?php
                        $types = array('Statutory Returns', 'Legal / Regulatory Requirements', 'Business Compliance Requirements');
                        foreach ($types as $key => $value):
                            ?>
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox_cr_type_<?= $key ?>" type="checkbox"  name="compliance_requirement_type[]" value="<?= $value ?>" onchange="report_filter();"  />
                                <label for="checkbox_cr_type_<?= $key ?>">
                                    <?= $value; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="card collapse-grc ">
                <div class="card-block">
                    <a href="#" data-target="#card_frequency" class="card-title h5 link collapse-cmd">
                        Frequency
                        <div class="pull-right " id="card_frequency_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_frequency">
                        <hr>
                        <?php
                        $types = array('annually', 'semi annually', 'quarterly', 'monthly');
                        foreach ($types as $key => $value):
                            ?>
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox_frequency_<?= $key ?>" type="checkbox"  name="frequency[]" value="<?= $value ?>" onchange="report_filter();"  >
                                <label for="checkbox_frequency_<?= $key ?>">
                                    <?= ucwords($value) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="card collapse-grc ">
                <div class="card-block">
                    <a href="#" data-target="#card_compliance_register" class="card-title h5 link collapse-cmd">
                        Compliance Register
                        <div class="pull-right " id="card_frequency_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_compliance_register">
                        <hr>
                        <?php foreach ($data ['registers']as $key => $value): ?>
                            <div class="checkbox checkbox-primary">
                                <input id="compliance_register_<?= $key ?>" type="checkbox"  name="compliance_register[]" value="<?= $value['id'] ?>" onchange="report_filter();"  >
                                <label for="compliance_register_<?= $key ?>">
                                    <?= $value['title'] ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div><!---->

            <div class="card collapse-grc ">
                <div class="card-block">
                    <a href="#" data-target="#card_compliance_requirement" class="card-title h5 link collapse-cmd">
                        Compliance Requirement
                        <div class="pull-right " id="card_compliance_requirement_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_compliance_requirement">
                        <hr>
                        <?php
                        $max = 27;
                        foreach ($data['compliance_requirements'] as $key => $value) :
                            ?>
                            <div class="checkbox checkbox-primary">
                                <input id="compliance_requirement_<?= $value['id'] ?>" type="checkbox"  name="compliance_requirement[]" value="<?= $value['id'] ?>" onchange="report_filter();"  >
                                <label for="compliance_requirement_<?= $value['id'] ?>">
                                    <span title="<?= strlen($value['title']) > $max ? $value['title'] : NULL; ?>"><?= substr($value['title'], 0, $max) ?> <?= strlen($value['title']) > $max ? "..." : NULL; ?></span>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="card collapse-grc ">
                <div class="card-block">
                    <a href="#" data-target="#card_authority" class="card-title h5 link collapse-cmd">
                        Authority
                        <div class="pull-right " id="card_authority_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_authority">
                        <hr>
                        <?php foreach ($data ['authority'] as $key => $value): ?>
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox_authority_<?= $value['id'] ?>" type="checkbox"  name="authority[]" value="<?= $value['id'] ?>" onchange="report_filter();"  >
                                <label for="checkbox_authority_<?= $value['id'] ?>">
                                    <?= $value ['title'] ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div><!---->

            <div class="card collapse-grc hidden">
                <div class="card-block">
                    <a href="#" data-target="#card_units" class="card-title h5 link collapse-cmd">
                        Business Units
                        <div class="pull-right " id="card_units_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_units">
                        <hr>
                        <?php
                        //$types = array('annually', 'semi annually', 'quarterly', 'monthly', 'weekly', 'daily');
                        foreach ($data['units'] as $key => $array):

                            ///echo "<h5 class=''>{$key} </h5><hr class=' p-0 row'>";
                            foreach ($array as $label => $value):
                                //print_pre($value);;
                                if ($value['environment_level']['id'] != 2) {
                                    continue;
                                }// $value[]
                                ?>
                                <div class="checkbox checkbox-primary">
                                    <input id="unit_<?= $value['id'] ?>" type="checkbox"  name="environment[]" value="<?= $value['id'] ?>" onchange="report_filter();"  >
                                    <label for="unit_<?= $value['id'] ?>">
                                        <?= $value['name'] ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?= form_close(); ?>
        </div>

        <div class="col-sm-9">
            <div class="card">
                <div class="card-block">
                    <div class="pull-right">
                        <button class="btn btn-secondary btn-sm btn-small switch_report_view waves-effect waves-light hidden" id="view_ob_charts" data-target="obligationChart"><i class="icon icon-chart"></i> Chart</button>
                        <button class="btn btn-secondary btn-sm btn-small switch_report_view waves-effect waves-light" id="view_ob_table" data-target="obligatonsTableReportView"><i class="icon icon-list"></i> Table</button>

                    </div>
                    <h4 class="card-title">Report </h4>
                </div>
            </div>

            <div class="" id="report_filter">

            </div>

        </div>

    </div>



</div>
<script type="text/javascript">
    $(document).ready(function(){
        report_filter();
    });
    function report_filter() {
        $.post($('#form_report_filter').attr("action"), $('#form_report_filter').serialize(), function (response) {
            $('#report_filter').html(response);
        });
    }

    $('.switch_report_view').click(function () {
        $('.switch_report_view').toggleClass('hidden');
        var taget = ($(this).data("target"));
        $('#txt-active_view').val(taget);
        report_filter();
    });


</script>