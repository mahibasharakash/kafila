<template>

    <div class="relative">
        <select v-model="period" @change="updateTotal($event)" class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px] appearance-none">
            <option :value="'weekly'">{{___(`Weekly`)}}</option>
            <option :value="'monthly'">{{___(`Monthly`)}}</option>
            <option :value="'yearly'">{{___(`Yearly`)}}</option>
        </select>
        <div class="absolute top-0 bottom-0 end-0 pe-3 flex items-center pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-[15px]">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
            </svg>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-2">

        <template v-if="!loading">

            <!-- Total Customers -->
            <div class="w-full pt-2">
                <div class="border border-gray-200 p-2 w-full font-semibold text-[#333] block sm:flex justify-between rounded-md items-start">
                    <div class="size-[75px] rounded-md inline-flex justify-center items-center bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-[35px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                        </svg>
                    </div>
                    <div class="sm:ms-2 mt-3 sm:mt-0">
                        <div class="block w-full text-start sm:text-end">
                            {{ ___('Total Customers') }}
                        </div>
                        <div class="flex font-medium justify-start sm:justify-end items-center mt-1">
                            <span class="text-lg inline-block" :class=" resources?.customer_growth !== 0 ? 'text-green-800' : 'text-rose-800'">
                                {{ checkAmount(resources?.total_customers) }}
                            </span>
                            <span class="text-lg inline-flex ms-2">
                            <span class="me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="size-[20px] stroke-green-600" v-if="resources?.customer_growth !== 0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="size-[20px] stroke-rose-600" v-else>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181"/>
                                </svg>
                            </span>
                            <span :class="resources?.customer_growth !== 0 ? 'text-green-600' : 'text-red-600'"> {{ resources?.customer_growth }} % </span>
                        </span>
                        </div>
                    </div>
                </div>
            </div>

        </template>

        <template v-if="!loading">

            <!-- Total Revenue -->
            <div class="w-full pt-2">
                <div class="border border-gray-200 p-2 w-full font-semibold text-[#333] block sm:flex justify-between rounded-md items-start">
                    <div class="size-[75px] rounded-md inline-flex justify-center items-center bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-[35px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z"/>
                        </svg>
                    </div>
                    <div class="sm:ms-2 mt-3 sm:mt-0">
                        <div class="block w-full text-start sm:text-end">
                            {{ ___('Total Revenue') }}
                        </div>
                        <div class="flex font-medium justify-start sm:justify-end items-center mt-1">
                            <span class="text-lg inline-block" :class=" resources?.revenue_growth !== 0 ? 'text-green-800' : 'text-rose-800'">
                                {{ checkAmount((parseFloat(resources?.total_revenue || 0)).toFixed(2)) }}
                            </span>
                            <span class="text-lg inline-flex ms-2">
                                <span class="me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                         class="size-[20px] stroke-green-600" v-if="resources?.revenue_growth !== 0">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                         class="size-[20px] stroke-rose-600" v-else>
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181"/>
                                    </svg>
                                </span>
                                <span :class="resources?.revenue_growth !== 0 ? 'text-green-600' : 'text-red-600'"> {{ resources?.revenue_growth }} % </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </template>

        <template v-if="!loading">

            <!-- Total Revenue -->
            <div class="w-full pt-2">
                <div class="border border-gray-200 p-2 w-full font-semibold text-[#333] block sm:flex justify-between rounded-md items-start">
                    <div class="size-[75px] rounded-md inline-flex justify-center items-center bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-[35px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"/>
                        </svg>
                    </div>
                    <div class="sm:ms-2 mt-3 sm:mt-0">
                        <div class="block w-full text-start sm:text-end">
                            {{ ___('Total Orders') }}
                        </div>
                        <div class="flex font-medium justify-start sm:justify-end items-center mt-1">
                            <span class="text-lg inline-block" :class=" resources?.orders_growth !== 0 ? 'text-green-800' : 'text-rose-800'">
                                {{ checkAmount(resources?.total_orders) }}
                            </span>
                            <span class="text-lg inline-flex ms-2">
                                <span class="me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                         class="size-[20px] stroke-green-600" v-if="resources?.orders_growth !== 0">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                         class="size-[20px] stroke-rose-600" v-else>
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181"/>
                                    </svg>
                                </span>
                                <span :class="resources?.orders_growth !== 0 ? 'text-green-600' : 'text-red-600'"> {{ resources?.orders_growth }} % </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </template>

        <template v-if="!loading">

            <!-- Total Revenue -->
            <div class="w-full pt-2">
                <div class="border border-gray-200 p-2 w-full font-semibold text-[#333] block sm:flex justify-between rounded-md items-start">
                    <div class="size-[75px] rounded-md inline-flex justify-center items-center bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-[35px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605"/>
                        </svg>
                    </div>
                    <div class="sm:ms-2 mt-3 sm:mt-0">
                        <div class="block w-full text-start sm:text-end">
                            {{ ___('Total Returns') }}
                        </div>
                        <div class="flex font-medium justify-start sm:justify-end items-center mt-1">
                            <span class="text-lg inline-block" :class=" resources?.returns_growth === 0 ? 'text-green-800' : 'text-rose-800'">
                                {{ checkAmount(resources?.total_returns) }}
                            </span>
                            <span class="text-lg inline-flex ms-2">
                                <span class="me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="size-[20px] stroke-green-600" v-if="resources?.returns_growth === 0">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="size-[20px] stroke-rose-600" v-else>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181"/>
                                    </svg>
                                </span>
                                <span :class="resources?.returns_growth === 0 ? 'text-green-600' : 'text-red-600'"> {{ resources?.returns_growth }} % </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </template>

    </div>

</template>

<script>

import axios from "axios";
import apiRoutes from "../../../../../services/apiRoutes.js";
import apiServices from "../../../../../services/apiServices.js";

export default {
    data() {
        return {
            period: 'monthly',
            resources: null,
            loading: false
        }
    },
    mounted() {
        this.period = 'monthly';
        this.listApi();
    },
    methods: {
        async listApi() {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.totalResource+`?period=${this.period}`, {headers: apiServices.authHeaderContent});
                this.resources = response?.data;
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        updateTotal(event) {
            this.period = event.target.value;
            setTimeout(() => {
                this.listApi();
            })
        },
        checkAmount(amount) {
            if (amount === null || amount === undefined || isNaN(amount)) return '0';
            const absAmount = Math.abs(Number(amount));
            const sign = amount < 0 ? '-' : '';
            if (absAmount >= 1.0e+12) {
                return `${sign}${(absAmount / 1.0e+12).toFixed(1).replace(/\.0$/, '')}T`;
            } else if (absAmount >= 1.0e+9) {
                return `${sign}${(absAmount / 1.0e+9).toFixed(1).replace(/\.0$/, '')}B`;
            } else if (absAmount >= 1.0e+6) {
                return `${sign}${(absAmount / 1.0e+6).toFixed(1).replace(/\.0$/, '')}M`;
            } else if (absAmount >= 1.0e+3) {
                return `${sign}${(absAmount / 1.0e+3).toFixed(1).replace(/\.0$/, '')}K`;
            } else {
                return `${sign}${absAmount}`;
            }
        }
    }
}

</script>
