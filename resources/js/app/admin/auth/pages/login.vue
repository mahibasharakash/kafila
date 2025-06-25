<template>

    <!-- title -->
    <div class="mb-2 text-2xl">
        {{ ___('Login') }}
    </div>

    <!-- description -->
    <div class="mb-3 text-sm text-gray-600">
        {{ ___('Please login using account detail bellow.') }}
    </div>

    <div class="bg-red-100 text-red-700 text-center p-3 mb-3 rounded-xl" v-if="credentials">
        {{ credentials }}
    </div>

    <!-- form -->
    <form @submit.prevent="loginApi()">

        <!-- email -->
        <div class="mb-3 block text-[14px]">
            <label for="email" class="block w-full font-semibold mb-1"> {{ ___('Email') }} <span class="text-[#21306b]">*</span>
            </label>
            <input id="email" type="email" v-model="formData.email" name="email"
                   class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]"
                   autocomplete="new-email"/>
            <div class="mt-1 text-rose-500 text-[13px]" v-if="error?.email"> {{ error?.email[0] }}</div>
        </div>

        <!-- password -->
        <div class="mb-5 block text-[14px]">
            <label for="password" class="flex justify-between font-semibold items-center w-full mb-1">
                <span> {{ ___('Password') }} <span class="text-[#21306b]">*</span> </span>
                <span> <router-link :to="{name:'forgot'}"
                                    class="decoration-0 text-rose-400 duration-500 hover:text-rose-600"> {{ ___('Forgot Password?') }} </router-link> </span>
            </label>
            <div class="relative w-full">
                <input id="password" :type="passwordFieldType" v-model="formData.password" name="password"
                       class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]"
                       autocomplete="new-password"/>
                <div class="absolute top-0 end-0 bottom-0 pe-3 flex justify-center items-center">
                    <button type="button" class="outline-0 border-0 bg-transparent cursor-pointer" @click="passwordVisibility()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="size-[17px] stroke-gray-700" v-if="passwordFieldType === 'text'">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="size-[17px] stroke-gray-700" v-if="passwordFieldType === 'password'">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="mt-1 text-rose-500 text-[13px]" v-if="error?.password"> {{ error?.password[0] }}</div>
        </div>

        <!-- login button -->
        <div class="w-full flex justify-center items-center">
            <button type="submit" class="px-10 h-[45px] btn-theme min-w-[170px]" v-if="!loading">
                {{ ___('Login') }}
            </button>
            <button type="button" class="px-10 h-[45px] btn-theme min-w-[170px]" v-if="loading">
                <span class="inline-block rounded-full border-2 border-white border-t-transparent animate-spin size-[18px]"></span>
            </button>
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
            password: '',
            passwordFieldType: 'password',
            formData: {
                email: '',
                password: '',
            },
            error: {},
            credentials: null,
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
        passwordVisibility() {
            this.passwordFieldType = this.passwordFieldType === "password" ? "text" : "password";
        },
        async loginApi() {
            try {
                this.credentials = null;
                this.error = {};
                this.loading = true;
                const response = await axios.post(apiRoutes.login, this.formData, {headers: apiServices.authHeaderContent});
                cookiesServices.set('access_token', response.data.access_token);
                if (response.data.user_type === 'Admin') {
                    cookiesServices.set('user_type', response.data.user_type);
                    this.formData = {email: '', password: ''};
                    this.$router.push({name: 'dashboard'});
                    toast.success(this.lang === "en" ? "User logged in successfully." : "تم تسجيل دخول المستخدم بنجاح.");
                } else {
                    this.credentials = "Please Apply Admin Credential";
                }
            } catch (error) {
                if (error?.response?.data?.credential) {
                    this.credentials = error?.response?.data?.credential;
                } else if (error?.response?.data?.errors) {
                    this.error = error?.response?.data?.errors;
                }
            } finally {
                this.loading = false;
            }
        },
    }
}

</script>
