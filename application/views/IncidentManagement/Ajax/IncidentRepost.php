<?php
$active_tab = $data['active_tab'];
$incident = $data['incidents'];
//   print_pre($incident); die();
$open = [];
$closed = [];
$near_miss = [];
$opportunity_cost = [];
$indirect_financial_loss = [];
$direct_financial_loss = [];
$risk_category_title = [];
$environment = [];
$category_sort = [];
$unit_sort = [];
$category = [];
$unit = [];
foreach ($incident as $key => $value):

    if ($value['incident'] == 'open') {
        $open [] = $value['incident'];
    } elseif ($value['incident'] == 'closed') {
        $closed [] = $value['incident'];
    }
    if ($value['experience_type'] == 'Near Miss') {
        $near_miss[] = $value['experience_type'];
    } elseif ($value['experience_type'] == 'Opportunity Cost') {
        $opportunity_cost [] = $value['experience_type'];
    } elseif ($value['experience_type'] == 'Indirect Financial Loss') {
        $indirect_financial_loss [] = $value['experience_type'];
    } elseif ($value['experience_type'] == 'Direct Financial Loss') {
        $direct_financial_loss [] = $value['experience_type'];
    }
    if (!isset($category_sort[$value['risk_category']['title']])) {
        $category_sort[$value['risk_category']['title']] = [];
    }
    if (!isset($unit_sort[$value['environment']['name']])) {
        $unit_sort[$value['environment']['name']] = [];
    }
    $category_sort[$value['risk_category']['title']][] = $value['total_cost'];
    $unit_sort[$value['environment']['name']][] = $value['id'];
    $risk_category_title [] = $value['risk_category']['title'];
    $environment [] = $value['environment']['name'];
endforeach;
//print_pre($unit_sort);
foreach ($category_sort as $key => $value) {
    $key_value = array_sum($value);
    if ($key_value > 0) {
        $category[$key] = $key_value;
    }
}
foreach ($unit_sort as $key => $value) {

    $key_value = count($value);
    $unit[$key] = $key_value;
}
//echo count($incident);
$experience_type = array(
    "Near Miss" => count($near_miss),
    "Opportunity Cost" => count($opportunity_cost),
    "Indirect Financial Loss" => count($indirect_financial_loss),
    "Direct Financial Loss" => count($direct_financial_loss)
);
//print_pre($experience_type);
?>
<div  class="report_details  <?= $active_tab == 'incidentReportTableView' ? NULL : "hidden" ?>" id="incidentReportTableView">
    <div id="im_report" class="table-responsive card-block">
        <a class="btn btn-sm btn-primary pull-right m-b-10" id="comp_table_report_export_btn">Export to PDF</a>
        <table id="datatable-buttons" class="table table-sm table-small table-hover " id="datatable-buttons" >
            <thead>
                <tr>

                    <th>Incident</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">State</th>
                    <th class="text-center">Approved</th>
                    <th class="text-center">Date of Incident</th>
                    <th class="text-center">Incident Category</th>
                    <th class="text-center">Experience Type</th>
                    <th class="text-center">Total Cost</th>
                    <th class="text-center">Area of Occurrence  </th>
                    <th class="text-center">Responsible Manager</th>
                    <th class="text-center">Escalation</th>
                    <th class="text-center">Risk</th>
                    <th class="text-center">Risk Category</th>
                    <th class="text-center">Risk Capacity</th>
                    <th class="text-center">Incidents to Date</th>
                    <th style="width:80px">Edit/Delete</th>

                </tr>
            </thead>
            <tbody><?php // print_pre($data['incidents'])                                         ?>

                <?php
                $count = 0;
                foreach ($data['incidents'] as $key => $value):
                    $count++;
                    $edit_link = base_url("index.php/IncidentManagement/incidentForm/{$value['id']}");
                    $delete_link = base_url("index.php/IncidentManagement/actionDelete/{$value['id']}");
                    $preview_link = base_url("index.php/IncidentManagement/incidentPreview/{$value['id']}");
                    $status_label = $value['status'] == "inactive" ? "info" : $value['status'] == "active" ? "success" : "warning";
                    $incident_label = $value['incident'] == "closed" ? "info" : $value['status'] == "open" ? "success" : "warning";
                    ?>
                    <tr>
                      
                        <td  >
                            <a class="link" href=" <?= base_url("index.php/IncidentManagement/incidentDetail/{$value['id']}"); ?>"><?= $value['title'] ?></a></td>
                        <td class="text-center ">
                            <span class="label label-pill label-<?= $status_label ?>">
                                <?= ucwords($value['status'])?>
                            </span>
                        </td>
                        <td class="text-center ">
                            <span class="label label-pill label-<?= $status_label ?>">
                                <?= ucwords($value['incident']) ?>
                            </span>
                        </td>
                        
                        <td class="text-center ">
<!--                            <span class="label label-pill label-<?= $status_label ?>">-->
                                <?= ucwords($value['approved']) ?>
                           
                        </td>
                        <td class="text-center " >
                            <span class="text-<?= strtotime($value['date_of_incident']) ?>"> 
                                <?= strftime(" %b %d %Y", strtotime($value['date_of_incident'])); ?>
                            </span>
                        </td>
                        <td ><?= $value['category']['title']?></td>
                        <td ><?= $value['experience_type'] ?></td>
                        <td ><?= $value['total_cost'] ?></td>
                        <td ><?= $value['environment']['name'] ?></td>
                        <td ><?= $value['responsible_manager']['names'] ?></td>
                        <td class="text-center "><?= ucwords(str_replace("_", " ", $value['escalation_level'])) ?></td>
                        <td ><?= $value['risk']['title'] ?></td>
                        <td ><?= $value['risk_category']['title'] ?></td>
                        <td ><?= $value['risk']['incidents_capacity'] ?></td>
                        <td ><?= isset($value['risk']['incidents']) ? count($value['risk']['incidents']) : 0; ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a class="btn btn-secondary btn-sm"  href="<?= $edit_link ?>"><i class="icon icon-pencil"></i> </a>
                                <a class="btn btn-secondary btn-sm"   href="<?= base_url("index.php/IncidentManagement/incidentDelete/{$value['id']}"); ?>" <?= MODAL_LINK ?>><i class="icon icon-trash"></i> </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div id="incidentReportChartView" class="report_details  <?= $active_tab == 'incidentReportChartView' ? NULL : "hidden" ?>">
    <!--CHARTS IN AJAX FILE-->
    <div class="row">
        

        <div id="comp_status_export" class="col-sm-4">
            <div class="row m-t-10">
                <h4 class="text-center"> Open Vs Closed Incidents</h4>
            </div>
          
            <?php
            $chart_id = "status";
            $data = array(
                array("name" => "Open", "value" => count($open), "color" => "#cc5555"),
                array("name" => "Closed", "value" => count($closed), "color" => "#55cc55"),
            );
            ?>
            <?= pie_chart_cs($chart_id, $data) ?>
            <div class="row m-t-10 text-muted">
                <h6 class="text-center">Summary</h6>
                <ul class="list-group" style="padding-left: 25px">
                    <li class="list-group-item">Open : <?= count($open)?></li>
                    <li class="list-group-item">Closed : <?= count($closed)?></li>
                </ul>
            </div>
        </div>
        <div id="comp_exType_export" class="col-sm-8">
            <div class="row m-t-10">
                <h4 class="text-center"> No. Incidences Vs Experience Type </h4>
            </div>
            <div class="row">
            <?php
            $array = array(
                array("series_name" => "Experience Type", "color" => "#999999", "data" => $experience_type,),
            );
            ?>
            <?= bar_graph_c3("experience_type", $array, 400); ?>
            </div>
        </div>
    </div>
    <br>
    <hr>
    <div class="row">
        
        <div id="comp_lossesPerCat_export" class="col-sm-6">
          <div class="row m-t-10">
                <h4 class="text-center"> Amount of Losses per Risk Category </h4>
            </div>
            <?php
            //print_pre($category);
            $array = array(
                array("series_name" => "Losses Per Risk Category", "color" => "#999999", "data" => $category,),
            );
            ?>
            <?= bar_graph_c3("Actual_Loss", $array); ?>
        </div>
        <div id="comp_incPerUnit_export" class="col-sm-6">
            <div class="row m-t-10">
                <h4 class="text-center"> No. Incidences per Unit </h4>
            </div>
            <?php
            $array = array(
                array("series_name" => "No Of Incidences Per Unit", "color" => "#999999", "data" => $unit,),
            );
            ?>
            <?= bar_graph_c3("No_of_Incidences", $array); ?>
        </div>


    </div>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').DataTable();
        //Buttons examples
        var table = $('#datatable-buttons').DataTable({
            lengthChange: true,
            buttons: ['copy', 'excel', 'colvis'],
             "columnDefs": [
                {"visible": false, "targets": [8,9,10,11]}
            ]
        });
        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });
    
       var doc = new jsPDF('landscape');
    $("#datatable-buttons").css('background', '#fff');
    $('#comp_table_report_export_btn').click(function () {
        $("#im_report").removeClass('table-responsive');
        $("#im_report").addClass('table');
        doc.addHTML($('#datatable-buttons')[0], function () {

            doc.save('Compliance_report_table.pdf');

        });
        $("#im_report").addClass('table-responsive');
    });
    
    
   $('svg').height(430);
</script>
