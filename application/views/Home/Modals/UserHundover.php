<?php if (count($data['users']) > 1): ?>
    <?= form_open("Home/userHundoverPost"); ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"> 
                    Hand Over <br><small> &emsp;<span class="text-info"><i class="icon icon-user"></i> <?= $data['user']['names'] ?></span></small>
                </h4>
            </div>

            <div class="modal-body">
                <?php // print_pre($data); ?>
                <input type="hidden" name="from" value="<?= $data['user']['id'] ?>" />
                <table class="table table-sm table-small table-hover">
                    <tbody>

                        <?php
                        foreach ($data['users'] as $key => $value):
                            if ($data['user']['id'] == $value['id']) {
                                continue;
                            }
                            ?>
                            <tr>
                                <td> 
                                    <div class="radio radio-primary radio-circle  ">
                                        <input id="checkbox-<?= $value['id'] ?>" type="radio" required="" value="<?= $value['id'] ?>" name="to">
                                        <label for="checkbox-<?= $value['id'] ?>">
                                            <?= $value['names'] ?>
                                        </label>
                                    </div> 
                                </td>
                                <td> <img src="<?= img_src($value['profile_pic'], 30, 30) ?>" class="img-circle pull-right"></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

                <div class="checkbox checkbox-danger checkbox-circle">
                    <input id="checkbox-12" required type="checkbox" name="agree" value="agree" />
                    <label for="checkbox-12">
                        I understand that once I transfer this duties I can only reverse them one at a time.
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger waves-effect" ><i class="icon icon-vector"></i> Transfer Responsibilities</button>

            </div>



        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    <?= form_close(); ?>
<?php else: ?>

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"> 
                    No <?= $data['user']['name'] ?>
                </h4>
            </div>

            <div class="modal-body text-center">
                <h1 class="text-center text-muted">There is no one to hand over to</h1>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
<?php endif; ?>

