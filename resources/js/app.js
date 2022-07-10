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
import VueSession from "vue-session";

import * as VueGoogleMaps from "vue2-google-maps"
// import { LMap, LTileLayer, LMarker } from 'vue2-leaflet';
Vue.config.productionTip = false;
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(VueSession);


Vue.use(VueGoogleMaps, {
    load: {
      key: "AIzaSyB0RHP65AGrVflp6KJjzNznuHdJr2IExio",
    }
  });

import App from './app.vue';
import router from './router';






const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});