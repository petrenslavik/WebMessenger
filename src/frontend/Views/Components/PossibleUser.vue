<template>
    <div class="conversation" @click="clicked">
        <div class="info">
            <div class="name">
                {{data.FirstName}} {{data.SecondName}}
            </div>
            <div class="lastMessage">
                {{data.Email}}
            </div>
        </div>
        <div class="date">
            {{data.SendDate}}
        </div>
    </div>
</template>

<script>
    export default {
        name: "PossibleUser",
        props:{
            data: Object,
        },
        methods:{
            clicked: function(event){
                this.$emit('setConversation', this.data, event.currentTarget);
            }
        }
    }
</script>

<style scoped>
    .conversation{
        display: flex;
        flex-direction: row;
        padding: 5px;
        font-size: .85em;
        cursor: pointer;
    }
    .info{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }
    .date{
        text-align: right;
    }
    .name{
        font-weight:700;
        word-wrap:break-word;
        white-space: nowrap;
    }
    .lastMessage{
        color: #698192;
        white-space: nowrap;
    }
    .conversation:hover{
        background-color: #fae2e5;
    }
    .active{
        background-color:#dc3545 !important;
        color:white;
    }

    .active .lastMessage{
        color: #fae2e5;
    }
</style>