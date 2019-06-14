<template>
    <div class="message rounded" :class="[isOwner? 'owner': 'speakerr']">
        {{data.Content.Text}}
    </div>
</template>

<script>
    export default {
        name: "Message",
        props:{
            data: Object,
            curUser: Object,
        },
        computed:{
            isOwner: function()
            {
                return this.curUser.Id == this.data.SenderId;
            }
        }
    }
</script>

<style scoped>
    .message{
        padding:5px;
        margin-top :5px;
    }

    .owner{
        background-color: #32CD32;
        text-align: right;
        align-self: flex-end;
        padding-right: 10px;
        color:white;
    }

    .speakerr{
        background-color: darkblue;
        text-align: left;
        color:white;
        width:fit-content !important;
        width: -moz-fit-content;
    }
</style>