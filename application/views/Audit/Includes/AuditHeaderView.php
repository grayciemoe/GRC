<?php // print_pre($corporate); exit;   ?>
<div class="bg-faded">
    <!-- end topbar-main -->
    <div class="container ">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <?php if (!empty($corporate)): ?>
                    <?php if (am_user_type(array(8))): ?>
                        <div class="btn-group pull-right m-t-10">

                            <div class="dropdown-menu">

                                <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= base_url("index.php/Audit/auditForm/0/" . $corporate); ?>">Audit</a>
                                <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= base_url("index.php/Audit/auditAreaForm/0/" . $corporate); ?>">Audit Area</a>

                            </div>
                            <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light"
                                    data-toggle="dropdown" aria-expanded="false">
                                <span class=""><i class="zmdi zmdi-plus-box"></i></span> Quick create</button>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <h4 class="page-title">

                    <?php if (($me['user']['user_type'] == 6) || ($me['user']['user_type'] == 2)): ?>
                        <a href="<?= base_url('index.php/Audit') ?>">Audit</a> <span> <small><i class="fa fa-angle-right"></i> <?= $title ?> </small></span>
                    <?php else: ?>
                        <?php if (isset($corporate_details)): ?>
                            <a href="<?= base_url('index.php/Audit') ?>"><i class="icon icon-globe"></i> <?= $corporate_details['name'] ?></a> <span><i class="fa fa-angle-right"></i></span>
                            <a href="<?= base_url('index.php/Audit/Dashboard/' . $corporate) ?>">Audit</a> <span> <small><i class="fa fa-angle-right"></i> <?= $title ?> </small></span>
                        <?php endif; ?>
                    <?php endif; ?>
                </h4>
            </div>
        </div>
    </div>



</div>

<div class="navbar-custom">
    <div class="container">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">
                <?php if (!empty($corporate)): ?>
                    <li><a href="<?= base_url("index.php/Audit/dashboard/" . $corporate); ?>"><i class="icon icon-speedometer"></i> <span>Dashboard  </span> </a></li>
                    <li><a href="<?= base_url("index.php/Audit/allAudits/" . $corporate); ?>"><i class="icon icon-list"></i> <span>All Audits  </span> </a></li>
                    <li><a href="<?= base_url("index.php/Audit/allActionPlans/" . $corporate); ?>"><i class="icon icon-folder"></i> <span>Action Plan  </span> </a></li>
                <?php endif; ?>
            </ul>
            <!-- End navigation menu  -->
        </div>
    </div>
</div>
</header>
<div class="wrapper" style="">
