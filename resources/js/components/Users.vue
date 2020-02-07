
<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users Table</h3>
                        <div class="card-tools">
                            <button class="btn btn-success btn-sm mt-2" data-toggle="modal" data-target="#addNew">
                                <i class="fa fa-user-plus"></i> Add New
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover" >
                            <tbody>
                                <tr class="thead-dark">
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Registered At</th>
                                    <th>Modify</th>
                                </tr>

                                <tr v-for="user in users" :key="user.id">
                                    <td>{{user.id}}</td>
                                    <td>{{user.name}}</td>
                                    <td>{{user.email}}</td>
                                    <td>{{user.type | upText}}</td>
                                    <td>{{user.created_at | myDate}}</td>
                                     <td>
                                        <a href="#">
                                            <i class="fa fa-edit blue"></i>
                                        </a>
                                        /
                                        <a href="#">
                                            <i class="fa fa-trash red"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                            <!-- end body table -->
                        </table>
                        <!-- end table -->
                    </div>
                      <!-- end card body -->
                </div>

            </div>
        </div>

        <!-- Madel -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog"
            aria-labelledby="addNew" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="createUser">
                <div class="modal-body">
                    <div class="form-group">
                        <input v-model="form.name" type="text" name="name"
                            placeholder="name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="Name"></has-error>
                    </div>

                    <div class="form-group">
                        <input v-model="form.email" type="email" name="email"
                            placeholder="Email"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>
                    </div>

                    <div class="form-group">
                        <select v-model="form.type" id="type" name="type"
                            placeholder="Type"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">

                            <option value="">Select User Role</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                            <option value="author">Author</option>

                        </select>
                        <has-error :form="form" field="type"></has-error>
                    </div>

                    <div class="form-group">
                        <input v-model="form.password" type="password" name="password"
                            placeholder="Password"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
                    </div>

                    <div class="form-group">
                        <textarea v-model="form.bio" name="type"
                            placeholder="Short bio for user (optional)" id="bio"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }">
                        <has-error :form="form" field="bio"></has-error>
                        </textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Create</button>
                </div>
            </form>
            </div>
        </div>
        </div>
        <!-- End Madol -->

    </div>
    <!-- end container -->
</template>

<script>
    export default {
        data () {
                    return {
                    users : {},
                    // Create a new form instance
                    form: new Form({
                        name: '',
                        email:'',
                        type:'',
                        password: '',
                        bio:'',
                        avatar:'',
                    })
                    }
                },
        methods:{

                  loadUsers(){
                          axios.get('api/users').then(({ data }) => (this.users = data.data));
                  },
                  createUser(){
                                this.$Progress.start();
                                this.form.post('api/users')
                                .then(()=>{
                                            Fire.$emit('AfterCreate');
                                            $('#addNew').modal('hide');
                                            toast.fire({
                                                        icon: 'success',
                                                        title: 'User created in successfully'
                                                        })
                                            this.$Progress.finish();
                                })
                                .catch(()=>{
                                         this.$Progress.fail();
                                });

                  }
        },
        created(){
                    this.loadUsers();
                    Fire.$on('AfterCreate',() => {
                        this.loadUsers();
                    });
                   // setInterval(() => this.loadUsers(),3000);

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

