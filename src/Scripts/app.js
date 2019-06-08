import Vue from "vue";
import router from './router';
import App from '@/Views/App.vue';
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'

new Vue({
    router:router,
    render: h => h(App)
}).$mount('#app');