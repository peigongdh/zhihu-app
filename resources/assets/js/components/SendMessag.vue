<template>
    <div>
        <button
                class="btn btn-default pull-left"
                v-bind:class="{'btn-primary': voted}"
                @click="showSendMessageForm"
        >发送私信
        </button>

        <div class="modal fade" id="modal-send-message" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            发送私信
                        </h4>
                    </div>

                    <div class="modal-body">
                        <textarea name="body" class="form-control"></textarea>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" @click="store">
                            发送
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['answer', 'count'],
        mounted() {
            axios.post('/api/answer/vote/users', {'answer': this.answer}).then((response) => {
                this.voted = response.data.voted
            })
            this.voteCount = this.count
        },
        data() {
            return {
                voted: false,
                voteCount: 0
            }
        },
        computed: {
            text() {
                return this.voteCount
            }
        },
        methods: {
            store() {
                axios.post('/api/answer/vote', {'answer': this.answer}).then((response) => {
                    this.voted = response.data.voted
                    response.data.voted ? this.voteCount++ : this.voteCount--
                })
            },
            showSendMessage() {
                $('#modal-send-message').show();
            }
        }
    }
</script>
