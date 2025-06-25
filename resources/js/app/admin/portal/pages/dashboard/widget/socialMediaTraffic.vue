<template>

    <div class="w-full block text-center text-[#333] p-[10px] mb-[30px] font-bold"> Social Media Traffic</div>
    <div class="mb-3 w-full block">
        <div class="mb-1 w-full flex justify-between items-center">
            <div> {{___(`From Facebook`)}} </div>
            <div class="text-[14px] font-semibold"> {{___(`visited`)}}: {{ facebook.count }}</div>
        </div>
        <div class="relative w-full h-[25px] bg-gray-300 rounded-2xl">
            <div class="h-full duration-500 rounded-2xl bg-rose-300" :style="{ width: `${facebook.percent}%` }"></div>
        </div>
    </div>
    <div class="mb-3 w-full block">
        <div class="mb-1 w-full flex justify-between items-center">
            <div> {{___(`From Twitter`)}} </div>
            <div class="text-[14px] font-semibold"> {{___(`visited`)}}: {{ twitter.count }}</div>
        </div>
        <div class="relative w-full h-[25px] bg-gray-300 rounded-2xl">
            <div class="h-full duration-500 rounded-2xl bg-yellow-300"
                 :style="{ width: `${twitter.percent}%` }"></div>
        </div>
    </div>
    <div class="mb-3 w-full block">
        <div class="mb-1 w-full flex justify-between items-center">
            <div> {{___(`From Instagram`)}} </div>
            <div class="text-[14px] font-semibold"> {{___(`visited`)}}: {{ instagram.count }}</div>
        </div>
        <div class="relative w-full h-[25px] bg-gray-300 rounded-2xl">
            <div class="h-full duration-500 rounded-2xl bg-orange-300" :style="{ width: `${instagram.percent}%` }"></div>
        </div>
    </div>
    <div class="mb-3 w-full block">
        <div class="mb-1 w-full flex justify-between items-center">
            <div> {{___(`From Linkedin`)}} </div>
            <div class="text-[14px] font-semibold"> {{___(`visited`)}}: {{ linkedin.count }}</div>
        </div>
        <div class="relative w-full h-[25px] bg-gray-300 rounded-2xl">
            <div class="h-full duration-500 rounded-2xl bg-green-300" :style="{ width: `${linkedin.percent}%` }"></div>
        </div>
    </div>
    <div class="mb-3 w-full block">
        <div class="mb-1 w-full flex justify-between items-center">
            <div> {{___(`From YouTube`)}} </div>
            <div class="text-[14px] font-semibold"> {{___(`visited`)}}: {{ youtube.count }}</div>
        </div>
        <div class="relative w-full h-[25px] bg-gray-300 rounded-2xl">
            <div class="h-full duration-500 rounded-2xl bg-blue-300" :style="{ width: `${youtube.percent}%` }"></div>
        </div>
    </div>

</template>

<script>

import axios from "axios";
import apiRoutes from "../../../../../services/apiRoutes.js";
import apiServices from "../../../../../services/apiServices.js";
import cookiesServices from "../../../../../services/cookiesServices.js";

export default {
    data() {
        return {
            loading: false,
            facebook: {percent: 0, count: 0},
            instagram: {percent: 0, count: 0},
            linkedin: {percent: 0, count: 0},
            twitter: {percent: 0, count: 0},
            youtube: {percent: 0, count: 0},
        }
    },
    mounted() {
        this.listApi();
        this.lang = cookiesServices.get('lang') || "en";
    },
    methods: {
        async listApi() {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.socialMediaSource, {headers: apiServices.authHeaderContent});
                this.facebook = response?.data?.facebook;
                this.instagram = response?.data?.instagram;
                this.linkedin = response?.data?.linkedin;
                this.twitter = response?.data?.twitter;
                this.youtube = response?.data?.youtube;
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
    }
}


</script>
