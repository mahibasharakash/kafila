<template>

    <!-- breadcrumb -->
    <Breadcrumb :title="___(`About Us`)"
                :links="[ { label: ___(`Home`), href: 'home' }, { label: ___(`About Us`), href: 'about' } ]"></Breadcrumb>

    <!-- welcome to furniture store -->
    <section class="pt-3 sm:pt-16 w-full px-5 sm:px-10" v-if="!loading">

        <!-- about image 1 -->
        <div class="block pb-3 sm:pb-16 w-full mx-auto max-w-[1200px]">
            <img v-if="generalData?.cover_file_path" :src="generalData?.cover_file_path"
                 class="rounded-xl max-h-[450px] min-h-[450px] h-[450px] bg-cover object-cover w-full" alt="about"/>
        </div>

        <div class="pb-3 sm:pb-16 max-w-[900px] mx-auto">

            <!-- about title -->
            <div class="text-[20px] sm:text-[25px] md:text-[35px] text-center mb-5">
                {{ ___(`Welcome Furnimal Store.`) }}
            </div>

            <!-- about description part 1 -->
            <div class="text-[15px] text-gray-600 text-center mb-5">
                {{ generalData?.short_description }}
            </div>

            <!-- about description part 2 -->
            <div class="text-[15px] text-gray-600 text-center mb-5">
                {{ generalData?.long_description }}
            </div>

        </div>

    </section>

    <!-- timeline -->
    <section class="w-full mx-auto max-w-[1200px] mb-16 px-10" v-if="!loading">
        <div class="w-full flex flex-wrap relative">
            <div v-for="(item, index) in generalData?.timelines" v-if="!loading" :key="index" class="w-full">
                <template v-if="index % 2 === 0">
                    <div
                        class="w-full md:w-1/2 py-3 md:py-10 md:px-10 flex justify-end md:border-t-2 md:border-gray-400">
                        <div class="md:max-w-[380px]">
                            <h3 class="text-xl md:text-3xl mb-2 font-bold text-start md:text-end">{{ item?.year }}</h3>
                            <p class="text-md md:text-xl mb-2 text-start font-semibold md:text-end text-[#21306b]">
                                {{ item?.timeline }}</p>
                            <p class="text-sm md:text-md text-start md:text-end text-gray-600">
                                {{ item?.short_description }}</p>
                        </div>
                    </div>
                </template>
                <div class="w-full h-full hidden md:flex absolute top-0 bottom-0 justify-center pointer-events-none">
                    <div class="border h-full border-gray-400"></div>
                </div>
                <template v-if="index % 2 !== 0">
                    <div class="md:flex justify-end">
                        <div class="w-full md:w-1/2 py-3 md:py-10 md:px-10 md:border-t-2 md:border-gray-400">
                            <div class="md:max-w-[380px]">
                                <h3 class="text-xl md:text-3xl mb-2 font-bold text-start">{{ item?.year }}</h3>
                                <p class="text-md md:text-xl mb-2 text-start font-semibold text-[#21306b]">
                                    {{ item.timeline }}</p>
                                <p class="text-sm md:text-md text-start text-gray-600">{{ item?.short_description }}</p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>

    <!-- timeline loading -->
    <section class="w-full h-[650px] min-h-[650px] object-cover bg-cover flex justify-center items-center"
             v-if="loading">
        <span class="screen-loader"></span>
    </section>

    <!-- testimonial -->
    <section class="w-full pb-3 sm:pb-16 block" v-if="testimonialData.length > 0 && !loading">
        <div class="mx-auto w-full max-w-[1200px] px-10">

            <div class="text-center text-[30px] md:text-[55px] mb-3">
                {{ ___(`Testimonial`) }}
            </div>

            <div class="flex justify-center items-center flex-col mb-5">

                <div class="flex justify-center items-center mb-2">
                    <div class="bg-transparent min-w-[60px] h-[5px]"></div>
                    <div
                        class="bg-gray-600 min-w-[120px] h-[5px] relative before:absolute before:content-[''] before:top-0 before:bottom-0 before:end-0 before:z-10 before:w-[60px] before:h-[5px] before:bg-[#21306b]"></div>
                </div>

                <div class="flex justify-center items-center mb-2">
                    <div
                        class="bg-gray-600 min-w-[120px] h-[5px] relative before:absolute before:content-[''] before:top-0 before:bottom-0 before:start-0 before:z-10 before:w-[60px] before:h-[5px] before:bg-[#21306b]"></div>
                    <div class="bg-transparent min-w-[60px] h-[5px]"></div>
                </div>

            </div>

            <transition enter-active-class="transition-all duration-500 ease-in-out"
                        enter-from-class="opacity-0 -translate-x-5" enter-to-class="opacity-100 translate-x-0"
                        leave-active-class="transition-all duration-500 ease-in-out"
                        leave-from-class="opacity-100 translate-x-0" leave-to-class="opacity-0 translate-x-5"
                        mode="out-in">
                <div v-if="testimonialData.length" :key="selectedIndex"
                     class="mx-auto max-w-[750px] text-center text-gray-700 mb-5">
                    <span class="px-3">{{ testimonialData[selectedIndex]?.description }} </span>
                </div>
            </transition>

            <!-- Avatars -->
            <div class="flex justify-center gap-4 flex-wrap">
                <img v-for="(each, index) in testimonialData" :key="index" :src="each.image"
                     class="size-[65px] object-cover bg-cover rounded-full cursor-pointer border-4 transition duration-500"
                     :class="{ 'border-blue-500': selectedIndex === index, 'border-transparent': selectedIndex !== index }"
                     alt="avatar" @click="selectTestimonial(index)"/>
            </div>
        </div>
    </section>

</template>

<script>

import axios from "axios";
import Breadcrumb from "../../../../components/breadcrumb.vue";
import apiRoutes from "../../../../services/apiRoutes.js";
import apiServices from "../../../../services/apiServices.js";
import cookiesServices from "../../../../services/cookiesServices.js";

export default {
    components: {
        Breadcrumb
    },
    data() {
        return {
            lang: "en",
            generalData: null,
            testimonialData: [],
            selectedIndex: 0,
            autoRotateInterval: null,
            loading: false
        }
    },
    mounted() {
        this.trackVisit('About');
        this.lang = cookiesServices.get('lang') || "en";
        this.generalApi();
        this.testimonialApi();
    },
    beforeUnmount() {
        clearInterval(this.autoRotateInterval);
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
        async generalApi() {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.general + `/1`, {headers: apiServices.authHeaderContent});
                this.generalData = response?.data?.data
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        async testimonialApi() {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.testimonial, {
                    headers: apiServices.authHeaderContent
                });
                this.testimonialData = response?.data?.data;
                if (this.testimonialData.length > 1) {
                    this.startAutoRotation();
                }
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        selectTestimonial(index) {
            this.selectedIndex = index;
            this.restartAutoRotation();
        },
        startAutoRotation() {
            this.autoRotateInterval = setInterval(() => {
                this.selectedIndex =
                    (this.selectedIndex + 1) % this.testimonialData.length;
            }, 2500);
        },
        restartAutoRotation() {
            clearInterval(this.autoRotateInterval);
            this.startAutoRotation();
        }
    }
}

</script>
