<template>

    <footer class="w-full bg-gray-100 bg-cover bg-no-repeat object-cover"
            :style="{ backgroundImage: 'url(/collection/footer_bg.webp)' }">
        <div class="w-full max-w-[1200px] mx-auto py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3">

                <div class="w-full p-5 block">
                    <div class="mb-3 text-[21px]"> {{ ___(`Working Time`) }} </div>
                    <div class="w-full mb-2 text-[14px] text-gray-800 flex flex-wrap gap-2">
                        <template v-for="each in generalData?.times">
                            <div class="inline-block"> {{ each.working_time }} </div>
                        </template>
                    </div>
                </div>

                <div class="w-full p-5 block">
                    <div class="mb-3 text-[21px]"> {{ ___(`Present Address`) }} </div>
                    <template v-if="generalData?.location"> {{ generalData?.location }} </template>
                </div>

                <div class="w-full p-5 block">
                    <div class="mb-3 block text-[20px]"> {{ ___(`Phone Numbers`) }} </div>
                    <div class="w-full mb-3 flex flex-wrap gap-2">
                        <template v-for="each in generalData?.phone_numbers">
                            <a :href="`tel:`+each.phone" class="decoration-0 inline-block mb-2 text-gray-800 duration-500 bg-transparent px-3 py-1 rounded-lg hover:bg-gray-300 text-[14px]">
                                {{ each.phone }}
                            </a>
                        </template>
                    </div>
                </div>

                <div class="w-full p-5 block">
                    <div class="mb-3 block text-[20px]">
                        {{ ___(`Emails`) }}
                    </div>
                    <div class="w-full flex flex-wrap gap-2">
                        <template v-for="each in generalData?.emails">
                            <a :href="`tel:`+each.email" class="decoration-0 inline-block text-gray-800 duration-500 bg-transparent px-3 py-1 rounded-lg hover:bg-gray-300 text-[14px]">
                                {{ each.email }}
                            </a>
                        </template>
                    </div>
                    <template v-if="loading">
                        <span class="screen-loader"></span>
                    </template>
                </div>

                <div class="w-full p-5 block">
                    <div class="mb-3 text-[21px]"> {{ ___(`Quick Links`) }}</div>
                    <div class="w-full flex flex-wrap gap-2">
                        <router-link :to="{name:'about'}" class="decoration-0 inline-block mb-2 text-gray-800 duration-500 bg-transparent px-3 py-1 rounded-lg hover:bg-gray-300 text-[14px]">
                            {{ ___(`About Us`) }}
                        </router-link>
                        <router-link :to="{name:'contact'}" class="decoration-0 inline-block mb-2 text-gray-800 duration-500 bg-transparent px-3 py-1 rounded-lg hover:bg-gray-300 text-[14px]">
                            {{ ___(`Contact Us`) }}
                        </router-link>
                        <router-link :to="{name:'blogs'}" class="decoration-0 inline-block mb-2 text-gray-800 duration-500 bg-transparent px-3 py-1 rounded-lg hover:bg-gray-300 text-[14px]">
                            {{ ___(`Blogs`) }}
                        </router-link>
                        <router-link :to="{name:'services'}" class="decoration-0 inline-block mb-2 text-gray-800 duration-500 bg-transparent px-3 py-1 rounded-lg hover:bg-gray-300 text-[14px]">
                            {{ ___(`Services`) }}
                        </router-link>
                        <router-link :to="{name:'products'}" class="decoration-0 inline-block mb-2 text-gray-800 duration-500 bg-transparent px-3 py-1 rounded-lg hover:bg-gray-300 text-[14px]">
                            {{ ___(`Products`) }}
                        </router-link>
                    </div>
                </div>

                <div class="w-full p-5 block">
                    <div class="mb-3 text-[21px]"> {{ ___(`Social Media`) }} </div>
                    <div class="w-full flex flex-wrap gap-2">
                        <a href="https://www.facebook.com/kafila" target="_blank" class="decoration-0 inline-block mb-2 text-gray-800 duration-500 bg-transparent px-3 py-1 rounded-lg hover:bg-gray-300 text-[14px]">
                            {{ ___(`Facebook`) }}
                        </a>
                        <a href="https://www.skype.com/kafila" target="_blank" class="decoration-0 inline-block mb-2 text-gray-800 duration-500 bg-transparent px-3 py-1 rounded-lg hover:bg-gray-300 text-[14px]">
                            {{ ___(`Skype`) }}
                        </a>
                        <a href="https://www.instagram.com/kafila" target="_blank" class="decoration-0 inline-block mb-2 text-gray-800 duration-500 bg-transparent px-3 py-1 rounded-lg hover:bg-gray-300 text-[14px]">
                            {{ ___(`Instagram`) }}
                        </a>
                        <a href="https://www.pinterest.com/kafila" target="_blank" class="decoration-0 inline-block mb-2 text-gray-800 duration-500 bg-transparent px-3 py-1 rounded-lg hover:bg-gray-300 text-[14px]">
                            {{ ___(`Pinterest`) }}
                        </a>
                        <a href="https://www.youtube.com/kafila" target="_blank" class="decoration-0 inline-block mb-2 text-gray-800 duration-500 bg-transparent px-3 py-1 rounded-lg hover:bg-gray-300 text-[14px]">
                            {{ ___(`Youtube`) }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full bg-white">
            <div class="w-full max-w-[1200px] mx-auto p-5 text-center flex justify-between items-center flex-col md:flex-row gap-5">
                <a href="https://mahibasharakash.thethemeai.com" target="_blank" class="decoration-0 text-gray-800 duration-500 hover:text-[#21306b]">
                    Mahi Bashar Akash
                </a>
                <a href="mailto:mahibashar2023@gmail.com" class="decoration-0 text-gray-800 duration-500 hover:text-[#21306b]">
                    mahibashar2023@gmail.com
                </a>
                <a href="tel:01400125289" class="decoration-0 text-gray-800 duration-500 hover:text-[#21306b]">
                    01400125289
                </a>
            </div>
        </div>
    </footer>

</template>

<script>

import axios from "axios";
import apiRoutes from "../../../../services/apiRoutes.js";
import apiServices from "../../../../services/apiServices.js";
import cookiesServices from "../../../../services/cookiesServices.js";

export default {
    data() {
        return {
            lang: 'en',
            loading: false,
            generalData: null,
        }
    },
    mounted() {
        this.lang = cookiesServices.get('lang') || "en";
        this.generalApi();
    },
    methods: {
        async generalApi() {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.general + `/1`, this.formData, {headers: apiServices.authHeaderContent});
                this.generalData = response?.data?.data;
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
    }
}

</script>
