<template>

    <section class="w-full px-3 sm:px-10">

        <!-- Card body title -->
        <div class="text-[25px]"> {{ ___('Customers') }} </div>

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
                <router-link :to="{name:'customers'}" class="decoration-0 text-[#21306b] duration-500 hover:text-[#3B497E] p-2 inline-block">
                    {{___(`Customers`)}}
                </router-link>
            </li>
        </ul>

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

            <template v-if="paginatedList.length > 0 && !listLoading">

                <!-- Customer list -->
                <div class="w-full overflow-y-auto pe-2" :class="filteredList.length > 16 ? 'h-[calc(100vh-360px)]' : 'h-[calc(100vh-310px)]'">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-3">

                        <!-- Customer data -->
                        <template v-for="(each, index) in paginatedList" :key="index">
                            <div class="w-full shadow-md border border-gray-100 rounded-xl p-5">
                                <div class="flex justify-center mb-5">
                                    <div v-if="each?.image" class="size-[125px] max-w-[125px] max-h-[125px] rounded-full overflow-hidden">
                                        <img :src="each?.image" class="object-cover bg-cover w-full h-full rounded-full overflow-hidden" :alt="each.name" />
                                    </div>
                                    <div v-else class="size-[125px] inline-flex justify-center items-center text-[35px] uppercase bg-gray-200 rounded-full">
                                        {{shortName(each?.name)}}
                                    </div>
                                </div>
                                <div class="w-full block font-normal mb-2">
                                    <div class="block"> {{___('Name')}}: </div>
                                    <div class="text-gray-700"> {{ each?.name || 'N/A' }} </div>
                                </div>
                                <div class="w-full block font-normal mb-2">
                                    <div class="block"> {{___('Email')}}: </div>
                                    <div class="text-gray-700"> {{ each?.email || 'N/A' }} </div>
                                </div>
                                <div class="w-full block font-normal mb-2">
                                    <div class="block"> {{___('Phone')}}: </div>
                                    <div class="text-gray-700"> {{ each?.phone || 'N/A' }} </div>
                                </div>
                                <div class="w-full block font-normal">
                                    <div class="block"> {{___('Address')}}: </div>
                                    <div class="text-gray-700"> {{ each?.address || 'N/A' }} </div>
                                </div>
                            </div>
                        </template>

                    </div>
                </div>
            </template>

            <Preloader v-if="listLoading"/>

            <EmptyScreen :title="___('customer')" v-if="paginatedList.length === 0 && !listLoading"/>

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
    <DeleteModal :open="isActiveDeleteModal" :form="manageDelete" :deleteLoading="deleteLoading" @close="isActiveDeleteModal = false" />

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
                const name = data.name;
                const email = data.email;
                const phone = data.phone;
                const address = data.address;
                const query = this.searchQuery.toLowerCase();
                return name?.toLowerCase().includes(query) || email?.toLowerCase().includes(query) || phone?.toLowerCase().includes(query) || address?.toLowerCase().includes(query);
            })
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
            isActiveManageModal: false,
            clearDeleteLoading: false,
            manageLoading: false,
            listLoading: false,
            deleteLoading: false,
            lang: 'en',
            searchQuery: '',
            currentPage: 1,
            itemsPerPage: 16,
            formData: {
                id: null,
            },
            listData: [],
            isActiveDropdown: null,
            error: {},
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
        openDeleteModal(id) {
            if(id === 'all') {
                this.formData.id = '';
            } else {
                this.singleApi(id)
                this.formData.id = id;
            }
            this.isActiveDeleteModal = true;
        },
        closeDeleteModal() {
            this.isActiveDeleteModal = false;
        },
        async singleApi(data) {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.customer + `/${data}`, {
                    headers: apiServices.authHeaderContent,
                });
                this.formData = response?.data?.data;
                this.attach_preview = response?.data?.data?.image;
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.loading = false;
            }
        },
        async listApi() {
            try {
                this.listLoading = true;
                const response = await axios.get(apiRoutes.customer, {headers: apiServices.authHeaderContent});
                this.listData = response.data.data;
            } catch (error) {
                console.log(error);
            } finally {
                this.listLoading = false;
            }
        },
        async manageDelete() {
            if(this.formData.id === '') {
                await this.clear();
            } else {
                await this.deleteApi();
            }
        },
        async deleteApi() {
            try {
                this.deleteLoading = true;
                await axios.delete(apiRoutes.customer + '/' + this.formData.id, {headers: apiServices.authHeaderContent});
                this.closeDeleteModal();
                await this.listApi();
                toast.success(this.lang === "en" ? "Customer deleted successfully." : "تم حذف العلامة التجارية بنجاح.");
            } catch (error) {
                console.log(error);
            } finally {
                this.deleteLoading = false;
            }
        },
        async clear() {
            try {
                this.deleteLoading = true;
                await axios.delete(apiRoutes.customer + '/clear', {headers: apiServices.authHeaderContent});
                this.closeDeleteModal();
                await this.listApi();
                toast.success(this.lang === "en" ? "Customer clear successfully." : "تم مسح العلامة التجارية بنجاح.");
            } catch (error) {
                console.log(error);
            } finally {
                this.deleteLoading = false;
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
