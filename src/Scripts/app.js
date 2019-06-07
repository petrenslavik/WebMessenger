import Vue from '/node_modules/vue/dist/vue.esm.browser';
import VueRouter from '/node_modules/vue-router/dist/vue-router.esm.browser';
import App from '@/src/Views/App.vue';

Vue.use(VueRouter);
const Foo = { template: '<div>foo</div>' };
const Bar = { template: '<div>bar</div>' };

const routes = [
    { path: '/foo', component: Foo },
    { path: '/bar', component: Bar }
];

const router = new VueRouter({
    mode:'history',
    routes: routes,
});

new Vue({
    router:router,
}).$mount('#app');