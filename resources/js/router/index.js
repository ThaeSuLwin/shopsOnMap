import VueRouter from "vue-router";

import ShopIndex from "../components/shops/index.vue";
import ShopCreate from "../components/shops/create.vue";
import ShopEdit from "../components/shops/edit.vue";
import MapView from "../components/shops/view.vue";

import Login from "../components/auth/login.vue";
import Register from "../components/auth/register.vue";

import UserIndex from "../components/users/index.vue";
import UserCreate from "../components/users/create.vue";
import UserEdit from "../components/users/edit.vue";
import ChangePassword from "../components/users/change-password.vue";
import UserDetail from "../components/users/view.vue";

const routes = [
    {
        path: "/",
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
    {
        path: "/users",
        meta: { requiresAuth: true },
        component: UserIndex,
        name: "UserIndex",
    },
    {
        path: "/users/create",
        meta: { requiresAuth: true },
        component: UserCreate,
        name: "UserCreate",
    },
    {
        path: "/users/edit/:id",
        meta: { requiresAuth: true },
        component: UserEdit,
        name: "UserEdit",
    },
    {
        path: "/users/password/:id",
        meta: { requiresAuth: true },
        component: ChangePassword,
        name: "ChangePassword",
    },
    {
        path: "/users/:id",
        meta: { requiresAuth: true },
        component: UserDetail,
        name: "UserDetail",
        
    }
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
