<template>

    <section class="w-full px-3 sm:px-10">

        <!-- Title -->
        <div class="text-[25px]"> {{ ___('Dashboard') }} </div>

        <!-- Breadcrumb -->
        <ul class="w-full flex justify-start items-center">
            <li class="mb-0">
                <a href="javascript:void(0)" class="decoration-0 text-black ps-0 p-2 inline-block">
                    {{___(`Pages`)}}
                </a>
            </li>
            <li class="-mb-[5px] pb-0">
                <div class="inline-block opacity-75">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-[15px]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            </li>
            <li class="mb-0">
                <router-link :to="{name:'dashboard'}" class="decoration-0 text-[#21306b] duration-500 hover:text-[#3B497E] p-2 inline-block">
                    {{___(`Dashboard`)}}
                </router-link>
            </li>
        </ul>

        <section class="w-full bg-white p-3 shadow-sm rounded-[0.625rem_0.625rem_0_0] h-[calc(100vh-220px)]">

            <div class="w-full overflow-y-auto h-[calc(100vh-250px)] pe-2">
                <div class="w-full grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-2">

                    <!-- Task - to do list -->
                    <div class="w-full p-1">
                        <ToDoTask/>
                    </div>

                    <!-- Donut chart -->
                    <div class="w-full p-1">
                        <DonutChart/>
                    </div>

                    <!-- Social Media traffic -->
                    <div class="w-full p-1">
                        <SocialMediaTraffic/>
                    </div>

                    <!-- Total Customers, total revenue, orders, returns -->
                    <div class="w-full p-1">
                        <TotalCount/>
                    </div>

                    <!-- Bar chart -->
                    <div class="w-full p-1 md:col-span-2">
                        <BarChart/>
                    </div>

                </div>
            </div>

        </section>

    </section>

</template>

<script>

import ToDoTask from "./widget/toDoTask.vue";
import BarChart from "./widget/barChart.vue";
import DonutChart from "./widget/donutChart.vue";
import SocialMediaTraffic from "./widget/socialMediaTraffic.vue";
import TotalCount from "./widget/totalCount.vue";

export default {
    components: {
        ToDoTask, BarChart, DonutChart, SocialMediaTraffic, TotalCount
    },
    data() {
        return {}
    },
    mounted() {

    },
    methods: {}
}

</script>
