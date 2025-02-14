(function (window, document, $, undefined) {
    "use strict";
    $(function () {

        if ($('#chartjs_line').length) {
            var ctx = document.getElementById('chartjs_line').getContext('2d');

            var myChart = new Chart(ctx, {
                type: 'line',

                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Almonds',
                        data: [12, 19, 3, 17, 6, 3, 7],

                        backgroundColor: "rgba(89, 105, 255,0.5)",
                        borderColor: "rgba(89, 105, 255,0.7)",
                        borderWidth: 2
                    }, {
                        label: 'Cashew',
                        data: [2, 29, 5, 5, 2, 3, 10],
                        backgroundColor: "rgba(255, 64, 123,0.5)",
                        borderColor: "rgba(255, 64, 123,0.7)",
                        borderWidth: 2
                    }]

                },
                options: {
                    legend: {
                        display: true,
                        position: 'bottom',

                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14,
                        }
                    },

                    scales: {
                        xAxes: [{
                            ticks: {
                                fontSize: 14,
                                fontFamily: 'Circular Std Book',
                                fontColor: '#71748d',
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                fontSize: 14,
                                fontFamily: 'Circular Std Book',
                                fontColor: '#71748d',
                            }
                        }]
                    }
                }



            });
        }


        if ($('#chartjs_bar').length) {
            var ctx = document.getElementById("chartjs_bar").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: shipsPo,
                    datasets: [{
                        label: 'Relevant PO',
                        data: relevantCounts,
                        backgroundColor: "rgba(255, 64, 123,0.5)",
                        borderColor: "rgba(255, 64, 123,0.5)",
                        borderWidth: 2
                    }, {
                        label: 'NON Relevant PO',
                        data: nonRelevantCounts,
                        backgroundColor: "#B5DFB2",
                        borderColor: "#B5DFB2",
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{

                        }]
                    },
                    legend: {
                        display: true,
                        position: 'bottom',

                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14,
                        }
                    },

                    scales: {
                        xAxes: [{
                            ticks: {
                                fontSize: 14,
                                fontFamily: 'Circular Std Book',
                                fontColor: '#71748d',
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                fontSize: 14,
                                fontFamily: 'Circular Std Book',
                                fontColor: '#71748d',
                            }
                        }]
                    }
                }


            });
        }
        if ($('#po_summery_graph').length) {
            var ctx = document.getElementById("po_summery_graph").getContext('2d');
            myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: poSummeryGraph.labels,
                    datasets: [{
                        label: 'Relevant PO',
                        data: poSummeryGraph.monthrelevantCounts, // Updated data to fit the axis
                        backgroundColor: "rgba(255, 64, 123,0.5)",
                        borderColor: "rgba(255, 64, 123,0.5)",
                        borderWidth: 2
                    }, {
                        label: 'NON Relevant PO',
                        data: poSummeryGraph.monthnonRelevantCounts, // Updated data to fit the axis
                        backgroundColor: "#B5DFB2",
                        borderColor: "#B5DFB2",
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,   // Start the Y-axis from 0
                                stepSize: 5,         // Control the step size
                                min: 0,              // Minimum value of Y-axis
                                max: 40,             // Maximum value of Y-axis
                                fontSize: 14,
                                fontFamily: 'Circular Std Book',
                                fontColor: '#71748d'
                            },
                            gridLines: {            // Customize grid lines
                                color: "#e0e0e0"
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                fontSize: 14,
                                fontFamily: 'Circular Std Book',
                                fontColor: '#71748d'
                            }
                        }]
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14
                        }
                    }
                }
            });
        }
        var my_chartchartjs_bar_ship; // Define chart variable globally
        
        if ($('#chartjs_bar_ship').length) {
            var ctx = document.getElementById("chartjs_bar_ship").getContext('2d');

            my_chartchartjs_bar_ship = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: anyliticsdata.labels,
                    datasets: [{
                        label: 'Relevant PO',
                        data: anyliticsdata.monthrelevantCounts, // Updated data to fit the axis
                        backgroundColor: "rgba(255, 64, 123,0.5)",
                        borderColor: "rgba(255, 64, 123,0.5)",
                        borderWidth: 2
                    }, {
                        label: 'NON Relevant PO',
                        data: anyliticsdata.monthnonRelevantCounts, 
                        backgroundColor: "#B5DFB2",
                        borderColor: "#B5DFB2",
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,   // Start the Y-axis from 0
                                stepSize: 5,         // Control the step size
                                min: 0,              // Minimum value of Y-axis
                                max: 40,             // Maximum value of Y-axis
                                fontSize: 14,
                                fontFamily: 'Circular Std Book',
                                fontColor: '#71748d'
                            },
                            gridLines: {            // Customize grid lines
                                color: "#e0e0e0"
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                fontSize: 14,
                                fontFamily: 'Circular Std Book',
                                fontColor: '#71748d'
                            }
                        }]
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14
                        }
                    }
                }
            });
        }
        var my_chart_chartjs_bar_md;
        if ($('#chartjs_bar_md').length) {
            var ctx = document.getElementById("chartjs_bar_md").getContext('2d');

            my_chart_chartjs_bar_md = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: anyliticsdata.labels,
                    datasets: [{
                        label: 'MD & SDOC',
                        data: anyliticsdata.mdSdRecoreds, // Updated data to fit the axis
                        backgroundColor: "rgba(255, 64, 123,0.5)",
                        borderColor: "rgba(255, 64, 123,0.5)",
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,   // Start the Y-axis from 0
                                stepSize: 5,         // Control the step size
                                min: 0,              // Minimum value of Y-axis
                                max: 40,             // Maximum value of Y-axis
                                fontSize: 14,
                                fontFamily: 'Circular Std Book',
                                fontColor: '#71748d'
                            },
                            gridLines: {            // Customize grid lines
                                color: "#e0e0e0"
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                fontSize: 14,
                                fontFamily: 'Circular Std Book',
                                fontColor: '#71748d'
                            }
                        }]
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14
                        }
                    }
                }
            });
        }
        var   my_chart_training_md ;
        if ($('#c3chart_donut').length) {
            my_chart_training_md = c3.generate({
                bindto: "#c3chart_donut",
                data: {
                    columns:anyliticsdata.trainingverview,
                    type: 'donut',
                    onclick: function(d, i) { console.log("onclick", d, i); },
                    onmouseover: function(d, i) { console.log("onmouseover", d, i); },
                    onmouseout: function(d, i) { console.log("onmouseout", d, i); },

                    colors: {
                        Jan: '#4A90E2',   // A refined blue for better aesthetics
                        Feb: '#ff407b',   // Vibrant pink
                        Mar: '#25d5f2',   // Bright cyan
                        Apr: '#ffc750',   // Warm yellow-orange
                        May: '#d45087',   // Deep magenta
                        Jun: '#f95d6a',   // Reddish-orange
                        Jul: '#ff7c43',   // Soft orange
                        Aug: '#ffa600',   // Golden yellow
                        Sep: '#ff8c00',   // Orange-red (better contrast)
                        Oct: '#0bb4ff',   // Sky blue
                        Nov: '#ffb55a',   // Light orange
                        Dec: '#8bd3c7'    // Soft teal
                    }
                    
                },
              
                donut: {
                    title: "Training Records",
                    label: {
                        format: function(value, ratio, id) {
                            return value; // Show only value, no percentage
                        },
                        show: true // Ensure labels are displayed
                    }

                }


            });

            
          
        }
        var my_chart_brifing_md;
        if ($('#c3chart_donut_brifing').length) {
            my_chart_brifing_md = c3.generate({
                bindto: "#c3chart_donut_brifing",
                data: {
                    columns: anyliticsdata.brifingoverview,
                    type: 'donut',
                    onclick: function(d, i) { console.log("onclick", d, i); },
                    onmouseover: function(d, i) { console.log("onmouseover", d, i); },
                    onmouseout: function(d, i) { console.log("onmouseout", d, i); },
                    colors: {
                        Jan: '#4A90E2', Feb: '#ff407b', Mar: '#25d5f2',
                        Apr: '#ffc750', May: '#d45087', Jun: '#f95d6a',
                        Jul: '#ff7c43', Aug: '#ffa600', Sep: '#ff8c00',
                        Oct: '#0bb4ff', Nov: '#ffb55a', Dec: '#8bd3c7'
                    }
                },
                donut: {
                    title: "Brifing Records",
                    label: {
                        format: function(value) { return value; },
                        show: true
                    }
                }
            });
        }
        function updateChartData(newLabels, relevantData, nonRelevantData,updatedmdSdData,brifingoverview,trainingverview) {
            if (my_chartchartjs_bar_ship) {
                console.log("ddddd");
                my_chartchartjs_bar_ship.data.labels = newLabels; // Update labels
                my_chartchartjs_bar_ship.data.datasets[0].data = relevantData; // Update Relevant PO data
                my_chartchartjs_bar_ship.data.datasets[1].data = nonRelevantData; // Update NON Relevant PO data
                my_chartchartjs_bar_ship.update(); // Refresh chart
            }
            if (my_chart_chartjs_bar_md) {
                my_chart_chartjs_bar_md.data.labels = newLabels; // Update labels
                my_chart_chartjs_bar_md.data.datasets[0].data = updatedmdSdData; // Update Relevant PO data
                my_chart_chartjs_bar_md.update(); // Refresh chart
            }
            if(my_chart_brifing_md){
                console.log(brifingoverview);
                my_chart_brifing_md.load({
                    columns: brifingoverview,
                    unload:true,
                });
            }
            if(my_chart_training_md){
                my_chart_training_md.load({
                    columns: trainingverview,
                    unload:true,
                });
            }
            
        }
        const firstShipId = $('.shipswisePo option:selected').val();
       
        if (firstShipId && firstShipId !== "Select Ship") {
            getshipwisepo(ship_id);
        }
        // $('.shipswisePo').change(function (e) {
        //     var id = $(this).val();
        //     getshipwisepo(id);

        // });
        $('#datetimepicker11').on("change.datetimepicker", function (e) {
            let selectedDate = e.date ? e.date.format('YYYY') : ''; // Get the selected date
            getshipwisepo(ship_id,selectedDate);
        });

        function getshipwisepo(id,selectedDate=null) {
            $.ajax({
                url: `${baseUrl}/shipwisepo/${id}/${selectedDate}`,
                method: 'Get',

                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    var updatedLabels = response.labels;
                    var updatedRelevantData = response.monthrelevantCounts;
                    var updatedNonRelevantData = response.monthnonRelevantCounts;
                    var updatedmdSdData = response.mdSdRecoreds;
                    var brifingoverview = response.brifingoverview;
                    var trainingverview = response.trainingverview;
                    updateChartData(updatedLabels, updatedRelevantData, updatedNonRelevantData,updatedmdSdData,brifingoverview,trainingverview);


                }

            });
        }
        if ($('#chartjs_bar_ihm_summery').length) {
            var ctx = document.getElementById("chartjs_bar_ihm_summery").getContext('2d');
            const maxQty = Math.max(...hazmatSummeryName.map(hazmat => hazmat.qty_sum || 0));
            const stepSize = Math.ceil(maxQty / 10);  // Example: Divide the max value by 5, and round up to the nearest integer

            const datasets = hazmatSummeryName.map(hazmat => ({
                label: hazmat.short_name,
                data: [hazmat.qty_sum || 0], // Use qty or 0 if it's undefined
                backgroundColor: hazmat.color,
                borderColor: hazmat.color,
                borderWidth: 2
            }));
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['hazmats'],
                    datasets: datasets 
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,   // Start the Y-axis from 0
                                stepSize: stepSize,         // Control the step size
                                min: 0,              // Minimum value of Y-axis
                                max: maxQty, // Set max value to the maxQty + step size buffer
                                fontSize: 14,
                                fontFamily: 'Circular Std Book',
                                fontColor: '#71748d'
                            },
                            gridLines: {            // Customize grid lines
                                color: "#e0e0e0"
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                fontSize: 14,
                                fontFamily: 'Circular Std Book',
                                fontColor: '#71748d'
                            }
                        }]
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14
                        }
                    }
                }
            });
        }

        if ($('#chartjs_radar').length) {
            var ctx = document.getElementById("chartjs_radar");
            var myChart = new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: ["M", "T", "W", "T", "F", "S", "S"],
                    datasets: [{
                        label: 'Almonds',
                        backgroundColor: "rgba(89, 105, 255,0.5)",
                        borderColor: "rgba(89, 105, 255,0.7)",
                        data: [12, 19, 3, 17, 28, 24, 7],
                        borderWidth: 2
                    }, {
                        label: 'Cashew',
                        backgroundColor: "rgba(255, 64, 123,0.5)",
                        borderColor: "rgba(255, 64, 123,0.7)",
                        data: [30, 29, 5, 5, 20, 3, 10],
                        borderWidth: 2
                    }]
                },
                options: {

                    legend: {
                        display: true,
                        position: 'bottom',

                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14,
                        }
                    },


                }

            });
        }


        if ($('#chartjs_polar').length) {
            var ctx = document.getElementById("chartjs_polar").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'polarArea',
                data: {
                    labels: ["M", "T", "W", "T", "F", "S", "S"],
                    datasets: [{
                        backgroundColor: [
                            "#5969ff",
                            "#ff407b",
                            "#25d5f2",
                            "#ffc750",
                            "#2ec551",
                            "#7040fa",
                            "#ff004e"
                        ],
                        data: [12, 19, 3, 17, 28, 24, 7]
                    }]
                },
                options: {

                    legend: {
                        display: true,
                        position: 'bottom',

                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14,
                        }
                    },


                }
            });
        }
    
      

        if ($('#chartjs_pie').length) {
            var ctx = document.getElementById("chartjs_pie").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ["M", "T", "W", "T", "F", "S", "S"],
                    datasets: [{
                        backgroundColor: [
                            "#5969ff",
                            "#ff407b",
                            "#25d5f2",
                            "#ffc750",
                            "#2ec551",
                            "#7040fa",
                            "#ff004e"
                        ],
                        data: [12, 19, 3, 17, 28, 24, 7]
                    }]
                },
                options: {
                    legend: {
                        display: true,
                        position: 'bottom',

                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14,
                        }
                    },


                }
            });
        }


        if ($('#chartjs_doughnut').length) {
            var ctx = document.getElementById("chartjs_doughnut").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["M", "T", "W", "T", "F", "S", "S"],
                    datasets: [{
                        backgroundColor: [
                            "#5969ff",
                            "#ff407b",
                            "#25d5f2",
                            "#ffc750",
                            "#2ec551",
                            "#7040fa",
                            "#ff004e"
                        ],
                        data: [12, 19, 3, 17, 28, 24, 7]
                    }]
                },
                options: {

                    legend: {
                        display: true,
                        position: 'bottom',

                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14,
                        }
                    },


                }

            });
        }


    });

})(window, document, window.jQuery);