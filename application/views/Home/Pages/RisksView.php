<?php 
if (!am_user_type(array(7)) ) {
    restricted_view();
    return false;
}
?>    <?php
 $data['undefined'];

//print_pre($data);
//  exit;;
?>
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                <div class="card-title">Pending Actions</div>
                <ul class="nav nav-tabs m-b-10 unapproved-details-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="risk-tab" data-toggle="tab" href="#risk"
                                   role="tab" aria-controls="risk" aria-expanded="true">Risk</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="control-tab" data-toggle="tab" href="#control"
                                   role="tab" aria-controls="control" aria-expanded="true">  Control</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="control_activity-tab" data-toggle="tab" href="#control_activity"
                                   role="tab" aria-controls="control_activity">Control Activity</a>
                            </li>
                            
                        </ul>


                        <div class="tab-content" id="risk-tab">
                            <div role="tabpanel" class="tab-pane fade in active" id="risk" aria-labelledby="risk-tab">
                                <!-- <?= $risk['description'] ?> -->

                <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th> status</th>
                                                        <th> Approved</th>
                                                      
                                                        <th> risk Owner</th>
                                                       
                                                </thead>
                                        <tbody>
                                        <?php foreach ($data['risks'] as $key => $value): ?>
                                            
                                                <tr>
                                                    <td> <a href="<?= base_url("index.php/Risk/risk/{$value['id']}") ?>"><?= $value['title']; ?></a> </td>
                                                    <td> <?= $value ['status'] ?> </td>
                                                    <td> <?= $value ['approved'] ?> </td>
                                                    
                                                   
                                                    <td> <?= $value ['risk_owner'] ['names'] ?> </td>


                                                    
                                                </tr>
                                            <?php endforeach; ?> 

                                        </tbody>
                                    </table>
                            </div>
                            <div role="tabpanel" class="tab-pane fade " id="control" aria-labelledby="control-tab">
                                <!-- <?= $risk['event_of_risk'] ?> -->

                                <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>

                                                        <th><i class="icon icon-user"></i>&nbsp; Control Owner</th>
                                                        <th >  risk</th>
                                                        <th >  status</th>
                                                        <th > type</th>
                                                    </tr>
                                                </thead>
                                        <tbody>
                                            <?php foreach ($data['controls'] as $key => $value): ?> 
                                                <tr>
                                                    <td><a class="link" href=""><?= $value['title'] ?></a></td>
                                                    <td> <?= $value ['owner'] ?> </td>
                                                    <td> <?= $value ['risk'] ?> </td>
                                                    <td> <?= $value ['status'] ?> </td>
                                                    <td> <?= $value ['type'] ?> </td>
                                                    
                                                </tr>
                                      <?php endforeach; ?> 

                                        </tbody>
                                    </table>

                            </div>
                            <div class="tab-pane fade" id="control_activity" role="tabpanel" aria-labelledby="control_activity">
                                <!-- <?= $risk['effects_of_risk'] ?> -->

                                <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>

                                                        <th><i class="icon icon-user"></i>&nbsp; Control Owner</th>
                                                        <th >  control</th>
                                                        <th >  status</th>
                                                        <th > Review status</th>
                                                    </tr>
                                                </thead>
                                        <tbody>
                                            <?php foreach ($data['activities'] as $key => $value): ?> 
                                                <tr>
                                                    <td><a class="link" href=""><?= $value['title'] ?></a></td>
                                                    <td> <?= $value ['owner'] ?> </td>
                                                    <td> <?= $value ['control'] ?> </td>
                                                    <td> <?= $value ['status'] ?> </td>
                                                    <td> <?= $value ['review_status'] ?> </td>
                                                    
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



        <div class="row">
          <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                <div class="card-title">Unidentified Risks</div>
                <ul class="nav nav-tabs m-b-10 unapproved-details-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="risk-tab" data-toggle="tab" href="#risk"
                                   role="tab" aria-controls="risk" aria-expanded="true">Risk</a>
                            </li>
                            
                            
                        </ul>


                        <div class="tab-content" id="risk-tab">
                            <div role="tabpanel" class="tab-pane fade in active" id="risk" aria-labelledby="risk-tab">
                                <!-- <?= $risk['description'] ?> -->

                <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th> status</th>
                                                        <th> Approved</th>
                                                      
                                                        <th> risk Owner</th>
                                                       
                                                </thead>
                                        <tbody>
                                        <?php foreach ($data['undefined'] as $key => $value): ?>
                                            
                                                <tr>
                                                    <td> <a href="<?= base_url("index.php/Risk/risk/{$value['id']}") ?>"><?= $value['title']; ?></a> </td>
                                                    <td> <?= $value ['status'] ?> </td>
                                                    <td> <?= $value ['approved'] ?> </td>
                                                    
                                                   
                                                    <td> <?= $value ['risk_owner'] ['names'] ?> </td> 


                                                    
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
  
  