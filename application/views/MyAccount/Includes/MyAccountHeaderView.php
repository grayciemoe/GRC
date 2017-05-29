<div class="bg-faded">
    <!-- end topbar-main -->
    <div class="container ">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-10">
                    <?php if (am_user_type(array(1, 2, 3, 4, 5, 6, 8, 10))): ?>    
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= base_url("index.php/Compliance/registerForm/0"); ?>">Compliance Register</a>
                            <a class="dropdown-item" href="<?= base_url("index.php/Compliance/complianceRequirementForm/0"); ?>">Compliance Requirement</a>
                            <a class="dropdown-item" href="<?= base_url("index.php/Compliance/authorityForm/0"); ?>">Authority</a>
                            <a class="dropdown-item" href="<?= base_url("index.php/Compliance/obligationForm/0"); ?>">Obligation</a>
                            <a class="dropdown-item" href="<?= base_url("index.php/Compliance/breachForm/0"); ?>">Report Breach</a>
                            <a class="dropdown-item" href="<?= base_url("index.php/Compliance/compliantForm/0"); ?>">Submit Compliant</a>
                        </div>
                    <?php else : ?>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= base_url("index.php/IncidentManagement/incidentForm/"); ?>">Create Incident</a>
                        </div>
                    <?php endif; ?>


                    <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light"
                            data-toggle="dropdown" aria-expanded="false">
                        <span class=""><i class="zmdi zmdi-plus-box"></i></span> Quick create</button>
                </div>
                <h4 class="page-title">My Account <span>| <small>
                            <?php
                            if ($this->uri->segment(2) == "risk") {
                                echo "Risk";
                            } elseif ($this->uri->segment(2) == "compliance") {
                                echo "Compliance";
                            } elseif ($this->uri->segment(2) == "incidentManagement") {
                                echo "Incident Management";
                            } elseif ($this->uri->segment(2) == "incidentActions") {
                                echo "Incident Actions";
                            } else {
                                echo "Welcome {$me['user']['names']}";
                            }
                            ?> </small></span></h4>
            </div>
        </div>
    </div>    
</div>
<div class="navbar-custom">
    <div class="container">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">
                <li><a href="<?= base_url("index.php/Account/profile"); ?>"><i class="zmdi zmdi-account"></i> <span> Profile  </span> </a></li>
                <?php if (am_user_type(array(1, 2, 3, 4, 5, 6, 8, 9))): ?><li><a href="<?= base_url("index.php/Account/risk"); ?>"><i class="icon icon-flash2"></i> <span> Risk  </span> </a></li><?php endif; ?>
                <?php if (am_user_type(array(1, 2, 3, 4, 5, 6, 7, 8, 9))): ?><li><a href="<?= base_url("index.php/Account/compliance"); ?>"><i class="icon icon-target"></i> <span> Compliance  </span> </a></li><?php endif; ?>
                <?php if (am_user_type(array(1, 2, 3, 4, 5, 6, 7, 8, 9))): ?><li><a href="<?= base_url("index.php/Account/incidentManagement"); ?>"><i class="icon icon-energy "></i> <span> Incident Management  </span> </a></li><?php endif; ?>
                <?php if (am_user_type(array(1, 2, 3, 4, 5, 6, 7, 8, 9))): ?><li><a href="<?= base_url("index.php/Account/incidentActions"); ?>"><i class="zmdi zmdi-view-dashboard"></i>Incident Actions <span> </span> </a></li><?php endif; ?>
                <li class="hidden"><a href="<?= base_url("index.php/Account/settings"); ?>"><i class="zmdi zmdi-settings"></i> <span> Settings  </span> </a></li>
                <li class="hidden"><a href="<?= base_url("index.php/Account/documents"); ?>"><i class="zmdi zmdi-case "></i> <span> Documents  </span> </a></li>
                <li class="hidden"><a href="<?= base_url("index.php/Account/notifications"); ?>"><i class="zmdi zmdi-notifications-none"></i> <span> Notifications  </span> </a></li>
                <li class="hidden"><a href="<?= base_url("index.php/Account/messages"); ?>"><i class="zmdi zmdi-settings"></i> <span> Messages  </span> </a></li>
                <li class="hidden"><a href="<?= base_url("index.php/Account/drafts"); ?>"><i class="zmdi zmdi-settings"></i> <span> Drafts  </span> </a></li>
            </ul>
            <!-- End navigation menu  -->
        </div>
    </div>
</div>
</header>
<div class="wrapper" style="padding-top: 190px !important;"> 
