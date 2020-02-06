
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
                        <table class="table table-hover">
                            <tbody>
                                <tr class="thead-dark">
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Modify</th>
                                </tr>

                                <tr>
                                    <td>1</td>
                                    <td>Ahmed</td>
                                    <td>Ahmed@gamil.com</td>
                                    <td>Approved</td>
                                    <td>Edit/Delete</td>
                                </tr>

                                 <tr>
                                    <td>1</td>
                                    <td>Mohamed</td>
                                    <td>Mohamed@gamil.com</td>
                                    <td>Approved</td>
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
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm">Create</button>
            </div>
            </div>
        </div>
        </div>
        <!-- End Madol -->

    </div>
    <!-- end container -->
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

