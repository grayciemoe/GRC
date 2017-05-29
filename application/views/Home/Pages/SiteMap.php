<?php
if (!am_user_type(array(1, 5, 2, 8, 9))) {
    restricted_view();
    return false;
}
?><div class="container-fluid">
    <div class="row">
        <div class="col-sm-7">
            <div class="card">
                <div class="card-header">
                    <h3><?= SESSION_INDEX ?> Corporate Map</h3>
                </div>
                <div class="card-block">

                    <?php

                    // print_pre($data['site_map'] );

                    function doSomething($array) {
                        echo "<ul class='sitemap'>";
                        foreach ($array as $n => $v) {

                            if (is_array($v['units'])) {
                                echo "<li>";
                                echo "<a href='" . base_url("index.php/Home/dashboard/{$v['id']}") . "' class='unit' >" . $v['level']['initials'] . " : " . $v['name'] . "</a>  ";

                                echo isset($v['owner']['names']) ? "<span class='pull-right text-muted' ><i class='icon icon-user'></i>  " . $v['owner']['names'] . "</span>  " : "<span class='pull-right text-muted' >No Owner</span>";


                                echo "</li>";
                                doSomething($v['units']);
                            } else {
                                echo $v['name'];


                                //do whatever you want to do with a single node
                            }
                        }

                        echo "</ul>";
                    }

                    doSomething($data['site_map']);
                    ?>

                </div>

                <style>
                    ul.sitemap,  ul.sitemap li {
                        list-style: none;
                        /*                        padding: 0; 
                                                margin: 0;*/

                    }
                    ul.sitemap li{
                        border-bottom: 1px dashed #eee;
                        padding: 5px;
                    }
                    ul.sitemap li > ul {
                        padding: 5px;
                        background: #000;
                        margin: 5px;
                    }

                </style>

            </div>


        </div>
        <div class="col-sm-5">
            <div class="card">
                <div class="card-header">

                    <h3>List View</h3>
                </div>
                <div class="card-block">
                    <table class="table table-small table-sm ">
                        <tbody>
                            <tr>
                                <th>Unit</th>
                                <th>Type</th>
                                <th>Owner</th>
                            </tr>

                        </tbody>
                        <tbody>

                            <?php foreach ($data['all_units'] as $key => $value): ?>
                                <tr>
                                    <td><a href="<?= base_url("index.php/Home/dashboard/{$value['id']}"); ?>"><?= $value['name'] ?></a></td>
                                    <td><?= $value['level']['name'] ?></td>
                                    <td> <?= isset($value['owner']['names']) ? '<i class="icon icon-user"></i>' . $value['owner']['names'] : "No Owner"; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>


                </div>

            </div>


        </div>

    </div>


</div>