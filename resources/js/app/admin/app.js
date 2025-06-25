import app from "./app.vue";
import {createApp} from "vue";
import router from "./router/router.js";
import 'vue3-toastify/dist/index.css';
import Translation from '../services/translation.js';

const Mixins = Object.assign({}, Translation);
createApp(app).use(router, {autoClose: 3000}).mixin({methods: Mixins}).mount('#app');
