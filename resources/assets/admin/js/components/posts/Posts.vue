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
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Post</th>
						<th>Categories</th>
						<th></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
</template>

<script>
	export default {

	}
</script>