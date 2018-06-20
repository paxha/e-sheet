
require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';

Vue.use(VueRouter);

import home from './components/Home';
import sheets from './components/Sheets';
import sheet from './components/Sheet';

const routes = [
    {
        path: '/',
        component: home
    },
    {
        path: '/sheets/:project_id',
        component: sheets,
        props: true
    },
    {
        path: '/sheet/:sheet_id',
        component: sheet,
        props: true
    },
];

const router = new VueRouter({
    routes
});

const app = new Vue({
    el: '#app',
    router
});