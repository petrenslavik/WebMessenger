<template>
    <div class="container">
        <div class="statusRow  card rounded-top">
            <div class="col-3">Messenger</div>
        </div>
        <div class="page">
            <div class="col-3 border-danger">
                <div class="searchBox">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="addon"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" placeholder="Search" class="form-control" aria-label="search"
                               aria-describedby="addon">
                    </div>
                </div>
                <div class="conversations">
                </div>
            </div>
            <div class="messages">
            </div>
        </div>
    </div>
</template>

<script>
    import Conversation from "@/frontend/Views/Components/Conversation";
    import lib from "@/frontend/Scripts/FetchLib";

    export default {
        name: "Conversations",
        components: {
            Conversation
        },
        data: function(){
            return{
                conversations: null,
            }
        },
        created: function () {
            lib.fetch("conversation/getAll", null, this.emailConfirmed);
        },
        methods:{
            receivedConversations: function(data){
                if (data.code == 0) {
                } else {
                    this.successfulLoad(data);
                }
            },
            successfulLoad: function(data){

            }
        }
    }
</script>

<style scoped>
    .container {
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
    }

    .statusRow {
        flex-direction: row;
        width: 100%;
        text-align: center;
        background-color: #dc3545;
        min-height: 40px;
        color: white;
    }

    .statusRow .col-3 {
        display: flex;
        justify-content: center;
        align-items: center
    }

    .card {
        border-width: 1px;
        border-bottom-width: 0px;
        padding-right: 0;
        padding-left: 0;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    .page {
        height: 100%;
        background-color: white;
        margin-bottom: 15px;
        display: flex;
        flex-direction: row;
    }

    .searchBox {
        padding-left: 5px;
        padding-right: 5px;
    }

    .page .col-3 {
        border-right: 2px solid black;
        padding-right: 0;
        padding-left: 0;
        padding-top: 10px;
        display: flex;
        flex-direction: column;
    }

    .conversations {
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        flex: 1 0 auto;
        height: 50px;
    }
</style>