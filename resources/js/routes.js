import ProductIndex from './components/products/index.vue';
import ProductCreate from './components/products/create.vue';
import ProductEdit from './components/products/edit.vue';

import ShopIndex from './components/shops/index.vue';
import ShopCreate from './components/shops/create.vue';
import ShopEdit from './components/shops/edit.vue';
import MapView from './components/shops/view.vue';

import Login from './components/auth/login.vue';
import Register from './components/auth/register.vue';


export const routes = [
    {
        path: '/products',
        component: ProductIndex,
        name: "ProductIndex"
    },
    {
        path: '/products/create',
        component: ProductCreate,
        name: "ProductCreate"
    },
    {
        path: '/products/edit/:id',
        component: ProductEdit,
        name: "ProductEdit"
    },
    {
        path:"/",
        redirect: "/",
        component: ShopIndex,
        meta: {requiresAuth: true},
        
    },
    // {
    //     path: '/shops',
    //     component: ShopIndex,
    //     name: "ShopIndex"
    // },
    {
        path: '/shops/create',
        component: ShopCreate,
        name: "ShopCreate"
    },
    {
        path: '/shops/edit/:id',
        component: ShopEdit,
        name: "ShopEdit"
    },
    {
        path: '/shops/map-view',
        component: MapView,
        name: "MapView"
    },
    {
        path: '/login',
        component: Login,
        name: "Login"
    },
    {
        path: '/register',
        component: Register,
        name: "Register"
    },
    
];

// const token = routes.app.$session.get('jwt');
// console.log(token)
// console.log(app.$session);
// routes.beforeEach((to, from, next) => {
//     if (to.meta.requiresAuth && !token.token) {
//       next({ name: "Login" });
//     } else {
//       next();
//     }
//   });

// export default routes;