<template>
    <div class="conversation">
        <div class="info">
            <div class="name">
                {{FirstName}} {{SecondName}}
            </div>
            <div class="lastMessage">
                {{LastMessage}}
            </div>
        </div>
        <div class="date">
            {{SendDate}}
        </div>
    </div>
</template>

<script>
    export default {
        name: "Conversation",
        data: function(){
            return{
                conversationId:null,
                FirstName: null,
                SecondName: null,
                LastMessage: null,
                SendDate: null
            }
        },
        props:{
            data: Object,
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
</style>