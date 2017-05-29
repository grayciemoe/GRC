<div class="container">
    <div class="card-box">
        <div class="card-block">
            <div class="row">
                <?= form_open("Account/sqlPost", array("onsubmit" => "sqlPost();return false", "id" => "sqlPost")); ?>
                <div class="col-sm-11"><input type="text" name="sql" class="form-control"/></div>
                <div class="col-sm-1"><button type="submit" class="btn btn-secondary">Save</button></div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <div class="card-box">
        <div class="card-block" id="results"></div>
    </div>

</div>
<script>
    function sqlPost() {
        //alert($("#sqlPost").attr("action"));
        $("#results").html("Loading");
        $.post($("#sqlPost").attr("action"), $("#sqlPost").serialize(), function (response) {
            $("#results").html(response);
        });


    }

</script>