<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Manage <a v-if="form.action == 'Update'" href="javascript:;" @click="resetForm()" class="pull-right">New</a></div>

                    <div class="panel-body">
                        <form action="post" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
                            <input type="hidden" name="form_action" v-model="form.action">
                            <input type="hidden" name="id" v-model="form.id">

                            <div class="form-group">
                                <label>Category</label>
                                <input class="form-control" name="name" v-model="form.name" @keyup="generateSlug()">

                                <span class="text-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                            </div>

                            <div class="form-group">
                                <label>Parent</label>
                                <select class="form-control" name="parent" v-model="form.parent">
                                    <option value=""></option>
                                    <option v-for="parent_category in parent_categories" :value="parent_category.id">
                                        {{ parent_category.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" class="form-control" name="slug" v-model="form.slug">

                                <span class="text-danger" v-if="form.errors.has('slug')" v-text="form.errors.get('slug')"></span>

                                <span class="help-block">{{ site_url }}/category/{{ form.slug }}</span>
                            </div>

                            <input type="submit" :disabled="isLoading" class="btn btn-primary" :value="form.action">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Categories</div>

                    <div class="panel-body">
                        <div class="alert alert-success" v-if="alert_message">{{ alert_message }}</div>
                        <div v-if="isFetching">
                            <h3 class="text-center">Loading..</h3>
                        </div>
                        <table class="table table-striped" v-if="!isFetching">
                            <thead>
                                <tr>
                                    <th>Category Name</th>
                                    <th>Parent</th>
                                    <th>Slug</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="category in categories.data">
                                    <td>{{ category.name }}</td>
                                    <td>{{ (category.parent != null) ? category.parent.name : '-' }}</td>
                                    <td>{{ category.slug }}</td>
                                    <td align="right">
                                        <a href="javascript:;" @click="editCategory(category)">Edit</a>&nbsp;&nbsp;
                                        <a href="javascript:;" @click="deleteCategory(category.id)" class="text-danger">Delete</a>
                                    </td>
                                </tr>
                                <tr v-if="categories.total == 0">
                                    <td colspan="4" align="center">No Data Available</td>
                                </tr>
                            </tbody>
                        </table>
                        <paginator
                            pagination-base-url="/admin/categories"
                            :next-page-url="categories.next_page_url"
                            :prev-page-url="categories.prev_page_url"
                            :result-set="categories">                                
                        </paginator>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Category from '../models/Category';

    export default {
        data() {
            return {
                site_url: window.Laravel.site_url,
                
                categories: [],

                isLoading: false,

                isFetching: false,

                parent_categories: [],

                form: new Form({
                    id: '',
                    action: 'Create',
                    name: '',
                    parent: '',
                    slug: '',
                }),

                alert_message : ''
            }
        },
        created() {
            this.listCategories();

            Event.listen('onPageChanged', (data) => {
                this.resetForm();
                this.categories = data.categories;
            });
        },
        methods: {
            generateSlug() {
                return this.form.slug = this.form.name.trim().toLowerCase().replace(/ /g, '-');
            },

            onSubmit() {
                this.isLoading = true;

                let formSubmit, successMessage;

                if(this.form.action == 'Update') {
                    formSubmit = this.form.put('/admin/categories/'+this.form.id)

                    successMessage = "Record has been updated";
                } else {
                    formSubmit = this.form.post('/admin/categories')

                    successMessage = "Record has been created";
                }

                formSubmit
                .then(data => {
                    this.isLoading = false;
                   if(!data.error) {
                        swal({
                            title: "Success",
                            text: successMessage,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        })
                        this.listCategories();
                        this.resetForm();
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
                    this.isLoading = false;

                    console.log(error);
                });
            },

            editCategory(category) {
                this.form.reset();                
                this.form.id = category.id;
                this.form.action = 'Update';
                this.form.name = category.name;
                this.form.parent = (category.parent != null) ? category.parent.id : '';
                this.form.slug = category.slug;
            },

            resetForm() {
                this.form.reset();
                this.form.action = 'Create';
            },

            deleteCategory(id) {
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
                    Category.delete(id)
                    .then(response => {
                        console.log(response);
                        thisRef.listCategories();
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
            },

            listCategories() {
                this.isFetching = true;
                Category.all()
                .then(response => {
                    this.isFetching = false;
                    this.categories = response.data.categories;
                    this.parent_categories = response.data.parent_categories;
                });                
            }
        }
    }
</script>
