<?php
/*
 *  Code By Alex
 *  Eat Code Sleep Repeat
 */
$audit = $data['audit'];
?>
<link href="<?= base_url("assets/plugins/toastr/toastr.min.css") ?>" rel="stylesheet" type="text/css">
<style>
    #uplon_wizard .nav ul li,
    #uplon_wizard .nav ul {
        list-style: none; 
        margin: 0; 
        padding: 0;
    }
    #uplon_wizard .nav ul li {
        float: left; 
        width: <?= (100 / (count($data['audit_area']) + 2)) ?>% ;
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
    .toast-warning  {
        border: none;
    }
    #drafting {
        padding: 10px;
    }
</style>
<?php
$details = json_decode($data['report']['details'], TRUE);
// print_pre($data);
//exit;
?>
<?= form_open('Audit/postAuditReport', array('id' => 'frm_audit_report')) ?>
<input type='hidden' class='form-control'  name='audit' id='txt-issue-id' value='<?= $audit['id'] ?>' />
<input type='hidden' class='form-control'  name='id' id='txt-issue-id' value='<?= $data['report']['id'] ?>' />
<div class='container-fluid'>
    <div class='card card-box'>
        <div class='card-title'>
            <h4> Prepare Audit Report </h4>
        </div>
        <hr />
        <div class="row">
            <div id="uplon_wizard">
                <div class="nav">
                    <ul>
                        <li class="wiz_nav active" data-target="1" id="cmd_1">Audit Executive Summary</li>
                        <li class="wiz_nav " data-target="2" id="cmd_2">Business Review</li>
                        <?php
                        $i = 2;
                        foreach ($data['audit_areas'] as $key => $value):
                            $i++;
                            ?>
                            <li class="wiz_nav " data-target="<?= $i ?>" id="cmd_<?= $i ?>"><?= ucwords($value['title']) ?></li>
                        <?php endforeach; ?>
                        <div class="clearfix"></div>
                    </ul>
                </div>
                <div class="wizard_content">
                    <div class="wiz_item active " id="tab_1">
                        <div class="row">
                            <div class="col-sm-12">
                                <small class="text-danger" id="txt-wiz-val"></small>

                            </div>
                        </div>
                        <div class='form-group'>
                            <label  for="txt-audit_report-background"  class='col-sm-12 form-control-label'><h5>Audit Background and Scope</h5></label>
                            <div class='col-sm-12'>
                                <textarea required class='form-control wysiwyg' onchange="draftSystem();"  rows="10" name='background' id='txt-audit_report-background' placeholder='background' ><?= isset($details['background']) ? $details['background'] : "" ?></textarea>
                                <small class="text-danger" id="txt-audit_report-background-val"></small>
                            </div>
                        </div>
                        <div class='form-group'>
                            <label  for="txt-audit_report-main_recommendation"  class='col-sm-12 form-control-label m-t-15'><h5>Audit Main Recommendation</h5></label>
                            <div class='col-sm-12'>
                                <textarea required class='form-control wysiwyg' onchange="draftSystem();"  rows="10" name='main_recommendation' id='txt-audit_report-main_recommendation' placeholder='main_recommendation' ><?= isset($details['main_recommendation']) ? $details['main_recommendation'] : "" ?></textarea>
                                <small class="text-danger" id="txt-audit_report-main_recommendation-val"></small>
                            </div>
                        </div>
                        <div class='form-group'>
                            <label  for="txt-audit_report-overall_assessment"  class='col-sm-12 form-control-label m-t-15'><h5>Audit Overall Assessment</h5></label>
                            <div class='col-sm-12'>
                                <textarea required class='form-control wysiwyg' onchange="draftSystem();"  rows="10" name='overall_assessment' id='txt-audit_report-overall_assessment' placeholder='overall_assessment' ><?= isset($details['overall_assessment']) ? $details['overall_assessment'] : "" ?></textarea>
                                <small class="text-danger" id="txt-audit_report-overall_assessment-val"></small>
                            </div>
                        </div>
                        <div class='form-group'>
                            <label  for="txt-audit_report-follow_up"  class='col-sm-12 form-control-label m-t-15'><h5>Follow-Up Audit</h5></label>
                            <div class='col-sm-12'>
                                <textarea required class='form-control wysiwyg' onkeyup="draftSystem();"  rows="10" name='follow_up' id='txt-audit_report-follow_up' placeholder='follow_up' ><?= isset($details['follow_up']) ? $details['follow_up'] : "" ?></textarea>
                                <small class="text-danger" id="txt-audit_report-follow_up-val"></small>
                            </div>
                        </div>
                    </div>
                    <div class="wiz_item" id="tab_2">
                        <div class='form-group'>
                            <label  for="txt-audit_report-business_review"  class='col-sm-12 form-control-label m-t-15'><h5>Business Review</h5></label>
                            <div class='col-sm-12'>
                                <textarea class='form-control wysiwyg' onkeyup="draftSystem();"  rows="10" name='business_review' id='txt-audit_report-business_review' placeholder='business_review' ><?= isset($details['business_review']) ? $details['business_review'] : "" ?></textarea>
                                <small class="text-danger" id="txt-audit_report-business_review-val"></small>
                            </div>
                        </div>
                    </div>
                    <?php
                    $j = 2;
                    foreach ($data['audit_areas'] as $key => $value):
                        $j++;
                        $issue = 'issue' . $j;
                        $title = str_replace(" ", "_", $value['title']);
                        ?>
                        <input type="text" class="form-control" hidden name="auditareas[]" value='<?= json_encode($value['id']) ?>'>
                        <div class="wiz_item" id="tab_<?= $j ?>">
                            <div class="row">
                                <div class="col-sm-12 col-lg-12 col-xs-12">
                                    <div class="card">
                                        <div class="card-block">
                                            <h5 class="card-title">Issues in this Audit Area</h5>
                                            <?php
                                            if (empty($value['issues'])):
                                                $issue = array();
                                                ?>
                                                <div class="alert alert-info" role="alert">
                                                    This audit area has <strong>No Issues</strong>
                                                </div>
                                            <?php else: ?>
                                                <table id="datatable-buttons" class="table table-striped table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Issue Title</th>
                                                            <th>Issue Rating</th>
                                                            <th>Action By</th>
                                                            <th>Action Plan Status</th>
                                                            <th>Issue Status</th>
                                                            <th>Implication Type</th>
                                                            <th>Publishing Status</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody>

                                                        <?php
                                                        $issue = array();
                                                        $num = 0;
                                                        foreach ($value['issues'] as $key => $info) :
                                                            $num++;
                                                            $issue[] = $info['id'];
                                                            ?>
                                                            <tr>
                                                                <td><?= $num ?></td>
                                                                <td><a href="<?= base_url('index.php/Audit/issue/' . $info['id'] . '') ?>"><?= ucwords($info['title']) ?></a></td>
                                                                <td>
                                                                    <?php
                                                                    if ($info['issue_rating'] == 'Low') {
                                                                        echo '<span class="label label-pill label-primary">';
                                                                    } elseif ($info['issue_rating'] == 'Moderate') {
                                                                        echo '<span class="label label-pill label-warning">';
                                                                    } elseif ($info['issue_rating'] == 'High') {
                                                                        echo '<span class="label label-pill label-danger">';
                                                                    } else {
                                                                        echo '<span class="label label-pill label-danger">';
                                                                    }
                                                                    ?>
                                                                    <?= $info['issue_rating'] ?>
                                                                    </span>
                                                                </td>
                                                                <td><?= $info['issue_owner']['names'] ?></td>
                                                                <td><?= $info['action_plan_status'] ?></td>
                                                                <td>
                                                                    <?php
                                                                    if ($info['issue_status'] == 'Open') {
                                                                        echo '<span class="label label-pill label-danger">';
                                                                    } elseif ($info['issue_status'] == 'Closed') {
                                                                        echo '<span class="label label-pill label-info">';
                                                                    } else {
                                                                        
                                                                    }
                                                                    ?>
                                                                    <?= $info['issue_status'] ?>
                                                                    </span>
                                                                </td>
                                                                <td><?= $info['implication_type'] ?></td>
                                                                <td>
                                                                    <?= $info['published_management'] == "1" ? "<span class=\"label label-pill label-info\">Management</span>" : "" ?> 
                                                                    <?= $info['published_ceo'] == "1" ? "<span class=\"label label-pill label-primary\">CEO</span>" : "" ?>
                                                                    <?php
                                                                    if (($info['published_board'] == "1") && ($audit['published_board'] == "0")) {
                                                                        echo "<span class=\"label label-pill label-warning\">Draft</span>";
                                                                    } elseif (($info['published_board'] == "1") && ($audit['published_board'] == "1")) {
                                                                        echo "<span class=\"label label-pill label-success\">Board</span>";
                                                                    } else {
                                                                        echo "";
                                                                    }
                                                                    ?>
                                                                </td>

                                                            </tr>
        <?php endforeach; ?>
                                                    </tbody>

                                                </table>
    <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <input type="text" class="form-control" hidden name="<?= $value['id'] ?>.issue[]" value='<?= json_encode($issue) ?>'>
                            <div class='form-group'>
                                <label  for="txt-audit_report-<?= $value['title'] ?>"  class='col-sm-12 form-control-label'><h5>Objective/Work Done on Audit Area:</h5><h5 class="text-muted"> <?= ucwords($value['title']) ?></h5></label>
                                <div class='col-sm-12'>
                                    <textarea class='form-control wysiwyg' onchange="draftSystem();"  rows="10" name='<?= $value['title'] ?>.objective' id='txt-audit_report-<?= $value['title'] ?>' placeholder='objective' ><?= isset($details[$title . '_objective']) ? $details[$title . '_objective'] : "" ?></textarea>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label  for="txt-audit_report-con-<?= $value['title'] ?>"  class='col-sm-12 form-control-label m-t-15'><h5>Conclusion on Audit Area:</h5><h5 class="text-muted"> <?= ucwords($value['title']) ?></h5></label>
                                <div class='col-sm-12'>
                                    <textarea class='form-control wysiwyg' onchange="draftSystem();"  rows="10" name='<?= $value['title'] ?>.conclusion' id='txt-audit_report-con-<?= $value['title'] ?>' placeholder='conclusion' ><?= isset($details[$title . '_conclusion']) ? $details[$title . '_conclusion'] : "" ?></textarea>
                                </div>
                            </div>
                        </div>
<?php endforeach; ?>
                </div>
            </div>
            <pre id="responce_pre"></pre>
            <input id="track" type="hidden" value="1"/>
            <input id="tab_count" type="hidden" value="<?= (count($data['audit_area']) + 2) ?>"/>
        </div>
        <div class="card-block" style="
             padding-bottom: 40px;
             ">
            <hr />
            <div class="btn-group pull-left">
                <button type='button' id="cmd_prev" class='btn btn-secondary waves-effect'>Previous</button>
                <button type='button' id="cmd_next" class='btn btn-secondary waves-effect'>Next</button>
            </div>
            <div class="hidden pull-left" id="drafting"><span class="fa icon icon-hourglass fa-spin"></span> Drafting</div>

            <div class="btn-group pull-right">

                <?php if ($data['report']['draft'] == 0) { ?>
                    <a class='btn btn-secondary btn-sm waves-effect waves-light pull-right' href="<?= base_url("index.php/Audit/audit/{$data['report']['audit']}") ?>"> Cancel </a>

                <?php } else { ?>
                        <!--<a class='btn btn-secondary btn-sm waves-effect waves-light pull-right' href="<?= base_url("index.php/Audit/deleteAuditReport/{$data['report']['id']}/true") ?>"> Discard Draft </a>-->
                    <a class='btn btn-sm btn-secondary waves-effect'  href="<?= base_url("index.php/Audit/audit/{$data['report']['audit']}") ?>" >Save Draft</a>
<?php } ?>
                <button type='submit' class='btn btn-sm btn-primary waves-effect' onclick="validate_audit_report()">Save </button>
            </div>
        </div>
    </div>
</div>


<script src="<?= base_url("assets/plugins/toastr/toastr.min.js") ?>"></script>
<script>
                    CKEDITOR.replace('txt-audit_report-background');
                    CKEDITOR.replace('txt-audit_report-main_recommendation');
                    CKEDITOR.replace('txt-audit_report-overall_assessment');
                    CKEDITOR.replace('txt-audit_report-follow_up');
                    CKEDITOR.replace('txt-audit_report-business_review');

<?php
$x = 0;
foreach ($data['audit_areas'] as $key => $value) {
    $x++;
    echo "CKEDITOR.replace('txt-audit_report-" . $value['title'] . "');";
    echo "CKEDITOR.replace('txt-audit_report-con-" . $value['title'] . "');";
}
?>
                    for (var i in CKEDITOR.instances) {
                        CKEDITOR.instances[i].on('change', function () {
                            draftSystem();
                        });
                    }
                    function draftSystem() {

                        for (instance in CKEDITOR.instances) {
                            CKEDITOR.instances[instance].updateElement();
                        }

                        $("#drafting").removeClass("hidden");
                        var url = "<?= base_url("index.php/Audit/auditReportDraft/") ?>";
                        var formId = "frm_audit_report";
                        $.post(url, $("#" + formId).serialize(), function (response) {
//            alert(response);
                            $("#drafting").addClass("hidden");
                        });
                    }



                    function validate_audit_report() {
                        for (instance in CKEDITOR.instances) {
                            CKEDITOR.instances[instance].updateElement();
                            //alert("Me");
                        }


                        var flag = true;




                        if (!$('#txt-audit_report-background').val()) {
                            $("#txt-audit_report-background-val").html("The Audit background and scope is required");
                            $("#txt-wiz-val").html("Please fill all the fields required");
                            wiz_nav_to(1);
                            flag = false;
                        } else {
                            $("#txt-audit_report-background-val").html("");
                        }

                        if (!$('#txt-audit_report-main_recommendation').val()) {
                            $("#txt-audit_report-main_recommendation-val").html("The Audit report main recommendation is required");
                            $("#txt-wiz-val").html("Please fill all the fields required");
                            wiz_nav_to(1);
                            flag = false;
                        } else {
                            $("#txt-audit_report-main_recommendation-val").html("");
                        }

                        if (!$('#txt-audit_report-overall_assessment').val()) {
                            $("#txt-audit_report-overall_assessment-val").html("The Audit overall assessment is required");
                            $("#txt-wiz-val").html("Please fill all the fields required");
                            wiz_nav_to(1);
                            flag = false;
                        } else {
                            $("#txt-audit_report-overall_assessment-val").html("");
                        }

                        if (!$('#txt-audit_report-follow_up').val()) {
                            $("#txt-audit_report-follow_up-val").html("The Audit follow-up is required");
                            $("#txt-wiz-val").html("Please fill all the fields required");
                            wiz_nav_to(1);
                            flag = false;
                        } else {
                            $("#txt-audit_report-follow_up-val").html("");
                        }


                        if (flag === false) {
                            event.preventDefault();
                            toastr["warning"]("Please fill the required fields!")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": true,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                        }

                    }
                    var tab_count = $("#tab_count").val();

                    $('#cmd_next').click(function () {
                        var pos = $("#track").val();
                        if (pos >= tab_count) {
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
                            pos = tab_count;
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
<?= form_close() ?>