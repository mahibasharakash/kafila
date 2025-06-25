<template>

    <!-- breadcrumb -->
    <Breadcrumb :title="___(`Forgot Password`)"
                :links="[ { label: ___(`Home`), href: 'home' }, { label: ___(`Forgot Password`), href: 'forgot' } ]"></Breadcrumb>

    <div class="w-full mx-auto max-w-[1200px] py-16 grid sm:justify-center items-center">
        <div class="bg-gray-100 p-10 w-full sm:min-w-[470px] mx-auto">

            <!-- title -->
            <div class="text-[25px] font-bold">
                {{ ___(`Forgot Password`) }}
            </div>

            <!-- description -->
            <div class="text-[13px] mb-5 font-medium">
                {{ ___(`We will send you an email to verify your account`) }}
            </div>

            <!-- form -->
            <form @submit.prevent="forgotApi()">

                <div class="bg-red-100 text-red-700 text-center p-3 mb-5 rounded-xl" v-if="message">
                    {{ message }}
                </div>

                <!-- email -->
                <div class="mb-5 block text-[14px]">
                    <label for="user-email" class="block w-full font-semibold mb-1">
                        {{ ___(`Email`) }} <span class="text-[#21306b]">*</span>
                    </label>
                    <input id="user-email" type="email" v-model="formData.email" name="email" class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:border-[#21306b] h-[45px] px-4" autocomplete="off"/>
                    <div class="mt-1 text-red-600 font-medium text-[13px]" v-if="error?.email"> {{ error?.email[0] }}</div>
                </div>

                <!-- send button -->
                <div class="w-full flex mb-5">
                    <button type="submit" class="h-[45px] btn-theme min-w-[140px] max-w-[140px]" v-if="!forgotLoading">
                        {{ ___('Send') }}
                    </button>
                    <button type="button" class="h-[45px] btn-theme min-w-[140px] max-w-[140px]" v-if="forgotLoading">
                        <span class="inline-block rounded-full border-2 border-white border-t-transparent animate-spin size-[18px]"></span>
                    </button>
                </div>

                <!-- login route -->
                <div class="text-start text-[14px]">
                    <div class="font-medium"> {{___(`Already have an account`)}} </div>
                    <router-link :to="{name:'login'}" class="decoration-0 font-semibold inline-block text-gray-700 duration-500 hover:text-blue-900">
                        {{___('Sign In')}}
                    </router-link>
                </div>

            </form>

        </div>
    </div>

</template>

<script>

import axios from "axios";
import Breadcrumb from "../../../components/breadcrumb.vue";
import apiServices from "../../../services/apiServices.js";
import apiRoutes from "../../../services/apiRoutes.js";
import cookiesServices from "../../../services/cookiesServices.js";

export default {
    components: {
        Breadcrumb
    },
    data() {
        return {
            lang: 'en',
            forgotLoading: false,
            formData: {
                email: '',
            },
            error: {},
            message: null,
        }
    },
    mounted() {
        this.lang = cookiesServices.get('lang') || "en";
    },
    methods: {
        async forgotApi() {
            try {
                this.forgotLoading = true;
                this.error = {};
                this.message = null;
                await axios.post(apiRoutes.forgot, this.formData, {headers: apiServices.authHeaderContent});
                this.$router.push({name: 'verification', state: {email: this.formData.email}});
            } catch (error) {
                if (error?.response && error?.response?.status === 404) {
                    this.message = error?.response?.data?.message;
                } else if (error?.response && error?.response?.data?.errors) {
                    this.error = error?.response?.data?.errors;
                } else {
                    this.message = 'An unexpected error occurred.';
                }
            } finally {
                this.forgotLoading = false;
            }
        }
    }
}

</script>
