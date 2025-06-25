<template>

    <!-- breadcrumb -->
    <Breadcrumb :title="___(`Reset Password`)"
                :links="[ { label: ___(`Home`), href: 'home' }, { label: ___(`Reset Password`), href: 'reset' } ]"></Breadcrumb>

    <div class="w-full mx-auto max-w-[1200px] py-16 grid sm:justify-center items-center">
        <div class="bg-gray-200/25 backdrop-blur-md p-10 w-full sm:min-w-[570px] mx-auto shadow-2xl rounded-3xl">

            <!-- title -->
            <div class="text-center text-[25px] mb-3">
                {{ ___(`Reset Password`) }}
            </div>

            <!-- description -->
            <div class="text-center text-[13px] mb-5">
                {{ ___(`Please check your email and take reset code to fill below details.`) }}
            </div>

            <!-- form -->
            <form @submit.prevent="resetApi()">

                <!-- email -->
                <div class="mb-3 block text-[14px]">
                    <label for="user-email" class="block w-full mb-1"> {{ ___(`Email`) }}
                        <span class="text-[#21306b]">*</span>
                    </label>
                    <input id="user-email" type="email" v-model="formData.email" name="email"
                           class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]"
                           autocomplete="off"/>
                    <div class="mt-1 text-rose-500 text-[13px]" v-if="error?.email"> {{ error?.email[0] }}</div>
                </div>

                <!-- reset code -->
                <div class="mb-3 block text-[14px]">
                    <label for="user-reset-code" class="block w-full mb-1"> {{ ___(`Reset Code`) }}
                        <span class="text-[#21306b]">*</span>
                    </label>
                    <input id="user-reset-code" type="text" v-model="formData.reset_code" name="reset_code"
                           class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]"
                           autocomplete="off"/>
                    <div class="mt-1 text-rose-500 text-[13px]" v-if="error?.reset_code"> {{ error?.reset_code[0] }}</div>
                </div>

                <!-- password -->
                <div class="mb-3 block text-[14px]">
                    <label for="user-password" class="block w-full mb-1">
                        {{ ___(`Password`) }}
                        <span class="text-[#21306b]">*</span>
                    </label>
                    <input id="user-password" type="password" v-model="formData.password" name="password"
                           class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]"
                           autocomplete="off"/>
                    <div class="mt-1 text-rose-500 text-[13px]" v-if="error?.password"> {{ error?.password[0] }}</div>
                </div>

                <!-- confirm password -->
                <div class="mb-3 block text-[14px]">
                    <label for="user-password-confirmation" class="block w-full mb-1">
                        {{ ___(`Confirm Password`) }}
                        <span class="text-[#21306b]">*</span>
                    </label>
                    <input id="user-password-confirmation" type="password" v-model="formData.password_confirmation" name="password_confirmation"
                           class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]"
                           autocomplete="off"/>
                    <div class="mt-1 text-rose-500 text-[13px]" v-if="error?.password_confirmation">
                        {{ error?.password_confirmation[0] }}
                    </div>
                </div>

                <!-- send button -->
                <div class="mb-5 w-full flex justify-center items-center">
                    <button type="submit" class="px-10 h-[50px] btn-theme min-w-[170px]" v-if="!resetLoading">
                        {{ ___('Send') }}
                    </button>
                    <button type="button" class="px-10 h-[50px] btn-theme min-w-[170px]" v-if="resetLoading">
                        <span
                            class="inline-block rounded-full border-2 border-white border-t-transparent animate-spin size-[18px]"></span>
                    </button>
                </div>

                <!-- login route -->
                <div class="text-center">
                    <router-link :to="{name:'login'}"
                                 class="decoration-0 block text-gray-700 duration-500 hover:text-[#21306b]">
                        {{ ___(`Remember password`) }}
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
            resetLoading: false,
            formData: {
                email: window.history.state.email,
                reset_code: '',
                password: '',
                password_confirmation: '',
            },
            error: {},
        }
    },
    watch: {
        'formData.password'(newVal) {
            newVal.replace(/[^a-zA-Z0-9!@#$%^&*()_+]/g, '');
        }
    },
    mounted() {
        this.lang = cookiesServices.get('lang') || "en";
    },
    methods: {
        async resetApi() {
            try {
                this.resetLoading = true;
                const response = await axios.post(apiRoutes.reset, this.formData, {headers: apiServices.authHeaderContent});
                if (response.data.message) {
                    this.formData = {email: '', reset_code: '', password: '', password_confirmation: ''};
                    this.$router.push({name: 'login'});
                }
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.resetLoading = false;
            }
        },
    }
}

</script>
