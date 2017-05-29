$("#example-12").click(function () {

    placeholder.unbind();

    $("#title").text("Interactivity");
    $("#description").text("The pie can be made interactive with hover and click events.");

    $.plot(placeholder, data, {
        series: {
            pie: {
                show: true
            }
        },
        grid: {
            hoverable: true,
            clickable: true
        }
    });

    setCode([
        "$.plot('#placeholder', data, {",
        "    series: {",
        "        pie: {",
        "            show: true",
        "        }",
        "    },",
        "    grid: {",
        "        hoverable: true,",
        "        clickable: true",
        "    }",
        "});"
    ]);

    placeholder.bind("plothover", function (event, pos, obj) {

        if (!obj) {
            return;
        }

        var percent = parseFloat(obj.series.percent).toFixed(2);
        $("#hover").html("<span style='font-weight:bold; color:" + obj.series.color + "'>" + obj.series.label + " (" + percent + "%)</span>");
    });

    placeholder.bind("plotclick", function (event, pos, obj) {

        if (!obj) {
            return;
        }

        percent = parseFloat(obj.series.percent).toFixed(2);
        alert("" + obj.series.label + ": " + percent + "%");
    });
});
