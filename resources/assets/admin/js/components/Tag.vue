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
                                <label>Tag</label>
                                <input class="form-control" name="name" v-model="form.name" @keyup="generateSlug()">

                                <span class="text-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                            </div>

                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" class="form-control" name="slug" v-model="form.slug">

                                <span class="text-danger" v-if="form.errors.has('slug')" v-text="form.errors.get('slug')"></span>

                                <span class="help-block">{{ site_url }}/tag/{{ form.slug }}</span>
                            </div>

                            <input type="submit" :disabled="isLoading" class="btn btn-primary" :value="form.action">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Tags</div>

                    <div class="panel-body">
                        <div class="alert alert-success" v-if="alert_message">{{ alert_message }}</div>
                        <div v-if="isFetching">
                            <h3 class="text-center">Loading..</h3>
                        </div>
                        <table class="table table-striped" v-if="!isFetching">
                            <thead>
                                <tr>
                                    <th>Tag Name</th>
                                    <th>Slug</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="tag in tags.data">
                                    <td>{{ tag.name }}</td>
                                    <td>{{ tag.slug }}</td>
                                    <td align="right">
                                        <a href="javascript:;" @click="editTag(tag)">Edit</a>&nbsp;&nbsp;
                                        <a href="javascript:;" @click="deleteTag(tag.id)" class="text-danger">Delete</a>
                                    </td>
                                </tr>
                                <tr v-if="tags.total == 0">
                                    <td colspan="3" align="center">No Data Available</td>
                                </tr>
                            </tbody>
                        </table>
                        <paginator
                            pagination-base-url="/admin/blog-tags"
                            :next-page-url="tags.next_page_url"
                            :prev-page-url="tags.prev_page_url"
                            :result-set="tags">                                
                        </paginator>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from '../core/Form';
    import Tag from '../models/Tag';

    export default {
        data() {
            return {
                site_url: window.Laravel.site_url,

                tags: [],

                isLoading: false,

                isFetching: false,

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
            this.listTags();

            Event.listen('onPageChanged', (data) => {
                this.resetForm();
                this.tags = data.tags;
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
                    formSubmit = this.form.submit('patch', '/admin/blog-tags/'+this.form.id)

                    successMessage = "Record has been updated";
                } else {
                    formSubmit = this.form.submit('post', '/admin/blog-tags')

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
                        this.listTags();
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

            editTag(tag) {
                this.form.reset();                
                this.form.id = tag.id;
                this.form.action = 'Update';
                this.form.name = tag.name;
                this.form.parent = (tag.parent != null) ? tag.parent.id : '';
                this.form.slug = tag.slug;
            },

            resetForm() {
                this.form.reset();
                this.form.action = 'Create';
            },

            deleteTag(id) {
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
                    Tag.delete(id)
                    .then(response => {
                        console.log(response);
                        thisRef.listTags();
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

            listTags() {
                this.isFetching = true;
                Tag.all()
                .then(response => {
                    this.isFetching = false;
                    this.tags = response.data.tags;
                });                
            }
        }
    }
</script>
