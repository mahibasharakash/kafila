<template>

    <section class="w-full px-3 sm:px-10">

        <!-- Title -->
        <div class="text-[25px]"> {{ ___('Translations') }} </div>

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
                <router-link :to="{name:'translations'}" class="decoration-0 text-[#21306b] duration-500 hover:text-[#3B497E] p-2 inline-block">
                    {{___(`Translations`)}}
                </router-link>
            </li>
        </ul>

        <!-- Card body -->
        <section class="w-full bg-white p-3 shadow-sm rounded-[0.625rem_0.625rem_0_0] h-[calc(100vh-220px)]">

            <!-- Card header -->
            <section class="w-full block sm:flex items-center justify-between flex-wrap sm:flex-nowrap mb-2.5">

                <!-- Search -->
                <div class="sm:max-w-[350px] w-full mb-3 sm:mb-0 sm:me-2">
                    <input type="text" name="keyword" v-model="searchQuery" :placeholder="___('Search Here')" class="placeholder-[#21306b] w-full text-[14px] outline-0 min-h-[45px] rounded-[0.625rem] border border-gray-200 bg-white px-5" autocomplete="off"/>
                </div>

                <div class="flex justify-end items-center gap-3 w-full">

                    <!-- Clear -->
                    <button type="button" class="cursor-pointer px-10 h-[45px] text-[14px] font-medium max-w-[120px] min-w-[120px] bg-gray-200 duration-500 hover:bg-gray-300 inline-flex justify-center items-center text-gray-900 rounded-[0.625rem]" @click="openDeleteModal('all')">
                        {{___(`Clear`)}}
                    </button>

                    <!-- route -->
                    <button type="button" class="cursor-pointer px-10 h-[45px] text-[14px] font-medium max-w-[120px] min-w-[120px] bg-[#21306b] duration-500 hover:bg-[#3B497E] inline-flex justify-center items-center text-white rounded-[0.625rem]" @click="openManageModal(null)">
                        {{ ___('Add') }}
                    </button>

                </div>

            </section>

            <template v-if="paginatedList.length > 0 && !listLoading">

                <div class="w-full overflow-y-auto" :class="filteredList.length > 16 ? 'h-[calc(100vh-400px)] pe-2' : 'h-[calc(100vh-320px)]'">

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">

                        <template v-for="(each, index) in paginatedList" :key="index">
                            <div class="w-full shadow-md border border-gray-100 rounded-xl p-5">
                                <div class="w-full flex justify-between items-center mb-3">
                                    <div>
                                        {{ ___('Translation') }}
                                    </div>
                                    <div class="relative">
                                        <button type="button" class="size-[35px] inline-flex justify-center items-center bg-transparent duration-500 hover:bg-gray-200 rounded-xl cursor-pointer" @click.stop="dropdownToggle(index)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-[20px]">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z"/>
                                            </svg>
                                        </button>
                                        <div class="absolute overflow-hidden drop-shadow-2xl z-10 duration-500 top-auto end-0 w-[150px]" :class="{ 'max-h-[250px]' : isActiveDropdown === index, 'max-h-[0px]' : isActiveDropdown !== index }" @click.stop>
                                            <div class="p-2 bg-white rounded-xl">
                                                <button type="button" class="w-full flex mb-1 justify-start items-center py-3 px-5 cursor-pointer bg-transparent duration-500 hover:bg-gray-100 group/item rounded-xl hover:text-[#21306b]" @click="dropdownToggle(index);openManageModal(each)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="size-[16px] duration-500 stroke-black group-hover/item:stroke-[#21306b]">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                                    </svg>
                                                    <span class="ms-2"> {{ ___('Edit') }} </span>
                                                </button>
                                                <button type="button" class="w-full flex justify-start items-center py-3 px-5 cursor-pointer bg-transparent duration-500 hover:bg-gray-100 group/item rounded-xl hover:text-[#21306b]" @click="dropdownToggle(index);openDeleteModal(each.id)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="size-[16px] duration-500 stroke-black group-hover/item:stroke-[#21306b]">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                                    </svg>
                                                    <span class="ms-2"> {{ ___('Delete') }} </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full block font-normal pb-3">
                                    <div class="mb-2 block w-full">
                                        {{ each.en }}
                                    </div>
                                    <div class="block w-full">
                                        {{ each.ar }}
                                    </div>
                                </div>
                            </div>
                        </template>

                    </div>

                </div>

            </template>

            <Preloader v-if="listLoading"/>

            <EmptyScreen :title="___('translation')" v-if="paginatedList.length === 0 && !listLoading"/>

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
    <section class="fixed inset-0 size-full flex justify-center items-center duration-500 z-50" :class="{ 'invisible bg-black/35' : !isActiveManageModal, 'visible bg-black/65' : isActiveManageModal }" @click="isActiveManageModal = false">
        <aside class="bg-white rounded-3xl w-full max-w-[550px] p-10 duration-500 origin-top" :class="{ 'translate-y-0 opacity-100' : isActiveManageModal, '-translate-y-1/2 opacity-0' : !isActiveManageModal }" @click.stop>
            <form @submit="manageApi($event)" class="w-full block">
                <div class="mb-3 flex justify-between items-center">
                    <div class="text-[25px]">
                        <template v-if="!formData.id">
                            {{ ___('Create') }}
                        </template>
                        <template v-if="formData.id">
                            {{ ___('Edit') }}
                        </template>
                        {{ ___('Translation') }}
                    </div>
                    <button type="button" class="size-[45px] inline-flex justify-center items-center bg-transparent duration-500 hover:bg-gray-200 rounded-xl cursor-pointer" @click="closeManageModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-[25px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="w-full block mb-3">
                    <label for="en" class="w-full block mb-1">
                        {{ ___('English Text') }}
                    </label>
                    <textarea name="en" id="en" v-model="formData.en" class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] px-4 text-[13px] h-auto px-5 py-4" cols="30" rows="5" autocomplete="off"></textarea>
                    <div class="mt-1 text-rose-500 text-[13px]" v-if="error?.en">
                        {{ ___('This english text field is required') }}
                    </div>
                </div>
                <div class="w-full block mb-3">
                    <label for="ar" class="w-full block mb-1">
                        {{ ___('Arabic Text') }}
                    </label>
                    <textarea name="ar" id="ar" v-model="formData.ar" class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] px-4 text-[13px] h-auto px-5 py-4" cols="30" rows="5" autocomplete="off"></textarea>
                    <div class="mt-1 text-rose-500 text-[13px]" v-if="error?.ar">
                        {{ ___('This arabic text field is required') }}
                    </div>
                </div>
                <div class="w-full flex justify-end items-center gap-2 font-medium">
                    <button type="button" class="duration-500 bg-gray-100 text-gray-800 hover:bg-gray-600 hover:text-white max-w-[120px] min-w-[120px] h-[45px] inline-flex justify-center items-center rounded-xl cursor-pointer" @click="closeManageModal()">
                        {{ ___('Cancel') }}
                    </button>
                    <button type="submit" class="max-w-[120px] min-w-[120px] h-[45px] btn-theme" v-if="!manageLoading">
                        <template v-if="!formData.id"> {{ ___('Save') }}</template>
                        <template v-if="formData.id"> {{ ___('Update') }}</template>
                    </button>
                    <button type="button" disabled class="max-w-[120px] min-w-[120px] h-[45px] btn-theme" v-if="manageLoading">
                        <span class="size-[18px] inline-block border-2 border-white border-t-transparent animate-spin rounded-full"></span>
                    </button>
                </div>
            </form>
        </aside>
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
                const title_en = data.en;
                const title_ar = data.ar;
                const query = this.searchQuery.toLowerCase();
                return title_en?.toLowerCase().includes(query) || title_ar?.toLowerCase().includes(query);
            });
        },
        totalPages() {
            return Math.ceil(this.filteredList.length / this.itemsPerPage);
        },
        paginatedList() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return [...this.filteredList].sort((a, b) => b.id - a.id).slice(start, end);
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
            manageLoading: false,
            listLoading: false,
            deleteLoading: false,
            lang: 'en',
            searchQuery: '',
            currentPage: 1,
            itemsPerPage: 16,
            formData: {id: null, en: '', ar: ''},
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
        async listApi() {
            try {
                this.listLoading = true;
                const response = await axios.get(apiRoutes.translation, {headers: apiServices.authHeaderContent});
                this.listData = response.data;
            } catch (error) {
                console.log(error);
            } finally {
                this.listLoading = false;
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
        openManageModal(data = null) {
            this.error = {};
            if (data) {
                this.formData = {
                    id: data.id,
                    en: data.en,
                    ar: data.ar
                };
            } else {
                this.formData = {
                    id: null,
                    en: '',
                    ar: ''
                }
            }
            this.isActiveManageModal = true;
        },
        closeManageModal() {
            this.isActiveManageModal = false;
        },
        async manageApi(event) {
            event.preventDefault();
            if (!this.formData.id) {
                await this.createApi();
            } else {
                await this.updateApi();
            }
        },
        async createApi() {
            try {
                this.error = {};
                this.manageLoading = true;
                await axios.post(apiRoutes.translation, this.formData, {headers: apiServices.authHeaderContent});
                this.closeManageModal();
                await this.listApi();
                toast.success(this.lang === "en" ? "Translation created successfully." : "تم إنشاء الترجمة بنجاح.")
            } catch (error) {
                this.error = error?.response?.data?.errors
            } finally {
                this.manageLoading = false;
            }
        },
        async updateApi() {
            try {
                this.error = {};
                this.manageLoading = true;
                await axios.put(apiRoutes.translation + '/' + this.formData.id, this.formData, {headers: apiServices.authHeaderContent});
                this.closeManageModal();
                await this.listApi();
                toast.success(this.lang === "en" ? "Translation updated successfully." : "تم تحديث الترجمة بنجاح.")
            } catch (error) {
                this.error = error?.response?.data?.errors
            } finally {
                this.manageLoading = false;
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
                await axios.delete(apiRoutes.translation + '/' + this.formData.id, {headers: apiServices.authHeaderContent});
                this.closeDeleteModal();
                await this.listApi();
                toast.success(this.lang === "en" ? "Translation deleted successfully." : "تم حذف الترجمة بنجاح.")
            } catch (error) {
                console.log(error);
            } finally {
                this.deleteLoading = false;
            }
        },
        async clear() {
            try {
                this.deleteLoading = true;
                await axios.delete(apiRoutes.translation + '/clear', {headers: apiServices.authHeaderContent});
                this.closeDeleteModal();
                await this.listApi();
                toast.success(this.lang === "en" ? "Translation clear successfully." : "تم مسح الترجمة بنجاح.")
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
