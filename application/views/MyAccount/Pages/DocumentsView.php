<div class="container">

    <div class="card">

        <div class="card-block">

            <div class="row">
                <div class="col-sm-4">

                    <ul class="nav nav-tabs nav-pills nav-stacked m-b-10" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#all"
                               role="tab" aria-controls="home" aria-expanded="true">All</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#risk"
                               role="tab" aria-controls="profile">Risk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#im"
                               role="tab" aria-controls="profile">Incident Management</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#compliance"
                               role="tab" aria-controls="profile">Compliance</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#audit"
                               role="tab" aria-controls="profile">Audit</a>
                        </li>

                    </ul>
                </div>
                <div class="col-sm-8">
                    <div class="tab-content" id="myTabContent">
                        <div role="tabpanel" class="tab-pane fade" id="all" aria-labelledby="home-tab" aria-expanded="false">
                            <table class="table table-striped table-condensed table-sm ">
                                <thead>
                                    <tr>
                                        <th style="width:40px;">#</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Size</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['files']['all'] as $key => $value): ?>
                                        <tr class="upload_<?= $value['id'] ?>">
                                            <td scope="row"> <?= $key + 1 ?></td>
                                            <td> <?= $value['title'] ?></td>
                                            <td> <?= $value['filetype'] ?></td>
                                            <td> <?= getFileSize($value['filename']) ?> </td>
                                            <td style="widtd:170px;">
                                                <div class="btn-group btn-group-sm pull-right">
                                                    <a class="btn btn-dark-outline waves-effect waves-light" <?= MODAL_LINK ?> href="<?= base_url("index.php/Documents/previewFile/{$value['id']}") ?>"><i class="icon ion-eye"></i></a>
                                                    <a class="btn btn-success-outline waves-effect waves-light" download="<?= $value['title'] ?>"href="<?= base_url(getFileLink($value['filename'])) ?>" ><i class="icon ion-android-download"></i></a>
                                                    <a class="btn btn-warning-outline waves-effect waves-light" <?= MODAL_LINK ?> href="<?= base_url("index.php/Documents/editDocument/{$value['id']}") ?>"><i class="icon icon-pencil"></i></a>
                                                    <a class="btn btn-danger-outline waves-effect waves-light" <?= MODAL_LINK ?> href="<?= base_url("index.php/Documents/deleteDocument/{$value['id']}") ?>"><i class="icon icon-trash"></i></a>
                                                </div>
                                            </td>


                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade active in" id="risk" role="tabpanel" aria-labelledby="profile-tab" aria-expanded="true">
                            <table class="table table-striped table-condensed table-sm ">
                                <thead>
                                    <tr>
                                        <th style="width:40px;">#</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Size</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['files']['risk'] as $key => $value): ?>
                                        <tr class="upload_<?= $value['id'] ?>">
                                            <td scope="row"> <?= $key + 1 ?></td>
                                            <td> <?= $value['title'] ?></td>
                                            <td> <?= $value['filetype'] ?></td>
                                            <td> <?= getFileSize($value['filename']) ?> </td>
                                            <td style="widtd:170px;">
                                                <div class="btn-group btn-group-sm pull-right">
                                                    <a class="btn btn-dark-outline waves-effect waves-light" <?= MODAL_LINK ?> href="<?= base_url("index.php/Documents/previewFile/{$value['id']}") ?>"><i class="icon ion-eye"></i></a>
                                                    <a class="btn btn-success-outline waves-effect waves-light" download="<?= $value['title'] ?>"href="<?= base_url(getFileLink($value['filename'])) ?>" ><i class="icon ion-android-download"></i></a>
                                                    <a class="btn btn-warning-outline waves-effect waves-light" <?= MODAL_LINK ?> href="<?= base_url("index.php/Documents/editDocument/{$value['id']}") ?>"><i class="icon icon-pencil"></i></a>
                                                    <a class="btn btn-danger-outline waves-effect waves-light" <?= MODAL_LINK ?> href="<?= base_url("index.php/Documents/deleteDocument/{$value['id']}") ?>"><i class="icon icon-trash"></i></a>
                                                </div>
                                            </td>


                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="im" role="tabpanel" aria-labelledby="dropdown1-tab" aria-expanded="false">
                            <table class="table table-striped table-condensed table-sm ">
                                <thead>
                                    <tr>
                                        <th style="width:40px;">#</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Size</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['files']['incident_management'] as $key => $value): ?>
                                        <tr class="upload_<?= $value['id'] ?>">
                                            <td scope="row"> <?= $key + 1 ?></td>
                                            <td> <?= $value['title'] ?></td>
                                            <td> <?= $value['filetype'] ?></td>
                                            <td> <?= getFileSize($value['filename']) ?> </td>
                                            <td style="widtd:170px;">
                                                <div class="btn-group btn-group-sm pull-right">
                                                    <a class="btn btn-dark-outline waves-effect waves-light" <?= MODAL_LINK ?> href="<?= base_url("index.php/Documents/previewFile/{$value['id']}") ?>"><i class="icon ion-eye"></i></a>
                                                    <a class="btn btn-success-outline waves-effect waves-light" download="<?= $value['title'] ?>"href="<?= base_url(getFileLink($value['filename'])) ?>" ><i class="icon ion-android-download"></i></a>
                                                    <a class="btn btn-warning-outline waves-effect waves-light" <?= MODAL_LINK ?> href="<?= base_url("index.php/Documents/editDocument/{$value['id']}") ?>"><i class="icon icon-pencil"></i></a>
                                                    <a class="btn btn-danger-outline waves-effect waves-light" <?= MODAL_LINK ?> href="<?= base_url("index.php/Documents/deleteDocument/{$value['id']}") ?>"><i class="icon icon-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        </div>
                        <div class="tab-pane fade" id="audit" role="tabpanel" aria-labelledby="dropdown2-tab">
                            <table class="table table-striped table-condensed table-sm ">
                                <thead>
                                    <tr>
                                        <th style="width:40px;">#</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Size</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['files']['audit'] as $key => $value): ?>
                                        <tr class="upload_<?= $value['id'] ?>">
                                            <td scope="row"> <?= $key + 1 ?></td>
                                            <td> <?= $value['title'] ?></td>
                                            <td> <?= $value['filetype'] ?></td>
                                            <td> <?= getFileSize($value['filename']) ?> </td>
                                            <td style="widtd:170px;">
                                                <div class="btn-group btn-group-sm pull-right">
                                                    <a class="btn btn-dark-outline waves-effect waves-light" <?= MODAL_LINK ?> href="<?= base_url("index.php/Documents/previewFile/{$value['id']}") ?>"><i class="icon ion-eye"></i></a>
                                                    <a class="btn btn-success-outline waves-effect waves-light" download="<?= $value['title'] ?>"href="<?= base_url(getFileLink($value['filename'])) ?>" ><i class="icon ion-android-download"></i></a>
                                                    <a class="btn btn-warning-outline waves-effect waves-light" <?= MODAL_LINK ?> href="<?= base_url("index.php/Documents/editDocument/{$value['id']}") ?>"><i class="icon icon-pencil"></i></a>
                                                    <a class="btn btn-danger-outline waves-effect waves-light" <?= MODAL_LINK ?> href="<?= base_url("index.php/Documents/deleteDocument/{$value['id']}") ?>"><i class="icon icon-trash"></i></a>
                                                </div>
                                            </td>


                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


</div>



<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/tether.min.js"></script><!-- Tether for Bootstrap -->
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/jquery.nicescroll.js"></script>
<script src="assets/plugins/switchery/switchery.min.js"></script>

<!-- App js -->
<script src="assets/js/jquery.core.js"></script>
<script src="assets/js/jquery.app.js"></script>
