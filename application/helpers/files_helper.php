<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


if (!function_exists('getFile')) {

    function getFile($filename) {
        return $file;
    }

}

if (!function_exists('accept_file')) {

    function accept_file($file_type) {
        $rejected = array(
            "",
            "application/x-msdownload",
            "application/octet-stream",
        );
        return (!in_array($file_type, $rejected)) ? true : false;
    }

}
if (!function_exists('getFileLink')) {

    function getFileLink($filename) {
        return (UPLOAD_BASE_URL . UPLOAD_BACKET . "/" . $filename);
    }

}
if (!function_exists('getFileRoot')) {

    function getFileRoot($filename) {
        return (UPLOAD_FOLDER . $filename);
    }

}

if (!function_exists('calcFileSize')) {

    function calcFileSize($filesize) {
        return number_format($filesize / (1024 * 1024), 1) . " MB ";
    }

}

if (!function_exists('getFileSize')) {

    function getFileSize($filename) {
        return 0;
        $filelink = getFileRoot($filename);
        $filesize = file_exists($filelink) ? filesize($filelink) : 0;
        return calcFileSize($filesize);
    }

}

if (!function_exists('img_src')) {

    function img_src($filename, $width = 300, $height = 300) {
        $ci = & get_instance();
        $ci->load->model('Documents/cropModel', "crop");
        $file = $ci->crop->crop($filename, $width, $height);
        return UPLOAD_BASE_URL . UPLOAD_BACKET . "/" . $file;
    }

}

if (!function_exists('files_upload')) {

    function files_upload($module = NULL, $table = NULL, $record_id = 0) {
//        return __METHOD__;
        $html = "
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
                <input type='hidden'  value='' name='attachments' class='form-control' placeholder='this text field should be hidden'  />
                <table class='table table-striped table-condensed table-sm table-small-font table-bordered'>
                    <thead>
                        <tr>
                            <th><input type='file' class='ipfile'  multiple='multiple' onchange=\"uploadFiles(this.id, 'files-'+this.id)\" name='attachments[]' id='$module-$table-$record_id' placeholder=''  /></th>
                            <th width='100'>Size</th>
                        </tr>
                        <small class='text-danger' id='auditreport-val'></small>
                    </thead>
                    <tbody id='files-$module-$table-$record_id'>
                    </tbody>
                </table>
                ";
        $html .= show_documents($module, $table, $record_id);
        $html .= "
            </div>
        </div>";
        return $html;
    }

}

if (!function_exists('show_documents')) {

    function show_documents($module = NULL, $table = NULL, $record_id = 0, $modal = false, $callback = false, $access = array("read" => 1, "preview" => 1, "edit" => 0, "delete" => 0)) {
        $allowed = array("read" => 1, "preview" => 1, "edit" => false, "delete" => false);
        if (is_array($access)) {
            foreach ($allowed as $key => $value) {
                if (!isset($access[$key])) {
                    $access[$key] = $value;
                }
            }
        } else {
            foreach ($allowed as $key => $value) {
                if (!isset($access[$key])) {
                    $access[$key] = $value;
                }
            }
        }


        $office_mime_types = array("application/msword",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.template",
            "application/vnd.ms-word.document.macroEnabled.12",
            "application/vnd.ms-word.template.macroEnabled.12",
            "application/vnd.ms-excel",
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "application/vnd.openxmlformats-officedocument.spreadsheetml.template",
            "application/vnd.ms-excel.sheet.macroEnabled.12",
            "application/vnd.ms-excel.template.macroEnabled.12",
            "application/vnd.ms-excel.addin.macroEnabled.12",
            "application/vnd.ms-excel.sheet.binary.macroEnabled.12",
            "application/vnd.ms-powerpoint",
            "application/vnd.openxmlformats-officedocument.presentationml.presentation",
            "application/vnd.openxmlformats-officedocument.presentationml.template",
            "application/vnd.openxmlformats-officedocument.presentationml.slideshow",
            "application/vnd.ms-powerpoint.addin.macroEnabled.12",
            "application/vnd.ms-powerpoint.presentation.macroEnabled.12",
            "application/vnd.ms-powerpoint.template.macroEnabled.12",
            "application/vnd.ms-powerpoint.slideshow.macroEnabled.12",
            "application/vnd.ms-access");

        $modal_link = !$modal ? MODAL_LINK : MODAL_AJAX;
        $ci = & get_instance();
        $ci->load->model("Documents/documentsModel", "doc");
        $where = array("table_name" => $table, "record_id" => $record_id);
        $files = $ci->doc->getRecordDocuments($where);
        $html = "
        <table class='table table-striped table-condensed table-sm '>
            <thead>
                <tr>
                    <th style='width:40px;'>#</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Size</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>    
            ";
        $num = 0;
        foreach ($files as $key => $value):
            if (in_array($value['filetype'], $office_mime_types)) {
                $doc_link = "href='https://view.officeapps.live.com/op/view.aspx?src=" . (getFileLink($value['filename'])) . "'";
            } else {
                $doc_link = "href='" . base_url("/index.php/Viewer/index/#") . (getFileLink($value['filename'])) . "'";
            }
            $num++;
            $html .= "    
                    <tr class='upload_" . $value['id'] . "'>
                        <td scope='row'> " . $num . " </td>
                        <td> <a " . $doc_link . " target='_BLANK'>" . $value['title'] . "</a> </td>
                        <td> " . $value['filetype'] . " </td>
                        <td> " . getFileSize($value['filename']) . " </td>
                        <td style='widtd:170px;'>
                            <div class='btn-group btn-group-sm pull-right'>
                                <a class='btn " . (($access['read']) ? NULL : "hidden") . " btn-dark-outline waves-effect waves-light' target='_blank' " . $doc_link . "><i class='icon ion-eye'></i></a>
                                <a class='btn " . (($access['preview']) ? NULL : "hidden") . "btn-success-outline waves-effect waves-light' download='{$value['title']}' href='" . (getFileLink($value['filename'])) . "' ><i class='icon ion-android-download'></i></a>
                                <a class='btn " . (($access['edit']) ? NULL : "hidden") . " btn-warning-outline waves-effect waves-light' " . $modal_link . " href='" . base_url("index.php/Documents/editDocument/{$value['id']}") . "'><i class='icon icon-pencil'></i></a>
                                <a class='btn " . (($access['delete']) ? NULL : "hidden") . " btn-danger-outline waves-effect waves-light' " . $modal_link . " href='" . base_url("index.php/Documents/deleteDocument/{$value['id']}") . "'><i class='icon icon-trash'></i></a>
                            </div>
                        </td>
                        
                    </tr>";
        endforeach;
        $html .= "</tbody>
        </table>";
        return $html;
    }

}

if (!function_exists('documents_properties')) {

    function documents_properties($module = NULL, $table = NULL, $record_id = 0) {
        $ci = & get_instance();
        $ci->load->model("Documents/documentsModel", "doc");
        $where = array("table_name" => $table, "record_id" => $record_id);
        $files = $ci->doc->getRecordDocuments($where);
        $properties = array("files" => 0, "filesSize" => 0);
        $filesize_sum = 0;
        foreach ($files as $key => $value):
            $filesize_sum += file_exists(getFileRoot($value['filename'])) ? filesize(getFileRoot($value['filename'])) : 0;
        endforeach;
        $properties['files'] = count($files);
        $properties['size'] = calcFileSize($filesize_sum);
        return $properties;
    }

}
