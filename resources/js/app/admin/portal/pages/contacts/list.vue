<template>

    <section class="w-full px-3 sm:px-10">

        <!-- Card body title -->
        <div class="text-[25px]"> {{ ___('Contacts') }} </div>

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
                <router-link :to="{name:'contacts'}" class="decoration-0 text-[#21306b] duration-500 hover:text-[#3B497E] p-2 inline-block">
                    {{___(`Contacts`)}}
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

                <!-- Clear -->
                <button type="button" class="cursor-pointer px-10 h-[45px] text-[14px] font-medium max-w-[120px] min-w-[120px] bg-gray-200 duration-500 hover:bg-gray-300 inline-flex justify-center items-center text-gray-900 rounded-[0.625rem]" @click="openDeleteModal('all')">
                    {{___(`Clear`)}}
                </button>

            </section>

            <template v-if="paginatedList.length > 0 && !listLoading">

                <!-- contact list -->
                <div class="w-full overflow-y-auto pe-2" :class="filteredList.length > 16 ? 'h-[calc(100vh-360px)]' : 'h-[calc(100vh-310px)]'">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-3">

                        <template v-for="(each, index) in paginatedList" :key="index">

                            <!-- contact data -->
                            <div class="w-full border border-gray-200 rounded-[0.625rem_0.625rem_0_0] relative overflow-hidden p-5">
                                <div class="w-full flex justify-end items-center mb-3">
                                    <div class="relative">
                                        <button type="button" class="size-[35px] inline-flex justify-center items-center bg-transparent duration-500 hover:bg-gray-200 rounded-xl cursor-pointer" @click.stop="dropdownToggle(index)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-[20px]">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z"/>
                                            </svg>
                                        </button>
                                        <div class="absolute overflow-hidden drop-shadow-2xl z-10 duration-500 top-auto end-0 w-[150px]" :class="{ 'max-h-[250px]' : isActiveDropdown === index, 'max-h-[0px]' : isActiveDropdown !== index }" @click.stop>
                                            <div class="p-2 bg-white rounded-xl">
                                                <button type="button" class="w-full flex justify-start items-center py-3 px-5 cursor-pointer bg-transparent duration-500 hover:bg-gray-100 group/item rounded-xl hover:text-[#21306b]" @click="dropdownToggle(index);openViewModal(each)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="size-[16px] duration-500 stroke-black group-hover/item:stroke-[#21306b]">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                                    </svg>
                                                    <span class="ms-2"> {{ ___('View') }} </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full block">
                                    <div class="font-medium block">
                                        {{___(`Name`)}}:
                                    </div>
                                    <div class="mb-2 font-normal text-gray-600">
                                        {{ each.name }}
                                    </div>
                                    <div class="font-medium block">
                                        {{___(`Email`)}}:
                                    </div>
                                    <div class="mb-2 font-normal text-gray-600">
                                        {{ each.email }}
                                    </div>
                                    <div class="font-medium block"> {{___(`Message`)}}:</div>
                                    <div class="font-normal">
                                        <div class="truncate-to-2-line text-gray-600">
                                            {{ each.message }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                    </div>
                </div>
            </template>

            <Preloader v-if="listLoading"/>

            <EmptyScreen :title="___('contact')" v-if="paginatedList.length === 0 && !listLoading"/>

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

    <!-- manage modal -->
    <section class="fixed inset-0 size-full grid sm:justify-center items-center duration-500 z-50 p-5 overflow-y-auto" :class="{ 'invisible bg-black/35' : !isActiveViewModal, 'visible bg-black/65' : isActiveViewModal }" @click="isActiveViewModal = false">
        <aside class="bg-white rounded-3xl w-full sm:max-w-[550px] sm:min-w-[550px] p-10 duration-500 origin-top" :class="{ 'translate-y-0 opacity-100' : isActiveViewModal, '-translate-y-1/2 opacity-0' : !isActiveViewModal }" @click.stop>
            <div class="w-full block">
                <div class="mb-3 flex justify-between items-center">
                    <div class="text-[25px]">
                        {{ ___('View') }} {{ ___('Contact') }}
                    </div>
                    <button type="button" class="size-[45px] inline-flex justify-center items-center bg-transparent duration-500 hover:bg-gray-200 rounded-xl cursor-pointer" @click="closeManageModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-[25px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="w-full block mb-3">
                    <div class="w-full block mb-1 font-medium"> {{ ___('Name') }}</div>
                    <div class="mb-2 block w-full text-[15px]">
                        {{ formData.name }}
                    </div>
                    <div class="w-full block mb-1 font-medium"> {{ ___('Email') }}</div>
                    <div class="mb-2 block w-full text-[15px]">
                        {{ formData.email }}
                    </div>
                    <div class="w-full block mb-1 font-medium"> {{ ___('Message') }}</div>
                    <div class="block w-full text-[15px]">
                        {{ formData.message }}
                    </div>
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
        EmptyScreen, Preloader, DeleteModal
    },
    computed: {
        filteredList() {
            if (!this.searchQuery.trim()) return this.listData;
            return this.listData.filter(data => {
                const name = data.name;
                const email = data.email;
                const query = this.searchQuery.toLowerCase();
                return name?.toLowerCase().includes(query) || email?.toLowerCase().includes(query);
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
            isActiveViewModal: false,
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
                name: '',
            },
            listData: [],
            isActiveDropdown: null,
            error: {},
        }
    },
    mounted() {
        this.lang = cookiesServices.get('lang') || "en";
        this.listApi();
        document.addEventListener('click', this.handleClickOutside);
    },
    beforeUnmount() {
        document.removeEventListener('click', this.handleClickOutside);
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
        openViewModal(data = null) {
            if (data) {
                this.formData = {
                    id: data.id,
                    name: data.name,
                    email: data.email,
                    message: data.message,
                }
            } else {
                this.formData = {
                    id: null,
                    name: '',
                    email: '',
                    message: '',
                }
            }
            this.isActiveViewModal = true;
        },
        closeManageModal() {
            this.isActiveViewModal = false;
        },
        async listApi() {
            try {
                this.listLoading = true;
                const response = await axios.get(apiRoutes.contact, {headers: apiServices.authHeaderContent});
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
                await axios.delete(apiRoutes.contact + '/clear', {headers: apiServices.authHeaderContent});
                this.closeDeleteModal();
                await this.listApi();
                toast.success(this.lang === "en" ? "Contact clear successfully." : "تم مسح الاتصال بنجاح")
            } catch (error) {
                console.log(error);
            } finally {
                this.deleteLoading = false;
            }
        },
        dropdownToggle(index) {
            this.isActiveDropdown = this.isActiveDropdown === index ? null : index;
        },
        handleClickOutside() {
            this.isActiveDropdown = null;
        }
    }
}

</script>
