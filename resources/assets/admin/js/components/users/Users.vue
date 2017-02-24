<template>	
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-8">
					<span>Users</span>
				</div>
				
				<div class="col-md-4">
					<div class="pull-right">
						<router-link to="/users/add" class="btn btn-info">Create New</router-link>
					</div>					
				</div>
			</div>
		</div>

		<div class="panel-body">
			<table class="table table-striped" v-if="!isFetching">
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="user in users.data">
						<td v-text="user.name"></td>
						<td v-text="user.email"></td>
						<td align="right">					
                            <router-link :to="{ name: 'edit-user', params: { id: user.id } }" >Edit</router-link>&nbsp;&nbsp;
                            <a v-if="loggedUser.id != user.id" href="javascript:;" @click="deleteUser(user.id)" class="text-danger">Delete</a>
                        </td>
					</tr>
				</tbody>
			</table>
			<div v-else>
				<h3 class="text-center">Loading..</h3>
			</div>
            <paginator
                pagination-base-url="/admin/blog-users"
                :next-page-url="users.next_page_url"
                :prev-page-url="users.prev_page_url"
                :result-set="users">                                
            </paginator>
		</div>
	</div>
</div>
</template>

<script>
	import User from '../../models/User';

	export default {
		data() {
			return {
				loggedUser : window.Laravel.current_user,

				users: [],

				isFetching: false,
			}
		},
		created() {
			this.listUsers();

			Event.listen('onPageChanged', (data) => {
                this.users = data;
            });
		},

		methods: {
			listUsers() {
				this.isFetching = true;
				User.all()
				.then(response => {
					this.isFetching = false;
					this.users = response.data;
				});
			},

            deleteUser(id) {
                let thisRef = this;

                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this data!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    showLoaderOnConfirm: true,
                    closeOnConfirm: false
                },
                function(){
                    User.delete(id)
                    .then(response => {
                        console.log(response);
                        thisRef.listUsers();
                        swal({
                            title: "Deleted!",
                            text: "Your record has been deleted.",
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    })
                    .catch(error => {
                        console.log(error);
                    });
                });
            }
		}
	}	
</script>