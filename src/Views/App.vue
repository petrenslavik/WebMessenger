<template>
    <div id="app">
        <RwvHeader />
        <router-view></router-view>
        <RwvFooter />
    </div>
</template>

<script>
    import RwvHeader from "@/components/Header";
    import RwvFooter from "@/components/TheFooter";
    export default {
        name: "App",
        components: {
            RwvHeader,
            RwvFooter
        }
    };
</script>

<style></style>