<div class='container'>

    <div class='card-box'>

        <h4 class='header-title m-t-0 m-b-30'>Attach Documents</h4>

        <?= form_open_multipart('Documents/uploadFiles'); ?>
        <div class='row'>
            <div class='col-sm-12'>

                <div class='row border-r'>

                    <div class='col-xs-12'><label class='control-label'> </label></div>
                    <div class='col-xs-4'>
                    </div>

                    <br>
                </div>
                <script>
                    
                </script>
                <input type='text'  value='' name='attachments' class='form-control' placeholder='this text field should be hidden'  />
                <table class='table table-striped table-condensed table-sm table-small-font table-bordered'>
                    <thead>
                        <tr>
                            <th><input type='file'  multiple='multiple' onchange='uploadFiles(this.id, "filesList")' name='attachments[]' id='file-attachments' placeholder=''  /></th>
                            <th width='100'>Size</th>
                        </tr>
                    </thead>
                    <tbody id='filesList'>

                    </tbody>
                </table>
            </div>
        </div>
        <button type='submit' class='btn btn-default'>Upload</button>
        <?= form_close(); ?>


    </div>
</div>