import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

export default new VueRouter({
    mode: "history",
    routes: [
        {
            name: "Home",
            path: "/",
            component: () => import ("@/frontend/Views/Layout/Home"),
            props: true
        },
        {
            name: "Register",
            path: "/register",
            component: () => import ("@/frontend/Views/Layout/Register"),
            props: true,
        },
        {
            name: "RegisterConfirmation",
            path: "/confirmRegister",
            component: () => import ("@/frontend/Views/Layout/RegisterConfirmation"),
            props: true,
        },
        {
            name: "EmailConfirm",
            path: "/user/confirmEmail",
            component: () => import ("@/frontend/Views/Layout/ConfirmEmail"),
            props: true,
        },
        {
            name: "Login",
            path: "/login",
            component: () => import ("@/frontend/Views/Layout/Login"),
            props: true,
        },
        {
            name: "Conversations",
            path: "/conversations",
            component: () => import ("@/frontend/Views/Layout/Conversations"),
            props: true,
        },
        {
            name: "Error404",
            path: "*",
            component: () => import ("@/frontend/Views/Layout/Error404"),
            props: true
        }
    ]
});