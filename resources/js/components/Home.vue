<template>
    <main class="main">
        <div class="container h-100">
            <div class="d-flex flex-column h-100 position-relative">
                <div class="chat-header border-bottom py-4 py-lg-7">
                    <div class="row align-items-center">
                        <!-- Content -->
                        <div class="col-8 col-xl-12">
                            <div class="row align-items-center text-center text-xl-start">
                                <!-- Title -->
                                <div class="col-12 col-xl-6">
                                    <div class="row align-items-center gx-5">
                                        <div class="col-auto">
                                            <div class="avatar d-none d-xl-inline-block">
                                                <img class="avatar-img" src="mufti.png" alt="">
                                            </div>
                                        </div>

                                        <div class="col overflow-hidden">
                                            <h5 class="text-truncate">Sheikh.AI</h5>
                                            <p class="text-truncate d-none" id="typing-marker">is typing<span class="typing-dots"><span>.</span><span>.</span><span>.</span></span></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Title -->
                            </div>
                        </div>
                        <!-- Content -->
                    </div>
                </div>

                <div class="chat-body hide-scrollbar flex-1 h-100">
                    <div class="chat-body-inner">
                        <div class="py-6 py-lg-12">
                            <div v-for="(message, index) in messages" :key="index">
                                <div :class="[messageClass, message.message.type]">
                                    <div class="message-inner">
                                        <div class="message-body">
                                            <div class="message-content">
                                                <div class="message-text">
                                                    <p>{{ message.message.text }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-footer pb-3 pb-lg-7 position-absolute bottom-0 start-0">
                        <div class="chat-form rounded-pill bg-dark" data-emoji-form="">
                            <div class="row align-items-center gx-0">
                                <div class="col">
                                    <div class="input-group">
                                        <textarea class="form-control px-0" placeholder="Type Quran, Sunnah or Islamic Life Questions here..." rows="1" data-emoji-input="" data-autosize="true" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 47px;" v-model="question"></textarea>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <button class="btn btn-icon btn-primary rounded-circle ms-5" @click="ask">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                question: '',
                messages: [],
                messageClass: 'message'
            }
        },
        methods: {
            ask() {
                var typing = document.querySelector('#typing-marker');
                typing.classList.remove('d-none');
                var theQuestion = this.question;
                var messagesData = this.messages;
                this.question = "";
                this.messages.push({'message': {'text': theQuestion, 'type': 'message-out'}})
                axios.post('http://127.0.0.1:8000/api/ask', {
                    question: theQuestion
                })
                .then( response => {
                    this.messages.push({'message': {'text': response.data, 'type': '-'}})
                    typing.classList.add('d-none');
                }).catch( error => {
                    // console.log(this)
                });
            }
        },
    }
</script>
