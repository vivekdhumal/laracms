<template>	
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-8">
					<span v-if="id">
						Edit User
					</span>
					<span v-else>
						New User
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
					<label>Name</label>

					<input type="text" class="form-control" v-model="form.name" name="name">

					<span class="text-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
				</div>

				<div class="form-group">
					<label>Email</label>

					<input type="text" class="form-control" v-model="form.email" name="email">

					<span class="text-danger" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
				</div>

				<div class="form-group">
					<label>Password</label>

					<input type="password" class="form-control" v-model="form.password" name="password">

					<span class="text-danger" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></span>
				</div>

				<input type="submit" :disabled="isSubmiting" class="btn btn-primary" value="Submit">&nbsp;&nbsp;

				<router-link to="/users" :disabled="isSubmiting" class="btn btn-info">Cancel</router-link>
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
    import Form from '../../core/Form';
	import User from '../../models/User';

	export default {
		props: [
			'id'
		],

		data() {
			return {
				site_url: window.Laravel.site_url,

				isSubmiting : false,

				retreivingData: false,

				form: new Form({
                    name: '',
                    email: '',
                    password: '',
                })
			}
		},

		created() {
			console.log(this.id);

			if(this.id) {
				this.retreivingData = true;
				User.edit(this.id)
				.then(response => {
					this.retreivingData = false;
					this.form.name = response.data.name;
					this.form.email = response.data.email;
				})
				.catch(error => {
					console.log(error.response.data);
				});
			}
		},

	    methods: {

			onSubmit() {
				this.isSubmiting = true;

				let form_submit, success_message;

				console.log(this.id);

				if(this.id > 0) {
					form_submit = this.form.submit('patch', '/admin/users/'+this.id);
					success_message = "Record has been updated";
				} else {
					form_submit = this.form.submit('post', '/admin/users');
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

                        this.$router.push('/users');
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
	    }
	}
</script>