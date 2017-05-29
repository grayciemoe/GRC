<div class="container">
 <?= __FILE__ ?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="row">
  <h3>&nbsp;Information</h3>
  <hr />
</div>
<div class="row">
  
</div>

<!-- jQuery  -->
<script src="<?= base_url("assets/js/jquery.min.js") ?>"></script>
<script src="<?= base_url("assets/js/tether.min.js") ?>"></script><!-- Tether for Bootstrap -->
<script src="<?= base_url("assets/js/bootstrap.min.js") ?>"></script>
<script src="<?= base_url("assets/js/waves.js") ?>"></script>
<script src="<?= base_url("assets/js/jquery.nicescroll.js") ?>"></script>
<script src="<?= base_url("assets/plugins/switchery/switchery.min.js") ?>"></script>

<!-- controlled scripts -->
<?php

$UPLON_SCRIPTS = objectToArray(json_decode(UPLON_SCRIPTS));
foreach ($scripts as $key => $value) {
    if (array_key_exists($value, $UPLON_SCRIPTS)) {
        echo "<script src=\"" . base_url($UPLON_SCRIPTS[$value]) . "\"></script> \n";
    }
}

?>


<!-- App js -->
<script src="<?= base_url("assets/js/jquery.core.js") ?>"></script>
<script src="<?= base_url("assets/js/jquery.app.js") ?>"></script>
