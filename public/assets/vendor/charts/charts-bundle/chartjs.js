(function(window, document, $, undefined) {
        "use strict";
        $(function() {

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
                        labels: ["Ship1", "Ship2", "Ship3", "Ship4", "Ship5"],
                        datasets: [{
                            label: 'Relevant PO',
                            data: [12, 19, 3, 17, 28],
                            backgroundColor: "rgba(255, 64, 123,0.5)",
                            borderColor: "rgba(255, 64, 123,0.5)",
                            borderWidth: 2
                        }, {
                            label: 'NON Relevant PO',
                            data: [30, 29, 5, 5, 20],
                           backgroundColor: "#B5DFB2",
                            borderColor: "#B5DFB2",
                            borderWidth: 2
                        },{
                            label: 'MD & SDOC',
                            data: [2, 5, 4, 3, 20,5],
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

            if ($('#chartjs_bar_ship').length) {
                var ctx = document.getElementById("chartjs_bar_ship").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Jan-24","Feb-24",'Mar-24','Apr-24','May-24','Jun-24','Jul-24','Aug-24','Sep-24','Oct-24'],
                        datasets: [{
                            label: 'Relevant PO',
                            data: [5,8,11,14,17,20,23,26,29,32,35,38], // Updated data to fit the axis
                            backgroundColor: "rgba(255, 64, 123,0.5)",
                            borderColor: "rgba(255, 64, 123,0.5)",
                            borderWidth: 2
                        }, {
                            label: 'NON Relevant PO',
                            data: [6,9,12,15,18,21,24,27,30,33,36], // Updated data to fit the axis
                            backgroundColor: "#B5DFB2",
                            borderColor: "#B5DFB2",
                            borderWidth: 2
                        }, {
                            label: 'MD & SDOC',
                            data: [7,10,13,16,19,22,25,28,31,34,37], // Updated data to fit the axis
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
            
            
            if ($('#chartjs_bar_ihm_summery').length) {
                var ctx = document.getElementById("chartjs_bar_ihm_summery").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Asb","PCB",'ODS','Otin','Cyb','PFOS','Cd','Cr','Pb','Hg','PBB','PBDE','PCN','Radio','SCCP','HBCDD'],
                        datasets: [{
                            label: 'Content',
                            data: [5,8,11,14,17,20,23,26,29,32,35,38,25,18,3,13], // Updated data to fit the axis
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