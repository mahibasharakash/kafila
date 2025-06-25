<template>

    <section class="w-full px-3 sm:px-10">

        <!-- Card body title -->
        <div class="text-[25px]"> {{ ___('Reviews') }} </div>

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
                <router-link :to="{name:'reviews'}" class="decoration-0 text-[#21306b] duration-500 hover:text-[#3B497E] p-2 inline-block">
                    {{___(`Reviews`)}}
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
            <template v-if="paginatedList.length > 0 && !listLoading">

                <!-- Review list -->
                <div class="w-full overflow-y-auto" :class="filteredList.length > 16 ? 'h-[calc(100vh-400px)] pe-2' : 'h-[calc(100vh-320px)]'">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-3">

                        <template v-for="(each, index) in paginatedList" :key="index">

                            <!-- Review data -->
                            <div class="w-full shadow-md border border-gray-100 rounded-xl p-5">
                                <div class="w-full flex justify-between items-center mb-3">
                                    <div> {{ each.type }}</div>
                                    <div class="size-[45px] rounded-xl inline-flex justify-center items-center bg-gray-100 duration-500 hover:bg-gray-200 cursor-pointer" @click="openViewModal(each)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-[20px]">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="w-full block mb-5">
                                    <div v-if="!each?.related_data?.image" class="w-full flex justify-center items-center min-h-[150px] max-h-[150px] bg-gray-200 rounded-xl">
                                        300 * 200
                                    </div>
                                    <img v-else :src="each?.related_data.image" class="w-full min-h-[150px] max-h-[150px] object-cover bg-cover" alt="cover"/>
                                </div>
                                <div class="w-full block font-semibold min-h-[55px]">
                                    <div class="truncate-to-2-line">
                                        {{ each.related_data?.title }}
                                    </div>
                                </div>
                                <div class="w-full block font-normal min-h-[55px]">
                                    <div class="truncate-to-2-line">
                                        {{ each.related_data?.description }}
                                    </div>
                                </div>
                                <template v-if="each.reviews.length">
                                    <div class="bg-gray-200 p-5 mt-3 rounded-md">
                                        <div class="min-h-[55px]">
                                            <div class="w-full truncate-to-2-line">
                                                {{ each.reviews[each.reviews.length - 1].message }}
                                            </div>
                                        </div>
                                        <div class="text-end mt-2">
                                            - {{ each.reviews[each.reviews.length - 1].name }}
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                    </div>
                </div>
            </template>

            <Preloader v-if="listLoading"/>

            <EmptyScreen :title="___('review')" v-if="paginatedList.length === 0 && !listLoading"/>

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

    <!-- view modal -->
    <section class="fixed inset-0 size-full grid sm:justify-center items-center duration-500 z-50 p-5 overflow-y-auto" :class="{ 'invisible bg-black/35' : !isActiveViewModal, 'visible bg-black/65' : isActiveViewModal }" @click="isActiveViewModal = false">
        <aside class="bg-white rounded-3xl w-full sm:max-w-[550px] sm:min-w-[550px] p-10 duration-500 origin-top" :class="{ 'translate-y-0 opacity-100' : isActiveViewModal, '-translate-y-1/2 opacity-0' : !isActiveViewModal }" @click.stop>
            <div class="w-full block">
                <div class="mb-3 flex justify-between items-center">
                    <div class="text-[25px]"> {{ ___('Review') }} </div>
                    <button type="button" class="size-[45px] inline-flex justify-center items-center bg-transparent duration-500 hover:bg-gray-200 rounded-xl cursor-pointer" @click="closeViewModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-[25px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="w-full block">
                    <div class="font-bold mb-2 text-2xl"> {{ eachData?.related_data?.title }}</div>
                    <div class="w-full mb-3 block">
                        <img :src="eachData?.related_data?.image" class="w-full min-h-[250px] max-h-[250px] object-cover bg-cover" :alt="eachData?.id">
                    </div>
                    <div class="w-full mb-2 block">
                        <div class="truncate-to-3-line">
                            {{ eachData?.related_data?.description }}
                        </div>
                    </div>
                    <template v-for="each in eachData?.reviews">
                        <div class="bg-gray-100 p-5 rounded-xl mt-2">
                            {{ each.message }}
                            <div class="mt-2 text-end"> - {{ each.name }}</div>
                        </div>
                    </template>
                </div>
            </div>
        </aside>
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
                const title = data.title;
                const query = this.searchQuery.toLowerCase();
                return title?.toLowerCase().includes(query);
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
            attach_preview: null,
            isActiveDropdown: null,
            error: {},
            isActiveViewModal: false,
            eachData: null,
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
        openViewModal(eachSingle) {
            this.eachData = eachSingle
            this.isActiveViewModal = true;
        },
        closeViewModal() {
            this.isActiveViewModal = false;
        },
        async listApi() {
            try {
                this.listLoading = true;
                const response = await axios.get(apiRoutes.review, {headers: apiServices.authHeaderContent});
                this.listData = response.data.data;
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
                await axios.delete(apiRoutes.review + '/clear', {headers: apiServices.authHeaderContent});
                this.closeDeleteModal();
                await this.listApi();
                toast.success(this.lang === "en" ? "Review clear successfully." : "تمت المراجعة بنجاح.")
            } catch (error) {
                console.log(error);
            } finally {
                this.deleteLoading = false;
            }
        },
    }
}

</script>
