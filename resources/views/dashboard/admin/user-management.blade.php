@extends('layouts.apps')

@section('content')
@if($checkRole == 0)
<div class="container text-center" id="forbidden">
    <h1>403</h1>
    <p>Forbidden Access!</p>
    <p>Permission Denied</p>
</div>
@else
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('User Management') }} <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#userModal">Insert User</button></div>

                <div class="card-body">
                    <table class="table table-hover table-condensed  dt-responsive nowrap" id="userTable">

                        <thead>
                            <th>&#35;</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>

                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="userModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="userModalLabel">Add New User Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{route('insert.new.user')}}" method="post" id="newUserForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name">
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="col-md-12">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email">
                            <span class="text-danger error-text email_error"></span>
                        </div>
                        <div class="col-md-12">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <span class="text-danger error-text password_error"></span>
                        </div>
                        <div class="cold-md-12">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeNewUserModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="userUpdateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="userUpdateModalLabel">Update User Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{route('update.user')}}" method="post" id="updateUserForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" id="dataID" name="dataID">
                        <div class="col-md-12">
                            <label for="new_name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="new_name" name="new_name">
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="col-md-12">
                            <label for="new_email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="new_email" name="new_email">
                            <span class="text-danger error-text email_error"></span>
                        </div>
                        <div class="col-md-12">
                            <label for="new_password" class="form-label">New Password:</label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                            <span class="text-danger error-text new_password_error"></span>
                        </div>
                        <div class="cold-md-12">
                            <label for="new_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" autocomplete="new-password">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeUpdateModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="submitUpdate" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="module">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {

        $('#userTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            ajax: "{{ route('user.list.management')}}",
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "ALL"]
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'email',
                    name: 'email',
                },
                {
                    data: 'actions',
                    name: 'actions',
                },

            ]
        });
    });
    $('#newUserForm').on('submit', function(e) {
        e.preventDefault();
        let form = this;
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure you want to save this record?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.code == 0) {
                            $.each(data.error, function(prefix, val) {
                                $(form).find('span.' + prefix + '_error').text(val[0]);
                            });
                        } else if (data.code == 1) {

                            $(form)[0].reset();
                            Swal.fire({
                                icon: 'success',
                                title: 'Successfully!',
                                text: data.msg,
                                timer: 3500
                            })
                            $('#userTable').DataTable().draw();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oopss..',
                                text: data.msg,
                                timer: 3500
                            });
                        }
                    }
                })



            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        });

    })
    $(document).on('click', '#editBtn', function() {
        const dataID = $(this).data('id');

        $.get("{{route('get.user')}}", {
            dataID: dataID
        }, function(data) {
            $('#userUpdateModal').modal('show');
            $('#userUpdateModal').find('#dataID').val(dataID);
            $('#userUpdateModal').find('#new_name').val(data.details.name);
            $('#userUpdateModal').find('#new_email').val(data.details.email);

        })
    })
    $('#updateUserForm').on('submit', function(e) {
        e.preventDefault();
        let form = this;
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure you want to save this record?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.code == 0) {
                            $.each(data.error, function(prefix, val) {
                                $(form).find('span.' + prefix + '_error').text(val[0]);
                            });
                        } else if (data.code == 1) {

                            $(form)[0].reset();
                            Swal.fire({
                                icon: 'success',
                                title: 'Successfully!',
                                text: data.msg,
                                timer: 3500
                            })
                            $('#updateUserForm').modal('hide');
                            $('#userTable').DataTable().draw();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oopss..',
                                text: data.msg,
                                timer: 3500
                            });
                        }
                    }
                })



            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        });
    })
    $(document).on('click', '#deleteBtn', function(e) {
        e.preventDefault();
        const dataID = $(this).data('id');
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure you want to Delete this record?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.post("{{route('delete.user')}}", {
                    dataID: dataID
                }, function(data) {
                    if (data.code == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully!',
                            text: data.msg,
                            timer: 3500
                        })
                        $('#userTable').DataTable().draw();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oopss..',
                            text: data.msg,
                            timer: 3500
                        });
                    }
                })




            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        });


    })
</script>
@endif
@endsection
