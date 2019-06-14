<template>
    <div class="conversation" @click="clicked">
        <div class="info">
            <div class="name">
                {{data.Speaker.FirstName}} {{data.Speaker.SecondName}}
            </div>
            <div class="lastMessage">
                {{data.LastMessage.Content.Text}}
            </div>
        </div>
        <div class="rigthInfo">
            <div class="date">
                {{data.LastMessage.SendDateTime}}
            </div>
            <div class="UnreadMessages" v-if="data.NewMessages>0">
                {{data.NewMessages}}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Conversation",
        props: {
            data: Object,
        },
        methods: {
            clicked: function (event) {
                this.$emit('setConversation', this.data, event.currentTarget);
            }
        }
    }
</script>

<style scoped>
    .conversation {
        display: flex;
        flex-direction: row;
        padding: 5px;
        font-size: .85em;
        cursor: pointer;
    }

    .info {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }

    .date {
        text-align: right;
    }

    .name {
        font-weight: 700;
        word-wrap: break-word;
        white-space: nowrap;
    }

    .lastMessage {
        color: #698192;
        white-space: nowrap;
    }

    .conversation:hover {
        background-color: #fae2e5;
    }

    .active {
        background-color: #dc3545 !important;
        color: white;
    }

    .active .lastMessage {
        color: #fae2e5;
    }
    .rigthInfo{
        display: flex;
        flex-direction: column;
    }
    .UnreadMessages{
        background-color: orange;
        color:black;
        border-radius:50%;
        width:20px;
        align-self:end;
        text-align: center;
    }
</style>