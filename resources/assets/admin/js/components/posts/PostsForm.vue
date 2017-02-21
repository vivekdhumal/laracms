<template>	
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-8">
					<span v-if="id">
						Edit Post
					</span>
					<span v-else>
						New Post
					</span>
				</div>
			</div>
		</div>

		<div class="panel-body">
			<div v-if="retreivingData">
				<h3 class="text-center">Please wait..</h3>
			</div>
			<form v-else method="post" enctype="multipart/form-data" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
				<div class="form-group">
					<label>Title</label>

					<input type="text" class="form-control" v-model="form.title" name="title" @keyup="generateSlug()">

					<span class="text-danger" v-if="form.errors.has('title')" v-text="form.errors.get('title')"></span>
				</div>

				<div class="form-group">
					<label>Content</label>

					<vue-editor
						:editor-content="content"
						:use-save-button="false"
						:editor-toolbar="customToolbar"
						@editor-updated="handleUpdatedContent"						
  						@save-content="handleSavingContent">						
					</vue-editor>

					<input type="hidden" name="content" v-model="form.content">

					<span class="text-danger" v-if="form.errors.has('content')" v-text="form.errors.get('content')"></span>
				</div>

				<div class="form-group">
					<label>Excerpt</label>

					<textarea class="form-control editor" v-model="form.excerpt" name="excerpt"></textarea>
				</div>

				<div class="form-group">
					<label>Choose Categories</label>

					<select class="form-control multi-select" :disabled="!categories.length > 0" multiple="multiple" name="categories[]" v-model="form.categories">
						<option v-for="category in categories" :value="category.id" v-text="category.name"></option>
					</select>
				</div>

				<div class="form-group">
					<label>Choose Tags</label>

					<select class="form-control multi-select" :disabled="!tags.length > 0" multiple="multiple" name="tags[]"  v-model="form.tags">
						<option v-for="tag in tags" :value="tag.id" v-text="tag.name"></option>
					</select>
				</div>

				<div class="form-group">
					<label>Featured Image</label>

					<input type="file" name="" @change="onFileChange">

					<input type="hidden" name="featured_image" v-model="form.featured_image">

					<div v-if="featured_image_path != null">
						<br>
						<img :src="featured_image_path" width="100">						
					</div>

					<div v-if="file_uploading">
						<br>
						Uploading..					
					</div>

					<span class="text-danger" v-if="form.errors.has('featured_image')" v-text="form.errors.get('featured_image')"></span>
				</div>

				<div class="form-group">
					<label>Slug</label>

					<input type="text" class="form-control" name="slug" v-model="form.slug">

					<span class="help-block">{{ site_url }}/article/{{ form.slug }}</span>

					<span class="text-danger" v-if="form.errors.has('slug')" v-text="form.errors.get('slug')"></span>
				</div>

				<div class="form-group">
					<label>Status</label>

					<select class="form-control" name="status" v-model="form.status">
						<option value="draft">Draft</option>
						<option value="published">Published</option>
					</select>
				</div>

				<input type="submit" :disabled="isSubmiting" class="btn btn-primary" value="Submit">&nbsp;&nbsp;

				<router-link to="/posts" :disabled="isSubmiting" class="btn btn-info">Cancel</router-link>
			</form>
		</div>
	</div>
</div>
</template>

<style>
	form .multi-select {
		height: 150px;
	}
</style>

<script>
	import { VueEditor } from 'vue2-editor';
    import Form from '../../core/Form';
	import Article from '../../models/Article';
    import Category from '../../models/Category';
    import Tag from '../../models/Tag';

	export default {
		props: [
			'id'
		],

		data() {
			return {

				site_url: window.Laravel.site_url,

				isSubmiting : false,

				retreivingData: false,

				categories: [],

				tags: [],

				featured_image_path : null,

				file_uploading: false,

				form: new Form({
                    title: '',
                    content: '',
                    excerpt: '',
                    featured_image: '',
                    slug: '',
                    author_id: '',
                    status: 'draft',
                    categories: [],
                    tags: [],
                }),

				content: null,

				customToolbar: [
		            ['bold', 'italic', 'underline', 'strike', 'link'],
		            [{ 'align': [] }],
		            [{ 'header': 1 }, { 'header': 2 }],
		            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
		            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
		            [{ 'color': [] }, { 'background': [] }],  
		            ['image', 'code-block'],
		            ['clean']
	          	]
			}
		},

		created() {
			console.log(this.id);

			if(this.id) {
				this.retreivingData = true;
				Article.edit(this.id)
				.then(response => {
					this.retreivingData = false;
					this.form.title = response.data.article.title;
					//this.form.content = this.content = response.data.article.content;
					console.log(this.content);
					this.form.excerpt = response.data.article.excerpt;
					this.form.featured_image = response.data.article.featured_image;
					this.form.slug = response.data.article.slug;
					this.form.status = response.data.article.status;
					this.featured_image_path = response.data.article.featured_image_url;					
					this.getCategories(response.data.categories);
					this.getTags(response.data.tags);
					this.$nextTick(() => {
						this.form.content = this.content = response.data.article.content;
					})
				})
				.catch(error => {
					console.log(error.response.data);
				});
			} else {
				this.getCategories();
				this.getTags()
			}
		},

	    components: {
	      VueEditor
	    },

	    methods: {
            generateSlug() {
                return this.form.slug = this.form.title.trim().toLowerCase().replace(/ /g, '-');
            },

			handleSavingContent(value) {
				this.form.content = value;
			},

			handleUpdatedContent(value) {
				this.form.content = value;
			},

			onSubmit() {
				this.isSubmiting = true;

				let form_submit, success_message;

				console.log(this.id);

				if(this.id > 0) {
					form_submit = this.form.submit('patch', '/admin/blog-articles/'+this.id);
					success_message = "Record has been updated";
				} else {
					form_submit = this.form.submit('post', '/admin/blog-articles');
					success_message = "Record has been created";
				}
				
				form_submit
				.then(data => {
					console.log(this.form);
					this.isSubmiting = false;
					if(!data.error) {
                        swal({
                            title: "Success",
                            text: success_message,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });

                        this.$router.push('/posts');
					} else {
                         swal({
                            title: "Error",
                            text: "Please try again",
                            type: "error",
                            timer: 2000,
                            showConfirmButton: false
                        })
                   }
				})
				.catch(error => {
					this.isSubmiting = false;
					console.log(error);
				})
			},

			getCategories(selected_categories = false) {
				Category.withoutPagination()
                .then(response => {
                    this.categories = response.data.categories;
                    if(selected_categories) {
                    	this.form.categories = selected_categories;
                    }
                });
			},

			getTags(selected_tags = false) {
				 Tag.withoutPagination()
                .then(response => {
                    this.tags = response.data.tags;
                    if(selected_tags) {
                    	this.form.tags = selected_tags;
                    }
                });  
			},

			onFileChange(ele) {
				let files = ele.target.files || ele.dataTransfer.files;

	            if (!files.length) {
	                return;
	            }

	            this.form.featured_image = files[0];

	            let formData = new FormData();

	            formData.append('featured_image', files[0]);

	            this.file_uploading = true;

	            axios.post('/admin/blog-articles/file-upload', formData)
	            .then(response => {
	            	console.log(response.data);

                    swal({
                        title: "Success",
                        text: "File uploaded successfully",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });

	            	this.file_uploading = false;
	            	this.featured_image_path = response.data.path;
	            	this.form.featured_image = response.data.filename;
	            })
	            .catch(error => {
	            	this.file_uploading = false;

	            	let uploadError = error.response.data['featured_image'][0];
	            	console.log(error.response.data['featured_image'][0]);

	            	if(uploadError != "") {
                         swal({
                            title: "Error",
                            text: uploadError,
                            type: "error",
                        });
	            	}
	            })
			}
	    }
	}
</script>