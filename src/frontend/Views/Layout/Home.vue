<template>
    <div class="container">
        <div>Welcome to fast, secure messenger.</div>
        <div class="buttons">
            <Button text="Register" color="#dc3545"></Button>
            <Button text="Login" color="#dc3545"></Button>
        </div>
    </div>
</template>

<script>
    import Button from "@/frontend/Views/Components/Button";

    export default {
        name: "Home",
        components: {Button}
    }
</script>

<style scoped>
    .container {
        background-color: #32CD32;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .buttons {
        display: flex;
        justify-content: space-evenly;
        width: 100%;
    }

</style>