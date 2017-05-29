<?php $risk = $data['risks'] ?>
<div>

</div>
<div class="card-title">
    <ul class="nav nav-tabs tabs-risk" id="myTab" role="tablist">
        <li class="nav-item nav-risk">
            <a class="nav-link nav-risk active" id="home-tab" data-toggle="tab" href="#home"
               role="tab" aria-controls="home" aria-expanded="true"><i class="fa fa-list"></i> List</a>
        </li>
        <li class="nav-item nav-risk">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile"
               role="tab" aria-controls="profile"><i class="fa fa-fire"></i> Gross Risk</a>
        </li>
        <li class="nav-item nav-risk">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#dropdown1"
               role="tab" aria-controls="profile"><i class="fa fa-fire-extinguisher"></i> Control Ratings</a>
        </li>
        <li class="nav-item nav-risk">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#dropdown2"
               role="tab" aria-controls="profile"><i class="fa fa-fire"></i> Net Risk</a>
        </li>
    </ul>
</div>
<div class="tab-content " id="myTabContent">
    <div role="tabpanel" class="tab-pane fade in active" id="home"
         aria-labelledby="home-tab">
        <div id="list_risks_export" class="card card-block">
            <a class="btn btn-sm btn-primary pull-right m-b-10" id="list_risks_export_btn">Export to PDF</a>
            <table class="table table-hover table-sm table-small table-small-font " style="border-top: none" >
                <thead style="border-top: none">
                    <tr style="border-top: none">
                        <th style="width: 60px;"></th>
                        <th>Name</th>
                        <th class="text-center">Gross Risk</th>
                        <th class="text-center">Control Ratings</th>
                        <th class="text-center">Net Risk</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($risks as $key => $value): ?>
                        <tr>
                            <td><?= $value['heat_map_ref'] ?></td>
                            <td><a href="<?= base_url("index.php/Risk/risk/{$value['id']}") ?>"><?= $value['title']; ?></a></td>
                            <td  class="gross_risk-<?= strtolower(heatmap_key("gross_risk", $value['gross_risk'])) ?>"><span></span> <?= heatmap_key("gross_risk", $value['gross_risk']); ?></td>
                            <td class="control_ratings-<?= strtolower(heatmap_key("control_ratings", $value['control_ratings'])) ?>"><?= heatmap_key("control_ratings", $value['control_ratings']); ?></td>
                            <td class="net_risk-<?= strtolower(heatmap_key("net_risk", $value['net_risk'])) ?>"><?= heatmap_key("net_risk", $value['net_risk']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel"
         aria-labelledby="profile-tab">
        <div class="row" id="gross_risk_export"><a class="btn btn-sm btn-primary pull-right m-b-10 m-r-20" id="gross_risk_export_btn">Export to PDF</a>
            <!--<h4 hidden>Gross Risk Heatmap</h4>-->
            <div class="col-sm-12" > <?= gross_risk($risks) ?></div>
        </div>

    </div>
    <div class="tab-pane fade" id="dropdown1" role="tabpanel"
         aria-labelledby="dropdown1-tab">
        <div class="row" id="control_ratings_export"><a class="btn btn-sm btn-primary pull-right m-b-10 m-r-20" id="control_ratings_export_btn">Export to PDF</a>
            <div class="col-sm-12"><?= control_ratings($risks) ?></div>

        </div>
    </div>
    <div class="tab-pane fade" id="dropdown2" role="tabpanel"
         aria-labelledby="dropdown2-tab">
        <div class="row" id="net_risk_export"><a class="btn btn-sm btn-primary pull-right m-b-10 m-r-20" id="net_risk_export_btn">Export to PDF</a>
            <div class="col-sm-12"><?= net_risk($risks) ?></div>

        </div>
    </div>
</div>
<script>

var doc = new jsPDF();

$("#list_risks_export").css('background', '#fff');
$("#gross_risk_export").css('background', '#fff');
$("#control_ratings_export").css('background', '#fff');
$("#net_risk_export").css('background', '#fff');
$('#list_risks_export_btn').click(function () {
    doc.addHTML($('#list_risks_export')[0], function () {
        
     doc.save('List_Risks.pdf');
     
    });
});
$('#gross_risk_export_btn').click(function () {
    doc.addHTML($('#gross_risk_export')[0], function () {
        
     doc.save('Gross_Risk.pdf');
     
    });
});
$('#control_ratings_export_btn').click(function () {
    doc.addHTML($('#control_ratings_export')[0], function () {
        
     doc.save('control_ratings.pdf');
     
    });
});

$('#net_risk_export_btn').click(function () {
    doc.addHTML($('#net_risk_export')[0], function () {
        
     doc.save('net_risk.pdf');
     
    });
});
</script>