<!-- Footer -->
<footer class="footer text-right">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?= strftime("%Y", time()) ?> &copy; GRC.
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->
</div> 
<!-- container -->
<!-- Right Sidebar -->
<div class="side-bar right-bar">
    <div class="nicescroll">
        <ul class="nav nav-tabs text-xs-center">
            <li class="nav-item">
                <a href="#home-2"  class="nav-link active" data-toggle="tab" aria-expanded="false">
                    Activity
                </a>
            </li>
            <li class="nav-item">
                <a href="#messages-2" class="nav-link" data-toggle="tab" aria-expanded="true">
                    Settings
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active" id="home-2">
                <div class="timeline-2">
                    <div class="time-item">
                        <div class="item-info">
                            <small class="text-muted">5 minutes ago</small>
                            <p><strong><a href="#" class="text-info">John Doe</a></strong> Uploaded a photo <strong>"DSC000586.jpg"</strong></p>
                        </div>
                    </div>

                    <div class="time-item">
                        <div class="item-info">
                            <small class="text-muted">30 minutes ago</small>
                            <p><a href="" class="text-info">Lorem</a> commented your post.</p>
                            <p><em>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet tellus ut tincidunt euismod. "</em></p>
                        </div>
                    </div>

                    <div class="time-item">
                        <div class="item-info">
                            <small class="text-muted">59 minutes ago</small>
                            <p><a href="" class="text-info">Jessi</a> attended a meeting with<a href="#" class="text-success">John Doe</a>.</p>
                            <p><em>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet tellus ut tincidunt euismod. "</em></p>
                        </div>
                    </div>

                    <div class="time-item">
                        <div class="item-info">
                            <small class="text-muted">1 hour ago</small>
                            <p><strong><a href="#" class="text-info">John Doe</a></strong>Uploaded 2 new photos</p>
                        </div>
                    </div>

                    <div class="time-item">
                        <div class="item-info">
                            <small class="text-muted">3 hours ago</small>
                            <p><a href="" class="text-info">Lorem</a> commented your post.</p>
                            <p><em>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet tellus ut tincidunt euismod. "</em></p>
                        </div>
                    </div>

                    <div class="time-item">
                        <div class="item-info">
                            <small class="text-muted">5 hours ago</small>
                            <p><a href="" class="text-info">Jessi</a> attended a meeting with<a href="#" class="text-success">John Doe</a>.</p>
                            <p><em>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet tellus ut tincidunt euismod. "</em></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="messages-2">

                <div class="row m-t-20">
                    <div class="col-xs-8">
                        <h5 class="m-0">Notifications</h5>
                        <p class="text-muted m-b-0"><small>Do you need them?</small></p>
                    </div>
                    <div class="col-xs-4 text-right">
                        <input type="checkbox" checked data-plugin="switchery" data-color="#64b0f2" data-size="small"/>
                    </div>
                </div>

                <div class="row m-t-20">
                    <div class="col-xs-8">
                        <h5 class="m-0">API Access</h5>
                        <p class="m-b-0 text-muted"><small>Enable/Disable access</small></p>
                    </div>
                    <div class="col-xs-4 text-right">
                        <input type="checkbox" checked data-plugin="switchery" data-color="#64b0f2" data-size="small"/>
                    </div>
                </div>

                <div class="row m-t-20">
                    <div class="col-xs-8">
                        <h5 class="m-0">Auto Updates</h5>
                        <p class="m-b-0 text-muted"><small>Keep up to date</small></p>
                    </div>
                    <div class="col-xs-4 text-right">
                        <input type="checkbox" checked data-plugin="switchery" data-color="#64b0f2" data-size="small"/>
                    </div>
                </div>

                <div class="row m-t-20">
                    <div class="col-xs-8">
                        <h5 class="m-0">Online Status</h5>
                        <p class="m-b-0 text-muted"><small>Show your status to all</small></p>
                    </div>
                    <div class="col-xs-4 text-right">
                        <input type="checkbox" checked data-plugin="switchery" data-color="#64b0f2" data-size="small"/>
                    </div>
                </div>

            </div>
        </div>
    </div> <!-- end nicescroll -->
</div>
<!-- /Right-bar -->
</div> <!-- End wrapper -->
<!-- App js -->
<script src="<?= base_url("assets/js/jquery.core.js") ?>"></script>
<script src="<?= base_url("assets/js/jquery.app.js") ?>"></script>

<script type="text/javascript">
    
    CKEDITOR.replace('txt-issue-comment');

    function toggle_hidden_class(class_name) {
        $('.' + class_name).toggleClass('hidden');
    }



    function parseDate(str) {
        var s = str.split(" "),
                d = str[0].split("-"),
                t = str[1].replace(/:/g, "");
        return d[2] + d[1] + d[0] + t;
    }

    $(document).ready(function () {
        $('.hide_onclick').click(function () {
            $(this).hide("fast")

        });
//        $('.valdate_greater').onchange(function () {
//            if (parseDate("17-05-1989 12:15:00") > parseDate("15-05-1989 14:00:00")) {
//                alert("larger");
//            } else {
//                alert("smaller");
//            }
//        });

        $('.ajax_request').click(function () {
            var url = $(this).attr("href");
            var target_id = $(this).data("target");
            ajaxFileRequest(url, target_id);
            return false;
        });
        $('.collapse-content').slideUp(0);
        $('.callapse-open .collapse-content').slideDown(0);
        $('.collapse-grc .collapse-cmd').click(function () {

            if (($($(this).data("target")).css("display")) === 'none') {
                $('.direction-arrows').removeClass('icon-arrow-down');
                $('.direction-arrows').removeClass('icon-arrow-up');
                $('.direction-arrows').addClass('icon-arrow-down');
                $($(this).data("target") + "_arrow" + ' .direction-arrows ').addClass('icon-arrow-up');
                $('.collapse-content').slideUp('fast');
                $($(this).data("target")).slideDown('fast');
            } else {
                $('.direction-arrows').removeClass('icon-arrow-down');
                $('.direction-arrows').removeClass('icon-arrow-up');
                $('.direction-arrows').addClass('icon-arrow-down');
                $('.collapse-content').slideUp('fast');
            }
        });
        var e = document.getElementsByClassName('collapse-cmd');
        e.item(0).click();
    });
    function modalRequest(url) {
        //alert(url);
        $("#uploan_modal").html("<div class='modal-dialog'><div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button><h4 class='modal-title ' id='myModalLabel'><div class='text-center'> LOADING <i class='fa fa-spin fa-spinner '></i></div> </h4></div><div class='modal-body'><div class=''> <br><br><br><br> </div></div></div></div>");
        $.post(url, {
            url: url,
            requestView: "modal",
        }, function (response) {
            //alert(response);
            $("#uploan_modal").html(response);
        });
    }

    function ajaxFileRequest(element) {
        var url = $(element).attr("href");
        var contentTarget = $(element).data("target");
        $("#" + contentTarget).html("<i class='fa fa-spin fa-spinner'></i> Loading");
        $.post(url, {
            requestView: "modal"
        }, function (response) {
            //$("#" + target_id).html("<i class='fa fa-spin fa-spinner'></i> Loading");
            $("#" + contentTarget).html(response);
        });
    }

    function ajaxFileRequest_2(url, target) {
        $("#" + target).html("<i class='fa fa-spin fa-spinner'></i> Loading");
        $.post(url, {
            requestView: "modal"
        }, function (response) {
            //$("#" + target_id).html("<i class='fa fa-spin fa-spinner'></i> Loading");
            $("#" + target).html(response);
        });
    }

    function ajaxFormPost(formId) {
        var url = ($("#" + formId).attr("action"));
        $.post(url, $("#" + formId).serialize(), function (response) {
            //alert(response);
        });
    }

    function commentsPost(formId) {
        var url = ($("#" + formId).attr("action"));
        $.post(url, $("#" + formId).serialize(), function (response) {
            var content_id = formId.replace("form", "comments");
            document.getElementById(formId).reset();
            $("#" + content_id).html(response + $("#" + content_id).html());
        });
    }
    function commentsPost2(formId) {
//        document.getElementById('txt-issue-comment').value = editor.getData();
        var url = ($("#" + formId).attr("action"));
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {"parent": parent, "module": module, "table_name": table_name, "record_id": record_id, "comment": comment},
            success: function (data) {
                alert("Success");
                var content_id = formId.replace("form", "comments");
                document.getElementById(formId).reset();
                $("#" + content_id).html(response + $("#" + content_id).html());
            },
            error: function (data) {
                alert("Error");
            }
        });
    }

    function reloadPage() {
        location.reload();
    }

    function ajaxFileModal(url) {
        $("#uploan_modal").html("<div class='modal-dialog'><div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button><h4 class='modal-title ' id='myModalLabel'><div class='text-center'> LOADING <i class='fa fa-spin fa-spinner '></i></div> </h4></div><div class='modal-body'><div class=''> <br><br><br><br> </div></div></div></div>");
        $.post(url, {
            requestView: "modal"
        }, function (response) {
            $("#uploan_modal").html(response);
        });
    }

    function notificationRequest(url) {

    }

    function deleteRecord(url, table_name, record_id) {
        var id_name = "#" + table_name + "_" + record_id;
        var class_name = "." + table_name + "_" + record_id;
        $.post(url, {data: "data"}, function () {
            $(id_name).hide(0);
            $(class_name).hide(0);
        });
    }

    function uploadFiles(inputId, outputId) {
        var inp = document.getElementById(inputId);
        var string = '';
        var name;
        var size;
        for (var i = 0; i < inp.files.length; i++) {
            name = inp.files.item(i).name;
            size = (inp.files.item(i).size / (1024 * 1024)).toFixed(2);
            if (size > 10) {
                alert("File is too large. Only 10MB size for one file is allowed");
                return;
            }
            filetype = inp.files.item(i).type;
            string +=
                    "<tr>" +
                    "<td>" + name + "</td>" +
                    "<td>" + size + " MB</td>" +
                    "</tr>";
        }
        var html = string;
        document.getElementById(outputId).innerHTML = html;
        /*
         CONSIDER IMPLIMENTING THIS
         
         var validatedFiles = [];
         $("#fileToUpload").on("change", function (event) {
         var files = event.originalEvent.target.files;
         files.forEach(function (file) {
         if (file.name.matches(/something.txt/)) {
         validatedFiles.push(file); // Simplest case
         } else { 
         
         }
         });
         });
         */
    }


    function readURL(input, image) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {

                $('#' + image).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
<!-- sample modal content -->
<div id="uploan_modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<!-- /.modal -->
<div class="" id="modal_loading">
    <!-- /.modal-dialog -->
</div>

</body>
</html>


