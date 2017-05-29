
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"><?= $data['file']['title'] ?></h4>
        </div>
        <div class="modal-body">


            <div class="row">
                <div class="col-sm-8">
                    <p><?= $data['file']['caption'] ?></p>



                </div>
                <div class="col-sm-4">
                    <table class="table table-condensed table-small-font table-sm">
                        <tbody>
                            <tr>
                                <td><strong>Module </strong></td>
                                <td><?= $data['file']['module'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Item </strong></td>
                                <td><?= $data['file']['table_name'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Uploaded By </strong></td>
                                <td><?= $data['file']['user'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>File Size </strong></td>
                                <td><?= getFileSize($data['file']['filename']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Created </strong></td>
                                <td><?= strftime("%Y %b %d", $data['file']['created']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Modified </strong></td>
                                <td><?= strftime("%Y %b %d", $data['file']['modified']) ?></td>
                            </tr>

                        </tbody>

                    </table>
                </div>
            </div>    
            <div class="form-group">
                <label class="control-label col-sm-1">File URL</label>
                <div class="col-sm-11"> <input class="form-control form-control-sm" style="background: none; border-width: 0; border-bottom-width: 1px;" readonly="" value="<?= getFileLink($data['file']['filename']) ?>" />
                </div>

            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
