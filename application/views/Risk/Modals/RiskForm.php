<?php $risk = $data['risk']; ?>
<?= form_open_multipart("Risk/riskPost", array('id' => 'GRC_RISK_FORM', 'class' => '', "onclick" => "return validate_risk()")) ?>
<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header bg-faded'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Risk </h4>
        </div>
        <style>
            #uplon_wizard .nav ul li,
            #uplon_wizard .nav ul {
                list-style: none; 
                margin: 0; 
                padding: 0;
            }
            #uplon_wizard .nav ul li {
                float: left; 
                width: 33.33% ;
                border: 1px solid #eee;
                padding: 10px;
                text-align: center;
                font-weight: bold;
                border-right: none;
                cursor: pointer;
            }
            #uplon_wizard .nav ul li.active {
                background: #eee;

            }
            #uplon_wizard .nav ul li:last-of-type {
                border-right: 1px solid #eee;
            }
            #uplon_wizard .nav {
                margin-bottom: 20px;
            }
            .wiz_item{ display: none;}
            .wiz_item.active{ 
                display: block;
            }
            #drafting {
                padding: 10px;
            }
        </style>
        <input type='hidden' class='form-control'  name='id' id='txt-risk-id' value='<?= $risk['id'] ?>' />
        <div class='modal-body' >
            <?php // print_pre($risk); ?>

            <div id="uplon_wizard">
                <div class="nav">
                    <ul>
                        <li class="wiz_nav active" data-target="1" id="cmd_1">Basic Information</li>
                        <li class="wiz_nav " data-target="2" id="cmd_2">Risk Description</li>
                        <li class="wiz_nav " data-target="3" id="cmd_3">Attachments</li>
                        <div class="clearfix"></div>
                    </ul>
                </div>
                <div class="wizard_content">
                    <div class="wiz_item active " id="tab_1">
                        <div class='form-group row'>
                            <label  for="txt-risk-title"  class='col-sm-3 form-control-label'>Risk Title</label>
                            <div class='col-sm-9'>
                                <input type='text' class='form-control' onchange="draftSystem()"   name='title'  id='txt-risk-title' value='<?= $risk['title'] ?>' placeholder='Risk Name' required/>
                                <small class="text-danger" id="txt-risk-title-val"></small>
                            </div>
                        </div>
                        <div class='form-group row'>
                            <label  for="txt-risk-environments"  class='col-sm-3 form-control-label'> Unit</label>
                            <div class='col-sm-9'>
                                <select  class='form-control select2' name='' style="width:100%"  onchange="findKRAsOptions(this.value)" id='txt-risk-environment'> 
                                    <option value="">Select Unit / Environment</option>
                                    <?php foreach ($data['environments'] as $key => $array): ?>
                                        <optgroup label="<?= $key ?>">
                                            <?php foreach ($array as $key => $value): ?>
                                                <option <?= ($data['environment']['id'] == $value['id']) ? "selected='selected'" : NULL; ?> value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-danger" id="txt-risk-environments-val"></small>

                            </div>
                        </div>
                        <div class='form-group row'>
                            <label  for="txt-risk-repository"  class='col-sm-3 form-control-label'>Key Risk Area</label>
                            <div class='col-sm-9'>
                                <select  class='form-control  ' required onchange="draftSystem()" style="width:100%" name='repository' id='txt-risk-repository'> 

                                    <option value="">SELECT</option>

                                    <?php foreach ($data['repository'] as $key => $array): ?>
                                        <optgroup label="<?= $key ?>">
                                            <?php foreach ($array as $key => $value): ?>
                                                <option value='<?= $value['id'] ?>' <?= ($value['id'] == $risk['repository']) ? "selected='selected'" : NULL; ?> > <?= $value['name'] ?> </option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-danger" id="txt-risk-repository-val"></small>

                            </div>
                        </div>
                        <div class='form-group row'>
                            <label  for="txt-risk-incidents_capacity"  class='col-sm-3 form-control-label'>Incident Capacity Limit</label>
                            <div class='col-sm-9'>
                                <input type='number' class='form-control' required onchange="draftSystem()"  name='incidents_capacity' id='txt-risk-incidents_capacity' value='<?= $risk['incidents_capacity'] ?>' placeholder='incidents_capacity' />
                            </div>
                        </div>
                        <div class='form-group row'>
                            <label  for="txt-risk-frequency"  class='col-sm-3 form-control-label'>Incident Capacity Period</label>
                            <div class='col-sm-9'>
                                <select  class='form-control'name='frequency'  onchange="draftSystem()" id='txt-risk-frequency'> 
                                    <option value='unlimited' <?= $risk['frequency'] == 'unlimited' ? "selected='selected'" : NULL; ?> > Unlimited </option>
                                    <option value='annually' <?= $risk['frequency'] == 'annually' ? "selected='selected'" : NULL; ?> > Annually </option>
                                    <option value='semi annually' <?= $risk['frequency'] == 'semi annually' ? "selected='selected'" : NULL; ?> > Semi Annually </option>
                                    <option value='quarterly' <?= $risk['frequency'] == 'quarterly' ? "selected='selected'" : NULL; ?> > Quarterly </option>
                                    <option value='monthly' <?= $risk['frequency'] == 'monthly' ? "selected='selected'" : NULL; ?> > Monthly </option>
                                    <option value='weekly' <?= $risk['frequency'] == 'weekly' ? "selected='selected'" : NULL; ?> > Weekly </option>
                                    <option value='daily' <?= $risk['frequency'] == 'daily' ? "selected='selected'" : NULL; ?> > Daily </option>
                                </select>
                            </div>
                        </div>
                        <div class='form-group row'>
                            <label  for="txt-risk-management_control"  class='col-sm-3 form-control-label'>Management Control Capability</label>
                            <div class='col-sm-9'>
                                <select  class='form-control'name='management_control'  onchange="draftSystem()" id='txt-risk-management_control'> 
                                    <option value='Monitor' <?= $risk['management_control'] == 'Monitor' ? "selected='selected'" : NULL; ?> > Monitor </option>
                                    <option value='Accept' <?= $risk['management_control'] == 'Accept' ? "selected='selected'" : NULL; ?> > Accept </option>
                                    <option value='Improve' <?= $risk['management_control'] == 'Improve' ? "selected='selected'" : NULL; ?> > Improve </option>
                                </select>
                            </div>
                        </div>
                        <div class='form-group row'>
                            <label  for="txt-risk-management_control"  class='col-sm-3 form-control-label'>Evaluation Measure Type</label>
                            <div class='col-sm-9'>
                                <select  class='form-control' name='evaluation_type'  onchange="draftSystem()" id='txt-risk-evaluation_type'> 
                                    <option value="">SELECT</option>
                                    <option value='positive' <?= $risk['evaluation_type'] == 'positive' ? "selected='selected'" : NULL; ?> > Positive </option>
                                    <option value='negative' <?= $risk['evaluation_type'] == 'negative' ? "selected='selected'" : NULL; ?> > Negative </option>
                                </select>
                            </div>
                        </div>
                        <div class='form-group row'>
                            <label  for="txt-risk-risk_owner"  class='col-sm-3 form-control-label '>Risk Owner</label>
                            <div class='col-sm-9'>
                                <select  class='form-control select2' style="width:100%" onchange="draftSystem()" name='risk_owner' id='txt-risk-risk_owner'> 
                                    <option value="">SELECT</option>
                                    <?php foreach ($data['risk_owners'] as $key => $value): ?>
                                        <option value='<?= $value['id'] ?>' <?= $value['id'] == $risk['risk_owner'] ? "selected='selected'" : NULL; ?> > <?= $value['names'] ?> </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-danger" id="txt-risk-risk_owner-val"></small>

                            </div>
                        </div>
                        <div class='form-group row'>
                            <label  for="txt-risk-heat_map_ref"  class='col-sm-3 form-control-label'>Heat Map Reference Code </label>
                            <div class='col-sm-9'>
                                <input type='text' maxlength="5" required="" onchange="riskUniqueRefCode(this.value,<?= $risk['id'] ?>)" class='form-control'  name='heat_map_ref' id='txt-risk-heat_map_ref' value='<?= $risk['heat_map_ref'] ?>' placeholder='REF:   CODE' />
                                <small class="text-muted text-danger" id="txt-risk-heat_map_ref-val"></small>
                            </div>
                        </div>
                        <div class='form-group row'>
                            <label  for="txt-risk-title"  class='col-sm-3 form-control-label'>Risk Category</label>
                            <div class='col-sm-9' >
                                <div class="row">
                                    <div class="hidden">                                   
                                        <input type="text" readonly class="form-control" name="category" id="txt-risk-category" value="<?= $risk['category'] ?>"/>
                                    </div>
                                    <div class="col-xs-12">                                    
                                        <input type="text" onclick="riskCategorySelect(<?= $risk['id'] ?>);" class="form-control" name="" id="txt-risk-category-name" value="<?= isset($data['category']['title']) ? $data['category']['title'] : "None"; ?>"/>
                                    </div>
                                </div>
                                <small class="text-danger" id="txt-risk-category-val"></small>

                            </div>
                        </div>
                        <div class='form-group row'>
                            <label  for="txt-risk-insurable_status"  class='col-sm-3 form-control-label'>Insurable Status</label>
                            <div class='col-sm-9'>
                                <select  class='form-control'name='insurable_status'  onchange="draftSystem()" id='txt-risk-insurable_status'> 
                                    <option value='YES' <?= $risk['insurable_status'] == 'YES' ? "selected='selected'" : NULL; ?> > Yes </option>
                                    <option value='NO' <?= $risk['insurable_status'] == 'NO' ? "selected='selected'" : NULL; ?> > No </option>
                                    <option value='UNKNOWN' <?= $risk['insurable_status'] == 'UNKNOWN' ? "selected='selected'" : NULL; ?> > Unknown </option>
                                </select>
                                <small class="text-danger" id="txt-risk-title-val"></small>

                            </div>
                        </div>
                        <div class='form-group row'>
                            <label  for="txt-risk-insurance_status"  class='col-sm-3 form-control-label'>Insurance Status</label>
                            <div class='col-sm-9'>
                                <select  class='form-control'name='insurance_status'  onchange="draftSystem()" id='txt-risk-insurance_status'> 
                                    <option value='YES' <?= $risk['insurance_status'] == 'YES' ? "selected='selected'" : NULL; ?> > Yes </option>
                                    <option value='NO' <?= $risk['insurance_status'] == 'NO' ? "selected='selected'" : NULL; ?> > No </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="wiz_item"id="tab_2">
                        <div class='form-group row'>
                            <label  for="txt-risk-description"  class='col-sm-3 form-control-label'>Description</label>
                            <div class='col-sm-9'>
                                <textarea class='form-control wysiwyg' rows="5"  onchange="draftSystem()"  name='description' id='txt-risk-description' placeholder='description' ><?= strip_tags($risk['description']) ?></textarea>
                            </div>
                        </div>
                        <div class='form-group row'>
                            <label  for="txt-risk-event_of_risk"  class='col-sm-3 form-control-label'>Risk Event </label>
                            <div class='col-sm-9'>
                                <textarea class='form-control wysiwyg'  rows="5"  onchange="draftSystem()" name='event_of_risk' id='txt-risk-event_of_risk' placeholder='event_of_risk' ><?= strip_tags($risk['event_of_risk']) ?></textarea>
                            </div>
                        </div>
                        <div class='form-group row'>
                            <label  for="txt-risk-effects_of_risk"  class='col-sm-3 form-control-label'>Effects Of Risk</label>
                            <div class='col-sm-9'>
                                <textarea class='form-control wysiwyg' rows="5"  onchange="draftSystem()"name='effects_of_risk' id='txt-risk-effects_of_risk' placeholder='effects_of_risk' ><?= strip_tags($risk['effects_of_risk']) ?></textarea>
                            </div>
                        </div>
                        <div class='form-group row'>
                            <label  for="txt-risk-source_of_risk"  class='col-sm-3 form-control-label'>Source Of Risk</label>
                            <div class='col-sm-9'>
                                <textarea class='form-control wysiwyg' rows="5"  onchange="draftSystem()" name='source_of_risk' id='txt-risk-source_of_risk' placeholder='source_of_risk' ><?= strip_tags($risk['source_of_risk']) ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="wiz_item" id="tab_3">
                        <?= files_upload("Risk", "risk", $risk['id']); ?>
                    </div>
                </div>
            </div>
            <pre id="responce_pre"></pre>
            <input id="track" type="hidden" value="1"/>
            <div class='modal-footer'>
                <div class="btn-group pull-left">
                    <button type='button' id="cmd_prev" class='btn btn-secondary waves-effect'>Previous</button>
                    <button type='button' id="cmd_next" class='btn btn-secondary waves-effect'>Next</button>
                </div>
                <div class="hidden pull-left" id="drafting"><span class="fa icon icon-hourglass fa-spin"></span> Drafting</div>
                <div class="btn-group">
                    <?php if ($risk['draft'] != 0): ?>
                        <a href="<?= base_url("index.php/Risk/riskDelete/{$risk['id']}/true"); ?>" class='btn btn-secondary waves-effect'>Discard Draft</a>
                    <?php endif; ?>
                    <button type='button' class='btn btn-secondary waves-effect'  data-dismiss="modal">Save Draft</button>
                    <button type='submit' class='btn btn-secondary waves-effect' >Save</button>
                </div>
            </div>
        </div>

    </div><!-- /.modal-content -->
</div>
<?= form_close(); ?>


<script>
    CKEDITOR.replace('txt-risk-description');
    CKEDITOR.replace('txt-risk-event_of_risk');
    CKEDITOR.replace('txt-risk-effects_of_risk');
    CKEDITOR.replace('txt-risk-source_of_risk');

    $(".select2").select2();

    function riskCategorySelect(risk_id) {
        ajaxFileModal("<?= base_url("index.php/Risk/riskCategorySelect"); ?>/" + risk_id);

    }

    function sub_category_level(value, level) {
        document.getElementById('txt-risk-category').value = value;
        $("#level_" + level).html("<option>Loading...</option>");
        var url = "<?= base_url("index.php/Risk/fetchCategoryLevelOptions/") ?>" + value;
        $.post(url, {data: "data", level: level}, function (response) {

            if (response) {
                $("#level_" + level).html("<option value='0'>SELECT</option>" + response);
            } else {
                $("#level_" + level).html("<option>Nothing Found </option>");
            }
        });

    }


    function validate_risk() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
            //alert("Me");
        }


        var flag = true;


        if (!$('#txt-risk-title').val()) {
            $("#txt-risk-title-val").html("The title is required");
            wiz_nav_to(1);
            flag = false;
        } else {
            $("#txt-risk-title-val").html("");
        }

        if (!$('#txt-risk-repository').val()) {
            $("#txt-risk-repository-val").html("The Source Repository is required");
            wiz_nav_to(1);
            flag = false;
        } else {
            $("#txt-risk-repository-val").html("");
        }

        if (!$('#txt-risk-risk_owner').val()) {
            $("#txt-risk-risk_owner-val").html("A risk must have a risk owner");
            wiz_nav_to(1);
            flag = false;
        } else {
            $("#txt-risk-risk_owner-val").html("");
        }

        if ($("#txt-risk-heat_map_ref-val").html() !== "") {
            $("#txt-risk-heat_map_ref-val").html("Please select a unique reference code");
            //wiz_nav_to(1);
            return false;
        }

        if (!$('#txt-risk-category').val()) {
            $("#txt-risk-category-val").html("Please select atleast a level 1 category");
            wiz_nav_to(1);
            flag = false;
        } else {
            $("#txt-risk-category-val").html("");
        }
        return flag;

    }




    function riskUniqueRefCode(ref_code, risk_id) {
        var url = "<?= base_url("index.php/Risk/riskUniqueRefCode/") ?>" + ref_code + "/" + risk_id;
        $.post(url, {
            data: "data"
        }, function (response, status) {
            if (response === 'yes') {
                draftSystem();
                $("#txt-risk-heat_map_ref-val").html("");
            } else {
                $("#txt-risk-heat_map_ref-val").html("Heat-map referece code already exists");
            }
        });
    }


    function count_limit(element) {
        var string = $(element).value();
        var max = 5;
        var length = max - string.length;
        $("#show_limit").html(length);
    }

    function draftSystem() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }


        $("#drafting").removeClass("hidden");
        var url = "<?= base_url("index.php/Risk/draftRisk/") ?>";
        var formId = "GRC_RISK_FORM";
        $.post(url, $("#" + formId).serialize(), function (response) {
            //alert(response);
            //$("#responce_pre").html(response);
            $("#drafting").addClass("hidden");
        });
    }

    function findKRAsOptions(value) {
        $("#txt-risk-repository").html("<option>Loading...</option>");
        var url = "<?= base_url("index.php/Home/findKRAsOptions") ?>" + "/" + value;
        $.post(url, {data: "data"}, function (response) {
            //$("#txt-risk-repository").val("<option>Loading...</option>");
            if (response != '') {
                $("#txt-risk-repository").html("<option>SELECT Key Risk Area  </option>" + response);
            } else {
                $("#txt-risk-repository").html("<option>No Key Risk Areas Found! </option>");
            }
        })

    }

    $('#cmd_next').click(function () {
        var pos = $("#track").val();
        if (pos >= 3) {
            pos = 1;
        } else {
            pos++;
        }
        $("#track").val(pos);
        var tab_id = "#tab_" + pos;
        var cmd_id = "#cmd_" + pos;
        $('.wiz_nav').removeClass('active');
        $('.wiz_item').removeClass('active');
        $(tab_id).addClass('active');
        $(cmd_id).addClass('active');
    });

    $('#cmd_prev').click(function () {
        var pos = $("#track").val();
        if (pos <= 1) {
            pos = 3;
        } else {
            pos--;
        }
        $("#track").val(pos);
        var tab_id = "#tab_" + pos;
        var cmd_id = "#cmd_" + pos;
        $('.wiz_nav').removeClass('active');
        $('.wiz_item').removeClass('active');
        $(tab_id).addClass('active');
        $(cmd_id).addClass('active');

    });


    $('.wiz_nav').click(function () {
        var pos = $(this).data("target");
        //alert(pos);
        $("#track").val(pos);
        var tab_id = "#tab_" + pos;
        var cmd_id = "#cmd_" + pos;
        $('.wiz_nav').removeClass('active');
        $('.wiz_item').removeClass('active');
        $(tab_id).addClass('active');
        $(cmd_id).addClass('active');

    });

    function wiz_nav_to(target) {
        var pos = target;
        $("#track").val(pos);
        var tab_id = "#tab_" + pos;
        var cmd_id = "#cmd_" + pos;
        $('.wiz_nav').removeClass('active');
        $('.wiz_item').removeClass('active');
        $(tab_id).addClass('active');
        $(cmd_id).addClass('active');

    }
</script>

