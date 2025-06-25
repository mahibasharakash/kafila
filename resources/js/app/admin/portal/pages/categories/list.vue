<template>

    <section class="w-full px-3 sm:px-10">

        <!-- Card body title -->
        <div class="text-[25px]"> {{ ___('Categories') }} </div>

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
                <router-link :to="{name:'categories'}" class="decoration-0 text-[#21306b] duration-500 hover:text-[#3B497E] p-2 inline-block">
                    {{___(`Categories`)}}
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

                <!-- Categories list -->
                <div class="w-full overflow-y-auto pe-2" :class="filteredList.length > 16 ? 'h-[calc(100vh-360px)]' : 'h-[calc(100vh-310px)]'">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">

                        <template v-for="(each, index) in paginatedList" :key="index">

                            <!-- Category data -->
                            <div class="w-full shadow-md border border-gray-100 rounded-xl p-3">
                                <div class="relative w-full">
                                    <div class="absolute top-0 end-0 flex justify-end items-center p-3">
                                        <div class="relative">
                                            <button type="button" class="size-[35px] inline-flex justify-center items-center bg-white/85 duration-500 hover:bg-gray-200 rounded-xl cursor-pointer" @click.stop="dropdownToggle(index)">
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
                                    <div class="block w-full mb-3">
                                        <img :src="each.image"
                                             class="w-full rounded-xl min-h-[250px] max-h-[250px] h-[250px] bg-cover object-cover"
                                             alt="image"/>
                                    </div>
                                    <div class="w-full block font-semibold text-[14px] text-center">
                                        {{ each.name }}
                                    </div>
                                </div>
                            </div>
                        </template>

                    </div>
                </div>
            </template>

            <Preloader v-if="listLoading"/>

            <EmptyScreen :title="___('category')" v-if="paginatedList.length === 0 && !listLoading"/>

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
    <section class="fixed inset-0 size-full grid sm:justify-center items-center duration-500 z-50 p-5 overflow-y-auto" :class="{ 'invisible bg-black/35' : !isActiveManageModal, 'visible bg-black/65' : isActiveManageModal }" @click="isActiveManageModal = false">
        <aside class="bg-white rounded-3xl w-full sm:max-w-[550px] sm:min-w-[550px] p-10 duration-500 origin-top" :class="{ 'translate-y-0 opacity-100' : isActiveManageModal, '-translate-y-1/2 opacity-0' : !isActiveManageModal }" @click.stop>
            <form @submit.prevent="manageApi" class="w-full block">
                <div class="mb-3 flex justify-between items-center">
                    <div class="text-[25px]">
                        <template v-if="!formData.id"> {{ ___('Create') }} </template>
                        <template v-if="formData.id"> {{ ___('Edit') }} </template>
                        {{ ___('Category') }}
                    </div>
                    <button type="button" class="size-[45px] inline-flex justify-center items-center bg-transparent duration-500 hover:bg-gray-200 rounded-xl cursor-pointer" @click="closeManageModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-[25px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="w-full mb-3">
                    <div class="w-full flex justify-center">
                        <template v-if="!attach_preview">
                            <label for="image" class="w-full max-h-[250px] min-h-[250px] rounded-xl bg-[#21306b]/15 duration-500 hover:bg-[#21306b]/35 group cursor-pointer flex justify-center items-center">
                                <input id="image" type="file" name="image" hidden="hidden" autocomplete="off" accept="image/*" @change="attachFile($event)"/>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="size-[45px] stroke-[#21306b] duration-500 group-hover:stroke-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                                    </svg>
                                </span>
                            </label>
                        </template>
                        <template v-if="attach_preview">
                            <div class="relative w-full flex justify-center items-center">
                                <img :src="attach_preview" class="w-full max-h-[250px] min-h-[250px] object-cover bg-cover" alt="attach_file"/>
                                <div class="absolute inset-0 flex justify-center items-center w-full h-full bg-transparent duration-500 hover:bg-gray-200/25 backdrop-blur-none hover:backdrop-blur-sm">
                                    <button type="button" class="size-[45px] inline-flex justify-center items-center rounded-xl bg-rose-400 duration-500 hover:bg-rose-700 cursor-pointer" @click="removeFile()">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="size-6 stroke-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="mt-1 text-rose-500 text-[13px]" v-if="error?.image"> {{ error?.image[0] }}</div>
                </div>
                <div class="w-full block mb-3">
                    <label for="name" class="w-full block mb-1">
                        {{ ___('Name') }}
                    </label>
                    <input type="text" name="name" id="name" v-model="formData.name" class="w-full block outline-0 rounded-xl bg-white border border-gray-300 duration-500 focus-within:border-[#3B497E] h-[45px] px-5" autocomplete="off"/>
                    <div class="mt-1 text-rose-500 text-[13px]" v-if="error?.name"> {{ error?.name[0] }}</div>
                </div>
                <div class="w-full flex justify-end items-center gap-2 font-medium">
                    <button type="button" class="cursor-pointer px-10 h-[45px] text-[14px] font-medium max-w-[120px] min-w-[120px] bg-gray-200 duration-500 hover:bg-gray-300 inline-flex justify-center items-center text-gray-900 rounded-[0.625rem]" @click="closeManageModal()">
                        {{ ___('Cancel') }}
                    </button>
                    <button type="submit" class="cursor-pointer px-10 h-[45px] text-[14px] font-medium max-w-[120px] min-w-[120px] bg-[#21306b] duration-500 hover:bg-[#3B497E] inline-flex justify-center items-center text-white rounded-[0.625rem]" v-if="!manageLoading">
                        <template v-if="!formData.id"> {{ ___('Save') }}</template>
                        <template v-if="formData.id"> {{ ___('Update') }}</template>
                    </button>
                    <button type="button" disabled class="cursor-pointer px-10 h-[45px] text-[14px] font-medium max-w-[120px] min-w-[120px] bg-[#21306b] duration-500 hover:bg-[#3B497E] inline-flex justify-center items-center text-white rounded-[0.625rem]" v-if="manageLoading">
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
        EmptyScreen, Preloader, DeleteModal
    },
    computed: {
        filteredList() {
            if (!this.searchQuery.trim()) return this.listData;
            return this.listData.filter(data => {
                const name = data.name;
                const query = this.searchQuery.toLowerCase();
                return name?.toLowerCase().includes(query);
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
                name: '',
                image: null,
            },
            listData: [],
            isActiveDropdown: null,
            error: {},
            attach_preview: null,
            attachLoading: false,
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
        openDeleteModal(id) {
            if(id === 'all') {
                this.formData.id = '';
            } else {
                this.singleApi(id)
                this.formData.id = id;
            }
            this.isActiveDeleteModal = true;
        },
        async singleApi(data) {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.category + `/${data}`, {headers: apiServices.authHeaderContent,});
                this.formData = response?.data?.data;
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.loading = false;
            }
        },
        closeDeleteModal() {
            this.isActiveDeleteModal = false;
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
        openManageModal(data = null) {
            this.error = {};
            if (data) {
                this.formData = {
                    id: data.id,
                    image: data.image,
                    name: data.name,
                }
                this.attach_preview = data.image;
            } else {
                this.formData = {
                    id: null,
                    image: null,
                    name: '',
                }
                this.attach_preview = null;
            }
            this.isActiveManageModal = true;
        },
        closeManageModal() {
            this.isActiveManageModal = false;
        },
        async listApi() {
            try {
                this.listLoading = true;
                const response = await axios.get(apiRoutes.category, {headers: apiServices.authHeaderContent});
                this.listData = response.data.data;
            } catch (error) {
                console.log(error);
            } finally {
                this.listLoading = false;
            }
        },
        async manageApi() {
            if (!this.formData.id) {
                await this.createApi();
            } else {
                await this.updateApi();
            }
        },
        async createApi() {
            try {
                this.manageLoading = true;
                const formData = new FormData();
                if (this.formData.image) {
                    formData.append('image', this.formData.image);
                }
                formData.append('name', this.formData.name);
                await axios.post(apiRoutes.category, formData, {headers: apiServices.authHeaderMediaContent});
                this.closeManageModal();
                await this.listApi();
                toast.success(this.lang === "en" ? "Category created successfully." : "تم إنشاء الفئة بنجاح.")
            } catch (error) {
                this.error = error?.response?.data?.errors
            } finally {
                this.manageLoading = false;
            }
        },
        async updateApi() {
            try {
                this.manageLoading = true;
                const formData = new FormData();
                if (this.formData.image) {
                    formData.append('image', this.formData.image);
                }
                formData.append('name', this.formData.name);
                await axios.post(apiRoutes.category + '/' + this.formData.id + '?_method=PUT', formData, {headers: apiServices.authHeaderMediaContent});
                this.closeManageModal();
                await this.listApi();
                toast.success(this.lang === "en" ? "Category updated successfully." : "تم تحديث الفئة بنجاح.")
            } catch (error) {
                this.error = error?.response?.data?.errors
            } finally {
                this.manageLoading = false;
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
                await axios.delete(apiRoutes.category + '/' + this.formData.id, {headers: apiServices.authHeaderContent});
                this.closeDeleteModal();
                await this.listApi();
                toast.success(this.lang === "en" ? "Category deleted successfully." : "تم حذف الفئة بنجاح.")
            } catch (error) {
                console.log(error);
            } finally {
                this.deleteLoading = false;
            }
        },
        async clear() {
            try {
                this.deleteLoading = true;
                await axios.delete(apiRoutes.category + '/clear', {headers: apiServices.authHeaderContent});
                this.closeDeleteModal();
                await this.listApi();
                toast.success(this.lang === "en" ? "Category clear successfully." : "تم مسح الفئة بنجاح.")
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
