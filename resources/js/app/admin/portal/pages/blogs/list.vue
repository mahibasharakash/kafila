<template>

    <section class="w-full px-3 sm:px-10">

        <!-- Title -->
        <div class="text-[25px]"> {{ ___('Blogs') }} </div>

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
                <router-link :to="{name:'blogs'}" class="decoration-0 text-[#21306b] duration-500 hover:text-[#3B497E] p-2 inline-block">
                    {{___(`Blogs`)}}
                </router-link>
            </li>
        </ul>

        <section class="w-full bg-white p-3 shadow-sm rounded-[0.625rem_0.625rem_0_0] h-[calc(100vh-220px)]">

            <!-- Search, Clear, route -->
            <section class="w-full block sm:flex items-center justify-between flex-wrap sm:flex-nowrap mb-2.5">

                <!-- Search -->
                <div class="sm:max-w-[350px] w-full mb-3 sm:mb-0 sm:me-2">
                    <input type="text" name="keyword" v-model="searchQuery" :placeholder="___('Search Here')" class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px] rounded-[0.625rem]" autocomplete="off"/>
                </div>

                <div class="flex justify-end items-center gap-3 w-full">

                    <!-- Clear -->
                    <button type="button" class="cursor-pointer px-10 h-[45px] text-[14px] font-medium max-w-[120px] min-w-[120px] bg-gray-200 duration-500 hover:bg-gray-300 inline-flex justify-center items-center text-gray-900 rounded-[0.625rem]" @click="openDeleteModal('all')">
                        {{___(`Clear`)}}
                    </button>

                    <!-- route -->
                    <router-link :to="{name:'blogManage',params:{id:'new'}}" class="cursor-pointer px-10 h-[45px] text-[14px] font-medium max-w-[120px] min-w-[120px] bg-[#21306b] duration-500 hover:bg-[#3B497E] inline-flex justify-center items-center text-white rounded-[0.625rem]">
                        {{ ___('Add') }}
                    </router-link>

                </div>

            </section>

            <template v-if="paginatedList.length > 0 && !listLoading">

                <!-- Blog list -->
                <div class="w-full overflow-y-auto pe-2" :class="filteredList.length > 16 ? 'h-[calc(100vh-360px)]' : 'h-[calc(100vh-310px)]'">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-3">

                        <template v-for="(each, index) in paginatedList" :key="index">

                            <!-- Blog data -->
                            <div class="w-full border border-gray-200 rounded-[0.625rem_0.625rem_0_0] relative overflow-hidden">
                                <div class="py-2 px-3 absolute top-0 end-0 z-3">
                                    <div class="relative">
                                        <button type="button" class="size-[35px] inline-flex justify-center items-center bg-gray-200/55 duration-500 hover:bg-white rounded-md cursor-pointer" @click.stop="dropdownToggle(index)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-[20px]">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z"/>
                                            </svg>
                                        </button>
                                        <div class="absolute mt-2 overflow-hidden drop-shadow-2xl z-10 duration-500 top-auto end-0 w-[150px]" :class="{ 'max-h-[250px]' : isActiveDropdown === index, 'max-h-[0px]' : isActiveDropdown !== index }" @click.stop>
                                            <div class="p-2 bg-white rounded-xl">
                                                <router-link :to="{name:'blogManage',params:{id:each.id}}" class="w-full flex mb-1 justify-start items-center py-3 px-5 cursor-pointer bg-transparent duration-500 hover:bg-gray-200 group/item rounded-xl text-gray-500 hover:text-[#21306b]" @click="dropdownToggle(index);">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="size-[16px] duration-500 stroke-gray-500 group-hover/item:stroke-[#3B497E]">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                                    </svg>
                                                    <span class="ms-2"> {{ ___('Edit') }} </span>
                                                </router-link>
                                                <button type="button" class="w-full flex justify-start items-center py-3 px-5 cursor-pointer bg-transparent duration-500 hover:bg-gray-200 group/item rounded-xl text-gray-500 hover:text-[#21306b]" @click="dropdownToggle(index);openDeleteModal(each.id)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="size-[16px] duration-500 stroke-gray-500 group-hover/item:stroke-[#3B497E]">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                                    </svg>
                                                    <span class="ms-2"> {{ ___('Delete') }} </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full block mb-5">
                                    <div class="w-full h-auto relative">
                                        <div v-if="!each.image" class="w-full flex justify-center items-center min-h-[250px] max-h-[250px] bg-gray-200 rounded-xl">
                                            300 * 200
                                        </div>
                                        <img v-else :src="each.image" class="w-full min-h-[250px] max-h-[250px] object-cover bg-cover" alt="cover"/>
                                        <div class="absolute bottom-0 start-0 text-white flex items-end justify-start pb-3 ps-4">
                                            {{each.category}}
                                        </div>
                                    </div>
                                </div>
                                <div class="py-2 px-3">
                                    <div class="w-full flex flex-wrap font-normal gap-1 mb-2">
                                        <template v-for="subEach in each.tags.split(', ')">
                                            <div class="outline-0 border-0 bg-gray-200 duration-500 hover:bg-gray-300 px-3 py-1 rounded-lg text-[14px]">
                                                {{ subEach }}
                                            </div>
                                        </template>
                                    </div>
                                    <div class="w-full block font-normal text-xl mb-2">
                                        <div class="truncate-to-2-line">
                                            {{ each.title }}
                                        </div>
                                    </div>
                                    <div class="w-full block font-normal mb-2">
                                        <div class="truncate-to-2-line">
                                            {{ each.short_description }}
                                        </div>
                                    </div>
                                    <div class="w-full block font-normal">
                                        <div class="truncate-to-3-line">
                                            <div v-html="renderEditorJsDescription(each.description)"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </template>

                    </div>
                </div>

            </template>

            <Preloader v-if="listLoading"/>

            <EmptyScreen :title="___('blog')" v-if="paginatedList.length === 0 && !listLoading"/>

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
    props: ['each'],
    components: {
        Preloader, EmptyScreen, DeleteModal
    },
    computed: {
        filteredList() {
            if (!this.searchQuery.trim()) return this.listData;
            return this.listData.filter(data => {
                const title = data.title;
                const author_name = data.author_name;
                const query = this.searchQuery.toLowerCase();
                return title?.toLowerCase().includes(query) || author_name?.toLowerCase().includes(query);
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
            singleLoading: false,
            manageLoading: false,
            listLoading: false,
            deleteLoading: false,
            isActiveDropdown: null,
            lang: 'en',
            formData: {
                id: null,
            },
            searchQuery: '',
            currentPage: 1,
            itemsPerPage: 16,
            listData: [],
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
        closeDeleteModal() {
            this.isActiveDeleteModal = false;
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
        async listApi() {
            try {
                this.listLoading = true;
                const response = await axios.get(apiRoutes.blog, {headers: apiServices.authHeaderContent});
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
                await axios.delete(apiRoutes.blog + '/' + this.formData.id, {headers: apiServices.authHeaderContent});
                this.closeDeleteModal();
                await this.listApi();
                toast.success(this.lang === "en" ? "Blog deleted successfully." : "تم حذف المدونة بنجاح.");
            } catch (error) {
                console.log(error);
            } finally {
                this.deleteLoading = false;
            }
        },
        async clear() {
            try {
                this.deleteLoading = true;
                await axios.delete(apiRoutes.blog + '/clear', {headers: apiServices.authHeaderContent});
                this.closeDeleteModal();
                await this.listApi();
                toast.success(this.lang === "en" ? "Blog clear successfully." : "تم مسح المدونة بنجاح.");
            } catch (error) {
                console.log(error);
            } finally {
                this.deleteLoading = false;
            }
        },
        async singleApi(data) {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.blog + `/${data}`, {
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
        dropdownToggle(index) {
            this.isActiveDropdown = this.isActiveDropdown === index ? null : index;
        },
        handleClickOutside() {
            this.isActiveDropdown = null;
        },
    }
}

</script>
