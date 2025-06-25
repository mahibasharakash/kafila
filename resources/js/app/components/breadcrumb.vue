<template>

    <section
        class="min-h-[250px] max-h-[250px] bg-cover object-center flex justify-center items-center relative before:absolute before:inset-0 before:w-full before:h-full before:bg-white/75"
        :style="{ backgroundImage: 'url(' + generalData?.breadcrumb_file_path + ')' }" v-if="!loading">
        <div class="flex justify-center items-center flex-col relative">
            <div class="text-[25px] sm:text-[25px] font-semibold"> {{ title }}</div>
            <ul class="w-full flex justify-center items-center">
                <li v-for="(item, index) in links" :key="index">
                    <router-link :to="{name: item.href}" class="decoration-0 inline-block px-2 py-1 font-semibold"
                                 :class="index === links.length - 1 ? 'text-[#21306b]' : 'text-black'"> {{ item.label }}
                    </router-link>
                    <span v-if="index < links.length - 1" class="mx-2">/</span>
                </li>
            </ul>
        </div>
    </section>

    <section class="min-h-[250px] w-full flex justify-center items-center bg-white" v-if="loading">
        <span class="screen-loader"></span>
    </section>

</template>

<script>

import axios from "axios";
import apiRoutes from "../services/apiRoutes.js";
import apiServices from "../services/apiServices.js";

export default {
    props: {
        title: {
            type: String,
            required: true
        },
        links: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            generalData: null,
            loading: false,
        }
    },
    mounted() {
        this.generalApi();
    },
    methods: {
        async generalApi() {
            try {
                this.loading = true;
                const response = await axios.get(apiRoutes.general + `/1`, {headers: apiServices.authHeaderContent});
                this.generalData = response?.data?.data
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
    }
}
</script>
