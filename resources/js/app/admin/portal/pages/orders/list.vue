<template>

    <section class="w-full px-3 sm:px-10">

        <!-- Card body title -->
        <div class="text-[25px]"> {{ ___('Orders') }} </div>

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
                <router-link :to="{name:'orders'}" class="decoration-0 text-[#21306b] duration-500 hover:text-[#3B497E] p-2 inline-block">
                    {{___(`Orders`)}}
                </router-link>
            </li>
        </ul>

        <!-- Card body -->
        <section class="w-full bg-white p-3 shadow-sm rounded-[0.625rem_0.625rem_0_0] h-[calc(100vh-220px)]">

            <!-- Search, Clear, route -->
            <section class="w-full block sm:flex items-center justify-between flex-wrap sm:flex-nowrap mb-2.5">

                <!-- Search -->
                <div class="sm:max-w-[350px] w-full mb-3 sm:mb-0 sm:me-2">
                    <input type="text" name="keyword" v-model="searchQuery" :placeholder="___('Search Here')" class="placeholder-[#21306b] w-full text-[14px] outline-0 min-h-[45px] rounded-[0.625rem] border border-gray-200 bg-white px-5" autocomplete="off"/>
                </div>

                <button type="button" class="cursor-pointer px-10 h-[45px] text-[14px] font-medium max-w-[120px] min-w-[120px] bg-gray-200 duration-500 hover:bg-gray-300 inline-flex justify-center items-center text-gray-900 rounded-[0.625rem]" @click="openDeleteModal('all')">
                    {{___(`Clear`)}}
                </button>

            </section>

            <!-- Card body - body part -->
            <div class="w-full overflow-y-auto" v-if="paginatedList.length > 0 && !listLoading" :class="filteredList.length > 16 ? 'h-[calc(100vh-400px)]' : 'h-[calc(100vh-320px)]'">

                <div class="grid grid-cols-1 gap-3">
                    <template v-for="(each, index) in paginatedList" :key="index">
                        <div class="w-full shadow-md border border-gray-100 rounded-xl p-5">
                            <div class="w-full flex justify-between items-center mb-3">
                                <div> {{ ___('Order') }}</div>
                            </div>
                            <div class="w-full block font-normal pb-3 mt-3">
                                <div class="p-2 block w-full font-semibold border border-gray-200">
                                    {{ ___('Customer Information') }}
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2">
                                    <div class="p-2 border border-gray-200 block xl:flex justify-between items-center">
                                        <span class="me-2">{{ ___('Name') }}: </span> {{ each.customer.name }}
                                    </div>
                                    <div class="p-2 border border-gray-200 block xl:flex justify-between items-center">
                                        <span class="me-2">{{ ___('Phone Number') }}: </span> {{ each.customer.phone }}
                                    </div>
                                    <div class="p-2 border border-gray-200 block xl:flex justify-between items-center">
                                        <span class="me-2">{{ ___('Preset Address') }}: </span>
                                        {{ each.customer.address }}
                                    </div>
                                    <div class="p-2 border border-gray-200 block xl:flex justify-between items-center">
                                        <span class="me-2">{{ ___('Delivery Process') }}: </span>
                                        <template v-if="each.payment_method === 'home_delivery'">
                                            {{ ___('Home Delivery') }}
                                        </template>
                                        <template v-if="each.payment_method === 'cash_on_delivery'">
                                            {{ ___('Cash On Delivery') }}
                                        </template>
                                    </div>
                                </div>
                                <div class="p-2 block w-full font-semibold border border-gray-200">
                                    {{ ___('Product Information') }}
                                </div>
                                <template v-for="item in each.items">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3">
                                        <div class="p-2 border border-gray-200 flex xl:justify-between items-center">
                                            <span class="me-2"> {{ ___('Name') }}: </span>
                                            <div class="truncate">
                                                {{ item.title }}
                                            </div>
                                        </div>
                                        <div class="p-2 border border-gray-200 flex xl:justify-between items-center">
                                            <span class="me-2"> {{ ___('Quantity') }}: </span>
                                            <div class="truncate">
                                                {{ parseFloat(item.quantity) }}
                                            </div>
                                        </div>
                                        <div class="p-2 border border-gray-200 flex xl:justify-between items-center">
                                            <span class="me-2"> {{ ___('Price') }}: </span>
                                            <div class="truncate">
                                                ${{ parseFloat(item.price).toFixed(2) }}
                                            </div>
                                        </div>
                                        <div class="p-2 border border-gray-200 flex xl:justify-between items-center">
                                            <span class="me-2"> {{ ___('SubTotal') }}: </span>
                                            <div class="truncate">
                                                ${{ parseFloat(item.price * item.quantity).toFixed(2) }}
                                            </div>
                                        </div>
                                        <div class="p-2 border border-gray-200 flex xl:justify-between items-center">
                                            <span class="me-2"> {{ ___('Status') }}: </span>
                                            <div class="relative">
                                                <select name="status" v-model="item.status"
                                                        class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px] appearance-none"
                                                        @change="updateApi(item)">
                                                    <option :value="'pending'"> {{ ___('Pending') }}</option>
                                                    <option :value="'on progress'"> {{ ___('On Progress') }}</option>
                                                    <option :value="'complete'"> {{ ___('Complete') }}</option>
                                                    <option :value="'returned'"> {{ ___('Returned') }}</option>
                                                </select>
                                                <div class="absolute top-0 bottom-0 end-0 pe-3 flex items-center pointer-events-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                         stroke="currentColor" class="size-[15px]">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 border border-gray-200 flex xl:justify-between items-center">
                                            <span class="me-2"> {{ ___('Order Date') }}: </span>
                                            <div class="truncate">
                                                {{ item.orderDate }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2 border border-gray-200 flex justify-between items-center">
                                        <span class="invisible"> {{ ___('item') }} </span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>

            </div>

            <Preloader v-if="listLoading"/>

            <EmptyScreen :title="___('order')" v-if="paginatedList.length === 0 && !listLoading"/>

            <template v-if="filteredList.length > 16">

                <div class="flex justify-center items-center mt-5 gap-1">
                    <button type="button" @click="prevPage" class="size-[35px] text-[13px] inline-flex justify-center items-center bg-gray-100 duration-500 hover:bg-[#8C76FF]/10 group rounded-md cursor-pointer disabled:pointer-events-none" :disabled="currentPage === 1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" class="size-[15px] stroke-black duration-500 group-hover:stroke-[#8C76FF]" :class="{ 'rotate-0' : lang === 'en', 'rotate-180' : lang === 'ar' }">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                        </svg>
                    </button>
                    <span v-for="page in visiblePages" :key="'page-' + page" @click="typeof page === 'number' && setPage(page)" class="font-semibold size-[35px] text-[13px] inline-flex justify-center items-center duration-500 hover:bg-[#8C76FF]/10 group rounded-md" :class="{ 'cursor-pointer hover:text-[#8C76FF]': page !== '...', 'bg-[#8C76FF]/20 text-[#8C76FF]': page === currentPage, 'bg-gray-100 text-black': page !== currentPage && page !== '...','pointer-events-none cursor-default': page === '...'}">
                    {{ page }}
                </span>
                    <button type="button" @click="nextPage" class="size-[35px] text-[13px] inline-flex justify-center items-center bg-gray-100 duration-500 hover:bg-[#8C76FF]/10 group rounded-md cursor-pointer disabled:pointer-events-none" :disabled="currentPage === totalPages">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" class="size-[15px] stroke-black duration-500 group-hover:stroke-[#8C76FF]" :class="{ 'rotate-0' : lang === 'en', 'rotate-180' : lang === 'ar' }">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                        </svg>
                    </button>
                </div>

            </template>

        </section>

    </section>

    <!-- delete modal -->
    <DeleteModal :open="isActiveDeleteModal" :form="clear" :deleteLoading="deleteLoading" @close="isActiveDeleteModal = false" />

</template>

<script>

import axios from "axios";
import apiRoutes from "../../../../services/apiRoutes.js";
import apiServices from "../../../../services/apiServices.js";
import Preloader from "../../../../components/preloader.vue";
import EmptyScreen from "../../../../components/empty-screen.vue";
import DeleteModal from "../../../../components/deleteModal.vue";
import cookiesServices from "../../../../services/cookiesServices.js";

import {toast} from "vue3-toastify";

export default {
    components: {
        Preloader, EmptyScreen, DeleteModal
    },
    computed: {
        filteredList() {
            if (!this.searchQuery.trim()) return this.listData;
            return this.listData.filter(data => {
                const name = data?.customer?.name;
                const phone = data?.customer?.phone;
                const address = data?.customer?.address;
                const query = this.searchQuery.toLowerCase();
                return name?.toLowerCase().includes(query) || phone?.toLowerCase().includes(query) || address?.toLowerCase().includes(query);
            });
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
            isActiveDeleteModal: false,
            lang: 'en',
            searchQuery: '',
            currentPage: 1,
            itemsPerPage: 16,
            formData: {
                id: null,
            },
            listData: [],
            listLoading: false,
            deleteLoading: false,
        }
    },
    mounted() {
        this.lang = cookiesServices.get('lang') || "en";
        this.listApi();
    },
    methods: {
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
        async listApi() {
            try {
                this.listLoading = true;
                const response = await axios.get(apiRoutes.order, {headers: apiServices.authHeaderContent});
                this.listData = response.data.data;
            } catch (error) {
                console.log(error);
            } finally {
                this.listLoading = false;
            }
        },
        async updateApi(item) {
            try {
                this.listLoading = true;
                await axios.post(`${apiRoutes.order}/${item.id}?_method=PUT`, {status: item.status}, {headers: apiServices.authHeaderContent});
                await this.listApi();
                toast.success(this.lang === "en" ? "Order status update successfully." : "تم تحديث حالة الطلب بنجاح.")
            } catch (error) {
                console.log(error);
            } finally {
                this.listLoading = false;
            }
        },
        openDeleteModal(id) {
            if(id === 'all') {
                this.formData.id = '';
            }
            this.isActiveDeleteModal = true;
        },
        closeDeleteModal() {
            this.isActiveDeleteModal = false;
        },
        async clear() {
            try {
                this.deleteLoading = true;
                await axios.delete(apiRoutes.order + '/clear', {headers: apiServices.authHeaderContent});
                this.closeDeleteModal();
                await this.listApi();
                toast.success(this.lang === "en" ? "order clear successfully." : "أمر واضح بنجاح.")
            } catch (error) {
                console.log(error);
            } finally {
                this.deleteLoading = false;
            }
        },
    }
}

</script>
