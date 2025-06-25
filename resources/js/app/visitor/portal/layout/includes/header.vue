<template>

    <header class="start-0 end-0 top-0 sticky w-full bg-gray-100/45 backdrop-blur-3xl py-2 z-50">
        <div class="w-full mx-auto max-w-[1200px] flex justify-between items-center py-3 px-5 sm:px-10">
            <template v-if="loading">
                <span class="screen-loader"></span>
            </template>
            <router-link :to="{name:'home'}" class="decoration-0 inline-flex w-1/2 xl:w-3/12 justify-start items-center py-1 px-2 text-[25px]" v-if="!loading">
                <span class="md:me-3">
                    <img :src="generalData?.logo_file_path" class="size-[35px]" alt="favicon"/>
                </span>
                <span class="hidden md:inline-block"> {{ generalData?.logo_name }} </span>
            </router-link>
            <ul class="bg-white xl:bg-transparent h-screen xl:h-auto xl:flex justify-center items-center gap-2 top-0 bottom-0 fixed xl:static max-w-[300px] min-w-[300px] xl:max-w-full lg:w-6/12 duration-500 xl:duration-initial z-50"
                :class="{ 'start-[0px]' : isActiveNavbar, '-start-[310px]' : !isActiveNavbar }" @click.stop>
                <li class="xl:hidden">
                    <div class="flex justify-between items-center font-semibold p-5 border-b border-b-gray-200">
                        <div class="text-[21px]">
                            {{ ___(`Menu`) }}
                        </div>
                        <button type="button" class="size-[45px] min-w-[45px] max-w-[45px] min-h-[45px] max-h-[45px] inline-flex justify-center items-center rounded-xl bg-transparent duration-500 hover:bg-gray-200 cursor-pointer" @click="isActiveNavbar = false">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-[25px]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </li>
                <li class="px-5 xl:px-0">
                    <router-link :to="{name:'home'}" class="decoration-0 min-h-[45px] font-medium flex xl:inline-flex justify-start xl:justify-center items-center px-0 xl:px-3 relative before:absolute before:content-[''] before:start-0 hover:before:w-full before:duration-500 before:h-[3px] before:bg-black before:bottom-0" :class="{ 'before:w-0' : $route.name !== 'home', 'before:w-full' : $route.name === 'home' }" @click="isActiveNavbar = false">
                        {{ ___(`Home`) }}
                    </router-link>
                </li>
                <li class="px-5 xl:px-0">
                    <router-link :to="{name:'about'}" class="decoration-0 min-h-[45px] font-medium flex xl:inline-flex justify-start xl:justify-center items-center px-0 xl:px-3 relative before:absolute before:content-[''] before:start-0 hover:before:w-full before:duration-500 before:h-[3px] before:bg-black before:bottom-0" :class="{ 'before:w-0' : $route.name !== 'about', 'before:w-full' : $route.name === 'about' }" @click="isActiveNavbar = false">
                        {{ ___(`About`) }}
                    </router-link>
                </li>
                <li class="px-5 xl:px-0">
                    <router-link :to="{name:'contact'}" class="decoration-0 min-h-[45px] font-medium flex xl:inline-flex justify-start xl:justify-center items-center px-0 xl:px-3 relative before:absolute before:content-[''] before:start-0 hover:before:w-full before:duration-500 before:h-[3px] before:bg-black before:bottom-0" :class="{ 'before:w-0' : $route.name !== 'contact', 'before:w-full' : $route.name === 'contact' }" @click="isActiveNavbar = false">
                        {{ ___(`Contact`) }}
                    </router-link>
                </li>
                <li class="px-5 xl:px-0">
                    <router-link :to="{name:'blogs'}" class="decoration-0 min-h-[45px] font-medium flex xl:inline-flex justify-start xl:justify-center items-center px-0 xl:px-3 relative before:absolute before:content-[''] before:start-0 hover:before:w-full before:duration-500 before:h-[3px] before:bg-black before:bottom-0" :class="{ 'before:w-0' : $route.name !== 'blogs', 'before:w-full' : $route.name === 'blogs' }" @click="isActiveNavbar = false">
                        {{ ___(`Blogs`) }}
                    </router-link>
                </li>
                <li class="px-5 xl:px-0">
                    <router-link :to="{name:'products'}" class="decoration-0 min-h-[45px] font-medium flex xl:inline-flex justify-start xl:justify-center items-center px-0 xl:px-3 relative before:absolute before:content-[''] before:start-0 hover:before:w-full before:duration-500 before:h-[3px] before:bg-black before:bottom-0" :class="{ 'before:w-0' : $route.name !== 'products', 'before:w-full' : $route.name === 'products' }" @click="isActiveNavbar = false">
                        {{ ___(`Products`) }}
                    </router-link>
                </li>
                <li class="px-5 xl:px-0">
                    <router-link :to="{name:'services'}" class="decoration-0 min-h-[45px] font-medium flex xl:inline-flex justify-start xl:justify-center items-center px-0 xl:px-3 relative before:absolute before:content-[''] before:start-0 hover:before:w-full before:duration-500 before:h-[3px] before:bg-black before:bottom-0" :class="{ 'before:w-0' : $route.name !== 'services', 'before:w-full' : $route.name === 'services' }" @click="isActiveNavbar = false">
                        {{ ___(`Services`) }}
                    </router-link>
                </li>
            </ul>
            <ul class="flex justify-end items-center gap-2 w-1/2 xl:w-3/12">
                <li class="xl:hidden">
                    <button type="button" class="cursor-pointer decoration-0 inline-flex justify-center items-center size-[35px] sm:size-[45px] bg-gray-200 duration-500 hover:bg-[#21306b]/10 rounded-full group" @click.stop="navbarToggle()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-[14px] sm:size-[20px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.098 19.902a3.75 3.75 0 0 0 5.304 0l6.401-6.402M6.75 21A3.75 3.75 0 0 1 3 17.25V4.125C3 3.504 3.504 3 4.125 3h5.25c.621 0 1.125.504 1.125 1.125v4.072M6.75 21a3.75 3.75 0 0 0 3.75-3.75V8.197M6.75 21h13.125c.621 0 1.125-.504 1.125-1.125v-5.25c0-.621-.504-1.125-1.125-1.125h-4.072M10.5 8.197l2.88-2.88c.438-.439 1.15-.439 1.59 0l3.712 3.713c.44.44.44 1.152 0 1.59l-2.879 2.88M6.75 17.25h.008v.008H6.75v-.008Z"/>
                        </svg>
                    </button>
                </li>
                <li>
                    <div class="relative" id="userDropdown">
                        <button type="button" class="cursor-pointer decoration-0 inline-flex justify-center items-center size-[35px] sm:size-[45px] bg-gray-200 duration-500 hover:bg-[#21306b]/10 rounded-full group" @click.stop="userDropdown()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="stroke-black duration-500 group-hover:stroke-[#21306b] size-[14px] sm:size-[20px]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                            </svg>
                        </button>
                        <div class="top-auto end-0 w-[210px] absolute mt-2 duration-500 overflow-hidden" :class="{ 'max-h-[1100px]' : isActiveUserDropdown, 'max-h-[0px]' : !isActiveUserDropdown }" @click.stop>
                            <div class="p-3 block w-full bg-white border border-gray-200 rounded-lg drop-shadow-2xl">
                                <div class="font-medium pb-2 px-4 border-b border-b-gray-300 text-[15px]">
                                    {{ ___(`My Account`) }}
                                </div>
                                <template v-if="userInfo === false">
                                    <router-link :to="{name:'login'}" class="cursor-pointer font-medium decoration-0 w-full min-h-[45px] flex justify-start items-center px-4 text-[15px] mt-1 duration-500 hover:text-[#21306b] hover:bg-[#21306b]/10 rounded-lg" :class="{ 'text-black bg-transparent' : $route.name !== 'login', 'text-[#21306b] bg-[#21306b]/10' : $route.name === 'login' }" @click="userDropdown()">
                                        {{ ___(`Sign In`) }}
                                    </router-link>
                                    <router-link :to="{name:'registration'}" class="cursor-pointer font-medium decoration-0 w-full min-h-[45px] flex justify-start items-center px-4 text-[15px] mt-1 duration-500 hover:text-[#21306b] hover:bg-[#21306b]/10 rounded-lg" :class="{ 'text-black bg-transparent' : $route.name !== 'registration', 'text-[#21306b] bg-[#21306b]/10' : $route.name === 'registration' }" @click="userDropdown()">
                                        {{ ___(`Sign Up`) }}
                                    </router-link>
                                </template>
                                <template v-if="userInfo === true">
                                    <router-link :to="{name:'orderHistory'}" class="cursor-pointer font-medium decoration-0 w-full min-h-[45px] flex justify-start items-center px-4 text-[15px] mt-1 duration-500 hover:text-[#21306b] hover:bg-[#21306b]/10 rounded-lg" :class="{ 'text-black bg-transparent' : $route.name !== 'login', 'text-[#21306b] bg-[#21306b]/10' : $route.name === 'login' }" @click="userDropdown()">
                                        {{ ___(`Order History`) }}
                                    </router-link>
                                    <button type="button" class="cursor-pointer font-medium decoration-0 min-h-[45px] w-full flex justify-start items-center px-4 text-[15px] mt-1 duration-500 hover:text-[#21306b] hover:bg-[#21306b]/10 rounded-lg text-black bg-transparent" @click="openModalChangeDetails()">
                                        {{ ___(`Change Details`) }}
                                    </button>
                                    <button type="button" class="cursor-pointer font-medium decoration-0 min-h-[45px] w-full flex justify-start items-center px-4 text-[15px] mt-1 duration-500 hover:text-[#21306b] hover:bg-[#21306b]/10 rounded-lg text-black bg-transparent" @click="openModalChangePassword()">
                                        {{ ___(`Change Password`) }}
                                    </button>
                                    <button type="button" class="cursor-pointer font-medium decoration-0 min-h-[45px] w-full flex justify-start items-center px-4 text-[15px] mt-1 duration-500 hover:text-[#21306b] hover:bg-[#21306b]/10 rounded-lg text-black bg-transparent" @click="logoutApi()" v-if="!logoutLoading">
                                        {{ ___(`Logout`) }}
                                    </button>
                                    <button type="button" class="cursor-pointer font-medium decoration-0 min-h-[45px] w-full flex justify-center items-center px-4 text-[15px] mt-1 duration-500 hover:text-[#21306b] hover:bg-[#21306b]/10 rounded-lg text-black bg-transparent" v-if="logoutLoading">
                                        <span class="inline-block size-[20px] rounded-full border-2 border-[#21306b] border-t-transparent animate-spin"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <button type="button" class="relative cursor-pointer decoration-0 inline-flex justify-center items-center size-[35px] sm:size-[45px] bg-gray-200 duration-500 hover:bg-[#21306b]/10 rounded-full group" @click.stop="cartSidebar()">
                        <span class="absolute pointer-events-none top-[57px]" v-if="products.length !== 0">
                            <span class="w-[65px] h-[45px] bg-black font-bold text-white text-[12px] rounded-lg flex justify-center items-center flex-col">
                                <span class="size-[15px] bg-black rotate-45 -mt-[10px]"></span>
                                <span class="block -mt-[5px] relative"> {{ products.length }} </span>
                                <span class="block -mt-[2px] relative"> {{ ___(`Item`) }} </span>
                            </span>
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="stroke-black duration-500 group-hover:stroke-[#21306b] size-[14px] sm:size-[20px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                        </svg>
                    </button>
                </li>
                <li>
                    <div class="relative" id="languageDropdown">
                        <button type="button" class="cursor-pointer decoration-0 inline-flex justify-center items-center size-[35px] sm:size-[45px] bg-gray-200 duration-500 hover:bg-[#21306b]/10 rounded-full group" @click.stop="languageDropdown()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="stroke-black duration-500 group-hover:stroke-[#21306b] size-[14px] sm:size-[20px]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m10.5 21 5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 0 1 6-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 0 1-3.827-5.802"/>
                            </svg>
                        </button>
                        <div class="top-auto end-0 w-[150px] absolute mt-2 duration-500 overflow-hidden" :class="{ 'max-h-[1100px]' : isActiveLanguageDropdown, 'max-h-[0px]' : !isActiveLanguageDropdown }" @click.stop>
                            <div class="p-3 block w-full bg-white border border-gray-200 rounded-lg drop-shadow-2xl">
                                <button type="button" class="text-start font-semibold mb-1 cursor-pointer w-full decoration-0 py-2 px-5 text-[15px] block duration-500 hover:bg-[#21306b]/10 rounded-lg hover:text-[#21306b]" :class="{ 'bg-[#21306b]/10 text-[#21306b]' : lang === 'en', 'text-black bg-transparent' : lang !== 'en' }" @click="setLang('en')">
                                    English
                                </button>
                                <button type="button" class="text-start font-semibold cursor-pointer w-full decoration-0 py-2 px-5 text-[15px] block duration-500 hover:bg-[#21306b]/10 rounded-lg hover:text-[#21306b]" :class="{ 'bg-[#21306b]/10 text-[#21306b]' : lang === 'ar', 'text-black bg-transparent' : lang !== 'ar' }" @click="setLang('ar')">
                                    {{ ___(`Arabic`) }}
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </header>

    <aside class="z-50 min-w-[360px] max-w-[360px] w-[360px] bg-white drop-shadow-2xl border border-gray-200 fixed top-0 bottom-0 h-screen duration-500" :class="{ 'end-0' : isActiveCartSidebar, '-end-[360px]' : !isActiveCartSidebar }" @click.stop>
        <div class="flex justify-between items-center p-5 border-b border-b-gray-300">
            <div class="text-[25px] font-semibold"> {{ ___(`Cart`) }}</div>
            <button type="button" class="cursor-pointer size-[45px] inline-flex justify-center items-center bg-gray-100 duration-500 hover:bg-gray-600 group rounded-full" @click="cartSidebar()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="stroke-black duration-500 group-hover:stroke-white size-[25px]">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="w-full p-5 overflow-y-auto h-[calc(100vh-172px)]">
            <template v-if="products.length === 0">
                <div class="flex justify-center items-center flex-col h-full">
                    <div class="mb-3 font-semibold text-center">
                        {{ ___(`No Product added`) }}
                        <br/>
                        {{___(`in your cart`)}}
                    </div>
                    <router-link :to="{name:'products'}" class="outline-0 w-full rounded-lg bg-gray-200 duration-500 max-w-[120px] h-[45px] cursor-pointer inline-flex justify-center items-center font-semibold p-0 m-0 hover:bg-[#21306b] text-black hover:text-white" @click="cartSidebar()">
                        {{ ___(`Shopping`) }}
                    </router-link>
                </div>
            </template>
            <template v-if="products.length !== 0">
                <template v-for="(cartItem, index) in products">
                    <div class="flex justify-start items-center p-2">
                        <div class="size-[125px] min-w-[125px] min-h-[125px] relative">
                            <img :src="cartItem.image" class="size-[125px] min-w-[125px] min-h-[95px] object-cover bg-cover" :alt="index"/>
                            <div class="absolute inset-0 w-full h-full flex justify-end items-end p-1">
                                <button type="button" class="min-w-[35px] min-h-[35px] size-[35px] inline-flex justify-center items-center text-white bg-rose-500 rounded-full cursor-pointer" @click="removeFromCart(cartItem)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-[20px]">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="inline-block ps-2">
                            <div class="block font-semibold mb-1">
                                <div class="truncate-to-1-line">
                                    {{ cartItem.title }}
                                </div>
                            </div>
                            <div class="block mb-1 font-semibold">
                                {{ ___(`Price`) }}: ${{ parseFloat(cartItem.price).toFixed(2) }}
                            </div>
                            <div class="block mb-1 font-semibold">
                                {{ ___(`Total`) }}: ${{ parseFloat(cartItem.price * cartItem.quantity).toFixed(2) }}
                            </div>
                            <div class="inline-flex justify-center items-center gap-2">
                                <button type="button" class="inline-flex justify-center items-center size-[35px] min-w-[35px] min-h-[35px] rounded-lg bg-gray-200 duration-500 hover:bg-gray-300 cursor-pointer" @click="decrementQuantity(cartItem)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-[15px]">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/>
                                    </svg>
                                </button>
                                <span
                                    class="min-w-[35px] min-h-[35px] size-[35px] inline-flex justify-center items-center bg-gray-200 rounded-lg pointer-events-none">
                                    {{ cartItem.quantity }}
                                </span>
                                <button type="button" class="inline-flex justify-center items-center size-[35px] min-w-[35px] min-h-[35px] rounded-lg bg-gray-200 duration-500 hover:bg-gray-300 cursor-pointer" @click="incrementQuantity(cartItem)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-[15px]">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </template>
        </div>
        <div class="p-5 flex justify-between items-center gap-3">
            <button type="button" class="outline-0 w-full rounded-lg bg-gray-200 duration-500 h-[50px] cursor-pointer flex justify-center items-center hover:bg-[#21306b] text-black hover:text-white" @click="clearCart()">
                {{ ___(`Clear`) }}
            </button>
            <router-link :to="{name:'checkout'}" class="outline-0 w-full rounded-lg bg-gray-200 duration-500 h-[50px] cursor-pointer flex justify-center items-center hover:bg-[#21306b] text-black hover:text-white" @click="cartSidebar()">
                {{ ___(`Checkout`) }}
            </router-link>
        </div>
    </aside>

    <!-- change details modal -->
    <section class="fixed inset-0 size-full grid sm:justify-center items-center duration-500 z-50 p-5 overflow-y-auto" :class="{ 'invisible bg-black/35' : !isActiveChangeDetailsModal, 'visible bg-black/65' : isActiveChangeDetailsModal }" @click="isActiveChangeDetailsModal = false">
        <aside class="bg-white rounded-3xl w-full sm:max-w-[550px] sm:min-w-[550px] p-10 duration-500 origin-top" :class="{ 'translate-y-0 opacity-100' : isActiveChangeDetailsModal, '-translate-y-1/2 opacity-0' : !isActiveChangeDetailsModal }" @click.stop>
            <form @submit.prevent="changeDetails()" class="w-full h-full block">
                <div class="text-[20px] font-semibold block mb-3"> {{ ___(`Edit Profile`) }} </div>
                <div class="flex justify-center mb-5 w-full">
                    <template v-if="!attach_preview">
                        <label for="upload" class="w-full max-w-[250px] max-h-[250px] min-h-[250px] rounded-full bg-[#21306b]/25 duration-500 hover:bg-[#21306b]/95 group cursor-pointer flex justify-center items-center">
                            <input id="upload" type="file" name="image" accept="image/*" hidden="hidden" autocomplete="off" @change="attachFile($event)"/>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="size-[45px] stroke-[#21306b] duration-500 group-hover:stroke-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                                </svg>
                            </span>
                        </label>
                    </template>
                    <template v-if="attach_preview">
                        <div class="relative w-full flex justify-center items-center">
                            <img :src="attach_preview" class="w-full max-w-[250px] min-w-[250px] max-h-[250px] min-h-[250px] rounded-full object-cover bg-cover" alt="attach_file"/>
                            <div class="absolute inset-0 w-full h-full flex justify-center items-center">
                                <div class="max-w-[250px] min-w-[250px] max-h-[250px] min-h-[250px] flex justify-center items-center rounded-full bg-transparent duration-500 hover:bg-gray-200/25 backdrop-blur-none hover:backdrop-blur-sm">
                                    <button type="button" class="size-[45px] inline-flex justify-center items-center rounded-xl bg-rose-400 duration-500 hover:bg-rose-700 cursor-pointer" @click="removeFile()">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="size-6 stroke-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="block w-full mb-3">
                    <label for="edit-name" class="block mb-1 font-semibold w-full"> {{ ___(`Name`) }} </label>
                    <input id="edit-name" type="text" name="name" v-model="formData.name" class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]" autocomplete="off"/>
                    <div class="mt-1 text-red-500 font-medium text-[13px]" v-if="detailsError?.name"> {{ detailsError.name[0] }} </div>
                </div>
                <div class="block w-full mb-3">
                    <label for="edit-email" class="block mb-1 font-semibold w-full">
                        {{ ___(`Email`) }}
                    </label>
                    <input id="edit-email" type="email" name="email" v-model="formData.email" class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]" autocomplete="off"/>
                    <div class="mt-1 text-red-500 font-medium text-[13px]" v-if="detailsError?.email"> {{ detailsError.email[0] }} </div>
                </div>
                <div class="block w-full mb-3">
                    <label for="edit-phone-number" class="block mb-1 font-semibold w-full"> {{ ___(`Phone Number`) }} </label>
                    <input id="edit-phone-number" type="text" name="phone" v-model="formData.phone" class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]" autocomplete="off"/>
                    <div class="mt-1 text-red-500 font-medium text-[13px]" v-if="detailsError?.phone"> {{ detailsError.phone[0] }} </div>
                </div>
                <div class="block w-full mb-3">
                    <label for="address" class="block mb-1 font-semibold w-full"> {{ ___(`Address`) }} </label>
                    <input id="address" type="text" name="address" v-model="formData.address" class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]" autocomplete="off"/>
                    <div class="mt-1 text-red-500 font-medium text-[13px]" v-if="detailsError?.address"> {{ detailsError.address[0] }} </div>
                </div>
                <div class="flex justify-end items-center gap-2 w-full">
                    <button type="button" class="duration-500 bg-gray-100 text-gray-800 hover:bg-gray-600 hover:text-white max-w-[120px] min-w-[120px] h-[45px] inline-flex justify-center items-center rounded-xl cursor-pointer font-semibold" @click="closeModalChangeDetails()">
                        Cancel
                    </button>
                    <button type="submit" v-if="!profileUpdateLoading" class="max-w-[120px] min-w-[120px] h-[45px] btn-theme rounded-xl font-semibold">
                        {{ ___(`Update`) }}
                    </button>
                    <button type="button" v-if="profileUpdateLoading" class="max-w-[120px] min-w-[120px] h-[45px] btn-theme rounded-xl font-semibold">
                        <span class="inline-block animate-spin size-[20px] rounded-full border-2 border-white border-t-transparent"></span>
                    </button>
                </div>
            </form>
        </aside>
    </section>

    <!-- change password modal -->
    <section class="fixed inset-0 size-full grid sm:justify-center items-center duration-500 z-50 p-5 overflow-y-auto" :class="{ 'invisible bg-black/35' : !isActiveChangePasswordModal, 'visible bg-black/65' : isActiveChangePasswordModal }" @click="isActiveChangePasswordModal = false">
        <aside class="bg-white rounded-3xl w-full sm:max-w-[550px] sm:min-w-[550px] p-10 duration-500 origin-top" :class="{ 'translate-y-0 opacity-100' : isActiveChangePasswordModal, '-translate-y-1/2 opacity-0' : !isActiveChangePasswordModal }" @click.stop>
            <form @submit.prevent="changePassword()" class="w-full h-full block">
                <div class="text-[20px] font-semibold block mb-3"> {{ ___(`Change Password`) }} </div>
                <div class="block w-full mb-3">
                    <label for="change-current-password" class="block mb-1 font-semibold w-full"> {{ ___(`Current Password`) }} </label>
                    <input id="change-current-password" type="password" name="current_password" v-model="passwordData.current_password" class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]" autocomplete="off"/>
                    <div class="mt-1 text-red-500 font-medium text-[13px]" v-if="passwordError?.current_password"> {{ passwordError.current_password[0] }} </div>
                </div>
                <div class="block w-full mb-3">
                    <label for="change-new-password" class="block mb-1 font-semibold w-full"> {{ ___(`New Password`) }} </label>
                    <input id="change-new-password" type="password" name="new_password" v-model="passwordData.new_password" class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]" autocomplete="off"/>
                    <div class="mt-1 text-red-500 font-medium text-[13px]" v-if="passwordError?.new_password"> {{ passwordError.new_password[0] }} </div>
                </div>
                <div class="block w-full mb-3">
                    <label for="change-new-password-confirm" class="block mb-1 font-semibold w-full"> {{ ___(`Confirm New Password`) }} </label>
                    <input id="change-new-password-confirm" type="password" name="new_password_confirmation" v-model="passwordData.new_password_confirmation" class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]" autocomplete="off"/>
                    <div class="mt-1 text-red-500 font-medium text-[13px]" v-if="passwordError?.new_password_confirmation"> {{ passwordError.new_password_confirmation[0] }} </div>
                </div>
                <div class="flex justify-end items-center gap-2 w-full">
                    <button type="button" class="duration-500 bg-gray-100 text-gray-800 hover:bg-gray-600 hover:text-white max-w-[120px] min-w-[120px] h-[45px] inline-flex justify-center items-center rounded-xl cursor-pointer font-semibold" @click="closeModalChangePassword()">
                        Cancel
                    </button>
                    <button type="submit" v-if="!passwordUpdateLoading" class="max-w-[120px] min-w-[120px] h-[45px] btn-theme font-semibold">
                        {{ ___(`Update`) }}
                    </button>
                    <button type="button" v-if="passwordUpdateLoading" class="max-w-[120px] min-w-[120px] h-[45px] btn-theme font-semibold">
                        <span class="inline-block animate-spin size-[20px] rounded-full border-2 border-white border-t-transparent"></span>
                    </button>
                </div>
            </form>
        </aside>
    </section>

</template>

<script>

import axios from "axios";
import apiRoutes from "../../../../services/apiRoutes.js";
import apiServices from "../../../../services/apiServices.js";
import store from "../../../../store/index.js";
import cookiesServices from "../../../../services/cookiesServices.js";

export default {
    computed: {
        products: function () {
            return store.state.products;
        }
    },
    data() {
        return {
            isActiveUserDropdown: false,
            isActiveLanguageDropdown: false,
            isActiveCartSidebar: false,
            isActiveSearchDropdown: false,
            isActiveNavbar: false,
            getCustomerLoading: false,
            logoutLoading: false,
            lang: 'en',
            userInfo: false,
            keyword: null,
            loading: false,
            generalData: null,
            cartItems: [],
            profileData: null,
            user: cookiesServices.get('user_type'),
            isActiveChangeDetailsModal: false,
            isActiveChangePasswordModal: false,
            formData: {
                image: null,
                name: '',
                email: '',
                phone: '',
                address: '',
            },
            passwordData: {
                current_password: '',
                new_password: '',
                new_password_confirmation: '',
            },
            changeLoading: false,
            changePasswordLoading: false,
            detailsError: {},
            passwordError: {},
            profileUpdateLoading: false,
            passwordUpdateLoading: false,
            attach_preview: null,
        }
    },
    mounted() {
        this.lang = cookiesServices.get('lang') || "en";
        window.addEventListener('click', (event) => this.handleUserDropdownClose(event));
        window.addEventListener('click', (event) => this.handleLanguageDropdownClose(event));
        window.addEventListener('click', (event) => this.handleCartSidebarClose(event));
        window.addEventListener('click', (event) => this.handleSearchDropdownClose(event));
        window.addEventListener('click', (event) => this.handleNavbarClose(event));
        this.generalApi();
        this.getCartItems();
        this.userInfo = this.user === 'Customer';
        if(this.user === 'Customer') {
            this.getCustomer();
        }
    },
    beforeUnmount() {
        window.removeEventListener('click', this.handleUserDropdownClose);
        window.removeEventListener('click', this.handleLanguageDropdownClose);
        window.removeEventListener('click', this.handleCartSidebarClose);
        window.removeEventListener('click', this.handleSearchDropdownClose);
        window.removeEventListener('click', this.handleNavbarClose);
    },
    methods: {
        getCartItems() {
            store.dispatch('getCartItems')
        },
        decrementQuantity(cartItem) {
            if (cartItem.quantity > 1) {
                cartItem.quantity--;
                store.dispatch('decrementCartItem', cartItem)
            }
        },
        incrementQuantity(cartItem) {
            if (cartItem.quantity < 5) {
                cartItem.quantity++;
                store.dispatch('addToCart', cartItem)
            }
        },
        removeFromCart(cartItem) {
            store.dispatch('removeFromCart', cartItem)
        },
        clearCart() {
            store.dispatch('clearCart');
        },
        userDropdown() {
            if (this.isActiveLanguageDropdown) {
                this.isActiveLanguageDropdown = false;
            }
            if (this.isActiveCartSidebar) {
                this.isActiveCartSidebar = false;
            }
            if (this.isActiveSearchDropdown) {
                this.isActiveSearchDropdown = false;
            }
            this.isActiveUserDropdown = !this.isActiveUserDropdown;
        },
        handleUserDropdownClose(event) {
            if (this.isActiveUserDropdown) {
                this.isActiveUserDropdown = false;
            }
        },
        languageDropdown() {
            if (this.isActiveUserDropdown) {
                this.isActiveUserDropdown = false;
            }
            if (this.isActiveCartSidebar) {
                this.isActiveCartSidebar = false;
            }
            if (this.isActiveSearchDropdown) {
                this.isActiveSearchDropdown = false;
            }
            this.isActiveLanguageDropdown = !this.isActiveLanguageDropdown;
        },
        handleLanguageDropdownClose(event) {
            if (this.isActiveLanguageDropdown) {
                this.isActiveLanguageDropdown = false;
            }
        },
        cartSidebar() {
            if (this.isActiveLanguageDropdown) {
                this.isActiveLanguageDropdown = false;
            }
            if (this.isActiveUserDropdown) {
                this.isActiveUserDropdown = false;
            }
            if (this.isActiveSearchDropdown) {
                this.isActiveSearchDropdown = false;
            }
            this.isActiveCartSidebar = !this.isActiveCartSidebar;
        },
        handleCartSidebarClose() {
            if (this.isActiveCartSidebar) {
                this.isActiveCartSidebar = false;
            }
        },
        setLang(language) {
            cookiesServices.set('lang', language);
            window.location.reload();
            this.isActiveLanguageDropdown = false;
        },
        searchDropdown() {
            if (this.isActiveLanguageDropdown) {
                this.isActiveLanguageDropdown = false;
            }
            if (this.isActiveUserDropdown) {
                this.isActiveUserDropdown = false;
            }
            if (this.isActiveCartSidebar) {
                this.isActiveCartSidebar = false;
            }
            this.isActiveSearchDropdown = !this.isActiveSearchDropdown;
        },
        handleSearchDropdownClose() {
            if (this.isActiveSearchDropdown) {
                this.isActiveSearchDropdown = false;
            }
        },
        searchData() {
            this.$router.push({name: 'products', params: {keyword: this.keyword}})
        },
        navbarToggle() {
            if (this.isActiveLanguageDropdown) {
                this.isActiveLanguageDropdown = false;
            }
            if (this.isActiveUserDropdown) {
                this.isActiveUserDropdown = false;
            }
            if (this.isActiveCartSidebar) {
                this.isActiveCartSidebar = false;
            }
            if (this.isActiveSearchDropdown) {
                this.isActiveSearchDropdown = false;
            }
            this.isActiveNavbar = !this.isActiveNavbar;
        },
        handleNavbarClose() {
            if (this.isActiveNavbar) {
                this.isActiveNavbar = false;
            }
        },
        async logoutApi() {
            this.logoutLoading = true;
            try {
                await axios.post(apiRoutes.logout, null, {headers: apiServices.authHeaderContent()});
                cookiesServices.remove('access_token');
                cookiesServices.remove('user_type');
                this.userInfo = false;
                this.$router.push({name: 'login'});
                window.location.reload();
            } catch (error) {
                if (error?.response && error?.response?.status === 401) {
                    cookiesServices.remove('access_token');
                    this.$router.push({name: 'login'});
                } else {
                    this.error = error?.response?.data?.message || "An error occurred during logout";
                }
            } finally {
                this.logoutLoading = false;
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
        openModalChangeDetails() {
            this.detailsError = {};
            this.isActiveChangeDetailsModal = true;
        },
        closeModalChangeDetails() {
            this.detailsError = {};
            this.isActiveChangeDetailsModal = false;
        },
        openModalChangePassword() {
            this.passwordError = {};
            this.isActiveChangePasswordModal = true;
        },
        closeModalChangePassword() {
            this.passwordError = {};
            this.isActiveChangePasswordModal = false;
        },
        attachFile(event) {
            const file = event.target.files[0];
            this.attach_preview = URL.createObjectURL(file);
            this.formData.image = file;
        },
        removeFile() {
            this.attach_preview = null;
            this.formData.image = null;
        },
        async changeDetails() {
            try {
                this.profileUpdateLoading = true;
                const formData = new FormData();
                formData.append('name', this.formData.name || '');
                formData.append('email', this.formData.email || '');
                formData.append('phone', this.formData.phone || '');
                formData.append('address', this.formData.address || '');
                if (this.formData.image && typeof this.formData.image !== 'string') {
                    formData.append('image', this.formData.image);
                }
                await axios.post(apiRoutes.changeDetails, formData, {headers: apiServices.authHeaderMediaContent, params: {_method: 'PUT'}});
                this.closeModalChangeDetails();
                await this.getCustomer();
            } catch (error) {
                this.detailsError = error?.response?.data?.errors || {};
            } finally {
                this.profileUpdateLoading = false;
            }
        },
        async changePassword() {
            try {
                this.passwordUpdateLoading = true;
                await axios.put(apiRoutes.changePassword, this.passwordData, {headers: apiServices.authHeaderContent});
                this.closeModalChangePassword();
                await this.getCustomer();
            } catch (error) {
                this.passwordError = error?.response?.data?.errors || {};
            } finally {
                this.passwordUpdateLoading = false;
            }
        },
        async getCustomer() {
            try {
                this.getCustomerLoading = true;
                const response = await axios.get(apiRoutes.details, {headers: apiServices.authHeaderContent});
                this.formData = response?.data?.user
                this.attach_preview = response?.data?.user.image
            } catch (error) {
                console.log(error);
            } finally {
                this.getCustomerLoading = false;
            }
        },
    }
}

</script>
