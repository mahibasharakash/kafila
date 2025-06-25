<template>

    <!-- breadcrumb -->
    <Breadcrumb :title="___(`Order History`)"
                :links="[ { label: ___(`Home`), href: 'home' }, { label: ___(`Order History`), href: 'orderHistory' } ]"></Breadcrumb>

    <section class="w-full pt-3 sm:pt-16 px-5 sm:px-10 block">
        <div class="w-full max-w-[1200px] mx-auto">

            <div class="overflow-x-auto">

                <!-- order history -->
                <table class="table-auto w-full" v-if="paginatedList.length > 0 && !listLoading">
                    <thead class="w-full">
                    <tr class="w-full">
                        <th class="px-5 py-3 text-start font-medium bg-gray-100 overflow-hidden">
                            {{ ___(`Product`) }}
                        </th>
                        <th class="px-5 py-3 text-start font-medium bg-gray-100 overflow-hidden">
                            {{ ___(`Price`) }}
                        </th>
                        <th class="px-5 py-3 text-start font-medium bg-gray-100 overflow-hidden">
                            {{ ___(`Quantity`) }}
                        </th>
                        <th class="px-5 py-3 text-start font-medium bg-gray-100 overflow-hidden">
                            {{ ___(`SubTotal`) }}
                        </th>
                        <th class="px-5 py-3 text-start font-medium bg-gray-100 overflow-hidden">
                            {{ ___(`Status`) }}
                        </th>
                    </tr>
                    </thead>
                    <tbody class="w-full">
                    <tr class="w-full" v-for="(each, index) in paginatedList" :key="index">
                        <td class="pt-3 font-medium h-full min-w-[350px] max-w-[250px]">
                            <div class="flex justify-start items-center p-3 bg-gray-100 h-[100px]">
                                <img v-if="each.image" :src="each.image"
                                     class="shadow-md rounded-xl object-cover bg-cover min-w-[75px] min-h-[75px] max-w-[75px] max-h-[75px]"
                                     alt=""/>
                                <div v-else
                                     class="shadow-md rounded-xl min-w-[75px] bg-gray-200 min-h-[75px] max-w-[75px] max-h-[75px] inline-flex justify-center items-center">
                                    {{ shortName(each.title) }}
                                </div>
                                <span class="block ms-2 w-full">
                                    <span
                                        class="block w-full text-[12px] text-gray-600"> {{ each.category || 'N/A' }} </span>
                                    <span class="block w-full"> {{ each.title || 'N/A' }} </span>
                                    <span class="block w-full text-[12px] text-gray-600"
                                          v-if="each.payment_method === 'home_delivery'"> {{ ___(`Home Delivery`) }} </span>
                                    <span class="block w-full text-[12px] text-gray-600"
                                          v-if="each.payment_method === 'cash_on_delivery'"> {{ ___(`Cash On Delivery`) }} </span>
                                </span>
                            </div>
                        </td>
                        <td class="pt-3 font-medium h-full min-w-[150px] max-w-[150px]">
                            <div class="bg-gray-100 px-5 py-3 h-[100px] flex justify-start items-center">
                                ${{ parseFloat(each.price).toFixed(2) }}
                            </div>
                        </td>
                        <td class="pt-3 font-medium h-full min-w-[150px] max-w-[150px]">
                            <div class="bg-gray-100 px-5 py-3 h-[100px] flex justify-start items-center">
                                {{ parseInt(each.quantity) }}
                            </div>
                        </td>
                        <td class="pt-3 font-medium h-full min-w-[150px] max-w-[150px]">
                            <div class="bg-gray-100 px-5 py-3 h-[100px] flex justify-start items-center">
                                ${{ parseFloat(Number(each.price * each.quantity)).toFixed(2) }}
                            </div>
                        </td>
                        <td class="pt-3 font-medium h-full min-w-[150px] max-w-[150px]">
                            <div class="bg-gray-100 px-5 py-3 h-[100px] flex justify-start items-center">
                                {{ each.status }}
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div class="w-full min-h-[650px] flex justify-center items-center bg-gray-100 mb-16 flex-col"
                     v-if="paginatedList.length === 0 && !listLoading">
                    <div class="mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                             stroke="currentColor" class="size-[65px]">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                        </svg>
                    </div>
                    <div class="font-medium"> {{ ___(`You have no order history`) }}</div>
                </div>

                <!-- pagination -->
                <Preloader v-if="listLoading"/>

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

        </div>
    </section>

</template>

<script>

import axios from "axios";
import Breadcrumb from "../../../components/breadcrumb.vue";
import apiRoutes from "../../../services/apiRoutes.js";
import apiServices from "../../../services/apiServices.js";
import Preloader from "../../../components/preloader.vue";
import EmptyScreen from "../../../components/empty-screen.vue";
import cookiesServices from "../../../services/cookiesServices.js";

export default {
    components: {
        EmptyScreen, Preloader,
        Breadcrumb
    },
    computed: {
        filteredList() {
            if (!this.searchQuery.trim()) return this.listData;
            return this.listData.filter(data => {
                const title = data?.title;
                const price = data?.price;
                const category = data?.category;
                const query = this.searchQuery.toLowerCase();
                return title?.toLowerCase().includes(query) || price?.toLowerCase().includes(query) || category?.toLowerCase().includes(query);
            });
        },
        totalPages() {
            return Math.ceil(this.filteredList.length / this.itemsPerPage);
        },
        paginatedList() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.filteredList.slice(start, end);
        }
    },
    data() {
        return {
            lang: 'en',
            historyLoading: false,
            orderData: [],
            searchQuery: '',
            currentPage: 1,
            itemsPerPage: 16,
            listData: [],
            listLoading: false,
        }
    },
    mounted() {
        this.lang = cookiesServices.get('lang') || "en";
        this.getOrderHistory();
    },
    methods: {
        async getOrderHistory() {
            try {
                this.listLoading = true;
                const response = await axios.get(apiRoutes.order, {headers: apiServices.authHeaderContent});
                this.listData = response.data.data
            } catch (error) {
                console.log(error);
            } finally {
                this.listLoading = false;
            }
        },
        shortName(name) {
            let parts = name.trim().split(' ');
            // return parts[0][0] + parts[1][0];
            return parts[0][0] + parts[parts.length - 1][0];
        },
    }
}

</script>
