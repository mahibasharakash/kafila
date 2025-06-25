<template>

    <!-- breadcrumb -->
    <Breadcrumb :title="___(`Blogs`)"
                :links="[ { label: ___(`Home`), href: 'home' }, { label: ___(`Blogs`), href: 'blogs' } ]"></Breadcrumb>

    <section class="w-full py-3 sm:py-16 block">
        <div class="mx-auto max-w-[1200px] w-full px-5 sm:px-10">

            <div class="w-full flex items-center mb-3 justify-between flex-wrap">

                <!-- search -->
                <div class="w-full md:w-1/2 lg:w-2/3 p-2">
                    <div class="w-full relative">
                        <input type="text" name="keyword" v-model="searchQuery"
                               class="w-full block outline-0 rounded-lg bg-white border border-gray-200 duration-500 focus-within:ring-4 focus-within:ring-[#21306b] h-[50px] ps-10 pe-5"
                               autocomplete="off" :placeholder="___(`Search here`)"/>
                        <div
                            class="absolute top-0 bottom-0 start-0 pointer-events-none flex justify-start items-center ps-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-[20px]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- select sorting order -->
                <div class="w-full md:w-1/2 lg:w-1/3 p-2">
                    <div class="w-full relative">
                        <select name="sortOrder" id="sortOrder" v-model="sortOrder"
                                class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px] appearance-none">
                            <option value=""> {{ ___(`Select Sorting Order`) }}</option>
                            <option value="asc"> {{ ___(`Ascending`) }}</option>
                            <option value="desc"> {{ ___(`Descending`) }}</option>
                        </select>
                        <div
                            class="absolute top-0 bottom-0 end-0 pointer-events-none flex justify-end items-center pe-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                 class="size-[20px] stroke-black">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3 p-2"
                 v-if="filteredList.length > 0 && !loading">

                <template v-for="(each, index) in filteredList" :key="index">

                    <!-- each blog -->
                    <router-link :to="{name:'blogDetails',params:{id:each.id},state:each}"
                                 class="w-full block bg-gray-100 h-full rounded-2xl overflow-hidden duration-500 shadow-none hover:shadow-lg"
                                 @mouseover="isBlogHovered = index" @mouseleave="isBlogHovered = null"
                                 :class="isBlogHovered !== null && isBlogHovered !== index ? 'opacity-70 blur-[2px]' : 'opacity-100 blur-0'">

                        <!-- image -->
                        <div class="relative w-full h-auto">
                            <img :src="each.image" class="object-cover bg-cover w-full min-h-[290px] h-[290px]"
                                 alt="blog"/>
                            <div class="absolute top-0 end-0 p-3">
                                <div class="bg-white px-3 py-1 rounded-lg">
                                    {{ each.created_at_formatted }}
                                </div>
                            </div>
                        </div>

                        <div class="p-5 w-full block">

                            <!-- title -->
                            <div class="mb-3 block text-[20px]">
                                {{ each.title }}
                            </div>

                            <!-- description -->
                            <div class="mb-3 text-[14px] block text-gray-700">
                                <div class="truncate-to-2-line">
                                    {{ each.short_description }}
                                </div>
                            </div>

                            <div class="text-[14px]">
                                <!-- posted by -->
                                <span>
                                        {{ lang === 'en' ? 'Posted By' : 'أرسلت بواسطة' }}:
                                        {{ each.author_name }}
                                    </span>

                            </div>

                        </div>

                    </router-link>

                </template>

            </div>

            <template v-if="filteredList.length === 0 && !loading">
                <!-- empty screen -->
                <div
                    class="w-full font-semibold flex justify-center items-center flex-col rounded-lg text-[21px] bg-gray-100 min-h-[calc(100vh-305px)] h-[calc(100vh-305px)] max-h-[calc(100vh-305px)]">
                    <div class="mb-5">
                        <svg viewBox="0 0 24 24" class="size-[65px]" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M22 19H14M2 19H10" stroke="#000000" stroke-width="2"
                                      stroke-linecap="round"></path>
                                <path d="M12 17V14" stroke="#000000" stroke-width="2" stroke-linecap="round"></path>
                                <circle cx="12" cy="19" r="2" stroke="#000000" stroke-width="2"></circle>
                                <path
                                    d="M14 14H5C3.34315 14 2 12.6569 2 11C2 9.34315 3.34315 8 5 8H19C20.6569 8 22 9.34315 22 11C22 12.6569 20.6569 14 19 14H18"
                                    stroke="#000000" stroke-width="2" stroke-linecap="round"></path>
                                <path
                                    d="M12 2H19C20.6569 2 22 3.34315 22 5C22 6.65685 20.6569 8 19 8H5C3.34315 8 2 6.65685 2 5C2 3.34315 3.34315 2 5 2H8"
                                    stroke="#000000" stroke-width="2" stroke-linecap="round"></path>
                                <path d="M13 5L19 5" stroke="#000000" stroke-width="2" stroke-linecap="round"></path>
                                <path d="M13 11L19 11" stroke="#000000" stroke-width="2" stroke-linecap="round"></path>
                                <circle cx="6" cy="5" r="1" fill="#000000"></circle>
                                <circle cx="6" cy="11" r="1" fill="#000000"></circle>
                            </g>
                        </svg>
                    </div>
                    <div class="text-[17px]">
                        {{ ___(`Currently there have no blog.`) }}
                    </div>
                </div>
            </template>

            <!-- loading -->
            <section class="w-full h-[650px] min-h-[650px] object-cover bg-cover flex justify-center items-center"
                     v-if="loading">
                <span class="screen-loader"></span>
            </section>

            <!-- pagination -->
            <template v-if="filteredList.length > 16">

                <div class="flex justify-center items-center mt-5 gap-x-2">
                    <button type="button" @click="prevPage"
                            class="size-[40px] inline-flex justify-center items-center bg-gray-100 duration-500 hover:bg-[#21306b]/10 group rounded-xl cursor-pointer disabled:pointer-events-none"
                            :disabled="currentPage === 1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                             class="size-[15px] stroke-black duration-500 group-hover:stroke-[#21306b]"
                             :class="{ 'rotate-0' : lang === 'en', 'rotate-180' : lang === 'ar' }">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                        </svg>
                    </button>
                    <span v-for="page in visiblePages" :key="'page-' + page"
                          @click="typeof page === 'number' && setPage(page)"
                          class="size-[40px] inline-flex justify-center items-center duration-500 hover:bg-[#21306b]/10 group font-medium rounded-xl"
                          :class="{ 'cursor-pointer hover:text-[#21306b]': page !== '...', 'bg-[#21306b]/20 text-[#21306b]': page === currentPage, 'bg-gray-100 text-black': page !== currentPage && page !== '...','pointer-events-none cursor-default': page === '...'}">
                    {{ page }}
                </span>
                    <button type="button" @click="nextPage"
                            class="size-[40px] inline-flex justify-center items-center bg-gray-100 duration-500 hover:bg-[#21306b]/10 group rounded-xl cursor-pointer disabled:pointer-events-none"
                            :disabled="currentPage === totalPages">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                             class="size-[15px] stroke-black duration-500 group-hover:stroke-[#21306b]"
                             :class="{ 'rotate-0' : lang === 'en', 'rotate-180' : lang === 'ar' }">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                        </svg>
                    </button>
                </div>

            </template>

        </div>

    </section>

</template>

<script>

import axios from "axios";
import Breadcrumb from "../../../../components/breadcrumb.vue";
import apiRoutes from "../../../../services/apiRoutes.js";
import apiServices from "../../../../services/apiServices.js";
import Preloader from "../../../../components/preloader.vue";
import EmptyScreen from "../../../../components/empty-screen.vue";
import cookiesServices from "../../../../services/cookiesServices.js";

export default {
    components: {
        Breadcrumb, Preloader, EmptyScreen
    },
    computed: {
        filteredList() {
            let result = this.listData;
            if (this.searchQuery.trim()) {
                const query = this.searchQuery.toLowerCase();
                result = result.filter(item =>
                    item.title.toLowerCase().includes(query) ||
                    item.author_name.toLowerCase().includes(query)
                );
            }
            if (this.sortOrder === 'asc') {
                result = [...result].sort((a, b) => a.title.localeCompare(b.title));
            } else if (this.sortOrder === 'desc') {
                result = [...result].sort((a, b) => b.title.localeCompare(a.title));
            }
            return result;
        },
        totalPages() {
            return Math.ceil(this.filteredList.length / this.itemsPerPage);
        },
        paginatedList() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.filteredList.slice(start, end);
        },
        visiblePages() {
            const pages = [];
            const total = this.totalPages;
            const current = this.currentPage;
            if (total <= 5) {
                for (let i = 1; i <= total; i++) pages.push(i);
            } else {
                if (current <= 3) {
                    pages.push(1, 2, 3, 4, '...', total);
                } else if (current >= total - 2) {
                    pages.push(1, '...', total - 3, total - 2, total - 1, total);
                } else {
                    pages.push(1, '...', current - 1, current, current + 1, '...', total);
                }
            }
            return pages;
        }
    },
    watch: {
        searchQuery() {
            this.currentPage = 1;
        }
    },
    data() {
        return {
            lang: 'en',
            isBlogHovered: null,
            listData: [],
            loading: false,
            searchQuery: '',
            currentPage: 1,
            itemsPerPage: 16,
            sortOrder: '',
        }
    },
    mounted() {
        this.trackVisit('Blog');
        this.lang = cookiesServices.get('lang') || "en";
        this.blogApi();
    },
    methods: {
        async trackVisit(page) {
            try {
                this.loading = true;
                await axios.post(apiRoutes.visitPage + '/store', {page}, {headers: apiServices.authHeaderContent});
            } catch (error) {
                console.log(error)
            } finally {
                this.loading = false;
            }
        },
        setPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        async blogApi() {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.blog, {headers: apiServices.authHeaderContent});
                this.listData = response?.data?.data
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
    }
}

</script>
