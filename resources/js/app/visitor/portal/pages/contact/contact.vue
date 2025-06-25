<template>

    <!-- breadcrumb -->
    <Breadcrumb :title="___(`Contact Us`)"
                :links="[ { label: ___(`Home`), href: 'home' }, { label: ___(`Contact Us`), href: 'contact' } ]"></Breadcrumb>

    <section v-if="!loading" class="w-full py-3 sm:py-16 block">
        <div class="mx-auto max-w-[1200px] w-full flex flex-wrap justify-start px-5 sm:px-10">

            <div class="w-full lg:w-2/6 p-1 h-full">
                <div class="bg-gray-100 p-5 md:p-10 h-full rounded-lg w-full block">

                    <!-- title -->
                    <div class="mb-3 block text-[18px] font-semibold">
                        {{ ___(`Contact Info`) }}
                    </div>

                    <!-- description -->
                    <div class="mb-3 block text-[14px] text-gray-800">
                        {{ ___(`Get in touch with us for any inquiries, support, or feedback. We're here to help!`) }}
                    </div>

                    <!-- title -->
                    <div class="mb-3 block text-[18px] font-semibold">
                        {{ ___(`Present Address`) }}
                    </div>

                    <!-- address -->
                    <div class="text-[14px] block mb-3 text-gray-800">
                        {{ generalData?.location }}
                    </div>

                    <!-- title -->
                    <div class="mb-3 block text-[18px] font-semibold">
                        {{ ___(`Phone Numbers`) }}
                    </div>

                    <!-- mobile phone -->
                    <template v-for="each in generalData?.phone_numbers">
                        <div class="block w-full mb-3 text-[14px] text-gray-800">
                            <a :href="`tel:`+each.phone" class="decoration-0 inline-block">
                                {{ each.phone }}
                            </a>
                        </div>
                    </template>

                    <!-- email -->
                    <div class="mb-3 block text-[18px] font-semibold">
                        {{ ___(`Email Addresses`) }}
                    </div>

                    <template v-for="each in generalData?.emails">
                        <div class="block w-full mt-3 text-[14px] text-gray-800">
                            <a :href="`mailto:`+each.email">
                                {{ each.email }}
                            </a>
                        </div>
                    </template>

                </div>
            </div>

            <div class="w-full lg:w-4/6 p-1 h-full">
                <form @submit.prevent="contactApi()" class="bg-gray-100 p-5 md:p-10 h-full block w-full rounded-lg">

                    <!-- title -->
                    <div class="mb-3 block text-[18px] sm:text-[25px] font-semibold">
                        {{ ___(`Write Your Query`) }}
                    </div>

                    <!-- name -->
                    <div class="mb-3 block text-[14px]">
                        <label for="user-name" class="block w-full mb-1"> {{ ___(`Your Name`) }}
                            <span class="text-[#21306b]">*</span>
                        </label>
                        <input id="user-name" type="text" v-model="formData.name" name="name"
                               class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]"
                               autocomplete="off"/>
                        <div class="mt-1 text-rose-500" v-if="error?.name"> {{ error?.name[0] }}</div>
                    </div>

                    <!-- email -->
                    <div class="mb-3 block text-[14px]">
                        <label for="user-email" class="block w-full mb-1">
                            {{ ___(`Your Email`) }}
                            <span class="text-[#21306b]">*</span>
                        </label>
                        <input id="user-email" type="text" v-model="formData.email" name="email"
                               class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]"
                               autocomplete="off"/>
                        <div class="mt-1 text-rose-500" v-if="error?.email"> {{ error?.email[0] }}</div>
                    </div>

                    <!-- message -->
                    <div class="mb-3 block text-[14px]">
                        <label for="user-message" class="block w-full mb-1">
                            {{ ___(`Your Message`) }} <span class="text-[#21306b]">*</span>
                        </label>
                        <textarea id="user-message" name="message" v-model="formData.message"
                                  class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] px-4 text-[13px] h-auto px-5 py-4"
                                  cols="30" rows="3"></textarea>
                        <div class="mt-1 text-rose-500" v-if="error?.message"> {{ error?.message[0] }}</div>
                    </div>

                    <!-- submit button -->
                    <div class="inline-flex items-center text-[14px]">
                        <button type="submit" v-if="!submitLoading"
                                class="min-w-[150px] h-[50px] btn-theme">
                            {{ ___(`Send Message`) }}
                        </button>
                        <button type="button" v-if="submitLoading" class="min-w-[150px] h-[50px] btn-theme">
                            <span
                                class="size-[20px] inline-block rounded-full border-2 border-white border-t-transparent animate-spin"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section v-if="loading" class="w-full min-h-[650px] flex justify-center items-center">
        <span class="screen-loader"></span>
    </section>

</template>

<script>

import axios from "axios";
import Breadcrumb from "../../../../components/breadcrumb.vue";
import apiServices from "../../../../services/apiServices.js";
import apiRoutes from "../../../../services/apiRoutes.js";
import cookiesServices from "../../../../services/cookiesServices.js";

export default {
    components: {
        Breadcrumb
    },
    data() {
        return {
            lang: 'en',
            submitLoading: false,
            loading: false,
            formData: {
                name: '',
                email: '',
                message: '',
            },
            error: {},
            generalData: null,
        }
    },
    mounted() {
        this.trackVisit('Contact');
        this.lang = cookiesServices.get('lang') || "en";
        this.generalApi();
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
        async contactApi() {
            try {
                this.error = {};
                this.submitLoading = true;
                await axios.post(apiRoutes.contact + '/store', this.formData, {headers: apiServices.authHeaderContent});
                this.formData = {name: '', email: '', message: ''};
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.submitLoading = false;
            }
        },
        async generalApi() {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.general + `/1`, this.formData, {headers: apiServices.authHeaderContent});
                this.generalData = response?.data?.data
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
    }
}

</script>
