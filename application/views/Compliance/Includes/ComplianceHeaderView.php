
<div class="bg-faded">
    <!-- end topbar-main -->
    <div class="container ">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <?php if (am_user_type(array(1, 5))): ?>
                    <div class="btn-group pull-right m-t-10">
                        <div class="dropdown-menu">
                            <?php if (am_user_type(array(1, 5))): ?>
                                <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= base_url("index.php/Home/repositoryForm/0/strategic_objectives"); ?>">Strategic Objective</a>
                            <?php endif; ?>
                            <?php if (am_user_type(array(1, 5))): ?>
                                <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= base_url("index.php/Home/repositoryForm/0/corporate_policy"); ?>">Corporate Policy</a>
                            <?php endif; ?>
                            <?php if (am_user_type(array(1, 5))): ?>
                                <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= base_url("index.php/Home/repositoryForm/0/process"); ?>">Process</a>
                            <?php endif; ?>
                            <?php if (am_user_type(array(1, 5))): ?>
                                <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= base_url("index.php/Home/repositoryForm/0/laws_and_regulations"); ?>">Law and Regulation</a>
                            <?php endif; ?>
                            <?php if (am_user_type(array(1, 5))): ?>
                                <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= base_url("index.php/Home/repositoryForm/0/contract"); ?>">Contract</a>
                            <?php endif; ?>
                            <?php if (am_user_type(array(1, 5))): ?>
                                <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= base_url("index.php/Home/repositoryForm/0/best_practices"); ?>">Best Practice</a>
                            <?php endif; ?>


                        </div>
                        <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light"
                                data-toggle="dropdown" aria-expanded="false">
                            <span class=""><i class="zmdi zmdi-plus-box"></i></span> Source Document</button>
                    </div>
                <?php endif; ?>

                <span class=" pull-right text-hidden"> .</span>
                <?php if (am_user_type(array(1, 6, 5))): ?>
                    <div class="btn-group pull-right m-t-10">

                        <div class="dropdown-menu">
                            <?php if (am_user_type(array(1, 5))): ?>
                                <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= base_url("index.php/Compliance/registerForm/0"); ?>">Compliance Register</a>
                            <?php endif; ?>
                            <?php if (am_user_type(array(1, 5))): ?>
                                <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= base_url("index.php/Compliance/complianceRequirementForm/0"); ?>">Compliance Requirement</a>
                            <?php endif; ?>
                            <?php if (am_user_type(array(1, 5))): ?>
                                <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= base_url("index.php/Compliance/authorityForm/0"); ?>">Authority</a>
                            <?php endif; ?>
                            <?php if (am_user_type(array(1, 5, 6, 10))): ?>
                                <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= base_url("index.php/Compliance/obligationForm/0"); ?>">Obligation</a>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light"
                                data-toggle="dropdown" aria-expanded="false">
                            <span class=""><i class="zmdi zmdi-plus-box"></i></span> Quick create</button>
                    </div>

                <?php endif; ?>
                <div class="page-title p-t-1" style="line-height: 15px;">
                    <h4> <a href="<?= base_url('index.php/Compliance')?>">Compliance</a> <span> <small><i class="fa fa-angle-right"></i> <?= $page_title ?></small></span>
                    </h4>
                    <span><small class="pull-left m-l-5 hidden"><?= create_breadcrumb(); ?></small></span>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="navbar-custom">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">
                <li><a href="<?= base_url("index.php/Compliance/"); ?>"><i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard  </span> </a></li>
                <li><a href="<?= base_url("index.php/Compliance/statutory"); ?>"><i class="fa fa-gavel"></i> <span> Statutory Compliance</span> </a></li>

                <li><a href="<?= base_url("index.php/Compliance/legal"); ?>"><i class="zmdi zmdi-album"></i> <span> Legal/Regulatory Compliance</span> </a></li>
                <li><a href="<?= base_url("index.php/Compliance/business"); ?>"><i class="zmdi zmdi-case"></i> <span> Business Compliance </span> </a></li>

                <li><a href="<?= base_url("index.php/Compliance/report"); ?>"><i class="zmdi zmdi-chart"></i> <span> Reports </span> </a></li>
                <li><a href="<?= base_url("index.php/Compliance/complianceRequirement"); ?>"><i class="icon icon-list"></i> <span> All Compliance Requirements</span> </a></li>
                <li><a href="<?= base_url("index.php/Compliance/registers"); ?>"><i class="zmdi zmdi-info"></i> <span> Registers </span> </a></li>

<!--<li><a href="<?//= base_url("index.php/Compliance/actions"); ?>"><i class="zmdi zmdi-comment-edit"></i> <span> Actions </span> </a></li>-->

            </ul>
            <!-- End navigation menu  -->
        </div>
    </div>
</div>
</header>
<div class="wrapper">
