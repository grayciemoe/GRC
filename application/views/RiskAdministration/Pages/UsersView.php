<?php
$user = $data['user'];

$user_type = $data['user_types'];

$me =  $data['me'];

//print_pre($me); 


?>

<div class="container">

    <div class="card">
        <div class="card-block">
            <h4 class="card-title">Users </h4> 
            <hr>
            <div class="row">
                    <div class="col-sm-4">
                        <table class="table table-small table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
               `                     <th>Names</th>
                                    <th class="text-center">User Type</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php
                                $count = 0;
                                foreach ($data['users'] as $key => $value):
                                    $count++;
                                    ?>
                                    <tr>
                                        <td><?= $count ?></td>
                                        <td><a href="<?= base_url("index.php/RiskAdministration/users/{$value['id']} "); ?>" ><?= $value['names'] ?></a></td>
                                        <td class="text-right"><?= $value['user_type']['name'] ?></td>
                                        <td>
                                        <div class="btn-group">
                                        <a class="btn btn-secondary btn-sm" <?= MODAL_LINK ?> href="<?= base_url("index.php/RiskAdministration/UsersForm/{$value['id']} "); ?> " ><i class="icon icon-pencil"></i> </a>
                                        <a class="btn btn-secondary btn-sm" <?= MODAL_LINK ?> href="<?= base_url("index.php/RiskAdministration/usersDelete/{$value['id']}"); ?>"><i class="icon icon-trash"></i> </a>
                                        </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>

                <div class="col-sm-8">

                    <div class="p-t-3 row">
                        <div class="col-sm-4 col-lg-3 col-xs-12">

                            <div class="card">
                                <img class="card-img-top img-fluid" src="<?= img_src($user['profile_pic']); ?>" alt="Card image cap">
                                
                                <div class="card-block">
                                    <h6 class="card-title"><?= $user['names']?></h6>
                                    <a href="<?= base_url("index.php/Account/changePic"); ?>" <?= MODAL_LINK ?> class="card-link">Change Profile Pic</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-8 col-lg-9 col-xs-12">
                            <div class="card">
                                <div class="card-block">

                                    <div class="p-20">
                                     <div class="form-group row">
                                            <label  class="col-sm-4 form-control-label">Username</label>
                                            <div class="col-sm-7"> 
                                                <input type="email" required="" name="" readonly=""  value="<?= $user['username'] ?>"  class="form-control" placeholder="Username" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label  class="col-sm-4 form-control-label">Names</label>
                                            <div class="col-sm-7">
                                                <input type="text" required="" name="names" readonly=""  value="<?= $user['names'] ?>"  class="form-control" placeholder="Full Names" >
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label  class="col-sm-4 form-control-label">Phone</label>
                                            <div class="col-sm-7">
                                                <input type="text" required="" name="phone" readonly=""   value="<?= $user['phone'] ?>" class="form-control" placeholder="Phone" >
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label  class="col-sm-4 form-control-label">Type</label>
                                            <div class="col-sm-7">
                                                <input type="text" required=""  name="" readonly=""  value="<?= $user['name'] ?>" class="form-control"  >
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                            </div>

                        </div>

                    </div>

                <div class=" row card">
                        <ul class="nav nav-tabs nav-tabs-alt nav-justified " id="myTab" role="tablist">

                            <li class="nav-item ">
                                <a class="nav-link active" id="risk-tab" data-toggle="tab" href="#risks"
                                   role="tab" aria-controls="risk" aria-expanded="true"><i class="fa fa-dashboard "></i> Risks</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="compliance-tab" data-toggle="tab" href="#compliance"
                                   role="tab" aria-controls="compliance"><i class="fa fa-dashboard "></i> Compliance</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="incident_management-tab" data-toggle="tab" href="#incident_management"
                                   role="tab" aria-controls="incident_management"> <i class="fa fa-dashboard"></i> Incident Management</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="audit-tab" data-toggle="tab" href="#audit"
                                   role="tab" aria-controls="audit"><i class="fa fa-dashboard "></i> Audit</a>
                            </li>

                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div role="tabpanel" class="tab-pane fade in active" id="all_risks"
                                 aria-labelledby="home-tab">

                            </div>
                         
                        </div>
                </div>


                </div>
            </div>




        </div>
    </div>

</div>
<script src="<?= base_url("assets/js/jquery.min.js") ?>"></script>
<script src="<?= base_url("assets/js/tether.min.js") ?>"></script><!-- Tether for Bootstrap -->
<script src="<?= base_url("assets/js/bootstrap.min.js") ?>"></script>
<script src="<?= base_url("assets/js/waves.js") ?>"></script>
<script src="<?= base_url("assets/js/jquery.nicescroll.js") ?>"></script>
<script src="<?= base_url("assets/plugins/switchery/switchery.min.js") ?>"></script>


<!-- App js -->
<script src="<?= base_url("assets/js/jquery.core.js") ?>"></script>
<script src="<?= base_url("assets/js/jquery.app.js") ?>"></script>
