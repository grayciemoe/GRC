
<div class="bg-faded">
    <!-- end topbar-main -->
    <div class="container ">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-10">
                    <div class="dropdown-menu">
                        <!-- ?? -->
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
                        <span class=""><i class="zmdi zmdi-plus-box"></i></span> Key Risk Area</button>
                </div>


                <span class=" pull-right text-hidden"> .</span>
                <div class="btn-group pull-right m-t-10">
                    <div class="dropdown-menu">
                        <?php if (am_user_type(array(1, 5))): ?>
                            <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= base_url("index.php/Risk/registerForm/0"); ?>">Risk Register</a>
                        <?php endif; ?>
                        <?php if (am_user_type(array(1, 5))): ?>
                            <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= base_url("index.php/Risk/categoryForm/0"); ?>">Risk Category</a>
                        <?php endif; ?>
                        <?php if (am_user_type(array(1, 5, 6))): ?>
                            <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= base_url("index.php/Risk/riskForm/0"); ?>">Risk</a>
                        <?php endif; ?>
                        <?php if (am_user_type(array(1, 5))): ?>
                            <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= base_url("index.php/Risk/controlCateogoryForm/0"); ?>">Control Category</a>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light"
                            data-toggle="dropdown" aria-expanded="false">
                        <span class=""><i class="zmdi zmdi-plus-box"></i></span> Quick create</button>

                </div>
                <div class="page-title  p-t-1">
                    <h4><a href="<?= base_url('index.php/Risk')?>">Risk</a> <span> <small><i class="fa fa-angle-right"></i> <?= $page_title ?></small></span> </h4>
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
                <li><a href="<?= base_url("index.php/Risk/"); ?>"><i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard  </span> </a></li>
                <li><a href="<?= base_url("index.php/Risk/riskregister"); ?>"><i class="pe-7s-hammer"></i> <span> Risk Register</span> </a></li>
                <li><a href="<?= base_url("index.php/Risk/riskcategories"); ?>"><i class="zmdi zmdi-album"></i> <span> Risk Categories</span> </a></li>
                <li><a href="<?= base_url("index.php/Risk/riskcontrols"); ?>"><i class="zmdi zmdi-case"></i> <span> Risk Controls </span> </a></li>
                <li><a href="<?= base_url("index.php/Risk/controlactivity"); ?>"><i class="zmdi zmdi-format-list-bulleted"></i> <span> Control Activity </span> </a></li>
                <li><a href="<?= base_url("index.php/Risk/riskReport"); ?>"><i class="icon icon-drawar"></i> <span>  Risk Report</span></a></li>
                <li><a href="<?= base_url("index.php/Risk/riskIssue"); ?>"><i class="zmdi zmdi-arrow-merge"></i> <span>  Published Audit Issues</span></a></li>
<!--<li><a href="<?//= base_url("index.php/Risk/actions"); ?>"><i class="zmdi zmdi-comment-edit"></i> <span> Actions </span> </a></li>-->

            </ul>
            <!-- End navigation menu  -->
        </div>
    </div>
</div>
</header>
<div class="wrapper">
