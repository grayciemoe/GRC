<div class="row">

        <div class="col-sm-12">
            <?php
            $num = 0;
            foreach ($data['recommendations'] as $key => $value) :
                $num++;
                ?>
                <div class="card">


                    <div class="card-block">
                        <h4 class="card-title text-muted">Recommendation:</h4>
                        <hr />
                        <a href="<?= base_url('index.php/Audit/recommendationView/' . $value['id']) ?>" ><?= $value['recommendation'] ?></a>

                        <div class="row">

                            <div class="col-sm-3 <?= ((strtotime($issue['review_date']) < strtotime(date('Y-m-d'))) && (count_comments('Audit', 'recommendation', $value['id']) == 0)) ? "text-danger" : "text-success"?>">
                                <label>Respond by date:</label>
                                <?= strftime("%b-%d-%Y", strtotime($value['respond_by_date'])) ?></div>
                            <div class="col-sm-6"></div>

                            <div class="btn-group pull-right">

                                <a href="<?= base_url('index.php/Audit/recommendationForm/' . $value['id'] . '/' . $value['issue']) ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm btn-small"><i class="icon icon-pencil"></i></a>

                                <a href="<?= base_url('index.php/Audit/deleteRecommendation/' . $value['id']) ?>" <?= MODAL_LINK ?> class="btn btn-secondary btn-sm btn-small"><i class="icon icon-trash"></i></a>
                                <a href="<?= base_url('index.php/Audit/recommendationView/' . $value['id']) ?>" class="btn btn-custom btn-sm" >
                                    <i class="icon icon-bubbles"></i>
                                    <span> <?= count_comments('Audit', 'recommendation', $value['id']) ?></span>
                                    Go To Recommendation
                                </a> 
                            </div>

                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </div>

