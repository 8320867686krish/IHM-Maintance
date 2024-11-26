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
                    }, {
                        label: 'MD & SDOC',
                        data: [2, 5, 4, 3, 20, 5],
                        backgroundColor: "rgba(89, 105, 255,0.5)",
                        borderColor: "rgba(89, 105, 255,0.5)",
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
                    }, {
                        label: 'MD & SDOC',
                        data: [7, 10, 13, 16, 19, 22, 25, 28, 31, 34, 37], // Updated data to fit the axis
                        backgroundColor: "rgba(89, 105, 255,0.5)",
                        borderColor: "rgba(89, 105, 255,0.5)",
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
        var myChart; // Define chart variable globally
        
        if ($('#chartjs_bar_ship').length) {
            var ctx = document.getElementById("chartjs_bar_ship").getContext('2d');
            myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Relevant PO',
                        data: [], // Updated data to fit the axis
                        backgroundColor: "rgba(255, 64, 123,0.5)",
                        borderColor: "rgba(255, 64, 123,0.5)",
                        borderWidth: 2
                    }, {
                        label: 'NON Relevant PO',
                        data: [], // Updated data to fit the axis
                        backgroundColor: "#B5DFB2",
                        borderColor: "#B5DFB2",
                        borderWidth: 2
                    }, {
                        label: 'MD & SDOC',
                        data: [7, 10, 13, 16, 19, 22, 25, 28, 31, 34, 37], // Updated data to fit the axis
                        backgroundColor: "rgba(89, 105, 255,0.5)",
                        borderColor: "rgba(89, 105, 255,0.5)",
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
        function updateChartData(newLabels, relevantData, nonRelevantData, mdSDOCData) {
            if (myChart) {
                myChart.data.labels = newLabels; // Update labels
                myChart.data.datasets[0].data = relevantData; // Update Relevant PO data
                myChart.data.datasets[1].data = nonRelevantData; // Update NON Relevant PO data
                myChart.update(); // Refresh chart
            }
        }
        const firstShipId = $('.shipswisePo option:selected').val();
       
        if (firstShipId && firstShipId !== "Select Ship") {
            getshipwisepo(firstShipId);
        }
        $('.shipswisePo').change(function (e) {
            var id = $(this).val();
            getshipwisepo(id);

        });

        function getshipwisepo(id) {
            $.ajax({
                url: `${baseUrl}/shipwisepo/${id}`,
                method: 'Get',

                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    var updatedLabels = response.labels;
                    var updatedRelevantData = response.monthrelevantCounts;
                    var updatedNonRelevantData = response.monthnonRelevantCounts;
                    updateChartData(updatedLabels, updatedRelevantData, updatedNonRelevantData, []);


                }

            });
        }
        if ($('#chartjs_bar_ihm_summery').length) {
            var ctx = document.getElementById("chartjs_bar_ihm_summery").getContext('2d');
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