<template>

    <!-- breadcrumb -->
    <Breadcrumb :title="___(`Verification Account`)"
                :links="[ { label: ___(`Home`), href: 'home' }, { label: ___(`Verification Account`), href: 'verification' } ]"></Breadcrumb>

    <div class="w-full mx-auto max-w-[1200px] py-16 grid sm:justify-center items-center">
        <div class="bg-gray-200/25 backdrop-blur-md p-10 w-full sm:min-w-[570px] mx-auto shadow-2xl rounded-3xl">

            <!-- title -->
            <div class="text-[25px] mb-3 text-center">
                {{ ___(`Verification Account`) }}
            </div>

            <!-- description -->
            <div class="text-[13px] mb-5 text-center">
                {{ ___(`Please check your email and provide verification code.`) }}
            </div>

            <!-- form -->
            <form @submit.prevent="verificationApi()">

                <!-- verification code -->
                <div class="mb-5 block text-[14px]">
                    <label for="user-verification-code" class="block w-full text-center mb-1">
                        {{ ___(`Verification Code`) }} <span class="text-[#21306b]">*</span>
                    </label>
                    <input id="user-verification-code" type="text"
                           name="verification_code"
                           class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px] text-center"
                           autocomplete="off"/>
                    <div class="mt-1 text-rose-500 text-[13px] text-center" v-if="error?.verification_code">
                        {{ error?.verification_code[0] }}
                    </div>
                </div>

                <!-- verify button -->
                <div class="mb-5 w-full flex justify-center">
                    <button type="submit" class="px-10 h-[50px] btn-theme min-w-[170px]" v-if="!verifyLoading">
                        {{ ___(`Verify`) }}
                    </button>
                    <button type="button" class="px-10 h-[50px] btn-theme min-w-[170px]" v-if="verifyLoading">
                        <span
                            class="inline-block rounded-full border-2 border-white border-t-transparent animate-spin size-[18px]"></span>
                    </button>
                </div>

                <!-- login route -->
                <div class="text-center">
                    <router-link :to="{name:'login'}"
                                 class="decoration-0 block text-gray-700 duration-500 hover:text-[#21306b]">
                        {{ ___(`Already verified`) }}
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
            verifyLoading: false,
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
                this.verifyLoading = true;
                const response = await axios.post(apiRoutes.verification, this.formData, {headers: apiServices.authHeaderContent});
                if (response.data.message) {
                    this.$router.push({name: 'reset', state: {email: this.formData.email}});
                }
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.verifyLoading = false;
            }
        },
    }
}

</script>
