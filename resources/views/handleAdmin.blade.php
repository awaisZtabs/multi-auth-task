@extends('layouts.app')
@section('content')
<style>
     .modal-backdrop {
            opacity: 0.5 !important;
        }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                  <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th class="th-sm">Name</th>
                <th class="th-sm">Email</th>
                <th class="th-sm">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }} </td>
                <td>{{ $user->email }} </td>
                <td style="text-align: center;">
                                    <button type="button" data-toggle="modal" data-target="#update_userModal"
                                        id="addBtn" class="btn btn-primary btn-sm m-0  btn-width"
                                        onclick="stars({{  $user->id }})" data-user-id="{{ $user->id }}">Update
                                        </button>
                                    <button type="button" class="delete-user btn btn-primary btn-sm m-0 btn-width"
                                        data-user-id="{{ $user->id }}"
                                        onclick="deleteUser({{  $user->id }})">Delete </button>
                                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
                </div>
            </div>
        </div>
    </div>
</div>
      <div class="modal" tabindex="-1" id="update_userModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="update_user" type="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" min="0" required name="name" class="form-control" id="user_name">
                            <span class="text-danger" id="updatenameError"></span>
                        </div>
                        <input type="hidden" value="" name="user_id" id="user_id">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" min="0" required name="email" class="form-control" id="user_email">
                            <span class="text-danger" id="updateemailError"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="update-user" class="btn btn-primary btn-width2">Update</button>
                            <button type="button" class="btn btn-secondary btn-width2" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
function deleteUser(userId)
        {
            var user = userId;
            let url = "{{ route('admin.user.destroy',':id') }}";
            url = url.replace(':id', user);
              swal({
                title: "Are you sure?",
                text: "You will not be able to recover the user!",
                icon: "warning",
                buttons: true,
                dangerMode: true
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        data: {
                            '_token': "{{ csrf_token() }}",
                        },
                        success: function (data) {
                            if (data['status'] == 'success') {
                                swal("User has been deleted successfully!", {
                                    icon: "success",
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            } else {
                                swal("Oops", "Something went wrong!", "error")

                            }
                        },
                        error: function (response) {
                            swal("Oops", "Something went wrong!", "error")

                        }
                    });
                }
            });

        }
        function stars(userId) {
            var user = userId;
            let url = "{{ route('admin.getUser',':id') }}";
            url = url.replace(':id', user);
            $.ajax({
                type: "GET",
                url: url,
                success: function (data) {
                    $("#user_name").val(data.user.name);
                    $("#user_email").val(data.user.email);
                    $("#user_id").val(data.user.id);
                },
            });
    }
    $(document).ready(function () {
        $('#update_userModal').on('shown.bs.modal', function () {
            $('#myInput').trigger('focus')
        })
    $('#example').DataTable({
          "pagingType": "simple",
    });

      $('#update-user').click(function(){
               $('#updatenameError').text("");
                $('#updateemailError').text("");
                var user_id = $("#user_id").val();
                let url = "{{ route('admin.user.update',':id') }}";
            url = url.replace(':id', user_id);
            $.ajax({
                type: "POST",
                url: url,
                data: $('#update_user').serialize(),
                success: function (data) {
                    if(data['status'] == 'success'){
                             swal("User has been updated successfully!", {
                            icon: "success",
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                        location.reload();
                    } else {
                           swal("Oops", "Something went wrong!", "error")
                    }
                },
                error: function (response) {
                    var res = JSON.parse(response.responseText);
                    console.log(res);
                if(res.error)
                {
                }else {
                    $('#updatenameError').text(res.errors.name);
                    $('#updateemailError').text(res.errors.email);

                }
            },
        });
        });

});
</script>
