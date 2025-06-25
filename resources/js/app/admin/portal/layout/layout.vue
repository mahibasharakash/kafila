<template>

    <section class="w-full flex items-start bg-[#f3f3f3]">

        <!-- sidebar -->
        <nav id="sidebar" class="fixed top-0 bottom-0 lg:static max-w-full sm:max-w-[240px] min-w-full sm:min-w-[240px] h-screen bg-[#21306b] overflow-y-auto duration-500 z-50" :class="{ 'start-[0px]' : isActiveSidebar, '-start-[110%] sm:-start-[350px]' : !isActiveSidebar }" @click.stop>
            <div class="w-full flex justify-between lg:justify-center items-center h-[95px]">
                <router-link :to="{name:'dashboard'}" class="decoration-0 text-white text-[25px]" @click="sidebarToggle()">
                    {{ ___('Admin Panel') }}
                </router-link>
                <div class="lg:hidden">
                    <button type="button"
                            class="size-[45px] rounded-full bg-transparent duration-500 hover:bg-white/25 inline-flex justify-center items-center cursor-pointer"
                            @click="sidebarToggle()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                             class="size-[25px] stroke-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="pe-3 w-full block">

                <router-link :to="{name:'dashboard'}"
                             class="flex justify-start items-center w-full px-5 py-2 mb-1 rounded-e-[0.625rem] duration-500 hover:opacity-100 font-medium"
                             :class="{ 'text-[#abb8e6]/50' : $route.name !== 'dashboard', 'text-white' : $route.name === 'dashboard' }"
                             @click="sidebarToggle()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                         stroke="currentColor" class="size-[20px]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z"/>
                    </svg>
                    <span class="ms-3">
                        {{ ___('Dashboard') }}
                    </span>
                </router-link>
                <router-link :to="{name:'boxes'}"
                             class="flex justify-start items-center w-full px-5 py-2 mb-1 rounded-e-[0.625rem] duration-500 hover:opacity-100 font-medium"
                             :class="{ 'text-[#abb8e6]/50' : $route.name !== 'boxes', 'text-white' : $route.name === 'boxes' }"
                             @click="sidebarToggle()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-[20px]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m7.875 14.25 1.214 1.942a2.25 2.25 0 0 0 1.908 1.058h2.006c.776 0 1.497-.4 1.908-1.058l1.214-1.942M2.41 9h4.636a2.25 2.25 0 0 1 1.872 1.002l.164.246a2.25 2.25 0 0 0 1.872 1.002h2.092a2.25 2.25 0 0 0 1.872-1.002l.164-.246A2.25 2.25 0 0 1 16.954 9h4.636M2.41 9a2.25 2.25 0 0 0-.16.832V12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 12V9.832c0-.287-.055-.57-.16-.832M2.41 9a2.25 2.25 0 0 1 .382-.632l3.285-3.832a2.25 2.25 0 0 1 1.708-.786h8.43c.657 0 1.281.287 1.709.786l3.284 3.832c.163.19.291.404.382.632M4.5 20.25h15A2.25 2.25 0 0 0 21.75 18v-2.625c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125V18a2.25 2.25 0 0 0 2.25 2.25Z"/>
                    </svg>
                    <span class="ms-3">
                        {{ ___('Boxes') }}
                    </span>
                </router-link>
                <router-link :to="{name:'categories'}"
                             class="flex justify-start items-center w-full px-5 py-2 mb-1 rounded-e-[0.625rem] duration-500 hover:opacity-100 font-medium"
                             :class="{ 'text-[#abb8e6]/50' : $route.name !== 'categories', 'text-white' : $route.name === 'categories' }"
                             @click="sidebarToggle()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                         stroke="currentColor" class="size-[20px]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z"/>
                    </svg>
                    <span class="ms-3">
                        {{ ___('Categories') }}
                    </span>
                </router-link>
                <router-link :to="{name:'brands'}"
                             class="flex justify-start items-center w-full px-5 py-2 mb-1 rounded-e-[0.625rem] duration-500 hover:opacity-100 font-medium"
                             :class="{ 'text-[#abb8e6]/50' : $route.name !== 'brands', 'text-white' : $route.name === 'brands' }"
                             @click="sidebarToggle()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-[20px]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m21 7.5-2.25-1.313M21 7.5v2.25m0-2.25-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3 2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75 2.25-1.313M12 21.75V19.5m0 2.25-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25"/>
                    </svg>
                    <span class="ms-3">
                        {{ ___('Brands') }}
                    </span>
                </router-link>
                <router-link :to="{name:'contacts'}"
                             class="flex justify-start items-center w-full px-5 py-2 mb-1 rounded-e-[0.625rem] duration-500 hover:opacity-100 font-medium"
                             :class="{ 'text-[#abb8e6]/50' : $route.name !== 'contacts', 'text-white' : $route.name === 'contacts' }"
                             @click="sidebarToggle()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-[20px]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/>
                    </svg>
                    <span class="ms-3">
                        {{ ___('Contacts') }}
                    </span>
                </router-link>
                <router-link :to="{name:'products'}"
                             class="flex justify-start items-center w-full px-5 py-2 mb-1 rounded-e-[0.625rem] duration-500 hover:opacity-100 font-medium"
                             :class="{ 'text-[#abb8e6]/50' : $route.name !== 'products', 'text-white' : $route.name === 'products' }"
                             @click="sidebarToggle()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-[20px]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                    </svg>
                    <span class="ms-3">
                        {{ ___('Products') }}
                    </span>
                </router-link>
                <router-link :to="{name:'blogs'}"
                             class="flex justify-start items-center w-full px-5 py-2 mb-1 rounded-e-[0.625rem] duration-500 hover:opacity-100 font-medium"
                             :class="{ 'text-[#abb8e6]/50' : $route.name !== 'blogs', 'text-white' : $route.name === 'blogs' }"
                             @click="sidebarToggle()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-[20px]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z"/>
                    </svg>
                    <span class="ms-3">
                        {{ ___('Blogs') }}
                    </span>
                </router-link>
                <router-link :to="{name:'services'}"
                             class="flex justify-start items-center w-full px-5 py-2 mb-1 rounded-e-[0.625rem] duration-500 hover:opacity-100 font-medium"
                             :class="{ 'text-[#abb8e6]/50' : $route.name !== 'services', 'text-white' : $route.name === 'services' }"
                             @click="sidebarToggle()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-[20px]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z"/>
                    </svg>
                    <span class="ms-3">
                        {{ ___('Services') }}
                    </span>
                </router-link>
                <router-link :to="{name:'testimonials'}"
                             class="flex justify-start items-center w-full px-5 py-2 mb-1 rounded-e-[0.625rem] duration-500 hover:opacity-100 font-medium"
                             :class="{ 'text-[#abb8e6]/50' : $route.name !== 'testimonials', 'text-white' : $route.name === 'testimonials' }"
                             @click="sidebarToggle()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-[20px]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>
                    </svg>
                    <span class="ms-3">
                        {{ ___('Testimonials') }}
                    </span>
                </router-link>
                <router-link :to="{name:'reviews'}"
                             class="flex justify-start items-center w-full px-5 py-2 mb-1 rounded-e-[0.625rem] duration-500 hover:opacity-100 font-medium"
                             :class="{ 'text-[#abb8e6]/50' : $route.name !== 'reviews', 'text-white' : $route.name === 'reviews' }"
                             @click="sidebarToggle()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-[20px]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M7.5 3.75H6A2.25 2.25 0 0 0 3.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0 1 20.25 6v1.5m0 9V18A2.25 2.25 0 0 1 18 20.25h-1.5m-9 0H6A2.25 2.25 0 0 1 3.75 18v-1.5M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                    <span class="ms-3">
                        {{ ___('Reviews') }}
                    </span>
                </router-link>
                <router-link :to="{name:'customers'}" class="flex justify-start items-center w-full px-5 py-2 mb-1 rounded-e-[0.625rem] duration-500 hover:opacity-100 font-medium" :class="{ 'text-[#abb8e6]/50' : $route.name !== 'customers', 'text-white' : $route.name === 'customers' }" @click="sidebarToggle()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-[20px]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <span class="ms-3">
                        {{ ___('Customers') }}
                    </span>
                </router-link>
                <router-link :to="{name:'orders'}"
                             class="flex justify-start items-center w-full px-5 py-2 mb-1 rounded-e-[0.625rem] duration-500 hover:opacity-100 font-medium"
                             :class="{ 'text-[#abb8e6]/50' : $route.name !== 'orders', 'text-white' : $route.name === 'orders' }"
                             @click="sidebarToggle()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-[20px]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                    </svg>
                    <span class="ms-3">
                        {{ ___('Orders') }}
                    </span>
                </router-link>
                <router-link :to="{name:'translations'}"
                             class="flex justify-start items-center w-full px-5 py-2 mb-1 rounded-e-[0.625rem] duration-500 hover:opacity-100 font-medium"
                             :class="{ 'text-[#abb8e6]/50' : $route.name !== 'translations', 'text-white' : $route.name === 'translations' }"
                             @click="sidebarToggle()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-[20px]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m10.5 21 5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 0 1 6-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 0 1-3.827-5.802"/>
                    </svg>
                    <span class="ms-3">
                        {{ ___('Translations') }}
                    </span>
                </router-link>
            </div>
        </nav>

        <!-- content -->
        <aside class="min-w-full lg:min-w-[calc(100%-240px)] overflow-y-auto">

            <!-- header -->
            <header class="w-full flex justify-between items-center h-[95px] px-3 sm:px-10">

                <!-- sidebar toggle -->
                <div class="visible lg:invisible">
                    <button type="button"
                            class="size-[45px] inline-flex justify-center items-center bg-white rounded-full cursor-pointer"
                            @click.stop="sidebarToggle()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="size-[20px]">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75"/>
                        </svg>
                    </button>
                </div>

                <!-- language dropdown and user dropdown -->
                <div class="flex justify-end items-center gap-2">

                    <button type="button"
                            class="size-[45px] inline-flex justify-center items-center bg-white rounded-full cursor-pointer"
                            @click="toggleFullscreen()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-[20px]" viewBox="0 0 24 24"
                             v-if="fullScreen">
                            <path color="currentColor" fill="none" stroke="currentColor" stroke-linecap="round"
                                  stroke-linejoin="round" stroke-width="1.5"
                                  d="m12.567 7.934l2.742.1c.407.015.73.35.73.758v2.615m-5.5 2.027l5.044-5.018M2 17c0-1.886 0-2.828.586-3.414S4.114 13 6 13h1c1.886 0 2.828 0 3.414.586S11 15.114 11 17v1c0 1.886 0 2.828-.586 3.414S8.886 22 7 22H6c-1.886 0-2.828 0-3.414-.586S2 19.886 2 18zm0-8.5v2M14 2h-4m12 12v-4m-8.5 12h2M2.06 5.5c.154-1.066.453-1.821 1.036-2.404S4.434 2.214 5.5 2.06m13 0c1.066.154 1.821.453 2.404 1.036c.582.583.882 1.338 1.036 2.404m0 13c-.154 1.066-.454 1.821-1.036 2.404c-.583.582-1.338.882-2.404 1.036"></path>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-[20px]" viewBox="0 0 24 24"
                             v-if="!fullScreen">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                               stroke-width="1.5" color="currentColor">
                                <path
                                    d="M2 10.002c.029-3.414.218-5.296 1.46-6.537C4.924 2 7.282 2 11.997 2s7.073 0 8.538 1.465S22 7.287 22 12.003c0 4.715 0 7.073-1.465 8.537c-1.241 1.242-3.123 1.431-6.537 1.46"></path>
                                <path
                                    d="M4.999 13c-1.17.035-1.868.165-2.351.648s-.613 1.18-.648 2.35M8.001 13c1.17.035 1.868.165 2.351.648s.613 1.18.648 2.35m0 3.003c-.035 1.17-.165 1.868-.648 2.351s-1.18.613-2.35.648m-3.003 0c-1.17-.035-1.868-.165-2.351-.648s-.613-1.18-.648-2.35m14.413-7.996l-2.903-.066c-.432-.01-.777-.345-.782-.757l-.031-2.644m7.331-3.773l-6.747 6.601"></path>
                            </g>
                        </svg>
                    </button>

                    <!-- language dropdown -->
                    <div class="relative" id="languageDropdown">
                        <button type="button"
                                class="size-[45px] inline-flex justify-center items-center bg-white rounded-full cursor-pointer"
                                @click.stop="languageDropdown()">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-[20px]">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M20.58 19.37L17.59 11.01C17.38 10.46 16.91 10.12 16.37 10.12C15.83 10.12 15.37 10.46 15.14 11.03L12.16 19.37C12.02 19.76 12.22 20.19 12.61 20.33C13 20.47 13.43 20.27 13.57 19.88L14.19 18.15H18.54L19.16 19.88C19.27 20.19 19.56 20.38 19.87 20.38C19.95 20.38 20.04 20.37 20.12 20.34C20.51 20.2 20.71 19.77 20.57 19.38L20.58 19.37ZM14.74 16.64L16.38 12.05L18.02 16.64H14.74ZM12.19 7.85C9.92999 11.42 7.89 13.58 5.41 15.02C5.29 15.09 5.16 15.12 5.04 15.12C4.78 15.12 4.53 14.99 4.39 14.75C4.18 14.39 4.3 13.93 4.66 13.73C6.75999 12.51 8.48 10.76 10.41 7.86H4.12C3.71 7.86 3.37 7.52 3.37 7.11C3.37 6.7 3.71 6.36 4.12 6.36H7.87V4.38C7.87 3.97 8.21 3.63 8.62 3.63C9.02999 3.63 9.37 3.97 9.37 4.38V6.36H13.12C13.53 6.36 13.87 6.7 13.87 7.11C13.87 7.52 13.53 7.86 13.12 7.86H12.18L12.19 7.85ZM12.23 15.12C12.1 15.12 11.97 15.09 11.85 15.02C11.2 14.64 10.57 14.22 9.97999 13.78C9.64999 13.53 9.58 13.06 9.83 12.73C10.08 12.4 10.55 12.33 10.88 12.58C11.42 12.99 12.01 13.37 12.61 13.72C12.97 13.93 13.09 14.39 12.88 14.75C12.74 14.99 12.49 15.12 12.23 15.12Z"
                                        fill="#000000"></path>
                                </g>
                            </svg>
                        </button>
                        <div
                            class="absolute top-auto end-0 mt-2 bg-white backdrop-blur-3xl rounded-xl duration-500 overflow-hidden z-30"
                            :class="{ 'max-h-[1000px]' : isActiveLanguageDropdown, 'max-h-[0px]' : !isActiveLanguageDropdown }">
                            <div class="p-2 block w-full">
                                <button type="button"
                                        class="px-6 min-h-[45px] max-h-[45px] flex justify-center items-center w-full cursor-pointer duration-500 hover:bg-gray-100 rounded-xl mb-1"
                                        :class="{ 'bg-transparent' : lang !== 'en', 'bg-gray-100' : lang === 'en' }"
                                        @click="setLang('en')">
                                    English
                                </button>
                                <button type="button"
                                        class="px-6 min-h-[45px] max-h-[45px] flex justify-center items-center w-full cursor-pointer duration-500 hover:bg-gray-100 rounded-xl"
                                        :class="{ 'bg-transparent' : lang !== 'ar', 'bg-gray-100' : lang === 'ar' }"
                                        @click="setLang('ar')">
                                    عربي
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- user dropdown -->
                    <div class="relative" id="userDropdown">
                        <button type="button"
                                class="size-[45px] inline-flex justify-center items-center bg-white rounded-full cursor-pointer"
                                @click.stop="userDropdown()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-[20px]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </button>
                        <div
                            class="absolute top-auto end-0 mt-2 bg-white drop-shadow-2xl min-w-[150px] rounded-xl duration-500 overflow-hidden z-30"
                            :class="{ 'max-h-[1000px]' : isActiveUserDropdown, 'max-h-[0px]' : !isActiveUserDropdown, 'min-w-[170px]' : lang === 'en', 'min-w-[200px]' : lang === 'ar' }">
                            <div class="p-2 block w-full">
                                <router-link :to="{name:'profile'}"
                                             class="px-6 min-h-[45px] max-h-[45px] flex justify-start items-center w-full cursor-pointer duration-500 hover:bg-gray-100 rounded-xl mb-1 font-medium"
                                             :class="{ 'bg-transparent' : $route.name !== 'profile', 'bg-gray-100' : $route.name === 'profile' }"
                                             @click="userDropdown()">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="size-[20px]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                    </svg>
                                    <span class="ms-3"> {{ ___('Profile') }} </span>
                                </router-link>
                                <router-link :to="{name:'settings'}"
                                             class="px-6 min-h-[45px] max-h-[45px] flex justify-start items-center w-full cursor-pointer duration-500 hover:bg-gray-100 rounded-xl mb-1 font-medium"
                                             :class="{ 'bg-transparent' : $route.name !== 'settings', 'bg-gray-100' : $route.name === 'settings' }"
                                             @click="userDropdown()">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="size-[20px]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>
                                    <span class="ms-3"> {{ ___('Settings') }} </span>
                                </router-link>
                                <button type="button"
                                        class="px-6 min-h-[45px] max-h-[45px] flex justify-start items-center w-full cursor-pointer duration-500 bg-transparent hover:bg-gray-100 rounded-xl font-medium"
                                        @click="userDropdown();logoutApi()" v-if="!logoutLoading">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="size-[20px]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9"/>
                                    </svg>
                                    <span class="ms-3"> {{ ___('Logout') }} </span>
                                </button>
                                <button type="button"
                                        class="min-h-[45px] max-h-[45px] w-full flex justify-center items-center cursor-pointer duration-500 bg-transparent hover:bg-gray-100 rounded-xl"
                                        v-if="logoutLoading">
                                    <span
                                        class="inline-block size-[20px] rounded-full border-2 border-transparent border-t-black animate-spin"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </header>

            <!-- inner content -->
            <article class="w-full h-[calc(100vh-95px)]">
                <router-view/>
            </article>

        </aside>

    </section>

</template>

<script>

import axios from "axios";
import apiRoutes from "../../../services/apiRoutes.js";
import apiServices from "../../../services/apiServices.js";
import cookiesServices from "../../../services/cookiesServices.js";

import {toast} from "vue3-toastify";

export default {
    data() {
        return {
            isActiveSidebar: false,
            isActiveUserDropdown: false,
            isActiveLanguageDropdown: false,
            fullScreen: false,
            logoutLoading: false,
            lang: 'en',
        }
    },
    mounted() {
        this.lang = cookiesServices.get('lang') || "en";
        if (!cookiesServices.get('access_token')) {
            this.$router.push({name: 'login'});
        }
        window.addEventListener('click', (event) => this.handleSideBarClose(event));
        window.addEventListener('click', (event) => this.handleUserDropdownClose(event));
        window.addEventListener('click', (event) => this.handleLanguageDropdownClose(event));
    },
    beforeUnmount() {
        window.removeEventListener('click', this.handleSideBarClose);
        window.removeEventListener('click', this.handleUserDropdownClose);
        window.removeEventListener('click', this.handleLanguageDropdownClose);
    },
    methods: {
        userDropdown() {
            if (this.isActiveLanguageDropdown) {
                this.isActiveLanguageDropdown = false;
            }
            if (this.isActiveLanguageDropdown) {
                this.isActiveSidebar = false;
            }
            this.isActiveUserDropdown = !this.isActiveUserDropdown;
        },
        handleUserDropdownClose(event) {
            if (!event.target.closest('#userDropdown') && this.isActiveUserDropdown) {
                this.isActiveUserDropdown = false;
            }
        },
        languageDropdown() {
            if (this.isActiveUserDropdown) {
                this.isActiveUserDropdown = false;
            }
            if (this.isActiveLanguageDropdown) {
                this.isActiveSidebar = false;
            }
            this.isActiveLanguageDropdown = !this.isActiveLanguageDropdown;
        },
        handleLanguageDropdownClose(event) {
            if (!event.target.closest('#languageDropdown') && this.isActiveLanguageDropdown) {
                this.isActiveLanguageDropdown = false;
            }
        },
        sidebarToggle() {
            if (this.isActiveUserDropdown) {
                this.isActiveUserDropdown = false;
            }
            if (this.isActiveLanguageDropdown) {
                this.isActiveLanguageDropdown = false;
            }
            this.isActiveSidebar = !this.isActiveSidebar;
        },
        handleSideBarClose(event) {
            if (!event.target.closest('#sidebar') && this.isActiveSidebar) {
                this.isActiveSidebar = false;
            }
        },
        setLang(language) {
            cookiesServices.set('lang', language);
            window.location.reload();
            this.isActiveLanguageDropdown = false;
        },
        async logoutApi() {
            this.loading = true;
            try {
                await axios.post(apiRoutes.logout, null, {headers: apiServices.authHeaderContent()});
                cookiesServices.remove('access_token');
                cookiesServices.remove('user_type');
                this.$router.push({name: 'login'});
                toast.success(this.lang === "en" ? "User Logout successfully" : "تم تسجيل خروج المستخدم بنجاح");
            } catch (error) {
                if (error?.response && error?.response?.status === 401) {
                    cookiesServices.remove('access_token');
                    this.$router.push({name: 'login'});
                } else {
                    this.error = error?.response?.data?.message || "An error occurred during logout";
                }
            } finally {
                this.loading = false;
            }
        },
        toggleFullscreen() {
            const elem = document.documentElement;
            if (!this.fullScreen) {
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.webkitRequestFullscreen) {
                    elem.webkitRequestFullscreen();
                } else if (elem.msRequestFullscreen) {
                    elem.msRequestFullscreen();
                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            }
            setTimeout(() => {
                this.fullScreen = !!(
                    document.fullscreenElement ||
                    document.webkitFullscreenElement ||
                    document.msFullscreenElement
                );
            }, 100);
        }
    }
}

</script>
