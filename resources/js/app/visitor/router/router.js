import {createRouter, createWebHistory} from "vue-router";
import cookiesServices from "../../services/cookiesServices.js";
import authLayout from "../auth/layout/layout.vue";
import login from "../auth/pages/login.vue";
import registration from "../auth/pages/registration.vue";
import forgot from "../auth/pages/forgot.vue";
import reset from "../auth/pages/reset.vue";
import verification from "../auth/pages/verification.vue";
import portalLayout from "../portal/layout/layout.vue";
import home from "../portal/pages/home/index.vue";
import about from "../portal/pages/about/about.vue";
import contact from "../portal/pages/contact/contact.vue";
import blogs from "../portal/pages/blog/blog.vue";
import blogDetails from "../portal/pages/blog/blog-details.vue";
import services from "../portal/pages/service/service.vue";
import serviceDetails from "../portal/pages/service/service-details.vue";
import products from "../portal/pages/product/product.vue";
import productDetails from "../portal/pages/product/product-details.vue";
import checkout from "../portal/pages/checkout/checkout.vue";
import profileLayout from "../profile/layout/layout.vue";
import orderHistory from "../profile/pages/order-history.vue";

const title = 'Furnimal - ';
const routes = [
    {
        path: '/', name: 'portalLayout', component: portalLayout,
        children: [
            {path: '', name: 'home', component: home, meta: {title: title + 'Home'}},
            {path: 'about', name: 'about', component: about, meta: {title: title + 'About'}},
            {path: 'contact', name: 'contact', component: contact, meta: {title: title + 'Contact'}},
            {path: 'blogs', name: 'blogs', component: blogs, meta: {title: title + 'Blogs'}},
            {
                path: 'blog-details/:id',
                name: 'blogDetails',
                component: blogDetails,
                meta: {title: title + 'Blog Details'}
            },
            {path: 'services', name: 'services', component: services, meta: {title: title + 'Services'}},
            {
                path: 'service-details/:id',
                name: 'serviceDetails',
                component: serviceDetails,
                meta: {title: title + 'Service Details'}
            },
            {path: 'products', name: 'products', component: products, meta: {title: title + 'Products'}},
            {
                path: 'product-details/:id',
                name: 'productDetails',
                component: productDetails,
                meta: {title: title + 'Product Details'}
            },
            {path: 'checkout', name: 'checkout', component: checkout, meta: {title: title + 'Checkout'}},
            {
                path: '/auth', name: 'authLayout', component: authLayout,
                children: [
                    {path: 'login', name: 'login', component: login, meta: {title: title + 'Login'}},
                    {
                        path: 'registration',
                        name: 'registration',
                        component: registration,
                        meta: {title: title + 'Registration'}
                    },
                    {path: 'forgot', name: 'forgot', component: forgot, meta: {title: title + 'Forgot'}},
                    {path: 'reset', name: 'reset', component: reset, meta: {title: title + 'Reset'}},
                    {
                        path: 'verification',
                        name: 'verification',
                        component: verification,
                        meta: {title: title + 'Verification'}
                    },
                ]
            },
            {
                path: '/profile', name: 'profileLayout', component: profileLayout,
                children: [
                    {
                        path: 'order-history',
                        name: 'orderHistory',
                        component: orderHistory,
                        meta: {title: title + 'Order History'}
                    },
                ]
            },
        ]
    },
];
const router = createRouter({
    history: createWebHistory(), routes,
    scrollBehavior(to, from, savedPosition) {
        if (to.hash) {
            return {
                el: to.hash,
                behavior: 'smooth',
            };
        } else {
            return {top: 0, behavior: 'smooth'};
        }
    }
});
router.beforeEach((to, from, next) => {
    const isAuthenticated = !!cookiesServices.get('access_token');
    const userType = cookiesServices.get('user_type')
    if (userType === 'Admin') {
        cookiesServices.remove('access_token');
        cookiesServices.remove('user_type');
    }
    if (to.matched.some(record => record.name === 'authLayout')) {
        if (isAuthenticated) {
            next({name: 'orderHistory'});
        } else {
            next();
        }
    } else if (to.matched.some(record => record.name === 'profileLayout')) {
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
