<style>
.widget-user-header{
    background: center center;
    background-size: cover;
    height: 300px !important ;
}
</style>

<template>
    <div class="container">
            <section class="content">
                <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Widget: user widget style 1 -->
                                <div class="card card-widget widget-user">
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header text-white" style="background: url('./images/user-cover.jpg') center center;">
                                    <h3 class="widget-user-username text-right">{{this.form.name}}</h3>
                                </div>
                                <div class="widget-user-image">
                                    <img class="img-circle" src="images/1537591603.png" alt="User Avatar">
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                        <h5 class="description-header">3,200</h5>
                                        <span class="description-text">SALES</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                        <h5 class="description-header">13,000</h5>
                                        <span class="description-text">FOLLOWERS</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4">
                                        <div class="description-block">
                                        <h5 class="description-header">35</h5>
                                        <span class="description-text">PRODUCTS</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                </div>
                                <!-- /.widget-user -->
                            </div>
                        </div>
                        <!-- /.row -->
                    <!-- /.widget-user -->

            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" href="#activites" data-toggle="tab">Activites</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <!-- /.tab-pane -->
                  <div class="tab-pane active " id="activites">
                      <div class="text-center">Display User Activites</div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal" >
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input v-model="form.name" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"
                           id="inputName" 
                          placeholder="Name" >
                          <has-error :form="form" field="name"></has-error>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input v-model="form.email" type='email' required class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" id="inputEmail" placeholder="Email">
                          <has-error :form="form" field="email"></has-error>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Bio</label>
                        <div class="col-sm-10">
                          <textarea v-model="form.bio" class="form-control" id="inputExperience" placeholder="Biography"></textarea>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Picture</label>
                        <div class="col-sm-10">
                          <input type="file" @change="updateProfile" class="form-control" id="avatar" placeholder="Email">
                        </div>
                      </div>

                        <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                          <input v-model="form.password" type="password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" id="password" placeholder="Password (leave empty if not changing) ">
                           <has-error :form="form" field="password"></has-error>
                        </div>
                      </div>

                     

                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button @click.prevent="updateInfo" type="submit" class="btn btn-success">Update</button>
                        </div>
                      </div>


                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
     

                </div><!-- /.container-fluid -->
            </section>
            <!-- end section-->
        </div>
</template>

<script>
    export default {
        data(){
          return{
             form: new Form({
                    id:'',
                    name: '',
                    email:'',
                    password: '',
                    bio:'',
                    avatar:'',
                  })
          } 
        },
        mounted() {
            console.log('Component mounted.')
        },

        methods:{

          updateInfo(){
            this.$Progress.start();
            this.form.put('api/profile/')
            .then(() => {
              this.form.password='';
              this.$Progress.finish();
            })
            .catch(()=>{
              this.$Progress.fail();
            });
          },

          updateProfile(e){
           // console.log('uploading');
           let file = e.target.files[0];
           let reader = new FileReader();
           reader.onloadend =(file) => {
            //console.log('RESULT', reader.result)
            this.form.avatar = reader.result;
           }
           reader.readAsDataURL(file);
          }

        },

        created(){
          axios.get('api/profile')
          .then(({data})=>(this.form.fill(data)));
        }
    }
</script>
