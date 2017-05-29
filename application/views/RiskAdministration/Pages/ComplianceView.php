    <?php
    $data['complies'];   //print_pre($data['breaches']);
    ?>
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                <ul class="nav nav-tabs m-b-10 unapproved-details-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="risk-tab" data-toggle="tab" href="#risk"
                                   role="tab" aria-controls="risk" aria-expanded="true">Breaches</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="control-tab" data-toggle="tab" href="#control"
                                   role="tab" aria-controls="control" aria-expanded="true">Complies</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="obligation-tab" data-toggle="tab" href="#obligation"
                                   role="tab" aria-controls="obligation" aria-expanded="true">Obligations</a>
                            </li>
                            
                        </ul>


                        <div class="tab-content" id="risk-tab">
                            <div role="tabpanel" class="tab-pane fade in active" id="risk" aria-labelledby="risk-tab">
                                <!-- <?= $risk['description'] ?> -->

                <table id="datatable-buttons2"  class="table table-small-font  table-small table-sm table  table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th> status</th>
                                                        <th> Approved</th>
                                                        <th> Type</th>
                                                        <th>Date Created</th>
                                                        
                                                       
                                                </thead>
                                        <tbody>
                                        <?php foreach ($data['breaches'] as $key => $value): 

                                        $status_label = $value['status'] == "open" ? "danger" : $value['status'] == "closed" ? "danger" : "warning";
                              
                                        ?>
                                            
                                                <tr>
                                                    <td> <a class="link" href="<?= base_url("index.php/Compliance/breach/{$value['id']}"); ?>" <?= MODAL_LINK ?>><?= $value ['title'] ?></a> </td>
                                                    <td> 
                                                    <span class="label label-pill label-<?= $status_label ?>">
                                                    <?= ucwords($value ['status']) ?> </span></td>
                                                    <td><span class="label label-pill label-<?=
                                                $value['approved'] == 'pending' ? "warning" :
                                                        "success"
                                                            ?>" ><?= ucwords($value ['approved']) ?> </td>
                                                    
                                                    <td> <?= $value ['type'] ?> </td>
                                                    <td> <?= strftime("%b %d %Y",strtotime($value ['created'])); ?> </td>
                                                    


                                                    
                                                </tr>
                                            <?php endforeach; ?> 

                                        </tbody>
                                    </table>
                            </div>
                            <div role="tabpanel" class="tab-pane fade " id="control" aria-labelledby="control-tab">
                                <!-- <?//= $risk['event_of_risk'] ?> -->

                                <table id="datatable-buttons1"  class="table table-small-font  table-small table-sm table  table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Approved Status</th>
                                                        <th>Completion</th>
                                                        <th>Period Name</th>
                                                        <th>Date Updated</th>
                                                       
                                                </thead>
                                        <tbody>
                                        <?php
                                        foreach ($data['complies'] as $key => $value): ?>
                                            
                                                <tr>
                                                    <td> <a class="link" href="<?= base_url("index.php/Compliance/compliant/{$value['id']}"); ?>" <?= MODAL_LINK ?>><?= $value ['title'] ?></a> </td>
                                                    <td> <span class="label label-pill label-<?=
                                                $value['approved'] == 'pending' ? "warning" :
                                                        "success"
                                                            ?>" ><?= ucwords($value ['approved']) ?> </span></td>
                                                    
                                                   
                                                    <td> <?= ucwords($value ['completion']) ?> </td>
                                                    
                                                    <td> <?= $value ['period_name'] ?> </td>
                                                    <td><?= strftime("%b %d %Y",strtotime($value ['updated'])); ?></td>
                                                    


                                                    
                                                </tr>
                                            <?php endforeach; ?> 

                                        </tbody>
                                    </table>

                            </div>
                            
                            <div role="tabpanel" class="tab-pane fade " id="obligation" aria-labelledby="obligation-tab">
                                <!-- <?//= $risk['event_of_risk'] ?> -->
<?php //print_pre($data['obligations'])?>
                                <table id="datatable-buttons"  class="table table-small-font  table-small table-sm table  table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Approval</th>
                                                        <th>Status</th>
                                                        <th>State</th>
                                                        <th>Date Created</th>
                                                       
                                                </thead>
                                        <tbody>
                                        <?php foreach ($data['obligations'] as $key => $value): ?>
                                            
                                                <tr>
                                                    <td> <a class="link" href="<?= base_url("index.php/Compliance/obligation/{$value['id']}"); ?>"><?= $value ['title'] ?></a> </td>
                                                    <td><span class="label label-pill label-<?=
                                                $value['approved'] == 'pending' ? "warning" :
                                                        "success"
                                                            ?>" ><?= ucwords($value ['approved']) ?> </td>
                                                    <td> <?= ucwords($value ['status']) ?> </td>
                                                    <td> <?= $value ['complied'] ?> </td>
                                                    <td><?= strftime("%b %d %Y",strtotime($value ['created'])); ?></td>
                                                    


                                                    
                                                </tr>
                                            <?php endforeach; ?> 

                                        </tbody>
                                    </table>

                            </div>

                                
                            </div>
                        
                    </div><!--block-->
                    </div><!--card-->
                </div><!--col -->
            </div><!-- content-page -->

            <!-- ============================================================== -->
        </div>
      
        
        <script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').DataTable();
        


        //Buttons examples
        var table = $('#datatable-buttons').DataTable({
            lengthChange: false,
            // buttons: ['excel', 'pdf', 'colvis'],
            ColumnDefs: [
                {'Sortable': false, 'orderable': false, 'Targets': [-1]}
            ]
        });


        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });


    $(document).ready(function () {
        $('#datatable').DataTable();
        


        //Buttons examples
        var table = $('#datatable-buttons1').DataTable({
            lengthChange: false,
            // buttons: ['excel', 'pdf', 'colvis'],
            ColumnDefs: [
                {'Sortable': false, 'orderable': false, 'Targets': [-1]}
            ]
        });


        table.buttons().container()
                .appendTo('#datatable-buttons1_wrapper .col-md-6:eq(0)');
    });

$(document).ready(function () {
        $('#datatable').DataTable();
        


        //Buttons examples
        var table = $('#datatable-buttons2').DataTable({
            lengthChange: false,
            // buttons: ['excel', 'pdf', 'colvis'],
            ColumnDefs: [
                {'Sortable': false, 'orderable': false, 'Targets': [-1]}
            ]
        });


        table.buttons().container()
                .appendTo('#datatable-buttons2_wrapper .col-md-6:eq(0)');
    });

</script>

        
   
