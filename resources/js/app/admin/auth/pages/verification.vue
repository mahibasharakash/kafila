<template>

    <!-- title -->
    <div class="text-2xl mb-2 text-center">
        {{ ___('Verification Account') }}
    </div>

    <!-- description -->
    <div class="mb-3 text-sm text-gray-600 text-center">
        {{ ___('Please check your email and provide verification code.') }}
    </div>

    <!-- form -->
    <form @submit.prevent="verificationApi()">

        <!-- verification code -->
        <div class="mb-5 block text-[14px]">
            <label for="user-verification-code" class="w-full text-center block mb-1 hidden">
                {{ ___('Verification Code') }} </label>
            <input id="user-verification-code" v-model="formData.verification_code" type="text" name="verification_code"
                   class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px] text-center"
                   autocomplete="off"/>
            <div class="mt-1 text-rose-500 text-[13px]" v-if="error?.verification_code"> {{ error?.verification_code[0] }}</div>
        </div>

        <!-- verify button -->
        <div class="mb-5 w-full flex justify-center items-center">
            <button type="submit" class="px-10 h-[45px] btn-theme min-w-[170px]" v-if="!loading">
                {{ ___('Verify') }}
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

import cookiesServices from "../../../services/cookiesServices.js";

import {toast} from "vue3-toastify";

export default {
    data() {
        return {
            lang: 'en',
            loading: false,
            formData: {
                email: window.history.state.email,
                verification_code: '',
            },
            error: {},
        }
    },
    mounted() {
        this.lang = cookiesServices.get('lang') || "en";
    },
    methods: {
        async verificationApi() {
            try {
                this.loading = true;
                const response = await axios.post(apiRoutes.verification, this.formData, {headers: apiServices.authHeaderContent});
                if (response.data.message) {
                    this.$router.push({name: 'reset', state: {email: this.formData.email}});
                    toast.success(this.lang === "en" ? "Verified your account successfully." : "تم التحقق من حسابك بنجاح.");
                }
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.loading = false;
            }
        },
    }
}

</script>
