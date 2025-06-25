import {createRouter, createWebHistory} from "vue-router";
import cookiesServices from "../../services/cookiesServices.js";

import authLayout from "../auth/layout/layout.vue";
import login from "../auth/pages/login.vue";
import forgot from "../auth/pages/forgot.vue";
import reset from "../auth/pages/reset.vue";
import verification from "../auth/pages/verification.vue";
import portalLayout from "../portal/layout/layout.vue";
import dashboard from "../portal/pages/dashboard/dashboard.vue";

import boxes from "../portal/pages/boxes/list.vue";

import categories from "../portal/pages/categories/list.vue";
import brands from "../portal/pages/brands/list.vue";
import contacts from "../portal/pages/contacts/list.vue";

import products from "../portal/pages/products/list.vue";
import productManage from "../portal/pages/products/manage.vue";

import blogs from "../portal/pages/blogs/list.vue";
import blogManage from "../portal/pages/blogs/manage.vue";

import services from "../portal/pages/services/list.vue";
import serviceManage from "../portal/pages/services/manage.vue";

import testimonials from "../portal/pages/testimonial/list.vue";

import customers from "../portal/pages/customers/list.vue";
import reviews from "../portal/pages/reviews/list.vue";
import orders from "../portal/pages/orders/list.vue";
import translations from "../portal/pages/translations/translations.vue";
import profile from "../portal/pages/profile/profile.vue";
import settings from "../portal/pages/settings/settings.vue";

const title = 'Furnimal - ';
const routes = [
    {
        path: '/admin/auth', name: 'authLayout', component: authLayout,
        children: [
            {path: 'login', name: 'login', component: login, meta: {title: title + 'Login'}},
            {path: 'forgot', name: 'forgot', component: forgot, meta: {title: title + 'Forgot'}},
            {path: 'reset', name: 'reset', component: reset, meta: {title: title + 'Reset'}},
            {path: 'verification', name: 'verification', component: verification, meta: {title: title + 'Verification'}},
        ]
    },
    {
        path: '/admin', name: 'portalLayout', component: portalLayout,
        children: [
            {path: '', name: 'dashboard', component: dashboard, meta: {title: title + 'Dashboard'}},
            {path: 'boxes', name: 'boxes', component: boxes, meta: {title: title + 'Boxes'}},
            {path: 'categories', name: 'categories', component: categories, meta: {title: title + 'Categories'}},
            {path: 'brands', name: 'brands', component: brands, meta: {title: title + 'Brands'}},
            {path: 'contacts', name: 'contacts', component: contacts, meta: {title: title + 'Contacts'}},
            {path: 'products', name: 'products', component: products, meta: {title: title + 'Products'}},
            {path: 'product-manage/:id', name: 'productManage', component: productManage, meta: {title: title + 'Product Manage'}},
            {path: 'blogs', name: 'blogs', component: blogs, meta: {title: title + 'Blogs'}},
            {path: 'blog-manage/:id', name: 'blogManage', component: blogManage, meta: {title: title + 'Blog Manage'}},
            {path: 'services', name: 'services', component: services, meta: {title: title + 'Services'}},
            {path: 'service-manage/:id', name: 'serviceManage', component: serviceManage, meta: {title: title + 'Service Manage'}},
            {path: 'testimonials', name: 'testimonials', component: testimonials, meta: {title: title + 'Testimonials'}},
            {path: 'customers', name: 'customers', component: customers, meta: {title: title + 'Customers'}},
            {path: 'reviews', name: 'reviews', component: reviews, meta: {title: title + 'Reviews'}},
            {path: 'orders', name: 'orders', component: orders, meta: {title: title + 'orders'}},
            {path: 'translations', name: 'translations', component: translations, meta: {title: title + 'Translations'}},
            {path: 'settings', name: 'settings', component: settings, meta: {title: title + 'Settings'}},
            {path: 'profile', name: 'profile', component: profile, meta: {title: title + 'Profile'}},
        ]
    },
];
const router = createRouter({
    history: createWebHistory(), routes,
    scrollBehavior(to, from, savedPosition) {
        if (to.hash) {
            return {
                el: to.hash, behavior: 'smooth'
            };
        } else {
            return {
                top: 0, behavior: 'smooth'
            };
        }
    }
});
router.beforeEach((to, from, next) => {
    const isAuthenticated = !!cookiesServices.get('access_token');
    const userType = cookiesServices.get('user_type')
    if (userType === 'Customer') {
        cookiesServices.remove('access_token');
        cookiesServices.remove('user_type');
    }
    if (to.matched.some(record => record.name === 'authLayout')) {
        if (isAuthenticated) {
            next({name: 'dashboard'});
        } else {
            next();
        }
    } else if (to.matched.some(record => record.name === 'portalLayout')) {
        if (!isAuthenticated) {
            next({name: 'login'});
        } else {
            next();
        }
    } else {
        next();
    }
});
export default router;
