<template>
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="media page-header" v-for="item in items">
                <div class="media-left">
                    <a :href="getUserUrl(item)">
                        <img width="48" :src="item.user.avatar" :alt="item.user.name">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">
                        <a :href="getQuestionUrl(item)">
                            {{ item.title }}
                        </a>
                    </h4>
                    <div v-html="item.body"></div>
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
                axios.get('/api/item/question?topic=' + this.topic + '&page=' + data.page).then((response) => {
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
            getQuestionUrl(item) {
                return '/question/' + item.id;
            }
        }
    }
</script>
