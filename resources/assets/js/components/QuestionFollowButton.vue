<template>
    <button
            class="btn btn-default pull-left"
            v-if="hidden"
            v-text="text"
            v-bind:class="{'btn-success': followed}"
            v-on:click="follow"
    >
    </button>
</template>

<script>
    export default {
        props: ['is_login', 'question'],
        mounted() {
            if (this.is_login) {
                axios.post('/api/question/follower', {'question': this.question}).then((response) => {
                    this.followed = response.data.followed;
                    this.hidden = true;
                })
            } else {
                this.followed = false;
                this.hidden = false;
            }
        },
        data() {
            return {
                hidden: true,
                followed: false
            }
        },
        computed: {
            text() {
                return this.followed ? '已关注' : '关注该问题'
            }
        },
        methods: {
            follow() {
                if (this.is_login) {
                    axios.post('/api/question/follow', {'question': this.question}).then((response) => {
                        this.followed = response.data.followed
                    })
                }
            }
        }
    }
</script>
