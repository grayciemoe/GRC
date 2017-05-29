<?php
if (!am_user_type(array(1, 9))) {
    restricted_view();
    return false;
}
?>
<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <div class="timeline">
                <?php
                foreach ($data['trail'] as $key => $value):
                    ?>
                    <article class="timeline-item <?= ($key % 2 == 0) ? 'alt' : null ?>">
                        <div class="timeline-desk">
                            <div class="panel">
                                <div class="timeline-box">
                                    <span class="arrow-alt"></span>
                                    <span class="timeline-icon"><i class="zmdi zmdi-circle"></i></span>

                                    <div class="pull-right">
                                        <h4 class="text-muted"><?= strftime("%d %B %Y", strtotime($value['timestamp'])) ?></h4>
                                        <p class="timeline-date text-muted"><small><?= strftime("%H:%M %p", strtotime($value['timestamp'])) ?></small></p>
                                    </div>
                                    <h4 class="text-muted"><?= $value['title'] ?></h4>
                                    <div class="clearfix"></div>

                                    <p><?= $value['message']?></p>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
                
            </div>
        </div>
    </div>
</div>