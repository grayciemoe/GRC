<?= form_open_multipart("Risk/analysisPost", array('id' => '', 'class' => '')) ?>
<?php $risk_analysis = $data['analyse'] ?>
<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Control Analysis  </h4>
        </div>
        <div class='modal-body'>
            <input type='hidden' class='form-control'  name='id' id='txt-risk_analysis-id' value='<?= $risk_analysis['id'] ?>' />
            <input type='hidden' class='form-control'  name='risk' id='txt-risk_analysis-risk' value='<?= $risk_analysis['risk'] ?>' placeholder='risk' />
            <input type='hidden' class='form-control'  name='type' id='txt-risk_analysis-risk' value='control_ratings' placeholder='risk' />
            <div class="row">
                <div class="col-sm-6">            
                    <div class='form-group row'>
                        <label  for="txt-risk_analysis-effectiveness"  class='col-sm-3 form-control-label'>Effectiveness</label>
                        <div class='col-sm-9'>
                            <select  class='form-control' required="" name='effectiveness' id='txt-risk_analysis-effectiveness'> 
                                <option value=''>SELECT</option>
                                <option value='1' <?= $risk_analysis['effectiveness'] == '1' ? "selected='selected'" : NULL; ?> >  <?= ucwords(heatmap_key('effectiveness', 1)) ?><span>(1)</span>  </option>
                                <option value='2' <?= $risk_analysis['effectiveness'] == '2' ? "selected='selected'" : NULL; ?> >  <?= ucwords(heatmap_key('effectiveness', 2)) ?> <span>(2)</span> </option>
                                <option value='3' <?= $risk_analysis['effectiveness'] == '3' ? "selected='selected'" : NULL; ?> >  <?= ucwords(heatmap_key('effectiveness', 3)) ?> <span>(3)</span> </option>
                                <option value='4' <?= $risk_analysis['effectiveness'] == '4' ? "selected='selected'" : NULL; ?> >  <?= ucwords(heatmap_key('effectiveness', 4)) ?> <span>(4)</span> </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class='form-group row'>
                        <label  for="txt-risk_analysis-adequacy"  class='col-sm-3 form-control-label'>Adequacy</label>
                        <div class='col-sm-9'>
                            <select  class='form-control' required="" name='adequacy' id='txt-risk_analysis-adequacy'> 
                                <option value=''>SELECT</option>
                                <option value='1' <?= $risk_analysis['adequacy'] == '1' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('adequacy', 1)) ?> <span>(1)</span> </option>
                                <option value='2' <?= $risk_analysis['adequacy'] == '2' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('adequacy', 2)) ?><span>(2)</span> </option>
                                <option value='3' <?= $risk_analysis['adequacy'] == '3' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('adequacy', 3)) ?> <span>(3)</span> </option>
                                <option value='4' <?= $risk_analysis['adequacy'] == '4' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('adequacy', 4)) ?><span>(4)</span>  </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Cancel</button>
            <button type='submit' class='btn btn-secondary waves-effect' >Save</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<div class="col-sm-6 hidden">            
    <div class='form-group row'>
        <label  for="txt-risk_analysis-probability"  class='col-sm-2 form-control-label'>Probability</label>
        <div class='col-sm-10'>
            <select  class='form-control' required="" name='probability' autofocus="on" id='txt-risk_analysis-probability'  onfocus="changeTable(this.name)"> 
                <option value=''>SELECT</option>
                <option value='1' <?= $risk_analysis['probability'] == '1' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('probability', 1)) ?> <span>(1)</span></option>
                <option value='2' <?= $risk_analysis['probability'] == '2' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('probability', 2)) ?> <span>(2)</span></option>
                <option value='3' <?= $risk_analysis['probability'] == '3' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('probability', 3)) ?> <span>(3)</span></option>
                <option value='4' <?= $risk_analysis['probability'] == '4' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('probability', 4)) ?> <span>(4)</span></option>
                <option value='5' <?= $risk_analysis['probability'] == '5' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('probability', 5)) ?> <span>(5)</span></option>
            </select>
        </div>
    </div>
</div>
<div class="col-sm-6 hidden">
    <div class='form-group row'>
        <label  for="txt-risk_analysis-impact"  class='col-sm-2 form-control-label'>Impact</label>
        <div class='col-sm-10'>
            <select  class='form-control' required="" name='impact' id='txt-risk_analysis-impact' onfocus="changeTable(this.name)" > 
                <option value=''>SELECT</option>
                <option value='1' <?= $risk_analysis['impact'] == '1' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('impact', 1)) ?> <span>(1)</span></option>
                <option value='2' <?= $risk_analysis['impact'] == '2' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('impact', 2)) ?> <span>(2)</span></option>
                <option value='3' <?= $risk_analysis['impact'] == '3' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('impact', 3)) ?> <span>(3)</span> </option>
                <option value='4' <?= $risk_analysis['impact'] == '4' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('impact', 4)) ?> <span>(4)</span></option>
                <option value='5' <?= $risk_analysis['impact'] == '5' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('impact', 5)) ?> <span>(5)</span></option>
            </select>
        </div>
    </div>
</div>
<?= form_close(); ?>