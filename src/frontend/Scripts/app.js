import Vue from "vue";
import router from './router';
import App from '@/frontend/Views/App.vue';
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'
import '@fortawesome/fontawesome-free/js/all'

new Vue({
    router:router,
    render: h => h(App)
}).$mount('#app');