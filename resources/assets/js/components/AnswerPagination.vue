<template>
    <div>
        <div class="media" v-for="item in items">
            <div class="media-left">
                <user-vote-button :is_login="isLogin"
                                  :answer="item.id"
                                  :count="item.votes_count">
              </user-vote-button>
            </div>
            <div class="media-body">
                <h4 class="media-heading">
                    <a :href="getUserUrl(item)">
                        {{ item.user.name }}
                    </a>
                </h4>
                <a :name="getAnswerName(item)"></a>
                <div v-html="item.body"></div>
            </div>
            <comment :is_login="isLogin"
                     type="answer"
                     :model="item.id"
                     :count="getAnswerCommentCount(item)">
            </comment>
        </div>

        <nav>
            <ul class="pagination">
                <li v-if="pagination.current_page > 1">
                    <a href="#" aria-label="Previous"
                       @click.prevent="changePage(pagination.current_page - 1)">
                        <span>&laquo;</span>
                    </a>
                </li>
                <li v-for="page in pagesNumber"
                    v-bind:class="[ page == isActived ? 'active' : '']">
                    <a href="#"
                       @click.prevent="changePage(page)">{{ page }}</a>
                </li>
                <li v-if="pagination.current_page < pagination.last_page">
                    <a href="#" aria-label="Next"
                       @click.prevent="changePage(pagination.current_page + 1)">
                        <span>&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        props: ['is_login'],
        data() {
            return {
                pagination: {
                    total: 0,
                    per_page: 7,
                    from: 1,
                    to: 0,
                    current_page: 1,
                    last_page: 1,
                },
                offset: 4,// left and right padding from the pagination <span>,just change it to see effects
                items: [],
                isLogin: false,
            }
        },
        mounted() {
            this.fetchItems(this.pagination.current_page);
            this.isLogin = this.is_login;
        },
        computed: {
            isActived() {
                return this.pagination.current_page;
            },
            pagesNumber() {
                if (!this.pagination.to) {
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods: {
            fetchItems(page) {
                var data = {page: page};
                axios.get('/api/item/answer?page=' + data.page).then((response) => {
                    this.items = response.data.data;
                    this.pagination = response.data;
                });
            },
            changePage(page) {
                this.pagination.current_page = page;
                this.fetchItems(page);
            },
            getUserUrl(item) {
                return '/user/' + item.user.id;
            },
            getAnswerName(item) {
                return 'answer_' + item.id;
            },
            getAnswerCommentCount(item) {
                return item.comments.length;
            }
        }
    }
</script>
