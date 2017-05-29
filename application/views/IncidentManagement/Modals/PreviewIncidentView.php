<?php
$incident_report = $data["incident"];
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
        <div class="row">
          <div class="col-sm-6">
          <table class="table table-hover table-sm">
            <tbody>
              <tr>
                <th scope="row"> Risk </th>
                <td> <?= $incident_report['risk'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Environment </th>
                <td> <?= $incident_report['environment'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Compliance </th>
                <td> <?= $incident_report['compliance'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Obligation </th>
                <td> <?= $incident_report['obligation'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Breach </th>
                <td> <?= $incident_report['breach'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Risk Level </th>
                <td> <?= $incident_report['risk_level'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Risk Category </th>
                <td> <?= $incident_report['risk_category'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Undefined Risk Title </th>
                <td> <?= $incident_report['undefined_risk_title'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Status </th>
                <td> <?= $incident_report['status'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Title </th>
                <td> <?= $incident_report['title'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Created </th>
                <td> <?= $incident_report['created'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Date of Incident </th>
                <td> <?= $incident_report['date_of_incident'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Escalation Level </th>
                <td> <?= $incident_report['escalation_level'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Responsible Manager </th>
                <td> <?= $incident_report['responsible_manager'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Reported by </th>
                <td> <?= $incident_report['reported_by'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Reporter Category </th>
                <td> <?= $incident_report['reporter_category'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Incident Owner </th>
                <td> <?= $incident_report['incident_owner'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Line of Business </th>
                <td> <?= $incident_report['line_of_business'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Branch </th>
                <td> <?= $incident_report['branch'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Department </th>
                <td> <?= $incident_report['department'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Risk Code </th>
                <td> <?= $incident_report['risk_code'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Start Date </th>
                <td> <?= $incident_report['start_date'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> End Date </th>
                <td> <?= $incident_report['end_date'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Detection Method </th>
                <td> <?= $incident_report['detection_method'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Experience Type </th>
                <td> <?= $incident_report['experience_type'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Category </th>
                <td> <?= $incident_report['category'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Incident </th>
                <td> <?= $incident_report['incident'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Total Cost </th>
                <td> <?= $incident_report['total_cost'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Maximum Potential Loss </th>
                <td> <?= $incident_report['maximum_potential_loss'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Expected Loss </th>
                <td> <?= $incident_report['expected_loss'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Cause Category </th>
                <td> <?= $incident_report['cause_category'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Source </th>
                <td> <?= $incident_report['source'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Action Due Date </th>
                <td> <?= $incident_report['action_due_date'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Actions Complete </th>
                <td> <?= $incident_report['actions_complete'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Approved </th>
                <td> <?= $incident_report['approved'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Draft </th>
                <td> <?= $incident_report['draft'] ?> </td>
              </tr>
              <tr>
                <th scope="row"> Attachments </th>
                <td> <?= $incident_report['attachments'] ?> </td>
              </tr>
          </tbody>
        </table>
        </div>
        <div class="col-sm-6">
          <h5>Description</h5>
          <hr />
          <p>
            <?= $incident_report['description'] ?>
          </p>
          <br />
          <h5>Cause</h5>
          <hr />
          <p>
            <?= $incident_report['cause'] ?>
          </p>
          <br />
          <h5>Actions</h5>
          <hr />
          <p>
            <?= $incident_report['actions'] ?>
          </p>
          
        </div>

        </div>
        <div class="modal-footer">
            <a class="btn btn-secondary-outline waves-effect fa fa-close" data-dismiss="modal">&nbsp;Close</a>
            <a <?= MODAL_AJAX ?> href="<?= base_url("index.php/IncidentManagement/incidentForm/{$incident_report["id"]}")?>" class="btn btn-primary-outline waves-effect fa fa-edit" data-dismiss="modal">&nbsp;Edit</a>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
