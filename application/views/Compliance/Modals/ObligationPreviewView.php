<?php
$obligations = $data['obligations'];
$obligations = $obligations['obligation'];
//   print_pre($obligations);
//   die();
?>
<div class="modal-dialog card modal-lg">
    <div class="modal-content">
        <div class="modal-header obligation-preview">
            <button type="button " class="close btn-secondary" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
            <h4 class="modal-title " id="myModalLabel">Obligation Details Preview</h4>
        </div>
        <div class="modal-body">
      
         <?php
         $priority_label = $obligations['priority'] == "low" ? "info" : $obligations['priority'] == "medium" ? "warning" : "danger";
         $active_label = $obligations['status'] == "active" ? "info" : $obligations['status'] == "inactive" ? "warning" : "danger";
         $complied_label = $obligations['complied'] == "yes" ? "primary" : $obligations['complied'] == "no" ? "warning" : "danger";
         $approved_label = $obligations['approved'] == "approved" ? "primary" : $obligations['approved'] == "not_approved" ? "warning" : "danger";
         ?>
       
                    
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <th> Title</th>  <td> 
                                    <a href="<?= base_url("index.php/Compliance/obligation/{$obligations['id']}") ?>"><?=$obligations ['title'] ?></a>
                                </td>
                            </tr>
                            <tr>
                                <th> Compliance Requirement</th>  <td> <?=$obligations ['compliance_requirement']['title'] ?></td>
                            </tr>
                            <tr>
                                <th> Compliance Requirement Type</th>  <td> <?=$obligations ['compliance_requirement']['type'] ?></td>
                            </tr>
                            <tr>
                                <th> Short Code</th>  <td> <?=$obligations ['short_code'] ?></td>
                            </tr>

                            <tr>
                                <th> Primary Responsible Manager</th>  <td> <?=$obligations ['responsible_manager_1']['names'] ?></td>
                            </tr>

                            <tr>
                                <th> Secondary Responsible Manager</th>  <td> <?=$obligations ['responsible_manager_2']['names'] ?></td>
                            </tr>
                            <tr>
                                <th> Escalation Person</th>  <td> <?=$obligations ['escalation_person']['names'] ?></td>
                            </tr>
                             <tr>
                                <th> Frequency</th>  <td> <?= ucwords($obligations ['frequency']) ?></td>
                            </tr>
                            <tr>
                                <th> Repeat</th>  <td> <?= ucwords($obligations ['repeat']) ?></td>
                            </tr>

                            <tr>
                                <th> Priority</th>  <td> 
                                <span class="label label-pill label-<?= $priority_label ?>">
                                    <?= ucwords($obligations['priority']) ?>
                                    </span></td>
                            </tr>

                            <tr>
                                <th> Status</th>  <td> 
                                <span class="label label-pill label-<?= $active_label ?>">
                                    <?= ucwords($obligations['status']) ?>
                                    </span></td>
                            </tr>
                            
                            <tr>
                                <th> Approved</th>  
                                <td> 
                                <span class="label label-pill label-<?= $approved_label ?>">
                                    <?= ucwords($obligations['approved']) ?>
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th> Complied</th>  <td> 
                                <span class="label label-pill label-<?= $complied_label ?>">
                                    <?= ucwords($obligations['complied']) ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Next Review date</th>  <td> <?= strftime("%b %d %Y", strtotime($obligations ['next_review'])) ?></td>
                            </tr>

                            <tr>
                                <th>Next Submission </th>  <td> <?= strftime("%b %d %Y", strtotime($obligations ['submission_deadline'])) ?></td>
                            </tr>

                            <tr>
                                <th>Non-compliance penalty</th>  <td> <?=$obligations ['noncompliance_penalty'] ?></td>
                            </tr>

                            <tr>
                                <th>Non-compliance consequence</th>  <td> <?=$obligations ['noncompliance_consequence'] ?></td>
                            </tr>
                            <tr>
                                <th>Description</th>  
                                <td> <?=$obligations ['description'] ?></td>
                            </tr>
                        </tbody>

                    </table>
                </div>
        <div class="modal-footer">
            <a class="btn btn-block btn-lg btn-default" href="<?= base_url("index.php/Compliance/obligation/{$obligations['id']}") ?>">Read More</a>
        </div>
</div>
       
         
                 


         
         
      
        
        </div><!--end of card-->
          
        </div>
        
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->