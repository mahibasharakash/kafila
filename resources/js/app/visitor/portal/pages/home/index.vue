<template>

    <!-- slider content loading -->
    <section class="w-full h-[850px] min-h-[950px] object-cover bg-cover flex justify-center items-center" v-if="loading">
        <span class="screen-loader"></span>
    </section>

    <!-- slider content -->
    <section class="w-full h-[650px] min-h-[650px] object-cover bg-cover relative" v-if="!loading"
             :class="{ '' : lang === 'en', '-scale-x-100' : lang === 'ar' }"
             :style="{ backgroundImage: `url(${generalData?.slider_file_path})` }">
        <div class="absolute inset-0 bg-black pointer-events-none z-1"
             :style="{opacity: (generalData?.slider_background_opacity ?? 50) / 100}"></div>

        <!-- background slider content -->
        <div
            class="w-full max-w-[1200px] mx-auto flex justify-center flex-col items-start h-full px-5 sm:px-10 relative z-10"
            :class="{ '' : lang === 'en', '-scale-x-100' : lang === 'ar' }">

            <!-- background slider content tags -->
            <div class="text-[17px] font-medium block mb-3" :style="{ color: generalData?.slider_text_color }">
                {{ generalData?.slider_small_title }}
            </div>

            <!-- background slider content title -->
            <div class="text-[25px] sm:text-[40px] md:text-[55px] font-semibold block max-w-[600px] leading-[65px]"
                 :style="{ color: generalData?.slider_text_color }">
                {{ generalData?.slider_big_title }}
            </div>

            <!-- background slider content short description -->
            <div class="max-w-[550px] mb-7 mt-3" :style="{ color: generalData?.slider_text_color }">
                {{ generalData?.slider_small_short_description }}
            </div>

            <div class="flex justify-start items-center gap-x-10">

                <!-- background slider content route -->
                <router-link :to="{name:'products'}" class="btn-theme px-10 min-h-[55px]">
                    {{ ___(`Discover Now`) }}
                </router-link>

                <!-- background slider video -->
                <template v-if="generalData?.video_file_path">
                    <a class="cursor-pointer min-w-[55px] min-h-[55px] border-2 border-[#21306b] rounded-full inline-flex justify-center items-center bg-[#21306b] relative before:absolute before:content-[''] transition duration-700 ease-in-out before:z-0 before:top-[3px] before:w-[45px] before:h-[45px] before:rounded-full before:animate-ping before:bg-[#3B497E] before:opacity-75"
                       :class="{ '' : lang === 'en', '-scale-x-100' : lang === 'ar' }" @click="showPromotionModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2"
                             class="size-[25px] fill-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z"/>
                        </svg>
                    </a>
                </template>

            </div>

        </div>

    </section>

    <!-- modal of video -->
    <section class="fixed inset-0 size-full flex justify-center items-center duration-500 z-50 p-5 sm:p-10"
             :class="{ 'invisible bg-black/35': !promotionModal, 'visible bg-black/65': promotionModal }"
             @click="promotionModal = false">
        <div class="bg-white rounded-2xl w-full max-w-[750px] duration-500 origin-top overflow-hidden"
             :class="{ 'translate-y-0 opacity-100': promotionModal, '-translate-y-1/2 opacity-0': !promotionModal }"
             @click.stop>
            <iframe class="w-full aspect-video object-cover bg-cover h-auto" :src="generalData?.video_file_path"
                    frameborder="0" allowfullscreen></iframe>
        </div>
    </section>

    <!-- box content -->
    <section class="w-full bg-white py-3 sm:py-10" v-if="boxData.length > 0 && !loading">
        <div
            class="w-full max-w-[1200px] mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 justify-start items-start px-5 sm:px-10">
            <template v-for="(each, index) in boxData" :key="index">
                <div class="p-5 w-full block">
                    <div class="flex justify-center py-3 px-10">
                        <img :src="each.image" alt="box 1"/>
                    </div>
                    <div class="text-center text-md mb-5">
                        <span class="inline-block px-5 py-1 rounded-2xl text-[13px]" :style="randomColor(index)"> {{ lang === 'en' ? 'Step' : 'خطوة' }} {{ index + 1 }} </span>
                    </div>
                    <div class="text-center text-lg font-bold mb-3 text-[13px]"> {{ each.title }}</div>
                    <div class="text-center text-md text-[14px]"> {{ each.short_description }}</div>
                </div>
            </template>
        </div>
    </section>

    <!-- category content -->
    <section class="w-full bg-white py-3 sm:py-10" v-if="categoryData.length > 0 && !loading">
        <div class="w-full max-w-[1200px] mx-auto grid grid-cols-1 md:grid-cols-3 gap-2 px-4 md:px-10">
            <div class="grid grid-cols-1 gap-y-2">
                <template v-for="(item, index) in groupedColumns.columnOne" :key="index">
                    <a href="javascript:void(0)"
                       class="h-[250px] md:h-[334px] bg-cover bg-center relative decoration-0"
                       :style="{ backgroundImage: `url(${item.image})` }">
                        <div
                            class="z-10 absolute inset-0 bg-black/25 hover:bg-black/75 p-10 hover:backdrop-blur-sm transition duration-500 flex justify-center items-center">
                            <div class="relative z-10 text-center">
                                <div class="text-[25px] text-white">{{ item.name }}</div>
                            </div>
                        </div>
                    </a>
                </template>
            </div>
            <div class="grid grid-cols-1 gap-y-2">
                <template v-for="(item, index) in groupedColumns.columnTwo" :key="index">
                    <a href="javascript:void(0)"
                       class="h-[250px] md:h-[220px] bg-cover bg-center relative decoration-0"
                       :style="{ backgroundImage: `url(${item.image})` }">
                        <div
                            class="z-10 absolute inset-0 bg-black/25 hover:bg-black/75 p-10 hover:backdrop-blur-sm transition duration-500 flex justify-center items-center">
                            <div class="relative z-10 text-center">
                                <div class="text-[25px] text-white">{{ item.name }}</div>
                            </div>
                        </div>
                    </a>
                </template>
            </div>
            <div class="grid grid-cols-1 gap-y-2">
                <template v-for="(item, index) in groupedColumns.columnThree" :key="index">
                    <a href="javascript:void(0)"
                       class="h-[250px] md:h-[334px] bg-cover bg-center relative decoration-0"
                       :style="{ backgroundImage: `url(${item.image})` }">
                        <div
                            class="z-10 absolute inset-0 bg-black/25 hover:bg-black/75 p-10 hover:backdrop-blur-sm transition duration-500 flex justify-center items-center">
                            <div class="relative z-10 text-center">
                                <div class="text-[25px] text-white">{{ item.name }}</div>
                            </div>
                        </div>
                    </a>
                </template>
            </div>
        </div>
    </section>

    <!-- featured product content -->
    <section v-if="featuredProducts.length > 0 && !loading"
             class="w-full mx-auto max-w-[1200px] py-3 sm:py-16 px-5 sm:px-10">

        <!-- product title -->
        <div class="text-center text-[30px] md:text-[35px] font-semibold mb-3">
            {{ ___(`Featured Products`) }}
        </div>

        <div class="flex justify-center items-center flex-col mb-5">

            <div class="flex justify-center items-center mb-2">
                <div class="bg-transparent min-w-[60px] h-[5px]"></div>
                <div
                    class="bg-gray-600 min-w-[120px] h-[5px] relative before:absolute before:content-[''] before:top-0 before:bottom-0 before:end-0 before:z-10 before:w-[60px] before:h-[5px] before:bg-[#21306b]"></div>
            </div>

            <div class="flex justify-center items-center mb-2">
                <div
                    class="bg-gray-600 min-w-[120px] h-[5px] relative before:absolute before:content-[''] before:top-0 before:bottom-0 before:start-0 before:z-10 before:w-[60px] before:h-[5px] before:bg-[#21306b]"></div>
                <div class="bg-transparent min-w-[60px] h-[5px]"></div>
            </div>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5"
             v-if="featuredProducts.length > 0 && !loading">
            <template v-for="(each, index) in featuredProducts" :key="each.id">
                <div
                    class="relative block w-full h-full bg-gray-100 overflow-hidden rounded-lg group shadow-none duration-500 hover:shadow-lg transition-all backdrop-blur-sm"
                    @mouseover="isProductHovered = index" @mouseleave="isProductHovered = null"
                    :class="isProductHovered !== null && isProductHovered !== index ? 'opacity-70 blur-[2px]' : 'opacity-100 blur-0'">

                    <div class="absolute top-0 start-0 p-5">
                        <div class="bg-green-200 text-green-800 inline-block px-3 py-1 rounded-md text-sm"
                             v-if="parseInt(each.quantity) !== 0">
                            In Stock
                        </div>
                        <div class="bg-rose-200 text-rose-800 inline-block px-3 py-1 rounded-md text-sm"
                             v-if="parseInt(each.quantity) === 0">
                            Out of Stock
                        </div>
                    </div>

                    <div
                        class="absolute top-0 end-0 p-5 flex flex-col gap-3 opacity-0 duration-500 group-hover:opacity-100">

                        <!-- view -->
                        <router-link :to="{name:'productDetails',params:{id:each.id}}"
                                     class="size-[35px] inline-flex justify-center items-center bg-gray-200 outline-0 cursor-pointer rounded-lg group/item duration-500 hover:bg-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                 class="size-[17px] stroke-black duration-500 group-hover/item:stroke-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </router-link>

                        <!-- add to cart -->
                        <button type="button"
                                class="size-[35px] justify-center items-center bg-gray-200 outline-0 rounded-lg group/item duration-500 hover:bg-green-600 cursor-pointer"
                                @click="addToCart(each)"
                                :class="{ 'inline-flex' : parseInt(each.quantity) !== 0, 'hidden' : parseInt(each.quantity) === 0 }"
                                :disabled="parseInt(each.quantity) === 0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                 class="size-[17px] stroke-black duration-500 group-hover/item:stroke-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                        </button>

                        <!-- add to wishlist -->
                        <button type="button"
                                class="size-[35px] inline-flex justify-center items-center bg-gray-200 outline-0 cursor-pointer rounded-lg group/item duration-500 hover:bg-rose-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                 class="size-[17px] fill-black duration-500 group-hover/item:fill-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                            </svg>
                        </button>

                    </div>

                    <!-- image -->
                    <img :src="each?.image" class="object-cover bg-cover w-full max-h-[350px] min-h-[350px]"
                         :alt="each?.name"/>

                    <div class="p-5 w-full block">

                        <!-- category -->
                        <div class="mb-3 w-full block text-[14px] text-gray-700">
                            {{ each?.category?.name }}
                        </div>

                        <!-- title -->
                        <div class="mb-3 w-full block text-[21px]">
                            <div class="truncate-to-1-line">
                                {{ each?.title }}
                            </div>
                        </div>

                        <div class="mb-3 w-full block text-[14px] text-gray-700">
                            <div class="truncate-to-3-line">
                                <div v-html="renderEditorJsDescription(each.description)" v-if="each.description"></div>
                                <template v-else> N/A</template>
                            </div>
                        </div>

                        <!-- price -->
                        <div class="w-full block text-[14px] text-end">
                            ${{ each?.price }}
                        </div>

                    </div>

                </div>
            </template>
        </div>

    </section>

    <!-- latest product content -->
    <section v-if="latestProducts.length > 0 && !loading"
             class="w-full mx-auto max-w-[1200px] py-3 sm:py-16 px-5 sm:px-10">

        <!-- product title -->
        <div class="text-center text-[30px] md:text-[35px] font-semibold mb-3">
            {{ ___(`Latest Products`) }}
        </div>

        <div class="flex justify-center items-center flex-col mb-5">

            <div class="flex justify-center items-center mb-2">
                <div class="bg-transparent min-w-[60px] h-[5px]"></div>
                <div
                    class="bg-gray-600 min-w-[120px] h-[5px] relative before:absolute before:content-[''] before:top-0 before:bottom-0 before:end-0 before:z-10 before:w-[60px] before:h-[5px] before:bg-[#21306b]"></div>
            </div>

            <div class="flex justify-center items-center mb-2">
                <div
                    class="bg-gray-600 min-w-[120px] h-[5px] relative before:absolute before:content-[''] before:top-0 before:bottom-0 before:start-0 before:z-10 before:w-[60px] before:h-[5px] before:bg-[#21306b]"></div>
                <div class="bg-transparent min-w-[60px] h-[5px]"></div>
            </div>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" v-if="latestProducts.length > 0 && !loading">
            <template v-for="(each, index) in latestProducts" :key="each.id">
                <div
                    class="relative block w-full h-full bg-gray-100 overflow-hidden rounded-lg group shadow-none duration-500 hover:shadow-lg transition-all backdrop-blur-sm"
                    @mouseover="isProductHovered = index" @mouseleave="isProductHovered = null"
                    :class="isProductHovered !== null && isProductHovered !== index ? 'opacity-70 blur-[2px]' : 'opacity-100 blur-0'">

                    <div class="absolute top-0 start-0 p-5">
                        <div class="bg-green-200 text-green-800 inline-block px-3 py-1 rounded-md text-sm"
                             v-if="parseInt(each.quantity) !== 0">
                            In Stock
                        </div>
                        <div class="bg-rose-200 text-rose-800 inline-block px-3 py-1 rounded-md text-sm"
                             v-if="parseInt(each.quantity) === 0">
                            Out of Stock
                        </div>
                    </div>

                    <div
                        class="absolute top-0 end-0 p-5 flex flex-col gap-3 opacity-0 duration-500 group-hover:opacity-100">

                        <!-- view -->
                        <router-link :to="{name:'productDetails',params:{id:each.id}}"
                                     class="size-[35px] inline-flex justify-center items-center bg-gray-200 outline-0 cursor-pointer rounded-lg group/item duration-500 hover:bg-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                 class="size-[17px] stroke-black duration-500 group-hover/item:stroke-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </router-link>

                        <!-- add to cart -->
                        <button type="button"
                                class="size-[35px] justify-center items-center bg-gray-200 outline-0 rounded-lg group/item duration-500 hover:bg-green-600 cursor-pointer"
                                @click="addToCart(each)"
                                :class="{ 'inline-flex' : parseInt(each.quantity) !== 0, 'hidden' : parseInt(each.quantity) === 0 }"
                                :disabled="parseInt(each.quantity) === 0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                 class="size-[17px] stroke-black duration-500 group-hover/item:stroke-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                        </button>

                        <!-- add to wishlist -->
                        <button type="button"
                                class="size-[35px] inline-flex justify-center items-center bg-gray-200 outline-0 cursor-pointer rounded-lg group/item duration-500 hover:bg-rose-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                 class="size-[17px] fill-black duration-500 group-hover/item:fill-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                            </svg>
                        </button>

                    </div>

                    <!-- image -->
                    <img :src="each?.image" class="object-cover bg-cover w-full max-h-[350px] min-h-[350px]"
                         :alt="each?.name"/>

                    <div class="p-5 w-full block">

                        <!-- category -->
                        <div class="mb-3 w-full block text-[14px] text-gray-700">
                            {{ each?.category?.name }}
                        </div>

                        <!-- name -->
                        <div class="mb-3 w-full block text-[21px]">
                            <div class="truncate-to-1-line">
                                {{ each?.title }}
                            </div>
                        </div>

                        <div class="mb-3 w-full block text-[14px] text-gray-700">
                            <div class="truncate-to-3-line">
                                <div v-html="renderEditorJsDescription(each.description)" v-if="each.description"></div>
                                <template v-else> N/A</template>
                            </div>
                        </div>

                        <!-- price -->
                        <div class="w-full block text-[14px] text-end">
                            ${{ each?.price }}
                        </div>

                    </div>

                </div>
            </template>
        </div>

    </section>

    <!-- best seller product content -->
    <section v-if="bestSellerProducts.length > 0 && !loading"
             class="w-full mx-auto max-w-[1200px] py-3 sm:py-16 px-5 sm:px-10">

        <!-- product title -->
        <div class="text-center text-[30px] md:text-[35px] font-semibold mb-3">
            {{ ___(`Best Seller Products`) }}
        </div>

        <div class="flex justify-center items-center flex-col mb-5">

            <div class="flex justify-center items-center mb-2">
                <div class="bg-transparent min-w-[60px] h-[5px]"></div>
                <div
                    class="bg-gray-600 min-w-[120px] h-[5px] relative before:absolute before:content-[''] before:top-0 before:bottom-0 before:end-0 before:z-10 before:w-[60px] before:h-[5px] before:bg-[#21306b]"></div>
            </div>

            <div class="flex justify-center items-center mb-2">
                <div
                    class="bg-gray-600 min-w-[120px] h-[5px] relative before:absolute before:content-[''] before:top-0 before:bottom-0 before:start-0 before:z-10 before:w-[60px] before:h-[5px] before:bg-[#21306b]"></div>
                <div class="bg-transparent min-w-[60px] h-[5px]"></div>
            </div>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5"
             v-if="bestSellerProducts.length > 0 && !loading">
            <template v-for="(each, index) in bestSellerProducts" :key="each.id">
                <div
                    class="relative block w-full h-full bg-gray-100 overflow-hidden rounded-lg group shadow-none duration-500 hover:shadow-lg transition-all backdrop-blur-sm"
                    @mouseover="isProductHovered = index" @mouseleave="isProductHovered = null"
                    :class="isProductHovered !== null && isProductHovered !== index ? 'opacity-70 blur-[2px]' : 'opacity-100 blur-0'">

                    <div class="absolute top-0 start-0 p-5">
                        <div class="bg-green-200 text-green-800 inline-block px-3 py-1 rounded-md text-sm"
                             v-if="parseInt(each.quantity) !== 0">
                            In Stock
                        </div>
                        <div class="bg-rose-200 text-rose-800 inline-block px-3 py-1 rounded-md text-sm"
                             v-if="parseInt(each.quantity) === 0">
                            Out of Stock
                        </div>
                    </div>

                    <div
                        class="absolute top-0 end-0 p-5 flex flex-col gap-3 opacity-0 duration-500 group-hover:opacity-100">

                        <!-- view -->
                        <router-link :to="{name:'productDetails',params:{id:each.id}}"
                                     class="size-[35px] inline-flex justify-center items-center bg-gray-200 outline-0 cursor-pointer rounded-lg group/item duration-500 hover:bg-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                 class="size-[17px] stroke-black duration-500 group-hover/item:stroke-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </router-link>

                        <!-- add to cart -->
                        <button type="button"
                                class="size-[35px] justify-center items-center bg-gray-200 outline-0 rounded-lg group/item duration-500 hover:bg-green-600 cursor-pointer"
                                @click="addToCart(each)"
                                :class="{ 'inline-flex' : parseInt(each.quantity) !== 0, 'hidden' : parseInt(each.quantity) === 0 }"
                                :disabled="parseInt(each.quantity) === 0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                 class="size-[17px] stroke-black duration-500 group-hover/item:stroke-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                        </button>

                        <!-- add to wishlist -->
                        <button type="button"
                                class="size-[35px] inline-flex justify-center items-center bg-gray-200 outline-0 cursor-pointer rounded-lg group/item duration-500 hover:bg-rose-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                 class="size-[17px] fill-black duration-500 group-hover/item:fill-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                            </svg>
                        </button>

                    </div>

                    <!-- image -->
                    <img :src="each?.image" class="object-cover bg-cover w-full max-h-[350px] min-h-[350px]"
                         :alt="each?.name"/>

                    <div class="p-5 w-full block">

                        <!-- category -->
                        <div class="mb-3 w-full block text-[14px] text-gray-700">
                            {{ each?.category?.name }}
                        </div>

                        <!-- name -->
                        <div class="mb-3 w-full block text-[21px]">
                            <div class="truncate-to-1-line">
                                {{ each?.title }}
                            </div>
                        </div>

                        <div class="mb-3 w-full block text-[14px] text-gray-700">
                            <div class="truncate-to-3-line">
                                <div v-html="renderEditorJsDescription(each.description)" v-if="each.description"></div>
                                <template v-else> N/A</template>
                            </div>
                        </div>

                        <!-- price -->
                        <div class="w-full block text-[14px] text-end">
                            ${{ each?.price }}
                        </div>

                    </div>

                </div>
            </template>
        </div>

    </section>

    <!-- offer background image -->
    <section class="w-full bg-cover object-cover relative before:absolute before:inset-0 before:w-full before:h-full before:bg-black/55" :style="{ backgroundImage: `url(/collection/offer.jpg)` }">
        <div
            class="w-full max-w-[1200px] py-16 mx-auto sm:h-[650px] relative sm:min-h-[650px] flex justify-center items-center flex-col px-5 sm:px-10">

            <!-- offer percentage -->
            <div class="text-[30px] md:text-[35px] font-semibold text-white">
                {{ ___(`Sale! upto`) }}
                <span class="text-[#21306b] bg-white rounded-md px-4 mx-2"> 50% </span>
                {{ ___(`Off`) }}
            </div>

            <!-- offer title -->
            <div class="text-[20px] md:text-[25px] mb-3 sm:mb-10 text-white">
                {{ ___(`Best Promotion Product Here`) }}
            </div>

            <!-- offer promotional link -->
            <a href="javascript:void(0)"
               class="min-w-[55px] min-h-[55px] border-2 border-white rounded-full inline-flex justify-center items-center bg-white relative before:absolute before:content-[''] transition duration-700 ease-in-out before:z-0 before:top-[3px] before:w-[45px] before:h-[45px] before:rounded-full before:animate-ping before:bg-gray-500 before:opacity-75"
               :class="{ '' : lang === 'en', 'rotate-180' : lang === 'ar' }" @click="showPromotionModal()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2"
                     class="size-[25px] fill-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z"/>
                </svg>
            </a>

            <!-- offer route -->
            <div class="mt-10 sm:mt-14 text-center">
                <router-link :to="{name:'products'}"
                             class="inline-flex font-bold justify-center items-center text-white border-2 border-white duration-500 bg-transparent hover:bg-white hover:text-[#21306b] px-10 min-h-[55px]">
                    {{ ___(`Discover Now`) }}
                </router-link>
            </div>
        </div>
    </section>

    <!-- blog content -->
    <section class="w-full bg-white" v-if="blogData.length > 0 && !loading">
        <div class="w-full mx-auto max-w-[1200px] py-3 sm:py-16 px-5 sm:px-10">

            <!-- title -->
            <div class="text-center text-[30px] md:text-[35px] font-semibold">
                {{ ___(`Latest Blog Posts`) }}
            </div>

            <!-- description -->
            <div class="text-center text-[18px] text-gray-700 mb-5 mx-auto max-w-[750px]">
                {{ ___(`Stay updated with our latest blog posts featuring tips, trends, and insights to inspire your lifestyle and home decor choices.`) }}
            </div>

            <div class="flex justify-center items-center flex-col mb-5">
                <div class="flex justify-center items-center mb-2">
                    <div class="bg-transparent min-w-[60px] h-[5px]"></div>
                    <div
                        class="bg-gray-600 min-w-[120px] h-[5px] relative before:absolute before:content-[''] before:top-0 before:bottom-0 before:end-0 before:z-10 before:w-[60px] before:h-[5px] before:bg-[#21306b]"></div>
                </div>

                <div class="flex justify-center items-center mb-2">
                    <div
                        class="bg-gray-600 min-w-[120px] h-[5px] relative before:absolute before:content-[''] before:top-0 before:bottom-0 before:start-0 before:z-10 before:w-[60px] before:h-[5px] before:bg-[#21306b]"></div>
                    <div class="bg-transparent min-w-[60px] h-[5px]"></div>
                </div>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

                <template v-for="(each, index) in latestBlogs" :key="index">
                    <router-link :to="{name:'blogDetails',params:{id:each.id},state:each}"
                                 class="block decoration-0 text-black w-full h-full bg-gray-100 overflow-hidden rounded-lg shadow-none duration-500 hover:shadow-lg transition-all backdrop-blur-sm"
                                 @mouseover="blogIsHovered = index" @mouseleave="blogIsHovered = null"
                                 :class="blogIsHovered !== null && blogIsHovered !== index ? 'opacity-70 blur-[2px]' : 'opacity-100 blur-0'">

                        <!-- image -->
                        <div class="relative w-full h-auto">
                            <img :src="each.image" class="object-cover bg-cover w-full min-h-[290px] h-[290px]"
                                 alt="blog"/>
                            <div class="absolute top-0 end-0 p-3">
                                <div class="bg-white px-3 py-1 rounded-lg">
                                    {{ each.created_at_formatted }}
                                </div>
                            </div>
                        </div>

                        <div class="p-5 block w-full">
                            <div class="mb-1 block text-black text-[21px]">
                                {{ each.title }}
                            </div>
                            <div class="mb-3 block text-gray-700 text-[14px]">
                                <div class="truncate-to-2-line">
                                    {{ each.short_description }}
                                </div>
                            </div>
                            <div class="text-[14px]">
                                {{ lang === 'en' ? 'Posted By' : 'أرسلت بواسطة' }}: {{ each.author_name }}
                            </div>
                        </div>

                    </router-link>
                </template>

            </div>
        </div>
    </section>

    <!-- newsletter -->
    <section class="w-full bg-gray-100 py-3 sm:py-16">
        <div class="w-full max-w-[1200px] mx-auto flex justify-center items-center flex-col px-5 sm:px-10">

            <!-- newsletter title -->
            <div class="text-[25px] sm:text-[30px] md:text-[35px] font-semibold mb-5">
                {{ ___(`Subscribe Newsletter`) }}
            </div>

            <!-- newsletter description -->
            <div class="text-[15px] text-gray-700 text-center mb-5">
                {{ ___(`Subscribe to our newsletter for exclusive updates, special offers, and the latest trends delivered straight to your inbox.`) }}
            </div>

            <div class="flex justify-center items-center flex-col mb-5">

                <div class="flex justify-center items-center mb-2">
                    <div class="bg-transparent min-w-[60px] h-[5px]"></div>
                    <div
                        class="bg-gray-600 min-w-[120px] h-[5px] relative before:absolute before:content-[''] before:top-0 before:bottom-0 before:end-0 before:z-10 before:w-[60px] before:h-[5px] before:bg-[#21306b]"></div>
                </div>

                <div class="flex justify-center items-center mb-2">
                    <div
                        class="bg-gray-600 min-w-[120px] h-[5px] relative before:absolute before:content-[''] before:top-0 before:bottom-0 before:start-0 before:z-10 before:w-[60px] before:h-[5px] before:bg-[#21306b]"></div>
                    <div class="bg-transparent min-w-[60px] h-[5px]"></div>
                </div>

            </div>

            <div class="w-full mx-auto max-w-[750px]">

                <!-- newsletter form email subscription -->
                <form class="w-full relative flex justify-between items-center gap-3">

                    <!-- email -->
                    <input type="text" name="email" placeholder="email@gmail.com"
                           class="w-full block outline-0 rounded-xl bg-white border border-gray-200 duration-500 focus-within:ring-2 focus-within:ring-[#21306b] h-[45px] px-4 text-[13px]"
                           required autocomplete="off"/>

                    <!-- submit button -->
                    <button type="submit" class="btn-theme px-5 min-h-[45px] max-h-[45px]">
                        {{ ___(`Subscribe`) }}
                    </button>

                </form>

            </div>

        </div>
    </section>

</template>

<script>

import axios from "axios";
import apiRoutes from "../../../../services/apiRoutes.js";
import apiServices from "../../../../services/apiServices.js";
import store from "../../../../store/index.js";
import cookiesServices from "../../../../services/cookiesServices.js";

export default {
    computed: {
        groupedColumns() {
            const data = this.categoryData || [];
            return {
                columnOne: data.slice(0, 2),
                columnTwo: data.slice(2, 5),
                columnThree: data.slice(5, 7),
            };
        },
        latestBlogs() {
            return [...this.blogData].sort((a, b) => b.id - a.id).slice(0, 3);
        },
        featuredProducts() {
            return this.productData
                .filter(product => product.product_type === 'featured_products')
                .sort((a, b) => b.id - a.id)
                .slice(0, 6);
        },
        latestProducts() {
            return this.productData
                .filter(product => product.product_type === 'latest_products')
                .sort((a, b) => b.id - a.id)
                .slice(0, 6);
        },
        bestSellerProducts() {
            return this.productData
                .filter(product => product.product_type === 'best_sellers')
                .sort((a, b) => b.id - a.id)
                .slice(0, 6);
        },
    },
    data() {
        return {
            promotionModal: false,
            lang: 'en',
            isProductHovered: null,
            blogIsHovered: null,
            generalData: null,
            boxData: [],
            categoryData: [],
            blogData: [],
            productData: [],
            loading: false,
            colors: ['#9d174d', '#1d4ed8', '#059669', '#ca8a04', '#6d28d9', '#dc2626', '#0e7490', '#7c3aed'],
            cart: [],
        }
    },
    mounted() {
        this.trackVisit('Home');
        this.lang = cookiesServices.get('lang') || "en";
        this.generalApi();
    },
    methods: {
        addToCart(product) {
            store.dispatch('addToCart', product)
        },
        showPromotionModal() {
            this.promotionModal = true
        },
        async trackVisit(page) {
            try {
                this.loading = true;
                await axios.post(apiRoutes.visitPage + '/store', {page}, {headers: apiServices.authHeaderContent});
            } catch (error) {
                console.log(error)
            } finally {
                this.loading = false;
            }
        },
        async generalApi() {
            try {
                this.loading = true;

                const generalDataResponse = await axios.get(apiRoutes.general + `/1`, {headers: apiServices.authHeaderContent});
                this.generalData = generalDataResponse?.data?.data;

                const boxDataResponse = await axios.get(apiRoutes.box, {headers: apiServices.authHeaderContent});
                this.boxData = boxDataResponse?.data?.data;

                const categoryDataResponse = await axios.get(apiRoutes.category, {headers: apiServices.authHeaderContent});
                this.categoryData = categoryDataResponse?.data?.data;

                const productDataResponse = await axios.get(apiRoutes.product, {headers: apiServices.authHeaderContent});
                this.productData = productDataResponse?.data?.data

                const blogDataResponse = await axios.get(apiRoutes.blog, {headers: apiServices.authHeaderContent});
                this.blogData = blogDataResponse?.data?.data;

            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        randomColor(index) {
            const color = this.colors[index % this.colors.length];
            return {
                backgroundColor: this.hexToRGBA(color, 0.1),
                color: color
            };
        },
        hexToRGBA(hex, alpha) {
            const r = parseInt(hex.slice(1, 3), 16);
            const g = parseInt(hex.slice(3, 5), 16);
            const b = parseInt(hex.slice(5, 7), 16);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
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
    }
}

</script>
