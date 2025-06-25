<template>

    <!-- breadcrumb -->
    <Breadcrumb :title="___(`Products`)"
                :links="[ { label: ___(`Home`), href: 'home' }, { label: ___(`Products`), href: 'products' } ]"></Breadcrumb>

    <section class="w-full py-3 sm:py-16 block">
        <div class="mx-auto max-w-[1200px] w-full px-5 sm:px-10">

            <div class="w-full grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 p-2">

                <!-- search -->
                <div class="w-full">
                    <div class="w-full relative">
                        <input type="text" name="keyword" v-model="searchQuery"
                               class="w-full block outline-0 rounded-lg bg-white border border-gray-200 duration-500 focus-within:ring-4 focus-within:ring-[#21306b] h-[50px] ps-10 pe-5"
                               required autocomplete="off" :placeholder="___(`Search here`)"/>
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

                <!-- select category -->
                <div class="w-full">
                    <div class="w-full relative">
                        <select name="category" id="category" v-model="selectedCategory"
                                class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px] appearance-none">
                            <option value=""> {{ ___(`Select Category`) }}</option>
                            <option v-for="each in categoryData" :value="each.id"> {{ each.name }}</option>
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

                <!-- select product type -->
                <div class="w-full">
                    <div class="w-full relative">
                        <select name="product_type" id="product_type" v-model="selectProductType"
                                class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px] appearance-none">
                            <option value=""> {{ ___(`Select Product Type`) }}</option>
                            <option value="featured_products"> {{ ___(`Featured Products`) }}</option>
                            <option value="latest_products"> {{ ___(`Latest Products`) }}</option>
                            <option value="best_sellers"> {{ ___(`Best Sellers`) }}</option>
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

            <div class="w-full grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 p-2"
                 v-if="filteredList.length > 0 && !loading">
                <template v-for="(each, index) in filteredList" :key="each.id">
                    <div
                        class="relative block w-full h-full bg-gray-100 overflow-hidden rounded-lg group shadow-none duration-500 hover:shadow-lg transition-all backdrop-blur-sm"
                        @mouseover="isProductHovered = index" @mouseleave="isProductHovered = null"
                        :class="isProductHovered !== null && isProductHovered !== index ? 'opacity-70 blur-[2px]' : 'opacity-100 blur-0'">

                        <div class="absolute top-0 start-0 p-5">
                            <div class="bg-green-200 text-green-800 inline-block px-3 py-1 rounded-md text-sm"
                                 v-if="parseInt(each.quantity) !== 0">
                                In Stock
                            </div>
                            <div class="bg-rose-200 text-rose-800 inline-block px-3 py-1 rounded-md text-sm"
                                 v-if="parseInt(each.quantity) === 0">
                                Out of Stock
                            </div>
                        </div>

                        <div
                            class="absolute top-0 end-0 p-5 flex flex-col gap-3 opacity-0 duration-500 group-hover:opacity-100">

                            <!-- view -->
                            <router-link :to="{name:'productDetails',params:{id:each.id}}"
                                         class="size-[35px] inline-flex justify-center items-center bg-gray-200 outline-0 cursor-pointer rounded-lg group/item duration-500 hover:bg-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="2.5"
                                     class="size-[17px] stroke-black duration-500 group-hover/item:stroke-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                            </router-link>

                            <!-- add to cart -->
                            <button type="button"
                                    class="size-[35px] justify-center items-center bg-gray-200 outline-0 rounded-lg group/item duration-500 hover:bg-green-600 cursor-pointer"
                                    @click="addToCart(each)"
                                    :class="{ 'inline-flex' : parseInt(each.quantity) !== 0, 'hidden' : parseInt(each.quantity) === 0 }"
                                    :disabled="parseInt(each.quantity) === 0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="2.5"
                                     class="size-[17px] stroke-black duration-500 group-hover/item:stroke-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                            </button>

                            <!-- add to wishlist -->
                            <button type="button"
                                    class="size-[35px] inline-flex justify-center items-center bg-gray-200 outline-0 cursor-pointer rounded-lg group/item duration-500 hover:bg-rose-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="2.5"
                                     class="size-[17px] fill-black duration-500 group-hover/item:fill-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                                </svg>
                            </button>

                        </div>

                        <!-- image -->
                        <img :src="each?.image" class="object-cover bg-cover w-full max-h-[350px] min-h-[350px]"
                             :alt="each?.name"/>

                        <div class="p-5 w-full block">

                            <!-- category -->
                            <div class="mb-3 w-full block text-[14px] text-gray-700">
                                {{ each?.category?.name }}
                            </div>

                            <!-- name -->
                            <div class="mb-3 w-full block text-[21px]">
                                <div class="truncate-to-1-line">
                                    {{ each?.title }}
                                </div>
                            </div>

                            <div class="mb-3 w-full block text-[14px] text-gray-700">
                                <div v-if="each.description" class="truncate-to-3-line"
                                     v-html="renderEditorJsDescription(each?.description)"></div>
                                <template v-else> N/A</template>
                            </div>

                            <!-- price -->
                            <div class="w-full block text-[14px] text-end">
                                ${{ each?.price }}
                            </div>

                        </div>

                    </div>
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
                        {{ ___(`Currently there have no product.`) }}
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
import EmptyScreen from "../../../../components/empty-screen.vue";
import apiRoutes from "../../../../services/apiRoutes.js";
import apiServices from "../../../../services/apiServices.js";
import store from "../../../../store/index.js";
import cookiesServices from "../../../../services/cookiesServices.js";

export default {
    props: ['each'],
    computed: {
        filteredList() {
            let result = this.listData;
            if (this.searchQuery.trim()) {
                const query = this.searchQuery.toLowerCase();
                result = result.filter(product =>
                    product.title.toLowerCase().includes(query) ||
                    product.price.toLowerCase().includes(query)
                );
            }
            if (this.selectedCategory) {
                result = result.filter(product => product.category?.id === this.selectedCategory);
            }
            if (this.selectProductType === 'featured_products') {
                result = result.filter(product => product.product_type === this.selectProductType);
            }
            if (this.selectProductType === 'latest_products') {
                result = result.filter(product => product.product_type === this.selectProductType);
            }
            if (this.selectProductType === 'best_sellers') {
                result = result.filter(product => product.product_type === this.selectProductType);
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
        searchKeyword() {
            this.currentPage = 1;
        },
        selectedCategory() {
            this.currentPage = 1;
        },
        selectProductType() {
            this.currentPage = 1;
        }
    },
    components: {
        EmptyScreen, Breadcrumb
    },
    data() {
        return {
            lang: 'en',
            loading: false,
            categoryData: [],
            brandData: [],
            isProductHovered: null,
            searchKeyword: '',
            selectedCategory: '',
            selectProductType: '',
            currentPage: 1,
            perPage: 6,
            isBlogHovered: null,
            listData: [],
            searchQuery: '',
            itemsPerPage: 16,
            sortOrder: '',
        }
    },
    mounted() {
        this.trackVisit('Product');
        this.lang = cookiesServices.get('lang') || "en";
        this.productApi();
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
        async productApi() {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.product, {headers: apiServices.authHeaderContent});
                this.listData = response?.data?.data
                await this.categoryApi();
                await this.brandApi();
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        async categoryApi() {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.category, {headers: apiServices.authHeaderContent});
                this.categoryData = response?.data?.data
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        async brandApi() {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.brand, {headers: apiServices.authHeaderContent});
                this.brandData = response?.data?.data
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        renderEditorJsDescription(description) {
            if (!description) return '';
            let blocks = description;
            if (typeof blocks === 'string') {
                try {
                    blocks = JSON.parse(blocks);
                } catch {
                    return '';
                }
            }
            if (!blocks.blocks) return '';
            return blocks.blocks.map(block => {
                const {type, data} = block;
                switch (type) {
                    case 'paragraph':
                        return `<p>${data.text}</p>`;
                    case 'header':
                        const level = data.level >= 1 && data.level <= 6 ? data.level : 2;
                        return `<h${level}>${data.text}</h${level}>`;
                    case 'list':
                        const tag = data.style === 'ordered' ? 'ol' : 'ul';
                        const items = data.items.map(item => `<li>${item}</li>`).join('');
                        return `<${tag}>${items}</${tag}>`;
                    case 'quote':
                        return `<blockquote><p>${data.text}</p><footer>${data.caption || ''}</footer></blockquote>`;
                    case 'image':
                        return `<img src="${data.file.url}" alt="${data.caption || ''}" />`;
                    default:
                        return '';
                }
            }).join('');
        },
        addToCart(product) {
            store.dispatch('addToCart', product)
        },
    }
}

</script>
