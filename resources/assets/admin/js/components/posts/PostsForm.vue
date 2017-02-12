<template>	
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-8">
					<h4>Posts</h4>
				</div>
			</div>
		</div>

		<div class="panel-body">
			<form method="post">
				<div class="form-group">
					<label>Title</label>

					<input type="text" class="form-control" name="title">
				</div>

				<div class="form-group">
					<label>Content</label>

					<vue-html-editor name="html-editor"></vue-html-editor>
					<textarea class="form-control editor" name="content"></textarea>
				</div>

				<div class="form-group">
					<label>Excerpt</label>

					<textarea class="form-control editor" name="excerpt"></textarea>
				</div>

				<div class="form-group">
					<label>Choose Categories</label>

					<select class="form-control" multiple="multiple">
					</select>
				</div>

				<div class="form-group">
					<label>Choose Tags</label>

					<select class="form-control" multiple="multiple">
					</select>
				</div>

				<div class="form-group">
					<label>Featured Image</label>

					<input type="file" name="featured_image">
				</div>

				<div class="form-group">
					<label>Slug</label>

					<input type="text" class="form-control" name="slug">
				</div>

				<div class="form-group">
					<label>Status</label>

					<select class="form-control" name="status">
						<option value="draft">Draft</option>
						<option value="published">Published</option>
					</select>
				</div>

				<input type="submit" class="btn btn-primary" value="Submit">&nbsp;&nbsp;
				<router-link to="/posts" class="btn btn-info">Cancel</router-link>
			</form>
		</div>
	</div>
</div>
</template>

<script src="/backend/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">	
	tinymce.init({ selector: '.editor'});
</script>
<script>
	export default {
		mounted() {
		}
	}
</script>