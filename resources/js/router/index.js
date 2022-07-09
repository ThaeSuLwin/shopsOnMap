import VueRouter from "vue-router";
import ProductIndex from "../components/products/index.vue";
import ProductCreate from "../components/products/create.vue";
import ProductEdit from "../components/products/edit.vue";

import ShopIndex from "../components/shops/index.vue";
import ShopCreate from "../components/shops/create.vue";
import ShopEdit from "../components/shops/edit.vue";
import MapView from "../components/shops/view.vue";

import Login from "../components/auth/login.vue";
import Register from "../components/auth/register.vue";

const routes = [
    {
        path: "/products",
        component: ProductIndex,
        name: "ProductIndex",
    },
    {
        path: "/products/create",
        component: ProductCreate,
        name: "ProductCreate",
    },
    {
        path: "/products/edit/:id",
        component: ProductEdit,
        name: "ProductEdit",
    },
    {
        path: "/shops",
        meta: { requiresAuth: true },
        component: ShopIndex,
        name: "ShopIndex",
    },
    {
        path: "/shops/create",
        meta: { requiresAuth: true },
        component: ShopCreate,
        name: "ShopCreate",
    },
    {
        path: "/shops/edit/:id",
        meta: { requiresAuth: true },
        component: ShopEdit,
        name: "ShopEdit",
    },
    {
        path: "/shops/map-view",
        meta: { requiresAuth: true },
        component: MapView,
        name: "MapView",
    },

    {
        path: "/login",
        component: Login,
        name: "Login",
    },
    {
        path: "/register",
        component: Register,
        name: "Register",
    },
];

const router = new VueRouter({
    mode: "history",
    routes,
});

// console.log(sessionStorage.getItem("jwt"))
// const token = routes.app.$session.get('jwt');
// console.log(token)
// console.log(app.$session);
router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !router.app.$session.exists()) {
        // if (to.meta.requiresAuth && !token.token) {
        next({ name: "Login" });
    } else {
        next();
        // }
    }
});

export default router;
