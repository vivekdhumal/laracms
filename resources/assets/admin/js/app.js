import './bootstrap';
import router from './routes';

/*Vue.component('category-desk', require('./components/Category.vue'));
Vue.component('tag-desk', require('./components/Tag.vue'));
Vue.component('posts-desk', require('./components/posts/Posts.vue'));*/
Vue.component('paginator', require('./components/Paginator.vue'));

const app = new Vue({
    el: '#app',
    router
});
