<template>

    <!-- breadcrumb -->
    <Breadcrumb :title="___(`Services`)"
                :links="[ { label: ___(`Home`), href: 'home' }, { label: ___(`Services`), href: 'services' } ]"></Breadcrumb>

    <section class="w-full py-3 sm:py-16 block">
        <div class="mx-auto max-w-[1200px] w-full px-5 sm:px-10">

            <div class="w-full flex justify-start items-start flex-wrap">
                <template v-for="(each, index) in listData" :key="each.id" v-if="listData.length > 0 && !loading">
                    <div :class="getWidthClass(index)" class="p-1">
                        <router-link :to="{name:'serviceDetails',params:{id:each.id},state:each}"
                                     class="block w-full decoration-0 text-black relative">
                            <img :src="each.image"
                                 class="w-full h-full min-h-[250px] max-h-[250px] rounded-xl object-cover bg-cover cursor-pointer"
                                 :alt="each.title"/>
                            <div
                                class="absolute inset-0 bg-black/25 font-bold backdrop-blur-none hover:backdrop-blur-md duration-500 p-7 flex justify-start items-end rounded-xl text-white">
                                <div>
                                    <div class="text-[19px] mb-1">
                                        {{ each.title }}
                                    </div>
                                    <div class="text-[14px]">
                                        {{ each.tags }}
                                    </div>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </template>
            </div>

            <template v-if="listData.length === 0 && !loading">
                <!-- empty screen -->
                <div
                    class="w-full font-semibold flex justify-center items-center flex-col rounded-lg text-[21px] bg-gray-100 min-h-[calc(100vh-305px)] h-[calc(100vh-305px)] max-h-[calc(100vh-305px)]">
                    <div class="mb-5">
                        <svg viewBox="0 0 24 24" class="size-[65px]" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M22 19H14M2 19H10" stroke="#000000" stroke-width="2"
                                      stroke-linecap="round"></path>
                                <path d="M12 17V14" stroke="#000000" stroke-width="2" stroke-linecap="round"></path>
                                <circle cx="12" cy="19" r="2" stroke="#000000" stroke-width="2"></circle>
                                <path
                                    d="M14 14H5C3.34315 14 2 12.6569 2 11C2 9.34315 3.34315 8 5 8H19C20.6569 8 22 9.34315 22 11C22 12.6569 20.6569 14 19 14H18"
                                    stroke="#000000" stroke-width="2" stroke-linecap="round"></path>
                                <path
                                    d="M12 2H19C20.6569 2 22 3.34315 22 5C22 6.65685 20.6569 8 19 8H5C3.34315 8 2 6.65685 2 5C2 3.34315 3.34315 2 5 2H8"
                                    stroke="#000000" stroke-width="2" stroke-linecap="round"></path>
                                <path d="M13 5L19 5" stroke="#000000" stroke-width="2" stroke-linecap="round"></path>
                                <path d="M13 11L19 11" stroke="#000000" stroke-width="2" stroke-linecap="round"></path>
                                <circle cx="6" cy="5" r="1" fill="#000000"></circle>
                                <circle cx="6" cy="11" r="1" fill="#000000"></circle>
                            </g>
                        </svg>
                    </div>
                    <div class="text-[17px]">
                        {{ ___(`Currently there have no service.`) }}
                    </div>
                </div>
            </template>

            <!-- loading -->
            <section class="w-full h-[650px] min-h-[650px] object-cover bg-cover flex justify-center items-center"
                     v-if="loading">
                <span class="screen-loader"></span>
            </section>

        </div>

    </section>

</template>

<script>

import axios from "axios";
import Breadcrumb from "../../../../components/breadcrumb.vue";
import apiRoutes from "../../../../services/apiRoutes.js";
import apiServices from "../../../../services/apiServices.js";
import Preloader from "../../../../components/preloader.vue";
import EmptyScreen from "../../../../components/empty-screen.vue";
import cookiesServices from "../../../../services/cookiesServices.js";

export default {
    components: {
        Breadcrumb, Preloader, EmptyScreen
    },
    data() {
        return {
            lang: 'en',
            listData: [],
            loading: false,
        }
    },
    mounted() {
        this.trackVisit('Service');
        this.lang = cookiesServices.get('lang') || "en";
        this.serviceApi();
    },
    methods: {
        async trackVisit(page) {
            try {
                this.loading = true;
                await axios.post(apiRoutes.visitPage + '/store', {page}, {headers: apiServices.authHeaderContent});
            } catch (error) {
                console.log(error)
            } finally {
                this.loading = false;
            }
        },
        getWidthClass(index) {
            const widths = ['w-full sm:w-1/2 lg:w-3/4', 'w-full sm:w-1/2 lg:w-1/4', 'w-full sm:w-1/2 lg:w-2/4', 'w-full sm:w-1/2 lg:w-1/4', 'w-full sm:w-1/2 lg:w-1/4', 'w-full sm:w-1/2 lg:w-1/4', 'w-full sm:w-1/2 lg:w-3/4', 'w-full sm:w-1/2 lg:w-2/4', 'w-full sm:w-1/2 lg:w-1/4', 'w-full sm:w-1/2 lg:w-1/4']
            return widths[index % widths.length]
        },
        async serviceApi() {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.service, {headers: apiServices.authHeaderContent});
                this.listData = response?.data?.data
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
    }
}

</script>
