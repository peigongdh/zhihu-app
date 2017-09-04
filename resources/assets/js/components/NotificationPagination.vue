<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default" id="notification">
                    <div class="panel-heading">
                        消息通知
                    </div>
                    <div class="panel-body" v-for="(item, date) in items">
                        <strong>{{ date }}</strong>
                        <li v-for="n in item" v-if="isMessageNotification(n)" :class="['notification', isUnread(n)]">
                            {{ n.data.name }}给你发了一条<a :href="getMessageNotificationFinalUrl(n)">私信。</a>
                        </li>
                        <li v-for="n in item" v-if="isNewUserFollowNotification(n)"
                            :class="['notification', isUnread(n)]">
                            <a :href="getNewUserFollowNotificationFinalUrl(n)">{{ n.data.name }}</a>关注了你。
                        </li>
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
    </div>
</template>

<script>
    export default {
        props: [],
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
                axios.get('/api/item/notification?page=' + data.page).then((response) => {
                    this.items = response.data.data;
                    this.pagination = response.data;
                });
            },
            changePage(page) {
                this.pagination.current_page = page;
                this.fetchItems(page);
            },
            isMessageNotification(notification) {
                return notification.type === 'App\\Notifications\\MessageNotification';
            },
            isNewUserFollowNotification(notification) {
                return notification.type === 'App\\Notifications\\NewUserFollowNotification';
            },
            isUnread(notification) {
                return !!notification.read_at ? '' : 'unread';
            },

            getMessageNotificationUrlWithRedirectUrl(notification) {
                return "/notification/" + notification.id + "?redirect_url=/message/" + notification.data.dialog_id;
            },
            getMessageNotificationUrl(notification) {
                return "/message/" + notification.data.dialog_id;
            },
            getMessageNotificationFinalUrl(notification) {
                return !!notification.read_at ? this.getMessageNotificationUrl(notification) : this.getMessageNotificationUrlWithRedirectUrl(notification);
            },

            getNewUserFollowNotificationUrlWithRedirectUrl(notification) {
                return "/notification/" + notification.id + "?redirect_url=/user/" + notification.data.id;
            },
            getNewUserFollowNotificationUrl(notification) {
                return "/user/" + notification.data.id;
            },
            getNewUserFollowNotificationFinalUrl(notification) {
                return !!notification.read_at ? this.getNewUserFollowNotificationUrl(notification) : this.getNewUserFollowNotificationUrlWithRedirectUrl(notification);
            }
        }
    }
</script>
