
<div class="bg-faded">

    <div class="container ">

        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-10">

                    <div class="dropdown-menu">
                        <?php if (am_user_type([1, 5, 6, 7])): ?>
                            <a href="<?= base_url("index.php/IncidentManagement/incidentForm/"); ?>"  class="dropdown-item"> Create Incident</a>
                        <?php endif; ?>
                        <?php if (am_user_type([1, 5])): ?>
                            <a href="<?= base_url("index.php/IncidentManagement/incidentCateogoryForm/0/"); ?>" <?= MODAL_LINK ?>  class="dropdown-item"> New Incident Category</a>
                        <?php endif; ?>

                    </div>
                    <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light"
                            data-toggle="dropdown" aria-expanded="false">
                        <span class=""><i class="zmdi zmdi-plus-box"></i></span> Quick create</button>
                </div>
                <h4 class="page-title"><a href="<?= base_url('index.php/IncidentManagement')?>">Incident Management</a> <span> <small><i class="fa fa-angle-right"></i> <?= $page_title ?> </small></span></h4>
            </div>
        </div>
    </div>

</div>

<div class="navbar-custom">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">
                <li>
                    <a href="<?= base_url("index.php/IncidentManagement/"); ?>"><i class="icon icon-speedometer"></i><span> Dashboard</span> </a>
                </li>
                <li>
                    <?php if (am_user_type([1, 5, 6])): ?>
                    <a href="<?= base_url("index.php/IncidentManagement/incidentsActions/"); ?>"><i class="icon icon-calender"></i><span> Incidents Actions</span> </a>
                <?php endif; ?>
                </li>

<!--<li><a href="<?//= base_url("index.php/Risk/actions"); ?>"><i class="zmdi zmdi-comment-edit"></i> <span> Actions </span> </a></li>-->

            </ul>
            <!-- End navigation menu  -->
        </div>
    </div>
</div>

</header>
<div class="wrapper" style="margin-top:100px important;">
    

    <?php
    /*
     * if(am_user_type('1,5') or ($value['risk_woner'] == my_id()){
     * <a href="" >create risk</a>
     * }
     * 
     *  
     * 1 Administrator
     * 2 CEO
     * 3 Chairman
     * 4 Board
     * 5 Risk Manager
     * 6 Unit Owner
     * 7 Staff
     * 8 Auditor
     * 9 Corporate Admin
     * 10 Compliance Officer
     * 
     * 
     * */
    ?>