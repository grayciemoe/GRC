
<div class="account-pages" style=" background: #f7f7f4;"></div>
<div class="clearfix"></div>
<div class="wrapper-page" >
    <div class="account-bg" >
        <div class="card-box m-b-0" style="border: 5px solid #2b3d51;">
            <div class="text-xs-center m-t-20">
                <a href="<?= base_url("Login"); ?>" class="logo">
                    <img src="<?= base_url("assets/images/eMo-Logo1.png"); ?>" alt="Logo"/>
<!--                    <span>GRC</span>-->
                </a>
            </div>
            <div class="m-t-10 p-20">
                <div class="row">
                    <div class="col-xs-12 text-xs-center">
                        <h6 class="text-muted text-uppercase m-b-10 m-t-0">Reset Password</h6>
                    </div>
                </div>
                <?= validation_errors() ?>
                <?= form_open_multipart("Login/passwordrecovery/", "m-t-20") ?>
                <?php if ($this->input->get("message")): ?>
                    <div class="alert alert-warning alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <?= $this->input->get("message"); ?>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-xs-12 text-xs-center">
                        <p class="text-muted m-b-0 font-13 m-t-20">Enter your email address and we'll send you an email with instructions to reset your password.  </p>
                    </div>
                </div>

                <div class="form-group row m-t-30">
                    <div class="col-xs-12">
                        <input class="form-control" name="username" type="text" required="" placeholder="Enter Email">
                    </div>
                </div>

                <div class="form-group text-center row m-t-10">
                    <div class="col-xs-12">
                        <button class="btn btn-block waves-effect waves-light" style="background-color: #0054a4; color: #ffffff;" type="submit">Send Email</button>
                    </div>
                </div>

                <div class="form-group row m-t-30 m-b-0">
                    <div class="col-sm-12">
                        <a href="<?= base_url("index.php/Login/"); ?>" class="text-muted"><i class="fa fa-lock m-r-5"></i> Sign In</a>
                    </div>
                </div>

                <?= form_close(); ?>

            </div>

            <div class="clearfix"></div>
        </div>
    </div>
    <!-- end card-box-->


</div>
<!-- end wrapper page -->

