<?php 
if (!am_user_type(array(7)) ) {
    restricted_view();
    return false;
}
?><?php // print_pre($data);        ?>

<div class="container">
    <div class="card">
        <div class="card-block">
            <table class="table table-striped table-hover ">
                <thead>
                    <tr>
                        <th>Action</th>
                        <?php foreach ($data['user_type'] as $key => $value) : ?>
                            <th><?= $value['name'] ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $unique = [];
                    foreach ($data['actions'] as $key => $action) :
                        if (in_array($action['id'], $unique)) {
                            continue;
                        }
                        $unique[] = $action['id'];
                        //print_pre($unique);
                        ?>
                        <tr>
                            <th><?= $action['method'] ?></th>
                            <?php foreach ($data['user_type'] as $key => $value) : ?>
                                <th><?= $value['name'] ?></th>
                            <?php endforeach; ?>
                        </tr>

                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>