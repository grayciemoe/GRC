<?php
$incident_action = $data['action'];
// print_pre($incident_action);
//  die();
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Incident Report Details
                <span class="text-info">

                </span><br>
                <small class="font-11" style="font-size: 12px;"></small>
            </h4>
        </div>
        <div class="modal-body">
        
          
          <table class="table table-hover table-sm">
            <tbody>
              
              <tr>
                <th scope="row"> Title </th>
                <td> <?= $incident_action['title'] ?> </td>
              </tr>

               <tr>
                <th scope="row"> Owner </th>
                <td> <?= $incident_action['owner'] ?> </td>
              </tr>

               <tr>
                <th scope="row"> Due date </th>
                <td> <?= $incident_action['Due_date'] ?> </td>
              </tr>

               <tr>
                <th scope="row"> Completion </th>
                <td> <?= $incident_action['status'] ?> </td>
              </tr>
          </tbody>
        </table>
        </div>
        

        </div>
        <div class="modal-footer">
            <a class="btn btn-secondary-outline waves-effect fa fa-close" data-dismiss="modal">&nbsp;Close</a>
            
            <a <?= MODAL_AJAX ?> href="<?= base_url("index.php/IncidentManagement/createAction/{$incident_action["id"]}")?>" class="btn btn-primary-outline waves-effect fa fa-edit" data-dismiss="modal">&nbsp;Edit</a>
            
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
