<?php 
//$actionlist = $data['actionlist'];
//print_pre ($data);

?>

<div class="container-fluid">

    
   <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Management Action Plans</h4>
<?= form_open_multipart("Audit/action_filter", array("id" => "frm_action_filter", "class" => null)); ?>
                    <input hidden name="corpId" value="<?= $data['corpId']?>"/>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group" style="">
                                        <label class="control-label" form="txt-filter-audit">Audit</label>
                                        <select name="audit" id="txt-filter-audit" onchange="action_filter()" class="form-control form-control-sm">
                                            <option value="0">Select Audit</option>
                                            <?php foreach ($data['auditslist'] as $key => $value): ?>
                                                <option value="<?= $value['id'] ?>"><?= $value['audit_name'] ?></option>
<?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                
                                <div class="col-sm-4">
                                    <div class="form-group" style="">
                                        <label class="control-label" form="txt-filter-issue">Issue </label>
                                        <select name="issue" id="txt-filter-issue" onchange="action_filter()" class="form-control form-control-sm">
                                            <option value="0">Select Issue</option>
                                            <?php foreach ($data['issueslist'] as $key => $value): ?>
                                                <option value="<?=$value['id'] ?>"> <?= $value['title'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                
                                <div class="col-sm-4">
                                    <div class="form-group" style="">
                                        <label class="control-label" form="txt-filter-active_status">Action plan Active Status</label>
                                        <select name="active_status" id="txt-filter-active_status" onchange="action_filter()" class="form-control form-control-sm">
                                            <option value="">Select Status</option>
                                            <option value='Active'>Active</option>
                                            <option value='Complete'>Complete</option>
                                        </select>
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                      
                       
                    </div>
                    
<?= form_close(); ?>
                </div>
            </div>
            <div class="" id="action_filter_list">

            </div>


        </div>

    </div>
    
</div>
    

 <script>

        $(document).ready(function () {
            action_filter();
        });

        //    function frequency_filter(value) {
        //        $('.filter-period').addClass('hidden');
        //        $('#period-' + value).removeClass('hidden');
        //        $('#txt-filter-period').focus();
        //        issues_filter();
        //    }



        function action_filter() {
            var url = $("#frm_action_filter").attr("action");
            $.post(url, $("#frm_action_filter").serialize(), function (response) {
//                alert(response);
                $("#action_filter_list").html(response);
            });
//            setTimeout((function () {
//                obligations_filter();
//            }), 1000);
        }

    </script>