<template>

    <!-- breadcrumb -->
    <Breadcrumb :title="___(`Products`)"
                :links="[ { label: ___(`Home`), href: 'home' }, { label: ___(`Products`), href: 'products' }, { label: ___(`Product Details`), href: 'productDetails' } ]"></Breadcrumb>

    <section class="w-full py-3 sm:py-16 block">
        <div class="mx-auto max-w-[1200px] w-full px-5 sm:px-10">

            <template v-if="singleData?.description">

                <div class="w-full flex flex-wrap">
                    <div class="w-full lg:w-2/5 mb-16">
                        <img :src="singleData?.image"
                             class="object-cover bg-cover w-full min-h-[300px] lg:min-h-[500px] max-h-[300px] lg:max-h-[500px]"
                             alt="product"/>
                    </div>
                    <div class="w-full lg:w-3/5 ps-3">
                        <div class="text-2xl mb-3 block"> {{ singleData?.title }}</div>
                        <div class="text-lg mb-3 block">
                            <del class="text-gray-400 me-2"> ${{ singleData?.price }}</del>
                            <span
                                class="text-[#21306b]"> ${{ parseFloat(singleData?.price - discount).toFixed(2) }} </span>
                        </div>
                        <div class="text-md mb-3 block"> {{ ___(`Category`) }} : {{ singleData?.category?.name }}</div>
                        <div class="text-md mb-3 block"> {{ ___(`Brand`) }} : {{ singleData?.brand?.name }}</div>
                        <div class="text-md mb-3 block"> {{ ___(`Available`) }} : {{ singleData?.quantity }}</div>
                        <div class="w-full mb-4 block"> {{ ___(`Description`) }} :
                            <div class="text-gray-600 mt-5 whitespace-break-spaces"
                                 v-html="renderEditorJsDescription(singleData?.description)"></div>
                        </div>
                        <div class="mb-3 grid grid-cols-1 md:grid-cols-2  gap-3 w-full">
                            <button type="button" :disabled="parseInt(singleData?.quantity) === 0"
                                    :class="{ 'cursor-pointer' : parseInt(singleData?.quantity) !== 0, 'pointer-events-none' : parseInt(singleData?.quantity) === 0 }"
                                    class="flex justify-center items-center w-full py-4 px-3 rounded-lg bg-gray-200 duration-500 hover:bg-[#21306b]"
                                    @click="addToCart(singleData)">
                                {{ ___(`Add To Cart`) }}
                            </button>
                            <button type="button"
                                    class="flex justify-center items-center w-full py-4 px-3 rounded-lg cursor-pointer bg-gray-200 duration-500 hover:bg-rose-600 hover:text-white">
                                {{ ___(`Add To Wishlist`) }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-10 w-full p-5 bg-gray-100 rounded-lg mb-3">
                    <form @submit.prevent="feedback()">
                        <div class="text-2xl pb-3 px-3"> {{ ___(`Comment`) }}</div>
                        <div class="w-full flex flex-wrap">
                            <div class="w-full md:w-1/2 px-3">
                                <!-- name -->
                                <div class="mb-3 block text-[14px]">
                                    <label for="user-name" class="block w-full mb-1"> {{ ___(`Your Name`) }}
                                        <span class="text-[#21306b]">*</span>
                                    </label>
                                    <input id="user-name" type="text" v-model="reviewParam.name" name="name"
                                           class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]"
                                           required autocomplete="off"/>
                                </div>
                            </div>
                            <div class="w-full px-3">
                                <!-- message -->
                                <div class="mb-3 block text-[14px]">
                                    <label for="user-message" class="block w-full mb-1">
                                        {{ ___(`Your Message`) }} <span class="text-[#21306b]">*</span>
                                    </label>
                                    <textarea id="user-message" name="message" v-model="reviewParam.message" cols="30" rows="3"
                                              class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] px-4 text-[13px] h-auto px-5 py-4"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- submit button -->
                        <div class="block text-[14px] px-3">
                            <button type="submit" v-if="!messageLoading"
                                    class="min-w-[170px] max-w-[170px] max-h-[50px] min-h-[50px] btn-theme">
                                {{ ___(`Send Message`) }}
                            </button>
                            <button type="button" v-if="messageLoading" class="min-w-[170px] max-w-[170px] max-h-[50px] min-h-[50px] btn-theme">
                                <span
                                    class="inline-block size-[20px] rounded-full border-2 border-white border-t-transparent animate-spin"></span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="w-full block mb-2" v-for="each in reviewData" :key="each.id"
                     v-if="!ListDataLoading && reviewData.length > 0">
                    <div class="bg-gray-100 px-5 py-4 rounded-xl w-full">
                        <div class="w-full block">
                            {{ each.message }}
                        </div>
                        <div class="mt-2 text-end">
                            - {{ each.name }}
                        </div>
                    </div>
                </div>

            </template>

            <template v-if="!singleData?.description && !loading">

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
                        {{ ___(`Currently there have no product details.`) }}
                    </div>
                </div>

            </template>

            <section class="w-full h-[650px] min-h-[650px] object-cover bg-cover flex justify-center items-center"
                     v-if="loading">
                <span class="screen-loader"></span>
            </section>

        </div>
    </section>

</template>

<script>

import axios from "axios";
import {useRoute} from "vue-router";
import Breadcrumb from "../../../../components/breadcrumb.vue";
import apiServices from "../../../../services/apiServices.js";
import apiRoutes from "../../../../services/apiRoutes.js";
import store from "../../../../store/index.js";
import cookiesServices from "../../../../services/cookiesServices.js";

export default {
    components: {
        Breadcrumb
    },
    data() {
        return {
            discount: 10,
            cart: [],
            lang: 'en',
            loading: false,
            reviewParam: {
                id: null,
                type: 'product',
                name: '',
                message: '',
            },
            reviewData: [],
            error: {},
            singleData: window.history.state,
            messageLoading: false,
            ListDataLoading: false,
            editor: null,
            editorData: null,
        }
    },
    mounted() {
        this.lang = cookiesServices.get('lang') || "en";
        const route = useRoute();
        const routeId = JSON.parse(route.params.id);
        if (routeId) {
            this.singleApi(route.params.id);
            this.reviewParam.id = route.params.id;
        }
        this.fetchReviewData();
    },
    methods: {
        async feedback() {
            try {
                this.messageLoading = true;
                await axios.post(apiRoutes.review + `/store`, this.reviewParam, {headers: apiServices.authHeaderContent});
                await this.fetchReviewData();
                this.reviewParam = {type: 'product', name: '', message: ''};
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.messageLoading = false;
            }
        },
        async fetchReviewData() {
            try {
                this.ListDataLoading = true;
                const response = await axios.get(apiRoutes.review + `?type=product&id=${this.reviewParam.id}`, {headers: apiServices.authHeaderContent});
                this.reviewData = response?.data?.data;
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.ListDataLoading = false;
            }
        },
        async singleApi(data) {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.product + `/${data}`, {headers: apiServices.authHeaderContent});
                this.singleData = response.data?.data;
                if (this.editor && this.formData.description) {
                    try {
                        const blocks = typeof this.formData.description === 'string' ? JSON.parse(this.formData.description) : this.formData.description;
                        await this.editor.render(blocks);
                    } catch (e) {
                        console.error("Failed to render blocks:", e);
                        console.error("Problematic description data:", this.formData.description);
                    }
                }
            } catch (error) {
                this.error = error?.response?.data?.errors;
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
                        return `<div class="block mb-3 font-medium text-[14px]">${data.text}</div>`;
                    case 'header':
                        return `<div class="block mb-3 font-semibold text-black"> <div class="text-lg">${data.text}</div> </div>`;
                    case 'list':
                        const tag = data.style === 'ordered' ? 'ol' : 'ul';
                        const items = data.items.map(item => `<li>${item}</li>`).join('');
                        return `<div class="block mb-3 text-black text-[14px]"> <${tag}>${items}</${tag}> </div>`;
                    case 'quote':
                        return `<blockquote><div class="border-s-4 text-[14px] border-[#21306b] font-semibold bg-[#eeeeee] px-5 py-3 mb-4 text-black">${data.text}</div style="display:none;"><footer style="display: none;">${data.caption || ''}</footer></blockquote>`;
                    case 'image':
                        return `<div class="flex justify-center my-10 text-black"> <img src="${data.file.url}" class="bg-cover object-cover max-w-[576px] max-h-[350px] min-h-[350px] w-full rounded-3xl" alt="${data.caption || ''}" /> </div>`;
                    default:
                        return '';
                }
            }).join('');
        },
        addToCart(product) {
            store.dispatch("addToCart", product);
        }
    }
}

</script>
