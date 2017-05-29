
<div class="bg-faded">
    <!-- end topbar-main -->
    <div class="container ">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-10">

                    <div class="dropdown-menu">
                        <?php if (am_user_type(array(1, 9))): ?>
                        <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= base_url("index.php/Home/unitForm/0/1"); ?>">Business Unit</a>
                        <?php endif; ?>
                        <?php
                        $sources = $repository_sources;
                        $environment_id = isset($data['environment']['id']) ? $data['environment']['id'] : 1;
                        foreach ($sources as $key => $value):
                            $link = base_url("index.php/Home/repositoryForm/0/$key/{$environment_id}")
                            ?>
                            <?php if (am_user_type(array(1, 5, 6))): ?>
                                <a class="dropdown-item" <?= MODAL_LINK ?> href="<?= $link; ?>"><?= $value ?></a>
                            <?php endif; ?>
                        <?php endforeach; ?></div>
                    <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light"
                            data-toggle="dropdown" aria-expanded="false">
                        <span class=""><i class="zmdi zmdi-plus-box"></i></span> Quick create</button>
                </div>
                <h4 class="page-title"><a href="<?= base_url('index.php/Home')?>">Home</a> <span> <small><i class="fa fa-angle-right"></i> <?= $title ?> </small></span></h4>
            </div>
        </div>
    </div>



</div>
<div class="navbar-custom">
    <div class="container">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">
                <li><a href="<?= base_url("index.php/Home/dashboard"); ?>"><i class="icon icon-speedometer"></i> <span>Dashboard  </span> </a></li>
                <li><a href="<?= base_url("index.php/Home/repositoryPool"); ?>"><i class="icon icon-layers"></i> <span> Source Repository Pool</span> </a></li>
                <li><a href="<?= base_url("index.php/Home/siteMap"); ?>"><i class="fa fa-sitemap"></i> <span> Organizational Map</span> </a></li>
                <li><a href="<?= base_url("index.php/Home/activityList"); ?>"><i class="fa fa-clock-o"></i> <span> Audit Trail</span> </a></li>
                <li class="hidden"><a href="<?= base_url("index.php/Home/userTypes"); ?>"><i class="icon icon-people"></i> <span> User Types</span> </a></li>
                <li class="hidden"><a href="<?= base_url("index.php/Home/notifications"); ?>"><i class="icon icon-bell"></i> <span> Notifications</span> </a></li>
                <li class=""><a href="<?= base_url("index.php/Home/documents"); ?>"><i class="icon  icon-notebook"></i> <span> Documents </span> </a></li>

<!--<li><a href="<? //= base_url("index.php/Risk/actions");  ?>"><i class="zmdi zmdi-comment-edit"></i> <span> Actions </span> </a></li>-->

            </ul>
            <!-- End navigation menu  -->
        </div>
    </div>
</div>
</header>
<div class="wrapper" style="">
