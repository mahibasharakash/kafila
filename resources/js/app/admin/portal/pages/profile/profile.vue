<template>

    <section class="w-full px-3 sm:px-10">

        <!-- Card body title -->
        <div class="text-[25px]"> {{ ___('Profile') }} </div>

        <!-- Breadcrumb -->
        <ul class="w-full flex justify-start items-center">
            <li class="mb-0">
                <a href="javascript:void(0)" class="decoration-0 text-black ps-0 p-2 inline-block">
                    {{___(`Pages`)}}
                </a>
            </li>
            <li class="-mb-[5px] pb-0">
                <div class="inline-block opacity-75">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-[15px]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            </li>
            <li class="mb-0">
                <router-link :to="{name:'dashboard'}" class="decoration-0 text-[#21306b] duration-500 hover:text-[#3B497E] p-2 inline-block">
                    {{___(`Dashboard`)}}
                </router-link>
            </li>
            <li class="-mb-[5px] pb-0">
                <div class="inline-block opacity-75">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-[15px]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            </li>
            <li class="mb-0">
                <router-link :to="{name:'profile'}" class="decoration-0 text-[#21306b] duration-500 hover:text-[#3B497E] p-2 inline-block">
                    {{___(`Profile`)}}
                </router-link>
            </li>
        </ul>

        <div class="flex flex-wrap">
            <div class="lg:w-1/3 lg:pe-5">
                <template v-if="loading">
                    <div class="w-full bg-white p-10 shadow-sm rounded-[0.625rem_0.625rem_0_0] h-[calc(100vh-220px)] overflow-y-auto">
                        <div class="flex justify-start items-start">
                            <div class="w-full">
                                <div class="flex justify-center mb-5 w-full">
                                    <div
                                        class="size-[250px] min-w-[250px] min-h-[250px] rounded-full bg-gray-700 animate-pulse"></div>
                                </div>
                                <div class="mb-3 w-full">
                                    <div class="min-h-[24px] w-full max-w-[100px] bg-gray-700 animate-pulse mb-1"></div>
                                    <div class="min-h-[24px] w-full max-w-[250px] bg-gray-700 animate-pulse"></div>
                                </div>
                                <div class="mb-3 w-full">
                                    <div class="min-h-[24px] w-full max-w-[150px] bg-gray-700 animate-pulse mb-1"></div>
                                    <div class="min-h-[24px] w-full max-w-[300px] bg-gray-700 animate-pulse"></div>
                                </div>
                                <div class="mb-3 w-full">
                                    <div class="min-h-[24px] w-full max-w-[200px] bg-gray-700 animate-pulse mb-1"></div>
                                    <div class="min-h-[24px] w-full max-w-[350px] bg-gray-700 animate-pulse"></div>
                                </div>
                                <div class="w-full">
                                    <div class="min-h-[24px] w-full max-w-[150px] bg-gray-700 animate-pulse mb-1"></div>
                                    <div class="min-h-[24px] w-full max-w-[300px] bg-gray-700 animate-pulse"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-if="!loading">
                    <div class="w-full bg-white p-10 shadow-sm rounded-[0.625rem_0.625rem_0_0] h-[calc(100vh-220px)] overflow-y-auto">
                       <div class="flex justify-center mb-5 w-full">
                            <img v-if="profileData?.image" :src="profileData?.image" class="size-[250px] min-w-[250px] min-h-[250px] object-cover bg-cover rounded-full" alt="profile"/>
                            <div v-else class="size-[250px] min-w-[250px] min-h-[250px] text-6xl bg-[#21306b] rounded-full text-white inline-flex justify-center items-center">
                                {{shortName(profileData?.name)}}
                            </div>
                        </div>
                        <div class="block w-full mb-3">
                            <div class="block w-full mb-1"> {{ ___('Full Name') }} </div>
                            <div class="block w-full text-gray-700">
                                <template v-if="profileData?.name"> {{ profileData?.name }} </template>
                                <template v-else> N/A </template>
                            </div>
                        </div>
                        <div class="block w-full mb-3">
                            <div class="block w-full mb-1"> {{ ___('Email') }} </div>
                            <div class="block w-full text-gray-700">
                                <template v-if="profileData?.email"> {{ profileData?.email }} </template>
                                <template v-else> N/A </template>
                            </div>
                        </div>
                        <div class="block w-full mb-3">
                            <div class="block w-full mb-1">
                                {{ ___('Phone Number') }}
                            </div>
                            <div class="block w-full text-gray-700">
                                <template v-if="profileData?.phone"> {{ profileData?.phone }} </template>
                                <template v-else> N/A </template>
                            </div>
                        </div>
                        <div class="block w-full">
                            <div class="block w-full mb-1"> {{ ___('Address') }} </div>
                            <div class="block w-full text-gray-700">
                                <template v-if="profileData?.address"> {{ profileData?.address }} </template>
                                <template v-else> N/A </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div class="lg:w-2/3">
                <section class="w-full bg-white p-10 shadow-sm rounded-[0.625rem_0.625rem_0_0] h-[calc(100vh-220px)] overflow-y-auto">
                    <form @submit.prevent="changeDetails" class="w-full mb-5">
                        <div class="mb-5 w-full justify-center">
                            <template v-if="!attach_preview">
                                <label for="upload"
                                    class="w-full max-w-[250px] max-h-[250px] min-h-[250px] rounded-full bg-[#21306b]/25 duration-500 hover:bg-[#21306b]/95 group cursor-pointer flex justify-center items-center">
                                    <input id="upload" type="file" name="image" accept="image/*" hidden="hidden"
                                        autocomplete="off" @change="attachFile($event)"/>
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            class="size-[45px] stroke-[#21306b] duration-500 group-hover:stroke-white">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                                        </svg>
                                    </span>
                                </label>
                            </template>
                            <template v-if="attach_preview">
                                <div class="w-full max-w-[250px] relative flex justify-center items-center">
                                    <img :src="attach_preview"
                                        class="w-full max-w-[250px] max-h-[250px] min-h-[250px] rounded-full object-cover bg-cover"
                                        alt="attach_file"/>
                                    <div class="absolute inset-0 w-full h-full flex justify-center items-center">
                                        <div
                                            class="max-w-[250px] min-w-[250px] max-h-[250px] min-h-[250px] flex justify-center items-center rounded-full bg-transparent duration-500 hover:bg-gray-200/25 backdrop-blur-none hover:backdrop-blur-sm">
                                            <button type="button"
                                                    class="size-[45px] inline-flex justify-center items-center rounded-xl bg-rose-400 duration-500 hover:bg-rose-700 cursor-pointer"
                                                    @click="removeFile()">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" class="size-6 stroke-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="p-7 shadow-gray-300 shadow-inner rounded-2xl">
                            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-2">
                                <div class="block text-[14px] w-full mb-3">
                                    <label for="profile-name" class="block mb-1 w-full"> {{ ___('Name') }} </label>
                                    <input id="profile-name" type="text" name="name" v-model="profileParam.name"
                                           class="w-full block outline-0 rounded-xl bg-white border border-gray-300 duration-500 focus-within:border-[#21306b] h-[45px] px-5"
                                           autocomplete="off"/>
                                </div>
                                <div class="block text-[14px] w-full mb-3">
                                    <label for="profile-email" class="block mb-1 w-full"> {{ ___('Email') }} </label>
                                    <input id="profile-email" type="text" name="email" v-model="profileParam.email"
                                           class="w-full block outline-0 rounded-xl bg-white border border-gray-300 duration-500 focus-within:border-[#21306b] h-[45px] px-5"
                                           autocomplete="off"/>
                                </div>
                                <div class="block text-[14px] w-full mb-3">
                                    <label for="profile-phone-number" class="block mb-1 w-full"> {{ ___('Phone Number') }} </label>
                                    <input id="profile-phone-number" type="text" name="phone" v-model="profileParam.phone"
                                           class="w-full block outline-0 rounded-xl bg-white border border-gray-300 duration-500 focus-within:border-[#21306b] h-[45px] px-5"
                                           autocomplete="off"/>
                                </div>
                                <div class="block text-[14px] w-full mb-3">
                                    <label for="profile-address" class="block mb-1 w-full"> {{ ___('Address') }} </label>
                                    <input id="profile-address" type="text" name="address" v-model="profileParam.address"
                                           class="w-full block outline-0 rounded-xl bg-white border border-gray-300 duration-500 focus-within:border-[#21306b] h-[45px] px-5"
                                           autocomplete="off"/>
                                </div>
                            </div>
                            <div class="w-full flex justify-start items-center gap-2 text-[14px]">
                                <button type="submit" class="duration-500 bg-[#21306b]/85 text-white hover:bg-[#21306b] hover:text-white max-w-[120px] min-w-[120px] h-[45px] inline-flex justify-center items-center rounded-xl cursor-pointer" v-if="!profileUpdateLoading">
                                    {{ ___('Update') }}
                                </button>
                                <button type="button" disabled class="duration-500 bg-[#21306b]/85 text-white hover:bg-[#21306b] hover:text-white max-w-[120px] min-w-[120px] h-[45px] inline-flex justify-center items-center rounded-xl cursor-pointer" v-if="profileUpdateLoading">
                                <span class="size-[18px] inline-block border-2 border-white border-t-transparent animate-spin rounded-full"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                    <form @submit.prevent="changePassword" class="w-full mb-5 p-7 shadow-gray-300 shadow-inner rounded-2xl">
                        <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-2">
                            <div class="mb-3 block text-[14px] w-full">
                                <label for="profile-current-password" class="block mb-1 w-full">{{ ___('Current Password') }} </label>
                                <input id="profile-current-password" type="password" name="current_password"
                                    v-model="passwordParam.current_password"
                                    class="w-full block outline-0 rounded-xl bg-white border border-gray-300 duration-500 focus-within:border-[#21306b] h-[45px] px-5"
                                    autocomplete="off"/>
                                <div class="mt-1 text-rose-500 text-[13px]" v-if="error?.current_password">
                                    {{ error?.current_password[0] }}
                                </div>
                            </div>
                            <div class="mb-3 block text-[14px] w-full">
                                <label for="profile-new-password" class="block mb-1 w-full"> {{ ___('New Password') }} </label>
                                <input id="profile-new-password" type="password" name="new_password"
                                    v-model="passwordParam.new_password"
                                    class="w-full block outline-0 rounded-xl bg-white border border-gray-300 duration-500 focus-within:border-[#21306b] h-[45px] px-5"
                                    autocomplete="off"/>
                                <div class="mt-1 text-rose-500 text-[13px]" v-if="error?.new_password">
                                    {{ error?.new_password[0] }}
                                </div>
                            </div>
                            <div class="mb-3 block text-[14px] w-full">
                                <label for="profile-new-password-confirmation" class="block mb-1 w-full">
                                    {{ ___('New Confirm Password') }} </label>
                                <input id="profile-new-password-confirmation" type="password" name="new_password_confirmation"
                                    v-model="passwordParam.new_password_confirmation"
                                    class="w-full block outline-0 rounded-xl bg-white border border-gray-300 duration-500 focus-within:border-[#21306b] h-[45px] px-5"
                                    autocomplete="off" />
                                <div class="mt-1 text-rose-500 text-[13px]" v-if="error?.new_password_confirmation">
                                    {{ error?.new_password_confirmation[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="w-full flex justify-start items-center gap-2 text-[14px]">
                            <button type="submit" class="duration-500 bg-[#21306b]/85 text-white hover:bg-[#21306b] hover:text-white max-w-[120px] min-w-[120px] h-[45px] inline-flex justify-center items-center rounded-xl cursor-pointer" v-if="!passwordUpdateLoading">
                                {{ ___('Update') }}
                            </button>
                            <button type="button" disabled class="duration-500 bg-[#21306b]/85 text-white hover:bg-[#21306b] hover:text-white max-w-[120px] min-w-[120px] h-[45px] inline-flex justify-center items-center rounded-xl cursor-pointer" v-if="passwordUpdateLoading">
                                <span class="size-[18px] inline-block border-2 border-white border-t-transparent animate-spin rounded-full"></span>
                            </button>
                        </div>
                    </form>
                </section>
            </div>
        </div>

    </section>

</template>

<script>

import axios from "axios";
import apiServices from "../../../../services/apiServices.js";
import apiRoutes from "../../../../services/apiRoutes.js";
import cookiesServices from "../../../../services/cookiesServices.js";

import {toast} from "vue3-toastify";

export default {
    data() {
        return {
            lang: 'en',
            profileEditModal: false,
            changePasswordModal: false,
            profileData: null,
            profileParam: {
                image: null,
                name: '',
                email: '',
                phone: '',
                address: '',
            },
            passwordParam: {
                current_password: '',
                new_password: '',
                new_password_confirm: '',
            },
            error: {},
            loading: false,
            profileUpdateLoading: false,
            passwordUpdateLoading: false,
            attach_preview: null,
        }
    },
    mounted() {
        this.lang = cookiesServices.get('lang') || "en";
        this.getProfile();
    },
    methods: {
        openEditProfileModal() {
            this.attach_preview = this.profileParam.image;
            this.profileEditModal = true;
        },
        closeEditProfileModal() {
            this.profileEditModal = false;
        },
        openChangePasswordModal() {
            this.changePasswordModal = true;
        },
        closeChangePasswordModal() {
            this.changePasswordModal = false;
        },
        attachFile(event) {
            const file = event.target.files[0];
            this.attach_preview = URL.createObjectURL(file);
            this.profileParam.image = file;
        },
        removeFile() {
            this.attach_preview = null;
            this.profileParam.image = null;
        },
        async getProfile() {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.details, this.profileData, {headers: apiServices.authHeaderContent})
                this.profileData = response.data.user;
                this.profileParam = JSON.parse(JSON.stringify(response.data.user));
            } catch (error) {
                console.log(error)
            } finally {
                this.loading = false;
            }
        },
        async changeDetails() {
            try {
                this.profileUpdateLoading = true;
                const formData = new FormData();
                formData.append('name', this.profileParam.name);
                formData.append('email', this.profileParam.email);
                formData.append('phone', this.profileParam.phone);
                formData.append('address', this.profileParam.address);
                if (this.profileParam.image && typeof this.profileParam.image !== 'string') {
                    formData.append('image', this.profileParam.image);
                }
                await axios.post(apiRoutes.changeDetails, formData, {
                    headers: apiServices.authHeaderMediaContent,
                    params: {_method: 'PUT'}
                });
                await this.getProfile();
                this.closeEditProfileModal();
                toast.success(this.lang === "en" ? "Change details successfully." : "تم تغيير التفاصيل بنجاح.")
            } catch (error) {
                this.error = error?.response?.data?.errors || {};
            } finally {
                this.profileUpdateLoading = false;
            }
        },
        async changePassword() {
            try {
                this.passwordUpdateLoading = true;
                await axios.put(apiRoutes.changePassword, this.passwordParam, {headers: apiServices.authHeaderContent,});
                await this.getProfile();
                this.closeChangePasswordModal();
                toast.success(this.lang === "en" ? "Change password successfully." : "تم تغيير كلمة المرور بنجاح.")
            } catch (error) {
                this.error = error?.response?.data?.errors || {};
            } finally {
                this.passwordUpdateLoading = false;
            }
        },
        shortName(name) {
            if (!name || typeof name !== 'string') return '';
            let parts = name.trim().split(' ');
            if (parts.length < 2) return parts[0][0] || '';
            return parts[0][0] + parts[1][0];
        }
    }
}

</script>
