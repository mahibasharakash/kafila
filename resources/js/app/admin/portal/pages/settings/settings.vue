<template>

    <form @submit.prevent="updateApi()" class="w-full px-3 sm:px-10">

        <!-- Card body title -->
        <div class="text-[25px]"> {{ ___('Settings') }} </div>

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
                <router-link :to="{name:'settings'}" class="decoration-0 text-[#21306b] duration-500 hover:text-[#3B497E] p-2 inline-block">
                    {{___(`Settings`)}}
                </router-link>
            </li>
        </ul>

        <section class="w-full bg-white p-3 shadow-sm rounded-[0.625rem_0.625rem_0_0] h-[calc(100vh-220px)]">

            <div class="w-full overflow-y-auto min-h-[calc(100vh-300px)] h-[calc(100vh-300px)] max-h-[calc(100vh-300px)]">

                <div class="flex justify-end items-center w-full mb-2.5 pe-2">

                    <!-- Clear -->
                    <button type="submit" class="cursor-pointer px-10 h-[45px] text-[14px] font-medium max-w-[120px] min-w-[120px] bg-[#21306b] duration-500 hover:bg-[#3B497E] inline-flex justify-center items-center text-white rounded-[0.625rem]" v-if="!manageLoading">
                        {{ ___('Update') }}
                    </button>
                    <button type="button" class="cursor-pointer px-10 h-[45px] text-[14px] font-medium max-w-[120px] min-w-[120px] bg-[#21306b] duration-500 hover:bg-[#3B497E] inline-flex justify-center items-center text-white rounded-[0.625rem]" v-if="manageLoading">
                        <span class="size-[18px] inline-block border-2 border-white border-t-transparent animate-spin rounded-full"></span>
                    </button>

                </div>

                <template v-if="!singleLoading">

                    <div class="w-full block mb-4">
                        <label for="upload_logo" class="size-[250px] inline-flex justify-center flex-col cursor-pointer items-center border border-gray-300 hover:border-[#3B497E]/20 bg-transparent hover:bg-[#3B497E]/20 rounded-xl duration-500 text-[#3B497E]" v-if="!attach_preview">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                </svg>
                                <span class="mt-3 inline-block text-center"> {{ ___('Upload Logo') }} </span>
                            <input id="upload_logo" type="file" name="upload_logo" hidden="hidden" autocomplete="off" accept="image/*" @change="attachLogoFile($event)"/>
                        </label>
                        <div class="size-[250px] border border-gray-300 rounded-xl overflow-hidden relative p-10" v-if="attach_preview">
                            <img :src="attach_preview" class="w-full h-full object-cover bg-cover" alt="preview_image"/>
                            <div class="absolute inset-0 inline-flex justify-center items-center z-10">
                                <button type="button" class="size-[45px] inline-flex justify-center items-center rounded-full bg-rose-400 duration-500 hover:bg-rose-600 cursor-pointer" @click="removeLogoFile()">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="size-[20px] stroke-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="mt-2 block text-[12px] text-gray-600">
                            {{ ___('* You can apply logo image and logo name. But if you want no i want just upload logo or i want just upload name depend on you.') }}
                        </div>
                    </div>
                    <div class="w-full flex flex-wrap">
                        <div class="w-full xl:w-1/2 pe-2">
                            <div class="w-full block mb-4">
                                <label for="logo_name" class="block w-full mb-1"> {{ ___('Logo Name') }} </label>
                                <input id="logo_name" type="text" v-model="formData.logo_name" name="logo_name" class="w-full border border-gray-300 min-h-[45px] duration-500 focus-within:border-[#3B497E] rounded-xl outline-0 px-5" autocomplete="off"/>
                            </div>
                            <div class="w-full block mb-4">
                                <div class="flex justify-between items-start w-full mb-2">
                                    {{ ___('Working Time') }}
                                    <template v-if="formData.times.length < 2">
                                        <button type="button" class="max-w-[35px] min-w-[35px] size-[35px] min-h-[35px] max-h-[35px] inline-flex justify-center items-center bg-gray-200 duration-500 hover:bg-gray-300 rounded-xl cursor-pointer" @click="addWorkingTime()">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="size-[15px] stroke-gray-700">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75"/>
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                                <div class="mb-2 w-full flex justify-between items-center gap-2" v-for="(each, index) in formData.times" :key="index">
                                    <input type="text" :name="`${each.working_time}_${index}`" v-model="each.working_time" class="w-full border border-gray-300 min-h-[45px] duration-500 focus-within:border-[#3B497E] rounded-xl outline-0 px-5" autocomplete="off"/>
                                    <template v-if="formData.times.length > 1">
                                        <button type="button" class="size-[50px] min-w-[45px] min-h-[45px] max-w-[45px] max-h-[45px] inline-flex justify-center items-center bg-rose-200 duration-500 hover:bg-rose-300 rounded-xl cursor-pointer" @click="deleteWorkingTime(index)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="size-[20px] stroke-rose-700">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <div class="w-full block mb-4">
                                <div class="flex justify-between items-start w-full mb-2">
                                    {{ ___('Phone Number') }}
                                    <template v-if="formData.phone_numbers.length < 2">
                                        <button type="button"
                                                class="max-w-[35px] min-w-[35px] size-[35px] min-h-[35px] max-h-[35px] inline-flex justify-center items-center bg-gray-200 duration-500 hover:bg-gray-300 rounded-xl cursor-pointer"
                                                @click="addPhoneNumber()">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="2" class="size-[15px] stroke-gray-700">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75"/>
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                                <div class="mb-2 w-full flex justify-between items-center gap-2"
                                     v-for="(each, index) in formData.phone_numbers" :key="index">
                                    <input type="text" :name="`${each.phone}_${index}`" v-model="each.phone"
                                           class="w-full border border-gray-300 min-h-[45px] duration-500 focus-within:border-[#3B497E] rounded-xl outline-0 px-5"
                                           autocomplete="off"/>
                                    <template v-if="formData.phone_numbers.length > 1">
                                        <button type="button"
                                                class="size-[50px] min-w-[45px] min-h-[45px] max-w-[45px] max-h-[45px] inline-flex justify-center items-center bg-rose-200 duration-500 hover:bg-rose-300 rounded-xl cursor-pointer"
                                                @click="deletePhoneNumber(index)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="2" class="size-[20px] stroke-rose-700">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <div class="w-full block mb-4">
                                <div class="flex justify-between items-start w-full mb-2">
                                    {{ ___('Email') }}
                                    <template v-if="formData.emails.length < 2">
                                        <button type="button"
                                                class="max-w-[35px] min-w-[35px] size-[35px] min-h-[35px] max-h-[35px] inline-flex justify-center items-center bg-gray-200 duration-500 hover:bg-gray-300 rounded-xl cursor-pointer"
                                                @click="addEmail()">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="2" class="size-[15px] stroke-gray-700">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75"/>
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                                <div class="mb-2 w-full flex justify-between items-center gap-2"
                                     v-for="(each, index) in formData.emails" :key="index">
                                    <input type="email" :name="`${each.email}_${index}`" v-model="each.email"
                                           class="w-full border border-gray-300 min-h-[45px] duration-500 focus-within:border-[#3B497E] rounded-xl outline-0 px-5"
                                           autocomplete="off"/>
                                    <template v-if="formData.emails.length > 1">
                                        <button type="button"
                                                class="size-[50px] min-w-[45px] min-h-[45px] max-w-[45px] max-h-[45px] inline-flex justify-center items-center bg-rose-200 duration-500 hover:bg-rose-300 rounded-xl cursor-pointer"
                                                @click="deleteEmail(index)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="2" class="size-[20px] stroke-rose-700">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <div class="w-full block mb-4">
                                <label for="short_description" class="block w-full mb-1">
                                    {{ ___('Short Description') }} </label>
                                <textarea name="short_description" id="short_description"
                                          v-model="formData.short_description" cols="30" rows="5" autocomplete="off"
                                          class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] px-4 text-[13px] h-auto px-5 py-4"></textarea>
                            </div>

                            <div class="w-full block mb-4">
                                <label for="long_description" class="block w-full mb-1">
                                    {{ ___('Long Description') }} </label>
                                <textarea name="long_description" id="long_description"
                                          v-model="formData.long_description" cols="30" rows="5" autocomplete="off"
                                          class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] px-4 text-[13px] h-auto px-5 py-4"></textarea>
                            </div>

                            <div class="w-full block mb-4">
                                <label for="location" class="block w-full mb-1"> {{ ___(`Address`) }} </label>
                                <textarea name="location" id="location" v-model="formData.location" cols="30" rows="5"
                                          class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] px-4 text-[13px] h-auto px-5 py-4"></textarea>
                            </div>

                            <div class="mb-4 block w-full">

                                <label for="cover_file_path"
                                       class="w-full h-[250px] flex justify-center flex-col cursor-pointer items-center border border-gray-300 hover:border-[#3B497E]/20 bg-transparent hover:bg-[#3B497E]/20 rounded-xl duration-500 text-[#3B497E]"
                                       v-if="!attach_preview_cover_background">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                    </svg>
                                    <span class="mt-3 inline-block text-center"> {{ ___('Upload Cover Background') }} </span>
                                    <input id="cover_file_path" type="file" name="cover_file_path" hidden="hidden"
                                           autocomplete="off" accept="image/*" @change="attachCoverBackground($event)"/>
                                </label>
                                <div class="w-full h-[250px] border border-gray-300 rounded-xl overflow-hidden relative"
                                     v-if="attach_preview_cover_background">
                                    <img :src="attach_preview_cover_background"
                                         class="w-full h-full object-cover bg-cover" alt="preview_image"/>
                                    <div class="absolute inset-0 inline-flex justify-center items-center z-10">
                                        <button type="button"
                                                class="size-[45px] inline-flex justify-center items-center rounded-full bg-rose-400 duration-500 hover:bg-rose-600 cursor-pointer"
                                                @click="removeCoverBackground()">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="2" class="size-[20px] stroke-white">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <div class="mb-4 block w-full">

                                <label for="breadcrumb_file_path"
                                       class="w-full h-[250px] flex justify-center flex-col cursor-pointer items-center border border-gray-300 hover:border-[#3B497E]/20 bg-transparent hover:bg-[#3B497E]/20 rounded-xl duration-500 text-[#3B497E]"
                                       v-if="!attach_preview_breadcrumb_background">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                    </svg>
                                    <span class="mt-3 inline-block text-center"> {{ ___('Upload Breadcrumb Background') }} </span>
                                    <input id="breadcrumb_file_path" type="file" name="breadcrumb_file_path"
                                           hidden="hidden" autocomplete="off" accept="image/*"
                                           @change="attachBreadcrumbBackground($event)"/>
                                </label>
                                <div class="w-full h-[250px] border border-gray-300 rounded-xl overflow-hidden relative"
                                     v-if="attach_preview_breadcrumb_background">
                                    <img :src="attach_preview_breadcrumb_background"
                                         class="w-full h-full object-cover bg-cover" alt="preview_image"/>
                                    <div class="absolute inset-0 inline-flex justify-center items-center z-10">
                                        <button type="button"
                                                class="size-[45px] inline-flex justify-center items-center rounded-full bg-rose-400 duration-500 hover:bg-rose-600 cursor-pointer"
                                                @click="removeBreadcrumbBackground()">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="2" class="size-[20px] stroke-white">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="w-full xl:w-1/2 pe-2">

                            <div class="w-full block mb-4">
                                <div class="flex justify-between items-start w-full mb-2">
                                    {{ ___('Timeline History') }}
                                    <button type="button"
                                            class="max-w-[35px] min-w-[35px] size-[35px] min-h-[35px] max-h-[35px] inline-flex justify-center items-center bg-gray-200 duration-500 hover:bg-gray-300 rounded-xl cursor-pointer"
                                            @click="addTimeLineHistory()">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="2" class="size-[15px] stroke-gray-700">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75"/>
                                        </svg>
                                    </button>
                                </div>
                                <template v-for="(each, index) in formData.timelines" :key="index">
                                    <div class="mb-2 w-full grid-cols-1 grid sm:grid-cols-2 gap-2">
                                        <div>
                                            <input type="text" :name="`${each.year}_${index}`" v-model="each.year"
                                                   class="w-full border border-gray-300 min-h-[45px] duration-500 focus-within:border-[#3B497E] rounded-xl outline-0 px-5"
                                                   autocomplete="off"/>
                                        </div>
                                        <div class="flex justify-between items-center gap-2">
                                            <input type="text" :name="`${each.timeline}_${index}`"
                                                   v-model="each.timeline"
                                                   class="w-full border border-gray-300 min-h-[45px] duration-500 focus-within:border-[#3B497E] rounded-xl outline-0 px-5"
                                                   autocomplete="off"/>
                                            <template v-if="formData.timelines.length > 1">
                                                <button type="button"
                                                        class="size-[50px] min-w-[45px] min-h-[45px] max-w-[45px] max-h-[45px] inline-flex justify-center items-center bg-rose-200 duration-500 hover:bg-rose-300 rounded-xl cursor-pointer"
                                                        @click="deleteTimeLineHistory(index)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke-width="2"
                                                         class="size-[20px] stroke-rose-700">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                                    </svg>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="mb-2 w-full block">
                                        <textarea :name="`${each.short_description}_${index}`"
                                                  v-model="each.short_description"
                                                  class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] px-4 text-[13px] h-auto px-5 py-4"
                                                  cols="30" rows="3"></textarea>
                                    </div>
                                </template>
                            </div>

                        </div>

                    </div>

                    <div class="w-full flex flex-wrap">

                        <div class="mb-4 block w-full lg:w-1/2 pe-2">

                            <label for="upload_slider"
                                   class="w-full h-[250px] inline-flex justify-center flex-col cursor-pointer items-center border border-gray-300 hover:border-[#3B497E]/20 bg-transparent hover:bg-[#3B497E]/20 rounded-xl duration-500 text-[#3B497E]"
                                   v-if="!attach_preview_slider">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                </svg>
                                <span class="inline-block mt-3">
                                {{ ___('Upload Slider Background') }}
                                    </span>
                                <input id="upload_slider" type="file" name="upload_slider" hidden="hidden"
                                       autocomplete="off" accept="image/*" @change="attachSlider($event)"/>
                            </label>
                            <div class="w-full h-[250px] border border-gray-300 rounded-xl overflow-hidden relative"
                                 v-if="attach_preview_slider">
                                <img :src="attach_preview_slider" class="w-full h-full object-cover bg-cover"
                                     alt="preview_image"/>
                                <div class="absolute inset-0 inline-flex justify-center items-center z-10">
                                    <button type="button"
                                            class="size-[45px] inline-flex justify-center items-center rounded-full bg-rose-400 duration-500 hover:bg-rose-600 cursor-pointer"
                                            @click="removeSlider()">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="2" class="size-[20px] stroke-white">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                        </div>

                        <div class="mb-4 block w-full lg:w-1/2 pe-2">

                            <label for="upload_intro_video"
                                   class="w-full h-[250px] flex justify-center flex-col cursor-pointer items-center border border-gray-300 hover:border-[#3B497E]/20 bg-transparent hover:bg-[#3B497E]/20 rounded-xl duration-500 text-[#3B497E]"
                                   v-if="!attach_preview_video">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                </svg>
                                <span class="inline-block mt-3">
                                {{ ___('Upload Introduction Video') }}
                                    </span>
                                <input id="upload_intro_video" type="file" name="upload_intro_video" hidden
                                       autocomplete="off" accept="video/*" @change="attachIntroVideo($event)"/>
                            </label>

                            <div class="w-full h-[250px] border border-gray-300 rounded-xl overflow-hidden relative"
                                 v-if="attach_preview_video">
                                <video :src="attach_preview_video" class="w-full h-full object-cover bg-cover"
                                       controls></video>
                            </div>

                            <div class="mt-3" v-if="attach_preview_video">
                                <button type="button"
                                        class="size-[45px] inline-flex justify-center items-center rounded-full bg-rose-400 duration-500 hover:bg-rose-600 cursor-pointer"
                                        @click="removeVideo()">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="2" class="size-[20px] stroke-white">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                    </svg>
                                </button>
                            </div>

                        </div>

                        <div class="mb-4 block w-full lg:w-1/2 pe-2">
                            <label for="small_title" class="block w-full mb-1"> {{ ___('Slider Small Title') }} </label>
                            <input type="text" name="small_title" v-model="formData.slider_small_title" id="small_title"
                                   class="w-full border border-gray-300 min-h-[45px] duration-500 focus-within:border-[#3B497E] rounded-xl outline-0 px-5"
                                   autocomplete="off" />
                        </div>

                        <div class="mb-4 block w-full lg:w-1/2 pe-2">
                            <label for="text_color_1" class="w-full block mb-1">
                                {{ ___(`Slider Text Color`) }} </label>
                            <div
                                class="w-full overflow-hidden flex items-center gap-2 border border-gray-300 rounded-lg px-5 relative min-h-[45px] max-h-[45px]">
                                <input type="color" name="slider_text_color" v-model="formData.slider_text_color"
                                       id="text_color_1"
                                       class="absolute -top-[6px] -bottom-[6px] -start-[6px] cursor-pointer max-w-[60px] max-h-[60px] m-0 size-[60px] border-0 min-w-[60px] min-h-[60px] outline-0 p-0"
                                       autocomplete="off"/>
                                <span class="ps-[32px] w-full">
                                    <input type="text" name="slider_text_color" v-model="formData.slider_text_color"
                                           id="text_color_2" class="px-5 min-h-[45px] max-h-[45px] outline-0 w-full">
                                </span>
                            </div>
                        </div>
                        <div class="mb-4 block w-full lg:w-1/2 pe-2">
                            <label for="slider_background_opacity" class="w-full block mb-1">
                                {{ ___(`Background Opacity`) }} </label>
                            <div class="w-full min-h-[45px] max-h-[45px] flex justify-start items-center">
                                <div class="inputRange w-full flex justify-start items-center max-w-[340px]">
                                    <input id="slider_background_opacity" type="range" :min="min" :max="max"
                                           v-model="formData.slider_background_opacity" @input="handlePercentage"
                                           class="w-full h-2 rounded-lg appearance-none cursor-pointer transition-all duration-200 bg-gray-200"/>
                                    <output class="block ms-3 text-[#21306b] font-semibold text-end min-w-[30px]">
                                        {{ formData.slider_background_opacity }}
                                    </output>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 block w-full lg:w-1/2 pe-2">
                            <label for="big_title" class="block w-full mb-1"> {{ ___('Slider Big Title') }} </label>
                            <input type="text" name="big_title" v-model="formData.slider_big_title" id="big_title"
                                   class="w-full border border-gray-300 min-h-[45px] duration-500 focus-within:border-[#3B497E] rounded-xl outline-0 px-5"
                                   autocomplete="off"/>
                        </div>

                        <div class="mb-4 block w-full lg:w-1/2 pe-2">
                            <label for="slider_short_description" class="block w-full mb-1">
                                {{ ___('Slider Short Description') }} </label>
                            <textarea name="slider_short_description" v-model="formData.slider_small_short_description"
                                      id="slider_short_description" cols="30" rows="5" autocomplete="off"
                                      class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] px-4 text-[13px] h-auto px-5 py-4"></textarea>
                        </div>

                    </div>

                </template>

                <Loading v-if="singleLoading"></Loading>

            </div>

        </section>

    </form>

</template>

<script>
import axios from "axios";
import apiRoutes from "../../../../services/apiRoutes.js";
import apiServices from "../../../../services/apiServices.js";
import Loading from "../../../../components/preloader.vue";
import cookiesServices from "../../../../services/cookiesServices.js";

import {toast} from "vue3-toastify";

export default {
    components: {
        Loading
    },
    data() {
        return {
            min: 0,
            max: 100,
            formData: {
                id: null,
                logo_file_path: '',
                logo_name: '',
                short_description: '',
                long_description: '',
                location: '',
                times: [
                    {working_time: ''}
                ],
                phone_numbers: [
                    {phone: ''}
                ],
                emails: [
                    {email: ''}
                ],
                timelines: [
                    {
                        year: '',
                        short_description: '',
                        timeline: ''
                    }
                ],
                slider_file_path: '',
                video_file_path: '',
                cover_file_path: '',
                breadcrumb_file_path: '',
                slider_small_title: '',
                slider_text_color: '#000',
                slider_background_opacity: 50,
                slider_big_title: '',
                slider_small_short_description: '',
            },
            attach_preview: null,
            attach_preview_slider: null,
            attach_preview_video: null,
            attach_preview_cover_background: null,
            attach_preview_breadcrumb_background: null,
            manageLoading: false,
            singleLoading: false,
        }
    },
    mounted() {
        this.lang = cookiesServices.get('lang') || "en";
        this.singleApi();
    },
    methods: {
        addWorkingTime() {
            this.formData.times.push({
                working_time: '',
            })
        },
        deleteWorkingTime(index) {
            this.formData.times.splice(index, 1)
        },
        addPhoneNumber() {
            this.formData.phone_numbers.push({
                phone: '',
            })
        },
        deletePhoneNumber(index) {
            this.formData.phone_numbers.splice(index, 1)
        },
        addEmail() {
            this.formData.emails.push({
                email: '',
            })
        },
        deleteEmail(index) {
            this.formData.emails.splice(index, 1)
        },
        addTimeLineHistory() {
            this.formData.timelines.push({
                email: '',
            })
        },
        deleteTimeLineHistory(index) {
            this.formData.timelines.splice(index, 1)
        },
        attachLogoFile(event) {
            const file = event.target.files[0];
            this.attach_preview = URL.createObjectURL(file);
            this.formData.logo_file_path = file;
        },
        attachSlider(event) {
            const file = event.target.files[0];
            this.attach_preview_slider = URL.createObjectURL(file);
            this.formData.slider_file_path = file;
        },
        attachCoverBackground(event) {
            const file = event.target.files[0];
            this.attach_preview_cover_background = URL.createObjectURL(file);
            this.formData.cover_file_path = file;
        },
        attachIntroVideo(event) {
            const file = event.target.files[0];
            this.attach_preview_video = URL.createObjectURL(file);
            this.formData.video_file_path = file;
        },
        attachBreadcrumbBackground(event) {
            const file = event.target.files[0];
            this.attach_preview_breadcrumb_background = URL.createObjectURL(file);
            this.formData.breadcrumb_file_path = file;
        },
        removeLogoFile() {
            this.attach_preview = null;
            this.formData.logo_file_path = null;
        },
        removeSlider() {
            this.attach_preview_slider = null;
            this.formData.slider_file_path = null;
        },
        removeCoverBackground() {
            this.attach_preview_cover_background = null;
            this.formData.cover_file_path = null;
        },
        removeVideo() {
            this.attach_preview_video = null;
            this.formData.video_file_path = null;
        },
        removeBreadcrumbBackground() {
            this.attach_preview_breadcrumb_background = null;
            this.formData.breadcrumb_file_path = null;
        },
        async updateApi() {
            try {
                this.manageLoading = true;
                const formData = new FormData();
                formData.append('logo_name', this.formData.logo_name);
                formData.append('short_description', this.formData.short_description);
                formData.append('long_description', this.formData.long_description);
                formData.append('location', this.formData.location);
                if (this.formData.logo_file_path && typeof this.formData.logo_file_path !== 'string') {
                    formData.append('logo_file_path', this.formData.logo_file_path);
                }
                this.formData.times.forEach((item, index) => {
                    formData.append(`times[${index}][working_time]`, item.working_time);
                });
                this.formData.phone_numbers.forEach((item, index) => {
                    formData.append(`phone_numbers[${index}][phone]`, item.phone);
                });
                this.formData.emails.forEach((item, index) => {
                    formData.append(`emails[${index}][email]`, item.email);
                });
                this.formData.timelines.forEach((item, index) => {
                    formData.append(`timelines[${index}][year]`, item.year);
                    formData.append(`timelines[${index}][timeline]`, item.timeline);
                    formData.append(`timelines[${index}][short_description]`, item.short_description);
                });
                if (this.formData.slider_file_path && typeof this.formData.slider_file_path !== 'string') {
                    formData.append('slider_file_path', this.formData.slider_file_path);
                }
                if (this.formData.video_file_path && typeof this.formData.video_file_path !== 'string') {
                    formData.append('video_file_path', this.formData.video_file_path);
                }
                if (this.formData.cover_file_path && typeof this.formData.cover_file_path !== 'string') {
                    formData.append('cover_file_path', this.formData.cover_file_path);
                }
                if (this.formData.breadcrumb_file_path && typeof this.formData.breadcrumb_file_path !== 'string') {
                    formData.append('breadcrumb_file_path', this.formData.breadcrumb_file_path);
                }
                formData.append('slider_small_title', this.formData.slider_small_title);
                formData.append('slider_text_color', this.formData.slider_text_color);
                formData.append('slider_background_opacity', this.formData.slider_background_opacity);
                formData.append('slider_big_title', this.formData.slider_big_title);
                formData.append('slider_small_short_description', this.formData.slider_small_short_description);
                await axios.post(`${apiRoutes.generalSettings}/1?_method=PUT`, formData, {
                    headers: apiServices.authHeaderMediaContent
                });
                await this.singleApi();
                toast.success(this.lang === "en" ? "General settings updated successfully." : "تم تحديث الإعدادات العامة بنجاح.")
            } catch (error) {
                console.log(error);
            } finally {
                this.manageLoading = false;
            }
        },
        async singleApi() {
            try {
                this.singleLoading = true;
                const response = await axios.get(`${apiRoutes.generalSettings}/1`, {
                    headers: apiServices.authHeaderMediaContent,
                });
                const data = response.data.data;
                this.attach_preview = data.logo_file_path || null;
                this.attach_preview_cover_background = data.cover_file_path || null;
                this.attach_preview_slider = data.slider_file_path || null;
                this.attach_preview_video = data.video_file_path || null;
                this.attach_preview_breadcrumb_background = data.breadcrumb_file_path || null;
                this.formData = {
                    id: data.id || null,
                    logo_name: data.logo_name || '',
                    short_description: data.short_description || '',
                    long_description: data.long_description || '',
                    location: data.location || '',
                    slider_small_title: data.slider_small_title || '',
                    slider_big_title: data.slider_big_title || '',
                    slider_text_color: data.slider_text_color || '',
                    slider_small_short_description: data.slider_small_short_description || '',
                    slider_background_opacity: data.slider_background_opacity || '',
                    times: (data.times || []).map(item => ({
                        working_time: item.working_time || '',
                    })),
                    phone_numbers: (data.phone_numbers || []).map(item => ({
                        phone: item.phone || '',
                    })),
                    emails: (data.emails || []).map(item => ({
                        email: item.email || '',
                    })),
                    timelines: (data.timelines || []).map(item => ({
                        year: item.year || '',
                        timeline: item.timeline || '',
                        short_description: item.short_description || '',
                    })),
                };
            } catch (error) {
                console.error('Error fetching general settings:', error);
            } finally {
                this.singleLoading = false;
            }
        },
        handlePercentage(event) {
            this.formData.slider_background_opacity = Number(event.target.value);
        }
    }
}

</script>

<style scoped>

input[type="range"]::-webkit-slider-thumb {
    appearance: none;
    width: 20px;
    height: 20px;
    background-color: #f47a7a;
    border-radius: 100%;
}

input[type="range"]::-moz-range-thumb {
    width: 1rem;
    height: 1rem;
    background: #f47a7a;
    border-radius: 9999px;
    border: none;
    cursor: pointer;
}
</style>
