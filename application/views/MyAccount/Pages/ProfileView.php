<div class="container">
    <div class="row">
        <div class="col-sm-4 col-lg-3 col-xs-12">

            <div class="card">
                <img class="card-img-top img-fluid" src="<?= img_src($me['user']['profile_pic']); ?>" alt="Card image cap">
                <div class="card-block">
                    <h4 class="card-title"><?= $me['user']['names'] ?></h4>
                    <p class="card-text"><?= $me['user_type']['name'] ?></p>
                </div>
                <ul class="list-group list-group-flush hidden-lg-down hidden-md-up">
                    <li class="list-group-item">Finance</li>
                    <li class="list-group-item">Information Tech</li>
                </ul>
                <div class="card-block">
                    <a href="<?= base_url("index.php/Account/changePic"); ?>" <?= MODAL_LINK ?> class="card-link">Change Profile Pic</a>
                </div>
            </div>
        </div>

        <div class="col-sm-8 col-lg-9 col-xs-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Details</h4>
                    <h6 class="card-subtitle text-muted">Edit my account details</h6>
                </div>
                <div class="card-block">
                    <div class="p-20">
                        <?= form_open_multipart("Account/editMe"); ?>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 form-control-label">Username<span class="text-danger">*</span></label>
                            <div class="col-sm-7"> 
                                <input type="email" required="" name="" readonly="" value="<?= $me['user']['username'] ?>"  class="form-control" placeholder="Username" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 form-control-label">Names<span class="text-danger">*</span></label>
                            <div class="col-sm-7">
                                <input type="text" required="" name="names" value="<?= $me['user']['names'] ?>"  class="form-control" placeholder="Full Names" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 form-control-label">Phone<span class="text-danger"></span></label>
                            <div class="col-sm-7">
                                <input type="text" required="" name="phone"  value="<?= $me['user']['phone'] ?>" class="form-control" placeholder="Phone" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 form-control-label">Type<span class="text-danger">*</span></label>
                            <div class="col-sm-7">
                                <input type="text" required="" readonly="" name=""  value="<?= $me['user_type']['name'] ?>" class="form-control"  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-8 col-sm-offset-4">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    Save Changes
                                </button>
                                <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                    Reset
                                </button>
                            </div>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
                <div class="card-block" id="Change_Password">
                    <h4 class="card-title">Password Settings</h4>
                    <h6 class="card-subtitle text-muted">Change my account password</h6>
                </div>
                <div class="card-block">
                    <?php if (isset($data['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <?= $data['success'] ?>
                        </div>

                    <?php endif; ?>
                    <?php if (isset($data['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <?= $data['error'] ?>
                        </div>
                    <?php endif; ?>
                    <div class="p-20">
                        <?= form_open_multipart("Account/changePassword"); ?>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 form-control-label">Username<span class="text-danger">*</span></label>
                            <div class="col-sm-7"> 
                                <input type="email" required="" name="" readonly="" value="<?= $me['user']['username'] ?>"  class="form-control" placeholder="Username" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass1" class="col-sm-4 form-control-label">Old Password<span class="text-danger">*</span></label>
                            <div class="col-sm-7">
                                <input id="hori-pass1" type="password" name="oldPassword" placeholder="Password" required="" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass3" class="col-sm-4 form-control-label">New Password<span class="text-danger">*</span></label>
                            <div class="col-sm-7">
                                <input id="hori-pass3" type="password" name="newPassword" placeholder="Password" required="" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="confirmPassword" class="col-sm-4 form-control-label">Confirm Password
                                <span class="text-danger">*</span></label>
                            <div class="col-sm-7">
                                <input id="confirmPassword" type="password" required="" name="confirmPassword" placeholder="Password" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-8 col-sm-offset-4">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    Save Changes
                                </button>
                                <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                    Reset
                                </button>
                            </div>
                        </div>
                        <?= form_close(); ?>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>