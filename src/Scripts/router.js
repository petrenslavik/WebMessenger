import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

export default new VueRouter({
    mode: "history",
    routes: [
        {
          name: "Home",
          path: "/",
          component: () => import ("@/Views/Layout/Home"),
          props:true
        },
        {
          name: "Register",
          path: "/register",
          component: () => import ("@/Views/Layout/Register"),
          props:true,
        },
        {
            name: "Error404",
            path: "*",
            component: () => import ("@/Views/Layout/Error404"),
            props:true
        }
    ]
});