<template>

    <section class="w-full px-3 sm:px-10">

        <!-- Title -->
        <div class="text-[25px]">
            <template v-if="formData.id === null"> {{ ___('Product Create') }}</template>
            <template v-else> {{ ___('Product Edit') }}</template>
        </div>

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
                <router-link :to="{name:'products'}" class="decoration-0 text-[#21306b] duration-500 hover:text-[#3B497E] p-2 inline-block">
                    {{___(`Products`)}}
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
                <router-link :to="{name:'productManage',id: {params: formData.id }}" class="decoration-0 text-[#21306b] duration-500 hover:text-[#3B497E] p-2 inline-block">
                    <template v-if="formData.id === null"> {{ ___('Product Create') }}</template>
                    <template v-else> {{ ___('Product Edit') }}</template>
                </router-link>
            </li>
        </ul>

        <form @submit.prevent="manageApi()" class="w-full bg-white p-3 shadow-sm rounded-[0.625rem_0.625rem_0_0] h-[calc(100vh-220px)] overflow-y-auto">

            <div class="flex justify-end items-center gap-2">
                <router-link :to="{name:'products'}" class="cursor-pointer px-10 h-[45px] text-[14px] font-medium max-w-[120px] min-w-[120px] bg-gray-200 duration-500 hover:bg-gray-300 inline-flex justify-center items-center text-gray-900 rounded-[0.625rem]">
                    {{___(`Cancel`)}}
                </router-link>
                <button type="submit" class="cursor-pointer px-10 h-[45px] text-[14px] font-medium max-w-[120px] min-w-[120px] bg-[#21306b] duration-500 hover:bg-[#3B497E] inline-flex justify-center items-center text-white rounded-[0.625rem]" v-if="!manageLoading">
                    <template v-if="formData.id === null"> {{ ___('Save') }}</template>
                    <template v-else> {{ ___('Update') }}</template>
                </button>
                <button type="button" class="cursor-pointer px-10 h-[45px] text-[14px] font-medium max-w-[120px] min-w-[120px] bg-[#21306b] duration-500 hover:bg-[#3B497E] inline-flex justify-center items-center text-white rounded-[0.625rem]" v-if="manageLoading">
                    <span class="size-[18px] inline-block border-2 border-white border-t-transparent animate-spin rounded-full"></span>
                </button>
            </div>

            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="w-full">
                    <label for="product_title" class="block mb-1"> {{___('Product Title')}} </label>
                    <input id="product_title" type="text" name="title" v-model="formData.title" class="w-full block outline-0 rounded-md bg-white border border-gray-200 duration-500 focus-within:border-[#3B497E] h-[45px] px-5" required autocomplete="off" />
                </div>
                <div class="w-full">
                    <label for="product_price" class="block mb-1"> {{___('Product Price')}} </label>
                    <input id="product_price" type="text" name="title" v-model="formData.price" @keypress="checkNumber($event)" class="w-full block outline-0 rounded-md bg-white border border-gray-200 duration-500 focus-within:border-[#3B497E] h-[45px] px-5" required autocomplete="off" />
                </div>
                <div class="w-full">
                    <label for="product_quantity" class="block mb-1"> {{___('Product Quantity')}} </label>
                    <input id="product_quantity" type="text" name="quantity" v-model="formData.quantity" @keypress="checkNumber($event)" maxlength="3" class="w-full block outline-0 rounded-md bg-white border border-gray-200 duration-500 focus-within:border-[#3B497E] h-[45px] px-5" required autocomplete="off" />
                </div>
                <div class="w-full">
                    <label for="product_category" class="block mb-1"> {{___('Product Category')}} </label>
                    <div class="relative w-full">
                        <select name="category_id" id="product_category" v-model="formData.category_id" class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px] appearance-none" required autocomplete="off">
                            <option :value="''"> {{ ___('Select Category') }}</option>
                            <option v-for="(each, index) in categoryList" :value="each.id" :key="index">
                                {{ each.name }}
                            </option>
                            <option value="" v-if="categoryList.length === 0"> {{ ___('No Data Found') }}</option>
                        </select>
                        <div class="absolute top-0 bottom-0 end-0 pe-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                 stroke="currentColor" class="size-[15px]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="w-full">
                    <label for="product_type" class="block mb-1"> {{___('Product Type')}} </label>
                    <div class="relative w-full">
                        <select name="product_type" id="product_type" v-model="formData.product_type" class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px] appearance-none" required autocomplete="off">
                            <option :value="''"> {{ ___(`Select Product Type`) }}</option>
                            <option :value="'featured_products'"> {{ ___(`Featured Products`) }}</option>
                            <option :value="'latest_products'"> {{ ___(`Latest Products`) }}</option>
                            <option :value="'best_sellers'"> {{ ___(`Best Sellers`) }}</option>
                        </select>
                        <div class="absolute top-0 bottom-0 end-0 pe-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                 stroke="currentColor" class="size-[15px]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="w-full">
                    <label for="product_brand" class="block mb-1"> {{___('Product Brand')}} </label>
                    <div class="relative w-full">
                        <select name="brand_id" id="product_brand" v-model="formData.brand_id" class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px] appearance-none" required autocomplete="off">
                            <option :value="''"> {{ ___('Select Brand') }}</option>
                            <option v-for="(each, index) in brandList" :value="each.id" :key="index">
                                {{ each.name }}
                            </option>
                            <option value="" v-if="brandList.length === 0"> {{ ___('No Data Found') }}</option>
                        </select>
                        <div class="absolute top-0 bottom-0 end-0 pe-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                 stroke="currentColor" class="size-[15px]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="w-full md:col-span-2">
                    <div class="w-full flex justify-start">
                        <template v-if="!attach_preview">
                            <label for="image"
                                   class="max-w-[250px] min-w-[250px] max-h-[250px] min-h-[250px] rounded-xl bg-[#21306b]/25 duration-500 hover:bg-[#21306b]/95 group cursor-pointer flex justify-center items-center">
                                <input id="image" type="file" name="image" accept="image/*" hidden="hidden"
                                       autocomplete="off" @change="attachFile($event)"/>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="2"
                                         class="size-[45px] stroke-[#21306b] duration-500 group-hover:stroke-white">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                                    </svg>
                                </span>
                            </label>
                        </template>
                        <template v-if="attach_preview">
                            <div class="relative max-w-[250px] min-w-[250px] max-h-[250px] min-h-[250px] rounded-xl">
                                <img :src="attach_preview"
                                     class="max-w-[250px] min-w-[250px] max-h-[250px] min-h-[250px] rounded-xl object-cover bg-cover"
                                     alt="attach_file"/>
                                <div
                                    class="absolute inset-0 flex justify-center items-center w-full h-full bg-transparent duration-500 hover:bg-gray-200/25 backdrop-blur-none hover:backdrop-blur-sm">
                                    <button type="button"
                                            class="size-[45px] inline-flex justify-center items-center rounded-xl bg-rose-400 duration-500 hover:bg-rose-700 cursor-pointer"
                                            @click="removeFile()">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="2" class="size-6 stroke-white">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="mt-1 text-rose-500 text-[13px]" v-if="error?.image"> {{ error?.image[0] }}</div>
                </div>
                <div class="w-full md:col-span-2">
                    <label for="editor-js" class="block mb-1"> {{___('Product Description')}} </label>
                    <div id="editor-js" class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] px-4 text-[13px] h-auto px-5 py-4"></div>
                </div>
            </div>

        </form>

    </section>

</template>

<script>
import axios from "axios";
import {useRoute} from "vue-router";
import apiRoutes from "../../../../services/apiRoutes.js";
import apiServices from "../../../../services/apiServices.js";
import cookiesServices from "../../../../services/cookiesServices.js";
import EditorJS from '@editorjs/editorjs';
import Header from '@editorjs/header';
import List from '@editorjs/list';
import Quote from '@editorjs/quote';
import ImageTool from '@editorjs/image';
import Paragraph from '@editorjs/paragraph';
import {toast} from "vue3-toastify";

export default {
    props: ['each'],
    components: {},
    data() {
        return {
            formData: {
                id: null,
                image: null,
                title: '',
                price: '',
                category_id: '',
                brand_id: '',
                quantity: '',
                product_type: '',
                description: '',
            },
            categoryLoading: false,
            categoryList: [],
            brandLoading: false,
            brandList: [],
            attach_preview: null,
            error: {},
            editor: null,
            editorData: null,
            manageLoading: false,
        }
    },
    mounted() {
        this.lang = cookiesServices.get('lang') || "en";
        const routeId = useRoute();
        this.getCategoryApi();
        this.getBrandApi();
        if (routeId.params.id !== 'new') {
            this.contentInit(routeId.params.id);
            this.singleApi(routeId.params.id);
        } else {
            this.$nextTick(() => {
                this.initEditor();
            });
        }
    },
    methods: {
        async contentInit(data) {
            if (data) {
                await this.$nextTick();
                this.initEditor();
                if (this.editor) {
                    try {
                        await this.editor.isReady;
                    } catch (error) {
                        console.error("Editor.js failed to become ready:", error);
                        return;
                    }
                }
                await this.singleApi(data);
                if (this.editor && this.formData.description) {
                    try {
                        const blocks = typeof this.formData.description === 'string' ? JSON.parse(this.formData.description) : this.formData.description;
                        await this.editor.render(blocks);
                    } catch (e) {
                        console.error("Failed to render blocks:", e);
                        console.error("Problematic description data:", this.formData.description);
                    }
                }
            } else {
                this.formData = {
                    id: null,
                    image: null,
                    title: '',
                    price: '',
                    category_id: '',
                    brand_id: '',
                    quantity: '',
                    product_type: '',
                    description: {},
                };
                await this.$nextTick();
                this.initEditor();
                this.attach_preview = null;
            }
        },
        initEditor() {
            if (this.editor) {
                this.editor.destroy();
                this.editor = null;
            }
            this.editor = new EditorJS({
                holder: 'editor-js',
                autofocus: true,
                data: {},
                tools: {
                    header: Header,
                    list: List,
                    quote: Quote,
                    paragraph: {
                        class: Paragraph,
                        inlineToolbar: true,
                        config: {
                            placeholder: 'Enter description...',
                        },
                    },
                    image: {
                        class: ImageTool,
                        config: {
                            caption: false,
                            uploader: {
                                uploadByFile: async (file) => {
                                    const base64 = await this.convertToBase64(file);
                                    return {
                                        success: 1,
                                        file: {
                                            url: base64,
                                        },
                                    };
                                },
                            },
                        },
                    },
                },
            });
        },
        convertToBase64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = () => resolve(reader.result);
                reader.onerror = error => reject(error);
                reader.readAsDataURL(file);
            });
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
                this.formData.description = await this.editor.save();
                formData.append('title', this.formData.title);
                formData.append('price', this.formData.price);
                formData.append('category_id', this.formData.category_id);
                formData.append('brand_id', this.formData.brand_id);
                formData.append('quantity', this.formData.quantity);
                formData.append('product_type', this.formData.product_type);
                formData.append('description', JSON.stringify(this.formData.description));
                if (this.formData.image && typeof this.formData.image !== 'string') {
                    formData.append('image', this.formData.image);
                }
                await axios.post(apiRoutes.product, formData, {headers: apiServices.authHeaderMediaContent});
                this.$router.push({name: 'products'});
                toast.success(this.lang === "en" ? "Product created successfully." : "تم إنشاء المنتج بنجاح.")
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
                this.formData.description = await this.editor.save();
                formData.append('title', this.formData.title);
                formData.append('price', this.formData.price);
                formData.append('category_id', this.formData.category_id);
                formData.append('brand_id', this.formData.brand_id);
                formData.append('quantity', this.formData.quantity);
                formData.append('product_type', this.formData.product_type);
                formData.append('description', JSON.stringify(this.formData.description));
                if (this.formData.image && typeof this.formData.image !== 'string') {
                    formData.append('image', this.formData.image);
                }
                await axios.post(apiRoutes.product + '/' + this.formData.id + '?_method=PUT', formData, {headers: apiServices.authHeaderMediaContent});
                this.$router.push({name: 'products'});
                toast.success(this.lang === "en" ? "Product updated successfully." : "تم تحديث المنتج بنجاح.")
            } catch (error) {
                this.error = error?.response?.data?.errors
            } finally {
                this.manageLoading = false;
            }
        },
        async getCategoryApi() {
            try {
                this.categoryLoading = true;
                const response = await axios.get(apiRoutes.category, {headers: apiServices.authHeaderContent});
                this.categoryList = response.data.data;
            } catch (error) {
                console.log(error);
            } finally {
                this.categoryLoading = false;
            }
        },
        async getBrandApi() {
            try {
                this.brandLoading = true;
                const response = await axios.get(apiRoutes.brand, {headers: apiServices.authHeaderContent});
                this.brandList = response.data.data;
            } catch (error) {
                console.log(error);
            } finally {
                this.brandLoading = false;
            }
        },
        async singleApi(data) {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.product + `/${data}`, {
                    headers: apiServices.authHeaderContent,
                });
                this.formData.id = response?.data?.data?.id;
                this.formData = response?.data?.data;
                this.attach_preview = response?.data?.data?.image;
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.loading = false;
            }
        },
        /*Number Validation*/
        checkNumber(evt) {
            var theEvent = evt || window.event;

            // Handle paste
            if (theEvent.type === 'paste') {
                // @ts-ignore
                key = event.clipboardData.getData('text/plain');
            } else {
                // Handle key press
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /^\d*\.?\d*$/;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault) theEvent.preventDefault();
            }
        },
    }
}

</script>
