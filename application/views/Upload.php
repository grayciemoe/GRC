<html>
<!--<img src = "https://storage.googleapis.com/grc_uploads_icea/<?php echo $employee->photo_url ?>" style="width:274px;height:250px;"/>-->
    <body>
        <?= form_open_multipart("Chart/uploadPost", array()); ?>
        <input type="file" name="file" />
        <input type="submit"/>
        <?= form_close(); ?>
    </body>

</html>