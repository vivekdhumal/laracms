import VueRouter from 'vue-router';

let routes = [
	{
		path: '/posts',
		name: 'posts-desk',
		component: require('./components/posts/Posts')
	},
	{
		path: '/posts/add',
		component: require('./components/posts/PostsForm')
	},
	{
		path: '/categories',
		component: require('./components/Category')
	},
	{
		path: '/tags',
		component: require('./components/Tag')
	}
];

export default new VueRouter({
	routes
});