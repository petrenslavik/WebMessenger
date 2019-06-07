import Vue from '/src/Scripts/Libraries/vue.js';
import VueRouter from '/src/Scripts/Libraries/vue-router.js';
import App from '/src/Views/App.vue';

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