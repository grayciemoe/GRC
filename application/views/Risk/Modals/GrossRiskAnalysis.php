<?= form_open_multipart("Risk/analysisPost", array('id' => '', 'class' => '')) ?>
<?php $risk_analysis = $data['analyse'] ?>
<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Risk Analysis </h4>
        </div>
        <script>
            function changeTable(parameters) {
                $('.analysis_table').addClass('hidden');
                $('#table-' + parameters).removeClass('hidden');
            }

        </script>
        <div class='modal-body'>
            <input type='hidden' class='form-control'  name='id' id='txt-risk_analysis-id' value='<?= $risk_analysis['id'] ?>' />
            <input type='hidden' class='form-control'  name='risk' id='txt-risk_analysis-risk' value='<?= $risk_analysis['risk'] ?>' placeholder='risk' />
            <input type='hidden' class='form-control'  name='type' id='txt-risk_analysis-risk' value='gross_risk' placeholder='risk' />
            <div class="row">
                <div class="col-sm-6">            
                    <div class='form-group row'>
                        <label  for="txt-risk_analysis-probability"  class='col-sm-2 form-control-label'>Probability</label>
                        <div class='col-sm-10'>
                            <select  class='form-control' required="" name='probability' autofocus="on" id='txt-risk_analysis-probability'  onfocus="changeTable(this.name)"> 
                                <option value='1' <?= $risk_analysis['probability'] == '1' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('probability', 1)) ?> <span>(1)</span></option>
                                <option value='2' <?= $risk_analysis['probability'] == '2' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('probability', 2)) ?> <span>(2)</span></option>
                                <option value='3' <?= $risk_analysis['probability'] == '3' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('probability', 3)) ?> <span>(3)</span></option>
                                <option value='4' <?= $risk_analysis['probability'] == '4' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('probability', 4)) ?> <span>(4)</span></option>
                                <option value='5' <?= $risk_analysis['probability'] == '5' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('probability', 5)) ?> <span>(5)</span></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class='form-group row'>
                        <label  for="txt-risk_analysis-impact"  class='col-sm-2 form-control-label'>Impact</label>
                        <div class='col-sm-10'>
                            <select required=""  class='form-control' name='impact' id='txt-risk_analysis-impact' onfocus="changeTable(this.name)" > 
                                <option value='1' <?= $risk_analysis['impact'] == '1' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('impact', 1)) ?> <span>(1)</span></option>
                                <option value='2' <?= $risk_analysis['impact'] == '2' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('impact', 2)) ?> <span>(2)</span></option>
                                <option value='3' <?= $risk_analysis['impact'] == '3' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('impact', 3)) ?> <span>(3)</span> </option>
                                <option value='4' <?= $risk_analysis['impact'] == '4' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('impact', 4)) ?> <span>(4)</span></option>
                                <option value='5' <?= $risk_analysis['impact'] == '5' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('impact', 5)) ?> <span>(5)</span></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <table class="table analysis_table hidden" id="table-impact">
                        <thead>
                            <tr>
                                <th style="width: 200px;">Description
                                    (Score)
                                </th>
                                <th>Potential or Actual Financial Loss
                                </th>
                                <th>Reputation and Image </th>
                            </tr>

                        </thead> 
                        <tbody>
                            <tr>
                                <td  class="ht-blue font-w600 text-white"> Insignificant (1)  </td>
                                <td>< Kshs 100,0000</td>
                                <td>Little or no reputational impact.</td>
                            </tr>

                            <tr>
                                <td  class=" ht-green  font-w600 text-white"> Minor (2) </td>
                                <td>Kshs. 100,000 to Kshs. 500,000</td>
                                <td>Sporadic localised unfavourable publicity. Issue resolved by day-to-day processes.</td>
                            </tr>
                            <tr>
                                <td  class=" ht-yellow  font-w600 text-white"> Moderate (3)  </td>
                                <td>Kshs. 500,000 to Kshs. 1,000,000</td>
                                <td>Localised negative publicity. Short-term impact. Embarrassment for company. Managed by communication function.</td>
                            </tr>
                            <tr>
                                <td  class=" ht-orange  font-w600 text-white">Major (4)  </td>
                                <td>Kshs. 1,000,000 to Kshs. 5,000,000 </td>
                                <td>Significant continued negative publicity in local and regional press. Intervention of CEO to answer public concerns.</td>
                            </tr>
                            <tr>
                                <td  class="ht-red   font-w600 text-white"> Catastrophic (5) </td>
                                <td>Over Kshs. 5,000,000</td>
                                <td>Major sustained negative publicity nationally. Loss of public trust, intervention of Board to answer public concerns.</td>
                            </tr>

                        </tbody>

                    </table>

                    <table class="table analysis_table  " id="table-probability">
                        <thead>
                            <tr>
                                <th>Description
                                    (Score)
                                </th>
                                <th>Probability </th>
                                <th>Frequency  </th>
                                <th>Further descriptions </th>

                            </tr>

                        </thead> 
                        <tbody>
                            <tr>
                                <td  class=" ht-blue text-center font-w600 text-white">Rare (1)</td>
                                <td>1% - 5%
                                </td>
                                <td>Less than once every 10 years
                                </td>
                                <td>  Occurrence is highly unlikely
                                    <br>  Risk is not likely repeated
                                    <br>  Risk is once-off
                                    <br>  No previous history
                                </td>
                            </tr>

                            <tr>
                                <td  class="  ht-green text-center font-w600 text-white"> Unlikely (2)</td>
                                <td>5% - 25%
                                </td>
                                <td> Every 5 – 10 years
                                </td>
                                <td>Slight possibility of occurrence
                                    <br> Risks are isolated incidents
                                    <br>  Risk occurs in managed area
                                </td>
                            </tr>

                            <tr > <td class="ht-yellow text-center font-w600 text-white "> Probable (3)</td>
                                <td>25% - 50%
                                </td>
                                <td> Every 2 – 5 years
                                </td>
                                <td> Evidence of increasing trend
                                    <br> Compliance is complex </td>
                            </tr>

                            <tr>
                                <td  class=" ht-orange text-center font-w600 text-white ">Likely  (4)</td>
                                <td>50% - 75%
                                </td>
                                <td> Every 1 – 2 years
                                </td>
                                <td> Frequently recurring risk
                                    <br>  No management reviews
                                    <br> No clear policies, procedures
                                </td>
                            </tr>

                            <tr>
                                <td  class=" ht-red text-center font-w600 text-white "> Almost certain (5)</td>
                                <td>75% - 100%
                                </td>
                                <td> Once or more per year
                                </td>
                                <td>  High frequency of recurrence
                                    <br> Risk will definitely occur
                                </td>
                            </tr>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='submit' class='btn btn-secondary waves-effect' >Save</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<div class="row  hidden">
    <div class="col-sm-6">            
        <div class='form-group row'>
            <label  for="txt-risk_analysis-effectiveness"  class='col-sm-3 form-control-label'>Effectiveness</label>
            <div class='col-sm-9'>
                <select  class='form-control' required="" name='effectiveness' id='txt-risk_analysis-effectiveness'> 

                    <option value='4' <?= $risk_analysis['effectiveness'] == '4' ? "selected='selected'" : NULL; ?> >  <?= ucwords(heatmap_key('effectiveness', 4)) ?> <span>(4)</span> </option>
                    <option value='3' <?= $risk_analysis['effectiveness'] == '3' ? "selected='selected'" : NULL; ?> >  <?= ucwords(heatmap_key('effectiveness', 3)) ?> <span>(3)</span> </option>
                    <option value='2' <?= $risk_analysis['effectiveness'] == '2' ? "selected='selected'" : NULL; ?> >  <?= ucwords(heatmap_key('effectiveness', 2)) ?> <span>(2)</span> </option>
                    <option value='1' <?= $risk_analysis['effectiveness'] == '1' ? "selected='selected'" : NULL; ?> >  <?= ucwords(heatmap_key('effectiveness', 1)) ?><span>(1)</span>  </option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class='form-group row'>
            <label  for="txt-risk_analysis-adequacy"  class='col-sm-3 form-control-label'>Adequacy</label>
            <div class='col-sm-9'>
                <select  class='form-control'name='adequacy' required="" id='txt-risk_analysis-adequacy'> 

                    <option value='4' <?= $risk_analysis['adequacy'] == '4' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('adequacy', 4)) ?><span>(4)</span>  </option>
                    <option value='3' <?= $risk_analysis['adequacy'] == '3' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('adequacy', 3)) ?> <span>(3)</span> </option>
                    <option value='2' <?= $risk_analysis['adequacy'] == '2' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('adequacy', 2)) ?><span>(2)</span> </option>
                    <option value='1' <?= $risk_analysis['adequacy'] == '1' ? "selected='selected'" : NULL; ?> > <?= ucwords(heatmap_key('adequacy', 1)) ?> <span>(1)</span> </option>
                </select>
            </div>
        </div>
    </div>
</div>

<?= form_close(); ?>