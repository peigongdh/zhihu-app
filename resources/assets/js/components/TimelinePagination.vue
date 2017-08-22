<template>
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" id="timeline" v-for="item in items">
                    <div class="panel-heading">
                        {{ item.action.user.name }} {{ getEventName(item.action.event) }}
                    </div>
                <div class="panel-body">
                    <div class="media">
                        <h4 class="media-heading">
                            <a :href="getQuestionUrl(item)">
                                {{ item.action.actionable.question.title }}
                            </a>
                        </h4>
                        <p></p>
                        <div class="media-left">
                            <a href="">
                                <img width="48" :src="item.action.user.avatar" :alt="item.action.user.name">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{ item.action.user.name }}</h4>
                            <p>待扩展</p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="collapse in" :id="getCollapseItemId(item)">
                        <div class="panel-body">
                            <div v-html="item.action.actionable.body"></div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <a class="pull-right" data-toggle="collapse" data-parent="#timeline" aria-expanded="true" :href="getCollapseItemHref(item)" :aria-controls="getCollapseItemId(item)">
                        展开/折叠
                    </a>
                </div>
            </div>
            <nav v-if="pagination.last_page > 1">
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
    </div>
</template>

<script>
    export default {
        props: ['topic'],
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
                items: []
            }
        },
        mounted() {
            this.fetchItems(this.pagination.current_page);
        },
        computed: {
            isActived() {
                return this.pagination.current_page;
            },
            pagesNumber() {
                if (!this.pagination.to) {
                    return [];
                }
                let from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                let to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                let pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods: {
            fetchItems(page) {
                let data = {page: page};
                axios.get('/api/item/timeline' + '?page=' + data.page).then((response) => {
                    this.items = response.data.data;
                    this.pagination = response.data;
                });
            },
            changePage(page) {
                this.pagination.current_page = page;
                this.fetchItems(page);
            },
            getQuestionUrl(item) {
                return '/question/' + item.action.actionable.question.id;
            },
            getCollapseItemId(item) {
                return 'answerBody' + item.id;
            },
            getCollapseItemHref(item) {
                return '#answerBody' + item.id;
            },
            getEventName(event) {
                let event_map = {
                    "USER_NEW_QUESTION": "创建了问题",
                    "USER_NEW_ANSWER": "回答了问题",
                    "USER_VOTE_ANSWER": "赞同了回答",
                    "USER_FOLLOW_QUESTION": "关注了问题",
                };
                return event_map[event];
            }
        }
    }
</script>
