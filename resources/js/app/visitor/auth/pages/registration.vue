<template>

    <!-- breadcrumb -->
    <Breadcrumb :title="___(`Registration`)"
                :links="[ { label: ___(`Home`), href: 'home' }, { label: ___(`Registration`), href: 'registration' } ]"></Breadcrumb>

    <div class="w-full mx-auto max-w-[1200px] py-16 grid sm:justify-center items-center">
        <div class="bg-gray-100 p-10 w-full sm:min-w-[470px] mx-auto">

            <!-- title -->
            <div class="text-[25px] font-bold">
                {{___(`Create New Account`)}}
            </div>

            <!-- description -->
            <div class="text-[13px] mb-5 font-medium">
                {{ ___(`Please Register using account detail bellow.`)}}
            </div>

            <!-- form -->
            <form @submit.prevent="registrationApi()">

                <!-- name -->
                <div class="mb-3 block text-[14px]">
                    <label for="user-name" class="block w-full font-semibold mb-1">
                        {{___(`Name`)}}
                        <span class="text-[#21306b]">*</span>
                    </label>
                    <input id="user-name" type="text" v-model="formData.name" name="name"
                           class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:border-[#21306b] h-[45px] px-4"
                           autocomplete="new-name"/>
                    <div class="mt-1 text-red-600 font-medium text-[13px]" v-if="error?.name"> {{error?.name[0]}} </div>
                </div>

                <!-- phone -->
                <div class="mb-3 block text-[14px]">
                    <label for="user-phone" class="block w-full font-semibold mb-1">
                        {{___(`Phone`)}}
                        <span class="text-[#21306b]">*</span>
                    </label>
                    <input id="user-phone" type="text" v-model="formData.phone" name="phone"
                           class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]"
                           autocomplete="new-phone"/>
                    <div class="mt-1 text-red-600 font-medium text-[13px]" v-if="error?.phone"> {{error?.phone[0]}} </div>
                </div>

                <!-- email -->
                <div class="mb-3 block text-[14px]">
                    <label for="user-email" class="block w-full font-semibold mb-1"> {{___(`Email`)}}
                        <span class="text-[#21306b]">*</span>
                    </label>
                    <input id="user-email" type="email" v-model="formData.email" name="email"
                           class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]"
                           autocomplete="new-email"/>
                    <div class="mt-1 text-red-600 font-medium text-[13px]" v-if="error?.email"> {{error?.email[0]}} </div>
                </div>

                <!-- password -->
                <div class="mb-3 block text-[14px]">
                    <label for="user-password" class="block w-full font-semibold mb-1">{{___(`Password`)}}
                        <span class="text-[#21306b]">*</span>
                    </label>
                    <input id="user-password" type="password" v-model="formData.password" name="password"
                           class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]"
                           autocomplete="new-password"/>
                    <div class="mt-1 text-red-600 font-medium text-[13px]" v-if="error?.password"> {{error?.password[0]}} </div>
                </div>

                <!-- password confirmation -->
                <div class="mb-5 block text-[14px]">
                    <label for="user-password-confirmation" class="block w-full font-semibold mb-1">
                        {{___(`Confirm Password`)}}
                        <span class="text-[#21306b]">*</span>
                    </label>
                    <input id="user-password-confirmation" type="password" v-model="formData.password_confirmation" name="password_confirmation"
                           class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]"
                           autocomplete="new-confirm-password"/>
                    <div class="mt-1 text-red-600 font-medium text-[13px]" v-if="error?.password_confirmation"> {{error?.password_confirmation[0]}} </div>
                </div>

                <!-- registration button -->
                <div class="mb-5 w-full flex">
                    <button type="submit" class="h-[45px] btn-theme min-w-[140px] max-w-[140px] rounded-xl" v-if="!registrationLoading">
                        {{___(`Registration`)}}
                    </button>
                    <button type="button" class="h-[45px] btn-theme min-w-[140px] max-w-[140px] rounded-xl" v-if="registrationLoading">
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
            registrationLoading: false,
            formData: {
                user_type: 'Customer',
                name: '',
                phone: '',
                email: '',
                password: '',
                password_confirmation: '',
            },
            error: {},
        }
    },
    mounted() {
        this.lang = cookiesServices.get('lang') || "en";
    },
    methods: {
        async registrationApi() {
            try {
                this.error = {};
                this.registrationLoading = true;
                const response = await axios.post(apiRoutes.registration, this.formData, {headers: apiServices.authHeaderContent});
                if (response.data.user) { this.$router.push({name: 'login'}); }
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.registrationLoading = false;
            }
        },
    }
}

</script>
