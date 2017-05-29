<?php // print_pre($me);           ?>

<header id="topnav">
    <div class=" bg-faded">
        <div class="container">
            <span class="pull-left text-muted"> <small>Account Type <i class="icon  icon-login"></i>  <?= $me['user_type']['name'] ?></small></span>
            <span class="pull-right text-muted"> <small> <i class="icon icon-user"></i> Welcome <?= $me['user']['names'] ?></small></span>
            <?php if($me['user']['corporate'] != 0):?>
                <span class="pull-right text-muted m-r-10"> <small>Corporate <i class="icon  icon-globe"></i>  <?= $me['corporate']['name'] ?></small></span>
            <?php endif;?>
        </div>
    </div>
    <div class="topbar-main">
        <div class="container">
            <!-- LOGO -->
            <div class="topbar-left">

                <?php
                if (am_user_type(array(1, 2, 3, 4, 5, 6, 8, 9, 10))):
                    $home = base_url("index.php/Home/");
                else :
                    $home = base_url("#");
                endif;
                ?>    
                <a href="<?= $home ?>" class="logo">
                    <img src="<?= base_url("assets/images/eMo-Logo.png") ?>"></img>
                </a>
            </div>
            <!-- End Logo container-->
            <div class="menu-extras menu-extras-grc">
                <?php if (am_user_type(array(1, 2, 3, 4, 5, 6, 8, 9, 10))): ?>    
                    <ul class="nav navbar-nav pull-left p-l-3">
                        <li class="nav-item notification-list <?php
                        if ($this->uri->segment(1) == "Home") {
                            echo "active";
                        }
                        ?>">
                            <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" href="<?= base_url("index.php/Home/") ?>" >
                                <i class="icon icon-home "></i><span class="hidden-xs hidden-sm-down"> Home</span> 
                            </a>
                        </li>
                        <li class="nav-item notification-list <?php
                        if ($this->uri->segment(1) == "Risk") {
                            echo "active";
                        }
                        ?>">
                            <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" href="<?= base_url("index.php/Risk/") ?>" >
                                <span class="icon icon-flash2"></span><span class="hidden-xs hidden-sm-down"> Risk</span> 
                            </a>

                        </li>
                        <li class="nav-item notification-list <?php
                        if ($this->uri->segment(1) == "Compliance") {
                            echo "active";
                        }
                        ?>">
                            <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" href="<?= base_url("index.php/Compliance/") ?>" >
                                <i class="icon icon-target "></i><span class="hidden-xs hidden-sm-down"> Compliance</span> 
                            </a>
                        </li>
                        <li class="nav-item notification-list <?php
                        if ($this->uri->segment(1) == "IncidentManagement") {
                            echo "active";
                        }
                        ?>">
                            <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" href="<?= base_url("index.php/IncidentManagement/report") ?>" >
                                <i class="icon icon-energy "></i><span class="hidden-xs hidden-sm-down"> Incident Management</span> 
                            </a>
                        </li>
                        <li class="nav-item notification-list <?php
                        if ($this->uri->segment(1) == "Audit") {
                            echo "active";
                        }
                        ?>">
                            <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" href="<?= base_url("index.php/Audit/") ?>" >
                                <i class="icon icon-check "></i><span class="hidden-xs hidden-sm-down"> Audit</span> 
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
                <?php if (am_user_type(array(7)) and ! am_user_type(array(1, 2, 3, 4, 5, 6, 8, 9, 10))): ?>
                    <ul class="nav navbar-nav pull-left p-l-3">
                        <li class="nav-item notification-list <?php
                        if ($this->uri->segment(1) == "Account") {
                            echo "active";
                        }
                        ?>">
                            <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" href="<?= base_url("index.php/Account/compliance") ?>" >
                                <i class="icon icon-home "></i><span class="hidden-xs hidden-sm-down"> Home</span> 
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div> <!-- end menu-extras -->
            <div class="menu-extras">
                <ul class="nav navbar-nav pull-right">

                    <li class="nav-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>


                    <li class="nav-item dropdown notification-list hidden">
                        <a class="nav-link waves-effect waves-light right-bar-toggle" href="javascript:void(0);" > 
                            <i class="zmdi zmdi-format-subject noti-icon"></i>
                        </a>
                    </li>
                    <?php if (am_user_type(array(1, 5))) : ?>
                        <li class="nav-item dropdown notification-list hidden">
                            <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                <i class="zmdi zmdi-notifications-none noti-icon"></i>
                                <?= $KRAs > 0 || $risks > 0 || $controls > 0 || $control_activity > 0 || $breaches > 0 || $complies > 0 || $obligations > 0 || $incidents > 0 ? "<span class=\"noti-icon-badge\"></span>" : "" ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-lg" aria-labelledby="Preview">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5><small>Notification</small></h5>
                                </div>

                                <!-- item-->
                                <?=
                                $KRAs > 0 ?
                                        "<a href=\"" . base_url('index.php/RiskAdministration/keyRiskArea') . "\" class=\"dropdown-item notify-item\">
                                <div class=\"notify-icon bg-faded\"><i class=\"zmdi zmdi-hourglass-alt\"></i></div>
                                <p class=\"notify-details\">KRAs<span class=\"label label-danger pull-right\">$KRAs</span></p>
                            </a>" : ""
                                ?>

                                <!-- item-->
                                <?=
                                $risks > 0 ?
                                        "<a href=\"" . base_url('index.php/RiskAdministration') . "\" class=\"dropdown-item notify-item\">
                                <div class=\"notify-icon bg-faded\"><i class=\"zmdi zmdi-hourglass-alt\"></i></div>
                                <p class=\"notify-details\">Risks<span class=\"label label-danger pull-right\">$risks</span></p>
                            </a>" : ""
                                ?>

                                <!-- item-->
                                <?=
                                $controls > 0 ?
                                        "<a href=\"" . base_url('index.php/RiskAdministration') . "\" class=\"dropdown-item notify-item\">
                                <div class=\"notify-icon bg-faded\"><i class=\"zmdi zmdi-hourglass-alt\"></i></div>
                                <p class=\"notify-details\">Controls<span class=\"label label-danger pull-right\">$controls</span></p>
                            </a>" : ""
                                ?>

                                <!-- item-->
                                <?=
                                $control_activity > 0 ?
                                        "<a href=\"" . base_url('index.php/RiskAdministration') . "\" class=\"dropdown-item notify-item\">
                                <div class=\"notify-icon bg-faded\"><i class=\"zmdi zmdi-hourglass-alt\"></i></div>
                                <p class=\"notify-details\">Control Activities<span class=\"label label-danger pull-right\">$control_activity</span></p>
                            </a>" : ""
                                ?>

                                <!-- item-->
                                <?=
                                $breaches > 0 ?
                                        "<a href=\"" . base_url('index.php/RiskAdministration/compliance') . "\" class=\"dropdown-item notify-item\">
                                <div class=\"notify-icon bg-faded\"><i class=\"zmdi zmdi-hourglass-alt\"></i></div>
                                <p class=\"notify-details\">Breaches<span class=\"label label-danger pull-right\">$breaches</span></p>
                            </a>" : ""
                                ?>

                                <!-- item-->
                                <?=
                                $complies > 0 ?
                                        "<a href=\"" . base_url('index.php/RiskAdministration/compliance') . "\" class=\"dropdown-item notify-item\">
                                <div class=\"notify-icon bg-faded\"><i class=\"zmdi zmdi-hourglass-alt\"></i></div>
                                <p class=\"notify-details\">Complies<span class=\"label label-danger pull-right\">$complies</span></p>
                            </a>" : ""
                                ?>

                                <!-- item-->
                                <?=
                                $obligations > 0 ?
                                        "<a href=\"" . base_url('index.php/RiskAdministration/compliance') . "\" class=\"dropdown-item notify-item\">
                                <div class=\"notify-icon bg-faded\"><i class=\"zmdi zmdi-hourglass-alt\"></i></div>
                                <p class=\"notify-details\">Obligations<span class=\"label label-danger pull-right\">$obligations</span></p>
                            </a>" : ""
                                ?>

                                <!-- item-->
                                <?=
                                $incidents > 0 ?
                                        "<a href=\"" . base_url('index.php/RiskAdministration/incidentManagement') . "\" class=\"dropdown-item notify-item\">
                                <div class=\"notify-icon bg-faded\"><i class=\"zmdi zmdi-hourglass-alt\"></i></div>
                                <p class=\"notify-details\">Inicident Management<span class=\"label label-danger pull-right\">$incidents</span></p>
                            </a>" : ""
                                ?>

                            </div>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light nav-user" data-toggle="dropdown" href="#" >

                            <img src="<?php if (img_src($me['user']['profile_pic'])) {
                        echo img_src($me['user']['profile_pic']);
                    } else {
                        echo img_src("user.jpg");
                    } ?>" alt="user" class="img-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-arrow profile-dropdown " aria-labelledby="Preview">
                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <h5 class="text-overflow"><small>  <i class="icon  icon-login"></i> <?= $me['user_type']['name'] ?></small> </h5>
                            </div>
<?php if (am_user_type(array(1, 5))): ?>
                                <a href="<?= base_url("index.php/RiskAdministration/keyRiskArea"); ?>" class="dropdown-item notify-item">
                                    <i class="icon icon-speedometer"></i> <span> Risk Admin  </span> </a>
<?php endif; ?>
                            <a href="<?= base_url("index.php/Account/profile"); ?>" class="dropdown-item notify-item">
                                <i class="icon icon-user"></i> <span> My Profile  </span> </a>
                            <a href="<?= base_url("index.php/Account/notifications"); ?>" class="dropdown-item notify-item">
                                <i class="icon icon-bell"></i> <span> Notifications  </span> </a>
                            <a href="<?= base_url("index.php/Home/users"); ?>" class="dropdown-item notify-item">
                                <i class="icon icon-people"></i> <span>Users Settings  </span> </a>
<!--                            <a href="<?= base_url("index.php/Account/documents"); ?>" class="dropdown-item notify-item"><i class="zmdi zmdi-case "></i> <span> documents  </span> </a>
                            <a href="<?= base_url("index.php/Account/notifications"); ?>" class="dropdown-item notify-item"><i class="zmdi zmdi-notifications-none"></i> <span> notifications  </span> </a>
                            <a href="<?= base_url("index.php/Account/drafts"); ?>" class="dropdown-item notify-item"><i class="zmdi zmdi-time"></i> <span> drafts  </span> </a>
                             item-->
                            <a href="<?= base_url("index.php/Login/logout"); ?>" class="dropdown-item notify-item">
                                <i class="zmdi zmdi-power"></i> <span>Logout</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div> <!-- end menu-extras -->
            <div class="clearfix"></div>

        </div> <!-- end container -->
    </div>
    <div class="bg-warning text-center" id="system_alert_box">
        <div class=""><?= (urldecode($message)) ?></div>
    </div>

    <script>
        $(document).ready(function () {
            setTimeout((function () {
                $("#system_alert_box").slideUp("slow")
            }), 5000);
            $("#system_alert_box").click(function () {
                $("#system_alert_box").slideUp("slow")
            });
        });
    </script>

    <!-- end topbar-main -->

