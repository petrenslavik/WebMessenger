<template>
    
</template>

<script>
    import lib from "@/frontend/Scripts/FetchLib";
    export default {
        name: "ConfirmEmail",
        created: function() {
            var token = this.$route.query.token;
            lib.fetch("user/confirmEmail/?token=" + token, null, this.emailConfirmed);
        },
        methods:{
            emailConfirmed: function(){
                this.$router.push('/login');
            }
        }
    }
</script>

<style scoped>

</style>