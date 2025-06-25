<template>
    <div>
        <div class="flex justify-between items-center mb-[30px]">
            <div class="w-full text-[#333] p-[10px] font-bold">
                {{___(`Revenue Growth`)}}
            </div>
            <div class="relative">
                <select v-model="selectedPeriod" @change="updateChart"
                        class="min-w-[120px] max-w-[120px] w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px] appearance-none">
                    <option value="weekly">{{___(`Weekly`)}}</option>
                    <option value="monthly">{{___(`Monthly`)}}</option>
                    <option value="yearly">{{___(`Yearly`)}}</option>
                </select>
                <div class="absolute top-0 bottom-0 end-0 pe-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                         stroke="currentColor" class="size-[15px]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                    </svg>
                </div>
            </div>
        </div>

        <canvas ref="barCanvas" class="w-full max-h-[350px] min-h-[350px]"></canvas>
    </div>
</template>

<script>
import axios from "axios";
import apiRoutes from "../../../../../services/apiRoutes.js";
import apiServices from "../../../../../services/apiServices.js";

import {
    Chart,
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Title,
    Tooltip,
    Legend
} from 'chart.js';

Chart.register(BarController, BarElement, CategoryScale, LinearScale, Title, Tooltip, Legend);

export default {
    data() {
        return {
            chart: null,
            selectedPeriod: 'weekly',
            revenueData: {},
        };
    },

    mounted() {
        this.updateChart();
    },

    methods: {
        generateColors(count) {
            const baseColors = [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(100, 200, 150, 0.5)',
            ];
            const backgroundColors = Array.from({length: count}, (_, i) => baseColors[i % baseColors.length]);
            const borderColors = backgroundColors.map(bg => bg.replace('0.5', '1'));
            return {backgroundColors, borderColors};
        },

        renderChart() {
            const canvas = this.$refs.barCanvas;
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            if (!ctx) return;

            const {labels, values} = this.revenueData[this.selectedPeriod] || {labels: [], values: []};
            const total = values.reduce((sum, val) => sum + val, 0);
            const {backgroundColors, borderColors} = this.generateColors(values.length);

            if (this.chart) this.chart.destroy();

            this.chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        data: values,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1,
                    }],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {display: false},
                        tooltip: {
                            callbacks: {
                                label: context => {
                                    const value = context.parsed.y;
                                    const percentage = total ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${value} (${percentage}%)`;
                                },
                            },
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        },

        async updateChart() {
            try {
                const response = await axios.get(`${apiRoutes.revenueGrowth}?period=${this.selectedPeriod}`, {
                    headers: apiServices.authHeaderContent
                });
                this.revenueData[this.selectedPeriod] = {
                    labels: response.data.labels,
                    values: response.data.values
                };
                this.renderChart();
            } catch (error) {
                console.error("Error loading revenue data:", error);
            }
        },
    },
};
</script>
