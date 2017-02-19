import VueRouter from 'vue-router';

let routes = [
	{
		path: '/',
		component: require('./components/Dashboard')
	},
	{
		path: '/posts',
		name: 'posts-desk',
		component: require('./components/posts/Posts')
	},
	{
		path: '/posts/add',
		component: require('./components/posts/PostsForm'),
	},
	{
		path: '/posts/edit/:id',
		name: 'edit-post',
		component: require('./components/posts/PostsForm'),
		props: true
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