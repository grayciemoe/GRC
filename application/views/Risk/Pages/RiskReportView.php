<?php
//print_pre($data);
//exit;
if (!am_user_type(array(1, 9, 6, 5))) {
    restricted_view();
    return false;
}
?>  <div class="container-fluid">
    <div class="card card-header bg-light">
        <h4 class="card-title">Risk Report</h4>
    </div>
    <div class="card">
        <?php // print_pre($data); ?>

        <hr class="m-0">
        <div class="card-block">
            <div id="table_risk" class="table-responsive">
                <a class="btn btn-sm btn-primary pull-right m-b-10" id="risk_table_report_export_btn">Export to PDF</a>
                <table class="table table-striped table-sm table-small" id="datatable-buttons">
                    <thead>
                        <tr>
                            <th>REF code</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Business unit</th>
                            <th>Management Control Capability</th>
                            <th>Risk Source</th>
                            <th>Key Risk Area</th>
                            <th>Risk Category</th>
                            <th>Risk Sub Category 1</th>
                            <th>Risk Sub Category 2</th>
                            <th>Owner</th>
                            <th>Probability</th>
                            <th>Impact</th>
                            <th>Gross Risk</th>
                            <th>Control Ratings</th>
                            <th>Net Risk</th>
                            <th>Control adequacy </th>
                            <th>Control Effectiveness</th>
                            <th>Proposed Controls</th>
                            <th>Controls in Place</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        foreach ($data['risks'] as $key => $value):
                            $count++;
                            $edit_link = base_url("index.php/Risk/riskForm/{$value['id']}");
                            $delete_link = base_url("index.php/Risk/riskDeleteAjax/{$value['id']}");
                            ?>
                            <tr id="risk-<?= $value['id'] ?>">
                                <td><?= $value['heat_map_ref']; ?></td>
                                <td><a title="<?= strip_tags(($value['description'])) ?>"
                                       href="<?= base_url("index.php/Risk/risk/{$value['id']}") ?>" > <?= $value['title'] ?></a></td>
                                <td><?= $value['description'] ?></td>
                                <td><?= $value['environment']['name'] ?></td>
                                <td><?= $value['management_control'] ?></td>
                                <td><?= ucwords(str_replace("_", " ", $value['repository']['source'])) ?></td>
                                <td><?= $value['repository']['name'] ?></td>
                                <td><?php
                                    if (isset($value['category'][2])) {
                                            echo $value['category'][1]['title'];
                                    } else {
                                            echo $value['category'][0]['title'];
                                    }
                                    ?></td>
                                <td><?php
                                    if (isset($value['category'][1])) {
                                        if (isset($value['category'][2])) {
                                                echo $value['category'][0]['title'];
                                        } else {
                                                echo $value['category'][1]['title'];
                                        }
                                    }
                                    ?></td>
                                <td><?php
                                    if (isset($value['category'][2])) {
                                            echo $value['category'][2]['title'];
                                    }
                                    ?></td>
                                <td><?= $value['risk_owner']['names'] ?></td>
                                <td><?= ucwords(heatmap_key("probability", $value['probability'])) ?></td>
                                <td><?= ucwords(heatmap_key("impact", $value['impact'])) ?></td>
                                <td class="gross_risk-<?= strtolower(heatmap_key("gross_risk", $value['gross_risk'])) ?>"><?= heatmap_key("gross_risk", $value['gross_risk']) ?></td>
                                <td class="control_ratings-<?= strtolower(heatmap_key("control_ratings", $value['control_ratings'])) ?>"><?= heatmap_key("control_ratings", $value['control_ratings']) ?></td>
                                <td class="net_risk-<?= strtolower(heatmap_key("net_risk", $value['net_risk'])) ?>"><?= heatmap_key("net_risk", $value['net_risk']) ?></td>
                                <td><?= ucwords(heatmap_key("adequacy", $value['adequacy'])) ?></td>
                                <td><?= ucwords(heatmap_key("effectiveness", $value['effectiveness'])) ?></td>

                                <td><ul>
                                        <?php
                                        foreach ($value['controls']['proposed'] as $key => $ctrl) {
                                            echo "<li>{$ctrl['title']}</li>";
                                        }
                                        ?>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        <?php
                                        foreach ($value['controls']['in place'] as $key => $ctrl) {
                                            echo "<li>{$ctrl['title']}</li>";
                                        }
                                        ?>
                                    </ul>
                                </td>
                                <td>
                                    <div class="btn-group">

                                        <a href="<?= $delete_link ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm btn-small"><i class="icon icon-trash"></i></a>
                                        <a href="<?= $edit_link ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm btn-small"><i class="icon icon-pencil"></i></a>
                                    </div>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>

        </div>

    </div> 
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').DataTable();

        //Buttons examples
        var table = $('#datatable-buttons').DataTable({
            lengthChange: true,
            "scrollX": false,
            buttons: ['copy', 'excel', 'colvis'],
            "columnDefs": [
                {"visible": false, "targets": [2, 16, ]}
            ]
        });

        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });
    var doc = new jsPDF('landscape');
    $("#datatable-buttons").css('background', '#fff');
    $('#risk_table_report_export_btn').click(function () {
        $("#table_risk").removeClass('table-responsive');
        $("#table_risk").addClass('table');
        doc.addHTML($('#datatable-buttons')[0], function () {

            doc.save('Risk_report_table.pdf');

        });
        $("#table_risk").addClass('table-responsive');
    });

</script>
<script>
//tooltip 
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    })
</script>
