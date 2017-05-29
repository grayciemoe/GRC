<?php 
if (am_user_type(array(7)) ) {
    restricted_view();
    return false;
}
?><div class="container">
    <?= show_comments() ?>

</div>
<script>
    var resizefunc = [];</script>

<!-- jQuery  -->
<script src="<?= base_url("assets/js/jquery.min.js") ?>"></script>
<script src="<?= base_url("assets/js/tether.min.js") ?>"></script><!-- Tether for Bootstrap -->
<script src="<?= base_url("assets/js/bootstrap.min.js") ?>"></script>
<script src="<?= base_url("assets/js/waves.js") ?>"></script>
<script src="<?= base_url("assets/js/jquery.nicescroll.js") ?>"></script>
<script src="<?= base_url("assets/plugins/switchery/switchery.min.js") ?>"></script>


<!-- controlded scripts -->
<?php
$UPLON_SCRIPTS = objectToArray(json_decode(UPLON_SCRIPTS));
$scripts = array("jstree.min");
foreach ($scripts as $key => $value) {
    if (array_key_exists($value, $UPLON_SCRIPTS)) {
        // echo "<script src=\"" . base_url($UPLON_SCRIPTS[$value]) . "\"></script> \n";
    }
}
//print_pre($UPLON_SCRIPTS);
?>
<!-- App js -->
<script src="<?= base_url("assets/js/jquery.core.js") ?>"></script>
<script src="<?= base_url("assets/js/jquery.app.js") ?>"></script>