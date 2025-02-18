(function (window, document, $, undefined) {
    "use strict";
    $(function () {
        $(".chartBtn").on("click",function(e){
            $(".chartBtn").removeClass("active");
            $(this).addClass("active");
            var type = $(this).attr('data-type');
            let selectedDate = $("#allships").val();
            getallships(type,selectedDate);
        });
        $("#allships").on("change", function (e) {
            let selectedDate = $("#allships").val();
            var activeType = $(".chartBtn.active").attr("data-type");
            getallships(activeType, selectedDate);
        });
        function getallships(type, selectedDate = null) {
            $.ajax({
                url: `${baseUrl}/allshipsData/${type}/${selectedDate}`,
                method: 'Get',

                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {

                    if(chart){
                        chart.load({
                            columns: response.columns,
                            colors: response.colors,
                            unload:true,
                        });
                        chart.internal.config.axis_y_min = 0;
                        chart.flush();
                    }

                }

            });
        }

        var chart = "";
        if ($('#c3chart_spline').length) {
            
             chart = c3.generate({
                bindto: "#c3chart_spline",
                data: {
                    x: "x", // Explicitly set x-axis reference
                    columns: chartData.columns,
                    type: 'spline',
                    colors: chartData.colors
                },
                axis: {
                    x: {
                        type: "category", // Force categorical x-axis
                        tick: {
                            multiline: false
                        }
                    },
                    y: {
                       
                        min: 0,
                        padding: { top: 10, bottom: 0 }, // Prevents unwanted negative space
                        tick: {
                            format: function (d) { return d < 0 ? 0 : d; } // Prevents negative tick labels
                        }
                    }
                }
            });
        }











    });

})(window, document, window.jQuery);