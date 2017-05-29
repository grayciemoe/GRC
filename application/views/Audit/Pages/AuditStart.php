<?php
/*
 *  Code By Alex
 *  Eat Code Sleep Repeat
 */
?>
<div class="container">
    <div class="row" style="
    margin-top: -90px;
">
        <div class="col-xs-12">
            <div class="card card-header">
                <h6 class="page-title text-black text-center">Please Select a Corporate</h6>
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($data as $key => $value): ?>
        <a href="<?= base_url('index.php/Audit/dashboard/'.$value['id']) ?>">
        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card-box tilebox-two">
                <!--<span><i class="icon-globe pull-xs-right text-muted" style="margin-top: 0px;"></i></span>-->
                <h6 class="text-primary text-center text-uppercase m-b-15 m-t-10"><?= $value['name']?></h6>
            </div>
        </div>
        </a>
        <?php endforeach;?>
    </div>
</div>