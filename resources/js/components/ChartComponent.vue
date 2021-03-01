<template>
    <div>
        <CommandesComponent></CommandesComponent>
        <h1 class="cu">Statistique <i class="fas fa-chart-bar mr-1"></i></h1>
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area mr-1"></i>
                        chiffre d'affaire dans chaque mois
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" width="100%" height="40"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Quantité vendu dans ce mois
                    </div>
                    <div class="card-body">
                        <canvas id="myChart2" width="100%" height="40"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            label: [],
            data: [],
            data2: [],
            label2: [],
            data3: [],
            url: "/admin/public/api/test"
        };
    },
    mounted() {
        axios.get(this.url, {}).then(response => {
            console.log(response);
            if (response.data != "f") {
                var cm = [];
                response.data.forEach((element, index) => {
                    this.label[index] = element.month;
                    this.data[index] = element.data;
                    this.data2[index] = element.c;
                });

                this.chart1();
            } else {
            }
        });

        axios.get(this.url + "2", {}).then(response => {
            console.log(response);
            if (response.data != "f") {
                var cm = [];
                response.data.forEach((element, index) => {
                    this.label2[index] = element.produit_id;
                    this.data3[index] = element.c;
                });

                this.chart2();
            } else {
            }
        });
    },
    methods: {
        chart1() {
            var ctx = document.getElementById("myChart").getContext("2d");
            var myChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: this.label,
                    datasets: [
                        {
                            label: "chiffre d'affaire en DT",
                            data: this.data,
                            stack: "Stack -0",
                            backgroundColor: ["#E9C46A"],

                            borderWidth: 1
                        },
                        {
                            label: "Totale des Commandes",
                            data: this.data2,
                            stack: "Stack 0",
                            backgroundColor: ["#2A9D8F", "#E9C46A"],

                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    legend: {
                        position: "top"
                    },
                    title: {
                        display: false,
                        text: "chiffre d'affaire dans chaque mois "
                    },
                    scales: {
                        xAxes: [
                            {
                                stacked: true
                            }
                        ],
                        yAxes: [
                            {
                                stacked: true
                            }
                        ]
                    },
                    tooltips: {
                        mode: "index",
                        intersect: false
                    }
                }
            });
        },
        chart2() {
            var ctx = document.getElementById("myChart2").getContext("2d");
            var myChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: this.label2,
                    datasets: [
                        {
                            label: "Quantité vendu",
                            data: this.data3,

                            backgroundColor: [
                                "#28a745",
                                "#007bff",
                                "#ffc107",
                                "#dc3545",
                                "#3A0CA3"
                            ],

                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    legend: {
                        position: "top"
                    },
                    title: {
                        display: false,
                        text: "Quantité vendu dans ce mois"
                    },
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true
                                }
                            }
                        ]
                    }
                }
            });
        }
    }
};
</script>

<style scoped>
h1.cu {
    margin: 35px 20px;
}
canvas {
    min-height: 200px;
}
</style>
