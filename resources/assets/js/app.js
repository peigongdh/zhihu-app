/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./ws');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('question-follow-button', require('./components/QuestionFollowButton.vue'));
Vue.component('user-follow-button', require('./components/UserFollowButton.vue'));
Vue.component('user-vote-button', require('./components/UserVoteButton.vue'));
Vue.component('send-message', require('./components/SendMessage.vue'));
Vue.component('comment', require('./components/Comment.vue'));
Vue.component('user-avatar', require('./components/Avatar.vue'));
Vue.component('question-pagination', require('./components/QuestionPagination.vue'));
Vue.component('answer-pagination', require('./components/AnswerPagination.vue'));
Vue.component('action-pagination', require('./components/ActionPagination.vue'));
Vue.component('timeline-pagination', require('./components/TimelinePagination.vue'));
Vue.component('message-pagination', require('./components/MessagePagination.vue'));
Vue.component('notification-pagination', require('./components/NotificationPagination.vue'));

const app = new Vue({
    el: '#app'
});
