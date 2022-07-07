/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'; // if this is not work add this =>  window.Vue = require('vue');

import axios from 'axios';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
// import * as VueGoogleMaps from "vue2-google-maps"
import { LMap, LTileLayer, LMarker } from 'vue2-leaflet';

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.component('l-map', LMap);
Vue.component('l-tile-layer', LTileLayer);
Vue.component('l-marker', LMarker);
// Vue.use(VueGoogleMaps, {
//     load: {
//       key: "AIzaSyB0RHP65AGrVflp6KJjzNznuHdJr2IExio",
//       libraries: "places"
//     }
//   });

import App from './app.vue';
import { routes } from './routes';


const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});