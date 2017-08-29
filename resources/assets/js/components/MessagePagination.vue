<template>
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" id="message">
                <div class="panel-heading">
                    私信列表
                </div>
                <div class="panel-body">
                    <div class="media" v-for="(item, index) in items">
                        <div class="media-left" v-if="isToUserIdEqualSelfUserId(item)">
                            <a :href="getUserUrl(item[0].from_user.id)">
                                <img width="48" :src="item[0].from_user.avatar" :alt="item[0].from_user.name">
                            </a>
                        </div>
                        <div class="media-left" v-else>
                            <a :href="getUserUrl(item[0].to_user.id)">
                                <img width="48" :src="item[0].to_user.avatar" :alt="item[0].to_user.name">
                            </a>
                        </div>
                        <div class="media-body" :class="isUnread(item)">
                            <h4 class="media-heading" v-if="isToUserIdEqualSelfUserId(item)">
                                <a :href="getUserUrl(item[0].from_user.id)">
                                    {{ item[0].from_user.name }}
                                </a>
                            </h4>
                            <h4 class="media-heading" v-else>
                                <a :href="getUserUrl(item[0].to_user.id)">
                                    {{ item[0].to_user.name }}
                                </a>
                            </h4>
                            <p>
                                {{ item[0].body }}
                            </p>
                            <a :href="getDialogUrl(index)">
                                查看对话
                            </a>
                        </div>
                        <small class="pull-right">
                            {{ item[0].created_at }}
                        </small>
                        <br>
                    </div>
                </div>
            </div>
            <br>
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
        props: ['user_id'],
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
                axios.get('/api/item/message' + '?page=' + data.page).then((response) => {
                    this.items = response.data.data;
                    this.pagination = response.data;
                });
            },
            changePage(page) {
                this.pagination.current_page = page;
                this.fetchItems(page);
            },
            getDialogUrl(index) {
                return '/message/' + index;
            },
            getUserUrl(index) {
                return '/user/' + index;
            },
            isFromUserIdEqualSelfUserId(item) {
                return item[0].from_user.id === this.user_id;
            },
            isToUserIdEqualSelfUserId(item) {
                return item[0].to_user.id === this.user_id;
            },
            isUnread(item) {
                if (item[0].from_user.id === this.user_id) {
                    return '';
                } else if (item[0].has_read === 'F') {
                    return 'unread';
                }
                return '';
            }
        }
    }
</script>
