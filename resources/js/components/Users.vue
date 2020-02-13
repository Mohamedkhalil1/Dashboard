
<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users Table</h3>
                        <div class="card-tools">
                            <button class="btn btn-success btn-sm mt-2" data-toggle="modal" data-target="#addNew" @click="createForm">
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

                                <tr v-for="user in users.data" :key="user.id">
                                    <td>{{user.id}}</td>
                                    <td>{{user.name}}</td>
                                    <td>{{user.email}}</td>
                                    <td>{{user.type | upText}}</td>
                                    <td>{{user.created_at | myDate}}</td>
                                     <td>
                                       <a href="#"
                                       data-toggle="modal" data-target="#editUser">
                                            <i class="fa fa-edit blue" @click="editShow(user)"></i>
                                        </a>
                                        /
                                        <a href ="#"  @click="deleteUser(user.id)">
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
                      <div class="card-footer">
                          <pagination :data="users"
                             @pagination-change-page="getResults"></pagination>
                      </div>
                </div>

            </div>
        </div>

        <div v-if="!$gate.isAdminOrAuthor()">
            <not-found></not-found>
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


         <!-- Madel -->
        <div class="modal fade" id="editUser" tabindex="-1" role="dialog"
            aria-labelledby="editUser" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="editUser">
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
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
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
                    editMode : true ,
                    users : {},
                    // Create a new form instance
                    form: new Form({
                        id:'',
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
                getResults(page = 1){
                    axios.get('api/users?page=' + page)
                        .then(response => {
                            this.users = response.data;
                        });
                },

                editUser(){
                      this.$Progress.start();
                      const swalWithBootstrapButtons =
                        swal.mixin({
                                    customClass: {
                                        confirmButton: 'btn btn-success ml-3',
                                        cancelButton: 'btn btn-danger'
                                    },
                                    buttonsStyling: false
                                    })

                                    swalWithBootstrapButtons.fire({
                                    title: 'Are you sure?',
                                    text: "user will be updated to new data",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes, update it!',
                                    cancelButtonText: 'No, cancel!',
                                    reverseButtons: true
                                    }).then((result) => {

                                    if (result.value) {
                                       this.form.put('api/users/'+this.form.id)
                                        .then(()=>{
                                                $('#editUser').modal('hide');
                                        })
                                        swalWithBootstrapButtons.fire(
                                        'Updated!',
                                        'Your file has been update.',
                                        'success'
                                        )
                                        Fire.$emit('AfterEdit');
                                    } else if (
                                        /* Read more about handling dismissals below */
                                        result.dismiss === swal.DismissReason.cancel
                                    ) {
                                        swalWithBootstrapButtons.fire(
                                        'Cancelled',
                                        'Your imaginary file is safe :)',
                                        'error'
                                        )
                                    }
                                    })
                                    .catch(() => {
                                        Swal.fire({
                                                    title: 'ERROR',
                                                    width: 600,
                                                    padding: '3em',
                                                    background: '#fff url(/images/trees.png)',
                                                    backdrop: `
                                                        rgba(0,0,123,0.4)
                                                        url("/images/nyan-cat.gif")
                                                        left top
                                                        no-repeat
                                                    `
                                                    })
                                    })


                },

                editShow(user){
                    $('#editUser').modal('show');
                    this.form.fill(user);
                },

                deleteUser(id){
                        const swalWithBootstrapButtons =
                        swal.mixin({
                                    customClass: {
                                        confirmButton: 'btn btn-success ml-3',
                                        cancelButton: 'btn btn-danger'
                                    },
                                    buttonsStyling: false
                                    })
                                    swalWithBootstrapButtons.fire({
                                    title: 'Are you sure?',
                                    text: "You won't be able to revert this!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes, delete it!',
                                    cancelButtonText: 'No, cancel!',
                                    reverseButtons: true
                                    }).then((result) => {
                                    if (result.value) {
                                        this.form.delete('api/users/'+id).then(()=>{
                                            swalWithBootstrapButtons.fire(
                                            'Deleted!',
                                            'Your file has been deleted.',
                                            'success'
                                            )
                                        Fire.$emit('AfterDelete');
                                        })
                                        .catch(()=>{
                                               swal.fire({
                                                    icon: 'error',
                                                    title: 'Oops...',
                                                    text: 'Something went wrong!',
                                                })
                                            });
                                       
                                    } else if (
                                        /* Read more about handling dismissals below */
                                        result.dismiss === swal.DismissReason.cancel
                                    ) {
                                        swalWithBootstrapButtons.fire(
                                        'Cancelled',
                                        'Your imaginary file is safe :)',
                                        'error'
                                        )
                                    }
                                    })
                                    .catch(() => {
                                        swal.fire({
                                                    title: 'ERROR',
                                                    width: 600,
                                                    padding: '3em',
                                                    background: '#fff url(/images/trees.png)',
                                                    backdrop: `
                                                        rgba(0,0,123,0.4)
                                                        url("/images/nyan-cat.gif")
                                                        left top
                                                        no-repeat
                                                    `
                                                    })
                                    })
                  },
                  createForm(){
                            this.form.reset();
                  },
                  loadUsers(){
                         if(this.$gate.isAdminOrAuthor()){
                                axios.get('api/users').then(({ data }) => (this.users = data));
                         }
                         else{

                         }
                         
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

                    Fire.$on('Searching',() => {
                        let query =this.$parent.search;
                        axios.get('api/findUser?q='+query)
                        .then((data)=>{
                           this.users= data.data;
                        })
                        .catch(()=>{

                        });
                    });
                    this.loadUsers();
                    Fire.$on('AfterCreate',() => {
                        this.loadUsers();
                    });
                     Fire.$on('AfterDelete',() => {
                        this.loadUsers();
                    });

                      Fire.$on('AfterEdit',() => {
                        this.loadUsers();
                    });

                   // setInterval(() => this.loadUsers(),3000);

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

