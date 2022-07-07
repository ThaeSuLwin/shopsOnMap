import ProductIndex from './components/products/index.vue';
import ProductCreate from './components/products/create.vue';
import ProductEdit from './components/products/edit.vue';

import ShopIndex from './components/shops/index.vue';
import ShopCreate from './components/shops/create.vue';
import ShopEdit from './components/shops/edit.vue';

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
        path: '/shops',
        component: ShopIndex,
        name: "ShopIndex"
    },
    {
        path: '/shops/create',
        component: ShopCreate,
        name: "ShopCreate"
    },
    {
        path: '/shops/edit/:id',
        component: ShopEdit,
        name: "ShopEdit"
    }
];