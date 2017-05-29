
<div class="bg-faded">
    <!-- end topbar-main -->
    <div class="container ">
        <!-- Page-Title -->
        <div class="row">
            
                <h4 class="page-title"><a href="<?= base_url('index.php/RiskAdministration')?>">Risk Administration</a> <span> <small><i class="fa fa-angle-right"></i> <?php if($this->uri->segment(2)=="keyRiskArea") {echo 'Key Risk Areas';} else if
                                ($this->uri->segment(2)=="") {echo 'Risks';} elseif  
                                ($this->uri->segment(2)=="compliance") {echo 'Compliance';} elseif 
                                ($this->uri->segment(2)=="incidentManagement") {echo 'Incident Management';} elseif
                                ($this->uri->segment(2)=="audit") {echo 'Audit';} elseif
                                ($this->uri->segment(2)=="users") {echo 'Users';} else {'';}?></small></span></h4>
            </div>
        </div>
    </div>
    
    
    
</div>
<div class="navbar-custom">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">
            <li><a href="<?= base_url("index.php/RiskAdministration/keyRiskArea"); ?>"><i class="zmdi zmdi-view-dashboard"></i> <span> Key Risk Areas</span> </a></li>
                <li><a href="<?= base_url("index.php/RiskAdministration/"); ?>"><i class="zmdi zmdi-view-dashboard"></i> <span> Risks</span> </a></li>
                <li><a href="<?= base_url("index.php/RiskAdministration/compliance"); ?>"><i class="zmdi zmdi-view-dashboard"></i> <span> Compliance </span> </a></li>
                <li><a href="<?= base_url("index.php/RiskAdministration/incidentManagement"); ?>"><i class="zmdi zmdi-view-dashboard"></i>Incident Management <span> </span> </a></li>
                <li><a href="#"><i class="zmdi zmdi-view-dashboard"></i>Audit <span> </span> </a></li>
               
            </ul>
            <!-- End navigation menu  -->
        </div>
    </div>
</div>
</header>
<div class="wrapper">
