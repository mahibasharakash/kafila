<template>

    <!-- title -->
    <div class="mb-2 text-2xl">
        {{ ___('Forgot Password') }}
    </div>

    <!-- description -->
    <div class="mb-3 text-sm text-gray-600">
        {{ ___('We will send you an email to verify your account') }}
    </div>

    <!-- form -->
    <form @submit.prevent="forgotApi()">

        <div class="bg-red-100 text-red-700 text-center p-3 mb-3 rounded-xl" v-if="message">
            {{ message }}
        </div>

        <!-- email -->
        <div class="mb-5 block text-[14px]">
            <label for="user-email" class="block w-full font-semibold mb-1"> {{ ___('Email') }} <span class="text-[#21306b]">*</span>
            </label>
            <input id="user-email" type="email" name="email" v-model="formData.email"
                   class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]"
                   autocomplete="off"/>
            <div class="mt-1 text-rose-500 text-[13px]" v-if="error?.email"> {{ error?.email[0] }}</div>
        </div>

        <!-- send button -->
        <div class="mb-5 w-full flex justify-center items-center">
            <button type="submit" class="px-10 h-[45px] btn-theme min-w-[170px]" v-if="!loading">
                {{ ___('Send') }}
            </button>
            <button type="button" class="px-10 h-[45px] btn-theme min-w-[170px]" v-if="loading">
                <span
                    class="inline-block rounded-full border-2 border-white border-t-transparent animate-spin size-[18px]"></span>
            </button>
        </div>

        <!-- login route -->
        <div class="text-center">
            <div class="mb-2">
                {{___(`!Remember my password`)}}
            </div>
            <router-link :to="{name:'login'}" class="decoration-0 block text-gray-700 duration-500 hover:text-[#21306b]">
                {{ ___('Remember password') }}
            </router-link>
        </div>

    </form>

</template>

<script>

import axios from "axios";
import apiServices from "../../../services/apiServices.js";
import apiRoutes from "../../../services/apiRoutes.js";

import {toast} from "vue3-toastify";

import cookiesServices from "../../../services/cookiesServices.js";

export default {
    data() {
        return {
            lang: 'en',
            loading: false,
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
                this.loading = true;
                this.error = {};
                this.message = null;
                await axios.post(apiRoutes.forgot, this.formData, {headers: apiServices.authHeaderContent});
                this.$router.push({name: 'verification', state: {email: this.formData.email}});
                toast.success(this.lang === "en" ? "Code send in your email." : "أرسل الكود إلى بريدك الإلكتروني.");
            } catch (error) {
                if (error?.response && error?.response?.status === 404) {
                    this.message = error?.response?.data?.no_email;
                } else if (error?.response && error?.response?.data?.errors) {
                    this.error = error?.response?.data?.errors;
                } else {
                    this.message = 'An unexpected error occurred.';
                }
            } finally {
                this.loading = false;
            }
        }
    }
}

</script>
