<?php
if (!am_user_type(array(1, 9, 6, 5))) {
    restricted_view();
    return false;
}
?><?php
$risk = $data['risks'];
$risks = $risk;
$heat_colors = heatmap_constants("gorss_risk");
$labels = array(
    1 => "info",
    2 => "success",
    3 => "warning",
    4 => "danger",
    5 => "inverse",
);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">

            <?= form_open_multipart("Risk/riskFilter", array("id" => "frm_risk_repost_filter")); ?>
            <input type="hidden" id="active_tab" value="" />
            <div class="card collapse-grc ">
                <div class="card-block">
                    <a href="#" data-target="#card_gross-risk" class="card-title h6 link collapse-cmd open">
                        Gross Risk
                        <div class="pull-right " id="card_gross-risk_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_gross-risk">
                        <hr>
                        <?php
                        foreach ($heat_colors['gross_risk'] as $key => $value) :
                            if ($key == 0) {
                                continue;
                            }
                            ?>
                            <div class="checkbox checkbox-<?= $labels[$key]; ?> checkbox-<?= $value ?>">
                                <input id="checkbox_gross_risk_<?= $key ?>" type="checkbox"  name="gross_risk[]" checked value="<?= $key ?>" onchange="riskFilter();" >
                                <label for="checkbox_gross_risk_<?= $key ?>">
                                    <?= $value; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="card collapse-grc ">
                <div class="card-block">
                    <a href="#" data-target="#card_control-ratings" class="card-title h6 link collapse-cmd">
                        Control Ratings
                        <div class="pull-right " id="card_control-ratings_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_control-ratings">
                        <hr>
                        <?php
                        foreach ($heat_colors['control_ratings'] as $key => $value) :
                            if ($key == 0) {
                                continue;
                            }
                            ?>
                            <div class="checkbox checkbox-<?= $labels[$key]; ?> checkbox-<?= $value ?>">
                                <input id="checkbox_control_ratings_<?= $key ?>" type="checkbox"   name="control_ratings[]" value="<?= $key ?>" onchange="riskFilter();"  >
                                <label for="checkbox_control_ratings_<?= $key ?>">
                                    <?= $value; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="card collapse-grc ">
                <div class="card-block">
                    <a href="#" data-target="#card_net-risk" class="card-title h6 link collapse-cmd">
                        Net Risk
                        <div class="pull-right " id="card_net-risk_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_net-risk">
                        <hr>
                        <?php
                        foreach ($heat_colors['net_risk'] as $key => $value) :
                            if ($key == 0) {
                                continue;
                            }
                            ?>
                            <div class="checkbox checkbox-<?= $labels[$key]; ?> checkbox-<?= $value ?>">
                                <input id="checkbox_net_risk_<?= $key ?>" type="checkbox"   name="net_risk[]" value="<?= $key ?>" onchange="riskFilter();"  >
                                <label for="checkbox_net_risk_<?= $key ?>">
                                    <?= $value; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="card collapse-grc ">
                <div class="card-block">
                    <a href="#" data-target="#card_registers" class="card-title h6 link collapse-cmd">
                        Risk Registers
                        <div class="pull-right " id="card_registers_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_registers">
                        <hr>
                        <?php foreach ($data['registers'] as $key => $value) : ?>
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox_register_<?= $key ?>" type="checkbox"   name="registers[]" value="<?= $value['id'] ?>" onchange="riskFilter();"  >
                                <label for="checkbox_register_<?= $key ?>">
                                    <?= $value['title']; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="card collapse-grc ">
                <div class="card-block">
                    <a href="#" data-target="#card_categories" class="card-title h6 link collapse-cmd">
                        Categories
                        <div class="pull-right " id="card_categories_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_categories">
                        <hr>
                        <?php foreach ($data['categories'] as $key => $value) : ?>
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox_register_<?= $key ?>" type="checkbox"   name="categories[]" value="<?= $value['id'] ?>" onchange="riskFilter();"  >
                                <label for="checkbox_register_<?= $key ?>">
                                    <?= $value['title']; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="card collapse-grc ">
                <div class="card-block">
                    <a href="#" data-target="#card_units" class="card-title h6 link collapse-cmd">
                        Units/Environment
                        <div class="pull-right " id="card_units_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_units">
                        <hr>
                        <?php foreach ($data['business_units'] as $key => $value) : ?>
                            <div class="checkbox checkbox-primary">
                                <input id="units_<?= $value['id'] ?>" type="checkbox"   name="business_units[]" value="<?= $value['id'] ?>" onchange="riskFilter();"  >
                                <label for="units_<?= $value['id'] ?>">
                                    <?= $value['name']; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="card collapse-grc ">
                <div class="card-block">
                    <a href="#" data-target="#card_risk_sources" class="card-title h6 link collapse-cmd">
                        Risk Sources
                        <div class="pull-right " id="card_risk_sources_arrow">
                            <i class=" direction-arrows icon icon-arrow-down"></i>
                        </div>
                    </a>
                    <div class="collapse-content" id="card_risk_sources">
                        <hr>
                        <?php foreach ($data['risk_sources'] as $key => $value) : ?>
                            <div class="checkbox checkbox-primary">
                                <input id="risk_sources_<?= $key ?>" type="checkbox"   name="risk_sources[]" value="<?= $key ?>" onchange="riskFilter();"  >
                                <label for="risk_sources_<?= $key ?>">
                                    <?= $value; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
        <div class="col-md-10">
            <div class="card" id="riskReportView">
                <!-- LOAD FROM AJAX FUNCTION  riskFilter() -->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        riskFilter();
        $('.nav_link').click(function () {
            $("#active_tab").val($(this).attr("href"));
        });
    });

    function riskFilter() {
        //$("#riskReportView").animate({opactity: 0.4}, "fast");
        var url = $("#frm_risk_repost_filter").attr("action");
        $.post(url, $("#frm_risk_repost_filter").serialize(), function (response) {
            //alert(response);
            $("#riskReportView").html(response);
            $("#riskReportView").animate({opactity: 1}, "fast");
        });
    }
    
    


</script>
