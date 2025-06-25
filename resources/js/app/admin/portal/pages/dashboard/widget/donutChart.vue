<template>
    <div class="w-full block text-center text-[#333] p-[10px] mb-[30px] font-bold">
        {{___(`Website Page Visited`)}}
    </div>
    <div class="flex justify-center">
        <div class="size-[250px]">
            <canvas ref="doughnutCanvas" class="w-full h-auto"></canvas>
        </div>
    </div>
</template>

<script>

import axios from "axios";
import apiRoutes from "../../../../../services/apiRoutes.js";
import apiServices from "../../../../../services/apiServices.js";

import {Chart, DoughnutController, ArcElement, Tooltip, Legend, Title} from 'chart.js';
Chart.register(DoughnutController, ArcElement, Tooltip, Legend, Title)

export default {
    data() {
        return {
            chart: null,
            pageData: [],
        }
    },
    mounted() {
        this.listApi();
        this.renderChart();
    },
    methods: {
        async listApi() {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.visitPage, {headers: apiServices.authHeaderContent});
                this.pageData = response.data;
                this.renderChart();
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        renderChart() {
            const ctx = this.$refs.doughnutCanvas;
            if (this.chart) {
                this.chart.destroy();
            }
            const allPages = ['Home', 'About', 'Contact', 'Blog', 'Product', 'Service'];
            const pageCountMap = {};
            this.pageData.forEach(item => {
                pageCountMap[item.page] = item.count;
            });

            const dataValues = allPages.map(page => pageCountMap[page] || 0);
            const total = dataValues.reduce((sum, val) => sum + val, 0);

            this.chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: allPages,
                    datasets: [
                        {
                            data: dataValues,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(27,120,120,0.6)',
                                'rgba(104, 192, 75, 0.6)',
                                'rgba(171, 75, 192, 0.6)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(27,120,120, 1)',
                                'rgba(104, 192, 75, 1)',
                                'rgba(171, 75, 192, 1)',
                            ],
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: (context) => {
                                    const value = context.parsed;
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${percentage}%`;
                                }
                            }
                        }
                    }
                }
            });
        },
    }
}
</script>
