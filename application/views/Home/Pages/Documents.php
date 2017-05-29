<?php
if (!am_user_type(array(5,7))) {
    restricted_view();
    return false;
}
?><div class="container">
 <?= __FILE__ ?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
</div>