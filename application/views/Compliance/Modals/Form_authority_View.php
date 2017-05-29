
<?php $authority = $data['authority']; ?>

<?= form_open_multipart("Compliance/authorityPost/", array('id' => 'frm-authority', 'class' => '', 'onsubmit' => "postAuthority('frm-authority'); return false;")) ?>

<div class='modal-dialog modal-lg'>
    <div class='modal-content'>
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h4 class='modal-title' id='myModalLabel'> Authority </h4>
        </div>
        <div class='modal-body'>
            <input type='hidden' class='form-control'  name='id' id='txt-authority-id' value='<?= $authority['id'] ?>' />
            <div class="response"></div>

            <div class='form-group row'>
                <label  for="txt-authority-title"  class='col-sm-2 form-control-label'>Title</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'   name='title'  required=''  id='txt-authority-title' value='<?= $authority['title'] ?>' placeholder='title' />
                </div>
            </div>
            <div class='form-group row hidden'>
                <label  for="txt-authority-category"  class='col-sm-2 form-control-label'>Category</label>
                <div class='col-sm-10'>
                    <input type='text' class='form-control'  name='category' id='txt-authority-category' value='<?= $authority['category'] ?>' placeholder='category' />
                </div>
            </div>
            <div class="row">


                <div class='form-group col-sm-6'>
                    <label  for="txt-authority-report_sent_to"  class='col-sm-4 form-control-label'>Report Sent To</label>
                    <div class='col-sm-8'>
                        <input type='text' class='form-control'  name='report_sent_to' id='txt-authority-report_sent_to' value='<?= $authority['report_sent_to'] ?>' placeholder='Full Names' />
                    </div>
                </div>
                <div class='form-group  col-sm-6'>
                    <label  for="txt-authority-type"  class='col-sm-4 form-control-label'>Type</label>
                    <div class='col-sm-8'>
                        <select  class='form-control' required name='type' id='txt-authority-type'> 
                            <option value=''>SELECT</option>
                            <option value='government' <?= $authority['type'] == 'government' ? "selected='selected'" : NULL; ?> > Government </option>
                            <option value='legal' <?= $authority['type'] == 'legal' ? "selected='selected'" : NULL; ?> > Legal </option>
                            <option value='regulatory' <?= $authority['type'] == 'regulatory' ? "selected='selected'" : NULL; ?> > Regulatory </option>
                            <option value='internal' <?= $authority['type'] == 'internal' ? "selected='selected'" : NULL; ?> > Internal </option>
                        </select>
                    </div>
                </div>

            </div>
            <hr class="m-0 p-0 row"> 
            <div class="row">
                <div class='form-group col-sm-3'>
                    <label  for="txt-authority-contact_name"  class='col-sm-12 form-control-label'>Contact Name</label>
                    <div class='col-sm-12'>
                        <input type='text' class='form-control'  name='contact_name' id='txt-authority-contact_name' value='<?= $authority['contact_name'] ?>' placeholder='Full Names' />
                    </div>
                </div>
                <div class='form-group  col-sm-3'>
                    <label  for="txt-authority-contact_email"  class='col-sm-12 form-control-label'>Contact Email</label>
                    <div class='col-sm-12'>
                        <input type='email' class='form-control'  name='contact_email' id='txt-authority-contact_email' value='<?= $authority['contact_email'] ?>' placeholder='' />
                    </div>
                </div>
                <div class='form-group  col-sm-3'>
                    <label  for="txt-authority-contact_address"  class='col-sm-12 form-control-label'>Contact Address</label>
                    <div class='col-sm-12'>
                        <input type='text' class='form-control'  name='contact_address' id='txt-authority-contact_address' value='<?= $authority['contact_address'] ?>' placeholder='' />
                    </div>
                </div>
                <div class='form-group  col-sm-3'>
                    <label  for="txt-authority-contact_phone"  class='col-sm-12 form-control-label'>Contact Phone</label>
                    <div class='col-sm-12'>
                        <input type='text' class='form-control'  name='contact_phone' id='txt-authority-contact_phone' value='<?= $authority['contact_phone'] ?>' placeholder='' />
                    </div>
                </div>

            </div>

        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary waves-effect' data-dismiss='modal'>Close</button>
            <button type='submit' id="submission_button" class='btn btn-primary waves-effect' >Save Changes</button>
        </div>
        <div class="modal-body ">

            <div class="table-responsive">
                <table class="table table-striped table-sm table-small">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Report Sent To</th>
                            <th>Contact Names</th>
                            <th>Contact Email</th>
                            <th>Contact Address</th>
                            <th colspan="2">Contact Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['authorities'] as $key => $value): ?>
                            <tr>
                                <td><?= $value['title'] ?></td>
                                <td><?= ucwords($value['type']) ?></td>
                                <td><?= $value['report_sent_to'] ?></td>
                                <td><?= $value['contact_name'] ?></td>
                                <td><a href="mailto:<?= $value['contact_email'] ?>"><?= $value['contact_email'] ?></a></td>
                                <td><?= $value['contact_address'] ?></td>
                                <td><?= $value['contact_phone'] ?></td>
                                <td style="width:120px;">
                                    <div class="btn btn-group pull-right">
                                        <?php if (am_user_type(array(1, 5, 10))): ?>
                                            <a href="<?= base_url("index.php/Compliance/authorityForm/{$value['id']}") ?>" <?= MODAL_AJAX ?> class="btn btn-secondary btn-small btn-sm m-0 "><i class="icon icon-pencil"></i></a>
                                        <?php endif; ?>
                                        <?php if (am_user_type(array(1, 5, 10))): ?>
                                            <a href="<?= base_url("index.php/Compliance/authorityDelete/{$value['id']}") ?>" <?= MODAL_AJAX ?> class="btn btn-secondary btn-sm m-0 "><i class="icon icon-trash"></i></a>
                                            <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?= form_close(); ?>
<script type="text/javascript">


    function postAuthority(formId) {
        var url = ($("#" + formId).attr("action"));
        //$("#" + formId).html("Loading...");
        $(".modal-footer").html("<h3 class='text-muted'><i class='fa fa-spin fa-spinner'></i> loading ... .</h3>");
        $(".modal-footer").addClass("text-center");

        $.post(url, $("#" + formId).serialize(), function (response) {
            ajaxFileModal("<?= base_url("index.php/Compliance/authorityForm/") ?>");
        });
    }



</script>