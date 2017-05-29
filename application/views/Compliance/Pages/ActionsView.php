<?php
if (!am_user_type(array(1, 9, 6, 5))) {
    restricted_view();
    return false;
}
?><!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="container">
    <div class="row">
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="col-sm-12">
            <a href="<?= base_url("index.php/Compliance/deleteRegister");?>" class="btn btn-custom waves-effect waves-light" <?= MODAL_LINK ?>> deleteRegister </a>
            <a href="<?= base_url("index.php/Compliance/deleteComplainceRequirement");?>" class="btn btn-custom waves-effect waves-light" <?= MODAL_LINK ?>> deleteComplainceRequirement </a>
            <a href="<?= base_url("index.php/Compliance/obligationDelete");?>" class="btn btn-custom waves-effect waves-light" <?= MODAL_LINK ?>> obligationDelete </a>
            <a href="<?= base_url("index.php/Compliance/breachDelete");?>" class="btn btn-custom waves-effect waves-light" <?= MODAL_LINK ?>> breachDelete </a>
            <a href="<?= base_url("index.php/Compliance/deleteRegister");?>" class="btn btn-custom waves-effect waves-light" <?= MODAL_LINK ?>> compliantDelete </a>
            <a href="<?= base_url("index.php/Compliance/authorityDelete");?>" class="btn btn-custom waves-effect waves-light" <?= MODAL_LINK ?>> authorityDelete </a>
        </div>
        <div class=""><br></div>
        <div class="col-sm-12">
            <a href="<?= base_url("index.php/Compliance/approveComplianceRequirement");?>" class="btn btn-custom waves-effect waves-light" <?= MODAL_LINK ?>> approveComplianceRequirement </a>
            <a href="<?= base_url("index.php/Compliance/approveRegister");?>" class="btn btn-custom waves-effect waves-light" <?= MODAL_LINK ?>> approveRegister </a>
            <a href="<?= base_url("index.php/Compliance/approveComplianceRequirement");?>" class="btn btn-custom waves-effect waves-light" <?= MODAL_LINK ?>> approveComplianceRequirement </a>
            <a href="<?= base_url("index.php/Compliance/obligationApprove");?>" class="btn btn-custom waves-effect waves-light" <?= MODAL_LINK ?>> obligationApprove </a>
            <a href="<?= base_url("index.php/Compliance/obligationComply");?>" class="btn btn-custom waves-effect waves-light" <?= MODAL_LINK ?>> obligationComply </a>
            <a href="<?= base_url("index.php/Compliance/breachApprove");?>" class="btn btn-custom waves-effect waves-light" <?= MODAL_LINK ?>> breachApprove </a>
            <a href="<?= base_url("index.php/Compliance/authorityApprove");?>" class="btn btn-custom waves-effect waves-light" <?= MODAL_LINK ?>> authorityApprove </a>
        </div>
        
    </div>
</div>

