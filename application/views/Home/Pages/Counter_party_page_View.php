<?php 
if (!am_user_type(array(1, 6, 5)) ) {
    restricted_view();
    return false;
}
?><?php
$$data['repository']['source'] = $data['repository'][$data['repository']['source']]
?><div class='container-fluid'>
    <div class='card card-block'>
        <div class='card-title'>
            <h4> Counter Party </h4>
        </div>
        <div class='card-text'>

            <dl class='dl-horizontal row'>
                <dt class='col-sm-3'> id </dt>
                <dd class='col-sm-9'> <?= $counter_party['id'] ?> </dd>
                <dt class='col-sm-3'> contract </dt>
                <dd class='col-sm-9'> <?= $counter_party['contract'] ?> </dd>
                <dt class='col-sm-3'> name </dt>
                <dd class='col-sm-9'> <?= $counter_party['name'] ?> </dd>
                <dt class='col-sm-3'> email </dt>
                <dd class='col-sm-9'> <?= $counter_party['email'] ?> </dd>
                <dt class='col-sm-3'> phone </dt>
                <dd class='col-sm-9'> <?= $counter_party['phone'] ?> </dd>
                <dt class='col-sm-3'> company </dt>
                <dd class='col-sm-9'> <?= $counter_party['company'] ?> </dd>
            </dl>

        </div>
    </div>
</div>
