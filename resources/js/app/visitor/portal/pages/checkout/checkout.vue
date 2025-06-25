<template>

    <!-- breadcrumb -->
    <Breadcrumb :title="lang==='en' ? 'Cart & Payment Checkout' : 'عربة التسوق والدفع'"
                :links="[ { label: lang === 'en' ? 'Home' : 'الرئيسية', href: 'home' }, { label: lang === 'en' ? 'Cart & Payment Checkout' : 'عربة التسوق والدفع', href: 'checkout' } ]"></Breadcrumb>

    <form @submit.prevent="placeAllOrders" class="py-16 w-full max-w-[1200px] mx-auto flex flex-wrap">

        <div class="w-full lg:w-1/2 p-2">
            <div class="p-5 bg-gray-100 w-full block rounded-lg">

                <div class="flex justify-between items-center mb-3">
                    <div class="block w-full">

                        <!-- title -->
                        <div class="text-[25px]">
                            {{ ___(`Account`) }}
                        </div>

                        <!-- email -->
                        <template v-if="getParam?.email">
                            <a :href="`mailto:${getParam?.email}`" class="block decoration-0 w-full">
                                {{ getParam?.email }}
                            </a>
                        </template>
                        <template v-else>
                            {{ ___(`First Login and then checkout cart.`) }}
                        </template>

                    </div>

                </div>

                <div class="border-t border-t-gray-500 w-full block pt-5">

                    <!-- title -->
                    <div class="text-[25px] block mb-3"> {{ ___(`Delivery`) }}</div>

                    <div class="w-full grid grid-cols-1">

                        <!-- name -->
                        <div class="w-full block mb-2">
                            <label for="checkout-name" class="block w-full mb-1">
                                {{ ___(`Name`) }}
                            </label>
                            <input id="checkout-name" type="text" name="name" disabled :value="getParam?.name"
                                   class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]"
                                   required autocomplete="off"/>
                        </div>

                        <!-- address -->
                        <div class="w-full block mb-2">
                            <label for="checkout-address" class="block w-full mb-1">
                                {{ ___(`Address`) }}
                            </label>
                            <input id="checkout-address" type="text" name="checkout-address" :value="getParam?.address"
                                   disabled
                                   class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]"
                                   autocomplete="off"/>
                        </div>

                        <!-- phone number -->
                        <div class="w-full block mb-2">
                            <label for="checkout-phone-number" class="block w-full mb-1">
                                {{ ___(`Phone Number`) }} </label>
                            <input id="checkout-phone-number" type="text" disabled :value="getParam?.phone"
                                   name="checkout-phone-number"
                                   class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]"
                                   autocomplete="off"/>
                        </div>

                        <!-- payment methods -->
                        <div class="w-full block mb-2">
                            <label for="payment-methods" class="block w-full mb-1">
                                {{ ___(`Payment Methods`) }} </label>
                            <div class="w-full relative">
                                <select name="payment_method" id="payment-methods" v-model="formData.payment_method"
                                        class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px] appearance-none">
                                    <option value=""> {{ ___(`Select Payment Methods`) }}</option>
                                    <option :value="`home_delivery`"> {{ ___(`Home Delivery`) }}</option>
                                    <option :value="`cash_on_delivery`"> {{ ___(`Cash On Delivery`) }}</option>
                                </select>
                                <div class="absolute top-0 bottom-0 end-0 pe-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="size-[25px]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="m19.5 8.25-7.5 7.5-7.5-7.5"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-rose-600 text-sm mt-1" v-if="errors.payment_method">
                                {{ errors.payment_method[0] }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <div class="w-full lg:w-1/2 p-2">
            <div class="p-5 bg-gray-100 w-full block rounded-lg">

                <template v-if="products.length === 0">
                    <div class="flex justify-center items-center flex-col h-full gap-5 py-16">
                        <div class="mb-3 font-semibold"> {{ ___(`No Product add in your cart`) }}</div>
                        <router-link :to="{name:'products'}"
                                     class="outline-0 rounded-lg bg-gray-200 duration-500 h-[50px] cursor-pointer inline-flex justify-center items-center hover:bg-[#21306b] text-black hover:text-white px-5">
                            {{ ___(`Continue Shopping`) }}
                        </router-link>
                    </div>
                </template>

                <!-- product data -->
                <table class="w-full border-0" v-if="products.length !== 0">
                    <tbody class="w-full border-0">
                    <tr class="w-full border-0 align-middle" v-for="(cartItem, index) in products">
                        <td class="w-full border-0">
                            <div class="flex justify-start items-center rounded-lg p-1">
                                <img :src="cartItem.image"
                                     class="object-cover bg-cover min-w-[75px] min-h-[75px] max-w-[75px] max-h-[75px]"
                                     alt=""/>
                                <span class="block ms-2 w-full">
                                    <span class="block w-full text-[12px] text-gray-600">
                                        {{ cartItem.category.name }}
                                    </span>
                                    <span class="block w-full">
                                        {{ cartItem.name }}
                                    </span>
                                    <span class="block w-full text-[14px]"> ${{ parseFloat(cartItem.price).toFixed(2) }} * {{ cartItem.quantity }} </span>
                                    <span v-if="errors[`orders.${index}.quantity`]"
                                          class="text-sm block w-full text-red-600"> {{
                                            errors[`orders.${index}.quantity`][0]
                                        }} </span>
                                </span>
                            </div>
                        </td>
                        <td class="w-full border-0">
                            <div class="p-1 text-end">
                                ${{ parseFloat(cartItem.price * cartItem.quantity).toFixed(2) }}
                            </div>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot class="w-full border-0">
                    <tr class="w-full border-0 align-middle">
                        <td class="w-full border-0">
                            <div class="p-1">
                                {{ ___(`Subtotal`) }}
                            </div>
                        </td>
                        <td class="w-full border-0">
                            <div class="p-1 text-end">
                                ${{ parseFloat(subtotal).toFixed(2) }}
                            </div>
                        </td>
                    </tr>
                    <tr class="w-full border-0 align-middle">
                        <td class="w-full border-0">
                            <div class="p-1">
                                {{ ___(`Shipping`) }}
                            </div>
                        </td>
                        <td class="w-full border-0">
                            <div class="p-1 text-end">
                                ${{ parseFloat(shipping).toFixed(2) }}
                            </div>
                        </td>
                    </tr>
                    <tr class="w-full border-0 align-middle">
                        <td class="w-full border-0">
                            <div class="p-1">
                                {{ ___(`Total`) }}
                            </div>
                        </td>
                        <td class="w-full border-0">
                            <div class="p-1 text-end">
                                ${{ parseFloat(total).toFixed(2) }}
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <!-- submit button -->
            <div class="my-5 flex justify-end">
                <button type="submit" v-if="!createOrderLoading" :disabled="products.length === 0"
                        :class="{ 'cursor-pointer' : products.length !== 0, 'pointer-events-none' : products.length === 0 }"
                        class="min-w-[135px] min-h-[50px] btn-theme">
                    {{ ___(`Confirm`) }}
                </button>
                <button type="button" v-if="createOrderLoading"
                        class="pointer-events-none min-w-[135px] min-h-[50px] btn-theme">
                    <span
                        class="size-[20px] inline-block rounded-full border-2 border-white border-t-transparent animate-spin"></span>
                </button>
            </div>

        </div>

    </form>

    <section class="fixed inset-0 size-full grid sm:justify-center items-center duration-500 z-50 p-5 overflow-y-auto"
             :class="{ 'invisible bg-black/35' : !isActiveAuthentic, 'visible bg-black/65' : isActiveAuthentic, 'scale-110' : isScaled }"
             @click="handleOutsideClick">
        <aside class="bg-white rounded-md w-full sm:max-w-[450px] sm:min-w-[450px] p-5 duration-500 origin-top"
               :class="{ 'translate-y-0 opacity-100' : isActiveAuthentic, '-translate-y-1/2 opacity-0' : !isActiveAuthentic }"
               @click.stop>
            <div class="w-full py-9">
                <div class="flex justify-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                         stroke="currentColor" class="size-[65px]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                    </svg>
                </div>
                <div class="text-gray-800 text-center text-[20px] mb-3">
                    {{ ___('You are not logged in.') }}
                </div>
                <div class="flex justify-center items-center">
                    <router-link :to="{name:'login'}"
                                 class="bg-gray-200 duration-500 hover:bg-gray-300 text-gray-900 px-7 py-3 rounded-lg">
                        Login
                    </router-link>
                </div>
            </div>
        </aside>
    </section>

</template>

<script>

import axios from "axios";
import Breadcrumb from "../../../../components/breadcrumb.vue";
import apiRoutes from "../../../../services/apiRoutes.js";
import apiServices from "../../../../services/apiServices.js";
import store from "../../../../store/index.js";
import cookiesServices from "../../../../services/cookiesServices.js";

export default {
    computed: {
        subtotal() {
            return this.products.reduce((total, item) => {
                return total + (item.price * item.quantity);
            }, 0);
        },
        shipping() {
            return 0.16;
        },
        total() {
            return this.subtotal + this.shipping;
        },
        products: function () {
            return store.state.products
        }
    },
    components: {
        Breadcrumb
    },
    data() {
        return {
            cartItems: [],
            lang: 'en',
            error: {},
            createOrderLoading: false,
            getParam: null,
            checkMethodOfPayment: '',
            formData: {
                customer_id: null,
                name: '',
                price: '',
                quantity: '',
                status: 'pending',
                payment_method: '',
            },
            isActiveAuthentic: false,
            isScaled: false,
            errors: {},
        }
    },
    mounted() {
        this.lang = cookiesServices.get('lang') || "en";
        this.getCartItems();
        if (cookiesServices.get('user_type') === 'Customer') {
            this.getDetails();
        } else {
            this.isActiveAuthentic = true;
        }
    },
    methods: {
        getCartItems() {
            store.dispatch('getCartItems')
        },
        clearCart() {
            store.dispatch('clearCart');
        },
        generateYears(start, end) {
            let yearsArray = [];
            for (let year = start; year <= end; year++) {
                yearsArray.push(year);
            }
            return yearsArray;
        },
        async getDetails() {
            try {
                this.getDetailsLoading = true;
                const response = await axios.get(apiRoutes.details, {headers: apiServices.authHeaderContent});
                this.formData.customer_id = response?.data?.user.id;
                this.getParam = response.data.user;
            } catch (error) {
                console.log(error);
            } finally {
                this.getDetailsLoading = false;
            }
        },
        async placeAllOrders() {
            try {
                this.errors = {};
                this.createOrderLoading = true;
                const payload = {
                    customer_id: this.formData.customer_id,
                    payment_method: this.formData.payment_method,
                    orders: this.products.map(product => ({
                        image: product.image,
                        product_id: product.id,
                        title: product.title,
                        category: product.category.name,
                        price: product.price,
                        quantity: product.quantity,
                        status: 'pending',
                    })),
                };
                await axios.post(apiRoutes.order + `/store`, payload, {headers: apiServices.authHeaderContent});
                this.clearCart()
                this.$router.push({name: 'orderHistory'})
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
            } finally {
                this.createOrderLoading = false;
            }
        },
        handleOutsideClick() {
            this.isScaled = true
            setTimeout(() => {
                this.isScaled = false
            }, 200)
        }
    }
}

</script>
