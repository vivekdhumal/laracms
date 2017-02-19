<template>	
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-8">
					<h4>Posts</h4>
				</div>
				
				<div class="col-md-4">
					<div class="pull-right">
						<router-link to="/posts/add" class="btn btn-info">Create New</router-link>
					</div>					
				</div>
			</div>
		</div>

		<div class="panel-body">
			<table class="table table-striped" v-if="!isFetching">
				<thead>
					<tr>
						<th>Title</th>
						<th>Categories</th>
						<th>Status</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="article in articles.data">
						<td v-text="article.title"></td>
						<td>
							<span v-if="article.categories != null" v-for="article_cat in article.categories" class="label label-info">
								{{ article_cat.category.name }}
							</span>
							<p v-else >Uncategories</p>
						</td>
						<td v-text="article.status"></td>
						<td align="right">
                            <router-link :to="{ name: 'edit-post', params: { id: article.id } }" >Edit</router-link>&nbsp;&nbsp;
                            <a href="javascript:;" class="text-danger">Delete</a>
                        </td>
					</tr>
				</tbody>
			</table>
			<div v-else>
				<h3 class="text-center">Loading..</h3>
			</div>
            <paginator
                pagination-base-url="/admin/blog-articles"
                :next-page-url="articles.next_page_url"
                :prev-page-url="articles.prev_page_url"
                :result-set="articles">                                
            </paginator>
		</div>
	</div>
</div>
</template>

<style>
	table tbody .label {
		margin-right: 3px;
		font-size: 13px;
	}
</style>

<script>
	import Article from '../../models/Article';

	export default {
		data() {
			return {
				articles: [],

				isFetching: false,
			}
		},
		created() {
			this.isFetching = true;
			Article.all()
			.then(response => {
				this.isFetching = false;
				this.articles = response.data;
			});

			Event.listen('onPageChanged', (data) => {
                this.articles = data;
            });
		}
	}
</script>