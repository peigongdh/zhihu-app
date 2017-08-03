<template>
    <button
            class="btn btn-default pull-left"
            v-text="text"
            v-on:click="vote"
            v-bind:class="{'btn-primary': voted}"
    >
    </button>
</template>

<script>
    export default {
        props: ['is_login', 'answer', 'count'],
        mounted() {
            if (this.is_login) {
                axios.post('/api/answer/vote/users', {'answer': this.answer}).then((response) => {
                    this.voted = response.data.voted
                });
            }
            this.voteCount = this.count;
        },
        data() {
            return {
                voted: false,
                voteCount: 0
            }
        },
        watch: {
            answer(newAnswer) {
                if (this.is_login) {
                    axios.post('/api/answer/vote/users', {'answer': newAnswer}).then((response) => {
                        this.voted = response.data.voted
                    });
                }
            },
            count(newCount) {
                this.voteCount = newCount;
            }
        },
        computed: {
            text() {
                return this.voteCount
            }
        },
        methods: {
            vote() {
                if (this.is_login) {
                    axios.post('/api/answer/vote', {'answer': this.answer}).then((response) => {
                        this.voted = response.data.voted;
                        response.data.voted ? this.voteCount++ : this.voteCount--
                    })
                }
            }
        }
    }
</script>
